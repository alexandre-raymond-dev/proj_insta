<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221108083816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE user_secure_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE album_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ami_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE follow_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE photo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE test_bool_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_composer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE album (id INT NOT NULL, title VARCHAR(200) NOT NULL, descr VARCHAR(500) DEFAULT NULL, prive BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ami (id INT NOT NULL, ami_id INT NOT NULL, ami2_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, photo_id INT NOT NULL, upload_comment DATE NOT NULL, content VARCHAR(1000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE follow (id INT NOT NULL, follower_id INT NOT NULL, following_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE photo (id INT NOT NULL, album_id INT NOT NULL, title VARCHAR(100) NOT NULL, descr VARCHAR(500) DEFAULT NULL, prive BOOLEAN NOT NULL, user_id INT NOT NULL, upload_photo DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE test_bool (id INT NOT NULL, testing BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, nom VARCHAR(150) NOT NULL, email VARCHAR(150) NOT NULL, mdp VARCHAR(150) NOT NULL, descr VARCHAR(150) NOT NULL, prive BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_composer (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_78FEE2D8F85E0677 ON user_composer (username)');
        $this->addSql('DROP TABLE user_secure');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE album_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ami_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE comment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE follow_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE photo_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE test_bool_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE user_composer_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE user_secure_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_secure (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_538c4139f85e0677 ON user_secure (username)');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE ami');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE follow');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE test_bool');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_composer');
    }
}
