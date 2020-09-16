<?php

namespace App\Controller;

use App\Entity\CategorieProduit;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EnregistrerProduitController extends AbstractController
{
    const ACCES_ERROR_CODE = 403;
    const ERROR_CODE=400;

    /**
     * @Route("/admin/enregistrerProduit", name="enregistrer_produit", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        $roles = $this->getUser()->getRoles();
        for ($i = 0; $i < count($roles); $i++) {
            if ($roles[$i] == "ROLE_ADMIN") {

                if ($content = $request->getContent()) {
                    $json = json_decode($content, true);
                    if (isset($json['nom']) &&
                        isset($json['description']) &&
                        isset($json['prix']) &&
                        isset($json['promo']) &&
                        isset($json['categorie'])
                    ) {
                        $repository = $this->getDoctrine()->getRepository(CategorieProduit::class);
                        $categorie = $repository->findBy(['nom' => $json['categorie']]);
                        $produit = new Produit();
                        $produit->setCategorieProduit($categorie[0]);
                        $produit->setNom($json['nom']);
                        $produit->setDescription($json['description']);
                        $produit->setPrix($json['prix']);
                        $produit->setPromo($json['promo'] == "true");
                        if(isset($_FILES['photo'])){
                            $dossier = '';
                            $fichier=time();
                            $extension = strrchr($_FILES['photo']['name'], '.');
                            $extensionsAcceptees = array('.png', '.gif', '.jpg', '.jpeg');
                            if(!in_array($extension, $extensionsAcceptees)){
                                return new JsonResponse(['Extension non acceptee'], self::ERROR_CODE);
                            }
                            if(!move_uploaded_file($_FILES['photo']['tmp_name'], $dossier . $fichier . $extension)){
                                return new JsonResponse(['Erreur dans la requete'], self::ERROR_CODE);
                            }
                            $produit->setPhoto($fichier . $extension);
                        } else {
                            $produit->setPhoto("/Produits/0000.png");
                        }
                        $entityManager->persist($produit);
                        $entityManager->flush();


                        return new JsonResponse(['reponse' => 'Produit enregistré']);
                    }
                }
            }
        }
        return new JsonResponse(['L\'utilisateur n\'est pas un administrateur'], self::ACCES_ERROR_CODE);

    }
}
