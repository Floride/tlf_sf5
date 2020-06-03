<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200602063630 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE perso_comps ADD remplace_by INT DEFAULT NULL, ADD remplace INT DEFAULT NULL, ADD obsolete TINYINT(1) DEFAULT \'1\' NOT NULL');
        $this->addSql('ALTER TABLE perso_comps ADD CONSTRAINT FK_C52C3CEEBF5D3B7B FOREIGN KEY (remplace_by) REFERENCES perso_comps (id)');
        $this->addSql('ALTER TABLE perso_comps ADD CONSTRAINT FK_C52C3CEE548C9292 FOREIGN KEY (remplace) REFERENCES perso_comps (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C52C3CEEBF5D3B7B ON perso_comps (remplace_by)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C52C3CEE548C9292 ON perso_comps (remplace)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE perso_comps DROP FOREIGN KEY FK_C52C3CEEBF5D3B7B');
        $this->addSql('ALTER TABLE perso_comps DROP FOREIGN KEY FK_C52C3CEE548C9292');
        $this->addSql('DROP INDEX UNIQ_C52C3CEEBF5D3B7B ON perso_comps');
        $this->addSql('DROP INDEX UNIQ_C52C3CEE548C9292 ON perso_comps');
        $this->addSql('ALTER TABLE perso_comps DROP remplace_by, DROP remplace, DROP obsolete');
    }
}
