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

    			// echo $email . ' ' . $password;
    		}
    	}

        return $this->render('AppBundle:Login:index.html.twig',array(
        	'form' => $form->createView()
        ));
    }
}
