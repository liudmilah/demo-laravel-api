<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

final class GenerateDocumentation extends Command
{
    protected $signature = 'api:doc';

    protected $description = 'Generate api documentation';

    public function handle(): void
    {
        $openapi = base_path('vendor/bin/openapi');
        $source = app_path();
        $target = public_path('docs/openapi.json');

        passthru('"' . PHP_BINARY . '"' . " \"{$openapi}\" \"{$source}\" --output \"{$target}\"");
    }
}

