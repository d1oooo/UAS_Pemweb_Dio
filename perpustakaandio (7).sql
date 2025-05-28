-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Bulan Mei 2025 pada 08.58
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaandio`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `NIM` varchar(10) NOT NULL,
  `Nama` varchar(100) DEFAULT NULL,
  `Kelas` varchar(20) DEFAULT NULL,
  `Alamat` text DEFAULT NULL,
  `TTL` date DEFAULT NULL,
  `Jenis_Kelamin` enum('Laki - Laki','Perempuan') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`NIM`, `Nama`, `Kelas`, `Alamat`, `TTL`, `Jenis_Kelamin`) VALUES
('23173039', 'Ananda Dio Pratama Harahap', 'XI RPL', 'Jl. Swadaya No. 3 Tangerang Selatan', '0000-00-00', 'Laki - Laki'),
('23173040', 'Aura Anastasya Putri Fiara', 'XI RPL', 'Griya Hijau Regency, Kedaung, Tangerang Selatan', '2008-03-13', 'Perempuan'),
('23173041', 'Azka Putra Aulia', 'XI RPL', 'Ciputat, Tangerang Selatan', '2008-05-14', 'Laki - Laki');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_buku`
--

CREATE TABLE `data_buku` (
  `Kode_Buku` varchar(10) NOT NULL,
  `Judul_Buku` varchar(100) DEFAULT NULL,
  `Pengarang` varchar(100) DEFAULT NULL,
  `Penerbit` varchar(100) DEFAULT NULL,
  `Tahun_Terbit` year(4) DEFAULT NULL,
  `Stok` int(11) DEFAULT 0,
  `Gambar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_buku`
--

INSERT INTO `data_buku` (`Kode_Buku`, `Judul_Buku`, `Pengarang`, `Penerbit`, `Tahun_Terbit`, `Stok`, `Gambar`) VALUES
('BK001', 'Atomic Habits', 'James Clear', 'Penguin Random House', '2018', 9, 'atomic_habits.jpg'),
('BK002', 'Deep Work', 'Cal Newport', 'Grand Central Publishing', '2016', 0, 'deep_work.jpg'),
('BK003', 'The Subtle Art of Not Giving a F*ck', 'Mark Manson', 'HarperOne', '2016', 5, 'the_subtle.jpeg'),
('BK004', 'Rich Dad Poor Dad', 'Robert T. Kiyosaki', 'Plata Publishing', '1997', 5, 'rich_dad.jpg'),
('BK005', 'Thinking, Fast and Slow', 'Daniel Kahneman', 'Farrar, Straus and Giroux', '2011', 7, 'thinking_fast.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `NIM` varchar(20) NOT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Nickname` varchar(100) DEFAULT NULL,
  `Role` enum('admin','anggota','staf') DEFAULT 'anggota',
  `Status` enum('aktif','tidak aktif') DEFAULT 'tidak aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`NIM`, `Password`, `Nickname`, `Role`, `Status`) VALUES
('23173039', 'dioganteng', 'Ananda Dio Pratama Harahap', 'anggota', 'aktif'),
('23173040', '123', 'Aura Anastasya Putri Fiara', 'anggota', 'aktif'),
('23173041', '123', 'Azka Putra Aulia', 'anggota', 'aktif'),
('23173045', '123', 'Iqbal Hilmi Wibowo', 'anggota', 'aktif'),
('23173063', '123', 'Safdiza Azizi', 'anggota', 'aktif'),
('23173080', '123', 'Dimas Aryo Witjaksono', 'anggota', 'aktif'),
('23173090', '123', 'Rafi Sauqi', 'anggota', 'aktif'),
('admindio', 'dioganteng', 'Ananda Dio Pratama Harahap', 'admin', 'aktif'),
('stafdio', '123', 'Ananda Dio Pratama Harahap', 'staf', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjam`
--

CREATE TABLE `peminjam` (
  `Id_Peminjam` int(11) NOT NULL,
  `NIM` varchar(10) DEFAULT NULL,
  `Kode_Buku` varchar(10) DEFAULT NULL,
  `Tgl_Peminjaman` date DEFAULT NULL,
  `Tgl_Pengembalian` date DEFAULT NULL,
  `Tgl_Pengembalian_Real` date DEFAULT NULL,
  `Denda` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjam`
--

INSERT INTO `peminjam` (`Id_Peminjam`, `NIM`, `Kode_Buku`, `Tgl_Peminjaman`, `Tgl_Pengembalian`, `Tgl_Pengembalian_Real`, `Denda`) VALUES
(25, '23173039', 'BK004', '2025-05-28', '2025-05-29', NULL, 0),
(35, '23173040', 'BK005', '2025-05-28', '2025-06-04', NULL, 0),
(40, '23173041', 'BK001', '2025-05-28', '2025-05-30', NULL, 0),
(41, '23173039', 'BK001', '2025-05-28', '2025-06-04', NULL, 0);

--
-- Trigger `peminjam`
--
DELIMITER $$
CREATE TRIGGER `after_insert_peminjam` AFTER INSERT ON `peminjam` FOR EACH ROW BEGIN
  DECLARE tglKembali DATE;
  SET tglKembali = DATE_ADD(NEW.Tgl_Peminjaman, INTERVAL 7 DAY);

  INSERT INTO riwayat_peminjaman (NIM, Kode_Buku, Tgl_Peminjaman, Tgl_Pengembalian, Status)
  VALUES (
    NEW.NIM,
    NEW.Kode_Buku,
    NEW.Tgl_Peminjaman,
    tglKembali,
    'Dalam Proses'
  );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_pengembalian` AFTER UPDATE ON `peminjam` FOR EACH ROW BEGIN
    IF NEW.Tgl_Pengembalian IS NOT NULL THEN
        UPDATE riwayat_peminjaman
        SET Tgl_Pengembalian = NEW.Tgl_Pengembalian,
            Status = 'Selesai'
        WHERE NIM = NEW.NIM AND Kode_Buku = NEW.Kode_Buku AND Status = 'Dalam Proses';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cek_stok_sebelum_pinjam` BEFORE INSERT ON `peminjam` FOR EACH ROW BEGIN
    DECLARE jumlah_stok INT;

    
    SELECT Stok INTO jumlah_stok FROM data_Buku WHERE Kode_Buku = NEW.Kode_Buku;

    
    IF jumlah_stok <= 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Peminjaman gagal: Stok buku habis!';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `kurangi_stok` AFTER INSERT ON `peminjam` FOR EACH ROW BEGIN
    UPDATE data_Buku
    SET Stok = Stok - 1
    WHERE Kode_Buku = NEW.Kode_Buku;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tambah_stok` AFTER UPDATE ON `peminjam` FOR EACH ROW BEGIN
    IF NEW.Tgl_Pengembalian IS NOT NULL AND OLD.Tgl_Pengembalian IS NULL THEN
        UPDATE data_Buku
        SET Stok = Stok + 1
        WHERE Kode_Buku = NEW.Kode_Buku;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_peminjaman`
--

CREATE TABLE `riwayat_peminjaman` (
  `Id_Riwayat` int(11) NOT NULL,
  `NIM` varchar(10) DEFAULT NULL,
  `Kode_Buku` varchar(10) DEFAULT NULL,
  `Tgl_Peminjaman` date DEFAULT NULL,
  `Tgl_Pengembalian` date DEFAULT NULL,
  `Status` enum('Dalam Proses','Selesai') DEFAULT NULL,
  `Denda` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayat_peminjaman`
--

INSERT INTO `riwayat_peminjaman` (`Id_Riwayat`, `NIM`, `Kode_Buku`, `Tgl_Peminjaman`, `Tgl_Pengembalian`, `Status`, `Denda`) VALUES
(29, '23173039', 'BK001', '2025-05-28', '2025-06-12', 'Selesai', 35000),
(30, '23173040', 'BK005', '2025-05-28', '2025-06-06', 'Selesai', 5000),
(31, '23173039', 'BK005', '2025-05-28', '2025-06-06', 'Selesai', 5000),
(32, '23173039', 'BK005', '2025-05-28', '2025-06-04', 'Selesai', 0),
(33, '23173040', 'BK005', '2025-05-28', '2025-06-07', 'Selesai', 5000),
(34, '23173041', 'BK001', '2025-05-28', '2025-05-30', 'Selesai', 0),
(35, '23173039', 'BK001', '2025-05-28', '2025-07-03', 'Selesai', 145000),
(36, '23173041', 'BK005', '2025-05-28', '2025-05-30', 'Selesai', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`NIM`);

--
-- Indeks untuk tabel `data_buku`
--
ALTER TABLE `data_buku`
  ADD PRIMARY KEY (`Kode_Buku`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`NIM`);

--
-- Indeks untuk tabel `peminjam`
--
ALTER TABLE `peminjam`
  ADD PRIMARY KEY (`Id_Peminjam`),
  ADD KEY `NIM` (`NIM`),
  ADD KEY `Kode_Buku` (`Kode_Buku`);

--
-- Indeks untuk tabel `riwayat_peminjaman`
--
ALTER TABLE `riwayat_peminjaman`
  ADD PRIMARY KEY (`Id_Riwayat`),
  ADD KEY `NIM` (`NIM`),
  ADD KEY `Kode_Buku` (`Kode_Buku`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `peminjam`
--
ALTER TABLE `peminjam`
  MODIFY `Id_Peminjam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `riwayat_peminjaman`
--
ALTER TABLE `riwayat_peminjaman`
  MODIFY `Id_Riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `peminjam`
--
ALTER TABLE `peminjam`
  ADD CONSTRAINT `peminjam_ibfk_1` FOREIGN KEY (`NIM`) REFERENCES `anggota` (`NIM`),
  ADD CONSTRAINT `peminjam_ibfk_2` FOREIGN KEY (`Kode_Buku`) REFERENCES `data_buku` (`Kode_Buku`);

--
-- Ketidakleluasaan untuk tabel `riwayat_peminjaman`
--
ALTER TABLE `riwayat_peminjaman`
  ADD CONSTRAINT `riwayat_peminjaman_ibfk_1` FOREIGN KEY (`NIM`) REFERENCES `anggota` (`NIM`),
  ADD CONSTRAINT `riwayat_peminjaman_ibfk_2` FOREIGN KEY (`Kode_Buku`) REFERENCES `data_buku` (`Kode_Buku`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
