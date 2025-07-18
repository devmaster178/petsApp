<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250701220658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE breed (id INT AUTO_INCREMENT NOT NULL, pet_type_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, is_dangerous TINYINT(1) DEFAULT 0 NOT NULL, INDEX IDX_F8AF884FDB020C75 (pet_type_id), INDEX IDX_F8AF884F5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pet (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, breed_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, has_dob_information VARCHAR(255) DEFAULT NULL, date_of_birth DATE DEFAULT NULL, age INT DEFAULT NULL, sex VARCHAR(255) DEFAULT NULL, breed_choice VARCHAR(255) DEFAULT NULL, breed_other LONGTEXT DEFAULT NULL, INDEX IDX_E4529B85C54C8C93 (type_id), INDEX IDX_E4529B85A8B4A30F (breed_id), INDEX IDX_E4529B855E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pet_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE breed ADD CONSTRAINT FK_F8AF884FDB020C75 FOREIGN KEY (pet_type_id) REFERENCES pet_type (id)');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B85C54C8C93 FOREIGN KEY (type_id) REFERENCES pet_type (id)');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B85A8B4A30F FOREIGN KEY (breed_id) REFERENCES breed (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE breed DROP FOREIGN KEY FK_F8AF884FDB020C75');
        $this->addSql('ALTER TABLE pet DROP FOREIGN KEY FK_E4529B85C54C8C93');
        $this->addSql('ALTER TABLE pet DROP FOREIGN KEY FK_E4529B85A8B4A30F');
        $this->addSql('DROP TABLE breed');
        $this->addSql('DROP TABLE pet');
        $this->addSql('DROP TABLE pet_type');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
