<?php

namespace App\Controller;

use App\Entity\CategorieProduit;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Dotenv\Dotenv;

class EnregistrerProduitController extends AbstractController
{
    const ACCES_ERROR_CODE = 403;
    const ERROR_CODE = 400;

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

                        $produit->setPhoto("/Produits/0000.png");

                    $entityManager->persist($produit);
                    $entityManager->flush();


                    return new JsonResponse(['reponse' => 'Produit enregistré']);

                }
            }
        }
        return new JsonResponse(['L\'utilisateur n\'est pas un administrateur'], self::ACCES_ERROR_CODE);

    }
}
