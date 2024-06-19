<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearItemImagesStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the item_images folder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $folder = 'public/item_images';

        // Check if the folder exists
        if (Storage::exists($folder)) {
            // Delete all files in the folder
            Storage::deleteDirectory($folder);

            $this->info('item_images folder cleared successfully.');
        } else {
            $this->warn('item_images folder not found.');
        }

        return 0;
    }
}
