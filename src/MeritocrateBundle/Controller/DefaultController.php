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

            $user = $em->getRepository('MeritocrateBundle:User')->findOneById($this->getUser()->getId());

            $discussion->setUser($user);
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

    public function getUserDiscussionGroupAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $discussions = $em->getRepository('MeritocrateBundle:Discussion')->findBy(array(
           'user' => $this->getUser()
        ));

        foreach($discussions as $discussion){
            $forms[] = $this->createForm('MeritocrateBundle\Form\DiscussionType', $discussion)->createView();
        }

        if($request->isXmlHttpRequest()){
            $idDiscussion = $request->request->get('meritocratebundle_discussion')['id'];
            $ongoing = $request->request->get('meritocratebundle_discussion')['ongoing'];
            $discussion = $em->getRepository('MeritocrateBundle:Discussion')->findOneById($idDiscussion);
            $discussion->setOngoing($ongoing);

            $em->flush();

            if($ongoing == 0){
                $action = "closed";
            }
            else{
                $action = "open";
            }
            $discussionName = $discussion->getName();
            $response = "The " . $discussionName . " discussion group has been successfully " .$action;

            $response = new Response($response);
            return $response;
        }

        return $this->render('MeritocrateBundle:Default:settings.html.twig', array(
           'discussionForms' => $forms
        ));
    }

    public function discussionGroupAction($id){
        $em = $this->getDoctrine()->getManager();
        $discussion = $em->getRepository('MeritocrateBundle:Discussion')->findOneById($id);
        $speeches = $em->getRepository('MeritocrateBundle:Speech')->myfindSpeeches($discussion);

        return $this->render('MeritocrateBundle:Default:show_discussion.html.twig', array(
           'group' => $discussion,
           'speeches' => $speeches,
           'user' => $this->getUser()
        ));
    }

    public function groupStatisticsAction($id){
        $em = $this->getDoctrine()->getManager();
        $discussion = $em->getRepository('MeritocrateBundle:Discussion')->findOneById($id);
        $speeches = $em->getRepository('MeritocrateBundle:Speech')->myFindAll($discussion);

        /* Go checkout merits linked to each speech of the discussion chosen ($id) */
        foreach($speeches as $speech) {
            $merits[] = $em->getRepository('MeritocrateBundle:Merits')->MyFindMerits($speech);
        }

        /* Get the username of the user that has got the merits */
        foreach($speeches as $speech){
            foreach($speech->getMerits() as $merit){
                $users[] = $merit->getSpeech()->getUser()->getUsername();
            };
        }

        /* How many merits per username ? */
        $statistics = array_count_values($users);

        return $this->render('MeritocrateBundle:Default:show_group_statistics.html.twig', array(
            'group' => $discussion,
            'speeches' => $merits,
            'statistics' => $statistics
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

            $user->addSpeech($speech);
            $discussion->addSpeech($speech);

            $em->persist($speech);
            $em->flush();

            return new Response('You have been added to the list of speakers');
        }
    }

    public function getSpeechAction(Request $request){
        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();

            $idGroup = $request->request->get('idDiscussion');
            $idLastSpeech = $request->request->get('idLastSpeech');

            $discussion = $em->getRepository('MeritocrateBundle:Discussion')->findOneById($idGroup);

            $speech = $em->getRepository('MeritocrateBundle:Speech')->myFindBefore($idLastSpeech, $discussion);
            $nbSpeechesBeforeLastId = count($speech);

            $speeches = $em->getRepository('MeritocrateBundle:Speech')->myFindAll($discussion);
            $nbSpeeches = count($speeches);

            $max = $nbSpeeches - $nbSpeechesBeforeLastId;
            $speeches = $em->getRepository('MeritocrateBundle:Speech')->myFindBy($idLastSpeech, $discussion, $max);

            if(count($speeches) > 0){
                $jsonSpeech = json_encode($speeches);
                $response = new Response($jsonSpeech);
                return $response;
            }
            else{
                return new Response('NOR');
            }
        }
    }

    public function addMeritAction(Request $request)
    {
        $merit = new Merits();

        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();

            $idRator = $request->request->get('idRator');
            $idSpeech = $request->request->get('idSpeech');

            $rator = $em->getRepository('MeritocrateBundle:User')->findOneById($idRator);
            $speech = $em->getRepository('MeritocrateBundle:Speech')->findOneById($idSpeech);

            $speech->addMerit($merit);
            $rator->addMerit($merit);

            $merit->setRator($rator);
            $merit->setSpeech($speech);

            $em->persist($merit);
            $em->flush();

            return new Response('ok');
        }
    }
}
