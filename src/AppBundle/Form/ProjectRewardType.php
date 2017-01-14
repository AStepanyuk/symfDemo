<?php

namespace AppBundle\Form;

use AppBundle\Entity\Project;
use AppBundle\Entity\Reward;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectRewardType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('addAt')
            ->add('description')
            ->add('project', EntityType::class, ['class'=>Project::class, 'choice_label'=>'name'])
            ->add('reward', EntityType::class, ['class'=>Reward::class, 'choice_label'=>'name'])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ProjectReward'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_projectreward';
    }


}
