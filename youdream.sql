-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mag 20, 2022 alle 18:10
-- Versione del server: 5.6.38
-- Versione PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `youdream`
--
CREATE DATABASE IF NOT EXISTS `youdream` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `youdream`;

-- --------------------------------------------------------

--
-- Struttura della tabella `blog`
--

DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `desc` varchar(512) NOT NULL,
  `time_stamp` timestamp NULL DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `likes` int(11) DEFAULT '0',
  `dislikes` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `blog`
--

INSERT INTO `blog` (`id`, `user_id`, `title`, `desc`, `time_stamp`, `views`, `likes`, `dislikes`) VALUES
(1, 1, 'Il lavoro contemporaneo', 'Le soft e hard skill nel mondo del lavoro e alcuni accorgimenti sulla sicurezza', '2022-04-20 18:05:48', 1118, 4, 0),
(3, 1, '€100 PRIZE BEST STORY', 'WRITE THE BEST STORY TO WIN A PRIZE', '2022-05-14 17:14:49', 22, 1, 1),
(4, 1, 'THE WORLD IS SPINNING', '', '2022-05-14 17:27:26', 19, 1, 1),
(5, 2, 'Ferrara, meta di pellegrinaggio', 'Tutto quello che c\'è da sapere sul pellegrinaggio, storia e simboli, e perchè è collegato alla città di Ferrara', '2022-05-19 16:07:34', 35, 1, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `blog_confirm`
--

DROP TABLE IF EXISTS `blog_confirm`;
CREATE TABLE `blog_confirm` (
  `blog_id` int(11) NOT NULL,
  `secret` varchar(32) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `blog_has_tag`
--

DROP TABLE IF EXISTS `blog_has_tag`;
CREATE TABLE `blog_has_tag` (
  `blog_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `blog_has_tag`
--

INSERT INTO `blog_has_tag` (`blog_id`, `tag_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(3, 5),
(4, 8),
(5, 9),
(5, 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `text` varchar(1024) NOT NULL,
  `is_top` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `nreplies` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `blog_id`, `text`, `is_top`, `nreplies`) VALUES
(1, 4, 1, 'Ottimo', 1, 2),
(2, 1, 1, 'Grazie !!!', 0, 1),
(3, 3, 1, 'Very good', 0, 0),
(4, 3, 1, 'Awsome', 1, 0),
(5, 3, 1, 'Indeed', 0, 0),
(6, 2, 1, 'Impressive !!!!!!!!!', 1, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `comment_has_comment`
--

DROP TABLE IF EXISTS `comment_has_comment`;
CREATE TABLE `comment_has_comment` (
  `parent` int(11) NOT NULL,
  `child` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `comment_has_comment`
--

INSERT INTO `comment_has_comment` (`parent`, `child`) VALUES
(1, 2),
(1, 5),
(2, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `confirmation`
--

DROP TABLE IF EXISTS `confirmation`;
CREATE TABLE `confirmation` (
  `email` varchar(128) NOT NULL,
  `secret` varchar(32) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `confirmation`
--

INSERT INTO `confirmation` (`email`, `secret`, `time_stamp`) VALUES
('testthing@gmaik.com', '6623e879d17b316b0a967c2fed00f6dd', '2022-05-19 18:04:10');

-- --------------------------------------------------------

--
-- Struttura della tabella `disliked`
--

DROP TABLE IF EXISTS `disliked`;
CREATE TABLE `disliked` (
  `user_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `disliked`
--

INSERT INTO `disliked` (`user_id`, `blog_id`) VALUES
(2, 3),
(2, 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `liked`
--

DROP TABLE IF EXISTS `liked`;
CREATE TABLE `liked` (
  `user_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `liked`
--

INSERT INTO `liked` (`user_id`, `blog_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(1, 3),
(1, 4),
(2, 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `user_id` int(11) NOT NULL,
  `secret` varchar(32) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `subscription`
--

DROP TABLE IF EXISTS `subscription`;
CREATE TABLE `subscription` (
  `subscriptor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `subscription`
--

INSERT INTO `subscription` (`subscriptor_id`, `user_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `name` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `tag`
--

INSERT INTO `tag` (`id`, `name`) VALUES
(9, 'ferrara'),
(3, 'hardskill'),
(1, 'lavoro'),
(5, 'money'),
(10, 'pellegrinaggio'),
(4, 'sicurezza'),
(2, 'softskill'),
(8, 'world');

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `username` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `username`) VALUES
(1, 'umbertodallolio2001@gmail.com', '$2y$10$YjQgZkHmBcSWOKAKFPgHqumA1pK5Qla1KWHcoefXB0sTmEYzErnzi', 'Umbe'),
(2, 'umberto.dallolio@iticopernico.it', '$2y$10$c9YbnaRXDHHAxlaAxUNm7O6F6ch66m57apILOJs.5dORGfmbtEb7e', 'Mark'),
(3, 'umbe.gt@libero.it', '$2y$10$NAqPcIgOvyUJ/rJvnuzeGODI68N01Y7szWSkyt7ORKeyhZpTVAjO6', 'Josh'),
(4, 'antoniodallolio@libero.it', '$2y$10$UhsObKPwC4BhOY3M7wEkxe62sIIHncdAYHFLmIdqXQ6AgKt87CjL.', 'Antonio');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `fk_blog_user_idx` (`user_id`);

--
-- Indici per le tabelle `blog_confirm`
--
ALTER TABLE `blog_confirm`
  ADD PRIMARY KEY (`blog_id`),
  ADD UNIQUE KEY `secret_UNIQUE` (`secret`);

--
-- Indici per le tabelle `blog_has_tag`
--
ALTER TABLE `blog_has_tag`
  ADD PRIMARY KEY (`blog_id`,`tag_id`),
  ADD KEY `fk_blog_has_tag_tag1_idx` (`tag_id`),
  ADD KEY `fk_blog_has_tag_blog1_idx` (`blog_id`);

--
-- Indici per le tabelle `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`,`user_id`,`blog_id`),
  ADD KEY `fk_user_has_blog_user3_idx` (`user_id`),
  ADD KEY `fk_comment_blog1_idx` (`blog_id`);

--
-- Indici per le tabelle `comment_has_comment`
--
ALTER TABLE `comment_has_comment`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `fk_comment_has_comment_comment2_idx` (`parent`),
  ADD KEY `fk_comment_has_comment_comment1_idx` (`child`);

--
-- Indici per le tabelle `confirmation`
--
ALTER TABLE `confirmation`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `secret_UNIQUE` (`secret`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indici per le tabelle `disliked`
--
ALTER TABLE `disliked`
  ADD PRIMARY KEY (`user_id`,`blog_id`),
  ADD KEY `fk_user_has_blog_blog1_idx` (`blog_id`),
  ADD KEY `fk_user_has_blog_user1_idx` (`user_id`);

--
-- Indici per le tabelle `liked`
--
ALTER TABLE `liked`
  ADD PRIMARY KEY (`user_id`,`blog_id`),
  ADD KEY `fk_user_has_blog_blog1_idx` (`blog_id`),
  ADD KEY `fk_user_has_blog_user1_idx` (`user_id`);

--
-- Indici per le tabelle `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`user_id`,`secret`),
  ADD UNIQUE KEY `secret_UNIQUE` (`secret`),
  ADD UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  ADD KEY `fk_session_user1_idx` (`user_id`);

--
-- Indici per le tabelle `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`subscriptor_id`,`user_id`),
  ADD KEY `fk_user_has_user_user2_idx` (`user_id`),
  ADD KEY `fk_user_has_user_user1_idx` (`subscriptor_id`);

--
-- Indici per le tabelle `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `fk_blog_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Limiti per la tabella `blog_confirm`
--
ALTER TABLE `blog_confirm`
  ADD CONSTRAINT `fk_blog_confirm_blog1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`);

--
-- Limiti per la tabella `blog_has_tag`
--
ALTER TABLE `blog_has_tag`
  ADD CONSTRAINT `fk_blog_has_tag_blog1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_blog_has_tag_tag1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_blog1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_has_blog_user3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `comment_has_comment`
--
ALTER TABLE `comment_has_comment`
  ADD CONSTRAINT `fk_comment_has_comment_comment1` FOREIGN KEY (`child`) REFERENCES `comment` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comment_has_comment_comment2` FOREIGN KEY (`parent`) REFERENCES `comment` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `disliked`
--
ALTER TABLE `disliked`
  ADD CONSTRAINT `fk_user_has_blog_blog10` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_has_blog_user10` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `liked`
--
ALTER TABLE `liked`
  ADD CONSTRAINT `fk_user_has_blog_blog1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_has_blog_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `fk_session_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Limiti per la tabella `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `fk_user_has_user_user1` FOREIGN KEY (`subscriptor_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_user_has_user_user2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


CREATE USER 'root'@'localhost' IDENTIFIED BY 'root';
GRANT ALL PRIVILEGES ON 'youdream'.* TO 'root'@'localhost' WITH GRANT OPTION;