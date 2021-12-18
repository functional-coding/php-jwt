<?php

namespace FunctionalCoding\JWT\Service;

use FunctionalCoding\Service;
use JOSE_JWE;

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

            'result' => function ($jwe) {
                return $jwe->toString();
            },

            'jwe' => function ($publicKey, $payload) {
                $jwe = new JOSE_JWE(json_encode($payload));

                return $jwe->encrypt($publicKey);
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
            'public_key' => ['required', 'string'],

            'payload' => ['required', 'array'],
        ];
    }

    public static function getTraits()
    {
        return [];
    }
}
