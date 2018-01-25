-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Янв 25 2018 г., 17:53
-- Версия сервера: 5.6.25-log
-- Версия PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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
(2, 'defaultSiteHost', 'petition', '', '', ''),
(3, 'hashKey', '', 'Pkhjdfsgy3423mklc', '', ''),
(4, 'password_length', '', '6', '', ''),
(8, 'tagToPage', '', '10', '', ''),
(9, 'numberAndSymbolString', '', '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', '', ''),
(10, 'formatPhoneNumber', '', '+38(099) 999 99 99', '', ''),
(12, 'countSymbol', '', '255', '', ''),
(15, 'google_map_api_key', '', 'AIzaSyATSrm-EMxaDP2tEpgUBO1PaT88wW6hRrY', '', ''),
(16, 'file_size', '', '2', '', ''),
(17, 'save_file', '', '1', '', ''),
(18, 'save_file_to_base64', '', '1', '', ''),
(19, 'siteEmail', '', '', '', ''),
(20, 'sitePhone', '', '', '', ''),
(22, 'capchaKey', '6LerWkEUAAAAALoLORUIu3YT8uxy80vBXc4c0qWU', '', 'capchaKey', ''),
(23, 'capchaSecretKey', '6LerWkEUAAAAAOoN8XEojG23mWgcm7Gjwv7Twd0S', '', 'capchaSecretKey', ''),
(24, 'ipAccess', '127.0.0.1,192.168.1.1', '127.0.0.1', 'ipAccess', '');

-- --------------------------------------------------------

--
-- Структура таблицы `email`
--

CREATE TABLE `email` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `alt` varchar(255) DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `create_at` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `email`
--

