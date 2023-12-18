<?php

namespace App\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Domaine;
use App\Repository\DomaineRepository;

class RegistrationFormType extends AbstractType
{
    
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $domaineRepository = $this->doctrine->getRepository(Domaine::class);
        $domains = $domaineRepository->findAll();
        $domaineChoices = [];

        foreach ($domains as $domain) {
            $domaineChoices[$domain->getNom()] = $domain->getId();
        }
        $builder
            ->add('login')
            ->add('email', EmailType::class)
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner ce champ .']),
                    new Length(['min' => 4, 'minMessage' => 'Veuillez avoir au moins {{ limit }} caractères','max' => 20, 'maxMessage' => 'Veuillez avoir au max {{ limit }} caractères']),
                ],
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner ce champ .']),
                    new Length(['min' => 4, 'minMessage' => 'Veuillez avoir au moins {{ limit }} caractères','max' => 20, 'maxMessage' => 'Veuillez avoir au max {{ limit }} caractères']),
                ],
            ])
            ->add('adresse', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner ce champ .']),
                    new Length(['min' => 4, 'minMessage' => 'Veuillez avoir au moins {{ limit }} caractères','max' => 40, 'maxMessage' => 'Veuillez avoir au max {{ limit }} caractères']),
                ],
            ])
            ->add('numtel', NumberType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir votre numero de telphone correctement .']),
                    new Length(['min' => 8, 'minMessage' => 'Veuillez avoir au moins {{ limit }} caractères','max' => 8, 'maxMessage' => 'Veuillez avoir au max {{ limit }} caractères']),
                ],
            ])
            ->add('domaine', EntityType::class, [
                'class' => Domaine::class,
                'choice_label' => 'nom',


                ])
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'Freelancer' => 3,
                    'Business Owner' => 2,
                ],
                

                ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
