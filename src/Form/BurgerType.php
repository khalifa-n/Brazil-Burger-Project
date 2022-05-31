<?php

namespace App\Form;

use App\Entity\Burger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;

class BurgerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => 'Nom Burger',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrer le nom'
                ],
                'constraints' => [
                    new NotBlank(message:'veillez remplir ce champs')
                ]
            ])
            ->add('prix',NumberType::class,[
                'label' => 'Prix Burger',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrer le prix'
                ],
                'constraints' => [
                    new NotBlank(message:'veillez remplir ce champs')
                ]
            ])
            ->add('image',FileType::class,[
                'attr'=>[
                    'class'=>'mt-4'
                ],
                'label'=>false,
                'multiple'=>true,
                'mapped'=>false,
                'required'=>false,
            ])
            



            ->add('valider',SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-primary float-end',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Burger::class,
            'required' => false,
        ]);
    }
}
