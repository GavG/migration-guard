<?php

namespace GavG\MigrationGaurd;

use Illuminate\Database\Migrations\Migrator as DefaultMigrator;

class Migrator extends DefaultMigrator
{

  protected function fileHash($file)
  {
    return hash_file('adler32', $file);
  }

  protected function runUp($file, $batch, $pretend)
  {
      $migration = $this->resolve(
          $name = $this->getMigrationName($file)
      );
      if ($pretend) {
          return $this->pretendToRun($migration, 'up');
      }
      $this->note("<comment>Migrating:</comment> {$name}");
      $this->runMigration($migration, 'up');

      $this->repository->log($name, $batch, $this->fileHash($file));
      $this->note("<info>Migrated:</info>  {$name}");
  }
}
