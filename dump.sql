--
-- Database: `lab`
--
CREATE DATABASE IF NOT EXISTS `lab` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `lab`;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `teacher_id`, `name`, `birthday`, `gender`, `photo`) VALUES
(1, 42, 'Влад Лукаш', '1995-03-03', 1, '43fa7dca255ff8f70faa945b0fc32514.jpg'),
(2, 42, 'Елизавета Авета', '1995-03-03', 0, '2a4787fd092f417ff6117ae07c8d3439.jpg'),
(3, 45, 'Миша Таксист', '2004-12-29', 1, 'e98090ba037d09b5904cdf9b3c3ae68c.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biography` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `experience` date NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `biography`, `experience`, `photo`) VALUES
(1, 'Илькин Агаев', 'Агаев Илькин Фархадович профессиональный математик и программист работающий в известной корпорации Arbus Azerbaijan. Ветеран Карабаха.', '1999-12-16', '41ac4c7a199a2b3a7b8a5b4602a05ee2.jpg'),
(2, 'Владимир Путин', 'Российский президент Владимир Путин высказался по поводу заявлений своего американского коллеги Дональда Трампа о том, что Москва продолжает платить деньги его сопернику на выборах демократу Джо Байдену фцв фцв цфвцфв ', '2004-12-28', '38b222116431b34ed8472db2039aa8e5.jpg'),
(3, 'Рамзан Кадыров', 'Российский государственный и политический деятель. Глава Чеченской Республики с 5 апреля 2011. Президент Чеченской Республики с 5 апреля 2007 по 5 апреля 2011. Председатель правительства Чеченской Республики с 4 марта 2006 по 10 апреля 2007. Член Высшего совета партии Единая Россия', '1985-11-07', '3f660c76f196d3de6656a897d0ca0ae0.png'),
(4, 'Алексей Старый', 'В более широком смысле, программирование процесс создания программ, то есть разработка программного обеспечения. Большая часть работы программиста связана с написанием исходного кода на одном из языков программирования', '1999-11-27', '50ba45c6241712ea328b7f985c330e18.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `social` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `name`, `email`, `social`) VALUES
(1, 'Xynusob2', '$2y$10$UYOumZpr5f/muIpTK7EPLu5.hCXpVU2OBlfzqf4qZMGSGEqAEeXw2', '', 'dawdawd@wada.ru', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);
ALTER TABLE `students` ADD FULLTEXT KEY `name` (`name`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `teachers` ADD FULLTEXT KEY `teacher` (`name`,`biography`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`) USING BTREE,
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `social` (`social`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `teacher_id` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
