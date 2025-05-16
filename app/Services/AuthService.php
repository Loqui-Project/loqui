<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

final class AuthService
{
    /**
     * Get access token for patient.
     *
     *
     * @throws Exception
     */
    public function getAccessToken(array $credentials): mixed
    {

        $client = [
            'client_id' => config('services.passport_client.client_id'),
            'client_secret' => config('services.passport_client.client_secret'),
        ];

        $request_body = [
            'grant_type' => 'password',
            'scope' => '',
        ] + $credentials + $client;

        $request = Request::create('oauth/token', 'POST', $request_body, [], [], [
            'HTTP_Accept' => 'application/json',
        ]);

        $response = app()->handle($request);
        $decodedResponse = json_decode($response->getContent(), true);
        if ($response->getStatusCode() !== 200) {
            if ($decodedResponse['message'] === 'The provided authorization grant (e.g., authorization code, resource owner credentials) or refresh token is invalid, expired, revoked, does not match the redirection URI used in the authorization request, or was issued to another client.') {
                throw new AuthenticationException(__('Incorrect username or password'));
            }

            throw new AuthenticationException( __($decodedResponse['message']));
        }

        return $decodedResponse;
    }
}
