<?php
declare(strict_types=1);

namespace Tests;

abstract class ApiTestCase extends TestCase
{
    protected string $baseUri = "/api/v1";
}
