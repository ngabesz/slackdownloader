<?php

namespace App\ParserBundle\Presentation\Web\Controller;

use App\ParserBundle\Application\GetImagesFromFile\GetImagesFromFileHandler;
use App\ParserBundle\Application\GetImagesFromFile\GetImagesFromFileQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FileUploadController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('file_upload/index.html.twig');
    }

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
