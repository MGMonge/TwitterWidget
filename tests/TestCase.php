<?php

namespace Tests;

use Mockery;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://my.eta.webapp';

    public function setUp(): void
    {
        parent::setUp();

        $this->_before();
    }

    public function tearDown(): void
    {
        $this->_after();

        parent::tearDown();

        Mockery::close();
    }

    protected function _before()
    {
        // Override
    }

    protected function _after()
    {
        // Override
    }
}