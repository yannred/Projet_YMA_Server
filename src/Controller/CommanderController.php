<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\LigneCdeProduit;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

class CommanderController extends AbstractController
{
    const ERROR_CODE = 400;

    /**
     * @Route("/profile/validationPanier", name="validation_panier", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function EnregistrerCommande(Request $request, EntityManagerInterface $entityManager)
    {
        if ($content = $request->getContent()) {
            $json = json_decode($content, true);
            if (isset($json['idProduit'])) {
                $repository = $this->getDoctrine()->getRepository(Produit::class);
                $prixTotal = 0;
                $tabProduitsDeLaCde = [];
                foreach ($json['idProduit'] as $idProduit){
                    $product = $repository->find($idProduit);
                    array_push($tabProduitsDeLaCde, $product);
                    $prixTotal = $prixTotal + $product->getPrix();
                }
                $commande = new Commande();
                $commande->setUtilisateur($this->getUser());
                $commande->setEmporter(true);
                $commande->setDateRetrait(new \DateTime());
                $commande->setPrixTotal($prixTotal);
                $entityManager->persist($commande);
                $entityManager->flush();

                $i = 1;
                foreach ($tabProduitsDeLaCde as $produitDeLaCde){
                    $ligneCommande = new LigneCdeProduit();
                    $ligneCommande->setCommande($commande);
                    $ligneCommande->setNumLigne($i);
                    $ligneCommande->setQuantite(1);
                    $ligneCommande->setProduit($produitDeLaCde);
                    $entityManager->persist($ligneCommande);
                    $entityManager->flush();
                    $i++;
                }
            }

            return new JsonResponse(['reponse' => 'Commande enregistree']);
        } else {
            return new JsonResponse(['Erreur dans la requete'], self::ERROR_CODE);
        }
    }
}
