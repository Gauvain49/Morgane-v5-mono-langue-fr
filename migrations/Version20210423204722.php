<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210423204722 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE mg_products_mg_properties_values');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mg_products_mg_properties_values (mg_products_id INT NOT NULL, mg_properties_values_id INT NOT NULL, INDEX IDX_983BFA16D0FEAF8B (mg_products_id), INDEX IDX_983BFA16BDA956D1 (mg_properties_values_id), PRIMARY KEY(mg_products_id, mg_properties_values_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE mg_products_mg_properties_values ADD CONSTRAINT FK_983BFA16BDA956D1 FOREIGN KEY (mg_properties_values_id) REFERENCES mg_properties_values (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mg_products_mg_properties_values ADD CONSTRAINT FK_983BFA16D0FEAF8B FOREIGN KEY (mg_products_id) REFERENCES mg_products (id) ON DELETE CASCADE');
    }
}
