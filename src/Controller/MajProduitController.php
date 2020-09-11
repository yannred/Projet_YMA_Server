<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MajProduitController extends AbstractController
{
    const ERROR_CODE = 400;

    /**
     * @Route("/admin/majProduit", name="maj_produit", methods={"PUT"})
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
                }
                $json = json_decode($content, true);
                if (isset($json['id'])){

                    $repository = $this->getDoctrine()->getRepository(Produit::class);
                    $produit = $repository->find($json['id']);

                    if ($produit) {
                        if (isset($json['nom'])) {
                            $produit->setNom($json['nom']);
                        }
                        if (isset($json['description'])) {
                            $produit->setDescription($json['description']);
                        }
                        if (isset($json['promo'])) {
                            $produit->setPromo($json['promo'] == "true");
                        }
                        if (isset($json['prix'])) {
                            $produit->setPrix($json['prix']);
                        }

                        $entityManager->persist($produit);
                        $entityManager->flush();
                        return new JsonResponse(['reponse' => 'Produit modifie']);
                    }
                }
                return new JsonResponse(['Erreur dans la requete'], self::ERROR_CODE);
            }
        }
    }
}
