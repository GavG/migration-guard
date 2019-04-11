<?php

namespace GavG\MigrationGuard;

use Illuminate\Database\Migrations\DatabaseMigrationRepository as DefaultDatabaseMigrationRepository;

class DatabaseMigrationRepository extends DefaultDatabaseMigrationRepository
{

  public function log($file, $batch, $hash = null)
  {
     $record = ['migration' => $file, 'batch' => $batch, 'hash' => $hash];
     $this->table()->insert($record);
  }
}
