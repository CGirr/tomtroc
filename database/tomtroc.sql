-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 28 août 2025 à 16:50
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tomtroc`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `cover` varchar(255) DEFAULT 'images/default-cover.svg',
  `description` varchar(1000) NOT NULL,
  `available` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id`, `user_id`, `title`, `author`, `cover`, `description`, `available`, `created_at`) VALUES
(1, 17, 'The Kinkfolk Table', 'Nathan Williams', 'images/default-cover.svg', 'J\'ai récemment plongé dans les pages de \'The Kinfolk Table\' et j\'ai été enchanté par cette œuvre captivante. Ce livre va bien au-delà d\'une simple collection de recettes ; il célèbre l\'art de partager des moments authentiques autour de la table. \r\n\r\nLes photographies magnifiques et le ton chaleureux captivent dès le départ, transportant le lecteur dans un voyage à travers des recettes et des histoires qui mettent en avant la beauté de la simplicité et de la convivialité. \r\n\r\nChaque page est une invitation à ralentir, à savourer et à créer des souvenirs durables avec les êtres chers. \r\n\r\n\'The Kinfolk Table\' incarne parfaitement l\'esprit de la cuisine et de la camaraderie, et il est certain que ce livre trouvera une place spéciale dans le cœur de tout amoureux de la cuisine et des rencontres inspirantes.', 0, '2025-07-31 12:56:29'),
(2, 17, 'Minimalist Graphics', 'Julia Schonlau', 'images/default-cover.svg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam mattis libero feugiat augue feugiat, et luctus enim sollicitudin. Morbi dolor magna, consequat ut orci ac, sagittis viverra metus. Nunc blandit, eros quis lobortis pellentesque, diam dolor aliquet lorem, sit amet tempor ligula quam rutrum metus. Sed aliquam bibendum fringilla. Nullam iaculis velit eu est lacinia, ut ullamcorper arcu interdum. In non laoreet eros, ut tempus risus. In hac habitasse platea dictumst. Pellentesque ut varius felis, sit amet porttitor augue. Nullam vel mi nec tellus ultricies dictum quis vel enim. Praesent consectetur lacinia velit, vitae vehicula est imperdiet id. Cras in eros hendrerit, rutrum nibh et, malesuada tortor. Nulla facilisi. Fusce id neque ipsum. Quisque et gravida diam.\n\n', 1, '2025-07-29 12:56:29'),
(3, 25, 'Esther', 'Alabaster', 'uploads/alabaster.png', 'Tempore perferendis', 1, '2025-07-29 12:58:47'),
(7, 25, 'Wabi Sabi', 'Beth Kempton', 'uploads/wabi.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam mattis libero feugiat augue feugiat, et luctus enim sollicitudin. Morbi dolor magna, consequat ut orci ac, sagittis viverra metus. Nunc blandit, eros quis lobortis pellentesque, diam dolor aliquet lorem, sit amet tempor ligula quam rutrum metus. Sed aliquam bibendum fringilla. Nullam iaculis velit eu est lacinia, ut ullamcorper arcu interdum. In non laoreet eros, ut tempus risus. In hac habitasse platea dictumst. Pellentesque ut varius felis, sit amet porttitor augue. Nullam vel mi nec tellus ultricies dictum quis vel enim. Praesent consectetur lacinia velit, vitae vehicula est imperdiet id. Cras in eros hendrerit, rutrum nibh et, malesuada tortor. Nulla facilisi. Fusce id neque ipsum. Quisque et gravida diam.\n\n', 1, '2025-07-29 13:00:27'),
(8, 25, 'Milk & honey', 'Rupi Kaur', 'uploads/milk.png', 'Etiam pretium finibus velit, sit amet consequat turpis imperdiet in. Nulla facilisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam ut elementum nibh. Pellentesque ac risus non magna vestibulum porttitor. Maecenas non tempor eros, id pellentesque massa. Sed vestibulum orci velit, id cursus lectus lobortis ac. Morbi sagittis felis id urna dignissim, id mollis arcu maximus. Ut finibus, dolor sed lacinia pulvinar, turpis massa sodales neque, a efficitur sapien nunc ac dolor. Nam nec felis sed dolor vestibulum aliquet at facilisis nibh.  Morbi ullamcorper finibus dui rhoncus iaculis. Vivamus et nisl euismod, semper libero ac, feugiat nisi. Integer blandit velit ex, id commodo felis ultricies a. Cras porttitor diam et ante mollis maximus. Proin vitae placerat nulla. Morbi ac pretium lectus.', 1, '2025-07-29 13:00:27'),
(14, 18, 'Esse ex consequatur', 'Perspiciatis culpa', 'images/default-cover.svg', 'Ipsum animi vel re', 1, '2025-08-01 10:20:07'),
(17, 17, 'Reiciendis aut sed e', 'Quis amet vel sit d', 'images/default-cover.svg', 'Ratione ad delectus', 1, '2025-08-04 10:24:06'),
(18, 23, 'Alias voluptatem Bl', 'Omnis dolor dolor en', 'images/default-cover.svg', 'Corporis ea veniam ', 1, '2025-08-04 10:24:06'),
(20, 18, 'Debitis qui rerum sa', 'Nisi dolorum quo sed', 'images/default-cover.svg', 'Mollitia et temporib', 1, '2025-08-04 10:25:31'),
(21, 25, 'Deleniti ipsum numq', 'Irure doloribus ipsa', 'images/default-cover.svg', 'Est explicabo Aut b', 0, '2025-08-04 12:26:27'),
(27, 17, 'Voluptas facere face', 'Ullamco velit suscip', 'uploads/46e3e844da21cd1d7c282f3c58abd340.jpg', 'Esse quia ut omnis', 1, '2025-08-15 21:48:44'),
(29, 17, 'Similique distinctio', 'Ipsum quia consequat', 'images/default-cover.svg', 'Ex blanditiis laboru', 0, '2025-08-15 21:52:54'),
(30, 17, 'Les Dépossédés', 'Ursula K. Le Guin', 'uploads/1e5ef1f30b28677a15b70b3e5df0a51a.jpg', 'Deux mondes se font face :\r\nAnarres, peuplé deux siècles plus tôt par des dissidents soucieux de créer enfin une société utopique vraiment libre, même si le prix à payer est la pauvreté.\r\nEt Urras qui a, pour les habitants d\'Anarres, conservé la réputation d\'un enfer, en proie à la tyrannie, à la corruption et à la violence. Shevek, physicien hors normes, a conscience que l\'isolement d\'Anarres condamne son monde à la sclérose. Et, fort de son invention, l\'ansible, qui permettra une communication instantanée entre tous les peuples de l\'Ekumène, il choisit de s\'exiler sur Urras en espérant y trouver une solution.\r\n\r\nCe roman, qui a obtenu les prix Hugo, Nebula et Locus, n\'a rien perdu aujourd\'hui de sa virulence politique ni de sa charge d\'aventures.\r\n\r\nAvec La Main gauche de la nuit, précédemment paru dans la même collection, c\'est un des chefs-d\'oeuvre d\'Ursula Le Guin.', 1, '2025-08-15 21:54:47'),
(31, 17, 'Dune – Tome 1', 'Frank Herbert', 'uploads/feb0dbaa02d46035c2c1055e26bd6a3f.jpg', 'Il n\'y a pas, dans tout l\'Empire, de planète plus inhospitalière que Dune. Partout des sables à perte de vue. Une seule richesse : l\'épice de longue vie, née du désert, et que tout l\'univers achète à n\'importe quel prix.\r\nRichesse très convoitée : quand Leto Atréides reçoit Dune en fief, il flaire le piège. Il aura besoin des guerriers Fremen qui, réfugiés au fond du désert, se sont adaptés à une vie très dure en préservant leur liberté, leurs coutumes et leur foi mystique. Ils rêvent du prophète qui proclamera la guerre sainte et qui, à la tête des commandos de la mort, changera le cours de l\'histoire.\r\nCependant les Révérendes Mères du Bene Gesserit poursuivent leur programme millénaire de sélection génétique ; elles veulent créer un homme qui concrétisera tous les dons latents de l\'espèce. Tout est fécond dans ce royaume, y compris ses défaillances.\r\nLe Messie des Fremen est-il déjà né dans l\'Empire ?', 1, '2025-08-15 22:18:04'),
(32, 25, 'Deserunt nulla qui t', 'Doloremque aut conse', 'uploads/28541a651211e365976ea58bc48604e9.jpg', 'Dolorum laborum Dol', 0, '2025-08-22 07:44:40'),
(34, 25, 'Aut nobis nostrum re', 'Non iste adipisci si', 'uploads/44356a63692da268554c9f09a6a71f28.jpg', 'Do exercitation magn', 1, '2025-08-28 13:26:31');

