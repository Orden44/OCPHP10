<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240825104342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create a 2FA Authentication with Email';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE employe ADD auth_code VARCHAR(4) NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE employe DROP COLUMN auth_code');
    }
}
