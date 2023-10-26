<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230206151315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE materials_of_product (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, material_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_F353A1154584665A (product_id), INDEX IDX_F353A115E308AC6F (material_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE materials_of_product ADD CONSTRAINT FK_F353A1154584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE materials_of_product ADD CONSTRAINT FK_F353A115E308AC6F FOREIGN KEY (material_id) REFERENCES materials (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materials_of_product DROP FOREIGN KEY FK_F353A1154584665A');
        $this->addSql('ALTER TABLE materials_of_product DROP FOREIGN KEY FK_F353A115E308AC6F');
        $this->addSql('DROP TABLE materials_of_product');       
    }
}
