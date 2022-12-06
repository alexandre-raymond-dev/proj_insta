<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221205175207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo DROP CONSTRAINT fk_user');
        $this->addSql('DROP SEQUENCE album_albumid_seq CASCADE');
        $this->addSql('DROP SEQUENCE follow_followid_seq CASCADE');
        $this->addSql('DROP SEQUENCE follow_followerid_seq CASCADE');
        $this->addSql('DROP SEQUENCE follow_followingid_seq CASCADE');
        $this->addSql('DROP SEQUENCE photo_photoid_seq CASCADE');
        $this->addSql('DROP SEQUENCE photo_albumid_seq CASCADE');
        $this->addSql('DROP SEQUENCE photo_userid_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE profile_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE comment_commentid_seq CASCADE');
        $this->addSql('DROP SEQUENCE comment_photoid_seq CASCADE');
        $this->addSql('ALTER TABLE follow DROP CONSTRAINT fk_follower');
        $this->addSql('ALTER TABLE follow DROP CONSTRAINT fk_following');
        $this->addSql('ALTER TABLE profile DROP CONSTRAINT fk_8157aa0fccfa12b8');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT fk_photo');
        $this->addSql('DROP TABLE follow');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP INDEX "primary"');
        $this->addSql('ALTER TABLE album ADD description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE album ADD view INT NOT NULL');
        $this->addSql('ALTER TABLE album DROP albumid');
        $this->addSql('ALTER TABLE album DROP descr');
        $this->addSql('ALTER TABLE album ALTER title SET NOT NULL');
        $this->addSql('ALTER TABLE album ALTER title TYPE VARCHAR(120)');
        $this->addSql('ALTER TABLE album RENAME COLUMN prive TO id');
        $this->addSql('ALTER TABLE album ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE album_photo ADD CONSTRAINT FK_620FCE3E1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE album_photo ADD CONSTRAINT FK_620FCE3E7E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP INDEX IDX_14B78418F132696E');
        $this->addSql('DROP INDEX "primary"');
        $this->addSql('ALTER TABLE photo ADD description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE photo ADD privacy VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE photo ADD upload_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE photo ADD view INT NOT NULL');
        $this->addSql('ALTER TABLE photo ADD image_path VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE photo DROP photoid');
        $this->addSql('ALTER TABLE photo DROP userid');
        $this->addSql('ALTER TABLE photo DROP albumid');
        $this->addSql('ALTER TABLE photo DROP descr');
        $this->addSql('ALTER TABLE photo DROP uploadphoto');
        $this->addSql('ALTER TABLE photo ALTER title SET NOT NULL');
        $this->addSql('ALTER TABLE photo ALTER title TYPE VARCHAR(120)');
        $this->addSql('ALTER TABLE photo RENAME COLUMN prive TO id');
        $this->addSql('ALTER TABLE photo ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE album_albumid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE follow_followid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE follow_followerid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE follow_followingid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE photo_photoid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE photo_albumid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE photo_userid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE profile_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE comment_commentid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE comment_photoid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE follow (followid SERIAL NOT NULL, followerid SERIAL NOT NULL, followingid SERIAL NOT NULL, PRIMARY KEY(followid))');
        $this->addSql('CREATE INDEX IDX_6834447060C68EA1 ON follow (followerid)');
        $this->addSql('CREATE INDEX IDX_683444705963495D ON follow (followingid)');
        $this->addSql('CREATE TABLE profile (id INT NOT NULL, profile_id INT NOT NULL, adresse VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, genre VARCHAR(255) DEFAULT NULL, anniversaire VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_8157aa0fccfa12b8 ON profile (profile_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, username VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, private INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d649e7927c74 ON "user" (email)');
        $this->addSql('CREATE TABLE comment (commentid SERIAL NOT NULL, photoid SERIAL NOT NULL, uploadcomment DATE NOT NULL, content VARCHAR(1000) DEFAULT NULL, PRIMARY KEY(commentid))');
        $this->addSql('CREATE INDEX IDX_9474526CD7F7AC87 ON comment (photoid)');
        $this->addSql('ALTER TABLE follow ADD CONSTRAINT fk_follower FOREIGN KEY (followerid) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE follow ADD CONSTRAINT fk_following FOREIGN KEY (followingid) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT fk_8157aa0fccfa12b8 FOREIGN KEY (profile_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_photo FOREIGN KEY (photoid) REFERENCES photo (photoid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP INDEX album_pkey');
        $this->addSql('ALTER TABLE album ADD albumid SERIAL NOT NULL');
        $this->addSql('ALTER TABLE album ADD descr VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE album ADD prive INT NOT NULL');
        $this->addSql('ALTER TABLE album DROP id');
        $this->addSql('ALTER TABLE album DROP description');
        $this->addSql('ALTER TABLE album DROP view');
        $this->addSql('ALTER TABLE album ALTER title DROP NOT NULL');
        $this->addSql('ALTER TABLE album ALTER title TYPE VARCHAR(200)');
        $this->addSql('ALTER TABLE album ADD PRIMARY KEY (albumid)');
        $this->addSql('ALTER TABLE album_photo DROP CONSTRAINT FK_620FCE3E1137ABCF');
        $this->addSql('ALTER TABLE album_photo DROP CONSTRAINT FK_620FCE3E7E9E4C8C');
        $this->addSql('DROP INDEX photo_pkey');
        $this->addSql('ALTER TABLE photo ADD photoid SERIAL NOT NULL');
        $this->addSql('ALTER TABLE photo ADD userid SERIAL NOT NULL');
        $this->addSql('ALTER TABLE photo ADD albumid SERIAL NOT NULL');
        $this->addSql('ALTER TABLE photo ADD descr VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE photo ADD prive INT NOT NULL');
        $this->addSql('ALTER TABLE photo ADD uploadphoto DATE NOT NULL');
        $this->addSql('ALTER TABLE photo DROP id');
        $this->addSql('ALTER TABLE photo DROP description');
        $this->addSql('ALTER TABLE photo DROP privacy');
        $this->addSql('ALTER TABLE photo DROP upload_date');
        $this->addSql('ALTER TABLE photo DROP view');
        $this->addSql('ALTER TABLE photo DROP image_path');
        $this->addSql('ALTER TABLE photo ALTER title DROP NOT NULL');
        $this->addSql('ALTER TABLE photo ALTER title TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT fk_user FOREIGN KEY (userid) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_14B78418F132696E ON photo (userid)');
        $this->addSql('ALTER TABLE photo ADD PRIMARY KEY (photoid)');
    }
}
