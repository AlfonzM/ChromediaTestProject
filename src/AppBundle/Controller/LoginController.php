<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Form\LoginType;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function indexAction()
    {
    	$form = $this->createForm(new LoginType());

    	$request = $this->get('request');
    	$form->handleRequest($request);

    	if($request->getMethod() == 'POST'){
    		if($form->isValid()){
    			$email = $form->get('email')->getData();
    			$password = $form->get('password')->getData();

		    	$em = $this->getDoctrine()->getManager();
		    	$p = $em->getRepository('AppBundle:User')->findOneBy(array(
		    		'email' => $email
		    	));

		    	if($p){
		    		if(hash("sha256",$password) == $p->getPassword()){
		    			echo 'Success! ' . $p->getFirstName() . ' ' . $p->getLastName();
		    		}
		    		else{
		    			echo 'Incorrect password';
		    		}
		    	}
		    	else{
		    		echo 'E-mail address not found.';
		    	}

		    	// echo $email . ' ' . $password;

    		}
    	}

        return $this->render('AppBundle:Login:index.html.twig',array(
        	'form' => $form->createView()
        ));
    }
}
