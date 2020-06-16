<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200616100742 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE c_character (id INT AUTO_INCREMENT NOT NULL, birth_place_id INT DEFAULT NULL, profession_id INT DEFAULT NULL, rank_id INT DEFAULT NULL, recruitment_place_id INT DEFAULT NULL, speciality INT DEFAULT NULL, biography LONGTEXT DEFAULT NULL, birth_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', firthname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, nickname VARCHAR(100) DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, sexe SMALLINT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_default TINYINT(1) DEFAULT \'0\' NOT NULL, is_enable TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_9FDD388AB4BB6BBC (birth_place_id), INDEX IDX_9FDD388AFDEF8996 (profession_id), INDEX IDX_9FDD388A7616678F (rank_id), INDEX IDX_9FDD388A41EB20D7 (recruitment_place_id), INDEX IDX_9FDD388AF3D7A08E (speciality), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE join_character_accreditation (character_id INT NOT NULL, accreditation_id INT NOT NULL, INDEX IDX_A9CB5D411136BE75 (character_id), INDEX IDX_A9CB5D41A0822E24 (accreditation_id), PRIMARY KEY(character_id, accreditation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE join_character_role (character_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_9D8A4C7A1136BE75 (character_id), INDEX IDX_9D8A4C7AD60322AC (role_id), PRIMARY KEY(character_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE c_character_affectation (id INT AUTO_INCREMENT NOT NULL, affectation_id INT NOT NULL, character_id INT NOT NULL, begin_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_DFA77E36D0ABA22 (affectation_id), INDEX IDX_DFA77E31136BE75 (character_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE c_character_feature (id INT AUTO_INCREMENT NOT NULL, feature_id INT NOT NULL, character_id INT NOT NULL, experience_upgrade SMALLINT DEFAULT NULL, value SMALLINT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_CF1E590C60E4B879 (feature_id), INDEX IDX_CF1E590C1136BE75 (character_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE c_character_medal (id INT AUTO_INCREMENT NOT NULL, character_id INT NOT NULL, medal_id INT NOT NULL, attribute_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', comment LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_5A77E1551136BE75 (character_id), INDEX IDX_5A77E15528854E69 (medal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE c_character_skill (id INT AUTO_INCREMENT NOT NULL, character_id INT NOT NULL, skill_id INT NOT NULL, experience_upgrade SMALLINT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D80E529B1136BE75 (character_id), INDEX IDX_D80E529B5585C142 (skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE c_character ADD CONSTRAINT FK_9FDD388AB4BB6BBC FOREIGN KEY (birth_place_id) REFERENCES g_geo_place (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_character ADD CONSTRAINT FK_9FDD388AFDEF8996 FOREIGN KEY (profession_id) REFERENCES c_profession (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_character ADD CONSTRAINT FK_9FDD388A7616678F FOREIGN KEY (rank_id) REFERENCES c_rank (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_character ADD CONSTRAINT FK_9FDD388A41EB20D7 FOREIGN KEY (recruitment_place_id) REFERENCES g_geo_place (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_character ADD CONSTRAINT FK_9FDD388AF3D7A08E FOREIGN KEY (speciality) REFERENCES c_speciality (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE join_character_accreditation ADD CONSTRAINT FK_A9CB5D411136BE75 FOREIGN KEY (character_id) REFERENCES c_character (id)');
        $this->addSql('ALTER TABLE join_character_accreditation ADD CONSTRAINT FK_A9CB5D41A0822E24 FOREIGN KEY (accreditation_id) REFERENCES c_accreditation (id)');
        $this->addSql('ALTER TABLE join_character_role ADD CONSTRAINT FK_9D8A4C7A1136BE75 FOREIGN KEY (character_id) REFERENCES c_character (id)');
        $this->addSql('ALTER TABLE join_character_role ADD CONSTRAINT FK_9D8A4C7AD60322AC FOREIGN KEY (role_id) REFERENCES c_role (id)');
        $this->addSql('ALTER TABLE c_character_affectation ADD CONSTRAINT FK_DFA77E36D0ABA22 FOREIGN KEY (affectation_id) REFERENCES g_affectation (id)');
        $this->addSql('ALTER TABLE c_character_affectation ADD CONSTRAINT FK_DFA77E31136BE75 FOREIGN KEY (character_id) REFERENCES c_character (id)');
        $this->addSql('ALTER TABLE c_character_feature ADD CONSTRAINT FK_CF1E590C60E4B879 FOREIGN KEY (feature_id) REFERENCES c_feature (id)');
        $this->addSql('ALTER TABLE c_character_feature ADD CONSTRAINT FK_CF1E590C1136BE75 FOREIGN KEY (character_id) REFERENCES c_character (id)');
        $this->addSql('ALTER TABLE c_character_medal ADD CONSTRAINT FK_5A77E1551136BE75 FOREIGN KEY (character_id) REFERENCES c_character (id)');
        $this->addSql('ALTER TABLE c_character_medal ADD CONSTRAINT FK_5A77E15528854E69 FOREIGN KEY (medal_id) REFERENCES c_medal (id)');
        $this->addSql('ALTER TABLE c_character_skill ADD CONSTRAINT FK_D80E529B1136BE75 FOREIGN KEY (character_id) REFERENCES c_character (id)');
        $this->addSql('ALTER TABLE c_character_skill ADD CONSTRAINT FK_D80E529B5585C142 FOREIGN KEY (skill_id) REFERENCES c_skill (id)');
        $this->addSql('ALTER TABLE c_rank DROP FOREIGN KEY FK_2CDCB3B42C1BECD6');
        $this->addSql('DROP INDEX IDX_2CDCB3B42C1BECD6 ON c_rank');
        $this->addSql('ALTER TABLE c_rank CHANGE lvl_accred_min lvl_accred_min_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE c_rank ADD CONSTRAINT FK_2CDCB3B497EBF992 FOREIGN KEY (lvl_accred_min_id) REFERENCES c_accreditation (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_2CDCB3B497EBF992 ON c_rank (lvl_accred_min_id)');
        $this->addSql('ALTER TABLE c_role DROP FOREIGN KEY FK_F3CCD13B2C1BECD6');
        $this->addSql('ALTER TABLE c_role DROP FOREIGN KEY FK_F3CCD13B8BD3C2CC');
        $this->addSql('ALTER TABLE c_role DROP FOREIGN KEY FK_F3CCD13BB7DEFD95');
        $this->addSql('DROP INDEX IDX_F3CCD13BB7DEFD95 ON c_role');
        $this->addSql('DROP INDEX IDX_F3CCD13B2C1BECD6 ON c_role');
        $this->addSql('DROP INDEX IDX_F3CCD13B8BD3C2CC ON c_role');
        $this->addSql('ALTER TABLE c_role ADD lvl_accred_min_id INT DEFAULT NULL, ADD rank_min_id INT DEFAULT NULL, ADD rank_max_id INT DEFAULT NULL, DROP lvl_accred_min, DROP rank_min, DROP rank_max');
        $this->addSql('ALTER TABLE c_role ADD CONSTRAINT FK_F3CCD13B97EBF992 FOREIGN KEY (lvl_accred_min_id) REFERENCES c_accreditation (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_role ADD CONSTRAINT FK_F3CCD13B5DE0DFBF FOREIGN KEY (rank_min_id) REFERENCES c_rank (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_role ADD CONSTRAINT FK_F3CCD13B18E29C3D FOREIGN KEY (rank_max_id) REFERENCES c_rank (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_F3CCD13B97EBF992 ON c_role (lvl_accred_min_id)');
        $this->addSql('CREATE INDEX IDX_F3CCD13B5DE0DFBF ON c_role (rank_min_id)');
        $this->addSql('CREATE INDEX IDX_F3CCD13B18E29C3D ON c_role (rank_max_id)');
        $this->addSql('ALTER TABLE c_skill DROP FOREIGN KEY FK_42F5204E3EEC051B');
        $this->addSql('ALTER TABLE c_skill DROP FOREIGN KEY FK_42F5204E4E86F194');
        $this->addSql('ALTER TABLE c_skill DROP FOREIGN KEY FK_42F5204EA7E554A1');
        $this->addSql('ALTER TABLE c_skill DROP FOREIGN KEY FK_42F5204ED0E26437');
        $this->addSql('DROP INDEX IDX_42F5204E4E86F194 ON c_skill');
        $this->addSql('DROP INDEX IDX_42F5204EA7E554A1 ON c_skill');
        $this->addSql('DROP INDEX IDX_42F5204ED0E26437 ON c_skill');
        $this->addSql('DROP INDEX IDX_42F5204E3EEC051B ON c_skill');
        $this->addSql('ALTER TABLE c_skill ADD feature_1_id INT DEFAULT NULL, ADD feature_2_id INT DEFAULT NULL, ADD feature_3_id INT DEFAULT NULL, ADD feature_4_id INT DEFAULT NULL, DROP feature_1, DROP feature_2, DROP feature_3, DROP feature_4');
        $this->addSql('ALTER TABLE c_skill ADD CONSTRAINT FK_42F5204EA2F9D389 FOREIGN KEY (feature_1_id) REFERENCES c_feature (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_skill ADD CONSTRAINT FK_42F5204EB04C7C67 FOREIGN KEY (feature_2_id) REFERENCES c_feature (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_skill ADD CONSTRAINT FK_42F5204E8F01B02 FOREIGN KEY (feature_3_id) REFERENCES c_feature (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_skill ADD CONSTRAINT FK_42F5204E952723BB FOREIGN KEY (feature_4_id) REFERENCES c_feature (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_42F5204EA2F9D389 ON c_skill (feature_1_id)');
        $this->addSql('CREATE INDEX IDX_42F5204EB04C7C67 ON c_skill (feature_2_id)');
        $this->addSql('CREATE INDEX IDX_42F5204E8F01B02 ON c_skill (feature_3_id)');
        $this->addSql('CREATE INDEX IDX_42F5204E952723BB ON c_skill (feature_4_id)');
        $this->addSql('ALTER TABLE c_speciality DROP FOREIGN KEY FK_DF02998DBA930D69');
        $this->addSql('DROP INDEX IDX_DF02998DBA930D69 ON c_speciality');
        $this->addSql('ALTER TABLE c_speciality CHANGE profession profession_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE c_speciality ADD CONSTRAINT FK_DF02998DFDEF8996 FOREIGN KEY (profession_id) REFERENCES c_profession (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_DF02998DFDEF8996 ON c_speciality (profession_id)');
        $this->addSql('ALTER TABLE g_affectation DROP FOREIGN KEY FK_AD418FC63D8E604F');
        $this->addSql('DROP INDEX IDX_AD418FC63D8E604F ON g_affectation');
        $this->addSql('ALTER TABLE g_affectation CHANGE parent parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE g_affectation ADD CONSTRAINT FK_AD418FC6727ACA70 FOREIGN KEY (parent_id) REFERENCES g_affectation (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_AD418FC6727ACA70 ON g_affectation (parent_id)');
        $this->addSql('ALTER TABLE g_geo_luminary DROP FOREIGN KEY FK_597F60C671A66075');
        $this->addSql('ALTER TABLE g_geo_luminary DROP FOREIGN KEY FK_597F60C68CDE5729');
        $this->addSql('DROP INDEX IDX_597F60C671A66075 ON g_geo_luminary');
        $this->addSql('DROP INDEX IDX_597F60C68CDE5729 ON g_geo_luminary');
        $this->addSql('ALTER TABLE g_geo_luminary ADD around_id INT DEFAULT NULL, ADD type_id INT DEFAULT NULL, DROP type, DROP around');
        $this->addSql('ALTER TABLE g_geo_luminary ADD CONSTRAINT FK_597F60C66E330280 FOREIGN KEY (around_id) REFERENCES g_geo_luminary (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE g_geo_luminary ADD CONSTRAINT FK_597F60C6C54C8C93 FOREIGN KEY (type_id) REFERENCES g_geo_luminary_type (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_597F60C66E330280 ON g_geo_luminary (around_id)');
        $this->addSql('CREATE INDEX IDX_597F60C6C54C8C93 ON g_geo_luminary (type_id)');
        $this->addSql('ALTER TABLE g_geo_place DROP FOREIGN KEY FK_C8678FDE3D8E604F');
        $this->addSql('ALTER TABLE g_geo_place DROP FOREIGN KEY FK_C8678FDE8CDE5729');
        $this->addSql('ALTER TABLE g_geo_place DROP FOREIGN KEY FK_C8678FDEDA426F62');
        $this->addSql('DROP INDEX IDX_C8678FDE3D8E604F ON g_geo_place');
        $this->addSql('DROP INDEX IDX_C8678FDE8CDE5729 ON g_geo_place');
        $this->addSql('DROP INDEX IDX_C8678FDEDA426F62 ON g_geo_place');
        $this->addSql('ALTER TABLE g_geo_place ADD luminary_id INT DEFAULT NULL, ADD parent_id INT DEFAULT NULL, ADD type_id INT DEFAULT NULL, DROP type, DROP luminary, DROP parent');
        $this->addSql('ALTER TABLE g_geo_place ADD CONSTRAINT FK_C8678FDE57A58D70 FOREIGN KEY (luminary_id) REFERENCES g_geo_luminary (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE g_geo_place ADD CONSTRAINT FK_C8678FDE727ACA70 FOREIGN KEY (parent_id) REFERENCES g_geo_place (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE g_geo_place ADD CONSTRAINT FK_C8678FDEC54C8C93 FOREIGN KEY (type_id) REFERENCES g_geo_place_type (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_C8678FDE57A58D70 ON g_geo_place (luminary_id)');
        $this->addSql('CREATE INDEX IDX_C8678FDE727ACA70 ON g_geo_place (parent_id)');
        $this->addSql('CREATE INDEX IDX_C8678FDEC54C8C93 ON g_geo_place (type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE join_character_accreditation DROP FOREIGN KEY FK_A9CB5D411136BE75');
        $this->addSql('ALTER TABLE join_character_role DROP FOREIGN KEY FK_9D8A4C7A1136BE75');
        $this->addSql('ALTER TABLE c_character_affectation DROP FOREIGN KEY FK_DFA77E31136BE75');
        $this->addSql('ALTER TABLE c_character_feature DROP FOREIGN KEY FK_CF1E590C1136BE75');
        $this->addSql('ALTER TABLE c_character_medal DROP FOREIGN KEY FK_5A77E1551136BE75');
        $this->addSql('ALTER TABLE c_character_skill DROP FOREIGN KEY FK_D80E529B1136BE75');
        $this->addSql('DROP TABLE c_character');
        $this->addSql('DROP TABLE join_character_accreditation');
        $this->addSql('DROP TABLE join_character_role');
        $this->addSql('DROP TABLE c_character_affectation');
        $this->addSql('DROP TABLE c_character_feature');
        $this->addSql('DROP TABLE c_character_medal');
        $this->addSql('DROP TABLE c_character_skill');
        $this->addSql('ALTER TABLE c_rank DROP FOREIGN KEY FK_2CDCB3B497EBF992');
        $this->addSql('DROP INDEX IDX_2CDCB3B497EBF992 ON c_rank');
        $this->addSql('ALTER TABLE c_rank CHANGE lvl_accred_min_id lvl_accred_min INT DEFAULT NULL');
        $this->addSql('ALTER TABLE c_rank ADD CONSTRAINT FK_2CDCB3B42C1BECD6 FOREIGN KEY (lvl_accred_min) REFERENCES c_accreditation (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_2CDCB3B42C1BECD6 ON c_rank (lvl_accred_min)');
        $this->addSql('ALTER TABLE c_role DROP FOREIGN KEY FK_F3CCD13B97EBF992');
        $this->addSql('ALTER TABLE c_role DROP FOREIGN KEY FK_F3CCD13B5DE0DFBF');
        $this->addSql('ALTER TABLE c_role DROP FOREIGN KEY FK_F3CCD13B18E29C3D');
        $this->addSql('DROP INDEX IDX_F3CCD13B97EBF992 ON c_role');
        $this->addSql('DROP INDEX IDX_F3CCD13B5DE0DFBF ON c_role');
        $this->addSql('DROP INDEX IDX_F3CCD13B18E29C3D ON c_role');
        $this->addSql('ALTER TABLE c_role ADD lvl_accred_min INT DEFAULT NULL, ADD rank_min INT DEFAULT NULL, ADD rank_max INT DEFAULT NULL, DROP lvl_accred_min_id, DROP rank_min_id, DROP rank_max_id');
        $this->addSql('ALTER TABLE c_role ADD CONSTRAINT FK_F3CCD13B2C1BECD6 FOREIGN KEY (lvl_accred_min) REFERENCES c_accreditation (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_role ADD CONSTRAINT FK_F3CCD13B8BD3C2CC FOREIGN KEY (rank_max) REFERENCES c_rank (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_role ADD CONSTRAINT FK_F3CCD13BB7DEFD95 FOREIGN KEY (rank_min) REFERENCES c_rank (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_F3CCD13BB7DEFD95 ON c_role (rank_min)');
        $this->addSql('CREATE INDEX IDX_F3CCD13B2C1BECD6 ON c_role (lvl_accred_min)');
        $this->addSql('CREATE INDEX IDX_F3CCD13B8BD3C2CC ON c_role (rank_max)');
        $this->addSql('ALTER TABLE c_skill DROP FOREIGN KEY FK_42F5204EA2F9D389');
        $this->addSql('ALTER TABLE c_skill DROP FOREIGN KEY FK_42F5204EB04C7C67');
        $this->addSql('ALTER TABLE c_skill DROP FOREIGN KEY FK_42F5204E8F01B02');
        $this->addSql('ALTER TABLE c_skill DROP FOREIGN KEY FK_42F5204E952723BB');
        $this->addSql('DROP INDEX IDX_42F5204EA2F9D389 ON c_skill');
        $this->addSql('DROP INDEX IDX_42F5204EB04C7C67 ON c_skill');
        $this->addSql('DROP INDEX IDX_42F5204E8F01B02 ON c_skill');
        $this->addSql('DROP INDEX IDX_42F5204E952723BB ON c_skill');
        $this->addSql('ALTER TABLE c_skill ADD feature_1 INT DEFAULT NULL, ADD feature_2 INT DEFAULT NULL, ADD feature_3 INT DEFAULT NULL, ADD feature_4 INT DEFAULT NULL, DROP feature_1_id, DROP feature_2_id, DROP feature_3_id, DROP feature_4_id');
        $this->addSql('ALTER TABLE c_skill ADD CONSTRAINT FK_42F5204E3EEC051B FOREIGN KEY (feature_1) REFERENCES c_feature (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_skill ADD CONSTRAINT FK_42F5204E4E86F194 FOREIGN KEY (feature_4) REFERENCES c_feature (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_skill ADD CONSTRAINT FK_42F5204EA7E554A1 FOREIGN KEY (feature_2) REFERENCES c_feature (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE c_skill ADD CONSTRAINT FK_42F5204ED0E26437 FOREIGN KEY (feature_3) REFERENCES c_feature (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_42F5204E4E86F194 ON c_skill (feature_4)');
        $this->addSql('CREATE INDEX IDX_42F5204EA7E554A1 ON c_skill (feature_2)');
        $this->addSql('CREATE INDEX IDX_42F5204ED0E26437 ON c_skill (feature_3)');
        $this->addSql('CREATE INDEX IDX_42F5204E3EEC051B ON c_skill (feature_1)');
        $this->addSql('ALTER TABLE c_speciality DROP FOREIGN KEY FK_DF02998DFDEF8996');
        $this->addSql('DROP INDEX IDX_DF02998DFDEF8996 ON c_speciality');
        $this->addSql('ALTER TABLE c_speciality CHANGE profession_id profession INT DEFAULT NULL');
        $this->addSql('ALTER TABLE c_speciality ADD CONSTRAINT FK_DF02998DBA930D69 FOREIGN KEY (profession) REFERENCES c_profession (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_DF02998DBA930D69 ON c_speciality (profession)');
        $this->addSql('ALTER TABLE g_affectation DROP FOREIGN KEY FK_AD418FC6727ACA70');
        $this->addSql('DROP INDEX IDX_AD418FC6727ACA70 ON g_affectation');
        $this->addSql('ALTER TABLE g_affectation CHANGE parent_id parent INT DEFAULT NULL');
        $this->addSql('ALTER TABLE g_affectation ADD CONSTRAINT FK_AD418FC63D8E604F FOREIGN KEY (parent) REFERENCES g_affectation (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_AD418FC63D8E604F ON g_affectation (parent)');
        $this->addSql('ALTER TABLE g_geo_luminary DROP FOREIGN KEY FK_597F60C66E330280');
        $this->addSql('ALTER TABLE g_geo_luminary DROP FOREIGN KEY FK_597F60C6C54C8C93');
        $this->addSql('DROP INDEX IDX_597F60C66E330280 ON g_geo_luminary');
        $this->addSql('DROP INDEX IDX_597F60C6C54C8C93 ON g_geo_luminary');
        $this->addSql('ALTER TABLE g_geo_luminary ADD type INT DEFAULT NULL, ADD around INT DEFAULT NULL, DROP around_id, DROP type_id');
        $this->addSql('ALTER TABLE g_geo_luminary ADD CONSTRAINT FK_597F60C671A66075 FOREIGN KEY (around) REFERENCES g_geo_luminary (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE g_geo_luminary ADD CONSTRAINT FK_597F60C68CDE5729 FOREIGN KEY (type) REFERENCES g_geo_luminary_type (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_597F60C671A66075 ON g_geo_luminary (around)');
        $this->addSql('CREATE INDEX IDX_597F60C68CDE5729 ON g_geo_luminary (type)');
        $this->addSql('ALTER TABLE g_geo_place DROP FOREIGN KEY FK_C8678FDE57A58D70');
        $this->addSql('ALTER TABLE g_geo_place DROP FOREIGN KEY FK_C8678FDE727ACA70');
        $this->addSql('ALTER TABLE g_geo_place DROP FOREIGN KEY FK_C8678FDEC54C8C93');
        $this->addSql('DROP INDEX IDX_C8678FDE57A58D70 ON g_geo_place');
        $this->addSql('DROP INDEX IDX_C8678FDE727ACA70 ON g_geo_place');
        $this->addSql('DROP INDEX IDX_C8678FDEC54C8C93 ON g_geo_place');
        $this->addSql('ALTER TABLE g_geo_place ADD type INT DEFAULT NULL, ADD luminary INT DEFAULT NULL, ADD parent INT DEFAULT NULL, DROP luminary_id, DROP parent_id, DROP type_id');
        $this->addSql('ALTER TABLE g_geo_place ADD CONSTRAINT FK_C8678FDE3D8E604F FOREIGN KEY (parent) REFERENCES g_geo_place (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE g_geo_place ADD CONSTRAINT FK_C8678FDE8CDE5729 FOREIGN KEY (type) REFERENCES g_geo_place_type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE g_geo_place ADD CONSTRAINT FK_C8678FDEDA426F62 FOREIGN KEY (luminary) REFERENCES g_geo_luminary (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_C8678FDE3D8E604F ON g_geo_place (parent)');
        $this->addSql('CREATE INDEX IDX_C8678FDE8CDE5729 ON g_geo_place (type)');
        $this->addSql('CREATE INDEX IDX_C8678FDEDA426F62 ON g_geo_place (luminary)');
    }
}
