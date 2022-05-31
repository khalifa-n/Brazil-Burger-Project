<?php

namespace App\Form;

use App\Entity\Menu;
use App\Entity\Burger;
use App\Entity\Complement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom',TextType::class,[
            'label' => 'Nom Burger',
            'attr' => [
                'class' => 'input'
            ],
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
        
            ->add('burger',EntityType::class,[
                'class'=>Burger::class
            ])
            ->add('complement',EntityType::class,[
                'class'=>Complement::class,
                'multiple' => true,
                'choice_label' => 'nom',
                'expanded' => true,

            ])
            
            ->add('valider',SubmitType::class)

            ;
            
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
