-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 06-Jul-2026 às 20:51
-- Versão do servidor: 9.1.0
-- versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_users`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_users`
--

DROP TABLE IF EXISTS `tb_users`;
CREATE TABLE IF NOT EXISTS `tb_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_users`
--

INSERT INTO `tb_users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin_sistema', 'Administrador', 'Sistema', 'admin@academia.com', 'admin123', '2026-01-15 09:00:00', '2026-01-15 09:00:00'),
(2, 'joao_silva', 'João', 'Silva', 'joao.silva@email.com', 'joao123', '2026-02-20 13:30:00', '2026-02-20 13:30:00'),
(3, 'maria_santos', 'Maria', 'Santos', 'maria.santos@email.com', 'maria123', '2026-03-10 08:15:00', '2026-03-10 08:15:00'),
(4, 'pedro_oliveira', 'Pedro', 'Oliveira', 'pedro.oliveira@email.com', 'pedro123', '2026-04-05 15:45:00', '2026-04-05 15:45:00'),
(5, 'ana_pereira', 'Ana', 'Pereira', 'ana.pereira@email.com', 'ana123', '2026-05-12 10:20:00', '2026-05-12 10:20:00'),
(6, 'carlos_rodrigues', 'Carlos', 'Rodrigues', 'carlos.rodrigues@email.com', 'carlos123', '2026-06-18 07:00:00', '2026-06-18 07:00:00'),
(7, 'fernanda_lopes', 'Fernanda', 'Lopes', 'fernanda.lopes@email.com', 'fernanda123', '2026-07-05 12:40:00', '2026-07-22 12:40:00'),
(8, 'ricardo_martins', 'Ricardo', 'Martins', 'ricardo.martins@email.com', 'ricardo123', '2026-07-06 16:10:00', '2026-07-06 20:48:11');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
