<?php

namespace App\Form;

use App\Entity\ROLE_ADMINISTRATION;
use App\Entity\Users;
use App\Entity\Opportunity;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class OpportunityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', ChoiceType::class, [
                'choices' => [
                    'Semestre de stage' => 'Semestre de stage',
                    'Double diplôme' => 'Double diplôme',
                ],
                'label' => 'Type d\'opportunité',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control']
            ])
            ->add('university', TextType::class, [
                'label' => 'Université',
                'attr' => ['class' => 'form-control']
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
                'attr' => ['class' => 'form-control']
            ])
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de création',
                'attr' => ['class' => 'form-control']
            ])
            ->add('createdBy', EntityType::class, [
                'class' => Users::class,  
                'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('u')
                ->where('u.roles LIKE :role')  // Utilisation d'une simple recherche par chaîne
                ->setParameter('role', '%ROLE_ADMINISTRATION%')  // Chercher tous les utilisateurs avec le rôle "ROLE_ADMINISTRATION"
                ->orderBy('u.nom', 'ASC');
        },
        'choice_label' => 'nom',
        'placeholder' => 'Sélectionnez un administrateur',
        'label' => 'Créé par l\'administration',
    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Opportunity::class,
        ]);
    }
}