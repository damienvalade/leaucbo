<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220426135722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE code_departement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE save_hubeau_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE code_departement (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE save_hubeau (id INT NOT NULL, lebelle_parametre VARCHAR(255) DEFAULT NULL, code_lieu_analyse VARCHAR(255) DEFAULT NULL, analyse_numerique VARCHAR(255) DEFAULT NULL, libelle_unite VARCHAR(255) DEFAULT NULL, date_prelevement VARCHAR(255) DEFAULT NULL, code_departement VARCHAR(255) DEFAULT NULL, nom_departement VARCHAR(255) DEFAULT NULL, code_commune VARCHAR(255) DEFAULT NULL, nom_commune VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE code_departement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE save_hubeau_id_seq CASCADE');
        $this->addSql('DROP TABLE code_departement');
        $this->addSql('DROP TABLE save_hubeau');
    }
}
