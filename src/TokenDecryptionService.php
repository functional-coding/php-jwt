<?php

namespace FunctionalCoding\JWT;

use FunctionalCoding\Service;
use JOSE_JWE;

class TokenDecryptionService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'valid_token' => 'valid {{token}}',
        ];
    }

    public static function getArrCallbacks()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'payload' => function ($validToken) {
                return json_decode($validToken, true);
            },

            'result' => function ($payload) {
                return $payload;
            },

            'valid_token' => function ($decrypter, $secretKey, $token) {
                try {
                    $jwe = JOSE_JWE::decode($encrypted);
                    $decrypted = $jwe->decrypt($secretKey);
                } catch (\Exception $exception) {
                    return null;
                }

                return $decrypted->plain_text;
            },
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [
            'secret_key' => ['required', 'string'],

            'token' => ['required', 'string'],

            'valid_token' => ['required', 'string'],
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
