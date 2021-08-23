<?php

namespace FunctionalCoding\JWT\Service;

use FunctionalCoding\Service;
use JOSE_JWE;

class TokenEncryptionService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbacks()
    {
        return [];
    }

    public static function getArrLoaders()
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

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [
            'public_key' => ['required', 'string'],

            'payload' => ['required', 'array'],
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
