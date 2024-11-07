<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241107152245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE media_entity DROP CONSTRAINT FK_B251DEB64F34D596');
        $this->addSql('ALTER TABLE media_entity ADD CONSTRAINT FK_B251DEB64F34D596 FOREIGN KEY (ad_id) REFERENCES ads (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE media_entity DROP CONSTRAINT fk_b251deb64f34d596');
        $this->addSql('ALTER TABLE media_entity ADD CONSTRAINT fk_b251deb64f34d596 FOREIGN KEY (ad_id) REFERENCES media_entity (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
