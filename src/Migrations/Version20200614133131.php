<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200614133131 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE g_geo_place DROP FOREIGN KEY FK_C8678FDE57A58D70');
        $this->addSql('DROP INDEX IDX_C8678FDE57A58D70 ON g_geo_place');
        $this->addSql('ALTER TABLE g_geo_place CHANGE luminary_id luminary INT DEFAULT NULL');
        $this->addSql('ALTER TABLE g_geo_place ADD CONSTRAINT FK_C8678FDEDA426F62 FOREIGN KEY (luminary) REFERENCES g_geo_luminary (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_C8678FDEDA426F62 ON g_geo_place (luminary)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE g_geo_place DROP FOREIGN KEY FK_C8678FDEDA426F62');
        $this->addSql('DROP INDEX IDX_C8678FDEDA426F62 ON g_geo_place');
        $this->addSql('ALTER TABLE g_geo_place CHANGE luminary luminary_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE g_geo_place ADD CONSTRAINT FK_C8678FDE57A58D70 FOREIGN KEY (luminary_id) REFERENCES g_geo_luminary (id)');
        $this->addSql('CREATE INDEX IDX_C8678FDE57A58D70 ON g_geo_place (luminary_id)');
    }
}
