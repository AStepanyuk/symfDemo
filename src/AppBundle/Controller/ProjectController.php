<?php

namespace AppBundle\Controller;

use AppBundle\Entity\LikeItem;
use AppBundle\Entity\Project;
use AppBundle\Form\ProjectType;
use AppBundle\Repository\LikeItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProjectController
 * @Route("projects/")
 */
class ProjectController extends Controller
{
    /**
     * @Route(name = "project-list")
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
     * @Route("{project}/view", name="project-view")
     */
    public function viewAction(Project $project)
    {
        $em = $this->getDoctrine()->getManager();

        $likesRepo = $em->getRepository("AppBundle:LikeItem");

        /** @var LikeItemRepository $likesRepo */
        $likes = $likesRepo->getLikesForProject($project);
        if ($project->getLikesCount() !== count($likes)){
            $project->setLikesCount(count($likes));
            $em->persist($project);
            $em->flush();

        }
        return $this->render('AppBundle:Project:view.html.twig', [
            "project" => $project,
            "likes" => $likes,
        ]);

    }


    /**
     * @Route("new", name="project-new", requirements={"project"="\d+"})
     */
    public function newProjectAction(Request $request)
    {

        $project = new Project();
        $project->setStartAt(new \DateTime());

        dump($project);

        $form = $this->createForm(ProjectType::class, $project);
//        $form->add('cancel', 'submit');

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return $this->redirectToRoute("project-list");
        } else {
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

    }


    /**
     * @Route("{project}/edit"  , name="project-edit")
     */
    public function editProjectAction(Project $project, Request $request)
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->add('cancel', 'submit');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->get("doctrine.orm.entity_manager");

            if ($form->get('cancel')->isClicked()) {
                return $this->redirectToRoute("project-list");
            } else {
                $entityManager->persist($project);

                $entityManager->flush();


                $this->addFlash(
                    'project-list',
                    'Отредактировано'
                );
            };

            return $this->redirectToRoute("project-list");
        } else {
            return $this->render('AppBundle:Project:new.html.twig', [
                "form" => $form->createView()
            ]);
        }

    }

    /**
     * @Route("{project}/delete", name="project-delete")
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

    /**
     * @Route("{project}/like", name="project-add-like")
     */
    public function addLikeAction(Project $project, Request $request)
    {
        $like = new LikeItem();
        $like
            ->setAddAt(new \DateTime())
            ->setObjectId($project->getId())
            ->setObjectType("project")
            ->setIp($request->getClientIp());


        $curLikes = $project->getLikesCount();
        $project->setLikesCount($curLikes + 1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($project);
        $em->persist($like);
        $em->flush();

        $from = $request->get("from");

        if ($from == "list") {
            return $this->redirectToRoute("project-list");
        } else {
            return $this->redirectToRoute("project-view", ['project' => $project->getId()]);
        }
    }


}
