<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Reparation;
use App\Entity\Technicien;
use App\Entity\Vehicule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReparationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('dateReparation')
            ->add('prix')
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => function (Client $client) {
                    $utilisateur = $client->getIdUser();

                    return $utilisateur ? ucfirst($utilisateur->getNom()) . " " . ucfirst($utilisateur->getPrenom()) : 'Unknown Client';
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reparation::class,
        ]);
    }
}
