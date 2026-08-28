<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\View;
use App\Models\Document;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\QuoteRequest;

final class PublicController
{
    public function home(): void
    {
        $products = [];
        $documents = [];

        try {
            $products = (new Product())->active();
            $documents = (new Document())->active();
        } catch (\Throwable) {
            $products = $this->fallbackProducts();
        }

        $products = $this->featuredLines($products);

        View::render('public/home', [
            'products' => $products,
            'documents' => $documents,
            'whatsapp' => app_config('whatsapp'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'public/layout');
        unset($_SESSION['flash']);
    }

    public function product(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $images = [];
        $relatedProducts = [];
        try {
            $productModel = new Product();
            $product = $productModel->findActive($id);
            if ($product) {
                $images = (new ProductImage())->forProduct($id);
                $relatedProducts = array_values(array_filter(
                    $productModel->active(),
                    static fn(array $item): bool => (int) ($item['id'] ?? 0) !== $id
                ));
            }
        } catch (\Throwable) {
            $product = $this->fallbackProduct($id);
            $relatedProducts = array_values(array_filter(
                $this->fallbackProducts(),
                static fn(array $item): bool => (int) ($item['id'] ?? 0) !== $id
            ));
        }

        if (!$product) {
            http_response_code(404);
            View::render('public/not-found', [], 'public/layout');
            return;
        }

        $this->renderStoreProduct($this->normalizeStoreProduct($product), $images, $relatedProducts);
    }

    public function catalog(): void
    {
        $products = [];
        $documents = [];

        try {
            $products = (new Product())->active();
            $documents = (new Document())->active();
        } catch (\Throwable) {
            $products = $this->fallbackProducts();
        }

        $products = $this->featuredLines($products);

        View::render('public/catalog', [
            'title' => 'Loja de Inversores Industriais | MRDRIVES',
            'products' => $products,
            'documents' => $documents,
            'whatsapp' => app_config('whatsapp'),
        ], 'public/layout');
    }

    public function checkout(): void
    {
        if (!(bool) (app_config('store')['cart_enabled'] ?? false)) {
            redirect('/catalogo');
        }

        View::render('public/checkout', [
            'title' => 'Finalizar pedido | MRDRIVES',
            'whatsapp' => app_config('whatsapp'),
        ], 'public/layout');
    }

    public function downloads(): void
    {
        $documents = [];

        try {
            $documents = (new Document())->active();
        } catch (\Throwable) {
            $documents = [];
        }

        View::render('public/downloads', [
            'title' => 'Downloads | MRDRIVES',
            'documents' => $documents,
        ], 'public/layout');
    }

    public function privacy(): void
    {
        $this->legal('politica-de-privacidade');
    }

    public function legal(string $slug): void
    {
        $pages = require base_path('config/legal.php');

        if (!isset($pages[$slug])) {
            http_response_code(404);
            View::render('public/not-found', [], 'public/layout');
            return;
        }

        View::render('public/legal', [
            'title' => $pages[$slug]['title'] . ' | MRDRIVES',
            'description' => $pages[$slug]['description'],
            'slug' => $slug,
            'page' => $pages[$slug],
            'company' => app_config('company'),
            'whatsapp' => app_config('whatsapp'),
        ], 'public/layout');
    }

    public function mrd700Ip65(): void
    {
        $this->storeProductByModel('MRD700/IP65');
    }

    public function mrd600(): void
    {
        $this->storeProductByModel('MRD600');
    }

    public function mrd700(): void
    {
        $this->storeProductByModel('MRD700');
    }

    public function ticket(): void
    {
        View::render('public/ticket', [
            'title' => 'Ticket técnico | MRDRIVES',
            'whatsapp' => app_config('whatsapp'),
        ], 'public/layout');
    }

    public function notFound(): void
    {
        View::render('public/not-found', [
            'title' => 'Página não encontrada | MR Drives',
            'description' => 'A página solicitada não foi encontrada no site da MR Drives.',
        ], 'public/layout');
    }

    public function ticketSubmit(): void
    {
        Csrf::verify();

        $data = [
            'type' => trim((string) ($_POST['ticket_type'] ?? 'Solicitação técnica')),
            'name' => trim((string) ($_POST['name'] ?? '')),
            'company' => trim((string) ($_POST['company'] ?? '')),
            'email' => trim((string) ($_POST['email'] ?? '')),
            'phone' => trim((string) ($_POST['phone'] ?? '')),
            'product_interest' => trim((string) ($_POST['product_interest'] ?? '')),
            'power' => trim((string) ($_POST['power'] ?? '')),
            'voltage' => trim((string) ($_POST['voltage'] ?? '')),
            'application' => trim((string) ($_POST['application'] ?? '')),
            'catalog' => trim((string) ($_POST['catalog'] ?? '')),
            'message' => trim((string) ($_POST['message'] ?? '')),
        ];

        $attachment = $_FILES['attachment']['name'] ?? '';
        $lines = [
            'Ticket MRDRIVES',
            'Tipo: ' . ($data['type'] ?: 'Solicitação técnica'),
            'Nome: ' . ($data['name'] ?: 'Não informado'),
            'Empresa: ' . ($data['company'] ?: 'Não informado'),
            'E-mail: ' . ($data['email'] ?: 'Não informado'),
            'WhatsApp: ' . ($data['phone'] ?: 'Não informado'),
            'Produto: ' . ($data['product_interest'] ?: 'Não informado'),
            'Catálogo/guia: ' . ($data['catalog'] ?: 'Não informado'),
            'Potência: ' . ($data['power'] ?: 'Não informado'),
            'Tensão: ' . ($data['voltage'] ?: 'Não informado'),
            'Aplicação: ' . ($data['application'] ?: 'Não informado'),
            'Mensagem: ' . ($data['message'] ?: 'Não informado'),
        ];

        if ($attachment !== '') {
            $lines[] = 'Anexo selecionado: ' . $attachment;
            $lines[] = 'Observação: enviar a imagem/video nesta conversa do WhatsApp.';
        }

        $url = 'https://wa.me/' . app_config('whatsapp') . '?text=' . rawurlencode(implode("\n", $lines));
        redirect($url);
    }

    public function quote(): void
    {
        Csrf::verify();

        $data = [
            'name' => trim((string) ($_POST['name'] ?? '')),
            'company' => trim((string) ($_POST['company'] ?? '')),
            'email' => trim((string) ($_POST['email'] ?? '')),
            'phone' => trim((string) ($_POST['phone'] ?? '')),
            'product_interest' => trim((string) ($_POST['product_interest'] ?? '')),
            'application' => trim((string) ($_POST['application'] ?? '')),
            'message' => trim((string) ($_POST['message'] ?? '')),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent' => substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255),
        ];

        if ($data['name'] === '' || !filter_var($data['email'], FILTER_VALIDATE_EMAIL) || $data['phone'] === '') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Preencha nome, e-mail valido e telefone.'];
            redirect('/#contato');
        }

        try {
            (new QuoteRequest())->creaté($data);
        } catch (\Throwable) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Banco de dados indisponivel. Envie pelo WhatsApp ou configure o .env.'];
            redirect('/#contato');
        }

        $this->sendMail($data);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Solicitação enviada. Nossa equipe entrara em contato.'];
        redirect('/#contato');
    }

