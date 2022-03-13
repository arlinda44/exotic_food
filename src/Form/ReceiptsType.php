<?php

namespace App\Form;

use App\Entity\Food;
use App\Entity\Receipts;
use App\Entity\TypesReceipts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ReceiptsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameRecipe')
            ->add('country')
            ->add('vegetarian')
            ->add('content')
            ->add('preparationTime')
            ->add('cookingTime')
            ->add('pictureReceipts', FileType::class, [
                'label' => 'Photo',
                'mapped' => false,
                'required' => false,
                'constraints' =>
                [new File([
                    'maxSize' => '1024k',
                    'mimeTypes' =>
                    ['image/*',],
                    'mimeTypesMessage' => 'Veuillez entrer un format de document valide',
                ])],
            ])
            ->add('type_recipe', EntityType::class, [
                'class' => TypesReceipts::class,
                'choice_label' => 'nametypeRecipe',
            ])

            ->add('food', EntityType::class, [
                'class' => Food::class,
                'multiple' => true,
                'choice_label' => 'nameFood',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Receipts::class,
        ]);
    }
}
