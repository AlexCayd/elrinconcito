-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-11-2024 a las 23:05:13
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
-- Base de datos: `elrinconcito`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_productocarrito` int(4) NOT NULL,
  `usuario` int(4) NOT NULL,
  `producto` int(4) NOT NULL,
  `cantidad` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`) VALUES
(1, 'Vinos'),
(2, 'Quesos'),
(3, 'Carnes'),
(4, 'Aceites');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_compras`
--

CREATE TABLE `historial_compras` (
  `id_compra` int(4) NOT NULL,
  `usuario` int(4) NOT NULL,
  `producto` int(4) NOT NULL,
  `cantidad` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_compras`
--

INSERT INTO `historial_compras` (`id_compra`, `usuario`, `producto`, `cantidad`) VALUES
(24, 25, 70, 3),
(25, 25, 75, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `origenes`
--

CREATE TABLE `origenes` (
  `id_origen` int(4) NOT NULL,
  `origen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `origenes`
--

INSERT INTO `origenes` (`id_origen`, `origen`) VALUES
(1, 'Italia'),
(2, 'España'),
(3, 'Francia'),
(4, 'México'),
(5, 'Inglaterra'),
(6, 'Estados Unidos'),
(7, 'Japón'),
(8, 'Argentina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(4) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(400) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(4) NOT NULL,
  `fabricante` varchar(50) NOT NULL,
  `origen` int(4) NOT NULL,
  `categoria` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `imagen`, `precio`, `stock`, `fabricante`, `origen`, `categoria`) VALUES
(33, 'Queso Brie Francés', 'Este queso suave y cremoso, originario de Francia, se elabora con leche pasteurizada de vaca. Su corteza comestible de moho blanco esconde un interior untuoso con delicados matices de nuez y champiñones. Ideal para disfrutar con panes artesanales, frutas frescas o como centro de una tabla de quesos, el Brie Francés es un clásico elegante que realza cualquier ocasión.', 'ee47144df41d7fcfbf8f9ffad223f178.jpg', 379.00, 26, 'Président', 3, 2),
(34, 'Vino Tinto Cabernet Sauvignon (Reserva)', 'Este vino excepcional, elaborado con uvas cuidadosamente seleccionadas, se envejece en barricas de roble durante 18 meses. Presenta aromas de frutos negros, vainilla y especias, con un cuerpo robusto y taninos elegantes. Perfecto para acompañar carnes rojas, quesos maduros o disfrutar solo, este Cabernet Sauvignon reserva ofrece una experiencia rica y sofisticada en cada copa.', '643288f7acce67b02fbf3fcd5bc591aa.jpg', 849.00, 22, 'Marqués de Cáceres', 3, 1),
(35, 'Jamón Ibérico de Bellota', 'Este exquisito jamón proviene de cerdos ibéricos alimentados con bellotas en dehesas españolas. Su curación de más de 36 meses aporta un sabor profundo, con notas a frutos secos y mantequilla. De textura jugosa y marmoleada, es ideal para disfrutar solo o acompañado de un buen vino tinto, ofreciendo una experiencia gastronómica inigualable.', '018640d0f039efbdb39c79da3bd88890.jpg', 1199.00, 19, 'Cinco Jotas', 2, 3),
(36, 'Aceite de Oliva Extra Virgen Italiano', 'Este aceite de oliva se elabora exclusivamente con aceitunas italianas seleccionadas, prensadas en frío para conservar su pureza. Su sabor es afrutado, con notas de hierba fresca y un toque picante final. Ideal para ensaladas, panes artesanales y marinados, este aceite refleja la tradición culinaria italiana y realza cualquier platillo gourmet con su calidad premium.', '9d0de0f7c4b1401077ead66270117b01.jpg', 249.00, 18, 'Urbani Truffles', 1, 4),
(49, 'Manchego Reserva Artesanal', 'Este queso Manchego Reserva Artesanal es elaborado con leche cruda de oveja manchega en Finca La Mancha, España. Su maduración de 12 meses crea un sabor intenso, con matices a frutos secos y mantequilla. De textura escamosa y aroma envolvente, es ideal para tablas de quesos o maridajes con vinos tintos robustos.', '2982970c68b17abff895dc753c5286f8.jpg', 719.00, 45, 'Finca La Mancha', 2, 2),
(50, 'Carne de Res Angus Premium', 'La Carne de Res Angus Premium proviene de ganado criado bajo estrictos estándares de calidad, alimentado con granos naturales. Su marmoleo superior garantiza jugosidad, ternura y un sabor intenso. Ideal para cortes finos como ribeye o filete, esta carne destaca por su textura y calidad excepcionales, perfecta para asados gourmet y cenas especiales.', '1a6c1a3de5ce7a55b1d0899603d2ce33.jpg', 1249.00, 35, 'Rancho Angus Select', 6, 3),
(51, 'Sauvignon Blanc de Loire', 'Este Sauvignon Blanc de Loire es un vino fresco y elegante, con notas vibrantes de cítricos, frutas tropicales y un toque mineral distintivo. Perfecto para maridar con mariscos, ensaladas o como aperitivo, refleja el carácter único del Valle del Loira y su herencia vitivinícola de renombre mundial.', 'ae9a2ec57ef246d1397081bafe287213.jpg', 579.00, 71, 'Domaine Loire Éternel', 3, 1),
(52, 'Parmigiano Reggiano DOP', 'Este queso Parmigiano Reggiano DOP, madurado durante 24 a 36 meses, ofrece una textura granulada y un sabor inconfundible con matices de nueces y un toque umami. Ideal para rallar, usar en pastas o disfrutar con miel y frutos secos como aperitivo gourmet.', '122170d3bf3c8d174fa03ba41adf0c78.jpg', 949.00, 34, 'Caseificio Emilia Tradizione', 1, 2),
(53, 'Aceite de Sésamo Premium Japonés', 'Este Aceite de Sésamo Premium Japonés ofrece un sabor auténtico y profundo, elaborado con semillas de sésamo seleccionadas y tostadas con cuidado. Perfecto para realzar el sabor de salteados, aderezos y marinados, este aceite es un básico en la cocina japonesa, apreciado por su aroma intenso y calidad excepcional.', '86a4d8b67e6a1b111b349fef8781c152.jpg', 319.00, 65, 'Kinjirushi Co.', 7, 4),
(54, 'Rosé de Provence Millésimé', 'Este Rosé de Provence Millésimé combina elegancia y frescura con notas de frutos rojos, cítricos y un toque floral. Su color pálido y delicado refleja la tradición provenzal. Ideal para acompañar pescados, ensaladas o disfrutar solo en un día soleado, ofrece una experiencia de sabor refinada y única.', 'a1899b6e0e1cde87e14dbe36284722d4.jpg', 759.00, 42, 'Domaine de Provence Éclat', 3, 1),
(56, 'Malbec Gran Reserva', 'Vino tinto elegante con notas de frutos rojos maduros, vainilla y un toque especiado. Ideal para acompañar carnes rojas y quesos maduros. Envejecido en barricas de roble para un final suave y persistente.', '3fe600f1be640cba16d9a09570577864.jpg', 549.00, 85, 'Viñalba', 8, 1),
(57, 'Gorgonzola Dolce', 'Un queso azul suave y cremoso con un delicado sabor dulce y ligeramente picante. Perfecto para untar en pan fresco o disfrutar con frutas frescas y vinos blancos. Una experiencia auténtica y artesanal de la tradición italiana.', '143a2e01492b73c07f267b9ef20a235b.jpg', 319.00, 65, 'Luigi Guffanti 1876', 1, 2),
(58, 'Prosciutto di Parma', 'Jamón curado de forma tradicional con un sabor delicado y un toque salado. Perfecto para acompañar con melón, pan crujiente o en tablas de quesos. Un deleite gourmet que captura la esencia de la cocina italiana.', 'c3acc7273daa3639f484df660b76b68a.jpg', 449.00, 45, 'La Corte Parma', 1, 3),
(59, 'Aceite de Avellana', 'Un aceite artesanal de avellanas tostadas con un aroma intenso y un sabor suave y refinado. Ideal para aderezar ensaladas, pescados o platos gourmet. Una joya culinaria que aporta un toque único a cualquier receta.', 'cdef5d42928dbc34315b73cab076382c.jpg', 379.00, 32, 'La Tourangelle', 3, 4),
(60, 'Cheddar Vintage', 'Un queso cheddar madurado por más de 18 meses, con un sabor robusto, profundo y ligeramente picante. Perfecto para tablas de quesos, gratinados o acompañar con cervezas artesanales. Una joya clásica del legado británico.', 'f0288f7548d125e538bb282f3d4e86a2.jpg', 289.00, 73, 'Barber’s', 5, 2),
(61, 'Infusión de Limón y Romero Siciliano', 'Una infusión aromática y refrescante, con notas cítricas vibrantes del limón siciliano y el toque herbal del romero. Ideal para relajarse en cualquier momento del día, disfrutando de un sabor auténtico y natural.', 'e16b4fb88b806177bd7464aeb61cc218.jpg', 249.00, 60, 'Terre di Sicilia', 1, 4),
(62, 'Bresaola de Wagyu', 'Delicada carne de Wagyu curada, con una textura suave y un sabor profundo y sofisticado. Perfecta para degustar en finas lonjas acompañadas de aceite de oliva y limón. Un lujo culinario para los paladares más exigentes.', 'dcc1fa27ae41f259804efbb108659f5b.jpg', 889.00, 50, 'Wagyu Gourmet Delights', 7, 3),
(63, 'Roquefort de Cueva', 'Queso azul elaborado con leche de oveja, madurado en las legendarias cuevas de Roquefort. Su textura cremosa y sabor intenso con matices salinos lo convierten en un deleite exclusivo para amantes del queso gourmet. Perfecto para maridar con vinos dulces.', 'ecaad071da2b21073193dff3e57fb892.jpg', 649.00, 40, 'Société des Caves', 3, 2),
(64, 'Chorizo Español Selección Gourmet', 'Chorizo premium elaborado con carne de cerdo ibérico, pimentón de la Vera y una mezcla secreta de especias. Curado lentamente para alcanzar un sabor profundo y auténtico. Ideal para tapas, paellas o disfrutar con un buen vino tinto.', '17292e518026e0d256de7eb92b79fc04.jpg', 489.00, 26, 'La Iberia Artesana', 2, 3),
(65, 'Barolo Riserva DOCG', 'Vino tinto elegante y estructurado, elaborado con uvas Nebbiolo seleccionadas y envejecido en barricas de roble durante al menos 5 años. Destaca por sus notas de cereza madura, especias y tabaco, con un final largo y armonioso. Perfecto para ocasiones especiales.', '24ae1be39194228bb61159c6f16ef9d6.jpg', 1849.00, 40, 'Tenuta delle Langhe', 1, 1),
(66, 'Aceite de Almendra Dulce Provenzal', 'Aceite de almendras dulces prensado en frío, con un delicado aroma a frutos secos y un sabor suave y aterciopelado. Ideal para aderezos, repostería gourmet o como toque especial en platos mediterráneos. Un auténtico lujo provenzal.', '20235439d753013259bfb7dd98ef8e51.jpg', 619.00, 27, 'Maison Provençale', 3, 4),
(67, 'Cecina de Vacuno Premium', 'Delicada cecina de vacuno elaborada con cortes seleccionados, curada lentamente y ahumada con maderas nobles. Su textura suave y su sabor intenso la convierten en una joya de la gastronomía española. Ideal para tablas gourmet y maridajes.', '35731964a68aee6d681e6e4df6c7bc87.jpg', 749.00, 33, 'Dehesa Gourmet', 2, 3),
(68, 'Monterey Jack Artesanal', 'Queso Monterey Jack elaborado de forma artesanal con leche de vaca de pastoreo. Su textura cremosa y sabor suave con notas ligeramente dulces lo hacen ideal para derretir en platos gourmet o disfrutar con frutas frescas. Una auténtica delicia americana.', '0d7035e988616f5830d45862131149d4.jpg', 519.00, 25, 'Sierra Valley Creamery', 6, 2),
(69, 'Aceite de Uva Malbec', 'Aceite prensado en frío elaborado a partir de semillas de uva Malbec. Posee un aroma sutil y un sabor delicado con matices frutales. Ideal para ensaladas, marinados o como toque final en platos gourmet. Una exquisitez única de origen vinícola.', '988217bd431c4a88bbbe94f57aae7db4.jpg', 579.00, 50, 'Viñas del Sol', 8, 4),
(70, 'Wagyu A5 Ribeye', 'Corte excepcional de carne Wagyu grado A5, famoso por su marmoleo perfecto y textura mantequillosa. Su sabor profundo y suculento lo convierte en el estándar más alto de la gastronomía mundial. Ideal para preparar a la parrilla o al sartén con sal marina.', '305677e4648a93e2a1097f757cb6cc03.jpg', 4499.00, 21, 'Hokkaido Premium Meats', 7, 3),
(71, 'Sake Daiginjo Premium', 'Sake ultra premium elaborado con arroz pulido al 50% y fermentado con técnicas tradicionales japonesas. Presenta aromas delicados de melón y pera, con un sabor suave y elegante. Ideal para maridar con sushi, sashimi o disfrutar solo en momentos especiales.', 'b0ea9e4fba812c859b7de6a4a7476b19.jpg', 2099.00, 31, 'Takara Artisan Spirits', 7, 1),
(72, 'Tira de Asado Estilo Parrillero', 'Corte selecto de costilla de res, preparado al estilo tradicional parrillero argentino. Su marmoleo y jugosidad ofrecen un sabor auténtico, ideal para asar a la parrilla con fuego lento. Perfecto para compartir en reuniones y celebraciones.', '82281777f74bc2491dacc19ac87cf92f.jpg', 1199.00, 30, 'Gaucho Tradición', 8, 3),
(73, 'Zinfandel Sonoma Valley', 'Vino tinto vibrante y afrutado con notas de mora, frambuesa y un toque especiado de pimienta negra. Envejecido en barricas de roble, ofrece un final suave y persistente. Ideal para acompañar carnes a la parrilla y quesos maduros.', '338f98acb0371d97401459cee7e3e00b.jpg', 979.00, 25, 'Heritage Vineyards', 6, 1),
(74, 'Aceite de Oliva con Chimichurri', 'Mezcla artesanal de aceite de oliva virgen extra infusionado con chimichurri tradicional. Un equilibrio perfecto de hierbas, ajo y especias, ideal para marinar carnes, aderezar ensaladas o realzar el sabor de platos a la parrilla. Un imprescindible gourmet.', 'd07da69c2d29ccaef200dfeaaaf87d75.jpg', 449.00, 70, 'Sabores del Plata', 8, 4),
(75, 'Gruyère Alpino', 'Queso Gruyère de montaña madurado durante 12 meses, con una textura firme y un sabor profundo que combina notas de nuez y un toque salino. Perfecto para fondues, gratinados o disfrutar en tablas de quesos gourmet. Un clásico suizo incomparable.', '89f0727d98f9ca1f0213f09d607a3ac7.jpg', 669.00, 39, 'Maison des Fromages Suisses', 5, 2),
(77, 'Queso', 'Una descripcion Una descripcion Una descripcion Una descripcion Una descripcion', '331964145e60853dfb0470059d45d2fc.jpg', 1599.00, 15, 'Luigi Guffanti 1876', 7, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(4) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` char(60) NOT NULL,
  `f_nacimiento` date NOT NULL,
  `tarjeta_bancaria` varchar(20) NOT NULL,
  `direccion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`, `f_nacimiento`, `tarjeta_bancaria`, `direccion`) VALUES
(19, 'Angel Jesus Ruiz Estrada', 'angelj.ruiz2004@gmail.com', '$2y$10$WBselgRgIp53B2i6DhW5Sutq6RK/bhW9qN7cdEpHv1eRnKFp8bAHa', '2004-04-15', '1234-1234-1234-1234', 'Colotlipa 22'),
(20, 'Shelly Flores', '1234@gmail.com', '$2y$10$09OTri5F3Ab2iqvzoL5pHu6k28jYcb6Rpg7f2etnp47f/1nP27pS.', '2024-11-11', '1234-1254-1234-1234', 'Roma 24'),
(21, 'Admin Admin', 'admin@admin.com', '$2y$10$8yvcxe04PzHfumLGEh7PuO42erzEH1qemnP9duwrEl81HUMSVcPTq', '2024-11-21', '1234-1234-1234-1234', 'Lomas Anahuac 27'),
(23, 'Alida Alvarado', 'alida@gmail.com', '$2y$10$miD6O/vWBOGFzUdZQaNfkO3PrY7gg07o31BDmm3ORwJnz1zsDod1y', '2004-10-11', '1234-1234-1234-1234', 'Santa isabel tola 12'),
(25, 'Héctor Selley', 'hselley@gmail.com', '$2y$10$r.UFahALd04Zh.54tXvH9Ox3atm7Pbs3Q/v.z8WZmM..zxYOkuQwK', '1985-07-19', '1234-1234-1234-1234', 'Lomas Anahuac 66');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_productocarrito`),
  ADD KEY `producto` (`producto`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `producto` (`producto`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `origenes`
--
ALTER TABLE `origenes`
  ADD PRIMARY KEY (`id_origen`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `categoria` (`categoria`),
  ADD KEY `origen` (`origen`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_productocarrito` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  MODIFY `id_compra` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `origenes`
--
ALTER TABLE `origenes`
  MODIFY `id_origen` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD CONSTRAINT `historial_compras_ibfk_1` FOREIGN KEY (`producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `historial_compras_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`origen`) REFERENCES `origenes` (`id_origen`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
