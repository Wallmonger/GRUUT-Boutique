<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215073953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE authorization_avis (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, product_id INT DEFAULT NULL, is_allowed TINYINT(1) NOT NULL, INDEX IDX_D7B773D0A76ED395 (user_id), INDEX IDX_D7B773D04584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE authorization_avis ADD CONSTRAINT FK_D7B773D0A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE authorization_avis ADD CONSTRAINT FK_D7B773D04584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE reset_password CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE authorization_avis DROP FOREIGN KEY FK_D7B773D0A76ED395');
        $this->addSql('ALTER TABLE authorization_avis DROP FOREIGN KEY FK_D7B773D04584665A');
        $this->addSql('DROP TABLE authorization_avis');
        $this->addSql('ALTER TABLE reset_password CHANGE created_at created_at DATETIME NOT NULL');
    }
}
