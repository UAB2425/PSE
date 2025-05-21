<?php

namespace App\Form;

use App\Entity\JDVContent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JDVContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titlu'
            ])
            ->add('paragraphOne', TextareaType::class, [
                'label' => 'Primul paragraf',
                'attr' => ['rows' => 5]
            ])
            ->add('paragraphTwo', TextareaType::class, [
                'label' => 'Al doilea paragraf',
                'attr' => ['rows' => 5]
            ])
            ->add('skillsText', TextareaType::class, [
                'label' => 'Lista de abilități (una pe linie)',
                'mapped' => false,
                'attr' => ['rows' => 5]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JDVContent::class,
        ]);
    }
}
