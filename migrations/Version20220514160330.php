<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220514160330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE capsule (id INT AUTO_INCREMENT NOT NULL, forfait_id INT DEFAULT NULL, INDEX IDX_C268A183906D5F2C (forfait_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forfait (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, prix INT NOT NULL, duree INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE capsule ADD CONSTRAINT FK_C268A183906D5F2C FOREIGN KEY (forfait_id) REFERENCES forfait (id)');
        $this->addSql('ALTER TABLE user ADD forfait_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649906D5F2C FOREIGN KEY (forfait_id) REFERENCES forfait (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649906D5F2C ON user (forfait_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capsule DROP FOREIGN KEY FK_C268A183906D5F2C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649906D5F2C');
        $this->addSql('DROP TABLE capsule');
        $this->addSql('DROP TABLE forfait');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP INDEX IDX_8D93D649906D5F2C ON user');
        $this->addSql('ALTER TABLE user DROP forfait_id');
    }
}
