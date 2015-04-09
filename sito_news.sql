-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Ott 10, 2012 alle 23:56
-- Versione del server: 5.5.16
-- Versione PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sito_news`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `articoli`
--

CREATE TABLE IF NOT EXISTS `articoli` (
  `id_articolo` int(50) NOT NULL AUTO_INCREMENT,
  `titolo` text NOT NULL,
  `testo` text NOT NULL,
  `meta_description` text NOT NULL,
  `id_categoria` int(50) NOT NULL,
  `tags` text,
  `id_autore` int(50) NOT NULL,
  `data` datetime NOT NULL,
  `in_evidenza` int(1) NOT NULL DEFAULT '0',
  `pubblicato` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_articolo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dump dei dati per la tabella `articoli`
--

INSERT INTO `articoli` (`id_articolo`, `titolo`, `testo`, `meta_description`, `id_categoria`, `tags`, `id_autore`, `data`, `in_evidenza`, `pubblicato`) VALUES
(1, 'Articolo 1', 'Questo è un nuovo articolo di prova. Hello World! Prova prova, bla bla bla bla, il grande blu.. prosciutto, sgabello, formaggio, austrolopiteco, cannuccia. Siamo arrivati a 200 caratteri si o no? penso proprio di si... che fai ora parli anche solo? ..non ho preso le pillole oggi.', 'hello world!', 1, 'prova, hello world, telefonia, cellulari', 1, '2012-05-02 13:00:00', 0, 0),
(2, 'Secondo Articolo - in evidenza', 'Qualcuno sa dirmi se dopo aver tolto la linguetta ad una granata è possibile rimetterla a posto? mi serve una risposta urgente... - ....Secondo articolo di prova. Meglio non proseguire la lettura di questo articolo, non ci assumiamo alcuna responsabilità in caso di danni celebrali permanenti. <font color="red">PROVA HTML</font>', 'secondo articolo di prova', 2, 'prova, articolo, secondo', 1, '2012-05-08 16:20:11', 1, 1),
(3, 'Articolo non in evidenza', 'io povero articolo non sono in evidenza.... mi hanno isolato perchè sono brutto e obsoleto..... A A A A A A A A A A A A... Nuovo galaxy s3 appena presentato a Londraa a a a aa a aa a a a a a lol', 'nuovo galaxy s3 presentato a londra', 1, 'galaxy, prova, non in evidenza, s3, samsung', 2, '2012-05-10 10:34:05', 0, 1),
(5, 'LibreOffice', 'LibreOffice non è altro che OpenOffice, ma con diverse funzionalità aggiuntive. Con il KIT Plus Windows, avremo ulteriori caratteristiche ed un ricco repertorio di modelli, anche italiani e clip-arts. Con un semplice click del mouse, otterremo, anche, la persistenza delle immagini, pure se copiate da documenti web, grazie ad una macro appositamente inserita. LibreOffice, normalmente abbreviato LibO è una suite completa per l''ufficio che ovviamente risulta indispensabile anche per la casa. ', 'parliamo di libreoffice e le differenze con openoffice', 2, 'openoffice, libreoffice, download, linux', 2, '2012-05-10 11:20:38', 0, 1),
(6, 'Raspberry Pi', 'Il Raspberry Pi è un single-board computer (un calcolatore implementato su una sola scheda elettronica) sviluppato nel Regno Unito dalla Raspberry Pi Foundation. Il suo lancio al pubblico era previsto per la fine del mese di febbraio 2012[1]. La fondazione prevede di distribuirlo in due versioni, al prezzo di $25 e $35 dollari statunitensi (rispettivamente, circa 16 e 22 sterline). <img src="http://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Raspberry_Pi_Beta_Board.jpg/350px-Raspberry_Pi_Beta_Board.jpg" />', 'cos''è il raspberry pi?', 3, 'raspberry pi, foundation, elettronica, arm, embedded, pc', 1, '2012-05-11 05:00:00', 0, 1),
(7, 'Confronti sulla qualità foto del SG3', 'In questo articolo andiamo analizziamo indirettamente (perché realizzato dai nostri colleghi di GSMArena) un confronto delle foto e dei video degli smartphone-fratelli più vociferati sulla rete: Samsung Galaxy S III e Samsung Galaxy S II.<br/><br/>\r\nEntrambi i dispositivi sono dotati di una fotocamera da 8 megapixel, ma la differenza sta in alcuni dettagli a vantaggio della camera dell’S III che, come annunciato durante la presentazione è, per esempio, dotata di retroilluminazione che garantisce scatti più nitidi e colori più fedeli.', 'fotocamera del galaxy s3 ed s2 a confronto', 1, 'galaxy s3, samsung, fotocamera', 1, '2012-05-12 17:49:44', 0, 1),
(10, 'Primo articolo da form', 'Testo di prova per il primo articolo inviato da form dal pannello di controllo.\r\n\r\nTest html: <font color=''green''>VERDE</font>.\r\n<br/>spazio<br/>spazio<br/> OK', 'descrizione breve per il primo articolo da form', 2, 'form, articolo, primo, prova', 1, '2012-05-26 21:23:00', 0, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categoria` int(50) NOT NULL AUTO_INCREMENT,
  `nome_categoria` varchar(50) NOT NULL,
  `descr_breve` text,
  `visibile` int(1) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`id_categoria`, `nome_categoria`, `descr_breve`, `visibile`) VALUES
