-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 07 août 2026 à 11:53
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
-- Base de données : `parc_national`
--

-- --------------------------------------------------------

--
-- Structure de la table `amenities`
--

CREATE TABLE `amenities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `amenities`
--

INSERT INTO `amenities` (`id`, `name`, `created_at`) VALUES
(1, 'Toilettes', '2026-01-22 14:33:04'),
(2, 'Wifi', '2026-01-22 14:33:04'),
(3, 'Restaurant', '2026-01-22 14:33:04'),
(4, 'Piscine', '2026-01-22 14:33:04'),
(5, 'Cuisine', '2026-01-22 14:33:04'),
(6, 'Aire de jeux', '2026-01-22 14:33:04');

-- --------------------------------------------------------

--
-- Structure de la table `campings`
--

CREATE TABLE `campings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `capacity` int(11) NOT NULL,
  `pool` tinyint(1) NOT NULL,
  `environment` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `activities` text NOT NULL,
  `location` varchar(150) DEFAULT NULL,
  `description` varchar(535) NOT NULL,
  `price` int(50) NOT NULL,
  `rating` double NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `campings`
--

INSERT INTO `campings` (`id`, `name`, `capacity`, `pool`, `environment`, `type`, `activities`, `location`, `description`, `price`, `rating`, `slug`) VALUES
(1, 'Camping Les Cigales', 150, 1, 'Ensoleillé', 'Familial', 'Plein air, Sites touristiques', 'Cassis, France', 'Le Camping Les Cigales propose une ambiance conviviale et familiale dans un cadre ensoleillé.\r\nLes vacanciers peuvent profiter d’une piscine, ainsi que d’équipements adaptés aux séjours de détente. Sa situation permet un accès facile aux activités de plein air et aux sites touristiques alentours.', 88, 4, 'camping-les-cigales-1'),
(2, 'Camping Garlaban', 120, 1, 'Provençal, verdoyant', 'Nature / Calme', 'Randonnée, Massifs, Sentiers', 'Aubagne, France', 'Situé au cœur d’un environnement naturel typiquement provençal, le Camping Garlaban offre un cadre calme et verdoyant, idéal pour les amoureux de la nature et de la randonnée.\r\nLe camping dispose d’une piscine, parfaite pour se rafraîchir après une journée d’exploration. Proche des massifs et sentiers, il constitue un excellent point de départ pour découvrir la région.', 105, 4.1, 'camping-garlaban-2'),
(3, 'Camping Ceyreste', 100, 0, 'Mer et collines', 'Tranquille', 'Plages, Randonnée', 'Ceyreste, France', 'Le Camping de Ceyreste est apprécié pour son atmosphère paisible et son implantation entre mer et collines.\r\nIdéal pour les campeurs à la recherche de tranquillité, il offre un accès rapide aux plages et aux sentiers de randonnée, tout en restant proche des commodités locales.', 90, 3.2, 'camping-ceyreste-3'),
(4, 'Camping La Baie', 80, 1, 'Proche mer', 'Littoral', 'Baignade, Découvertes locales', 'La Ciotat, France', 'Idéalement situé près du littoral, le Camping La Baie séduit par son cadre agréable et sa proximité avec la mer.\r\nIl met à disposition une piscine, offrant une alternative confortable aux plages voisines. C’est un lieu parfait pour des vacances alliant détente, baignade et découvertes locales.', 120, 5, 'camping-la-baie-4'),
(5, 'Camping Marseille Provence', 200, 1, 'Proximité ville', 'Urbain / Confort', 'Calanques, Littoral, Culture', 'Marseille, France', 'Le Camping Marseille Provence combine confort et accessibilité à proximité de la ville de Marseille.\r\nIl dispose d’une piscine, permettant aux vacanciers de se détendre tout en profitant d’un emplacement stratégique pour visiter les Calanques, le littoral et les attractions culturelles de la région.', 75, 4, 'camping-marseille-provence-5');

-- --------------------------------------------------------

--
-- Structure de la table `camping_amenities`
--

