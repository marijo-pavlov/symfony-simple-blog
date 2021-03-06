<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use BlogBundle\Form\DataTransformer\PostToNumberTransformer;

class CommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityManager = $options['em'];
        $id = $options['id'];

        $transformer = new PostToNumberTransformer($entityManager);

        $builder
            ->add('content', 'textarea', array('label' => 'Leave a comment: '))
            ->add($builder->create('post', 'hidden', array(
                'data' => $id))
                ->addModelTransformer($transformer)
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Comment'
        ))
        ->setRequired(array('em'))
        ->setAllowedTypes('em', 'Doctrine\Common\Persistence\ObjectManager')
        ->setDefined(array('id'));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blogbundle_comment';
    }
}
