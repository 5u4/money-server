<?php

namespace App\Providers;

use GraphAware\Neo4j\OGM\EntityManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /** Neo4J EntityManager Binding */
        $this->app->bind(EntityManager::class, function () {
            return EntityManager::create(self::neoConnection());
        });
    }

    /**
     * Neo4J Connection Credentials
     *
     * @return string
     */
    private static function neoConnection(): string
    {
        return sprintf(
            "%s://%s:%s@%s:%s",
            config('database.connections.neo4j.scheme'),
            config('database.connections.neo4j.username'),
            config('database.connections.neo4j.password'),
            config('database.connections.neo4j.host'),
            config('database.connections.neo4j.port')
        );
    }
}
