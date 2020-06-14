<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200612125429 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE c_accreditation (id INT AUTO_INCREMENT NOT NULL, level SMALLINT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', abbreviation VARCHAR(20) NOT NULL, category SMALLINT DEFAULT 0 NOT NULL, description LONGTEXT NOT NULL, is_default TINYINT(1) DEFAULT \'0\' NOT NULL, is_playable TINYINT(1) DEFAULT \'0\' NOT NULL, type SMALLINT DEFAULT 0 NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C182C54CBCF3411D (abbreviation), UNIQUE INDEX UNIQ_C182C54C5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE c_feature (id INT AUTO_INCREMENT NOT NULL, picture VARCHAR(255) DEFAULT NULL, value_min INT DEFAULT 0 NOT NULL, value_max INT DEFAULT 100 NOT NULL, value_Average INT DEFAULT 50 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', abbreviation VARCHAR(20) NOT NULL, description LONGTEXT NOT NULL, is_obsolete TINYINT(1) DEFAULT \'0\' NOT NULL, type SMALLINT DEFAULT 0 NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D5AE2BDBCF3411D (abbreviation), UNIQUE INDEX UNIQ_8D5AE2BD5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE c_medal (id INT AUTO_INCREMENT NOT NULL, coef_xp DOUBLE PRECISION DEFAULT \'0\' NOT NULL, picture VARCHAR(255) DEFAULT NULL, ribbon VARCHAR(255) DEFAULT NULL, value INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', abbreviation VARCHAR(20) NOT NULL, category SMALLINT DEFAULT 0 NOT NULL, description LONGTEXT NOT NULL, is_obsolete TINYINT(1) DEFAULT \'0\' NOT NULL, type SMALLINT DEFAULT 0 NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C08C9380BCF3411D (abbreviation), UNIQUE INDEX UNIQ_C08C93805E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE c_profession (id INT AUTO_INCREMENT NOT NULL, picture VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_obsolete TINYINT(1) DEFAULT \'0\' NOT NULL, is_playable TINYINT(1) DEFAULT \'0\' NOT NULL, description LONGTEXT NOT NULL, type SMALLINT DEFAULT 0 NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_9646346A5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE c_rank (id INT AUTO_INCREMENT NOT NULL, lvl_accred_min INT DEFAULT NULL, coef_xp DOUBLE PRECISION DEFAULT \'0\' NOT NULL, picture VARCHAR(255) DEFAULT NULL, score INT DEFAULT 0 NOT NULL, score_ol INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', abbreviation VARCHAR(20) NOT NULL, category SMALLINT DEFAULT 0 NOT NULL, description LONGTEXT NOT NULL, is_default TINYINT(1) DEFAULT \'0\' NOT NULL, is_obsolete TINYINT(1) DEFAULT \'0\' NOT NULL, is_playable TINYINT(1) DEFAULT \'0\' NOT NULL, type SMALLINT DEFAULT 0 NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2CDCB3B4BCF3411D (abbreviation), UNIQUE INDEX UNIQ_2CDCB3B45E237E06 (name), INDEX IDX_2CDCB3B42C1BECD6 (lvl_accred_min), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE c_role (id INT AUTO_INCREMENT NOT NULL, lvl_accred_min INT DEFAULT NULL, rank_min INT DEFAULT NULL, rank_max INT DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', abbreviation VARCHAR(20) NOT NULL, description LONGTEXT NOT NULL, is_default TINYINT(1) DEFAULT \'0\' NOT NULL, is_obsolete TINYINT(1) DEFAULT \'0\' NOT NULL, is_playable TINYINT(1) DEFAULT \'0\' NOT NULL, type SMALLINT DEFAULT 0 NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F3CCD13BBCF3411D (abbreviation), UNIQUE INDEX UNIQ_F3CCD13B5E237E06 (name), INDEX IDX_F3CCD13B2C1BECD6 (lvl_accred_min), INDEX IDX_F3CCD13BB7DEFD95 (rank_min), INDEX IDX_F3CCD13B8BD3C2CC (rank_max), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE c_skill (id INT AUTO_INCREMENT NOT NULL, feature_1 INT DEFAULT NULL, feature_2 INT DEFAULT NULL, feature_3 INT DEFAULT NULL, feature_4 INT DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, value SMALLINT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', abbreviation VARCHAR(20) NOT NULL, description LONGTEXT NOT NULL, is_obsolete TINYINT(1) DEFAULT \'0\' NOT NULL, type SMALLINT DEFAULT 0 NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_42F5204EBCF3411D (abbreviation), UNIQUE INDEX UNIQ_42F5204E5E237E06 (name), INDEX IDX_42F5204E3EEC051B (feature_1), INDEX IDX_42F5204EA7E554A1 (feature_2), INDEX IDX_42F5204ED0E26437 (feature_3), INDEX IDX_42F5204E4E86F194 (feature_4), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE c_speciality (id INT AUTO_INCREMENT NOT NULL, profession INT DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_default TINYINT(1) DEFAULT \'0\' NOT NULL, is_obsolete TINYINT(1) DEFAULT \'0\' NOT NULL, is_playable TINYINT(1) DEFAULT \'0\' NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, type SMALLINT DEFAULT 0 NOT NULL, INDEX IDX_DF02998DBA930D69 (profession), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE g_affectation (id INT AUTO_INCREMENT NOT NULL, parent INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', abbreviation VARCHAR(20) NOT NULL, is_default TINYINT(1) DEFAULT \'0\' NOT NULL, is_obsolete TINYINT(1) DEFAULT \'0\' NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, type SMALLINT DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_AD418FC6BCF3411D (abbreviation), INDEX IDX_AD418FC63D8E604F (parent), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE g_geo_luminary (id INT AUTO_INCREMENT NOT NULL, type INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_obsolete TINYINT(1) DEFAULT \'0\' NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, INDEX IDX_597F60C68CDE5729 (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE g_geo_luminary_type (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_obsolete TINYINT(1) DEFAULT \'0\' NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE g_geo_place (id INT AUTO_INCREMENT NOT NULL, type INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_obsolete TINYINT(1) DEFAULT \'0\' NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, INDEX IDX_C8678FDE8CDE5729 (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE g_geo_place_type (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_obsolete TINYINT(1) DEFAULT \'0\' NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE s_faq (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(512) NOT NULL, response LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_FC80DE28B6F7494E (question), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE s_parameter (id INT AUTO_INCREMENT NOT NULL, value LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_88C6DD655E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE u_user (id INT AUTO_INCREMENT NOT NULL, is_ban TINYINT(1) DEFAULT \'0\' NOT NULL, biography LONGTEXT DEFAULT NULL, birth_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', email VARCHAR(180) NOT NULL, first_name VARCHAR(50) DEFAULT NULL, last_connexion DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', last_name VARCHAR(50) DEFAULT NULL, password VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, sexe SMALLINT DEFAULT 0, token VARCHAR(32) DEFAULT NULL, username VARCHAR(50) DEFAULT NULL, is_valid TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_enable TINYINT(1) DEFAULT \'1\' NOT NULL, UNIQUE INDEX UNIQ_FCB96C9EE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE c_rank ADD CONSTRAINT FK_2CDCB3B42C1BECD6 FOREIGN KEY (lvl_accred_min) REFERENCES c_accreditation (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_role ADD CONSTRAINT FK_F3CCD13B2C1BECD6 FOREIGN KEY (lvl_accred_min) REFERENCES c_accreditation (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_role ADD CONSTRAINT FK_F3CCD13BB7DEFD95 FOREIGN KEY (rank_min) REFERENCES c_rank (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_role ADD CONSTRAINT FK_F3CCD13B8BD3C2CC FOREIGN KEY (rank_max) REFERENCES c_rank (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_skill ADD CONSTRAINT FK_42F5204E3EEC051B FOREIGN KEY (feature_1) REFERENCES c_feature (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_skill ADD CONSTRAINT FK_42F5204EA7E554A1 FOREIGN KEY (feature_2) REFERENCES c_feature (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_skill ADD CONSTRAINT FK_42F5204ED0E26437 FOREIGN KEY (feature_3) REFERENCES c_feature (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_skill ADD CONSTRAINT FK_42F5204E4E86F194 FOREIGN KEY (feature_4) REFERENCES c_feature (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_speciality ADD CONSTRAINT FK_DF02998DBA930D69 FOREIGN KEY (profession) REFERENCES c_profession (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE g_affectation ADD CONSTRAINT FK_AD418FC63D8E604F FOREIGN KEY (parent) REFERENCES g_affectation (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE g_geo_luminary ADD CONSTRAINT FK_597F60C68CDE5729 FOREIGN KEY (type) REFERENCES g_geo_luminary_type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE g_geo_place ADD CONSTRAINT FK_C8678FDE8CDE5729 FOREIGN KEY (type) REFERENCES g_geo_place_type (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE c_rank DROP FOREIGN KEY FK_2CDCB3B42C1BECD6');
        $this->addSql('ALTER TABLE c_role DROP FOREIGN KEY FK_F3CCD13B2C1BECD6');
        $this->addSql('ALTER TABLE c_skill DROP FOREIGN KEY FK_42F5204E3EEC051B');
        $this->addSql('ALTER TABLE c_skill DROP FOREIGN KEY FK_42F5204EA7E554A1');
        $this->addSql('ALTER TABLE c_skill DROP FOREIGN KEY FK_42F5204ED0E26437');
        $this->addSql('ALTER TABLE c_skill DROP FOREIGN KEY FK_42F5204E4E86F194');
        $this->addSql('ALTER TABLE c_speciality DROP FOREIGN KEY FK_DF02998DBA930D69');
        $this->addSql('ALTER TABLE c_role DROP FOREIGN KEY FK_F3CCD13BB7DEFD95');
        $this->addSql('ALTER TABLE c_role DROP FOREIGN KEY FK_F3CCD13B8BD3C2CC');
        $this->addSql('ALTER TABLE g_affectation DROP FOREIGN KEY FK_AD418FC63D8E604F');
        $this->addSql('ALTER TABLE g_geo_luminary DROP FOREIGN KEY FK_597F60C68CDE5729');
        $this->addSql('ALTER TABLE g_geo_place DROP FOREIGN KEY FK_C8678FDE8CDE5729');
        $this->addSql('DROP TABLE c_accreditation');
        $this->addSql('DROP TABLE c_feature');
        $this->addSql('DROP TABLE c_medal');
        $this->addSql('DROP TABLE c_profession');
        $this->addSql('DROP TABLE c_rank');
        $this->addSql('DROP TABLE c_role');
        $this->addSql('DROP TABLE c_skill');
        $this->addSql('DROP TABLE c_speciality');
        $this->addSql('DROP TABLE g_affectation');
        $this->addSql('DROP TABLE g_geo_luminary');
        $this->addSql('DROP TABLE g_geo_luminary_type');
        $this->addSql('DROP TABLE g_geo_place');
        $this->addSql('DROP TABLE g_geo_place_type');
        $this->addSql('DROP TABLE s_faq');
        $this->addSql('DROP TABLE s_parameter');
        $this->addSql('DROP TABLE u_user');
    }
}
