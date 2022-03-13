<?php

namespace App\Form;

use App\Entity\Food;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File; 

class FoodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameFood')
            ->add('pictureFood', FileType::class, [
                              
                   'label' => 'Photo',             
                    'mapped' => false,            
                    'required' => false,         
                    'constraints' => [                   
                         new File([                      
                            'maxSize' => '1024k',                    
                            'mimeTypes' => [                     
                                'image/*',                   
                             ],                       
                             'mimeTypesMessage' => 'Veuillez entrer un format de document valide',  

                         ])           
                     ],         
                    ]); 
                }
       

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Food::class,
        ]);
    }
}
