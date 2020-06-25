<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200616154727 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE c_character ADD user_id INT NOT NULL, ADD email VARCHAR(180) NOT NULL, CHANGE firthname firstname VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE c_character ADD CONSTRAINT FK_9FDD388AA76ED395 FOREIGN KEY (user_id) REFERENCES u_user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9FDD388AE7927C74 ON c_character (email)');
        $this->addSql('CREATE INDEX IDX_9FDD388AA76ED395 ON c_character (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE c_character DROP FOREIGN KEY FK_9FDD388AA76ED395');
        $this->addSql('DROP INDEX UNIQ_9FDD388AE7927C74 ON c_character');
        $this->addSql('DROP INDEX IDX_9FDD388AA76ED395 ON c_character');
        $this->addSql('ALTER TABLE c_character DROP user_id, DROP email, CHANGE firstname firthname VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
