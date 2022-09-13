<?php

namespace App\ParserBundle\Presentation\Web\Controller;

use App\ParserBundle\Application\GetImagesFromFile\GetImagesFromFileHandler;
use App\ParserBundle\Application\GetImagesFromFile\GetImagesFromFileQuery;
use App\ParserBundle\Application\GetShoprenterWorkerbyId\GetShoprenterWorkerByIdHandler;
use App\ParserBundle\Application\GetShoprenterWorkerbyId\GetShoprenterWorkerByIdQuery;
use App\ParserBundle\Infrastructure\Security\SecureUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FileUploadController extends AbstractController
{
    public function index(GetShoprenterWorkerByIdHandler $handler): Response
    {
        $worker = $handler->execute(new GetShoprenterWorkerByIdQuery($this->getUser()->getId()));

        return $this->render('file_upload/index.html.twig',[
            'fullName' => $worker->getFullName()
        ]);
    }

    public function upload(Request $request, GetImagesFromFileHandler $parser, GetShoprenterWorkerByIdHandler $workerGetter): Response
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('fileToUpload');

        /** @var SecureUser $user */
        $worker = $workerGetter->execute(new GetShoprenterWorkerByIdQuery($this->getUser()->getId()));

        $urls = $parser->execute(new GetImagesFromFileQuery(
            $file->getPathname(),
            $file->getClientOriginalName(),
            $worker->getId()
        ));

        return $this->render('file_upload/list.html.twig',[
            'urls' => $urls
        ]);
    }
}
