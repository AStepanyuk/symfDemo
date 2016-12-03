<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length as LengthConstraint;

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
    public function newProjectAction(Request $request)
    {

        $project = new Project();

        $form = $this->createProjectForm($project);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->get("doctrine.orm.entity_manager");

            $entityManager->persist($project);

            $entityManager->flush();

            return $this->redirectToRoute("project-list");
        } else {
            return $this->render('AppBundle:Project:new.html.twig', [
                "form" => $form->createView()
            ]);
        }

    }


    /**
     * @Route("/project/edit_{project}", name="project-edit")
     */
    public function editProjectAction(Project $project, Request $request)
    {
        $form = $this->createProjectForm($project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->get("doctrine.orm.entity_manager");
            $entityManager->persist($project);

            $entityManager->flush();

            return $this->redirectToRoute("project-list");
        } else {
            return $this->render('AppBundle:Project:new.html.twig', [
                "form" => $form->createView()
            ]);
        }

    }

    /**
     * @param Project $project
     * @return \Symfony\Component\Form\Form
     */
    private function createProjectForm(Project $project)
    {
        $form = $this->createForm("form", $project);
        $form->add("name", "text", [
            "required" => false,
            "constraints" => [
                new LengthConstraint([
                    "min" => 3,
                    "max" => 50,
                ])
            ],])
            ->add("description", "textarea", [
                "required" => false,])
            ->add("aboutText", "textarea", [
                "required" => false,])
            ->add("priority", "integer", [
                "required" => false,])
            ->add("startAt", "datetime", [
                "required" => false,])
            ->add("isClosed", "checkbox", [
                "required" => false,
                "label" => "Проект закрыт?"
            ])
            ->add("submit", "submit");

        return $form;

    }
}
