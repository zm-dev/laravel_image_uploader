<?php

namespace ZMDev\ImageUploader;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use ZMDev\ImageUploader\ImageURL\ImageproxyURL;
use ZMDev\ImageUploader\ImageURL\IURL;

class ServiceProvider extends BaseServiceProvider
{

    public function boot(Router $router)
    {
        $this->publishes([
            __DIR__ . '/../config/image_uploader.php' => config_path('image_uploader.php'),
        ], 'config');

        if (!class_exists('CreatePermissionTables')) {
            $timestamp = date('Y_m_d_His', time());
            $this->publishes([
                __DIR__ . '/../database/migrations/create_images_table.php.stub' => database_path("/migrations/{$timestamp}_create_images_table.php"),
            ], 'migrations');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__) . '/config/image_uploader.php', 'image_uploader');
        $this->app->singleton(IHasher::class, function () {
            return new MD5Hasher();
        });

        $this->app->singleton(IUploader::class, function () {
            return new LaravelFSUploader(config('image_uploader.disk'));
        });

        $this->app->singleton(IURL::class, function () {
            $config = config('image_uploader');
            return new ImageproxyURL(
                $config['url']['imageproxy']['imageproxy_host'],
                $config['url']['imageproxy']['base_url'],
                $config['url']['imageproxy']['bucket_name'],
                $config['url']['imageproxy']['omit_base_url']
            );
        });
    }

}
