<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Form\LoginType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\BrowserKit\Response;


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
		$session = $request->getSession();

		if($session->get('user')){
			echo 'You are already logged in.<br>';
			return $this->redirectToRoute('profile');
		}

    	if($request->getMethod() == 'POST'){
    		if($form->isValid()){
    			$email = $form->get('email')->getData();
    			$password = $form->get('password')->getData();

		    	$em = $this->getDoctrine()->getManager();
		    	$p = $em->getRepository('AppBundle:User')->findOneBy(array(
		    		'email' => $email
		    	));

		    	// email exists
		    	if($p){
		    		// account not activated
		    		if($p->getIsActive() == 0){
		    			$this->addFlash('notice', 'Your account has not yet been activated. Please check your email.');
		    		}
		    		// email and pass is correct
		    		else if(hash("sha256",$password) == $p->getPassword()){
		    			echo 'Login successful!';

		    			$session->start();
		    			$session->set('user', $p);

		    			// flash message
		    			$this->addFlash('notice', 'Welcome back, ' . $p->getFirstName() . '!');

		    			return $this->redirectToRoute('profile');
		    		}
		    		// incorrect password
		    		else{
		    			$this->addFlash('notice', 'Incorrect password.');
		    		}
		    	}
		    	// email doesnt exist
		    	else{
		    		$this->addFlash('notice', 'Email not found.');
		    	}
    		}
    	}

        return $this->render('AppBundle:Login:index.html.twig',array(
        	'form' => $form->createView()
        ));
    }
}
