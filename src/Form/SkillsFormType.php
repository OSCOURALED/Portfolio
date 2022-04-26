<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Skills;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SkillsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Titre')
            ->add('DateDebut', DateType::class, [
                'row_attr' => [
                    'class' => 'form-category-create-div'
                ],
                'label'=>'Date de début',
                'widget' => 'single_text',
            ])
            ->add('DateFin', DateType::class, [
                'row_attr' => [
                    'class' => 'form-category-create-div'
                ],
                'label'=>'Date de fin',
                'widget' => 'single_text',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label'=>'Name',
                'placeholder' => 'Choisir une catégorie',
        ])
        ->add('save', SubmitType::class, [
            'row_attr' => [
                'class' => 'btn-category-create-div'
            ],
            'label' => 'Enregistrer',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Skills::class,
        ]);
    }
}
