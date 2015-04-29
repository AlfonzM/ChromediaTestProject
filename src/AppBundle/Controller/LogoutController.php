<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LogoutController extends Controller
{
    /**
     * @Route("/logout", name="logout")
     * @Template()
     */
    public function logoutAction()
    {
    	$session = $this->get('request')->getSession();
    	$session->set('user', null);

        return $this->render('AppBundle:Logout:logout.html.twig');    
    }

}
