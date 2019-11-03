<?php

namespace App\Service\Archive;

use App\Service\Archive\ArchiveInterface;
use ZipArchive as BaseZipArchive;

class ZipArchive implements ArchiveInterface
{
    /**
     * @var BaseZipArchive
     */
    private $archive;

    /**
     * {@inheritdoc}
     */
    public function extract(string $path): array
    {
        try {
            $this->open($path);
            $this->archive->extractTo(sys_get_temp_dir());
            $entries = $this->sortFiles();
            $output = [];
            $directories = [];
            foreach ($entries as $key => $file) {
                $extractedFile = sys_get_temp_dir() .'/'. $file['name'];
                if (($file['size'] > 0) && preg_match('/jp(e?)g|gif|png/i', $extractedFile)) {
                    list($width, $height, $type, $attr) = getimagesize($extractedFile);
                    $output[] = [
                        'image' => base64_encode(file_get_contents($extractedFile)),
                        'width' => $width,
                        'height' => $height,
                        'type' => image_type_to_mime_type($type),
                    ];
                };
                is_dir($extractedFile) ? $directories[] = $extractedFile : unlink($extractedFile);
            }
            $this->close();
            $this->cleanDirectories($directories);

            return $output;
        } catch (\Exception $e) {
            throw new \Exception(sprintf("Cannot extract %s as ZipArchive.", $path));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preview(string $path): array
    {
        try {
            $this->open($path);
            $this->archive->extractTo(sys_get_temp_dir());
            $entries = $this->sortFiles();
            $output = [];
            $directories = [];
            foreach ($entries as $key => $file) {
                $extractedFile = sys_get_temp_dir() .'/'. $file['name'];
                if (($file['size'] > 0) && preg_match('/jp(e?)g|gif|png/i', $extractedFile)) {
                    list($width, $height, $type, $attr) = getimagesize($extractedFile);
                    $output[] = [
                        'image' => base64_encode(file_get_contents($extractedFile)),
                        'width' => $width,
                        'height' => $height,
                        'type' => image_type_to_mime_type($type),
                    ];
                    is_dir($extractedFile) ? $directories[] = $extractedFile : unlink($extractedFile);
                    $this->close();
                    $this->cleanDirectories($directories);

                    return $output;
                };
            }
        } catch (\Exception $e) {
            throw new \Exception(sprintf("Cannot extract %s as ZipArchive.", $path));
        }
    }

    /**
     * @param array $directories
     */
    protected function cleanDirectories(array $directories): void
    {
        foreach (array_reverse($directories) as $directory) {
            rmdir($directory);
        }
    }

    /**
     * @return array
     */
    protected function sortFiles(): array
    {
        $entries = [];
        for ($i = 0; $i < $this->archive->numFiles; $i++) {
            $entry = $this->archive->statIndex($i);
            $entries[$i] = $entry;
        }
        asort($entries);

        return $entries;
    }

    /**
     * @param string $path
     *
     * @throws \Exception
     */
    protected function open($path): void
    {
        try {
            $this->archive = new BaseZipArchive;
            $this->archive->open($path);
        } catch (\Exception $e) {
            throw new \Exception(sprintf("Cannot open %s as ZipArchive, Is PHP Zip extension installed ?", $path));
        }
    }

    /**
     * @throws \Exception
     */
    protected function close(): void
    {
        try {
            $this->archive->close();
        } catch (\Exception $e) {
            throw new \Exception(sprintf("Cannot close %s as ZipArchive.", $path));
        }
    }
}
