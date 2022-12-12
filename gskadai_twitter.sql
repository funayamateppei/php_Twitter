-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2022 年 12 月 12 日 15:17
-- サーバのバージョン： 10.4.27-MariaDB
-- PHP のバージョン: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gskadai_twitter`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `bookmark_table`
--

CREATE TABLE `bookmark_table` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- テーブルの構造 `follow_table`
--

CREATE TABLE `follow_table` (
  `id` int(11) NOT NULL,
  `my_id` int(11) NOT NULL,
  `your_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `follow_table`
--

INSERT INTO `follow_table` (`id`, `my_id`, `your_id`, `created_at`) VALUES
(20, 1, 6, '2022-12-12 18:59:21'),
(23, 1, 11, '2022-12-12 20:16:00'),
(25, 5, 1, '2022-12-12 20:16:42'),
(26, 10, 1, '2022-12-12 20:17:02'),
(27, 9, 1, '2022-12-12 20:17:36'),
(28, 9, 10, '2022-12-12 20:17:49'),
(29, 9, 11, '2022-12-12 20:17:53'),
(30, 16, 1, '2022-12-12 20:18:26'),
(32, 1, 14, '2022-12-12 20:19:04'),
(33, 1, 18, '2022-12-12 20:19:08'),
(34, 1, 12, '2022-12-12 20:19:13'),
(35, 1, 16, '2022-12-12 20:19:17'),
(36, 1, 15, '2022-12-12 20:19:18'),
(37, 1, 13, '2022-12-12 20:19:20'),
(38, 1, 17, '2022-12-12 20:19:23'),
(41, 1, 5, '2022-12-12 23:09:11');

-- --------------------------------------------------------

--
-- テーブルの構造 `like_table`
--

