-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 12 Gru 2022, 19:52
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `test_bs_php`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `ID_pracownika` int(11) NOT NULL,
  `Imie` varchar(30) NOT NULL,
  `Nazwisko` varchar(35) NOT NULL,
  `Telefon` varchar(12) NOT NULL,
  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `pracownicy`
--

INSERT INTO `pracownicy` (`ID_pracownika`, `Imie`, `Nazwisko`, `Telefon`, `Email`) VALUES
(1, 'Michał', 'Jóźwiak', '+48123456789', 'michjoz@gmail.com'),
(2, 'Justyn', 'Bielawski', '+48987654321', 'jusbiel@wp.pl'),
(3, 'Szymon', 'Gawroński', '+48123654789', 'szygawr@o2.pl'),
(4, 'Emil', 'Matuszak', '+48321456987', 'emmat@gmail.com'),
(5, 'Paweł', 'Kalisz', '+48321654987', 'pawkali@gmail.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `nickname` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `imie` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `nazwisko` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `haslo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `email` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `nickname`, `imie`, `nazwisko`, `haslo`, `email`) VALUES
(1, 'Admin', 'Oleh', 'Olaf', '$2y$10$aQ8JreFteo35QQLnynOcTuEmgXH.PUyC.XyU74qipk3hj4u.kN/v.', 'olegradchenko@gmail.com'),
(2, 'Admin2', 'Bartek', 'Ciuf', '$2y$10$LsO.v4O6qPrdL/IErxOlI.smDM6e8alWAmTQ9lv1jelR7Xsng.S.6', 'bartoszpaluch@gmail.com'),
(3, 'Olafidas', 'Olaf', 'Radćenką', '$2y$10$15lKCdvjoY2C.ktnyS/hJuRuMzzP/5EpKAE6WG7eQLxzX0vk4vN7K', 'olaf@gmai.com'),
(5, 'top3l3k7ryk', 'Eugeniusz', 'Elketrykmistrz', '$2y$10$Z/p.pn7YLCfFG2.sz5q9kOTEyVwKQRor5S1y4oneF5z93AXVC9/Xe', 'asdasd@gmail.com'),
(6, 'AaaB', 'Aaaa', 'Bbbb', '$2y$10$.NBeGbxWJOBuLla92MQT0.vignA7vXPJ5k7dFG6t547GpfOCQUQB.', 'aaaa@gmail.com'),
(7, 'olegrad', 'Oleh', 'Radchenko', '$2y$10$3mXqP7RcwilwOL.70dVw/e6rjkJIYd34qpoPgxWaUyMK9Ptx0KWWa', 'olegradchenko2005@gmail.com'),
(8, 'nowylogin', 'Oleh', 'Radchenko', '$2y$10$jxyEsQjRNPSGP5WfrORQMOClD6lrBGM8KqHimuqLacvlCmQGI6d56', 'nowy_email@gmail.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wizyty`
--

CREATE TABLE `wizyty` (
  `ID_wizyty` int(11) NOT NULL,
  `ID_elektryka` int(11) NOT NULL,
  `ID_uzytkownika` int(11) NOT NULL,
  `Data_wizyty` datetime NOT NULL,
  `Opis_problemu` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `wizyty`
--

INSERT INTO `wizyty` (`ID_wizyty`, `ID_elektryka`, `ID_uzytkownika`, `Data_wizyty`, `Opis_problemu`) VALUES
(1, 1, 1, '2022-12-13 12:00:00', 'Nie działa czajnik!'),
(2, 1, 1, '2022-12-13 12:30:00', 'Nie działa chłodzenie(laptop)'),
(3, 1, 2, '2022-12-13 13:00:00', 'Nie działa odkurzacz ;c'),
(4, 5, 2, '2022-12-13 12:00:00', 'Pomocy, nie działa mi lampa 0_0');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wspolpraca`
--

CREATE TABLE `wspolpraca` (
  `ID_zgloszenia_dolaczenia` int(11) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nr_tel` varchar(12) NOT NULL,
  `wiadomosc` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `wspolpraca`
--

INSERT INTO `wspolpraca` (`ID_zgloszenia_dolaczenia`, `imie`, `nazwisko`, `email`, `nr_tel`, `wiadomosc`) VALUES
(2, 'Oleh', 'Radchenko', 'ktosinny@gmail.com', '577070238', 'Chcę praktykować, może chcecie mnie czegoś nauczyć? XD');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zgloszenia_problemow`
--

CREATE TABLE `zgloszenia_problemow` (
  `ID_report` int(11) NOT NULL,
  `email_kontaktowy` varchar(100) NOT NULL,
  `temat` varchar(100) NOT NULL,
  `opis` longtext NOT NULL,
  `nr_tel_kontaktowego` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `zgloszenia_problemow`
--

INSERT INTO `zgloszenia_problemow` (`ID_report`, `email_kontaktowy`, `temat`, `opis`, `nr_tel_kontaktowego`) VALUES
(1, 'olegradchenko@gmail.com', 'Propozycja', 'Wasza stronka jest bardzo pusta, może czymś pomóc?', ''),
(2, 'olaf@gam.eu', 'Praca', 'Chciałbym u was popracować B), czy szukacie aktualnie programistów? XDDDD', '123456789'),
(3, 'ktosinny@gmail.com', 'Coś nie działa', 'Dzień dobry, nie działa wam strona ;<', '+48123456987');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`ID_pracownika`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `wizyty`
--
ALTER TABLE `wizyty`
  ADD PRIMARY KEY (`ID_wizyty`),
  ADD KEY `ID_lekarza` (`ID_elektryka`),
  ADD KEY `ID_uzytkownika` (`ID_uzytkownika`);

--
-- Indeksy dla tabeli `wspolpraca`
--
ALTER TABLE `wspolpraca`
  ADD PRIMARY KEY (`ID_zgloszenia_dolaczenia`);

--
-- Indeksy dla tabeli `zgloszenia_problemow`
--
ALTER TABLE `zgloszenia_problemow`
  ADD PRIMARY KEY (`ID_report`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `ID_pracownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `wizyty`
--
ALTER TABLE `wizyty`
  MODIFY `ID_wizyty` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `wspolpraca`
--
ALTER TABLE `wspolpraca`
  MODIFY `ID_zgloszenia_dolaczenia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `zgloszenia_problemow`
--
ALTER TABLE `zgloszenia_problemow`
  MODIFY `ID_report` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `wizyty`
--
ALTER TABLE `wizyty`
  ADD CONSTRAINT `wizyty_ibfk_1` FOREIGN KEY (`ID_elektryka`) REFERENCES `pracownicy` (`ID_pracownika`),
  ADD CONSTRAINT `wizyty_ibfk_2` FOREIGN KEY (`ID_uzytkownika`) REFERENCES `uzytkownicy` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
