<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    /**
     * @Route("project/list", name = "project-list")
     */
    public function listAction()
    {
        $entityManager = $this->get("doctrine.orm.entity_manager");
        $repo = $entityManager->getRepository("AppBundle:Project");
        $allProjects = $repo->findAll();

        dump($allProjects);

        return $this->render('AppBundle:Project:list.html.twig', [
            "allProjects" => $allProjects,
        ]);
    }

    /**
     * @Route("project/view")
     */
    public function viewAction()
    {
        return $this->render('AppBundle:Project:view.html.twig', [
            // ...
        ]);
    }


    /**
     * @Route("/project/new", name="project-new")
     */
    public function newSubmitAction(Request $request)
    {
        $fields = ["name", "description", "aboutText", "priority", "startAt", "isClosed", "submit"];
        $vars = [];
        $errors = [];


        foreach ($fields as $field) {
            $vars[$field] = $request->get($field);
        }
//        $errors[] = "У вас ошибка в ДНК";


        if (!strtotime($vars["startAt"])) {
            $errors[] = "Некорректная дата";
        }

        if (!$vars["name"]) {
            $errors[] = "Поля ИМЯ обязательно!";
        } elseif (mb_strlen($vars["name"]) < 3) {
            $errors[] = "Слишком короткое имя (min 3)";
        } elseif (mb_strlen($vars["name"]) > 50) {
            $errors[] = "Слишком длинное имя (max 50)";
        }

        if ($vars["submit"] && !count($errors)) {
            $project = new Project();

            $project->setName($vars["name"])
                ->setDescription($vars["description"])
                ->setAboutText($vars["aboutText"])
                ->setPriority($vars["priority"])
                ->setStartAt(new \DateTime($vars["startAt"]))
                ->setIsClosed($vars["isClosed"])
                ->setUsers([]);

            $entityManager = $this->get("doctrine.orm.entity_manager");

            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute("project-list");
        }
        if (!$vars["submit"]){
            $errors = [];
            $vars["startAt"] = date("Y-m-d H:i:s");


        }

        $currdate = new \DateTime();

 
        return $this->render('AppBundle:Project:new.html.twig', [
            "errors" => $errors,
            "vars" => $vars,
        ]);


//        dump($project);
    }
}
