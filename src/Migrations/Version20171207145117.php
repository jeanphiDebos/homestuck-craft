<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171207145117 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE capacity_hs (lvl INT NOT NULL, capacity INT DEFAULT 0 NOT NULL, max_type_object_craft INT DEFAULT 0 NOT NULL, PRIMARY KEY(lvl)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE craft (object_source_one_id INT NOT NULL, object_source_two_id INT NOT NULL, object_result_id INT NOT NULL, INDEX IDX_F45C4A849E546587 (object_source_one_id), INDEX IDX_F45C4A84F5088248 (object_source_two_id), INDEX IDX_F45C4A84441889C4 (object_result_id), PRIMARY KEY(object_source_one_id, object_source_two_id, object_result_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE craft ADD CONSTRAINT FK_F45C4A849E546587 FOREIGN KEY (object_source_one_id) REFERENCES object (id)');
        $this->addSql('ALTER TABLE craft ADD CONSTRAINT FK_F45C4A84F5088248 FOREIGN KEY (object_source_two_id) REFERENCES object (id)');
        $this->addSql('ALTER TABLE craft ADD CONSTRAINT FK_F45C4A84441889C4 FOREIGN KEY (object_result_id) REFERENCES object (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE capacity_hs');
        $this->addSql('DROP TABLE craft');
    }
}
