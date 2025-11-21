<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeProduit;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(SessionInterface $session, ProduitsRepository $produitRepository): Response
    {
        $panier = $session->get('panier', []);

        $panierWithData = [];


        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'produit' => $produitRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($panierWithData as $item) {
            $totalItem = $item['produit']->getPrixProduit() * $item['quantity'];
            $total += $totalItem;
        }



        return $this->render('cart/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total
        ]);
    }

    #[Route('/panier/add/{id}', name: 'app_add_panier')]
    public function add(SessionInterface $session, $id): Response
    {
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }


    #[Route('/panier/remove/{id}', name: 'app_remove_panier')]
    public function remove(SessionInterface $session, $id): Response
    {
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/valider', name: 'app_panier_validate')]
    public function validate(SessionInterface $session,ProduitsRepository $produitRepository,EntityManagerInterface $em): Response {

        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour valider votre panier.');
            return $this->redirectToRoute('app_login');
        }

        $panier = $session->get('panier', []);
        if (empty($panier)) {
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('app_panier'); 
        }

        $commande = new Commande();
        $commande->setUser($user);
        $commande->setCreatedAt(new \DateTimeImmutable());

        $total = 0;

        foreach ($panier as $id => $quantity) {
            $produit = $produitRepository->find($id);

            if (!$produit) {
                continue;
            }

            $commandeProduit = new CommandeProduit();
            $commandeProduit->setCommande($commande);
            $commandeProduit->setProduit($produit);
            $commandeProduit->setQuantity($quantity);
            $commandeProduit->setPrice($produit->getPrixProduit());

            $em->persist($commandeProduit);

            $total += $produit->getPrixProduit() * $quantity;
        }

        $commande->setTotal($total);
        $em->persist($commande);
        $em->flush();

        $session->remove('panier');

        $this->addFlash('success', 'Votre commande a bien été validée !');
        return $this->redirectToRoute('app_home');
    }
}
