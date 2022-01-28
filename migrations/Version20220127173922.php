<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220127173922 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mg_departments_french (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, code_insee VARCHAR(3) NOT NULL, name VARCHAR(64) NOT NULL, INDEX IDX_7B444DF998260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mg_regions_french (id INT AUTO_INCREMENT NOT NULL, code_iso VARCHAR(10) NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mg_departments_french ADD CONSTRAINT FK_7B444DF998260155 FOREIGN KEY (region_id) REFERENCES mg_regions_french (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mg_departments_french DROP FOREIGN KEY FK_7B444DF998260155');
        $this->addSql('DROP TABLE mg_departments_french');
        $this->addSql('DROP TABLE mg_regions_french');
    }
}
