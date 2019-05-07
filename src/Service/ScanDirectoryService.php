<?php

namespace App\Service;

use Symfony\Component\Finder\Finder;

class ScanDirectoryService
{
    /**
     * @var string
     */
    private $projectDirectory;

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
        $files = [];

        $finder = new Finder();
        $finder
            ->depth('== 0')
            ->filter(function (\SplFileInfo $file) {
                if (!is_dir($file->getRealPath())
                    && filesize($file->getRealPath()) < 1000
                    && !preg_match("/^(.+|\*+)(\.(cbr|cbz))$/i", $file->getRelativePathname())
                ) {
                    return false;
                }
            })
            ->ignoreUnreadableDirs()
            ->sortByName()
            ->in($directory)
        ;

        foreach ($finder as $file) {
            $path = $this->getRelativePath($file->getRealPath());
            $name = $file->getRelativePathname();
            if (is_dir($file->getRealPath())) {
                $files[] = [
                    'id' => md5($name),
                    'name' => $name,
                    'type' => 'folder',
                    'path' => $path,
                    'items' => $this->scan($file->getRealPath()),
                ];
            } else {
                $files[] = array(
                    'id' => md5($name),
                    'name' => $name,
                    'type' => 'file',
                    'path' => $path,
                    'size' => filesize($file->getRealPath()) // Gets the size of this file
                );
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
