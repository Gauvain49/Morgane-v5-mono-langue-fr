<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312160738 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mg_users ADD customer_group_id INT DEFAULT NULL, ADD customer_compagny VARCHAR(100) DEFAULT NULL, ADD customer_birthday DATE DEFAULT NULL, ADD customer_notes LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE mg_users ADD CONSTRAINT FK_4FA4F0BED2919A68 FOREIGN KEY (customer_group_id) REFERENCES mg_customers_groups (id)');
        $this->addSql('CREATE INDEX IDX_4FA4F0BED2919A68 ON mg_users (customer_group_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mg_users DROP FOREIGN KEY FK_4FA4F0BED2919A68');
        $this->addSql('DROP INDEX IDX_4FA4F0BED2919A68 ON mg_users');
        $this->addSql('ALTER TABLE mg_users DROP customer_group_id, DROP customer_compagny, DROP customer_birthday, DROP customer_notes');
    }
}
