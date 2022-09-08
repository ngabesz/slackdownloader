<?php

namespace App\ParserBundle\Presentation\Web\Controller;

use App\ParserBundle\Application\GetImagesFromFile\GetImagesFromFileHandler;
use App\ParserBundle\Application\GetImagesFromFile\GetImagesFromFileQuery;
use App\ParserBundle\Infrastructure\Security\SecureUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FileUploadController extends AbstractController
{
    public function index(): Response
    {
        /** @var SecureUser $user */
        $user = $this->getUser();

        return $this->render('file_upload/index.html.twig',[
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'userName' => $user->getUserIdentifier()
        ]);
    }

    public function upload(Request $request, GetImagesFromFileHandler $handler): Response
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('fileToUpload');

        /** @var SecureUser $user */
        $user = $this->getUser();

        $urls = $handler->execute(new GetImagesFromFileQuery(
            $file->getPathname(),
            $file->getClientOriginalName()
        ));

        return $this->render('file_upload/list.html.twig',[
            'urls' => $urls
        ]);
    }
}
