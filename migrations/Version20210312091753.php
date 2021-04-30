<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312091753 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mg_carriers (id INT AUTO_INCREMENT NOT NULL, carrier_name VARCHAR(100) NOT NULL, carrier_description LONGTEXT NOT NULL, carrier_active TINYINT(1) NOT NULL, carrier_default TINYINT(1) NOT NULL, carrier_logo VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mg_products (id INT AUTO_INCREMENT NOT NULL, supplier_id INT NOT NULL, carrier_id INT DEFAULT NULL, taxe_id INT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, summary VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, reference VARCHAR(100) DEFAULT NULL, purshasing_price DOUBLE PRECISION DEFAULT NULL, selling_price DOUBLE PRECISION NOT NULL, selling_price_all_taxes DOUBLE PRECISION NOT NULL, sales_unit INT NOT NULL, min_quantity INT NOT NULL, max_quantity INT DEFAULT NULL, bulk_quantity INT DEFAULT NULL, discount DOUBLE PRECISION DEFAULT NULL, discount_type VARCHAR(10) DEFAULT NULL, discount_on_taxe TINYINT(1) DEFAULT \'0\', stock_management TINYINT(1) DEFAULT \'0\' NOT NULL, stock_quantity INT DEFAULT NULL, sell_out_of_stock TINYINT(1) DEFAULT \'0\', stock_alert INT DEFAULT NULL, pre_order TINYINT(1) DEFAULT \'0\' NOT NULL, date_available DATETIME NOT NULL, date_publish DATETIME NOT NULL, offline TINYINT(1) DEFAULT \'0\' NOT NULL, type VARCHAR(50) NOT NULL, date_creat DATETIME NOT NULL, date_up DATETIME DEFAULT NULL, additionnal_shipping_cost DOUBLE PRECISION NOT NULL, width DOUBLE PRECISION DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, depth DOUBLE PRECISION DEFAULT NULL, weight DOUBLE PRECISION DEFAULT NULL, INDEX IDX_B88F7E4E2ADD6D8C (supplier_id), INDEX IDX_B88F7E4E21DFC797 (carrier_id), INDEX IDX_B88F7E4E1AB947A4 (taxe_id), INDEX IDX_B88F7E4E727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mg_suppliers (id INT AUTO_INCREMENT NOT NULL, supplier_name VARCHAR(100) NOT NULL, supplier_address VARCHAR(255) DEFAULT NULL, supplier_zipcode VARCHAR(5) DEFAULT NULL, supplier_town VARCHAR(100) DEFAULT NULL, supplier_phone VARCHAR(20) DEFAULT NULL, supplier_email VARCHAR(100) DEFAULT NULL, supplier_web VARCHAR(100) DEFAULT NULL, supplier_logo VARCHAR(100) DEFAULT NULL, supplier_note LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mg_taxes (id INT AUTO_INCREMENT NOT NULL, taxe_name VARCHAR(50) NOT NULL, taxe_rate DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mg_products ADD CONSTRAINT FK_B88F7E4E2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES mg_suppliers (id)');
        $this->addSql('ALTER TABLE mg_products ADD CONSTRAINT FK_B88F7E4E21DFC797 FOREIGN KEY (carrier_id) REFERENCES mg_carriers (id)');
        $this->addSql('ALTER TABLE mg_products ADD CONSTRAINT FK_B88F7E4E1AB947A4 FOREIGN KEY (taxe_id) REFERENCES mg_taxes (id)');
        $this->addSql('ALTER TABLE mg_products ADD CONSTRAINT FK_B88F7E4E727ACA70 FOREIGN KEY (parent_id) REFERENCES mg_products (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mg_products DROP FOREIGN KEY FK_B88F7E4E21DFC797');
        $this->addSql('ALTER TABLE mg_products DROP FOREIGN KEY FK_B88F7E4E727ACA70');
        $this->addSql('ALTER TABLE mg_products DROP FOREIGN KEY FK_B88F7E4E2ADD6D8C');
        $this->addSql('ALTER TABLE mg_products DROP FOREIGN KEY FK_B88F7E4E1AB947A4');
        $this->addSql('DROP TABLE mg_carriers');
        $this->addSql('DROP TABLE mg_products');
        $this->addSql('DROP TABLE mg_suppliers');
        $this->addSql('DROP TABLE mg_taxes');
    }
}
