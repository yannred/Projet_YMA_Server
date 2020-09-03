<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InscriptionController extends AbstractController
{
    const ERROR_CODE = 400;
    const REQUEST_VALIDATE_CODE = 200;
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/api/inscription", name="inscription", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function EnregistrerUtilisateur(Request $request, EntityManagerInterface $entityManager)
    {
        if ($content = $request->getContent()) {
            $json = json_decode($content, true);
            if (
                isset($json['email']) &&
                isset($json['password']) &&
                isset($json['prenom']) &&
                isset($json['nom']) &&
                isset($json['num']) &&
                isset($json['rue']) &&
                isset($json['cp']) &&
                isset($json['ville']) &&
                isset($json['telephone'])
            ) {
                $utilisateur = new Utilisateur();
                $adresse = new Adresse();
                $adresse->setNum($json['num']);
                $adresse->setRue($json['rue']);
                $adresse->setCp($json['cp']);
                $adresse->setVille($json['ville']);
                $entityManager->persist($adresse);
                $entityManager->flush();

                $utilisateur->setAdresse($adresse);
                $utilisateur->setPrenom($json['prenom']);
                $utilisateur->setNom($json['nom']);
                $utilisateur->setEmail($json['email']);
                $utilisateur->setTelephone($json['telephone']);
                $utilisateur->setRoles(['ROLE_USER']);
                $utilisateur->setPassword($this->passwordEncoder->encodePassword($utilisateur, $json['password']));
                $utilisateur->setNewsletter(false);
                $entityManager->persist($utilisateur);
                $entityManager->flush();

                return new JsonResponse(['reponse' => 'utilisateur enregistre']);
            } else {
                return new JsonResponse(['Erreur dans les donnees de formulaire'], self::ERROR_CODE);
            }

        } else {
            return new JsonResponse(['Erreur dans la requete'], self::ERROR_CODE);
        }

    }
}