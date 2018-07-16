<?php

namespace ZMDev\ImageUploader\Test;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as IlluminateTestCase;
use ZMDev\ImageUploader\Image;
use ZMDev\ImageUploader\ServiceProvider;


class TestCase extends IlluminateTestCase
{
    use DatabaseTransactions;

    /**
     * Creates the application.
     *
     * Needs to be implemented by subclasses.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite.database', ':memory:');
        $sp = new ServiceProvider($app);
        $sp->register();
        return $app;
    }

    /**
     * Setup DB before each test.
     */
    public function setUp()
    {
        parent::setUp();
        $this->migrate();
        $this->seed();
//        DB::listen(function ($query) {
//            $sql = str_replace('?', "'%s'", $query->sql);
//            foreach ($query->bindings as &$binding) {
//                $binding = (string)$binding;
//            }
//            $sql = sprintf($sql, ...$query->bindings);
//            echo "$sql\n";
//        });
    }

    /**
     * run package database migrations.
     */
    public function migrate()
    {
        $fileSystem = new Filesystem();
        $fileSystem->copy(
            __DIR__ . '/../database/migrations/create_images_table.php.stub',
            __DIR__ . '/../tests/create_images_table.php'
        );
        $fileSystem->requireOnce(__DIR__ . '/../tests/create_images_table.php');
        (new \CreateImagesTable())->up();
    }

    public function tearDown()
    {
        parent::tearDown();
        unlink(__DIR__ . '/../tests/create_images_table.php');
    }

    /**
     * Seed testing database.
     */
    public function seed($classname = null)
    {
        Image::create([
            'hash' => md5('test.jpg'),
            'format' => 'jpeg',
            'title' => 'test.jpg',
            'width' => 200,
            'height' => 300,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}