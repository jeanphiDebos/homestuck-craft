<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171207134220 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category_object (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, shortname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory (user_id INT NOT NULL, object_id INT NOT NULL, count INT DEFAULT 1 NOT NULL, INDEX IDX_B12D4A36A76ED395 (user_id), INDEX IDX_B12D4A36232D562B (object_id), PRIMARY KEY(user_id, object_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE object (id INT AUTO_INCREMENT NOT NULL, type_object_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, isvalid TINYINT(1) DEFAULT \'0\', INDEX IDX_A8ADABEC97EB173B (type_object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_object (id INT AUTO_INCREMENT NOT NULL, category_object_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, shortname VARCHAR(255) NOT NULL, INDEX IDX_8B7AC0D4E44D841B (category_object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, lvl INT DEFAULT 1 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visibility_object (user_id INT NOT NULL, object_id INT NOT NULL, isvalid TINYINT(1) DEFAULT \'0\', INDEX IDX_A5355299A76ED395 (user_id), INDEX IDX_A5355299232D562B (object_id), PRIMARY KEY(user_id, object_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36232D562B FOREIGN KEY (object_id) REFERENCES object (id)');
        $this->addSql('ALTER TABLE object ADD CONSTRAINT FK_A8ADABEC97EB173B FOREIGN KEY (type_object_id) REFERENCES type_object (id)');
        $this->addSql('ALTER TABLE type_object ADD CONSTRAINT FK_8B7AC0D4E44D841B FOREIGN KEY (category_object_id) REFERENCES category_object (id)');
        $this->addSql('ALTER TABLE visibility_object ADD CONSTRAINT FK_A5355299A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE visibility_object ADD CONSTRAINT FK_A5355299232D562B FOREIGN KEY (object_id) REFERENCES object (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE type_object DROP FOREIGN KEY FK_8B7AC0D4E44D841B');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36232D562B');
        $this->addSql('ALTER TABLE visibility_object DROP FOREIGN KEY FK_A5355299232D562B');
        $this->addSql('ALTER TABLE object DROP FOREIGN KEY FK_A8ADABEC97EB173B');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36A76ED395');
        $this->addSql('ALTER TABLE visibility_object DROP FOREIGN KEY FK_A5355299A76ED395');
        $this->addSql('DROP TABLE category_object');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE object');
        $this->addSql('DROP TABLE type_object');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE visibility_object');
    }
}
