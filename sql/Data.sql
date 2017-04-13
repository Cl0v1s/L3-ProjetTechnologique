-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 13, 2017 at 08:45 PM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `Disabled`
--

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`id`, `name`) VALUES
(2, 'Aide à domicile'),
(3, 'Formation');

--
-- Dumping data for table `Status`
--

INSERT INTO `Status` (`id`, `name`) VALUES
(3, 'Personne agée'),
(4, 'Handicapé moteur'),
(5, 'Handicapé mental'),
(6, 'Personne mal voyante');

--
-- Dumping data for table `Subject`
--

INSERT INTO `Subject` (`id`, `name`) VALUES
(16, 'Vie communale'),
(17, 'Sécurité'),
(18, 'Bien-être');

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `lastname`, `firstname`, `password`, `username`, `isadmin`, `isbanned`, `phone`, `email`) VALUES
(79, 'root', 'root', '$2y$10$vh8TrmUG2syDPKRmygjwY.dh0sLQT4IO1RPWtMFieRuOXms0Fr9bm', 'root.root', 1, 0, 761898895, 'root@root.com');

