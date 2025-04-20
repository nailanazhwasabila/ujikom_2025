-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Apr 2025 pada 22.52
-- Versi server: 10.3.16-MariaDB
-- Versi PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todolist`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `status_task` enum('Biasa','Cukup','Penting') DEFAULT 'Cukup',
  `status_completed` enum('Selesai','Belum Selesai') DEFAULT 'Belum Selesai',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `task_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(16, 'narto', '$2y$10$2ZA89PmFK4VwRBOivwj7T.pX5Rb8rgf1FmlTvMcY7HHOiB2EIDl/2'),
(17, 'nara', '$2y$10$zSfBAqRYC7f2SeMtKT0zNuxGv7p4u/UcaE71GzXylQThYc3ZHIQwW'),
(18, 'nailanazhwasabila', '$2y$10$L.4pUunU5eicv1DO0X4UNOk13rRaWrLefTHYx9UZE/u93r/vGcFOC'),
(19, 'naila', '$2y$10$neidVsBB2P6yGKXJ3dbyo.qP3OBgrLE.08yY9riJZm5NRbzHwfMwq'),
(20, 'yyy', '$2y$10$EjPJYycac2N.MI448NuJTeMCSQzWIumJKS1XCdtURoCE5t3U5Aiim'),
(21, 'sabrin', '$2y$10$8sCa7tGcOoSUDM7r4EZ8BOieRJqBAz4jCzBucExkao.LlQEqsM3Ne'),
(22, 'abin', '$2y$10$JO6rq/D0IvTEt0us.tWEkunqjng9gdH10htOcsXnCTT/xyCcydu96');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
