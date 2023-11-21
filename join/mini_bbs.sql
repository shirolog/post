-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2023-11-01 14:05:38
-- サーバのバージョン： 10.4.28-MariaDB
-- PHP のバージョン: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `mini_bbs`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `members`
--

INSERT INTO `members` (`id`, `name`, `email`, `password`, `picture`, `created`, `modified`) VALUES
(1, 'user01', 'user01@gmail.com', '011c945f30ce2cbafc452f39840f025693339c42', '20231028064039fish.png', '2023-10-28 13:40:42', '2023-10-28 04:40:42'),
(2, 'userA', 'userA@gmail.com', '011c945f30ce2cbafc452f39840f025693339c42', '20231028064100Gardening.png', '2023-10-28 13:41:09', '2023-10-28 04:41:09');

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `member_id` int(11) NOT NULL,
  `reply_posts_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `posts`
--

INSERT INTO `posts` (`id`, `message`, `member_id`, `reply_posts_id`, `created`, `modified`) VALUES
(1, 'yyy', 2, 0, '2023-10-29 18:48:17', '2023-10-29 09:48:17'),
(2, '@userA yyy\r\nkkk', 2, 1, '2023-10-29 18:48:24', '2023-10-29 09:48:24'),
(3, '新規メッセージ', 2, 0, '2023-10-29 18:49:06', '2023-10-29 09:49:06'),
(4, '新規コメ', 1, 0, '2023-10-29 18:57:28', '2023-10-29 09:57:28'),
(5, 'コメント2', 1, 0, '2023-10-29 18:57:47', '2023-10-29 09:57:47'),
(6, '@user01 コメント2\r\n->返信テスト', 1, 5, '2023-10-29 18:58:00', '2023-10-29 09:58:00'),
(7, 'aa', 1, 0, '2023-10-29 19:02:04', '2023-10-29 10:02:04'),
(8, 'bb', 1, 0, '2023-10-29 19:02:08', '2023-10-29 10:02:08'),
(9, 'vv', 1, 0, '2023-10-29 19:02:11', '2023-10-29 10:02:11'),
(10, '@user01 vv\r\nlll', 1, 9, '2023-10-29 19:02:20', '2023-10-29 10:02:20'),
(11, '@user01 @user01 vv\r\nlll\r\nppp', 1, 10, '2023-10-29 19:02:28', '2023-10-29 10:02:28'),
(14, 'llll', 2, 0, '2023-10-30 11:54:53', '2023-10-30 02:54:53'),
(15, '@user01 aa\r\n->返信bb', 2, 7, '2023-10-30 11:55:24', '2023-10-30 02:55:24'),
(27, 'ｇｇｇｇ', 1, 0, '2023-10-30 23:25:33', '2023-10-30 14:25:33'),
(29, '<a href=\"https://news.yahoo.co.jp/articles/89cdd3c7f998a25918fdc6e16d5c37414a514ec3\" target=\"_blank\">https://news.yahoo.co.jp/articles/89cdd3c7f998a25918fdc6e16d5c37414a514ec3</a>', 1, 0, '2023-10-31 17:03:07', '2023-10-31 08:03:07'),
(37, '記事<a href=\"https://news.yahoo.co.jp/articles/15bc5fed8463639bcf82aa710ba0089e32f063b9\" target=\"_blank\">https://news.yahoo.co.jp/articles/15bc5fed8463639bcf82aa710ba0089e32f063b9</a>', 1, 0, '2023-11-01 21:56:01', '2023-11-01 12:56:01'),
(39, 'テストコメント', 1, 0, '2023-11-01 21:57:23', '2023-11-01 12:57:23'),
(40, '@user01 テストコメント\r\n>>返信1', 1, 39, '2023-11-01 21:57:32', '2023-11-01 12:57:32'),
(42, '@user01 @user01 テストコメント\r\n>>返信1\r\n>>返信2', 2, 40, '2023-11-01 21:58:26', '2023-11-01 12:58:26'),
(43, '天気予報はどこで調べたらいい？', 2, 0, '2023-11-01 22:00:36', '2023-11-01 13:00:36'),
(44, '@userA 天気予報はどこで調べたらいい？\r\n>>ここを見たらいいと思う<a href=\"https://weather.yahoo.co.jp/weather/jp/37/7200/37206.html\" target=\"_blank\">https://weather.yahoo.co.jp/weather/jp/37/7200/37206.html</a>', 1, 43, '2023-11-01 22:01:44', '2023-11-01 13:01:44'),
(45, '@user01 @userA 天気予報はどこで調べたらいい？\r\n>>ここを見たらいいと思う<a href=\"https://weather.yahoo.co.jp/weather/jp/37/7200/37206.html\" target=\"_blank\">https://weather.yahoo.co.jp/weather/jp/37/7200/37206.html</a>\r\n>>分かった、ありがとう。', 2, 44, '2023-11-01 22:03:01', '2023-11-01 13:03:01');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
