<?php

namespace Arubacao\AssetCdn\Commands;

use Illuminate\Config\Repository;
use Illuminate\Filesystem\FilesystemManager;

class EmptyCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asset-cdn:empty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes assets on CDN';

    /**
     * Execute the console command.
     *
     * @param FilesystemManager $filesystemManager
     * @param Repository $config
     *
     * @return void
     */
    public function handle(FilesystemManager $filesystemManager, Repository $config)
    {
        $filesystem = $config->get('asset-cdn.filesystem.disk');
        $filesOnCdn = $filesystemManager
            ->disk($filesystem)
            ->allFiles($config->get('asset-cdn.cdn_folder'));

        if ($filesystemManager
            ->disk($filesystem)
            ->delete($filesOnCdn)) {
            foreach ($filesOnCdn as $file) {
                $this->info("Successfully deleted: {$file}");
            }
        }
    }
}
