<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class DonneesUtilisateurController extends AbstractController
{
    /**
     * @Route("/profile/donneesUtilisateur", name="donnees_utilisateur",  methods={"GET"})
     * @return JsonResponse
     */
    public function index()
    {
        $utilisateur = $this->getUser();
        
        if ($utilisateur === null || !$utilisateur instanceof Utilisateur){
            throw new Exception("Utilisateur non trouvé");
        }

        $json = [];
        $json['utilisateur']['nom']=$utilisateur->getNom();
        $json['utilisateur']['prenom']=$utilisateur->getPrenom();
        $json['utilisateur']['email']=$utilisateur->getEmail();
        $json['utilisateur']['telephone']=$utilisateur->getTelephone();
        $json['utilisateur']['num_porte']=$utilisateur->getNumPorte();
        $json['utilisateur']['code_entree']=$utilisateur->getCodeEntree();
        $json['utilisateur']['complement']=$utilisateur->getComplement();
        $json['adresse']['num']=$utilisateur->getAdresse()->getNum();
        $json['adresse']['rue']=$utilisateur->getAdresse()->getRue();
        $json['adresse']['ville']=$utilisateur->getAdresse()->getVille();
        $json['adresse']['cp']=$utilisateur->getAdresse()->getCp();

        return new JsonResponse($json);
    }
}
