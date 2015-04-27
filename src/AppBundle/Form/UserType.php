<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email');
        $builder->add('firstName', 'text');
        $builder->add('lastName', 'text');
        $builder->add('password', 'repeated', array(
            'first_name' => 'password',
            'second_name' => 'confirm',
            'type' => 'password',
        ));
        $builder->add('submit', 'submit');
    }

    public function getName()
    {
        return 'user';
    }
}

?>