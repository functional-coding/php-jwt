<?php

namespace SimplifyServiceLayer\JWT\Tests\Service;

use SimplifyServiceLayer\JWT\Service\TokenDecryptionService;
use SimpleJWT\JWE;
use SimpleJWT\Keys\KeySet;
use SimpleJWT\Keys\RSAKey;

/**
 * @internal
 *
 * @coversNothing
 */
class TokenDecryptionServiceTest extends _TestCase
{
    public function testBasicCase()
    {
        $payload = ['message' => 'hello world'];
        $publicKey = file_get_contents(__DIR__.'/_Fixture/id_rsa.pub');
        $key = new RSAKey($publicKey, 'pem');
        $set = new KeySet();
        $set->add($key);

        $headers = ['alg' => 'RSA1_5', 'enc' => 'A128CBC-HS256'];
        $jwe = new JWE($headers, json_encode($payload));
        $token = $jwe->encrypt($set);
        $service = new TokenDecryptionService([
            'secret_key' => file_get_contents(__DIR__.'/_Fixture/id_rsa'),
            'token' => $token,
        ], [
            'secret_key' => '...',
            'token' => '...',
        ]);
        $service->run();
        $result = $service->getData()->offsetGet('result');

        $this->assertEquals($payload, $result);
    }
}
