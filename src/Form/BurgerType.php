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
                'attr' => [
                    'class' => 'form-control-f',
                    // 'placeholder' => 'Entrer le nom'
                ],
                'constraints' => [
                    new NotBlank(message:'veillez remplir ce champs')
                ]
            ])
            ->add('prix',NumberType::class,[
                'attr' => [
                    'class' => 'form-control-f',
                    //'placeholder' => 'Entrer le prix'
                ],
                'constraints' => [
                    new NotBlank(message:'veillez remplir ce champs')
                ]
            ])
            ->add('image',FileType::class,[
                'attr'=>[
                    'class'=>'form-control-f border-0'
                ],
                'label'=>false,
                'multiple'=>true,
                'mapped'=>false,
                'required'=>false,
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
