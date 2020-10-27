<?php

namespace FreshinUp\ActivityApi\Tests;

use FreshinUp\ActivityApi\ActivityApiServiceProvider;
use FreshinUp\ActivityApi\Seeds\DatabaseSeeder;
use FreshinUp\FreshBusForms\Providers\AppServiceProvider;
use FreshinUp\FreshBusForms\Providers\HelpersServiceProvider;
use FreshinUp\FreshBusForms\RouteRegistrar;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Routing\Router;
use Spatie\JsonApiPaginate\JsonApiPaginateServiceProvider;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use Spatie\Permission\PermissionServiceProvider;
use Spatie\QueryBuilder\QueryBuilderServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use AssertionUtilsTrait;
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        include_once __DIR__ . '/../vendor/jjclane/laravel-sqlite-migrations/src/SQLiteMigration.php';
        include_once __DIR__ . '/../vendor/spatie/laravel-medialibrary/database/migrations/create_media_table.php.stub';
        (new \CreateMediaTable())->up();


        $this->loadMigrationsFrom([
            '--database' => 'sqlite',
            '--path' => __DIR__ . '/../vendor/laravel/passport/database/migrations'
        ]);
        $this->loadMigrationsFrom([
            '--database' => 'sqlite',
            '--path' => __DIR__ . '/../vendor/freshinup/fresh-bus-forms/database/migrations'
        ]);
        $this->withFactories(__DIR__ . '/../vendor/freshinup/fresh-bus-forms/database/factories');

        // app
        $this->loadMigrationsFrom([
            '--database' => 'sqlite',
            '--path' => __DIR__ . '/../database/migrations'
        ]);
        $this->withFactories(__DIR__ . '/../database/factories');
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');


        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
        $app['config']->set('app.fpokey', 'base64:aky6VPaLV7lMnlMDouv5kkcC8djAn5zJh5hpeLPep5Y=');

        // Use test User model for users provider
        $app['config']->set('cache.prefix', 'fresh-bus_tests---');
        $app['config']->set('mail.driver', 'log');
        // Load routes
        require __DIR__ . '/../routes/api.php';
        $this->setUpRoutes($app);
    }

    protected function setUpRoutes($app)
    {
        /** @var Router $router */
        $router = $app['router'];
        $routeRegistrar = new RouteRegistrar($router);
        $routeRegistrar->registerRoutes();
        $routeRegistrar->registerMiddleware();
    }

    protected function getPackageProviders($app)
    {
        return [
            ActivityApiServiceProvider::class,
            AppServiceProvider::class,
            HelpersServiceProvider::class,
            QueryBuilderServiceProvider::class,
            JsonApiPaginateServiceProvider::class,
            MediaLibraryServiceProvider::class,
            PermissionServiceProvider::class,
        ];
    }

    /**
     * Dump the response in case the response status code does not match the one specified as parameter (200 as default)
     * @param TestResponse $response
     * @param int $status
     * @return TestResponse
     */
    protected function assertSuccess(TestResponse $response, $status = 200)
    {
        if ($response->status() != $status) {
            dump($response);
        }
        return $response->assertStatus($status);
    }

    protected function assertNotExceptionResponse($response)
    {
        $message = is_a($response->exception, \Exception::class) ? $response->exception->getMessage() : '';
        $this->assertEmpty($response->exception, $message);
    }
}
