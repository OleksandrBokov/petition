-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 15 2018 г., 16:05
-- Версия сервера: 10.1.26-MariaDB
-- Версия PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `petition`
--

-- --------------------------------------------------------

--
-- Структура таблицы `config`
--

CREATE TABLE `config` (
  `id` int(10) UNSIGNED NOT NULL,
  `param` varchar(128) NOT NULL,
  `value` text NOT NULL,
  `default` text NOT NULL,
  `label` varchar(255) NOT NULL,
  `type` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `config`
--

INSERT INTO `config` (`id`, `param`, `value`, `default`, `label`, `type`) VALUES
(1, 'adminEmail', 'admin@admin.com', 'webmaster@example.com', '', ''),
(2, 'defaultSiteHost', 'nasport.com.ua', '', '', ''),
(3, 'hashKey', '', 'Pkhjdfsgy3423mklc', '', ''),
(4, 'password_length', '', '6', '', ''),
(5, 'branchToPage', '', '5', '', ''),
(6, 'cityToPage', '', '5', '', ''),
(7, 'stationToPage', '', '10', '', ''),
(8, 'tagToPage', '', '10', '', ''),
(9, 'numberAndSymbolString', '', '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', '', ''),
(10, 'formatPhoneNumber', '', '+38(099) 999 99 99', '', ''),
(11, 'managerToPage', '', '5', '', ''),
(12, 'countSymbol', '', '255', '', ''),
(13, 'sound_signal', '', '0', '', ''),
(14, 'placeToPage', '', '15', '', ''),
(15, 'google_map_api_key', '', 'AIzaSyATSrm-EMxaDP2tEpgUBO1PaT88wW6hRrY', '', ''),
(16, 'file_size', '', '2', '', ''),
(17, 'save_file', '', '1', '', ''),
(18, 'save_file_to_base64', '', '1', '', ''),
(19, 'siteEmail', 'nasport@gmail.com', '', '', ''),
(20, 'sitePhone', '', '095 057 79 090', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `mobile_phones_code`
--

CREATE TABLE `mobile_phones_code` (
  `id` int(11) NOT NULL,
  `code` varchar(4) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mobile_phones_code`
--

INSERT INTO `mobile_phones_code` (`id`, `code`, `name`) VALUES
(1, '050', 'МТС(Vodafone)'),
(2, '063', 'Лайф'),
(3, '066', 'МТС (Джинс)(Vodafone)'),
(4, '067', 'Киевстар'),
(5, '073', 'Лайф'),
(6, '091', '3Mob (Utel)'),
(7, '092', 'Пиплнет'),
(8, '093', 'Лайф'),
(9, '094', 'Интертелеком'),
(10, '095', 'МТС(Vodafone)'),
(11, '096', 'Киевстар (Диджус)'),
(12, '097', ' Киевстар (Диджус)'),
(13, '099', 'МТС (Джинс)(Vodafone)'),
(14, '098', 'Киевстар (Диджус)'),
(15, '068', ' Киевстар (Билайн)'),
(16, '039', 'Киевстар Украина (Golden Telecom)'),
(17, '070', 'ПЛАТНЫЕ НОМЕРА'),
(18, '090', 'ПЛАТНЫЕ НОМЕРА');

-- --------------------------------------------------------

--
-- Структура таблицы `petition`
--

CREATE TABLE `petition` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `full_text` text NOT NULL,
  `date_create` int(11) NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `patronymic` varchar(50) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `social_status` varchar(15) DEFAULT NULL,
  `birthday` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `date_registration` int(11) NOT NULL,
  `inn` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `token` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT '''''',
  `role` varchar(15) NOT NULL COMMENT 'admin,user,moderator',
  `status` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 - не авторизирован1 - авторизирован2 - заблокирован'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `firstName`, `lastName`, `patronymic`, `phone`, `social_status`, `birthday`, `address`, `date_registration`, `inn`, `ip`, `token`, `avatar`, `role`, `status`) VALUES
(1, 'admin@admin.com', '4c60e7c968ead4a0b73a13134aba1f80', 'firstName', 'lastName', 'patronymic', '111111111111111', NULL, 0, '', 1501143874, 1111111111, '', '', '', 'administrator', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `voting`
--

CREATE TABLE `voting` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `petition_id` int(11) UNSIGNED NOT NULL,
  `date_registration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `param` (`param`);

--
-- Индексы таблицы `mobile_phones_code`
--
ALTER TABLE `mobile_phones_code`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Индексы таблицы `petition`
--
ALTER TABLE `petition`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `voting`
--
ALTER TABLE `voting`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `config`
--
ALTER TABLE `config`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT для таблицы `mobile_phones_code`
--
ALTER TABLE `mobile_phones_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT для таблицы `petition`
--
ALTER TABLE `petition`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `voting`
--
ALTER TABLE `voting`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
