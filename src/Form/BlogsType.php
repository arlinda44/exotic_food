<?php

namespace App\Form;

use App\Entity\Blogs;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('introduction')
            ->add('description')
            ->add('dateCreate')
            ->add('picture')
            ->add('category', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'nameCategory',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blogs::class,
        ]);
    }
}
