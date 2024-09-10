<?php

namespace IdrissaNdiouck\LaravelWolof\Commands;

use Illuminate\Console\Command;

class LaravelWolofCommand extends Command
{
    public $signature = 'laravel-wolof';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
