<?php

namespace App\Service\Archive;

use App\Service\Archive\ArchiveInterface;
use ZipArchive as BaseZipArchive;

class ZipArchive implements ArchiveInterface
{
    /**
     * @var BaseRarArchive
     */
    private $archive;

    /**
     * @inheritdoc
     */
    public function extract(string $path): array
    {
        try {
            $this->open($path);

            $entries = [];
            for ($i = 0; $i < $this->archive->numFiles; $i++) {
                $entry = $this->archive->statIndex($i);
                $entries[$i] = $entry;
            }
            asort($entries);
            $output = [];
            foreach ($entries as $entry) {
                $name = $entry['name'];
                $size = $entry['size'];
                if (preg_match('/(jp(e?)g|png|gif)$/i', $name)) {
                    $resource = $this->archive->getStream($name);
                    $contents = fread($resource, $size);
                    $output[] = base64_encode($contents);
                    fclose($resource);
                }
            }
            $this->close();

            return $output;
        } catch (\Exception $e) {
            throw new \Exception(sprintf("Cannot extract %s as ZipArchive.", $path));
        }
    }

    /**
     * @inheritdoc
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
     * @inheritdoc
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
