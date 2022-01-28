<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220127191908 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mg_carriers_steps (id INT AUTO_INCREMENT NOT NULL, config_id INT NOT NULL, step_min DOUBLE PRECISION NOT NULL, step_max DOUBLE PRECISION NOT NULL, type VARCHAR(20) NOT NULL, INDEX IDX_FCD0FACB24DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mg_carriers_steps ADD CONSTRAINT FK_FCD0FACB24DB0683 FOREIGN KEY (config_id) REFERENCES mg_carriers_config (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE mg_carriers_steps');
    }
}
