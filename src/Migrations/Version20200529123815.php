<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200529123815 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE perso_comps (id INT AUTO_INCREMENT NOT NULL, carac_1 INT NOT NULL, abreviation VARCHAR(4) NOT NULL, description LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, type SMALLINT DEFAULT 0 NOT NULL, valeur SMALLINT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C52C3CEEC27E42E8 (carac_1), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE perso_comps ADD CONSTRAINT FK_C52C3CEEC27E42E8 FOREIGN KEY (carac_1) REFERENCES perso_caracs (id)');
        $this->addSql('ALTER TABLE user ADD is_banned TINYINT(1) DEFAULT \'0\' NOT NULL, ADD Last_connexion DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE perso_comps');
        $this->addSql('ALTER TABLE user DROP is_banned, DROP Last_connexion');
    }
}
