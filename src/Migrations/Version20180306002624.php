<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180306002624 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE capacity_hs (lvl INT NOT NULL, capacity INT DEFAULT 0 NOT NULL, max_type_item_craft INT DEFAULT 0 NOT NULL, PRIMARY KEY(lvl)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, shortname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE craft (id INT AUTO_INCREMENT NOT NULL, item_source_one_id INT NOT NULL, item_source_two_id INT NOT NULL, item_result_id INT NOT NULL, operation enum(\'OR\', \'AND\'), INDEX IDX_F45C4A84A1C9432E (item_source_one_id), INDEX IDX_F45C4A84CA95A4E1 (item_source_two_id), INDEX IDX_F45C4A84B7DA0B3 (item_result_id), UNIQUE INDEX craft_unique (item_source_one_id, item_source_two_id, operation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_B12D4A36A76ED395 (user_id), INDEX IDX_B12D4A36126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, cost INT NOT NULL, image VARCHAR(255) NOT NULL, isvisible TINYINT(1) DEFAULT \'0\' NOT NULL, isvalid TINYINT(1) DEFAULT \'0\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE items_type (item_id INT NOT NULL, type_item_id INT NOT NULL, INDEX IDX_8B32F9AF126F525E (item_id), INDEX IDX_8B32F9AF3A4E3DAB (type_item_id), PRIMARY KEY(item_id, type_item_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_item (id INT AUTO_INCREMENT NOT NULL, category_item_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, shortname VARCHAR(255) NOT NULL, INDEX IDX_C814E016D5B71220 (category_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', lvl INT DEFAULT 1 NOT NULL, resource INT DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visibility_craft_item (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, craft_id INT NOT NULL, isvalid TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_C65A6C3DA76ED395 (user_id), INDEX IDX_C65A6C3DE836CCC8 (craft_id), UNIQUE INDEX visibility_craft_item_unique (user_id, craft_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE craft ADD CONSTRAINT FK_F45C4A84A1C9432E FOREIGN KEY (item_source_one_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE craft ADD CONSTRAINT FK_F45C4A84CA95A4E1 FOREIGN KEY (item_source_two_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE craft ADD CONSTRAINT FK_F45C4A84B7DA0B3 FOREIGN KEY (item_result_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE items_type ADD CONSTRAINT FK_8B32F9AF126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE items_type ADD CONSTRAINT FK_8B32F9AF3A4E3DAB FOREIGN KEY (type_item_id) REFERENCES type_item (id)');
        $this->addSql('ALTER TABLE type_item ADD CONSTRAINT FK_C814E016D5B71220 FOREIGN KEY (category_item_id) REFERENCES category_item (id)');
        $this->addSql('ALTER TABLE visibility_craft_item ADD CONSTRAINT FK_C65A6C3DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE visibility_craft_item ADD CONSTRAINT FK_C65A6C3DE836CCC8 FOREIGN KEY (craft_id) REFERENCES craft (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE type_item DROP FOREIGN KEY FK_C814E016D5B71220');
        $this->addSql('ALTER TABLE visibility_craft_item DROP FOREIGN KEY FK_C65A6C3DE836CCC8');
        $this->addSql('ALTER TABLE craft DROP FOREIGN KEY FK_F45C4A84A1C9432E');
        $this->addSql('ALTER TABLE craft DROP FOREIGN KEY FK_F45C4A84CA95A4E1');
        $this->addSql('ALTER TABLE craft DROP FOREIGN KEY FK_F45C4A84B7DA0B3');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36126F525E');
        $this->addSql('ALTER TABLE items_type DROP FOREIGN KEY FK_8B32F9AF126F525E');
        $this->addSql('ALTER TABLE items_type DROP FOREIGN KEY FK_8B32F9AF3A4E3DAB');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36A76ED395');
        $this->addSql('ALTER TABLE visibility_craft_item DROP FOREIGN KEY FK_C65A6C3DA76ED395');
        $this->addSql('DROP TABLE capacity_hs');
        $this->addSql('DROP TABLE category_item');
        $this->addSql('DROP TABLE craft');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE items_type');
        $this->addSql('DROP TABLE type_item');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE visibility_craft_item');
    }
}
