<?php

namespace App\Controller;

use App\Entity\CategorieProduit;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ContainerParametersHelper;

class EnregistrerProduitController extends AbstractController
{
    const ACCES_ERROR_CODE = 403;
    const ERROR_CODE = 400;

    /**
     * @Route("/admin/enregistrerProduit", name="enregistrer_produit", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ContainerParametersHelper $pathHelpers (permet d'obtenir le repertoire ou est installer l'appli back)
     * @return JsonResponse
     */
    public function index(Request $request, EntityManagerInterface $entityManager, ContainerParametersHelper $pathHelpers)
    {
        $roles = $this->getUser()->getRoles();
        for ($i = 0; $i < count($roles); $i++) {
            if ($roles[$i] == "ROLE_ADMIN") {

                $parametresRequest = [];
                if ($request->request->get('nom') &&
                    $request->request->get('categorie') &&
                    $request->request->get('description') &&
                    $request->request->get('prix') &&
                    $request->request->get('promo'))
                {
                    $parametresRequest['nom'] = (string)$request->request->get('nom');
                    $parametresRequest['categorie'] = (string)$request->request->get('categorie');
                    $parametresRequest['description'] = (string)$request->request->get('description');
                    $parametresRequest['prix'] = (float)$request->request->get('prix');
                    $parametresRequest['promo'] = (string)$request->request->get('promo');
                    $repository = $this->getDoctrine()->getRepository(CategorieProduit::class);
                    $categorie = $repository->findBy(['nom' => $parametresRequest['categorie']]);
                    $produit = new Produit();
                    $produit->setCategorieProduit($categorie[0]);
                    $produit->setNom($parametresRequest['nom']);
                    $produit->setDescription($parametresRequest['description']);
                    $produit->setPrix($parametresRequest['prix']);
                    $produit->setPromo($parametresRequest['promo'] == 'true');
                    if ($request->files->get('file')) {
                        $tmpFilePath = $request->files->get('file')->getPathName();
                        $originalName = $request->files->get('file')->getClientOriginalName();
                        //TODO : Impossible de recuperer le dossier public du projet sans apparement créer une couche de service qu'il faudrait injecter dans ce controller
                        //https://ourcodeworld.com/articles/read/882/how-to-retrieve-the-root-dir-of-the-project-and-other-container-parameters-using-a-service-in-symfony-4
//                        $dossier = $this->get('kernel')->getProjectDir() . '/public/';   // ne focntionne pas
//                        $dossier = "D:\Documents\Dev\Projets HOC\Projet_YMA\Projet_YMA_Server\public\Images\Produits";
                        $dossier = $pathHelpers->getApplicationRootDir() . "/public/Images/Produits";
                        $nomFichier = uniqid();
                        $extensionFichier = strrchr($originalName, '.');
                        $extensionsAcceptees = array('.png', '.gif', '.jpg', '.jpeg');
                        if (!in_array($extensionFichier, $extensionsAcceptees)) {
                            return new JsonResponse(['Extension non acceptee'], self::ERROR_CODE);
                        }
                        if (!move_uploaded_file($tmpFilePath, $dossier . "/" . $nomFichier . $extensionFichier)) {
                            return new JsonResponse(['Erreur liee a l enregistrement du fichier image'], self::ERROR_CODE);
                        }
                        $produit->setPhoto($nomFichier . $extensionFichier);
                    } else {
                        $produit->setPhoto("0000.png");
                    }
                    $entityManager->persist($produit);
                    $entityManager->flush();


                    return new JsonResponse(['reponse' => 'Produit enregistré']);

                }
            }
        }
        return new JsonResponse(['L\'utilisateur n\'est pas un administrateur'], self::ACCES_ERROR_CODE);

    }
}
