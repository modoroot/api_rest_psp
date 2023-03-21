-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-03-2023 a las 14:03:15
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

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
-- Estructura de tabla para la tabla `access_tokens`
--

CREATE TABLE `access_tokens` (
  `id_access_token` int(11) NOT NULL,
  `token_id` varchar(500) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `access_tokens`
--

INSERT INTO `access_tokens` (`id_access_token`, `token_id`, `email`) VALUES
(9, 'ya29.a0AVvZVsrKT1ENTYzaSbvp1elnF11orx2srRtJEQ10qcxjhRvVxJPqjHQ06E8jrGI2k5CZHqWyN1_ebAuTxqEyiioC8_09v-03Rug3Vu8uuFJIO2akKjdU_0eRT0a8V41vnBwIbQ_vDc1MqhXX9sMOHrPp2fGcrgaCgYKAVcSARISFQGbdwaIK-B3HLsJmACham3vQFDltA0165', 'anunari324@g.educaand.es'),
(10, 'ya29.a0AVvZVso2pp33fuIvrAcmCOfi50W1pmpA4K4ypNkX-JYZir6a59TAwnfOqplqopx0pWJVP0CBW95Z7CuJlJdFR8vB_uFQdLgKvgD9yZweLZykfqV_Q87zUoXJPFNixDuQgpYu-OjohHoHjwF5eWMZC_XC2TtkaQaCgYKAfYSARISFQGbdwaI_Spu_KU5-46Bd0qobLzM1Q0165', 'anunari324@g.educaand.es'),
(47, 'ya29.a0AVvZVspzGMmGHk7w_Q8yninyjBpKyYlCN4AWawLKEPUx1M9Eg8SIhQ79_DLBkjPaBkp-617CDujTtn-RFYeRQPurhB_oe6iAlgTeA_boHKFmBowa2z3nk3wuDW-k013yEsxvH_K-Z1SSbTYAivK_anNvTGtDaCgYKASASARISFQGbdwaIr2fOJgD-eZ4CwtDdBg1gSQ0163', 'anunari324@g.educaand.es'),
(48, 'ya29.a0AVvZVsqch-kO0WkctTUJlesoQAModiEhKzWrlxkhobhf1C5SIWAQ-XDfFLj3u5Qxd7gZJ_CdgDd8Q5GaDBE_y-dHzcYiZP5biznY5cY905zuUGc4FOrD60FYfrxVN6GLBuIRjEpD28EOBqKXqcVZaokVjIRVaCgYKAbgSARISFQGbdwaIyJOWHoi-7ws5lClRQAeIOA0163', 'anunari324@g.educaand.es'),
(49, 'ya29.a0AVvZVsqDQ5p_lSf4A0C7QiK30a-5wy7bteEPvCdWlAWpVSu_cA93bRF_Qw8c74C9ARhTyPOYfdpRaFLckgB-4AGKHKXtlKLUI9qUySbpeFnEZp_H2cIJfo0LXuhv6moDKbV1ETOmvRFTPlHdQiJlee2U8AGCaCgYKAbMSARISFQGbdwaIFz7z51J12qBdlRN1og83Tw0163', 'anunari324@g.educaand.es');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estrella`
--

INSERT INTO `estrella` (`id_estrella`, `nombre`, `gravedad`, `radio`, `masa`, `velocidad_escape`, `id_galaxia`) VALUES
(1, 'Sol', 274, 695700, 1989000, 617.5, 1),
(2, 'Sirius A', 26.4, 1.71, 2.02, 1030, 2),
(3, 'Alpha Centauri A', 22.8, 1.227, 1.1, 617, 3),
(4, 'Vega', 135, 2.135, 2.135, 1582, 4),
(6, 'Vegadddsdasda', 1332335, 2.135, 2.135, 1582, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galaxia`
--

CREATE TABLE `galaxia` (
  `id_galaxia` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_estrella` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `galaxia`
--

INSERT INTO `galaxia` (`id_galaxia`, `nombre`, `id_estrella`) VALUES
(1, 'Vía Láctea', 1),
(2, 'Canis Maior', 2),
(3, 'Centaurus', 3),
(4, 'Lyra', 4),
(6, 'Lyrsadasdasdasda', 4),
(7, 'Lyrsda', 4),
(8, 'yrsda', 4),
(9, 'ejemplo POST', 2);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(19, 'Neptasdadsuno', 11.15, 24.62, 17.2, 23.5, 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `satelite`
--

CREATE TABLE `satelite` (
  `id_satelite` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_planeta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indices de la tabla `access_tokens`
--
ALTER TABLE `access_tokens`
  ADD PRIMARY KEY (`id_access_token`);

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
-- AUTO_INCREMENT de la tabla `access_tokens`
--
ALTER TABLE `access_tokens`
  MODIFY `id_access_token` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `estrella`
--
ALTER TABLE `estrella`
  MODIFY `id_estrella` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `galaxia`
--
ALTER TABLE `galaxia`
  MODIFY `id_galaxia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `planeta`
--
ALTER TABLE `planeta`
  MODIFY `id_planeta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
