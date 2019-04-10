<?php

namespace GavG\MigrationGaurd;

use Illuminate\Database\Migrations\DatabaseMigrationRepository as DefaultDatabaseMigrationRepository;

class DatabaseMigrationRepository extends DefaultDatabaseMigrationRepository
{

 public function log($file, $batch, $hash)
 {
     $record = ['migration' => $file, 'batch' => $batch, 'hash' => $hash];
     $this->table()->insert($record);
 }
}
