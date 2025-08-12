<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShowEnv extends Command
{
    protected $signature = 'env:show';

    protected $description = 'Show PHP environment variables, including PATH';

    public function handle()
    {
        $path = getenv('PATH') ?: 'PATH not set';
        $this->info("PHP PATH environment variable:");
        $this->line($path);

        $this->info("\nAll environment variables (env):");
        foreach ($_ENV as $key => $value) {
            $this->line("$key = $value");
        }

        return 0;
    }
}
