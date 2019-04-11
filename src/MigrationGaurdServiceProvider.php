<?php

namespace GavG\MigrationGaurd;

use Illuminate\Database\MigrationServiceProvider as DefaultMigrationServiceProvider;
use GavG\MigrationGaurd\Migrator;
use GavG\MigrationGaurd\DatabaseMigrationRepository;

class MigrationGaurdServiceProvider extends DefaultMigrationServiceProvider
{

  public function boot()
  {
    print("\nBooting MigrationGaurdServiceProvider\n");
    $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    $this->registerRepository();
    $this->registerMigrator();
  }

  protected function registerRepository()
  {
      $this->app->singleton('migration.watchman_repository', function ($app) {
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
