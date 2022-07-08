<?php

namespace App\Presentation\Web\Controller;

use App\Application\GetImagesFromFile\GetImagesFromFileHandler;
use App\Application\GetImagesFromFile\GetImagesFromFileQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FileUploadController extends AbstractController
{
    /**
     * @Route("/file/upload", name="app_file_upload", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('file_upload/index.html.twig');
    }

    /**
     * @Route("/file/upload/post", name="app_file_upload_post", methods={"POST"})
     */
    public function upload(Request $request, GetImagesFromFileHandler $handler): Response
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('fileToUpload');

        $urls = $handler->execute(new GetImagesFromFileQuery(
            $file->getPathname(),
            $file->getClientOriginalName()
        ));

        return $this->render('file_upload/list.html.twig',[
            'urls' => $urls
        ]);
    }
}
