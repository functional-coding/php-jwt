<?php

namespace FunctionalCoding\JWT\Tests;

use PHPUnit\Framework\TestCase;
use FunctionalCoding\Illuminate\ValidationProvider;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;

class _TestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $app = Container::getInstance();
        $app->singleton('validator', function ($app) {
            $filesystem = new Filesystem;
            $loader = new FileLoader($filesystem, '');
            $translator = new Translator($loader, 'en');

            return new Factory($translator, $app);
        });

        (new ValidationProvider($app))->register();
    }
}