INSERT INTO `email` (`id`, `email`, `name`, `subject`, `message`, `alt`, `from`, `create_at`, `status`) VALUES
(1, 'dahanavar13@mail.ru', 'dahanavar13@mail.ru', 'Регистрация (укр)', '<html>\n<head>\n    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">\n    <title> =?utf-8?Q?=F0=9F=93=A7?= Регистрация (укр)</title>\n</head>\n<body style="background: #fff;">\n<table  align="center" border="0" cellpadding="0" cellspacing="0" style="\n    width:650px;\n    min-height: 600px;\n    text-align: center;\n    ">\n    <tbody>\n        <p>Добро пожаловать</p>\n<p>Благодарим Вас за регистрацию </p>\n<p>Для завершения регистрации вам нужно :</p>\n<p>перейти по <a href="http://petition.loc/login/validation?ref=">ссылке</a></p>\n<p>Если вы не зарегистрированы на нашем сайте, просто удалите это письмо.</p>    </tbody>\n</table>\n\n</body>\n</html>', NULL, 'Петиція admin@admin.com', 1516892498, 0),
(2, 'dahanavar13@mail.ru', 'dahanavar13@mail.ru', 'Регистрация (укр)', '<html>\r\n<head>\r\n    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">\r\n    <title> =?utf-8?Q?=F0=9F=93=A7?= Регистрация (укр)</title>\r\n</head>\r\n<body style="background: #fff;">\r\n<table  align="center" border="0" cellpadding="0" cellspacing="0" style="\r\n    width:650px;\r\n    min-height: 600px;\r\n    text-align: center;\r\n    ">\r\n    <tbody>\r\n        <p>Добро пожаловать</p>\n<p>Благодарим Вас за регистрацию </p>\n<p>Для завершения регистрации вам нужно :</p>\n<p>перейти по <a href="http://petition.loc/login/validation?ref=wTRAh0BYmGzotfhWRyEdeWcjOgQPiR6PVzUWqJLfYcBlljUjIVELOmiMStOXBCFodCQGqPNUt5uF4Kp4qEvGg8gCO3EtLJ7km2EMkiIVRmgmGzNb1LfYAi7PC0mmOfrDoQkg59uk60UraL3GufSDNPQqjlWCJ7Dji0S7Jma6e1rTwkbyP7mGSKroR3pfwnHn5zjlfXHgepPIKgbN3mJ6P1VJi8Jgc0EOJuCWDW7M6b6URA4p8YYTEGgrCAWEK0s">ссылке</a></p>\n<p>Если вы не зарегистрированы на нашем сайте, просто удалите это письмо.</p>    </tbody>\r\n</table>\r\n\r\n</body>\r\n</html>', NULL, 'Петиція admin@admin.com', 1516895156, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `mail`
--

CREATE TABLE `mail` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `type` varchar(45) NOT NULL,
  `link` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mail`
--

INSERT INTO `mail` (`id`, `title`, `content`, `type`, `link`) VALUES
(1, '', '', 'registration', ''),
(2, '', '', 'reset_password', ''),
(3, '', '', 'account_create', ''),
(4, '', '', 'new_task', ''),
(5, '', '', 'assign_task', ''),
(6, '', '', 'new_comment_to_task', ''),
(7, '', '', 'moderation_entity', '');

-- --------------------------------------------------------

--
-- Структура таблицы `mail_lang`
--

CREATE TABLE `mail_lang` (
  `id` int(10) UNSIGNED NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL,
  `lang_id` varchar(6) NOT NULL,
  `l_title` varchar(255) DEFAULT NULL,
  `l_content` text,
  `l_link` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mail_lang`
--

INSERT INTO `mail_lang` (`id`, `owner_id`, `lang_id`, `l_title`, `l_content`, `l_link`) VALUES
(3, 1, 'ru', 'Регистрация', '<p>Ласкаво просимо</p>\n<p>Дякуємо Вам за підпис петиції </p>\n<p>Для завершення підпису вам потрібно :</p>\n<p>перейти по {link}</p>\n<p>Якщо ви не підписували петицію на нашому сайті, просто видаліть цей лист.</p>', 'посиланню'),
(4, 1, 'uk', 'Регистрация (укр)', '<p>Добро пожаловать</p>\n<p>Благодарим Вас за регистрацию </p>\n<p>Для завершения регистрации вам нужно :</p>\n<p>перейти по {link}</p>\n<p>Если вы не зарегистрированы на нашем сайте, просто удалите это письмо.</p>', 'ссылке'),
(5, 2, 'ru', 'Новый пароль', 'Ваш новый пароль {password}', NULL),
(6, 2, 'uk', 'Новый пароль (укр)', 'Ваш новый пароль {password}', NULL),
(8, 3, 'ru', 'Создание аккаунта', '<p>Добрый день, {firstName} {lastName}.</p>\n<p>Вас зарегистрировали в системе {application_name} .</p>\n<p>Для входа в  личный кабинет</p>\n<p>Используйте </p>\n<ul>\n<li>email: {email}</li>\n<li>пароль: {password}</li>\n</ul>\n\n\n<p>Изменить свой пароль Вы сможете в личном кабинете.</p>', 'личный кабинет'),
(9, 3, 'uk', 'Создание аккаунта (укр)', '<p>Добрый день, {firstName} {lastName}.</p>\n<p>Вас зарегистрировали в системе {application_name} .</p>\n<p>Для входа в   личный кабинет</p>\n<p>Используйте </p>\n<ul>\n<li>email: {email}</li>\n<li>пароль: {password}</li>\n</ul>\n\n\n<p>Изменить свой пароль Вы сможете в личном кабинете.</p>', 'личный кабинет'),
(10, 4, 'ru', 'Новая заявка', '<p>Поступила новая заявка</p>\n<p>{link}</p>', 'ссылка'),
(11, 4, 'uk', 'Новая заявка (укр)', '<p>Поступила новая заявка</p>\n<p>{link}</p>', 'ссылка'),
(12, 5, 'ru', 'Новая задача', '<p>Поступила новая задача</p>\n<p>{link}</p>', 'ссылка'),
(13, 5, 'uk', 'Новая задача (укр)', '<p>Поступила новая задача</p>\n<p>{link}</p>', 'ссылка'),
(15, 6, 'ru', 'Новое сообщение', 'Вы получили новое сообщение {link}', 'ссылка'),
(16, 6, 'uk', 'Новое сообщение(укр)', 'Вы получили новое сообщение {link}', 'ссылка'),
(17, 7, 'ru', 'Модерация', 'Поступил новый объект на проверку {link}', 'ссылка'),
(18, 7, 'uk', 'Модерация', 'Поступил новый объект на проверку {link}', 'ссылка');

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
  `date_create` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `petition`
--

INSERT INTO `petition` (`id`, `title`, `full_text`, `date_create`) VALUES
(6, 'Створити Петицію', 'Що таке Lorem Ipsum?\r\nLorem Ipsum - це текст-"риба", що використовується в друкарстві та дизайні. Lorem Ipsum є, фактично, стандартною "рибою" аж з XVI сторіччя, коли невідомий друкар взяв шрифтову гранку та склав на ній підбірку зразків шрифтів. "Риба" не тільки успішно пережила п\'ять століть, але й прижилася в електронному верстуванні, залишаючись по суті незмінною. Вона популяризувалась в 60-их роках минулого сторіччя завдяки виданню зразків шрифтів Letraset, які містили уривки з Lorem Ipsum, і вдруге - нещодавно завдяки програмам комп\'ютерного верстування на кшталт Aldus Pagemaker, які використовували різні версії Lorem Ipsum.\r\n\r\nЧому ми ним користуємось?\r\nВже давно відомо, що читабельний зміст буде заважати зосередитись людині, яка оцінює композицію сторінки. Сенс використання Lorem Ipsum полягає в тому, що цей текст має більш-менш нормальне розподілення літер на відміну від, наприклад, "Тут іде текст. Тут іде текст." Це робить текст схожим на оповідний. Багато програм верстування та веб-дизайну використовують Lorem Ipsum як зразок і пошук за терміном "lorem ipsum" відкриє багато веб-сайтів, які знаходяться ще в зародковому стані. Різні версії Lorem Ipsum з\'явились за минулі роки, деякі випадково, деякі було створено зумисно (зокрема, жартівливі).\r\n\r\n\r\nЗвідки він походить?\r\nНа відміну від поширеної думки Lorem Ipsum не є випадковим набором літер. Він походить з уривку класичної латинської літератури 45 року до н.е., тобто має більш як 2000-річну історію. Річард Макклінток, професор латини з коледжу Хемпдін-Сидні, що у Вірджінії, вивчав одне з найменш зрозумілих латинських слів - consectetur - з уривку Lorem Ipsum, і у пошуку цього слова в класичній літературі знайшов безсумнівне джерело. Lorem Ipsum походить з розділів 1.10.32 та 1.10.33 цицеронівського "de Finibus Bonorum et Malorum" ("Про межі добра і зла"), написаного у 45 році до н.е. Цей трактат з теорії етики був дуже популярним в епоху Відродження. Перший рядок Lorem Ipsum, "Lorem ipsum dolor sit amet..." походить з одного з рядків розділу 1.10.32.\r\n\r\nКласичний текст, використовуваний з XVI сторіччя, наведено нижче для всіх зацікавлених. Також точно за оригіналом наведено розділи 1.10.32 та 1.10.33 цицеронівського "de Finibus Bonorum et Malorum" разом із перекладом англійською, виконаним 1914 року Х.Рекемом.\r\n\r\nДе собі взяти трохи?\r\nІснує багато варіацій уривків з Lorem Ipsum, але більшість з них зазнала певних змін на кшталт жартівливих вставок або змішування слів, які навіть не виглядають правдоподібно. Якщо ви збираєтесь використовувати Lorem Ipsum, ви маєте упевнитись в тому, що всередині тексту не приховано нічого, що могло б викликати у читача конфуз. Більшість відомих генераторів Lorem Ipsum в Мережі генерують текст шляхом повторення наперед заданих послідовностей Lorem Ipsum. Принципова відмінність цього генератора робить його першим справжнім генератором Lorem Ipsum. Він використовує словник з більш як 200 слів латини та цілий набір моделей речень - це дозволяє генерувати Lorem Ipsum, який виглядає осмислено. Таким чином, згенерований Lorem Ipsum не міститиме повторів, жартів, нехарактерних для латини слів і т.ін.', 1516809796);

-- --------------------------------------------------------

--
-- Структура таблицы `petition_answer`
--

CREATE TABLE `petition_answer` (
  `id` int(10) UNSIGNED NOT NULL,
  `petition_id` int(10) UNSIGNED DEFAULT NULL,
  `answer` text,
  `date_create` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `patronymic` varchar(50) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `social_status` varchar(15) DEFAULT NULL,
  `birthday` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_registration` int(11) DEFAULT NULL,
  `inn` varchar(10) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `role` varchar(15) NOT NULL COMMENT 'admin,user,moderator',
  `status` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `firstName`, `lastName`, `patronymic`, `phone`, `social_status`, `birthday`, `address`, `date_registration`, `inn`, `token`, `role`, `status`) VALUES
(1, 'admin@admin.com', 'bbe229c989b6d2f716b879ca4560dbf4', 'firstName', 'lastName', 'patronymic', '+38(050) 666 66 66', NULL, 0, '', 1501143874, '1111111111', 'test', 'admin', 1),
(23, 'dahanavar13@mail.ru', 'bbe229c989b6d2f716b879ca4560dbf4', 'Саша', 'Боков', 'Саша', '+38(067) 777 77 77', 'tester', 1011139200, 'Киев', 1516185085, '3333333333', 'Ll7OcOsl2FAdYd0xfkGTyl4n858AGUmCrFH47HE1WQ94CrGjmlclUUcftWCDLPXA0naHVXI4Iozi82dsmKBa9QcuGbZ3I6rVrsvIAAFvnjSUw0DZfvSmf957MNeQxLMDKUI68AtjUC3SMmUTZE1WeQQ7KMl0fN0JWKNRyXavji7eV54aCa2S6UtuA9lyPd7c0XL0RIK3Al2YWb7O74WcPmYejSdthZ52WxAv1QbZKLQ4PE1QulIUramlUZWLB9W', 'moderator', 1),
(32, 'dahanavar13@mail.ru', '1e85b7573e701f0374089b2980f8ef57', 'Саша', 'Боков', 'Саша', '+38(039) 999 99 99', '', 1011132000, '111111 Киев', 1516890134, '3333333333', 'wTRAh0BYmGzotfhWRyEdeWcjOgQPiR6PVzUWqJLfYcBlljUjIVELOmiMStOXBCFodCQGqPNUt5uF4Kp4qEvGg8gCO3EtLJ7km2EMkiIVRmgmGzNb1LfYAi7PC0mmOfrDoQkg59uk60UraL3GufSDNPQqjlWCJ7Dji0S7Jma6e1rTwkbyP7mGSKroR3pfwnHn5zjlfXHgepPIKgbN3mJ6P1VJi8Jgc0EOJuCWDW7M6b6URA4p8YYTEGgrCAWEK0s', 'user', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `voting`
--

CREATE TABLE `voting` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `petition_id` int(10) UNSIGNED NOT NULL,
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
-- Индексы таблицы `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mail`
--
ALTER TABLE `mail`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mail_lang`
--
ALTER TABLE `mail_lang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mail_lang_mail1_idx` (`owner_id`);

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
-- Индексы таблицы `petition_answer`
--
ALTER TABLE `petition_answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `petitions_idx` (`petition_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `voting`
--
ALTER TABLE `voting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_voting_petition1_idx` (`petition_id`),
  ADD KEY `fk_voting_user1_idx` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `config`
--
ALTER TABLE `config`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT для таблицы `email`
--
ALTER TABLE `email`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `mail`
--
ALTER TABLE `mail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `mail_lang`
--
ALTER TABLE `mail_lang`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT для таблицы `mobile_phones_code`
--
ALTER TABLE `mobile_phones_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT для таблицы `petition`
--
ALTER TABLE `petition`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `petition_answer`
--
ALTER TABLE `petition_answer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT для таблицы `voting`
--
ALTER TABLE `voting`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `petition_answer`
--
ALTER TABLE `petition_answer`
  ADD CONSTRAINT `petitions` FOREIGN KEY (`petition_id`) REFERENCES `petition` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `voting`
--
ALTER TABLE `voting`
  ADD CONSTRAINT `fk_voting_petition1` FOREIGN KEY (`petition_id`) REFERENCES `petition` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_voting_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
