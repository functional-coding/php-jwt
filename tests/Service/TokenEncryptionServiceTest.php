<?php

namespace SimplifyServiceLayer\JWT\Tests\Service;

use SimplifyServiceLayer\JWT\Service\TokenEncryptionService;

/**
 * @internal
 *
 * @coversNothing
 */
class TokenEncryptionServiceTest extends _TestCase
{
    public function testBasicCase()
    {
        $service = new TokenEncryptionService([
            'payload' => ['key1' => 'value1'],
            'public_key' => file_get_contents(__DIR__.'/_Fixture/id_rsa.pub'),
        ], [
            'payload' => '...',
            'public_key' => '...',
        ]);
        $service->run();
        $result = $service->getData()->offsetGet('result');

        $this->assertIsString($result);
    }
}
