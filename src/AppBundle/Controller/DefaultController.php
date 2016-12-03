<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/demo", name="demopage")
     */
    public function demoAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $text = $request->get("text", "Без текста");

        return $this->render('default/home.html.twig', [
            "text"=>$text
        ]);
    }

    /**
     * @Route("/count/{my_number}", name="countpage", requirements={"my_number": "\d+"})
     */
    public function countAction(Request $request)
    {
        $num = $request->get("my_number", "Без текста");
        $text = str_repeat("*", $num);

        return $this->render('default/home.html.twig', [
            "text"=>$text
        ]);
    }

}
