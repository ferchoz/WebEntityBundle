<?php
namespace Ferchoz\WebEntityBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FieldType extends AbstractType
{
    private $types;

    public function __construct($types){
        $this->types   = $types;
    }

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
                'choices' => $this->types,
                'empty_value' => 'Select one'
            ))
            ->add('length', "number", array(
                'attr' => array(
                    'placeholder' => 'Length of type'
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