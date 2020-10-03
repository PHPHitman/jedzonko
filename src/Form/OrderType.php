<?php

namespace App\Form;

use App\Entity\Orders;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('food', TextType::class,[
                'label' => 'Co zamawiasz?'])
            ->add('quantity', IntegerType::class, [
                'label'=>'Podaj ilość'])
            ->add('company', TextType::class,[
                'label'=>'Podaj nazwę firmy'])
            ->add('cost',IntegerType::class,[
                'label'=>'Należność'
            ])
            ->add('Dodaj', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-info float-right'
                ]])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Orders::class,
        ]);
    }
}
