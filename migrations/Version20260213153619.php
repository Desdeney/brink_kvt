<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213153619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment_document (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, appointment_id INTEGER NOT NULL, filename VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, uploaded_at DATETIME NOT NULL, CONSTRAINT FK_ED4D01BEE5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointments (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_ED4D01BEE5B533F9 ON appointment_document (appointment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE appointment_document');
    }
}
