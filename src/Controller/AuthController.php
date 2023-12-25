<?php

namespace App\Controller;

use App\Utils\SessionManager;
use App\Repository\UserRepository;

class AuthController extends AbstractController
{
    private $userRepository;
    private $sessionManager;

    public function __construct(UserRepository $userRepository, SessionManager $sessionManager)
    {
        $this->userRepository = $userRepository;
        $this->sessionManager = $sessionManager;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Afficher le formulaire de login
            return $this->render('login.html.twig');
        } else {
            // Traitement du formulaire
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userRepository->findByUsername($username);
            if ($user) {
                $this->sessionManager->startSession();
                $_SESSION['user'] = $user;
                return $this->redirect('/home');
            } else {
                return $this->render('login.html.twig', ['error' => 'Identifiants incorrects']);
            }
        }
    }

    public function logout()
    {
        $this->sessionManager->destroySession();
        return $this->redirect('login.html.twig');
    }
}
