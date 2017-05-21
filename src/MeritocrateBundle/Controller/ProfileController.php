<?php

namespace MeritocrateBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Controller\ProfileController as BaseController;

class ProfileController extends BaseController
{
    /**
     * Edit the user.
     *
     * @param Request $request
     *
     * @return Response
     */

    public function editAction(Request $request)
    {
        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $user = $user;
        $picture = $user->getPicture();

        $form->handleRequest($request);

        if ($request->isXmlHttpRequest()) {
            $userManager = $this->get('fos_user.user_manager');

            $file = $request->files->get('fos_user_profile_form')['picture'];

            if ($file !== null) {
                if ($picture !== null) {
                    $currentFileName = $picture;
                    $path = $this->getParameter('image_directory')."/".$currentFileName;

                    if (file_exists($path)) {
                        unlink($path);
                    }
                }

                $fileName = uniqId().'.'.$file->guessExtension();
                $file->move($this->getParameter('image_directory'), $fileName);
                $user->setPicture($fileName);
            }
            else{
                if($picture == 'avatar.png'){
                    $user->setPicture($picture);
                }
                else{
                    $user->setPicture('avatar.png');
                }
            }

            $userManager->updateUser($user);
            if(isset($fileName)){
                $response = json_encode($fileName);
            }
            else{
                $response = 'Your profile has been updated !';
            }

            return new Response($response);

        }
        return $this->render('@FOSUser/Profile/edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }
}