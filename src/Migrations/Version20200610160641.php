<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200610160641 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE c_medal (id INT AUTO_INCREMENT NOT NULL, coef_xp DOUBLE PRECISION DEFAULT \'0\' NOT NULL, picture VARCHAR(255) DEFAULT NULL, ribbon VARCHAR(255) DEFAULT NULL, value INT DEFAULT 0 NOT NULL, abbreviation VARCHAR(10) NOT NULL, category SMALLINT DEFAULT 0 NOT NULL, description LONGTEXT NOT NULL, is_obsolete TINYINT(1) DEFAULT \'0\' NOT NULL, type SMALLINT DEFAULT 0 NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C08C9380BCF3411D (abbreviation), UNIQUE INDEX UNIQ_C08C93805E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE c_rank ADD coef_xp DOUBLE PRECISION DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE c_medal');
        $this->addSql('ALTER TABLE c_rank DROP coef_xp');
    }
}
