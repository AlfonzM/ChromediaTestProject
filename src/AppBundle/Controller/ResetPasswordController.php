<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Form\ResetPassType;

class ResetPasswordController extends Controller
{
    /**
     * @Route("/reset/{code}")
     * @Template()
     */
    public function indexAction($code)
    {	
    	$request = $this->get('request');

    	$em = $this->getDoctrine()->getManager();
    	$token = $em->getRepository('AppBundle:PasswordResetToken')->findOneBy(array('token' => $code));

		$form = $this->createForm(new ResetPassType());	
		$form->handleRequest($request);

		if($request->getMethod() == 'POST'){
			if($form->isValid()){
				// get user
    			$p = $em->getRepository('AppBundle:User')->findOneBy(array(
    				'id' => $token->getUserId()
    			));

    			// set user's pass to new pass
    			$p->setPassword(hash("sha256",$form->get('new_pass')->getData()));

    			$em->remove($token);
    			$em->flush();

    			$this->addFlash('success', 'Reset password successful!');
				return $this->redirectToRoute('login');
			}
			else{
	    		$this->addFlash('error', 'Invalid input. Please try again.');
			}

			return $this->render('AppBundle:ResetPassword:index.html.twig',array(
				'form' => $form->createView()
			));
		}
		else {
			if($token){
	    		$i = date_diff(new \DateTime(),$token->getCreatedAt());
	    		$days_diff = $i->format('%a');

	    		if($days_diff >= 1){
	    			$this->addFlash('error', 'The reset password token is expired.');
	    		}
	    		else{
					return $this->render('AppBundle:ResetPassword:index.html.twig',array(
						'form' => $form->createView()
					));
	    		}
	    	}
	    	else{
	    		$this->addFlash('error', 'Invalid token.');
	    	}
		}
        
    }

}
