<?php

namespace FunctionalCoding\JWT\Service;

use FunctionalCoding\Service;

class TokenDecryptionService extends Service
{
    public static function getBindNames()
    {
        return [
            'valid_token' => 'valid {{token}}',
        ];
    }

    public static function getCallbacks()
    {
        return [];
    }

    public static function getLoaders()
    {
        return [
            'payload' => function ($validToken) {
                return json_decode($validToken, true);
            },

            'result' => function ($payload) {
                return $payload;
            },

            'secret_key' => function () {
                throw new \Exception();
            },

            'valid_token' => function ($secretKey, $token) {
                try {
                    $jwe = \JOSE_JWE::decode($token);
                    $decrypted = $jwe->decrypt($secretKey);
                } catch (\Exception $exception) {
                    return null;
                }

                return $decrypted->plain_text;
            },
        ];
    }

    public static function getPromiseLists()
    {
        return [];
    }

    public static function getRuleLists()
    {
        return [
            'token' => ['required', 'string'],

            'valid_token' => ['required', 'string'],
        ];
    }

    public static function getTraits()
    {
        return [];
    }
}
