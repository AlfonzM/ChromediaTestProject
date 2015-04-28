<?php

namespace AppBundle\Form;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('current_password', 'password');
        $builder->add('new_pass', 'repeated', array(
            'first_name' => 'new_password',
            'second_name' => 'confirm_new_password',
            'type' => 'password',
            'constraints' => array(
                new NotBlank(),
                new Length(array('min'=>6))
            )
        ));
        $builder->add('submit', 'submit');
    }

    public function getName()
    {
        return 'changepass';
    }
}

?>