-- --------------------------------------------------------

--
-- Structure de la table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(10) UNSIGNED NOT NULL,
  `participant_one_id` int(10) UNSIGNED NOT NULL,
  `participant_two_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `conversations`
--

INSERT INTO `conversations` (`id`, `participant_one_id`, `participant_two_id`, `created_at`) VALUES
(11, 17, 17, '2025-08-22 09:53:54'),
(12, 25, 17, '2025-08-22 09:54:26'),
(13, 23, 24, '2025-08-22 15:57:23'),
(17, 23, 25, '2025-08-22 16:17:47'),
(18, 23, 17, '2025-08-28 15:30:40');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `conversation_id` int(10) UNSIGNED NOT NULL,
  `sender_id` int(10) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `sent_at` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `conversation_id`, `sender_id`, `content`, `sent_at`, `is_read`) VALUES
(55, 11, 17, 'Bonjour', '2025-08-22 09:53:59', 0),
(56, 12, 17, 'coucou', '2025-08-22 09:54:30', 1),
(57, 12, 25, 'Comment all', '2025-08-28 15:28:37', 1),
(58, 12, 25, 'Bonsoir', '2025-08-28 15:28:55', 1),
(59, 18, 17, 'Bonsoir', '2025-08-28 15:30:44', 0),
(60, 12, 25, 'Salutations', '2025-08-28 15:54:14', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `register_date` date NOT NULL,
  `profile_picture` varchar(255) NOT NULL DEFAULT 'images/default-profile.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `login`, `email`, `password`, `register_date`, `profile_picture`) VALUES
(16, 'Praesentium et non d', 'vanoles@mailinator.com', '$2y$10$1eJ6AdLztSAYFGaLjLE.keSvP3pj.0I6du7hmLHC0rgmMYIvdaAGW', '2023-07-06', 'images/default-profile.png'),
(17, 'CoraLivres', 'isydia@gmail.com', '$2y$10$FKBhvDLgbl27o9T7nr8nRePzIfHisEasWcEZk5bdI4JsJmLgFBCOS', '2019-07-05', 'images/default-profile.png'),
(18, 'louise', 'louisesoulier789@gmail.com', '$2y$10$kJd6AbuFP8E/bRO45.efxeYvBpZtN4jEQuoFlVJl0h24nBoMKQ.76', '2025-07-21', 'images/default-profile.png'),
(23, 'Consequatur Veniam', 'riryme@mailinator.com', '$2y$10$kqAsghKBE9IddbB7.K9dkuO/WKQPB3sP8lzygqkDgccpL9lrFgbNe', '2025-07-24', 'images/default-profile.png'),
(24, 'Dolor ea est non ne', 'wevobefum@mailinator.com', '$2y$10$jUwHh03A53SAkHsGZxHwjezjwIY4R4sfqgZkQ.zWyaM8so0xL2iWi', '2025-07-25', 'images/default-profile.png'),
(25, 'Isydia', 'coraline.girr@gmail.com', '$2y$10$mEgXgM.IHj8t5Y3olXqMHePpd7YjAni8jbPuZIapvrSZxLf7mnQyG', '2025-07-28', 'images/default-profile.png'),
(26, 'Voluptate ea amet d', 'cuvabuwagy@mailinator.com', '$2y$10$KKPGaxKFqzCC44yyS.5Aqe84PgYiop2OBNjOCJMoQskl3PHrqkxqC', '2025-07-28', 'images/default-profile.png'),
(34, 'Optio rerum tempora', 'kunasysuz@mailinator.com', '$2y$10$b21NKo8tscyK41QqUdrWWukF6v2jcTVdrqlq.XOpEUIOFZFv..D/.', '2025-07-28', 'images/default-profile.png'),
(41, 'In laborum Sit in', 'bufusup@mailinator.com', '$2y$10$8u8c1VYl9EuPUOKbnTnxfeL5039NCFomjznGQtQtBD93kuf8gKb2W', '2025-08-08', 'images/default-profile.png'),
(42, 'Sit dolores dolores', 'dasakubata@mailinator.com', '$2y$10$f45Q5b2ANHvudNv1gbns4uHgzD/tmJAvaK8gp8Gkepz8zpsD9ASJ.', '2025-08-15', 'images/default-profile.png'),
(44, 'Qui quidem non place', 'hipy@mailinator.com', '$2y$10$L7IFwHyj43Y59a4VYi59m.kOpOb/3HPzhlSs25QnSiVmU.jP2sy2e', '2025-08-18', 'images/default-profile.png'),
(46, 'Exercitation cum dol', 'tyqobujido@mailinator.com', '$2y$10$KjN6uXu2tQA6oX.GZpLBWuawMYC9LHN3Tz0aXrRB0G87PafdXX3wW', '2025-08-22', 'images/default-profile.png'),
(47, 'Sit proident magna', 'cehy@mailinator.com', '$2y$10$QxpzLtd0Tlwb2D7y3vZzd.ZJz8Dkhbeiq6JVwOJzc8yirzIN1V186', '2025-08-28', 'images/default-profile.png'),
(48, 'Eaque praesentium ea', 'raqovicuno@mailinator.com', '$2y$10$U/bPJI1SJYNhx4kL88/pHur/h3LcDVXqRbyyDtIeWcrhK21JeeWWS', '2025-08-28', 'images/default-profile.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_conversation_pair` (`participant_one_id`,`participant_two_id`),
  ADD KEY `conversations_ibfk_2` (`participant_two_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_ibfk_1` (`conversation_id`),
  ADD KEY `messages_ibfk_2` (`sender_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_ibfk_1` FOREIGN KEY (`participant_one_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversations_ibfk_2` FOREIGN KEY (`participant_two_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
