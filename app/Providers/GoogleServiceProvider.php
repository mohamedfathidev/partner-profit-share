<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Google\Client;
use Google\Service\Drive;
use League\Flysystem\Filesystem;
use Masbug\Flysystem\GoogleDriveAdapter;
use Illuminate\Filesystem\FilesystemAdapter;

class GoogleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Storage::extend('google', function ($app, $config) {
            $client = new Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);

            $service = new Drive($client);
            $adapter = new GoogleDriveAdapter($service, $config['folderId']);
            
            // Wrap the adapter in a Filesystem instance
            $filesystem = new Filesystem($adapter);

            return new FilesystemAdapter($filesystem, $adapter, $config);
        });
    }
}