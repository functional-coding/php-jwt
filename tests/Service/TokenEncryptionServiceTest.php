<?php

namespace FunctionalCoding\JWT\Tests\Service;

use FunctionalCoding\JWT\Service\TokenEncryptionService;
use FunctionalCoding\JWT\Tests\_TestCase;

/**
 * @internal
 * @coversNothing
 */
class TokenEncryptionServiceTest extends _TestCase
{
    public function testBasicCase()
    {
        $service = new TokenEncryptionService([
            'key' => file_get_contents(__DIR__.'/../_Fixture/id_rsa.pub'),
            'payload' => ['key1' => 'value1'],
        ], [
            'key' => '...',
            'payload' => '...',
        ]);
        $result = $service->run();

        $this->assertIsString('string', $result);
    }
}
