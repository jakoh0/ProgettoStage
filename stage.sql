-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 08, 2024 alle 16:28
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stage`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `approvazione`
--

CREATE TABLE `approvazione` (
  `IDutente` bigint(20) NOT NULL COMMENT 'Utente che ha commentato',
  `utenteID` bigint(20) NOT NULL COMMENT 'Utente che caricato',
  `verifica` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `commenti`
--

CREATE TABLE `commenti` (
  `opereID` bigint(20) NOT NULL,
  `IDutente` bigint(20) NOT NULL,
  `testo` varchar(255) NOT NULL,
  `datain` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `opere`
--

CREATE TABLE `opere` (
  `opereID` bigint(20) NOT NULL,
  `Nomeopera` varchar(255) NOT NULL,
  `IDutente` bigint(20) NOT NULL,
  `titolo` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `svoti`
--

CREATE TABLE `svoti` (
  `opereID` bigint(20) NOT NULL,
  `sommavoti` bigint(20) NOT NULL,
  `nvoti` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `Nome` varchar(255) NOT NULL,
  `Cognome` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Datadinascita` date NOT NULL,
  `Indirizzo` varchar(255) NOT NULL,
  `Citta` varchar(255) NOT NULL,
  `Numeroditelefono` bigint(11) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Provincia` varchar(255) NOT NULL,
  `Nazione` varchar(255) NOT NULL,
  `token` int(11) NOT NULL,
  `IDutente` bigint(20) NOT NULL,
  `profilo` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `sessione` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`Nome`, `Cognome`, `Email`, `Datadinascita`, `Indirizzo`, `Citta`, `Numeroditelefono`, `Password`, `Provincia`, `Nazione`, `token`, `IDutente`, `profilo`, `sessione`) VALUES
('Admin', 'Admin', 'Jacopo.toffolo@antonioscarpa.edu.it', '2006-03-27', 'Piavon', 'Piavon', 3280221234, '4bcb3f5565ebc6f11faa2e77da866e69', 'Italia', 'Oderzo', 0, 0, 'default.jpg', 982850),
('Ospite', 'Ospite', 'ospite@ospite.com', '1972-12-01', 'Via', 'City', 123456789, '', 'Provicia', 'Nazione', 11111110, 11111110, 'default.jpg', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `voti`
--

CREATE TABLE `voti` (
  `opereID` bigint(20) NOT NULL,
  `voto` int(11) NOT NULL,
  `IDutente` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `approvazione`
--
ALTER TABLE `approvazione`
  ADD KEY `IDutente` (`IDutente`),
  ADD KEY `utenteID` (`utenteID`);

--
-- Indici per le tabelle `commenti`
--
ALTER TABLE `commenti`
  ADD KEY `opereID` (`opereID`),
  ADD KEY `IDutente` (`IDutente`);

--
-- Indici per le tabelle `opere`
--
ALTER TABLE `opere`
  ADD PRIMARY KEY (`opereID`),
  ADD KEY `IDutente` (`IDutente`);

--
-- Indici per le tabelle `svoti`
--
ALTER TABLE `svoti`
  ADD KEY `operEID` (`opereID`);

--
-- Indici per le tabelle `voti`
--
ALTER TABLE `voti`
  ADD KEY `IDutente` (`IDutente`),
  ADD KEY `opereID` (`opereID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
