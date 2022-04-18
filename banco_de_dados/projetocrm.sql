-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 24/08/2021 às 13:23
-- Versão do servidor: 5.7.24
-- Versão do PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projetocrm`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `department_tickets`
--

CREATE TABLE `department_tickets` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `department_tickets`
--

INSERT INTO `department_tickets` (`id`, `name`) VALUES
(1, 'Suporte Técnico'),
(2, 'Financeiro'),
(3, 'Desenvolvimento'),
(4, 'Marketing Digital');

-- --------------------------------------------------------

--
-- Estrutura para tabela `files`
--

CREATE TABLE `files` (
  `id` int(10) UNSIGNED NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `ticket_id` int(10) UNSIGNED DEFAULT NULL,
  `author_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `files`
--

INSERT INTO `files` (`id`, `file_name`, `file_url`, `file_type`, `created_at`, `ticket_id`, `author_id`) VALUES
(2, 'feta1-2.png', '/assets/uploads/files/feta1-2.png', 'image/png', '2021-02-18 13:37:14', 4, 1),
(4, 'feta1.png', '/assets/uploads/files/feta1.png', 'image/png', '2021-02-18 13:45:59', 5, 1),
(5, '2.jpg', '/assets/uploads/files/2.jpg', 'image/jpeg', '2021-02-22 20:36:34', 4, 1),
(6, '6.jpg', '/assets/uploads/files/6.jpg', 'image/jpeg', '2021-02-22 20:36:44', 4, 1),
(7, '9ead720af2e500628ad99df2fce863a7---cone-de-gr--fico-de-barras-coloridas-by-vexels.png', '/assets/uploads/files/9ead720af2e500628ad99df2fce863a7---cone-de-gr--fico-de-barras-coloridas-by-vexels.png', 'image/png', '2021-02-28 11:15:51', 5, 1),
(8, '5.jpg', '/assets/uploads/files/5.jpg', 'image/jpeg', '2021-02-28 11:15:57', 5, 1),
(9, 'image2-home4.png', '/assets/uploads/files/image2-home4.png', 'image/png', '2021-02-28 11:18:58', 5, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `followups`
--

CREATE TABLE `followups` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `description` text,
  `author_id` int(10) UNSIGNED DEFAULT NULL,
  `ticket_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `followups`
--

INSERT INTO `followups` (`id`, `created_at`, `description`, `author_id`, `ticket_id`) VALUES
(1, '2021-02-19 23:36:36', 'teste de descrição', 1, 4),
(2, '2021-02-19 23:37:49', 'teste de descrição 02 \r\n\r\naqui pulando linha', 1, 4),
(3, '2021-02-28 10:57:12', 'teste de interação', 1, 5),
(4, '2021-02-28 10:57:22', 'teste 02\r\n', 1, 5),
(5, '2021-03-10 00:14:36', 'teste', 1, 12),
(6, '2021-03-10 00:14:40', 'teste 05\r\n', 1, 12),
(7, '2021-03-10 00:25:09', 'teste de envio de email', 1, 12),
(8, '2021-03-10 00:29:36', 'Olá Adriano ok', 2, 12),
(9, '2021-03-10 00:30:27', 'legal adriano', 2, 12),
(10, '2021-03-10 00:31:09', 'ok Tadeu te ligo para confirmar', 1, 12),
(11, '2021-03-17 00:22:47', 'teste 01', 3, 14),
(12, '2021-03-17 00:23:29', 'show de bola parabéns', 2, 14),
(13, '2021-03-17 01:26:14', 'teste', 3, 15),
(14, '2021-03-17 01:27:07', 'teste de interação', 2, 15);

-- --------------------------------------------------------

--
-- Estrutura para tabela `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ticket_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `notifications`
--

INSERT INTO `notifications` (`id`, `created_at`, `title`, `icon`, `url`, `status`, `user_id`, `ticket_id`) VALUES
(3, '2021-03-17 01:27:10', 'Você teve uma nova interação no chamado Nº 15', 'fa fa-envelope', '/painel/chamados/detaill-followups/8fd97a637920b08dfd76e8b1096078dc', '2', 3, 15),
(5, '2021-04-13 13:28:06', 'Novo chamado criado nº 17', 'fa fa-envelope', 'https://www.dev.projetocrm.com.br/painel/chamados/detaill-followups/d48874b94fa6111e2a17bcfe9952f797', '2', 4, 17);

-- --------------------------------------------------------

--
-- Estrutura para tabela `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `level`) VALUES
(2, 'Cliente', '2'),
(10, 'Admin', '10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `products`
--

INSERT INTO `products` (`id`, `name`) VALUES
(1, 'Aplicativo Mobile'),
(2, 'Campanha de marketing digital'),
(3, 'Criação de site'),
(4, 'Aplicação Comercial');

-- --------------------------------------------------------

--
-- Estrutura para tabela `status_tickets`
--

CREATE TABLE `status_tickets` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `status_tickets`
--

INSERT INTO `status_tickets` (`id`, `name`, `color`, `icon`) VALUES
(1, 'Aberto', '#148FDB', 'fa fa-bullhorn'),
(2, 'Fechado', '#DB1A14', 'fa fa-lock'),
(3, 'Em Andamento', '#FFA617', 'fa fa-calendar'),
(4, 'Cancelado', '#8722F2', 'fa fa-ban'),
(5, 'Aguardando Resposta', '#1465DB', 'fa fa-clock-o');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tickets`
--

CREATE TABLE `tickets` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `status` int(11) DEFAULT NULL,
  `send_email` int(11) DEFAULT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `department_id` int(10) UNSIGNED DEFAULT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `responsible_id` int(10) UNSIGNED DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `tickets`
--

INSERT INTO `tickets` (`id`, `created_at`, `updated_at`, `title`, `description`, `status`, `send_email`, `product_id`, `department_id`, `client_id`, `responsible_id`, `token`) VALUES
(4, '2021-02-06 12:43:50', '2021-02-22 20:36:44', 'Teste de chamado 2', '<p>teste&nbsp;</p><p><br></p><p><b>teste de chamado</b></p>', 1, NULL, 1, 3, 2, 1, '3da6a5fe2905befed59daf1960fd1ab9'),
(5, '2021-02-18 13:45:59', NULL, 'teste', '<p>teste</p>', 1, NULL, 4, 3, 2, 1, '0e0a9bf4a479aa6f215a0fe7eab3d405'),
(6, '2021-03-02 11:35:01', NULL, 'teste de chamado com e-mail', '<p>tesaasa s asasas</p>', 1, NULL, 4, 1, 2, 1, 'bc6bdda4cc3c7172e86b6dfbe6327194'),
(7, '2021-03-02 11:35:31', '2021-04-13 13:30:58', 'chamado com envio de e-mail', '<p>teste ok</p>', 2, NULL, 4, 3, 2, 1, '0493508d649edb965fafab331f23bf74'),
(11, '2021-03-02 11:42:53', NULL, 'Teste de envio de e-mail 02', '<p>teste&nbsp;</p>', 1, NULL, 4, 3, 2, 1, 'c9c5de677fff3db38ac440b905f8e300'),
(12, '2021-03-02 11:45:14', '2021-03-10 00:14:17', 'teste de e-mail 03', '<p>tessa asasasa</p>', 3, NULL, 4, 3, 2, 1, '8889f6a3447560869983daacc2cf50e1'),
(13, '2021-03-16 22:54:56', NULL, 'teste e notificação', '<p>teste</p>', 1, NULL, 3, 3, 2, 3, '5f7a09068f6f75a5184ad4e87f9ad9c6'),
(14, '2021-03-16 23:01:14', NULL, 'teste chamado cliente', '<p>teasasas</p>', 1, NULL, 4, 3, 2, 3, '205182cd10977c93379056787bd01ed6'),
(15, '2021-03-17 01:00:24', NULL, 'novo chamado do tadeu ', '<p>teste</p>', 1, NULL, 3, 3, 2, 3, '8fd97a637920b08dfd76e8b1096078dc'),
(17, '2021-04-13 13:28:06', NULL, 'teste de dias', '', 1, NULL, 4, 3, 4, 1, 'd48874b94fa6111e2a17bcfe9952f797');

-- --------------------------------------------------------

--
-- Estrutura para tabela `type_user`
--

CREATE TABLE `type_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `type_user`
--

INSERT INTO `type_user` (`id`, `name`) VALUES
(1, 'Cliente'),
(2, 'Funcionário'),
(3, 'Freela');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `cellphone` varchar(255) DEFAULT NULL,
  `cpf` varchar(255) DEFAULT NULL,
  `cnpj` varchar(255) DEFAULT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `neightborhood` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `uf` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `type_user_id` int(10) UNSIGNED DEFAULT NULL,
  `permission_level` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `cellphone`, `cpf`, `cnpj`, `zipcode`, `address`, `neightborhood`, `city`, `uf`, `company`, `phone`, `avatar`, `token`, `status`, `type_user_id`, `permission_level`, `created_at`, `updated_at`, `department_id`) VALUES
(1, 'Adriano Luiz', 'adriano@adriano.com', '1db882a3b2201cdea8a03e4cc8b44c673af84439', '149999', '787.878.787-87', '', '', '', '', '', '', 'Als Digital', '', '/assets/uploads/users/1/E6896D34-1D2F-43B0-A20C-55202D2CE295.jpg', '7c4a88oiTR@ca3762af61e59520943dc26494f8941b', 1, 2, 10, NULL, '2021-04-12 20:59:16', 3),
(2, 'Tadeu Da Silva', 'tadeucliente@email.com', '1db882a3b2201cdea8a03e4cc8b44c673af84439', '878745488778', '290.878.787-78', '', '', '', '', '', '', 'Teste empresa', '', '/assets/uploads/users/2/9A4C6ED6-9957-401A-B8C1-4097E1CB337D.jpg', 'a0ac7ad8b31f2713797fa327ef418a73', 1, 1, 2, '2021-01-07 22:14:29', '2021-03-17 00:29:44', NULL),
(3, 'João Batista', 'joaob@email.com.br', '1db882a3b2201cdea8a03e4cc8b44c673af84439', '45548789887', '588.777.887-77', '', '', '', '', '', '', '', '', '/assets/uploads/users/3/99726BFC-6E03-49B5-9FF8-E82F10912E73.jpg', 'c713cb9071bf09519e623a981cd064bd', 1, 3, 10, '2021-03-16 22:50:24', '2021-04-12 21:05:35', 3),
(4, 'Kelly Navarro', 'kellycliente@email.com', '1db882a3b2201cdea8a03e4cc8b44c673af84439', '55488751', '784.848.778-78', '', '', '', '', '', '', '', '', '/assets/uploads/users/7F96D731-6CD1-45B5-8AB3-7016228B060D.jpg', '65638336f7bb44ab92c18c7527c940a2', 1, 1, 2, '2021-03-17 00:28:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `wappler_migrations`
--

CREATE TABLE `wappler_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `batch` int(11) DEFAULT NULL,
  `migration_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `wappler_migrations`
--

INSERT INTO `wappler_migrations` (`id`, `name`, `batch`, `migration_time`) VALUES
(1, '20210412175443_nova coluna departamento id para usuarios.js', 1, '2021-04-12 20:54:44');

-- --------------------------------------------------------

--
-- Estrutura para tabela `wappler_migrations_lock`
--

CREATE TABLE `wappler_migrations_lock` (
  `index` int(10) UNSIGNED NOT NULL,
  `is_locked` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `wappler_migrations_lock`
--

INSERT INTO `wappler_migrations_lock` (`index`, `is_locked`) VALUES
(1, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `department_tickets`
--
ALTER TABLE `department_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projetocrm_files_ticket_id_foreign` (`ticket_id`),
  ADD KEY `projetocrm_files_author_id_foreign` (`author_id`);

--
-- Índices de tabela `followups`
--
ALTER TABLE `followups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projetocrm_followups_author_id_foreign` (`author_id`),
  ADD KEY `projetocrm_followups_ticket_id_foreign` (`ticket_id`);

--
-- Índices de tabela `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`),
  ADD KEY `notifications_ticket_id_foreign` (`ticket_id`);

--
-- Índices de tabela `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `status_tickets`
--
ALTER TABLE `status_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_department_id_foreign` (`department_id`),
  ADD KEY `tickets_client_id_foreign` (`client_id`),
  ADD KEY `tickets_responsible_id_foreign` (`responsible_id`),
  ADD KEY `tickets_product_id_foreign` (`product_id`);

--
-- Índices de tabela `type_user`
--
ALTER TABLE `type_user`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_type_user_id_foreign` (`type_user_id`),
  ADD KEY `users_permission_level_foreign` (`permission_level`);

--
-- Índices de tabela `wappler_migrations`
--
ALTER TABLE `wappler_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `wappler_migrations_lock`
--
ALTER TABLE `wappler_migrations_lock`
  ADD PRIMARY KEY (`index`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `department_tickets`
--
ALTER TABLE `department_tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `followups`
--
ALTER TABLE `followups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `status_tickets`
--
ALTER TABLE `status_tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `type_user`
--
ALTER TABLE `type_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `wappler_migrations`
--
ALTER TABLE `wappler_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `wappler_migrations_lock`
--
ALTER TABLE `wappler_migrations_lock`
  MODIFY `index` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `projetocrm_files_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projetocrm_files_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `followups`
--
ALTER TABLE `followups`
  ADD CONSTRAINT `projetocrm_followups_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projetocrm_followups_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `department_tickets` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_responsible_id_foreign` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Restrições para tabelas `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_permission_level_foreign` FOREIGN KEY (`permission_level`) REFERENCES `permissions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `users_type_user_id_foreign` FOREIGN KEY (`type_user_id`) REFERENCES `type_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
