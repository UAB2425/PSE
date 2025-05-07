<?php

namespace App\Form;

use App\Entity\HighlanderBlogAccount;
use App\Entity\HighlanderBlogArticle;
use App\Entity\HighlanderBlogComment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HighlanderBlogAddCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comment_content')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HighlanderBlogComment::class,
        ]);
    }
}
