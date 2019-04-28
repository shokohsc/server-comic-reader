<?php

namespace App\Factory;

use App\Exception\UnknownArchiveMimeTypeException;
use App\Service\Archive\ArchiveInterface;
use App\Service\Archive\RarArchive;
use App\Service\Archive\ZipArchive;
use Symfony\Component\Mime\MimeTypes;

class ArchiveFactory implements FactoryInterface
{
    /**
     * @var MimeTypes
     */
    private $mimeTypes;

    /**
     * @param MimeTypes $mimeTypes
     */
    public function __construct(MimeTypes $mimeTypes)
    {
      $this->mimeTypes = $mimeTypes;
    }

    /**
     * @inheritdoc
     */
    public function build(string $path): ArchiveInterface
    {
      $mimeType = $this->mimeTypes->guessMimeType($path);

      switch (true) {
        case in_array($mimeType, $this->mimeTypes->getMimeTypes('rar')):
          return new RarArchive;
          break;

        case in_array($mimeType, $this->mimeTypes->getMimeTypes('zip')):
          return new ZipArchive;
          break;

        default:
          throw new UnknownArchiveMimeTypeException;
          break;
      }
    }
}
