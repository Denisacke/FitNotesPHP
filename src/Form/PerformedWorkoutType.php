<?php

namespace App\Form;

use App\Entity\DTO\PerformedWorkoutDTO;
use App\Entity\PerformedWorkout;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PerformedWorkoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('performedDate', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('exercises', CollectionType::class, [
                'entry_type' => PerformedExerciseType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PerformedWorkoutDTO::class,
        ]);
    }
}