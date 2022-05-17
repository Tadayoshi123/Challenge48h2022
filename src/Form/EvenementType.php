<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('ville')
            ->add('date_debut')
            ->add('date_fin')
            ->add('description')
            ->add('image')
            ->add('id_categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom_categorie'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