(1, 'Telefonia', 'Tutte le news riguardanti i telefoni cellulari e le nuove offerte proposte dai migliori operatori telefonici.', 1),
(2, 'Open Source', 'Categoria inerente al mondo Open Source.', 1),
(3, 'Elettronica', 'Categoria riservata alle news trattanti il mondo dell''elettronica applicata.', 1),
(4, 'Programmazione', 'Categoria sulla programmazione web e lato client..', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `commenti`
--

CREATE TABLE IF NOT EXISTS `commenti` (
  `art_commentato` int(50) NOT NULL,
  `testo_commento` text NOT NULL,
  `utente` text NOT NULL,
  `data` datetime NOT NULL,
  KEY `art_commentato` (`art_commentato`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `commenti`
--

INSERT INTO `commenti` (`art_commentato`, `testo_commento`, `utente`, `data`) VALUES
(2, 'ho sognato una confezione di patatine surgelate da 7kg.', 'Rocco', '2012-05-09 13:30:00'),
(7, 'prova commento inserito da form.', 'Rocco', '2012-05-09 07:00:00'),
(5, 'non mi piace', 'Rocco', '2012-05-09 00:00:00'),
(7, 'Aspettiamo il nexus per fine settembre! ...', 'Rocco', '2012-05-13 17:33:44'),
(2, 'Commento di prova....', 'Rocco', '2012-05-16 09:30:33'),
(3, 'Commento NUOVO.', 'Rocco', '2012-05-16 00:00:00'),
(3, 'Sei un buzurro...', 'Rocco', '2012-05-16 12:37:13'),
(2, 'drdfgfbb', 'Bilbo_Beggins', '2012-05-16 13:04:34'),
(2, 'Run awayyyyyy!', 'Rocco', '2012-05-25 19:15:39'),
(6, 'Da acquistare...', 'Rocco', '2012-05-25 19:50:36'),
(1, 'Primo articolo di prova..', 'Rocco', '2012-05-25 19:50:55');

-- --------------------------------------------------------

--
-- Struttura della tabella `info_sito`
--

CREATE TABLE IF NOT EXISTS `info_sito` (
  `nome_sito` varchar(20) NOT NULL,
  `slogan` varchar(100) NOT NULL,
  `articoli_per_pagina` int(10) NOT NULL,
  `reg_attiva` int(1) NOT NULL,
  `footer` text NOT NULL,
  `descrizione_sito` text NOT NULL,
  `keywords_sito` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `info_sito`
--

INSERT INTO `info_sito` (`nome_sito`, `slogan`, `articoli_per_pagina`, `reg_attiva`, `footer`, `descrizione_sito`, `keywords_sito`) VALUES
('Geek News', 'Resta sempre aggiornato con Geek-News!', 4, 1, 'Copyright @ 2012 - <a href="http://www.hackerstribe.com">Rocco Musolino</a>', 'Questo sito fornisce news sempre aggiornate sul mondo dell''informatica.', 'informatica, news, blog, tecnologia, geek ');

-- --------------------------------------------------------

--
-- Struttura della tabella `link`
--

CREATE TABLE IF NOT EXISTS `link` (
  `nome_sito_amico` text NOT NULL,
  `url` varchar(60) NOT NULL,
  `new_page` int(1) NOT NULL DEFAULT '1',
  `nofollow` int(1) NOT NULL DEFAULT '1',
  `visibile` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `link`
--

INSERT INTO `link` (`nome_sito_amico`, `url`, `new_page`, `nofollow`, `visibile`) VALUES
('Hackers Tribe', 'http://www.hackerstribe.com', 1, 0, 1),
('Sviluppo Web', 'http://www.sviluppoweb.org', 1, 0, 1),
('Profilo FB Rocco', 'http://www.facebook.com/rocco.musolino', 1, 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `pagine`
--

CREATE TABLE IF NOT EXISTS `pagine` (
  `id_pagina` int(11) NOT NULL AUTO_INCREMENT,
  `titolo` varchar(35) NOT NULL,
  `testo` text NOT NULL,
  `ordine` int(11) NOT NULL,
  PRIMARY KEY (`id_pagina`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `pagine`
--

INSERT INTO `pagine` (`id_pagina`, `titolo`, `testo`, `ordine`) VALUES
(1, 'HOME', '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php"> ', 1),
(2, 'CHI SIAMO', 'Questo è un semplice CMS scritto in PHP/SQL/HTML/CSS che fa impiego di tecnologie ajax/jquery.\r\n<br/><br/>\r\nE'' nato per una rapida gestione di articoli, categorie, pagine e utenti. Scritto da Rocco Musolino (http://www.hackerstribe.com).\r\n<br/><br/>\r\nVersione attuale: 1.0 (28/06/2012)', 2),
(3, 'FAQ', '<b>Come è gestito il sistema a ruoli?</b>\r\n<br/>\r\nViene utilizzato un Modello a ruoli RBAC (role base access control) di tipo Gerarchico (Hierarchical).\r\n<br/><br/>\r\n<b>Quali sono i ruoli disponibili?</b>\r\n\r\n<li>Amministratore</li>\r\n<li>Moderatore</li>\r\n<li>Editore</li>\r\n<li>Autore</li>\r\n<li>Lettore</li>\r\n\r\n<br/>\r\n<b>Quali sono i permessi disponibili?</b>\r\n<br/>\r\n<p>\r\n<u>mod_sito</u> può modificare la struttura del sito, compreso titolo, keywords principali, footer, le pagine (quindi il menu) e i link ai siti amici.<br/>\r\n<u>mod_utenti</u> può modificare i dati relativi agli utenti (username, password, email etc..).<br/>\r\n<u>pubblicazione</u> può scrivere e pubblicare articoli (anche quelli in bozze di altri utenti).<br/>\r\n<u>scrittura</u> può scrivere articoli (ma non ha il permesso di pubblicarli, verranno quindi passati prima in rassegna da un Editore/Moderatore/Amministratore abilitato alla pubblicazione).<br/>\r\n<u>lettura</u> può modificare alcune info del suo profilo, lasciare e visionare i commenti da lui pubblicati.<br/>\r\n</p>', 4),
(4, 'CONTATTACI', '<center>\r\nNome: Rocco<br/>\r\nEmail: rocco@hackerstribe.com<br/>\r\nSito Web: <a href="http://www.hackerstribe.com" target="_new">www.hackerstribe.com</a><br/>\r\n</center>', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `permessi`
--

CREATE TABLE IF NOT EXISTS `permessi` (
  `ruolo` varchar(20) NOT NULL,
  `lettura` int(1) NOT NULL,
  `scrittura` int(1) NOT NULL,
  `pubblicazione` int(1) NOT NULL,
  `mod_utenti` int(1) NOT NULL,
  `mod_sito` int(1) NOT NULL,
  UNIQUE KEY `ruolo` (`ruolo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `permessi`
--

INSERT INTO `permessi` (`ruolo`, `lettura`, `scrittura`, `pubblicazione`, `mod_utenti`, `mod_sito`) VALUES
('amministratore', 1, 1, 1, 1, 1),
('autore', 1, 1, 0, 0, 0),
('editore', 1, 1, 1, 0, 0),
('lettore', 1, 0, 0, 0, 0),
('moderatore', 1, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE IF NOT EXISTS `utenti` (
  `id_utente` int(50) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `nome` text NOT NULL,
  `cognome` text NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `ruolo` text NOT NULL,
  PRIMARY KEY (`id_utente`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id_utente`, `username`, `nome`, `cognome`, `email`, `password`, `ruolo`) VALUES
(1, 'Rocco', 'Rocco', 'Musolino', 'rocco@hackerstribe.com', 'e10adc3949ba59abbe56e057f20f883e', 'amministratore'),
(2, 'Bilbo_Beggins', 'Bilbo', 'Beggins', 'prova@prova.it', 'e10adc3949ba59abbe56e057f20f883e', 'editore'),
(4, 'collins', 'Barnabas', 'Collins', 'barnaba@gmail.com', '202cb962ac59075b964b07152d234b70', 'lettore'),
(5, 'einstein', 'einstein', 'boh', 'autore@autore.it', 'e10adc3949ba59abbe56e057f20f883e', 'autore');

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `commenti`
--
ALTER TABLE `commenti`
  ADD CONSTRAINT `commenti_ibfk_1` FOREIGN KEY (`art_commentato`) REFERENCES `articoli` (`id_articolo`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
