<?php

namespace MeritocrateBundle\Controller;

use MeritocrateBundle\Entity\Assembly;
use MeritocrateBundle\Entity\PrivateAssembly;
use MeritocrateBundle\Entity\PrivateChat;
use MeritocrateBundle\Entity\Speech;
use MeritocrateBundle\Entity\User;
use MeritocrateBundle\Entity\Merits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MeritocrateBundle\Entity\Discussion;
use Symfony\Component\ExpressionLanguage\Tests\Node\Obj;
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

            $privacy = $request->request->get('meritocratebundle_discussion')['privacy'];
            $password = $request->request->get('meritocratebundle_discussion')['password'];

            if($privacy == 1){
                $discussion->setPassword($password);
            }

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
            $name = $request->request->get('meritocratebundle_discussion')['name'];
            $ongoing = $request->request->get('meritocratebundle_discussion')['ongoing'];
            $privacy = $request->request->get('meritocratebundle_discussion')['privacy'];
            $password = $request->request->get('meritocratebundle_discussion')['password'];
            $discussion = $em->getRepository('MeritocrateBundle:Discussion')->findOneById($idDiscussion);

            $discussion->setOngoing($ongoing);
            $discussionName = $discussion->getName();
            $discussion->setName($name);

            /* If the user decides to make the group go public */
            if($privacy == 0){
                $discussion->setPassword(NULL);
                $discussion->setPrivacy(false);
            }
            else{
                $discussion->setPassword($password);
                $discussion->setPrivacy(true);
            }

            $em->flush();

            if($ongoing == 0){
                $action = "closed";
            }
            else{
                $action = "opened";
            }

            $response = "The " . $discussionName . " discussion group has been successfully renamed " . $name . " and " .$action;

            $response = new Response($response);
            return $response;
        }

        if(!empty($forms)){
            return $this->render('MeritocrateBundle:Default:user_discussion_settings.html.twig', array(
                'discussionForms' => $forms,
                'discussions' => $discussions
            ));
        }

        else{
            return $this->render('MeritocrateBundle:Default:user_discussion_settings.html.twig');
        }
    }

    public function discussionGroupAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $discussion = $em->getRepository('MeritocrateBundle:Discussion')->findOneById($id);
        $speeches = $em->getRepository('MeritocrateBundle:Speech')->myfindSpeeches($discussion);

        if($discussion->getPrivacy() === true){
            if($request->isMethod('post')) {
                $password = $request->request->get('password');
                if ($password == $discussion->getPassword()) {
                    return $this->render('MeritocrateBundle:Default:show_discussion.html.twig', array(
                        'group' => $discussion,
                        'speeches' => $speeches,
                        'user' => $this->getUser()
                    ));
                }
                else{
                    return $this->render('MeritocrateBundle:Default:verify.html.twig', array(
                        'discussion' => $discussion,
                        'message' => 'Wrong password. Try again'
                    ));
                }
            }
            else{
                return $this->render('MeritocrateBundle:Default:verify.html.twig', array(
                    'discussion' => $discussion
                ));
            }
        }
        else{
            return $this->render('MeritocrateBundle:Default:show_discussion.html.twig', array(
                'group' => $discussion,
                'speeches' => $speeches,
                'user' => $this->getUser()
            ));
        }
    }

    public function groupStatisticsAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $discussion = $em->getRepository('MeritocrateBundle:Discussion')->findOneById($id);
        $speeches = $em->getRepository('MeritocrateBundle:Speech')->myFindAll($discussion);

        if($discussion->getPrivacy() == true) {
            if ($request->isMethod('post')) {
                $password = $password = $request->request->get('password');
                if ($password == $discussion->getPassword()) {
                    /*If any speech exist */
                    if (!empty($speeches)) {
                        /* Go checkout merits linked to each speech of the discussion chosen ($id) */
                        foreach ($speeches as $speech) {
                            $merits[] = $em->getRepository('MeritocrateBundle:Merits')->MyFindMerits($speech);
                        }

                        /* Get the username of the user that has got the merits */
                        foreach ($speeches as $speech) {
                            if (count($speech->getMerits()) != 0) {
                                foreach ($speech->getMerits() as $merit) {
                                    $users[] = $merit->getSpeech()->getUser()->getUsername();
                                }
                            }
                        }

                        /* How many merits per username if any speech ? */
                        if (isset($users) && $users != null) {
                            $statistics = array_count_values($users);

                            return $this->render('MeritocrateBundle:Default:show_group_statistics.html.twig', array(
                                'group' => $discussion,
                                'speeches' => $merits,
                                'statistics' => $statistics
                            ));
                        } else {
                            return $this->render('MeritocrateBundle:Default:show_group_statistics.html.twig', array(
                                'group' => $discussion
                            ));
                        }
                    } else {
                        return $this->render('MeritocrateBundle:Default:show_group_statistics.html.twig', array(
                            'group' => $discussion
                        ));
                    }
                } else {
                    return $this->render('MeritocrateBundle:Default:verify_access_stats.html.twig', array(
                       'discussion' => $discussion
                    ));
                }
            } else {
                return $this->render('MeritocrateBundle:Default:verify_access_stats.html.twig', array(
                    'discussion' => $discussion
                ));
            }
        }
        else{
            if (!empty($speeches)) {
                /* Go checkout merits linked to each speech of the discussion chosen ($id) */
                foreach ($speeches as $speech) {
                    $merits[] = $em->getRepository('MeritocrateBundle:Merits')->MyFindMerits($speech);
                }

                /* Get the username of the user that has got the merits */
                foreach ($speeches as $speech) {
                    if (count($speech->getMerits()) != 0) {
                        foreach ($speech->getMerits() as $merit) {
                            $users[] = $merit->getSpeech()->getUser()->getUsername();
                        }
                    }
                }

                /* How many merits per username if any speech ? */
                if (isset($users) && $users != null) {
                    $statistics = array_count_values($users);

                    return $this->render('MeritocrateBundle:Default:show_group_statistics.html.twig', array(
                        'group' => $discussion,
                        'speeches' => $merits,
                        'statistics' => $statistics
                    ));
                } else {
                    return $this->render('MeritocrateBundle:Default:show_group_statistics.html.twig', array(
                        'group' => $discussion
                    ));
                }
            } else {
                return $this->render('MeritocrateBundle:Default:show_group_statistics.html.twig', array(
                    'group' => $discussion
                ));
            }
        }
    }

    public function joinDiscussionAction(){
        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('MeritocrateBundle:Discussion')->findBy([], array(
            'name' => 'ASC'
        ));

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

    public function groupLivechatAction($id, $identification, Request $request){
        $em = $this->getDoctrine()->getManager();
        $discussion = $em->getRepository('MeritocrateBundle:Discussion')->findOneById($id);
        $assemblies = $em->getRepository('MeritocrateBundle:Assembly')->myFindByDiscussion($discussion, 0);

        if($request->isMethod('post')){
            if($request->request->get('message') || $request->files->get('attachment')){
                $assembly = new Assembly();
                $message = $request->request->get('message');
                $file = $request->files->get('attachment');

                $assembly->setText($message);
                $assembly->setDiscussion($discussion);
                $assembly->setUser($this->getUser());

                if(isset($file) && !empty($file)){
                    $fileName = uniqId() . '.' . $file->guessExtension();
                    $file->move($this->getParameter('image_directory'), $fileName);
                    $assembly->setAttachment($fileName);
                }
                else{
                    $assembly->setAttachment(NULL);
                }

                $em->persist($assembly);
                $em->flush();

                $userAssemblies = $em->getRepository('MeritocrateBundle:Assembly')->myFindBy($this->getUser());
                $userAssembly = $userAssemblies[count($userAssemblies)-1];

                $response = new Response(json_encode($userAssembly));
                $response->headers->set('Content-Type', 'application/json');

                return $response;
            }
            else{
                $password = $request->request->get('password');
                if($password == $discussion->getPassword()){
                    $identification = true;
                }
            }
        }

        if($discussion->getPrivacy() == true){
            if($identification == true){
                $this->getUser()->setDiscussion($discussion);
                $discussion->addUser($this->getUser());
                dump($discussion());
                return $this->render('MeritocrateBundle:Default:show_group_livechat.html.twig', array(
                    'discussion' => $discussion,
                    'assemblies' => $assemblies
                ));
            }
            else
            {
                return $this->render('MeritocrateBundle:Default:verify_access_chat.html.twig', array(
                   'discussion' => $discussion
                ));
            }
        }
        else{
            $this->getUser()->setDiscussion($discussion);
            $discussion->addUser($this->getUser());
            $em->flush();

            return $this->render('MeritocrateBundle:Default:show_group_livechat.html.twig', array(
                'discussion' => $discussion,
                'assemblies' => $assemblies
            ));
        }
    }

    public function getNewMessagesAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest()){

            $idLastMessage = $request->request->get('idLastMessage');
            $idDiscussion = $request->request->get('idDiscussion');
            $assemblies = $em->getRepository('MeritocrateBundle:Assembly')->myFindByDiscussion($idDiscussion, $idLastMessage);

            return new Response(json_encode($assemblies));
        }
    }

    public function privateLiveChatAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        /*$userClicked = $em->getRepository('MeritocrateBundle:User')->findOneById($id);
        $user = $this->getUser();
*/
        $user = $em->getRepository('MeritocrateBundle:User')->findOneById(2);
        $userClicked = $this->getUser();

        /* Looking for an already existing relation */
        /* But who is the creator & who is the classmate */
        $privateChat = $em->getRepository('MeritocrateBundle:PrivateChat')->findOneBy(array(
            'creator' => $this->getUser()->getUsername(),
            'classmate' => $userClicked->getUsername()
        ));

        dump($request);

        if(isset($privateChat) && !empty($privateChat)){
            $password = $privateChat->getToken();
            return $this->RedirectToRoute('meritocrate_private_assembly', array(
                'password' => $password
            ));
        }
        else{
            $privateChat = $em->getRepository('MeritocrateBundle:PrivateChat')->findOneBy(array(
                'creator' => $userClicked->getUsername(),
                'classmate' => $this->getUser()->getUsername()
            ));
            if(isset($privateChat) && !empty($privateChat)){
                $password = $privateChat->getToken();
                return $this->RedirectToRoute('meritocrate_private_assembly', array(
                    'password' => $password
                ));
            }
            else{
                $created = false;
            }
        }

        if($created == false){
            $privateChat = new PrivateChat();
            $privateChat->setCreator($user);
            $privateChat->setClassmate($userClicked);
            $password = md5(uniqId());
            $privateChat->setToken($password);

            $em->persist($privateChat);
            $em->flush();

            return $this->RedirectToRoute('meritocrate_private_assembly', array(
                'password' => $password
            ));
        }
    }

    public function privateAssemblyAction($password, Request $request){
        $em = $this->getDoctrine()->getManager();
        $privateChat = $em->getRepository('MeritocrateBundle:PrivateChat')->findOneByToken($password);

        if($request->isXmlHttpRequest()){
            $privateAssembly = new PrivateAssembly();

            $message = $request->request->get('message');
            $file = $request->files->get('attachment');

            if(isset($file) && !empty($file)){
                $fileName = uniqId() . '.' . $file->guessExtension();
                $file->move($this->getParameter('image_directory'), $fileName);
                $privateAssembly->setAttachment($fileName);
            }
            else{
                $privateAssembly->setAttachment(NULL);
            }

            $this->getUser()->addPrivateassembly($privateAssembly);
            $privateAssembly->setPrivatechat($privateChat);
            $privateAssembly->setUser($this->getUser());
            $privateAssembly->setText($message);
        }

        $privateAssemblies = $em->getRepository('MeritocrateBundle:PrivateAssembly')->myFindBy($privateChat);

        return $this->render('MeritocrateBundle:Default:show_private_livechat.html.twig', array(
            'privateAssemblies' => $privateAssemblies
        ));
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

    public function userSettingsAction(){
        return $this->render('MeritocrateBundle:Default:user_board_settings.html.twig');
    }
}
