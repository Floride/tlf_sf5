<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200529124113 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE perso_comps ADD carac_2 INT DEFAULT NULL, ADD carac_3 INT DEFAULT NULL, ADD carac_4 INT DEFAULT NULL');
        $this->addSql('ALTER TABLE perso_comps ADD CONSTRAINT FK_C52C3CEE5B771352 FOREIGN KEY (carac_2) REFERENCES perso_caracs (id)');
        $this->addSql('ALTER TABLE perso_comps ADD CONSTRAINT FK_C52C3CEE2C7023C4 FOREIGN KEY (carac_3) REFERENCES perso_caracs (id)');
        $this->addSql('ALTER TABLE perso_comps ADD CONSTRAINT FK_C52C3CEEB214B667 FOREIGN KEY (carac_4) REFERENCES perso_caracs (id)');
        $this->addSql('CREATE INDEX IDX_C52C3CEE5B771352 ON perso_comps (carac_2)');
        $this->addSql('CREATE INDEX IDX_C52C3CEE2C7023C4 ON perso_comps (carac_3)');
        $this->addSql('CREATE INDEX IDX_C52C3CEEB214B667 ON perso_comps (carac_4)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE perso_comps DROP FOREIGN KEY FK_C52C3CEE5B771352');
        $this->addSql('ALTER TABLE perso_comps DROP FOREIGN KEY FK_C52C3CEE2C7023C4');
        $this->addSql('ALTER TABLE perso_comps DROP FOREIGN KEY FK_C52C3CEEB214B667');
        $this->addSql('DROP INDEX IDX_C52C3CEE5B771352 ON perso_comps');
        $this->addSql('DROP INDEX IDX_C52C3CEE2C7023C4 ON perso_comps');
        $this->addSql('DROP INDEX IDX_C52C3CEEB214B667 ON perso_comps');
        $this->addSql('ALTER TABLE perso_comps DROP carac_2, DROP carac_3, DROP carac_4');
    }
}
