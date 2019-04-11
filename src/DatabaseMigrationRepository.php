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
  
  public function getRows()
  {
    return $this->table()
               ->orderBy('batch', 'asc')
               ->orderBy('migration', 'asc')
               ->get();
  }
  
  public function update($id, $data)
  {
    $this->table()->where('id', $id)->update($data);
  }
}
