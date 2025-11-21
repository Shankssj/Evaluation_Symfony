<?php

namespace App\Controller;


use App\Entity\Contact;
use App\Entity\Produits;
use App\Entity\User;
use App\Form\ContactType;
use App\Repository\ProduitsRepository;
use App\Service\MessageMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProduitsRepository $produitsRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'produits' => $produitsRepository->findAll(),
        ]);
    }

    #[Route('/produit/{id}', name: 'app_voir_produit', methods: ['GET'])]
    public function voirProduit(Produits $produit): Response
    {
        return $this->render('home/detail.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/contacter', name: 'app_contact', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function contact(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Contact();
        $form = $this->createForm(ContactType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $message->setUser($user);

            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }


        return $this->render('home/contact.html.twig', [
            'form' => $form,
        ]);
    }

    // #[Route('/produit/{id}/panier', name: 'app_ajout_panier')]
    // public function addToCart(Produits $produit, EntityManagerInterface $em): RedirectResponse
    // {
    //     /** @var \App\Entity\User $user */
    //     $user = $this->getUser();

    //     $user->addProduit($produit);

    //     $em->persist($user);
    //     $em->flush();

    //     $this->addFlash('success', 'Produit ajouté au panier !');

    //     return $this->redirectToRoute('app_show_panier');
    // }

    // #[Route('/panier', name: 'app_show_panier')]
    // public function showPanier(): Response
    // {
    //     /** @var \App\Entity\User $user */
    //     $user = $this->getUser();

    //     $produits = $user->getProduits();

    //     return $this->render('home/panier.html.twig', [
    //         'produits' => $produits,
    //     ]);
    // }

    // #[Route('/panier/supprimer/{id}', name: 'app_panier_supprimer')]
    // public function supprimerPanier(Produits $produit, EntityManagerInterface $entityManager): RedirectResponse
    // {
    //     /** @var \App\Entity\User $user */
    //     $user = $this->getUser();

    //     $user->removeProduit($produit);

    //     $entityManager->persist($user);
    //     $entityManager->flush();

    //     $this->addFlash('success', 'Produit supprimé du panier.');

    //     return $this->redirectToRoute('app_show_panier');
    // }

}
