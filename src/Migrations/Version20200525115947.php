<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200525115947 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, num VARCHAR(255) NOT NULL, rue VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, cp VARCHAR(255) NOT NULL, longitude VARCHAR(255) DEFAULT NULL, latitude VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_ingredient (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_produit (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, emporter TINYINT(1) NOT NULL, date_retrait DATETIME DEFAULT NULL, date_liv DATETIME DEFAULT NULL, heure_retrait DATETIME DEFAULT NULL, heure_liv DATETIME DEFAULT NULL, commentaire VARCHAR(255) DEFAULT NULL, prix_total DOUBLE PRECISION NOT NULL, INDEX IDX_6EEAA67DFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient_produit (ingredient_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_2892E7E1933FE08C (ingredient_id), INDEX IDX_2892E7E1F347EFB (produit_id), PRIMARY KEY(ingredient_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_cde (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, num_ligne INT NOT NULL, quantite INT NOT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_5B71680B82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_cde_menu (id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_A51E228DCCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_cde_produit (id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_37633330F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, promo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, categorie_produit_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, photo VARCHAR(255) DEFAULT NULL, promo TINYINT(1) NOT NULL, INDEX IDX_29A5EC2791FDB457 (categorie_produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit_menu (produit_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_549D477CF347EFB (produit_id), INDEX IDX_549D477CCCD7E912 (menu_id), PRIMARY KEY(produit_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, adresse_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone INT NOT NULL, num_porte VARCHAR(255) DEFAULT NULL, code_entree VARCHAR(255) DEFAULT NULL, complement VARCHAR(255) DEFAULT NULL, etage VARCHAR(255) DEFAULT NULL, INDEX IDX_1D1C63B34DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE ingredient_produit ADD CONSTRAINT FK_2892E7E1933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient_produit ADD CONSTRAINT FK_2892E7E1F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_cde ADD CONSTRAINT FK_5B71680B82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE ligne_cde_menu ADD CONSTRAINT FK_A51E228DCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE ligne_cde_menu ADD CONSTRAINT FK_A51E228DBF396750 FOREIGN KEY (id) REFERENCES ligne_cde (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_cde_produit ADD CONSTRAINT FK_37633330F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE ligne_cde_produit ADD CONSTRAINT FK_37633330BF396750 FOREIGN KEY (id) REFERENCES ligne_cde (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2791FDB457 FOREIGN KEY (categorie_produit_id) REFERENCES categorie_produit (id)');
        $this->addSql('ALTER TABLE produit_menu ADD CONSTRAINT FK_549D477CF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_menu ADD CONSTRAINT FK_549D477CCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B34DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B34DE7DC5C');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC2791FDB457');
        $this->addSql('ALTER TABLE ligne_cde DROP FOREIGN KEY FK_5B71680B82EA2E54');
        $this->addSql('ALTER TABLE ingredient_produit DROP FOREIGN KEY FK_2892E7E1933FE08C');
        $this->addSql('ALTER TABLE ligne_cde_menu DROP FOREIGN KEY FK_A51E228DBF396750');
        $this->addSql('ALTER TABLE ligne_cde_produit DROP FOREIGN KEY FK_37633330BF396750');
        $this->addSql('ALTER TABLE ligne_cde_menu DROP FOREIGN KEY FK_A51E228DCCD7E912');
        $this->addSql('ALTER TABLE produit_menu DROP FOREIGN KEY FK_549D477CCCD7E912');
        $this->addSql('ALTER TABLE ingredient_produit DROP FOREIGN KEY FK_2892E7E1F347EFB');
        $this->addSql('ALTER TABLE ligne_cde_produit DROP FOREIGN KEY FK_37633330F347EFB');
        $this->addSql('ALTER TABLE produit_menu DROP FOREIGN KEY FK_549D477CF347EFB');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DFB88E14F');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE categorie_ingredient');
        $this->addSql('DROP TABLE categorie_produit');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE ingredient_produit');
        $this->addSql('DROP TABLE ligne_cde');
        $this->addSql('DROP TABLE ligne_cde_menu');
        $this->addSql('DROP TABLE ligne_cde_produit');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE produit_menu');
        $this->addSql('DROP TABLE utilisateur');
    }
}
