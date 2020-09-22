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
     * @Route("/api/panier", name="panier", methods={"GET"})
     * @param $request : tableau d'idProduit [322,323,355,355]
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $tabPanier = [];
        $totalPanier = 0;
        if ($idProduitsPanier = $request->query->get('idProduitsPanier')) {
            $idProduitsPanier = urldecode($idProduitsPanier);
            $idProduitsPanier = json_decode($idProduitsPanier, true);
            if (!is_null($idProduitsPanier) && is_array($idProduitsPanier)){
                for ($i=0; $i<count($idProduitsPanier); $i++){
                    $produit = $this->getDoctrine()->getRepository(Produit::class)->find($idProduitsPanier[$i]);
                    if ($produit){
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
