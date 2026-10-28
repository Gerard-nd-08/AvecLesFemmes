<?php

namespace App\Form;

use App\Entity\Campagne;
use App\Entity\Groupement;
use App\Entity\ModeCotisation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampagneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('montant')
            ->add('type')
            ->add('modeCotisation', EntityType::class, [
                'class' => ModeCotisation::class,
                'choice_label' => 'id',
            ])
            ->add('groupement', EntityType::class, [
                'class' => Groupement::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Campagne::class,
        ]);
    }
}
