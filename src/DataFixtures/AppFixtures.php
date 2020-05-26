<?php

namespace App\DataFixtures;

use App\Entity\CategorieIngredient;
use App\Entity\CategorieProduit;
use App\Entity\Ingredient;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    const PHOTO = 'https://picsum.photos/200';

    public function load(ObjectManager $manager)
    {




        //************************************************************************************************************
        //************************************************ CategorieIngredient ***************************************
        //************************************************************************************************************
        $tabCategorieIngredient = array();
        array_push($tabCategorieIngredient, 'Viande', 'Sauce', 'Garniture', 'Supplement' );
        $tabObjetCategorieIngredient = array();
        for ($i=0; $i < count($tabCategorieIngredient); $i++){
            $tabObjetCategorieIngredient[$i] = new CategorieIngredient();
            $tabObjetCategorieIngredient[$i]->setNom($tabCategorieIngredient[$i]);
            $manager->persist($tabObjetCategorieIngredient[$i]);
        }

        $manager->flush();

        //************************************************************************************************************
        //************************************************ Ingredient ************************************************
        //************************************************************************************************************

        //***************************** Viande *****************************
        $tabIngredient = array();
        array_push($tabIngredient,
        'Viande hachée',
        'Kebbab',
        'Poulet mariné',
        'Cordon bleu',
        'Mergez',
        'Thunder',
        'Nugget',
        'Sans viande'
        );
        $tabObjetIngredient = array();
        $quelleCategorieIngredient = array_search('Viande', $tabCategorieIngredient);
        for ($i=0; $i < count($tabIngredient); $i++){
            $tabObjetIngredient[$i] = new Ingredient();
            $tabObjetIngredient[$i]->setNom($tabIngredient[$i]);
            $tabObjetIngredient[$i]->setCategorieIngredient($tabObjetCategorieIngredient[$quelleCategorieIngredient]);
            $manager->persist($tabObjetIngredient[$i]);
        }
        $compteurIngredient = count($tabIngredient);

        //***************************** Sauce *****************************
        array_push($tabIngredient,
        'Ketchup',
        'Mayonnaise',
        'Sauce blanche',
        'Barbecue',
        'Moutarde',
        'Curry',
        'Sauce Algérienne'
        );
        $quelleCategorieIngredient = array_search('Sauce', $tabCategorieIngredient);
        for ($i=$compteurIngredient; $i < count($tabIngredient); $i++){
            $tabObjetIngredient[$i] = new Ingredient();
            $tabObjetIngredient[$i]->setNom($tabIngredient[$i]);
            $tabObjetIngredient[$i]->setCategorieIngredient($tabObjetCategorieIngredient[$quelleCategorieIngredient]);
            $manager->persist($tabObjetIngredient[$i]);
        }
        $compteurIngredient = count($tabIngredient);

        //***************************** Garniture *****************************
        array_push($tabIngredient,
        'Salade',
        'Tomates',
        'Oignons',
        'Frite',
        'Sauce Fromage'
        );
        $quelleCategorieIngredient = array_search('Garniture', $tabCategorieIngredient);
        for ($i=$compteurIngredient; $i < count($tabIngredient); $i++){
            $tabObjetIngredient[$i] = new Ingredient();
            $tabObjetIngredient[$i]->setNom($tabIngredient[$i]);
            $tabObjetIngredient[$i]->setCategorieIngredient($tabObjetCategorieIngredient[$quelleCategorieIngredient]);
            $manager->persist($tabObjetIngredient[$i]);
        }
        $compteurIngredient = count($tabIngredient);

        //***************************** Supplement *****************************
        array_push($tabIngredient,
        'Cheddar',
        'Emmental râpé',
        'Raclette',
        'Sauce fromagère',
        'Oignons frits',
        'Chili pepper',
        'Oeuf',
        'Poivrons grillés',
        'Gratiné cheddar',
        'Gratiné raclette',
        'Gratiné emmental râpé'
        );
        $quelleCategorieIngredient = array_search('Supplement', $tabCategorieIngredient);
        for ($i=$compteurIngredient; $i < count($tabIngredient); $i++){
            $tabObjetIngredient[$i] = new Ingredient();
            $tabObjetIngredient[$i]->setNom($tabIngredient[$i]);
            $tabObjetIngredient[$i]->setCategorieIngredient($tabObjetCategorieIngredient[$quelleCategorieIngredient]);
            $manager->persist($tabObjetIngredient[$i]);
        }
        $compteurIngredient = count($tabIngredient);


        //************************************************************************************************************
        //************************************************ CategorieProduit ***************************************
        //************************************************************************************************************
        $tabCategorieProduit = array();
        array_push($tabCategorieProduit,
    'Tacos',
        'Tapas',
        'Boisson',
        'Dessert'
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
            array('Tacos simple', 'Délicieux tacos la beauté', 5.8, self::PHOTO, false, 'Tacos'),
            array('Tacos double', 'Délicieux tacos deux fois plus de la beauté', 5.8, self::PHOTO, true, 'Tacos'),
            array('Tacos triple', 'Bonheur triple bonheur', 5.8, self::PHOTO, true, 'Tacos'),
            array('Nuggets x4', '4 délicieux pollos', 3.5, self::PHOTO, false, 'Tapas'),
            array('Nuggets x6', '4 délicieux pollos', 3.5, self::PHOTO, false, 'Tapas'),
            array('Nuggets x8', '8 délicieux pollos', 7, self::PHOTO, true, 'Tapas'),
            array('Frites', 'Frites légères', 2.5, self::PHOTO, true, 'Tapas'),
            array('Coca-Cola Coke', '50cl', 18, self::PHOTO, false, 'Boisson'),
            array('Orangina', '50cl', 18, self::PHOTO, false, 'Boisson'),
            array('Tarte au fraise', 'Dessert fait maison', 5, self::PHOTO, true, 'Dessert'),
            array('Tarte Milka', 'Dessert si délicieux', 5.5, self::PHOTO, true, 'Dessert')
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



//

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//





        $manager->flush();
    }
}
