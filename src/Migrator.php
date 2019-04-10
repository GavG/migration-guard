<?php

namespace GavG\MigrationGaurd;

use Illuminate\Database\Migrations\Migrator as DefaultMigrator;

class Migrator extends DefaultMigrator
{

  protected function fileHash($file)
  {
    return hash_file('adler32', $file);
  }

  /**
   * Run "up" a migration instance.
   *
   * @param  string  $file
   * @param  int     $batch
   * @param  bool    $pretend
   * @return void
   */
  protected function runUp($file, $batch, $pretend)
  {
      // First we will resolve a "real" instance of the migration class from this
      // migration file name. Once we have the instances we can run the actual
      // command such as "up" or "down", or we can just simulate the action.
      $migration = $this->resolve(
          $name = $this->getMigrationName($file)
      );
      if ($pretend) {
          return $this->pretendToRun($migration, 'up');
      }
      $this->note("<comment>Migrating:</comment> {$name}");
      $this->runMigration($migration, 'up');
      // Once we have run a migrations class, we will log that it was run in this
      // repository so that we don't try to run it next time we do a migration
      // in the application. A migration repository keeps the migrate order.

      //TODO: open file from migrations dir and get hash as $hash

      $this->repository->log($name, $batch, $this->fileHash($file));
      $this->note("<info>Migrated:</info>  {$name}");
  }
}
