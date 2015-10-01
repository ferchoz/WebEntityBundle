<?php
namespace Ferchoz\WebEntityBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Name'
                ),
            ))
            ->add('type', 'choice', array(
                'choices' => array("string"=>"string", "text"=>"text"),
            ))
            ->add('length',"text",array(
                'attr' => array(
                    'placeholder' => 'Length'
                ),
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ferchoz\WebEntityBundle\Entity\Field',
        ));
    }

    public function getName()
    {
        return 'field';
    }
}