<?php

declare(strict_types=1);

namespace App\Listeners;

use Laravel\Sanctum\Events\TokenAuthenticated;

final class CreateSessionOnTokenCreated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TokenAuthenticated $event): void
    {
        $tokenId = $event->token->id;
        $isExisting = \App\Models\AccessTokenAdditionalInfo::where('access_token_id', $tokenId)->exists();
        if ($isExisting) {
            // If the session already exists, we don't need to create a new one.
            return;
        }
        $agentInfo = request()->header('User-Agent');
        $ipAddress = request()->ip();
        $passportAccessTokenAdditionalInfo = new \App\Models\AccessTokenAdditionalInfo();
        $passportAccessTokenAdditionalInfo->access_token_id = $tokenId;
        $passportAccessTokenAdditionalInfo->ip_address = $ipAddress;
        $passportAccessTokenAdditionalInfo->user_agent = $agentInfo;
        $passportAccessTokenAdditionalInfo->user_id = $event->token->tokenable_id;
        $passportAccessTokenAdditionalInfo->last_activity = time();
        $passportAccessTokenAdditionalInfo->save();

    }
}
