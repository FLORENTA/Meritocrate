<?php

namespace MeritocrateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MeritocrateBundle:Default:index.html.twig');
    }

    /* Method for creating a new discussion */

    public function newDiscussionAction(Request $request)
    {
        $discussion = new Discussion();
        $form = $this->createForm('MeritocrateBundle\Form\DiscussionType', $discussion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($discussion);
            $em->flush();

            return $this->redirectToRoute('discussion_show', array('id' => $discussion->getId()));
        }

        return $this->render('discussion/discussion.html.twig', array(
            'discussion' => $discussion,
            'form' => $form->createView(),
        ));
    }
}
