<?php

namespace FunctionalCoding\JWT\Tests;

use FunctionalCoding\JWT\TokenDecryptionService;
use JOSE_JWE;
use FunctionalCoding\JWT\Tests\_TestCase;

/**
 * @internal
 * @coversNothing
 */
class TokenDecryptionServiceTest extends _TestCase
{
    public function testBasicCase()
    {
        $payload = ['message' => 'hello world'];
        $jwe = new JOSE_JWE(\json_encode($payload));
        $jwe->encrypt(file_get_contents(__DIR__.'/fixtures/id_rsa.pub'));

        $service = new TokenDecryptionService([
            'secret_key' => file_get_contents(__DIR__.'/fixtures/id_rsa'),
            'token' => $jwe->toString(),
        ], [
            'secret_key' => '...',
            'token' => '...',
        ]);
        $result = $service->run();

        $this->assertEquals($payload, $result);
    }
}
