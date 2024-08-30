<?php

namespace SimplifyServiceLayer\JWT\Service;

use SimplifyServiceLayer\Service;
use SimpleJWT\JWE;
use SimpleJWT\Keys\KeySet;
use SimpleJWT\Keys\RSAKey;

class TokenEncryptionService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [];
    }

    public static function getLoaders()
    {
        return [
            'payload' => function () {
                throw new \Exception();
            },

            'public_key' => function () {
                throw new \Exception();
            },

            'result' => function ($jwe) {
                return $jwe;
            },

            'jwe' => function ($publicKey, $payload) {
                $key = new RSAKey($publicKey, 'pem');
                $set = new KeySet();
                $set->add($key);

                $headers = ['alg' => 'RSA1_5', 'enc' => 'A128CBC-HS256'];
                $jwe = new JWE($headers, json_encode($payload));

                return $jwe->encrypt($set);
            },
        ];
    }

    public static function getPromiseLists()
    {
        return [];
    }

    public static function getRuleLists()
    {
        return [];
    }

    public static function getTraits()
    {
        return [];
    }
}
