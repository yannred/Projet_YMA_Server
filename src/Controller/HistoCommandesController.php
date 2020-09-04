<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\Utilisateur;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

class HistoCommandesController extends AbstractController
{

    const ERROR_CODE=400;

    /**
     * @Route("/profile/histoCommandes", name="histo_commandes")
     * @return JsonResponse
     */
    public function index(CommandeRepository $cdeRepo)
    {
         $utilisateur = $this->getUser();
         if ($utilisateur === null || !$utilisateur instanceof Utilisateur) {
             throw new Exception("Utilisateur non trouvé");
         }

        $cdes = $cdeRepo->findBy(['utilisateur' => $utilisateur]);

        if (!$cdes){
            $json = "Pas de commande";
            return new JsonResponse($json);
        }
        
        $json = [];

        for ($i=0; $i<count($cdes); $i++){
            $cde = [];
            $cde['id'] = $cdes[$i]->getId();
            $cde['emporte'] = $cdes[$i]->getEmporter();
//            $cde['date_retrait'] = $cdes[$i]->getDateRetrait()->format('d/m/y');
            
            if ($cdes[$i]->getDateRetrait() == null){
                $cde['date_retrait'] = null;
            } else {
                $cde['date_retrait'] = $cdes[$i]->getDateRetrait()->format('d-m-Y');
            }
            $cde['prix_total'] = $cdes[$i]->getPrixTotal();
            array_push($json, $cde);
        }

        return new JsonResponse($json);
    }
}
