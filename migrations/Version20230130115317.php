<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230130115317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates characters, movies and movies&characters tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE characters (id INT NOT NULL, name VARCHAR(255) NOT NULL, height INT NOT NULL, mass INT NOT NULL, gender VARCHAR(3) NOT NULL, picture VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movies_characters (character_id INT NOT NULL, movie_id INT NOT NULL, INDEX IDX_6BDFABF81136BE75 (character_id), UNIQUE INDEX UNIQ_6BDFABF88F93B6FC (movie_id), PRIMARY KEY(character_id, movie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movies (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movies_characters ADD CONSTRAINT FK_6BDFABF81136BE75 FOREIGN KEY (character_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE movies_characters ADD CONSTRAINT FK_6BDFABF88F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE movies_characters DROP FOREIGN KEY FK_6BDFABF81136BE75');
        $this->addSql('ALTER TABLE movies_characters DROP FOREIGN KEY FK_6BDFABF88F93B6FC');
        $this->addSql('DROP TABLE characters');
        $this->addSql('DROP TABLE movies_characters');
        $this->addSql('DROP TABLE movies');
    }
}
