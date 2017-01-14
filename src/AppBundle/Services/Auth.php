<?php
/**
 * Created by PhpStorm.
 * User: Adrian
 * Date: 10.12.2016
 * Time: 16:26
 */

namespace AppBundle\Services;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class Auth
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var EntityManager
     */
    protected $em;

    protected $authKey = "current_user_id";

    /**
     * @var User/null
     */
    protected $currentUser = false;

    public function __construct(EntityManager $entityManager, Session $session)
    {
        $this->session = $session;
        $this->em = $entityManager;
    }

    public function loginAs(User $user)
    {
        $this->session->set($this->authKey, $user->getId());
    }

    public function getUser()
    {
        if ($this->currentUser === false) {



            $userId = $this->session->get($this->authKey);

            $user = null;
            if ($userId) {


                $user = $this->em->getRepository('AppBundle:User')->find($userId);
            }
            $this->currentUser = $user;
        }

        return $this->currentUser;

    }

    public function logout()
    {
        $this->session->set($this->authKey, null);
    }


}