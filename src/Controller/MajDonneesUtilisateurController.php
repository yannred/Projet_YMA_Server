<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MajDonneesUtilisateurController extends AbstractController
{
    const ERROR_CODE=400;

    /**
     * @Route("/profile/donneesUtilisateurMaj", name="maj_donnees_utilisateur", methods={"PUT"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        if ($content = $request->getContent()) {
        }
        $json = json_decode($content, true);
        if (
            isset($json['email']) &&
            isset($json['prenom']) &&
            isset($json['nom']) &&
            isset($json['num']) &&
            isset($json['rue']) &&
            isset($json['cp']) &&
            isset($json['ville']) &&
            isset($json['telephone'])
        ) {
            $utilisateur = $this->getUser();

            if ($utilisateur === null || !$utilisateur instanceof Utilisateur) {
                throw new Exception("Utilisateur non trouvé");
            }

            $utilisateur->setEmail($json['email']);
            $utilisateur->setPrenom($json['prenom']);
            $utilisateur->setNom($json['nom']);

            $repository = $this->getDoctrine()->getRepository(Adresse::class);
            $adresse = $repository->find($utilisateur->getAdresse());

            $adresse->setNum($json['num']);
            $adresse->setRue($json['rue']);
            $adresse->setCp($json['cp']);
            $adresse->setVille($json['ville']);

            $utilisateur->setTelephone($json['telephone']);

            $entityManager->persist($utilisateur);
            $entityManager->persist($adresse);
            $entityManager->flush();


            return new JsonResponse(['reponse' => 'utilisateur modifie']);
        }
        else {
            return new JsonResponse(['Erreur dans la requete'], self::ERROR_CODE);
        }
    }
}
