<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190429103123 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_140AB620D663094A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__page AS SELECT id, comic_id, image FROM page');
        $this->addSql('DROP TABLE page');
        $this->addSql('CREATE TABLE page (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, comic_id INTEGER NOT NULL, image CLOB NOT NULL COLLATE BINARY, height INTEGER NOT NULL, width INTEGER NOT NULL, type VARCHAR(25) NOT NULL, CONSTRAINT FK_140AB620D663094A FOREIGN KEY (comic_id) REFERENCES comic (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO page (id, comic_id, image) SELECT id, comic_id, image FROM __temp__page');
        $this->addSql('DROP TABLE __temp__page');
        $this->addSql('CREATE INDEX IDX_140AB620D663094A ON page (comic_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_140AB620D663094A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__page AS SELECT id, comic_id, image FROM page');
        $this->addSql('DROP TABLE page');
        $this->addSql('CREATE TABLE page (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, comic_id INTEGER NOT NULL, image CLOB NOT NULL)');
        $this->addSql('INSERT INTO page (id, comic_id, image) SELECT id, comic_id, image FROM __temp__page');
        $this->addSql('DROP TABLE __temp__page');
        $this->addSql('CREATE INDEX IDX_140AB620D663094A ON page (comic_id)');
    }
}
