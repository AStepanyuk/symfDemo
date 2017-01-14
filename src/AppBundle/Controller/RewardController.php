<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProjectReward;
use AppBundle\Entity\Reward;
use AppBundle\Form\ProjectRewardType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Reward controller.
 *
 * @Route("reward")
 */
class RewardController extends Controller
{
    /**
     * Lists all reward entities.
     *
     * @Route("/", name="reward_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rewards = $em->getRepository('AppBundle:Reward')->findAll();

        return $this->render('@App/reward/index.html.twig', array(
            'rewards' => $rewards,
        ));
    }

    /**
     * Creates a new reward entity.
     *
     * @Route("/new", name="reward_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $reward = new Reward();
        $form = $this->createForm('AppBundle\Form\RewardType', $reward);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reward);
            $em->flush($reward);

            return $this->redirectToRoute('reward_show', array('id' => $reward->getId()));
        }

        return $this->render('@App/reward/new.html.twig', array(
            'reward' => $reward,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reward entity.
     *
     * @Route("/{id}", name="reward_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(Reward $reward)
    {
        $deleteForm = $this->createDeleteForm($reward);

        return $this->render('@App/reward/show.html.twig', array(
            'reward' => $reward,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reward entity.
     *
     * @Route("/{id}/edit", name="reward_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Reward $reward)
    {
        $deleteForm = $this->createDeleteForm($reward);
        $editForm = $this->createForm('AppBundle\Form\RewardType', $reward);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reward_edit', array('id' => $reward->getId()));
        }

        return $this->render('@App/reward/show.html.twig', array(
            'reward' => $reward,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reward entity.
     *
     * @Route("/{id}", name="reward_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Reward $reward)
    {
        $form = $this->createDeleteForm($reward);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reward);
            $em->flush($reward);
        }

        return $this->redirectToRoute('reward_index');
    }

    /**
     * Creates a form to delete a reward entity.
     *
     * @param Reward $reward The reward entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reward $reward)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reward_delete', array('id' => $reward->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * @Route("/award_project", name="award_project")
     */
    public function projectAwardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $award = new ProjectReward();
        $award->setAddAt(new \DateTime());

        $projectId= $request->get('project');
        if ($projectId) {
            $project = $em->getRepository("AppBundle:Project")->find($projectId);
            $award->setProject($project);
        }

        $rewardId= $request->get('reward');
        if ($rewardId){
            $reward = $em->getRepository("AppBundle:Reward")->find($rewardId);
            $award->setReward($reward);
        }





        $form = $this->createForm(ProjectRewardType::class, $award);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($award);
            $em->flush();

            return $this->redirectToRoute("project-view", ["project"=> $award->getProject()->getId()]);

        } else {

            return $this->render('@App/reward/awardEdit.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
}
