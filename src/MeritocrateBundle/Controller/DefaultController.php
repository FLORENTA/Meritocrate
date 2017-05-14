<?php

namespace MeritocrateBundle\Controller;

use MeritocrateBundle\Entity\Speech;
use MeritocrateBundle\Entity\User;
use MeritocrateBundle\Entity\Merits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MeritocrateBundle\Entity\Discussion;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MeritocrateBundle:Default:index.html.twig');
    }

    public function boardAction()
    {
        return $this->render('MeritocrateBundle:Default:board.html.twig');
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

            return $this->redirectToRoute('meritocrate_discussion_group', array(
                'id' => $discussion->getId(),
            ));
        }

        return $this->render('MeritocrateBundle:Default:discussion.html.twig', array(
            'discussion' => $discussion,
            'form' => $form->createView(),
        ));
    }

    public function discussionGroupAction($id){
        $em = $this->getDoctrine()->getManager();
        $discussion = $em->getRepository('MeritocrateBundle:Discussion')->findOneById($id);
        $speeches = $em->getRepository('MeritocrateBundle:Speech')->findBy(array(
            'discussion' => $discussion
        ));
        return $this->render('MeritocrateBundle:Default:show_discussion.html.twig', array(
           'group' => $discussion,
           'speeches' => $speeches,
           'user' => $this->getUser()
        ));
    }

    public function joinDiscussionAction(){
        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('MeritocrateBundle:Discussion')->findAll();

        return $this->render('MeritocrateBundle:Default:show_groups.html.twig', array(
            'groups' => $groups
        ));
    }

    public function setSpeakerAction(Request $request){

        $speech = new Speech();
        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $idGroup = $request->request->get('idDiscussion');
            $idUser = $request->request->get('idUser');

            $discussion = $em->getRepository('MeritocrateBundle:Discussion')->findOneById($idGroup);
            $user = $em->getRepository('MeritocrateBundle:User')->findOneById($idUser);

            $speech->setUser($user);
            $speech->setDiscussion($discussion);

            $em->persist($speech);
            $em->flush();

            return new Response('You have been added to the list of speakers');
        }
    }

    public function getSpeakerAction(Request $request){
        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $idGroup = $request->request->get('idDiscussion');
            $idLastSpeech = $request->request->get('idLastSpeech');

            $discussion = $em->getRepository('MeritocrateBundle:Discussion')->findOneById($idGroup);

            $speeches = $em->getRepository('MeritocrateBundle:Speech')->myFindBy($idLastSpeech, $discussion);

            $encoders = new JsonEncoder();
            $normalizer = new ObjectNormalizer();
            $normalizer->setCircularReferenceHandler(function ($speeches) {
                return $speeches->getId();
            });
            $serializer = new Serializer(array($normalizer), array($encoders));

            $speeches = $serializer->serialize($speeches, "json");

            $response = new Response($speeches);
            $response->headers->set('Content-Type','application/json');
            return $response;
        }
    }

    public function addMeritAction(Request $request)
    {
        $merit = new Merits();

        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();

            $idSpeaker = $request->request->get('idSpeaker');
            $idRator = $request->request->get('idRator');
            $idDiscussion = $request->request->get('idDiscussion');
            $idSpeech = $request->request->get('idSpeech');

            $speaker = $em->getRepository('MeritocrateBundle:User')->findOneById($idSpeaker);
            $rator = $em->getRepository('MeritocrateBundle:User')->findOneById($idRator);
            $discussion = $em->getRepository('MeritocrateBundle:Discussion')->findOneById($idDiscussion);
            $speech = $em->getRepository('MeritocrateBundle:Speech')->findOneById($idSpeech);

            $merit->setUser($speaker);
            $merit->setRator($rator);
            $merit->setDiscussion($discussion);
            $merit->setSpeech($speech);

            $em->persist($merit);
            $em->flush();

            return new Response('ok');
        }
    }
}
