<?php

namespace App\Http\Controllers;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\OAuth2\Client\Token\AccessToken;

class TokenController extends Controller
{
    public function getToken(Request $request){
        $clientId = "d7769f4f-6857-4a94-94b0-11dba1392f08";
        $clientSecret = "kTlc74AkwoE0znsUgXz60Jg44kObDyKmeLVyBkZlg1grdOU5W3LNyZ2MrgSbvdj3";
        $redirectUri = "http://test.com";
        $user = Auth::user();
        $apiClient = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
        $oauth = $apiClient->getOAuthClient();
        $oauth->setBaseDomain($request->domain.'.amocrm.ru');
        $accessToken = $oauth->getAccessTokenByCode($request->token);
        $user->access_token = $accessToken->getToken();
        $user->refresh_token = $accessToken->getRefreshToken();
        $user->token_expires = $accessToken->getExpires();
        $user->domain = $request->domain;
        $user->save();
        $apiClient->setAccessToken($accessToken);
        return redirect(route('leads'));
    }
}
