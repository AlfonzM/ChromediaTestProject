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
    	$secret = 'aabbccdd123';

    	$email = 'm.alfonz@gmail.com';

    	// $em = $this->getDoctrine()->getRepository('AcmeDemoBundle:Person');
    	$em = $this->getDoctrine()->getManager();
    	$p = $em->getRepository('AppBundle:User')->findOneBy(array(
    		'activation' => $code
    	));

    	if($p){
    		if($p->getIsActive() == 0){
    			echo 'You have successfully activated your account. Welcome, ' . $p->getFirstName() . '!';
    			$p->setIsActive(true);
    			$em->flush();
    		}
    		else{
    			echo 'Your account is already activated.';
    		}

            $form = $this->createForm(new LoginType());
            return $this->render('AppBundle:Login:index.html.twig',array(
                'form' => $form->createView()
            ));

    	}
    	else{
    		echo 'Account activation failed.';
    	}

        return $this->render('AppBundle:Activation:index.html.twig');
    }

}
