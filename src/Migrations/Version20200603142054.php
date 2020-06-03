<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200603142054 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE perso_caracs (id INT AUTO_INCREMENT NOT NULL, abreviation VARCHAR(4) NOT NULL, description LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, val_min INT DEFAULT 0 NOT NULL, val_max INT DEFAULT 100 NOT NULL, val_moy INT DEFAULT 50 NOT NULL, type SMALLINT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_BC150EF686B470F8 (abreviation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE perso_comps (id INT AUTO_INCREMENT NOT NULL, carac_1 INT NOT NULL, carac_2 INT DEFAULT NULL, carac_3 INT DEFAULT NULL, carac_4 INT DEFAULT NULL, remplace_by INT DEFAULT NULL, remplace INT DEFAULT NULL, abreviation VARCHAR(4) NOT NULL, description LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, type SMALLINT DEFAULT 0 NOT NULL, valeur SMALLINT DEFAULT NULL, obsolete TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C52C3CEE86B470F8 (abreviation), INDEX IDX_C52C3CEEC27E42E8 (carac_1), INDEX IDX_C52C3CEE5B771352 (carac_2), INDEX IDX_C52C3CEE2C7023C4 (carac_3), INDEX IDX_C52C3CEEB214B667 (carac_4), UNIQUE INDEX UNIQ_C52C3CEEBF5D3B7B (remplace_by), UNIQUE INDEX UNIQ_C52C3CEE548C9292 (remplace), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site_faqs (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(512) NOT NULL, response LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_B2AE031CB6F7494E (question), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site_params (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, value LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_FF60A0AC5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, is_banned TINYINT(1) DEFAULT \'0\' NOT NULL, biographie LONGTEXT DEFAULT NULL, birthdate DATETIME DEFAULT NULL, email VARCHAR(180) NOT NULL, is_enable TINYINT(1) DEFAULT \'1\' NOT NULL, Last_connexion DATETIME DEFAULT NULL, last_name VARCHAR(50) DEFAULT NULL, password VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, first_name VARCHAR(50) DEFAULT NULL, roles JSON NOT NULL, sexe SMALLINT DEFAULT 0, token VARCHAR(32) DEFAULT NULL, username VARCHAR(50) DEFAULT NULL, is_valid TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE perso_comps ADD CONSTRAINT FK_C52C3CEEC27E42E8 FOREIGN KEY (carac_1) REFERENCES perso_caracs (id)');
        $this->addSql('ALTER TABLE perso_comps ADD CONSTRAINT FK_C52C3CEE5B771352 FOREIGN KEY (carac_2) REFERENCES perso_caracs (id)');
        $this->addSql('ALTER TABLE perso_comps ADD CONSTRAINT FK_C52C3CEE2C7023C4 FOREIGN KEY (carac_3) REFERENCES perso_caracs (id)');
        $this->addSql('ALTER TABLE perso_comps ADD CONSTRAINT FK_C52C3CEEB214B667 FOREIGN KEY (carac_4) REFERENCES perso_caracs (id)');
        $this->addSql('ALTER TABLE perso_comps ADD CONSTRAINT FK_C52C3CEEBF5D3B7B FOREIGN KEY (remplace_by) REFERENCES perso_comps (id)');
        $this->addSql('ALTER TABLE perso_comps ADD CONSTRAINT FK_C52C3CEE548C9292 FOREIGN KEY (remplace) REFERENCES perso_comps (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE perso_comps DROP FOREIGN KEY FK_C52C3CEEC27E42E8');
        $this->addSql('ALTER TABLE perso_comps DROP FOREIGN KEY FK_C52C3CEE5B771352');
        $this->addSql('ALTER TABLE perso_comps DROP FOREIGN KEY FK_C52C3CEE2C7023C4');
        $this->addSql('ALTER TABLE perso_comps DROP FOREIGN KEY FK_C52C3CEEB214B667');
        $this->addSql('ALTER TABLE perso_comps DROP FOREIGN KEY FK_C52C3CEEBF5D3B7B');
        $this->addSql('ALTER TABLE perso_comps DROP FOREIGN KEY FK_C52C3CEE548C9292');
        $this->addSql('DROP TABLE perso_caracs');
        $this->addSql('DROP TABLE perso_comps');
        $this->addSql('DROP TABLE site_faqs');
        $this->addSql('DROP TABLE site_params');
        $this->addSql('DROP TABLE user');
    }
}
