<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181127225546 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE producto (id INT AUTO_INCREMENT NOT NULL, detalle_factura_id INT NOT NULL, barcode VARCHAR(35) NOT NULL, nombre VARCHAR(100) NOT NULL, is_iva TINYINT(1) NOT NULL, fch_ingreso DATETIME NOT NULL, cant_pack INT NOT NULL, cant_unit INT NOT NULL, cant_total INT NOT NULL, precio_pack DOUBLE PRECISION NOT NULL, precio_unit DOUBLE PRECISION NOT NULL, INDEX IDX_A7BB061586B2547E (detalle_factura_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE empresa (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, direccion VARCHAR(100) NOT NULL, ciudad VARCHAR(50) NOT NULL, telefono VARCHAR(15) NOT NULL, email VARCHAR(50) NOT NULL, iva DOUBLE PRECISION NOT NULL, logo VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detalle_factura (id INT AUTO_INCREMENT NOT NULL, factura_id INT NOT NULL, producto VARCHAR(35) NOT NULL, cantidad INT NOT NULL, precio DOUBLE PRECISION NOT NULL, INDEX IDX_B1354EA1F04F795F (factura_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE factura (id INT AUTO_INCREMENT NOT NULL, cliente_id INT NOT NULL, vendedor_id INT NOT NULL, numero_factura INT NOT NULL, fecha_at DATETIME NOT NULL, total_venta DOUBLE PRECISION NOT NULL, estado_factura TINYINT(1) NOT NULL, INDEX IDX_F9EBA009DE734E51 (cliente_id), INDEX IDX_F9EBA0098361A8B8 (vendedor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB061586B2547E FOREIGN KEY (detalle_factura_id) REFERENCES detalle_factura (id)');
        $this->addSql('ALTER TABLE detalle_factura ADD CONSTRAINT FK_B1354EA1F04F795F FOREIGN KEY (factura_id) REFERENCES factura (id)');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA009DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA0098361A8B8 FOREIGN KEY (vendedor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cliente ADD telefono VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB061586B2547E');
        $this->addSql('ALTER TABLE detalle_factura DROP FOREIGN KEY FK_B1354EA1F04F795F');
        $this->addSql('DROP TABLE producto');
        $this->addSql('DROP TABLE empresa');
        $this->addSql('DROP TABLE detalle_factura');
        $this->addSql('DROP TABLE factura');
        $this->addSql('ALTER TABLE cliente DROP telefono');
    }
}
