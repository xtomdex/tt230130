<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230131073449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE movies_characters DROP INDEX UNIQ_6BDFABF88F93B6FC, ADD INDEX IDX_6BDFABF88F93B6FC (movie_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE movies_characters DROP INDEX IDX_6BDFABF88F93B6FC, ADD UNIQUE INDEX UNIQ_6BDFABF88F93B6FC (movie_id)');
    }
}