CREATE TABLE `like_table` (
  `id` int(11) NOT NULL,
  `like_check` int(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `like_table`
--

INSERT INTO `like_table` (`id`, `like_check`, `user_id`, `tweet_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 6, '2022-12-09 02:29:10', '2022-12-09 14:49:35'),
(2, 0, 1, 10, '2022-12-09 02:29:15', '2022-12-09 02:40:36'),
(3, 1, 5, 6, '2022-12-09 02:38:25', '2022-12-09 02:38:25'),
(4, 1, 5, 11, '2022-12-09 02:38:28', '2022-12-09 02:38:28'),
(5, 1, 5, 13, '2022-12-09 02:38:32', '2022-12-09 02:38:32'),
(6, 1, 7, 6, '2022-12-09 02:38:48', '2022-12-09 02:38:48'),
(7, 1, 7, 4, '2022-12-09 02:38:49', '2022-12-09 02:38:49'),
(8, 1, 7, 1, '2022-12-09 02:38:50', '2022-12-09 02:38:50'),
(9, 1, 1, 8, '2022-12-09 02:40:37', '2022-12-09 02:40:37'),
(10, 1, 1, 9, '2022-12-09 02:40:39', '2022-12-09 02:40:39'),
(11, 0, 1, 1, '2022-12-09 14:49:42', '2022-12-09 14:49:44');

-- --------------------------------------------------------

--
-- テーブルの構造 `myPage_table`
--

CREATE TABLE `myPage_table` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `img` varchar(300) NOT NULL,
  `freetext` varchar(128) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `myPage_table`
--

INSERT INTO `myPage_table` (`id`, `user_id`, `img`, `freetext`, `created_at`, `updated_at`) VALUES
(1, 1, './images/6392ca7234e9d', 'こんにちは', '2022-12-08 18:57:54', '2022-12-09 14:41:17'),
(4, 5, './images/639206fb71273', 'aaa', '2022-12-08 21:40:08', '2022-12-09 00:47:07'),
(5, 6, './images/63920aeb782aa', 'こんばんは', '2022-12-09 00:58:47', '2022-12-09 01:03:55');

-- --------------------------------------------------------

--
-- テーブルの構造 `reply_table`
--

CREATE TABLE `reply_table` (
  `id` int(11) NOT NULL,
  `text` varchar(128) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `tweet_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `reply_table`
--

INSERT INTO `reply_table` (`id`, `text`, `user_id`, `username`, `tweet_id`, `created_at`, `updated_at`) VALUES
(1, 'ジョコビッチ', 5, 'test1', 4, '2022-12-06 03:04:02', '2022-12-06 03:04:02'),
(3, 'ゴミ！', 5, 'test1', 4, '2022-12-06 03:27:40', '2022-12-06 03:27:40'),
(4, '食べました', 1, 'ふなむし', 1, '2022-12-06 03:58:24', '2022-12-06 03:58:24'),
(5, '何食べたんですか？', 5, 'test1', 1, '2022-12-06 03:59:51', '2022-12-06 03:59:51'),
(6, 'オムライス', 1, 'ふなむし', 1, '2022-12-06 04:00:24', '2022-12-06 04:00:24'),
(7, '惜しかった！', 1, 'ふなむし', 6, '2022-12-06 05:09:32', '2022-12-06 05:09:32'),
(8, 'wtf', 1, 'ふなむし', 8, '2022-12-06 13:50:11', '2022-12-06 13:50:11'),
(9, 'りんご', 1, 'ふなむし', 15, '2022-12-06 13:51:29', '2022-12-06 13:51:29'),
(10, 'ゴルバチョフ', 7, 'test5', 15, '2022-12-06 13:52:09', '2022-12-06 13:52:09');

-- --------------------------------------------------------

--
-- テーブルの構造 `tweet_table`
--

CREATE TABLE `tweet_table` (
  `id` int(11) NOT NULL,
  `text` varchar(128) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `tweet_table`
--

INSERT INTO `tweet_table` (`id`, `text`, `user_id`, `username`, `created_at`, `updated_at`) VALUES
(1, 'お腹減った', 1, 'ふなむし', '2022-11-30 04:18:12', '2022-12-07 17:38:24'),
(4, 'カシージャス', 1, 'ふなむし', '2022-12-02 04:08:49', '2022-12-02 04:08:49'),
(5, 'ガビ', 1, 'ふなむし', '2022-12-02 05:00:47', '2022-12-02 05:00:47'),
(6, '日本敗退！', 5, 'test1', '2022-12-02 06:23:30', '2022-12-06 03:38:59'),
(7, 'どうあんりつぅぅぅぅぅうううう', 6, 'test2', '2022-12-02 06:24:49', '2022-12-02 06:24:49'),
(8, '海外の方へ、\r\nブルーロックは実在します！', 6, 'test2', '2022-12-02 06:25:12', '2022-12-02 06:25:12'),
(9, '三笘のあおひげ', 1, 'ふなむし', '2022-12-02 06:26:06', '2022-12-02 06:26:06'),
(10, '伊藤純也の眉毛', 1, 'ふなむし', '2022-12-02 06:28:00', '2022-12-02 06:28:00'),
(11, '決勝トーナメント１試合目、\r\nvsクロアチア 12月6日 0:00~ キックオフ', 6, 'test2', '2022-12-02 06:29:12', '2022-12-02 06:29:12'),
(12, 'あああ', 6, 'test2', '2022-12-02 06:29:29', '2022-12-02 06:29:29'),
(13, 'bbb', 6, 'test2', '2022-12-02 06:29:35', '2022-12-02 06:29:35'),
(14, 'いいい', 7, 'test5', '2022-12-02 15:04:46', '2022-12-02 15:04:46'),
(15, 'しりとり', 1, 'ふなむし', '2022-12-06 13:51:23', '2022-12-06 13:51:23');

-- --------------------------------------------------------

--
-- テーブルの構造 `user_table`
--

CREATE TABLE `user_table` (
  `id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `email` varchar(128) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `user_table`
--

INSERT INTO `user_table` (`id`, `username`, `email`, `pass`, `created_at`, `updated_at`) VALUES
(1, 'ふなむし', 't.funayama0217@gmail.com', '$2y$10$Al//EQTxN8mzaFTqw7WoAuLqMvIvUOkTQoFsKRYidpiIy0XadAe8i', '2022-12-01 06:20:08', '2022-12-01 06:20:08'),
(5, 'test1', 'test1@gmail.com', '$2y$10$ON.l2ieBwRPnDaSfbxWg6eIRa7n3VTXc2I3jtYWp1JWdyPXQwLGfO', '2022-12-02 06:23:05', '2022-12-02 06:23:05'),
(6, 'test2', 'test2@gmail.com', '$2y$10$ocHehZLEC6VmRdnC/0rKNeF/7Uvw2mJBsZ4KKZcHPgU.4LgOWFcnW', '2022-12-02 06:24:18', '2022-12-02 06:24:18'),
(7, 'test5', 'test5@gmail.com', '$2y$10$.5H8lTCLpjK/2.K2PFiGFutvCr34TbMl9Up/bNzQ4LKJ37WuXQxpy', '2022-12-02 15:03:44', '2022-12-02 15:03:44'),
(8, 'test3', 'test3@gmail.com', '$2y$10$XcH4.wwLe8NSHviQaJcDjeAptosY91QDolHGZY7uG.mMwHwG0O5Se', '2022-12-12 20:06:08', '2022-12-12 20:06:08'),
(9, 'test4', 'test4@gmail.com', '$2y$10$zujfZ.D2wURbGs9OnVk4WeTYM0Dd7h3o1tTiOMEyLI25PGJNXChMu', '2022-12-12 20:06:26', '2022-12-12 20:06:26'),
(10, 'shohey', 'shohey@gmail.com', '$2y$10$ZEsMfPSLtxHYs6xnKkMGDePxW5xIxF1vAEgoO9IfKEK0PLTWtfAAm', '2022-12-12 20:10:53', '2022-12-12 20:10:53'),
(11, 'onisan', 'oni@gmail.com', '$2y$10$B9rSR9tQUJEGaZ3eRRm.9OBhQMUefNiXCUrlGh7o4muNvusHczLA.', '2022-12-12 20:11:13', '2022-12-12 20:11:13'),
(12, 'susan', 'susan@gmai.com', '$2y$10$.GSckg0XKaDB/oR1YbZ/8OrMaimR4a5ptOyH3cEoVRBJmyZB2yk92', '2022-12-12 20:11:42', '2022-12-12 20:11:42'),
(13, 'egosan', 'ego@gmail.com', '$2y$10$MwhvbhOe0l889VAc489jhuhCcLBDw9j2F1AWpsgOG6REbhj9CEYFK', '2022-12-12 20:12:00', '2022-12-12 20:12:00'),
(14, 'kubocchi', 'kubocchi@gmail.com', '$2y$10$ahlO1PN3OW/ArR5B.flXHusadMNtNBNOC2fKBcI6zp1hweIXXR9ty', '2022-12-12 20:12:27', '2022-12-12 20:12:27'),
(15, 'ayasan', 'ayasan@gmail.com', '$2y$10$n8.9pN7bJAIaClMHj1hvUuahQr7EVM72hX7h.RrAWqk1cG4NOgV5q', '2022-12-12 20:12:52', '2022-12-12 20:12:52'),
(16, 'acchan', 'acchan@gmail.com', '$2y$10$iQk938m8nexjH.CcFXuRJe5N7zbraJU2JXocaSxrVEZtJ6nKNplLy', '2022-12-12 20:13:11', '2022-12-12 20:13:11'),
(17, 'uekari', 'uekari@gmail.com', '$2y$10$Ge3xL6hgiC3VikpLrbfvROCefIe4RBAHYnHAeTf8uCNSPGlfCXeeS', '2022-12-12 20:13:28', '2022-12-12 20:13:28'),
(18, 'hiiiiikun', 'hiiiiikun@gmail.com', '$2y$10$4ZZwgeA3n5tytV.GX0UH..xhEwV2LcfkbTSi6Hxs4FxSLLpHWEY8u', '2022-12-12 20:14:04', '2022-12-12 20:14:04'),
(19, 'funayama', 'funayama@gmail.com', '$2y$10$ZyMoLTA5iZXpWmMBcy19k.0K7pZ55NpwRt5ORWp/mxqtf9aeiqd9G', '2022-12-12 20:14:41', '2022-12-12 20:14:41');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `follow_table`
--
ALTER TABLE `follow_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `like_table`
--
ALTER TABLE `like_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `myPage_table`
--
ALTER TABLE `myPage_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `reply_table`
--
ALTER TABLE `reply_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `tweet_table`
--
ALTER TABLE `tweet_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `follow_table`
--
ALTER TABLE `follow_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- テーブルの AUTO_INCREMENT `like_table`
--
ALTER TABLE `like_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- テーブルの AUTO_INCREMENT `myPage_table`
--
ALTER TABLE `myPage_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- テーブルの AUTO_INCREMENT `reply_table`
--
ALTER TABLE `reply_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- テーブルの AUTO_INCREMENT `tweet_table`
--
ALTER TABLE `tweet_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- テーブルの AUTO_INCREMENT `user_table`
--
ALTER TABLE `user_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
