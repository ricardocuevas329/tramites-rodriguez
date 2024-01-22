
CREATE TABLE IF NOT EXISTS `abogado` (
  `s_codigo` char(7) NOT NULL,
  `s_paterno` varchar(40) DEFAULT NULL,
  `s_materno` varchar(40) DEFAULT NULL,
  `s_nombres` varchar(40) DEFAULT NULL,
  `s_sexo` char(1) DEFAULT NULL,
  `s_telefono` varchar(15) DEFAULT NULL,
  `s_cal` char(6) DEFAULT NULL,
  `s_colegio` varchar(50) DEFAULT NULL,
  `s_personal` varchar(10) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `s_nombres` (`s_nombres`),
  KEY `s_paterno` (`s_paterno`),
  KEY `s_materno` (`s_materno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.abogado: ~2 rows (aproximadamente)
INSERT INTO `abogado` (`s_codigo`, `s_paterno`, `s_materno`, `s_nombres`, `s_sexo`, `s_telefono`, `s_cal`, `s_colegio`, `s_personal`, `i_estado`) VALUES
	('AB001', 'FGDFGD', 'FFDGDFG', 'FGD', 'F', '935587895', 'fgdfg', 'GDFGD', NULL, 1),
	('AB002', 'gghhhhhhhhj', 'SDFSDFS', 'abogad', 'M', '987789456', 'sdf', 'SDFSDFS', NULL, 1);

-- Volcando estructura para tabla notariatambini.acceso_reniec
CREATE TABLE IF NOT EXISTS `acceso_reniec` (
  `s_codigo` varchar(12) NOT NULL,
  `d_fecha` date NOT NULL,
  `s_servicio` varchar(10) NOT NULL,
  `s_kardex` varchar(12) DEFAULT NULL,
  `s_personal` varchar(12) NOT NULL,
  `s_derivado` varchar(12) NOT NULL,
  `i_pago` int unsigned NOT NULL,
  `s_observacion` varchar(250) DEFAULT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE IF NOT EXISTS `fuera_registro` (
  `s_codigo` varchar(12) NOT NULL,
  `s_solicitante` varchar(10) DEFAULT NULL,
  `i_tipoPoder` int DEFAULT '0',
  `de_fregistro` date DEFAULT NULL,
  `de_finicio` date DEFAULT NULL,
  `de_ffinal` date DEFAULT NULL,
  `s_contenido` blob,
  `s_acta` varchar(10) DEFAULT NULL,
  `i_plantilla` int DEFAULT '0',
  `s_personal` varchar(10) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
-- Volcando estructura para tabla notariatambini.acciones
CREATE TABLE IF NOT EXISTS `acciones` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `s_codper` varchar(4) DEFAULT NULL,
  `s_nombre` varchar(120) DEFAULT NULL,
  `s_descripcion` varchar(255) DEFAULT NULL,
  `s_objeto` varchar(255) DEFAULT NULL,
  `d_fecha_reg` datetime DEFAULT NULL,
  `s_personal_reg` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `d_fecha_mod` datetime DEFAULT NULL,
  `s_personal_mod` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.acciones: ~2 rows (aproximadamente)
INSERT INTO `acciones` (`i_codigo`, `s_codper`, `s_nombre`, `s_descripcion`, `s_objeto`, `d_fecha_reg`, `s_personal_reg`, `d_fecha_mod`, `s_personal_mod`, `i_estado`) VALUES
	(16, '2324', 'vvv', 'descc', NULL, '2023-07-05 20:37:43', 'PE000035', NULL, NULL, 1),
	(17, 'codd', 'dee', 'oppp', NULL, '2023-07-05 20:46:55', 'PE000035', NULL, NULL, 1);

-- Volcando estructura para tabla notariatambini.accionpermiso
CREATE TABLE IF NOT EXISTS `accionpermiso` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `s_personal` varchar(10) DEFAULT NULL,
  `i_permiso` varchar(120) DEFAULT NULL,
  `s_personal_reg` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `d_fecha_mod` datetime DEFAULT NULL,
  `s_personal_mod` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.accionpermiso: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.accion_particion_web
CREATE TABLE IF NOT EXISTS `accion_particion_web` (
  `s_codigo` char(12) NOT NULL,
  `s_codigo_datos_web` char(12) DEFAULT NULL,
  `s_compareciente` char(10) DEFAULT NULL,
  `d_valor_suscribir` decimal(10,2) DEFAULT NULL,
  `i_estado` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.accion_particion_web: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.actos
CREATE TABLE IF NOT EXISTS `actos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `desc` varchar(45) DEFAULT NULL,
  `tipoep_id` int NOT NULL,
  PRIMARY KEY (`id`,`tipoep_id`),
  KEY `fk_actos_tipoep` (`tipoep_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.actos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.actos_cnl
CREATE TABLE IF NOT EXISTS `actos_cnl` (
  `codigo` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.actos_cnl: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.actos_ro
CREATE TABLE IF NOT EXISTS `actos_ro` (
  `codigo` varchar(3) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `estado` int unsigned NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.actos_ro: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.acto_comparecencia
CREATE TABLE IF NOT EXISTS `acto_comparecencia` (
  `s_codigo` varchar(12) NOT NULL,
  `s_acto` varchar(12) NOT NULL,
  `s_tipo` varchar(12) NOT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.acto_comparecencia: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.acto_juridico
CREATE TABLE IF NOT EXISTS `acto_juridico` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(100) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.acto_juridico: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.acto_notarial
CREATE TABLE IF NOT EXISTS `acto_notarial` (
  `s_codigo` varchar(6) NOT NULL,
  `i_grupo` int DEFAULT '0',
  `s_familia` varchar(5) DEFAULT NULL,
  `s_codigo_sbs` varchar(3) DEFAULT NULL,
  `s_codigo_sunat` varchar(5) DEFAULT NULL,
  `s_codigo_acto` varchar(5) DEFAULT NULL,
  `s_nombre` varchar(200) DEFAULT NULL,
  `s_clase` char(5) DEFAULT NULL,
  `s_tipoKardex` char(5) DEFAULT NULL,
  `i_cuantia` int DEFAULT '0',
  `i_medio_pago` int DEFAULT '0',
  `i_origen_fondos` int DEFAULT '0',
  `i_oport_pago_otros` int DEFAULT '0',
  `i_imp_renta` int DEFAULT '0',
  `i_formato_intervencion` int DEFAULT '0',
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.acto_notarial: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.anotaciones
CREATE TABLE IF NOT EXISTS `anotaciones` (
  `s_codigo` varchar(12) NOT NULL,
  `s_referencia` varchar(12) DEFAULT NULL,
  `s_anotacion` varchar(500) DEFAULT NULL,
  `d_fecha_reg` datetime DEFAULT NULL,
  `s_personal_reg` varchar(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.anotaciones: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.anotacion_kardex
CREATE TABLE IF NOT EXISTS `anotacion_kardex` (
  `s_kardex` char(12) DEFAULT NULL,
  `s_personal` varchar(150) DEFAULT NULL,
  `s_observacion` text,
  `d_fecha` date DEFAULT NULL,
  `d_hora` varchar(10) DEFAULT NULL,
  `i_importancia` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.anotacion_kardex: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.arancel
CREATE TABLE IF NOT EXISTS `arancel` (
  `s_codigo` char(5) NOT NULL,
  `s_servicio` char(5) DEFAULT NULL,
  `s_tipo` char(5) DEFAULT NULL,
  `s_rango` char(5) DEFAULT NULL,
  `de_precio` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.arancel: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.area
CREATE TABLE IF NOT EXISTS `area` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(30) DEFAULT NULL,
  `s_descarea` varchar(90) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.area: ~16 rows (aproximadamente)
INSERT INTO `area` (`s_codigo`, `s_nombre`, `s_descarea`, `i_estado`) VALUES
	('12-31', 'nom,,', 'descasca', 1),
	('13', 'asdasdaasdasdsdas', 'dasdasdasasdasd', 1),
	('14', 'nomvv', 'descscasca', 1),
	('2', 'asdasdasd', 'asdasda', 1),
	('20', 'dessss', 'sensadddda', 1),
	('3', 'sdfsdfsd', 'fsdfsdf', 1),
	('35', NULL, NULL, 1),
	('38', NULL, NULL, 1),
	('4', 'asdasdas', 'dasdasd', 1),
	('56', 'asdasdasdas', 'dasdasdas', 1),
	('61', 'etccc', 'año nbuev', 1),
	('62', NULL, NULL, 1),
	('89', 'EXTRAPROTOCO', 'DESCSCSC', 1),
	('95', 'TEST', 'TEST', 1),
	('A0001', 'PROTOCOLAR', 'PRO', 1),
	('A0002', 'EXTRA', 'EXTRA', 1),
	('AR003', 'EXTRAPROTOCOLAR22', 'EXTRAPROTOCOLAR2', 1),
	('AR004', 'XXXX', 'DESSDSD', 1),
	('AR005', 'XXX', 'DESCXX', 1);

-- Volcando estructura para tabla notariatambini.area_registral
CREATE TABLE IF NOT EXISTS `area_registral` (
  `s_codigo` char(5) NOT NULL,
  `s_descripcion` varchar(40) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.area_registral: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.asesoria_legal
CREATE TABLE IF NOT EXISTS `asesoria_legal` (
  `s_codigo` char(12) NOT NULL,
  `s_registro` int DEFAULT NULL,
  `s_acto_notarial` varchar(6) DEFAULT NULL,
  `s_solicitante` char(10) DEFAULT NULL,
  `s_referencia` char(10) DEFAULT NULL,
  `s_facturado` char(10) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(15) DEFAULT NULL,
  `s_atendido` char(8) DEFAULT NULL,
  `s_observacion` varchar(500) DEFAULT NULL,
  `s_requisitos` varchar(255) DEFAULT NULL,
  `i_estado_tramite` int DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.asesoria_legal: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.asignacion_laboral
CREATE TABLE IF NOT EXISTS `asignacion_laboral` (
  `s_codigo` varchar(12) NOT NULL,
  `s_personal` varchar(12) DEFAULT NULL,
  `s_cargo` varchar(12) DEFAULT NULL,
  `s_area` varchar(12) DEFAULT NULL,
  `s_seccion` varchar(12) DEFAULT NULL,
  `d_fecha_ing` date DEFAULT NULL,
  `d_fecha_fin` date DEFAULT NULL,
  `d_fecha_reg` datetime DEFAULT NULL,
  `s_personal_reg` varchar(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.asignacion_laboral: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.autorizacion_venta
CREATE TABLE IF NOT EXISTS `autorizacion_venta` (
  `s_codigo` varchar(12) NOT NULL DEFAULT '',
  `s_solicitante` varchar(12) DEFAULT NULL,
  `s_servicio` varchar(12) DEFAULT NULL,
  `s_motivo` varchar(250) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(16) DEFAULT NULL,
  `de_precio` decimal(9,2) DEFAULT NULL,
  `s_autorizado` varchar(12) DEFAULT NULL,
  `d_fecha_autorizado` date DEFAULT NULL,
  `s_hora_autorizado` varchar(16) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.autorizacion_venta: 0 rows
/*!40000 ALTER TABLE `autorizacion_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `autorizacion_venta` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.autos
CREATE TABLE IF NOT EXISTS `autos` (
  `s_codigo` char(12) NOT NULL,
  `s_kardex` char(12) DEFAULT NULL,
  `i_tipo` int DEFAULT NULL,
  `s_numero` varchar(30) DEFAULT NULL,
  `s_clase` varchar(50) DEFAULT NULL,
  `s_marca` varchar(50) DEFAULT NULL,
  `s_ano` char(4) DEFAULT NULL,
  `s_modelo` varchar(50) DEFAULT NULL,
  `s_serie` varchar(50) DEFAULT NULL,
  `s_color` varchar(30) DEFAULT NULL,
  `s_carroceria` varchar(30) DEFAULT NULL,
  `s_motor` varchar(50) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  `i_tipo_vehiculo` int DEFAULT '0',
  `s_combustible` varchar(150) DEFAULT NULL,
  `s_cilindro` varchar(12) DEFAULT NULL,
  `s_num_rueda` varchar(12) DEFAULT NULL,
  `s_sede_registral` varchar(12) DEFAULT NULL,
  `s_partida_registral` varchar(12) DEFAULT NULL,
  `d_inscripcion` date DEFAULT NULL,
  `s_operacion` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.autos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.autos_web
CREATE TABLE IF NOT EXISTS `autos_web` (
  `s_codigo` char(12) NOT NULL,
  `s_datos` char(12) DEFAULT NULL,
  `i_tipo` int DEFAULT NULL,
  `s_numero` varchar(30) DEFAULT NULL,
  `s_clase` varchar(50) DEFAULT NULL,
  `s_marca` varchar(50) DEFAULT NULL,
  `s_ano` char(4) DEFAULT NULL,
  `s_modelo` varchar(50) DEFAULT NULL,
  `s_serie` varchar(50) DEFAULT NULL,
  `s_color` varchar(30) DEFAULT NULL,
  `s_carroceria` varchar(30) DEFAULT NULL,
  `s_motor` varchar(50) DEFAULT NULL,
  `s_dir_doc` text,
  `s_tar_doc` text,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.autos_web: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.banco
CREATE TABLE IF NOT EXISTS `banco` (
  `id_cod` int NOT NULL AUTO_INCREMENT,
  `s_cod_pdt` varchar(5) NOT NULL,
  `s_cod_cnl` varchar(5) DEFAULT NULL,
  `s_nombre` varchar(50) DEFAULT NULL,
  `s_abrev` varchar(5) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`id_cod`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.banco: ~76 rows (aproximadamente)
INSERT INTO `banco` (`id_cod`, `s_cod_pdt`, `s_cod_cnl`, `s_nombre`, `s_abrev`, `i_estado`) VALUES
	(1, '02', NULL, 'DE CREDITO DEL PERU', 'BCP', 1),
	(2, '03', NULL, 'INTERBANK', NULL, 1),
	(3, '05', NULL, 'LATINO', 'LAT', 0),
	(4, '07', NULL, 'CITYBANK N.A.', NULL, 1),
	(5, '08', NULL, 'STANDAR CHARTERED', NULL, 0),
	(6, '09', NULL, 'SCOTIABANK PERU', '', 1),
	(7, '100', NULL, 'YAPE', NULL, 1),
	(8, '101', NULL, 'PLIN', NULL, 1),
	(9, '11', NULL, 'CONTINENTAL', NULL, 1),
	(10, '12', NULL, 'DE LIMA', NULL, 0),
	(11, '16', NULL, 'MERCANTIL', NULL, 0),
	(12, '18', NULL, 'NACION', NULL, 1),
	(13, '22', NULL, 'SANTANNDER CENTRAL HISPANO - PERU', NULL, 0),
	(14, '23', NULL, 'DE COMERCIO', NULL, 1),
	(15, '25', NULL, 'REPUBLICA', NULL, 0),
	(16, '26', NULL, 'NBK BANK', NULL, 0),
	(17, '29', NULL, 'BANCOSUR', NULL, 0),
	(18, '35', NULL, 'FINANCIERO DEL PERU', NULL, 1),
	(19, '37', NULL, 'DEL PROGRESO', NULL, 0),
	(20, '38', NULL, 'INTERAMERICANO DE FINANZAS', NULL, 1),
	(21, '39', NULL, 'BANEX', NULL, 0),
	(22, '40', NULL, 'NUEVO MUNDO', NULL, 0),
	(23, '41', NULL, 'SUDAMERICANO', NULL, 0),
	(24, '42', NULL, 'DEL LIBERTADOR', NULL, 0),
	(25, '43', NULL, 'DEL TRABAJO', NULL, 0),
	(26, '44', NULL, 'SOLVENTA', NULL, 0),
	(27, '45', NULL, 'SERBANCO', NULL, 0),
	(28, '46', NULL, 'BANCO OF BOSTON', NULL, 0),
	(29, '47', NULL, 'ORION', NULL, 0),
	(30, '48', NULL, 'DEL PAIS', NULL, 0),
	(31, '49', NULL, 'MI BANCO', NULL, 0),
	(32, '50', NULL, 'BNP PARIBAS', NULL, 0),
	(33, '51', NULL, 'AGROBANCO', NULL, 0),
	(34, '53', NULL, 'HSBC BANK PERU S.A', NULL, 1),
	(35, '54', NULL, 'BANCO FALABELLA PERU', NULL, 1),
	(36, '55', NULL, 'BANCO RIPLEY', NULL, 1),
	(37, '56', NULL, 'BANCO SANTANDER PERU S.A', NULL, 0),
	(38, '58', NULL, 'BANCO AZTECA DEL PERU', NULL, 0),
	(39, '99', NULL, 'OTROS', NULL, 1),
	(40, 'PDT', 'CNL', 'NOM', 'ABRE', 1),
	(41, 'pdt', 'cnll', 'nombre', 'abrr', 1),
	(42, 'pdt', 'cnll', 'nombre', 'abrr', 1),
	(43, 'pdt', 'cnl', 'nomm', 'ab', 1),
	(44, 'ppp', 'ccc', 'nnn', 'abbb', 1),
	(45, 'nnnn', 'nnn', 'nnn', 'nn', 1),
	(46, 'nnnn', 'nnn', 'nnn', 'nn', 1),
	(47, 'nnnn', 'nnn', 'nnn', 'nn', 1),
	(48, 'nnnn', 'nnn', 'nnn4', 'nn', 1),
	(49, 'nn22', 'nnn', 'nnn4', 'nn', 1),
	(50, 'nn22', '1000', 'nnn4', 'nn', 1),
	(51, 'nn22', '1000', 'nnn4', 'ab', 1),
	(52, 'nn22', '1000', 'nnn4', 'ab', 1),
	(53, 'nnnn', 'nnn', 'nnn4', 'nn', 1),
	(54, 'nnnn', 'nnn', 'nnn4', 'nn', 1),
	(55, 'nnnn', 'nnn', 'nnn4', 'nn', 1),
	(56, 'nnnn', 'nnn', 'nnn4', 'nn', 0),
	(57, 'nnnn', 'nnn', 'nnn4', 'nn', 1),
	(58, 'nnnn', 'nnn', 'nnn4', 'nn', 1),
	(59, 'nnnn', 'nnn', 'nnn4', 'nn', 1),
	(60, 'nnnn', 'nnn', 'nnn4', 'nn', 1),
	(61, 'nnnn', 'nnn', 'nnn4', 'nn', 1),
	(62, 'nnnn', 'nnn', 'nnn4', 'nn', 1),
	(63, 'nnnn', 'nnn', 'nnn4', 'nn', 0),
	(64, 'nnnn', 'nnn', 'nnn4', 'nn', 1),
	(65, 'nnnn', 'nnn', 'nnn43', 'nn', 1),
	(66, 'nnnn', 'nnn', 'nnn4', 'nn', 1),
	(67, 'aaa', 'nnn', 'nnn4', 'nn', 1),
	(68, 'PDT', 'CNL', 'INTERLATINO', 'INLAT', 1),
	(69, 'PDT', 'CNL', 'CAJATRUJILLO', 'ABR', 1),
	(70, 'PDT', 'CNL', 'CAJATRUJILLO2', 'ABR', 1),
	(71, 'PDT', 'CNL', 'CAJATRUJILLO2', 'ABR', 1),
	(72, 'PDT', 'CNL', 'CAJATRUJILLO2', 'ABR', 1),
	(73, 'PDT', 'CNL', 'CAJATRUJILLO3', 'ABR', 0),
	(74, 'PDT', 'CNL', 'CAJATRUJILL6', 'ABR', 1),
	(75, 'PDT', 'CNL', 'CAJATRUJILLO88', 'ABR', 1),
	(76, 'PDT', 'CNL', 'CAJATRUJIL45', 'ABR', 1),
	(77, 'PGGG', 'CAA', 'CAGGG', 'AHHH', 1),
	(78, 'DEE', 'CMNN', 'TESSATT', 'AVBAB', 1);

-- Volcando estructura para tabla notariatambini.banco_deposito
CREATE TABLE IF NOT EXISTS `banco_deposito` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `s_nombre` varchar(255) DEFAULT NULL,
  `s_contable` varchar(255) DEFAULT NULL,
  `s_descripcion` varchar(255) DEFAULT NULL,
  `s_tipo` varchar(1) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.banco_deposito: ~20 rows (aproximadamente)
INSERT INTO `banco_deposito` (`i_codigo`, `s_nombre`, `s_contable`, `s_descripcion`, `s_tipo`, `i_estado`) VALUES
	(1, 'BCP REGISTRALES', '104105', NULL, '0', 1),
	(2, 'BCP NOTARIALES', '104101', NULL, '0', 1),
	(3, 'BCP REGISTROSPAGOS', '104109', NULL, '0', 1),
	(4, 'BANCO NACION AUTODETRACION', '104102', NULL, '0', 1),
	(5, 'BANCO NACION DETRACCION', '104102', NULL, '0', 1),
	(6, 'BANCO CONTINENTAL', '104104', NULL, '1', 1),
	(7, 'RECLAMACION TER', '162901', '', '0', 1),
	(8, 'REDONDEO', '65501', NULL, '0', 1),
	(9, 'DEPOSITOS NO IDENTIFICADOS NOTARIALES', '461101', '', '0', 1),
	(10, 'DEPOSITOS NO IDENTIFICADOS REGISTRALES', '469999', '', '0', 1),
	(11, 'IZIPAY', '168201', '', '0', 1),
	(12, 'CAJA', '101101', '', '0', 1),
	(13, 'PRESTAMOS', '141301', '', '0', 1),
	(14, 'INTERES GANADO', '772012', '', '0', 1),
	(15, 'CREDISCOTIA FINANCIERA S.A.', '000000', NULL, '0', 1),
	(16, 'BANBIF', '104108', '', '0', 1),
	(17, 'SUELDOS', '411101', '', '0', 1),
	(18, 'CXPAGAR', '421201', '', '0', 1),
	(19, 'RECHAZO PROVEED', '469901', '', '0', 1),
	(20, 'BANBIF USD', '104110', '', '0', 1),
	(21, 'INTERBANKK2', '0102023', NULL, '1', 1);

-- Volcando estructura para tabla notariatambini.bienes
CREATE TABLE IF NOT EXISTS `bienes` (
  `s_codigo` varchar(5) NOT NULL,
  `s_nombre` varchar(150) DEFAULT NULL,
  `s_decripcion` varchar(250) DEFAULT NULL,
  `i_estado` int unsigned DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.bienes: 5 rows
/*!40000 ALTER TABLE `bienes` DISABLE KEYS */;
INSERT INTO `bienes` (`s_codigo`, `s_nombre`, `s_decripcion`, `i_estado`) VALUES
	('B0002', 'BIEN3', 'DEGG', 1),
	('B0001', 'ASDASD', 'ASDASD', 1),
	('B0003', 'BIEN4', 'DESC', 1),
	('B0004', 'DESCASAD', 'BIEN5', 1),
	('B0005', 'BKEN2', 'DESCASAD', 1);
/*!40000 ALTER TABLE `bienes` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.bienes_aporta_web
CREATE TABLE IF NOT EXISTS `bienes_aporta_web` (
  `s_codigo` char(12) NOT NULL,
  `s_codigo_datos_web` char(12) DEFAULT NULL,
  `s_compareciente` char(10) DEFAULT NULL,
  `s_descripcion_bien` text,
  `d_valor_mercado` decimal(10,2) DEFAULT NULL,
  `i_cantidad` int DEFAULT NULL,
  `i_estado` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.bienes_aporta_web: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.bienoperacion
CREATE TABLE IF NOT EXISTS `bienoperacion` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `s_bien` varchar(12) DEFAULT NULL,
  `s_operacion` varchar(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4261 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.bienoperacion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.caja_chica
CREATE TABLE IF NOT EXISTS `caja_chica` (
  `s_codigo` varchar(12) NOT NULL,
  `i_tipo` int DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_solicitado` varchar(10) DEFAULT NULL,
  `s_descripcion` varchar(250) DEFAULT NULL,
  `s_comprobante` varchar(50) DEFAULT NULL,
  `s_usuario` varchar(12) DEFAULT NULL,
  `s_moneda` varchar(5) DEFAULT NULL,
  `de_monto` decimal(9,2) DEFAULT NULL,
  `d_fecha_autoriza` datetime DEFAULT NULL,
  `i_caja` int DEFAULT NULL,
  `s_personal_autoriza` varchar(10) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.caja_chica: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.caja_notary
CREATE TABLE IF NOT EXISTS `caja_notary` (
  `s_codigo` varchar(10) NOT NULL,
  `s_referencia` varchar(2) DEFAULT NULL,
  `s_numero` varchar(6) DEFAULT NULL,
  `s_tipo` varchar(30) DEFAULT NULL,
  `s_serie` varchar(3) DEFAULT NULL,
  `s_ticket` varchar(8) DEFAULT NULL,
  `s_nombre` varchar(150) DEFAULT NULL,
  `d_fecha` varchar(20) DEFAULT NULL,
  `s_total` decimal(9,2) DEFAULT NULL,
  `s_moneda` varchar(20) DEFAULT NULL,
  `de_pagado` decimal(9,2) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `referencia` (`s_referencia`),
  KEY `numero` (`s_numero`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.caja_notary: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.cambiocaracteristica
CREATE TABLE IF NOT EXISTS `cambiocaracteristica` (
  `s_codigo` varchar(12) NOT NULL,
  `d_fecha_registro` date DEFAULT NULL,
  `s_acta` varchar(10) DEFAULT NULL,
  `s_solicitante` varchar(12) DEFAULT NULL,
  `s_participacion` int DEFAULT NULL,
  `s_placa` varchar(50) DEFAULT NULL,
  `s_formulario` varchar(50) DEFAULT NULL,
  `s_documento_rep` varchar(5) DEFAULT NULL,
  `s_numero_rep` varchar(25) DEFAULT NULL,
  `s_representante` varchar(255) DEFAULT NULL,
  `s_partida` varchar(25) DEFAULT NULL,
  `s_oficina` varchar(12) DEFAULT NULL,
  `s_personal` varchar(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.cambiocaracteristica: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.captacion
CREATE TABLE IF NOT EXISTS `captacion` (
  `s_codigo` varchar(12) NOT NULL,
  `s_asesor` varchar(45) NOT NULL,
  `s_usuario` varchar(45) NOT NULL,
  `s_observacion` varchar(45) NOT NULL,
  `i_tipo_estado` int unsigned NOT NULL,
  `d_fecha` date NOT NULL,
  `i_estado` varchar(45) NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.captacion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.cargo
CREATE TABLE IF NOT EXISTS `cargo` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(50) DEFAULT NULL,
  `s_descripcion` varchar(100) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.cargo: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.cargos
CREATE TABLE IF NOT EXISTS `cargos` (
  `codigo` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`codigo`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.cargos: 9 rows
/*!40000 ALTER TABLE `cargos` DISABLE KEYS */;
INSERT INTO `cargos` (`codigo`, `descripcion`, `i_estado`) VALUES
	('cod', 'DESC', 1),
	('cod45', 'ree', 1),
	('co23', 'descsc', 1),
	('cdddd', 'asdasda', 1),
	('demo', 'demoo', 1),
	('te2', 'tessssasddd', 1),
	('cargo', 'descr demo', 1),
	('carg', 'demo2', 1),
	('cccc', 'dess', 1);
/*!40000 ALTER TABLE `cargos` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.cargo_minuta
CREATE TABLE IF NOT EXISTS `cargo_minuta` (
  `s_codigo` char(6) NOT NULL,
  `s_nombres` varchar(80) DEFAULT NULL,
  `s_abrev` varchar(12) DEFAULT NULL,
  `s_descripcion` varchar(255) DEFAULT NULL,
  `i_tipo` int DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.cargo_minuta: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.cartapresentacion
CREATE TABLE IF NOT EXISTS `cartapresentacion` (
  `i_idcart` int NOT NULL AUTO_INCREMENT,
  `s_codigo` char(8) DEFAULT NULL,
  `s_ruc` varchar(15) DEFAULT NULL,
  `s_razonsocial` varchar(500) DEFAULT NULL,
  `s_contacto` varchar(500) DEFAULT NULL,
  `s_email` varchar(500) DEFAULT NULL,
  `s_telefono` varchar(60) DEFAULT NULL,
  `s_fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`i_idcart`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.cartapresentacion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.cartas
CREATE TABLE IF NOT EXISTS `cartas` (
  `s_carta` char(12) NOT NULL,
  `s_codigo` char(12) NOT NULL,
  `s_numcarta` int DEFAULT NULL,
  `s_acto_notarial` varchar(6) DEFAULT NULL,
  `s_servicio` varchar(6) DEFAULT NULL,
  `s_remitente` char(10) DEFAULT NULL,
  `s_empresa` char(10) DEFAULT NULL,
  `s_facturado` char(10) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(15) DEFAULT NULL,
  `d_fecha_cierre` date DEFAULT NULL,
  `s_destinatario` varchar(250) DEFAULT NULL,
  `s_localidad` varchar(200) DEFAULT NULL,
  `s_direccioncarta` varchar(250) DEFAULT NULL,
  `s_atendido` char(8) DEFAULT NULL,
  `d_fechaEntrega` date DEFAULT NULL,
  `s_horaEntrega` varchar(15) DEFAULT NULL,
  `s_N1` varchar(12) DEFAULT NULL,
  `s_N2` char(5) DEFAULT NULL,
  `s_N3` char(5) DEFAULT NULL,
  `s_N4` char(5) DEFAULT NULL,
  `s_descripcion` varchar(4000) DEFAULT NULL,
  `s_observacion` varchar(255) DEFAULT NULL,
  `s_entregado` varchar(12) DEFAULT NULL,
  `s_mensajero` varchar(150) DEFAULT NULL,
  `s_recogido` char(10) DEFAULT NULL,
  `d_fechaRegogido` date DEFAULT NULL,
  `i_cantidad` int DEFAULT NULL,
  `de_precio` decimal(10,2) DEFAULT NULL,
  `s_horaRecogido` varchar(15) DEFAULT NULL,
  `i_tipopago` int DEFAULT NULL,
  `i_delivery` int DEFAULT '0',
  `i_bajopuerta` int DEFAULT '0',
  `i_urgente` int DEFAULT '0',
  `i_situacion` int DEFAULT '1',
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_carta`),
  KEY `Numero` (`s_codigo`),
  KEY `idx_cartas_01` (`d_fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.cartas: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.cartasarchivos
CREATE TABLE IF NOT EXISTS `cartasarchivos` (
  `s_codigo` int NOT NULL AUTO_INCREMENT,
  `s_codigo_carta` varchar(12) DEFAULT NULL,
  `s_numcarta` varchar(11) DEFAULT NULL,
  `i_firma` varchar(12) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.cartasarchivos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.cartas_provincia
CREATE TABLE IF NOT EXISTS `cartas_provincia` (
  `s_carta` char(12) NOT NULL,
  `s_codigo` char(12) NOT NULL,
  `s_numcarta` int DEFAULT NULL,
  `s_acto_notarial` varchar(6) DEFAULT NULL,
  `s_servicio` varchar(6) DEFAULT NULL,
  `s_remitente` char(10) DEFAULT NULL,
  `s_empresa` char(10) DEFAULT NULL,
  `s_facturado` char(10) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(15) DEFAULT NULL,
  `d_fecha_cierre` date DEFAULT NULL,
  `s_destinatario` varchar(250) DEFAULT NULL,
  `s_localidad` varchar(200) DEFAULT NULL,
  `s_direccioncarta` varchar(250) DEFAULT NULL,
  `s_atendido` char(8) DEFAULT NULL,
  `d_fechaEntrega` date DEFAULT NULL,
  `s_horaEntrega` varchar(15) DEFAULT NULL,
  `s_N1` char(5) DEFAULT NULL,
  `s_N2` char(5) DEFAULT NULL,
  `s_N3` char(5) DEFAULT NULL,
  `s_N4` char(5) DEFAULT NULL,
  `s_descripcion` varchar(1000) DEFAULT NULL,
  `s_observacion` varchar(255) DEFAULT NULL,
  `s_entregado` varchar(12) DEFAULT NULL,
  `s_mensajero` varchar(150) DEFAULT NULL,
  `s_recogido` char(10) DEFAULT NULL,
  `d_fechaRegogido` date DEFAULT NULL,
  `i_cantidad` int DEFAULT NULL,
  `de_precio` decimal(10,2) DEFAULT NULL,
  `s_horaRecogido` varchar(15) DEFAULT NULL,
  `i_tipopago` int DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_carta`),
  KEY `Numero` (`s_codigo`),
  KEY `idx_cartas_provincia_01` (`d_fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.cartas_provincia: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.carta_orden
CREATE TABLE IF NOT EXISTS `carta_orden` (
  `s_codigo` char(12) NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.carta_orden: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.carta_ordenprovincias
CREATE TABLE IF NOT EXISTS `carta_ordenprovincias` (
  `s_codigo` char(12) NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.carta_ordenprovincias: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.casado
CREATE TABLE IF NOT EXISTS `casado` (
  `s_codigo` char(8) NOT NULL,
  `s_esposo` char(10) DEFAULT NULL,
  `s_esposa` char(10) DEFAULT NULL,
  `s_Tipo` char(1) DEFAULT NULL,
  `s_conviven` char(1) DEFAULT NULL,
  `s_partida` varchar(20) DEFAULT NULL,
  `s_oficina` char(5) DEFAULT NULL,
  `s_observacion` varchar(255) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.casado: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `s_codigo` char(12) NOT NULL DEFAULT '',
  `s_nombre` varchar(120) DEFAULT NULL,
  `s_observacion` varchar(200) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.categoria: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.categoria_cliente
CREATE TABLE IF NOT EXISTS `categoria_cliente` (
  `i_codigo` int unsigned NOT NULL AUTO_INCREMENT,
  `s_usuario` varchar(45) NOT NULL,
  `i_categoria` int unsigned NOT NULL,
  `de_dscto` decimal(9,2) NOT NULL,
  `s_anotacion` varchar(250) NOT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.categoria_cliente: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.certificacion
CREATE TABLE IF NOT EXISTS `certificacion` (
  `i_codigo` varchar(13) NOT NULL,
  `s_oc` varchar(45) NOT NULL,
  `s_personal` varchar(45) NOT NULL,
  `s_certificado` varchar(45) NOT NULL,
  `s_clientes` varchar(255) NOT NULL,
  `i_monto` decimal(9,2) NOT NULL,
  `s_tipo` varchar(300) NOT NULL,
  `d_fecha` datetime NOT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.certificacion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.certificado_domiciliario
CREATE TABLE IF NOT EXISTS `certificado_domiciliario` (
  `s_codigo` varchar(10) NOT NULL,
  `d_fechareg` date DEFAULT NULL,
  `s_compareciente` varchar(10) DEFAULT NULL,
  `s_usuario` varchar(8) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.certificado_domiciliario: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.ciiu
CREATE TABLE IF NOT EXISTS `ciiu` (
  `CODIGO` varchar(255) NOT NULL,
  `DESCRIPCION` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`CODIGO`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.ciiu: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.ciudad
CREATE TABLE IF NOT EXISTS `ciudad` (
  `s_codigo` int unsigned DEFAULT NULL,
  `s_nombre` char(35) NOT NULL,
  `s_pais` char(3) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4080 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.ciudad: 0 rows
/*!40000 ALTER TABLE `ciudad` DISABLE KEYS */;
/*!40000 ALTER TABLE `ciudad` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.clase
CREATE TABLE IF NOT EXISTS `clase` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(50) DEFAULT NULL,
  `s_descipcion` varchar(150) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.clase: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `s_codigo` char(10) NOT NULL,
  `s_paterno` varchar(50) DEFAULT NULL,
  `s_materno` varchar(50) DEFAULT NULL,
  `s_nombres` varchar(50) DEFAULT NULL,
  `s_tipoDocu` char(5) DEFAULT NULL,
  `s_num_doc` varchar(30) DEFAULT NULL,
  `d_fecha_nac` date DEFAULT NULL,
  `s_estado_civil` varchar(20) DEFAULT NULL,
  `s_nacionalidad` char(5) DEFAULT NULL,
  `s_localidad` varchar(100) DEFAULT NULL,
  `s_direccion` varchar(150) DEFAULT NULL,
  `s_referencia` varchar(200) DEFAULT NULL,
  `s_sexo` char(1) DEFAULT NULL,
  `s_correo` varchar(200) DEFAULT NULL,
  `s_telefono` varchar(40) DEFAULT NULL,
  `s_celular` varchar(40) DEFAULT NULL,
  `s_pass` varchar(30) DEFAULT NULL,
  `s_profesion` varchar(7) DEFAULT NULL,
  `s_otro_profesion` varchar(255) DEFAULT NULL,
  `s_cargo` varchar(5) DEFAULT NULL,
  `s_otro_cargo` varchar(250) DEFAULT NULL,
  `i_residencia` int DEFAULT NULL,
  `d_fecha_reg` datetime DEFAULT NULL,
  `s_personal_reg` varchar(20) DEFAULT NULL,
  `d_fecha_mod` datetime DEFAULT NULL,
  `s_personal_mod` varchar(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `codigo` (`s_codigo`),
  KEY `DOCUMENTO` (`s_num_doc`),
  KEY `s_paterno` (`s_paterno`),
  KEY `idx_cliente_02` (`s_correo`),
  KEY `codigo_cliente` (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.cliente: ~1 rows (aproximadamente)
INSERT INTO `cliente` (`s_codigo`, `s_paterno`, `s_materno`, `s_nombres`, `s_tipoDocu`, `s_num_doc`, `d_fecha_nac`, `s_estado_civil`, `s_nacionalidad`, `s_localidad`, `s_direccion`, `s_referencia`, `s_sexo`, `s_correo`, `s_telefono`, `s_celular`, `s_pass`, `s_profesion`, `s_otro_profesion`, `s_cargo`, `s_otro_cargo`, `i_residencia`, `d_fecha_reg`, `s_personal_reg`, `d_fecha_mod`, `s_personal_mod`, `i_estado`) VALUES
	('CL00000001', 'DASDAS', 'DASDA', 'ASDAS', 'TD001', '45353544', NULL, 'sdfsd', NULL, '150101', 'SDFSF', NULL, NULL, 'correo@sgfd.fghf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
	('CL00000002', 'LOPEZ', 'GOMEZ', 'PEPELUCHO', 'TD001', '48338985', NULL, 'soltero', NULL, '030101', 'AV. LOS MANGOS 235', NULL, NULL, 'pepel@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- Volcando estructura para tabla notariatambini.cliente_credito
CREATE TABLE IF NOT EXISTS `cliente_credito` (
  `s_codigo` varchar(12) NOT NULL,
  `s_cliente` varchar(12) DEFAULT NULL,
  `i_dias` int DEFAULT NULL,
  `s_empresa_corp` varchar(12) DEFAULT NULL,
  `s_dia_fact_primer` varchar(50) DEFAULT NULL,
  `s_dia_fact_segundo` varchar(50) DEFAULT NULL,
  `s_observacion` varchar(500) DEFAULT NULL,
  `d_fecha_reg` datetime DEFAULT NULL,
  `s_personal_reg` varchar(12) DEFAULT NULL,
  `i_dscto` int DEFAULT '0',
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.cliente_credito: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.cliente_descuento
CREATE TABLE IF NOT EXISTS `cliente_descuento` (
  `s_codigo` int unsigned NOT NULL AUTO_INCREMENT,
  `s_cliente` varchar(255) NOT NULL,
  `s_nombre` varchar(255) NOT NULL,
  `s_detalle` varchar(255) NOT NULL,
  `s_tipo` varchar(45) NOT NULL,
  `s_servicio` varchar(45) NOT NULL,
  `i_dscto` double(9,2) NOT NULL,
  `d_fecha` datetime NOT NULL,
  `s_personal` varchar(45) NOT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.cliente_descuento: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.cliente_web
CREATE TABLE IF NOT EXISTS `cliente_web` (
  `s_codigo` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `s_paterno` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `s_materno` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `s_nombres` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `s_tipoDocu` char(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `s_num_doc` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `d_fecha_nac` date DEFAULT NULL,
  `s_estado_civil` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `s_nacionalidad` char(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `s_localidad` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `s_direccion` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `s_sexo` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `s_correo` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `s_telefono` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `s_celular` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `d_fecha_reg` date DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  `s_profecion` char(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.cliente_web: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.cobro
CREATE TABLE IF NOT EXISTS `cobro` (
  `s_codigo` char(12) NOT NULL,
  `s_factura` char(12) DEFAULT NULL,
  `s_orden` char(12) DEFAULT NULL,
  `i_tipo` int DEFAULT NULL,
  `s_moneda` char(5) DEFAULT NULL,
  `s_modoPago` char(5) DEFAULT NULL,
  `de_pago` decimal(10,2) DEFAULT NULL,
  `de_cobre` decimal(10,2) DEFAULT NULL,
  `de_cantidad` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.cobro: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.comparecientes
CREATE TABLE IF NOT EXISTS `comparecientes` (
  `s_codigo` varchar(12) NOT NULL,
  `s_pregistro` varchar(12) DEFAULT NULL,
  `s_tipo` varchar(12) DEFAULT NULL,
  `s_interviniente` varchar(10) DEFAULT NULL,
  `i_firma` int DEFAULT '0',
  `s_representa` varchar(255) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `fk_pregistro` (`s_pregistro`),
  CONSTRAINT `fk_pregistro` FOREIGN KEY (`s_pregistro`) REFERENCES `fuera_registro` (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.comparecientes: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.comparecientes_bloqueados
CREATE TABLE IF NOT EXISTS `comparecientes_bloqueados` (
  `s_codigo` char(10) NOT NULL,
  `s_referencia` varchar(70) DEFAULT NULL,
  `s_numero` varchar(70) DEFAULT NULL,
  `d_fecha_reg` datetime DEFAULT NULL,
  `s_condicion` int DEFAULT NULL,
  `s_observacion` blob,
  `s_ruta` varchar(250) DEFAULT NULL,
  `s_personal` char(8) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.comparecientes_bloqueados: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.composicion
CREATE TABLE IF NOT EXISTS `composicion` (
  `s_codigo` char(5) NOT NULL,
  `s_numero` int DEFAULT NULL,
  `s_nombre` varchar(255) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.composicion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.comprobante
CREATE TABLE IF NOT EXISTS `comprobante` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `numero` varchar(45) DEFAULT NULL,
  `monto` varchar(45) DEFAULT NULL,
  `igv` float DEFAULT NULL,
  `estado` varchar(70) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `orden_id` int DEFAULT NULL,
  `clientes_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comprobante_orden` (`orden_id`),
  KEY `fk_comprobante_clientes` (`clientes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.comprobante: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.concepto_movimiento
CREATE TABLE IF NOT EXISTS `concepto_movimiento` (
  `s_codigo` varchar(5) NOT NULL,
  `s_codmov` varchar(5) DEFAULT NULL,
  `s_nombre` varchar(90) DEFAULT NULL,
  `s_descripcion` varchar(120) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.concepto_movimiento: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.condicion
CREATE TABLE IF NOT EXISTS `condicion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) DEFAULT NULL,
  `id_cnl` varchar(255) DEFAULT NULL,
  `estado` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.condicion: ~5 rows (aproximadamente)
INSERT INTO `condicion` (`id`, `nombre`, `id_cnl`, `estado`) VALUES
	(8, 'PADREEE', 'cnl', 1),
	(9, 'C34', 'c34', 1),
	(10, '055', '05', 1),
	(11, 'DFFD', 'dffd', 1),
	(12, 'sdsd', 'sdsd', 1);

-- Volcando estructura para tabla notariatambini.condiciones
CREATE TABLE IF NOT EXISTS `condiciones` (
  `i_codigo` int DEFAULT NULL,
  `s_sisgen` varchar(45) DEFAULT NULL,
  `s_nombre` varchar(45) DEFAULT NULL,
  `i_estado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.condiciones: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.contacto
CREATE TABLE IF NOT EXISTS `contacto` (
  `s_codigo` varchar(12) NOT NULL,
  `s_codigo_usu` varchar(12) NOT NULL,
  `s_nombres` varchar(45) NOT NULL,
  `s_paterno` varchar(45) NOT NULL,
  `s_materno` varchar(45) DEFAULT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.contacto: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.convenios
CREATE TABLE IF NOT EXISTS `convenios` (
  `s_codigo` varchar(12) NOT NULL,
  `s_codigo_empresa` varchar(12) DEFAULT NULL,
  `s_codigo_servicio` varchar(10) DEFAULT NULL,
  `de_precio_base` decimal(9,2) DEFAULT NULL,
  `s_descripcion` varchar(250) DEFAULT NULL,
  `i_tipo_arancel` int DEFAULT NULL,
  `d_fecha_reg` date DEFAULT NULL,
  `s_hora_reg` varchar(16) DEFAULT NULL,
  `s_personal_reg` varchar(20) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.convenios: 0 rows
/*!40000 ALTER TABLE `convenios` DISABLE KEYS */;
/*!40000 ALTER TABLE `convenios` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.copias_certificada
CREATE TABLE IF NOT EXISTS `copias_certificada` (
  `s_codigo` char(12) NOT NULL,
  `i_copias` int DEFAULT NULL,
  `i_inicial` int DEFAULT NULL,
  `s_descripcion` varchar(255) DEFAULT NULL,
  `s_pertenece` char(10) DEFAULT NULL,
  `s_libros` varchar(255) DEFAULT NULL,
  `s_consta` varchar(20) DEFAULT NULL,
  `s_folios` varchar(50) DEFAULT NULL,
  `s_cargo` varchar(120) DEFAULT NULL,
  `s_legalizado` char(10) DEFAULT NULL,
  `d_fechaLegalizado` date DEFAULT NULL,
  `s_numeroReg` varchar(50) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(15) DEFAULT NULL,
  `s_observacion` varchar(255) DEFAULT NULL,
  `s_atendido` char(8) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.copias_certificada: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.correo
CREATE TABLE IF NOT EXISTS `correo` (
  `correo` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.correo: 0 rows
/*!40000 ALTER TABLE `correo` DISABLE KEYS */;
/*!40000 ALTER TABLE `correo` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.cta_corriente
CREATE TABLE IF NOT EXISTS `cta_corriente` (
  `s_kardex` char(12) DEFAULT NULL,
  `s_derecho` char(5) DEFAULT NULL,
  `d_fechventa` date DEFAULT NULL,
  `i_cantidad` int DEFAULT NULL,
  `d_precio` decimal(8,2) DEFAULT NULL,
  `i_estado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.cta_corriente: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.cuadro_cofide
CREATE TABLE IF NOT EXISTS `cuadro_cofide` (
  `s_kardex` char(12) NOT NULL,
  `d_fecha_notaria` date DEFAULT NULL,
  `d_hora_notaria` varchar(15) DEFAULT NULL,
  `s_hora_presentacion` varchar(15) DEFAULT NULL,
  `d_fecha_sol` date DEFAULT NULL,
  `s_hora_sol` varchar(15) DEFAULT NULL,
  `d_fecha_cepefodes` date DEFAULT NULL,
  `s_hora_cepefodes` varchar(15) DEFAULT NULL,
  `s_liquidacion` varchar(20) DEFAULT NULL,
  `s_factura` varchar(30) DEFAULT NULL,
  `s_estado_kardex` varchar(30) DEFAULT NULL,
  `s_tipo_tramite` varchar(30) DEFAULT NULL,
  `s_numero_vehicular` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`s_kardex`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.cuadro_cofide: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.cuadro_mitsui_cc
CREATE TABLE IF NOT EXISTS `cuadro_mitsui_cc` (
  `s_codigo` char(12) NOT NULL,
  `s_kardex` char(12) DEFAULT NULL,
  `d_obs_maf` date DEFAULT NULL,
  `d_liq_maf` date DEFAULT NULL,
  `d_tacha_maf` date DEFAULT NULL,
  `d_inscrito_maf` date DEFAULT NULL,
  `d_exp_maf` date DEFAULT NULL,
  `s_factura` varchar(30) DEFAULT NULL,
  `s_plazo_rrpp` varchar(50) DEFAULT NULL,
  `s_observacion` varchar(250) DEFAULT NULL,
  `i_estado` int unsigned DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.cuadro_mitsui_cc: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.datoscliente
CREATE TABLE IF NOT EXISTS `datoscliente` (
  `purchaseNumber` varchar(50) DEFAULT NULL,
  `s_cliente` varchar(50) DEFAULT NULL,
  `transactionDate` varchar(50) DEFAULT NULL,
  `amount` varchar(50) DEFAULT NULL,
  `currency` varchar(50) DEFAULT NULL,
  `ACTION_DESCRIPTION` varchar(50) DEFAULT NULL,
  `card` varchar(50) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `estado_pago` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.datoscliente: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.datoskardex
CREATE TABLE IF NOT EXISTS `datoskardex` (
  `purchaseNumber` varchar(50) DEFAULT NULL,
  `s_cliente` varchar(50) DEFAULT NULL,
  `transactionDate` varchar(50) DEFAULT NULL,
  `amount` varchar(50) DEFAULT NULL,
  `currency` varchar(50) DEFAULT NULL,
  `ACTION_DESCRIPTION` varchar(50) DEFAULT NULL,
  `card` varchar(50) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `estado_pago` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.datoskardex: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.datos_web
CREATE TABLE IF NOT EXISTS `datos_web` (
  `s_codigo` char(12) NOT NULL,
  `s_tipo` char(2) DEFAULT NULL,
  `s_kardex` char(12) DEFAULT NULL,
  `s_compareciente` char(10) DEFAULT NULL,
  `s_actnot` char(6) DEFAULT NULL,
  `d_fechaing` datetime DEFAULT NULL,
  `d_fechavigencia` datetime DEFAULT NULL,
  `d_fechaoperaccion` datetime DEFAULT NULL,
  `d_fechaentrega` datetime DEFAULT NULL,
  `s_Horaing` varchar(12) DEFAULT NULL,
  `i_num_reserva` text,
  `s_razon_social` varchar(80) DEFAULT NULL,
  `s_denominacion_abr` varchar(50) DEFAULT NULL,
  `s_localidad` varchar(6) DEFAULT NULL,
  `s_obj_social` varchar(700) DEFAULT NULL,
  `s_aporte` varchar(50) DEFAULT NULL,
  `d_montomoneda` decimal(10,2) DEFAULT NULL,
  `s_moneda` char(5) DEFAULT NULL,
  `d_valor` decimal(10,2) DEFAULT NULL,
  `i_formapago` char(5) DEFAULT NULL,
  `d_pago` decimal(10,2) DEFAULT NULL,
  `i_porcentaje` int DEFAULT NULL,
  `s_banco` char(5) DEFAULT NULL,
  `s_modopago` char(5) DEFAULT NULL,
  `s_nro_cheque` text,
  `s_nro_cuenta` text,
  `s_nro_operacion` text,
  `s_clausula` text,
  `s_informacion` text,
  `s_observacion` text,
  `s_dir_doc` text,
  `s_dir_min` text,
  `i_estado` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.datos_web: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.datos_web_intervinientes
CREATE TABLE IF NOT EXISTS `datos_web_intervinientes` (
  `s_codigo` char(12) NOT NULL,
  `s_codigo_datos_web` char(12) DEFAULT NULL,
  `s_compareciente` char(10) DEFAULT NULL,
  `s_tipo_comparecientes` char(6) DEFAULT NULL,
  `s_proceder` varchar(50) DEFAULT NULL,
  `d_fechaing` datetime DEFAULT NULL,
  `s_Horaing` varchar(12) DEFAULT NULL,
  `s_dir_doc` text,
  `i_estado` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.datos_web_intervinientes: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.departamento
CREATE TABLE IF NOT EXISTS `departamento` (
  `s_codigo` char(6) NOT NULL,
  `s_nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.departamento: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.departamento1
CREATE TABLE IF NOT EXISTS `departamento1` (
  `s_codigo` varchar(2) NOT NULL,
  `s_departamento` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.departamento1: ~25 rows (aproximadamente)
INSERT INTO `departamento1` (`s_codigo`, `s_departamento`) VALUES
	('01', 'AMAZONAS                 '),
	('02', 'ANCASH                   '),
	('03', 'APURIMAC                 '),
	('04', 'AREQUIPA                 '),
	('05', 'AYACUCHO                 '),
	('06', 'CAJAMARCA                '),
	('07', 'PROV. CONST. DEL CALLAO  '),
	('08', 'CUSCO                    '),
	('09', 'HUANCAVELICA             '),
	('10', 'HUANUCO                  '),
	('11', 'ICA                      '),
	('12', 'JUNIN                    '),
	('13', 'LA LIBERTAD              '),
	('14', 'LAMBAYEQUE               '),
	('15', 'LIMA'),
	('16', 'LORETO                   '),
	('17', 'MADRE DE DIOS            '),
	('18', 'MOQUEGUA                 '),
	('19', 'PASCO                    '),
	('20', 'PIURA                    '),
	('21', 'PUNO                     '),
	('22', 'SAN MARTIN               '),
	('23', 'TACNA                    '),
	('24', 'TUMBES                   '),
	('25', 'UCAYALI                  '),
	('34', 'DEEE'),
	('89', 'abc'),
	('99', 'LIMA'),
	('cd', 'asdad'),
	('sd', 'dessdsdf');

-- Volcando estructura para tabla notariatambini.depositos
CREATE TABLE IF NOT EXISTS `depositos` (
  `s_codigo` varchar(12) NOT NULL,
  `s_kardex` varchar(45) NOT NULL,
  `s_asesor` varchar(45) NOT NULL,
  `s_tipo` varchar(255) DEFAULT NULL,
  `s_banco` varchar(150) DEFAULT NULL,
  `d_fecha_ope` datetime DEFAULT NULL,
  `s_num_ope` varchar(255) DEFAULT NULL,
  `i_monto` decimal(9,2) DEFAULT NULL,
  `d_fecha_reg` datetime DEFAULT NULL,
  `d_fecha_aprob` datetime DEFAULT NULL,
  `s_aprobado` varchar(45) DEFAULT NULL,
  `i_estado` int unsigned NOT NULL,
  `i_excedente` decimal(65,2) DEFAULT '0.00',
  `s_comentario` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.depositos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.depositos_detalle
CREATE TABLE IF NOT EXISTS `depositos_detalle` (
  `s_codigo` int unsigned NOT NULL AUTO_INCREMENT,
  `s_deposito` varchar(30) NOT NULL,
  `s_ruta` varchar(700) NOT NULL,
  `s_img` longtext NOT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=8737 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.depositos_detalle: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.descuento
CREATE TABLE IF NOT EXISTS `descuento` (
  `s_kardex` char(12) DEFAULT NULL,
  `s_autorizo` char(8) DEFAULT NULL,
  `de_descuento` decimal(12,2) DEFAULT NULL,
  `i_estado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.descuento: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.detalla_entrada
CREATE TABLE IF NOT EXISTS `detalla_entrada` (
  `s_codigo` char(12) DEFAULT NULL,
  `s_tipo` char(5) DEFAULT NULL,
  `s_producto` char(12) DEFAULT NULL,
  `s_mondeda` char(5) DEFAULT NULL,
  `de_precio` decimal(10,2) DEFAULT NULL,
  `i_cantidad` int DEFAULT NULL,
  `s_observacion` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.detalla_entrada: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.detallecambio
CREATE TABLE IF NOT EXISTS `detallecambio` (
  `s_codigo` varchar(12) NOT NULL,
  `s_codCambio` varchar(12) DEFAULT NULL,
  `s_caracteristica` int DEFAULT NULL,
  `s_descripcion` varchar(255) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.detallecambio: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.detallecobranza
CREATE TABLE IF NOT EXISTS `detallecobranza` (
  `s_codigo` char(12) NOT NULL,
  `s_reciboCobranza` char(12) DEFAULT NULL,
  `s_recibo` char(12) DEFAULT NULL,
  `de_pago` decimal(12,2) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `s_codigo` (`s_codigo`),
  KEY `s_codigo_2` (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.detallecobranza: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.detallerecibo
CREATE TABLE IF NOT EXISTS `detallerecibo` (
  `s_codigo` char(12) NOT NULL,
  `s_recibo` char(12) DEFAULT NULL,
  `s_referencia` char(12) DEFAULT NULL,
  `s_servicio` char(5) DEFAULT NULL,
  `s_detalle` varchar(250) DEFAULT NULL,
  `de_precio` decimal(10,2) DEFAULT NULL,
  `i_cantidad` int DEFAULT NULL,
  `de_subTotal` decimal(12,2) DEFAULT NULL,
  `de_igv` decimal(12,2) DEFAULT NULL,
  `de_total` decimal(12,2) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `ind_s_referencia` (`s_referencia`),
  KEY `s_codigo` (`s_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.detallerecibo: 0 rows
/*!40000 ALTER TABLE `detallerecibo` DISABLE KEYS */;
/*!40000 ALTER TABLE `detallerecibo` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.detallesrapido
CREATE TABLE IF NOT EXISTS `detallesrapido` (
  `s_codigo` char(12) NOT NULL,
  `s_ServicioR` char(12) DEFAULT NULL,
  `s_servicio` char(5) DEFAULT NULL,
  `i_cantidad` int DEFAULT NULL,
  `de_precio` decimal(10,2) DEFAULT NULL,
  `de_total` decimal(10,2) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  `s_observacion` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `idx_detallesrapido_01` (`s_ServicioR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.detallesrapido: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.detalle_bien_uif
CREATE TABLE IF NOT EXISTS `detalle_bien_uif` (
  `s_codigo` varchar(12) NOT NULL,
  `s_kardex` varchar(12) DEFAULT NULL,
  `i_tipo_constru` int DEFAULT NULL,
  `s_fech_plazoini` varchar(12) DEFAULT NULL,
  `s_fech_plazofin` varchar(12) DEFAULT NULL,
  `s_bien_accion` int DEFAULT NULL,
  `s_acto_juridico` varchar(10) DEFAULT NULL,
  `i_primera_venta` int DEFAULT NULL,
  `s_ubigeo` varchar(6) DEFAULT NULL,
  `s_fech_adq` varchar(10) DEFAULT NULL,
  `i_permuta` int DEFAULT NULL,
  `s_denom_urb` varchar(12) DEFAULT NULL,
  `s_descrip_urb` varchar(250) DEFAULT NULL,
  `s_tipovia` varchar(12) DEFAULT NULL,
  `s_ubicacion` varchar(200) DEFAULT NULL,
  `s_partida_reg` varchar(12) DEFAULT NULL,
  `s_num_reg` varchar(12) DEFAULT NULL,
  `s_sede` varchar(12) DEFAULT NULL,
  `s_personal` varchar(12) DEFAULT NULL,
  `d_fecha_reg` datetime DEFAULT NULL,
  `s_operacion` varchar(255) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.detalle_bien_uif: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.detalle_bloqueados
CREATE TABLE IF NOT EXISTS `detalle_bloqueados` (
  `s_codigo` varchar(12) NOT NULL,
  `s_codreg_bloq` varchar(12) NOT NULL,
  `s_compareciente` varchar(12) DEFAULT NULL,
  `s_nombres` varchar(125) DEFAULT NULL,
  `s_paterno` varchar(50) DEFAULT NULL,
  `s_materno` varchar(50) DEFAULT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.detalle_bloqueados: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.detalle_convenio
CREATE TABLE IF NOT EXISTS `detalle_convenio` (
  `s_codigo` varchar(12) NOT NULL,
  `s_cod_rango` varchar(12) DEFAULT NULL,
  `s_concepto1` varchar(50) DEFAULT NULL,
  `s_concepto2` varchar(50) DEFAULT NULL,
  `de_precio` decimal(10,0) DEFAULT NULL,
  `d_fecha_reg` date DEFAULT NULL,
  `s_hora_reg` varchar(16) DEFAULT NULL,
  `s_personal_reg` varchar(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.detalle_convenio: 0 rows
/*!40000 ALTER TABLE `detalle_convenio` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_convenio` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.detalle_intervencion
CREATE TABLE IF NOT EXISTS `detalle_intervencion` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `s_interviniente` char(12) NOT NULL,
  `s_operacion` varchar(12) DEFAULT NULL,
  `s_kardex` char(12) DEFAULT NULL,
  `s_tipo` char(5) DEFAULT NULL,
  `s_rol_participacion` varchar(5) DEFAULT NULL,
  `s_tip_comp` varchar(10) DEFAULT NULL,
  `s_clase` varchar(10) DEFAULT NULL,
  `s_afectacion` varchar(10) DEFAULT NULL,
  `s_porcentaje` varchar(5) DEFAULT NULL,
  `s_moneda` varchar(5) DEFAULT NULL,
  `de_monto` decimal(12,2) DEFAULT NULL,
  `s_renta_terc` varchar(255) DEFAULT NULL,
  `s_casa_enaj` varchar(255) DEFAULT NULL,
  `s_imp_cero` varchar(255) DEFAULT NULL,
  `s_ope_1662` varchar(255) DEFAULT NULL,
  `s_pago_2cat` varchar(255) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`),
  KEY `Numero` (`s_kardex`),
  KEY `codigo` (`i_codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=421958 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.detalle_intervencion: 0 rows
/*!40000 ALTER TABLE `detalle_intervencion` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_intervencion` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.detalle_libro_w
CREATE TABLE IF NOT EXISTS `detalle_libro_w` (
  `s_codigo` varchar(12) NOT NULL,
  `s_codlibro` varchar(12) DEFAULT NULL,
  `s_libro` varchar(12) DEFAULT NULL,
  `s_formas` varchar(50) DEFAULT NULL,
  `s_folios` varchar(5) DEFAULT NULL,
  `s_numero` varchar(3) DEFAULT NULL,
  `i_cantidad` int DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.detalle_libro_w: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.detalle_modelo
CREATE TABLE IF NOT EXISTS `detalle_modelo` (
  `s_codigo` char(8) NOT NULL,
  `s_modelo` char(8) DEFAULT NULL,
  `s_acto` char(6) DEFAULT NULL,
  `s_insertos` varchar(100) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.detalle_modelo: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.detalle_ofi
CREATE TABLE IF NOT EXISTS `detalle_ofi` (
  `i_codigo` int unsigned NOT NULL AUTO_INCREMENT,
  `s_referencia` varchar(255) NOT NULL,
  `s_nombre` varchar(255) NOT NULL,
  `d_fech_ini` date DEFAULT NULL,
  `d_fech_fin` date DEFAULT NULL,
  `i_estado` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.detalle_ofi: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.detalle_ordencompra
CREATE TABLE IF NOT EXISTS `detalle_ordencompra` (
  `s_codigo` char(12) NOT NULL,
  `s_orden` char(12) DEFAULT NULL,
  `s_prodserv` char(12) DEFAULT NULL,
  `s_descripcion` varchar(100) DEFAULT NULL,
  `i_cant` int DEFAULT NULL,
  `de_prec` decimal(9,2) DEFAULT NULL,
  `de_total` decimal(9,2) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.detalle_ordencompra: 0 rows
/*!40000 ALTER TABLE `detalle_ordencompra` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_ordencompra` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.detalle_presencias
CREATE TABLE IF NOT EXISTS `detalle_presencias` (
  `s_codigo` char(12) NOT NULL,
  `s_referencia` char(12) DEFAULT NULL,
  `s_actonotarial` char(6) DEFAULT NULL,
  `s_descripcion` varchar(150) DEFAULT NULL,
  `s_hora_inicio` char(13) DEFAULT NULL,
  `s_hora_fin` char(13) DEFAULT NULL,
  `d_fechapresen` date DEFAULT NULL,
  `s_lugar` varchar(150) DEFAULT NULL,
  `s_asitente` char(10) DEFAULT NULL,
  `s_observacion` varchar(250) DEFAULT NULL,
  `i_cantidad` int DEFAULT NULL,
  `de_precio` decimal(9,2) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `idx_detalle_presencias_01` (`s_referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.detalle_presencias: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.detalle_protesto
CREATE TABLE IF NOT EXISTS `detalle_protesto` (
  `s_codigo` varchar(12) NOT NULL,
  `d_fechnotifica` varchar(10) DEFAULT NULL,
  `s_numero_not` varchar(25) DEFAULT NULL,
  `s_numero_doc` varchar(25) DEFAULT NULL,
  `i_titulovalor` int DEFAULT NULL,
  `s_lugar_emision` varchar(255) DEFAULT NULL,
  `de_tasa` decimal(9,2) DEFAULT NULL,
  `s_periodo` varchar(255) DEFAULT NULL,
  `d_fecha_emi` date DEFAULT NULL,
  `d_fecha_ven` date DEFAULT NULL,
  `de_monto` decimal(10,2) DEFAULT NULL,
  `s_moneda` varchar(5) DEFAULT NULL,
  `s_kardex` char(12) NOT NULL,
  `s_notificacion` varchar(500) DEFAULT NULL,
  `s_personal_notifica` varchar(12) DEFAULT NULL,
  `s_personal_reg` varchar(12) DEFAULT NULL,
  `d_fecha_reg` datetime DEFAULT NULL,
  `s_personal_mod` varchar(12) DEFAULT NULL,
  `d_fecha_mod` datetime DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `codigo` (`s_kardex`),
  KEY `idx_kardex_01` (`d_fecha_reg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.detalle_protesto: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.detalle_rango
CREATE TABLE IF NOT EXISTS `detalle_rango` (
  `s_codigo` char(6) NOT NULL,
  `s_servicios` char(5) DEFAULT NULL,
  `s_colum1` varchar(50) DEFAULT NULL,
  `s_colum2` varchar(50) DEFAULT NULL,
  `de_precio` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.detalle_rango: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.detalle_representante
CREATE TABLE IF NOT EXISTS `detalle_representante` (
  `s_representado` char(10) DEFAULT NULL,
  `s_representacion` char(10) DEFAULT NULL,
  `i_estado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.detalle_representante: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.detalle_servicios
CREATE TABLE IF NOT EXISTS `detalle_servicios` (
  `s_codigo` char(12) DEFAULT NULL,
  `s_tipo` char(5) DEFAULT NULL,
  `s_servicio` char(12) DEFAULT NULL,
  `s_mondeda` char(5) DEFAULT NULL,
  `de_precio` decimal(10,2) DEFAULT NULL,
  `i_cantidad` int DEFAULT NULL,
  `s_observacion` varchar(250) DEFAULT NULL,
  `i_estado` int unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.detalle_servicios: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.detalle_tomafirma
CREATE TABLE IF NOT EXISTS `detalle_tomafirma` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `s_tomafirma` varchar(12) DEFAULT NULL,
  `s_orden` int DEFAULT NULL,
  `s_tramite` varchar(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=1089 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.detalle_tomafirma: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.detraccion
CREATE TABLE IF NOT EXISTS `detraccion` (
  `s_factura` char(12) NOT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_observacion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`s_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.detraccion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.devoluciones
CREATE TABLE IF NOT EXISTS `devoluciones` (
  `s_codigo` varchar(10) NOT NULL,
  `s_kardex` varchar(12) DEFAULT NULL,
  `i_tipo` varchar(11) DEFAULT NULL,
  `de_devolucion` decimal(9,2) DEFAULT NULL,
  `s_usuario` varchar(10) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_personal` varchar(10) DEFAULT NULL,
  `s_descripcion` varchar(250) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.devoluciones: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.devolucionrp
CREATE TABLE IF NOT EXISTS `devolucionrp` (
  `s_codigo` varchar(12) NOT NULL,
  `s_titulo` varchar(45) NOT NULL,
  `s_kardex` varchar(45) NOT NULL,
  `d_fecha` date NOT NULL,
  `i_estado_d` int unsigned NOT NULL,
  `de_monto` decimal(9,2) NOT NULL,
  `s_observacion` varchar(100) DEFAULT NULL,
  `d_fecha_reg` datetime NOT NULL,
  `s_personal` varchar(45) NOT NULL,
  `d_fecha_pres` date NOT NULL,
  `s_registral` varchar(45) NOT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.devolucionrp: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.devolucionrp_detalle
CREATE TABLE IF NOT EXISTS `devolucionrp_detalle` (
  `s_codigo` varchar(12) NOT NULL,
  `s_codigo_prin` varchar(12) NOT NULL,
  `s_personal` varchar(45) NOT NULL,
  `d_fecha` date NOT NULL,
  `de_monto` double NOT NULL,
  `s_cliente` varchar(12) NOT NULL,
  `s_observacion` varchar(255) NOT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.devolucionrp_detalle: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.direcciones
CREATE TABLE IF NOT EXISTS `direcciones` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(30) DEFAULT NULL,
  `s_abreviatura` char(5) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.direcciones: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.distrito1
CREATE TABLE IF NOT EXISTS `distrito1` (
  `s_codigo` varchar(10) NOT NULL,
  `s_distrito` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.distrito1: ~1,833 rows (aproximadamente)
INSERT INTO `distrito1` (`s_codigo`, `s_distrito`) VALUES
	('010101', 'CHACHAPOYAS                   '),
	('010102', 'ASUNCION                      '),
	('010103', 'BALSAS                        '),
	('010104', 'CHETO                         '),
	('010105', 'CHILIQUIN                     '),
	('010106', 'CHUQUIBAMBA                   '),
	('010107', 'GRANADA                       '),
	('010108', 'HUANCAS                       '),
	('010109', 'LA JALCA                      '),
	('010110', 'LEIMEBAMBA                    '),
	('010111', 'LEVANTO                       '),
	('010112', 'MAGDALENA                     '),
	('010113', 'MARISCAL CASTILLA             '),
	('010114', 'MOLINOPAMPA                   '),
	('010115', 'MONTEVIDEO                    '),
	('010116', 'OLLEROS                       '),
	('010117', 'QUINJALCA                     '),
	('010118', 'SAN FRANCISCO DE DAGUAS       '),
	('010119', 'SAN ISIDRO DE MAINO           '),
	('010120', 'SOLOCO                        '),
	('010121', 'SONCHE                        '),
	('010201', 'LA PECA                       '),
	('010202', 'ARAMANGO                      '),
	('010203', 'COPALLIN                      '),
	('010204', 'EL PARCO                      '),
	('010205', 'IMAZA                         '),
	('010206', 'BAGUA'),
	('010301', 'JUMBILLA                      '),
	('010302', 'CHISQUILLA                    '),
	('010303', 'CHURUJA                       '),
	('010304', 'COROSHA                       '),
	('010305', 'CUISPES                       '),
	('010306', 'FLORIDA                       '),
	('010307', 'JAZAN                         '),
	('010308', 'RECTA                         '),
	('010309', 'SAN CARLOS                    '),
	('010310', 'SHIPASBAMBA                   '),
	('010311', 'VALERA                        '),
	('010312', 'YAMBRASBAMBA                  '),
	('010401', 'NIEVA                         '),
	('010402', 'EL CENEPA                     '),
	('010403', 'RIO SANTIAGO                  '),
	('010501', 'LAMUD                         '),
	('010502', 'CAMPORREDONDO                 '),
	('010503', 'COCABAMBA                     '),
	('010504', 'COLCAMAR                      '),
	('010505', 'CONILA                        '),
	('010506', 'INGUILPATA                    '),
	('010507', 'LONGUITA                      '),
	('010508', 'LONYA CHICO                   '),
	('010509', 'LUYA                          '),
	('010510', 'LUYA VIEJO                    '),
	('010511', 'MARIA                         '),
	('010512', 'OCALLI                        '),
	('010513', 'OCUMAL                        '),
	('010514', 'PISUQUIA                      '),
	('010515', 'PROVIDENCIA                   '),
	('010516', 'SAN CRISTOBAL                 '),
	('010517', 'SAN FRANCISCO DEL YESO        '),
	('010518', 'SAN JERONIMO                  '),
	('010519', 'SAN JUAN DE LOPECANCHA        '),
	('010520', 'SANTA CATALINA                '),
	('010521', 'SANTO TOMAS                   '),
	('010522', 'TINGO                         '),
	('010523', 'TRITA                         '),
	('010601', 'SAN NICOLAS                   '),
	('010602', 'CHIRIMOTO                     '),
	('010603', 'COCHAMAL                      '),
	('010604', 'HUAMBO                        '),
	('010605', 'LIMABAMBA                     '),
	('010606', 'LONGAR                        '),
	('010607', 'MARISCAL BENAVIDES            '),
	('010608', 'MILPUC                        '),
	('010609', 'OMIA                          '),
	('010610', 'SANTA ROSA                    '),
	('010611', 'TOTORA                        '),
	('010612', 'VISTA ALEGRE                  '),
	('010677', 'ANU'),
	('010701', 'BAGUA GRANDE                  '),
	('010702', 'CAJARURO                      '),
	('010703', 'CUMBA                         '),
	('010704', 'EL MILAGRO                    '),
	('010705', 'JAMALCA                       '),
	('010706', 'LONYA GRANDE                  '),
	('010707', 'YAMON                         '),
	('010765', 'fsdfsdf'),
	('020101', 'HUARAZ                        '),
	('020102', 'COCHABAMBA                    '),
	('020103', 'COLCABAMBA                    '),
	('020104', 'HUANCHAY                      '),
	('020105', 'INDEPENDENCIA                 '),
	('020106', 'JANGAS                        '),
	('020107', 'LA LIBERTAD                   '),
	('020108', 'OLLEROS                       '),
	('020109', 'PAMPAS                        '),
	('020110', 'PARIACOTO                     '),
	('020111', 'PIRA                          '),
	('020112', 'TARICA                        '),
	('020201', 'AIJA                          '),
	('020202', 'CORIS                         '),
	('020203', 'HUACLLAN                      '),
	('020204', 'LA MERCED                     '),
	('020205', 'SUCCHA                        '),
	('020301', 'LLAMELLIN                     '),
	('020302', 'ACZO                          '),
	('020303', 'CHACCHO                       '),
	('020304', 'CHINGAS                       '),
	('020305', 'MIRGAS                        '),
	('020306', 'SAN JUAN DE RONTOY            '),
	('020401', 'CHACAS                        '),
	('020402', 'ACOCHACA                      '),
	('020501', 'CHIQUIAN                      '),
	('020502', 'ABELARDO PARDO LEZAMETA       '),
	('020503', 'ANTONIO RAYMONDI              '),
	('020504', 'AQUIA                         '),
	('020505', 'CAJACAY                       '),
	('020506', 'CANIS                         '),
	('020507', 'COLQUIOC                      '),
	('020508', 'HUALLANCA                     '),
	('020509', 'HUASTA                        '),
	('020510', 'HUAYLLACAYAN                  '),
	('020511', 'LA PRIMAVERA                  '),
	('020512', 'MANGAS                        '),
	('020513', 'PACLLON                       '),
	('020514', 'SAN MIGUEL DE CORPANQUI       '),
	('020515', 'TICLLOS                       '),
	('020601', 'CARHUAZ                       '),
	('020602', 'ACOPAMPA                      '),
	('020603', 'AMASHCA                       '),
	('020604', 'ANTA                          '),
	('020605', 'ATAQUERO                      '),
	('020606', 'MARCARA                       '),
	('020607', 'PARIAHUANCA                   '),
	('020608', 'SAN MIGUEL DE ACO             '),
	('020609', 'SHILLA                        '),
	('020610', 'TINCO                         '),
	('020611', 'YUNGAR                        '),
	('0206fg', 'sdfsdf'),
	('020701', 'SAN LUIS                      '),
	('020702', 'SAN NICOLAS                   '),
	('020703', 'YAUYA                         '),
	('020801', 'CASMA                         '),
	('020802', 'BUENA VISTA ALTA              '),
	('020803', 'COMANDANTE NOEL               '),
	('020804', 'YAUTAN                        '),
	('020901', 'CORONGO                       '),
	('020902', 'ACO                           '),
	('020903', 'BAMBAS                        '),
	('020904', 'CUSCA                         '),
	('020905', 'LA PAMPA                      '),
	('020906', 'YANAC                         '),
	('020907', 'YUPAN                         '),
	('021001', 'HUARI                         '),
	('021002', 'ANRA                          '),
	('021003', 'CAJAY                         '),
	('021004', 'CHAVIN DE HUANTAR             '),
	('021005', 'HUACACHI                      '),
	('021006', 'HUACCHIS                      '),
	('021007', 'HUACHIS                       '),
	('021008', 'HUANTAR                       '),
	('021009', 'MASIN                         '),
	('021010', 'PAUCAS                        '),
	('021011', 'PONTO                         '),
	('021012', 'RAHUAPAMPA                    '),
	('021013', 'RAPAYAN                       '),
	('021014', 'SAN MARCOS                    '),
	('021015', 'SAN PEDRO DE CHANA            '),
	('021016', 'UCO                           '),
	('021101', 'HUARMEY                       '),
	('021102', 'COCHAPETI                     '),
	('021103', 'CULEBRAS                      '),
	('021104', 'HUAYAN                        '),
	('021105', 'MALVAS                        '),
	('021201', 'CARAZ                         '),
	('021202', 'HUALLANCA                     '),
	('021203', 'HUATA                         '),
	('021204', 'HUAYLAS                       '),
	('021205', 'MATO                          '),
	('021206', 'PAMPAROMAS                    '),
	('021207', 'PUEBLO LIBRE                  '),
	('021208', 'SANTA CRUZ                    '),
	('021209', 'SANTO TORIBIO                 '),
	('021210', 'YURACMARCA                    '),
	('021301', 'PISCOBAMBA                    '),
	('021302', 'CASCA                         '),
	('021303', 'ELEAZAR GUZMAN BARRON         '),
	('021304', 'FIDEL OLIVAS ESCUDERO         '),
	('021305', 'LLAMA                         '),
	('021306', 'LLUMPA                        '),
	('021307', 'LUCMA                         '),
	('021308', 'MUSGA                         '),
	('021401', 'OCROS                         '),
	('021402', 'ACAS                          '),
	('021403', 'CAJAMARQUILLA                 '),
	('021404', 'CARHUAPAMPA                   '),
	('021405', 'COCHAS                        '),
	('021406', 'CONGAS                        '),
	('021407', 'LLIPA                         '),
	('021408', 'SAN CRISTOBAL DE RAJAN        '),
	('021409', 'SAN PEDRO                     '),
	('021410', 'SANTIAGO DE CHILCAS           '),
	('021501', 'CABANA                        '),
	('021502', 'BOLOGNESI                     '),
	('021503', 'CONCHUCOS                     '),
	('021504', 'HUACASCHUQUE                  '),
	('021505', 'HUANDOVAL                     '),
	('021506', 'LACABAMBA                     '),
	('021507', 'LLAPO                         '),
	('021508', 'PALLASCA                      '),
	('021509', 'PAMPAS                        '),
	('021510', 'SANTA ROSA                    '),
	('021511', 'TAUCA                         '),
	('021601', 'POMABAMBA                     '),
	('021602', 'HUAYLLAN                      '),
	('021603', 'PAROBAMBA                     '),
	('021604', 'QUINUABAMBA                   '),
	('021701', 'RECUAY                        '),
	('021702', 'CATAC                         '),
	('021703', 'COTAPARACO                    '),
	('021704', 'HUAYLLAPAMPA                  '),
	('021705', 'LLACLLIN                      '),
	('021706', 'MARCA                         '),
	('021707', 'PAMPAS CHICO                  '),
	('021708', 'PARARIN                       '),
	('021709', 'TAPACOCHA                     '),
	('021710', 'TICAPAMPA                     '),
	('021801', 'CHIMBOTE                      '),
	('021802', 'CACERES DEL PERU              '),
	('021803', 'COISHCO                       '),
	('021804', 'MACATE                        '),
	('021805', 'MORO                          '),
	('021806', 'NEPEÑA                        '),
	('021807', 'SAMANCO                       '),
	('021808', 'SANTA                         '),
	('021809', 'NUEVO CHIMBOTE                '),
	('021901', 'SIHUAS                        '),
	('021902', 'ACOBAMBA                      '),
	('021903', 'ALFONSO UGARTE                '),
	('021904', 'CASHAPAMPA                    '),
	('021905', 'CHINGALPO                     '),
	('021906', 'HUAYLLABAMBA                  '),
	('021907', 'QUICHES                       '),
	('021908', 'RAGASH                        '),
	('021909', 'SAN JUAN                      '),
	('021910', 'SICSIBAMBA                    '),
	('022001', 'YUNGAY                        '),
	('022002', 'CASCAPARA                     '),
	('022003', 'MANCOS                        '),
	('022004', 'MATACOTO                      '),
	('022005', 'QUILLO                        '),
	('022006', 'RANRAHIRCA                    '),
	('022007', 'SHUPLUY                       '),
	('022008', 'YANAMA                        '),
	('030101', 'ABANCAY                       '),
	('030102', 'CHACOCHE                      '),
	('030103', 'CIRCA                         '),
	('030104', 'CURAHUASI                     '),
	('030105', 'HUANIPACA                     '),
	('030106', 'LAMBRAMA                      '),
	('030107', 'PICHIRHUA                     '),
	('030108', 'SAN PEDRO DE CACHORA          '),
	('030109', 'TAMBURCO                      '),
	('030201', 'ANDAHUAYLAS                   '),
	('030202', 'ANDARAPA                      '),
	('030203', 'CHIARA                        '),
	('030204', 'HUANCARAMA                    '),
	('030205', 'HUANCARAY                     '),
	('030206', 'HUAYANA                       '),
	('030207', 'KISHUARA                      '),
	('030208', 'PACOBAMBA                     '),
	('030209', 'PACUCHA                       '),
	('030210', 'PAMPACHIRI                    '),
	('030211', 'POMACOCHA                     '),
	('030212', 'SAN ANTONIO DE CACHI          '),
	('030213', 'SAN JERONIMO                  '),
	('030214', 'SAN MIGUEL DE CHACCRAMPA      '),
	('030215', 'SANTA MARIA DE CHICMO         '),
	('030216', 'TALAVERA                      '),
	('030217', 'TUMAY HUARACA                 '),
	('030218', 'TURPO                         '),
	('030219', 'KAQUIABAMBA                   '),
	('030301', 'ANTABAMBA                     '),
	('030302', 'EL ORO                        '),
	('030303', 'HUAQUIRCA                     '),
	('030304', 'JUAN ESPINOZA MEDRANO         '),
	('030305', 'OROPESA                       '),
	('030306', 'PACHACONAS                    '),
	('030307', 'SABAINO                       '),
	('030401', 'CHALHUANCA                    '),
	('030402', 'CAPAYA                        '),
	('030403', 'CARAYBAMBA                    '),
	('030404', 'CHAPIMARCA                    '),
	('030405', 'COLCABAMBA                    '),
	('030406', 'COTARUSE                      '),
	('030407', 'HUAYLLO                       '),
	('030408', 'JUSTO APU SAHUARAURA          '),
	('030409', 'LUCRE                         '),
	('030410', 'POCOHUANCA                    '),
	('030411', 'SAN JUAN DE CHACÑA            '),
	('030412', 'SAÑAYCA                       '),
	('030413', 'SORAYA                        '),
	('030414', 'TAPAIRIHUA                    '),
	('030415', 'TINTAY                        '),
	('030416', 'TORAYA                        '),
	('030417', 'YANACA                        '),
	('030501', 'TAMBOBAMBA                    '),
	('030502', 'COTABAMBAS                    '),
	('030503', 'COYLLURQUI                    '),
	('030504', 'HAQUIRA                       '),
	('030505', 'MARA                          '),
	('030506', 'CHALLHUAHUACHO                '),
	('030601', 'CHINCHEROS                    '),
	('030602', 'ANCO-HUALLO                   '),
	('030603', 'COCHARCAS                     '),
	('030604', 'HUACCANA                      '),
	('030605', 'OCOBAMBA                      '),
	('030606', 'ONGOY                         '),
	('030607', 'URANMARCA                     '),
	('030608', 'RANRACANCHA                   '),
	('030701', 'CHUQUIBAMBILLA                '),
	('030702', 'CURPAHUASI                    '),
	('030703', 'GAMARRA                       '),
	('030704', 'HUAYLLATI                     '),
	('030705', 'MAMARA                        '),
	('030706', 'MICAELA BASTIDAS              '),
	('030707', 'PATAYPAMPA                    '),
	('030708', 'PROGRESO                      '),
	('030709', 'SAN ANTONIO                   '),
	('030710', 'SANTA ROSA                    '),
	('030711', 'TURPAY                        '),
	('030712', 'VILCABAMBA                    '),
	('030713', 'VIRUNDO                       '),
	('030714', 'CURASCO                       '),
	('040101', 'AREQUIPA                      '),
	('040102', 'ALTO SELVA ALEGRE             '),
	('040103', 'CAYMA                         '),
	('040104', 'CERRO COLORADO                '),
	('040105', 'CHARACATO                     '),
	('040106', 'CHIGUATA                      '),
	('040107', 'JACOBO HUNTER                 '),
	('040108', 'LA JOYA                       '),
	('040109', 'MARIANO MELGAR                '),
	('040110', 'MIRAFLORES                    '),
	('040111', 'MOLLEBAYA                     '),
	('040112', 'PAUCARPATA                    '),
	('040113', 'POCSI                         '),
	('040114', 'POLOBAYA                      '),
	('040115', 'QUEQUEÑA                      '),
	('040116', 'SABANDIA                      '),
	('040117', 'SACHACA                       '),
	('040118', 'SAN JUAN DE SIGUAS            '),
	('040119', 'SAN JUAN DE TARUCANI          '),
	('040120', 'SANTA ISABEL DE SIGUAS        '),
	('040121', 'SANTA RITA DE SIGUAS          '),
	('040122', 'SOCABAYA                      '),
	('040123', 'TIABAYA                       '),
	('040124', 'UCHUMAYO                      '),
	('040125', 'VITOR                         '),
	('040126', 'YANAHUARA                     '),
	('040127', 'YARABAMBA                     '),
	('040128', 'YURA                          '),
	('040129', 'JOSE LUIS BUSTAMANTE Y RIVERO '),
	('040201', 'CAMANA                        '),
	('040202', 'JOSE MARIA QUIMPER            '),
	('040203', 'MARIANO NICOLAS VALCARCEL     '),
	('040204', 'MARISCAL CACERES              '),
	('040205', 'NICOLAS DE PIEROLA            '),
	('040206', 'OCOÑA                         '),
	('040207', 'QUILCA                        '),
	('040208', 'SAMUEL PASTOR                 '),
	('040301', 'CARAVELI                      '),
	('040302', 'ACARI                         '),
	('040303', 'ATICO                         '),
	('040304', 'ATIQUIPA                      '),
	('040305', 'BELLA UNION                   '),
	('040306', 'CAHUACHO                      '),
	('040307', 'CHALA                         '),
	('040308', 'CHAPARRA                      '),
	('040309', 'HUANUHUANU                    '),
	('040310', 'JAQUI                         '),
	('040311', 'LOMAS                         '),
	('040312', 'QUICACHA                      '),
	('040313', 'YAUCA                         '),
	('040401', 'APLAO                         '),
	('040402', 'ANDAGUA                       '),
	('040403', 'AYO                           '),
	('040404', 'CHACHAS                       '),
	('040405', 'CHILCAYMARCA                  '),
	('040406', 'CHOCO                         '),
	('040407', 'HUANCARQUI                    '),
	('040408', 'MACHAGUAY                     '),
	('040409', 'ORCOPAMPA                     '),
	('040410', 'PAMPACOLCA                    '),
	('040411', 'TIPAN                         '),
	('040412', 'UÑON                          '),
	('040413', 'URACA                         '),
	('040414', 'VIRACO                        '),
	('040501', 'CHIVAY                        '),
	('040502', 'ACHOMA                        '),
	('040503', 'CABANACONDE                   '),
	('040504', 'CALLALLI                      '),
	('040505', 'CAYLLOMA                      '),
	('040506', 'COPORAQUE                     '),
	('040507', 'HUAMBO                        '),
	('040508', 'HUANCA                        '),
	('040509', 'ICHUPAMPA                     '),
	('040510', 'LARI                          '),
	('040511', 'LLUTA                         '),
	('040512', 'MACA                          '),
	('040513', 'MADRIGAL                      '),
	('040514', 'SAN ANTONIO DE CHUCA          '),
	('040515', 'SIBAYO                        '),
	('040516', 'TAPAY                         '),
	('040517', 'TISCO                         '),
	('040518', 'TUTI                          '),
	('040519', 'YANQUE                        '),
	('040520', 'MAJES                         '),
	('040601', 'CHUQUIBAMBA                   '),
	('040602', 'ANDARAY                       '),
	('040603', 'CAYARANI                      '),
	('040604', 'CHICHAS                       '),
	('040605', 'IRAY                          '),
	('040606', 'RIO GRANDE                    '),
	('040607', 'SALAMANCA                     '),
	('040608', 'YANAQUIHUA                    '),
	('040701', 'MOLLENDO                      '),
	('040702', 'COCACHACRA                    '),
	('040703', 'DEAN VALDIVIA                 '),
	('040704', 'ISLAY                         '),
	('040705', 'MEJIA                         '),
	('040706', 'PUNTA DE BOMBON               '),
	('040801', 'COTAHUASI                     '),
	('040802', 'ALCA                          '),
	('040803', 'CHARCANA                      '),
	('040804', 'HUAYNACOTAS                   '),
	('040805', 'PAMPAMARCA                    '),
	('040806', 'PUYCA                         '),
	('040807', 'QUECHUALLA                    '),
	('040808', 'SAYLA                         '),
	('040809', 'TAURIA                        '),
	('040810', 'TOMEPAMPA                     '),
	('040811', 'TORO                          '),
	('050101', 'AYACUCHO                      '),
	('050102', 'ACOCRO                        '),
	('050103', 'ACOS VINCHOS                  '),
	('050104', 'CARMEN ALTO                   '),
	('050105', 'CHIARA                        '),
	('050106', 'OCROS                         '),
	('050107', 'PACAYCASA                     '),
	('050108', 'QUINUA                        '),
	('050109', 'SAN JOSE DE TICLLAS           '),
	('050110', 'SAN JUAN BAUTISTA             '),
	('050111', 'SANTIAGO DE PISCHA            '),
	('050112', 'SOCOS                         '),
	('050113', 'TAMBILLO                      '),
	('050114', 'VINCHOS                       '),
	('050115', 'JESUS NAZARENO                '),
	('050201', 'CANGALLO                      '),
	('050202', 'CHUSCHI                       '),
	('050203', 'LOS MOROCHUCOS                '),
	('050204', 'MARIA PARADO DE BELLIDO       '),
	('050205', 'PARAS                         '),
	('050206', 'TOTOS                         '),
	('050301', 'SANCOS                        '),
	('050302', 'CARAPO                        '),
	('050303', 'SACSAMARCA                    '),
	('050304', 'SANTIAGO DE LUCANAMARCA       '),
	('050401', 'HUANTA                        '),
	('050402', 'AYAHUANCO                     '),
	('050403', 'HUAMANGUILLA                  '),
	('050404', 'IGUAIN                        '),
	('050405', 'LURICOCHA                     '),
	('050406', 'SANTILLANA                    '),
	('050407', 'SIVIA                         '),
	('050501', 'SAN MIGUEL                    '),
	('050502', 'ANCO                          '),
	('050503', 'AYNA                          '),
	('050504', 'CHILCAS                       '),
	('050505', 'CHUNGUI                       '),
	('050506', 'LUIS CARRANZA                 '),
	('050507', 'SANTA ROSA                    '),
	('050508', 'TAMBO                         '),
	('050601', 'PUQUIO                        '),
	('050602', 'AUCARA                        '),
	('050603', 'CABANA                        '),
	('050604', 'CARMEN SALCEDO                '),
	('050605', 'CHAVIÑA                       '),
	('050606', 'CHIPAO                        '),
	('050607', 'HUAC-HUAS                     '),
	('050608', 'LARAMATE                      '),
	('050609', 'LEONCIO PRADO                 '),
	('050610', 'LLAUTA                        '),
	('050611', 'LUCANAS                       '),
	('050612', 'OCAÑA                         '),
	('050613', 'OTOCA                         '),
	('050614', 'SAISA                         '),
	('050615', 'SAN CRISTOBAL                 '),
	('050616', 'SAN JUAN                      '),
	('050617', 'SAN PEDRO                     '),
	('050618', 'SAN PEDRO DE PALCO            '),
	('050619', 'SANCOS                        '),
	('050620', 'SANTA ANA DE HUAYCAHUACHO     '),
	('050621', 'SANTA LUCIA                   '),
	('050701', 'CORACORA                      '),
	('050702', 'CHUMPI                        '),
	('050703', 'CORONEL CASTAÑEDA             '),
	('050704', 'PACAPAUSA                     '),
	('050705', 'PULLO                         '),
	('050706', 'PUYUSCA                       '),
	('050707', 'SAN FRANCISCO DE RAVACAYCO    '),
	('050708', 'UPAHUACHO                     '),
	('050801', 'PAUSA                         '),
	('050802', 'COLTA                         '),
	('050803', 'CORCULLA                      '),
	('050804', 'LAMPA                         '),
	('050805', 'MARCABAMBA                    '),
	('050806', 'OYOLO                         '),
	('050807', 'PARARCA                       '),
	('050808', 'SAN JAVIER DE ALPABAMBA       '),
	('050809', 'SAN JOSE DE USHUA             '),
	('050810', 'SARA SARA                     '),
	('050901', 'QUEROBAMBA                    '),
	('050902', 'BELEN                         '),
	('050903', 'CHALCOS                       '),
	('050904', 'CHILCAYOC                     '),
	('050905', 'HUACAÑA                       '),
	('050906', 'MORCOLLA                      '),
	('050907', 'PAICO                         '),
	('050908', 'SAN PEDRO DE LARCAY           '),
	('050909', 'SAN SALVADOR DE QUIJE         '),
	('050910', 'SANTIAGO DE PAUCARAY          '),
	('050911', 'SORAS                         '),
	('051001', 'HUANCAPI                      '),
	('051002', 'ALCAMENCA                     '),
	('051003', 'APONGO                        '),
	('051004', 'ASQUIPATA                     '),
	('051005', 'CANARIA                       '),
	('051006', 'CAYARA                        '),
	('051007', 'COLCA                         '),
	('051008', 'HUAMANQUIQUIA                 '),
	('051009', 'HUANCARAYLLA                  '),
	('051010', 'HUAYA                         '),
	('051011', 'SARHUA                        '),
	('051012', 'VILCANCHOS                    '),
	('051029', 'ABEL'),
	('051101', 'VILCAS HUAMAN                 '),
	('051102', 'ACCOMARCA                     '),
	('051103', 'CARHUANCA                     '),
	('051104', 'CONCEPCION                    '),
	('051105', 'HUAMBALPA                     '),
	('051106', 'INDEPENDENCIA                 '),
	('051107', 'SAURAMA                       '),
	('051108', 'VISCHONGO                     '),
	('060101', 'CAJAMARCA                     '),
	('060102', 'ASUNCION                      '),
	('060103', 'CHETILLA                      '),
	('060104', 'COSPAN                        '),
	('060105', 'ENCAÑADA                      '),
	('060106', 'JESUS                         '),
	('060107', 'LLACANORA                     '),
	('060108', 'LOS BAÑOS DEL INCA            '),
	('060109', 'MAGDALENA                     '),
	('060110', 'MATARA                        '),
	('060111', 'NAMORA                        '),
	('060112', 'SAN JUAN                      '),
	('060201', 'CAJABAMBA                     '),
	('060202', 'CACHACHI                      '),
	('060203', 'CONDEBAMBA                    '),
	('060204', 'SITACOCHA                     '),
	('060301', 'CELENDIN                      '),
	('060302', 'CHUMUCH                       '),
	('060303', 'CORTEGANA                     '),
	('060304', 'HUASMIN                       '),
	('060305', 'JORGE CHAVEZ                  '),
	('060306', 'JOSE GALVEZ                   '),
	('060307', 'MIGUEL IGLESIAS               '),
	('060308', 'OXAMARCA                      '),
	('060309', 'SOROCHUCO                     '),
	('060310', 'SUCRE                         '),
	('060311', 'UTCO                          '),
	('060312', 'LA LIBERTAD DE PALLAN         '),
	('060401', 'CHOTA                         '),
	('060402', 'ANGUIA                        '),
	('060403', 'CHADIN                        '),
	('060404', 'CHIGUIRIP                     '),
	('060405', 'CHIMBAN                       '),
	('060406', 'CHOROPAMPA                    '),
	('060407', 'COCHABAMBA                    '),
	('060408', 'CONCHAN                       '),
	('060409', 'HUAMBOS                       '),
	('060410', 'LAJAS                         '),
	('060411', 'LLAMA                         '),
	('060412', 'MIRACOSTA                     '),
	('060413', 'PACCHA                        '),
	('060414', 'PION                          '),
	('060415', 'QUEROCOTO                     '),
	('060416', 'SAN JUAN DE LICUPIS           '),
	('060417', 'TACABAMBA                     '),
	('060418', 'TOCMOCHE                      '),
	('060419', 'CHALAMARCA                    '),
	('060501', 'CONTUMAZA                     '),
	('060502', 'CHILETE                       '),
	('060503', 'CUPISNIQUE                    '),
	('060504', 'GUZMANGO                      '),
	('060505', 'SAN BENITO                    '),
	('060506', 'SANTA CRUZ DE TOLED           '),
	('060507', 'TANTARICA                     '),
	('060508', 'YONAN                         '),
	('060601', 'CUTERVO                       '),
	('060602', 'CALLAYUC                      '),
	('060603', 'CHOROS                        '),
	('060604', 'CUJILLO                       '),
	('060605', 'LA RAMADA                     '),
	('060606', 'PIMPINGOS                     '),
	('060607', 'QUEROCOTILLO                  '),
	('060608', 'SAN ANDRES DE CUTERVO         '),
	('060609', 'SAN JUAN DE CUTERVO           '),
	('060610', 'SAN LUIS DE LUCMA             '),
	('060611', 'SANTA CRUZ                    '),
	('060612', 'SANTO DOMINGO DE LA CAPILLA   '),
	('060613', 'SANTO TOMAS                   '),
	('060614', 'SOCOTA                        '),
	('060615', 'TORIBIO CASANOVA              '),
	('060701', 'BAMBAMARCA                    '),
	('060702', 'CHUGUR                        '),
	('060703', 'HUALGAYOC                     '),
	('060801', 'JAEN                          '),
	('060802', 'BELLAVISTA                    '),
	('060803', 'CHONTALI                      '),
	('060804', 'COLASAY                       '),
	('060805', 'HUABAL                        '),
	('060806', 'LAS PIRIAS                    '),
	('060807', 'POMAHUACA                     '),
	('060808', 'PUCARA                        '),
	('060809', 'SALLIQUE                      '),
	('060810', 'SAN FELIPE                    '),
	('060811', 'SAN JOSE DEL ALTO             '),
	('060812', 'SANTA ROSA                    '),
	('060901', 'SAN IGNACIO                   '),
	('060902', 'CHIRINOS                      '),
	('060903', 'HUARANGO                      '),
	('060904', 'LA COIPA                      '),
	('060905', 'NAMBALLE                      '),
	('060906', 'SAN JOSE DE LOURDES           '),
	('060907', 'TABACONAS                     '),
	('061001', 'PEDRO GALVEZ                  '),
	('061002', 'CHANCAY                       '),
	('061003', 'EDUARDO VILLANUEVA            '),
	('061004', 'GREGORIO PITA                 '),
	('061005', 'ICHOCAN                       '),
	('061006', 'JOSE MANUEL QUIROZ            '),
	('061007', 'JOSE SABOGAL                  '),
	('061101', 'SAN MIGUEL                    '),
	('061102', 'BOLIVAR                       '),
	('061103', 'CALQUIS                       '),
	('061104', 'CATILLUC                      '),
	('061105', 'EL PRADO                      '),
	('061106', 'LA FLORIDA                    '),
	('061107', 'LLAPA                         '),
	('061108', 'NANCHOC                       '),
	('061109', 'NIEPOS                        '),
	('061110', 'SAN GREGORIO                  '),
	('061111', 'SAN SILVESTRE DE COCHAN       '),
	('061112', 'TONGOD                        '),
	('061113', 'UNION AGUA BLANCA             '),
	('061201', 'SAN PABLO                     '),
	('061202', 'SAN BERNARDINO                '),
	('061203', 'SAN LUIS                      '),
	('061204', 'TUMBADEN                      '),
	('061301', 'SANTA CRUZ                    '),
	('061302', 'ANDABAMBA                     '),
	('061303', 'CATACHE                       '),
	('061304', 'CHANCAYBAÑOS                  '),
	('061305', 'LA ESPERANZA                  '),
	('061306', 'NINABAMBA                     '),
	('061307', 'PULAN                         '),
	('061308', 'SAUCEPAMPA                    '),
	('061309', 'SEXI                          '),
	('061310', 'UTICYACU                      '),
	('061311', 'YAUYUCAN                      '),
	('070101', 'CALLAO                        '),
	('070102', 'BELLAVISTA                    '),
	('070103', 'CARMEN DE LA LEGUA REYNOSO    '),
	('070104', 'LA PERLA                      '),
	('070105', 'LA PUNTA                      '),
	('070106', 'VENTANILLA                    '),
	('070107', 'MI PERU'),
	('080101', 'CUSCO                         '),
	('080102', 'CCORCA                        '),
	('080103', 'POROY                         '),
	('080104', 'SAN JERONIMO                  '),
	('080105', 'SAN SEBASTIAN                 '),
	('080106', 'SANTIAGO                      '),
	('080107', 'SAYLLA                        '),
	('080108', 'WANCHAQ                       '),
	('080201', 'ACOMAYO                       '),
	('080202', 'ACOPIA                        '),
	('080203', 'ACOS                          '),
	('080204', 'MOSOC LLACTA                  '),
	('080205', 'POMACANCHI                    '),
	('080206', 'RONDOCAN                      '),
	('080207', 'SANGARARA                     '),
	('080301', 'ANTA                          '),
	('080302', 'ANCAHUASI                     '),
	('080303', 'CACHIMAYO                     '),
	('080304', 'CHINCHAYPUJIO                 '),
	('080305', 'HUAROCONDO                    '),
	('080306', 'LIMATAMBO                     '),
	('080307', 'MOLLEPATA                     '),
	('080308', 'PUCYURA                       '),
	('080309', 'ZURITE                        '),
	('080401', 'CALCA                         '),
	('080402', 'COYA                          '),
	('080403', 'LAMAY                         '),
	('080404', 'LARES                         '),
	('080405', 'PISAC                         '),
	('080406', 'SAN SALVADOR                  '),
	('080407', 'TARAY                         '),
	('080408', 'YANATILE                      '),
	('080501', 'YANAOCA                       '),
	('080502', 'CHECCA                        '),
	('080503', 'KUNTURKANKI                   '),
	('080504', 'LANGUI                        '),
	('080505', 'LAYO                          '),
	('080506', 'PAMPAMARCA                    '),
	('080507', 'QUEHUE                        '),
	('080508', 'TUPAC AMARU                   '),
	('080601', 'SICUANI                       '),
	('080602', 'CHECACUPE                     '),
	('080603', 'COMBAPATA                     '),
	('080604', 'MARANGANI                     '),
	('080605', 'PITUMARCA                     '),
	('080606', 'SAN PABLO                     '),
	('080607', 'SAN PEDRO                     '),
	('080608', 'TINTA                         '),
	('080701', 'SANTO TOMAS                   '),
	('080702', 'CAPACMARCA                    '),
	('080703', 'CHAMACA                       '),
	('080704', 'COLQUEMARCA                   '),
	('080705', 'LIVITACA                      '),
	('080706', 'LLUSCO                        '),
	('080707', 'QUIÑOTA                       '),
	('080708', 'VELILLE                       '),
	('080801', 'ESPINAR                       '),
	('080802', 'CONDOROMA                     '),
	('080803', 'COPORAQUE                     '),
	('080804', 'OCORURO                       '),
	('080805', 'PALLPATA                      '),
	('080806', 'PICHIGUA                      '),
	('080807', 'SUYCKUTAMBO                   '),
	('080808', 'ALTO PICHIGUA                 '),
	('080901', 'SANTA ANA                     '),
	('080902', 'ECHARATE                      '),
	('080903', 'HUAYOPATA                     '),
	('080904', 'MARANURA                      '),
	('080905', 'OCOBAMBA                      '),
	('080906', 'QUELLOUNO                     '),
	('080907', 'KIMBIRI                       '),
	('080908', 'SANTA TERESA                  '),
	('080909', 'VILCABAMBA                    '),
	('080910', 'PICHARI                       '),
	('081001', 'PARURO                        '),
	('081002', 'ACCHA                         '),
	('081003', 'CCAPI                         '),
	('081004', 'COLCHA                        '),
	('081005', 'HUANOQUITE                    '),
	('081006', 'OMACHA                        '),
	('081007', 'PACCARITAMBO                  '),
	('081008', 'PILLPINTO                     '),
	('081009', 'YAURISQUE                     '),
	('081101', 'PAUCARTAMBO                   '),
	('081102', 'CAICAY                        '),
	('081103', 'CHALLABAMBA                   '),
	('081104', 'COLQUEPATA                    '),
	('081105', 'HUANCARANI                    '),
	('081106', 'KOSÑIPATA                     '),
	('081201', 'URCOS                         '),
	('081202', 'ANDAHUAYLILLAS                '),
	('081203', 'CAMANTI                       '),
	('081204', 'CCARHUAYO                     '),
	('081205', 'CCATCA                        '),
	('081206', 'CUSIPATA                      '),
	('081207', 'HUARO                         '),
	('081208', 'LUCRE                         '),
	('081209', 'MARCAPATA                     '),
	('081210', 'OCONGATE                      '),
	('081211', 'OROPESA                       '),
	('081212', 'QUIQUIJANA                    '),
	('081301', 'URUBAMBA                      '),
	('081302', 'CHINCHERO                     '),
	('081303', 'HUAYLLABAMBA                  '),
	('081304', 'MACHUPICCHU                   '),
	('081305', 'MARAS                         '),
	('081306', 'OLLANTAYTAMBO                 '),
	('081307', 'YUCAY                         '),
	('090101', 'HUANCAVELICA                  '),
	('090102', 'ACOBAMBILLA                   '),
	('090103', 'ACORIA                        '),
	('090104', 'CONAYCA                       '),
	('090105', 'CUENCA                        '),
	('090106', 'HUACHOCOLPA                   '),
	('090107', 'HUAYLLAHUARA                  '),
	('090108', 'IZCUCHACA                     '),
	('090109', 'LARIA                         '),
	('090110', 'MANTA                         '),
	('090111', 'MARISCAL CACERES              '),
	('090112', 'MOYA                          '),
	('090113', 'NUEVO OCCORO                  '),
	('090114', 'PALCA                         '),
	('090115', 'PILCHACA                      '),
	('090116', 'VILCA                         '),
	('090117', 'YAULI                         '),
	('090118', 'ASCENSION                     '),
	('090201', 'ACOBAMBA                      '),
	('090202', 'ANDABAMBA                     '),
	('090203', 'ANTA                          '),
	('090204', 'CAJA                          '),
	('090205', 'MARCAS                        '),
	('090206', 'PAUCARA                       '),
	('090207', 'POMACOCHA                     '),
	('090208', 'ROSARIO                       '),
	('090301', 'LIRCAY                        '),
	('090302', 'ANCHONGA                      '),
	('090303', 'CALLANMARCA                   '),
	('090304', 'CCOCHACCASA                   '),
	('090305', 'CHINCHO                       '),
	('090306', 'CONGALLA                      '),
	('090307', 'HUANCA-HUANCA                 '),
	('090308', 'HUAYLLAY GRANDE               '),
	('090309', 'JULCAMARCA                    '),
	('090310', 'SAN ANTONIO DE ANTAPARCO      '),
	('090311', 'SANTO TOMAS DE PATA           '),
	('090312', 'SECCLLA                       '),
	('090401', 'CASTROVIRREYNA                '),
	('090402', 'ARMA                          '),
	('090403', 'AURAHUA                       '),
	('090404', 'CAPILLAS                      '),
	('090405', 'CHUPAMARCA                    '),
	('090406', 'COCAS                         '),
	('090407', 'HUACHOS                       '),
	('090408', 'HUAMATAMBO                    '),
	('090409', 'MOLLEPAMPA                    '),
	('090410', 'SAN JUAN                      '),
	('090411', 'SANTA ANA                     '),
	('090412', 'TANTARA                       '),
	('090413', 'TICRAPO                       '),
	('090501', 'CHURCAMPA                     '),
	('090502', 'ANCO                          '),
	('090503', 'CHINCHIHUASI                  '),
	('090504', 'EL CARMEN                     '),
	('090505', 'LA MERCED                     '),
	('090506', 'LOCROJA                       '),
	('090507', 'PAUCARBAMBA                   '),
	('090508', 'SAN MIGUEL DE MAYOCC          '),
	('090509', 'SAN PEDRO DE CORIS            '),
	('090510', 'PACHAMARCA                    '),
	('090601', 'HUAYTARA                      '),
	('090602', 'AYAVI                         '),
	('090603', 'CORDOVA                       '),
	('090604', 'HUAYACUNDO ARMA               '),
	('090605', 'LARAMARCA                     '),
	('090606', 'OCOYO                         '),
	('090607', 'PILPICHACA                    '),
	('090608', 'QUERCO                        '),
	('090609', 'QUITO-ARMA                    '),
	('090610', 'SAN ANTONIO DE CUSICANCHA     '),
	('090611', 'SAN FRANCISCO DE SANGAYAICO   '),
	('090612', 'SAN ISIDRO                    '),
	('090613', 'SANTIAGO DE CHOCORVOS         '),
	('090614', 'SANTIAGO DE QUIRAHUARA        '),
	('090615', 'SANTO DOMINGO DE CAPILLAS     '),
	('090616', 'TAMBO                         '),
	('090701', 'PAMPAS                        '),
	('090702', 'ACOSTAMBO                     '),
	('090703', 'ACRAQUIA                      '),
	('090704', 'AHUAYCHA                      '),
	('090705', 'COLCABAMBA                    '),
	('090706', 'DANIEL HERNANDEZ              '),
	('090707', 'HUACHOCOLPA                   '),
	('090708', 'HUANDO                        '),
	('090709', 'HUARIBAMBA                    '),
	('090710', 'ÑAHUIMPUQUIO                  '),
	('090711', 'PAZOS                         '),
	('090713', 'QUISHUAR                      '),
	('090714', 'SALCABAMBA                    '),
	('090715', 'SALCAHUASI                    '),
	('090716', 'SAN MARCOS DE ROCCHAC         '),
	('090717', 'SURCUBAMBA                    '),
	('090718', 'TINTAY PUNCU                  '),
	('100101', 'HUANUCO                       '),
	('100102', 'AMARILIS                      '),
	('100103', 'CHINCHAO                      '),
	('100104', 'CHURUBAMBA                    '),
	('100105', 'MARGOS                        '),
	('100106', 'QUISQUI                       '),
	('100107', 'SAN FRANCISCO DE CAYRAN       '),
	('100108', 'SAN PEDRO DE CHAULAN          '),
	('100109', 'SANTA MARIA DEL VALLE         '),
	('100110', 'YARUMAYO                      '),
	('100111', 'PILLCO MARCA                  '),
	('100112', 'SAN PABLO DE PILLAO'),
	('100201', 'AMBO                          '),
	('100202', 'CAYNA                         '),
	('100203', 'COLPAS                        '),
	('100204', 'CONCHAMARCA                   '),
	('100205', 'HUACAR                        '),
	('100206', 'SAN FRANCISCO                 '),
	('100207', 'SAN RAFAEL                    '),
	('100208', 'TOMAY KICHWA                  '),
	('100301', 'LA UNION                      '),
	('100307', 'CHUQUIS                       '),
	('100311', 'MARIAS                        '),
	('100313', 'PACHAS                        '),
	('100316', 'QUIVILLA                      '),
	('100317', 'RIPAN                         '),
	('100321', 'SHUNQUI                       '),
	('100322', 'SILLAPATA                     '),
	('100323', 'YANAS                         '),
	('100401', 'HUACAYBAMBA                   '),
	('100402', 'CANCHABAMBA                   '),
	('100403', 'COCHABAMBA                    '),
	('100404', 'PINRA                         '),
	('100501', 'LLATA                         '),
	('100502', 'ARANCAY                       '),
	('100503', 'CHAVIN DE PARIARCA            '),
	('100504', 'JACAS GRANDE                  '),
	('100505', 'JIRCAN                        '),
	('100506', 'MIRAFLORES                    '),
	('100507', 'MONZON                        '),
	('100508', 'PUNCHAO                       '),
	('100509', 'PUÑOS                         '),
	('100510', 'SINGA                         '),
	('100511', 'TANTAMAYO                     '),
	('100601', 'RUPA-RUPA                     '),
	('100602', 'DANIEL ALOMIA ROBLES          '),
	('100603', 'HERMILIO VALDIZAN             '),
	('100604', 'JOSE CRESPO Y CASTILLO        '),
	('100605', 'LUYANDO                       '),
	('100606', 'MARIANO DAMASO BERAUN         '),
	('100701', 'HUACRACHUCO                   '),
	('100702', 'CHOLON                        '),
	('100703', 'SAN BUENAVENTURA              '),
	('100801', 'PANAO                         '),
	('100802', 'CHAGLLA                       '),
	('100803', 'MOLINO                        '),
	('100804', 'UMARI                         '),
	('100901', 'PUERTO INCA                   '),
	('100902', 'CODO DEL POZUZO               '),
	('100903', 'HONORIA                       '),
	('100904', 'TOURNAVISTA                   '),
	('100905', 'YUYAPICHIS                    '),
	('101001', 'JESUS                         '),
	('101002', 'BAÑOS                         '),
	('101003', 'JIVIA                         '),
	('101004', 'QUEROPALCA                    '),
	('101005', 'RONDOS                        '),
	('101006', 'SAN FRANCISCO DE ASIS         '),
	('101007', 'SAN MIGUEL DE CAURI           '),
	('101101', 'CHAVINILLO                    '),
	('101102', 'CAHUAC                        '),
	('101103', 'CHACABAMBA                    '),
	('101104', 'CHUPAN                        '),
	('101105', 'JACAS CHICO                   '),
	('101106', 'OBAS                          '),
	('101107', 'PAMPAMARCA                    '),
	('101108', 'CHORAS                        '),
	('110101', 'ICA                           '),
	('110102', 'LA TINGUIÑA                   '),
	('110103', 'LOS AQUIJES                   '),
	('110104', 'OCUCAJE                       '),
	('110105', 'PACHACUTEC                    '),
	('110106', 'PARCONA                       '),
	('110107', 'PUEBLO NUEVO                  '),
	('110108', 'SALAS                         '),
	('110109', 'SAN JOSE DE LOS MOLINOS       '),
	('110110', 'SAN JUAN BAUTISTA             '),
	('110111', 'SANTIAGO                      '),
	('110112', 'SUBTANJALLA                   '),
	('110113', 'TATE                          '),
	('110114', 'YAUCA DEL ROSARIO             '),
	('110201', 'CHINCHA ALTA                  '),
	('110202', 'ALTO LARAN                    '),
	('110203', 'CHAVIN                        '),
	('110204', 'CHINCHA BAJA                  '),
	('110205', 'EL CARMEN                     '),
	('110206', 'GROCIO PRADO                  '),
	('110207', 'PUEBLO NUEVO                  '),
	('110208', 'SAN JUAN DE YANAC             '),
	('110209', 'SAN PEDRO DE HUACARPANA       '),
	('110210', 'SUNAMPE                       '),
	('110211', 'TAMBO DE MORA                 '),
	('110301', 'NAZCA                         '),
	('110302', 'CHANGUILLO                    '),
	('110303', 'EL INGENIO                    '),
	('110304', 'MARCONA                       '),
	('110305', 'VISTA ALEGRE                  '),
	('110401', 'PALPA                         '),
	('110402', 'LLIPATA                       '),
	('110403', 'RIO GRANDE                    '),
	('110404', 'SANTA CRUZ                    '),
	('110405', 'TIBILLO                       '),
	('110501', 'PISCO                         '),
	('110502', 'HUANCANO                      '),
	('110503', 'HUMAY                         '),
	('110504', 'INDEPENDENCIA                 '),
	('110505', 'PARACAS                       '),
	('110506', 'SAN ANDRES                    '),
	('110507', 'SAN CLEMENTE                  '),
	('110508', 'TUPAC AMARU INCA              '),
	('120101', 'HUANCAYO                      '),
	('120104', 'CARHUACALLANGA                '),
	('120105', 'CHACAPAMPA                    '),
	('120106', 'CHICCHE                       '),
	('120107', 'CHILCA                        '),
	('120108', 'CHONGOS ALTO                  '),
	('120111', 'CHUPURO                       '),
	('120112', 'COLCA                         '),
	('120113', 'CULLHUAS                      '),
	('120114', 'EL TAMBO                      '),
	('120116', 'HUACRAPUQUIO                  '),
	('120117', 'HUALHUAS                      '),
	('120119', 'HUANCAN                       '),
	('120120', 'HUASICANCHA                   '),
	('120121', 'HUAYUCACHI                    '),
	('120122', 'INGENIO                       '),
	('120124', 'PARIAHUANCA                   '),
	('120125', 'PILCOMAYO                     '),
	('120126', 'PUCARA                        '),
	('120127', 'QUICHUAY                      '),
	('120128', 'QUILCAS                       '),
	('120129', 'SAN AGUSTIN                   '),
	('120130', 'SAN JERONIMO DE TUNAN         '),
	('120132', 'SAÑO                          '),
	('120133', 'SAPALLANGA                    '),
	('120134', 'SICAYA                        '),
	('120135', 'SANTO DOMINGO DE ACOBAMBA     '),
	('120136', 'VIQUES                        '),
	('120201', 'CONCEPCION                    '),
	('120202', 'ACO                           '),
	('120203', 'ANDAMARCA                     '),
	('120204', 'CHAMBARA                      '),
	('120205', 'COCHAS                        '),
	('120206', 'COMAS                         '),
	('120207', 'HEROINAS TOLEDO               '),
	('120208', 'MANZANARES                    '),
	('120209', 'MARISCAL CASTILLA             '),
	('120210', 'MATAHUASI                     '),
	('120211', 'MITO                          '),
	('120212', 'NUEVE DE JULIO                '),
	('120213', 'ORCOTUNA                      '),
	('120214', 'SAN JOSE DE QUERO             '),
	('120215', 'SANTA ROSA DE OCOPA           '),
	('120301', 'CHANCHAMAYO                   '),
	('120302', 'PERENE                        '),
	('120303', 'PICHANAQUI                    '),
	('120304', 'SAN LUIS DE SHUARO            '),
	('120305', 'SAN RAMON                     '),
	('120306', 'VITOC                         '),
	('120401', 'JAUJA                         '),
	('120402', 'ACOLLA                        '),
	('120403', 'APATA                         '),
	('120404', 'ATAURA                        '),
	('120405', 'CANCHAYLLO                    '),
	('120406', 'CURICACA                      '),
	('120407', 'EL MANTARO                    '),
	('120408', 'HUAMALI                       '),
	('120409', 'HUARIPAMPA                    '),
	('120410', 'HUERTAS                       '),
	('120411', 'JANJAILLO                     '),
	('120412', 'JULCAN                        '),
	('120413', 'LEONOR ORDOÑEZ                '),
	('120414', 'LLOCLLAPAMPA                  '),
	('120415', 'MARCO                         '),
	('120416', 'MASMA                         '),
	('120417', 'MASMA CHICCHE                 '),
	('120418', 'MOLINOS                       '),
	('120419', 'MONOBAMBA                     '),
	('120420', 'MUQUI                         '),
	('120421', 'MUQUIYAUYO                    '),
	('120422', 'PACA                          '),
	('120423', 'PACCHA                        '),
	('120424', 'PANCAN                        '),
	('120425', 'PARCO                         '),
	('120426', 'POMACANCHA                    '),
	('120427', 'RICRAN                        '),
	('120428', 'SAN LORENZO                   '),
	('120429', 'SAN PEDRO DE CHUNAN           '),
	('120430', 'SAUSA                         '),
	('120431', 'SINCOS                        '),
	('120432', 'TUNAN MARCA                   '),
	('120433', 'YAULI                         '),
	('120434', 'YAUYOS                        '),
	('120501', 'JUNIN                         '),
	('120502', 'CARHUAMAYO                    '),
	('120503', 'ONDORES                       '),
	('120504', 'ULCUMAYO                      '),
	('120601', 'SATIPO                        '),
	('120602', 'COVIRIALI                     '),
	('120603', 'LLAYLLA                       '),
	('120604', 'MAZAMARI                      '),
	('120605', 'PAMPA HERMOSA                 '),
	('120606', 'PANGOA                        '),
	('120607', 'RIO NEGRO                     '),
	('120608', 'RIO TAMBO                     '),
	('120701', 'TARMA                         '),
	('120702', 'ACOBAMBA                      '),
	('120703', 'HUARICOLCA                    '),
	('120704', 'HUASAHUASI                    '),
	('120705', 'LA UNION                      '),
	('120706', 'PALCA                         '),
	('120707', 'PALCAMAYO                     '),
	('120708', 'SAN PEDRO DE CAJAS            '),
	('120709', 'TAPO                          '),
	('120801', 'LA OROYA                      '),
	('120802', 'CHACAPALPA                    '),
	('120803', 'HUAY-HUAY                     '),
	('120804', 'MARCAPOMACOCHA                '),
	('120805', 'MOROCOCHA                     '),
	('120806', 'PACCHA                        '),
	('120807', 'SANTA BARBARA DE CARHUACAYAN  '),
	('120808', 'SANTA ROSA DE SACCO           '),
	('120809', 'SUITUCANCHA                   '),
	('120810', 'YAULI                         '),
	('120901', 'CHUPACA                       '),
	('120902', 'AHUAC                         '),
	('120903', 'CHONGOS BAJO                  '),
	('120904', 'HUACHAC                       '),
	('120905', 'HUAMANCACA CHICO              '),
	('120906', 'SAN JUAN DE ISCOS             '),
	('120907', 'SAN JUAN DE JARPA             '),
	('120908', 'TRES DE DICIEMBRE             '),
	('120909', 'YANACANCHA                    '),
	('130101', 'TRUJILLO                      '),
	('130102', 'EL PORVENIR                   '),
	('130103', 'FLORENCIA DE MORA             '),
	('130104', 'HUANCHACO                     '),
	('130105', 'LA ESPERANZA                  '),
	('130106', 'LAREDO                        '),
	('130107', 'MOCHE                         '),
	('130108', 'POROTO                        '),
	('130109', 'SALAVERRY                     '),
	('130110', 'SIMBAL                        '),
	('130111', 'VICTOR LARCO HERRERA          '),
	('130201', 'ASCOPE                        '),
	('130202', 'CHICAMA                       '),
	('130203', 'CHOCOPE                       '),
	('130204', 'MAGDALENA DE CAO              '),
	('130205', 'PAIJAN                        '),
	('130206', 'RAZURI                        '),
	('130207', 'SANTIAGO DE CAO               '),
	('130208', 'CASA GRANDE                   '),
	('130301', 'BOLIVAR                       '),
	('130302', 'BAMBAMARCA                    '),
	('130303', 'CONDORMARCA                   '),
	('130304', 'LONGOTEA                      '),
	('130305', 'UCHUMARCA                     '),
	('130306', 'UCUNCHA                       '),
	('130401', 'CHEPEN                        '),
	('130402', 'PACANGA                       '),
	('130403', 'PUEBLO NUEVO                  '),
	('130501', 'JULCAN                        '),
	('130502', 'CALAMARCA                     '),
	('130503', 'CARABAMBA                     '),
	('130504', 'HUASO                         '),
	('130601', 'OTUZCO                        '),
	('130602', 'AGALLPAMPA                    '),
	('130604', 'CHARAT                        '),
	('130605', 'HUARANCHAL                    '),
	('130606', 'LA CUESTA                     '),
	('130608', 'MACHE                         '),
	('130610', 'PARANDAY                      '),
	('130611', 'SALPO                         '),
	('130613', 'SINSICAP                      '),
	('130614', 'USQUIL                        '),
	('130701', 'SAN PEDRO DE LLOC             '),
	('130702', 'GUADALUPE                     '),
	('130703', 'JEQUETEPEQUE                  '),
	('130704', 'PACASMAYO                     '),
	('130705', 'SAN JOSE                      '),
	('130801', 'TAYABAMBA                     '),
	('130802', 'BULDIBUYO                     '),
	('130803', 'CHILLIA                       '),
	('130804', 'HUANCASPATA                   '),
	('130805', 'HUAYLILLAS                    '),
	('130806', 'HUAYO                         '),
	('130807', 'ONGON                         '),
	('130808', 'PARCOY                        '),
	('130809', 'PATAZ                         '),
	('130810', 'PIAS                          '),
	('130811', 'SANTIAGO DE CHALLAS           '),
	('130812', 'TAURIJA                       '),
	('130813', 'URPAY                         '),
	('130901', 'HUAMACHUCO                    '),
	('130902', 'CHUGAY                        '),
	('130903', 'COCHORCO                      '),
	('130904', 'CURGOS                        '),
	('130905', 'MARCABAL                      '),
	('130906', 'SANAGORAN                     '),
	('130907', 'SARIN                         '),
	('130908', 'SARTIMBAMBA                   '),
	('131001', 'SANTIAGO DE CHUCO             '),
	('131002', 'ANGASMARCA                    '),
	('131003', 'CACHICADAN                    '),
	('131004', 'MOLLEBAMBA                    '),
	('131005', 'MOLLEPATA                     '),
	('131006', 'QUIRUVILCA                    '),
	('131007', 'SANTA CRUZ DE CHUCA           '),
	('131008', 'SITABAMBA                     '),
	('131101', 'CASCAS                        '),
	('131102', 'LUCMA                         '),
	('131103', 'MARMOT                        '),
	('131104', 'SAYAPULLO                     '),
	('131201', 'VIRU                          '),
	('131202', 'CHAO                          '),
	('131203', 'GUADALUPITO                   '),
	('140101', 'CHICLAYO                      '),
	('140102', 'CHONGOYAPE                    '),
	('140103', 'ETEN                          '),
	('140104', 'ETEN PUERTO                   '),
	('140105', 'JOSE LEONARDO ORTIZ           '),
	('140106', 'LA VICTORIA                   '),
	('140107', 'LAGUNAS                       '),
	('140108', 'MONSEFU                       '),
	('140109', 'NUEVA ARICA                   '),
	('140110', 'OYOTUN                        '),
	('140111', 'PICSI                         '),
	('140112', 'PIMENTEL                      '),
	('140113', 'REQUE                         '),
	('140114', 'SANTA ROSA                    '),
	('140115', 'SAÑA                          '),
	('140116', 'CAYALTI                       '),
	('140117', 'PATAPO                        '),
	('140118', 'POMALCA                       '),
	('140119', 'PUCALA                        '),
	('140120', 'TUMAN                         '),
	('140201', 'FERREÑAFE                     '),
	('140202', 'CAÑARIS                       '),
	('140203', 'INCAHUASI                     '),
	('140204', 'MANUEL ANTONIO MESONES MURO   '),
	('140205', 'PITIPO                        '),
	('140206', 'PUEBLO NUEVO                  '),
	('140301', 'LAMBAYEQUE                    '),
	('140302', 'CHOCHOPE                      '),
	('140303', 'ILLIMO                        '),
	('140304', 'JAYANCA                       '),
	('140305', 'MOCHUMI                       '),
	('140306', 'MORROPE                       '),
	('140307', 'MOTUPE                        '),
	('140308', 'OLMOS                         '),
	('140309', 'PACORA                        '),
	('140310', 'SALAS                         '),
	('140311', 'SAN JOSE                      '),
	('140312', 'TUCUME                        '),
	('150101', 'CERCADO DE LIMA                          '),
	('150102', 'ANCON                         '),
	('150103', 'ATE                           '),
	('150104', 'BARRANCO                      '),
	('150105', 'BREÑA                         '),
	('150106', 'CARABAYLLO                    '),
	('150107', 'CHACLACAYO                    '),
	('150108', 'CHORRILLOS                    '),
	('150109', 'CIENEGUILLA                   '),
	('150110', 'COMAS                         '),
	('150111', 'EL AGUSTINO                   '),
	('150112', 'INDEPENDENCIA                 '),
	('150113', 'JESUS MARIA                   '),
	('150114', 'LA MOLINA                     '),
	('150115', 'LA VICTORIA                   '),
	('150116', 'LINCE                         '),
	('150117', 'LOS OLIVOS                    '),
	('150118', 'LURIGANCHO                    '),
	('150119', 'LURIN                         '),
	('150120', 'MAGDALENA DEL MAR             '),
	('150121', 'PUEBLO LIBRE'),
	('150122', 'MIRAFLORES                    '),
	('150123', 'PACHACAMAC                    '),
	('150124', 'PUCUSANA                      '),
	('150125', 'PUENTE PIEDRA                 '),
	('150126', 'PUNTA HERMOSA                 '),
	('150127', 'PUNTA NEGRA                   '),
	('150128', 'RIMAC                         '),
	('150129', 'SAN BARTOLO                   '),
	('150130', 'SAN BORJA                     '),
	('150131', 'SAN ISIDRO                    '),
	('150132', 'SAN JUAN DE LURIGANCHO        '),
	('150133', 'SAN JUAN DE MIRAFLORES        '),
	('150134', 'SAN LUIS                      '),
	('150135', 'SAN MARTIN DE PORRES          '),
	('150136', 'SAN MIGUEL                    '),
	('150137', 'SANTA ANITA                   '),
	('150138', 'SANTA MARIA DEL MAR           '),
	('150139', 'SANTA ROSA                    '),
	('150140', 'SANTIAGO DE SURCO             '),
	('150141', 'SURQUILLO                     '),
	('150142', 'VILLA EL SALVADOR             '),
	('150143', 'VILLA MARIA DEL TRIUNFO       '),
	('150167', 'AABU'),
	('150188', 'SJL ULTIMO'),
	('150199', 'SJL ULTIMO 2'),
	('150201', 'BARRANCA                      '),
	('150202', 'PARAMONGA                     '),
	('150203', 'PATIVILCA                     '),
	('150204', 'SUPE                          '),
	('150205', 'SUPE PUERTO                   '),
	('150301', 'CAJATAMBO                     '),
	('150302', 'COPA                          '),
	('150303', 'GORGOR                        '),
	('150304', 'HUANCAPON                     '),
	('150305', 'MANAS                         '),
	('150401', 'CANTA                         '),
	('150402', 'ARAHUAY                       '),
	('150403', 'HUAMANTANGA                   '),
	('150404', 'HUAROS                        '),
	('150405', 'LACHAQUI                      '),
	('150406', 'SAN BUENAVENTURA              '),
	('150407', 'SANTA ROSA DE QUIVES          '),
	('150501', 'SAN VICENTE DE CAÑETE         '),
	('150502', 'ASIA                          '),
	('150503', 'CALANGO                       '),
	('150504', 'CERRO AZUL                    '),
	('150505', 'CHILCA                        '),
	('150506', 'COAYLLO                       '),
	('150507', 'IMPERIAL                      '),
	('150508', 'LUNAHUANA                     '),
	('150509', 'MALA                          '),
	('150510', 'NUEVO IMPERIAL                '),
	('150511', 'PACARAN                       '),
	('150512', 'QUILMANA                      '),
	('150513', 'SAN ANTONIO                   '),
	('150514', 'SAN LUIS                      '),
	('150515', 'SANTA CRUZ DE FLORES          '),
	('150516', 'ZUÑIGA                        '),
	('150601', 'HUARAL                        '),
	('150602', 'ATAVILLOS ALTO                '),
	('150603', 'ATAVILLOS BAJO                '),
	('150604', 'AUCALLAMA                     '),
	('150605', 'CHANCAY                       '),
	('150606', 'IHUARI                        '),
	('150607', 'LAMPIAN                       '),
	('150608', 'PACARAOS                      '),
	('150609', 'SAN MIGUEL DE ACOS            '),
	('150610', 'SANTA CRUZ DE ANDAMARCA       '),
	('150611', 'SUMBILCA                      '),
	('150612', 'VEINTISIETE DE NOVIEMBRE      '),
	('150701', 'MATUCANA                      '),
	('150702', 'ANTIOQUIA                     '),
	('150703', 'CALLAHUANCA                   '),
	('150704', 'CARAMPOMA                     '),
	('150705', 'CHICLA                        '),
	('150706', 'CUENCA                        '),
	('150707', 'HUACHUPAMPA                   '),
	('150708', 'HUANZA                        '),
	('150709', 'HUAROCHIRI                    '),
	('150710', 'LAHUAYTAMBO                   '),
	('150711', 'LANGA                         '),
	('150712', 'LARAOS                        '),
	('150713', 'MARIATANA                     '),
	('150714', 'RICARDO PALMA                 '),
	('150715', 'SAN ANDRES DE TUPICOCHA       '),
	('150716', 'SAN ANTONIO                   '),
	('150717', 'SAN BARTOLOME                 '),
	('150718', 'SAN DAMIAN                    '),
	('150719', 'SAN JUAN DE IRIS              '),
	('150720', 'SAN JUAN DE TANTARANCHE       '),
	('150721', 'SAN LORENZO DE QUINTI         '),
	('150722', 'SAN MATEO                     '),
	('150723', 'SAN MATEO DE OTAO             '),
	('150724', 'SAN PEDRO DE CASTA            '),
	('150725', 'SAN PEDRO DE HUANCAYRE        '),
	('150726', 'SANGALLAYA                    '),
	('150727', 'SANTA CRUZ DE COCACHACRA      '),
	('150728', 'SANTA EULALIA                 '),
	('150729', 'SANTIAGO DE ANCHUCAYA         '),
	('150730', 'SANTIAGO DE TUNA              '),
	('150731', 'SANTO DOMINGO DE LOS OLLEROS  '),
	('150732', 'SURCO                         '),
	('150801', 'HUACHO                        '),
	('150802', 'AMBAR                         '),
	('150803', 'CALETA DE CARQUIN             '),
	('150804', 'CHECRAS                       '),
	('150805', 'HUALMAY                       '),
	('150806', 'HUAURA                        '),
	('150807', 'LEONCIO PRADO                 '),
	('150808', 'PACCHO                        '),
	('150809', 'SANTA LEONOR                  '),
	('150810', 'SANTA MARIA                   '),
	('150811', 'SAYAN                         '),
	('150812', 'VEGUETA                       '),
	('150901', 'OYON                          '),
	('150902', 'ANDAJES                       '),
	('150903', 'CAUJUL                        '),
	('150904', 'COCHAMARCA                    '),
	('150905', 'NAVAN                         '),
	('150906', 'PACHANGARA                    '),
	('151001', 'YAUYOS                        '),
	('151002', 'ALIS                          '),
	('151003', 'AYAUCA                        '),
	('151004', 'AYAVIRI                       '),
	('151005', 'AZANGARO                      '),
	('151006', 'CACRA                         '),
	('151007', 'CARANIA                       '),
	('151008', 'CATAHUASI                     '),
	('151009', 'CHOCOS                        '),
	('151010', 'COCHAS                        '),
	('151011', 'COLONIA                       '),
	('151012', 'HONGOS                        '),
	('151013', 'HUAMPARA                      '),
	('151014', 'HUANCAYA                      '),
	('151015', 'HUANGASCAR                    '),
	('151016', 'HUANTAN                       '),
	('151017', 'HUAÑEC                        '),
	('151018', 'LARAOS                        '),
	('151019', 'LINCHA                        '),
	('151020', 'MADEAN                        '),
	('151021', 'MIRAFLORES                    '),
	('151022', 'OMAS                          '),
	('151023', 'PUTINZA                       '),
	('151024', 'QUINCHES                      '),
	('151025', 'QUINOCAY                      '),
	('151026', 'SAN JOAQUIN                   '),
	('151027', 'SAN PEDRO DE PILAS            '),
	('151028', 'TANTA                         '),
	('151029', 'TAURIPAMPA                    '),
	('151030', 'TOMAS                         '),
	('151031', 'TUPE                          '),
	('151032', 'VIÑAC                         '),
	('151033', 'VITIS                         '),
	('16', 'disss'),
	('160101', 'IQUITOS                       '),
	('160102', 'ALTO NANAY                    '),
	('160103', 'FERNANDO LORES                '),
	('160104', 'INDIANA                       '),
	('160105', 'LAS AMAZONAS                  '),
	('160106', 'MAZAN                         '),
	('160107', 'NAPO                          '),
	('160108', 'PUNCHANA                      '),
	('160109', 'PUTUMAYO                      '),
	('160110', 'TORRES CAUSANA                '),
	('160111', 'YAQUERANA                     '),
	('160112', 'BELEN                         '),
	('160113', 'SAN JUAN BAUTISTA             '),
	('160201', 'YURIMAGUAS                    '),
	('160202', 'BALSAPUERTO                   '),
	('160203', 'BARRANCA                      '),
	('160204', 'CAHUAPANAS                    '),
	('160205', 'JEBEROS                       '),
	('160206', 'LAGUNAS                       '),
	('160207', 'MANSERICHE                    '),
	('160208', 'MORONA                        '),
	('160209', 'PASTAZA                       '),
	('160210', 'SANTA CRUZ                    '),
	('160211', 'TENIENTE CESAR LOPEZ ROJAS    '),
	('160301', 'NAUTA                         '),
	('160302', 'PARINARI                      '),
	('160303', 'TIGRE                         '),
	('160304', 'TROMPETEROS                   '),
	('160305', 'URARINAS                      '),
	('160401', 'RAMON CASTILLA                '),
	('160402', 'PEBAS                         '),
	('160403', 'YAVARI                        '),
	('160404', 'SAN PABLO                     '),
	('160501', 'REQUENA                       '),
	('160502', 'ALTO TAPICHE                  '),
	('160503', 'CAPELO                        '),
	('160504', 'EMILIO SAN MARTIN             '),
	('160505', 'MAQUIA                        '),
	('160506', 'PUINAHUA                      '),
	('160507', 'SAQUENA                       '),
	('160508', 'SOPLIN                        '),
	('160509', 'TAPICHE                       '),
	('160510', 'JENARO HERRERA                '),
	('160511', 'YAQUERANA                     '),
	('160601', 'CONTAMANA                     '),
	('160602', 'INAHUAYA                      '),
	('160603', 'PADRE MARQUEZ                 '),
	('160604', 'PAMPA HERMOSA                 '),
	('160605', 'SARAYACU                      '),
	('160606', 'VARGAS GUERRA                 '),
	('160697', 'AYU'),
	('170101', 'TAMBOPATA                     '),
	('170102', 'INAMBARI                      '),
	('170103', 'LAS PIEDRAS                   '),
	('170104', 'LABERINTO                     '),
	('170201', 'MANU                          '),
	('170202', 'FITZCARRALD                   '),
	('170203', 'MADRE DE DIOS                 '),
	('170204', 'HUEPETUHE                     '),
	('170301', 'IÑAPARI                       '),
	('170302', 'IBERIA                        '),
	('170303', 'TAHUAMANU                     '),
	('180101', 'MOQUEGUA                      '),
	('180102', 'CARUMAS                       '),
	('180103', 'CUCHUMBAYA                    '),
	('180104', 'SAMEGUA                       '),
	('180105', 'SAN CRISTOBAL                 '),
	('180106', 'TORATA                        '),
	('180201', 'OMATE                         '),
	('180202', 'CHOJATA                       '),
	('180203', 'COALAQUE                      '),
	('180204', 'ICHUÑA                        '),
	('180205', 'LA CAPILLA                    '),
	('180206', 'LLOQUE                        '),
	('180207', 'MATALAQUE                     '),
	('180208', 'PUQUINA                       '),
	('180209', 'QUINISTAQUILLAS               '),
	('180210', 'UBINAS                        '),
	('180211', 'YUNGA                         '),
	('180301', 'ILO                           '),
	('180302', 'EL ALGARROBAL                 '),
	('180303', 'PACOCHA                       '),
	('190101', 'CHAUPIMARCA                   '),
	('190102', 'HUACHON                       '),
	('190103', 'HUARIACA                      '),
	('190104', 'HUAYLLAY                      '),
	('190105', 'NINACACA                      '),
	('190106', 'PALLANCHACRA                  '),
	('190107', 'PAUCARTAMBO                   '),
	('190108', 'SAN FCO.DE ASIS DE YARUSYACAN '),
	('190109', 'SIMON BOLIVAR                 '),
	('190110', 'TICLACAYAN                    '),
	('190111', 'TINYAHUARCO                   '),
	('190112', 'VICCO                         '),
	('190113', 'YANACANCHA                    '),
	('190201', 'YANAHUANCA                    '),
	('190202', 'CHACAYAN                      '),
	('190203', 'GOYLLARISQUIZGA               '),
	('190204', 'PAUCAR                        '),
	('190205', 'SAN PEDRO DE PILLAO           '),
	('190206', 'SANTA ANA DE TUSI             '),
	('190207', 'TAPUC                         '),
	('190208', 'VILCABAMBA                    '),
	('190301', 'OXAPAMPA                      '),
	('190302', 'CHONTABAMBA                   '),
	('190303', 'HUANCABAMBA                   '),
	('190304', 'PALCAZU                       '),
	('190305', 'POZUZO                        '),
	('190306', 'PUERTO BERMUDEZ               '),
	('190307', 'VILLA RICA                    '),
	('200101', 'PIURA                         '),
	('200104', 'CASTILLA                      '),
	('200105', 'CATACAOS                      '),
	('200107', 'CURA MORI                     '),
	('200108', 'EL TALLAN                     '),
	('200109', 'LA ARENA                      '),
	('200110', 'LA UNION                      '),
	('200111', 'LAS LOMAS                     '),
	('200114', 'TAMBO GRANDE                  '),
	('200140', 'VEINTISEIS DE OCTUBRE'),
	('200201', 'AYABACA                       '),
	('200202', 'FRIAS                         '),
	('200203', 'JILILI                        '),
	('200204', 'LAGUNAS                       '),
	('200205', 'MONTERO                       '),
	('200206', 'PACAIPAMPA                    '),
	('200207', 'PAIMAS                        '),
	('200208', 'SAPILLICA                     '),
	('200209', 'SICCHEZ                       '),
	('200210', 'SUYO                          '),
	('200301', 'HUANCABAMBA                   '),
	('200302', 'CANCHAQUE                     '),
	('200303', 'EL CARMEN DE LA FRONTERA      '),
	('200304', 'HUARMACA                      '),
	('200305', 'LALAQUIZ                      '),
	('200306', 'SAN MIGUEL DE EL FAIQUE       '),
	('200307', 'SONDOR                        '),
	('200308', 'SONDORILLO                    '),
	('200401', 'CHULUCANAS                    '),
	('200402', 'BUENOS AIRES                  '),
	('200403', 'CHALACO                       '),
	('200404', 'LA MATANZA                    '),
	('200405', 'MORROPON                      '),
	('200406', 'SALITRAL                      '),
	('200407', 'SAN JUAN DE BIGOTE            '),
	('200408', 'SANTA CATALINA DE MOSSA       '),
	('200409', 'SANTO DOMINGO                 '),
	('200410', 'YAMANGO                       '),
	('200501', 'PAITA                         '),
	('200502', 'AMOTAPE                       '),
	('200503', 'ARENAL                        '),
	('200504', 'COLAN                         '),
	('200505', 'LA HUACA                      '),
	('200506', 'TAMARINDO                     '),
	('200507', 'VICHAYAL                      '),
	('200601', 'SULLANA                       '),
	('200602', 'BELLAVISTA                    '),
	('200603', 'IGNACIO ESCUDERO              '),
	('200604', 'LANCONES                      '),
	('200605', 'MARCAVELICA                   '),
	('200606', 'MIGUEL CHECA                  '),
	('200607', 'QUERECOTILLO                  '),
	('200608', 'SALITRAL                      '),
	('200701', 'PARIÑAS                       '),
	('200702', 'EL ALTO                       '),
	('200703', 'LA BREA                       '),
	('200704', 'LOBITOS                       '),
	('200705', 'LOS ORGANOS                   '),
	('200706', 'MANCORA                       '),
	('200801', 'SECHURA                       '),
	('200802', 'BELLAVISTA DE LA UNION        '),
	('200803', 'BERNAL                        '),
	('200804', 'CRISTO NOS VALGA              '),
	('200805', 'VICE                          '),
	('200806', 'RINCONADA LLICUAR             '),
	('210101', 'PUNO                          '),
	('210102', 'ACORA                         '),
	('210103', 'AMANTANI                      '),
	('210104', 'ATUNCOLLA                     '),
	('210105', 'CAPACHICA                     '),
	('210106', 'CHUCUITO                      '),
	('210107', 'COATA                         '),
	('210108', 'HUATA                         '),
	('210109', 'MAÑAZO                        '),
	('210110', 'PAUCARCOLLA                   '),
	('210111', 'PICHACANI                     '),
	('210112', 'PLATERIA                      '),
	('210113', 'SAN ANTONIO                   '),
	('210114', 'TIQUILLACA                    '),
	('210115', 'VILQUE                        '),
	('210201', 'AZANGARO                      '),
	('210202', 'ACHAYA                        '),
	('210203', 'ARAPA                         '),
	('210204', 'ASILLO                        '),
	('210205', 'CAMINACA                      '),
	('210206', 'CHUPA                         '),
	('210207', 'JOSE DOMINGO CHOQUEHUANCA     '),
	('210208', 'MUÑANI                        '),
	('210209', 'POTONI                        '),
	('210210', 'SAMAN                         '),
	('210211', 'SAN ANTON                     '),
	('210212', 'SAN JOSE                      '),
	('210213', 'SAN JUAN DE SALINAS           '),
	('210214', 'SANTIAGO DE PUPUJA            '),
	('210215', 'TIRAPATA                      '),
	('210301', 'MACUSANI                      '),
	('210302', 'AJOYANI                       '),
	('210303', 'AYAPATA                       '),
	('210304', 'COASA                         '),
	('210305', 'CORANI                        '),
	('210306', 'CRUCERO                       '),
	('210307', 'ITUATA                        '),
	('210308', 'OLLACHEA                      '),
	('210309', 'SAN GABAN                     '),
	('210310', 'USICAYOS                      '),
	('210401', 'JULI                          '),
	('210402', 'DESAGUADERO                   '),
	('210403', 'HUACULLANI                    '),
	('210404', 'KELLUYO                       '),
	('210405', 'PISACOMA                      '),
	('210406', 'POMATA                        '),
	('210407', 'ZEPITA                        '),
	('210501', 'ILAVE                         '),
	('210502', 'CAPAZO                        '),
	('210503', 'PILCUYO                       '),
	('210504', 'SANTA ROSA                    '),
	('210505', 'CONDURIRI                     '),
	('210601', 'HUANCANE                      '),
	('210602', 'COJATA                        '),
	('210603', 'HUATASANI                     '),
	('210604', 'INCHUPALLA                    '),
	('210605', 'PUSI                          '),
	('210606', 'ROSASPATA                     '),
	('210607', 'TARACO                        '),
	('210608', 'VILQUE CHICO                  '),
	('210701', 'LAMPA                         '),
	('210702', 'CABANILLA                     '),
	('210703', 'CALAPUJA                      '),
	('210704', 'NICASIO                       '),
	('210705', 'OCUVIRI                       '),
	('210706', 'PALCA                         '),
	('210707', 'PARATIA                       '),
	('210708', 'PUCARA                        '),
	('210709', 'SANTA LUCIA                   '),
	('210710', 'VILAVILA                      '),
	('210801', 'AYAVIRI                       '),
	('210802', 'ANTAUTA                       '),
	('210803', 'CUPI                          '),
	('210804', 'LLALLI                        '),
	('210805', 'MACARI                        '),
	('210806', 'NUÑOA                         '),
	('210807', 'ORURILLO                      '),
	('210808', 'SANTA ROSA                    '),
	('210809', 'UMACHIRI                      '),
	('210901', 'MOHO                          '),
	('210902', 'CONIMA                        '),
	('210903', 'HUAYRAPATA                    '),
	('210904', 'TILALI                        '),
	('211001', 'PUTINA                        '),
	('211002', 'ANANEA                        '),
	('211003', 'PEDRO VILCA APAZA             '),
	('211004', 'QUILCAPUNCU                   '),
	('211005', 'SINA                          '),
	('211101', 'JULIACA                       '),
	('211102', 'CABANA                        '),
	('211103', 'CABANILLAS                    '),
	('211104', 'CARACOTO                      '),
	('211201', 'SANDIA                        '),
	('211202', 'CUYOCUYO                      '),
	('211203', 'LIMBANI                       '),
	('211204', 'PATAMBUCO                     '),
	('211205', 'PHARA                         '),
	('211206', 'QUIACA                        '),
	('211207', 'SAN JUAN DEL ORO              '),
	('211208', 'YANAHUAYA                     '),
	('211209', 'ALTO INAMBARI                 '),
	('211301', 'YUNGUYO                       '),
	('211302', 'ANAPIA                        '),
	('211303', 'COPANI                        '),
	('211304', 'CUTURAPI                      '),
	('211305', 'OLLARAYA                      '),
	('211306', 'TINICACHI                     '),
	('211307', 'UNICACHI                      '),
	('220101', 'MOYOBAMBA                     '),
	('220102', 'CALZADA                       '),
	('220103', 'HABANA                        '),
	('220104', 'JEPELACIO                     '),
	('220105', 'SORITOR                       '),
	('220106', 'YANTALO                       '),
	('220201', 'BELLAVISTA                    '),
	('220202', 'ALTO BIAVO                    '),
	('220203', 'BAJO BIAVO                    '),
	('220204', 'HUALLAGA                      '),
	('220205', 'SAN PABLO                     '),
	('220206', 'SAN RAFAEL                    '),
	('220301', 'SAN JOSE DE SISA              '),
	('220302', 'AGUA BLANCA                   '),
	('220303', 'SAN MARTIN                    '),
	('220304', 'SANTA ROSA                    '),
	('220305', 'SHATOJA                       '),
	('220401', 'SAPOSOA                       '),
	('220402', 'ALTO SAPOSOA                  '),
	('220403', 'EL ESLABON                    '),
	('220404', 'PISCOYACU                     '),
	('220405', 'SACANCHE                      '),
	('220406', 'TINGO DE SAPOSOA              '),
	('220501', 'LAMAS                         '),
	('220502', 'ALONSO DE ALVARADO            '),
	('220503', 'BARRANQUITA                   '),
	('220504', 'CAYNARACHI                    '),
	('220505', 'CUÑUMBUQUI                    '),
	('220506', 'PINTO RECODO                  '),
	('220507', 'RUMISAPA                      '),
	('220508', 'SAN ROQUE DE CUMBAZA          '),
	('220509', 'SHANAO                        '),
	('220510', 'TABALOSOS                     '),
	('220511', 'ZAPATERO                      '),
	('220601', 'JUANJUI                       '),
	('220602', 'CAMPANILLA                    '),
	('220603', 'HUICUNGO                      '),
	('220604', 'PACHIZA                       '),
	('220605', 'PAJARILLO                     '),
	('220701', 'PICOTA                        '),
	('220702', 'BUENOS AIRES                  '),
	('220703', 'CASPISAPA                     '),
	('220704', 'PILLUANA                      '),
	('220705', 'PUCACACA                      '),
	('220706', 'SAN CRISTOBAL                 '),
	('220707', 'SAN HILARION                  '),
	('220708', 'SHAMBOYACU                    '),
	('220709', 'TINGO DE PONASA               '),
	('220710', 'TRES UNIDOS                   '),
	('220801', 'RIOJA                         '),
	('220802', 'AWAJUN                        '),
	('220803', 'ELIAS SOPLIN VARGAS           '),
	('220804', 'NUEVA CAJAMARCA               '),
	('220805', 'PARDO MIGUEL                  '),
	('220806', 'POSIC                         '),
	('220807', 'SAN FERNANDO                  '),
	('220808', 'YORONGOS                      '),
	('220809', 'YURACYACU                     '),
	('220901', 'TARAPOTO                      '),
	('220902', 'ALBERTO LEVEAU                '),
	('220903', 'CACATACHI                     '),
	('220904', 'CHAZUTA                       '),
	('220905', 'CHIPURANA                     '),
	('220906', 'EL PORVENIR                   '),
	('220907', 'HUIMBAYOC                     '),
	('220908', 'JUAN GUERRA                   '),
	('220909', 'LA BANDA DE SHILCAYO          '),
	('220910', 'MORALES                       '),
	('220911', 'PAPAPLAYA                     '),
	('220912', 'SAN ANTONIO                   '),
	('220913', 'SAUCE                         '),
	('220914', 'SHAPAJA                       '),
	('221001', 'TOCACHE                       '),
	('221002', 'NUEVO PROGRESO                '),
	('221003', 'POLVORA                       '),
	('221004', 'SHUNTE                        '),
	('221005', 'UCHIZA                        '),
	('23', 'sdf'),
	('230101', 'TACNA                         '),
	('230102', 'ALTO DE LA ALIANZA            '),
	('230103', 'CALANA                        '),
	('230104', 'CIUDAD NUEVA                  '),
	('230105', 'INCLAN                        '),
	('230106', 'PACHIA                        '),
	('230107', 'PALCA                         '),
	('230108', 'POCOLLAY                      '),
	('230109', 'SAMA                          '),
	('230110', 'CRL. GREG. ALBARRACIN LANCHIPA'),
	('230201', 'CANDARAVE                     '),
	('230202', 'CAIRANI                       '),
	('230203', 'CAMILACA                      '),
	('230204', 'CURIBAYA                      '),
	('230205', 'HUANUARA                      '),
	('230206', 'QUILAHUANI                    '),
	('230301', 'LOCUMBA                       '),
	('230302', 'ILABAYA                       '),
	('230303', 'ITE                           '),
	('230401', 'TARATA                        '),
	('230402', 'CHUCATAMANI                   '),
	('230403', 'ESTIQUE                       '),
	('230404', 'ESTIQUE-PAMPA                 '),
	('230405', 'SITAJARA                      '),
	('230406', 'SUSAPAYA                      '),
	('230407', 'TARUCACHI                     '),
	('230408', 'TICACO                        '),
	('240101', 'TUMBES                        '),
	('240102', 'CORRALES                      '),
	('240103', 'LA CRUZ                       '),
	('240104', 'PAMPAS DE HOSPITAL            '),
	('240105', 'SAN JACINTO                   '),
	('240106', 'SAN JUAN DE LA VIRGEN         '),
	('240201', 'ZORRITOS                      '),
	('240202', 'CASITAS                       '),
	('240301', 'ZARUMILLA                     '),
	('240302', 'AGUAS VERDES                  '),
	('240303', 'MATAPALO                      '),
	('240304', 'PAPAYAL                       '),
	('250100', 'MANANTAY'),
	('250101', 'CALLERIA                      '),
	('250102', 'CAMPOVERDE                    '),
	('250103', 'IPARIA                        '),
	('250104', 'MASISEA                       '),
	('250105', 'YARINACOCHA                   '),
	('250106', 'NUEVA REQUENA                 '),
	('250201', 'RAYMONDI                      '),
	('250202', 'SEPAHUA                       '),
	('250203', 'TAHUANIA                      '),
	('250204', 'YURUA                         '),
	('250301', 'PADRE ABAD                    '),
	('250302', 'IRAZOLA                       '),
	('250303', 'CURIMANA                      '),
	('250401', 'PURUS                         ');

-- Volcando estructura para tabla notariatambini.distritos
CREATE TABLE IF NOT EXISTS `distritos` (
  `s_codigo` char(6) NOT NULL,
  `s_nombre` varchar(50) DEFAULT NULL,
  `s_provi` char(6) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.distritos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.documentos_caja
CREATE TABLE IF NOT EXISTS `documentos_caja` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(50) DEFAULT NULL,
  `s_abrev` varchar(6) DEFAULT NULL,
  `s_serie` varchar(7) DEFAULT NULL,
  `s_impresora` varchar(100) DEFAULT NULL,
  `i_tipoComprobanteFe` int DEFAULT '0',
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.documentos_caja: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.documento_notariales
CREATE TABLE IF NOT EXISTS `documento_notariales` (
  `s_codigo` char(6) NOT NULL,
  `s_nombre` varchar(50) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.documento_notariales: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `s_codigo` char(10) NOT NULL,
  `s_nombre` varchar(250) DEFAULT NULL,
  `s_tip_doc` varchar(8) DEFAULT NULL,
  `s_num_doc` varchar(20) DEFAULT NULL,
  `i_nacionalidad` int DEFAULT '0',
  `s_localidad` varchar(100) DEFAULT NULL,
  `s_direccion` varchar(500) DEFAULT NULL,
  `s_referencia` varchar(250) DEFAULT NULL,
  `s_email` varchar(100) DEFAULT NULL,
  `s_web` varchar(70) DEFAULT NULL,
  `s_telefono` varchar(50) DEFAULT NULL,
  `s_celular` varchar(50) DEFAULT NULL,
  `s_oficina` char(5) DEFAULT NULL,
  `s_partida` varchar(20) DEFAULT NULL,
  `s_registro` char(2) DEFAULT NULL,
  `s_ciiu` varchar(6) DEFAULT NULL,
  `s_objeto_social` varchar(250) DEFAULT NULL,
  `s_anotacion` varchar(255) DEFAULT NULL,
  `s_pass` varchar(30) DEFAULT NULL,
  `d_fecha_reg` datetime DEFAULT NULL,
  `s_personal_reg` varchar(12) DEFAULT NULL,
  `d_fecha_mod` datetime DEFAULT NULL,
  `s_personal_mod` varchar(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `Numero` (`s_codigo`),
  KEY `DOCUMENTO` (`s_num_doc`),
  KEY `s_codigo` (`s_codigo`),
  KEY `codigo_empresa` (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.empresa: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.empresa_web
CREATE TABLE IF NOT EXISTS `empresa_web` (
  `s_codigo` varchar(12) NOT NULL,
  `s_num_doc` varchar(12) DEFAULT NULL,
  `s_nombre` varchar(250) DEFAULT NULL,
  `s_partida` varchar(20) DEFAULT NULL,
  `s_localidad` varchar(100) DEFAULT NULL,
  `s_direccion` varchar(500) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.empresa_web: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.enlazar_documentos
CREATE TABLE IF NOT EXISTS `enlazar_documentos` (
  `s_codigo` varchar(12) NOT NULL,
  `s_documento` varchar(12) DEFAULT NULL,
  `s_orden` varchar(12) DEFAULT NULL,
  `s_tramite` varchar(12) DEFAULT NULL,
  `de_monto_not` decimal(9,2) DEFAULT '0.00',
  `de_monto_reg` decimal(9,2) DEFAULT '0.00',
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.enlazar_documentos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.entrada_producto
CREATE TABLE IF NOT EXISTS `entrada_producto` (
  `s_codigo` char(12) NOT NULL,
  `s_atendido` char(8) DEFAULT NULL,
  `s_usuario` varchar(12) DEFAULT NULL,
  `s_documento` char(12) DEFAULT NULL,
  `s_numero` varchar(50) DEFAULT NULL,
  `s_fecha` date DEFAULT NULL,
  `s_hora` varchar(10) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.entrada_producto: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.entrada_servicio
CREATE TABLE IF NOT EXISTS `entrada_servicio` (
  `s_codigo` char(12) NOT NULL,
  `s_atendido` char(8) DEFAULT NULL,
  `s_usuario` varchar(12) DEFAULT NULL,
  `s_documento` char(12) DEFAULT NULL,
  `s_numero` varchar(50) DEFAULT NULL,
  `s_fecha` date DEFAULT NULL,
  `s_hora` varchar(10) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.entrada_servicio: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.entrega_documento
CREATE TABLE IF NOT EXISTS `entrega_documento` (
  `i_codigo` int unsigned NOT NULL AUTO_INCREMENT,
  `s_oc` varchar(45) NOT NULL,
  `s_dni` varchar(255) NOT NULL,
  `s_cliente` varchar(255) NOT NULL,
  `s_situacion` varchar(255) NOT NULL,
  `s_servicio` varchar(255) NOT NULL,
  `s_detalle` varchar(255) DEFAULT '',
  `s_observacion` varchar(255) DEFAULT NULL,
  `s_firma` longtext NOT NULL,
  `d_fecha_reg` datetime DEFAULT NULL,
  `s_personal` varchar(255) DEFAULT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=21901 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.entrega_documento: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.envios_banco
CREATE TABLE IF NOT EXISTS `envios_banco` (
  `s_codigo` varchar(6) NOT NULL,
  `s_personal` varchar(8) NOT NULL,
  `d_fecha` date NOT NULL,
  `s_hora` varchar(12) NOT NULL,
  `s_monto` varchar(45) NOT NULL,
  `s_moneda` varchar(45) NOT NULL,
  `s_autorizado` varchar(8) NOT NULL,
  `d_fecha_autorizacion` date NOT NULL,
  `i_cuenta` int DEFAULT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.envios_banco: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.estado
CREATE TABLE IF NOT EXISTS `estado` (
  `i_codigo` int NOT NULL,
  `s_codigo_sbs` varchar(5) DEFAULT NULL,
  `s_tipo` int DEFAULT NULL,
  `s_desc` varchar(255) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.estado: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.estado_kardex
CREATE TABLE IF NOT EXISTS `estado_kardex` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `s_nombre` varchar(200) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.estado_kardex: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.failed_jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.fechas_mantenimiento
CREATE TABLE IF NOT EXISTS `fechas_mantenimiento` (
  `s_codigo` char(12) NOT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_observacion` varchar(250) DEFAULT NULL,
  `de_tipoc_compra` decimal(9,2) DEFAULT NULL,
  `de_tipoc_venta` decimal(9,2) DEFAULT NULL,
  `i_estadofecha` int unsigned DEFAULT NULL,
  `i_estado` int unsigned DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.fechas_mantenimiento: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.firmarepresentacion
CREATE TABLE IF NOT EXISTS `firmarepresentacion` (
  `s_codigo` char(12) NOT NULL,
  `s_representado` char(12) DEFAULT NULL,
  `s_cliente` char(10) DEFAULT NULL,
  `s_observacion` varchar(255) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.firmarepresentacion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.firmas
CREATE TABLE IF NOT EXISTS `firmas` (
  `s_codigo` char(12) NOT NULL,
  `s_cliente` char(10) DEFAULT NULL,
  `d_fechaRegistro` date DEFAULT NULL,
  `s_proceder` varchar(255) DEFAULT NULL,
  `d_caducidad` date DEFAULT NULL,
  `s_atendido` char(8) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.firmas: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.firmas_legalizadas
CREATE TABLE IF NOT EXISTS `firmas_legalizadas` (
  `s_codigo` char(12) NOT NULL,
  `s_firmas` char(12) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` char(12) DEFAULT NULL,
  `s_atendido` char(8) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.firmas_legalizadas: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.firmatemporales
CREATE TABLE IF NOT EXISTS `firmatemporales` (
  `s_codigo` char(10) NOT NULL,
  `s_numero` varchar(15) DEFAULT NULL,
  `s_paterno` varchar(30) DEFAULT NULL,
  `s_materno` varchar(30) DEFAULT NULL,
  `s_nombre` varchar(30) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(15) DEFAULT NULL,
  `s_atendido` char(8) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  `s_documento` char(5) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.firmatemporales: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.foliador
CREATE TABLE IF NOT EXISTS `foliador` (
  `numero` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.foliador: 0 rows
/*!40000 ALTER TABLE `foliador` DISABLE KEYS */;
/*!40000 ALTER TABLE `foliador` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.formatos_texto
CREATE TABLE IF NOT EXISTS `formatos_texto` (
  `s_codigo` char(12) NOT NULL,
  `s_descripcion` blob,
  `i_tipo` int unsigned DEFAULT NULL,
  `s_otros` varchar(100) DEFAULT NULL,
  `i_estado` int unsigned DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.formatos_texto: ~0 rows (aproximadamente)

 
-- Volcando datos para la tabla notariatambini.fuera_registro: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.gastos_caja
CREATE TABLE IF NOT EXISTS `gastos_caja` (
  `s_codigo` char(12) NOT NULL,
  `s_prestado` char(12) DEFAULT NULL,
  `s_atendido` char(12) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `d_precio` decimal(9,2) DEFAULT NULL,
  `s_moneda` char(5) DEFAULT NULL,
  `s_descripcion` varchar(253) DEFAULT NULL,
  `d_fecha_reg` date DEFAULT NULL,
  `s_hora` varchar(15) DEFAULT NULL,
  `i_tipogasto` int DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.gastos_caja: 0 rows
/*!40000 ALTER TABLE `gastos_caja` DISABLE KEYS */;
/*!40000 ALTER TABLE `gastos_caja` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.genericos
CREATE TABLE IF NOT EXISTS `genericos` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(50) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.genericos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.hijos
CREATE TABLE IF NOT EXISTS `hijos` (
  `s_codigo` varchar(12) NOT NULL,
  `s_nombres` varchar(60) DEFAULT NULL,
  `s_apepaterno` varchar(60) DEFAULT NULL,
  `s_apematerno` varchar(60) DEFAULT NULL,
  `d_fecha_nac` date DEFAULT NULL,
  `s_edad` varchar(3) DEFAULT NULL,
  `s_tipodoc` varchar(5) DEFAULT NULL,
  `s_numdoc` varchar(20) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.hijos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.historial_kardex
CREATE TABLE IF NOT EXISTS `historial_kardex` (
  `s_codigo` char(12) NOT NULL,
  `s_kardex` char(12) DEFAULT NULL,
  `b_mensaje` blob,
  `s_usuario` char(10) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(20) DEFAULT NULL,
  `s_nombre_adjunto` varchar(250) DEFAULT NULL,
  `i_estado` int unsigned DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.historial_kardex: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.historial_kardex_adjunto
CREATE TABLE IF NOT EXISTS `historial_kardex_adjunto` (
  `s_codigo` char(12) NOT NULL DEFAULT '',
  `s_historial` char(12) NOT NULL,
  `s_nombre` varchar(250) DEFAULT NULL,
  `i_estado` int unsigned DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.historial_kardex_adjunto: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.historicoenviopdf
CREATE TABLE IF NOT EXISTS `historicoenviopdf` (
  `i_codigo` int unsigned NOT NULL AUTO_INCREMENT,
  `s_CodigoRecibo` varchar(45) NOT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=12866 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.historicoenviopdf: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.inmueble_web
CREATE TABLE IF NOT EXISTS `inmueble_web` (
  `s_codigo` char(12) NOT NULL,
  `s_localidad` varchar(10) DEFAULT NULL,
  `s_partida_registral` text,
  `s_direccion` varchar(100) DEFAULT NULL,
  `s_referencia` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.inmueble_web: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.insertos
CREATE TABLE IF NOT EXISTS `insertos` (
  `s_codigo` char(8) NOT NULL,
  `s_nombre` varchar(50) DEFAULT NULL,
  `s_descripcion` varchar(250) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.insertos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.interes
CREATE TABLE IF NOT EXISTS `interes` (
  `s_codigo` varchar(12) NOT NULL,
  `s_recibo` varchar(12) DEFAULT NULL,
  `s_nombre` varchar(120) DEFAULT NULL,
  `de_pago` decimal(9,2) DEFAULT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.interes: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.interviniente
CREATE TABLE IF NOT EXISTS `interviniente` (
  `s_codigo` char(12) NOT NULL,
  `s_kardex` char(12) DEFAULT NULL,
  `i_grupo` int DEFAULT NULL,
  `i_item` int DEFAULT NULL,
  `s_compareciente` char(10) DEFAULT NULL,
  `s_proceder` varchar(50) DEFAULT NULL,
  `s_tipo` char(5) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(20) DEFAULT NULL,
  `s_personal` char(10) DEFAULT NULL,
  `i_indice` int DEFAULT NULL,
  `i_pdt` int DEFAULT NULL,
  `i_foto` int DEFAULT '0',
  `i_firma` int DEFAULT NULL,
  `d_fechfirma` date DEFAULT NULL,
  `s_hora_firma` varchar(20) DEFAULT NULL,
  `s_tomador` char(8) DEFAULT NULL,
  `i_lugar_firma` int DEFAULT '0',
  `s_lugar_firma` varchar(255) DEFAULT NULL,
  `s_rol_participacion` varchar(5) DEFAULT NULL,
  `s_casado` varchar(12) DEFAULT NULL,
  `i_separacion_bienes` int DEFAULT '0',
  `s_oficina_reg` varchar(5) DEFAULT NULL,
  `s_registro` varchar(5) DEFAULT NULL,
  `s_partida` varchar(25) DEFAULT NULL,
  `i_inscrito` int DEFAULT NULL,
  `s_representa` varchar(12) DEFAULT NULL,
  `s_oficina_rep` varchar(5) DEFAULT NULL,
  `s_registro_rep` varchar(5) DEFAULT NULL,
  `s_partida_rep` varchar(25) DEFAULT NULL,
  `s_porcentaje` varchar(5) DEFAULT NULL,
  `s_origen_fondo` varchar(255) DEFAULT NULL,
  `s_moneda` varchar(5) DEFAULT NULL,
  `de_monto` decimal(12,2) DEFAULT NULL,
  `s_renta_terc` varchar(255) DEFAULT NULL,
  `s_casa_enaj` varchar(255) DEFAULT NULL,
  `s_imp_cero` varchar(255) DEFAULT NULL,
  `s_ope_1662` varchar(255) DEFAULT NULL,
  `s_pago_2cat` varchar(255) DEFAULT NULL,
  `s_operacion` varchar(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `Numero` (`s_kardex`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.interviniente: 0 rows
/*!40000 ALTER TABLE `interviniente` DISABLE KEYS */;
/*!40000 ALTER TABLE `interviniente` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.interviniente_minuta_web
CREATE TABLE IF NOT EXISTS `interviniente_minuta_web` (
  `s_codigo` char(12) NOT NULL,
  `s_codigo_datos_web` char(12) DEFAULT NULL,
  `s_compareciente` char(10) DEFAULT NULL,
  `s_tipo_comparecientes` char(6) DEFAULT NULL,
  `s_proceder` varchar(50) DEFAULT NULL,
  `d_fechaing` datetime DEFAULT NULL,
  `s_Horaing` varchar(12) DEFAULT NULL,
  `s_dir_doc` text,
  `s_cargo` text,
  `i_estado` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.interviniente_minuta_web: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.kardex
CREATE TABLE IF NOT EXISTS `kardex` (
  `s_codigo` char(12) NOT NULL,
  `s_tipokardex` char(2) DEFAULT NULL,
  `s_kardex` varchar(10) DEFAULT NULL,
  `s_actnot` char(6) DEFAULT NULL,
  `s_compareciente` char(12) DEFAULT NULL,
  `s_referente` char(10) DEFAULT NULL,
  `s_facturar` char(10) DEFAULT NULL,
  `d_feching` varchar(10) DEFAULT NULL,
  `s_horaing` varchar(12) DEFAULT NULL,
  `s_atendido` char(10) DEFAULT NULL,
  `s_responsable` varchar(12) DEFAULT NULL,
  `s_digitado` char(10) DEFAULT NULL,
  `d_fecha_digitado` datetime DEFAULT NULL,
  `s_impreso` char(10) DEFAULT NULL,
  `d_fecha_impreso` datetime DEFAULT NULL,
  `s_confrontador` varchar(12) DEFAULT NULL,
  `s_confrontador_seg` varchar(12) DEFAULT NULL,
  `d_fecha_confrontado` datetime DEFAULT NULL,
  `d_fechcalificada` varchar(10) DEFAULT NULL,
  `d_fechminuta` varchar(10) DEFAULT NULL,
  `i_numminuta` varchar(10) DEFAULT NULL,
  `i_minuta_usuario` int DEFAULT '0',
  `d_fechescritura` varchar(10) DEFAULT NULL,
  `i_numescritura` int DEFAULT NULL,
  `s_opcion_escritura` varchar(10) DEFAULT NULL,
  `d_fechparte` varchar(20) DEFAULT NULL,
  `s_personal_parte` varchar(12) DEFAULT NULL,
  `d_fechtestimonio` varchar(20) DEFAULT NULL,
  `s_personal_testimonio` varchar(12) DEFAULT NULL,
  `s_kardexconex` char(12) DEFAULT NULL,
  `s_abogado` char(7) DEFAULT NULL,
  `s_personal_abogado` varchar(12) DEFAULT NULL,
  `d_fecha_abogado` datetime DEFAULT NULL,
  `s_anno` varchar(12) DEFAULT NULL,
  `i_numfol` int unsigned DEFAULT NULL,
  `i_folini` int unsigned DEFAULT NULL,
  `i_foliniV` int DEFAULT NULL,
  `i_folfin` int unsigned DEFAULT NULL,
  `i_folfinV` int DEFAULT NULL,
  `i_serini` int unsigned DEFAULT NULL,
  `i_serieiniV` int DEFAULT NULL,
  `i_serfin` int unsigned DEFAULT NULL,
  `i_seriefinV` int DEFAULT NULL,
  `s_numtom` varchar(12) DEFAULT NULL,
  `s_numreg` varchar(12) DEFAULT NULL,
  `i_numeroOperacion` varchar(20) DEFAULT NULL,
  `s_obstitulo` varchar(255) DEFAULT NULL,
  `s_tipo_tramite` varchar(30) DEFAULT NULL,
  `s_num_solicitud` varchar(10) DEFAULT NULL,
  `d_fecha_solicitud` varchar(10) DEFAULT NULL,
  `i_estadonota` varchar(5) DEFAULT NULL,
  `d_fechbajakardex` varchar(10) DEFAULT NULL,
  `s_personal_baja` varchar(12) DEFAULT NULL,
  `i_sisgen` int DEFAULT '0',
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `index_s_kardex` (`s_kardex`),
  KEY `codigo` (`s_codigo`),
  KEY `idx_kardex_01` (`d_feching`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.kardex: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.libros
CREATE TABLE IF NOT EXISTS `libros` (
  `s_libro` int unsigned NOT NULL AUTO_INCREMENT,
  `s_codigo` char(12) DEFAULT NULL,
  `s_actonotarial` varchar(6) DEFAULT NULL,
  `s_registro` int DEFAULT NULL,
  `d_fecha_apertura` date DEFAULT NULL,
  `s_hora_apertura` varchar(15) DEFAULT NULL,
  `d_fecha_cierre` date DEFAULT NULL,
  `s_observacion` varchar(250) DEFAULT NULL,
  `s_tipolibro` varchar(10) DEFAULT NULL,
  `s_denominacion` varchar(1000) DEFAULT NULL,
  `s_numero_libro` varchar(50) DEFAULT NULL,
  `s_forma` varchar(50) DEFAULT NULL,
  `s_folios` varchar(20) DEFAULT NULL,
  `s_cantidad` int DEFAULT NULL,
  `s_precio` decimal(9,2) DEFAULT NULL,
  `i_tipopago` int unsigned DEFAULT NULL,
  `s_cliente` char(10) DEFAULT NULL,
  `s_empresa` char(10) DEFAULT NULL,
  `s_facturar` char(10) DEFAULT NULL,
  `s_representante` varchar(12) DEFAULT NULL,
  `s_atendido` char(10) DEFAULT NULL,
  `s_personal_entrega` char(10) DEFAULT NULL,
  `s_hora_entrega` varchar(20) DEFAULT NULL,
  `d_fecha_entrega` date DEFAULT NULL,
  `s_entregado` char(10) DEFAULT NULL,
  `i_imprime` int DEFAULT NULL,
  `i_sisgen` varchar(1) DEFAULT '0',
  `i_estado` int unsigned DEFAULT NULL,
  PRIMARY KEY (`s_libro`),
  KEY `index_libros` (`s_libro`),
  KEY `Numero` (`s_libro`),
  KEY `idx_libros_01` (`d_fecha_apertura`)
) ENGINE=MyISAM AUTO_INCREMENT=147024 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.libros: 0 rows
/*!40000 ALTER TABLE `libros` DISABLE KEYS */;
/*!40000 ALTER TABLE `libros` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.libros_w
CREATE TABLE IF NOT EXISTS `libros_w` (
  `s_codigo` varchar(12) NOT NULL,
  `s_representante` varchar(12) DEFAULT NULL,
  `s_empresa` varchar(12) DEFAULT NULL,
  `s_observacion` varchar(255) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.libros_w: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.libros_web
CREATE TABLE IF NOT EXISTS `libros_web` (
  `s_libro` int NOT NULL,
  `s_codigo` char(12) DEFAULT NULL,
  `s_actonotarial` varchar(6) DEFAULT NULL,
  `s_registro` int DEFAULT NULL,
  `d_fecha_apertura` date DEFAULT NULL,
  `s_hora_apertura` varchar(15) DEFAULT NULL,
  `d_fecha_cierre` date DEFAULT NULL,
  `s_observacion` varchar(250) DEFAULT NULL,
  `s_tipolibro` varchar(10) DEFAULT NULL,
  `s_denominacion` varchar(250) DEFAULT NULL,
  `s_numero_libro` varchar(50) DEFAULT NULL,
  `s_forma` varchar(50) DEFAULT NULL,
  `s_folios` varchar(20) DEFAULT NULL,
  `s_cantidad` int DEFAULT NULL,
  `s_precio` decimal(9,2) DEFAULT NULL,
  `i_tipopago` int DEFAULT NULL,
  `s_cliente` char(10) DEFAULT NULL,
  `s_empresa` char(10) DEFAULT NULL,
  `s_facturar` char(10) DEFAULT NULL,
  `s_atendido` char(10) DEFAULT NULL,
  `s_personal_entrega` char(10) DEFAULT NULL,
  `s_hora_entrega` varchar(20) DEFAULT NULL,
  `d_fecha_entrega` date DEFAULT NULL,
  `s_entregado` char(10) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  `s_dir_doc` text,
  PRIMARY KEY (`s_libro`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.libros_web: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.libro_orden
CREATE TABLE IF NOT EXISTS `libro_orden` (
  `s_codigo` char(12) NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.libro_orden: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.listo
CREATE TABLE IF NOT EXISTS `listo` (
  `s_codigo` char(12) NOT NULL,
  `s_kardex` char(12) DEFAULT NULL,
  `s_titulo` varchar(15) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_area` varchar(30) DEFAULT NULL,
  `s_oficina` varchar(30) DEFAULT NULL,
  `s_estadoR` varchar(30) DEFAULT NULL,
  `de_pago` decimal(12,2) DEFAULT NULL,
  `s_personal` char(8) DEFAULT NULL,
  `s_partida` varchar(30) DEFAULT NULL,
  `s_asiento` varchar(30) DEFAULT NULL,
  `i_estado` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.listo: 0 rows
/*!40000 ALTER TABLE `listo` DISABLE KEYS */;
/*!40000 ALTER TABLE `listo` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.logeados
CREATE TABLE IF NOT EXISTS `logeados` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `s_personal` char(8) DEFAULT NULL,
  `s_ip` varchar(20) DEFAULT NULL,
  `s_nombre_pc` varchar(80) DEFAULT NULL,
  `s_usuario` varchar(12) DEFAULT NULL,
  `d_fecha_acceso` datetime DEFAULT NULL,
  `d_fecha_salida` datetime DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=181810 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.logeados: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.log_accesos
CREATE TABLE IF NOT EXISTS `log_accesos` (
  `codigo` int unsigned NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=213526 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.log_accesos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.medios_pagos
CREATE TABLE IF NOT EXISTS `medios_pagos` (
  `s_codigo` char(12) NOT NULL,
  `s_kardex` char(12) DEFAULT NULL,
  `s_codOperacion` varchar(12) DEFAULT NULL,
  `i_mediopago` int DEFAULT NULL,
  `s_medioPago` char(5) DEFAULT NULL,
  `s_numeroCuenta` varchar(50) DEFAULT NULL,
  `s_banco` char(5) DEFAULT NULL,
  `d_fechaPago` date DEFAULT NULL,
  `s_moneda` varchar(10) DEFAULT NULL,
  `s_tipocambio` varchar(5) DEFAULT NULL,
  `de_monto` decimal(12,2) DEFAULT NULL,
  `s_observacion` varchar(255) DEFAULT NULL,
  `s_codigo_sbs` varchar(3) DEFAULT NULL,
  `s_forma_pago` varchar(5) DEFAULT NULL,
  `s_tipo_instrumento` varchar(3) DEFAULT NULL,
  `s_origen_fondos` varchar(200) DEFAULT NULL,
  `s_descripcion_fondo` varchar(250) DEFAULT NULL,
  `s_bancodest` varchar(5) DEFAULT NULL,
  `s_numeroCuentadest` varchar(50) DEFAULT NULL,
  `s_nombredest` varchar(255) DEFAULT NULL,
  `s_operacion` varchar(45) DEFAULT NULL,
  `s_personalreg` varchar(12) DEFAULT NULL,
  `d_fechareg` datetime DEFAULT NULL,
  `s_personalMod` varchar(12) DEFAULT NULL,
  `d_fechaMod` datetime DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.medios_pagos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.medio_pago_caja
CREATE TABLE IF NOT EXISTS `medio_pago_caja` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(150) DEFAULT NULL,
  `s_descripcion` varchar(255) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.medio_pago_caja: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.mensaje
CREATE TABLE IF NOT EXISTS `mensaje` (
  `i_codigo` int NOT NULL,
  `s_titulo` varchar(200) DEFAULT NULL,
  `s_ruta` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.mensaje: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.meta_primaria
CREATE TABLE IF NOT EXISTS `meta_primaria` (
  `s_codigo` varchar(12) NOT NULL,
  `s_area` varchar(12) DEFAULT NULL,
  `s_asesor` varchar(12) DEFAULT NULL,
  `s_annio` varchar(12) DEFAULT NULL,
  `s_descripcion` varchar(255) DEFAULT NULL,
  `de_monto` decimal(9,2) DEFAULT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.meta_primaria: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.meta_seccion
CREATE TABLE IF NOT EXISTS `meta_seccion` (
  `s_codigo` varchar(12) NOT NULL,
  `s_seccion` varchar(12) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_area` varchar(12) DEFAULT NULL,
  `s_asesor` varchar(12) DEFAULT NULL,
  `de_monto` decimal(9,2) DEFAULT NULL,
  `s_factura` varchar(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.meta_seccion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.migrations: ~0 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_100000_create_password_resets_table', 1),
	(2, '2019_08_19_000000_create_failed_jobs_table', 1),
	(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(4, '2014_10_12_000000_create_users_table', 2);

-- Volcando estructura para tabla notariatambini.mitabla
CREATE TABLE IF NOT EXISTS `mitabla` (
  `id` int DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.mitabla: 0 rows
/*!40000 ALTER TABLE `mitabla` DISABLE KEYS */;
/*!40000 ALTER TABLE `mitabla` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.mitabla_log
CREATE TABLE IF NOT EXISTS `mitabla_log` (
  `id` int DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.mitabla_log: 0 rows
/*!40000 ALTER TABLE `mitabla_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `mitabla_log` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.mobiliaria_web
CREATE TABLE IF NOT EXISTS `mobiliaria_web` (
  `s_codigo` char(12) NOT NULL,
  `s_datos` char(12) DEFAULT NULL,
  `i_tipo` int DEFAULT NULL,
  `s_numero` varchar(30) DEFAULT NULL,
  `s_clase` varchar(50) DEFAULT NULL,
  `s_marca` varchar(50) DEFAULT NULL,
  `s_ano` char(4) DEFAULT NULL,
  `s_modelo` varchar(50) DEFAULT NULL,
  `s_serie` varchar(50) DEFAULT NULL,
  `s_color` varchar(30) DEFAULT NULL,
  `s_carroceria` varchar(30) DEFAULT NULL,
  `s_motor` varchar(50) DEFAULT NULL,
  `s_dir_doc` text,
  `s_tar_doc` text,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.mobiliaria_web: 0 rows
/*!40000 ALTER TABLE `mobiliaria_web` DISABLE KEYS */;
/*!40000 ALTER TABLE `mobiliaria_web` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.modelo
CREATE TABLE IF NOT EXISTS `modelo` (
  `s_codigo` varchar(12) NOT NULL,
  `s_nombre` varchar(255) DEFAULT NULL,
  `s_modelo` varchar(1000) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.modelo: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.modelo_telefonica
CREATE TABLE IF NOT EXISTS `modelo_telefonica` (
  `s_codigo` char(10) NOT NULL,
  `d_fechareg` date DEFAULT NULL,
  `i_tipomodelo` int DEFAULT NULL,
  `s_compareciente` char(10) DEFAULT NULL,
  `s_codigotelf` varchar(12) DEFAULT NULL,
  `s_acciones` varchar(12) DEFAULT NULL,
  `s_certificado` varchar(12) DEFAULT NULL,
  `s_otorgado` char(10) DEFAULT NULL,
  `s_usuario` char(8) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.modelo_telefonica: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.modopago
CREATE TABLE IF NOT EXISTS `modopago` (
  `i_codigo` int NOT NULL,
  `s_codigo_pdt` varchar(5) DEFAULT NULL,
  `s_codigo_sbs` varchar(2) DEFAULT NULL,
  `s_nombre` varchar(120) DEFAULT NULL,
  `s_descripcion` varchar(150) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.modopago: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.moneda
CREATE TABLE IF NOT EXISTS `moneda` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(25) DEFAULT NULL,
  `s_descripcion` varchar(150) DEFAULT NULL,
  `s_Abreviatura` varchar(5) DEFAULT NULL,
  `s_simbolo` char(2) DEFAULT NULL,
  `s_codigo_sbs` varchar(3) DEFAULT NULL,
  `i_monedaFe` int DEFAULT '0',
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.moneda: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.movimiento
CREATE TABLE IF NOT EXISTS `movimiento` (
  `s_codigo` varchar(5) NOT NULL,
  `s_nombre` varchar(60) DEFAULT NULL,
  `s_descripcion` varchar(120) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.movimiento: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.nacionalidad
CREATE TABLE IF NOT EXISTS `nacionalidad` (
  `s_codigo` char(5) NOT NULL,
  `s_pais` varchar(50) DEFAULT NULL,
  `s_gentilicio` varchar(50) DEFAULT NULL,
  `s_codigo_sbs` varchar(3) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.nacionalidad: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.notario
CREATE TABLE IF NOT EXISTS `notario` (
  `s_codigo` char(10) NOT NULL,
  `s_tipodoc` char(5) DEFAULT NULL,
  `s_numdoc` varchar(11) DEFAULT NULL,
  `s_paterno` varchar(50) DEFAULT NULL,
  `s_materno` varchar(50) DEFAULT NULL,
  `s_nombres` varchar(100) DEFAULT NULL,
  `s_cargo` varchar(200) DEFAULT NULL,
  `s_sexo` char(1) DEFAULT NULL,
  `s_telefonos` varchar(60) DEFAULT NULL,
  `s_observacion` varchar(250) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.notario: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.no_corre
CREATE TABLE IF NOT EXISTS `no_corre` (
  `s_codigo` char(12) NOT NULL,
  `s_tipokardex` char(2) DEFAULT NULL,
  `s_kardex` varchar(10) DEFAULT NULL,
  `d_feching` varchar(10) DEFAULT NULL,
  `d_fechescritura` varchar(10) DEFAULT NULL,
  `i_numescritura` int DEFAULT NULL,
  `s_nombre` varchar(250) DEFAULT NULL,
  `i_numminuta` int DEFAULT NULL,
  `i_serini` int unsigned DEFAULT NULL,
  `i_serieiniV` int DEFAULT NULL,
  `i_serfin` int DEFAULT NULL,
  `i_serfinV` int DEFAULT NULL,
  `i_folini` int unsigned DEFAULT NULL,
  `i_foliniV` int DEFAULT NULL,
  `i_folfin` int DEFAULT NULL,
  `i_folfinV` int DEFAULT NULL,
  `s_observacion` varchar(250) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.no_corre: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.numeracion_car
CREATE TABLE IF NOT EXISTS `numeracion_car` (
  `fecha` varchar(255) DEFAULT NULL,
  `numeracion` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.numeracion_car: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.observacion_kardex
CREATE TABLE IF NOT EXISTS `observacion_kardex` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `s_kardex` char(12) NOT NULL,
  `i_tipo` int DEFAULT NULL,
  `s_observacion` varchar(900) DEFAULT NULL,
  `s_area` varchar(255) DEFAULT NULL,
  `i_envio` int DEFAULT '0',
  `s_personal` char(8) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`),
  KEY `idx_onbservacion_01` (`s_kardex`,`i_estado`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=666406 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.observacion_kardex: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.oficina_registral
CREATE TABLE IF NOT EXISTS `oficina_registral` (
  `s_codigo` char(5) NOT NULL,
  `s_codigo_sbs` varchar(2) DEFAULT NULL,
  `s_nombre` varchar(50) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.oficina_registral: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.ofi_licencia
CREATE TABLE IF NOT EXISTS `ofi_licencia` (
  `i_codigo` varchar(12) NOT NULL,
  `s_tipo` varchar(45) NOT NULL,
  `d_fecha` date NOT NULL,
  `s_num` varchar(45) NOT NULL,
  `d_fech_ini` date NOT NULL,
  `d_fech_fin` date NOT NULL,
  `s_personal` varchar(45) NOT NULL,
  `d_fech_reg` datetime NOT NULL,
  `i_estado` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.ofi_licencia: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.ofi_poder
CREATE TABLE IF NOT EXISTS `ofi_poder` (
  `i_codigo` varchar(12) NOT NULL,
  `s_tipo` varchar(45) NOT NULL,
  `d_fecha` date NOT NULL,
  `s_nombre` varchar(45) NOT NULL,
  `s_dni` varchar(45) NOT NULL,
  `s_observacion` varchar(255) NOT NULL,
  `s_personal` varchar(45) NOT NULL,
  `d_fecha_reg` datetime NOT NULL,
  `i_estado` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.ofi_poder: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.operaciones
CREATE TABLE IF NOT EXISTS `operaciones` (
  `s_codigo` varchar(12) NOT NULL,
  `s_kardex` varchar(12) DEFAULT NULL,
  `s_actoJuridico` varchar(12) DEFAULT NULL,
  `de_monto` decimal(14,2) DEFAULT NULL,
  `s_moneda` varchar(5) DEFAULT NULL,
  `d_fechaMinuta` date DEFAULT NULL,
  `s_personalreg` varchar(12) DEFAULT NULL,
  `d_fechareg` datetime DEFAULT NULL,
  `s_personalMod` varchar(12) DEFAULT NULL,
  `d_fechaMod` datetime DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.operaciones: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.ordencaja
CREATE TABLE IF NOT EXISTS `ordencaja` (
  `s_codigo` char(12) NOT NULL,
  `s_referencia` char(12) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(12) DEFAULT NULL,
  `i_situacion` int DEFAULT '266',
  `d_fecha_firma` datetime DEFAULT NULL,
  `d_fecha_entrega` datetime DEFAULT NULL,
  `s_certifica` varchar(255) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.ordencaja: 0 rows
/*!40000 ALTER TABLE `ordencaja` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordencaja` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.orden_compra
CREATE TABLE IF NOT EXISTS `orden_compra` (
  `s_codigo` char(12) NOT NULL,
  `i_numorden` int DEFAULT NULL,
  `s_proveedor` char(12) DEFAULT NULL,
  `i_formapago` int DEFAULT NULL,
  `s_fechaemision` date DEFAULT NULL,
  `s_moneda` char(5) DEFAULT NULL,
  `de_subtotal` decimal(9,2) DEFAULT NULL,
  `de_igv` decimal(9,2) DEFAULT NULL,
  `de_totalgeneral` decimal(9,2) DEFAULT NULL,
  `s_personal` varchar(8) DEFAULT NULL,
  `i_tipoorden` int DEFAULT NULL,
  `s_documento` char(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.orden_compra: 0 rows
/*!40000 ALTER TABLE `orden_compra` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_compra` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.otro_objeto
CREATE TABLE IF NOT EXISTS `otro_objeto` (
  `s_codigo` varchar(12) NOT NULL,
  `s_kardex` varchar(12) DEFAULT NULL,
  `s_descripcion` varchar(45) DEFAULT NULL,
  `i_clase` int unsigned DEFAULT NULL,
  `s_operacion` varchar(12) DEFAULT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.otro_objeto: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.pagos
CREATE TABLE IF NOT EXISTS `pagos` (
  `s_codigo` char(12) NOT NULL,
  `s_recibo` char(12) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_medioPago` varchar(50) DEFAULT NULL,
  `s_detalle` varchar(250) DEFAULT NULL,
  `s_banco` varchar(12) DEFAULT NULL,
  `d_fecha_ope` date DEFAULT NULL,
  `s_numero` varchar(255) DEFAULT NULL,
  `s_moneda` char(5) DEFAULT NULL,
  `s_tipocambio` char(10) DEFAULT NULL,
  `de_importe` decimal(10,2) DEFAULT NULL,
  `de_cobre` decimal(10,2) DEFAULT NULL,
  `d_fecha_cheque` date DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `idx_pagos_01` (`s_recibo`) USING BTREE,
  KEY `idx_pagos_02` (`s_tipocambio`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.pagos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.pagos_web
CREATE TABLE IF NOT EXISTS `pagos_web` (
  `s_codigo` char(12) NOT NULL,
  `s_kardex` char(12) DEFAULT NULL,
  `s_idtransaccion` text,
  `de_pago` decimal(10,4) DEFAULT NULL,
  `de_moneda` varchar(20) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `d_hora` varchar(12) DEFAULT NULL,
  `s_est_pago` varchar(35) DEFAULT NULL,
  `s_email_cliente` varchar(50) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.pagos_web: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.pais
CREATE TABLE IF NOT EXISTS `pais` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `s_cnl` char(3) NOT NULL,
  `s_sbs` varchar(4) DEFAULT NULL,
  `s_nombre` char(52) NOT NULL,
  `s_mas` varchar(60) DEFAULT NULL,
  `s_fem` varchar(60) DEFAULT NULL,
  `i_estado` int DEFAULT '1',
  PRIMARY KEY (`i_codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=243 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.pais: 0 rows
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.paises
CREATE TABLE IF NOT EXISTS `paises` (
  `s_codigo` char(5) NOT NULL DEFAULT '',
  `s_pais` varchar(255) DEFAULT NULL,
  `s_gentilicio_m` varchar(255) DEFAULT NULL,
  `s_gentilicio_f` varchar(255) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.paises: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.participantes
CREATE TABLE IF NOT EXISTS `participantes` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `i_permiso` int DEFAULT NULL,
  `i_condicion` int DEFAULT NULL,
  `s_participante` varchar(12) DEFAULT NULL,
  `i_firma` int DEFAULT NULL COMMENT '0',
  `s_edad` varchar(50) DEFAULT NULL,
  `s_partida` varchar(30) DEFAULT NULL,
  `s_sede_reg` varchar(50) DEFAULT NULL,
  `s_observacion` varchar(255) DEFAULT NULL,
  `d_fecha_reg` datetime DEFAULT NULL,
  `s_personal_reg` varchar(12) DEFAULT NULL,
  `d_fecha_mod` datetime DEFAULT NULL,
  `s_personal_mod` varchar(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=50094 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.participantes: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.password_resets: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.pdt_notarios
CREATE TABLE IF NOT EXISTS `pdt_notarios` (
  `s_codigo` char(12) NOT NULL,
  `s_kardex` char(12) DEFAULT NULL,
  `s_codOperacion` varchar(12) DEFAULT NULL,
  `i_mediopago` int DEFAULT NULL,
  `s_medioPago` char(5) DEFAULT NULL,
  `s_numeroCuenta` varchar(50) DEFAULT NULL,
  `s_banco` char(5) DEFAULT NULL,
  `d_fechaPago` date DEFAULT NULL,
  `s_moneda` varchar(10) DEFAULT NULL,
  `s_tipocambio` varchar(5) DEFAULT NULL,
  `de_monto` decimal(12,2) DEFAULT NULL,
  `s_observacion` varchar(255) DEFAULT NULL,
  `s_codigo_sbs` varchar(3) DEFAULT NULL,
  `s_forma_pago` varchar(5) DEFAULT NULL,
  `s_tipo_instrumento` varchar(3) DEFAULT NULL,
  `s_origen_fondos` varchar(200) DEFAULT NULL,
  `s_descripcion_fondo` varchar(250) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  `s_bancodest` varchar(5) DEFAULT NULL,
  `s_numeroCuentadest` varchar(100) DEFAULT NULL,
  `s_nombredest` varchar(255) DEFAULT NULL,
  `s_operacion` varchar(45) DEFAULT NULL,
  `i_exhibio` int DEFAULT '0',
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.pdt_notarios: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `s_codigo` varchar(12) NOT NULL,
  `s_codusuario` varchar(12) DEFAULT NULL,
  `s_codarea` varchar(5) DEFAULT NULL,
  `d_fechareg` date DEFAULT NULL,
  `s_horareg` varchar(10) DEFAULT NULL,
  `i_entregado` int DEFAULT '0',
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.pedidos: 0 rows
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.pedidos_detalle
CREATE TABLE IF NOT EXISTS `pedidos_detalle` (
  `s_codigo` varchar(12) NOT NULL,
  `s_codpedido` varchar(12) DEFAULT NULL,
  `s_codprod` varchar(12) DEFAULT NULL,
  `i_cant` int DEFAULT NULL,
  `s_observacion` varchar(255) DEFAULT NULL,
  `i_entregado` int DEFAULT '0',
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.pedidos_detalle: 0 rows
/*!40000 ALTER TABLE `pedidos_detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos_detalle` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.permisos
CREATE TABLE IF NOT EXISTS `permisos` (
  `i_codigo` int NOT NULL,
  `s_tipo` varchar(30) DEFAULT NULL,
  `s_descripcion` varchar(60) DEFAULT NULL,
  `i_nivel` int DEFAULT NULL,
  `s_personal` varchar(8) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.permisos: 0 rows
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.permisos_web
CREATE TABLE IF NOT EXISTS `permisos_web` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `d_fechareg` date DEFAULT NULL,
  `i_tipo_viaje` int DEFAULT NULL,
  `s_paternop` varchar(80) DEFAULT NULL,
  `s_maternop` varchar(80) DEFAULT NULL,
  `s_nombresp` varchar(80) DEFAULT NULL,
  `s_tipo_docp` char(5) DEFAULT NULL,
  `s_estado_civilp` varchar(40) DEFAULT NULL,
  `s_numerop` varchar(11) DEFAULT NULL,
  `s_direccionp` varchar(150) DEFAULT NULL,
  `s_distritop` varchar(150) DEFAULT NULL,
  `s_paisp` varchar(150) DEFAULT NULL,
  `s_paternom` varchar(80) DEFAULT NULL,
  `s_maternom` varchar(80) DEFAULT NULL,
  `s_nombresm` varchar(80) DEFAULT NULL,
  `s_tipo_docm` char(5) DEFAULT NULL,
  `s_estado_civilm` varchar(40) DEFAULT NULL,
  `s_numerom` varchar(11) DEFAULT NULL,
  `s_direccionm` varchar(150) DEFAULT NULL,
  `s_distritom` varchar(150) DEFAULT NULL,
  `s_paism` varchar(150) DEFAULT NULL,
  `s_nombre_menor` varchar(100) DEFAULT NULL,
  `s_edad_menor` varchar(50) DEFAULT NULL,
  `s_lugar` varchar(120) DEFAULT NULL,
  `s_pais` varchar(120) DEFAULT NULL,
  `s_duracion` varchar(80) DEFAULT NULL,
  `s_observacion` varchar(250) DEFAULT NULL,
  `s_contacto` varchar(150) DEFAULT NULL,
  `s_telefono` varchar(80) DEFAULT NULL,
  `s_correo` varchar(80) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.permisos_web: 0 rows
/*!40000 ALTER TABLE `permisos_web` DISABLE KEYS */;
/*!40000 ALTER TABLE `permisos_web` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.permiso_viaje
CREATE TABLE IF NOT EXISTS `permiso_viaje` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `d_fecha_ins` date DEFAULT NULL,
  `i_numero` int DEFAULT NULL,
  `i_tipo` int DEFAULT NULL,
  `d_fecha_sal` date DEFAULT NULL,
  `d_fecha_ret` date DEFAULT NULL,
  `s_transporte` varchar(1) DEFAULT NULL,
  `s_linea` varchar(120) DEFAULT NULL,
  `s_ruta` varchar(250) DEFAULT NULL,
  `i_retorno` int DEFAULT NULL,
  `s_observacion` varchar(800) DEFAULT NULL,
  `s_hijo` varchar(250) DEFAULT NULL,
  `s_edad` varchar(200) DEFAULT NULL,
  `i_solo` int DEFAULT '0',
  `s_formato` varchar(12) DEFAULT NULL,
  `d_fecha_reg` datetime DEFAULT NULL,
  `s_personal_reg` varchar(10) DEFAULT NULL,
  `d_fecha_mod` datetime DEFAULT NULL,
  `s_personal_mod` varchar(10) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=44997 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.permiso_viaje: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.permiso_viaje_web
CREATE TABLE IF NOT EXISTS `permiso_viaje_web` (
  `s_codigo` char(12) NOT NULL,
  `i_numero` int DEFAULT NULL,
  `d_fechareg` date DEFAULT NULL,
  `i_tipo` int DEFAULT NULL,
  `s_padre` char(10) DEFAULT NULL,
  `s_firmapadre` varchar(20) DEFAULT NULL,
  `s_madre` char(10) DEFAULT NULL,
  `s_firmamadre` varchar(20) DEFAULT NULL,
  `s_hijo` varchar(200) DEFAULT NULL,
  `s_edad` varchar(200) DEFAULT NULL,
  `s_destino` varchar(200) DEFAULT NULL,
  `s_retorno` int DEFAULT NULL,
  `s_observa` varchar(800) DEFAULT NULL,
  `s_usuario` char(8) DEFAULT NULL,
  `s_dir_doc` text,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.permiso_viaje_web: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.personal
CREATE TABLE IF NOT EXISTS `personal` (
  `s_codigo` varchar(50) NOT NULL DEFAULT '0',
  `s_paterno` varchar(50) DEFAULT NULL,
  `s_materno` varchar(50) DEFAULT NULL,
  `s_nombres` varchar(70) DEFAULT NULL,
  `s_nombre_seg` varchar(70) DEFAULT NULL,
  `s_tipoDocu` char(5) DEFAULT NULL,
  `s_numero` varchar(20) DEFAULT NULL,
  `s_estadoCivil` varchar(30) DEFAULT NULL,
  `d_fechaNacimiento` date DEFAULT NULL,
  `s_sexo` char(1) DEFAULT NULL,
  `s_nacionalidad` varchar(12) DEFAULT NULL,
  `s_distrito` varchar(50) DEFAULT NULL,
  `s_direccion` varchar(100) DEFAULT NULL,
  `s_mail` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `s_telefono` varchar(10) DEFAULT NULL,
  `s_celular` varchar(12) DEFAULT NULL,
  `s_correo_tra` varchar(255) DEFAULT NULL,
  `s_telefono_tra` varchar(50) DEFAULT NULL,
  `s_celular_tra` varchar(50) DEFAULT NULL,
  `s_anexo_tra` varchar(10) DEFAULT NULL,
  `s_observacion` varchar(255) DEFAULT NULL,
  `s_barra` varchar(255) DEFAULT NULL,
  `d_fecha_reg` date DEFAULT NULL,
  `s_personal_reg` varchar(12) DEFAULT NULL,
  `s_user` varchar(20) DEFAULT NULL,
  `s_pass` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `s_frase` varchar(250) DEFAULT NULL,
  `s_foto_fondo` varchar(255) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.personal: ~451 rows (aproximadamente)
INSERT INTO `personal` (`s_codigo`, `s_paterno`, `s_materno`, `s_nombres`, `s_nombre_seg`, `s_tipoDocu`, `s_numero`, `s_estadoCivil`, `d_fechaNacimiento`, `s_sexo`, `s_nacionalidad`, `s_distrito`, `s_direccion`, `s_mail`, `s_telefono`, `s_celular`, `s_correo_tra`, `s_telefono_tra`, `s_celular_tra`, `s_anexo_tra`, `s_observacion`, `s_barra`, `d_fecha_reg`, `s_personal_reg`, `s_user`, `s_pass`, `i_estado`) VALUES

	('PE000935', 'CUEVAS', 'YUPANQUI', 'JOSE RICARDO', '', 'TD001', '45048571', 'SOLTERO', '1988-03-29', 'M', 'N0051', '150132', 'MZ B LT 8 GR 7 CRUZ DE MOTUPE ', 'JCUEVAS@NOTARIATAMBINI.COM', '3925093', '989505453', '', '3925055', '991421857', '239', '', NULL, '2011-06-22', NULL, 'JCUEVAS', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

-- Volcando estructura para tabla notariatambini.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` varchar(50) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.personal_access_tokens: ~4 rows (aproximadamente)
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
	(46, 'App\\Models\\User', 'PE000035', 'API Token', '06e798f796fa5e0b602c53c55bad4cccb379f512481e11610b2c39a767b9cca7', '["sistema:admin"]', '2023-07-03 00:14:55', NULL, '2023-01-26 02:51:48', '2023-07-03 00:14:55'),
	(61, 'App\\Models\\User', 'PE000035', 'API Token', '81f2e38da894e00bb50247d7f576349c73ea171271f441bb9db80c5ec94d33f3', '["sistema:admin"]', '2023-07-04 23:48:23', NULL, '2023-07-04 22:23:03', '2023-07-04 23:48:23'),
	(65, 'App\\Models\\User', 'PE000035', 'API Token', '0c955bd94a4ab4b02159f2a8e521ddd031da23706ca2b25d2061b018418a3d6f', '["sistema:admin"]', '2023-07-05 16:48:12', NULL, '2023-07-05 16:47:58', '2023-07-05 16:48:12'),
	(66, 'App\\Models\\User', 'PE000035', 'API Token', 'a12618196e46ef72451ebd5917745cac172494e6a32d3bfe4d5212311d9a58b0', '["sistema:admin"]', '2023-07-10 19:24:20', NULL, '2023-07-08 03:53:52', '2023-07-10 19:24:20');

-- Volcando estructura para tabla notariatambini.planillaobservacion
CREATE TABLE IF NOT EXISTS `planillaobservacion` (
  `s_codigo` varchar(12) NOT NULL,
  `s_numero_obs` varchar(10) NOT NULL,
  `d_fecha` date NOT NULL,
  `s_area` varchar(5) NOT NULL,
  `s_responsable` varchar(8) NOT NULL,
  `s_descripcion` varchar(250) NOT NULL,
  `s_accion` varchar(250) NOT NULL,
  `i_estado` int NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.planillaobservacion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.predios
CREATE TABLE IF NOT EXISTS `predios` (
  `s_codigo` varchar(12) NOT NULL,
  `s_kardex` varchar(12) NOT NULL,
  `s_partida` varchar(20) NOT NULL,
  `s_ubigeo` varchar(6) NOT NULL,
  `s_direccion` varchar(200) DEFAULT NULL,
  `s_descripcion` varchar(200) DEFAULT NULL,
  `i_estado` int NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.predios: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.presencias
CREATE TABLE IF NOT EXISTS `presencias` (
  `s_codigo` char(12) NOT NULL,
  `s_contacto` char(10) DEFAULT NULL,
  `s_referente` char(10) DEFAULT NULL,
  `s_facturado` char(10) DEFAULT NULL,
  `d_fecha_registro` date DEFAULT NULL,
  `s_hora_registro` char(10) DEFAULT NULL,
  `s_atendido` char(10) DEFAULT NULL,
  `i_tipopago` int DEFAULT NULL,
  `s_observacion` varchar(250) DEFAULT NULL,
  `i_estado` int unsigned DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.presencias: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.presentadohistorial
CREATE TABLE IF NOT EXISTS `presentadohistorial` (
  `s_codigo` varchar(255) NOT NULL,
  `s_CodKardex` varchar(45) NOT NULL,
  `s_kardex` varchar(45) NOT NULL,
  `s_titulo` varchar(45) NOT NULL,
  `s_estadoR` varchar(45) NOT NULL,
  `d_fecha` varchar(45) NOT NULL,
  `s_dias` varchar(45) NOT NULL,
  `s_personal` varchar(225) DEFAULT NULL,
  `i_estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.presentadohistorial: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `s_codigo` char(12) NOT NULL,
  `s_nombre` varchar(120) DEFAULT NULL,
  `s_categoria` char(12) DEFAULT NULL,
  `s_unidad` char(5) DEFAULT NULL,
  `i_exismin` int DEFAULT NULL,
  `s_proveedor` char(12) DEFAULT NULL,
  `s_observacion` varchar(250) DEFAULT NULL,
  `d_fecreg` date DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.productos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.produc_tienda
CREATE TABLE IF NOT EXISTS `produc_tienda` (
  `s_codigo` varchar(12) NOT NULL,
  `s_nombre` varchar(45) NOT NULL,
  `i_cantidad` int unsigned NOT NULL,
  `s_personal_reg` varchar(12) NOT NULL,
  `s_tipo` varchar(12) NOT NULL,
  `de_precio_compra` double(12,2) unsigned NOT NULL,
  `de_precio_venta` double(12,2) NOT NULL,
  `i_ganancia_unidad` double(12,2) NOT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.produc_tienda: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.profesion
CREATE TABLE IF NOT EXISTS `profesion` (
  `s_codigo` varchar(7) NOT NULL,
  `s_codigo_sbs` varchar(5) DEFAULT NULL,
  `s_nombre` varchar(80) DEFAULT NULL,
  `s_nombref` varchar(80) DEFAULT NULL,
  `i_tipo` int DEFAULT NULL,
  `s_descripcion` varchar(250) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.profesion: ~2 rows (aproximadamente)
INSERT INTO `profesion` (`s_codigo`, `s_codigo_sbs`, `s_nombre`, `s_nombref`, `i_tipo`, `s_descripcion`, `i_estado`) VALUES
	('P0001', 'ss3', 'SSAS', 'SAD', 1, 'ASDA', 1),
	('P0002', 'sbs', 'NOMBRE', 'NOMBRE', 1, 'DESC', 1);

-- Volcando estructura para tabla notariatambini.proforma
CREATE TABLE IF NOT EXISTS `proforma` (
  `s_codigo` char(12) NOT NULL,
  `s_tipokardex` char(2) DEFAULT NULL,
  `s_cliente` char(10) DEFAULT NULL,
  `s_actnot` char(6) DEFAULT NULL,
  `s_atendido` char(10) DEFAULT NULL,
  `d_feching` date DEFAULT NULL,
  `s_Horaing` varchar(12) DEFAULT NULL,
  `s_observacion` varchar(254) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.proforma: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.prof_servicios_notariales
CREATE TABLE IF NOT EXISTS `prof_servicios_notariales` (
  `s_codigo` char(5) NOT NULL,
  `s_proforma` char(12) DEFAULT NULL,
  `s_tipo_servicio` int DEFAULT NULL,
  `s_servicio` char(5) DEFAULT NULL,
  `i_cantidad` int DEFAULT NULL,
  `de_precio` decimal(12,2) DEFAULT NULL,
  `de_total` decimal(12,2) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `i_estado` (`i_estado`),
  CONSTRAINT `prof_servicios_notariales_ibfk_1` FOREIGN KEY (`i_estado`) REFERENCES `estado` (`i_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.prof_servicios_notariales: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.proveedor
CREATE TABLE IF NOT EXISTS `proveedor` (
  `s_codigo` varchar(12) NOT NULL,
  `s_ruc` char(12) DEFAULT NULL,
  `s_nombres` varchar(100) DEFAULT NULL,
  `s_gironegocio` varchar(80) DEFAULT NULL,
  `s_localidad` varchar(100) DEFAULT NULL,
  `s_direccion` varchar(100) DEFAULT NULL,
  `s_direc_entrega` varchar(100) DEFAULT NULL,
  `s_telefonos` varchar(40) DEFAULT NULL,
  `s_fax` varchar(40) DEFAULT NULL,
  `s_paginaweb` varchar(80) DEFAULT NULL,
  `s_mail` varchar(80) DEFAULT NULL,
  `s_gerente` varchar(120) DEFAULT NULL,
  `s_jefeadmin` varchar(120) DEFAULT NULL,
  `s_gerente_com` varchar(120) DEFAULT NULL,
  `s_ejecutivocuenta` varchar(120) DEFAULT NULL,
  `s_areaconta` varchar(120) DEFAULT NULL,
  `i_cheque` int DEFAULT NULL,
  `s_chequedia` varchar(20) DEFAULT NULL,
  `i_transferencia` int DEFAULT NULL,
  `s_transdia` varchar(20) DEFAULT NULL,
  `s_codrefbancaria` char(12) DEFAULT NULL,
  `s_codrefcomercial` char(12) DEFAULT NULL,
  `d_fecreg` date DEFAULT NULL,
  `s_rutalogo` varchar(80) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.proveedor: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.provincia1
CREATE TABLE IF NOT EXISTS `provincia1` (
  `s_codigo` varchar(255) NOT NULL,
  `s_provincia` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.provincia1: ~194 rows (aproximadamente)
INSERT INTO `provincia1` (`s_codigo`, `s_provincia`) VALUES
	('0101', 'CHACHAPOYAS              '),
	('0102', 'BAGUA                    '),
	('0103', 'BONGARA                  '),
	('0104', 'CONDORCANQUI             '),
	('0105', 'LUYA                     '),
	('0106', 'RODRIGUEZ DE MENDOZA     '),
	('0107', 'UTCUBAMBA                '),
	('0201', 'HUARAZ                   '),
	('0202', 'AIJA                     '),
	('0203', 'ANTONIO RAYMONDI         '),
	('0204', 'ASUNCION                 '),
	('0205', 'BOLOGNESI                '),
	('0206', 'CARHUAZ                  '),
	('0207', 'CARLOS F. FITZCARRALD    '),
	('0208', 'CASMA                    '),
	('0209', 'CORONGO                  '),
	('0210', 'HUARI                    '),
	('0211', 'HUARMEY                  '),
	('0212', 'HUAYLAS                  '),
	('0213', 'MARISCAL LUZURIAGA       '),
	('0214', 'OCROS                    '),
	('0215', 'PALLASCA                 '),
	('0216', 'POMABAMBA                '),
	('0217', 'RECUAY                   '),
	('0218', 'SANTA                    '),
	('0219', 'SIHUAS                   '),
	('0220', 'YUNGAY                   '),
	('02SD', 'SDSD'),
	('0301', 'ABANCAY                  '),
	('0302', 'ANDAHUAYLAS              '),
	('0303', 'ANTABAMBA                '),
	('0304', 'AYMARAES                 '),
	('0305', 'COTABAMBAS               '),
	('0306', 'CHINCHEROS               '),
	('0307', 'GRAU                     '),
	('0401', 'AREQUIPA                 '),
	('0402', 'CAMANA                   '),
	('0403', 'CARAVELI                 '),
	('0404', 'CASTILLA                 '),
	('0405', 'CAYLLOMA                 '),
	('0406', 'CONDESUYOS               '),
	('0407', 'ISLAY                    '),
	('0408', 'LA UNION                 '),
	('0501', 'HUAMANGA                 '),
	('0502', 'CANGALLO                 '),
	('0503', 'HUANCA SANCOS            '),
	('0504', 'HUANTA                   '),
	('0505', 'LA MAR                   '),
	('0506', 'LUCANAS                  '),
	('0507', 'PARINACOCHAS             '),
	('0508', 'PAUCAR DEL SARA SARA     '),
	('0509', 'SUCRE                    '),
	('0510', 'VICTOR FAJARDO           '),
	('0511', 'VILCAS HUAMAN            '),
	('0601', 'CAJAMARCA                '),
	('0602', 'CAJABAMBA                '),
	('0603', 'CELENDIN                 '),
	('0604', 'CHOTA                    '),
	('0605', 'CONTUMAZA                '),
	('0606', 'CUTERVO                  '),
	('0607', 'HUALGAYOC                '),
	('0608', 'JAEN                     '),
	('0609', 'SAN IGNACIO              '),
	('0610', 'SAN MARCOS               '),
	('0611', 'SAN MIGUEL               '),
	('0612', 'SAN PABLO                '),
	('0613', 'SANTA CRUZ               '),
	('0701', 'PROV. CONST. DEL CALLA   '),
	('0801', 'CUSCO                    '),
	('0802', 'ACOMAYO                  '),
	('0803', 'ANTA                     '),
	('0804', 'CALCA                    '),
	('0805', 'CANAS                    '),
	('0806', 'CANCHIS                  '),
	('0807', 'CHUMBIVILCAS             '),
	('0808', 'ESPINAR                  '),
	('0809', 'LA CONVENCION            '),
	('0810', 'PARURO                   '),
	('0811', 'PAUCARTAMBO              '),
	('0812', 'QUISPICANCHI             '),
	('0813', 'URUBAMBA                 '),
	('0901', 'HUANCAVELICA             '),
	('0902', 'ACOBAMBA                 '),
	('0903', 'ANGARAES                 '),
	('0904', 'CASTROVIRREYNA           '),
	('0905', 'CHURCAMPA                '),
	('0906', 'HUAYTARA                 '),
	('0907', 'TAYACAJA                 '),
	('1001', 'HUANUCO                  '),
	('1002', 'AMBO                     '),
	('1003', 'DOS DE MAYO              '),
	('1004', 'HUACAYBAMBA              '),
	('1005', 'HUAMALIES                '),
	('1006', 'LEONCIO PRADO            '),
	('1007', 'MARAÑON                  '),
	('1008', 'PACHITEA                 '),
	('1009', 'PUERTO INCA              '),
	('1010', 'LAURICOCHA               '),
	('1011', 'YAROWILCA                '),
	('1101', 'ICA                      '),
	('1102', 'CHINCHA                  '),
	('1103', 'NAZCA                    '),
	('1104', 'PALPA                    '),
	('1105', 'PISCO                    '),
	('1201', 'HUANCAYO                 '),
	('1202', 'CONCEPCION               '),
	('1203', 'CHANCHAMAYO              '),
	('1204', 'JAUJA                    '),
	('1205', 'JUNIN                    '),
	('1206', 'SATIPO                   '),
	('1207', 'TARMA                    '),
	('1208', 'YAULI                    '),
	('1209', 'CHUPACA                  '),
	('1301', 'TRUJILLO                 '),
	('1302', 'ASCOPE                   '),
	('1303', 'BOLIVAR                  '),
	('1304', 'CHEPEN                   '),
	('1305', 'JULCAN                   '),
	('1306', 'OTUZCO                   '),
	('1307', 'PACASMAYO                '),
	('1308', 'PATAZ                    '),
	('1309', 'SANCHEZ CARRION          '),
	('1310', 'SANTIAGO DE CHUCO        '),
	('1311', 'GRAN CHIMU               '),
	('1312', 'VIRU                     '),
	('1401', 'CHICLAYO                 '),
	('1402', 'FERRENAFE                '),
	('1403', 'LAMBAYEQUE               '),
	('1501', 'LIMA                     '),
	('1502', 'BARRANCA                 '),
	('1503', 'CAJATAMBO                '),
	('1504', 'CANTA                    '),
	('1505', 'CAÑETE                   '),
	('1506', 'HUARAL                   '),
	('1507', 'HUAROCHIRI               '),
	('1508', 'HUAURA                   '),
	('1509', 'OYON                     '),
	('1510', 'YAUYOS                   '),
	('1601', 'MAYNAS                   '),
	('1602', 'ALTO AMAZONAS            '),
	('1603', 'LORETO                   '),
	('1604', 'MARISCAL RAMON CASTILLA  '),
	('1605', 'REQUENA                  '),
	('1606', 'UCAYALI                  '),
	('1701', 'TAMBOPATA                '),
	('1702', 'MANU                     '),
	('1703', 'TAHUAMANU                '),
	('1801', 'MARISCAL NIETO           '),
	('1802', 'GENERAL SANCHEZ CERRO    '),
	('1803', 'ILO                      '),
	('1901', 'PASCO                    '),
	('1902', 'DANIEL ALCIDES CARRION   '),
	('1903', 'OXAPAMPA                 '),
	('2001', 'PIURA                    '),
	('2002', 'AYABACA                  '),
	('2003', 'HUANCABAMBA              '),
	('2004', 'MORROPON                 '),
	('2005', 'PAITA                    '),
	('2006', 'SULLANA                  '),
	('2007', 'TALARA                   '),
	('2008', 'SECHURA                  '),
	('2101', 'PUNO                     '),
	('2102', 'AZANGARO                 '),
	('2103', 'CARABAYA                 '),
	('2104', 'CHUCUITO                 '),
	('2105', 'EL COLLAO                '),
	('2106', 'HUANCANE                 '),
	('2107', 'LAMPA                    '),
	('2108', 'MELGAR                   '),
	('2109', 'MOHO                     '),
	('2110', 'SAN ANTONIO DE PUTINA    '),
	('2111', 'SAN ROMAN                '),
	('2112', 'SANDIA                   '),
	('2113', 'YUNGUYO                  '),
	('2201', 'MOYOBAMBA                '),
	('2202', 'BELLAVISTA               '),
	('2203', 'EL DORADO                '),
	('2204', 'HUALLAGA                 '),
	('2205', 'LAMAS                    '),
	('2206', 'MARISCAL CACERES         '),
	('2207', 'PICOTA                   '),
	('2208', 'RIOJA                    '),
	('2209', 'SAN MARTIN               '),
	('2210', 'TOCACHE                  '),
	('2301', 'TACNA                    '),
	('2302', 'CANDARAVE                '),
	('2303', 'JORGE BASADRE            '),
	('2304', 'TARATA                   '),
	('2401', 'TUMBES                   '),
	('2402', 'CONTRALMIRANTE VILLAR    '),
	('2403', 'ZARUMILLA                '),
	('2501', 'CORONEL PORTILLO         '),
	('2502', 'ATALAYA                  '),
	('2503', 'PADRE ABAD               '),
	('2504', 'PURUS                    '),
	('9901', 'SDFDFDF');

-- Volcando estructura para tabla notariatambini.provincias
CREATE TABLE IF NOT EXISTS `provincias` (
  `s_codigo` char(6) NOT NULL,
  `s_nombre` varchar(50) DEFAULT NULL,
  `s_depa` char(6) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.provincias: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.pro_requisitos_kardex
CREATE TABLE IF NOT EXISTS `pro_requisitos_kardex` (
  `s_proforma` char(12) DEFAULT NULL,
  `s_requisistos` char(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.pro_requisitos_kardex: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.publicacion
CREATE TABLE IF NOT EXISTS `publicacion` (
  `s_codigo` int unsigned NOT NULL AUTO_INCREMENT,
  `s_kardex` varchar(100) NOT NULL,
  `s_oficio` varchar(500) NOT NULL,
  `s_peruano` varchar(500) NOT NULL,
  `s_razon` varchar(500) NOT NULL,
  `s_pagina` varchar(500) NOT NULL,
  `d_fecha_publicado` date NOT NULL,
  `d_fecha_aviso` date NOT NULL,
  `s_mensaje` varchar(500) NOT NULL,
  `s_personal` varchar(45) NOT NULL,
  `s_celular` varchar(45) NOT NULL,
  `d_fecha_registro` datetime NOT NULL,
  `i_estado` int NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.publicacion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.readme
CREATE TABLE IF NOT EXISTS `readme` (
  `id` int NOT NULL,
  `readme` text,
  `BTC_address` text,
  `email` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.readme: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.recibo
CREATE TABLE IF NOT EXISTS `recibo` (
  `s_codigo` char(12) NOT NULL,
  `s_usuario` char(10) DEFAULT NULL,
  `s_referente` char(12) DEFAULT NULL,
  `s_atendido` char(8) DEFAULT NULL,
  `s_numeroSerie` varchar(20) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(12) DEFAULT NULL,
  `de_total` decimal(12,2) DEFAULT NULL,
  `s_observacion` varchar(255) DEFAULT NULL,
  `s_autorizado` varchar(8) DEFAULT NULL,
  `s_descripcion` varchar(255) DEFAULT NULL,
  `d_fecha_anulacion` date DEFAULT NULL,
  `s_hora_anulacion` varchar(20) DEFAULT NULL,
  `i_tipopago` int DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `idx_recibo_01` (`s_referente`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.recibo: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.recibocobranza
CREATE TABLE IF NOT EXISTS `recibocobranza` (
  `s_codigo` char(12) NOT NULL,
  `s_facturado` char(10) DEFAULT NULL,
  `s_caja` char(8) DEFAULT NULL,
  `s_tipoDocumento` char(5) DEFAULT NULL,
  `s_numeroSerie` varchar(20) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(12) DEFAULT NULL,
  `de_total` decimal(12,2) DEFAULT NULL,
  `de_pagado` decimal(12,2) DEFAULT NULL,
  `de_cobre` decimal(12,2) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `id_codigo_cobranza` (`s_codigo`),
  KEY `s_codigo` (`s_codigo`),
  KEY `s_codigo_2` (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.recibocobranza: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.recibopago
CREATE TABLE IF NOT EXISTS `recibopago` (
  `s_codigo` char(12) NOT NULL,
  `s_facturado` char(10) DEFAULT NULL,
  `s_Atendido` char(10) DEFAULT NULL,
  `s_caja` char(10) DEFAULT NULL,
  `s_anulado` char(10) DEFAULT NULL,
  `s_autorizado` char(10) DEFAULT NULL,
  `s_razon` varchar(255) DEFAULT NULL,
  `d_anulacion` datetime DEFAULT NULL,
  `s_tipoDocumento` char(5) DEFAULT NULL,
  `s_numeroSerie` varchar(20) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(12) DEFAULT NULL,
  `s_tipo` char(1) DEFAULT NULL,
  `de_subTotal` decimal(12,2) DEFAULT NULL,
  `de_igv` decimal(12,2) DEFAULT NULL,
  `de_total` decimal(12,2) DEFAULT NULL,
  `de_pagado` decimal(12,2) DEFAULT NULL,
  `de_cobre` decimal(12,2) DEFAULT NULL,
  `d_fechaVencimiento` date DEFAULT NULL,
  `s_observacion` varchar(1000) DEFAULT NULL,
  `s_doc_modifica_tipo` varchar(1) DEFAULT NULL,
  `s_doc_modifica_serie` varchar(4) DEFAULT NULL,
  `s_doc_modifica_numero` varchar(8) DEFAULT NULL,
  `s_tipo_nota_credito` varchar(2) DEFAULT NULL,
  `s_codigo_hash` varchar(255) DEFAULT NULL,
  `s_enviado` varchar(10) DEFAULT NULL,
  `s_documento` varchar(12) DEFAULT NULL,
  `i_pago_credito` int DEFAULT '0',
  `s_serieunica` varchar(20) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  UNIQUE KEY `s_serieunica` (`s_serieunica`),
  KEY `id_codigo_recibopago` (`s_codigo`),
  KEY `s_codigo` (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.recibopago: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.refbancaria
CREATE TABLE IF NOT EXISTS `refbancaria` (
  `s_codigo` char(12) NOT NULL,
  `s_codproveedor` char(12) DEFAULT NULL,
  `s_banco` varchar(5) DEFAULT NULL,
  `s_numcuenta` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.refbancaria: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.refcomercial
CREATE TABLE IF NOT EXISTS `refcomercial` (
  `s_codigo` char(12) NOT NULL,
  `s_codproveedor` char(12) DEFAULT NULL,
  `s_compania` varchar(100) DEFAULT NULL,
  `s_contacto` varchar(100) DEFAULT NULL,
  `s_telefono` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.refcomercial: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.registros_publicos
CREATE TABLE IF NOT EXISTS `registros_publicos` (
  `s_codigo` char(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `s_kardex` char(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `s_titulo` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(5) DEFAULT NULL,
  `s_area` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `s_oficina` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `s_estadoR` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `de_pagado` decimal(12,2) DEFAULT NULL,
  `s_partida` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `s_asiento` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `s_orden` char(12) DEFAULT NULL,
  `s_tipo_pago` varchar(50) DEFAULT NULL,
  `d_fecha_plazo` date DEFAULT NULL,
  `s_descargo` varchar(11) DEFAULT NULL,
  `s_tive` varchar(20) DEFAULT NULL,
  `s_personal_registro` varchar(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `d_fecha_registro` datetime DEFAULT NULL,
  `s_usuario_modificacion` varchar(12) DEFAULT NULL,
  `d_fecha_modificacion` datetime DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `Numero` (`s_codigo`),
  KEY `kardex` (`s_kardex`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.registros_publicos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.registro_envio_correos
CREATE TABLE IF NOT EXISTS `registro_envio_correos` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `s_personal` varchar(8) DEFAULT NULL,
  `d_fecha_envio` date DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=13608 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.registro_envio_correos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.registro_formatos
CREATE TABLE IF NOT EXISTS `registro_formatos` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `d_fecha` date DEFAULT NULL,
  `i_formato` int unsigned DEFAULT NULL,
  `s_descripcion` varchar(255) DEFAULT NULL,
  `s_usuario` varchar(200) DEFAULT NULL,
  `s_factura` varchar(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=24548 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.registro_formatos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.registro_numeracion
CREATE TABLE IF NOT EXISTS `registro_numeracion` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `d_fecha` date DEFAULT NULL,
  `s_carta` int unsigned DEFAULT NULL,
  `s_descripcion` varchar(255) DEFAULT NULL,
  `s_usuario` varchar(200) DEFAULT NULL,
  `s_destinatario` varchar(250) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=32099 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.registro_numeracion: 0 rows
/*!40000 ALTER TABLE `registro_numeracion` DISABLE KEYS */;
/*!40000 ALTER TABLE `registro_numeracion` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.requerimientos
CREATE TABLE IF NOT EXISTS `requerimientos` (
  `s_codigo` char(12) NOT NULL,
  `d_fechareg` date DEFAULT NULL,
  `s_usuario` char(12) DEFAULT NULL,
  `d_fecha_termino` char(12) DEFAULT NULL,
  `s_observacion` varchar(500) DEFAULT NULL,
  `s_detalle` varchar(500) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.requerimientos: 0 rows
/*!40000 ALTER TABLE `requerimientos` DISABLE KEYS */;
/*!40000 ALTER TABLE `requerimientos` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.requisitos
CREATE TABLE IF NOT EXISTS `requisitos` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(100) DEFAULT NULL,
  `s_descripcion` varchar(200) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.requisitos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.requisitos_kardex
CREATE TABLE IF NOT EXISTS `requisitos_kardex` (
  `s_kardex` char(12) DEFAULT NULL,
  `s_requisistos` char(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.requisitos_kardex: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.retiro_dinero
CREATE TABLE IF NOT EXISTS `retiro_dinero` (
  `s_codigo` char(12) NOT NULL DEFAULT '',
  `d_fecharegistro` date DEFAULT NULL,
  `s_entregado` char(12) DEFAULT NULL,
  `s_tipo_salida` varchar(50) DEFAULT NULL,
  `s_numero_doc` varchar(50) DEFAULT NULL,
  `de_monto` decimal(9,2) DEFAULT NULL,
  `s_observacion` varchar(254) DEFAULT NULL,
  `s_atendido` char(12) DEFAULT NULL,
  `s_autorizado` char(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `index_pagosrrpp` (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.retiro_dinero: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.ro_error
CREATE TABLE IF NOT EXISTS `ro_error` (
  `codigo` int NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.ro_error: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.rutas
CREATE TABLE IF NOT EXISTS `rutas` (
  `s_codigo` varchar(12) NOT NULL,
  `s_ruta` varchar(100) NOT NULL,
  `s_descripcion` varchar(200) NOT NULL,
  `s_tipo` varchar(2) NOT NULL,
  `i_estado` int NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.rutas: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.salida_personal
CREATE TABLE IF NOT EXISTS `salida_personal` (
  `s_codigo` varchar(12) NOT NULL,
  `s_personal` varchar(8) NOT NULL,
  `s_area` varchar(12) NOT NULL,
  `d_fecha` date NOT NULL,
  `s_hora_salida` varchar(10) NOT NULL,
  `s_hora_regreso` varchar(10) NOT NULL,
  `i_destino` int unsigned NOT NULL,
  `s_detalle` varchar(250) NOT NULL,
  `s_autoriza` varchar(8) NOT NULL,
  `d_fecha_autoriza` datetime NOT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.salida_personal: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.seccion
CREATE TABLE IF NOT EXISTS `seccion` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(50) DEFAULT NULL,
  `s_descripcion` varchar(100) DEFAULT NULL,
  `s_area` char(5) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.seccion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.seguimiento_kardex
CREATE TABLE IF NOT EXISTS `seguimiento_kardex` (
  `s_codigo` varchar(12) NOT NULL,
  `s_kardex` varchar(10) DEFAULT NULL,
  `d_fechafirma` date DEFAULT NULL,
  `s_horafirma` varchar(12) DEFAULT NULL,
  `s_obslegal` varchar(255) DEFAULT NULL,
  `s_obsdigitacion` varchar(255) DEFAULT NULL,
  `s_personal` char(10) DEFAULT NULL,
  `d_fecharegistro` date DEFAULT NULL,
  `s_hora` varchar(12) DEFAULT NULL,
  `i_importacia` int DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.seguimiento_kardex: 0 rows
/*!40000 ALTER TABLE `seguimiento_kardex` DISABLE KEYS */;
/*!40000 ALTER TABLE `seguimiento_kardex` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.servicios
CREATE TABLE IF NOT EXISTS `servicios` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(400) DEFAULT NULL,
  `s_descripcion` varchar(400) DEFAULT NULL,
  `s_generico` char(5) DEFAULT NULL,
  `i_formato` int DEFAULT NULL,
  `i_rapidos` int DEFAULT '0',
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.servicios: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.serviciosrapidos
CREATE TABLE IF NOT EXISTS `serviciosrapidos` (
  `s_codigo` char(12) NOT NULL,
  `s_facturado` char(10) DEFAULT NULL,
  `s_solicitante` varchar(12) DEFAULT NULL,
  `s_atendido` char(8) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `idx_serviciosrapidos_01` (`d_fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.serviciosrapidos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.servicios_acto
CREATE TABLE IF NOT EXISTS `servicios_acto` (
  `s_codigo` varchar(12) NOT NULL,
  `s_acto` varchar(6) NOT NULL,
  `s_servicio` varchar(6) NOT NULL,
  `i_tipo` int DEFAULT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.servicios_acto: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.servicios_adicionales
CREATE TABLE IF NOT EXISTS `servicios_adicionales` (
  `i_codigo` int unsigned NOT NULL AUTO_INCREMENT,
  `s_cod_serv` varchar(12) NOT NULL,
  `s_descripcion` varchar(250) DEFAULT NULL,
  `s_observacion` varchar(500) DEFAULT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.servicios_adicionales: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.servicios_compras
CREATE TABLE IF NOT EXISTS `servicios_compras` (
  `s_codigo` char(12) NOT NULL,
  `s_nombre` varchar(200) DEFAULT NULL,
  `s_observacion` varchar(200) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.servicios_compras: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.servicios_notariales
CREATE TABLE IF NOT EXISTS `servicios_notariales` (
  `s_codigo` char(12) NOT NULL,
  `s_kardex` char(12) DEFAULT NULL,
  `s_tipo_servicio` int unsigned DEFAULT NULL,
  `s_servicio` varchar(10) DEFAULT NULL,
  `i_cantidad` int unsigned DEFAULT NULL,
  `de_precio` decimal(12,2) DEFAULT NULL,
  `de_total` decimal(12,2) DEFAULT NULL,
  `i_estado` int unsigned DEFAULT NULL,
  `d_fecha_reg` datetime DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `Numero` (`s_kardex`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.servicios_notariales: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.servicios_pendientes
CREATE TABLE IF NOT EXISTS `servicios_pendientes` (
  `s_kardex` char(12) DEFAULT NULL,
  `i_tipo` int DEFAULT NULL,
  `s_nombre` varchar(30) DEFAULT NULL,
  `i_cantidad` int DEFAULT NULL,
  `de_precio` decimal(10,2) DEFAULT NULL,
  `de_total` decimal(10,2) DEFAULT NULL,
  `s_personal` char(8) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.servicios_pendientes: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.servicios_principales
CREATE TABLE IF NOT EXISTS `servicios_principales` (
  `i_codigo` int unsigned NOT NULL AUTO_INCREMENT,
  `s_nombre` varchar(500) DEFAULT NULL,
  `s_generico` varchar(12) DEFAULT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.servicios_principales: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.situacion
CREATE TABLE IF NOT EXISTS `situacion` (
  `i_codigo` int unsigned NOT NULL AUTO_INCREMENT,
  `s_tipo` varchar(2) NOT NULL,
  `s_nombre` varchar(100) NOT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.situacion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.solicitante
CREATE TABLE IF NOT EXISTS `solicitante` (
  `id_solicitante` int NOT NULL AUTO_INCREMENT,
  `s_cliente` varchar(50) DEFAULT NULL,
  `s_codigo` varchar(50) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  `s_tipodocumento` varchar(50) DEFAULT NULL,
  `s_numerodocumento` varchar(50) DEFAULT NULL,
  `s_domicilio` varchar(1000) DEFAULT NULL,
  `s_nombres` varchar(50) DEFAULT NULL,
  `s_apellidopaterno` varchar(50) DEFAULT NULL,
  `s_apellidomaterno` varchar(50) DEFAULT NULL,
  `s_celular` varchar(50) DEFAULT NULL,
  `s_correo` varchar(50) DEFAULT NULL,
  `s_departamento` varchar(50) DEFAULT NULL,
  `s_provincia` varchar(50) DEFAULT NULL,
  `s_distrito` varchar(50) DEFAULT NULL,
  `s_informacion` varchar(1000) DEFAULT NULL,
  `aud_usuariocreacion` varchar(50) DEFAULT NULL,
  `aud_fechacreacion` datetime DEFAULT NULL,
  `aud_usuarioactualizacion` varchar(50) DEFAULT NULL,
  `aud_fechaactualizacion` date DEFAULT NULL,
  `aud_estado` int DEFAULT NULL,
  PRIMARY KEY (`id_solicitante`) USING BTREE,
  KEY `s_cliente` (`s_cliente`) USING BTREE,
  KEY `s_codigo` (`s_codigo`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.solicitante: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.soporte
CREATE TABLE IF NOT EXISTS `soporte` (
  `s_codigo` varchar(15) NOT NULL,
  `s_personal` varchar(50) NOT NULL,
  `s_area` varchar(20) NOT NULL,
  `s_tipo` varchar(20) NOT NULL,
  `s_tiempo` varchar(10) NOT NULL,
  `s_tipo_tiempo` varchar(50) DEFAULT NULL,
  `s_descripcion` varchar(250) NOT NULL,
  `s_accion` varchar(250) DEFAULT NULL,
  `s_atendido` varchar(20) NOT NULL,
  `d_fecha` date NOT NULL,
  `i_estado` int NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.soporte: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.s_configuracion
CREATE TABLE IF NOT EXISTS `s_configuracion` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `s_empresa` varchar(250) DEFAULT NULL,
  `s_direccion` varchar(255) DEFAULT NULL,
  `s_ruta_logo` varchar(255) DEFAULT NULL,
  `s_ruta_fondo_login` varchar(255) DEFAULT NULL,
  `d_fecha_registro` date DEFAULT NULL,
  `s_hora_registro` varchar(20) DEFAULT NULL,
  `s_responsable` varchar(250) DEFAULT NULL,
  `s_descripcion` varchar(250) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.s_configuracion: ~0 rows (aproximadamente)
INSERT INTO `s_configuracion` (`i_codigo`, `s_empresa`, `s_direccion`, `s_ruta_logo`, `s_ruta_fondo_login`, `d_fecha_registro`, `s_hora_registro`, `s_responsable`, `s_descripcion`, `i_estado`) VALUES
	(2, 'SIGANOT 2.0', 'Direc', 'http://sisnotarial-tambini.test/storage/logo/63c770eba0b9a.png', NULL, '2023-07-07', '17:40:49', 'PE000035', 'desccsss', 1);

-- Volcando estructura para tabla notariatambini.tabla_general_cab
CREATE TABLE IF NOT EXISTS `tabla_general_cab` (
  `s_codigo` int NOT NULL,
  `s_nombre` char(40) NOT NULL,
  `des_observaciones` char(100) DEFAULT NULL,
  `id_modulo` int DEFAULT NULL,
  `ind_activo` int NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.tabla_general_cab: 0 rows
/*!40000 ALTER TABLE `tabla_general_cab` DISABLE KEYS */;
/*!40000 ALTER TABLE `tabla_general_cab` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.tabla_general_det
CREATE TABLE IF NOT EXISTS `tabla_general_det` (
  `s_codigo` int NOT NULL,
  `id_general_cab` int DEFAULT NULL,
  `s_nombre_larga` char(20) NOT NULL,
  `s_nombre` char(100) NOT NULL,
  `s_nombre_larga_opcional` text,
  `ind_activo` int NOT NULL,
  `imp_valor` decimal(18,4) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.tabla_general_det: 0 rows
/*!40000 ALTER TABLE `tabla_general_det` DISABLE KEYS */;
/*!40000 ALTER TABLE `tabla_general_det` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.tarjeta_viaje
CREATE TABLE IF NOT EXISTS `tarjeta_viaje` (
  `purchaseNumber` varchar(50) DEFAULT NULL,
  `s_cliente` varchar(50) DEFAULT NULL,
  `transactionDate` varchar(50) DEFAULT NULL,
  `amount` varchar(50) DEFAULT NULL,
  `currency` varchar(50) DEFAULT NULL,
  `ACTION_DESCRIPTION` varchar(50) DEFAULT NULL,
  `card` varchar(50) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `estado_pago` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.tarjeta_viaje: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.testimonio
CREATE TABLE IF NOT EXISTS `testimonio` (
  `s_codigo` char(12) NOT NULL,
  `s_kardex` char(12) DEFAULT NULL,
  `s_cliente` char(10) DEFAULT NULL,
  `s_documento` varchar(255) NOT NULL,
  `s_observacion` varchar(255) DEFAULT NULL,
  `d_fecha_entrega` date DEFAULT NULL,
  `s_hora_registro` varchar(16) DEFAULT NULL,
  `s_personal_reg` char(8) DEFAULT NULL,
  `d_fecha_reg` date DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`),
  KEY `Numero` (`s_kardex`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.testimonio: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.tiponotacredito
CREATE TABLE IF NOT EXISTS `tiponotacredito` (
  `i_codigo` int NOT NULL,
  `s_nombre` varchar(255) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.tiponotacredito: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.tipopermiso
CREATE TABLE IF NOT EXISTS `tipopermiso` (
  `i_codigo` int NOT NULL,
  `s_nombre` varchar(30) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.tipopermiso: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.tipo_arancel
CREATE TABLE IF NOT EXISTS `tipo_arancel` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(50) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.tipo_arancel: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.tipo_atencion
CREATE TABLE IF NOT EXISTS `tipo_atencion` (
  `s_codigo` varchar(8) NOT NULL,
  `s_nombre` varchar(40) NOT NULL,
  `i_estado` int NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.tipo_atencion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.tipo_cambio
CREATE TABLE IF NOT EXISTS `tipo_cambio` (
  `s_codigo` char(10) NOT NULL,
  `de_compra` decimal(8,2) DEFAULT NULL,
  `de_venta` decimal(8,2) DEFAULT NULL,
  `d_fecha_reg` date DEFAULT NULL,
  `s_personal_reg` char(8) DEFAULT NULL,
  `d_fecha_mod` date DEFAULT NULL,
  `s_personal_mod` varchar(20) DEFAULT NULL,
  `i_estado` int DEFAULT '1',
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.tipo_cambio: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.tipo_comparecientes
CREATE TABLE IF NOT EXISTS `tipo_comparecientes` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(255) DEFAULT NULL,
  `s_codigo_sg` varchar(50) DEFAULT NULL,
  `s_tipo_pdt` varchar(50) DEFAULT NULL,
  `s_color` varchar(255) DEFAULT NULL,
  `s_clase` varchar(11) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.tipo_comparecientes: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.tipo_docu
CREATE TABLE IF NOT EXISTS `tipo_docu` (
  `s_codigo` char(5) NOT NULL,
  `s_codigo_sbs` varchar(2) DEFAULT NULL,
  `s_cod_cnl` varchar(2) DEFAULT NULL,
  `s_nombre` varchar(50) DEFAULT NULL,
  `s_abrev` varchar(7) DEFAULT NULL,
  `i_digitos` int DEFAULT NULL,
  `s_tipoFe` varchar(1) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.tipo_docu: ~5 rows (aproximadamente)
INSERT INTO `tipo_docu` (`s_codigo`, `s_codigo_sbs`, `s_cod_cnl`, `s_nombre`, `s_abrev`, `i_digitos`, `s_tipoFe`, `i_estado`) VALUES
	('TD001', 'v', 'dd', 'DOCUMENTO NACIONAL DE IDENTIDAD', 'DNI', 5, 'h', 1),
	('TD002', 'df', 'df', 'CARNET EXTRANJERIA', 'C.E', 0, 'k', 1),
	('TD003', 'sd', 'as', 'SDFSDFS', 'sdfsdfs', 0, 'd', 1),
	('TD004', 'df', 'cf', 'NM', 'an', 0, 'f', 1),
	('TD005', 'fu', 'cn', 'NOMM', 'abrr', 888, 'e', 1);

-- Volcando estructura para tabla notariatambini.tipo_kardes
CREATE TABLE IF NOT EXISTS `tipo_kardes` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(30) DEFAULT NULL,
  `s_abre` varchar(5) DEFAULT NULL,
  `s_descripcion` varchar(150) DEFAULT NULL,
  `s_clase` char(5) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.tipo_kardes: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.tipo_libro
CREATE TABLE IF NOT EXISTS `tipo_libro` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(150) DEFAULT NULL,
  `s_descripcion` varchar(250) DEFAULT NULL,
  `i_estado` int unsigned DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla notariatambini.tipo_libro: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.tipo_permiso
CREATE TABLE IF NOT EXISTS `tipo_permiso` (
  `i_codigo` int NOT NULL,
  `s_nombre` varchar(30) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.tipo_permiso: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.tipo_rango
CREATE TABLE IF NOT EXISTS `tipo_rango` (
  `s_codigo` char(5) NOT NULL,
  `s_nombre` varchar(50) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.tipo_rango: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.tomadefirma
CREATE TABLE IF NOT EXISTS `tomadefirma` (
  `s_codigo` varchar(12) NOT NULL,
  `d_fecha` date DEFAULT NULL,
  `s_hora` varchar(12) DEFAULT NULL,
  `s_tramite` varchar(100) DEFAULT NULL,
  `s_responsable` varchar(100) DEFAULT NULL,
  `s_nro_cp` varchar(100) DEFAULT NULL,
  `s_procurador` varchar(100) DEFAULT NULL,
  `s_biometrico` varchar(2) DEFAULT NULL,
  `s_empresa` varchar(100) DEFAULT NULL,
  `s_nombre_contacto` varchar(100) DEFAULT NULL,
  `s_cel_contacto` varchar(100) DEFAULT NULL,
  `s_distrito` varchar(100) DEFAULT NULL,
  `s_direccion` varchar(1000) NOT NULL,
  `s_referencia` varchar(500) DEFAULT NULL,
  `s_tipo_lugar` varchar(3) DEFAULT NULL,
  `s_personal` varchar(12) DEFAULT NULL,
  `d_fecha_reg` datetime DEFAULT NULL,
  `s_personal_mod` varchar(12) DEFAULT NULL,
  `d_fecha_mod` datetime DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.tomadefirma: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.tw_testimonio_parte
CREATE TABLE IF NOT EXISTS `tw_testimonio_parte` (
  `i_codigo` int NOT NULL AUTO_INCREMENT,
  `s_cod_web` varchar(10) DEFAULT NULL,
  `s_kardex` varchar(12) DEFAULT NULL,
  `s_cliente` varchar(11) DEFAULT NULL,
  `s_descripcion` varchar(250) DEFAULT NULL,
  `de_precio` double DEFAULT NULL,
  `i_cantidad` int DEFAULT NULL,
  `s_servicio` varchar(5) DEFAULT NULL,
  `s_observacion` varchar(250) DEFAULT NULL,
  `d_fecha` date DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`i_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.tw_testimonio_parte: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.t_grupo
CREATE TABLE IF NOT EXISTS `t_grupo` (
  `ID_GRUPO` int NOT NULL AUTO_INCREMENT,
  `DES_NOMBRE` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `DES_DESCRIPCION` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `USR_CREACION` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `IND_ESTADO` char(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `USR_ACTUALIZO` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `FEC_CREACION` datetime DEFAULT NULL,
  `FEC_ACTUALIZO` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_GRUPO`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla notariatambini.t_grupo: 0 rows
/*!40000 ALTER TABLE `t_grupo` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_grupo` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.t_grupo_opcion
CREATE TABLE IF NOT EXISTS `t_grupo_opcion` (
  `ID_GRUPO` int NOT NULL,
  `ID_OPCION` int NOT NULL,
  PRIMARY KEY (`ID_GRUPO`,`ID_OPCION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.t_grupo_opcion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.t_opcion
CREATE TABLE IF NOT EXISTS `t_opcion` (
  `ID_OPCION` int NOT NULL AUTO_INCREMENT,
  `DES_NOMBRE` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `DES_URL` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `DES_DESCRIPCION` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `IND_ESTADO` char(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `ID_PADRE` int DEFAULT NULL,
  `IND_TIPO` char(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `USR_CREACION` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `USR_ACTUALIZO` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `FEC_CREACION` datetime DEFAULT NULL,
  `FEC_ACTUALIZO` datetime DEFAULT NULL,
  `NUM_NIVEL` int DEFAULT NULL,
  `DES_OBJETIVO` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `NRO_ORDEN` int DEFAULT NULL,
  PRIMARY KEY (`ID_OPCION`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla notariatambini.t_opcion: 0 rows
/*!40000 ALTER TABLE `t_opcion` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_opcion` ENABLE KEYS */;

-- Volcando estructura para tabla notariatambini.t_usuario
CREATE TABLE IF NOT EXISTS `t_usuario` (
  `ID_USUARIO` varchar(20) NOT NULL,
  `DES_NOMBRE` varchar(50) DEFAULT NULL,
  `DES_APELLIDOS` varchar(50) DEFAULT NULL,
  `DES_EMAIL` varchar(50) DEFAULT NULL,
  `DES_PASSWORD` varchar(50) DEFAULT NULL,
  `IND_ESTADO` char(1) DEFAULT NULL,
  `IND_VENDEDOR` char(1) DEFAULT NULL,
  `COD_VENDEDOR` varchar(20) DEFAULT NULL,
  `USR_ACTUALIZO` varchar(20) DEFAULT NULL,
  `USR_CREACION` varchar(20) DEFAULT NULL,
  `FEC_CREACION` datetime DEFAULT NULL,
  `FEC_ACTUALIZO` datetime DEFAULT NULL,
  `IND_USER_PEDIDO` char(1) DEFAULT NULL,
  `COD_VENDEDOR_REP` varchar(6) DEFAULT NULL,
  `COD_VENDEDOR_VEH` varchar(6) DEFAULT NULL,
  `COD_USUARIO_REP` varchar(30) DEFAULT NULL,
  `COD_USUARIO_VEH` varchar(30) DEFAULT NULL,
  `IND_COOKIE` char(1) DEFAULT NULL,
  `IND_TIP_USER_PEDIDO` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_USUARIO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.t_usuario: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.t_usuario_grupo
CREATE TABLE IF NOT EXISTS `t_usuario_grupo` (
  `ID_USUARIO` varchar(20) NOT NULL,
  `ID_GRUPO` int NOT NULL,
  `Fecha_Asignado` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_USUARIO`,`ID_GRUPO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.t_usuario_grupo: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.unidades
CREATE TABLE IF NOT EXISTS `unidades` (
  `s_nombre` varchar(80) DEFAULT NULL,
  `s_abrev` varchar(10) DEFAULT NULL,
  `s_observacion` varchar(200) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  `s_codigo` char(5) NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.unidades: ~0 rows (aproximadamente)
INSERT INTO `unidades` (`s_nombre`, `s_abrev`, `s_observacion`, `i_estado`, `s_codigo`) VALUES
	('KILOGRAMOS', 'KG', 'OKK', 1, 'U-001');

-- Volcando estructura para tabla notariatambini.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `s_codigo` char(8) NOT NULL,
  `s_nombre` varchar(50) DEFAULT NULL,
  `s_clave` varchar(50) DEFAULT NULL,
  `s_permisos` varchar(500) DEFAULT NULL,
  `s_personal` char(8) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  `s_barra` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.usuario: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.usuario_tienda
CREATE TABLE IF NOT EXISTS `usuario_tienda` (
  `s_codigo` varchar(12) NOT NULL,
  `s_nombres` varchar(100) NOT NULL,
  `s_descripcion` varchar(45) NOT NULL,
  `i_estado` int NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.usuario_tienda: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.ventas
CREATE TABLE IF NOT EXISTS `ventas` (
  `codigo` int unsigned NOT NULL AUTO_INCREMENT,
  `codigocliente` int unsigned NOT NULL,
  `codigocomercial` int unsigned NOT NULL,
  `importeventa` decimal(9,2) DEFAULT NULL,
  `importecomision` decimal(9,2) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla notariatambini.ventas: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.ventas_atu
CREATE TABLE IF NOT EXISTS `ventas_atu` (
  `s_codigo` varchar(12) NOT NULL,
  `s_descripcion` varchar(100) NOT NULL,
  `i_cantidad` int unsigned NOT NULL,
  `i_precio_total` double(10,2) unsigned NOT NULL,
  `s_cliente` varchar(45) NOT NULL,
  `s_autorizo` varchar(45) NOT NULL,
  `d_fecha_auto` datetime NOT NULL,
  `i_estado` int unsigned NOT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.ventas_atu: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.viaje
CREATE TABLE IF NOT EXISTS `viaje` (
  `s_codigo` varchar(12) NOT NULL,
  `d_fecha_reg` date DEFAULT NULL,
  `s_tipo_viaje` char(1) DEFAULT NULL,
  `s_padre` varchar(12) DEFAULT NULL,
  `s_madre` varchar(12) DEFAULT NULL,
  `s_destino` varchar(60) DEFAULT NULL,
  `s_dest_desc` varchar(100) DEFAULT NULL,
  `s_retorno` char(1) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla notariatambini.viaje: ~0 rows (aproximadamente)

-- Volcando estructura para tabla notariatambini.viaje_hijo
CREATE TABLE IF NOT EXISTS `viaje_hijo` (
  `s_codigo` varchar(12) NOT NULL,
  `s_codigo_viaje` varchar(12) DEFAULT NULL,
  `s_codigo_hijo` varchar(12) DEFAULT NULL,
  `i_estado` int DEFAULT NULL,
  PRIMARY KEY (`s_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

