<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200617162024 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE c_character CHANGE birth_date birth_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE c_character_affectation CHANGE begin_at begin_at DATETIME NOT NULL, CHANGE end_at end_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE c_character_medal CHANGE attribute_at attribute_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE u_user CHANGE birth_date birth_date DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE c_character CHANGE birth_date birth_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE c_character_affectation CHANGE begin_at begin_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE end_at end_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE c_character_medal CHANGE attribute_at attribute_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE u_user CHANGE birth_date birth_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
