<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use App\Entity\Domaine;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('nom')
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner ce champ .']),
                    new Length(['min' => 5, 'minMessage' => 'Veuillez avoir au moins {{ limit }} caractères','max' => 30, 'maxMessage' => 'Veuillez avoir au max {{ limit }} caractères']),
                ],
            ])
            ->add('numtel', NumberType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir votre numero de telphone correctement .']),
                    new Length(['min' => 8, 'minMessage' => 'Veuillez avoir au moins {{ limit }} caractères','max' => 8, 'maxMessage' => 'Veuillez avoir au max {{ limit }} caractères']),
                ],
            ])
            ->add('adresse')
            
            ->add('Enregistrer', SubmitType::class)
        ;
    }
    /*public function getDomains(DomaineRepository $repo): Collection 
    {
        $domains = $repo->findAll();
        return $domains;
    } */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
