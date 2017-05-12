<?php

namespace MeritocrateBundle\Controller;

use MeritocrateBundle\Entity\Discussion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Discussion controller.
 *
 */
class DiscussionController extends Controller
{
    /**
     * Lists all discussion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $discussions = $em->getRepository('MeritocrateBundle:Discussion')->findAll();

        return $this->render('discussion/index.html.twig', array(
            'discussions' => $discussions,
        ));
    }

    /**
     * Creates a new discussion entity.
     *
     */


    /**
     * Finds and displays a discussion entity.
     *
     */
    public function showAction(Discussion $discussion)
    {
        $deleteForm = $this->createDeleteForm($discussion);

        return $this->render('discussion/show.html.twig', array(
            'discussion' => $discussion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing discussion entity.
     *
     */
    public function editAction(Request $request, Discussion $discussion)
    {
        $deleteForm = $this->createDeleteForm($discussion);
        $editForm = $this->createForm('MeritocrateBundle\Form\DiscussionType', $discussion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('discussion_edit', array('id' => $discussion->getId()));
        }

        return $this->render('discussion/edit.html.twig', array(
            'discussion' => $discussion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a discussion entity.
     *
     */
    public function deleteAction(Request $request, Discussion $discussion)
    {
        $form = $this->createDeleteForm($discussion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($discussion);
            $em->flush();
        }

        return $this->redirectToRoute('discussion_index');
    }

    /**
     * Creates a form to delete a discussion entity.
     *
     * @param Discussion $discussion The discussion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Discussion $discussion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('discussion_delete', array('id' => $discussion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
