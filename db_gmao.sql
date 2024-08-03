-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 03 juin 2024 à 09:45
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_gmao`
--

-- --------------------------------------------------------

--
-- Structure de la table `administration`
--

CREATE TABLE `administration` (
  `id` int(11) NOT NULL,
  `Number_Autorisation` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `fax_number` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `administration`
--

INSERT INTO `administration` (`id`, `Number_Autorisation`, `first_name`, `last_name`, `fax_number`, `user_id`) VALUES
(5, 2000, 'djair', 'mouad', 222222, 84);

-- --------------------------------------------------------

--
-- Structure de la table `agent`
--

CREATE TABLE `agent` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `fax_number` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id_adminstration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `agent`
--

INSERT INTO `agent` (`id`, `first_name`, `last_name`, `fax_number`, `user_id`, `id_adminstration`) VALUES
(1, 'djair', 'Abdjelil', 222222, 93, 5);

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

CREATE TABLE `equipe` (
  `id` int(11) NOT NULL,
  `type` varchar(45) NOT NULL,
  `name_boss` varchar(45) NOT NULL,
  `fax_number` int(11) DEFAULT NULL,
  `maintenance_id` int(11) NOT NULL,
  `maintenance_administration_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipe`
--

INSERT INTO `equipe` (`id`, `type`, `name_boss`, `fax_number`, `maintenance_id`, `maintenance_administration_id`, `user_id`) VALUES
(2, 'Electric', 'hmida', 2222222, 2, 5, 87),
(3, 'Hydraulic', 'oussama', 555442462, 2, 5, 88),
(4, 'Informatique', 'hako', 658025414, 2, 5, 89),
(5, 'Mechanical', 'zaki', 555442462, 2, 5, 92);

-- --------------------------------------------------------

--
-- Structure de la table `formulaire`
--

CREATE TABLE `formulaire` (
  `id` int(11) NOT NULL,
  `number_of_formulaire` int(11) NOT NULL,
  `name_agent` varchar(45) NOT NULL,
  `type_formulaire` varchar(45) NOT NULL,
  `date_agent` datetime NOT NULL,
  `ref` varchar(45) NOT NULL,
  `type_intervention` varchar(45) NOT NULL,
  `type_preventive` varchar(45) NOT NULL,
  `levels_danger` varchar(45) NOT NULL,
  `type_probleme` varchar(1000) NOT NULL,
  `subsidiary` varchar(45) NOT NULL,
  `line` varchar(45) NOT NULL,
  `equipment` varchar(45) NOT NULL,
  `name_maintenance_director` varchar(45) NOT NULL,
  `date_maintenance` datetime NOT NULL,
  `name_production_director` varchar(45) NOT NULL,
  `date_production` datetime NOT NULL,
  `name_Equipe` varchar(50) NOT NULL,
  `date_end` datetime NOT NULL,
  `summary_Mechanical` text NOT NULL,
  `summary_Electric` text NOT NULL,
  `summary_Hydraulic` text NOT NULL,
  `summary_Informatique` text NOT NULL,
  `maintenance_id` int(11) NOT NULL,
  `production_id` int(11) NOT NULL,
  `equipe_id` int(11) NOT NULL,
  `administration_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `formulaire`
--

