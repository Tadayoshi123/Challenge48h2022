<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Form\RechercheType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/create', name: 'app_create')]
    #[Route('/edit/{id}', name: 'app_edit')]

    public function create(Request $request, EntityManagerInterface $manager, Evenement $evenement = null)
    {
        // evenement = null signifie que si l'on va sur la route ne alors $article = null
        // et si on est sur edit, alors l'article correspondra à l'id dans la route

        // la classe Request contient toutes les données des superglobales
        if (!$evenement) {
            $utilisateur = $this->getUser();
            $evenement = new Evenement;
            $evenement->getIdUtilisateur($utilisateur);
        }
        // je créer un objet Article vide prêt à être rempli
        // dans la classe Request, l'objet request contient les données de $_POST
        //l'objet query contient les données de $_GET


        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        // handleRequest() permet de faire certaines vérifications (la méthode du formulaire ?)
        // permet aussi de vérifier si les champs sont remplis
        dump($form);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($evenement);
            $manager->flush();
            return $this->redirectToRoute('app_show', [
                'id' => $evenement->getId()
            ]);
            // après insertion de l'article, je me redirige vers la route blog_show
            // cette route a besoin du paramètre "id" : l'id de l'article que je viens d'insérer
        }
        return $this->render('evenement/create.html.twig', [
            'formEvenement' => $form->createView(),
            // createView() renvoie un objet permettant d'afficher le formulaire
            'editMode' => $evenement->getId() !== null
            // editMode = 1 si on est en édition
            // editMode = 0 si on est en création
        ]);
    }
}
