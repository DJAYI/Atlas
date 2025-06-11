<?php

namespace App\Services;

use GuzzleHttp\Client;

class TurnstileServiceCF
{
    /**
     * Valida el token de Cloudflare Turnstile
     * @param string $token
     * @param string|null $ip
     * @return array|false Devuelve el resultado de la validación o false si falla
     */
    public function validate(?string $token, ?string $ip = null): array|false
    {
        $secretKey = config('services.turnstile.secret_key');
        if (!$secretKey) {
            logger()->error('Turnstile secret key no configurada.');
            return false;
        }

        if (empty($token) || $token === null) {
            logger()->warning('Turnstile token vacío');
            return false;
        }

        $client = new Client();
        $formParams = [
            'secret'   => $secretKey,
            'response' => $token,
        ];
        if ($ip) {
            $formParams['remoteip'] = $ip;
        }

        try {
            $response = $client->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'form_params' => $formParams,
                'timeout' => 5,
            ]);
            $result = json_decode($response->getBody()->getContents(), true);
            if (!isset($result['success']) || !$result['success']) {
                logger()->warning('Turnstile token inválido', $result);
                return false;
            }

            logger()->info('Turnstile token validado correctamente', $result);
            return $result;
        } catch (\Exception $e) {
            logger()->error('Error al validar Turnstile: ' . $e->getMessage());
            return false;
        }
    }
}
