<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function login(AuthenticationUtils $utils): Response
    {
        $role = null;
        $user = $this->security->getUser();
        if ($user !== null) {
            $role = $this->security->getUser()->getRoles()[0];
        }

        $lastUserName = $utils->getLastUsername();
        $error = $utils->getLastAuthenticationError();
        return $this->render('security/index.html.twig', [
            'lastUserName' => $lastUserName,
            'error'=> $error,
            'user_role' => $role
        ]);
    }
}
