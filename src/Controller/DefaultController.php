<?php

namespace App\Controller;

use App\Service\ReaderService;
use App\Service\ScanDirectoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
      * @Route("/")
      */
    public function index()
    {
        return $this->render('index.html.twig');
    }

    /**
      * @Route("/scan")
      */
    public function scan(ScanDirectoryService $service): JsonResponse
    {
        return new JsonResponse(
            [
                "name" => "files",
                "type" => "folder",
                "path" => 'files',
                "items" => $service->scan($this->getParameter('kernel.project_dir') . '/public/files'),
            ]
        );
    }

    /**
     * @Route("/read/{path}", requirements={"path"=".+"})
     */
    public function read(string $path, ReaderService $service)
    {
        $path = $this->getParameter('kernel.project_dir') . '/public/' . rawurldecode($path);

        return new JsonResponse($service->read($path));
    }
}
