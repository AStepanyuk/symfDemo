<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Services\Auth;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    /**
     * @Route("/auth/{id}/LoginAs", name="user_make_auth")
     * @Method({"GET"})
     */
    public function loginAsAction(User $user)
    {
        $this->get('app.services.auth')->loginAs($user);

        return $this->redirectToRoute('project-list');



//        $session ->set("current_user_id", $user->getId());

    }

    /**
     * @Route("/auth/logout", name="auth_logout")
     * @Method({"GET"})
     */
    public function logoutAction()
    {
        $this->get('app.services.auth')->logout();

        return $this->redirectToRoute('project-list');


    }
}
