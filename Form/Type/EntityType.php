<?php
namespace Ferchoz\WebEntityBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntityType extends AbstractType
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
            ->add('fields', 'collection', array(
                'type'      => new FieldType(),
                'allow_add' => true,
            ))
            ->add('save', 'submit', array(
                'label' => 'Create Entity',
                'attr' => array(
                    'class' => 'btn btn-primary'
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ferchoz\WebEntityBundle\Entity\Entity',
        ));
    }

    public function getName()
    {
        return 'entity';
    }
}