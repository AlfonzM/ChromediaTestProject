<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Form\EditType;
use AppBundle\Entity\User;
use AppBundle\Entity\EditUser;

class EditAccountController extends Controller
{
    /**
     * @Route("/editaccount", name="editaccount")
     * @Template()
     */
    public function indexAction()
    {
    	$request = $this->get('request');
    	$user = new User();

    	$session = $request->getSession();
    	$user = $session->get('user');

    	// object used for the edit user form
    	$edituser = new EditUser();
    	$edituser->setEmail($user->getEmail());
    	$edituser->setFirstName($user->getFirstName());
    	$edituser->setLastName($user->getLastName());

    	$form = $this->createForm(new EditType(), $edituser);
    	$form->handleRequest($request);

    	if($request->getMethod() == 'POST'){
    		if($form->isValid()){
		    	$em = $this->getDoctrine()->getManager();
		    	$p = $em->getRepository('AppBundle:User')->findOneBy(array(
		    		'id' => $user->getId()
		    	));

		    	if($p){
		    		$p->setFirstName($form->get('firstname')->getData());
		    		$p->setLastName($form->get('lastname')->getData());
		    		$em->flush();

		    		$session->set('user', $p);

		    		$this->addFlash('notice', 'Your changes have been saved.');
		    	}
    		}
    	}
        
        return $this->render('AppBundle:EditAccount:index.html.twig',array(
        	'form' => $form->createView()
        ));    
    }
}