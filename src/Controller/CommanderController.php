<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\LigneCdeProduit;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Dotenv\Dotenv;

class CommanderController extends AbstractController
{
    const ERROR_CODE = 400;

    /**
     * @Route("/profile/validationPanier", name="validation_panier", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param MailerInterface $mailer
     * @return JsonResponse
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function EnregistrerCommande(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        if ($content = $request->getContent()) {
            $json = json_decode($content, true);
            if (isset($json['idProduit'])) {

                $repository = $this->getDoctrine()->getRepository(Produit::class);
                $prixTotal = 0;
                $tabProduitsDeLaCde = [];
                $listeProduitsHTML = "";

                foreach ($json['idProduit'] as $idProduit){
                    $product = $repository->find($idProduit);
                    array_push($tabProduitsDeLaCde, $product);
                    $prixTotal = $prixTotal + $product->getPrix();
                    $listeProduitsHTML .= $product->getNom() . '<br>';
                }
                $commande = new Commande();
                $commande->setUtilisateur($this->getUser());
                $commande->setEmporter(true);
                $commande->setDateRetrait(new \DateTime());
                $commande->setPrixTotal($prixTotal);
                $entityManager->persist($commande);
                $entityManager->flush();

                $i = 1;
                foreach ($tabProduitsDeLaCde as $produitDeLaCde){
                    $ligneCommande = new LigneCdeProduit();
                    $ligneCommande->setCommande($commande);
                    $ligneCommande->setNumLigne($i);
                    $ligneCommande->setQuantite(1);
                    $ligneCommande->setProduit($produitDeLaCde);
                    $entityManager->persist($ligneCommande);
                    $entityManager->flush();
                    $i++;
                }
            }

            $repo2 = $this->getDoctrine()->getRepository(Utilisateur::class);
            $utilisateur = $repo2->findBy(['email' => $this->getUser()->getUsername()]);
            $email = (new Email())
                ->from('order@bistrot-house.tk')
                ->to($_ENV['MAIL_COMMANDE'])
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Nouvelle Commande')
                ->html(
                    '<p>Vous avez recu une nouvelle commande : ' . $commande->getId() . '</p>' .
                    '<br>' .
                    '<p>Adresse de livraison :</p>' .
                    '<p>' . $utilisateur[0]->getNom() . ' ' . $utilisateur[0]->getPrenom() . '<br>' .
                    $utilisateur[0]->getAdresse()->getNum() . ' ' . $utilisateur[0]->getAdresse()->getRue() . '<br>' .
                    $utilisateur[0]->getAdresse()->getCp() . ' ' . $utilisateur[0]->getAdresse()->getVille() . '<br>' .
                    'Téléphone : ' . $utilisateur[0]->getTelephone() . '</p>' .
                    '<br>' .
                    '<p>Liste des produits commandés</p>' .
                    $listeProduitsHTML.
                    '<br>' .
                    '<p>Prix total : ' . $prixTotal . '€</p>' .
                    '<p>Fin de commande</p>'
                );

            $mailer->send($email);

            return new JsonResponse(['reponse' => 'Commande enregistree']);
        } else {
            return new JsonResponse(['Erreur dans la requete'], self::ERROR_CODE);
        }
    }
}