<?php

declare(strict_types=1);

namespace App\Traits;

trait HasAccessToken
{
    use \Laravel\Sanctum\HasApiTokens;

    public function createAccessToken(): \Laravel\Sanctum\NewAccessToken
    {
        $token = $this->createToken('auth_token', ['*'], now()->addDays(1));

        $agentInfo = request()->header('User-Agent');
        $ipAddress = request()->ip();

        $passportAccessTokenAdditionalInfo = new \App\Models\AccessTokenAdditionalInfo();
        $passportAccessTokenAdditionalInfo->access_token_id = $token->accessToken->id;
        $passportAccessTokenAdditionalInfo->ip_address = $ipAddress;
        $passportAccessTokenAdditionalInfo->user_agent = $agentInfo;
        $passportAccessTokenAdditionalInfo->user_id = $this->id;
        $passportAccessTokenAdditionalInfo->last_activity = time();

        $passportAccessTokenAdditionalInfo->save();

        return $token;
    }
}
