<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220514161626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capsule ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE capsule ADD CONSTRAINT FK_C268A183A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C268A183A76ED395 ON capsule (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649906D5F2C');
        $this->addSql('DROP INDEX IDX_8D93D649906D5F2C ON user');
        $this->addSql('ALTER TABLE user DROP forfait_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capsule DROP FOREIGN KEY FK_C268A183A76ED395');
        $this->addSql('DROP INDEX IDX_C268A183A76ED395 ON capsule');
        $this->addSql('ALTER TABLE capsule DROP user_id');
        $this->addSql('ALTER TABLE user ADD forfait_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649906D5F2C FOREIGN KEY (forfait_id) REFERENCES forfait (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649906D5F2C ON user (forfait_id)');
    }
}
