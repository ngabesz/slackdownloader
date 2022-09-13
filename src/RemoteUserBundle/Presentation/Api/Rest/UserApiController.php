<?php

namespace App\RemoteUserBundle\Presentation\Api\Rest;

use App\RemoteUserBundle\Application\Exception\UserNotFoundException;
use App\RemoteUserBundle\Application\GetUserByCredentials\GetUserByCredentialHandler;
use App\RemoteUserBundle\Application\GetUserByCredentials\GetUserByCredentialQuery;
use App\RemoteUserBundle\Application\GetUserByEmail\GetUserByEmailHandler;
use App\RemoteUserBundle\Application\GetUserByEmail\GetUserByEmailQuery;
use App\RemoteUserBundle\Application\GetUserById\GetUserByIdHandler;
use App\RemoteUserBundle\Application\GetUserById\GetUserByIdQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserApiController extends AbstractController
{
    public function getByEmailAction(Request $request, GetUserByEmailHandler $handler)
    {

        $email = $request->get('email');

        try {
            $user = $handler->execute(new GetUserByEmailQuery(
                $email
            ));
        } catch (UserNotFoundException $e) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ], 404);
        }

        return new JsonResponse([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'password' => $user->getPassword()
        ], 200);
    }

    public function authAction(Request $request, GetUserByCredentialHandler $handler)
    {

        $email = $request->get('email');
        $password = $request->get('password');

        try {
            $user = $handler->execute(new GetUserByCredentialQuery(
                $email,
                $password
            ));
        } catch (UserNotFoundException $e) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ], 404);
        }

        return new JsonResponse([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName()
        ], 200);
    }

    public function getByIdAction(int $userId, GetUserByIdHandler $handler)
    {

        try {
            $user = $handler->execute(new GetUserByIdQuery($userId));
        } catch (UserNotFoundException $e) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        return new JsonResponse([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'password' => $user->getPassword()
        ], 200);
    }

}