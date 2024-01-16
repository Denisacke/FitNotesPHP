<?php

namespace App\Form;

use App\Entity\AuthenticationUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Range;

class AuthenticationUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            ->add('height')
            ->add('weight')
            ->add('age')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => 'Male',
                    'Female' => 'Female',
                ],
                'constraints' => [
                    new Choice([
                        'choices' => ['Male', 'Female'],
                        'message' => 'Choose a valid gender.',
                    ]),
                ],
            ])
            ->add('neck', IntegerType::class, [
                'required' => false,
            ])
            ->add('waist', IntegerType::class, [
                'required' => false,
            ])
            ->add('hip', IntegerType::class, [
                'required' => false,
            ])
            ->add('activityLevel', IntegerType::class, [
                'constraints' => [
                    new Range([
                        'min' => 1,
                        'max' => 5,
                        'minMessage' => 'The activity level must be at least {{ limit }}.',
                        'maxMessage' => 'The activity level cannot be higher than {{ limit }}.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AuthenticationUser::class,
        ]);
    }
}
