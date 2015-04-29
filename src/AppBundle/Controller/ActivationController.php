<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\LoginType;

class ActivationController extends Controller
{
    /**
     * @Route("/activation/{code}")
     */
    public function indexAction($code)
    {
    	// $secret = 'aabbccdd123';

    	$em = $this->getDoctrine()->getManager();
    	$p = $em->getRepository('AppBundle:User')->findOneBy(array(
    		'activation' => $code
    	));

    	if($p){
    		if($p->getIsActive() == 0){
    			$this->addFlash('success', 'You have successfully activated your account. Welcome, ' . $p->getFirstName() . '!');
    			$p->setIsActive(true);
    			$em->flush();
    		}
    		else{
    			$this->addFlash('notice', 'Your account is already activated.');
                return $this->redirectToRoute('login');
    		}

            $form = $this->createForm(new LoginType());
            return $this->render('AppBundle:Login:index.html.twig',array(
                'form' => $form->createView()
            ));

    	}
    	else{
    		$this->addFlash('notice', 'Account activation failed.');
    	}

        return $this->render('AppBundle:Activation:index.html.twig');
    }

}
