<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221023155148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE users_userid_seq CASCADE');
        $this->addSql('DROP SEQUENCE album_albumid_seq CASCADE');
        $this->addSql('DROP SEQUENCE photo_photoid_seq CASCADE');
        $this->addSql('DROP SEQUENCE photo_albumid_seq CASCADE');
        $this->addSql('DROP SEQUENCE photo_userid_seq CASCADE');
        $this->addSql('DROP SEQUENCE follow_followid_seq CASCADE');
        $this->addSql('DROP SEQUENCE follow_followerid_seq CASCADE');
        $this->addSql('DROP SEQUENCE follow_followingid_seq CASCADE');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "users" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, username VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, prive INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "users" (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE follow DROP CONSTRAINT fk_follower');
        $this->addSql('ALTER TABLE follow DROP CONSTRAINT fk_following');
        $this->addSql('ALTER TABLE photo DROP CONSTRAINT fk_user');
        $this->addSql('ALTER TABLE photo DROP CONSTRAINT fk_album');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE follow');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE users');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('CREATE SEQUENCE users_userid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE album_albumid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE photo_photoid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE photo_albumid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE photo_userid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE follow_followid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE follow_followerid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE follow_followingid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE album (albumid SERIAL NOT NULL, title VARCHAR(200) DEFAULT NULL, descr VARCHAR(500) DEFAULT NULL, prive INT NOT NULL, PRIMARY KEY(albumid))');
        $this->addSql('CREATE TABLE follow (followid SERIAL NOT NULL, followerid SERIAL NOT NULL, followingid SERIAL NOT NULL, PRIMARY KEY(followid))');
        $this->addSql('CREATE INDEX IDX_6834447060C68EA1 ON follow (followerid)');
        $this->addSql('CREATE INDEX IDX_683444705963495D ON follow (followingid)');
        $this->addSql('CREATE TABLE photo (photoid SERIAL NOT NULL, albumid SERIAL NOT NULL, userid SERIAL NOT NULL, title VARCHAR(100) DEFAULT NULL, descr VARCHAR(500) DEFAULT NULL, prive INT NOT NULL, uploadphoto DATE NOT NULL, PRIMARY KEY(photoid))');
        $this->addSql('CREATE INDEX IDX_14B78418F132696E ON photo (userid)');
        $this->addSql('CREATE INDEX IDX_14B78418CE670E51 ON photo (albumid)');
        $this->addSql('CREATE TABLE users (userid SERIAL NOT NULL, nom VARCHAR(150) NOT NULL, email VARCHAR(150) NOT NULL, mdp VARCHAR(150) NOT NULL, descr VARCHAR(500) DEFAULT NULL, prive INT NOT NULL, PRIMARY KEY(userid))');
        $this->addSql('ALTER TABLE follow ADD CONSTRAINT fk_follower FOREIGN KEY (followerid) REFERENCES users (userid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE follow ADD CONSTRAINT fk_following FOREIGN KEY (followingid) REFERENCES users (userid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT fk_user FOREIGN KEY (userid) REFERENCES users (userid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT fk_album FOREIGN KEY (albumid) REFERENCES album (albumid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE "users"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
