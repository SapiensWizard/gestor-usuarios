--
-- Banco de dados: `db_users`
--

-- --------------------------------------------------------

--
-- Extraindo dados da tabela `tb_users`
--

-- Limpar a tabela
TRUNCATE TABLE `tb_users`;

INSERT INTO `tb_users` (
  `id`, `username`, `first_name`, `last_name`, 
  `email`, `password`, `created_at`, `updated_at`
) VALUES
-- Administrador
(
  1, 
  'admin_sistema', 
  'Administrador', 
  'Sistema', 
  'admin@academia.com', 
  'admin123', 
  '2026-01-15 09:00:00', 
  '2026-01-15 09:00:00'
),

-- João Silva
(
  2, 
  'joao_silva', 
  'João', 
  'Silva', 
  'joao.silva@email.com', 
  'joao123', 
  '2026-02-20 13:30:00', 
  '2026-02-20 13:30:00'
),

-- Maria Santos
(
  3, 
  'maria_santos', 
  'Maria', 
  'Santos', 
  'maria.santos@email.com', 
  'maria123', 
  '2026-03-10 08:15:00', 
  '2026-03-10 08:15:00'
),

-- Pedro Oliveira
(
  4, 
  'pedro_oliveira', 
  'Pedro', 
  'Oliveira', 
  'pedro.oliveira@email.com', 
  'pedro123', 
  '2026-04-05 15:45:00', 
  '2026-04-05 15:45:00'
),

-- Ana Pereira
(
  5, 
  'ana_pereira', 
  'Ana', 
  'Pereira', 
  'ana.pereira@email.com', 
  'ana123', 
  '2026-05-12 10:20:00', 
  '2026-05-12 10:20:00'
),

-- Carlos Rodrigues
(
  6, 
  'carlos_rodrigues', 
  'Carlos', 'Rodrigues', 
  'carlos.rodrigues@email.com', 
  'carlos123', 
  '2026-06-18 07:00:00', 
  '2026-06-18 07:00:00'
),

-- Fernanda Lopes
(
  7, 
  'fernanda_lopes', 
  'Fernanda', 'Lopes', 
  'fernanda.lopes@email.com', 
  'fernanda123', 
  '2026-07-05 12:40:00', 
  '2026-07-22 12:40:00'
),

-- Ricardo Martins
(
  8, 
  'ricardo_martins', 
  'Ricardo', 'Martins', 
  'ricardo.martins@email.com', 
  'ricardo123', 
  '2026-07-06 16:10:00', 
  '2026-07-06 19:53:43'
);