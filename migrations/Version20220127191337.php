<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220127191337 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mg_carriers_config (id INT AUTO_INCREMENT NOT NULL, carrier_id INT NOT NULL, taxe_id INT NOT NULL, billing_on VARCHAR(20) NOT NULL, out_of_range VARCHAR(20) NOT NULL, INDEX IDX_66FFD6A421DFC797 (carrier_id), INDEX IDX_66FFD6A41AB947A4 (taxe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mg_carriers_config ADD CONSTRAINT FK_66FFD6A421DFC797 FOREIGN KEY (carrier_id) REFERENCES mg_carriers (id)');
        $this->addSql('ALTER TABLE mg_carriers_config ADD CONSTRAINT FK_66FFD6A41AB947A4 FOREIGN KEY (taxe_id) REFERENCES mg_taxes (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE mg_carriers_config');
    }
}
