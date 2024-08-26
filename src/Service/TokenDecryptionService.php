<?php

namespace FunctionalCoding\JWT\Service;

use FunctionalCoding\Service;
use SimpleJWT\JWE;
use SimpleJWT\Keys\KeySet;
use SimpleJWT\Keys\RSAKey;

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
                    $key = new RSAKey($secretKey, 'pem');
                    $set = new KeySet();
                    $set->add($key);
                    $jwe = JWE::decrypt($token, $set, 'RSA1_5');
                } catch (\Exception $exception) {
                    return null;
                }

                return $jwe->getPlaintext();
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
