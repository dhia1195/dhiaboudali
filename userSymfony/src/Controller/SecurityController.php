<?php

namespace App\Controller;
use App\Form\ResetPasswordRequestFormType;
use App\Form\ResetPasswordFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Email;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('app_freelancers_index');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/oubli-pass', name: 'forgotten_password', methods: ['GET', 'POST'])]
public function forgottonPassword(Request $request, UtilisateurRepository $repo
    ,TokenGeneratorInterface $tokenGenerator,
    EntityManagerInterface $em, MailerInterface $mailer): Response
{
    $form = $this->createForm(ResetPasswordRequestFormType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $user = $repo->findOneByLogin($form->get('login')->getData());

        if ($user) {
            $token = $tokenGenerator->generateToken();
            $user->setResetToken($token);
            $em->persist($user);
            $em->flush();

            // generate the password reset link
            $url = $this->generateUrl('reset_pass', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

            $email = (new TemplatedEmail())
                ->from('no_reply@freelanci.tn')
                ->to($user->getEmail())
                ->subject('Réinitialisation de mot de passe')
                ->htmlTemplate('emails/password_reset.html.twig')
                ->context([
                    'url' => $url,
                    'user' => $user,
                ]);

            $mailer->send($email);

            $this->addFlash('success', 'Email envoyé avec succès');
            return $this->redirectToRoute('app_login');
        }

        $this->addFlash('danger', 'Un problème est survenu');
        return $this->redirectToRoute('app_login');
    }

    return $this->render('security/reset_password_request.html.twig', [
        'requestPassForm' => $form->createView(),
    ]);
}

    #[Route(path: '/oubli-pass/{token}', name: 'reset_pass')]
    public function resetPass(Request $request, UtilisateurRepository $repo
    ,TokenGeneratorInterface $tokenGenerator,
    string $token,
    EntityManagerInterface $em, MailerInterface $mailer,
    UserPasswordHasherInterface $passwordHasher ): Response
    {
        $user = $repo->findOneByResetToken($token);
        if($user){
            $form = $this->createForm(ResetPasswordFormType::class);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $user->setResetToken('');
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
                $em->persist($user);
                $em->flush();

                $this->addFlash('succes','Mot de passe changer avec succes');
                return $this->redirectToRoute('app_login');

            }
            return $this->render('security/reset_password.html.twig',[
                'PassForm' => $form->createView()
            ]);
        }
        $this->addFlash('danger','jeton invalide');
        return $this->redirectToRoute('app_login');

    }


}
