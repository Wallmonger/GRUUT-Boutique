<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214105700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, parent_id INT DEFAULT NULL, content LONGTEXT NOT NULL, username VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5F9E962A4584665A (product_id), INDEX IDX_5F9E962A727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A727ACA70 FOREIGN KEY (parent_id) REFERENCES comments (id)');
        $this->addSql('ALTER TABLE materials_of_product DROP FOREIGN KEY FK_F353A1158C0FA77');
        $this->addSql('DROP INDEX IDX_F353A1158C0FA77 ON materials_of_product');
        $this->addSql('ALTER TABLE materials_of_product DROP order_details_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A4584665A');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A727ACA70');
        $this->addSql('DROP TABLE comments');
        $this->addSql('ALTER TABLE materials_of_product ADD order_details_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE materials_of_product ADD CONSTRAINT FK_F353A1158C0FA77 FOREIGN KEY (order_details_id) REFERENCES order_details (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F353A1158C0FA77 ON materials_of_product (order_details_id)');
    }
}
