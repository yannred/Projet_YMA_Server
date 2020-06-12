<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/api/panier", name="panier", methods={"POST"})
     * @param $request : tableau d'idProduit [322,323,355,355]
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        //TODO YC Question LUCAS : Y avait-il un moyen de faire plus simple avec API Plateforme ?
        $tabPanier = [];
        $totalPanier = 0;
        if ($panier = $request->getContent()) {
            $panier = json_decode($panier, true);
            if (!is_null($panier) && is_array($panier)){
                for ($i=0; $i<count($panier); $i++){
                    $produit = $this->getDoctrine() //TODO YC Question LUCAS : Pourquoi je peux pas faire un : $produit = new Produit; $produit->find()
                        ->getRepository(Produit::class)
                        ->find($panier[$i]);
                    if ($produit){
                        //TODO YC Question LUCAS : Pourquoi je ne peux pas utiliser le getCategorieProduit dans la ligne suivante ? me renvoie un objet de rien
//                        array_push($tabPanier, [$produit->getId(), $produit->getCategorieProduit(), $produit->getNom(), $produit->getPhoto(), $produit->getPrix()]);
                        array_push($tabPanier, ["id" => $produit->getId(), "nom" => $produit->getNom(), "photo" => $produit->getPhoto(), "prix" => $produit->getPrix()]);
                        $totalPanier = $totalPanier + (float)$produit->getPrix();
                    }
                }
            }
        }
        $json = [];
        array_push($json, ['panier' => $tabPanier]);
        array_push($json, ['totalPanier' => $totalPanier]);
        return new JsonResponse($json);
    }
}
