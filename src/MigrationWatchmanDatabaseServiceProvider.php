<?php

use Illuminate\Database\MigrationServiceProvider;
use MigrationWatchman\WatchmanMigrator;
use MigrationWatchman\WatchmanDatabaseMigrationRepository;

class MigrationWatchmanServiceProvider extends MigrationServiceProvider
{

  protected function registerRepository()
  {
      //Publish and run our migration to add the hash column first

      $this->app->singleton('migration.watchman_repository', function ($app) {
          $table = $app['config']['database.migrations'];
          return new WatchmanDatabaseMigrationRepository($app['db'], $table);
      });
  }

  protected function registerMigrator()
  {
      $this->app->singleton('migrator', function ($app) {
          $repository = $app['migration.watchman_repository'];
          return new WatchmanMigrator($repository, $app['db'], $app['files']);
      });
  }
}
