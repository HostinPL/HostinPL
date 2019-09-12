-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u8
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 08 2018 г., 23:18
-- Версия сервера: 5.5.60
-- Версия PHP: 5.4.45-0+deb7u13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `gs6`
--

-- --------------------------------------------------------

--
-- Структура таблицы `authlog`
--

CREATE TABLE IF NOT EXISTS `authlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `ip` varchar(64) NOT NULL,
  `city` text NOT NULL,
  `country` text NOT NULL,
  `code` text NOT NULL,
  `datetime` datetime NOT NULL,
  `status` int(1) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `game_id` int(10) NOT NULL AUTO_INCREMENT,
  `game_name` varchar(32) DEFAULT NULL,
  `game_code` varchar(8) DEFAULT NULL,
  `game_query` varchar(32) DEFAULT NULL,
  `image_url` text NOT NULL,
  `game_min_slots` int(8) DEFAULT NULL,
  `game_max_slots` int(8) DEFAULT NULL,
  `game_min_port` int(8) DEFAULT NULL,
  `game_max_port` int(8) DEFAULT NULL,
  `game_price` decimal(10,2) DEFAULT NULL,
  `game_status` int(1) DEFAULT NULL,
  PRIMARY KEY (`game_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `games`
--

INSERT INTO `games` (`game_id`, `game_name`, `game_code`, `game_query`, `image_url`, `game_min_slots`, `game_max_slots`, `game_min_port`, `game_max_port`, `game_price`, `game_status`) VALUES
(1, 'San Andreas: Multiplayer', 'samp', 'samp', '', 50, 1000, 7777, 9999, 1.00, 1),
(2, 'Criminal Russia: Multiplayer', 'crmp', 'samp', '', 50, 1000, 3335, 7000, 1.00, 1),
(3, 'Multi Theft Auto: Multiplayer', 'mta', 'mtasa', '', 50, 4000, 25020, 80520, 1.00, 1),
(4, 'Counter Strike 1.6', 'cs', 'cs', '', 10, 32, 27016, 30550, 3.00, 2),
(5, 'MineCraft: PE', 'mcpe', 'mcpe', '', 10, 900, 12410, 55641, 5.00, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `inbox`
--

CREATE TABLE IF NOT EXISTS `inbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_firstname` varchar(15) NOT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `text` text,
  `status` int(1) NOT NULL,
  `inbox_date_add` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `invoice_ammount` decimal(10,2) DEFAULT NULL,
  `invoice_status` int(1) DEFAULT NULL,
  `invoice_date_add` datetime DEFAULT NULL,
  `system` int(11) NOT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `location_id` int(10) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(32) DEFAULT NULL,
  `location_ip` varchar(15) DEFAULT NULL,
  `location_ip2` varchar(15) DEFAULT NULL,
  `location_user` varchar(32) DEFAULT NULL,
  `location_password` varchar(32) DEFAULT NULL,
  `location_status` int(1) DEFAULT NULL,
  `location_cpu` varchar(128) NOT NULL DEFAULT '0',
  `location_ram` varchar(128) NOT NULL DEFAULT '0',
  `location_hdd` varchar(128) NOT NULL DEFAULT '0',
  `location_hddold` varchar(128) NOT NULL DEFAULT '0',
  `location_players` varchar(128) NOT NULL DEFAULT '0',
  `location_upd` datetime NOT NULL,
  `location_uptime` varchar(128) NOT NULL DEFAULT '0',
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT '0',
  `news_title` varchar(32) DEFAULT NULL,
  `news_text` char(255) NOT NULL,
  `news_date_add` datetime DEFAULT NULL,
  `look` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `place` int(11) NOT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `news_category`
--

CREATE TABLE IF NOT EXISTS `news_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `category_status` int(11) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `news_messages`
--

CREATE TABLE IF NOT EXISTS `news_messages` (
  `news_message_id` int(10) NOT NULL AUTO_INCREMENT,
  `news_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `news_message` text,
  `news_message_date_add` datetime DEFAULT NULL,
  PRIMARY KEY (`news_message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `promo`
--

CREATE TABLE IF NOT EXISTS `promo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` text,
  `uses` int(11) DEFAULT NULL,
  `used` int(11) DEFAULT NULL,
  `skidka` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `serverlog`
--

CREATE TABLE IF NOT EXISTS `serverlog` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `reason` text CHARACTER SET utf8 NOT NULL,
  `status` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `server_id` int(11) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `servers`
--

CREATE TABLE IF NOT EXISTS `servers` (
  `server_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `game_id` int(10) DEFAULT NULL,
  `location_id` int(10) DEFAULT NULL,
  `server_slots` int(8) DEFAULT NULL,
  `server_port` int(8) DEFAULT NULL,
  `server_password` varchar(32) DEFAULT NULL,
  `server_status` int(1) DEFAULT NULL,
  `server_cpu_load` float NOT NULL DEFAULT '0',
  `server_ram_load` float NOT NULL DEFAULT '0',
  `server_date_reg` datetime DEFAULT NULL,
  `server_date_end` datetime DEFAULT NULL,
  `db_pass` varchar(32) DEFAULT NULL,
  `server_mysql` int(11) DEFAULT NULL,
  `rcon_password` varchar(32) DEFAULT NULL,
  `server_install` int(11) NOT NULL,
  `fastdl_status` int(11) NOT NULL,
  `repozitory_item` text NOT NULL,
  PRIMARY KEY (`server_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `servers_adap`
--

CREATE TABLE IF NOT EXISTS `servers_adap` (
  `game_id` int(11) DEFAULT NULL,
  `adap_url` text CHARACTER SET utf8 NOT NULL,
  `adap_name` text CHARACTER SET utf8 NOT NULL,
  `adap_act` int(11) DEFAULT NULL,
  `adap_status` int(11) DEFAULT NULL,
  `adap_action` text CHARACTER SET utf8 NOT NULL,
  `adap_arch` text CHARACTER SET utf8 NOT NULL,
  `adap_textx` text CHARACTER SET utf8 NOT NULL,
  `adap_img` text CHARACTER SET utf8 NOT NULL,
  `adap_patch` text CHARACTER SET utf8 NOT NULL,
  `adap_price` text,
  `adap_category` int(1) DEFAULT NULL,
  `adap_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`adap_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `servers_adap`
--

INSERT INTO `servers_adap` (`game_id`, `adap_url`, `adap_name`, `adap_act`, `adap_status`, `adap_action`, `adap_arch`, `adap_textx`, `adap_img`, `adap_patch`, `adap_price`, `adap_category`, `adap_id`) VALUES
(5, 'https://zon.su/tmp/repository/20171028220445274.zip', 'AntiCheat v1.5.2 [1.5.2][Bukkit]', 2, 1, '', '20171028220445274.zip', 'Плагин&nbsp;защищающий ваш сервер от злоумышленников и взломщиков клиентов. Теперь на вашем сервере никто не сможет использовать&nbsp;<strong>чит-программы.</strong>', 'http://minecraft-mods.ru/uploads/posts/2012-12/1356272167_anc.png', '/plugins/', NULL, NULL, 10),
(5, 'https://zon.su/tmp/repository/20171028220748522.zip', 'AuthMe 1 5 2', 2, 1, '', '20171028220748522.zip', 'Качественный плагин регистрации и авторизации игроков для&nbsp;сервера Minecraft 1.5.2, большинство администраторов используют этот плагин за его простоту, что называется установил и забыл.', 'http://worldedit.shonado.ru/images/plagin-authme-v2.7.16-dlya-minecraft-1.5.2-bukkit.png', '/plugins/', NULL, NULL, 11),
(5, 'https://zon.su/tmp/repository/20171028220948757.zip', 'AutoMessage v2.2.1 [1.5.2]', 2, 1, '', '20171028220948757.zip', 'Плагин&nbsp;отвечает за&nbsp;<strong>автоматическую рассылку</strong>&nbsp;полезной информации (<em>Настраивается в конфигурации</em>) в общем игровом чате.', 'http://minecraft-mods.ru/uploads/posts/2013-05/1367866020_automessage.png', '/plugins/', NULL, NULL, 12),
(5, 'https://zon.su/tmp/repository/20171028221120369.zip', 'ChatGuard v5.8 [1.5.2]', 2, 1, '', '20171028221120369.zip', 'Вы можете&nbsp;<strong>избавиться</strong>&nbsp;от&nbsp;сквернословия,&nbsp;спама,&nbsp;флуда&nbsp;раз и навсегда!', 'http://minecraft-mods.ru/uploads/posts/2013-11/1385049746_a04513db33d6.png', '/plugins/', NULL, NULL, 13),
(5, 'https://zon.su/tmp/repository/20171028221422823.zip', 'ClearLagg', 2, 1, '', '20171028221422823.zip', 'Возможность удаление всего дропа в Игровом мире, с целью уменьшить нагрузку, тем самым убрать лаги.', 'https://setcraft.ru/uploads/posts/2015-09/thumbs/1443502715_1400405787_dxd0o.png', '/plugins/', NULL, NULL, 14),
(5, 'https://zon.su/tmp/repository/20171028221541280.zip', 'PermissionsEx', 2, 1, '', '20171028221541280.zip', '<strong>Самый знаменитый и удобный</strong>&nbsp;плагин&nbsp;распределения прав между всеми&nbsp;<em>игроками</em>!', 'http://minecraft-mods.ru/uploads/posts/2013-06/1370796129_logo_sketch.png', '/plugins/', NULL, NULL, 15),
(1, 'https://zon.su/tmp/repository/20180121124602574.zip', 'SA-MP 0.3.8 RC3', 0, 1, '', '20180121124602574.zip', 'The 0.3.8 version of SA-MP will feature&nbsp;<strong>server-side custom models</strong>. Right now custom objects and custom player skins are supported, with more types planned for the future. Since this feature potentially has a large scope for some servers, 0.3.8 is being placed in to RC early. This gives server owners plenty of time to plan. These new features will take some time to formalise, so be please be patient with the release.<br /><br />Although there are several new security features related to custom models, these are not yet enabled in the current build. Only use the RC version on servers you trust as&nbsp;<u>there could be unknown security flaws</u>&nbsp;in GTA:SA''s model formats.</p>\r\n<p><u>SA-MP 0.3.8 RC3 Client/Server update</u><br /><br />- Adds the first layer of security checks for model/texture file downloads. More security features will be added as the 0.3.8 RC period progresses. For now, only join servers where you trust the server owner.<br />- You can now change the location of the model cache folder using the Tools &gt; Settings menu in the SA-MP server browser.<br />- Objects created from models downloaded from the server are now freed from memory after they are deleted.<br />- Adds data compression to file downloads. Note: Downloads with thousands of small files can still be slow.</p>\r\n<p>&nbsp;</p>', 'http://forum.sa-mp.com/images/samp/logo_forum.gif', '/', '10', NULL, 19),
(7, 'https://zon.su/tmp/repository/20180122181807260.zip', 'Чистый сервер Build 5787', 4, 1, '', '20180122181807260.zip', 'Описание:&nbsp;Абсолютно чистый готовый сервер для Linux безо всяких дополнительных плагинов. C его помощью Вы сэкономите время отказавшись от самостоятельной загрузки чистой серверной части с hldsupdatetool, настройки metamod`а и даже установки amxmodx. Все это уже сделано за Вас, Вам остается лишь установить его и наслаждаться игрой. Кроме того, за счет использования последних билдов всех установленных программ Вы можете не беспокоиться о безопасности вашего сервера и его видимости в интернете, мы позаботились о том, чтобы эти "плюшки" уже присутствовали в вашем сервере.&nbsp;<strong>Включает в себя:</strong>&nbsp;1. Обновленную серверную платформу Aug 2012 (5787)&nbsp;2. AmxModX 1.8.2 build 26&nbsp;3. Dproto 0.9.179&nbsp;<strong>Особенности сервера:</strong>&nbsp;1. Сервер виден в интернете&nbsp;2. Сервер на 2 протокола (47/48, а также steam/non steam)&nbsp;3. Сервер не содержит сторонних плагинов&nbsp;4. Используются только самые свежии версии ПО&nbsp;5. Данная сборка работает на любом дистрибутиве Linux&nbsp;', 'http://cdn.akamai.steamstatic.com/steam/apps/10/header.jpg?t=1436833478', '/', '0', NULL, 20),
(1, 'http://zon.su/tmp/repository/20180131223129464.zip', 'SA-MP 0.3x R2', 4, 1, '', '20180131223129464.zip', 'A new version of SA-MP (0.3x) is on its way. We''re making an RC/beta available to server scripters so you can preview the new features before release. If you''ve been following SA-MP releases for a while, you''ll know that the (x) version means this will likely be the final release in the current (0.3) branch.', 'http://forum.sa-mp.com/images/samp/logo_forum.gif', '/', '100', NULL, 21),
(1, '', 'SA-MP 0.3z R4', 0, 1, '', '', '', '', '', '0', 0, 22),
(5, '', 'Сборка Minecraft 1 5 2 HiTECH', 0, 1, '', '', '', '', '', '0', 0, 23);

-- --------------------------------------------------------

--
-- Структура таблицы `servers_firewalls`
--

CREATE TABLE IF NOT EXISTS `servers_firewalls` (
  `firewall_id` int(10) NOT NULL AUTO_INCREMENT,
  `server_id` int(8) DEFAULT NULL,
  `server_ip` text,
  `firewall_add` datetime DEFAULT NULL,
  PRIMARY KEY (`firewall_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `servers_owners`
--

CREATE TABLE IF NOT EXISTS `servers_owners` (
  `owner_id` int(10) NOT NULL AUTO_INCREMENT,
  `server_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `owner_status` int(11) NOT NULL,
  `owner_add` datetime DEFAULT NULL,
  PRIMARY KEY (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `servers_stats`
--

CREATE TABLE IF NOT EXISTS `servers_stats` (
  `server_id` int(11) DEFAULT NULL,
  `server_stats_date` datetime DEFAULT NULL,
  `server_stats_players` int(11) DEFAULT NULL,
  `server_stats_cpu` int(11) NOT NULL,
  `server_stats_ram` int(11) NOT NULL,
  `server_stats_hdd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `ticket_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `ticket_name` varchar(32) DEFAULT NULL,
  `ticket_status` int(1) DEFAULT NULL,
  `ticket_date_add` datetime DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tickets_category`
--

CREATE TABLE IF NOT EXISTS `tickets_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `category_status` int(11) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tickets_messages`
--

CREATE TABLE IF NOT EXISTS `tickets_messages` (
  `ticket_message_id` int(10) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `ticket_message` text,
  `ticket_message_date_add` datetime DEFAULT NULL,
  PRIMARY KEY (`ticket_message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(96) DEFAULT NULL,
  `user_password` varchar(32) DEFAULT NULL,
  `user_firstname` varchar(32) DEFAULT NULL,
  `user_lastname` varchar(32) DEFAULT NULL,
  `user_status` int(1) DEFAULT NULL,
  `user_balance` decimal(10,2) DEFAULT NULL,
  `user_restore_key` varchar(32) DEFAULT NULL,
  `user_access_level` int(1) DEFAULT NULL,
  `user_date_reg` datetime DEFAULT NULL,
  `user_img` varchar(250) NOT NULL DEFAULT '/application/public/img/user.png',
  `user_online_date` text NOT NULL,
  `user_promo_date` date NOT NULL,
  `user_activate` int(1) NOT NULL,
  `key_activate` text NOT NULL,
  `ref` int(11) NOT NULL,
  `rmoney` decimal(10,2) DEFAULT NULL,
  `user_vk_id` varchar(96) DEFAULT NULL,
  `test_server` varchar(2) NOT NULL DEFAULT '2',
  `user_promised_pay` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `waste`
--

CREATE TABLE IF NOT EXISTS `waste` (
  `waste_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `waste_ammount` decimal(10,2) DEFAULT NULL,
  `waste_status` int(1) DEFAULT NULL,
  `waste_usluga` varchar(120) DEFAULT NULL,
  `waste_date_add` datetime DEFAULT NULL,
  PRIMARY KEY (`waste_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `webhost`
--

CREATE TABLE IF NOT EXISTS `webhost` (
  `web_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `tarif_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `web_password` varchar(32) NOT NULL,
  `web_domain` varchar(32) NOT NULL,
  `web_status` int(11) NOT NULL,
  `web_date_reg` datetime DEFAULT NULL,
  `web_date_end` datetime DEFAULT NULL,
  `pdomen1` varchar(32) NOT NULL,
  `pdomen2` varchar(32) NOT NULL,
  `pdomen3` varchar(32) NOT NULL,
  `pdomen4` varchar(32) NOT NULL,
  PRIMARY KEY (`web_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `web_tarifs`
--

CREATE TABLE IF NOT EXISTS `web_tarifs` (
  `tarif_id` int(11) NOT NULL AUTO_INCREMENT,
  `tarif_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `tarif_price` decimal(10,2) NOT NULL,
  `tarif_status` int(11) NOT NULL,
  PRIMARY KEY (`tarif_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `web_tarifs`
--

INSERT INTO `web_tarifs` (`tarif_id`, `tarif_name`, `tarif_price`, `tarif_status`) VALUES
(1, 'Стандарт', 20.00, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
