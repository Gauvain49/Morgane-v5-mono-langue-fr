<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415122403 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mg_properties_values DROP FOREIGN KEY FK_C7BFC7064584665A');
        $this->addSql('DROP INDEX IDX_C7BFC7064584665A ON mg_properties_values');
        $this->addSql('ALTER TABLE mg_properties_values DROP product_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mg_properties_values ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE mg_properties_values ADD CONSTRAINT FK_C7BFC7064584665A FOREIGN KEY (product_id) REFERENCES mg_products (id)');
        $this->addSql('CREATE INDEX IDX_C7BFC7064584665A ON mg_properties_values (product_id)');
    }
}
