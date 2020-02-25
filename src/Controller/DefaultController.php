<?php

namespace App\Controller;

use App\Service\ReaderService;
use App\Service\ScanDirectoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
      * @Route("/", methods={"GET"}))
      * @Cache(expires="+15 minutes", public=true)
      */
    public function index()
    {
        return $this->render('base.html.twig');
    }

    /**
      * @Route("/scan", methods={"GET"}))
      * @Cache(expires="+5 minutes", public=true)
      */
    public function scan(ScanDirectoryService $service): JsonResponse
    {
        return new JsonResponse(
            [
                'id' => base64_encode('files'),
                'name' => 'files',
                'type' => 'folder',
                'path' => 'files',
                'items' => $service->scan($this->getParameter('kernel.project_dir') . '/public/files'),
            ]
        );
    }

    /**
     * @Route("/read/{path}", requirements={"path"=".+"}, methods={"GET"}))
     * @Cache(expires="+15 minutes", public=true)
     */
    public function read(string $path, ReaderService $service)
    {
        $path = $this->getParameter('kernel.project_dir') . '/public/' . rawurldecode($path);

        return new JsonResponse($service->read($path));
    }

    /**
     * @Route("/preview/{path}", requirements={"path"=".+"}, methods={"GET"}))
     * @Cache(expires="+60 minutes", public=true)
     */
    public function preview(string $path, ReaderService $service)
    {
        $path = $this->getParameter('kernel.project_dir') . '/public/' . rawurldecode($path);

        return new JsonResponse($service->preview($path));
    }
}
