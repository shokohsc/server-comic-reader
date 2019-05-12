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
     *
     * @return array
     */
    public function read(string $path)
    {
        $comic = $this->provider->get(base64_encode($path));
        if (null !== $comic) {
            return $this->format($comic->getPages());
        }

        return $this->save($path);
    }

    /**
     * @param  string $path
     *
     * @return array
     *
     */
    protected function save(string $path)
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

        $this->manager->persist($comic);
        $this->manager->flush();

        return $this->format($comic->getPages());
    }

    /**
     * @param  Selectable $collection
     *
     * @return array
     *
     */
    protected function format(Selectable $collection)
    {
        $output = [];
        foreach ($collection as $page) {
            $output[] = [
                'image' => $page->getImage(),
                'type' => $page->getType(),
                'width' => $page->getWidth(),
                'height' => $page->getHeight(),
            ];
        }

        return $output;
    }
}
