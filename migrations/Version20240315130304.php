<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240315130304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, finance_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, amount VARCHAR(255) NOT NULL, INDEX IDX_64C19C1727ACA70 (parent_id), INDEX IDX_64C19C15E87A6C2 (finance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE finance (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, finance_id INT DEFAULT NULL, category_id INT DEFAULT NULL, amount NUMERIC(10, 0) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_723705D15E87A6C2 (finance_id), INDEX IDX_723705D112469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C15E87A6C2 FOREIGN KEY (finance_id) REFERENCES finance (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D15E87A6C2 FOREIGN KEY (finance_id) REFERENCES finance (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('INSERT INTO finance (name,  slug) VALUES ("Income", "income")');
        $this->addSql('INSERT INTO category (name,  slug, amount, parent_id, finance_id) VALUES ("Food", "food", \'{"amount":100,"currency":"USD"}\', null, 1)');
        $this->addSql('INSERT INTO category (name,  slug, amount, parent_id, finance_id) VALUES ("Restaurant", "restaurant", \'{"amount":100,"currency":"USD"}\', 1, 1)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C15E87A6C2');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D15E87A6C2');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D112469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE finance');
        $this->addSql('DROP TABLE transaction');
    }
}
