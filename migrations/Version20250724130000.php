<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250724130000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add user table and appointment_user join table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE appointments_users (appointments_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(appointments_id, user_id), CONSTRAINT FK_3F1B4D2E1DF6B064 FOREIGN KEY (appointments_id) REFERENCES appointments (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3F1B4D2EA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3F1B4D2E1DF6B064 ON appointments_users (appointments_id)');
        $this->addSql('CREATE INDEX IDX_3F1B4D2EA76ED395 ON appointments_users (user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE appointments_users');
        $this->addSql('DROP TABLE "user"');
    }
}
