<?php

namespace FunctionalCoding\JWT;

use FunctionalCoding\Service;

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
            'payload' => function ($decrypter, $jwk, $token) {
                $jwe = (new CompactSerializer())->unserialize($token);

                $decrypter->decryptUsingKey($jwe, $jwk, 0);

                return json_decode($jwe->getPayLoad(), true);
            },

            'payload_keys' => function () {
                throw new \Exception();
            },

            'result' => function ($payload) {
                return $payload;
            },

            'valid_token' => function ($decrypter, $jwk, $payloadKeys, $token) {
                try {
                    $jwe = (new CompactSerializer())->unserialize($token);

                    $decrypter->decryptUsingKey($jwe, $jwk, 0);
                }
                // @noinspection PhpUnusedLocalVariableInspection
                catch (\Exception $exception) {
                    return null;
                }

                $isValid = true;
                $payload = json_decode($jwe->getPayLoad(), true);

                if (null == $payload) {
                    return null;
                }

                foreach ($payloadKeys as $key) {
                    if (!array_key_exists($key, $payload)) {
                        $isValid = false;
                    }
                }

                return $isValid ? $token : null;
            },
        ];
    }

    public static function getArrPromiseLists()
    {
        return [
            'payload' => ['valid_token:strict'],
        ];
    }

    public static function getArrRuleLists()
    {
        return [
            'token' => ['required'],

            'valid_token' => ['required'],
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
