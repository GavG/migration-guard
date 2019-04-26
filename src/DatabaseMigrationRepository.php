<?php

namespace GavG\MigrationGuard;

use Illuminate\Database\Migrations\DatabaseMigrationRepository as DefaultDatabaseMigrationRepository;

class DatabaseMigrationRepository extends DefaultDatabaseMigrationRepository
{
    public function log($file, $batch, $hash = null)
    {
        $record = $this->haveHashColumn() ? ['migration' => $file, 'batch' => $batch, 'hash' => $hash] : ['migration' => $file, 'batch' => $batch];
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

    private function haveHashColumn()
    {
        static $res;

        if ($res) {
            return true;
        }

        $migration = $this->getRows()[0] ?? [];

        if (is_null($migration)) {
            return false;
        }

        return $res = array_key_exists('hash', $migration);
    }
}