    private function sendMail(array $data): void
    {
        $mail = app_config('mail');
        $subject = 'Nova solicitação de orçamento - MRDRIVES';
        $body = "Nome: {$data['name']}\nEmpresa: {$data['company']}\nE-mail: {$data['email']}\nTelefone: {$data['phone']}\nProduto: {$data['product_interest']}\nAplicação: {$data['application']}\n\nMensagem:\n{$data['message']}";
        $headers = 'From: ' . $mail['from'] . "\r\nReply-To: " . $data['email'];
        @mail($mail['to'], $subject, $body, $headers);
    }

    private function storeProductByModel(string $modelCode): void
    {
        $product = null;
        $images = [];
        $products = [];

        try {
            $productModel = new Product();
            $product = $productModel->findActiveByModelCode($modelCode);
            $products = $productModel->active();
            if ($product) {
                $images = (new ProductImage())->forProduct((int) $product['id']);
            }
        } catch (\Throwable) {
            $products = $this->fallbackProducts();
        }

        $product ??= $this->fallbackProductByModel($modelCode);
        if (!$product) {
            http_response_code(404);
            View::render('public/not-found', [], 'public/layout');
            return;
        }

        $product = $this->normalizeStoreProduct($product);
        $relatedProducts = array_values(array_filter(
            $this->featuredLines($products),
            static fn(array $item): bool => strcasecmp((string) ($item['model_code'] ?? ''), $modelCode) !== 0
        ));

        $this->renderStoreProduct($product, $images, $relatedProducts);
    }

