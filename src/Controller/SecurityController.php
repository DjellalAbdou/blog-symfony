<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    public function login(AuthenticationUtils $utils): Response
    {
        $lastUserName = $utils->getLastUsername();
        $error = $utils->getLastAuthenticationError();
        return $this->render('security/index.html.twig', [
            'lastUserName' => $lastUserName,
            'error'=> $error
        ]);
    }
}
