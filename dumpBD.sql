-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 24 2022 г., 09:10
-- Версия сервера: 10.3.16-MariaDB
-- Версия PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `stock_market`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `account` decimal(16,2) NOT NULL,
  `blocked` tinyint(4) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'client',
  `admin` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `account`, `blocked`, `status`, `admin`) VALUES
(1, 'Baffet', 'baffet@usa.com', '$2y$10$eFRz.eQPW/FBeEAnFcMY/OmI2F9WCDt7LNPgHkGKdSxDALFbjzaCm', '644.46', 1, 'client', 0),
(3, 'admin', 'admin@tripled.ru', '$2y$10$aTxXCpONgCryVtr3hKtzNur9TtjYK4DFmb5sFhmD3/EYaGaTSGjAi', '39.03', 0, 'admin', 0),
(4, 'Bill', 'bill@usa.com', '$2y$10$OTDjsu4Tr/aQO.MI1./vc.pweNGzCOM2chu6XJEVr.zWbx6nfZK5m', '305.00', 0, 'only read', 0),
(5, 'Elon', 'elon@usa.com', '$2y$10$Z3OgvOQ7Z.1i8Uc9cVx6seOTLljF6USh8TPnHQagqiDOPcje96rfm', '0.00', 0, 'admin', 0),
(6, 'Mark', 'mark@usa.com', '$2y$10$zh8jUmPRtV7KAs/Hu6yiM.9Ahix4IRg/pBEmMXpgczsR3EwTfoj3u', '0.00', 0, 'client', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_stock`
--

CREATE TABLE `user_stock` (
  `user_id` int(11) NOT NULL,
  `ticker` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `user_stock`
--

INSERT INTO `user_stock` (`user_id`, `ticker`, `amount`) VALUES
(3, 'EUR', 5),
(3, 'USD', 1),
(3, 'GBP', 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
