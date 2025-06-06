-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 25-05-2025 a las 15:23:05
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cookingshop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `direccion` text NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `idUsuario`, `fecha`, `nickname`, `direccion`, `telefono`, `email`) VALUES
(1, 1, '2025-05-18 00:54:51', 'Jose', 'calle tal 7, 8', '+34 633231631', 'jlcgmieres15@gmail.com'),
(3, 11, '2025-05-09 23:08:13', 'Comprobante', 'tal tal tal', '23232323', 'comprobante@gmail.com'),
(4, 12, '2025-05-13 02:36:45', 'Mois', 'dddddd', '23232323', 'mmois@mmmm.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleventas`
--

CREATE TABLE `detalleventas` (
  `id` int(11) NOT NULL,
  `idProduc` int(5) NOT NULL,
  `idVenta` int(5) NOT NULL,
  `cantidad` int(5) NOT NULL,
  `precio` double NOT NULL,
  `sub` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalleventas`
--

INSERT INTO `detalleventas` (`id`, `idProduc`, `idVenta`, `cantidad`, `precio`, `sub`) VALUES
(80, 25, 71, 4, 2.5, 10),
(81, 24, 72, 3, 20, 60),
(82, 19, 72, 3, 30, 90),
(83, 25, 72, 4, 2.5, 10),
(84, 25, 73, 1, 2.5, 2.5),
(85, 20, 73, 5, 5, 25),
(86, 24, 74, 2, 20, 40),
(87, 19, 74, 2, 30, 60),
(88, 17, 74, 5, 3.5, 17.5),
(89, 24, 75, 2, 20, 40),
(90, 19, 75, 2, 30, 60),
(91, 17, 75, 5, 3.5, 17.5),
(92, 24, 76, 5, 20, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`id`, `idProduct`, `url`, `tipo`, `fecha_subida`) VALUES
(132, 25, '../../uploads/67cc76baa2682.jpg', 'image/jpeg', '2025-03-08 16:56:26'),
(134, 17, '../../uploads/67cc772f19021.jpg', 'image/jpeg', '2025-03-08 16:58:23'),
(135, 17, '../../uploads/67cc772f1acfb.jpg', 'image/jpeg', '2025-03-08 16:58:23'),
(136, 8, '../../uploads/67cddf333859a.jpg', 'image/jpeg', '2025-03-09 18:34:27'),
(137, 14, '../../uploads/67cddf4b25dce.jpg', 'image/jpeg', '2025-03-09 18:34:51'),
(138, 24, '../../uploads/67cddfeab9978.jpg', 'image/jpeg', '2025-03-09 18:37:30'),
(139, 20, '../../uploads/67cde52178746.jpg', 'image/jpeg', '2025-03-09 18:59:45'),
(140, 15, '../../uploads/67cde5e16e195.jpg', 'image/jpeg', '2025-03-09 19:02:57'),
(141, 19, '../../uploads/67cde603bf552.jpg', 'image/jpeg', '2025-03-09 19:03:31'),
(142, 18, '../../uploads/67cde6c1d7886.jpg', 'image/jpeg', '2025-03-09 19:06:41'),
(143, 16, '../../uploads/67cde75068b23.jpg', 'image/jpeg', '2025-03-09 19:09:04'),
(144, 25, '../../uploads/67d4487dc1a58.jpg', 'image/jpeg', '2025-03-14 15:17:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` double NOT NULL,
  `existencias` int(5) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `existencias`, `descripcion`) VALUES
(8, 'CocaCola', 4, 0, ' Coca-Cola es una de las bebidas más icónicas y populares del mundo. Con su característico sabor refrescante, se ha mantenido como una opción preferida por generaciones. Originaria de Estados Unidos, esta bebida carbonatada combina agua, azúcar, cafeína y un exclusivo sabor que la hace única. Ideal para acompañar comidas, momentos de descanso o celebraciones, Coca-Cola sigue siendo una opción versátil y atemporal.'),
(14, 'Fanta', 3, 3, ''),
(15, 'Mortero', 4, 10, ''),
(16, 'Pimienta negra', 3, 1, ''),
(17, 'Cilantro', 3.5, 11, 'El cilantro fresco es el toque perfecto para realzar el sabor de tus platillos favoritos. Con su característico aroma fresco y un sabor ligeramente cítrico, esta hierba es ideal para ensaladas, guisos, salsas, y más. Rico en vitaminas y antioxidantes, el cilantro no solo añade sabor, sino que también aporta beneficios nutricionales a tu dieta.\r\n\r\nEste cilantro ha sido cuidadosamente seleccionado para ofrecerte la mejor frescura y calidad. Cada ramita conserva su máximo sabor, garantizando una experiencia culinaria deliciosa y saludable.'),
(18, 'Rodillo', 4, 2, ''),
(19, 'Olla a presion', 30, 4, ''),
(20, 'Jalapeños', 5, 6, ''),
(21, 'Salsa cesar', 5, 10, ''),
(24, 'Horno de pizzas', 20, 5, 'Esto es un horno de pizzas'),
(25, 'Canela', 2.5, 10, 'La canela es una especia aromática que ha sido apreciada por sus propiedades y su delicioso sabor durante siglos. Extraída de la corteza interna de los árboles del género Cinnamomum, esta especia no solo agrega un toque cálido y dulce a tus platos, sino que también es conocida por sus múltiples beneficios para la salud.  Usos culinarios: La canela es versátil en la cocina: ideal para aromatizar postres, como pasteles, galletas, o incluso bebidas como cafés y tés. También es perfecta en platos salados, como curries y guisos, donde su sabor único puede elevar el perfil de cualquier receta. Ya sea en polvo o en rama, la canela es indispensable para muchos platillos tradicionales de todo el mundo.  Beneficios para la salud: Además de su sabor inconfundible, la canela es rica en antioxidantes y tiene propiedades antiinflamatorias. Se ha demostrado que ayuda a regular los niveles de azúcar en sangre, favorece la digestión y mejora la circulación. Con un toque de canela en tu dieta diaria, no solo enriquecerás tus platillos, sino que también incorporarás un aliado natural para tu bienestar.  Formato y presentación: Nuestra canela de alta calidad está disponible en polvo o en ramas, para que puedas elegir la presentación que mejor se adapte a tus necesidades. Perfecta para cocinar, hornear o disfrutar en infusiones.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `imagen_perfil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `pass`, `nombre`, `admin`, `imagen_perfil`) VALUES
(1, 'correo@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Admin', 1, 'perfil_1.jpg'),
(2, 'jlcgmieres15@gmail.com', '81b073de9370ea873f548e31b8adc081', 'Jose Luis', 1, NULL),
(3, 'mcg@gmail.com', 'def7924e3199be5e18060bb3e1d547a7', 'Moises', 0, NULL),
(9, 'prueba@gmail.com', 'c893bad68927b457dbed39460e6afd62', 'Prueba', 0, NULL),
(10, 'rmn@gmail.com', '81b073de9370ea873f548e31b8adc081', 'Ramon', 0, 'perfil_10.jpg'),
(11, 'comprobante@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Jose', 0, NULL),
(12, 'mmm@mmm.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Moi', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoracion`
--

CREATE TABLE `valoracion` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `puntuacion` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `valoracion`
--

INSERT INTO `valoracion` (`id`, `idUsuario`, `idProducto`, `comentario`, `puntuacion`, `fecha`) VALUES
(116, 1, 8, 'Este es un buen producto a solucionado mi vida dándome sobrepeso', 5, '2025-02-08 20:24:37'),
(117, 9, 8, 'Tiene mucho azucar, y el zero zero sabe a agua-caldo', 2, '2025-02-10 10:14:30'),
(118, 3, 8, '¿Por qué no reponen el stock? Quiero vigésima coca cola del día', 1, '2025-02-10 10:16:50'),
(134, 1, 24, 'es muy útil, sirve para todo', 4, '2025-03-27 11:36:15'),
(138, 12, 19, 'Esto funciona', 5, '2025-05-13 02:33:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `idCli` int(11) NOT NULL,
  `idPago` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `idCli`, `idPago`, `fecha`) VALUES
(71, 1, 'ch_3RRoT7RkQiaPbbYG1ShwIWkG', '2025-05-23 07:48:34'),
(72, 3, 'ch_3RRoVFRkQiaPbbYG0u4LRfg5', '2025-05-23 07:50:45'),
(73, 3, 'ch_3RRqp1RkQiaPbbYG1qksIj74', '2025-05-23 10:19:19'),
(74, 1, 'ch_3RS1WaRkQiaPbbYG1tYEGgrW', '2025-05-23 21:45:01'),
(75, 1, 'ch_3RS1aqRkQiaPbbYG0g3tiOS6', '2025-05-23 21:49:25'),
(76, 1, 'ch_3RSeShRkQiaPbbYG1OIvuIXo', '2025-05-25 15:19:36');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkidUser` (`idUsuario`);

--
-- Indices de la tabla `detalleventas`
--
ALTER TABLE `detalleventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKidProduc` (`idProduc`),
  ADD KEY `FKidVenta` (`idVenta`) USING BTREE;

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKidProduc` (`idProduct`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkidUser` (`idUsuario`),
  ADD KEY `fkidProd` (`idProducto`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkidCli` (`idCli`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalleventas`
--
ALTER TABLE `detalleventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalleventas`
--
ALTER TABLE `detalleventas`
  ADD CONSTRAINT `FKidVenta` FOREIGN KEY (`idVenta`) REFERENCES `ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idProduc` FOREIGN KEY (`idProduc`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `idProduct` FOREIGN KEY (`idProduct`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD CONSTRAINT `fkIdProd` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkIdUser` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `idCli` FOREIGN KEY (`idCli`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
