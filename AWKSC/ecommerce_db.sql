-- Create new ecommerce database and tables

DROP DATABASE IF EXISTS ecommerce_db;
CREATE DATABASE ecommerce_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ecommerce_db;

-- Table structure for produk
DROP TABLE IF EXISTS produk;
CREATE TABLE produk (
  produk_id INT(11) NOT NULL AUTO_INCREMENT,
  nama_produk VARCHAR(255) NOT NULL,
  deskripsi TEXT NOT NULL,
  harga INT(11) NOT NULL,
  gambar VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (produk_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for pembayaran (payment)
DROP TABLE IF EXISTS pembayaran;
CREATE TABLE pembayaran (
  pembayaran_id INT(11) NOT NULL AUTO_INCREMENT,
  transaksi_id INT(11) NOT NULL,
  pembayaran_tanggal DATETIME NOT NULL,
  pembayaran_metode VARCHAR(50) NOT NULL,
  pembayaran_jumlah INT(11) NOT NULL,
  pembayaran_bukti VARCHAR(255) DEFAULT NULL,
  pembayaran_status ENUM('pending','confirmed','rejected') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (pembayaran_id),
  KEY transaksi_id (transaksi_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for transaksi (transaction)
DROP TABLE IF EXISTS transaksi;
CREATE TABLE transaksi (
  transaksi_id INT(11) NOT NULL AUTO_INCREMENT,
  pelanggan_id INT(11) NOT NULL,
  tanggal_transaksi DATETIME NOT NULL,
  total INT(11) NOT NULL,
  status ENUM('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (transaksi_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add foreign key constraint for pembayaran
ALTER TABLE pembayaran
  ADD CONSTRAINT pembayaran_ibfk_1 FOREIGN KEY (transaksi_id) REFERENCES transaksi (transaksi_id) ON DELETE CASCADE ON UPDATE CASCADE;

-- You can add more tables like pelanggan (customers) as needed
