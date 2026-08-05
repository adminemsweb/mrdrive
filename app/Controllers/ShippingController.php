<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\CorreiosService;
use RuntimeException;
use Throwable;

final class ShippingController
{
    public function postalCode(): void
    {
        $this->respond(function (): array {
            $address = (new CorreiosService())->lookupPostalCode((string) ($_GET['cep'] ?? ''));
            if (!$address) {
                throw new RuntimeException('CEP não encontrado.');
            }
            return ['ok' => true, 'address' => $address];
        });
    }

    public function quote(): void
    {
        $this->respond(fn(): array => array_merge(
            ['ok' => true],
            (new CorreiosService())->quote((string) ($_GET['cep'] ?? ''))
        ));
    }

    private function respond(callable $callback): void
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        try {
            echo json_encode($callback(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } catch (RuntimeException $exception) {
            http_response_code(422);
            echo json_encode(['ok' => false, 'message' => $exception->getMessage()], JSON_UNESCAPED_UNICODE);
        } catch (Throwable) {
            http_response_code(503);
            echo json_encode(['ok' => false, 'message' => 'Serviço de entrega temporariamente indisponível.'], JSON_UNESCAPED_UNICODE);
        }
    }
}
