<?php

namespace App\Controllers;

use App\Models\User\UserModel;
use Common\Attributes\Get;
use Common\Attributes\Post;
use Common\Attributes\Route;
use Common\Enums\RouteMethod;
use Config\Route\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends AbstractController
{
    #[Get("/login")]
    public function loginIndex(Request $request, Response $response): void
    {
        $response->render('login/index.html.twig');
    }

    #[Post("/login")]
    public function loginCheck(Request $request, Response $response)
    {
        $loginData = json_decode($request->getContent(), true);
        $erroMessage = "Email/password invalidos, tente novamente!";

        if (empty($loginData['email']) || empty($loginData['password'])) {
            return $response->json([
                "error" => $erroMessage
            ]);
        }

        $repository = $this->getRepository(UserModel::class);
        $userFound = $repository->findBy([ "email" => $loginData['email'] ]);

        if (count($userFound)) {
            if ($userFound['password'] !== $loginData['password']) {
                return $response->json([
                    "error" => $erroMessage
                ]);
            }
            $_SESSION['user'] = serialize($userFound);
        }

        return $response->json($userFound);
    }

    #[Get("/logout")]
    public function logoutIndex(Request $request, Response $response): void
    {
        session_destroy();
        $response->render('home/index.html.twig');
    }
}
