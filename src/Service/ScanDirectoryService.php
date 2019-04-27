<?php

namespace App\Service;

class ScanDirectoryService
{
    /**
     * @param string $projectDirectory
     */
    public function __construct(string $projectDirectory)
    {
        $this->projectDirectory = $projectDirectory;
    }

    /**
     * @param  string $directory
     *
     * @return array
     */
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
              "path" => $this->getRelativePath($directory) . '/' . $f,
              "items" => $this->scan($directory . '/' . $f) // Recursively get the contents of the folder
            );
          }

          else {

            // It is a file

            $files[] = array(
              "name" => $f,
              "type" => "file",
              "path" => $this->getRelativePath($directory) . '/' . $f,
              "size" => filesize($directory . '/' . $f) // Gets the size of this file
            );
          }
        }

      }

      return $files;
    }

    /**
     * @param  string $path
     *
     * @return string
     */
    protected function getRelativePath(string $path): string
    {
      $absolutePath = $this->projectDirectory . '/public/';
      $start = strpos($path, $absolutePath);

      if (false !== $start) {
        $end = strlen($absolutePath);

        return substr($path, $end);
      }

      return $path;
    }
}
