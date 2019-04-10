<?php

namespace GavG\MigrationGaurd;

use Illuminate\Database\Migrations\DatabaseMigrationRepository;

class MigrationGaurdDatabaseMigrationRepository extends DatabaseMigrationRepository
{
  /**
  * Log that a migration was run.
  *
  * @param  string  $file
  * @param  int     $batch
  * @param  string  $hash
  * @return void
  */
 public function log($file, $batch, $hash)
 {
     $record = ['migration' => $file, 'batch' => $batch, 'hash' => $hash];
     $this->table()->insert($record);
 }
}
