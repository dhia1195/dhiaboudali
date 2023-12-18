<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Domaine;
use App\Repository\UtilisateurRepository;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\core\Security;
use Knp\Component\Pager\PaginatorInterface;


#[Route('/')]
class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'app_utilisateur_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        
        $user = new Utilisateur();
        $user = $this->getUser();
        if($user->getIsVerified()){

            if($user->getIsBlocked()){
                $this->addFlash('danger','Your Account has been Banned ! ');
                return $this->redirectToRoute('app_logout');
            }

    
            $utilisateurs = $entityManager
                ->getRepository(Utilisateur::class)
                ->findAll();

            return $this->render('utilisateur/index.html.twig', [
                'utilisateurs' => $utilisateurs,
            ]);
        }else{
            return $this->redirectToRoute('app_logout');
        }
        
    }

    #[Route('/admin', name: 'app_utilisateur_back', methods: ['GET'])]
    public function back_users(EntityManagerInterface $entityManager): Response
    {
       
            $users = $entityManager
            ->getRepository(Utilisateur::class)
            ->findAll();

            return $this->render('admin/users.html.twig', [
                'users' => $users,
            ]);
        
       
    }
   
    #[Route('/admin/stats', name: 'app_utilisateur_back_stats', methods: ['GET'])]
    public function back_users_stats( UtilisateurRepository $repo, EntityManagerInterface $entityManager): Response
    {
        $doms = $entityManager->getRepository(Domaine::class)
        ->findAll();
        $users = $entityManager->getRepository(Utilisateur::class)->findAll();
        foreach($doms as $dom)
        {
            
            $dom->setId($repo->countDomaine($dom));
        }
        $freelancers = $repo->countFreelancers();
        $bowners = $repo->countBOwners();
        return $this->render('admin/stats.html.twig',[
            'doms' => $doms,
            'freelancers' => $freelancers,
            'bowners' => $bowners,

        ]);
    }

    #[Route('/freelancers', name: 'app_freelancers_index', methods: ['GET'])]
    public function freelancersindex(Request $request, PaginatorInterface $paginator,EntityManagerInterface $entityManager): Response
    {
        $user = new Utilisateur();
        $user = $this->getUser();
        if($user->getIsVerified()){
            if($user->getIsBlocked() == 1){
                $this->addFlash('danger','Your Account has been Banned ! ');
                return $this->redirectToRoute('app_logout');
            }

            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery('SELECT u FROM App\Entity\Utilisateur u WHERE u.role = 3');
            $utilisateurs = $query->getResult();

            $users = $paginator->paginate(
                $utilisateurs,
                $request->query->getInt('page', 1),
                6
            );
            return $this->render('utilisateur/freelancers.html.twig', [
                'utilisateurs' => $users,
            ]);
        }else
        {
            return $this->redirectToRoute('app_logout');
        }
        
        
    }

    #[Route('/utilisateur/profile', name: 'app_utilisateur_profile', methods: ['GET', 'POST'])]
    public function profile(Request $request): Response
    {
        // Fetch the current user object
        $utilisateur = $this->getUser();
        $cv = $utilisateur->getCv();
        //$cv =$doctrine->getRepository(Cv::class)->find($utilisateur->get);
        // If the user is not logged in, redirect them to the login page
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }
    
        // Create the profile form
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {

            // Handle form submission
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
    
            $this->addFlash('success', 'Profil mis à jour avec succès.');
    
            return $this->redirectToRoute('app_utilisateur_profile');
        }
    
        return $this->render('utilisateur/profile.html.twig', [
            'form' => $form->createView(),
            'utilisateur' => $utilisateur,
            'cv'=> $cv,
        ]);
    }


    #[Route('/new', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UtilisateurRepository $repo,EntityManagerInterface $entityManager): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$entityManager->persist($utilisateur);
            //$entityManager->flush();
            //$utilisateur->setRole(2);
            $repo->save($utilisateur,true);
            //return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    

    #[Route('/utilisateur/{id}', name: 'app_utilisateur_show', methods: ['GET'])]
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

   

    #[Route('/utilisateur/{id}/edit', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/utilisateur/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/block/{id}', name: 'app_utilisateur_back_block', methods: ['GET'])]
    public function block_user($id,EntityManagerInterface $entityManager): Response
    {
       
            $users = $entityManager
            ->getRepository(Utilisateur::class)
            ->findAll();

            $user = $entityManager->getRepository(Utilisateur::class)
            ->find($id);
                $user->setIsBlocked(1);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->render('admin/users.html.twig', [
                'users' => $users,
            ]);
        
       
    }

    #[Route('/unblock/{id}', name: 'app_utilisateur_back_unblock', methods: ['GET'])]
    public function unblock_user($id,EntityManagerInterface $entityManager): Response
    {
       
            $users = $entityManager
            ->getRepository(Utilisateur::class)
            ->findAll();

            $user = $entityManager->getRepository(Utilisateur::class)
            ->find($id);
                $user->setIsBlocked(0);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->render('admin/users.html.twig', [
                'users' => $users,
            ]);
        
       
    }
}
