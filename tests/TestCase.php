<?php

namespace Malbrandt\Lori\Tests;

use Malbrandt\Lori\LoriServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Base class for all test classes. Loads Lori's service provider.
 *
 * @package Malbrandt\Lori\Tests
 * @author  Marek Malbrandt <marek.malbrandt@gmail.com>
 */
abstract class TestCase extends OrchestraTestCase
{
    public function __construct(
        ?string $name = null,
        array $data = [],
        string $dataName = ''
    )
    {
        parent::__construct($name, $data, $dataName);
    }


    protected function getPackageProviders($app)
    {
        return [
            LoriServiceProvider::class,
        ];
    }
}
