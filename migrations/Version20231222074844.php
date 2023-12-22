<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231222074844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reparation (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, technicien_id INT DEFAULT NULL, description LONGTEXT NOT NULL, date_reparation DATE NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_8FDF219D19EB6921 (client_id), INDEX IDX_8FDF219D13457256 (technicien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reparation ADD CONSTRAINT FK_8FDF219D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE reparation ADD CONSTRAINT FK_8FDF219D13457256 FOREIGN KEY (technicien_id) REFERENCES technicien (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reparation DROP FOREIGN KEY FK_8FDF219D19EB6921');
        $this->addSql('ALTER TABLE reparation DROP FOREIGN KEY FK_8FDF219D13457256');
        $this->addSql('DROP TABLE reparation');
    }
}
