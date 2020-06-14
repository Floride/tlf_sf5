<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200612183010 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE g_geo_luminary ADD around INT DEFAULT NULL');
        $this->addSql('ALTER TABLE g_geo_luminary ADD CONSTRAINT FK_597F60C671A66075 FOREIGN KEY (around) REFERENCES g_geo_luminary (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_597F60C671A66075 ON g_geo_luminary (around)');
        $this->addSql('ALTER TABLE g_geo_place ADD luminary_id INT DEFAULT NULL, ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE g_geo_place ADD CONSTRAINT FK_C8678FDE57A58D70 FOREIGN KEY (luminary_id) REFERENCES g_geo_luminary (id)');
        $this->addSql('ALTER TABLE g_geo_place ADD CONSTRAINT FK_C8678FDE727ACA70 FOREIGN KEY (parent_id) REFERENCES g_geo_place (id)');
        $this->addSql('CREATE INDEX IDX_C8678FDE57A58D70 ON g_geo_place (luminary_id)');
        $this->addSql('CREATE INDEX IDX_C8678FDE727ACA70 ON g_geo_place (parent_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE g_geo_luminary DROP FOREIGN KEY FK_597F60C671A66075');
        $this->addSql('DROP INDEX IDX_597F60C671A66075 ON g_geo_luminary');
        $this->addSql('ALTER TABLE g_geo_luminary DROP around');
        $this->addSql('ALTER TABLE g_geo_place DROP FOREIGN KEY FK_C8678FDE57A58D70');
        $this->addSql('ALTER TABLE g_geo_place DROP FOREIGN KEY FK_C8678FDE727ACA70');
        $this->addSql('DROP INDEX IDX_C8678FDE57A58D70 ON g_geo_place');
        $this->addSql('DROP INDEX IDX_C8678FDE727ACA70 ON g_geo_place');
        $this->addSql('ALTER TABLE g_geo_place DROP luminary_id, DROP parent_id');
    }
}
