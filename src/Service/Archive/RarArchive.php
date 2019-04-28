<?php

namespace App\Service\Archive;

use App\Service\Archive\ArchiveInterface;
use RarArchive as BaseRarArchive;

class RarArchive implements ArchiveInterface
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
            $entries = $this->archive->getEntries();
            $entries = $this->sortFiles($entries);
            $output = [];
            foreach ($entries as $file) {
                if (($file->getUnpackedSize() > 0) && preg_match('/jp(e?)g|gif|png/i', $file->getName())) {
                    $file->extract(sys_get_temp_dir());
                    $extractedFile = sys_get_temp_dir() .'/'. $file->getName();
                    $output[] = base64_encode(file_get_contents($extractedFile));
                    unlink($extractedFile);
                };
            }
            $this->close();

            return $output;
        } catch (\Exception $e) {
            throw new \Exception(sprintf("Cannot extract %s as RarArchive.", $path));
        }
    }

    /**
     * @param  array $files
     *
     * @return array
     */
    protected function sortFiles(array $files): array
    {
        usort($files, function ($a, $b) {
            $a1 = $a->getName();
            $b1 = $b->getName();

            return strcmp($a1, $b1);
        });

        return $files;
    }

    /**
     * @param string $path
     *
     * @throws \Exception
     */
    protected function open(string $path)
    {
        try {
            $this->archive =  BaseRarArchive::open($path);
        } catch (\Exception $e) {
            throw new \Exception(sprintf("Cannot open %s as RarArchive, Is PHP Rar extension installed ?", $path));
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
            throw new \Exception(sprintf("Cannot close %s as RarArchive.", $path));
        }
    }
}