CREATE TABLE `camping_amenities` (
  `id` int(11) NOT NULL,
  `camping_id` int(11) NOT NULL,
  `amenity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `camping_amenities`
--

INSERT INTO `camping_amenities` (`id`, `camping_id`, `amenity_id`) VALUES
(1, 1, 1),
(2, 1, 6),
(3, 2, 1),
(4, 2, 2),
(5, 2, 3),
(6, 2, 6),
(7, 3, 1),
(8, 3, 4),
(9, 3, 5),
(10, 4, 1),
(11, 4, 2),
(12, 4, 3),
(13, 4, 4),
(14, 5, 1),
(15, 5, 4),
(16, 5, 5),
(17, 5, 6);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`) VALUES
(1, 'manage_users', 'Peut gérer les utilisateurs'),
(2, 'view_dashboard', 'Peut voir le dashboard'),
(3, 'edit_posts', 'Peut éditer les posts'),
(4, 'delete_posts', 'Peut supprimer des posts');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `date_resa` date NOT NULL,
  `nb_personnes` int(11) NOT NULL,
  `id_visiteur` int(11) DEFAULT NULL,
  `id_camping` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `resources`
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `state` enum('Bon','Fragile','Menace','Dégradé') NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `id_sentier` int(11) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `habitat` varchar(255) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL,
  `surface` varchar(100) DEFAULT NULL,
  `observation_period` varchar(100) DEFAULT NULL,
  `protection_status` varchar(100) DEFAULT NULL,
  `ecological_role` text DEFAULT NULL,
  `threats` text DEFAULT NULL,
  `recommendations` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `resources`
--

INSERT INTO `resources` (`id`, `name`, `type`, `state`, `description`, `location`, `id_sentier`, `slug`, `habitat`, `size`, `surface`, `observation_period`, `protection_status`, `ecological_role`, `threats`, `recommendations`) VALUES
(1, 'Pin d\'Alep', 'Flore', 'Bon', 'Arbre emblématique du parc, résistant à la sécheresse.', 'Zone boisée', 1, 'pin-d-alep', 'Forêt méditerranéenne', 'Jusqu\'à 20 m', 'Zones boisées étendues', 'Toute l\'année', 'Protégé', 'Stabilisation des sols et habitat pour la faune', 'Incendies, sécheresse', 'Ne pas endommager, éviter les feux'),
(2, 'Herbiers de posidonie', 'Marine', 'Menace', 'Plante marine essentielle à la biodiversité marine.', 'Zone littorale', 5, 'posidonie', 'Fonds marins peu profonds', 'Plantes marines jusqu\'à 1 m', 'Herbiers étendus', 'Toute l\'année', 'Espèce strictement protégée', 'Oxygénation de l\'eau et refuge pour la faune marine', 'Pollution, mouillage des bateaux', 'Ne pas ancrer, respecter les zones protégées'),
(3, 'Faucon pèlerin', 'Faune', 'Fragile', 'Rapace protégé nichant dans les falaises.', 'Falaises', 3, 'faucon-pelerin', 'Falaises rocheuses', 'Jusqu\'à 1,2 m', 'Territoire de chasse étendu', 'Printemps – Été', 'Espèce protégée', 'Régulation des populations d\'oiseaux', 'Dérangement humain, perte d\'habitat', 'Ne pas s\'approcher des zones de nidification'),
(4, 'Falaises calcaires de Morgiou', 'Géologique', 'Bon', 'Falaises calcaires façonnées par l’érosion marine et le vent.', 'Falaises de la calanque', 4, 'falaises-morgiou', 'Falaises littorales', 'Hauteur jusqu\'à 300 m', 'Plusieurs kilomètres', 'Toute l\'année', 'Site naturel protégé', 'Habitat pour oiseaux marins et protection du littoral', 'Érosion naturelle, surfréquentation', 'Rester sur les sentiers balisés'),
(5, 'Orchidée sauvage', 'Flore', 'Fragile', 'Espèce végétale rare présente au printemps.', 'Prairies naturelles', 2, 'orchidee-sauvage', 'Prairies naturelles', '30 à 60 cm', 'Zones localisées', 'Mars à mai', 'Espèce protégée', 'Contribution à la biodiversité végétale', 'Piétinement, cueillette', 'Ne pas cueillir, rester sur les sentiers');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrateur avec tous les droits'),
(2, 'user', 'Utilisateur classique avec droits limités');

-- --------------------------------------------------------

--
-- Structure de la table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `sentiers`
--

CREATE TABLE `sentiers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `difficulty` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `distance` decimal(10,0) NOT NULL,
  `elevation` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `exposition` varchar(50) NOT NULL,
  `public` varchar(50) NOT NULL,
  `pets_allowed` tinyint(1) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sentiers`
--

