<?php

namespace App\Service;

class ScanDirectoryService
{
    public function scan(string $directory): array
    {
      $files = array();

      // Is there actually such a folder/file?

      if(file_exists($directory)){

        foreach(scandir($directory) as $f) {

          if(!$f || $f[0] == '.') {
            continue; // Ignore hidden files
          }

          if(is_dir($directory . '/' . $f)) {

            // The path is a folder

            $files[] = array(
              "name" => $f,
              "type" => "folder",
              "path" => $this->hideAbsolutePath($directory) . '/' . $f,
              "items" => $this->scan($directory . '/' . $f) // Recursively get the contents of the folder
            );
          }

          else {

            // It is a file

            $files[] = array(
              "name" => $f,
              "type" => "file",
              "path" => $this->hideAbsolutePath($directory) . '/' . $f,
              "size" => filesize($directory . '/' . $f) // Gets the size of this file
            );
          }
        }

      }

      return $files;
    }

    protected function hideAbsolutePath(string $path): string
    {
      $start = strpos($path, '/var/www/html/public/');

      if (false !== $start) {
        $end = strlen('/var/www/html/public/');

        return substr($path, $end);
      }

      return $path;
    }
}
