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
        try {
            $product = (new Product())->findActive($id);
        } catch (\Throwable) {
            $product = null;
        }
        if (!$product) {
            http_response_code(404);
            View::render('public/not-found', [], 'public/layout');
            return;
        }

        View::render('public/product', [
            'product' => $product,
            'images' => (new ProductImage())->forProduct($id),
            'whatsapp' => app_config('whatsapp'),
        ], 'public/layout');
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

        View::render('public/catalog', [
            'title' => 'Catálogo MRDRIVES | MRD-320 Series',
            'products' => $products,
            'documents' => $documents,
        ], 'public/layout');
    }

    public function privacy(): void
    {
        View::render('public/privacy', [
            'title' => 'Politica de Privacidade | MRDRIVES',
        ], 'public/layout');
    }

    public function mrd700Ip65(): void
    {
        View::render('public/mrd700-ip65', [
            'title' => 'MRD700/IP65 | MRDRIVES',
            'whatsapp' => app_config('whatsapp'),
        ], 'public/layout');
    }

    public function mrd600(): void
    {
        View::render('public/mrd600', [
            'title' => 'MRD600 | MRDRIVES',
            'whatsapp' => app_config('whatsapp'),
        ], 'public/layout');
    }

    public function mrd700(): void
    {
        View::render('public/mrd700', [
            'title' => 'MRD700 | MRDRIVES',
            'whatsapp' => app_config('whatsapp'),
        ], 'public/layout');
    }

    public function ticket(): void
    {
        View::render('public/ticket', [
            'title' => 'Ticket técnico | MRDRIVES',
            'whatsapp' => app_config('whatsapp'),
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

    private function fallbackProducts(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Inversor MRD-320 220V',
                'model_code' => 'MRD-320 220V',
                'short_description' => 'Inversor vetorial compacto para redes 220V com excelente custo-benefício.',
                'power' => '0.4 kW a 5.5 kW',
                'voltage' => '220 V / 380 V',
                'main_image' => 'assets/img/mrd600/mrd600_2.jpeg',
                'manual_pdf' => null,
            ],
            [
                'id' => 2,
                'name' => 'Inversor MRD-320 380V',
                'model_code' => 'MRD-320 380V',
                'short_description' => 'Modelo trifásico para aplicações industriais com potência até 7.5 kW.',
                'power' => '0.4 kW a 7.5 kW',
                'voltage' => '380 V',
                'main_image' => 'assets/img/mrd600/mrd600_2.jpeg',
                'manual_pdf' => null,
            ],
            [
                'id' => 3,
                'name' => 'MRD-320 Interface e Controle',
                'model_code' => 'MRD-320 I/O',
                'short_description' => 'Configuração com display duplo LED, potenciômetro integrado e conexões de controle.',
                'power' => 'Conforme projeto',
                'voltage' => '220 V / 380 V',
                'main_image' => 'assets/img/mrd600/mrd600_2.jpeg',
                'manual_pdf' => null,
            ],
            [
                'id' => 700,
                'name' => 'Inversor MRD700/IP65',
                'model_code' => 'MRD700/IP65',
                'short_description' => 'Inversor lavável IP65 para ambientes severos, com STO, comunicação industrial e interfaces completas.',
                'power' => '0.4 kW a 400 kW',
                'voltage' => '220 V / 380 V / 480 V',
                'main_image' => 'assets/img/mrd700-ip65/mrd700ip65-transparent.png',
                'manual_pdf' => null,
            ],
        ];
    }
}


