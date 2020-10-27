<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Company;
use App\Entity\Food;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FoodAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Nazwa'
            ])
            ->add('price', IntegerType::class,[
                'label' =>'Podaj cenę'
            ])
            ->add('picture', FileType::class,[
                'mapped' => false
            ])
            ->add('category', EntityType::class,[
                'class' => Category::class
            ])
            ->add('company', EntityType::class,[
                'class' => Company::class,
                'label' =>'Firma'
            ])
            ->add('submit', SubmitType::class,[
                'attr' =>[
                'class' =>'btn btn-primary float-right'
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Food::class,
        ]);
    }
}
