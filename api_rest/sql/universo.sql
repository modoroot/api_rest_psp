-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 10-03-2023 a las 10:22:04
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `universo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estrella`
--

CREATE TABLE `estrella` (
  `id_estrella` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `gravedad` double NOT NULL,
  `radio` double NOT NULL,
  `masa` double NOT NULL,
  `velocidad_escape` double NOT NULL,
  `id_galaxia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estrella`
--

INSERT INTO `estrella` (`id_estrella`, `nombre`, `gravedad`, `radio`, `masa`, `velocidad_escape`, `id_galaxia`) VALUES
(1, 'Sol', 274, 695700, 1989000, 617.5, 1),
(2, 'Sirius A', 26.4, 1.71, 2.02, 1030, 2),
(3, 'Alpha Centauri A', 22.8, 1.227, 1.1, 617, 3),
(4, 'Vega', 135, 2.135, 2.135, 1582, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galaxia`
--

CREATE TABLE `galaxia` (
  `id_galaxia` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_estrella` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `galaxia`
--

INSERT INTO `galaxia` (`id_galaxia`, `nombre`, `id_estrella`) VALUES
(1, 'Vía Láctea', 1),
(2, 'Canis Maior', 2),
(3, 'Centaurus', 3),
(4, 'Lyra', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planeta`
--

CREATE TABLE `planeta` (
  `id_planeta` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `gravedad` double DEFAULT NULL,
  `radio` double DEFAULT NULL,
  `masa` double DEFAULT NULL,
  `velocidad_escape` double DEFAULT NULL,
  `id_satelite` int(11) DEFAULT NULL,
  `id_estrella` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `planeta`
--

INSERT INTO `planeta` (`id_planeta`, `nombre`, `gravedad`, `radio`, `masa`, `velocidad_escape`, `id_satelite`, `id_estrella`) VALUES
(3, 'Mercurio', 3.7, 2.44, 0.055, 4.25, NULL, 1),
(4, 'Venus', 8.87, 6.05, 0.815, 10.36, NULL, 1),
(5, 'Tierra', 9.8561, 6.5537, 1, 11.2, 1, 1),
(6, 'Marte', 3.71, 3.39, 0.107, 5, 2, 1),
(7, 'Jupiter', 24.79, 69.91, 317.8, 59.5, 3, 1),
(8, 'Saturno', 10.44, 58.23, 95.2, 35.5, 4, 1),
(9, 'Urano', 8.69, 25.36, 14.6, 21.3, 5, 1),
(10, 'Neptuno', 11.15, 24.62, 17.2, 23.5, 6, 1),
(12, 'Tierrsasaasdsda', 9.8561, 0, 1, 11.2, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `satelite`
--

CREATE TABLE `satelite` (
  `id_satelite` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_planeta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `satelite`
--

INSERT INTO `satelite` (`id_satelite`, `nombre`, `id_planeta`) VALUES
(1, 'Luna', 5),
(2, 'Fobos', 6),
(3, 'Io', 7),
(4, 'Mimas', 8),
(5, 'Ariel', 9),
(6, 'Tritón', 10);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estrella`
--
ALTER TABLE `estrella`
  ADD PRIMARY KEY (`id_estrella`),
  ADD KEY `id_galaxia` (`id_galaxia`);

--
-- Indices de la tabla `galaxia`
--
ALTER TABLE `galaxia`
  ADD PRIMARY KEY (`id_galaxia`),
  ADD KEY `id_estrella` (`id_estrella`);

--
-- Indices de la tabla `planeta`
--
ALTER TABLE `planeta`
  ADD PRIMARY KEY (`id_planeta`),
  ADD KEY `id_satelite` (`id_satelite`),
  ADD KEY `id_estrella` (`id_estrella`);

--
-- Indices de la tabla `satelite`
--
ALTER TABLE `satelite`
  ADD PRIMARY KEY (`id_satelite`),
  ADD KEY `id_planeta` (`id_planeta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estrella`
--
ALTER TABLE `estrella`
  MODIFY `id_estrella` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `galaxia`
--
ALTER TABLE `galaxia`
  MODIFY `id_galaxia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `planeta`
--
ALTER TABLE `planeta`
  MODIFY `id_planeta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `satelite`
--
ALTER TABLE `satelite`
  MODIFY `id_satelite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `estrella`
--
ALTER TABLE `estrella`
  ADD CONSTRAINT `estrella_ibfk_1` FOREIGN KEY (`id_galaxia`) REFERENCES `galaxia` (`id_galaxia`);

--
-- Filtros para la tabla `galaxia`
--
ALTER TABLE `galaxia`
  ADD CONSTRAINT `galaxia_ibfk_1` FOREIGN KEY (`id_estrella`) REFERENCES `estrella` (`id_estrella`);

--
-- Filtros para la tabla `planeta`
--
ALTER TABLE `planeta`
  ADD CONSTRAINT `planeta_ibfk_1` FOREIGN KEY (`id_satelite`) REFERENCES `satelite` (`id_satelite`),
  ADD CONSTRAINT `planeta_ibfk_2` FOREIGN KEY (`id_estrella`) REFERENCES `estrella` (`id_estrella`);

--
-- Filtros para la tabla `satelite`
--
ALTER TABLE `satelite`
  ADD CONSTRAINT `satelite_ibfk_1` FOREIGN KEY (`id_planeta`) REFERENCES `planeta` (`id_planeta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
