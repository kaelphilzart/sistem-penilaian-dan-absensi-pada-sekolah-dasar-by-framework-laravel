-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Agu 2024 pada 19.45
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dias_fix`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absen`
--

CREATE TABLE `absen` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_pengabsen` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `semester` int(11) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absen`
--

INSERT INTO `absen` (`id`, `id_siswa`, `id_pengabsen`, `id_mapel`, `tgl`, `semester`, `status`, `created_at`, `updated_at`) VALUES
(38, 12, 7, 8, '2024-07-15', 1, 'hadir', '2024-07-15 08:25:42', '2024-07-15 08:25:42'),
(39, 12, 21, 19, '2024-07-17', 1, 'izin', '2024-07-16 19:57:58', '2024-07-16 20:03:10'),
(40, 13, 26, 18, '2024-07-23', 1, 'alfa', '2024-07-23 11:25:55', '2024-07-23 11:25:55'),
(41, 14, 7, 21, '2024-07-24', 1, 'izin', '2024-07-24 07:37:37', '2024-07-24 07:37:37'),
(42, 20, 7, 21, '2024-07-24', 1, 'hadir', '2024-07-24 07:37:42', '2024-07-24 07:37:42'),
(43, 15, 7, 21, '2024-07-24', 1, 'hadir', '2024-07-24 07:37:47', '2024-07-24 07:37:47'),
(44, 16, 7, 21, '2024-07-24', 1, 'hadir', '2024-07-24 07:37:48', '2024-07-24 07:37:48'),
(45, 17, 7, 21, '2024-07-24', 1, 'hadir', '2024-07-24 07:37:50', '2024-07-24 07:37:50'),
(46, 18, 7, 21, '2024-07-24', 1, 'hadir', '2024-07-24 07:37:51', '2024-07-24 07:37:51'),
(47, 19, 7, 21, '2024-07-24', 1, 'hadir', '2024-07-24 07:37:55', '2024-07-24 07:37:55'),
(48, 14, 7, 23, '2024-07-24', 1, 'izin', '2024-07-24 07:39:11', '2024-07-24 07:39:11'),
(49, 14, 16, 19, '2024-07-25', 1, 'hadir', '2024-07-24 20:42:48', '2024-07-24 20:42:48'),
(50, 13, 16, 19, '2024-07-25', 1, 'alfa', '2024-07-24 20:44:08', '2024-07-24 20:44:08'),
(51, 14, 7, 23, '2024-07-25', 1, 'hadir', '2024-07-24 20:44:19', '2024-07-24 20:44:19'),
(52, 14, 18, 28, '2024-07-28', 1, 'alfa', '2024-07-28 06:39:30', '2024-07-28 06:39:30'),
(53, 15, 18, 28, '2024-07-28', 1, 'alfa', '2024-07-28 06:55:04', '2024-07-28 06:55:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `eskul`
--

CREATE TABLE `eskul` (
  `id` bigint(20) NOT NULL,
  `nama_eskul` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `eskul`
--

INSERT INTO `eskul` (`id`, `nama_eskul`, `status`, `created_at`, `updated_at`) VALUES
(1, 'pramuka', 'wajib', '2024-06-25 12:27:19', '2024-06-25 12:27:19'),
(2, 'pencak silat', 'tidak wajib', '2024-06-25 12:27:29', '2024-06-25 12:27:29'),
(3, 'voli', 'tidak wajib', '2024-06-25 12:27:37', '2024-06-25 12:27:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `eskul_siswa`
--

CREATE TABLE `eskul_siswa` (
  `id` int(11) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `semester` int(11) DEFAULT NULL,
  `id_eskul` int(11) NOT NULL,
  `predikat` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `eskul_siswa`
--

INSERT INTO `eskul_siswa` (`id`, `nisn`, `id_kelas`, `semester`, `id_eskul`, `predikat`, `keterangan`, `created_at`, `updated_at`) VALUES
(5, '3175346673', 7, 1, 1, 'B', 'bsb', '2024-07-17 18:03:31', '2024-07-17 18:10:09'),
(6, '3163413969', 7, 1, 1, 'B', 'BAIK', '2024-07-24 05:03:35', '2024-07-24 05:03:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(20) NOT NULL,
  `id_user` int(10) UNSIGNED DEFAULT NULL,
  `jenis_guru` varchar(20) DEFAULT NULL,
  `kode_mapel` varchar(20) NOT NULL DEFAULT 'kosong',
  `kelas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`kelas`)),
  `nama_lengkap` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jenis_kelamin` varchar(255) NOT NULL,
  `no_tlp` varchar(15) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `golongan` varchar(50) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id`, `nip`, `id_user`, `jenis_guru`, `kode_mapel`, `kelas`, `nama_lengkap`, `tempat_lahir`, `tgl_lahir`, `jenis_kelamin`, `no_tlp`, `alamat`, `golongan`, `jabatan`, `status`, `created_at`, `updated_at`) VALUES
(7, '198301162014072001', 19, 'wali_kelas', 'kosong', NULL, 'Tanti Setiyowati, S.Pd.SD.', 'Jombang', '1983-01-16', 'wanita', '087678765434', 'Mojowarno Jombang', 'III A', 'guru', 'aktif', '2024-06-19 06:18:22', '2024-06-29 09:29:52'),
(8, '198405202019031004', 20, 'wali_kelas', 'kosong', NULL, 'Solikatin, S. Pd.SD.', 'Jombang', '1984-07-20', 'wanita', '081234367876', 'Kesamben, Jombang', 'III A', 'guru', 'aktif', '2024-06-19 06:23:43', '2024-06-29 09:31:05'),
(9, '199209212019031007', 21, 'wali_kelas', 'kosong', NULL, 'Candra Arga Dinata, S.Pd.I.', 'Jombang', '1992-09-21', 'pria', '082876543345', 'Ngoro, Jombang', 'III A', 'guru', 'aktif', '2024-06-19 06:32:50', '2024-06-29 09:32:00'),
(10, '197312092021211003', 22, 'wali_kelas', 'kosong', NULL, 'Choirul Anwar, S.Pd.SD.', 'Jombang', '1973-12-09', 'pria', '081457689087', 'Kesamben, Jombang', 'III A', 'guru', 'aktif', '2024-06-19 06:35:49', '2024-06-29 09:33:06'),
(11, '198012162021211003', 23, 'wali_kelas', 'kosong', NULL, 'Gatot Subroto, S.Pd.', 'Jombang', '1980-12-16', 'pria', '083675698097', 'Sumobito, Jombang', 'III A', 'guru', 'aktif', '2024-06-19 06:37:29', '2024-06-29 09:36:00'),
(12, '198701282022211009', 24, 'wali_kelas', 'kosong', NULL, 'Tri Setyo Adi Wibowo, S. Pd.', 'Jombang', '1987-01-28', 'pria', '089765456345', 'Kesamben, Jombang', 'III A', 'guru', 'aktif', '2024-06-19 06:41:25', '2024-06-29 09:37:20'),
(13, '197504172017071004', 25, 'wali_kelas', 'kosong', NULL, 'Ruslina Afriani, S. Pd.SD.', 'Jombang', '1975-04-17', 'wanita', '082456765587', 'Mojowarno Jombang', 'III A', 'guru', 'aktif', '2024-06-19 06:50:29', '2024-06-29 09:38:41'),
(14, '199106232015091006', 26, 'wali_kelas', 'kosong', NULL, 'Nur Hidayati, S. Pd.', 'Jombang', '1991-06-23', 'wanita', '081723098008', 'Mojowarno Jombang', 'III A', 'guru', 'aktif', '2024-06-19 06:56:12', '2024-06-29 09:39:44'),
(15, '199004302021071006', 27, 'wali_kelas', 'kosong', NULL, 'Winda Suryo NIngsih, S.Pd.', 'Jombang', '1990-04-30', 'wanita', '082432113446', 'Kesamben, Jombang', 'III A', 'guru', 'aktif', '2024-06-19 07:00:32', '2024-06-29 09:40:29'),
(16, '19921202015071005', 28, 'guru_mapel', 'kosong', NULL, 'Dewi Sopiyah, S.Pd.', 'Jombang', '1992-12-20', 'wanita', '081224556754', 'Kesamben, Jombang', 'III A', 'guru', 'aktif', '2024-06-19 07:07:02', '2024-07-27 18:37:16'),
(17, '199303272014061007', 29, 'guru_mapel', 'SR2', '[{\"id_kelas\":\"12\"},{\"id_kelas\":\"17\"},{\"id_kelas\":\"18\"},{\"id_kelas\":\"7\"}]', 'Ghustanul Arifin, S.Pd.', 'Jombang', '1993-03-27', 'wanita', '083578865546', 'Sumobito, Jombang', 'III A', 'guru', 'aktif', '2024-06-19 07:10:23', '2024-07-28 08:59:54'),
(18, '199102012016081006', 30, 'guru_mapel', 'kosong', NULL, 'Badruzzaman, S.Pd.I.', 'Jombang', '1991-02-01', 'pria', '081347768765', 'Sumobito, Jombang', 'III A', 'guru', 'aktif', '2024-06-19 07:19:30', '2024-07-28 09:11:07'),
(19, '199803242014071003', 31, 'guru_mapel', 'kosong', NULL, 'Nuri Ria Elisya Herman, S. Pd.', 'Jombang', '1998-03-24', '', '0826658766567', 'Peterongan, Jombang', 'III A', 'guru', 'aktif', '2024-06-19 07:25:29', '2024-06-29 09:53:23'),
(20, '198407202016081003', 32, 'wali_kelas', 'kosong', NULL, 'Chusnul Chotimah, S.Pd.SD.', 'Jombang', '1984-07-20', 'wanita', '081225467658', 'Kesamben, Jombang', 'III A', 'guru', 'aktif', '2024-06-19 07:27:21', '2024-06-29 09:54:22'),
(23, '767686', 65, 'guru_mapel', 'kosong', NULL, 'dani', 'jawa', '2024-07-02', 'pria', '089345786321', 'Gg. Bahagia Jl. KH. Hasyim Asy\'ari banjarmlati mojoroto kota kediri', 'golongan 1', 'guru', 'tidak aktif', '2024-07-22 10:08:26', '2024-07-25 15:10:43'),
(24, '0998876556', NULL, 'wali_kelas', 'kosong', NULL, 'rena', 'jombang', '2024-07-23', 'wanita', '098765432120', 'ngawi', 'golongan 1', 'guru', 'tidak aktif', '2024-07-23 08:22:48', '2024-07-24 20:15:39'),
(27, '78263857', 58, 'wali_kelas', 'kosong', NULL, 'jkj', 'jakarta', '2024-07-25', 'pria', '087367728912', 'Gg. Bahagia Jl. KH. Hasyim Asy\'ari banjarmlati mojoroto kota kediri', 'golongan 1', 'guru', 'tidak aktif', '2024-07-25 14:46:25', '2024-07-25 15:09:56'),
(28, '892739378', 17, 'wali_kelas', 'kosong', NULL, 'zainurrr', 'jawa', '2024-07-27', 'pria', '089345786321', 'Gg. Bahagia Jl. KH. Hasyim Asy\'ari banjarmlati mojoroto kota kediri', 'golongan 1', 'guru', 'aktif', '2024-07-27 09:33:02', '2024-07-27 09:33:02'),
(29, '323453', 68, 'guru_mapel', 'kosong', NULL, 'rene', 'jawa', '2024-07-27', 'wanita', '087367728912', 'sksksk', 'golongan 1', 'guru', 'aktif', '2024-07-27 09:34:33', '2024-07-27 13:49:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kelas` varchar(255) NOT NULL,
  `bagian` varchar(20) NOT NULL,
  `nip_guru` int(11) NOT NULL,
  `id_tahunAjar` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`, `bagian`, `nip_guru`, `id_tahunAjar`, `created_at`, `updated_at`) VALUES
(7, '1', 'A', 7, 19, '2024-06-20 00:58:21', '2024-06-24 01:38:40'),
(8, '2', 'A', 8, 14, '2024-06-20 01:00:48', '2024-06-20 01:01:03'),
(9, '3', 'A', 9, 17, '2024-06-20 01:01:40', '2024-06-20 01:01:40'),
(10, '4', 'A', 10, 16, '2024-06-20 01:02:08', '2024-06-20 01:02:08'),
(11, '5', 'A', 11, 15, '2024-06-20 01:02:26', '2024-06-20 01:02:26'),
(12, '6', 'A', 12, 14, '2024-06-20 01:02:40', '2024-06-20 01:02:40'),
(17, '4', 'c', 6, 26, '2024-07-23 04:20:59', '2024-07-23 04:20:59'),
(18, '1', 'B', 20, 19, '2024-07-23 11:09:06', '2024-07-24 00:56:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kurikulum`
--

CREATE TABLE `kurikulum` (
  `id` int(11) NOT NULL,
  `kode_kurikulum` varchar(20) NOT NULL,
  `nama_kurikulum` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kurikulum`
--

INSERT INTO `kurikulum` (`id`, `kode_kurikulum`, `nama_kurikulum`, `created_at`, `updated_at`) VALUES
(4, 'MDK1', 'MERDEKA BELAJAR', '2024-06-12 10:58:39', '2024-06-12 10:58:39'),
(5, 'MDK2', 'MERDEKA BELAJAR', '2024-06-12 10:59:13', '2024-06-12 10:59:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `level`
--

CREATE TABLE `level` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `level`
--

INSERT INTO `level` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL),
(2, 'guru', NULL, NULL),
(3, 'walimurid', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `id_kurikulum` int(11) NOT NULL,
  `nama_mapel` varchar(50) NOT NULL,
  `nilai_kkm` double NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`id`, `kode`, `id_kurikulum`, `nama_mapel`, `nilai_kkm`, `kategori`, `created_at`, `updated_at`) VALUES
(19, 'AG', 4, 'AGAMA', 65, 'pilihan', '2024-07-16 16:38:29', '2024-07-24 01:27:00'),
(22, 'OLG1', 5, 'OLAHRAGA', 90, 'pilihan', '2024-07-23 10:42:17', '2024-07-24 01:39:13'),
(23, 'PC1', 4, 'PENDIDIKAN PANCASILA', 70, 'inti', '2024-07-24 00:51:15', '2024-07-24 00:51:15'),
(24, 'BI1', 4, 'BAHASA INDONESIA', 70, 'inti', '2024-07-24 00:51:39', '2024-07-24 00:51:39'),
(26, 'MK2', 5, 'MATEMATIKA', 70, 'inti', '2024-07-24 01:02:04', '2024-07-24 01:02:04'),
(28, 'SR2', 5, 'SENI RUPA', 70, 'pilihan', '2024-07-24 01:09:43', '2024-07-24 01:09:43'),
(29, 'BIG1', 5, 'BAHASA INGGRIS', 75, 'pilihan', '2024-07-24 02:32:13', '2024-07-24 02:32:13'),
(30, 'SM1', 4, 'SENI MUSIK', 70, 'pilihan', '2024-07-24 06:37:37', '2024-07-24 06:37:37'),
(31, 'AD', 4, 'jepang', 56, 'pilihan', '2024-07-24 15:24:15', '2024-07-24 15:24:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_02_27_204438_create_table_level', 2),
(6, '2024_02_27_204631_create_table_level', 3),
(7, '2024_03_25_143911_create_guru', 4),
(8, '2024_03_25_222041_create_tahun_ajar', 5),
(9, '2024_03_25_222213_create_kelas', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id` int(11) NOT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `kode_mapel` varchar(20) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `tugas_1` double NOT NULL,
  `tugas_2` double NOT NULL,
  `uts` double NOT NULL,
  `tugas_3` double NOT NULL,
  `tugas_4` double NOT NULL,
  `uas` double NOT NULL,
  `kompetensi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nilai`
--

INSERT INTO `nilai` (`id`, `nisn`, `id_kelas`, `kode_mapel`, `semester`, `tugas_1`, `tugas_2`, `uts`, `tugas_3`, `tugas_4`, `uas`, `kompetensi`, `created_at`, `updated_at`) VALUES
(254, '3163413969', 7, 'SR2', 1, 10, 10, 10, 10, 10, 10, 'galgil', '2024-07-30 16:50:45', '2024-07-30 16:50:45'),
(255, '3166876849', 7, 'SR2', 1, 10, 10, 10, 10, 10, 10, 'galgil', '2024-07-30 16:50:45', '2024-07-30 16:50:45'),
(256, '3163915915', 7, 'SR2', 1, 10, 10, 10, 10, 10, 10, 'galgil', '2024-07-30 16:50:45', '2024-07-30 16:50:45'),
(257, '163636978', 7, 'SR2', 1, 10, 10, 10, 10, 10, 10, 'galgil', '2024-07-30 16:50:45', '2024-07-30 16:50:45'),
(258, '3166895868', 7, 'SR2', 1, 10, 10, 10, 10, 10, 10, 'galgil', '2024-07-30 16:50:45', '2024-07-30 16:50:45'),
(259, '3163441030', 7, 'SR2', 1, 10, 10, 10, 10, 10, 10, 'galgil', '2024-07-30 16:50:45', '2024-07-30 16:50:45'),
(260, '3162200807', 7, 'SR2', 1, 10, 10, 10, 10, 10, 10, 'galgil', '2024-07-30 16:50:45', '2024-07-30 16:50:45'),
(282, '3163413969', 7, 'PC1', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(283, '3163413969', 7, 'BI1', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(284, '3163413969', 7, 'MK2', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(285, '3166876849', 7, 'PC1', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(286, '3166876849', 7, 'BI1', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(287, '3166876849', 7, 'MK2', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(288, '3163915915', 7, 'PC1', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(289, '3163915915', 7, 'BI1', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(290, '3163915915', 7, 'MK2', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(291, '163636978', 7, 'PC1', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(292, '163636978', 7, 'BI1', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(293, '163636978', 7, 'MK2', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(294, '3166895868', 7, 'PC1', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(295, '3166895868', 7, 'BI1', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(296, '3166895868', 7, 'MK2', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(297, '3163441030', 7, 'PC1', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(298, '3163441030', 7, 'BI1', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(299, '3163441030', 7, 'MK2', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(300, '3162200807', 7, 'PC1', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(301, '3162200807', 7, 'BI1', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18'),
(302, '3162200807', 7, 'MK2', 1, 90, 90, 90, 90, 90, 90, 'burung', '2024-07-30 16:52:18', '2024-07-30 16:52:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nisn` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `profile`
--

INSERT INTO `profile` (`id`, `id_user`, `nisn`, `created_at`, `updated_at`) VALUES
(29, 63, 163636978, '2024-07-22 09:18:27', '2024-07-22 09:18:27'),
(30, 64, 3166876849, '2024-07-22 09:26:27', '2024-07-22 09:26:27'),
(31, 66, 3166895868, '2024-07-23 06:32:54', '2024-07-23 06:32:54'),
(32, 67, 3163441030, '2024-07-23 06:35:49', '2024-07-23 06:35:49'),
(33, 70, 3175346673, '2024-07-23 13:57:44', '2024-07-23 13:57:44'),
(34, 71, 3163413969, '2024-07-23 14:49:13', '2024-07-23 14:49:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `raport`
--

CREATE TABLE `raport` (
  `id` int(11) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `kode_mapel` varchar(20) NOT NULL,
  `semester` int(11) DEFAULT NULL,
  `kompetensi` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `raport`
--

INSERT INTO `raport` (`id`, `nisn`, `id_kelas`, `kode_mapel`, `semester`, `kompetensi`, `created_at`, `updated_at`) VALUES
(19, '3175346673', 7, 'AG', 1, 'babi', '2024-07-17 19:50:33', '2024-07-17 19:50:33'),
(20, '12', 7, 'AG', 1, 'lebah', '2024-07-17 19:50:33', '2024-07-17 19:50:33'),
(21, '13', 7, 'AG', 1, 'semut', '2024-07-17 19:50:33', '2024-07-17 19:50:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rombel`
--

CREATE TABLE `rombel` (
  `id` int(11) NOT NULL,
  `tahun_rombel` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rombel`
--

INSERT INTO `rombel` (`id`, `tahun_rombel`, `created_at`, `updated_at`) VALUES
(9, 2023, '2024-06-19 23:24:35', '2024-06-24 07:28:41'),
(11, 2022, '2024-06-19 23:26:02', '2024-06-19 23:26:02'),
(12, 2021, '2024-06-19 23:26:09', '2024-06-19 23:26:09'),
(13, 2020, '2024-06-19 23:26:16', '2024-06-19 23:26:16'),
(14, 2019, '2024-06-19 23:26:23', '2024-06-19 23:26:23'),
(15, 2018, '2024-06-25 00:53:10', '2024-06-25 00:53:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `NISN` varchar(25) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_rombel` int(11) NOT NULL,
  `tempat_lahir` varchar(20) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jenis_kelamin` varchar(50) NOT NULL,
  `asal_sekolah` varchar(50) NOT NULL,
  `nama_ayah` varchar(50) NOT NULL,
  `pekerjaan_ayah` varchar(50) NOT NULL,
  `nama_ibu` varchar(50) NOT NULL,
  `pekerjaan_ibu` varchar(50) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `NISN`, `email`, `nama_siswa`, `id_kelas`, `id_rombel`, `tempat_lahir`, `tgl_lahir`, `jenis_kelamin`, `asal_sekolah`, `nama_ayah`, `pekerjaan_ayah`, `nama_ibu`, `pekerjaan_ibu`, `no_telp`, `alamat`, `status`, `created_at`, `updated_at`) VALUES
(13, '3175346673', 'meiisya9990@gmail.com', 'ADELIA HASNA MUMTAZA', 8, 9, 'Jombang', '2016-07-14', 'perempuan', 'TK PGRI KEDUNGPAPAR', 'HERIYANTO', 'Wiraswasta', 'MASNIAH', 'Wiraswasta', '085785468730', 'watudakon, kesamben jombang', 'aktif', '2023-06-23 23:35:13', '2024-07-24 04:23:13'),
(14, '3163413969', 'reginaldcp93@gmail.com', 'ADINDA GUSFI TAQIYYAH', 7, 9, 'Jombang', '2016-10-01', 'perempuan', 'TK ADE IRMA SURYANI', 'AGUS RIYANTO', 'Petani', 'YUFITA RIRIN ANGGRENI', 'Tidak bekerja', '085850220326', 'watudakon kesamben jombang', 'aktif', '2022-06-23 23:38:38', '2024-07-17 16:45:39'),
(15, '3166876849', 'rawa36677@gmail.com', 'AHMAD DIRGA DWI ABRIZAM', 7, 9, 'GRESIK', '2016-10-10', 'laki - laki', 'TK DAHLIA PGRI', 'MOHAMAD YAKUB', 'Karyawan Swasta', 'NANING SETYAWATI', 'Tidak bekerja', '085536395210', 'watudakon kesamben jombang', 'aktif', '2024-06-23 23:49:10', '2024-07-17 16:45:39'),
(16, '3163915915', 'septianningrum19@gmail.com', 'AHMAD HUSEN', 7, 9, 'Jombang', '2024-06-25', 'laki - laki', 'TK ADE IRMA SURYANI', 'MUCHAMAD LUKMAN NULHAKIM', 'petani', 'Jumaidah', 'Tidak bekerja', '098765432123', 'watudakon  kesamben jombang', 'aktif', '2021-06-24 00:22:41', '2024-07-17 16:45:39'),
(17, '163636978', 'dziazahroannisa@gmail.com', 'AINAYYA FATIYYATURRAHMA', 7, 9, 'Jombang', '2016-05-25', 'perempuan', 'TK ADE IRMA SURYANI', 'JATRIOKO', 'Karyawan Swasta', 'ANI SULISTIYOWATI', 'Tidak bekerja', '085755318185', 'watudakon kesamben jombang', 'aktif', '2024-06-24 05:44:06', '2024-07-17 16:45:39'),
(18, '3166895868', 'editorzal@gmail.com', 'AINUR ROSYID FAIRUS', 7, 9, 'Jombang', '2016-07-16', 'laki - laki', 'TK ADE IRMA SURYANI', 'AGUS WIBOWO', 'Karyawan Swasta', 'ANI SULISTIYOWATI', 'Tidak bekerja', '085236802434', 'jungkir watudakon kesdamben jombang', 'aktif', '2024-06-24 05:52:40', '2024-07-17 16:45:39'),
(19, '3163441030', 'kurop612@gmail.com', 'AISYAH AILA VARISHA', 7, 9, 'Jombang', '2016-05-25', 'laki - laki', 'TK ADE IRMA SURYANI', 'GATOT SETIAWAN', 'Karyawan Swasta', 'Imamatul Khutsiyah', 'Tidak bekerja', '085607549303', 'jungkir watudakon kesamben jombang', 'aktif', '2024-06-24 05:58:42', '2024-07-17 16:45:39'),
(20, '3162200807', 'andiago2000@gmail.com', 'AL DINAR SALAMA ULYA', 7, 9, 'Jombang', '2016-10-20', 'perempuan', 'TK ADE IRMA SURYANI', 'SUYANTO', 'Wiraswasta', 'NOFI NILA WIJAYA', 'Tidak bekerja', '083849277320', 'watudakon kesamben jombang', 'aktif', '2024-06-24 06:03:55', '2024-07-17 16:45:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `skrining`
--

CREATE TABLE `skrining` (
  `id` int(11) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `semester` int(11) DEFAULT NULL,
  `tinggi_badan` double NOT NULL,
  `berat_badan` double NOT NULL,
  `pendengaran` varchar(20) NOT NULL,
  `penglihatan` varchar(20) NOT NULL,
  `gigi` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `skrining`
--

INSERT INTO `skrining` (`id`, `nisn`, `id_kelas`, `semester`, `tinggi_badan`, `berat_badan`, `pendengaran`, `penglihatan`, `gigi`, `created_at`, `updated_at`) VALUES
(11, '12', 7, 1, 20, 71, '71', '71', '71', '2024-07-17 18:52:57', '2024-07-17 18:52:57'),
(12, '13', 7, 1, 20, 72, '72', '72', '72', '2024-07-17 18:52:57', '2024-07-17 18:52:57'),
(17, '3163413969', 7, 1, 120, 70, 'baik', 'baik', 'baik', '2024-07-24 05:04:50', '2024-07-24 05:04:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_ajar`
--

CREATE TABLE `tahun_ajar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahunAjar` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tahun_ajar`
--

INSERT INTO `tahun_ajar` (`id`, `tahunAjar`, `created_at`, `updated_at`) VALUES
(3, '2021/2022', '2024-05-14 21:59:06', '2024-06-28 09:14:54'),
(4, '2022/2023', '2024-05-14 21:59:20', '2024-05-14 21:59:20'),
(6, '2023/2024', '2024-06-24 21:22:24', '2024-06-24 21:22:24'),
(14, '2018/2019', '2024-06-20 00:54:18', '2024-06-20 00:54:18'),
(15, '2019/2020', '2024-06-20 00:54:30', '2024-06-20 00:54:30'),
(16, '2020/2021', '2024-06-20 00:54:40', '2024-06-20 00:54:40'),
(17, '2021/2022', '2024-06-20 00:56:28', '2024-06-20 00:56:28'),
(18, '2022/2023', '2024-06-20 00:56:57', '2024-06-20 00:56:57'),
(19, '2023/2024', '2024-06-20 00:57:15', '2024-06-20 00:57:15'),
(22, '2018/2019', '2024-06-24 06:42:26', '2024-06-24 06:42:26'),
(23, '2019/2020', '2024-06-26 06:09:34', '2024-06-26 06:09:34'),
(24, '2020/2021', '2024-06-26 06:10:11', '2024-06-26 06:10:11'),
(25, '2021/2022', '2024-06-26 06:10:37', '2024-06-26 06:10:37'),
(26, '2022/2023', '2024-06-26 06:10:55', '2024-06-26 06:10:55'),
(27, '2023/2024', '2024-06-26 06:11:16', '2024-06-26 06:11:16'),
(29, '2002', '2024-07-23 04:24:18', '2024-07-23 04:24:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `level`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'dias', 'dias@gmail.com', NULL, '$2y$12$VTJYs9lmt2RQKPmzaNNYpOH7uWsGKZN0zVPmn9CD7.NJ9oYmCVFrC', 3, NULL, '2024-02-28 09:37:16', '2024-02-28 09:37:16'),
(4, 'rizal', 'rizal@gmail.com', NULL, '$2y$12$3STRZG4aAVe4mQkgY00ZJuYRvDX.nB.F7oZyjyuHTSsqx0XBct9F6', 1, NULL, '2024-03-21 16:41:45', '2024-03-21 16:41:45'),
(17, 'M. Zainur Rofiq, M.Pd.I.', 'zainur@gmail.com', NULL, '$2y$12$WOamZ.EyzoeTsGa8CcLCJePYGTlKJNdjT/6MPB.9IxddlJKLufXLO', 2, NULL, '2024-06-19 05:16:50', '2024-06-19 05:16:50'),
(19, 'Tanti Setiyowati, S.Pd.SD.', 'tanti@gmail.com', NULL, '$2y$12$1c1Y9yGvj/zc3qlbCwC92OHAF1esJnTvxMSi2jqWmhdycYaj.Ng1.', 2, NULL, '2024-06-19 05:28:05', '2024-06-19 05:28:05'),
(20, 'Solikatin, S. Pd.SD.', 'solikatin@gmail.com', NULL, '$2y$12$WwP3Lw9/RgiDywCl68hmUOEJWX9mP0aPCTiyypgrFzOY/tpGUrSWG', 2, NULL, '2024-06-19 05:29:09', '2024-07-23 11:54:26'),
(21, 'Candra Arga Dinata, S.Pd.I.', 'candra@gmail.com', NULL, '$2y$12$EIwTpOJ8lr1Klcs18i9ice7xwH4SENBAlCdFCpokCHqJc1zG94TQ6', 2, NULL, '2024-06-19 05:34:16', '2024-06-19 05:39:37'),
(22, 'Choirul Anwar, S.Pd.SD.', 'choirull@gmail.com', NULL, '$2y$12$Ai4NSx1k/iDugoSXKaTLCuYWpFn1ANnT2wo01idCmEwjGsVpCiYbe', 2, NULL, '2024-06-19 05:40:45', '2024-06-19 05:40:45'),
(23, 'Gatot Subroto, S.Pd.', 'gatot@gmail.com', NULL, '$2y$12$QGiDII5TVxH.1jac0yjhRu1PrY74YgME/93KjFIA42dl1r.Z0plqG', 2, NULL, '2024-06-19 05:49:39', '2024-06-19 05:49:39'),
(24, 'Tri Setyo Adi Wibowo, S. Pd.', 'tri@gmail.com', NULL, '$2y$12$Hnza.i3DW493iM1B6IKOk.//iO8jDyKwzh5VB.AELlxU17q59ImOi', 2, NULL, '2024-06-19 05:54:48', '2024-06-19 05:54:48'),
(25, 'Ruslina Afriani, S. Pd.SD.', 'ruslina@gmail.com', NULL, '$2y$12$FGiegMFd1cowL6O3cbI.NeDU8YUFzR9TECC.amaffyX1ehI31miLm', 2, NULL, '2024-06-19 05:55:40', '2024-06-19 05:55:40'),
(26, 'Nur Hidayati, S. Pd.', 'nur@gmail.com', NULL, '$2y$12$LRZlA.yg58C5FjuEHNlIuO.CmxE2Mxhufr6t42fP41eVoyH6vzbXW', 2, NULL, '2024-06-19 05:57:59', '2024-06-19 05:57:59'),
(27, 'Winda Suryo NIngsih, S.Pd.', 'winda@gmail.com', NULL, '$2y$12$cAMBZlVcT4O44ilYbg3d5eE3pJlIESFCMzsYxH1RzRLnB6ofLY7li', 2, NULL, '2024-06-19 05:58:52', '2024-06-19 05:58:52'),
(28, 'Dewi Sopiyah, S.Pd.', 'dewi@gmail.com', NULL, '$2y$12$iVZj1EH15XNQjEu9Ud8rFOSLGd.IeuNmSjjv2gaEfaGXhv2vpGldy', 2, NULL, '2024-06-19 06:04:50', '2024-06-19 06:04:50'),
(29, 'Ghustanul Arifin, S.Pd.', 'gustanul@gmail.com', NULL, '$2y$12$xLt7.84ezyvNjT3YLsoxDeIQWjqGfw4m/.eN9ozhc3aLu/TLN8oiu', 2, NULL, '2024-06-19 06:05:56', '2024-06-19 06:05:56'),
(30, 'Badruzzaman, S.Pd.I.', 'badruzzaman@gmail.com', NULL, '$2y$12$1AtUnJeVnk3EtKHoCR2qye9P7m/EIwKuUnWKFip4hIY1LBXI5hbi6', 2, NULL, '2024-06-19 06:07:40', '2024-06-19 06:07:40'),
(31, 'Nuri Ria Elisya Herman, S. Pd.', 'nuri@gmail.com', NULL, '$2y$12$DccMUZUzpFYf/hDj/TnJEOoP4M0UNa8We5OnUho.5j0uRf10jm2ya', 2, NULL, '2024-06-19 06:08:29', '2024-06-19 06:08:29'),
(32, 'Chusnul Chotimah, S.Pd.SD.', 'chusnul@gmail.com', NULL, '$2y$12$Za4ra5CdQYzyZEl1PM5RCeqsDGxbZfq3XNtE9Jrqy2RRXEnHkI3Ma', 2, NULL, '2024-06-19 06:29:33', '2024-06-19 06:29:33'),
(63, '0163636978', 'dziazahroannisa@gmail.com', NULL, '$2y$12$E6KdyI1ar5eKsGrUygD0duRhvU5nGZk/LvF7C3Mj72a5pq/BI01he', 3, NULL, '2024-07-22 09:18:27', '2024-07-22 09:18:27'),
(64, '3166876849', 'rawa36677@gmail.com', NULL, '$2y$12$JIccBGxQ1mH5IF14QYoJY.7aywedolCNqqIG5OiAjaGmwvjLyw7t2', 3, NULL, '2024-07-22 09:26:27', '2024-07-22 09:26:27'),
(67, '3163441030', 'kurop612@gmail.com', NULL, '$2y$12$hKsBcmOex.Nc821n8MuQyu4cV9uhL6yq9BwlFJ3xa6.1iC9Ms5BNm', 3, NULL, '2024-07-23 06:35:49', '2024-07-23 06:35:49'),
(68, 'rena', 'rena@gmail.com', NULL, '$2y$12$CqoxDj3MEC0U55Vy0eOCZux61nnN9f1cvs9WN0DZOy.MVPrEsfYDK', 2, NULL, '2024-07-23 08:19:25', '2024-07-23 08:19:25'),
(70, 'meiisya9990@gmail.com', 'meiisya9990@gmail.com', NULL, '$2y$12$lgO5jS7ZY1K55ieEHpSDa.gDBFJNrai8FnYYKhl8ElQv7j6S22JDi', 3, NULL, '2024-07-23 13:57:44', '2024-07-24 04:13:10'),
(71, '3163413969', 'reginaldcp93@gmail.com', NULL, '$2y$12$DAsRInVvTRFUPRhuYIoBpObzJq7Wm3tKOEJhJ.TJEtBJisHpjMZMC', 3, NULL, '2024-07-23 14:49:13', '2024-07-24 05:05:58');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `eskul`
--
ALTER TABLE `eskul`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `eskul_siswa`
--
ALTER TABLE `eskul_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kurikulum`
--
ALTER TABLE `kurikulum`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `raport`
--
ALTER TABLE `raport`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rombel`
--
ALTER TABLE `rombel`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `skrining`
--
ALTER TABLE `skrining`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tahun_ajar`
--
ALTER TABLE `tahun_ajar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absen`
--
ALTER TABLE `absen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `eskul`
--
ALTER TABLE `eskul`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `eskul_siswa`
--
ALTER TABLE `eskul_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `kurikulum`
--
ALTER TABLE `kurikulum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `level`
--
ALTER TABLE `level`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=303;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `raport`
--
ALTER TABLE `raport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `rombel`
--
ALTER TABLE `rombel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT untuk tabel `skrining`
--
ALTER TABLE `skrining`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `tahun_ajar`
--
ALTER TABLE `tahun_ajar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
