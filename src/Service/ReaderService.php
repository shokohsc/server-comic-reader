<?php

namespace App\Service;

use App\Entity\Comic;
use App\Entity\Page;
use App\Factory\FactoryInterface;
use App\Provider\ComicProvider;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Selectable;

class ReaderService
{
    const BANDWIDTH_LIMIT_MB = 2;
    const LOW_QUALITY = 40;
    const HIGH_QUALITY = 100;

    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var ComicProvider
     */
    private $provider;

    /**
    * @param FactoryInterface $factory
    * @param EntityManagerInterface $manager
    * @param ComicProvider $provider
     */
    public function __construct(
        FactoryInterface $factory,
        EntityManagerInterface $manager,
        ComicProvider $provider
    )
    {
        $this->factory = $factory;
        $this->manager = $manager;
        $this->provider = $provider;
    }

    /**
     * @param  string $path
     * @param  string $downlink
     *
     * @return array
     */
    public function read(string $path, string $downlink): array
    {
        // Removing database connection until a check is done ot sync files and database entries
        // $comic = $this->provider->get(base64_encode($path));
        // if (null !== $comic) {
        //     return $this->format($comic->getPages());
        // }

        return $this->save($path, $downlink);
    }

    /**
     * @param  string $path
     *
     * @return array
     */
    public function preview(string $path): array
    {
        $archive = $this->factory->build($path);
        $pages = $archive->preview($path);

        $comic = (new Comic)
            ->setPath($path)
            ->setHash(base64_encode($path))
        ;

        foreach ($pages as $page) {
            $object = (new Page)
                ->setImage($page['image'])
                ->setHeight($page['height'])
                ->setWidth($page['width'])
                ->setType($page['type'])
            ;
            $comic->addPage($object);
        }

        return $this->format($comic->getPages());
    }

    /**
     * @param  string $path
     * @param  string $downlink
     *
     * @return array
     *
     */
    protected function save(string $path, string $downlink): array
    {
        $archive = $this->factory->build($path);
        $pages = $archive->extract($path);

        $comic = (new Comic)
            ->setPath($path)
            ->setHash(base64_encode($path))
        ;

        foreach ($pages as $page) {
            $object = (new Page)
                ->setImage($page['image'])
                ->setHeight($page['height'])
                ->setWidth($page['width'])
                ->setType($page['type'])
            ;
            $comic->addPage($object);
        }

        // $this->manager->persist($comic);
        // $this->manager->flush();

        return $this->format($comic->getPages(), $downlink);
    }

    /**
     * @param  Selectable $collection
     * @param  string $downlink
     *
     * @return array
     *
     */
    protected function format(Selectable $collection, string $downlink = '0'): array
    {
        $output = [];
        foreach ($collection as $page) {
            $output[] = [
                'image' => $this->compress($page->getImage(), $downlink),
                'type' => $page->getType(),
                'width' => $page->getWidth(),
                'height' => $page->getHeight(),
            ];
        }

        return $output;
    }

    /**
     * @param  string $source
     * @param  string $downlink
     *
     * @return string
     */
    protected function compress(string $source, string $downlink): string
    {
        $source = base64_decode($source);
        $file = sys_get_temp_dir() .'/output'. uniqid();
        file_put_contents($file, $source);
        $info = getimagesize($file);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($file);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($file);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($file);

        $destination = $file .'.jpg';
        $quality = floatval($downlink) < self::BANDWIDTH_LIMIT_MB ? self::LOW_QUALITY : self::HIGH_QUALITY;
        imagejpeg($image, $destination, $quality);
        $output = base64_encode(file_get_contents($destination));

        unlink($file);
        unlink($destination);

        return $output;
    }
}
