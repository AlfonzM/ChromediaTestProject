<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $builder->add('email', 'email')->add('password','password')->getForm();
        $builder->add('email', 'email')->add('password','password')->add('submit','submit', array('label'=>'Sign in'))->getForm();
    }

    public function getName()
    {
        return 'login';
    }
}

?>