    private function renderStoreProduct(array $product, array $images, array $relatedProducts): void
    {
        $presentation = $this->productPresentation((string) ($product['model_code'] ?? ''));
        $gallery = [];

        foreach ($images as $image) {
            if (!empty($image['image_path'])) {
                $gallery[] = ['image_path' => (string) $image['image_path']];
            }
        }
        foreach (($presentation['gallery'] ?? []) as $imagePath) {
            $gallery[] = ['image_path' => $imagePath];
        }

        $seen = [];
        $gallery = array_values(array_filter($gallery, static function (array $image) use (&$seen): bool {
            $path = strtolower(trim((string) ($image['image_path'] ?? '')));
            if ($path === '' || isset($seen[$path])) {
                return false;
            }
            $seen[$path] = true;
            return true;
        }));

        View::render('public/product', [
            'title' => $this->productSeoTitle($product),
            'description' => $this->productSeoDescription($product),
            'product' => $product,
            'images' => $gallery,
            'technicalView' => $presentation['technical_view'] ?? null,
            'relatedProducts' => array_slice(array_map(fn(array $item): array => $this->normalizeStoreProduct($item), $relatedProducts), 0, 4),
            'whatsapp' => app_config('whatsapp'),
        ], 'public/layout');
    }

    private function productSeoTitle(array $product): string
    {
        $modelCode = strtoupper(trim((string) ($product['model_code'] ?? '')));

        return match ($modelCode) {
            'MRD600' => 'Inversor de Frequência MRD600 220 V e 380 V | MR Drives',
            'MRD700' => 'Inversor Vetorial MRD700 para Automação | MR Drives',
            'MRD700/IP65', 'MRD700-IP65' => 'Inversor IP65 MRD700 para Ambientes Severos | MR Drives',
            default => ($product['name'] ?? 'Inversor de Frequência') . ' | MR Drives',
        };
    }

    private function productSeoDescription(array $product): string
    {
        $modelCode = strtoupper(trim((string) ($product['model_code'] ?? '')));

        return match ($modelCode) {
            'MRD600' => 'MRD600: inversor de frequência compacto para máquinas, bombas e ventiladores, disponível para aplicações industriais em redes 220 V e 380 V.',
            'MRD700' => 'MRD700: inversor vetorial industrial de alto desempenho, com expansão PLC e protocolos para automação de máquinas e processos.',
            'MRD700/IP65', 'MRD700-IP65' => 'MRD700/IP65: inversor de frequência protegido contra água, poeira e umidade, desenvolvido para ambientes industriais severos.',
            default => (string) ($product['short_description'] ?? 'Inversores de frequência e soluções para automação industrial MR Drives.'),
        };
    }

    private function normalizeStoreProduct(array $product): array
    {
        $fallback = $this->fallbackProductByModel((string) ($product['model_code'] ?? $product['name'] ?? ''));
        if (!$fallback) {
            return $product;
        }

        $configuredChannel = (string) ($product['sale_channel'] ?? $fallback['sale_channel']);
        if (!in_array($configuredChannel, ['whatsapp', 'cart'], true)) {
            $configuredChannel = !empty($product['price']) ? 'cart' : 'whatsapp';
        }

        return array_merge($fallback, $product, [
            'name' => $fallback['name'],
            'model_code' => $fallback['model_code'],
            'sku' => !empty($product['sku']) ? $product['sku'] : $fallback['sku'],
            'category' => $fallback['category'],
            'main_image' => $fallback['main_image'],
            'manual_pdf' => $fallback['manual_pdf'],
            'url' => $fallback['url'],
            'sale_channel' => $configuredChannel,
        ]);
    }

