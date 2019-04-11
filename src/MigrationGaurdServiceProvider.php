<?php

namespace GavG\MigrationGuard;

use Illuminate\Database\MigrationServiceProvider as DefaultMigrationServiceProvider;
use GavG\MigrationGuard\Migrator;
use GavG\MigrationGuard\DatabaseMigrationRepository;

class MigrationGuardServiceProvider extends DefaultMigrationServiceProvider
{

  public function boot()
  {
    $this->loadMigrationsFrom(__DIR__.'/database/migrations');
  }

  public function register()
  {
    $this->registerRepository();
    $this->registerMigrator();
  }

  protected function registerRepository()
  {
      $this->app->singleton('migration.repository', function ($app) {
          $table = $app['config']['database.migrations'];
          return new DatabaseMigrationRepository($app['db'], $table);
      });
  }

  protected function registerMigrator()
  {
      $this->app->singleton('migrator', function ($app) {
          $repository = $app['migration.repository'];
          return new Migrator($repository, $app['db'], $app['files']);
      });
  }
}
