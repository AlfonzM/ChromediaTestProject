<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    public function indexAction()
    {
        $secret_code = "aabbccdd123";

    	$person = new User();
    	$form = $this->createForm(new UserType(), $person);

    	$request = $this->get('request');
    	$form->handleRequest($request);

        $session = $request->getSession();
        if($session->get('user')){
            echo 'You are already logged in.<br>';
            return $this->redirectToRoute('profile');
        }

        // if request post
    	if($request->getMethod() == 'POST'){
    		if($form->isValid()){
    			// get data from the form
    			$email = $form->get('email')->getData();
    			$firstName = $form->get('firstName')->getData();
    			$lastName = $form->get('lastName')->getData();
    			$password = $form->get('password')->getData();

    			// set data for $person object
    			$person->setEmail($email);
    			$person->setFirstName($firstName);
    			$person->setLastName($lastName);
    			$person->setPassword(hash("sha256",$password));
    			$person->setIsActive(false);
                $person->setActivation(md5($email.time()));

    			// save to database
    			$em = $this->getDoctrine()->getManager();
    			$em->persist($person);

    			$em->flush();

    			// send verification email
    			$mailer = $this->get('mailer');
			    $message = $mailer->createMessage()
			        ->setSubject('Email verification')
			        ->setFrom('send@example.com')
			        ->setTo($email)
			        ->setBody(
			            $this->renderView(
			                // app/Resources/views/Emails/registration.html.twig
			                'Emails/registration.html.twig',
			                array('name' => $firstName, 'activationcode' => $person->getActivation())
			            ),
			            'text/html'
			        )
			    ;
			    $mailer->send($message);

    			return new Response('Sign up successful!<br>Hello, ' . $firstName . ' ' . $lastName . ' ! A verification email has been sent to ' . $email);
    		}
    		
    		return $this->render('AppBundle:Registration:index.html.twig', array('form'=>$form->createView()));
    	}
        // else return registration form
        else{
    	   return $this->render('AppBundle:Registration:index.html.twig', array('form'=>$form->createView()));
        }
    }

}