    private function productPresentation(string $modelCode): array
    {
        $normalized = strtolower(str_replace([' ', '-'], '', $modelCode));

        if (str_contains($normalized, 'mrd700') && str_contains($normalized, 'ip65')) {
            return [
                'technical_view' => 'mrd700-ip65',
                'gallery' => [
                    'assets/img/mrd700-ip65/tres-transparent.png',
                    'assets/img/mrd700-ip65/lateral-direita-transparent.png',
                    'assets/img/mrd700-ip65/topo-transparent.png',
                    'assets/img/mrd700-ip65/seis-transparent.png',
                    'assets/img/mrd700-ip65/quatro-transparent.png',
                    'assets/img/mrd700-ip65/um.jpeg',
                    'assets/img/mrd700-ip65/dois.jpeg',
                    'assets/img/mrd700-ip65/cinco.jpeg',
                    'assets/img/mrd700-ip65/sete.jpeg',
                    'assets/img/mrd700-ip65/oito.jpeg',
                ],
            ];
        }

        if (str_contains($normalized, 'mrd700')) {
            return [
                'technical_view' => 'mrd700',
                'gallery' => array_map(
                    static fn(string $file): string => 'assets/img/mrd700/' . $file,
                    ['089A0079.png', '089A0084.png', '089A0087.png', '089A0090.png', '089A0092.png', '089A0095.png', '089A0106.png', '089A9778.png']
                ),
            ];
        }

        if (str_contains($normalized, 'mrd600')) {
            return [
                'technical_view' => 'mrd600',
                'gallery' => array_map(
                    static fn(string $file): string => 'assets/img/mrd600/' . $file,
                    ['mrd600.png', 'mrd600_3.png', 'mrd600_4.png', 'mrd600_5.png', 'mrd600_6.png']
                ),
            ];
        }

        return [];
    }

