<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CustomLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:custom-link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backport of Laravel 7 links in filesystems';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $links = config('filesystems.links');

        foreach ($links as $public_path => $storage_path)
        {
            $this->laravel->make('files')->link(
                $storage_path, $public_path
            );
        }
    }
}
