<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191015114211 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD coordonnees VARCHAR(50) DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE code_postal code_postal VARCHAR(10) DEFAULT NULL, CHANGE ville ville VARCHAR(50) DEFAULT NULL, CHANGE txt_profil txt_profil VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP coordonnees, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE code_postal code_postal VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE ville ville VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE txt_profil txt_profil VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
