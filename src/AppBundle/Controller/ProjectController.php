<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\Form\Extension\Core\Type\FormType;
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
    public function newProjectAction(Request $request)
    {

        $project = new Project();
        $project->setStartAt(new \DateTime());
        dump($project);

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->get("doctrine.orm.entity_manager");

            $entityManager->persist($project);

            $entityManager->flush();

            $this->addFlash(
                'project-list',
                'Проект был создан'
            );

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
        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->get("doctrine.orm.entity_manager");
            $entityManager->persist($project);

            $entityManager->flush();


            $this->addFlash(
                'project-list',
                'Отредактировано'
            );

            return $this->redirectToRoute("project-list");
        } else {
            return $this->render('AppBundle:Project:new.html.twig', [
                "form" => $form->createView()
            ]);
        }

    }

    /**
     * @Route("/project/delete_{project}", name="project-delete")
     */
    public function deleteProjectAction(Project $project, Request $request)
    {
        $form = $this->createForm(FormType::class);
        $form->add('delete', 'submit');
        $form->add('cancel', 'submit');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('delete')->isClicked()) {
                $entityManager = $this->get("doctrine.orm.entity_manager");
                $entityManager->remove($project);

                $entityManager->flush();

                $this->addFlash(
                    'project-list',
                    'Проект был удален'
                );
            };


            return $this->redirectToRoute("project-list");
        } else {
            return $this->render('AppBundle:Project:delete.html.twig', [
                "form" => $form->createView()
            ]);
        }

    }


}
