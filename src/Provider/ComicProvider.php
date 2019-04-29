<?php

namespace App\Provider;

use App\Repository\ComicRepository;

class ComicProvider implements ProviderInterface
{
    /**
     * @var ComicRepository
     */
    private $repository;

    /**
     * @param ComicRepository $repository [description]
     */
    public function __construct(ComicRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $hash)
    {
        return $this->repository->findOneBy(['hash' => $hash]);
    }
}
