<?php

namespace App\Traits;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

trait UserOauthTrait
{
    public function getAccessToken(array $credentials)
    {
        $request = Request::create('oauth/token', 'POST', $credentials, [], [], [
            'HTTP_Accept' => 'application/json',
        ]);
        $response = app()->handle($request);
        $decodedResponse = json_decode($response->getContent(), true);
        if ($response->getStatusCode() != 200) {
            if ($decodedResponse['message'] === 'The provided authorization grant (e.g., authorization code, resource owner credentials) or refresh token is invalid, expired, revoked, does not match the redirection URI used in the authorization request, or was issued to another client.') {
                throw new AuthenticationException(__('Authentication exception'), __('Incorrect username or password'));
            }

            throw new AuthenticationException(__($decodedResponse['error'] ?? ''), __($decodedResponse['message']));
        }

        return $decodedResponse;
    }
}
