<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\PasswordResetToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ForgotPasswordController extends Controller
{
    /**
     * @Route("/forgot", name="forgot")
     * @Template()
     */
    public function indexAction()
    {
    	$form = $this->createFormBuilder()
    		->add('email', 'email')
    		->add('submit', 'submit')
    		->getForm();

    	$request = $this->get('request');
    	$form->handleRequest($request);

    	if($request->getMethod() == 'POST'){
    		if($form->isValid()){
    			$email = $form->get('email')->getData();

    			$em = $this->getDoctrine()->getManager();
    			$p = $em->getRepository('AppBundle:User')->findOneBy(array(
    				'email' => $email
    			));

    			if($p){
    				$token = new PasswordResetToken();
    				$token->setToken(md5(uniqid('', true)));
    				$token->setCreatedAt(new \DateTime());
    				$token->setUserId($p->getId());

    				$en_mgr = $this->getDoctrine()->getManager();
    				$en_mgr->persist($token);

    				$en_mgr->flush();

	    			// send verification email
	    			$mailer = $this->get('mailer');
				    $message = $mailer->createMessage()
				        ->setSubject('Reset password')
				        ->setFrom('send@example.com')
				        ->setTo($p->getEmail())
				        ->setBody(
				            $this->renderView(
				                'Emails/resetpassword.html.twig',
				                array(
				                	'name' => $p->getFirstName(),
				                	'token' => $token->getToken()
				                )),
					            'text/html'
				        )
				    ;
				    $mailer->send($message);

    				$this->addFlash('success', 'A reset password link has been sent to your e-mail address!');
    			}
    			else{
    				$this->addFlash('notice', 'Email not found! Please try again.');
    			}
    		}
    	}

        return $this->render('AppBundle:ForgotPassword:index.html.twig', array(
        	'form' => $form->createView()
        ));    
    }

}
