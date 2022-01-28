<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220115225434 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mg_posts ADD author_id INT NOT NULL, ADD parent_id INT DEFAULT NULL, ADD title VARCHAR(255) NOT NULL, ADD content LONGTEXT DEFAULT NULL, ADD type VARCHAR(20) NOT NULL, ADD status VARCHAR(20) NOT NULL, ADD sort SMALLINT DEFAULT NULL, ADD mime_type VARCHAR(100) DEFAULT NULL, ADD media_sizes VARCHAR(255) DEFAULT NULL, ADD slug VARCHAR(255) NOT NULL, ADD filename VARCHAR(255) DEFAULT NULL, ADD illustration VARCHAR(255) DEFAULT NULL, ADD comment TINYINT(1) DEFAULT \'0\' NOT NULL, ADD date_creat DATETIME NOT NULL, ADD date_update DATETIME DEFAULT NULL, ADD date_publish DATETIME NOT NULL, ADD date_expire DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE mg_posts ADD CONSTRAINT FK_D37AEFADF675F31B FOREIGN KEY (author_id) REFERENCES mg_users (id)');
        $this->addSql('ALTER TABLE mg_posts ADD CONSTRAINT FK_D37AEFAD727ACA70 FOREIGN KEY (parent_id) REFERENCES mg_posts (id)');
        $this->addSql('CREATE INDEX IDX_D37AEFADF675F31B ON mg_posts (author_id)');
        $this->addSql('CREATE INDEX IDX_D37AEFAD727ACA70 ON mg_posts (parent_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mg_posts DROP FOREIGN KEY FK_D37AEFADF675F31B');
        $this->addSql('ALTER TABLE mg_posts DROP FOREIGN KEY FK_D37AEFAD727ACA70');
        $this->addSql('DROP INDEX IDX_D37AEFADF675F31B ON mg_posts');
        $this->addSql('DROP INDEX IDX_D37AEFAD727ACA70 ON mg_posts');
        $this->addSql('ALTER TABLE mg_posts DROP author_id, DROP parent_id, DROP title, DROP content, DROP type, DROP status, DROP sort, DROP mime_type, DROP media_sizes, DROP slug, DROP filename, DROP illustration, DROP comment, DROP date_creat, DROP date_update, DROP date_publish, DROP date_expire');
    }
}
