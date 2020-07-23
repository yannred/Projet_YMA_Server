<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use App\Entity\CategorieIngredient;
use App\Entity\CategorieProduit;
use App\Entity\Ingredient;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    const PHOTO = 'https://picsum.photos/200';

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        //************************************************************************************************************
        //************************************************ Adresse ***************************************
        //************************************************************************************************************
        $tabAdresse = array();

        array_push($tabAdresse,
            array('4', 'Rue Ravier', 'Lyon', '69007')
        );
        $tabObjetAdresse = array();
        for ($i=0; $i < count($tabAdresse); $i++){
        $tabObjetAdresse[$i] = new Adresse();
        $tabObjetAdresse[$i]->setNum($tabAdresse[$i][0]);
        $tabObjetAdresse[$i]->setRue($tabAdresse[$i][1]);
        $tabObjetAdresse[$i]->setVille($tabAdresse[$i][2]);
        $tabObjetAdresse[$i]->setCp($tabAdresse[$i][3]);

        $manager->persist($tabObjetAdresse[$i]);
    }
        $manager->flush();


        //************************************************************************************************************
        //************************************************ User ***************************************
        //************************************************************************************************************
        $tabUser = array();

        $ROLE_USER[]= 'ROLE_USER';
        array_push($tabUser,
            array('user4auth', $ROLE_USER, '%!password4auth!%', 'user4auth', 'user4auth', 'telephone', 'numéro de porte', 'code entrée', 'complement', true,)
        );
        $tabObjetUser = array();
        for ($i=0; $i < count($tabUser); $i++){
            $tabObjetUser[$i] = new Utilisateur();
            $tabObjetUser[$i]->setEmail($tabUser[$i][0]);
            $tabObjetUser[$i]->setRoles($tabUser[$i][1]);
            $tabObjetUser[$i]->setPassword($this->passwordEncoder->encodePassword($tabObjetUser[$i],$tabUser[$i][2]));
            $tabObjetUser[$i]->setNom($tabUser[$i][3]);
            $tabObjetUser[$i]->setPrenom($tabUser[$i][4]);
            $tabObjetUser[$i]->setTelephone($tabUser[$i][5]);
            $tabObjetUser[$i]->setNumPorte($tabUser[$i][6]);
            $tabObjetUser[$i]->setCodeEntree($tabUser[$i][7]);
            $tabObjetUser[$i]->setComplement($tabUser[$i][8]);
            $tabObjetUser[$i]->setNewsletter($tabUser[$i][9]);

            $tabObjetUser[$i]->setAdresse($tabObjetAdresse[0]);

            $manager->persist($tabObjetUser[$i]);
        }
        $manager->flush();

        //************************************************************************************************************
        //************************************************ CategorieProduit ***************************************
        //************************************************************************************************************
        $tabCategorieProduit = array();
        array_push($tabCategorieProduit,
    'Pizza',
        'Burger',
        'Tapas',
        'Accompagnement menu',
        'Boisson',
        'Dessert',
        'Sauce'
        );
        $tabObjetCategorieProduit = array();
        for ($i=0; $i < count($tabCategorieProduit); $i++){
            $tabObjetCategorieProduit[$i] = new CategorieProduit();
            $tabObjetCategorieProduit[$i]->setNom($tabCategorieProduit[$i]);
            $manager->persist($tabObjetCategorieProduit[$i]);
        }
        $manager->flush();


        //************************************************************************************************************
        //************************************************ Produit ************************************************
        //************************************************************************************************************

        $tabProduit = array();
        array_push($tabProduit,
            array('MARGUERITA', 'Sauce tomate ou Crème fraîche, mozzarella, olives.', 8.9, "/Produits/0001.jpg", false, 'Pizza'),
            array('REGINA', 'Sauce tomate ou Crème fraîche, mozzarella, jambon, champignons frais.', 9.9, "/Produits/0001.jpg", true, 'Pizza'),
            array('TONNATA', 'Sauce tomate ou Crème fraîche, mozzarella, thon, olives.', 9.9, "/Produits/0001.jpg", true, 'Pizza'),
            array('ORIENTALE', 'Sauce tomate cuisiner maison ou Crème fraîche, mozzarella, merguez fraiche preparer maison et precuite a la braise, poivrons, oignons rouges.', 9.9, "/Produits/0001.jpg", false, 'Pizza'),
            array('CAMPIONE', 'Sauce tomate cuisiner maison ou Crème fraîche, mozzarella, viande hachée cuite a la braise ,olives vertes oeuf.', 9.9, "/Produits/0001.jpg", false, 'Pizza'),
            array('BUFFALO', 'Sauce tomate cuisiner maison ou Crème fraîche, mozzarella, viande hachée cuite a la braise, oignons rouges, olives.', 9.9, "/Produits/0001.jpg", false, 'Pizza'),
            array('MEDITERRANEENNE', 'Sauce tomate cuisiner maison ou Crème fraîche, mozzarella, fruits de mer, beurre persillé.', 9.9, "/Produits/0001.jpg", false, 'Pizza'),
            array('4 FROMAGES', 'Sauce tomate ou Crème fraîche, mozzarella, emmental, chèvre, roquefort.', 9.9, "/Produits/0001.jpg", false, 'Pizza'),
            array('CHEF', 'Sauce tomate ou Crème fraîche, mozzarella, viande hachée et merguez, poivrons et oignons rouges frais.', 9.9, "/Produits/0001.jpg", true, 'Pizza'),
            array('ALL STAR', 'Sauce tomate cuisinée maison ou Crème fraîche, mozzarella, poulet fumé en charcuterie, oignons rouges, poivrons frais, oeuf.', 11.9, "/Produits/0001.jpg", false, 'Pizza'),

            array('CHEESE', 'Pain brioche, Steak 45g pure boeuf cuit au barbecue, cheddar, cornichons, ketchup, moutarde.', 4.9, "/Produits/0002.jpg", false, 'Burger'),
            array('FLY FISH', 'Pain au sésame, poisson pané, cheddar, salade, tomates, oignons, sauce fish.', 4.9, "/Produits/0002.jpg", false, 'Burger'),
            array('CHICKEN', 'Pain au sésame, poulet pané, cheddar, salade, tomates, oignons, sauce tartare.', 5.9, "/Produits/0002.jpg", false, 'Burger'),
            array('TAHITIEN BURGER', 'Pain au sésame, steak 100g pure boeuf cuit au barbecue, tranche d\'ananas, salade, tomates, oignons sauce barbecue.', 5.9, "/Produits/0002.jpg", false, 'Burger'),
            array('SEGUIN', 'Steak 100g, tomates, rondelles de chèvre.', 5.9, "/Produits/0002.jpg", false, 'Burger'),
            array('BRAZIL', 'Pain au sésame, steak 100g pure boeuf cuit au barbecue, tranche de jambon, cheddar, salade, tomates, oignons.', 5.9, "/Produits/0002.jpg", false, 'Burger'),
            array('GREC', 'Pain au sésame, steak 100g pure boeuf et émincés kebab cuit au barbecue , salade, tomates, oignons.', 6.1, "/Produits/0002.jpg", true, 'Burger'),
            array('MYSTIC', 'Pain fariné cuit à la pierre, steak 180g pure boeuf cuit au barbecue, chekchouka (légumes grille au four légèrement épicée ) salade, sauce gruyère maison.', 5.9, "/Produits/0002.jpg", true, 'Burger'),
            array('SAVOYARD', 'pain fariné cuit a la pierre Steak 180g pure boeuf cuit au barbecue ,sauce gruyère maison ,salade ,tomate ,oignons rouges ,tranche de jambon, oeuf ,fromage raclette.', 6.9, "/Produits/0002.jpg", false, 'Burger'),
            array('BUFFALO', 'Steak 45g pure boeuf et escalope de poulet mariné cuit au barbecue, sauce buffalo, salade, tomates, oignons, cornichons, double cheddar.', 6.9, "/Produits/0002.jpg", false, 'Burger'),

            array('Nuggets x4', '4 délicieux pollos', 3.5, self::PHOTO, false, 'Tapas'),
            array('Nuggets x6', '6 délicieux pollos', 5.5, self::PHOTO, false, 'Tapas'),
            array('Nuggets x8', '8 délicieux pollos', 7, self::PHOTO, true, 'Tapas'),
            array('Frites', 'Frites légères et croustillantes', 3.5, self::PHOTO, false, 'Tapas'),
            array('Potatoes', 'Potatoes savoureuses', 3.5, self::PHOTO, false, 'Tapas'),

            array('Frites', 'Frites légères et croustillantes', 3.5, self::PHOTO, false, 'Accompagnement menu'),
            array('Potatoes', 'Potatoes savoureuses', 3.5, self::PHOTO, false, 'Accompagnement menu'),

            array('Ketchup', '20cl', 1, self::PHOTO, false, 'Sauce'),
            array('Mayonnaise', '20cl', 1, self::PHOTO, false, 'Sauce'),
            array('Barbecue', '20cl', 1, self::PHOTO, false, 'Sauce'),
            array('Moutarde', '20cl', 1, self::PHOTO, false, 'Sauce'),
            array('Béarnaise', '20cl', 1, self::PHOTO, false, 'Sauce'),

            array('Coca-Cola Coke', '33cl', 2.5, "/Produits/0003.png", false, 'Boisson'),
            array('Orangina', '33cl', 2.5, "/Produits/0004.png", false, 'Boisson'),
            array('Sprite', '33cl', 2.5, "/Produits/0005.png", false, 'Boisson'),
            array('Perrier', '33cl', 2.5, "/Produits/0006.png", false, 'Boisson'),
            array('Vittel', '50cl', 2.5, "/Produits/0007.png", false, 'Boisson'),

            array('Tarte au fraise', 'Dessert fait maison', 5, "/Produits/0008.png", true, 'Dessert'),
            array('Tarte Milka', 'Dessert si délicieux', 5.5, "/Produits/0009.png", true, 'Dessert')
        );
        $tabObjetProduit = array();
        for ($i=0; $i < count($tabProduit); $i++){
            $tabObjetProduit[$i] = new Produit();
            $tabObjetProduit[$i]->setNom($tabProduit[$i][0]);
            $tabObjetProduit[$i]->setDescription($tabProduit[$i][1]);
            $tabObjetProduit[$i]->setPrix($tabProduit[$i][2]);
            $tabObjetProduit[$i]->setPhoto($tabProduit[$i][3]);
            $tabObjetProduit[$i]->setPromo($tabProduit[$i][4]);//Bolean
            $quelleCategorieProduit = array_search($tabProduit[$i][5], $tabCategorieProduit);
            $tabObjetProduit[$i]->setCategorieProduit($tabObjetCategorieProduit[$quelleCategorieProduit]);
            $manager->persist($tabObjetProduit[$i]);
        }
        $manager->flush();

    }
}
