<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Utilisateur;
use App\Entity\Domaine;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Symfony\Component\Mime\Email;
use App\Service\EmailVerifier;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\MailerService;
class RegistrationController extends AbstractController
{
    private $doctrine;
    private EmailVerifier $emailVerifier;
    private $verifyEmailHelper;
    private $mailer;

    public function __construct(ManagerRegistry $doctrine,EmailVerifier $emailVerifier, VerifyEmailHelperInterface $helper, MailerInterface $mailer)
    {
        $this->doctrine = $doctrine;
        $this->emailVerifier = $emailVerifier;
        $this->verifyEmailHelper = $helper;
        $this->mailer = $mailer;
    }


    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager
    , MailerService $mailerService, TokenGeneratorInterface $tokenGeneratorInterface): Response
    {
        $user = new Utilisateur();
        
        $form = $this->createForm(RegistrationFormType::class, $user);
        /*$domaineRepository = $this->doctrine->getRepository(Domaine::class);
        $dom = $domaineRepository->find($form->get('domaine')->getData());
        $user->setDomaine($dom);
        */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Token 
            //$tokenReg = $tokenGeneratorInterface->generateToken();
            
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            // user token 
            //$user->setTokenRegistration($tokenReg);
            
            //Mailer Send
            $signatureComponents = $this->verifyEmailHelper->generateSignature(
                'app_verify_email',
                '$user->getId()',
                $user->getEmail()
            );
            $email = new TemplatedEmail();
            $email->subject('Veuillez confirmer votre email');
            $email->from('freelanci@gmail.com');
            $email->to($user->getEmail());
            $email->htmlTemplate('mails/confirmation_email.html.twig');
            $email->context(['signedUrl' => $signatureComponents->getSignedUrl(),
             
                'nom' => $user->getNom(),
                ]);
            //$email->context(['nom' => $user->getNom()]);
            $this->mailer->send($email); 
            /*$mailerService->send(
                $user->getEmail(),
                'Confirmation de compte',
                'registration_confirmation.html.twig',
                [
                    'user' => $user,
                    'token' => $tokenReg,
                    'lifeTimeToken' => $user->getTokenRegistrationLifeTime()->format('d-m-Y-H-i-S')
                ]

            );*/
            $roles = [];
            $roles[] = 'ROLE_USER';
            $user->setRoles($roles);
            $entityManager->persist($user);
            $entityManager->flush();
            
            // do anything else you need here, like send an email
            $this->addFlash('succes','Votre compte a bien été creé , veuiller vérifier vos e-mails pour l\'activer . ');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    #[Route('/verify/email', name: 'app_verify_email', methods: ['GET', 'POST'])]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        //dump($id);
        /*$user = $joueurRepository->find($id);
        if (null === $id) {
            return $this->redirectToRoute('app_index');
        }
        if (null === $user) {
            return $this->redirectToRoute('app_index');
        }*/
        /*try {
            $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());
        } catch (VerifyEmailExceptionInterface $e) {
            $this->addFlash('verify_email_error', $e->getReason());

            return $this->redirectToRoute('app_index');
        }*/
        $user->setIsVerified(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        // Mark your user as verified. e.g. switch a User::verified property to true

        //$this->addFlash('success', 'Your e-mail address has been verified.');

        return $this->redirectToRoute('app_login');
        
    }

    /*#[Route('/verify/{token}/{id<\d+>?}', name: 'account_verify', methods: ['GET'])]
    public function verify(string $token, Utilisateur $user, EntityManagerInterface $em): Response
    {

        if ($user->getTokenRegistration() !== $token) {
            throw new AccessDeniedException();
        }

        if ($user->getTokenRegistration() === null) {
            throw new AccessDeniedException();
        }

        if (new DateTime('now') > $user->getTokenRegistrationLifeTime()) {
            throw new AccessDeniedException();
        }

        $user->setIsVerified(true);
        $user->setTokenRegistration(null);
        $em->flush();

        $this->addFlash('success', 'Votre compte a bien été activé, vous pouvez maintenant vous connecter.');

        return $this->redirectToRoute('app_login');
    }*/
}
