-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Фев 05 2024 г., 08:08
-- Версия сервера: 10.11.6-MariaDB-1:10.11.6+maria~ubu2004
-- Версия PHP: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kosinov_flower_shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Cart`
--

CREATE TABLE `Cart` (
  `id` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Cart`
--

INSERT INTO `Cart` (`id`, `itemId`, `amount`, `userId`) VALUES
(18, 1, 2, 1),
(22, 1, 2, 4),
(23, 10, 1, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `Category`
--

CREATE TABLE `Category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Category`
--

INSERT INTO `Category` (`id`, `name`) VALUES
(1, 'Цветы'),
(2, 'Упаковка'),
(3, 'Дополнительно');

-- --------------------------------------------------------

--
-- Структура таблицы `Items`
--

CREATE TABLE `Items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `country` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `color` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `create_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Items`
--

INSERT INTO `Items` (`id`, `name`, `image`, `price`, `country`, `category`, `color`, `amount`, `create_time`) VALUES
(1, 'Фиалки', '/web/image_storage/d3Z27f-mhDqHlArRD9aIsU364AH02ujsE_4EELEuY-60Ep2Avp.jpg', 122.50, 'Испания', 1, 'Фиолетовый', 8, '2024-01-17 14:53:48'),
(2, 'Тюльпаны', '/web/image_storage/V4Mk9uX7f7uDDa7g1L4BWbbk_r7cfpAwUCqcoM2O8u122SmraH.jpg', 100.00, 'Россия', 1, 'Красный', 125, '2024-01-17 14:59:33'),
(3, 'Обёртка с блёстками прозрачная', '/web/image_storage/kExYiWBJ9qFjPgcP3OfShobQ5e4vES7fhuZo2ZrC3GOlQkDAju.jpg', 50.00, 'Китай', 2, 'Прозрачный', 94, '2024-01-17 15:03:15'),
(4, 'Пакет подарочный', '/web/image_storage/wXgKXHfXIpI-1zjaHmiTpvJtDoxzgUbreXYIvXeowystvTl7tV.jpg', 170.00, 'Вьетнам', 2, 'Белый', 20, '2024-01-17 15:04:09'),
(5, 'Ваза хрустальная', '/web/image_storage/KzQwifTUrS9kYque76FzvfDA6hJ8pCioHGdp40K9y9dYBBq7Fd.jpg', 600.00, 'Франция', 3, 'Белый', 12, '2024-01-17 15:04:58'),
(7, 'Горшок для цветов', '/web/image_storage/w_ruFs5AA3r3EsVB52WP8dZ78L_-HATeQIjzmv0R_v8IPhZM71.jpg', 200.00, 'Китай', 3, 'Коричневый', 22, '2024-01-21 22:29:02'),
(9, 'Букет роз', '/web/image_storage/1n_e_zEgk1CoscCJDHVQqRe27L9D4WzZc7xvsEVFoDjtjJDt_t.jpeg', 240.00, 'Беларусь', 1, 'Розовый', 21, '2024-01-22 12:15:46');

-- --------------------------------------------------------

--
-- Структура таблицы `Orders`
--

CREATE TABLE `Orders` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `order_time` datetime NOT NULL DEFAULT current_timestamp(),
  `idItem` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` enum('Новый','Подтвержден','Отменен','') NOT NULL DEFAULT 'Новый',
  `reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Orders`
--

INSERT INTO `Orders` (`id`, `userId`, `order_time`, `idItem`, `amount`, `status`, `reason`) VALUES
(1, 4, '2024-01-23 13:49:29', 1, 11, 'Подтвержден', NULL),
(2, 4, '2024-01-23 13:49:29', 3, 5, 'Отменен', 'Склад сгорел'),
(3, 4, '2024-01-23 13:49:29', 5, 1, 'Новый', NULL),
(4, 4, '2024-01-23 13:49:29', 4, 1, 'Новый', NULL),
(5, 4, '2024-01-23 13:49:29', 9, 1, 'Новый', NULL),
(7, 4, '2024-01-23 13:53:53', 7, 5, 'Новый', NULL),
(8, 4, '2024-01-23 15:08:16', 2, 1, 'Новый', NULL),
(9, 4, '2024-01-23 15:09:03', 3, 1, 'Новый', NULL),
(10, 4, '2024-01-23 15:43:45', 2, 10, 'Новый', NULL),
(11, 4, '2024-01-23 16:20:19', 4, 1, 'Новый', NULL),
(12, 4, '2024-01-25 13:46:28', 1, 2, 'Новый', NULL),
(13, 4, '2024-01-25 13:46:28', 5, 1, 'Новый', NULL),
(14, 1, '2024-01-25 14:00:52', 1, 1, 'Новый', NULL),
(15, 4, '2024-01-25 14:27:06', 4, 1, 'Новый', NULL),
(17, 4, '2024-01-25 15:55:15', 1, 10, 'Отменен', 'Нет в наличии'),
(18, 4, '2024-01-25 15:57:12', 7, 9, 'Новый', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `patronymic` varchar(255) DEFAULT NULL,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` int(11) DEFAULT 0,
  `access_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`id`, `name`, `surname`, `patronymic`, `login`, `email`, `password`, `isAdmin`, `access_token`) VALUES
(1, 'admin', '1', '', 'admin', 'admin@yandex.ru', 'admin44', 1, ''),
(4, 'Дмитрий', 'Косинов', '', 'qq', 'dima@yandex.com', 'dima12345', 0, NULL),
(5, 'Леонид', 'Ильюшенков', 'Владимирович', 'leonid', 'admin1@yandex.ru', '12345', 0, NULL),
(6, 'Леонид', 'Ильюшенков', 'Владимирович', 'leonid', 'forest@yandex.ru', '123456', 0, NULL),
(8, 'Леонид', 'Ильюшенков', '', 'leonid123', 'admin@yandex1.ru', '123123', 0, NULL),
(12, 'Дмитрий', 'Косинов', '', 'test', 'a@yandex.ru', '123123', 0, NULL),
(13, 'Анастасия', 'Кудряшова', 'Алексеевна', 'Ann', 'Ann@mail.ru', '12345678', 0, NULL),
(14, 'Леонид', 'Ильюшенков', 'Владимирович', 'Leonid', 'admin@mail.ru', '123456', 0, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Cart`
--
ALTER TABLE `Cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_item` (`itemId`);

--
-- Индексы таблицы `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Items`
--
ALTER TABLE `Items`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Cart`
--
ALTER TABLE `Cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `Category`
--
ALTER TABLE `Category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `Items`
--
ALTER TABLE `Items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `Orders`
--
ALTER TABLE `Orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