INSERT INTO `formulaire` (`id`, `number_of_formulaire`, `name_agent`, `type_formulaire`, `date_agent`, `ref`, `type_intervention`, `type_preventive`, `levels_danger`, `type_probleme`, `subsidiary`, `line`, `equipment`, `name_maintenance_director`, `date_maintenance`, `name_production_director`, `date_production`, `name_Equipe`, `date_end`, `summary_Mechanical`, `summary_Electric`, `summary_Hydraulic`, `summary_Informatique`, `maintenance_id`, `production_id`, `equipe_id`, `administration_id`, `agent_id`) VALUES
(1, 1, 'djair Abdjelil', 'Problem', '2024-06-02 23:19:00', '22', 'preventive', 'Working hours', '', '[\"Mechanical\",\"Electric\",\"Informatique\"]', 'subsidiary-A', 'line-1', 'equipment-D', 'dafi Fateh', '2024-06-02 23:32:00', 'badro badro', '2024-06-02 23:27:00', 'hako', '2024-06-02 23:33:00', '', '', '', 'electric problem ', 2, 1, 0, 5, 0),
(2, 2, 'djair Abdjelil', 'Production', '2024-06-02 23:21:00', '6444', 'curative', '', 'Peril', 'Electric', 'subsidiary-A', 'line-1', 'equipment-E', 'dafi Fateh', '2024-06-02 23:23:00', 'badro badro', '2024-06-02 23:27:00', '', '0000-00-00 00:00:00', '', '', '', '', 2, 1, 0, 5, 0),
(3, 3, 'djair Abdjelil', 'Production', '2024-06-02 23:21:00', '22', 'preventive', 'Production Quantity', '', 'Hydraulic', 'subsidiary-B', 'line-2', 'equipment-E', 'dafi Fateh', '2024-06-02 23:23:00', 'badro badro', '2024-06-02 23:27:00', '', '0000-00-00 00:00:00', '', '', '', '', 2, 1, 0, 5, 0),
(4, 4, 'djair Abdjelil', 'End', '2024-06-02 23:22:00', '22', 'systematic', '', '', 'Informatique', 'subsidiary-A', 'line-1', 'equipment-D', 'dafi Fateh', '2024-06-02 23:23:00', 'badro badro', '2024-06-02 23:27:00', 'hako', '2024-06-02 23:29:00', '', '', '', 'done here', 2, 1, 0, 5, 0),
(5, 5, 'djair Abdjelil', 'End', '2024-06-02 23:23:00', '6555', 'preventive', 'Production Quantity', '', 'Mechanical', 'subsidiary-A', 'line-1', 'equipment-F', 'dafi Fateh', '2024-06-02 23:25:00', 'badro badro', '2024-06-02 23:27:00', 'zaki', '2024-06-02 23:31:00', 'done here ', '', '', '', 2, 1, 0, 5, 0),
(6, 6, 'djair Abdjelil', 'Production', '2024-06-02 23:23:00', '88', 'systematic', '', '', '[\"Mechanical\",\"Electric\",\"Hydraulic\",\"Informatique\"]', 'subsidiary-B', 'line-1', 'equipment-D', 'dafi Fateh', '2024-06-02 23:30:00', 'badro badro', '2024-06-02 23:27:00', 'hmida', '2024-06-02 23:28:00', '', '', '', '', 2, 1, 0, 5, 0),
(7, 7, 'djair Abdjelil', 'Maintenance', '2024-06-02 23:24:00', '22', 'curative', '', 'Peril', 'Hydraulic', 'subsidiary-A', 'line-1', 'equipment-E', 'dafi Fateh', '2024-06-02 23:25:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '', '', '', 2, 1, 0, 5, 0),
(8, 8, 'djair Abdjelil', 'Maintenance', '2024-06-02 23:24:00', '6', 'systematic', '', '', 'Informatique', 'subsidiary-A', 'line-2', 'equipment-E', 'dafi Fateh', '2024-06-02 23:26:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '', '', '', 2, 1, 0, 5, 0),
(9, 9, 'djair Abdjelil', 'Agent', '2024-06-02 23:24:00', '22', 'curative', '', 'Hazard', 'Hydraulic', 'subsidiary-A', 'line-1', 'equipment-D', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '', '', '', 2, 1, 0, 5, 0),
(10, 10, 'djair Abdjelil', 'Agent', '2024-06-02 23:24:00', '22', 'preventive', 'Production Quantity', '', 'Mechanical', 'subsidiary-B', 'line-1', 'equipment-E', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '', '', '', 2, 1, 0, 5, 0),
(11, 11, 'djair Abdjelil', 'End', '2024-06-03 00:29:00', '88', 'systematic', '', '', 'Mechanical', 'subsidiary-A', 'line-1', 'equipment-D', 'dafi Fateh', '2024-06-03 00:30:00', 'badro badro', '2024-06-03 00:30:00', 'zaki', '2024-06-03 00:31:00', 'hello', '', '', '', 2, 1, 0, 5, 0);

-- --------------------------------------------------------

--
-- Structure de la table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `fax_number` int(11) NOT NULL,
  `administration_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `maintenance`
--

INSERT INTO `maintenance` (`id`, `first_name`, `last_name`, `fax_number`, `administration_id`, `user_id`) VALUES
(2, 'dafi', 'Fateh', 658025414, 5, 91);

-- --------------------------------------------------------

--
-- Structure de la table `production`
--

CREATE TABLE `production` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `fax_number` varchar(20) NOT NULL,
  `administration_id` int(11) NOT NULL,
  `maintenance_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `production`
--

INSERT INTO `production` (`id`, `first_name`, `last_name`, `fax_number`, `administration_id`, `maintenance_id`, `user_id`) VALUES
(1, 'badro', 'badro', '0555442462', 5, 0, 90);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `type`) VALUES
(84, 'djairmouad@gmail.com', '$2y$10$5xaWWiGn7sL1Kpq4WMk.se6j.Y9asrgo9wtBHOICVVH6liwfB7MgW', 'Administration'),
(87, 'hmidahmida@gmail.com', '$2y$10$JOec4uqRJnAGTbFtjF1PPulqgL2nEijN/LM/uNQQNk1/YIkshZauO', 'Electric'),
(88, 'oussama@gmail.com', '$2y$10$OlFgWqxobDLNLIF1cputiuR7isNcj/Bk5ZYQiPzOVzim7EE2f65LO', 'Hydraulic'),
(89, 'djairHako@gmail.com', '$2y$10$WynrCJBGniE9FpLDVoJshu9zNgl1DNc0UlWUCMya.AkAKgaL0gKai', 'Informatique'),
(90, 'badrobadro@gmail.com', '$2y$10$UbpRy5BEkaNT8ydQB4v0f.Tygdh7tUc.R2fEn9sFrMkg6RYwmVEpu', 'Production'),
(91, 'dafiFateh@gmail.com', '$2y$10$TuAl/8k8B.2jDP0UqC9Gp..0NAuX90Qz28sIrxJNb4iOa8pPnwrmK', 'Maintenance'),
(92, 'tehamiZaki@gmail.com', '$2y$10$FmclF5YjkznB19WcQOEWp.Q1G19SPoPC3Ng.TklyS9tkOHLVRaS2m', 'Mechanical'),
(93, 'djairabdjelil@gmail.com', '$2y$10$CFVZDYCFoKA4a5QOORxogejK.d8Aqm6uaVyAjD6uCzkRc4efKvWy.', 'Agent technique');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administration`
--
ALTER TABLE `administration`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_agent_user1_idx` (`user_id`);

--
-- Index pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_equipe_administration1_idx` (`maintenance_administration_id`),
  ADD KEY `fk_equipe_user1_idx` (`user_id`);

--
-- Index pour la table `formulaire`
--
ALTER TABLE `formulaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `production`
--
ALTER TABLE `production`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_production_administration1_idx` (`administration_id`),
  ADD KEY `fk_production_user1_idx` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administration`
--
ALTER TABLE `administration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `agent`
--
ALTER TABLE `agent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `equipe`
--
ALTER TABLE `equipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `formulaire`
--
ALTER TABLE `formulaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `production`
--
ALTER TABLE `production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `agent`
--
ALTER TABLE `agent`
  ADD CONSTRAINT `fk_agent_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD CONSTRAINT `fk_equipe_administration1` FOREIGN KEY (`maintenance_administration_id`) REFERENCES `administration` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_equipe_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `production`
--
ALTER TABLE `production`
  ADD CONSTRAINT `fk_production_administration1` FOREIGN KEY (`administration_id`) REFERENCES `administration` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_production_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
