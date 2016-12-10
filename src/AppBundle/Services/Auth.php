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

    public function logigAsAction(User $user)
    {
        $this->session->set("current_user_id", $user->getId());
    }

    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    public function getUser()
    {
        $userId = $this->session->get('current_user_id');

        $user = null;
        if ($userId) {
            $user = $this->em->getRepository('AppBundle:User')->find($userId);
        }

        return $user;

    }

    /**
     * @param EntityManager $em
     */
    public function setEntityManager($em)
    {
        $this->em = $em;
    }


}