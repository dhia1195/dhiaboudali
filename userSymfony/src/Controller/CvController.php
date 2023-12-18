<?php

namespace App\Controller;

use App\Entity\Cv;
use App\Form\CvType;
use App\Repository\CvRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/cv')]
class CvController extends AbstractController
{
    #[Route('/', name: 'app_cv_index', methods: ['GET'])]
    public function index(CvRepository $cvRepository): Response
    {
        return $this->render('cv/index.html.twig', [
            'cvs' => $cvRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cv_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CvRepository $cvRepository, UtilisateurRepository $repo,SluggerInterface $slugger): Response
    {
        $utilisateur = $this->getUser();
        $cv = new Cv();
        $form = $this->createForm(CvType::class, $cv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /// enregistrer l'image
            $photo = $form->get('img')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        //$_SERVER['DOCUMENT_ROOT'] . '/pi/Profileimages/',
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $cv->setImg($newFilename);
            }
            /// enregistrer le pdf Cv
            $doc= $form->get('pdfCv')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($doc) {
                $originalFilename = pathinfo($doc->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $doc->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $doc->move(
                        //$_SERVER['DOCUMENT_ROOT'] . '/pi/CV/',
                        $this->getParameter('files_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $cv->setPdfCv($newFilename);
            }
            /// enregistrer le cv
            $cvRepository->save($cv, true);
            $utilisateur->setCv($cv);
            $repo->save($utilisateur,true);
            return $this->redirectToRoute('app_utilisateur_profile');
        }

        return $this->renderForm('cv/new.html.twig', [
            'cv' => $cv,
            'form' => $form,
        ]);
    }
    
    #[Route('/monCv', name: 'app_cv_show', methods: ['GET'])]
    public function show(): Response
    {
        $utilisateur = $this->getUser();
        $cv = $utilisateur->getCv();
        
        return $this->render('cv/show.html.twig', [
            'cv' => $cv,
            'utilisateur' => $utilisateur
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_cv_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cv $cv, CvRepository $cvRepository): Response
    {
        
            $form = $this->createForm(CvType::class, $cv);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $cvRepository->save($cv, true);

                return $this->redirectToRoute('app_utilisateur_profile');
            }

            return $this->renderForm('cv/edit.html.twig', [
                'cv' => $cv,
                'form' => $form,
            ]);
        
        
    }

    #[Route('/{id}/delete', name: 'app_cv_delete', methods: ['POST'])]
    public function delete(Request $request, Cv $cv, CvRepository $cvRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cv->getId(), $request->request->get('_token'))) {
            $cvRepository->remove($cv, true);
        }

        return $this->redirectToRoute('app_cv_index', [], Response::HTTP_SEE_OTHER);
    }
}
