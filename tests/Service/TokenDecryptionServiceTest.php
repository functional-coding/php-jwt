<?php

namespace FunctionalCoding\JWT\Tests\Service;

use FunctionalCoding\JWT\Service\TokenDecryptionService;
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
        $result = $service->run();

        $this->assertEquals($payload, $result);
    }
}
