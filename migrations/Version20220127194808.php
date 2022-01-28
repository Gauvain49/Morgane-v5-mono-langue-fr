<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220127194808 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mg_carriers_amount (id INT AUTO_INCREMENT NOT NULL, carrier_step_id INT NOT NULL, carrier_config_id INT NOT NULL, place_id INT NOT NULL, amount DOUBLE PRECISION DEFAULT NULL, INDEX IDX_3CD4899A274138D4 (carrier_step_id), INDEX IDX_3CD4899ACE761280 (carrier_config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mg_carriers_amount ADD CONSTRAINT FK_3CD4899A274138D4 FOREIGN KEY (carrier_step_id) REFERENCES mg_carriers_steps (id)');
        $this->addSql('ALTER TABLE mg_carriers_amount ADD CONSTRAINT FK_3CD4899ACE761280 FOREIGN KEY (carrier_config_id) REFERENCES mg_carriers_config (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE mg_carriers_amount');
    }
}
