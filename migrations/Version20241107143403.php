<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241107143403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE media_entity (id UUID NOT NULL, ad_id UUID DEFAULT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B251DEB64F34D596 ON media_entity (ad_id)');
        $this->addSql('COMMENT ON COLUMN media_entity.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN media_entity.ad_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE media_entity ADD CONSTRAINT FK_B251DEB64F34D596 FOREIGN KEY (ad_id) REFERENCES media_entity (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE media_entity DROP CONSTRAINT FK_B251DEB64F34D596');
        $this->addSql('DROP TABLE media_entity');
    }
}
