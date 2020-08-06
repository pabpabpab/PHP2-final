-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 06 2020 г., 09:32
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `gbshop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `total_price` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `items`, `total_price`, `status`) VALUES
(18, 16, '{\"97\":{\"name\":\"товар 1\",\"price\":\"100.00\",\"main_img_name\":\"97_5f28f06b409890.jpg\",\"img_folder\":\"1\",\"count\":\"1\",\"totalPrice\":100},\"98\":{\"name\":\"товар 2\",\"price\":\"200.00\",\"main_img_name\":\"98_5f28f09f79b8d0.jpg\",\"img_folder\":\"1\",\"count\":\"2\",\"totalPrice\":400},\"99\":{\"name\":\"товар 3\",\"price\":\"300.00\",\"main_img_name\":\"99_5f28f0de9a5780.jpg\",\"img_folder\":\"1\",\"count\":\"3\",\"totalPrice\":900}}', '1400.00', 3),
(19, 16, '{\"103\":{\"name\":\"товар 7\",\"price\":\"700.00\",\"main_img_name\":\"103_5f28f19a55ac90.jpg\",\"img_folder\":\"1\",\"count\":\"2\",\"totalPrice\":1400},\"102\":{\"name\":\"товар 6\",\"price\":\"600.00\",\"main_img_name\":\"102_5f28f1774e5950.jpg\",\"img_folder\":\"1\",\"count\":\"1\",\"totalPrice\":600}}', '2000.00', 2),
(20, 17, '{\"100\":{\"name\":\"товар 4\",\"price\":\"400.00\",\"main_img_name\":\"100_5f28f11337b600.jpg\",\"img_folder\":\"1\",\"count\":\"1\",\"totalPrice\":400}}', '400.00', 1),
(21, 17, '{\"101\":{\"name\":\"товар 5\",\"price\":\"500.00\",\"main_img_name\":\"101_5f28f146d625a0.jpg\",\"img_folder\":\"1\",\"count\":\"2\",\"totalPrice\":1000},\"98\":{\"name\":\"товар 2\",\"price\":\"200.00\",\"main_img_name\":\"98_5f28f09f79b8d0.jpg\",\"img_folder\":\"1\",\"count\":\"1\",\"totalPrice\":200}}', '1200.00', 1),
(22, 18, '{\"102\":{\"name\":\"товар 6\",\"price\":\"600.00\",\"main_img_name\":\"102_5f28f1774e5950.jpg\",\"img_folder\":\"1\",\"count\":\"1\",\"totalPrice\":600},\"105\":{\"name\":\"товар 8\",\"price\":\"800.00\",\"main_img_name\":\"105_5f28f20abffb00.webp\",\"img_folder\":\"1\",\"count\":\"1\",\"totalPrice\":800}}', '1400.00', 1),
(23, 18, '{\"98\":{\"name\":\"товар 2\",\"price\":\"200.00\",\"main_img_name\":\"98_5f28f09f79b8d0.jpg\",\"img_folder\":\"1\",\"count\":\"3\",\"totalPrice\":600}}', '600.00', 1),
(24, 18, '{\"100\":{\"name\":\"товар 4\",\"price\":\"400.00\",\"main_img_name\":\"100_5f28f11337b600.jpg\",\"img_folder\":\"1\",\"count\":\"3\",\"totalPrice\":1200}}', '1200.00', 1),
(25, 5, '{\"98\":{\"name\":\"товар 2\",\"price\":\"200.00\",\"main_img_name\":\"98_5f28f09f79b8d0.jpg\",\"img_folder\":\"1\",\"count\":\"3\",\"totalPrice\":600}}', '600.00', 1),
(27, 5, '{\"101\":{\"name\":\"товар 5\",\"price\":\"500.00\",\"main_img_name\":\"101_5f28f146d625a0.jpg\",\"img_folder\":\"1\",\"count\":\"1\",\"totalPrice\":500},\"102\":{\"name\":\"товар 6\",\"price\":\"600.00\",\"main_img_name\":\"102_5f28f1774e5950.jpg\",\"img_folder\":\"1\",\"count\":\"4\",\"totalPrice\":2400},\"105\":{\"name\":\"товар 8\",\"price\":\"800.00\",\"main_img_name\":\"105_5f28f20abffb00.webp\",\"img_folder\":\"1\",\"count\":\"2\",\"totalPrice\":1600}}', '4500.00', 1),
(28, 16, '{\"98\":{\"name\":\"товар 2\",\"price\":\"200.00\",\"main_img_name\":\"98_5f28f09f79b8d0.jpg\",\"img_folder\":\"1\",\"count\":\"1\",\"totalPrice\":200},\"99\":{\"name\":\"товар 3\",\"price\":\"300.00\",\"main_img_name\":\"99_5f28f0de9a5780.jpg\",\"img_folder\":\"1\",\"count\":\"2\",\"totalPrice\":600},\"103\":{\"name\":\"товар 7\",\"price\":\"700.00\",\"main_img_name\":\"103_5f28f19a55ac90.jpg\",\"img_folder\":\"1\",\"count\":\"1\",\"totalPrice\":700}}', '1500.00', 1),
(29, 16, '{\"105\":{\"name\":\"товар 8\",\"price\":\"800.00\",\"main_img_name\":\"105_5f28f20abffb00.webp\",\"img_folder\":\"1\",\"count\":\"1\",\"totalPrice\":800},\"102\":{\"name\":\"товар 6\",\"price\":\"600.00\",\"main_img_name\":\"102_5f28f1774e5950.jpg\",\"img_folder\":\"1\",\"count\":\"2\",\"totalPrice\":1200}}', '2000.00', 1),
(30, 18, '{\"98\":{\"name\":\"товар 2\",\"price\":\"200.00\",\"main_img_name\":\"98_5f28f09f79b8d0.jpg\",\"img_folder\":\"1\",\"count\":\"2\",\"totalPrice\":400},\"99\":{\"name\":\"товар 3\",\"price\":\"300.00\",\"main_img_name\":\"99_5f28f0de9a5780.jpg\",\"img_folder\":\"1\",\"count\":\"1\",\"totalPrice\":300},\"101\":{\"name\":\"товар 5\",\"price\":\"500.00\",\"main_img_name\":\"101_5f28f146d625a0.jpg\",\"img_folder\":\"1\",\"count\":\"3\",\"totalPrice\":1500}}', '2200.00', 1),
(31, 18, '{\"98\":{\"name\":\"товар 2\",\"price\":\"200.00\",\"main_img_name\":\"98_5f28f09f79b8d0.jpg\",\"img_folder\":\"1\",\"count\":\"2\",\"totalPrice\":400},\"99\":{\"name\":\"товар 3\",\"price\":\"300.00\",\"main_img_name\":\"99_5f28f0de9a5780.jpg\",\"img_folder\":\"1\",\"count\":\"3\",\"totalPrice\":900}}', '1300.00', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(30) NOT NULL,
  `price` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `info` text NOT NULL,
  `img_folder` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `number_of_images` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `main_img_name` varchar(30) NOT NULL DEFAULT '',
  `view_number` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `number_of_comments` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `modification_time` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `user_id`, `name`, `price`, `info`, `img_folder`, `number_of_images`, `main_img_name`, `view_number`, `number_of_comments`, `modification_time`) VALUES
(97, 5, 'товар 1', '100.00', 'информация о товаре 1', 1, 3, '97_5f28f06b409890.jpg', 11, 2, 1596546899),
(98, 5, 'товар 2', '200.00', 'информация о товаре 2', 1, 1, '98_5f28f09f79b8d0.jpg', 10, 3, 1596544695),
(99, 5, 'товар 3', '300.00', 'информация о товаре 3', 1, 3, '99_5f28f0de9a5780.jpg', 10, 1, 1596544705),
(100, 5, 'товар 4', '400.00', 'информация о товаре 4', 1, 1, '100_5f28f11337b600.jpg', 8, 1, 1596544719),
(101, 5, 'товар 5', '500.00', 'информация о товаре 5', 1, 2, '101_5f28f146d625a0.jpg', 8, 0, 1596544729),
(102, 5, 'товар 6', '600.00', 'информация о товаре 6', 1, 1, '102_5f28f1774e5950.jpg', 8, 0, 1596544740),
(103, 5, 'товар 7', '700.00', 'информация о товаре 7', 1, 1, '103_5f28f19a55ac90.jpg', 7, 0, 1596544749),
(105, 5, 'товар 8', '800.00', 'информация о товаре 8', 1, 1, '105_5f28f20abffb00.webp', 8, 1, 1596544758);

-- --------------------------------------------------------

--
-- Структура таблицы `products_comments`
--

CREATE TABLE `products_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products_comments`
--

INSERT INTO `products_comments` (`id`, `product_id`, `text`) VALUES
(34, 97, 'комментарий 1 к товару 1'),
(35, 97, 'комментарий 2 к товару 1'),
(36, 98, 'комментарий 1 к товару 2'),
(37, 98, 'комментарий 2 к товару 2'),
(38, 98, 'комментарий 3 к товару 2'),
(39, 99, 'комментарий 1 к товару 3'),
(40, 100, 'комментарий 1 к товару 4'),
(41, 105, 'комментарий 1 к товару 8');

-- --------------------------------------------------------

--
-- Структура таблицы `products_images`
--

CREATE TABLE `products_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `img_name_info` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products_images`
--

INSERT INTO `products_images` (`id`, `product_id`, `img_name_info`) VALUES
(94, 76, '76_5f1ebb054cc910.jpg'),
(95, 76, '76_5f1ebb054d0791.jpg'),
(96, 76, '76_5f1ebb054d4612.jpg'),
(97, 79, '79_5f2034861bd760.jpg'),
(98, 79, '79_5f2034861c15e1.jpg'),
(99, 79, '79_5f2034861c5462.jpg'),
(106, 91, '91_5f2488dc4d50c0.jpg'),
(107, 91, '91_5f2488dc7616e1.jpg'),
(108, 91, '91_5f2488dc765562.jpg'),
(109, 94, '94_5f25e0e8324140.jpg'),
(110, 94, '94_5f25e0e833b841.jpg'),
(111, 96, '96_5f2669f78c8ee0.jpg'),
(112, 97, '97_5f28f06b409890.jpg'),
(113, 97, '97_5f28f06b4a9b31.jpg'),
(114, 97, '97_5f28f06b4ad9b2.jpg'),
(115, 98, '98_5f28f09f79b8d0.jpg'),
(116, 99, '99_5f28f0de9a5780.jpg'),
(117, 99, '99_5f28f0de9a9601.jpg'),
(118, 99, '99_5f28f0de9ad482.jpg'),
(119, 100, '100_5f28f11337b600.jpg'),
(120, 101, '101_5f28f146d625a0.jpg'),
(121, 101, '101_5f28f146d66421.jpg'),
(122, 102, '102_5f28f1774e5950.jpg'),
(123, 103, '103_5f28f19a55ac90.jpg'),
(125, 105, '105_5f28f20abffb00.webp');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(70) NOT NULL,
  `login` varchar(70) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `number_of_products` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `number_of_orders` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `password`, `is_admin`, `number_of_products`, `number_of_orders`) VALUES
(5, 'Alex', '123123@123.ru', '$2y$10$tYoSTP.zMJQfDdh9suD8weD167nTN3sHs7R8gCa6WNDM.3MEWpbSi', 1, 8, 0),
(16, 'Vova', '333@333.ru', '$2y$10$tSr9t7Ja09t15slBI56gpe0LoOSEDF.Z0A00UnUc6p1UlkCwrMOE.', 0, 0, 4),
(17, 'Misha', '456@456.ru', '$2y$10$f1/YZB//dY4mdj/CTWsD1uiSyC5aqYGDsfV1MJtt.J3dKju8Xdb5O', 0, 0, 2),
(18, 'Sasha', '777@777.ru', '$2y$10$WKykOMuT6vbaUEeitIr9QeHf26gr5YO/MW6OkKTNa5/edelQnsnzS', 0, 0, 5),
(19, 'Kuku', '555@555.ru', '$2y$10$kwe6simXPK6RvAdXUpNafOrCLGGLuAnl7vtUQIXTcodvaOIlc6Cfm', 0, 0, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_price` (`price`),
  ADD KEY `view_number` (`view_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `modification-time` (`modification_time`);

--
-- Индексы таблицы `products_comments`
--
ALTER TABLE `products_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `products_images`
--
ALTER TABLE `products_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT для таблицы `products_comments`
--
ALTER TABLE `products_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT для таблицы `products_images`
--
ALTER TABLE `products_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
