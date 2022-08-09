<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220808121845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shots_statistics (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, team_id SMALLINT NOT NULL, shots_count SMALLINT DEFAULT 0 NOT NULL, shot_time DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE shots_team (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, team_name VARCHAR(100) NOT NULL, color VARCHAR(8) NOT NULL, shots_count SMALLINT DEFAULT 0 NOT NULL, created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, shot_time DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE shots_statistics');
        $this->addSql('DROP TABLE shots_team');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
