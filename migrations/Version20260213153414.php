<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213153414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__appointments AS SELECT id, customer_id, location_id, occasion, date, start_time, end_time, is_confirmed, setup_with_location, teardown_with_location, setup_date, setup_time, teardown_date, teardown_time, attendees_count, attendees_age_from, attendees_age_to, attendees_notes, music_pdf_path, dj_notes, price_dj_hour, price_dj_extention, price_tech, price_approach, deactivated FROM appointments');
        $this->addSql('DROP TABLE appointments');
        $this->addSql('CREATE TABLE appointments (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, location_id INTEGER NOT NULL, occasion VARCHAR(255) DEFAULT NULL, date DATE NOT NULL, start_time TIME NOT NULL, end_time TIME DEFAULT NULL, is_confirmed BOOLEAN DEFAULT NULL, setup_with_location BOOLEAN DEFAULT NULL, teardown_with_location BOOLEAN DEFAULT NULL, setup_date DATE DEFAULT NULL, setup_time TIME DEFAULT NULL, teardown_date DATE DEFAULT NULL, teardown_time TIME DEFAULT NULL, attendees_count INTEGER DEFAULT NULL, attendees_age_from INTEGER DEFAULT NULL, attendees_age_to INTEGER DEFAULT NULL, attendees_notes CLOB DEFAULT NULL, music_pdf_path VARCHAR(255) DEFAULT NULL, dj_notes CLOB DEFAULT NULL, price_dj_hour DOUBLE PRECISION NOT NULL, price_dj_extention DOUBLE PRECISION NOT NULL, price_tech DOUBLE PRECISION NOT NULL, price_approach DOUBLE PRECISION NOT NULL, deactivated BOOLEAN DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_6A41727A9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6A41727A64D218E FOREIGN KEY (location_id) REFERENCES location (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO appointments (id, customer_id, location_id, occasion, date, start_time, end_time, is_confirmed, setup_with_location, teardown_with_location, setup_date, setup_time, teardown_date, teardown_time, attendees_count, attendees_age_from, attendees_age_to, attendees_notes, music_pdf_path, dj_notes, price_dj_hour, price_dj_extention, price_tech, price_approach, deactivated) SELECT id, customer_id, location_id, occasion, date, start_time, end_time, is_confirmed, setup_with_location, teardown_with_location, setup_date, setup_time, teardown_date, teardown_time, attendees_count, attendees_age_from, attendees_age_to, attendees_notes, music_pdf_path, dj_notes, price_dj_hour, price_dj_extention, price_tech, price_approach, deactivated FROM __temp__appointments');
        $this->addSql('DROP TABLE __temp__appointments');
        $this->addSql('CREATE INDEX IDX_6A41727A9395C3F3 ON appointments (customer_id)');
        $this->addSql('CREATE INDEX IDX_6A41727A64D218E ON appointments (location_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6A41727A5F37A13B ON appointments (token)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, username, prename, lastname, roles, password, is_blocked, deleted_at FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(180) DEFAULT NULL, prename VARCHAR(180) DEFAULT NULL, lastname VARCHAR(180) DEFAULT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, is_blocked BOOLEAN NOT NULL, deleted_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO user (id, email, username, prename, lastname, roles, password, is_blocked, deleted_at) SELECT id, email, username, prename, lastname, roles, password, is_blocked, deleted_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__appointments AS SELECT id, customer_id, location_id, occasion, date, start_time, end_time, is_confirmed, setup_with_location, teardown_with_location, setup_date, setup_time, teardown_date, teardown_time, attendees_count, attendees_age_from, attendees_age_to, attendees_notes, music_pdf_path, dj_notes, price_dj_hour, price_dj_extention, price_tech, price_approach, deactivated FROM appointments');
        $this->addSql('DROP TABLE appointments');
        $this->addSql('CREATE TABLE appointments (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, location_id INTEGER NOT NULL, occasion VARCHAR(255) DEFAULT NULL, date DATE NOT NULL, start_time TIME NOT NULL, end_time TIME DEFAULT NULL, is_confirmed BOOLEAN DEFAULT NULL, setup_with_location BOOLEAN DEFAULT NULL, teardown_with_location BOOLEAN DEFAULT NULL, setup_date DATE DEFAULT NULL, setup_time TIME DEFAULT NULL, teardown_date DATE DEFAULT NULL, teardown_time TIME DEFAULT NULL, attendees_count INTEGER DEFAULT NULL, attendees_age_from INTEGER DEFAULT NULL, attendees_age_to INTEGER DEFAULT NULL, attendees_notes CLOB DEFAULT NULL, music_pdf_path VARCHAR(255) DEFAULT NULL, dj_notes CLOB DEFAULT NULL, price_dj_hour DOUBLE PRECISION NOT NULL, price_dj_extention DOUBLE PRECISION NOT NULL, price_tech DOUBLE PRECISION NOT NULL, price_approach DOUBLE PRECISION NOT NULL, deactivated BOOLEAN DEFAULT NULL, CONSTRAINT FK_6A41727A9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6A41727A64D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO appointments (id, customer_id, location_id, occasion, date, start_time, end_time, is_confirmed, setup_with_location, teardown_with_location, setup_date, setup_time, teardown_date, teardown_time, attendees_count, attendees_age_from, attendees_age_to, attendees_notes, music_pdf_path, dj_notes, price_dj_hour, price_dj_extention, price_tech, price_approach, deactivated) SELECT id, customer_id, location_id, occasion, date, start_time, end_time, is_confirmed, setup_with_location, teardown_with_location, setup_date, setup_time, teardown_date, teardown_time, attendees_count, attendees_age_from, attendees_age_to, attendees_notes, music_pdf_path, dj_notes, price_dj_hour, price_dj_extention, price_tech, price_approach, deactivated FROM __temp__appointments');
        $this->addSql('DROP TABLE __temp__appointments');
        $this->addSql('CREATE INDEX IDX_6A41727A9395C3F3 ON appointments (customer_id)');
        $this->addSql('CREATE INDEX IDX_6A41727A64D218E ON appointments (location_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, username, prename, lastname, roles, password, is_blocked, deleted_at FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(180) DEFAULT NULL, prename VARCHAR(180) DEFAULT NULL, lastname VARCHAR(180) DEFAULT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, is_blocked BOOLEAN DEFAULT 0 NOT NULL, deleted_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO user (id, email, username, prename, lastname, roles, password, is_blocked, deleted_at) SELECT id, email, username, prename, lastname, roles, password, is_blocked, deleted_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
