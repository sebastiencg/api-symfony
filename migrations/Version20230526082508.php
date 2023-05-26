<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230526082508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blague ADD profile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE blague ADD CONSTRAINT FK_9AEC019CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9AEC019CCFA12B8 ON blague (profile_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE blague DROP CONSTRAINT FK_9AEC019CCFA12B8');
        $this->addSql('DROP INDEX IDX_9AEC019CCFA12B8');
        $this->addSql('ALTER TABLE blague DROP profile_id');
    }
}