INSERT INTO `sentiers` (`id`, `name`, `difficulty`, `description`, `duration`, `distance`, `elevation`, `type`, `exposition`, `public`, `pets_allowed`, `slug`, `latitude`, `longitude`) VALUES
(1, 'Sentier de l\'Eissadon', 2, 'Sentier côtier offrant des vues spectaculaires sur la mer et les falaises.', 120, 5, 250, 'Aller-retour', 'Ensoleillé', 'Randonneurs', 0, 'sentier-de-l-eissadon-1', 43.2139, 5.4206),
(2, 'Sentier des Goudes', 1, 'Promenade agréable le long de la côte, idéale pour les familles.', 60, 3, 80, 'Aller-retour', 'Ensoleillé', 'Familles', 1, 'sentier-des-goudes-2', 43.214, 5.3959),
(3, 'Sentier du Cap Canaille', 3, 'Randonnée avec panoramas impressionnants sur Cassis et la Méditerranée.', 180, 7, 450, 'Boucle', 'Ensoleillé', 'Sportifs', 0, 'sentier-du-cap-canaille-3', 43.1957, 5.563),
(4, 'Sentier de Morgiou', 4, 'Sentier reliant la calanque de Morgiou à celle de Sormiou, paysages typiques du Parc.', 240, 10, 600, 'Linéaire', 'Mixte', 'Randonneurs expérimentés', 0, 'sentier-de-morgiou-4', 43.2129, 5.4433),
(5, 'Sentier de Sugiton', 1, 'Balade facile, accessible à tous, avec accès aux criques et à la plage.', 90, 4, 150, 'Aller-retour', 'Ensoleillé', 'Tous', 1, 'sentier-de-sugiton-5', 43.2121, 5.454);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role_id` int(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role_id`) VALUES
(5, 'cindy123', '$2y$10$MQnjASPmbCbtTzDhXxQWduYNW5vBXOgkwSvp9FV4GbByYqPg8f35q', 'cindy123@gmail.com', 0),
(9, 'Anna123', '$2y$10$ifToqgBd2NOJoQEw.OgsGO73stLo5Eoe8G7IydA8JsxOkg6OXqnJm', 'Anna123@gmail.com', 0),
(11, 'Anna1234', '$2y$10$wS8WdmLX71EnAl2fendU7.cSahcr/tEfiBBzMWav2v6BLlMBJNQLS', 'Anna1234@gmail.com', 0),
(12, 'Aicha', '$2y$10$FppMjEDXVNl9NFxt9mN9BuNIHc/F1Smu31MjaYRoqIUgJ3yVT1hvm', 'Aicha.ouattara@gmail.com', 0),
(13, 'eric123', '$2y$10$G4FklzO9FH0G/hw3oJzQHuzyLdAxCVQYqs3bOqLa41yrCrdUY.Mt6', 'eric123@gmail.com', 0),
(15, 'eric1234', '$2y$10$Llmhg8rSOzRLoQvLjc2kHO95OFv/cvUHGN.NI3Ruv2s0oFSgW2Im6', 'eric1234@gmail.com', 0),
(16, 'Teo123', '$2y$10$nrgVXLKX2MK401oAukhCd.nq7Ext3appm0P8xxWx2pAf10C0VPDH2', 'teo.ouattara@gmail.com', 0);

-- --------------------------------------------------------

--
-- Structure de la table `visiteurs`
--

CREATE TABLE `visiteurs` (
  `id` int(11) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `date_inscription` date NOT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `campings`
--
ALTER TABLE `campings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug_campings` (`slug`);

--
-- Index pour la table `camping_amenities`
--
ALTER TABLE `camping_amenities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `camping_id` (`camping_id`),
  ADD KEY `amenity_id` (`amenity_id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_visiteur` (`id_visiteur`),
  ADD KEY `id_camping` (`id_camping`);

--
-- Index pour la table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `id_sentier` (`id_sentier`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Index pour la table `sentiers`
--
ALTER TABLE `sentiers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug_sentier` (`slug`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `visiteurs`
--
ALTER TABLE `visiteurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `campings`
--
ALTER TABLE `campings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `camping_amenities`
--
ALTER TABLE `camping_amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `sentiers`
--
ALTER TABLE `sentiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `visiteurs`
--
ALTER TABLE `visiteurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `camping_amenities`
--
ALTER TABLE `camping_amenities`
  ADD CONSTRAINT `camping_amenities_ibfk_1` FOREIGN KEY (`camping_id`) REFERENCES `campings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `camping_amenities_ibfk_2` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`id_visiteur`) REFERENCES `visiteurs` (`id`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`id_camping`) REFERENCES `campings` (`id`);

--
-- Contraintes pour la table `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `resources_ibfk_1` FOREIGN KEY (`id_sentier`) REFERENCES `sentiers` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `visiteurs`
--
ALTER TABLE `visiteurs`
  ADD CONSTRAINT `visiteurs_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
