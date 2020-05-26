<?php

namespace App\DataFixtures;

use App\Entity\CategorieIngredient;
use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
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
        $tabObjetIngredientViande = array();
        $quelleCategorieIngredient = array_search('Viande', $tabCategorieIngredient);
        for ($i=0; $i < count($tabIngredient); $i++){
            $tabObjetIngredientViande[$i] = new Ingredient();
            $tabObjetIngredientViande[$i]->setNom($tabIngredient[$i]);
            $tabObjetIngredientViande[$i]->setCategorieIngredient($tabObjetCategorieIngredient[$quelleCategorieIngredient]);
            $manager->persist($tabObjetIngredientViande[$i]);
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
//





        $manager->flush();
    }
}
