<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200609093219 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE c_role (id INT AUTO_INCREMENT NOT NULL, rank_min_id INT DEFAULT NULL, rank_max_id INT DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', abbreviation VARCHAR(10) NOT NULL, category SMALLINT DEFAULT 0 NOT NULL, description LONGTEXT NOT NULL, is_default TINYINT(1) DEFAULT \'0\' NOT NULL, is_obsolete TINYINT(1) DEFAULT \'0\' NOT NULL, is_playable TINYINT(1) DEFAULT \'0\' NOT NULL, type SMALLINT DEFAULT 0 NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F3CCD13BBCF3411D (abbreviation), UNIQUE INDEX UNIQ_F3CCD13B5E237E06 (name), INDEX IDX_F3CCD13B5DE0DFBF (rank_min_id), INDEX IDX_F3CCD13B18E29C3D (rank_max_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE c_role ADD CONSTRAINT FK_F3CCD13B5DE0DFBF FOREIGN KEY (rank_min_id) REFERENCES c_rank (id)');
        $this->addSql('ALTER TABLE c_role ADD CONSTRAINT FK_F3CCD13B18E29C3D FOREIGN KEY (rank_max_id) REFERENCES c_rank (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE c_role');
    }
}