    private function fallbackProducts(): array
    {
        return [
            [
                'id' => 600,
                'name' => 'MRD600',
                'model_code' => 'MRD600',
                'sku' => 'MRD600',
                'category' => 'Inversores compactos',
                'short_description' => 'Inversor compacto para máquinas, bombas, ventiladores e aplicações industriais de rotina.',
                'power' => '0.4 kW a 18 kW',
                'voltage' => '220 V / 380 V',
                'main_image' => 'assets/img/mrd600/mrd600_2.png',
                'url' => '/mrd600',
                'manual_pdf' => 'assets/img/mrd600/MRD600.pdf',
                'full_description' => 'Inversor vetorial compacto para controle preciso de motores em máquinas, bombas, ventiladores e sistemas industriais.',
                'recommended_applications' => 'Esteiras, ventiladores, máquinas industriais, bombas e sistemas de embalagem',
                'technical_specs' => "Controle vetorial\nDisplay duplo LED\nPotenciômetro integrado\nEntradas digitais e analógicas",
                'price' => null,
                'compare_at_price' => null,
                'sale_channel' => 'whatsapp',
                'stock_quantity' => 0,
                'track_stock' => 0,
                'shipping_days' => 'Prazo confirmado no atendimento',
                'is_featured' => 1,
                'is_offer' => 0,
                'is_best_seller' => 1,
                'is_new' => 0,
            ],
            [
                'id' => 700,
                'name' => 'MRD700',
                'model_code' => 'MRD700',
                'sku' => 'MRD700',
                'category' => 'Alto desempenho',
                'short_description' => 'Linha vetorial de alto desempenho com expansão PLC e protocolos industriais.',
                'power' => 'Sob consulta',
                'voltage' => '220 V / 380 V / 480 V',
                'main_image' => 'assets/img/mrd700/capa.png',
                'url' => '/mrd700',
                'manual_pdf' => 'assets/img/mrd700/MRD700.pdf',
                'full_description' => 'Linha vetorial de alta performance para máquinas e processos com recursos avançados de automação.',
                'recommended_applications' => 'Máquinas industriais, processos contínuos, elevação e integração com PLC',
                'technical_specs' => "Controle vetorial\nExpansão PLC\nProtocolos industriais\nAlta capacidade de sobrecarga",
                'price' => null,
                'compare_at_price' => null,
                'sale_channel' => 'whatsapp',
                'stock_quantity' => 0,
                'track_stock' => 0,
                'shipping_days' => 'Prazo confirmado no atendimento',
                'is_featured' => 1,
                'is_offer' => 1,
                'is_best_seller' => 1,
                'is_new' => 0,
            ],
            [
                'id' => 765,
                'name' => 'MRD700/IP65',
                'model_code' => 'MRD700/IP65',
                'sku' => 'MRD700-IP65',
                'category' => 'Proteção IP65',
                'short_description' => 'Inversor lavável para ambientes com água, poeira e rotinas severas de limpeza.',
                'power' => '0.4 kW a 400 kW',
                'voltage' => '380 V / 480 V',
                'main_image' => 'assets/img/mrd700-ip65/mrd700ip65-transparent.png',
                'url' => '/mrd700-ip65',
                'manual_pdf' => 'assets/img/mrd700/MRD700.pdf',
                'full_description' => 'Inversor industrial protegido para ambientes severos, com arquitetura modular e ampla compatibilidade de comunicação.',
                'recommended_applications' => 'Bombas fotovoltaicas, elevadores, guindastes, esteiras, ventiladores e ambientes com poeira ou umidade',
                'technical_specs' => "Proteção IP65\nFunção STO integrada\nPID e PLC integrados\nRS485, PROFINET, CANopen e EtherCAT",
                'price' => null,
                'compare_at_price' => null,
                'sale_channel' => 'whatsapp',
                'stock_quantity' => 0,
                'track_stock' => 0,
                'shipping_days' => 'Prazo confirmado no atendimento',
                'is_featured' => 1,
                'is_offer' => 0,
                'is_best_seller' => 1,
                'is_new' => 1,
            ],
        ];
    }

    private function featuredLines(array $products): array
    {
        $fallbacks = $this->fallbackProducts();
        $featured = [];

        foreach ($fallbacks as $fallback) {
            $expected = strtolower((string) $fallback['model_code']);
            $match = null;

            foreach ($products as $product) {
                $identity = strtolower((string) (($product['model_code'] ?? '') . ' ' . ($product['name'] ?? '')));
                if ($expected === 'mrd600' && str_contains($identity, 'mrd600')) {
                    $match = $product;
                    break;
                }
                if ($expected === 'mrd700' && str_contains($identity, 'mrd700') && !str_contains($identity, 'ip65')) {
                    $match = $product;
                    break;
                }
                if ($expected === 'mrd700/ip65' && str_contains($identity, 'mrd700') && str_contains($identity, 'ip65')) {
                    $match = $product;
                    break;
                }
            }

            $featured[] = $match ? $this->normalizeStoreProduct($match) : $fallback;
        }

        return $featured;
    }

    private function fallbackProduct(int $id): ?array
    {
        foreach ($this->fallbackProducts() as $product) {
            if ((int) $product['id'] === $id) {
                return $product;
            }
        }

        return null;
    }

    private function fallbackProductByModel(string $modelCode): ?array
    {
        $identity = strtolower(str_replace([' ', '-'], '', $modelCode));

        foreach ($this->fallbackProducts() as $product) {
            $expected = strtolower(str_replace([' ', '-'], '', (string) $product['model_code']));
            $isMatch = match (true) {
                str_contains($expected, 'ip65') => str_contains($identity, 'mrd700') && str_contains($identity, 'ip65'),
                str_contains($expected, 'mrd700') => str_contains($identity, 'mrd700') && !str_contains($identity, 'ip65'),
                str_contains($expected, 'mrd600') => str_contains($identity, 'mrd600'),
                default => $identity === $expected,
            };
            if ($isMatch) {
                return $product;
            }
        }

        return null;
    }
}


