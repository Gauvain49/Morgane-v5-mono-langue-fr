<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310184510 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mg_genders (id INT AUTO_INCREMENT NOT NULL, short_gender VARCHAR(5) NOT NULL, name_gender VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mg_users (id INT AUTO_INCREMENT NOT NULL, gender_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, date_creat DATETIME NOT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_4FA4F0BEF85E0677 (username), UNIQUE INDEX UNIQ_4FA4F0BEE7927C74 (email), INDEX IDX_4FA4F0BE708A0E0 (gender_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mg_users ADD CONSTRAINT FK_4FA4F0BE708A0E0 FOREIGN KEY (gender_id) REFERENCES mg_genders (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mg_users DROP FOREIGN KEY FK_4FA4F0BE708A0E0');
        $this->addSql('DROP TABLE mg_genders');
        $this->addSql('DROP TABLE mg_users');
    }
}
