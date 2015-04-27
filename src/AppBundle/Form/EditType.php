<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('email', 'email', array('disabled'=>'true', 'read_only'=>'true'))
        	->add('firstname','text')
        	->add('lastname','text')
        	->add('save','submit')
        	->getForm();
    }

    public function getName()
    {
        return 'edit';
    }
}

?>