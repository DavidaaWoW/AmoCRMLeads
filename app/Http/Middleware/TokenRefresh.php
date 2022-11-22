<?php

namespace App\Http\Middleware;

use AmoCRM\Client\AmoCRMApiClient;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\OAuth2\Client\Token\AccessToken;

class TokenRefresh
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if($user) {
            if ($user->refresh_token) {
                date_default_timezone_set('Europe/Moscow');
                if ($user->token_expires < strtotime("now")) {
                    $clientId = "d7769f4f-6857-4a94-94b0-11dba1392f08";
                    $clientSecret = "kTlc74AkwoE0znsUgXz60Jg44kObDyKmeLVyBkZlg1grdOU5W3LNyZ2MrgSbvdj3";
                    $redirectUri = "http://test.com";
                    $apiClient = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
                    $oauth = $apiClient->getOAuthClient();
                    $oauth->setBaseDomain($user->domain . '.amocrm.ru');
                    $accessToken = $oauth->getAccessTokenByRefreshToken(new AccessToken(['access_token' => $user->access_token, 'refresh_token' => $user->refresh_token, 'expires' => $user->token_expires, 'domain' => $user->domain]));
                    $user->access_token = $accessToken->getToken();
                    $user->refresh_token = $accessToken->getRefreshToken();
                    $user->token_expires = $accessToken->getExpires();
                    $user->save();
                }
            }
        }
        return $next($request);
    }
}
