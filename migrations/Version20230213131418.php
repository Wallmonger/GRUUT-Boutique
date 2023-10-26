<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213131418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materials_of_product ADD order_details_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE materials_of_product ADD CONSTRAINT FK_F353A1158C0FA77 FOREIGN KEY (order_details_id) REFERENCES order_details (id)');
        $this->addSql('CREATE INDEX IDX_F353A1158C0FA77 ON materials_of_product (order_details_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materials_of_product DROP FOREIGN KEY FK_F353A1158C0FA77');
        $this->addSql('DROP INDEX IDX_F353A1158C0FA77 ON materials_of_product');
        $this->addSql('ALTER TABLE materials_of_product DROP order_details_id');
    }
}
