<?php

namespace App\Form;

use App\Entity\AkmaralSeyidovaAboutMe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AkmaralSeyidovaAboutMeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('skills', TextareaType::class)
            ->add('hobbies', TextareaType::class)
            ->add('github', TextType::class)
            ->add('linkedin', TextType::class)
            ->add('kaggle', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AkmaralSeyidovaAboutMe::class,
        ]);
    }
}
