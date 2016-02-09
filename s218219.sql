-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Giu 19, 2015 alle 15:06
-- Versione del server: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sitopd1`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `attivita`
--

DROP TABLE IF EXISTS `attivita`;
CREATE TABLE IF NOT EXISTS `attivita` (
  `nome` varchar(25) NOT NULL DEFAULT '',
  `descrizione` varchar(1000) DEFAULT NULL,
  `luogo` varchar(25) DEFAULT NULL,
  `immagine` varchar(50) DEFAULT NULL,
  `posti_totali` int(11) DEFAULT NULL,
  `posti_prenotati` int(11) DEFAULT NULL,
  PRIMARY KEY (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `attivita`
--

INSERT INTO `attivita` (`nome`, `descrizione`, `luogo`, `immagine`, `posti_totali`, `posti_prenotati`) VALUES
('basket', 'In Corso Einaudi n.230 si trovano due campi da basket. La struttura e'' stata costruita nel 2010 ed e'' quindi abbastanza nuova ed in ottime condizioni. Il prezzo e'' di euro 6 a partita. Le dimensioni dei campetti, entrambi in parquet, sono di 28x15. Uno dei campi ha il canestro alto 1''80 quindi adatto per bambini. L''altro campo ha il canestro ad altezza classica, di 3''05', 'Corso Einaudi', 'basket.jpg', 4, 2),
('calcio', 'Non lontano dalla stazione di Porta Susa si trova il complesso Cit Turin che ospita diversi campi da calcio, per partite 5-5, 7-7 e 11-11. I campi sono attrezzati di tutto ed il costo varia dai 5 ai 7 euro. I campetti sono in erba sintetica e non sono permesse scarpe con tacchetti da calcio ma solo da calcetto. Durata della partita: 1 ora', 'cit turin', 'calcio.jpg', 8, 5),
('nuoto', 'In via Filadelfia n. 235 si trova la struttura ''SwimPlay'' nella quale sono presenti 3 piscine. Una di queste e'' adibita solo alla pallanuoto. Le altre due sono per il nuoto. La prima e'' una piscina olimpionica da 50m. L''altra, piu'' piccola, e'' di 20mx10m ed adatta a bambini in quanto l''acqua arriva a 1.50m nei punti piu profondi. Costo: 10 euro', 'via Filadelfia 235', 'nuoto.jpg', 30, 0),
('pallavolo', 'In Corso Peschiera n. 235 si trova un Palazzetto dello Sport nel quale sono presenti 2 campi da pallavolo. Uno di questi e'' un campetto classico per adulti con reti posizionate a 2,50m di altezza. L'' altro e'' invece adatto a bambini, con rete alta 1,60m.Il costo e'' di 7 euro per adulti, 5.50 per bambini.', 'Corso Peschiera', 'volley.jpg', 24, 0),
('sci', 'Sul versante piemontese del parco del Gran Paradiso e'' presente un grande complesso sciistico nel quale sono presenti piste di vario livello adatte sia ad adulti che a bambini. Il complesso e'' situato a 1700m di altezza. Si consiglia di venire con l''attrezzatura sciistica da casa in quanto l''attrezzatura presente nel complesso e'' di numero limitato.', 'Gran Paradiso', 'sci.jpg', 6, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazioni`
--

DROP TABLE IF EXISTS `prenotazioni`;
CREATE TABLE IF NOT EXISTS `prenotazioni` (
  `username` varchar(25) NOT NULL DEFAULT '',
  `attivita` varchar(25) NOT NULL DEFAULT '',
  `numero_posti` int(11) DEFAULT NULL,
  PRIMARY KEY (`username`,`attivita`),
  KEY `attivita` (`attivita`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `prenotazioni`
--

INSERT INTO `prenotazioni` (`username`, `attivita`, `numero_posti`) VALUES
('u1', 'basket', 1),
('u1', 'sci', 2),
('u2', 'calcio', 3),
('u2', 'sci', 1),
('u3', 'basket', 1),
('u3', 'calcio', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

DROP TABLE IF EXISTS `utenti`;
CREATE TABLE IF NOT EXISTS `utenti` (
  `USERNAME` varchar(25) NOT NULL DEFAULT '',
  `PASSWORD` varchar(50) NOT NULL,
  PRIMARY KEY (`USERNAME`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`USERNAME`, `PASSWORD`) VALUES
('a', '0cc175b9c0f1b6a831c399e269772661'),
('sds', '9003d1df22eb4d3820015070385194c8'),
('u1', 'ec6ef230f1828039ee794566b9c58adc'),
('u2', '1d665b9b1467944c128a5575119d1cfd'),
('u3', '7bc3ca68769437ce986455407dab2a1f'),
('x', '4a8a08f09d37b73795649038408b5f33'),
('x2', '9dd4e461268c8034f5c8564e155c67a6');

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD CONSTRAINT `prenotazioni_ibfk_1` FOREIGN KEY (`username`) REFERENCES `utenti` (`USERNAME`),
  ADD CONSTRAINT `prenotazioni_ibfk_2` FOREIGN KEY (`attivita`) REFERENCES `attivita` (`nome`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
