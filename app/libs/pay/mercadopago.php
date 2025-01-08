<?php

namespace app\libs\pay;

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

final class mercadopago
{
    public function pagar($ventaID, $precio, $metodosPago = []): string
{
    try {
        // Configura tu token de acceso de MercadoPago
        MercadoPagoConfig::setAccessToken(APP_MP);

        // Crea una nueva preferencia
        $client = new PreferenceClient();

        // Configura los métodos de pago
        $paymentMethods = [
            "excluded_payment_types" => [
                // Aquí puedes excluir tipos de pago si es necesario
            ],
            "installments" => 1 // Número de cuotas, puedes cambiarlo según tus necesidades
        ];

        // Si se pasan métodos de pago específicos, agrégalo a la configuración
        if (!empty($metodosPago)) {
            $paymentMethods['excluded_payment_types'] = $metodosPago;
        }

        $preference = $client->create([
            "items" => [
                [
                    "id" => $ventaID,
                    "title" => "Mi producto $ventaID",
                    "quantity" => 1,
                    "unit_price" => $precio
                ]
            ],
            "back_urls" => [
                "success" => "http://localhost/reservaPrivada/public/venta/procesarPago?status=success&ventaID=$ventaID",
                "failure" => "http://localhost/reservaPrivada/public/venta/procesarPago?status=failure&ventaID=$ventaID",
                "pending" => "http://localhost/reservaPrivada/public/venta/procesarPago?status=pending&ventaID=$ventaID"
            ],
            "auto_return" => "approved",
            "statement_descriptor" => "Reserva Privada",
            "external_reference" => $ventaID,
            "payment_methods" => $paymentMethods // Agrega los métodos de pago aquí
        ]);

        // Retorna el URL de inicio del pago
        return $preference->init_point;

    } catch (\Exception $e) {
        error_log("Error al crear la preferencia de pago: " . $e->getMessage());
        return '';
    }
}
}
