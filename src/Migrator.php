<?php

namespace GavG\MigrationGuard;

use Illuminate\Database\Migrations\Migrator as DefaultMigrator;

class Migrator extends DefaultMigrator
{

  protected function fileHash($file)
  {
    return hash_file('adler32', $file);
  }
  
  protected function processRan($files)
  {
    foreach ($this->repository->getRows() as $migration) {
      if(array_key_exists('hash', $migration)){
      
        if(!in_array($migration->migration, array_keys($files))){
          $this->note("<error>Missing Migration File</error> {$migration->migration}");
          die();
        }
      
        $file = $files[$migration->migration];
        
        if($migration->hash){
          if($migration->hash != $this->fileHash($file)){
            $this->note("<error>Migration File Has Changed</error> {$migration->migration}");
            die();
          }
        } else {
          $this->repository->update($migration->id, ['hash' => $this->fileHash($file)]);
        }
      }
    }
  }
  
  public function run($paths = [], array $options = [])
  {
      $this->notes = [];
      
      $files = $this->getMigrationFiles($paths);
      
      $this->processRan($files);
      
      $this->requireFiles($migrations = $this->pendingMigrations(
          $files, $this->repository->getRan()
      ));

      $this->runPending($migrations, $options);
      return $migrations;
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
