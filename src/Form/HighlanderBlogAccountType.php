<?php

namespace App\Form;

use App\Entity\HighlanderBlogAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HighlanderBlogAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('account_username')
            ->add('account_password', PasswordType::class)
            ->add('account_repassword', PasswordType::class, ['mapped' => false])
            ->add('account_email')
            ->add('register', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HighlanderBlogAccount::class,
        ]);
    }
}
