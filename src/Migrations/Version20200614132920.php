<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200614132920 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE g_geo_place DROP FOREIGN KEY FK_C8678FDE727ACA70');
        $this->addSql('DROP INDEX IDX_C8678FDE727ACA70 ON g_geo_place');
        $this->addSql('ALTER TABLE g_geo_place CHANGE parent_id parent INT DEFAULT NULL');
        $this->addSql('ALTER TABLE g_geo_place ADD CONSTRAINT FK_C8678FDE3D8E604F FOREIGN KEY (parent) REFERENCES g_geo_place (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_C8678FDE3D8E604F ON g_geo_place (parent)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE g_geo_place DROP FOREIGN KEY FK_C8678FDE3D8E604F');
        $this->addSql('DROP INDEX IDX_C8678FDE3D8E604F ON g_geo_place');
        $this->addSql('ALTER TABLE g_geo_place CHANGE parent parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE g_geo_place ADD CONSTRAINT FK_C8678FDE727ACA70 FOREIGN KEY (parent_id) REFERENCES g_geo_place (id)');
        $this->addSql('CREATE INDEX IDX_C8678FDE727ACA70 ON g_geo_place (parent_id)');
    }
}
