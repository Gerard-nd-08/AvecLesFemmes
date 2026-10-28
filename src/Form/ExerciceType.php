<?php

namespace App\Form;

use App\Entity\Exercice;
use App\Entity\Groupement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExerciceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', null, [
                'widget' => 'single_text'
            ])
            ->add('dateFin', null, [
                'widget' => 'single_text'
            ])
            ->add('dateLimitePrets', null, [
                'widget' => 'single_text'
            ])
            ->add('dateRetribution', null, [
                'widget' => 'single_text'
            ])
            ->add('statut')
            ->add('groupement', EntityType::class, [
                'class' => Groupement::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercice::class,
        ]);
    }
}
