<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312114231 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mg_categories ADD parent_id INT NOT NULL');
        $this->addSql('ALTER TABLE mg_categories ADD CONSTRAINT FK_285E7ED9727ACA70 FOREIGN KEY (parent_id) REFERENCES mg_categories (id)');
        $this->addSql('CREATE INDEX IDX_285E7ED9727ACA70 ON mg_categories (parent_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mg_categories DROP FOREIGN KEY FK_285E7ED9727ACA70');
        $this->addSql('DROP INDEX IDX_285E7ED9727ACA70 ON mg_categories');
        $this->addSql('ALTER TABLE mg_categories DROP parent_id');
    }
}
