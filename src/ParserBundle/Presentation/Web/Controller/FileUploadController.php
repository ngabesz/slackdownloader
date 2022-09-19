<?php

namespace App\ParserBundle\Presentation\Web\Controller;

use App\ParserBundle\Application\GetImagesFromFile\GetImagesFromFileQuery;
use App\ParserBundle\Application\GetShoprenterWorkerById\GetShoprenterWorkerByIdQuery;
use App\ParserBundle\Domain\ShoprenterWorker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class FileUploadController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function index(): Response
    {
        /** @var ShoprenterWorker $worker */
        $worker = $this->handle(new GetShoprenterWorkerByIdQuery($this->getUser()->getId()));

        return $this->render('file_upload/index.html.twig',[
            'fullName' => $worker->getFullName()
        ]);
    }

    public function upload(Request $request): Response
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('fileToUpload');

        /** @var ShoprenterWorker $worker */
        $worker = $this->handle(new GetShoprenterWorkerByIdQuery($this->getUser()->getId()));

        $urls = $this->handle(new GetImagesFromFileQuery(
            $file->getPathname(),
            $file->getClientOriginalName(),
            $worker->getId()
        ));

        return $this->render('file_upload/list.html.twig',[
            'urls' => $urls
        ]);
    }
}
