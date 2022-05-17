<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\RechercheType;
use App\Repository\EvenementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EvenementController extends AbstractController
{
    #[Route('/evenement', name: 'app_evenement')]
    public function evenement(EvenementRepository $repo, Request $request): Response
    {
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) // si l'utilisateur fait une recherche
        {
            $data = $form->get('recherche')->getData(); //je recupère la saisie de l'utilisateur
            $evenement = $repo->getEvenementsByName($data);
        } else //sinon, pas de recherche = récupération de tous les articles
        {
            $evenement = $repo->findAll();
            // je recupère les articles que je stocke dans un tableau $articles
        }
        return $this->render('evenement/event.html.twig', [
            'evenement' => $evenement,
            'formRecherche' => $form->createView()
        ]);
    }

    #[Route('/evenement/show/{id}', name: 'app_show')]

    public function show(Evenement $evenement)
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement
        ]);
    }

    

}
