<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\User;
use AppBundle\Form\ChangePassType;

class ChangePasswordController extends Controller
{

    /**
     * @Route("/changepass", name="changepass")
     * @Template()
     */
    public function indexAction()
    {
    	$request = $this->get('request');
    	$session = $request->getSession();
    	$form = $this->createForm(new ChangePassType());
    	$form->handleRequest($request);

    	$user = new User();
    	$user = $session->get('user');

    	if($request->getMethod() == 'POST'){
    		if($form->isValid()){
                if(hash("sha256",$form->get('current_password')->getData()) == $user->getPassword()){
        			$em = $this->getDoctrine()->getManager();
    		    	$p = $em->getRepository('AppBundle:User')->findOneBy(array(
    		    		'id' => $user->getId()
    		    	));

    		    	if($p){
    		    		$p->setPassword(hash("sha256",$form->get('new_pass')->getData()));
    		    		$em->flush();

    		    		$session->set('user', $p);

    		    		$this->addFlash('notice', 'Your password has been changed.');
    		    	}
                }
                else{
                    $this->addFlash('notice', 'Incorrect current password.');
                }
    		}
    	}

        return $this->render('AppBundle:ChangePassword:index.html.twig', array(
            'form' => $form->createView()
        ));    
    }

}
