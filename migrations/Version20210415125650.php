<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415125650 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mg_products_mg_properties (mg_products_id INT NOT NULL, mg_properties_id INT NOT NULL, INDEX IDX_715F44AD0FEAF8B (mg_products_id), INDEX IDX_715F44A4DF52651 (mg_properties_id), PRIMARY KEY(mg_products_id, mg_properties_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mg_products_mg_properties ADD CONSTRAINT FK_715F44AD0FEAF8B FOREIGN KEY (mg_products_id) REFERENCES mg_products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mg_products_mg_properties ADD CONSTRAINT FK_715F44A4DF52651 FOREIGN KEY (mg_properties_id) REFERENCES mg_properties (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE mg_products_mg_properties');
    }
}
