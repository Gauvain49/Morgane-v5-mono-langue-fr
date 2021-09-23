<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210511164946 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mg_manufacturers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, active TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mg_products ADD manufacturer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mg_products ADD CONSTRAINT FK_B88F7E4EA23B42D FOREIGN KEY (manufacturer_id) REFERENCES mg_manufacturers (id)');
        $this->addSql('CREATE INDEX IDX_B88F7E4EA23B42D ON mg_products (manufacturer_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mg_products DROP FOREIGN KEY FK_B88F7E4EA23B42D');
        $this->addSql('DROP TABLE mg_manufacturers');
        $this->addSql('DROP INDEX IDX_B88F7E4EA23B42D ON mg_products');
        $this->addSql('ALTER TABLE mg_products DROP manufacturer_id');
    }
}
