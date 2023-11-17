-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 07-12-2018 a las 18:29:07
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `scem`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acuerdos`
--

CREATE TABLE `acuerdos` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `plan_id` bigint(255) UNSIGNED NOT NULL,
  `acuNumero` varchar(10) NOT NULL,
  `acuFecha` date NOT NULL,
  `acuEstadoPlan` enum('L','N','C','X') NOT NULL DEFAULT 'N',
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aextra`
--

CREATE TABLE `aextra` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `curNumPer` smallint(6) NOT NULL,
  `curAnioPer` smallint(6) NOT NULL,
  `curClaveAlu` char(8) NOT NULL,
  `curClaveCarrera` char(3) NOT NULL,
  `curClavePlan` char(4) DEFAULT NULL,
  `curGradoSemestre` smallint(6) DEFAULT NULL,
  `curGrupo` char(3) DEFAULT NULL,
  `curTipoBeca` char(1) DEFAULT NULL,
  `curPorcentajeBeca` smallint(6) DEFAULT NULL,
  `curObservBeca` char(30) DEFAULT NULL,
  `curFechaReg` date DEFAULT NULL,
  `curFechaBaja` date DEFAULT NULL,
  `curEstado` char(1) DEFAULT NULL,
  `curTipoIngreso` char(2) DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `persona_id` bigint(255) UNSIGNED NOT NULL,
  `aluClave` int(8) NOT NULL COMMENT 'Clave de pago del alumno',
  `aluEstado` enum('R','B','N','E') NOT NULL DEFAULT 'N' COMMENT 'Estado alumno: B: baja, R: Reingreso, N: nuevo ingreso, E: egresado ',
  `aluFechaIngr` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de Ingreso',
  `aluNivelIngr` tinyint(4) NOT NULL COMMENT 'Nivel escolar de ingreso',
  `aluGradoIngr` tinyint(4) NOT NULL COMMENT 'Grado escolar de ingreso',
  `aluMatricula` varchar(15) DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Personas que son alumnos del plantel';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aulas`
--

CREATE TABLE `aulas` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `ubicacion_id` bigint(255) UNSIGNED NOT NULL,
  `aulaClave` char(3) NOT NULL,
  `aulaCupo` smallint(6) DEFAULT NULL,
  `aulaDescripcion` varchar(45) DEFAULT NULL,
  `aulaUbicacion` varchar(45) DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `aulas`
--

INSERT INTO `aulas` (`id`, `ubicacion_id`, `aulaClave`, `aulaCupo`, `aulaDescripcion`, `aulaUbicacion`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'A7A', 30, 'AUDIOVISUAL 7A', 'PLANTA ALTA CENTRO CULTURAL', 3, '2018-12-05 23:23:56', '2018-12-05 23:24:42', NULL),
(2, 1, '316', 25, 'AULA DE DISEÑO/ARQUITECTURA', 'TERCER PISO ALA NORTE', 3, '2018-12-05 23:26:23', '2018-12-05 23:26:23', NULL),
(3, 1, '318', 25, 'AULA DE DISEÑO/ARQUITECTURA', 'TERCER PISO ALA NORTE', 3, '2018-12-05 23:26:53', '2018-12-05 23:26:53', NULL),
(4, 1, 'LAR', 25, 'LABORATORIO DE ARQUITECTURA', 'PLANTA BAJA ALA NORTE', 3, '2018-12-05 23:27:31', '2018-12-05 23:27:31', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `inscrito_id` bigint(255) UNSIGNED NOT NULL,
  `inscCalificacionParcial1` smallint(6) DEFAULT NULL,
  `inscFaltasParcial1` smallint(6) DEFAULT NULL,
  `inscCalificacionParcial2` smallint(6) DEFAULT NULL,
  `inscFaltasParcial2` smallint(6) DEFAULT NULL,
  `inscCalificacionParcial3` smallint(6) DEFAULT NULL,
  `inscFaltasParcial3` smallint(6) DEFAULT NULL,
  `inscPromedioParciales` double DEFAULT NULL,
  `inscCalificacionOrdinario` smallint(6) DEFAULT NULL,
  `incsCalificacionFinal` smallint(6) DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cgt`
--

CREATE TABLE `cgt` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `plan_id` bigint(255) UNSIGNED NOT NULL,
  `periodo_id` bigint(255) UNSIGNED NOT NULL,
  `cgtGradoSemestre` smallint(6) NOT NULL,
  `cgtGrupo` char(3) NOT NULL,
  `cgtTurno` char(1) NOT NULL,
  `cgtCupo` smallint(6) DEFAULT NULL,
  `empleado_id` bigint(255) UNSIGNED NOT NULL,
  `cgtEstado` char(1) DEFAULT NULL,
  `cgtDescripcion` char(30) DEFAULT NULL,
  `cgtTotalRegistrados` smallint(6) DEFAULT NULL,
  `cgtInscritos` smallint(6) DEFAULT NULL,
  `cgtPreinscritos` smallint(6) DEFAULT NULL,
  `cgtBaja` smallint(6) DEFAULT NULL,
  `cgtOtros` smallint(6) DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clavePagoSufijos`
--

CREATE TABLE `clavePagoSufijos` (
  `cpsIdentificador` int(11) NOT NULL DEFAULT '1' COMMENT 'identificador',
  `cpsSufijo` int(4) UNSIGNED ZEROFILL DEFAULT '0001' COMMENT 'Sufijo consecutivo de la clave de pago'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Almacena el consecutivo de los cuatro últimos dígitos de la clave de pago.';

--
-- Volcado de datos para la tabla `clavePagoSufijos`
--

INSERT INTO `clavePagoSufijos` (`cpsIdentificador`, `cpsSufijo`) VALUES
(1, 0101);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concAextra`
--

CREATE TABLE `concAextra` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `aextClave` char(3) NOT NULL,
  `aextConcP1` char(2) NOT NULL,
  `aextConcP2` char(2) DEFAULT NULL,
  `aextConcP3` char(2) DEFAULT NULL,
  `aextConcP4` char(2) DEFAULT NULL,
  `aextConcP5` char(2) DEFAULT NULL,
  `aextConcP6` char(2) DEFAULT NULL,
  `aextConcP7` char(2) DEFAULT NULL,
  `aextConcP8` char(2) DEFAULT NULL,
  `aextConcP9` char(2) DEFAULT NULL,
  `aextConcP10` char(2) DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas`
--

CREATE TABLE `cuotas` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `cuoTipo` char(1) NOT NULL COMMENT 'D-departamento,E-escuela,P-programa',
  `dep_esc_prog_id` bigint(255) UNSIGNED NOT NULL,
  `cuoAnio` int(4) NOT NULL,
  `cuoImportePadresFamilia` decimal(8,2) DEFAULT NULL,
  `cuoImporteOrdinarioUady` decimal(8,2) DEFAULT NULL,
  `cuoImporteMensualidad10` decimal(8,2) DEFAULT NULL,
  `cuoImporteMensualidad11` decimal(8,2) DEFAULT NULL,
  `cuoImporteMensualidad12` decimal(8,2) DEFAULT NULL,
  `cuoImporteInscripcion1` decimal(8,2) DEFAULT NULL,
  `cuoFechaLimiteInscripcion1` date DEFAULT NULL,
  `cuoImporteInscripcion2` decimal(8,2) DEFAULT NULL,
  `cuoFechaLimiteInscripcion2` date DEFAULT NULL,
  `cuoImporteInscripcion3` decimal(8,2) DEFAULT NULL,
  `cuoFechaLimiteInscripcion3` date DEFAULT NULL,
  `cuoImporteVencimiento` decimal(8,2) DEFAULT NULL,
  `cuoImporteProntoPago` decimal(8,2) DEFAULT NULL,
  `cuoDiasProntoPago` smallint(6) DEFAULT NULL,
  `cuoNumeroCuenta` varchar(16) DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `alumno_id` bigint(255) UNSIGNED NOT NULL,
  `cgt_id` bigint(255) UNSIGNED NOT NULL,
  `periodo_id` bigint(255) UNSIGNED NOT NULL,
  `curTipoBeca` char(1) DEFAULT NULL,
  `curPorcentajeBeca` smallint(6) DEFAULT NULL,
  `curObservacionesBeca` char(30) DEFAULT NULL,
  `curFechaRegistro` date DEFAULT NULL,
  `curFechaBaja` date DEFAULT NULL,
  `curEstado` char(1) DEFAULT 'R' COMMENT 'P= preinscrito, R=regular, C=condicionado, A=condicionado2, B=baja',
  `curTipoIngreso` char(2) DEFAULT NULL COMMENT '''NI'' => ''NUEVO INGRESO'',\n            ''PI'' => ''PRIMER INGRESO'',\n            ''RO'' => ''REPETIDOR'',\n            ''RI'' => ''REINSCRIPCIÓN'',\n            ''RE'' => ''REINGRESO'',\n            ''EQ'' => ''REVALIDACIÓN'',\n            ''OY'' => ''OYENTE'',\n            ''XX'' => ''OTRO'',',
  `curImporteInscripcion` decimal(8,2) DEFAULT NULL,
  `curImporteMensualidad` decimal(8,2) DEFAULT NULL,
  `curImporteVencimiento` decimal(8,2) DEFAULT NULL,
  `curImporteDescuento` decimal(8,2) DEFAULT NULL,
  `curDiasProntoPago` smallint(6) DEFAULT NULL,
  `curPlanPago` char(1) DEFAULT NULL,
  `curOpcionTitulo` char(1) DEFAULT NULL,
  `curAnioCuotas` smallint(6) DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `ubicacion_id` bigint(255) UNSIGNED NOT NULL,
  `depNivel` tinyint(10) NOT NULL,
  `depClave` char(3) NOT NULL COMMENT 'Clave de tres carácteres del departamento',
  `depNombre` varchar(45) NOT NULL COMMENT 'Nombre completo',
  `depNombreCorto` varchar(15) NOT NULL COMMENT 'Nombre abreviado',
  `depClaveOficial` varchar(20) DEFAULT NULL COMMENT 'Clave oficial',
  `depNombreOficial` varchar(50) DEFAULT NULL COMMENT 'Nombre ante la institución educativa',
  `perAnte` bigint(255) UNSIGNED NOT NULL COMMENT 'Período anterior',
  `perActual` bigint(255) UNSIGNED NOT NULL COMMENT 'Período actual',
  `perSig` bigint(255) UNSIGNED NOT NULL COMMENT 'Período siguiente',
  `depCalMinAprob` tinyint(3) DEFAULT '60' COMMENT 'Calificación Mínima aprobatoria',
  `depCupoGpo` tinyint(3) DEFAULT '30' COMMENT 'Cupo Máximo',
  `depTituloDoc` varchar(60) DEFAULT NULL COMMENT 'Título del firmante',
  `depNombreDoc` varchar(60) DEFAULT NULL COMMENT 'Nombre del firmante',
  `depPuestoDoc` varchar(60) DEFAULT NULL COMMENT 'Puesto del firmante',
  `depIncorporadoA` varchar(70) DEFAULT NULL COMMENT 'Institución educativa a donde está incorporado el departamento',
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catálogo de Departamentos';

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `ubicacion_id`, `depNivel`, `depClave`, `depNombre`, `depNombreCorto`, `depClaveOficial`, `depNombreOficial`, `perAnte`, `perActual`, `perSig`, `depCalMinAprob`, `depCupoGpo`, `depTituloDoc`, `depNombreDoc`, `depPuestoDoc`, `depIncorporadoA`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 5, 'SUP', 'SUPERIOR', 'SUP', NULL, NULL, 1, 2, 3, 60, 30, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edocta`
--

CREATE TABLE `edocta` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `edoFechaOper` date NOT NULL,
  `edoAnioPago` char(4) DEFAULT NULL,
  `edoClaveAlu` char(8) NOT NULL,
  `edoMesPago` char(2) DEFAULT NULL,
  `edoDigPago` char(1) DEFAULT NULL,
  `edoDescripcion` char(30) DEFAULT NULL,
  `edoImpAbono` double(17,2) DEFAULT NULL,
  `edoImpCargo` double(17,2) DEFAULT NULL,
  `edoEstado` char(1) DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `edocta`
--

INSERT INTO `edocta` (`id`, `edoFechaOper`, `edoAnioPago`, `edoClaveAlu`, `edoMesPago`, `edoDigPago`, `edoDescripcion`, `edoImpAbono`, `edoImpCargo`, `edoEstado`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2018-09-30', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(2, '2018-09-30', '2018', '14184515', '01', '', 'Refer: 17864218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(3, '2018-09-30', '2018', '15150041', '02', '', 'Refer: 17815228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(4, '2018-09-29', '2018', '15150277', '02', '', 'Refer: 17815270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(5, '2018-09-29', '2018', '15173772', '02', '', 'Refer: 17816222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(6, '2018-09-29', '2018', '15186076', '01', '', 'Refer: 17864273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(7, '2018-09-28', '2002', '00000914', '9', '', 'Refer: SICOCO S', 0.00, 288.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(8, '2018-09-28', '2002', '00000914', '9', '', 'Refer: SICOCO S', 0.00, 1800.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(9, '2018-09-28', '2018', '14160958', '01', '', 'Refer: 17656220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(10, '2018-09-28', '2017', '14184515', '11', '', 'Refer: 17652232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(11, '2018-09-28', '2018', '14184605', '01', '', 'Refer: 17656290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(12, '2018-09-28', '2016', '15150372', '04', '', 'Refer: 17655250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(13, '2018-09-28', '2018', '15150317', '01', '', 'Refer: 17654213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(14, '2018-09-28', '2018', '16091075', '74', '', 'Refer: 17712220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(15, '2018-09-28', '2018', '15184622', '01', '', 'Refer: 17653257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(16, '2018-09-28', '2018', '15186391', '01', '', 'Refer: 17658292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(17, '2018-09-28', '2018', '14186128', '01', '', 'Refer: 17656205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(18, '2018-09-28', '2018', '15174036', '01', '', 'Refer: 17654202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(19, '2018-09-28', '2018', '14185697', '01', '', 'Refer: 17656254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(20, '2018-09-28', '2018', '14172725', '01', '', 'Refer: 17656272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(21, '2018-09-28', '2018', '15173965', '01', '', 'Refer: 17651228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(22, '2018-09-27', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANORTE/I', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(23, '2018-09-27', '2018', '14161243', '01', '', 'Refer: 17656246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(24, '2018-09-27', '2018', '15172685', '11', '', 'Refer: 20606225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(25, '2018-09-27', '2018', '15159376', '01', '', 'Refer: 17658212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(26, '2018-09-26', '20AG', 'DEN DE P', 'O', '', 'Refer: EXTRANJE', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(27, '2018-09-26', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANORTE/I', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(28, '2018-09-26', '2018', '14185164', '02', '', 'Refer: 17817287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(29, '2018-09-26', '2018', '14185164', '01', '', 'Refer: 17656291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(30, '2018-09-26', '2017', '15161078', '11', '', 'Refer: 17654291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(31, '2018-09-25', '2018', '15150060', '99', '', 'Refer: 17675260', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(32, '2018-09-25', '2018', '14185914', '02', '', 'Refer: 17817261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(33, '2018-09-25', '2018', '15186155', '02', '', 'Refer: 17814278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(34, '2018-09-25', '2018', '15185154', '01', '', 'Refer: 17653252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(35, '2018-09-24', '2018', '15186211', '01', '', 'Refer: 17653203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(36, '2018-09-24', '2017', '15150060', '11', '', 'Refer: 17654245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(37, '2018-09-24', '2018', '15185596', '01', '', 'Refer: 17658265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(38, '2018-09-24', '2018', '15185318', '01', '', 'Refer: 17653278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(39, '2018-09-24', '2018', '15161750', '11', '', 'Refer: 20766227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(40, '2018-09-24', '2018', '54186178', '03', '', 'Refer: 18127254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(41, '2018-09-24', '2018', '54186178', '02', '', 'Refer: 17817237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(42, '2018-09-21', '2018', '15161485', '01', '', 'Refer: 17654244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(43, '2018-09-21', '2018', '14160539', '01', '', 'Refer: 17656234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:43', '2018-12-06 02:49:43', NULL),
(44, '2018-09-20', '2016', '15150372', '03', '', 'Refer: 17658276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(45, '2018-09-20', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(46, '2018-09-19', '2018', '15161650', '01', '', 'Refer: 17655294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(47, '2018-09-19', '2018', '15161379', '01', '', 'Refer: 17650206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(48, '2018-09-19', '2018', '14173761', '99', '', 'Refer: 17654239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(49, '2018-09-19', '2018', '14186001', '01', '', 'Refer: 17656279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(50, '2018-09-19', '20ID', 'EI RECIB', 'OS', '', 'Refer: ANTANDER', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(51, '2018-09-19', '2018', '15185244', '99', '', 'Refer: 17615277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(52, '2018-09-18', '2018', '15173840', '99', '', 'Refer: 17535289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(53, '2018-09-18', '2018', '15185434', '01', '', 'Refer: 17657232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(54, '2018-09-18', '2016', '14161143', '09', '', 'Refer: 17658224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(55, '2018-09-18', '2017', '14161143', '06', '', 'Refer: 17658204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(56, '2018-09-18', '2017', '14161143', '07', '', 'Refer: 17658217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(57, '2018-09-18', '20ID', 'EI RECIB', 'OS', '', 'Refer: ANTANDER', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(58, '2018-09-18', '2018', '15185398', '01', '', 'Refer: 17653285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(59, '2018-09-17', '2018', '14173292', '01', '', 'Refer: 17527207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(60, '2018-09-17', '2018', '15159252', '01', '', 'Refer: 17528249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(61, '2018-09-17', '2018', '15161231', '01', '', 'Refer: 17524225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(62, '2018-09-17', '2018', '15185258', '01', '', 'Refer: 17528211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(63, '2018-09-17', '2018', '15147421', '01', '', 'Refer: 17520262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(64, '2018-09-17', '2018', '14186161', '01', '', 'Refer: 17527220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(65, '2018-09-17', '2018', '15159386', '01', '', 'Refer: 17524297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(66, '2018-09-17', '2018', '15161223', '01', '', 'Refer: 17524234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(67, '2018-09-17', '2018', '14161125', '01', '', 'Refer: 17527265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(68, '2018-09-17', '2018', '14172792', '01', '', 'Refer: 17527273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(69, '2018-09-17', '2018', '15185629', '01', '', 'Refer: 17528251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(70, '2018-09-17', '2018', '15172427', '01', '', 'Refer: 17529225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(71, '2018-09-17', '2018', '15150231', '01', '', 'Refer: 17524280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(72, '2018-09-17', '2018', '15160672', '01', '', 'Refer: 17529208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(73, '2018-09-17', '2018', '14173111', '01', '', 'Refer: 17527269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(74, '2018-09-17', '2018', '15174004', '01', '', 'Refer: 17522239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(75, '2018-09-17', '2018', '15173150', '01', '', 'Refer: 17524284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(76, '2018-09-17', '2018', '15161941', '01', '', 'Refer: 17528215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(77, '2018-09-17', '2018', '15150488', '01', '', 'Refer: 17524262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(78, '2018-09-17', '2018', '14173899', '01', '', 'Refer: 17527289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(79, '2018-09-17', '2018', '34173306', '01', '', 'Refer: 17527282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(80, '2018-09-17', '20ID', 'EI RECIB', 'OS', '', 'Refer: ANTANDER', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(81, '2018-09-17', '2018', '15172773', '01', '', 'Refer: 17525245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(82, '2018-09-17', '2018', '15186315', '01', '', 'Refer: 17524207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(83, '2018-09-17', '2018', '15174149', '01', '', 'Refer: 17524292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(84, '2018-09-17', '2018', '15161934', '01', '', 'Refer: 17520228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(85, '2018-09-17', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANORTE/I', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(86, '2018-09-17', '2018', '15173015', '01', '', 'Refer: 17524270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(87, '2018-09-17', '2018', '15173883', '01', '', 'Refer: 17525294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(88, '2018-09-17', '2018', '15161825', '01', '', 'Refer: 17521222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(89, '2018-09-17', '2018', '15160552', '01', '', 'Refer: 17520242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(90, '2018-09-17', '2018', '15172442', '01', '', 'Refer: 17522202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(91, '2018-09-17', '2018', '15173392', '01', '', 'Refer: 17528250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(92, '2018-09-17', '2018', '15186214', '01', '', 'Refer: 17524276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(94, '2018-09-17', '2018', '15160940', '01', '', 'Refer: 17524230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(95, '2018-09-17', '2018', '15159364', '01', '', 'Refer: 17527288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(96, '2018-09-17', '2018', '15160822', '01', '', 'Refer: 17524209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(97, '2018-09-17', '2018', '14172693', '01', '', 'Refer: 17527267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(98, '2018-09-17', '2018', '15160535', '01', '', 'Refer: 17528256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(99, '2018-09-17', '2018', '14172794', '01', '', 'Refer: 17527295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(100, '2018-09-17', '2018', '15184745', '01', '', 'Refer: 17524276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(101, '2018-09-17', '2018', '15161321', '01', '', 'Refer: 17528281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(102, '2018-09-17', '2018', '15173873', '01', '', 'Refer: 17526294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(103, '2018-09-17', '2018', '14172648', '01', '', 'Refer: 17527257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(104, '2018-09-17', '2018', '15173738', '01', '', 'Refer: 17524254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(105, '2018-09-17', '2018', '15172976', '01', '', 'Refer: 17529267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(106, '2018-09-17', '2018', '15161512', '01', '', 'Refer: 17524261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(107, '2018-09-17', '2018', '14185665', '01', '', 'Refer: 17527233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(108, '2018-09-17', '2018', '15147708', '01', '', 'Refer: 17524222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(109, '2018-09-17', '2018', '14172805', '01', '', 'Refer: 17527206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(110, '2018-09-17', '2018', '15186096', '01', '', 'Refer: 17525284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(111, '2018-09-17', '2018', '15185773', '01', '', 'Refer: 17524215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(112, '2018-09-17', '2018', '15160530', '01', '', 'Refer: 17524246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(113, '2018-09-17', '2018', '15185168', '01', '', 'Refer: 17524252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(114, '2018-09-17', '2018', '15160884', '01', '', 'Refer: 17529277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(115, '2018-09-17', '2018', '15185275', '01', '', 'Refer: 17655235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(116, '2018-09-17', '2018', '15172435', '01', '', 'Refer: 17529216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(117, '2018-09-17', '2018', '14160663', '01', '', 'Refer: 17527264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(118, '2018-09-17', '2018', '15185569', '01', '', 'Refer: 17524234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(119, '2018-09-17', '2018', '15158934', '01', '', 'Refer: 17524293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(120, '2018-09-17', '2018', '15185402', '03', '', 'Refer: 18124229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(121, '2018-09-17', '2018', '14161856', '01', '', 'Refer: 17527240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(122, '2018-09-17', '2018', '15185402', '02', '', 'Refer: 17814212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(123, '2018-09-17', '2000', '15173053', '97', '', 'Refer: 17524259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(125, '2018-09-17', '2018', '15185402', '01', '', 'Refer: 17524256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(126, '2018-09-17', '2018', '15161443', '01', '', 'Refer: 17524294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(127, '2018-09-17', '2018', '15161691', '01', '', 'Refer: 17524274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(128, '2018-09-17', '2018', '14159024', '01', '', 'Refer: 17529295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(129, '2018-09-17', '2018', '15172848', '01', '', 'Refer: 17529233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(130, '2018-09-17', '2018', '15172552', '01', '', 'Refer: 17524258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(131, '2018-09-17', '2018', '15173333', '01', '', 'Refer: 17526254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(132, '2018-09-17', '2018', '14160782', '01', '', 'Refer: 17527296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(133, '2018-09-17', '2018', '14184495', '01', '', 'Refer: 17527219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(134, '2018-09-17', '2018', '15172836', '01', '', 'Refer: 17529295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(135, '2018-09-17', '2018', '15159395', '01', '', 'Refer: 17524202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(136, '2018-09-17', '2018', '15173810', '01', '', 'Refer: 17529222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(137, '2018-09-17', '2018', '15161627', '01', '', 'Refer: 17527288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(138, '2018-09-17', '2018', '15147289', '01', '', 'Refer: 17520297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(139, '2018-09-17', '2018', '15184829', '01', '', 'Refer: 17524214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(140, '2018-09-17', '2018', '15161121', '01', '', 'Refer: 17524292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(141, '2018-09-17', '2018', '15173143', '01', '', 'Refer: 17529272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(142, '2018-09-17', '2018', '14174400', '01', '', 'Refer: 17528231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(143, '2018-09-17', '2018', '15161134', '01', '', 'Refer: 17524241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(144, '2018-09-17', '2018', '15159114', '01', '', 'Refer: 17527286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(145, '2018-09-17', '20S', 'P.CHEQUE', 'DE', '', 'Refer:  OTRO BA', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(146, '2018-09-17', '2018', '15185982', '01', '', 'Refer: 17524251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(147, '2018-09-17', '2018', '15161543', '01', '', 'Refer: 17524214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(148, '2018-09-17', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(150, '2018-09-17', '2003', '15159388', '22', '', 'Refer: 17529216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(151, '2018-09-17', '2018', '15150169', '01', '', 'Refer: 17524293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(152, '2018-09-17', '2018', '15160710', '01', '', 'Refer: 17529222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(153, '2018-09-17', '2018', '15186095', '01', '', 'Refer: 17524260', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(154, '2018-09-17', '2018', '15161304', '01', '', 'Refer: 17529204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(155, '2018-09-17', '2018', '15186141', '01', '', 'Refer: 17524265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(156, '2018-09-17', '2018', '15147403', '01', '', 'Refer: 17524213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(157, '2018-09-17', '2018', '15185036', '01', '', 'Refer: 17524271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(158, '2018-09-17', '2018', '15158904', '01', '', 'Refer: 17524254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(159, '2018-09-17', '2018', '15159163', '01', '', 'Refer: 17525217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(160, '2018-09-17', '2018', '15172968', '01', '', 'Refer: 17529276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(161, '2018-09-17', '2018', '14185006', '01', '', 'Refer: 17522290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(162, '2018-09-17', '2018', '14186167', '01', '', 'Refer: 17527286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(163, '2018-09-17', '2018', '15173077', '01', '', 'Refer: 17524273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(166, '2018-09-17', '2018', '15172684', '01', '', 'Refer: 17528291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(167, '2018-09-17', '2018', '15148406', '01', '', 'Refer: 17520213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(168, '2018-09-17', '2018', '15185871', '01', '', 'Refer: 17524210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(169, '2018-09-17', '2018', '14172818', '01', '', 'Refer: 17527252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(170, '2018-09-17', '2018', '15185783', '01', '', 'Refer: 17524228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(172, '2018-09-17', '2018', '15160889', '01', '', 'Refer: 17524267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(173, '2018-09-17', '2018', '15172413', '01', '', 'Refer: 17520245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(175, '2018-09-16', '2018', '15160553', '01', '', 'Refer: 17524208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(176, '2018-09-16', '2018', '14159377', '01', '', 'Refer: 17529250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(177, '2018-09-16', '2018', '15185175', '01', '', 'Refer: 17524232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(178, '2018-09-16', '2018', '15162239', '01', '', 'Refer: 17520280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(179, '2018-09-16', '2018', '14147348', '01', '', 'Refer: 17529258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(180, '2018-09-16', '2018', '15162001', '01', '', 'Refer: 17524268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(181, '2018-09-16', '2018', '15159827', '01', '', 'Refer: 17523205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(182, '2018-09-16', '2018', '15185110', '01', '', 'Refer: 17524293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(183, '2018-09-16', '2000', '15161021', '01', '', 'Refer: 17527236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(184, '2018-09-16', '2018', '15161004', '01', '', 'Refer: 17520230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(185, '2018-09-16', '2018', '14172703', '01', '', 'Refer: 17527264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(186, '2018-09-16', '2018', '15159576', '01', '', 'Refer: 17528273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(187, '2018-09-16', '2018', '15159319', '01', '', 'Refer: 17525252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(188, '2018-09-16', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANORTE/I', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(189, '2018-09-16', '2018', '15184640', '01', '', 'Refer: 17520249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(190, '2018-09-15', '2018', '15173052', '01', '', 'Refer: 17529257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(191, '2018-09-15', '2018', '15173961', '01', '', 'Refer: 17524250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(192, '2018-09-15', '2018', '15160784', '01', '', 'Refer: 17529260', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(193, '2018-09-15', '2018', '15174198', '01', '', 'Refer: 17524249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(194, '2018-09-15', '2018', '15184756', '01', '', 'Refer: 17524203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(195, '2018-09-15', '2018', '15150290', '01', '', 'Refer: 17528205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(196, '2018-09-15', '2018', '15172390', '01', '', 'Refer: 17525267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(197, '2018-09-15', '2018', '15172423', '01', '', 'Refer: 17525226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(198, '2018-09-15', '2018', '14161933', '01', '', 'Refer: 17527295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(199, '2018-09-15', '2018', '15185236', '01', '', 'Refer: 17524208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(200, '2018-09-15', '2018', '15173692', '01', '', 'Refer: 17523236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(201, '2018-09-15', '2018', '15160887', '01', '', 'Refer: 17520290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(202, '2018-09-15', '2018', '15172960', '03', '', 'Refer: 18129258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(203, '2018-09-15', '2018', '15160630', '01', '', 'Refer: 17520211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(204, '2018-09-15', '2018', '15172960', '02', '', 'Refer: 17819241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(205, '2018-09-15', '2018', '15172960', '01', '', 'Refer: 17529285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(206, '2018-09-15', '2018', '15172833', '01', '', 'Refer: 17529262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(207, '2018-09-15', '2018', '15172832', '01', '', 'Refer: 17529251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(208, '2018-09-15', '2018', '15158902', '01', '', 'Refer: 17528284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(209, '2018-09-15', '2018', '15160723', '01', '', 'Refer: 17520248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(210, '2018-09-15', '2018', '15160997', '01', '', 'Refer: 17526204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(211, '2018-09-15', '2018', '14186116', '01', '', 'Refer: 17527210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(212, '2018-09-15', '2018', '15147422', '01', '', 'Refer: 17525241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(213, '2018-09-15', '2018', '15160982', '01', '', 'Refer: 17528259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(214, '2018-09-15', '2018', '15162000', '01', '', 'Refer: 17520205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(215, '2018-09-15', '2018', '15159318', '01', '', 'Refer: 17524228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(216, '2018-09-15', '2018', '15173152', '01', '', 'Refer: 17524209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(217, '2018-09-15', '2018', '15162030', '01', '', 'Refer: 17528251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(218, '2018-09-15', '2018', '15147739', '01', '', 'Refer: 17524272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(219, '2018-09-15', '2018', '15185218', '01', '', 'Refer: 17526230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(220, '2018-09-15', '2018', '14161657', '01', '', 'Refer: 17527217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(221, '2018-09-15', '2018', '15159727', '01', '', 'Refer: 17524201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(222, '2018-09-15', '2018', '14159227', '01', '', 'Refer: 17525213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(223, '2018-09-15', '2018', '15162116', '01', '', 'Refer: 17520204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(224, '2018-09-15', '2018', '34185909', '01', '', 'Refer: 17527284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(225, '2018-09-15', '2018', '15172406', '01', '', 'Refer: 17529285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(226, '2018-09-15', '2018', '15173781', '01', '', 'Refer: 17525255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(227, '2018-09-14', '2018', '15172789', '99', '', 'Refer: 17555244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(228, '2018-09-14', '2017', '15172789', '11', '', 'Refer: 17654282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(229, '2018-09-14', '2017', '15172789', '10', '', 'Refer: 17654269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(230, '2018-09-14', '2018', '15150027', '01', '', 'Refer: 17524202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(231, '2018-09-14', '2018', '15173036', '01', '', 'Refer: 17529275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(232, '2018-09-14', '2018', '15186264', '01', '', 'Refer: 17524244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(233, '2018-09-14', '2018', '14184658', '01', '', 'Refer: 17527234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(234, '2018-09-14', '20ID', 'EI RECIB', 'OS', '', 'Refer: ANTANDER', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(235, '2018-09-14', '2018', '15173075', '01', '', 'Refer: 17529219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(236, '2018-09-14', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(237, '2018-09-14', '2018', '14159719', '01', '', 'Refer: 17525210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(240, '2018-09-14', '2018', '15185126', '01', '', 'Refer: 17524275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(241, '2018-09-14', '2018', '15159467', '01', '', 'Refer: 17528254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(242, '2018-09-14', '2018', '14185133', '01', '', 'Refer: 17527281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(243, '2018-09-14', '2018', '15174166', '01', '', 'Refer: 17521246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(244, '2018-09-14', '2018', '15173780', '01', '', 'Refer: 17524231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:44', '2018-12-06 02:49:44', NULL),
(245, '2018-09-14', '2018', '15162192', '01', '', 'Refer: 17528271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(246, '2018-09-14', '2018', '15174213', '01', '', 'Refer: 17524204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(247, '2018-09-14', '2018', '15160828', '01', '', 'Refer: 17529243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(248, '2018-09-14', '2018', '15185203', '01', '', 'Refer: 17524233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(249, '2018-09-14', '2018', '15185761', '01', '', 'Refer: 17525290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(250, '2018-09-14', '2018', '15174096', '01', '', 'Refer: 17529275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(251, '2018-09-14', '2018', '15186212', '01', '', 'Refer: 17524254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(252, '2018-09-14', '2018', '15172483', '01', '', 'Refer: 17523278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(253, '2018-09-14', '2018', '15184632', '01', '', 'Refer: 17524213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(254, '2018-09-14', '2018', '15185953', '01', '', 'Refer: 17524223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(255, '2018-09-14', '2018', '15185908', '01', '', 'Refer: 17524213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(256, '2018-09-14', '2018', '15159515', '06', '', 'Refer: 19059264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(257, '2018-09-14', '2018', '15159515', '05', '', 'Refer: 18749247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(258, '2018-09-14', '2018', '15159515', '04', '', 'Refer: 18459291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(259, '2018-09-14', '2018', '15159515', '03', '', 'Refer: 18129267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(260, '2018-09-14', '2018', '15159515', '02', '', 'Refer: 17819250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(261, '2018-09-14', '2018', '15159515', '01', '', 'Refer: 17529294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(262, '2018-09-14', '2018', '15186233', '01', '', 'Refer: 17525207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(264, '2018-09-14', '2018', '15172694', '01', '', 'Refer: 17522226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(265, '2018-09-14', '2017', '15147974', '86', '', 'Refer: 17525207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(266, '2018-09-14', '2018', '15161894', '01', '', 'Refer: 17524244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(267, '2018-09-14', '2018', '15161071', '01', '', 'Refer: 17524243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(268, '2018-09-14', '2018', '15186134', '01', '', 'Refer: 17524285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(269, '2018-09-14', '2018', '15174037', '01', '', 'Refer: 17524240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(270, '2018-09-14', '2018', '14186112', '01', '', 'Refer: 17527263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(271, '2018-09-14', '2018', '15172982', '01', '', 'Refer: 17525281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(272, '2018-09-14', '2018', '15185464', '01', '', 'Refer: 17529227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(273, '2018-09-14', '2018', '15160750', '01', '', 'Refer: 17523293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(274, '2018-09-14', '2018', '15160749', '01', '', 'Refer: 17529263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(275, '2018-09-14', '2018', '15185902', '01', '', 'Refer: 17524244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(276, '2018-09-14', '2018', '14172979', '01', '', 'Refer: 17527261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(277, '2018-09-14', '2018', '14185416', '01', '', 'Refer: 17527242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(278, '2018-09-14', '2018', '15186188', '01', '', 'Refer: 17525213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(279, '2018-09-14', '2018', '14172659', '01', '', 'Refer: 17527281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(280, '2018-09-14', '2018', '15161170', '01', '', 'Refer: 17524249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(281, '2018-09-14', '2018', '15161120', '01', '', 'Refer: 17526210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(282, '2018-09-14', '2018', '15161118', '01', '', 'Refer: 17520207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(283, '2018-09-14', '2018', '14161136', '01', '', 'Refer: 17527289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(284, '2018-09-14', '20AG', 'DEN DE P', 'O', '', 'Refer: EXTRANJE', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(285, '2018-09-14', '2018', '15184882', '01', '', 'Refer: 17524215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(286, '2018-09-14', '2018', '14186150', '01', '', 'Refer: 17522228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(287, '2018-09-14', '2018', '15172396', '01', '', 'Refer: 17526249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(288, '2018-09-14', '2001', '15173469', '69', '', 'Refer: 17528258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(289, '2018-09-14', '2018', '15185917', '01', '', 'Refer: 17524215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(290, '2018-09-14', '2018', '14172484', '01', '', 'Refer: 17527231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(291, '2018-09-14', '2018', '15161015', '01', '', 'Refer: 17528261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(292, '2018-09-14', '2018', '15161313', '01', '', 'Refer: 17524238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(293, '2018-09-14', '2018', '14160671', '01', '', 'Refer: 17520261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(294, '2018-09-14', '2018', '15147769', '01', '', 'Refer: 17520259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(295, '2018-09-14', '2018', '15173356', '01', '', 'Refer: 17526216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(296, '2018-09-14', '2018', '15147677', '01', '', 'Refer: 17524285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(297, '2018-09-14', '2018', '14161205', '01', '', 'Refer: 17527256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(298, '2018-09-14', '2018', '14184824', '01', '', 'Refer: 17527282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(299, '2018-09-14', '2017', '15160885', '11', '', 'Refer: 17653278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(300, '2018-09-14', '2018', '15160885', '99', '', 'Refer: 17565270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(301, '2018-09-14', '2018', '15160515', '01', '', 'Refer: 17524275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(302, '2018-09-14', '2018', '14185102', '01', '', 'Refer: 17527231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(303, '2018-09-14', '2018', '54174010', '01', '', 'Refer: 17529257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(304, '2018-09-14', '2018', '15184986', '01', '', 'Refer: 17528231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(305, '2018-09-14', '2018', '15185096', '01', '', 'Refer: 17524252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(306, '2018-09-14', '2018', '15159739', '01', '', 'Refer: 17528288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(307, '2018-09-14', '2018', '15184848', '01', '', 'Refer: 17525242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(308, '2018-09-14', '2018', '14185696', '01', '', 'Refer: 17527283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(309, '2018-09-14', '2018', '15160827', '01', '', 'Refer: 17522238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(310, '2018-09-13', '2018', '15160913', '99', '', 'Refer: 17655273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(311, '2018-09-13', '2018', '15161010', '01', '', 'Refer: 17524251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(312, '2018-09-13', '2018', '14160799', '01', '', 'Refer: 17527289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(313, '2018-09-13', '2018', '15185981', '01', '', 'Refer: 17524240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(314, '2018-09-13', '2018', '15173127', '01', '', 'Refer: 17529290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(315, '2018-09-13', '2018', '15174053', '01', '', 'Refer: 17524222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(316, '2018-09-13', '2018', '15186343', '01', '', 'Refer: 17529289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(317, '2018-09-13', '2018', '15186060', '01', '', 'Refer: 17525276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(318, '2018-09-13', '2018', '15184747', '01', '', 'Refer: 17529266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(319, '2018-09-13', '2018', '15185216', '01', '', 'Refer: 17524279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(320, '2018-09-13', '2018', '15184999', '01', '', 'Refer: 17524225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(321, '2018-09-13', '2018', '15172962', '01', '', 'Refer: 17529210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(322, '2018-09-13', '2018', '15161234', '01', '', 'Refer: 17520206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(323, '2018-09-13', '2018', '15150031', '01', '', 'Refer: 17524246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(324, '2018-09-13', '2018', '15160623', '04', '', 'Refer: 18454280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(325, '2018-09-13', '2018', '15160623', '03', '', 'Refer: 18124256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(326, '2018-09-13', '2018', '15160623', '02', '', 'Refer: 17814239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(327, '2018-09-13', '2018', '15160623', '01', '', 'Refer: 17524283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(328, '2018-09-13', '2018', '15174208', '11', '', 'Refer: 20762290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(329, '2018-09-13', '2018', '15172695', '01', '', 'Refer: 17522237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(330, '2018-09-13', '2018', '15185166', '01', '', 'Refer: 17524230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(331, '2018-09-13', '2018', '15173473', '01', '', 'Refer: 17522271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(332, '2018-09-13', '2018', '15172397', '01', '', 'Refer: 17526260', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(333, '2018-09-13', '2018', '15173527', '01', '', 'Refer: 17524293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(334, '2018-09-13', '2018', '15173038', '01', '', 'Refer: 17524232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(335, '2018-09-13', '2018', '14150150', '01', '', 'Refer: 17524265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(336, '2018-09-13', '2018', '14173903', '01', '', 'Refer: 17527220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(337, '2018-09-13', '2018', '14173804', '01', '', 'Refer: 17527214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(338, '2018-09-13', '2018', '14162043', '01', '', 'Refer: 17527271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(339, '2018-09-13', '2018', '15185955', '01', '', 'Refer: 17527284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(340, '2018-09-13', '2018', '15184764', '01', '', 'Refer: 17527233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(341, '2018-09-13', '2018', '15172424', '01', '', 'Refer: 17524224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(342, '2018-09-13', '2018', '15184602', '01', '', 'Refer: 17524271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(343, '2018-09-13', '2018', '14159105', '01', '', 'Refer: 17529297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(344, '2018-09-13', '2018', '15162354', '01', '', 'Refer: 17529288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(345, '2018-09-13', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(346, '2018-09-13', '2018', '15161938', '01', '', 'Refer: 17524227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(347, '2018-09-13', '2018', '15185113', '01', '', 'Refer: 17524229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(348, '2018-09-13', '2018', '14161731', '01', '', 'Refer: 17527239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(349, '2018-09-13', '2018', '15161942', '01', '', 'Refer: 17520219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(350, '2018-09-13', '2018', '15159324', '01', '', 'Refer: 17524294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(351, '2018-09-13', '2018', '15161487', '10', '', 'Refer: 20445272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(352, '2018-09-13', '2018', '15147355', '01', '', 'Refer: 17659224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(353, '2018-09-13', '2018', '15161618', '01', '', 'Refer: 17526273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(354, '2018-09-13', '2018', '14172778', '01', '', 'Refer: 17527216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(355, '2018-09-13', '2018', '15161126', '01', '', 'Refer: 17520295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(356, '2018-09-12', '2017', '15172789', '09', '', 'Refer: 17654272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(357, '2018-09-12', '2017', '15172789', '08', '', 'Refer: 17654259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(358, '2018-09-12', '2017', '15172789', '07', '', 'Refer: 17654246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(359, '2018-09-12', '2017', '15172789', '06', '', 'Refer: 17654233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(360, '2018-09-12', '2018', '15173070', '03', '', 'Refer: 18124266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(361, '2018-09-12', '2018', '15173070', '02', '', 'Refer: 17814249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(362, '2018-09-12', '2018', '15173070', '01', '', 'Refer: 17524293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(363, '2018-09-12', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(364, '2018-09-12', '2018', '15159613', '01', '', 'Refer: 17524224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(365, '2018-09-12', '2018', '15184863', '01', '', 'Refer: 17524297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(366, '2018-09-12', '2018', '14173291', '02', '', 'Refer: 17817249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL);
INSERT INTO `edocta` (`id`, `edoFechaOper`, `edoAnioPago`, `edoClaveAlu`, `edoMesPago`, `edoDigPago`, `edoDescripcion`, `edoImpAbono`, `edoImpCargo`, `edoEstado`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(367, '2018-09-12', '2018', '14173291', '01', '', 'Refer: 17527293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(368, '2018-09-12', '2018', '54174294', '01', '', 'Refer: 17529245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(369, '2018-09-12', '2018', '15150277', '01', '', 'Refer: 17525217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(370, '2018-09-12', '2018', '15186064', '01', '', 'Refer: 17524210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(371, '2018-09-12', '2000', '15161625', '76', '', 'Refer: 17521294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(372, '2018-09-12', '2018', '14186191', '01', '', 'Refer: 17527259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(373, '2018-09-12', '2018', '15161111', '01', '', 'Refer: 17521240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(374, '2018-09-12', '2018', '15160829', '01', '', 'Refer: 17520234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(376, '2018-09-12', '2018', '15173772', '01', '', 'Refer: 17526266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(377, '2018-09-12', '2018', '15185938', '01', '', 'Refer: 17524252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(378, '2018-09-12', '2018', '15185647', '01', '', 'Refer: 17524203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(379, '2018-09-12', '2018', '15186048', '01', '', 'Refer: 17521286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(380, '2018-09-12', '2018', '15159081', '01', '', 'Refer: 17528243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(381, '2018-09-12', '2018', '14173055', '01', '', 'Refer: 17527251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(382, '2018-09-12', '2018', '15184522', '01', '', 'Refer: 17522254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(383, '2018-09-12', '2018', '15173064', '01', '', 'Refer: 17529292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(384, '2018-09-12', '2018', '15159963', '01', '', 'Refer: 17528295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(385, '2018-09-12', '2018', '14185177', '01', '', 'Refer: 17527280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(386, '2018-09-12', '2018', '15185149', '01', '', 'Refer: 17524237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(387, '2018-09-12', '2018', '14161013', '01', '', 'Refer: 17527213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(388, '2018-09-12', '2018', '14172562', '01', '', 'Refer: 17527297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(389, '2018-09-12', '2018', '14161159', '01', '', 'Refer: 17527251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(390, '2018-09-12', '2018', '15185200', '01', '', 'Refer: 17524297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(391, '2018-09-12', '2018', '15159159', '01', '', 'Refer: 17522231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(392, '2018-09-12', '2018', '14185049', '01', '', 'Refer: 17527246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(393, '2018-09-12', '2018', '15185151', '01', '', 'Refer: 17524259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(394, '2018-09-12', '2018', '15161685', '01', '', 'Refer: 17520253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(396, '2018-09-11', '2018', '15160582', '01', '', 'Refer: 17526262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(397, '2018-09-11', '2018', '15150041', '01', '', 'Refer: 17525272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(398, '2018-09-11', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANAMEX/0', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(399, '2018-09-11', '2018', '15160659', '01', '', 'Refer: 17524291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(400, '2018-09-11', '2018', '15173889', '01', '', 'Refer: 17521211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(401, '2018-09-11', '2018', '15186391', '99', '', 'Refer: 17615248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(402, '2018-09-11', '2018', '15161033', '01', '', 'Refer: 17526239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(403, '2018-09-11', '2018', '15185016', '01', '', 'Refer: 17524245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(404, '2018-09-11', '2018', '14173822', '01', '', 'Refer: 17527218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(405, '2018-09-11', '2018', '14172524', '01', '', 'Refer: 17527267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(406, '2018-09-11', '2018', '15185441', '05', '', 'Refer: 18907259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(407, '2018-09-11', '2018', '14184817', '01', '', 'Refer: 17527205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(408, '2018-09-11', '2000', '15184893', '01', '', 'Refer: 17528213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(409, '2018-09-11', '2018', '15185879', '02', '', 'Refer: 17814254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(410, '2018-09-11', '2018', '15185116', '01', '', 'Refer: 17529230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(411, '2018-09-11', '2018', '15185879', '01', '', 'Refer: 17524201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(412, '2018-09-11', '2018', '15185211', '01', '', 'Refer: 17525237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(413, '2018-09-11', '2018', '15185084', '01', '', 'Refer: 17524217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(414, '2018-09-11', '2018', '14173757', '01', '', 'Refer: 17527295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(415, '2018-09-11', '2018', '15186203', '01', '', 'Refer: 17525265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(416, '2018-09-11', '2018', '15185403', '01', '', 'Refer: 17527209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(417, '2018-09-11', '2017', '14173996', '03', '', 'Refer: 17654214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(418, '2018-09-11', '2017', '14173996', '05', '', 'Refer: 17654240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(419, '2018-09-11', '2018', '14173996', '01', '', 'Refer: 17527273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(420, '2018-09-11', '2018', '15186290', '01', '', 'Refer: 17528291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(421, '2018-09-11', '2018', '14161879', '01', '', 'Refer: 17527202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(422, '2018-09-11', '2018', '15173142', '01', '', 'Refer: 17529261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(423, '2018-09-11', '2018', '14184917', '01', '', 'Refer: 17527222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(424, '2018-09-11', '2018', '15185387', '01', '', 'Refer: 17524204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(425, '2018-09-11', '2018', '15162046', '01', '', 'Refer: 17528233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(426, '2018-09-11', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(427, '2018-09-10', '2018', '15160826', '02', '', 'Refer: 17814209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(428, '2018-09-10', '2018', '15160826', '01', '', 'Refer: 17524253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(429, '2018-09-10', '2018', '15160869', '99', '', 'Refer: 17655290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(430, '2018-09-10', '2018', '15150011', '01', '', 'Refer: 17524220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(431, '2018-09-10', '2018', '14172531', '01', '', 'Refer: 17527247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(432, '2018-09-10', '2018', '15184980', '01', '', 'Refer: 17529275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(433, '2018-09-10', '2018', '15185942', '01', '', 'Refer: 17524296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(434, '2018-09-10', '2018', '15186182', '01', '', 'Refer: 17524231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(435, '2018-09-10', '2018', '15159259', '01', '', 'Refer: 17529242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(436, '2018-09-10', '2018', '15184479', '01', '', 'Refer: 17525224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(437, '2018-09-10', '2018', '14173261', '01', '', 'Refer: 17527254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(438, '2018-09-10', '2018', '15184496', '01', '', 'Refer: 17524204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(439, '2018-09-10', '2018', '15185883', '10', '', 'Refer: 20446237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(440, '2018-09-10', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANORTE/I', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(441, '2018-09-10', '2018', '15160687', '01', '', 'Refer: 17529276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(442, '2018-09-10', '2018', '15160915', '01', '', 'Refer: 17525259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(443, '2018-09-10', '2018', '15184891', '01', '', 'Refer: 17524217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(444, '2018-09-10', '2018', '15185526', '10', '', 'Refer: 20447251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(445, '2018-09-10', '2018', '14172806', '01', '', 'Refer: 17527217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(446, '2018-09-10', '2017', '15147693', '86', '', 'Refer: 17475237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(447, '2018-09-09', '2018', '15173073', '01', '', 'Refer: 17529294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(448, '2018-09-08', '2018', '15159888', '02', '', 'Refer: 17810211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(449, '2018-09-08', '2018', '15159888', '01', '', 'Refer: 17520255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(450, '2018-09-08', '2018', '15173954', '01', '', 'Refer: 17529238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(451, '2018-09-08', '2018', '15147318', '01', '', 'Refer: 17524264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(452, '2018-09-08', '2018', '15184988', '01', '', 'Refer: 17529266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(453, '2018-09-08', '2018', '15172674', '01', '', 'Refer: 17524226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(454, '2018-09-08', '2018', '15185099', '01', '', 'Refer: 17524285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(455, '2018-09-08', '2018', '14172843', '01', '', 'Refer: 17527236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(456, '2018-09-07', '2018', '15161379', '99', '', 'Refer: 17425245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(457, '2018-09-07', '2018', '15159252', '99', '', 'Refer: 17435271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(458, '2018-09-07', '2018', '15184851', '01', '', 'Refer: 17524262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(459, '2018-09-07', '2018', '15186315', '99', '', 'Refer: 17545220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(460, '2018-09-07', '2018', '15174004', '99', '', 'Refer: 17655217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(461, '2018-09-07', '2018', '15174432', '10', '', 'Refer: 20446245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(462, '2018-09-07', '2018', '15150479', '01', '', 'Refer: 17524260', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(463, '2018-09-07', '2018', '15150197', '04', '', 'Refer: 18454210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:45', '2018-12-06 02:49:45', NULL),
(464, '2018-09-07', '2018', '15150197', '03', '', 'Refer: 18124283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(465, '2018-09-07', '2018', '15150197', '02', '', 'Refer: 17814266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(466, '2018-09-07', '2018', '15150197', '01', '', 'Refer: 17524213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(467, '2018-09-07', '2018', '15186369', '01', '', 'Refer: 17529284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(468, '2018-09-07', '2017', '14161013', '11', '', 'Refer: 17650287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(469, '2018-09-07', '2018', '14186145', '11', '', 'Refer: 20763256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(470, '2018-09-07', '2018', '15159150', '01', '', 'Refer: 17529223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(471, '2018-09-07', '2018', '14174361', '01', '', 'Refer: 17527290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(472, '2018-09-07', '2018', '15173886', '01', '', 'Refer: 17529282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(473, '2018-09-07', '2018', '14161107', '01', '', 'Refer: 17527261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(474, '2018-09-07', '2018', '15186094', '01', '', 'Refer: 17526275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(475, '2018-09-07', '2018', '14173192', '01', '', 'Refer: 17527287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(476, '2018-09-07', '2018', '15185071', '01', '', 'Refer: 17524268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(477, '2018-09-07', '20ID', 'EI RECIB', 'OS', '', 'Refer: ANTANDER', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(478, '2018-09-30', '2018', '15148547', '01', '', 'Refer: 17868231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(479, '2018-09-29', '2018', '15159070', '04', '', 'Refer: 18599219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(480, '2018-09-28', '2018', '15161046', '02', '', 'Refer: 17813202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(481, '2018-09-28', '2018', '15161046', '01', '', 'Refer: 17659297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(482, '2018-09-28', '2044', '00000873', '6', '', 'Refer: SICOCO S', 0.00, 328.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(483, '2018-09-28', '2044', '00000873', '6', '', 'Refer: SICOCO S', 0.00, 2050.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(484, '2018-09-28', '2017', '15172973', '12', '', 'Refer: 17657289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(485, '2018-09-28', '2017', '15161870', '10', '', 'Refer: 17656255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(486, '2018-09-28', '2018', '14186319', '01', '', 'Refer: 17652282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(487, '2018-09-28', '2018', '15174030', '01', '', 'Refer: 17659201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(488, '2018-09-28', '2018', '14162014', '99', '', 'Refer: 17653227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(489, '2018-09-28', '2018', '15158950', '01', '', 'Refer: 17657287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(490, '2018-09-28', '2018', '13186248', '01', '', 'Refer: 17659274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(491, '2018-09-27', '2017', '15173699', '11', '', 'Refer: 17650245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(492, '2018-09-26', '2018', '15161165', '99', '', 'Refer: 17651288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(493, '2018-09-26', '2018', '15172868', '99', '', 'Refer: 17653217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(494, '2018-09-26', '2017', '15147344', '10', '', 'Refer: 17659282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(495, '2018-09-26', '2018', '15159409', '99', '', 'Refer: 17657221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(496, '2018-09-26', '2017', '15147397', '86', '', 'Refer: 17655234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(497, '2018-09-25', '2018', '15185765', '01', '', 'Refer: 17659262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(498, '2018-09-25', '2017', '15160835', '12', '', 'Refer: 17656265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(499, '2018-09-25', '2018', '13147217', '01', '', 'Refer: 17657222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(500, '2018-09-25', '2018', '14135810', '01', '', 'Refer: 17659225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(501, '2018-09-24', '2018', '14173677', '01', '', 'Refer: 17652212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(502, '2018-09-24', '2018', '14185661', '02', '', 'Refer: 17815216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(503, '2018-09-22', '2018', '15162109', '04', '', 'Refer: 18599231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(504, '2018-09-22', '2018', '15148547', '99', '', 'Refer: 17651245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(505, '2018-09-21', '2018', '15162178', '01', '', 'Refer: 17659297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(506, '2018-09-21', '2017', '15161832', '11', '', 'Refer: 17658264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(507, '2018-09-20', '2018', '15173700', '99', '', 'Refer: 17653247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(508, '2018-09-20', '2017', '15173700', '12', '', 'Refer: 17656234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(509, '2018-09-20', '2018', '15162378', '01', '', 'Refer: 17653253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(510, '2018-09-20', '2017', '15173821', '12', '', 'Refer: 17556269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(511, '2018-09-20', '2018', '15159345', '01', '', 'Refer: 17659272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(512, '2018-09-20', '2018', '15173257', '01', '', 'Refer: 17659222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(513, '2018-09-20', '2017', '15172869', '11', '', 'Refer: 17658228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(514, '2018-09-20', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANORTE/I', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(515, '2018-09-20', '2018', '15173716', '99', '', 'Refer: 17653229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(516, '2018-09-19', '2017', '33161763', '10', '', 'Refer: 17658292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(517, '2018-09-19', '2018', '13160691', '01', '', 'Refer: 17650247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(518, '2018-09-18', '2018', '15160852', '01', '', 'Refer: 17650266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(519, '2018-09-18', '2018', '15172449', '01', '', 'Refer: 17653265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(520, '2018-09-18', '2018', '15184463', '01', '', 'Refer: 17659267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(521, '2018-09-18', '2018', '15172405', '01', '', 'Refer: 17653266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(522, '2018-09-18', '2018', '15147175', '86', '', 'Refer: 17655268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(523, '2018-09-18', '2018', '15136280', '86', '', 'Refer: 17595250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(524, '2018-09-17', '2018', '15160721', '01', '', 'Refer: 17520226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(525, '2018-09-17', '2018', '14159474', '01', '', 'Refer: 17525279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(526, '2018-09-17', '2018', '15162200', '01', '', 'Refer: 17520239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(527, '2018-09-17', '2018', '14136621', '01', '', 'Refer: 17528248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(528, '2018-09-17', '2018', '15184619', '01', '', 'Refer: 17524264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(529, '2018-09-17', '2018', '15160554', '01', '', 'Refer: 17523206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(530, '2018-09-17', '2018', '15161613', '01', '', 'Refer: 17528244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(531, '2018-09-17', '2018', '15185073', '01', '', 'Refer: 17523277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(532, '2018-09-17', '2018', '15184606', '01', '', 'Refer: 17523205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(533, '2018-09-17', '2018', '15185056', '01', '', 'Refer: 17523284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(534, '2018-09-17', '2018', '15147751', '01', '', 'Refer: 17520255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(535, '2018-09-17', '2018', '13186285', '01', '', 'Refer: 17520203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(536, '2018-09-17', '2018', '14159367', '01', '', 'Refer: 17525282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(537, '2018-09-17', '2018', '14184497', '07', '', 'Refer: 19361220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(538, '2018-09-17', '2018', '24124577', '01', '', 'Refer: 17525279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(539, '2018-09-17', '2018', '15162089', '01', '', 'Refer: 17523253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(540, '2018-09-17', '2018', '15172385', '01', '', 'Refer: 17520244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(541, '2018-09-17', '2018', '13186144', '01', '', 'Refer: 17520220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(542, '2018-09-17', '2018', '15160785', '01', '', 'Refer: 17523290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(543, '2018-09-17', '2018', '15172450', '01', '', 'Refer: 17523206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(544, '2018-09-17', '2018', '13172394', '01', '', 'Refer: 17521233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(545, '2018-09-17', '2018', '13172394', '99', '', 'Refer: 17654211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(546, '2018-09-17', '2018', '15186174', '01', '', 'Refer: 17520285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(547, '2018-09-17', '2018', '15160657', '01', '', 'Refer: 17520217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(548, '2018-09-17', '2018', '15162368', '01', '', 'Refer: 17521241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(549, '2018-09-17', '2018', '15161743', '01', '', 'Refer: 17525261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(550, '2018-09-17', '2018', '15148714', '01', '', 'Refer: 17521268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(551, '2018-09-17', '2018', '13172391', '01', '', 'Refer: 17523226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(552, '2018-09-17', '2018', '13172386', '01', '', 'Refer: 17520229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(553, '2018-09-17', '2018', '15173896', '01', '', 'Refer: 17523217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(554, '2018-09-17', '2018', '14184921', '01', '', 'Refer: 17521285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(555, '2018-09-17', '2018', '15161566', '01', '', 'Refer: 17523260', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(556, '2018-09-17', '2018', '15173932', '01', '', 'Refer: 17520267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(557, '2018-09-17', '2018', '15173524', '01', '', 'Refer: 17525273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(558, '2018-09-17', '2018', '14185713', '01', '', 'Refer: 17521279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(559, '2018-09-17', '2018', '15159641', '01', '', 'Refer: 17523228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(560, '2018-09-17', '2018', '15184793', '01', '', 'Refer: 17520267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(561, '2018-09-17', '2018', '15162051', '01', '', 'Refer: 17523223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(563, '2018-09-17', '2018', '15147438', '01', '', 'Refer: 17520255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(564, '2018-09-17', '2018', '15147245', '01', '', 'Refer: 17520201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(565, '2018-09-17', '2018', '15159140', '01', '', 'Refer: 17529210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(566, '2018-09-17', '2018', '15185950', '01', '', 'Refer: 17520235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(567, '2018-09-17', '2018', '13124525', '01', '', 'Refer: 17521207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(568, '2018-09-17', '2018', '14174042', '01', '', 'Refer: 17520230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(569, '2018-09-17', '2018', '13174137', '01', '', 'Refer: 17522205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(570, '2018-09-17', '2018', '23174049', '01', '', 'Refer: 17520214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(571, '2018-09-17', '2018', '15184631', '01', '', 'Refer: 17525215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(572, '2018-09-17', '2018', '13159237', '11', '', 'Refer: 20760218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(573, '2018-09-17', '2018', '15185756', '01', '', 'Refer: 17524222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(574, '2018-09-17', '2018', '15172678', '01', '', 'Refer: 17528225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(575, '2018-09-17', '2018', '15162119', '01', '', 'Refer: 17524289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(576, '2018-09-17', '2018', '13147747', '01', '', 'Refer: 17521295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(577, '2018-09-17', '2018', '15148202', '86', '', 'Refer: 17655277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(578, '2018-09-17', '2018', '15150071', '01', '', 'Refer: 17529266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(579, '2018-09-17', '2018', '14186334', '01', '', 'Refer: 17525222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(580, '2018-09-17', '2018', '15184585', '01', '', 'Refer: 17525210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(581, '2018-09-17', '2018', '15159077', '01', '', 'Refer: 17523231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(582, '2018-09-17', '2018', '15159813', '01', '', 'Refer: 17529226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(583, '2018-09-17', '2018', '15184505', '01', '', 'Refer: 17528242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(584, '2018-09-17', '2018', '15185005', '01', '', 'Refer: 17525234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(585, '2018-09-17', '2018', '15173962', '01', '', 'Refer: 17524261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(586, '2018-09-17', '2018', '15173782', '01', '', 'Refer: 17525266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(587, '2018-09-17', '2018', '23173535', '01', '', 'Refer: 17520223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(588, '2018-09-17', '2018', '15185474', '01', '', 'Refer: 17525285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(589, '2018-09-17', '2018', '15173149', '01', '', 'Refer: 17520221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(590, '2018-09-17', '2018', '15172417', '01', '', 'Refer: 17524244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(591, '2018-09-17', '2018', '13185033', '01', '', 'Refer: 17523296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(592, '2018-09-17', '2018', '15184450', '01', '', 'Refer: 17528235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(593, '2018-09-17', '2018', '15173285', '01', '', 'Refer: 17524201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(594, '2018-09-17', '2018', '15148595', '01', '', 'Refer: 17520239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(595, '2018-09-17', '2018', '15172747', '01', '', 'Refer: 17523224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(596, '2018-09-17', '2018', '14174041', '01', '', 'Refer: 17520219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(597, '2018-09-17', '2017', '15161992', '09', '', 'Refer: 17654297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(598, '2018-09-17', '2018', '15160686', '01', '', 'Refer: 17525213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(599, '2018-09-17', '2018', '15173791', '01', '', 'Refer: 17528210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(600, '2018-09-17', '2018', '15172418', '01', '', 'Refer: 17524255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(601, '2018-09-17', '2017', '14161764', '12', '', 'Refer: 17659224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(602, '2018-09-17', '2018', '14172431', '01', '', 'Refer: 17521249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(603, '2018-09-17', '2018', '15148595', '99', '', 'Refer: 17653217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(604, '2018-09-17', '2017', '14161764', '10', '', 'Refer: 17651288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(605, '2018-09-17', '2018', '15159021', '01', '', 'Refer: 17529275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(607, '2018-09-17', '2018', '15185693', '01', '', 'Refer: 17525237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(608, '2018-09-17', '2018', '15174412', '01', '', 'Refer: 17528279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(609, '2018-09-17', '2018', '15185695', '01', '', 'Refer: 17520291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(610, '2018-09-17', '2018', '15184499', '01', '', 'Refer: 17524237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(611, '2018-09-17', '2018', '15172724', '01', '', 'Refer: 17520223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(612, '2018-09-17', '2018', '15173698', '01', '', 'Refer: 17520263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(613, '2018-09-17', '2018', '15160548', '01', '', 'Refer: 17524250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(614, '2018-09-17', '2018', '13172542', '01', '', 'Refer: 17520264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(615, '2018-09-17', '2018', '14147737', '01', '', 'Refer: 17520282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(616, '2018-09-17', '2018', '15172381', '01', '', 'Refer: 17521213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(617, '2018-09-17', '2018', '15148162', '01', '', 'Refer: 17520293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(618, '2018-09-17', '2018', '13184572', '01', '', 'Refer: 17523209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(619, '2018-09-17', '2018', '15185396', '01', '', 'Refer: 17520251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(620, '2018-09-17', '2018', '15185419', '01', '', 'Refer: 17523236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(621, '2018-09-17', '2018', '15184596', '10', '', 'Refer: 20310259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(622, '2018-09-17', '2018', '15161712', '01', '', 'Refer: 17524295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(623, '2018-09-17', '2018', '15136898', '01', '', 'Refer: 17521275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(624, '2018-09-17', '2018', '15185519', '01', '', 'Refer: 17520214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(625, '2018-09-17', '2018', '13159154', '01', '', 'Refer: 17521234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(626, '2018-09-17', '2018', '13124506', '01', '', 'Refer: 17520276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(627, '2018-09-17', '2018', '15147872', '01', '', 'Refer: 17523251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(628, '2018-09-17', '2018', '15161360', '01', '', 'Refer: 17520218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(629, '2018-09-17', '2018', '14184900', '01', '', 'Refer: 17525203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(630, '2018-09-17', '2018', '14160667', '01', '', 'Refer: 17520217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(631, '2018-09-17', '2018', '13185003', '01', '', 'Refer: 17523257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(632, '2018-09-17', '2018', '14161849', '01', '', 'Refer: 17521279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(633, '2018-09-17', '2018', '15172777', '01', '', 'Refer: 17529244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(634, '2018-09-17', '2018', '14160729', '01', '', 'Refer: 17522230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(635, '2018-09-17', '2018', '15173166', '01', '', 'Refer: 17525279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(636, '2018-09-17', '2018', '15160776', '01', '', 'Refer: 17524204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(637, '2018-09-16', '2018', '14172402', '01', '', 'Refer: 17525273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(638, '2018-09-16', '2018', '15184670', '01', '', 'Refer: 17525256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(639, '2018-09-16', '2018', '15147629', '01', '', 'Refer: 17521203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(640, '2018-09-16', '2018', '15185223', '01', '', 'Refer: 17520207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(641, '2018-09-16', '2018', '15159632', '01', '', 'Refer: 17523226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(642, '2018-09-16', '2018', '14185768', '01', '', 'Refer: 17525257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(643, '2018-09-16', '2018', '15161246', '01', '', 'Refer: 17523280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(644, '2018-09-16', '2018', '15162079', '01', '', 'Refer: 17520201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(645, '2018-09-16', '2018', '14135864', '01', '', 'Refer: 17525212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(646, '2018-09-16', '2018', '15150073', '01', '', 'Refer: 17523210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(647, '2018-09-16', '2018', '15161837', '01', '', 'Refer: 17520244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(648, '2018-09-16', '2018', '13185989', '01', '', 'Refer: 17520250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(649, '2018-09-16', '2018', '13147333', '01', '', 'Refer: 17525222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(650, '2018-09-16', '2018', '15150383', '01', '', 'Refer: 17525203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(651, '2018-09-15', '2018', '15173902', '01', '', 'Refer: 17525293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(652, '2018-09-15', '2018', '15161841', '01', '', 'Refer: 17523230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(653, '2018-09-15', '2018', '15159962', '01', '', 'Refer: 17523219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(654, '2018-09-15', '2018', '15172653', '01', '', 'Refer: 17523273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(655, '2018-09-15', '2018', '15172517', '01', '', 'Refer: 17523248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(656, '2018-09-15', '2018', '15147475', '01', '', 'Refer: 17526255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(657, '2018-09-15', '2018', '13185626', '01', '', 'Refer: 17523224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(658, '2018-09-15', '2018', '15173335', '01', '', 'Refer: 17523237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(659, '2018-09-15', '2018', '15159638', '01', '', 'Refer: 17525221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(660, '2018-09-15', '2018', '15185895', '11', '', 'Refer: 20769221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(661, '2018-09-15', '2018', '15136814', '01', '', 'Refer: 17520211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(662, '2018-09-15', '2018', '14185446', '01', '', 'Refer: 17525255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(663, '2018-09-15', '2018', '14185142', '01', '', 'Refer: 17525257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(664, '2018-09-15', '2018', '15161046', '99', '', 'Refer: 17653282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(665, '2018-09-15', '2018', '14172700', '01', '', 'Refer: 17525205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(666, '2018-09-15', '2018', '15173345', '01', '', 'Refer: 17520211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(667, '2018-09-15', '2018', '15185401', '01', '', 'Refer: 17527284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(668, '2018-09-15', '2018', '15159289', '01', '', 'Refer: 17528268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(669, '2018-09-15', '2018', '13184637', '01', '', 'Refer: 17523229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(670, '2018-09-15', '2018', '15161310', '01', '', 'Refer: 17523289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(671, '2018-09-15', '2018', '15172384', '01', '', 'Refer: 17525201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(672, '2018-09-14', '2018', '15160537', '01', '', 'Refer: 17523213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(673, '2018-09-14', '2018', '15185866', '01', '', 'Refer: 17525265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(674, '2018-09-14', '2018', '15172395', '01', '', 'Refer: 17528264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(675, '2018-09-14', '2018', '15160549', '01', '', 'Refer: 17520209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(676, '2018-09-14', '2018', '15159302', '01', '', 'Refer: 17521207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(677, '2018-09-14', '2018', '13136632', '01', '', 'Refer: 17525220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(678, '2018-09-14', '2018', '13162379', '01', '', 'Refer: 17523265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(679, '2018-09-14', '2018', '14161799', '01', '', 'Refer: 17523256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(680, '2018-09-14', '2018', '15161420', '01', '', 'Refer: 17520280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(681, '2018-09-14', '2018', '14172393', '01', '', 'Refer: 17525287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(682, '2018-09-14', '2018', '15161254', '01', '', 'Refer: 17520232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(684, '2018-09-14', '2018', '15184853', '01', '', 'Refer: 17521245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(685, '2018-09-14', '2018', '15162363', '01', '', 'Refer: 17528277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(686, '2018-09-14', '2018', '15147265', '01', '', 'Refer: 17527221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(687, '2018-09-14', '2018', '14160670', '01', '', 'Refer: 17520250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(688, '2018-09-14', '2018', '14160669', '01', '', 'Refer: 17525207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(689, '2018-09-14', '2018', '15172415', '01', '', 'Refer: 17523209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(690, '2018-09-14', '2018', '14172428', '01', '', 'Refer: 17525268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(691, '2018-09-14', '2018', '15159197', '01', '', 'Refer: 17525203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(692, '2018-09-14', '2018', '15172873', '01', '', 'Refer: 17520294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(693, '2018-09-14', '2018', '14173406', '01', '', 'Refer: 17525239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(694, '2018-09-14', '2018', '14113568', '01', '', 'Refer: 17520250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(695, '2018-09-14', '2018', '13150352', '01', '', 'Refer: 17525224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(696, '2018-09-14', '2018', '15185941', '01', '', 'Refer: 17524285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(697, '2018-09-14', '2018', '13147704', '01', '', 'Refer: 17525262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(698, '2018-09-14', '2018', '15161403', '01', '', 'Refer: 17523229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(699, '2018-09-14', '2018', '13172404', '01', '', 'Refer: 17523256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(700, '2018-09-14', '2018', '14162180', '99', '', 'Refer: 17653291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(701, '2018-09-14', '2018', '15160791', '01', '', 'Refer: 17520220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(702, '2018-09-14', '2018', '15174435', '01', '', 'Refer: 17525202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:46', '2018-12-06 02:49:46', NULL),
(703, '2018-09-14', '2018', '15174413', '01', '', 'Refer: 17520283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(704, '2018-09-14', '2018', '15161358', '01', '', 'Refer: 17523235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(705, '2018-09-14', '2018', '15186218', '01', '', 'Refer: 17520268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(706, '2018-09-14', '2018', '15147440', '01', '', 'Refer: 17521290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(707, '2018-09-14', '2018', '13160642', '01', '', 'Refer: 17521233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(708, '2018-09-14', '2018', '15172564', '01', '', 'Refer: 17523280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(709, '2018-09-14', '2018', '15184493', '01', '', 'Refer: 17528223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(710, '2018-09-14', '2018', '15161927', '01', '', 'Refer: 17524203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(711, '2018-09-14', '2018', '15160808', '01', '', 'Refer: 17523236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(712, '2018-09-14', '2018', '15160781', '01', '', 'Refer: 17524259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(714, '2018-09-14', '2018', '13185943', '01', '', 'Refer: 17523268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(715, '2018-09-14', '2018', '15184668', '01', '', 'Refer: 17524221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(716, '2018-09-14', '2018', '13124502', '01', '', 'Refer: 17525297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(717, '2018-09-14', '2018', '13184652', '01', '', 'Refer: 17523297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(718, '2018-09-14', '2018', '15160810', '01', '', 'Refer: 17650289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(719, '2018-09-14', '2018', '15161785', '01', '', 'Refer: 17520270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(720, '2018-09-14', '2018', '14135744', '01', '', 'Refer: 17527292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(721, '2018-09-14', '2018', '15184642', '01', '', 'Refer: 17528278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(722, '2018-09-14', '2018', '14135914', '01', '', 'Refer: 17528203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(723, '2018-09-14', '2018', '15185169', '01', '', 'Refer: 17525276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(724, '2018-09-14', '2018', '33185892', '01', '', 'Refer: 17520203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(725, '2018-09-14', '2018', '15185609', '01', '', 'Refer: 17525283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(726, '2018-09-14', '2018', '13160574', '01', '', 'Refer: 17521277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(727, '2018-09-14', '2018', '15160501', '01', '', 'Refer: 17528270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL);
INSERT INTO `edocta` (`id`, `edoFechaOper`, `edoAnioPago`, `edoClaveAlu`, `edoMesPago`, `edoDigPago`, `edoDescripcion`, `edoImpAbono`, `edoImpCargo`, `edoEstado`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(728, '2018-09-14', '2018', '15160839', '01', '', 'Refer: 17520247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(729, '2018-09-14', '2018', '13147321', '01', '', 'Refer: 17525284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(730, '2018-09-14', '2018', '15184475', '01', '', 'Refer: 17525277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(731, '2018-09-14', '2018', '15184663', '01', '', 'Refer: 17523250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(732, '2018-09-14', '2018', '15150189', '01', '', 'Refer: 17529287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(733, '2018-09-14', '2018', '15186136', '01', '', 'Refer: 17521268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(734, '2018-09-14', '2018', '15173316', '01', '', 'Refer: 17524235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(735, '2018-09-14', '2018', '15184694', '01', '', 'Refer: 17520261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(736, '2018-09-14', '2018', '13148465', '10', '', 'Refer: 20441233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(737, '2018-09-14', '2018', '15185074', '01', '', 'Refer: 17651235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(738, '2018-09-14', '2018', '14135985', '10', '', 'Refer: 20441277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(739, '2018-09-14', '2018', '15185445', '01', '', 'Refer: 17520289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(740, '2018-09-14', '2018', '14173817', '01', '', 'Refer: 17525234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(741, '2018-09-14', '2018', '15185554', '01', '', 'Refer: 17528218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(742, '2018-09-14', '2018', '15185784', '01', '', 'Refer: 17525252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(743, '2018-09-14', '2018', '15184614', '01', '', 'Refer: 17524209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(744, '2018-09-14', '2018', '15184580', '01', '', 'Refer: 17525252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(745, '2018-09-14', '2018', '15184981', '01', '', 'Refer: 17522292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(746, '2018-09-14', '2018', '15174440', '01', '', 'Refer: 17524244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(747, '2018-09-14', '2018', '14159487', '01', '', 'Refer: 17525228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(748, '2018-09-14', '2018', '13159139', '01', '', 'Refer: 17524205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(749, '2018-09-14', '2018', '15185552', '01', '', 'Refer: 17525254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(750, '2018-09-14', '2018', '15185059', '01', '', 'Refer: 17528285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(751, '2018-09-14', '2018', '15184503', '01', '', 'Refer: 17525278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(752, '2018-09-14', '2018', '15147621', '01', '', 'Refer: 17527290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(753, '2018-09-14', '2018', '15159748', '01', '', 'Refer: 17523225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(754, '2018-09-14', '2018', '15184826', '01', '', 'Refer: 17520226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(755, '2018-09-14', '2018', '15147766', '01', '', 'Refer: 17527220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(756, '2018-09-14', '2018', '15161031', '01', '', 'Refer: 17521249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(757, '2018-09-14', '2018', '13052345', '01', '', 'Refer: 17523245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(758, '2018-09-14', '2018', '15148135', '01', '', 'Refer: 17528294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(759, '2018-09-14', '2018', '13159113', '01', '', 'Refer: 17520255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(760, '2018-09-13', '2018', '15174286', '01', '', 'Refer: 17525244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(761, '2018-09-13', '2018', '15172383', '01', '', 'Refer: 17528229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(762, '2018-09-13', '2018', '15172874', '01', '', 'Refer: 17523247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(763, '2018-09-13', '2018', '15184883', '02', '', 'Refer: 17815292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(764, '2018-09-13', '2018', '15184883', '01', '', 'Refer: 17525239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(765, '2018-09-13', '2018', '14148563', '01', '', 'Refer: 17528269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(766, '2018-09-13', '2018', '15184511', '01', '', 'Refer: 17524256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(767, '2018-09-13', '2018', '15172398', '01', '', 'Refer: 17523232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(768, '2018-09-13', '2018', '13136680', '01', '', 'Refer: 17521211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(769, '2018-09-13', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANORTE/I', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(770, '2018-09-13', '2018', '15184587', '01', '', 'Refer: 17528271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(772, '2018-09-13', '2018', '15147927', '01', '', 'Refer: 17523258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(773, '2018-09-13', '2018', '15185052', '01', '', 'Refer: 17528208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(774, '2018-09-13', '2018', '15172453', '01', '', 'Refer: 17528207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(775, '2018-09-13', '2018', '14160805', '01', '', 'Refer: 17528255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(776, '2018-09-13', '2018', '14184871', '01', '', 'Refer: 17525288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(777, '2018-09-13', '2018', '15184500', '01', '', 'Refer: 17525245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(778, '2018-09-13', '2018', '15174442', '01', '', 'Refer: 17524266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(779, '2018-09-13', '2018', '15160724', '01', '', 'Refer: 17524214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(780, '2018-09-13', '2018', '15159194', '01', '', 'Refer: 17520202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(782, '2018-09-13', '2018', '14160777', '01', '', 'Refer: 17520247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(783, '2018-09-13', '2018', '15184453', '01', '', 'Refer: 17525229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(784, '2018-09-13', '2018', '14148366', '01', '', 'Refer: 17523203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(785, '2018-09-13', '2018', '15161233', '01', '', 'Refer: 17523234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(786, '2018-09-13', '2018', '14172400', '01', '', 'Refer: 17525251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(787, '2018-09-13', '2018', '15172426', '01', '', 'Refer: 17520291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(788, '2018-09-13', '2018', '13186132', '01', '', 'Refer: 17520282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(789, '2018-09-13', '2018', '15184696', '01', '', 'Refer: 17525251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(790, '2018-09-12', '2018', '15172677', '01', '', 'Refer: 17523246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(791, '2018-09-12', '2018', '15161166', '01', '', 'Refer: 17529270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(792, '2018-09-12', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANORTE/I', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(794, '2018-09-12', '2018', '15172468', '01', '', 'Refer: 17525236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(795, '2018-09-12', '2018', '15160728', '01', '', 'Refer: 17524258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(797, '2018-09-12', '2018', '15185578', '01', '', 'Refer: 17520281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(798, '2018-09-12', '2018', '15185520', '01', '', 'Refer: 17520225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(799, '2018-09-12', '2018', '15148520', '01', '', 'Refer: 17520287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(800, '2018-09-12', '2018', '14184655', '01', '', 'Refer: 17525272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(801, '2018-09-12', '2018', '15184492', '01', '', 'Refer: 17525270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(802, '2018-09-12', '2018', '14186292', '01', '', 'Refer: 17525261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(803, '2018-09-12', '2018', '13135766', '01', '', 'Refer: 17525204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(804, '2018-09-12', '2018', '15160715', '01', '', 'Refer: 17525225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(805, '2018-09-12', '2018', '14173430', '01', '', 'Refer: 17520244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(806, '2018-09-12', '2018', '15174395', '01', '', 'Refer: 17520295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(807, '2018-09-12', '2018', '15161249', '01', '', 'Refer: 17520274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(808, '2018-09-12', '2018', '15186281', '01', '', 'Refer: 17528289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(809, '2018-09-12', '2018', '15185891', '01', '', 'Refer: 17520281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(810, '2018-09-12', '2018', '15186135', '01', '', 'Refer: 17525212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(811, '2018-09-12', '2018', '15174386', '01', '', 'Refer: 17525261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(812, '2018-09-12', '2018', '15172652', '01', '', 'Refer: 17523262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(813, '2018-09-12', '2018', '15184576', '01', '', 'Refer: 17528247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(814, '2018-09-12', '2018', '13174410', '01', '', 'Refer: 17523263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(815, '2018-09-12', '2018', '13174416', '01', '', 'Refer: 17526271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(816, '2018-09-12', '2018', '15173981', '01', '', 'Refer: 17523263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(817, '2018-09-12', '2018', '14148157', '01', '', 'Refer: 17525290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(818, '2018-09-12', '2018', '15091058', '85', '', 'Refer: 17546212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(819, '2018-09-11', '2018', '15147245', '99', '', 'Refer: 17653276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(821, '2018-09-11', '2018', '15184490', '01', '', 'Refer: 17523222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(822, '2018-09-11', '2018', '15160495', '01', '', 'Refer: 17520213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(823, '2018-09-11', '2018', '15185070', '01', '', 'Refer: 17523244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(824, '2018-09-11', '2018', '15185722', '01', '', 'Refer: 17523223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(825, '2018-09-11', '2018', '15184568', '01', '', 'Refer: 17525217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(826, '2018-09-11', '2018', '15174402', '11', '', 'Refer: 20762258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(827, '2018-09-11', '2018', '15186169', '01', '', 'Refer: 17528237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(828, '2018-09-11', '2018', '15185040', '01', '', 'Refer: 17525231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(829, '2018-09-11', '2018', '15184742', '01', '', 'Refer: 17525256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(830, '2018-09-11', '2018', '15185570', '01', '', 'Refer: 17528297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(831, '2018-09-11', '2018', '13162358', '10', '', 'Refer: 20440252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(832, '2018-09-11', '2018', '15184809', '01', '', 'Refer: 17520233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(833, '2018-09-11', '2018', '13136334', '01', '', 'Refer: 17528230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(834, '2018-09-11', '2018', '15162374', '01', '', 'Refer: 17525262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(835, '2018-09-11', '2018', '15184997', '01', '', 'Refer: 17528255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(836, '2018-09-11', '2018', '14184527', '10', '', 'Refer: 20441249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(837, '2018-09-11', '2018', '15147642', '01', '', 'Refer: 17528243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(838, '2018-09-11', '2018', '14186160', '01', '', 'Refer: 17521228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(839, '2018-09-11', '2018', '13184620', '01', '', 'Refer: 17523236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(840, '2018-09-11', '2018', '15174341', '01', '', 'Refer: 17521296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(841, '2018-09-11', '2018', '15148343', '99', '', 'Refer: 17659271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(842, '2018-09-11', '2018', '15160867', '01', '', 'Refer: 17523206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(843, '2018-09-11', '2018', '15148153', '01', '', 'Refer: 17520291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(845, '2018-09-11', '2018', '15147246', '01', '', 'Refer: 17528219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(846, '2018-09-10', '2018', '15160825', '01', '', 'Refer: 17524242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(847, '2018-09-10', '2018', '15184714', '01', '', 'Refer: 17528278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(848, '2018-09-10', '2017', '15162178', '12', '', 'Refer: 17556250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(849, '2018-09-10', '2018', '15172867', '01', '', 'Refer: 17520228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(850, '2018-09-10', '2018', '15185197', '01', '', 'Refer: 17523267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(851, '2018-09-10', '2018', '15161517', '01', '', 'Refer: 17523206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(852, '2018-09-10', '2018', '15184443', '01', '', 'Refer: 17525216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(853, '2018-09-10', '2017', '15159349', '12', '', 'Refer: 17654262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(854, '2018-09-10', '2018', '13172446', '01', '', 'Refer: 17523233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(855, '2018-09-10', '2018', '15174409', '01', '', 'Refer: 17525207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(856, '2018-09-10', '2018', '15161017', '01', '', 'Refer: 17521289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(857, '2018-09-10', '2018', '15174433', '01', '', 'Refer: 17520212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(858, '2018-09-10', '2018', '15172654', '01', '', 'Refer: 17524297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(859, '2018-09-10', '2018', '15160817', '01', '', 'Refer: 17529219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(860, '2018-09-10', '2018', '15159836', '01', '', 'Refer: 17528272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(861, '2018-09-10', '2018', '14184586', '01', '', 'Refer: 17525208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(862, '2018-09-10', '2018', '15184834', '01', '', 'Refer: 17525282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(863, '2018-09-10', '2018', '15186376', '99', '', 'Refer: 17573237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(864, '2018-09-10', '2018', '15184915', '01', '', 'Refer: 17528226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(865, '2018-09-10', '2018', '15185017', '01', '', 'Refer: 17525269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(866, '2018-09-10', '2018', '15174128', '01', '', 'Refer: 17521216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(867, '2018-09-10', '2018', '15185766', '01', '', 'Refer: 17524235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(868, '2018-09-10', '2018', '15185309', '01', '', 'Refer: 17523206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(869, '2018-09-10', '2018', '15147622', '01', '', 'Refer: 17527204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(870, '2018-09-10', '2018', '15150331', '11', '', 'Refer: 20764270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(871, '2018-09-10', '2018', '15173653', '01', '', 'Refer: 17523292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(872, '2018-09-10', '2018', '13160587', '10', '', 'Refer: 20447270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(873, '2018-09-10', '2017', '13172416', '11', '', 'Refer: 17650223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(874, '2018-09-10', '2018', '15185666', '01', '', 'Refer: 17520263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(875, '2018-09-10', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(877, '2018-09-10', '2018', '15186240', '01', '', 'Refer: 17521232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(878, '2018-09-09', '2018', '14160731', '02', '', 'Refer: 17815247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(879, '2018-09-09', '2018', '14160731', '01', '', 'Refer: 17525291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(880, '2018-09-09', '2018', '23161747', '01', '', 'Refer: 17525296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(881, '2018-09-09', '2017', '13172446', '12', '', 'Refer: 17551269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(882, '2018-09-09', '2018', '15161718', '01', '', 'Refer: 17520212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(883, '2018-09-08', '2018', '14186087', '01', '', 'Refer: 17521217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(884, '2018-09-08', '2018', '15172676', '01', '', 'Refer: 17525261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(885, '2018-09-08', '2017', '15150108', '12', '', 'Refer: 17552240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(886, '2018-09-08', '2018', '15185523', '01', '', 'Refer: 17525226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(887, '2018-09-08', '2018', '13184654', '01', '', 'Refer: 17520280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(888, '2018-09-08', '2018', '15160631', '01', '', 'Refer: 17520222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(889, '2018-09-07', '2018', '15185577', '01', '', 'Refer: 17520270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(890, '2018-09-07', '2018', '15185608', '01', '', 'Refer: 17520207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(891, '2018-09-07', '2018', '15160865', '01', '', 'Refer: 17650215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(892, '2018-09-07', '2018', '14161326', '01', '', 'Refer: 17525284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(893, '2018-09-07', '2018', '14186130', '01', '', 'Refer: 17521286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(894, '2018-09-07', '2018', '14184843', '01', '', 'Refer: 17520206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(895, '2018-09-07', '2018', '13161224', '01', '', 'Refer: 17520264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(896, '2018-09-07', '2017', '15136083', '06', '', 'Refer: 17655239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(897, '2018-09-07', '2017', '15136083', '05', '', 'Refer: 17655226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(898, '2018-09-07', '2017', '15136083', '04', '', 'Refer: 17653284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:47', '2018-12-06 02:49:47', NULL),
(899, '2018-09-07', '2018', '15160721', '99', '', 'Refer: 17653204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(900, '2018-09-06', '2018', '14136621', '99', '', 'Refer: 17463295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(901, '2018-09-06', '2018', '15161535', '01', '', 'Refer: 17528275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(902, '2018-09-06', '2018', '15147719', '01', '', 'Refer: 17520291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(903, '2018-09-06', '2018', '15160808', '99', '', 'Refer: 17433297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(904, '2018-09-06', '2018', '15185132', '01', '', 'Refer: 17528296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(905, '2018-09-06', '2018', '13186335', '01', '', 'Refer: 17520252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(906, '2018-09-06', '2018', '14184455', '01', '', 'Refer: 17520270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(907, '2018-09-06', '2018', '14160704', '99', '', 'Refer: 17413286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(908, '2018-09-06', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANORTE/I', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(909, '2018-09-06', '2018', '15136923', '01', '', 'Refer: 17521243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(910, '2018-09-06', '2018', '15172670', '01', '', 'Refer: 17523266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(911, '2018-09-06', '2018', '15185393', '01', '', 'Refer: 17523257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(912, '2018-09-05', '2018', '23185583', '01', '', 'Refer: 17520230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(913, '2018-09-05', '2018', '13185584', '01', '', 'Refer: 17520224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(914, '2018-09-05', '2018', '14185196', '01', '', 'Refer: 17521217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(915, '2018-09-05', '2018', '14185684', '01', '', 'Refer: 17524209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(916, '2018-09-05', '2018', '14173940', '01', '', 'Refer: 17523284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(917, '2018-09-05', '2018', '15172883', '01', '', 'Refer: 17523249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(918, '2018-09-05', '2018', '15161516', '01', '', 'Refer: 17528260', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(919, '2018-09-05', '2018', '13174411', '01', '', 'Refer: 17523274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(920, '2018-09-05', '2018', '15185792', '01', '', 'Refer: 17523217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(921, '2018-09-05', '2018', '15185433', '01', '', 'Refer: 17528261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(922, '2018-09-05', '2018', '15185575', '01', '', 'Refer: 17520248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(923, '2018-09-05', '2017', '13124491', '11', '', 'Refer: 17659215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(924, '2018-09-05', '2018', '15147872', '99', '', 'Refer: 17423295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(925, '2018-09-05', '2018', '13172474', '01', '', 'Refer: 17523250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(926, '2018-09-05', '2018', '15173162', '01', '', 'Refer: 17529287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(927, '2018-09-05', '2018', '15184886', '01', '', 'Refer: 17524259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(928, '2018-09-04', '2017', '15160657', '12', '', 'Refer: 17556260', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(929, '2018-09-04', '2017', '15162368', '12', '', 'Refer: 17553232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(930, '2018-09-04', '20ID', 'EI RECIB', 'OS', '', 'Refer: ANTANDER', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(931, '2018-09-04', '2018', '15159885', '03', '', 'Refer: 18121208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(932, '2018-09-04', '2018', '15159885', '02', '', 'Refer: 17811288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(933, '2018-09-04', '2018', '15148419', '01', '', 'Refer: 17529279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(934, '2018-09-04', '2018', '15159885', '01', '', 'Refer: 17521235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(935, '2018-09-04', '2018', '15185223', '99', '', 'Refer: 17393293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(936, '2018-09-04', '2018', '15160920', '01', '', 'Refer: 17520249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(937, '2018-09-04', '2018', '15184502', '01', '', 'Refer: 17520202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(938, '2018-09-04', '2017', '15172678', '12', '', 'Refer: 17657293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(939, '2018-09-04', '2017', '15160810', '09', '', 'Refer: 17655245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(940, '2018-09-04', '2018', '13124505', '12', '', 'Refer: 20915269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(941, '2018-09-04', '2018', '13186335', '99', '', 'Refer: 17484256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(942, '2018-09-04', '2018', '15173654', '01', '', 'Refer: 17523206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(943, '2018-09-04', '2017', '13160801', '05', '', 'Refer: 17657288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(944, '2018-09-04', '2018', '14124473', '01', '', 'Refer: 17521246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(945, '2018-09-04', '2018', '14185977', '01', '', 'Refer: 17521241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(946, '2018-09-04', '2018', '14184473', '01', '', 'Refer: 17525242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(947, '2018-09-04', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANAMEX/0', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(948, '2018-09-04', '2018', '15135940', '01', '', 'Refer: 17529224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(949, '2018-09-03', '2018', '15186028', '01', '', 'Refer: 17527241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(950, '2018-09-03', '2017', '33161763', '09', '', 'Refer: 17659211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(951, '2018-09-03', '2018', '15136814', '99', '', 'Refer: 17413277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(952, '2018-09-03', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANORTE/I', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(953, '2018-09-03', '2018', '14185307', '01', '', 'Refer: 17525294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(954, '2018-09-03', '2018', '15160719', '99', '', 'Refer: 17653279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(955, '2018-09-03', '2017', '15173149', '12', '', 'Refer: 17559206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(956, '2018-09-03', '2018', '13136334', '99', '', 'Refer: 17433226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(957, '2018-09-03', '2018', '13184582', '10', '', 'Refer: 20442272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(958, '2018-09-03', '2017', '15159598', '12', '', 'Refer: 17652227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(959, '2018-09-03', '2018', '15159598', '99', '', 'Refer: 17453254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(960, '2018-09-30', '2018', '00003362', '09', '', 'Refer: 17716250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(961, '2018-09-30', '2018', '00002973', '09', '', 'Refer: 17716260', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(962, '2018-09-30', '2018', '15150030', '52', '', 'Refer: 17828248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(963, '2018-09-30', '2018', '00184609', '51', '', 'Refer: 17713262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(964, '2018-09-30', '2018', '00184609', '49', '', 'Refer: 17713252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(965, '2018-09-29', '2018', '00003366', '09', '', 'Refer: 17711229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(966, '2018-09-29', '2018', '00001917', '09', '', 'Refer: 17699266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(967, '2018-09-29', '2018', '09186420', '49', '', 'Refer: 17713203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(968, '2018-09-29', '2018', '15159530', '51', '', 'Refer: 17718261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(969, '2018-09-29', '2018', '15159530', '49', '', 'Refer: 17718251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(970, '2018-09-28', '2018', '15159969', '49', '', 'Refer: 17638278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(971, '2018-09-28', '2018', '15159254', '49', '', 'Refer: 17638285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(972, '2018-09-28', '2018', '15159254', '51', '', 'Refer: 17648215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(973, '2018-09-28', '2018', '15147956', '51', '', 'Refer: 17638278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(974, '2018-09-28', '2018', '15147956', '49', '', 'Refer: 17638268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(975, '2018-09-28', '2018', '15185518', '51', '', 'Refer: 17823287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(976, '2018-09-28', '2018', '15186102', '51', '', 'Refer: 17638203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(977, '2018-09-28', '2018', '15186102', '49', '', 'Refer: 17638290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(978, '2018-09-28', '2018', '14124501', '51', '', 'Refer: 17648282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(979, '2018-09-28', '2018', '15159969', '51', '', 'Refer: 17638288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(980, '2018-09-28', '2018', '15991518', '34', '', 'Refer: 17672264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(981, '2018-09-28', '2018', '15184938', '49', '', 'Refer: 17698207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(982, '2018-09-28', '2018', '15184938', '51', '', 'Refer: 17828233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(983, '2018-09-28', '2018', '15184765', '51', '', 'Refer: 17828205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(984, '2018-09-28', '2018', '15184765', '49', '', 'Refer: 17698276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(985, '2018-09-28', '2018', '15159257', '49', '', 'Refer: 17638221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(986, '2018-09-28', '2018', '15159744', '49', '', 'Refer: 17638260', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(987, '2018-09-28', '2018', '15159185', '51', '', 'Refer: 17638231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(988, '2018-09-28', '2018', '54148384', '51', '', 'Refer: 17638267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(989, '2018-09-28', '2018', '54148384', '49', '', 'Refer: 17638257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(990, '2018-09-27', '2018', '00003432', '09', '', 'Refer: 17686231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(991, '2018-09-27', '2018', '23185927', '34', '', 'Refer: 17682210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(992, '2018-09-27', '2017', '52148394', '60', '', 'Refer: 17633271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(993, '2018-09-27', '2018', '13113958', '49', '', 'Refer: 17638216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(994, '2018-09-27', '2018', '13113958', '51', '', 'Refer: 17638226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(995, '2018-09-27', '2018', '13173806', '34', '', 'Refer: 17692289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(996, '2018-09-27', '2018', '15185350', '49', '', 'Refer: 17638251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(997, '2018-09-27', '2018', '15185350', '51', '', 'Refer: 17638261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(998, '2018-09-27', '2018', '15185342', '51', '', 'Refer: 17638270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(999, '2018-09-27', '2018', '15185342', '49', '', 'Refer: 17638260', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1000, '2018-09-27', '2018', '15150052', '52', '', 'Refer: 17828296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1001, '2018-09-27', '2018', '22102369', '34', '', 'Refer: 17692236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1002, '2018-09-26', '2018', '00002889', '09', '', 'Refer: 17696245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1003, '2018-09-26', '2018', '00003431', '09', '', 'Refer: 17696237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1004, '2018-09-26', '2018', '13185715', '34', '', 'Refer: 17682221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1005, '2018-09-26', '2018', '15161302', '49', '', 'Refer: 17618246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1006, '2018-09-26', '2018', '12184750', '34', '', 'Refer: 17622278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1007, '2018-09-26', '2018', '21184818', '34', '', 'Refer: 17627206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1008, '2018-09-26', '2018', '00003422', '09', '', 'Refer: 17676201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1009, '2018-09-26', '2018', '15159336', '49', '', 'Refer: 17618264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1010, '2018-09-26', '2018', '15159336', '51', '', 'Refer: 17658245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1011, '2018-09-26', '2018', '15161221', '51', '', 'Refer: 17823244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1012, '2018-09-26', '2018', '14124501', '49', '', 'Refer: 17638255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1013, '2018-09-26', '2018', '15161221', '49', '', 'Refer: 17638278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1014, '2018-09-26', '2018', '15184573', '49', '', 'Refer: 17638228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1015, '2018-09-26', '2018', '15184573', '51', '', 'Refer: 17638238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1016, '2018-09-25', '2018', '00003395', '09', '', 'Refer: 17686228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1017, '2018-09-25', '2018', '15159804', '49', '', 'Refer: 17638225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1018, '2018-09-25', '2018', '15159804', '51', '', 'Refer: 17638235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1019, '2018-09-25', '2018', '00003470', '09', '', 'Refer: 17676244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1020, '2018-09-25', '2018', '00003227', '09', '', 'Refer: 17686239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1021, '2018-09-25', '2018', '00003478', '09', '', 'Refer: 17676235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1022, '2018-09-25', '2018', '00003420', '09', '', 'Refer: 17686293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1023, '2018-09-25', '2018', '00003419', '09', '', 'Refer: 17686282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1024, '2018-09-25', '2018', '15185518', '49', '', 'Refer: 17628207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1025, '2018-09-25', '2018', '12159023', '49', '', 'Refer: 17638259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1026, '2018-09-25', '2018', '12159023', '51', '', 'Refer: 17638269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1027, '2018-09-24', '2018', '54148002', '51', '', 'Refer: 17638284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1028, '2018-09-24', '2018', '54148002', '49', '', 'Refer: 17638274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1029, '2018-09-24', '2018', '15147363', '49', '', 'Refer: 17618209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1030, '2018-09-24', '2018', '15147363', '51', '', 'Refer: 17618219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1031, '2018-09-24', '2018', '15148183', '49', '', 'Refer: 17618220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1032, '2018-09-24', '2018', '00003317', '09', '', 'Refer: 17676226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1033, '2018-09-24', '2018', '00003488', '09', '', 'Refer: 17636277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1034, '2018-09-24', '2018', '00003388', '09', '', 'Refer: 17639202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1035, '2018-09-24', '2018', '11125501', '49', '', 'Refer: 17638235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1036, '2018-09-24', '2018', '11125501', '51', '', 'Refer: 17638245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1037, '2018-09-24', '2018', '11078853', '51', '', 'Refer: 17638253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1038, '2018-09-24', '2018', '11078853', '49', '', 'Refer: 17638243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1039, '2018-09-24', '20ID', 'EI RECIB', 'OV', '', 'Refer: E POR MA', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1041, '2018-09-24', '2018', '09186386', '49', '', 'Refer: 17613214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1042, '2018-09-24', '2018', '15159889', '49', '', 'Refer: 17608236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1043, '2018-09-24', '2018', '09186408', '49', '', 'Refer: 17598234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1044, '2018-09-24', '2018', '09186408', '51', '', 'Refer: 17598244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1047, '2018-09-24', '2018', '12135804', '49', '', 'Refer: 17638258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1048, '2018-09-23', '2018', '00172433', '49', '', 'Refer: 17613208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1049, '2018-09-23', '2018', '00003421', '09', '', 'Refer: 17636219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1050, '2018-09-22', '2018', '00003213', '09', '', 'Refer: 17596277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1051, '2018-09-21', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANAMEX/0', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1052, '2018-09-21', '2018', '00003481', '09', '', 'Refer: 17606246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1053, '2018-09-21', '2018', '09186407', '49', '', 'Refer: 17583238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1054, '2018-09-21', '2018', '15147637', '51', '', 'Refer: 17823265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1055, '2018-09-21', '2018', '09186386', '51', '', 'Refer: 17821253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1056, '2018-09-21', '2018', '13184725', '51', '', 'Refer: 17568235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1057, '2018-09-20', '2018', '15150388', '49', '', 'Refer: 17558229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1058, '2018-09-20', '2018', '62162360', '51', '', 'Refer: 17558232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1059, '2018-09-20', '2018', '15161469', '51', '', 'Refer: 17558283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1060, '2018-09-20', '2018', '09186338', '51', '', 'Refer: 17558295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1061, '2018-09-20', '2018', '09186337', '51', '', 'Refer: 17558284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1062, '2018-09-20', '2018', '31091541', '51', '', 'Refer: 17558226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1063, '2018-09-20', '2018', '15147874', '49', '', 'Refer: 17558270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1064, '2018-09-20', '2018', '00003484', '09', '', 'Refer: 17626216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1065, '2018-09-20', '2018', '15161499', '51', '', 'Refer: 17558225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1066, '2018-09-20', '2018', '15161370', '51', '', 'Refer: 17558277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1067, '2018-09-20', '2018', '15161500', '49', '', 'Refer: 17568227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1068, '2018-09-20', '2018', '15161500', '51', '', 'Refer: 17558220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1069, '2018-09-20', '2018', '09186355', '51', '', 'Refer: 17553223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1070, '2018-09-20', '2018', '09186356', '51', '', 'Refer: 17553234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1071, '2018-09-20', '2018', '09186409', '34', '', 'Refer: 17612259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1072, '2018-09-20', '2018', '09186399', '51', '', 'Refer: 17553222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1073, '2018-09-20', '2018', '15162080', '51', '', 'Refer: 17558258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1074, '2018-09-20', '2018', '15162080', '49', '', 'Refer: 17558248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1075, '2018-09-20', '2018', '00002894', '09', '', 'Refer: 17616261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1076, '2018-09-20', '2018', '12147828', '51', '', 'Refer: 17558220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1077, '2018-09-20', '2018', '12147828', '49', '', 'Refer: 17558210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1078, '2018-09-20', '2018', '10184681', '51', '', 'Refer: 17553228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1079, '2018-09-20', '2018', '00003375', '09', '', 'Refer: 17626294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1080, '2018-09-20', '2018', '13101717', '51', '', 'Refer: 17558277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1081, '2018-09-20', '2018', '00002446', '09', '', 'Refer: 17626264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1082, '2018-09-20', '2018', '52160950', '51', '', 'Refer: 17558266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1083, '2018-09-20', '2018', '52160950', '49', '', 'Refer: 17558256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1084, '2018-09-20', '2018', '00150365', '51', '', 'Refer: 17553227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1085, '2018-09-20', '2018', '09186400', '51', '', 'Refer: 17553217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1086, '2018-09-20', '2018', '09186400', '49', '', 'Refer: 17553207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1087, '2018-09-20', '2018', '15148183', '51', '', 'Refer: 17558279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1088, '2018-09-20', '2018', '15150057', '51', '', 'Refer: 17558235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1089, '2018-09-20', '2018', '00002259', '09', '', 'Refer: 17605229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1090, '2018-09-20', '2018', '13184725', '51', '', 'Refer: 17558218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1091, '2018-09-20', '2018', '00162221', '51', '', 'Refer: 17553272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL);
INSERT INTO `edocta` (`id`, `edoFechaOper`, `edoAnioPago`, `edoClaveAlu`, `edoMesPago`, `edoDigPago`, `edoDescripcion`, `edoImpAbono`, `edoImpCargo`, `edoEstado`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1092, '2018-09-20', '2018', '15147637', '49', '', 'Refer: 17558217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1093, '2018-09-20', '2018', '15150058', '51', '', 'Refer: 17558246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1094, '2018-09-20', '2018', '15172635', '51', '', 'Refer: 17558276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1095, '2018-09-20', '2018', '15172635', '49', '', 'Refer: 17558266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1096, '2018-09-19', '2017', '00174263', '56', '', 'Refer: 17563276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1097, '2018-09-19', '2018', '00174263', '49', '', 'Refer: 17553203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1098, '2018-09-19', '2018', '00003464', '09', '', 'Refer: 17596290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1100, '2018-09-19', '2018', '09186393', '49', '', 'Refer: 17543226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1102, '2018-09-19', '2018', '09186392', '49', '', 'Refer: 17553232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1103, '2018-09-19', '2018', '00003435', '09', '', 'Refer: 17616242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1104, '2018-09-19', '2018', '09186384', '49', '', 'Refer: 17553241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1105, '2018-09-19', '2018', '15159943', '51', '', 'Refer: 17558211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1106, '2018-09-19', '2018', '39186383', '49', '', 'Refer: 17553281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1107, '2018-09-19', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANAMEX/0', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1108, '2018-09-19', '2018', '15172835', '51', '', 'Refer: 17558213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1109, '2018-09-19', '2018', '15172835', '49', '', 'Refer: 17558203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1110, '2018-09-19', '2018', '15159228', '51', '', 'Refer: 17558218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1111, '2018-09-19', '2018', '15159228', '49', '', 'Refer: 17558208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1112, '2018-09-19', '2018', '32161676', '51', '', 'Refer: 17558292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1113, '2018-09-19', '2018', '32161676', '49', '', 'Refer: 17558282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1114, '2018-09-19', '2018', '13101590', '51', '', 'Refer: 17553205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1115, '2018-09-19', '2018', '13101590', '49', '', 'Refer: 17543275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1116, '2018-09-18', '2018', '09186353', '51', '', 'Refer: 17553201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1117, '2018-09-18', '2018', '10162212', '51', '', 'Refer: 17553287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1118, '2018-09-18', '2018', '00148767', '51', '', 'Refer: 17553252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1119, '2018-09-18', '2018', '00148767', '49', '', 'Refer: 17573276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1120, '2018-09-18', '2018', '00172433', '51', '', 'Refer: 17553267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1121, '2018-09-18', '2018', '34161988', '51', '', 'Refer: 17558210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1122, '2018-09-18', '2018', '14159870', '51', '', 'Refer: 17558284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1123, '2018-09-18', '2018', '14159870', '49', '', 'Refer: 17538240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1124, '2018-09-18', '2018', '09186399', '49', '', 'Refer: 17533275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1125, '2018-09-18', '2018', '62160656', '49', '', 'Refer: 17558288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1126, '2018-09-18', '2018', '62160656', '51', '', 'Refer: 17558201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1127, '2018-09-18', '2018', '54160647', '51', '', 'Refer: 17558208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1128, '2018-09-18', '2018', '09186403', '34', '', 'Refer: 17602273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1129, '2018-09-18', '2018', '54160647', '49', '', 'Refer: 17558295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1130, '2018-09-18', '2018', '31101559', '51', '', 'Refer: 17558228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1131, '2018-09-18', '2018', '32185039', '34', '', 'Refer: 17562237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:48', '2018-12-06 02:49:48', NULL),
(1132, '2018-09-17', '2018', '00001463', '09', '', 'Refer: 17526219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1133, '2018-09-17', '2018', '00003459', '09', '', 'Refer: 17526213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1134, '2018-09-17', '2018', '00003198', '09', '', 'Refer: 17596225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1135, '2018-09-17', '2018', '00003337', '09', '', 'Refer: 17596267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1136, '2018-09-17', '2018', '11161805', '34', '', 'Refer: 17532264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1137, '2018-09-17', '2018', '15172645', '51', '', 'Refer: 17558289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1138, '2018-09-17', '2018', '14113133', '51', '', 'Refer: 17553263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1139, '2018-09-17', '2018', '09186402', '34', '', 'Refer: 17592202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1140, '2018-09-17', '2018', '15148015', '51', '', 'Refer: 17558290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1141, '2018-09-17', '2018', '15159708', '51', '', 'Refer: 17553212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1142, '2018-09-17', '2018', '15148015', '49', '', 'Refer: 17558280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1143, '2018-09-17', '2018', '15159708', '49', '', 'Refer: 17553202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1144, '2018-09-17', '2018', '15161679', '51', '', 'Refer: 17558233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1145, '2018-09-17', '2018', '09186396', '34', '', 'Refer: 17552278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1146, '2018-09-17', '2018', '15159294', '49', '', 'Refer: 17528204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1147, '2018-09-17', '2018', '15159614', '51', '', 'Refer: 17558229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1148, '2018-09-17', '2018', '54148190', '51', '', 'Refer: 17558217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1149, '2018-09-17', '2018', '54148190', '49', '', 'Refer: 17528253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1150, '2018-09-17', '2018', '09186348', '51', '', 'Refer: 17553243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1152, '2018-09-17', '2018', '15161751', '51', '', 'Refer: 17558233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1153, '2018-09-17', '2018', '42172549', '51', '', 'Refer: 17558231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1154, '2018-09-17', '2018', '12147260', '49', '', 'Refer: 17558266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1155, '2018-09-16', '2018', '14124923', '49', '', 'Refer: 17528238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1156, '2018-09-16', '2018', '15162061', '51', '', 'Refer: 17558243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1157, '2018-09-16', '2018', '15162061', '49', '', 'Refer: 17558233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1158, '2018-09-16', '2018', '09186392', '51', '', 'Refer: 17553242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1159, '2018-09-15', '2018', '15113767', '51', '', 'Refer: 17558235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1160, '2018-09-15', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANAMEX/0', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1161, '2018-09-15', '2018', '15161850', '51', '', 'Refer: 17558239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1162, '2018-09-15', '2018', '00150378', '51', '', 'Refer: 17553273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1163, '2018-09-15', '2018', '09186393', '51', '', 'Refer: 17553253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1164, '2018-09-14', '2018', '31090725', '51', '', 'Refer: 17558259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1165, '2018-09-14', '2018', '00174281', '51', '', 'Refer: 17553217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1166, '2018-09-14', '2018', '00174281', '49', '', 'Refer: 17513236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1167, '2018-09-14', '2018', '12160664', '34', '', 'Refer: 17492277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1168, '2018-09-14', '2018', '31160665', '34', '', 'Refer: 17494238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1169, '2018-09-14', '2018', '12147260', '51', '', 'Refer: 17558276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1170, '2018-09-14', '2018', '13160585', '51', '', 'Refer: 17558237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1171, '2018-09-14', '2018', '10162215', '49', '', 'Refer: 17533276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1173, '2018-09-14', '2018', '09186398', '49', '', 'Refer: 17533264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1174, '2018-09-14', '2018', '09186336', '51', '', 'Refer: 17553208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1176, '2018-09-14', '2018', '12135804', '51', '', 'Refer: 17558283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1177, '2018-09-14', '2018', '10160649', '51', '', 'Refer: 17553239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1178, '2018-09-14', '2018', '15150052', '51', '', 'Refer: 17558277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1179, '2018-09-14', '2018', '15150052', '49', '', 'Refer: 17538233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1180, '2018-09-13', '2018', '15150030', '51', '', 'Refer: 17558229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1181, '2018-09-13', '2018', '00184672', '49', '', 'Refer: 17483231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1182, '2018-09-13', '2018', '52159068', '49', '', 'Refer: 17488287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1183, '2018-09-13', '2018', '22159069', '49', '', 'Refer: 17488247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1184, '2018-09-13', '2018', '32135865', '49', '', 'Refer: 17488234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1185, '2018-09-13', '2018', '12135762', '49', '', 'Refer: 17488247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1186, '2018-09-13', '2018', '13135764', '49', '', 'Refer: 17488282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1187, '2018-09-13', '2018', '15161499', '49', '', 'Refer: 17488247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1188, '2018-09-13', '2018', '00001472', '09', '', 'Refer: 17526221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1189, '2018-09-13', '2018', '10174242', '51', '', 'Refer: 17553290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1190, '2018-09-13', '2018', '12101728', '51', '', 'Refer: 17558288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1191, '2018-09-13', '2018', '12101728', '49', '', 'Refer: 17488213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1192, '2018-09-13', '2018', '10174242', '49', '', 'Refer: 17483215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1193, '2018-09-13', '2018', '13172502', '51', '', 'Refer: 17558258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1194, '2018-09-13', '2018', '13172502', '49', '', 'Refer: 17488280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1195, '2018-09-13', '2018', '09186395', '34', '', 'Refer: 17532233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1196, '2018-09-13', '2018', '13159054', '51', '', 'Refer: 17558250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1197, '2018-09-13', '2018', '13159054', '49', '', 'Refer: 17488272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1198, '2018-09-13', '2018', '19186394', '49', '', 'Refer: 17513203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1199, '2018-09-13', '2018', '00003473', '09', '', 'Refer: 17536287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1200, '2018-09-13', '2018', '15159461', '49', '', 'Refer: 17528263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1201, '2018-09-13', '2018', '00162224', '34', '', 'Refer: 17522246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1202, '2018-09-13', '2018', '13161395', '34', '', 'Refer: 17527273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1203, '2018-09-13', '2018', '13160603', '51', '', 'Refer: 17558225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1205, '2018-09-12', '2018', '34161988', '49', '', 'Refer: 17488232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1206, '2018-09-12', '2018', '31162359', '34', '', 'Refer: 17492230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1207, '2018-09-12', '2018', '62162360', '34', '', 'Refer: 17497273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1208, '2018-09-12', '2018', '62162360', '49', '', 'Refer: 17488254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1209, '2018-09-12', '2018', '15159560', '51', '', 'Refer: 17558233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1210, '2018-09-12', '2018', '15159560', '49', '', 'Refer: 17488255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1211, '2018-09-12', '2018', '09186356', '49', '', 'Refer: 17483256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1212, '2018-09-12', '2018', '09186355', '49', '', 'Refer: 17513242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1213, '2018-09-12', '2018', '00002584', '09', '', 'Refer: 17536212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1214, '2018-09-12', '2018', '00002951', '09', '', 'Refer: 17536208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1216, '2018-09-12', '2018', '13160815', '49', '', 'Refer: 17478202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1217, '2018-09-12', '2018', '13160815', '51', '', 'Refer: 17558294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1218, '2018-09-12', '2018', '00002571', '09', '', 'Refer: 17536263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1219, '2018-09-12', '2018', '15172947', '51', '', 'Refer: 17558265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1220, '2018-09-12', '2018', '15161751', '49', '', 'Refer: 17488255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1221, '2018-09-12', '2018', '09186337', '49', '', 'Refer: 17478289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1222, '2018-09-12', '2018', '09186338', '49', '', 'Refer: 17478203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1223, '2018-09-12', '2018', '15161469', '49', '', 'Refer: 17478288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1224, '2018-09-12', '2018', '00003449', '09', '', 'Refer: 17506263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1225, '2018-09-12', '2018', '15161353', '51', '', 'Refer: 17558284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1226, '2018-09-12', '2018', '14174027', '49', '', 'Refer: 17488230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1227, '2018-09-12', '2018', '52174186', '49', '', 'Refer: 17488259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1228, '2018-09-11', '20ID', 'EI RECIB', 'OS', '', 'Refer: ANTANDER', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1230, '2018-09-11', '2018', '00003468', '09', '', 'Refer: 17526215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1231, '2018-09-11', '2018', '00002955', '09', '', 'Refer: 17496238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1232, '2018-09-11', '2018', '00003446', '09', '', 'Refer: 17526264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1233, '2018-09-11', '2018', '00184608', '51', '', 'Refer: 17558249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1234, '2018-09-11', '2018', '09186389', '51', '', 'Refer: 17553209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1235, '2018-09-11', '2018', '15172991', '51', '', 'Refer: 17558264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1236, '2018-09-11', '2018', '09186389', '49', '', 'Refer: 17503211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1237, '2018-09-11', '2018', '00003461', '09', '', 'Refer: 17486221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1238, '2018-09-11', '2018', '00003474', '09', '', 'Refer: 17531233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1239, '2018-09-11', '2018', '54159659', '51', '', 'Refer: 17558294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1240, '2018-09-11', '2018', '54159659', '49', '', 'Refer: 17488219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1241, '2018-09-11', '2018', '31090725', '49', '', 'Refer: 17468247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1242, '2018-09-11', '2018', '00003458', '09', '', 'Refer: 17486285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1243, '2018-09-11', '2018', '10158901', '34', '', 'Refer: 17492223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1244, '2018-09-11', '2018', '15148417', '51', '', 'Refer: 17558283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1245, '2018-09-11', '2018', '15148417', '49', '', 'Refer: 17488208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1246, '2018-09-11', '2018', '15161703', '49', '', 'Refer: 17468275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1247, '2018-09-11', '2018', '15161703', '51', '', 'Refer: 17558287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1248, '2018-09-11', '2018', '09186385', '51', '', 'Refer: 17553262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1249, '2018-09-11', '2018', '00162233', '51', '', 'Refer: 17553210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1250, '2018-09-11', '2018', '00162233', '49', '', 'Refer: 17483232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1251, '2018-09-11', '2018', '09186385', '49', '', 'Refer: 17483284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1252, '2018-09-11', '2018', '00003326', '09', '', 'Refer: 17526221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1253, '2018-09-11', '2018', '33184447', '51', '', 'Refer: 17558249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1254, '2018-09-11', '2018', '62184445', '51', '', 'Refer: 17558265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1255, '2018-09-11', '2018', '62184445', '49', '', 'Refer: 17488287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1256, '2018-09-11', '2018', '33184447', '49', '', 'Refer: 17488271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1257, '2018-09-10', '2018', '15150077', '51', '', 'Refer: 17558261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1258, '2018-09-10', '2018', '15161353', '49', '', 'Refer: 17468272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1259, '2018-09-10', '2018', '15159185', '49', '', 'Refer: 17458217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1260, '2018-09-10', '2018', '00003460', '09', '', 'Refer: 17486210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1261, '2018-09-10', '2018', '00174282', '51', '', 'Refer: 17558293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1262, '2018-09-10', '2018', '00174282', '49', '', 'Refer: 17488218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1263, '2018-09-10', '2018', '00174277', '52', '', 'Refer: 17823289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1264, '2018-09-10', '2018', '00174277', '51', '', 'Refer: 17553270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1265, '2018-09-10', '2018', '00174277', '49', '', 'Refer: 17483292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1266, '2018-09-10', '2018', '15161005', '51', '', 'Refer: 17553222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1267, '2018-09-10', '2018', '15161005', '49', '', 'Refer: 17483244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1268, '2018-09-10', '2018', '00001479', '09', '', 'Refer: 17526201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1269, '2018-09-10', '2018', '00003467', '09', '', 'Refer: 17526204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1270, '2018-09-10', '2018', '09186364', '34', '', 'Refer: 17452295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1271, '2018-09-10', '2018', '00003465', '09', '', 'Refer: 17496282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1272, '2018-09-09', '2018', '31101559', '49', '', 'Refer: 17488250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1273, '2018-09-09', '2018', '00162232', '49', '', 'Refer: 17483221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1274, '2018-09-09', '2018', '15172645', '49', '', 'Refer: 17488214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1275, '2018-09-09', '2018', '13160603', '49', '', 'Refer: 17468213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1276, '2018-09-08', '2018', '10160533', '49', '', 'Refer: 17483262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1277, '2018-09-08', '2018', '12147753', '49', '', 'Refer: 17488209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1278, '2018-09-08', '2018', '62147754', '49', '', 'Refer: 17488208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1279, '2018-09-08', '2018', '09186382', '49', '', 'Refer: 17483251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1280, '2018-09-08', '2018', '09186382', '51', '', 'Refer: 17553229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1281, '2018-09-08', '2018', '15161850', '49', '', 'Refer: 17488261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1282, '2018-09-08', '2018', '12135738', '51', '', 'Refer: 17558252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1283, '2018-09-08', '2018', '12135738', '49', '', 'Refer: 17488274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1284, '2018-09-08', '2018', '15159907', '49', '', 'Refer: 17458271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1285, '2018-09-07', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANAMEX/0', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1286, '2018-09-07', '2018', '15150058', '49', '', 'Refer: 17468234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1287, '2018-09-07', '2018', '23172536', '51', '', 'Refer: 17558261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1288, '2018-09-07', '2018', '23172536', '49', '', 'Refer: 17468249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1289, '2018-09-07', '2018', '00003466', '09', '', 'Refer: 17496293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1290, '2018-09-07', '2017', '13135764', '59', '', 'Refer: 17428275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1291, '2018-09-07', '2017', '13135764', '60', '', 'Refer: 17428272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1292, '2018-09-07', '2017', '32135865', '60', '', 'Refer: 17428224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1293, '2018-09-07', '2017', '32135865', '59', '', 'Refer: 17428227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1294, '2018-09-07', '2017', '12135762', '60', '', 'Refer: 17428237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1295, '2018-09-07', '2017', '12135762', '59', '', 'Refer: 17428240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1296, '2018-09-07', '2018', '52184519', '49', '', 'Refer: 17468258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1297, '2018-09-07', '2018', '62184518', '49', '', 'Refer: 17468264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1298, '2018-09-07', '2018', '52184519', '51', '', 'Refer: 17558270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1299, '2018-09-07', '2018', '62184518', '51', '', 'Refer: 17558276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1300, '2018-09-07', '2018', '15160712', '49', '', 'Refer: 17458241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1301, '2018-09-06', '2018', '15159593', '49', '', 'Refer: 17418208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1302, '2018-09-06', '2018', '00174278', '49', '', 'Refer: 17413281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1303, '2018-09-06', '2018', '10160545', '49', '', 'Refer: 17413275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1304, '2018-09-06', '2018', '15161370', '49', '', 'Refer: 17418277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1305, '2018-09-06', '2018', '31091541', '49', '', 'Refer: 17418226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1306, '2018-09-06', '2018', '13101717', '49', '', 'Refer: 17418277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1307, '2018-09-06', '2018', '10160649', '49', '', 'Refer: 17433273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1308, '2018-09-06', '2018', '00150378', '49', '', 'Refer: 17413273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1309, '2018-09-06', '2018', '13160585', '49', '', 'Refer: 17418237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1310, '2018-09-06', '2018', '15113767', '49', '', 'Refer: 17418235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1311, '2018-09-06', '2018', '15161804', '49', '', 'Refer: 17458286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1312, '2018-09-06', '2018', '15161679', '49', '', 'Refer: 17418233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1313, '2018-09-06', '20ID', 'EI RECIB', 'OS', '', 'Refer: ANTANDER', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1315, '2018-09-06', '2018', '21124301', '51', '', 'Refer: 17558224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1316, '2018-09-06', '2018', '00162221', '49', '', 'Refer: 17413272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1317, '2018-09-06', '2018', '00174240', '34', '', 'Refer: 17467209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1318, '2018-09-06', '2018', '00174239', '34', '', 'Refer: 17462230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1319, '2018-09-05', '2018', '42172549', '49', '', 'Refer: 17418231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1320, '2018-09-05', '2018', '16185880', '49', '', 'Refer: 17418219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1321, '2018-09-05', '2018', '00003451', '09', '', 'Refer: 17456254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1322, '2018-09-05', '2018', '09186348', '49', '', 'Refer: 17413243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1323, '2018-09-05', '2018', '00003428', '09', '', 'Refer: 17456292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1324, '2018-09-05', '2018', '15150057', '49', '', 'Refer: 17408218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1325, '2018-09-05', '2018', '16173450', '51', '', 'Refer: 17558245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1326, '2018-09-05', '2018', '16173450', '49', '', 'Refer: 17448296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1327, '2018-09-05', '2018', '00003163', '09', '', 'Refer: 17466255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1328, '2018-09-05', '2018', '00184608', '49', '', 'Refer: 17418249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1329, '2018-09-05', '2018', '15172991', '49', '', 'Refer: 17418264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1330, '2018-09-05', '2018', '31135966', '51', '', 'Refer: 17558227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1331, '2018-09-05', '2018', '31135966', '49', '', 'Refer: 17418227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1332, '2018-09-05', '2018', '09186347', '34', '', 'Refer: 17412234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1333, '2018-09-05', '2018', '09186354', '51', '', 'Refer: 17553212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1334, '2018-09-05', '2018', '09186354', '49', '', 'Refer: 17413212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1335, '2018-09-04', '2018', '00003434', '08', '', 'Refer: 17396297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1336, '2018-09-04', '2018', '19186358', '51', '', 'Refer: 17553273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1337, '2018-09-04', '2018', '00003442', '08', '', 'Refer: 17396288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1338, '2018-09-04', '2018', '00003430', '09', '', 'Refer: 17466234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1339, '2018-09-04', '2018', '29186357', '49', '', 'Refer: 17413279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1340, '2018-09-04', '2018', '00003426', '08', '', 'Refer: 17396209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1341, '2018-09-04', '2018', '14173987', '49', '', 'Refer: 17418226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1342, '2018-09-04', '2018', '20184625', '49', '', 'Refer: 17418276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1343, '2018-09-04', '2018', '20184625', '51', '', 'Refer: 17558276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1344, '2018-09-04', '2018', '14173987', '51', '', 'Refer: 17558226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1345, '2018-09-04', '2018', '00001054', '09', '', 'Refer: 17465282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1346, '2018-09-04', '2018', '00173178', '34', '', 'Refer: 17412247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1347, '2018-09-03', '2018', '00186287', '34', '', 'Refer: 17392269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1348, '2018-09-03', '2018', '00003180', '09', '', 'Refer: 17456231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1349, '2018-09-03', '2018', '00002567', '09', '', 'Refer: 17456234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1350, '2018-09-03', '2018', '15150030', '49', '', 'Refer: 17438263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1351, '2018-09-03', '2018', '00002744', '08', '', 'Refer: 17416225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1352, '2018-09-03', '2018', '00003452', '09', '', 'Refer: 17456265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1353, '2018-09-03', '2018', '14113133', '49', '', 'Refer: 17413263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1354, '2018-09-03', '2018', '00003439', '08', '', 'Refer: 17406218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1355, '2018-09-03', '2018', '00003440', '08', '', 'Refer: 17406229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1356, '2018-09-03', '2018', '15159582', '51', '', 'Refer: 17558281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1357, '2018-09-03', '2018', '15159582', '49', '', 'Refer: 17398204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1358, '2018-09-03', '2018', '00002426', '08', '', 'Refer: 17406250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1359, '2018-09-03', '2018', '19186358', '49', '', 'Refer: 17413273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1360, '2018-09-03', '2018', '00003172', '09', '', 'Refer: 17456240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1361, '2018-09-03', '2018', '09186353', '49', '', 'Refer: 17413201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1362, '2018-09-03', '2018', '00174316', '51', '', 'Refer: 17553295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1363, '2018-09-03', '2018', '00174316', '49', '', 'Refer: 17383201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1364, '2018-09-02', '2018', '00003445', '08', '', 'Refer: 17406284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1365, '2018-09-02', '2018', '00003176', '08', '', 'Refer: 17406283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1366, '2018-09-01', '2018', '00003443', '08', '', 'Refer: 17406262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1367, '2018-09-01', '2018', '00003444', '08', '', 'Refer: 17406273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1368, '2018-09-01', '2018', '00150364', '49', '', 'Refer: 17413216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1369, '2018-09-29', '2018', '23173913', '06', '', 'Refer: 19415286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1370, '2018-09-29', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANAMEX/0', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1371, '2018-09-28', '2018', '23173684', '01', '', 'Refer: 17654222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1372, '2018-09-28', '2018', '42148875', '01', '', 'Refer: 17654204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:49', '2018-12-06 02:49:49', NULL),
(1373, '2018-09-28', '2018', '52162047', '01', '', 'Refer: 17654291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1374, '2018-09-28', '2018', '13186036', '01', '', 'Refer: 17654237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1375, '2018-09-28', '20ID', 'EI RECIB', 'OS', '', 'Refer: COTIABAN', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1376, '2018-09-27', '2018', '32136845', '01', '', 'Refer: 17975288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1377, '2018-09-27', '2018', '13185694', '01', '', 'Refer: 17654279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1379, '2018-09-27', '2018', '52147775', '01', '', 'Refer: 17657224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1380, '2018-09-27', '2018', '33186372', '01', '', 'Refer: 17654233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1381, '2018-09-26', '2018', '13184553', '01', '', 'Refer: 17654277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1382, '2018-09-25', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANORTE/I', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1383, '2018-09-24', '2018', '62150209', '01', '', 'Refer: 17654251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1384, '2018-09-24', '2018', '32136231', '01', '', 'Refer: 17654219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1385, '2018-09-24', '2018', '13160732', '01', '', 'Refer: 17654249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1386, '2018-09-24', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANORTE/I', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1388, '2018-09-22', '2018', '23173030', '02', '', 'Refer: 17814285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1389, '2018-09-21', '2018', '13185414', '01', '', 'Refer: 17654238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1390, '2018-09-21', '2017', '13159104', '08', '', 'Refer: 17656279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1391, '2018-09-20', '2018', '13172716', '21', '', 'Refer: 17624214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1392, '2018-09-20', '2018', '13160734', '01', '', 'Refer: 17652245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1393, '2018-09-20', '2018', '62174339', '01', '', 'Refer: 17654235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1394, '2018-09-20', '2018', '13173976', '01', '', 'Refer: 17654265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1395, '2018-09-18', '2018', '52147449', '01', '', 'Refer: 17652210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1396, '2018-09-18', '2018', '13160689', '01', '', 'Refer: 17654277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1397, '2018-09-18', '2018', '23186359', '99', '', 'Refer: 17533264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1398, '2018-09-18', '2017', '21080173', '10', '', 'Refer: 17654221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1399, '2018-09-17', '2018', '13173084', '01', '', 'Refer: 17524227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1400, '2018-09-17', '2018', '52162184', '01', '', 'Refer: 17524257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1401, '2018-09-17', '2018', '13173488', '01', '', 'Refer: 17522216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1402, '2018-09-17', '2018', '62172547', '01', '', 'Refer: 17522223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1403, '2018-09-17', '2018', '62162360', '01', '', 'Refer: 17522212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1404, '2018-09-17', '2018', '23174197', '01', '', 'Refer: 17522203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1406, '2018-09-17', '2018', '62159734', '01', '', 'Refer: 17522201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1408, '2018-09-17', '2018', '21090435', '01', '', 'Refer: 17522281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1409, '2018-09-17', '2018', '21090444', '01', '', 'Refer: 17524212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1410, '2018-09-17', '2018', '52162104', '01', '', 'Refer: 17522224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1411, '2018-09-17', '2018', '11089407', '01', '', 'Refer: 17524227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1412, '2018-09-17', '2018', '12113710', '01', '', 'Refer: 17522228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1414, '2018-09-17', '2018', '13172671', '01', '', 'Refer: 17522238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1415, '2018-09-17', '2018', '12113474', '01', '', 'Refer: 17522202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1416, '2018-09-17', '2018', '21090613', '01', '', 'Refer: 17522267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1417, '2018-09-17', '2018', '11078897', '01', '', 'Refer: 17522247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1418, '2018-09-17', '2018', '12101891', '01', '', 'Refer: 17522202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1419, '2018-09-17', '2018', '12124922', '01', '', 'Refer: 17527210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1420, '2018-09-17', '2018', '11091455', '01', '', 'Refer: 17527277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1421, '2018-09-17', '2018', '13184667', '01', '', 'Refer: 17524281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1422, '2018-09-17', '2018', '13174155', '01', '', 'Refer: 17524235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1423, '2018-09-17', '2018', '13160596', '01', '', 'Refer: 17522241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1424, '2018-09-17', '2018', '13184772', '01', '', 'Refer: 17524256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1425, '2018-09-17', '2018', '13185987', '01', '', 'Refer: 17522254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1426, '2018-09-17', '2018', '13185600', '01', '', 'Refer: 17524242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1427, '2018-09-17', '2018', '11078401', '01', '', 'Refer: 17524216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1428, '2018-09-17', '2018', '12112961', '01', '', 'Refer: 17522222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1429, '2018-09-17', '20ID', 'EI RECIB', 'OI', '', 'Refer: NBURSA/0', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1430, '2018-09-17', '2018', '13184864', '10', '', 'Refer: 20444248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1432, '2018-09-17', '2018', '13161103', '01', '', 'Refer: 17524262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1433, '2018-09-17', '2018', '13172584', '01', '', 'Refer: 17524293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1434, '2018-09-17', '2018', '12101812', '01', '', 'Refer: 17524232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1436, '2018-09-17', '2018', '52159068', '01', '', 'Refer: 17522245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1437, '2018-09-17', '2018', '13184541', '01', '', 'Refer: 17524269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1438, '2018-09-17', '2018', '12101645', '01', '', 'Refer: 17524270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1441, '2018-09-17', '2018', '31102580', '01', '', 'Refer: 17522264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1442, '2018-09-17', '2018', '12124494', '01', '', 'Refer: 17522270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1447, '2018-09-17', '2018', '13161132', '01', '', 'Refer: 17524290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1448, '2018-09-17', '2018', '22136874', '01', '', 'Refer: 17522293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1449, '2018-09-17', '2018', '31113131', '01', '', 'Refer: 17524210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1450, '2018-09-17', '2018', '23173836', '01', '', 'Refer: 17522214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1451, '2018-09-17', '2018', '31113484', '01', '', 'Refer: 17526288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1452, '2018-09-17', '2018', '12148206', '01', '', 'Refer: 17526218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1453, '2018-09-17', '2018', '12124638', '01', '', 'Refer: 17522270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1454, '2018-09-17', '2018', '13186237', '01', '', 'Refer: 17522283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1455, '2018-09-17', '2018', '12135903', '01', '', 'Refer: 17526224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1456, '2018-09-17', '2018', '13184725', '01', '', 'Refer: 17524224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1458, '2018-09-17', '2018', '11089532', '01', '', 'Refer: 17520273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1459, '2018-09-17', '2018', '13173841', '01', '', 'Refer: 17526207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1461, '2018-09-17', '2018', '12101738', '01', '', 'Refer: 17522281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1462, '2018-09-17', '2018', '12147312', '01', '', 'Refer: 17522230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1463, '2018-09-17', '2018', '42159620', '01', '', 'Refer: 17524216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1464, '2018-09-17', '2018', '31113716', '01', '', 'Refer: 17522218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1466, '2018-09-17', '2018', '11090584', '01', '', 'Refer: 17522238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1467, '2018-09-17', '2018', '12101815', '09', '', 'Refer: 19982276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1468, '2018-09-17', '2018', '12101815', '08', '', 'Refer: 19672286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1469, '2018-09-17', '2018', '12101815', '07', '', 'Refer: 19362296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL);
INSERT INTO `edocta` (`id`, `edoFechaOper`, `edoAnioPago`, `edoClaveAlu`, `edoMesPago`, `edoDigPago`, `edoDescripcion`, `edoImpAbono`, `edoImpCargo`, `edoEstado`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1470, '2018-09-17', '2018', '12101815', '06', '', 'Refer: 19052209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1471, '2018-09-17', '2018', '12101815', '05', '', 'Refer: 18742289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1472, '2018-09-17', '2018', '12101815', '04', '', 'Refer: 18452236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1473, '2018-09-17', '2018', '12101815', '03', '', 'Refer: 18122212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1474, '2018-09-17', '2018', '12101815', '02', '', 'Refer: 17812292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1475, '2018-09-17', '2018', '12101815', '01', '', 'Refer: 17522239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1476, '2018-09-17', '2018', '21101816', '09', '', 'Refer: 19982291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1477, '2018-09-17', '2018', '21101816', '08', '', 'Refer: 19672204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1478, '2018-09-17', '2018', '21101816', '07', '', 'Refer: 19362214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1479, '2018-09-17', '2018', '21101816', '06', '', 'Refer: 19052224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1480, '2018-09-17', '2018', '21101816', '05', '', 'Refer: 18742207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1481, '2018-09-17', '2018', '21101816', '04', '', 'Refer: 18452251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1482, '2018-09-17', '2018', '21101816', '03', '', 'Refer: 18122227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1483, '2018-09-17', '2018', '21101816', '02', '', 'Refer: 17812210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1484, '2018-09-17', '2018', '21101816', '01', '', 'Refer: 17522254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1485, '2018-09-17', '2018', '13160604', '01', '', 'Refer: 17524242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1486, '2018-09-17', '2018', '11101543', '01', '', 'Refer: 17524218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1487, '2018-09-17', '2018', '11090410', '01', '', 'Refer: 17522280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1488, '2018-09-17', '2018', '13184773', '01', '', 'Refer: 17522241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1493, '2018-09-17', '2018', '13172823', '01', '', 'Refer: 17524255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1494, '2018-09-17', '2018', '13161104', '01', '', 'Refer: 17524273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1495, '2018-09-17', '2018', '31091541', '01', '', 'Refer: 17522206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1496, '2018-09-17', '2018', '42136639', '01', '', 'Refer: 17522296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1497, '2018-09-16', '2018', '12124315', '01', '', 'Refer: 17524283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1498, '2018-09-16', '2018', '13160601', '01', '', 'Refer: 17526235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1499, '2018-09-16', '2018', '62161570', '01', '', 'Refer: 17524266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1500, '2018-09-16', '20ID', 'EI RECIB', 'OS', '', 'Refer: ANTANDER', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1501, '2018-09-16', '2018', '12135831', '01', '', 'Refer: 17524295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1502, '2018-09-15', '2018', '62161686', '01', '', 'Refer: 17522239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1503, '2018-09-15', '2018', '13172509', '01', '', 'Refer: 17524244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1504, '2018-09-15', '2018', '23174430', '01', '', 'Refer: 17524222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1505, '2018-09-15', '2018', '22136604', '01', '', 'Refer: 17524291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1506, '2018-09-15', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1507, '2018-09-15', '2018', '24186022', '01', '', 'Refer: 17524237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1508, '2018-09-15', '20ID', 'EI RECIB', 'OS', '', 'Refer: ANTANDER', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1509, '2018-09-15', '2018', '13172712', '01', '', 'Refer: 17522285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1510, '2018-09-15', '2018', '52162328', '01', '', 'Refer: 17522231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1511, '2018-09-14', '2018', '13184550', '01', '', 'Refer: 17522245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1512, '2018-09-14', '2018', '13172504', '10', '', 'Refer: 20444252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1513, '2018-09-14', '2018', '13160736', '01', '', 'Refer: 17527262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1514, '2018-09-14', '2018', '31090725', '01', '', 'Refer: 17522239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1515, '2018-09-14', '2018', '12124418', '01', '', 'Refer: 17529204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1516, '2018-09-14', '2018', '12102151', '01', '', 'Refer: 17522244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1517, '2018-09-14', '2018', '12124302', '01', '', 'Refer: 17524237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1519, '2018-09-14', '2018', '31113193', '01', '', 'Refer: 17522284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1520, '2018-09-14', '2018', '12101820', '01', '', 'Refer: 17524223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1522, '2018-09-14', '2018', '62173173', '01', '', 'Refer: 17524292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1523, '2018-09-14', '2018', '21079260', '01', '', 'Refer: 17522259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1524, '2018-09-14', '2018', '13186301', '01', '', 'Refer: 17522292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1525, '2018-09-14', '2018', '13185715', '01', '', 'Refer: 17524230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1526, '2018-09-14', '20S', 'P.CHEQUE', 'DE', '', 'Refer:  OTRO BA', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1527, '2018-09-14', '2018', '23173707', '01', '', 'Refer: 17524292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1528, '2018-09-14', '2018', '13160600', '01', '', 'Refer: 17524295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1529, '2018-09-14', '2018', '13184537', '01', '', 'Refer: 17524225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1530, '2018-09-14', '2018', '13161103', '99', '', 'Refer: 17653285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1531, '2018-09-14', '2018', '13172713', '01', '', 'Refer: 17522296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1532, '2018-09-14', '2018', '32136231', '21', '', 'Refer: 17554234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1533, '2018-09-14', '2018', '13161011', '01', '', 'Refer: 17524236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1534, '2018-09-14', '2018', '13172508', '01', '', 'Refer: 17524233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1535, '2018-09-14', '2018', '12101723', '01', '', 'Refer: 17522213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1536, '2018-09-14', '2018', '13160585', '01', '', 'Refer: 17522217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1537, '2018-09-14', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANORTE/I', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1538, '2018-09-14', '20ID', 'EI RECIB', 'OI', '', 'Refer: NBURSA/0', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1539, '2018-09-14', '2018', '13161507', '01', '', 'Refer: 17524277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1540, '2018-09-14', '2018', '12091255', '01', '', 'Refer: 17522288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1541, '2018-09-14', '2018', '12147828', '01', '', 'Refer: 17524226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1542, '2018-09-14', '2018', '23174331', '01', '', 'Refer: 17524216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1544, '2018-09-14', '2018', '62172447', '01', '', 'Refer: 17522206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1545, '2018-09-14', '2018', '12124987', '01', '', 'Refer: 17522278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1547, '2018-09-14', '2018', '00148811', '01', '', 'Refer: 17522280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1549, '2018-09-14', '2018', '12124316', '01', '', 'Refer: 17522268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1550, '2018-09-14', '2018', '12135804', '01', '', 'Refer: 17524289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1551, '2018-09-14', '2018', '52148322', '01', '', 'Refer: 17524259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1552, '2018-09-14', '2018', '32136563', '01', '', 'Refer: 17524261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1553, '2018-09-14', '2018', '32136610', '01', '', 'Refer: 17524277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1554, '2018-09-14', '2018', '42147201', '01', '', 'Refer: 17520214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1555, '2018-09-14', '2018', '33184484', '01', '', 'Refer: 17522248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1556, '2018-09-14', '2018', '13160660', '01', '', 'Refer: 17524276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1557, '2018-09-14', '2018', '12160636', '01', '', 'Refer: 17524290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1558, '2018-09-14', '2018', '12124260', '01', '', 'Refer: 17524276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1559, '2018-09-14', '2018', '52160950', '01', '', 'Refer: 17524272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1560, '2018-09-14', '2018', '13160591', '01', '', 'Refer: 17526238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1561, '2018-09-13', '2018', '13160759', '99', '', 'Refer: 17653208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1562, '2018-09-13', '2018', '32136845', '99', '', 'Refer: 17653234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1563, '2018-09-13', '2018', '11078662', '10', '', 'Refer: 20441266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1564, '2018-09-13', '2018', '23173185', '01', '', 'Refer: 17524272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1566, '2018-09-13', '2018', '13185264', '02', '', 'Refer: 17814252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1567, '2018-09-13', '2018', '13185264', '01', '', 'Refer: 17524296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1569, '2018-09-13', '2018', '13160594', '01', '', 'Refer: 17522219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1570, '2018-09-13', '2018', '13184552', '01', '', 'Refer: 17524293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1571, '2018-09-13', '2018', '12101728', '01', '', 'Refer: 17524294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1572, '2018-09-13', '2018', '11078602', '01', '', 'Refer: 17522235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1573, '2018-09-13', '2018', '42136232', '01', '', 'Refer: 17524274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1574, '2018-09-13', '2018', '23185762', '01', '', 'Refer: 17524279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1575, '2018-09-13', '2018', '12101585', '01', '', 'Refer: 17522279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1576, '2018-09-13', '20ID', 'EI RECIB', 'OS', '', 'Refer: ANTANDER', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1577, '2018-09-13', '2018', '52158899', '01', '', 'Refer: 17522218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1578, '2018-09-13', '2018', '32158898', '01', '', 'Refer: 17524296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1579, '2018-09-13', '2018', '32136193', '01', '', 'Refer: 17524232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1580, '2018-09-13', '2018', '12147290', '09', '', 'Refer: 19986287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1581, '2018-09-13', '2018', '12147290', '08', '', 'Refer: 19676297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1582, '2018-09-13', '2018', '12147290', '07', '', 'Refer: 19366210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1583, '2018-09-13', '2018', '12147290', '06', '', 'Refer: 19056220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1584, '2018-09-13', '2018', '12147290', '05', '', 'Refer: 18746203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1585, '2018-09-13', '2018', '12147290', '04', '', 'Refer: 18456247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1586, '2018-09-13', '2018', '12147290', '03', '', 'Refer: 18126223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1587, '2018-09-13', '2018', '12147290', '02', '', 'Refer: 17816206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1588, '2018-09-13', '2018', '12147290', '01', '', 'Refer: 17526250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1589, '2018-09-13', '2018', '12101710', '01', '', 'Refer: 17522264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1590, '2018-09-13', '2018', '12112834', '10', '', 'Refer: 20444288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:50', '2018-12-06 02:49:50', NULL),
(1591, '2018-09-13', '2018', '32147234', '10', '', 'Refer: 20441248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1592, '2018-09-13', '2018', '13173288', '01', '', 'Refer: 17522279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1593, '2018-09-13', '2018', '33186052', '01', '', 'Refer: 17524280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1594, '2018-09-13', '2018', '13161395', '01', '', 'Refer: 17522215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1595, '2018-09-13', '2018', '12124825', '01', '', 'Refer: 17522258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1596, '2018-09-13', '2018', '00162224', '01', '', 'Refer: 17524279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1597, '2018-09-13', '2018', '13160603', '01', '', 'Refer: 17524231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1598, '2018-09-13', '2018', '12124267', '01', '', 'Refer: 17524256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1599, '2018-09-13', '2018', '13184554', '01', '', 'Refer: 17524218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1602, '2018-09-12', '2018', '13184771', '01', '', 'Refer: 17522219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1603, '2018-09-12', '2017', '13161103', '01', '', 'Refer: 17659281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1604, '2018-09-12', '2018', '13184922', '01', '', 'Refer: 17524225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1606, '2018-09-12', '2018', '52147775', '99', '', 'Refer: 17653235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1607, '2018-09-12', '2018', '13161656', '01', '', 'Refer: 17522225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1608, '2018-09-12', '2018', '12124649', '01', '', 'Refer: 17524223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1609, '2018-09-12', '2018', '12124650', '01', '', 'Refer: 17522208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1610, '2018-09-12', '2018', '13161974', '01', '', 'Refer: 17522280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1611, '2018-09-12', '2018', '23184927', '01', '', 'Refer: 17522271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1612, '2018-09-12', '2018', '13185447', '01', '', 'Refer: 17524240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1613, '2018-09-12', '2018', '13184876', '01', '', 'Refer: 17524220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1614, '2018-09-12', '2018', '12124363', '01', '', 'Refer: 17524229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1615, '2018-09-12', '2018', '12124178', '10', '', 'Refer: 20443216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1616, '2018-09-12', '2018', '12113635', '01', '', 'Refer: 17522292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1620, '2018-09-12', '2018', '12124843', '01', '', 'Refer: 17522262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1622, '2018-09-11', '2018', '13160599', '01', '', 'Refer: 17524203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1625, '2018-09-11', '2018', '52162142', '01', '', 'Refer: 17524280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1627, '2018-09-11', '2018', '21101601', '05', '', 'Refer: 18742202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1628, '2018-09-11', '2018', '21101601', '04', '', 'Refer: 18452246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1629, '2018-09-11', '2018', '21101601', '03', '', 'Refer: 18122222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1630, '2018-09-11', '2018', '21101601', '02', '', 'Refer: 17812205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1631, '2018-09-11', '2018', '21101601', '01', '', 'Refer: 17522249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1632, '2018-09-11', '2018', '12112855', '01', '', 'Refer: 17524262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1633, '2018-09-11', '2018', '13184875', '01', '', 'Refer: 17522280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1634, '2018-09-11', '2018', '42136719', '10', '', 'Refer: 20442253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1635, '2018-09-11', '2018', '11113115', '10', '', 'Refer: 20441218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1636, '2018-09-11', '2018', '23173382', '01', '', 'Refer: 17522247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1637, '2018-09-11', '2018', '62150455', '01', '', 'Refer: 17524236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1638, '2018-09-11', '2018', '13173806', '01', '', 'Refer: 17522255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1639, '2018-09-11', '2018', '32148216', '01', '', 'Refer: 17524239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1642, '2018-09-10', '2018', '62174118', '01', '', 'Refer: 17524288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1643, '2018-09-10', '2018', '62161475', '10', '', 'Refer: 20444270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1644, '2018-09-10', '2018', '52161474', '10', '', 'Refer: 20441203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1645, '2018-09-10', '2018', '62173065', '01', '', 'Refer: 17524284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1646, '2018-09-10', '2018', '13160595', '10', '', 'Refer: 20443209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1647, '2018-09-10', '2018', '13161722', '99', '', 'Refer: 17653208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1648, '2018-09-10', '2018', '13160737', '34', '', 'Refer: 17522201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1649, '2018-09-10', '2018', '13160737', '10', '', 'Refer: 20441258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1650, '2018-09-10', '2018', '11078409', '10', '', 'Refer: 20312271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1651, '2018-09-10', '2018', '11078409', '09', '', 'Refer: 19982218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1652, '2018-09-10', '2018', '11078409', '08', '', 'Refer: 19672228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1653, '2018-09-10', '2018', '11078409', '07', '', 'Refer: 19362238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1654, '2018-09-10', '2018', '11078409', '06', '', 'Refer: 19052248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1655, '2018-09-10', '2018', '11078409', '05', '', 'Refer: 18742231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1656, '2018-09-10', '2018', '11078409', '04', '', 'Refer: 18452275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1657, '2018-09-10', '2018', '11078409', '03', '', 'Refer: 18122251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1658, '2018-09-10', '2018', '11078409', '02', '', 'Refer: 17812234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1659, '2018-09-10', '2018', '11078409', '01', '', 'Refer: 17522278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1660, '2018-09-10', '2018', '13184842', '01', '', 'Refer: 17524234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1661, '2018-09-10', '2018', '13173743', '01', '', 'Refer: 17524283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1662, '2018-09-10', '2018', '13160648', '01', '', 'Refer: 17522215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1663, '2018-09-10', '2018', '13160598', '01', '', 'Refer: 17522263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1664, '2018-09-10', '2018', '13160605', '01', '', 'Refer: 17522227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1667, '2018-09-09', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANORTE/I', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1668, '2018-09-09', '2018', '13172506', '01', '', 'Refer: 17524211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1669, '2018-09-08', '2018', '32136760', '01', '', 'Refer: 17522236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1670, '2018-09-08', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANAMEX/0', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1672, '2018-09-07', '2018', '13172716', '01', '', 'Refer: 17524258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1673, '2018-09-07', '2018', '13160738', '01', '', 'Refer: 17524245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1674, '2018-09-07', '2018', '13160738', '34', '', 'Refer: 17452244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1675, '2018-09-07', '2018', '23173030', '01', '', 'Refer: 17524232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1676, '2018-09-07', '2018', '23172536', '01', '', 'Refer: 17524267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1677, '2018-09-07', '2018', '13184770', '01', '', 'Refer: 17524234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1678, '2018-09-07', '2018', '13161174', '01', '', 'Refer: 17522241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1679, '2018-09-07', '2018', '33186309', '01', '', 'Refer: 17524246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1680, '2018-09-07', '2018', '33185567', '01', '', 'Refer: 17524220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1681, '2018-09-07', '2018', '62160500', '01', '', 'Refer: 17524253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1682, '2018-09-06', '2018', '11089499', '01', '', 'Refer: 17522243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1683, '2018-09-06', '2018', '13184544', '01', '', 'Refer: 17522276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1685, '2018-09-06', '2018', '12112908', '01', '', 'Refer: 17524247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1686, '2018-09-06', '2018', '13173693', '01', '', 'Refer: 17524234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1687, '2018-09-06', '2018', '13185767', '01', '', 'Refer: 17522291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1688, '2018-09-06', '2018', '12113552', '99', '', 'Refer: 17653220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1689, '2018-09-06', '2018', '32136231', '01', '', 'Refer: 17524246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1690, '2018-09-06', '2018', '23185138', '10', '', 'Refer: 20441228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1691, '2018-09-06', '2018', '13160717', '09', '', 'Refer: 19982219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1692, '2018-09-06', '2018', '13160717', '08', '', 'Refer: 19672229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1693, '2018-09-06', '2018', '13160717', '07', '', 'Refer: 19362239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1694, '2018-09-06', '2018', '13160717', '06', '', 'Refer: 19052249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1695, '2018-09-06', '2018', '13160717', '05', '', 'Refer: 18742232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1696, '2018-09-06', '2018', '13160717', '04', '', 'Refer: 18452276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1697, '2018-09-06', '2018', '13160717', '03', '', 'Refer: 18122252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1698, '2018-09-06', '2018', '13160717', '02', '', 'Refer: 17812235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1699, '2018-09-06', '2018', '13160717', '01', '', 'Refer: 17522279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1700, '2018-09-06', '2018', '13160606', '10', '', 'Refer: 20443217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1701, '2018-09-05', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANAMEX/0', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1702, '2018-09-05', '20ID', 'EI RECIB', 'OV', '', 'Refer: E POR MA', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1703, '2018-09-05', '2018', '33186372', '99', '', 'Refer: 17553264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1704, '2018-09-05', '2017', '11067898', '10', '', 'Refer: 17658252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1705, '2018-09-05', '2018', '13173991', '01', '', 'Refer: 17522237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1707, '2018-09-05', '2018', '42147451', '01', '', 'Refer: 17522242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1708, '2018-09-05', '2018', '62147520', '01', '', 'Refer: 17524269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1709, '2018-09-05', '2018', '13184539', '01', '', 'Refer: 17524247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1711, '2018-09-05', '2018', '13173371', '01', '', 'Refer: 17522206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1712, '2018-09-05', '2018', '13184774', '01', '', 'Refer: 17522252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1713, '2018-09-05', '2018', '24173083', '01', '', 'Refer: 17522220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1714, '2018-09-04', '2018', '23173684', '99', '', 'Refer: 17653272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1715, '2018-09-04', '2018', '23174165', '01', '', 'Refer: 17524265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1716, '2018-09-30', '2018', '15161745', '06', '', 'Refer: 19188265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1717, '2018-09-29', '2018', '15174214', '01', '', 'Refer: 17860288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1718, '2018-09-29', '2000', '15161343', '03', '', 'Refer: 17869221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1719, '2018-09-29', '2018', '15185507', '01', '', 'Refer: 17860207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1720, '2018-09-29', '2018', '13124252', '02', '', 'Refer: 17814254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1721, '2018-09-29', '2001', '15173447', '33', '', 'Refer: 17813250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1722, '2018-09-28', '2001', '15172762', '58', '', 'Refer: 17658253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1723, '2018-09-28', '2018', '15185199', '01', '', 'Refer: 17659243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1724, '2018-09-28', '2018', '15159664', '99', '', 'Refer: 17659207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1725, '2018-09-28', '2018', '15161530', '99', '', 'Refer: 17719220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1726, '2018-09-28', '2000', '15159189', '73', '', 'Refer: 17657278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1727, '2018-09-28', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1728, '2018-09-28', '2018', '13114004', '10', '', 'Refer: 20442235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1729, '2018-09-28', '2000', '15173348', '37', '', 'Refer: 17653210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1730, '2018-09-28', '2001', '15161440', '12', '', 'Refer: 17653289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1731, '2018-09-28', '2018', '15148351', '01', '', 'Refer: 17658283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1732, '2018-09-28', '2018', '15185851', '02', '', 'Refer: 17817276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1733, '2018-09-28', '2018', '15136159', '99', '', 'Refer: 17659255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1734, '2018-09-28', '2018', '15186286', '99', '', 'Refer: 17689250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1735, '2018-09-28', '2018', '15161659', '01', '', 'Refer: 17652257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1736, '2018-09-28', '2018', '42034739', '01', '', 'Refer: 17658218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1737, '2018-09-28', '2018', '15159321', '01', '', 'Refer: 17658286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1738, '2018-09-28', '2005', '15161606', '13', '', 'Refer: 17658297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1739, '2018-09-28', '2018', '15159433', '99', '', 'Refer: 17659220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1740, '2018-09-28', '2018', '15174292', '02', '', 'Refer: 17814253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1741, '2018-09-28', '2018', '15159945', '01', '', 'Refer: 17658264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1742, '2018-09-28', '2018', '15173823', '99', '', 'Refer: 17659207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1743, '2018-09-28', '2017', '15148437', '06', '', 'Refer: 17656263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1744, '2018-09-28', '2000', '15185440', '43', '', 'Refer: 18120294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1745, '2018-09-28', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANAMEX/0', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1746, '2018-09-28', '2000', '15173009', '77', '', 'Refer: 17658251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1747, '2018-09-28', '2018', '15078824', '99', '', 'Refer: 17659205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1748, '2018-09-28', '2002', '15173196', '92', '', 'Refer: 17652281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1749, '2018-09-28', '2018', '15173481', '01', '', 'Refer: 17658216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1750, '2018-09-28', '2018', '15172651', '01', '', 'Refer: 17655250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1751, '2018-09-28', '2001', '15173941', '62', '', 'Refer: 17653240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1752, '2018-09-28', '2018', '15159509', '02', '', 'Refer: 17818268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1753, '2018-09-28', '2000', '15185919', '74', '', 'Refer: 17658245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1754, '2018-09-28', '2002', '15186124', '54', '', 'Refer: 17650277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1755, '2018-09-28', '2016', '15136339', '10', '', 'Refer: 17658250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1756, '2018-09-28', '2018', '15148483', '99', '', 'Refer: 17659243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1759, '2018-09-28', '2018', '15186007', '99', '', 'Refer: 17653285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1760, '2018-09-28', '2018', '15185814', '10', '', 'Refer: 20442202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1761, '2018-09-28', '2018', '15161821', '02', '', 'Refer: 17810218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1762, '2018-09-28', '2000', '14124503', '53', '', 'Refer: 17812258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1763, '2018-09-28', '2018', '54148384', '01', '', 'Refer: 17658216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1764, '2018-09-28', '2018', '15147393', '02', '', 'Refer: 17817211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1765, '2018-09-28', '2001', '22078597', '00', '', 'Refer: 17659218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1766, '2018-09-28', '2018', '15173858', '99', '', 'Refer: 17659204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1767, '2018-09-28', '2018', '15185329', '02', '', 'Refer: 17814201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1768, '2018-09-27', '2002', '15159312', '99', '', 'Refer: 17658210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1769, '2018-09-27', '2017', '15159759', '10', '', 'Refer: 17658272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1770, '2018-09-27', '2018', '15173245', '01', '', 'Refer: 17658271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1771, '2018-09-27', '2018', '15173931', '01', '', 'Refer: 17658236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1772, '2018-09-27', '2018', '15159546', '02', '', 'Refer: 17818287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1773, '2018-09-27', '2018', '15186375', '99', '', 'Refer: 17629238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1774, '2018-09-27', '2018', '15159370', '10', '', 'Refer: 20441242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1775, '2018-09-27', '2018', '15159658', '10', '', 'Refer: 20447239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1776, '2018-09-27', '2018', '15160621', '99', '', 'Refer: 17659265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1777, '2018-09-27', '2018', '15090549', '85', '', 'Refer: 17702291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1778, '2018-09-27', '2017', '15148262', '05', '', 'Refer: 17655284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1779, '2018-09-27', '2018', '15173234', '99', '', 'Refer: 17659226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1780, '2018-09-27', '2018', '14090529', '99', '', 'Refer: 17659284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1781, '2018-09-27', '2018', '15159495', '01', '', 'Refer: 17650237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1782, '2018-09-27', '2018', '15162100', '01', '', 'Refer: 17650292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1783, '2018-09-27', '2018', '15159539', '02', '', 'Refer: 17812229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1784, '2018-09-27', '2018', '15136529', '78', '', 'Refer: 17691201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1785, '2018-09-27', '2018', '15186341', '01', '', 'Refer: 17654272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1786, '2018-09-27', '2018', '15148188', '99', '', 'Refer: 17659247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1787, '2018-09-27', '2003', '15161693', '38', '', 'Refer: 17658248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1788, '2018-09-27', '2017', '15173801', '10', '', 'Refer: 17658262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1789, '2018-09-27', '2018', '15136069', '78', '', 'Refer: 17691265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1790, '2018-09-27', '2017', '05159502', '00', '', 'Refer: 17673225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:51', '2018-12-06 02:49:51', NULL),
(1791, '2018-09-27', '2017', '15159513', '07', '', 'Refer: 17651297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1792, '2018-09-27', '2018', '15185381', '78', '', 'Refer: 17701216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1793, '2018-09-27', '2018', '15161501', '78', '', 'Refer: 17691255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1794, '2018-09-27', '2018', '15161115', '99', '', 'Refer: 17659230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1795, '2018-09-27', '2018', '15102522', '85', '', 'Refer: 17693274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1796, '2018-09-27', '2001', '15150052', '26', '', 'Refer: 17657238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1797, '2018-09-26', '2018', '15160762', '78', '', 'Refer: 17691262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1798, '2018-09-26', '2018', '15172820', '01', '', 'Refer: 17658273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1800, '2018-09-26', '2018', '15159810', '99', '', 'Refer: 17659229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1801, '2018-09-26', '2015', '15148692', '06', '', 'Refer: 17654256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1802, '2018-09-26', '2018', '15136853', '78', '', 'Refer: 17691225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1803, '2018-09-26', '2017', '11013128', '00', '', 'Refer: 17653254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1804, '2018-09-26', '2018', '15186187', '01', '', 'Refer: 17654259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1805, '2018-09-26', '2000', '15185825', '76', '', 'Refer: 17814238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1806, '2018-09-26', '2018', '15186298', '01', '', 'Refer: 17652274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1807, '2018-09-26', '2018', '15184928', '01', '', 'Refer: 17658245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1808, '2018-09-26', '2018', '07173161', '98', '', 'Refer: 17632280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1809, '2018-09-26', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1810, '2018-09-26', '2004', '15159327', '25', '', 'Refer: 18122235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1811, '2018-09-26', '2004', '15159327', '22', '', 'Refer: 17812289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1812, '2018-09-26', '2018', '14147886', '01', '', 'Refer: 17658236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1813, '2018-09-26', '2017', '15159999', '04', '', 'Refer: 17657283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1814, '2018-09-26', '2002', '11990002', '59', '', 'Refer: 17819212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1815, '2018-09-26', '2018', '11990032', '78', '', 'Refer: 17681289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1816, '2018-09-26', '2017', '15159472', '02', '', 'Refer: 17658276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1817, '2018-09-26', '2000', '15172783', '46', '', 'Refer: 17819211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1818, '2018-09-26', '2018', '15185114', '01', '', 'Refer: 17653297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1819, '2018-09-26', '2000', '15159498', '37', '', 'Refer: 17657218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1820, '2018-09-26', '2000', '15161780', '86', '', 'Refer: 17658221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1821, '2018-09-26', '2000', '15161780', '85', '', 'Refer: 17658208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1822, '2018-09-26', '2000', '15161780', '84', '', 'Refer: 17658292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1823, '2018-09-26', '2000', '15161780', '83', '', 'Refer: 17658279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1824, '2018-09-26', '2018', '15147673', '78', '', 'Refer: 17681242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1825, '2018-09-26', '20ID', 'EI RECIB', 'OI', '', 'Refer: NBURSA/0', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1826, '2018-09-26', '2018', '15159777', '02', '', 'Refer: 17818274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1827, '2018-09-26', '2018', '15159777', '01', '', 'Refer: 17658291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1828, '2018-09-25', '2018', '15147813', '78', '', 'Refer: 17681295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1829, '2018-09-25', '2018', '15185826', '01', '', 'Refer: 17658225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1830, '2018-09-25', '2018', '15185448', '01', '', 'Refer: 17658205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1831, '2018-09-25', '2017', '15159908', '10', '', 'Refer: 17658230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1832, '2018-09-25', '2018', '15136003', '78', '', 'Refer: 17671281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1834, '2018-09-25', '2018', '15185752', '01', '', 'Refer: 17658203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1835, '2018-09-25', '2018', '15161715', '01', '', 'Refer: 17659269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1836, '2018-09-25', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1837, '2018-09-25', '2018', '15185957', '02', '', 'Refer: 17814223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1838, '2018-09-25', '2018', '15173249', '01', '', 'Refer: 17651224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1839, '2018-09-25', '2001', '15159593', '12', '', 'Refer: 17812296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1840, '2018-09-25', '2002', '15159643', '20', '', 'Refer: 17812258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1841, '2018-09-25', '2001', '15172708', '51', '', 'Refer: 17819230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1842, '2018-09-25', '2018', '15161119', '01', '', 'Refer: 17651204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1843, '2018-09-25', '2018', '15159449', '99', '', 'Refer: 17659202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1844, '2018-09-25', '2001', '15173013', '12', '', 'Refer: 17813246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1845, '2018-09-25', '2018', '15124751', '02', '', 'Refer: 17812231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1846, '2018-09-25', '2018', '15172907', '01', '', 'Refer: 17658244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1847, '2018-09-25', '2018', '15174059', '01', '', 'Refer: 17654261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1848, '2018-09-25', '2018', '15024589', '86', '', 'Refer: 17605291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1849, '2018-09-25', '2018', '15185798', '78', '', 'Refer: 17631212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1850, '2018-09-25', '2018', '15173364', '99', '', 'Refer: 17659282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1851, '2018-09-25', '2018', '15150206', '99', '', 'Refer: 17659203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1852, '2018-09-24', '2018', '15159617', '99', '', 'Refer: 17659272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1853, '2018-09-24', '2018', '54174063', '10', '', 'Refer: 20444256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1854, '2018-09-24', '2018', '15173872', '01', '', 'Refer: 17653217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1855, '2018-09-24', '2000', '15185487', '02', '', 'Refer: 17658278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL);
INSERT INTO `edocta` (`id`, `edoFechaOper`, `edoAnioPago`, `edoClaveAlu`, `edoMesPago`, `edoDigPago`, `edoDescripcion`, `edoImpAbono`, `edoImpCargo`, `edoEstado`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1856, '2018-09-24', '2002', '15161422', '06', '', 'Refer: 17658210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1857, '2018-09-24', '2018', '15148311', '99', '', 'Refer: 17659210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1858, '2018-09-24', '2018', '14136700', '99', '', 'Refer: 17659277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1859, '2018-09-24', '2018', '15159937', '99', '', 'Refer: 17659252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1860, '2018-09-24', '2017', '15150214', '10', '', 'Refer: 17656271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1861, '2018-09-24', '2018', '15159508', '94', '', 'Refer: 17593256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1862, '2018-09-24', '2017', '15148437', '00', '', 'Refer: 17613272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1863, '2018-09-24', '2018', '15161440', '99', '', 'Refer: 17659265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1864, '2018-09-24', '2018', '15174138', '02', '', 'Refer: 17814224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1865, '2018-09-24', '2002', '15172831', '18', '', 'Refer: 20446231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1866, '2018-09-24', '2017', '15148607', '10', '', 'Refer: 17651229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1867, '2018-09-24', '2018', '15185654', '01', '', 'Refer: 17658208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1868, '2018-09-24', '2018', '15148578', '99', '', 'Refer: 17659205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1869, '2018-09-24', '2001', '15161230', '74', '', 'Refer: 17656215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1870, '2018-09-24', '2018', '15185450', '01', '', 'Refer: 17658227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1871, '2018-09-24', '2017', '15173069', '00', '', 'Refer: 17652294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1872, '2018-09-24', '2018', '15159432', '99', '', 'Refer: 17659209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1873, '2018-09-24', '2018', '15150225', '99', '', 'Refer: 17609230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1874, '2018-09-24', '2001', '15160772', '98', '', 'Refer: 17658273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1875, '2018-09-24', '2018', '15148521', '99', '', 'Refer: 17659257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1876, '2018-09-23', '2018', '15161152', '02', '', 'Refer: 17811259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1877, '2018-09-23', '2018', '15159745', '99', '', 'Refer: 17659209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1878, '2018-09-22', '2018', '15159454', '01', '', 'Refer: 17655239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1879, '2018-09-22', '2018', '15161646', '99', '', 'Refer: 17659268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1880, '2018-09-21', '2018', '15150142', '01', '', 'Refer: 17658215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1881, '2018-09-21', '2018', '15185310', '01', '', 'Refer: 17658255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1882, '2018-09-21', '2018', '15186098', '01', '', 'Refer: 17658221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1883, '2018-09-21', '2018', '15160527', '99', '', 'Refer: 17659217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1884, '2018-09-21', '2017', '14091349', '10', '', 'Refer: 17652223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1885, '2018-09-21', '2018', '15172606', '01', '', 'Refer: 17658279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1886, '2018-09-21', '2018', '15159498', '99', '', 'Refer: 17629205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1887, '2018-09-21', '2001', '15150111', '89', '', 'Refer: 17657236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1888, '2018-09-21', '2002', '15161667', '15', '', 'Refer: 17979265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1889, '2018-09-21', '2002', '15161667', '14', '', 'Refer: 17659258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1890, '2018-09-21', '2018', '15185728', '01', '', 'Refer: 17658230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1891, '2018-09-21', '2000', '15185469', '40', '', 'Refer: 17810279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1892, '2018-09-21', '2018', '14113727', '99', '', 'Refer: 17639243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1893, '2018-09-21', '2006', '14113727', '66', '', 'Refer: 17650203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1895, '2018-09-21', '2018', '10185297', '94', '', 'Refer: 17573205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1896, '2018-09-21', '2000', '15161305', '77', '', 'Refer: 17658294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1897, '2018-09-20', '2000', '15150271', '72', '', 'Refer: 17657204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1898, '2018-09-20', '2001', '15159790', '76', '', 'Refer: 17658268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1899, '2018-09-20', '2018', '17184857', '94', '', 'Refer: 17553293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1900, '2018-09-20', '2018', '15185597', '01', '', 'Refer: 17658276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1901, '2018-09-20', '2018', '17185014', '94', '', 'Refer: 17557240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1902, '2018-09-20', '2018', '15159287', '94', '', 'Refer: 17553230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1903, '2018-09-20', '2000', '15185580', '38', '', 'Refer: 17658250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1904, '2018-09-20', '2018', '10185139', '94', '', 'Refer: 17553292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1905, '2018-09-20', '2008', '15161531', '87', '', 'Refer: 17658201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1906, '2018-09-20', '2002', '15161072', '51', '', 'Refer: 17654272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1907, '2018-09-20', '2018', '15186327', '01', '', 'Refer: 17658267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1908, '2018-09-20', '2003', '15161782', '60', '', 'Refer: 17811261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1909, '2018-09-20', '20AG', 'DEN DE P', 'O', '', 'Refer: EXTRANJE', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1910, '2018-09-20', '2015', '15150163', '10', '', 'Refer: 17654244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1911, '2018-09-20', '2018', '15150353', '99', '', 'Refer: 17659252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1912, '2018-09-20', '2018', '15186344', '01', '', 'Refer: 17654208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1913, '2018-09-20', '2018', '15160891', '01', '', 'Refer: 17658217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1914, '2018-09-20', '2002', '15148489', '69', '', 'Refer: 17658205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1915, '2018-09-20', '2003', '15161896', '93', '', 'Refer: 17655216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1916, '2018-09-20', '2018', '15160504', '01', '', 'Refer: 17658276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1917, '2018-09-20', '2018', '15150014', '99', '', 'Refer: 17659257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1918, '2018-09-19', '2000', '15161772', '85', '', 'Refer: 18453234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1919, '2018-09-19', '2000', '15161772', '82', '', 'Refer: 18123281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1920, '2018-09-19', '2000', '15161772', '79', '', 'Refer: 17813254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1921, '2018-09-19', '2018', '14159972', '01', '', 'Refer: 17658257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1922, '2018-09-19', '2017', '15162091', '10', '', 'Refer: 17657285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1923, '2018-09-19', '2018', '14125165', '01', '', 'Refer: 17657274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1924, '2018-09-19', '2017', '15150009', '07', '', 'Refer: 17654230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1925, '2018-09-19', '2017', '15148521', '10', '', 'Refer: 17650256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1926, '2018-09-19', '2017', '15148521', '09', '', 'Refer: 17650259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1927, '2018-09-19', '2018', '15172656', '99', '', 'Refer: 17619255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1928, '2018-09-19', '2018', '15090772', '01', '', 'Refer: 17652262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1929, '2018-09-19', '2000', '14150081', '76', '', 'Refer: 17810295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1930, '2018-09-19', '2017', '15150149', '05', '', 'Refer: 17654273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1931, '2018-09-19', '2018', '15161356', '10', '', 'Refer: 20442263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1932, '2018-09-19', '2018', '13113241', '01', '', 'Refer: 17658257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1933, '2018-09-19', '2018', '15091239', '85', '', 'Refer: 17566265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1934, '2018-09-19', '2016', '15102452', '09', '', 'Refer: 17650261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1935, '2018-09-19', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1936, '2018-09-19', '2001', '15173605', '13', '', 'Refer: 17657258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1937, '2018-09-19', '2018', '15161510', '00', '', 'Refer: 17579279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1938, '2018-09-18', '2018', '15135939', '78', '', 'Refer: 17531239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1939, '2018-09-18', '2005', '15147874', '55', '', 'Refer: 17657258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1940, '2018-09-18', '2004', '15161285', '69', '', 'Refer: 17651278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1941, '2018-09-18', '2018', '11013121', '99', '', 'Refer: 17659253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1942, '2018-09-18', '2018', '19186405', '90', '', 'Refer: 17607233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1943, '2018-09-18', '2018', '15173461', '01', '', 'Refer: 17658287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1944, '2018-09-18', '2018', '15185903', '01', '', 'Refer: 17658280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1945, '2018-09-18', '2018', '15147689', '99', '', 'Refer: 17659227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1946, '2018-09-18', '2018', '15172629', '99', '', 'Refer: 17569218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1947, '2018-09-18', '2017', '15150101', '06', '', 'Refer: 17659211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1948, '2018-09-18', '2017', '15173561', '09', '', 'Refer: 17650285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1949, '2018-09-18', '2017', '15172919', '00', '', 'Refer: 17533226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1950, '2018-09-18', '2005', '13112987', '54', '', 'Refer: 17659241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1951, '2018-09-18', '2018', '15173483', '05', '', 'Refer: 18907272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1952, '2018-09-18', '2001', '23102135', '79', '', 'Refer: 17659229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1953, '2018-09-18', '2018', '13113001', '10', '', 'Refer: 20447248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1954, '2018-09-18', '2000', '15185546', '76', '', 'Refer: 17652228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1955, '2018-09-18', '2018', '15159279', '99', '', 'Refer: 17659207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1956, '2018-09-18', '2018', '17185143', '94', '', 'Refer: 17553233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1957, '2018-09-18', '2018', '15174287', '01', '', 'Refer: 17658267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1959, '2018-09-17', '2001', '15136484', '96', '', 'Refer: 17524251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1960, '2018-09-17', '2018', '15174121', '01', '', 'Refer: 17524275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1961, '2018-09-17', '2000', '15159368', '80', '', 'Refer: 17527280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1962, '2018-09-17', '2008', '15148562', '08', '', 'Refer: 17523274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1964, '2018-09-17', '2018', '15172571', '01', '', 'Refer: 17521234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1965, '2018-09-17', '2018', '15161442', '01', '', 'Refer: 17521244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1966, '2018-09-17', '2018', '15159260', '01', '', 'Refer: 17522259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1967, '2018-09-17', '2018', '15185344', '01', '', 'Refer: 17526242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1968, '2018-09-17', '2018', '15159157', '01', '', 'Refer: 17528287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1969, '2018-09-17', '2000', '15160503', '73', '', 'Refer: 17523294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1970, '2018-09-17', '2008', '15147284', '02', '', 'Refer: 17523271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1971, '2018-09-17', '2018', '15161663', '01', '', 'Refer: 17529225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1972, '2018-09-17', '2006', '14148115', '30', '', 'Refer: 17529245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1973, '2018-09-17', '2001', '14125295', '84', '', 'Refer: 17522214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1974, '2018-09-17', '2018', '15161561', '01', '', 'Refer: 17520263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1975, '2018-09-17', '2018', '15161145', '01', '', 'Refer: 17521226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1976, '2018-09-17', '2000', '15161626', '37', '', 'Refer: 17521250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1977, '2018-09-17', '2018', '15185857', '01', '', 'Refer: 17524250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1978, '2018-09-17', '2000', '15174034', '01', '', 'Refer: 17523213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1979, '2018-09-17', '2018', '15172993', '01', '', 'Refer: 17527234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1980, '2018-09-17', '2018', '15161515', '01', '', 'Refer: 17521255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1981, '2018-09-17', '2001', '15161425', '53', '', 'Refer: 17522219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1982, '2018-09-17', '2018', '15185186', '01', '', 'Refer: 17524256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1983, '2018-09-17', '2000', '15186272', '73', '', 'Refer: 17524205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1984, '2018-09-17', '2002', '15161469', '35', '', 'Refer: 17520203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1985, '2018-09-17', '2018', '15150257', '01', '', 'Refer: 17522249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1986, '2018-09-17', '2018', '13124187', '01', '', 'Refer: 17522252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1987, '2018-09-17', '2001', '15159555', '48', '', 'Refer: 17527226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1988, '2018-09-17', '2018', '14124520', '01', '', 'Refer: 17528256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1989, '2018-09-17', '2018', '15159911', '01', '', 'Refer: 17520201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1990, '2018-09-17', '2018', '15172786', '01', '', 'Refer: 17524278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1992, '2018-09-17', '2018', '15161501', '01', '', 'Refer: 17522211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1993, '2018-09-17', '2002', '15161100', '42', '', 'Refer: 17523283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1994, '2018-09-17', '2018', '15162048', '01', '', 'Refer: 17522274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1995, '2018-09-17', '2018', '15161279', '01', '', 'Refer: 17521229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1996, '2018-09-17', '2018', '15173229', '01', '', 'Refer: 17521225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:52', '2018-12-06 02:49:52', NULL),
(1997, '2018-09-17', '2000', '15162126', '01', '', 'Refer: 17521249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(1998, '2018-09-17', '2018', '14150065', '01', '', 'Refer: 17657231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(1999, '2018-09-17', '2003', '15150175', '15', '', 'Refer: 17527252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2000, '2018-09-17', '2001', '13136384', '81', '', 'Refer: 17525236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2001, '2018-09-17', '2018', '15161289', '01', '', 'Refer: 17522255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2002, '2018-09-17', '2018', '15148652', '01', '', 'Refer: 17520268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2003, '2018-09-17', '2000', '15186279', '01', '', 'Refer: 17524234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2004, '2018-09-17', '2001', '52024540', '09', '', 'Refer: 17524209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2006, '2018-09-17', '2018', '15161846', '01', '', 'Refer: 17520246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2007, '2018-09-17', '2018', '15174025', '01', '', 'Refer: 17657217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2008, '2018-09-17', '2010', '15150083', '81', '', 'Refer: 17527259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2009, '2018-09-17', '2005', '15159780', '83', '', 'Refer: 17527226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2010, '2018-09-17', '2002', '31024538', '57', '', 'Refer: 17522289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2011, '2018-09-17', '2000', '15161754', '73', '', 'Refer: 17521203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2012, '2018-09-17', '2018', '15160497', '01', '', 'Refer: 17524287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2013, '2018-09-17', '2001', '34148359', '51', '', 'Refer: 17523283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2014, '2018-09-17', '2018', '15147673', '01', '', 'Refer: 17527280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2015, '2018-09-17', '2002', '54147183', '62', '', 'Refer: 17527241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2016, '2018-09-17', '2018', '15124828', '01', '', 'Refer: 17520207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2017, '2018-09-17', '2018', '15159441', '01', '', 'Refer: 17527246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2018, '2018-09-17', '2018', '15159709', '01', '', 'Refer: 17520242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2019, '2018-09-17', '2017', '15160850', '10', '', 'Refer: 17652255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2020, '2018-09-17', '2018', '15173239', '01', '', 'Refer: 17524277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2021, '2018-09-17', '2002', '15159969', '47', '', 'Refer: 17522292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2022, '2018-09-17', '2000', '15173539', '01', '', 'Refer: 17523237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2023, '2018-09-17', '2000', '15173241', '01', '', 'Refer: 17523208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2025, '2018-09-17', '2018', '15159372', '01', '', 'Refer: 17528292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2026, '2018-09-17', '2000', '15185204', '37', '', 'Refer: 17522269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2027, '2018-09-17', '2018', '14113810', '01', '', 'Refer: 17528252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2028, '2018-09-17', '2010', '15147956', '39', '', 'Refer: 17526231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2029, '2018-09-17', '2001', '15173618', '06', '', 'Refer: 17527256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2030, '2018-09-17', '2001', '11034848', '81', '', 'Refer: 17528277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2031, '2018-09-17', '2018', '13113958', '01', '', 'Refer: 17527286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2033, '2018-09-17', '2002', '13101751', '83', '', 'Refer: 17523281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2034, '2018-09-17', '2018', '11991926', '01', '', 'Refer: 17525213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2035, '2018-09-17', '2018', '15161865', '01', '', 'Refer: 17521274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2036, '2018-09-17', '2018', '15147962', '01', '', 'Refer: 17520216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2037, '2018-09-17', '2018', '15173224', '01', '', 'Refer: 17524209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2038, '2018-09-17', '2018', '15148673', '01', '', 'Refer: 17520208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2039, '2018-09-17', '2001', '15174140', '17', '', 'Refer: 17523216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2040, '2018-09-17', '20FE', 'POSITO E', 'CT', '', 'Refer: IVO PRAC', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2042, '2018-09-17', '2018', '15184789', '01', '', 'Refer: 17524275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2043, '2018-09-17', '2003', '14136715', '20', '', 'Refer: 17522218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2044, '2018-09-17', '2018', '15185025', '01', '', 'Refer: 17527286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2045, '2018-09-17', '2002', '15159615', '11', '', 'Refer: 17527262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2046, '2018-09-17', '2018', '15159193', '01', '', 'Refer: 17528295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2048, '2018-09-17', '2005', '15159526', '14', '', 'Refer: 17522203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2049, '2018-09-17', '2018', '15172927', '01', '', 'Refer: 17524245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2050, '2018-09-17', '2018', '15159982', '01', '', 'Refer: 17522232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2051, '2018-09-17', '2002', '15173400', '34', '', 'Refer: 17528275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2052, '2018-09-17', '2001', '15150004', '48', '', 'Refer: 17526269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2053, '2018-09-17', '2018', '15162168', '01', '', 'Refer: 17521207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2054, '2018-09-17', '2018', '15174073', '01', '', 'Refer: 17524248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2055, '2018-09-17', '2004', '15159222', '12', '', 'Refer: 17526212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2056, '2018-09-17', '2018', '15185322', '01', '', 'Refer: 17524265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2057, '2018-09-17', '2018', '15172952', '01', '', 'Refer: 17525242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2058, '2018-09-17', '2018', '31035213', '01', '', 'Refer: 17521257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2059, '2018-09-17', '2018', '15172955', '01', '', 'Refer: 17524262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2060, '2018-09-17', '2018', '15185613', '01', '', 'Refer: 17524217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2061, '2018-09-17', '2018', '15184847', '01', '', 'Refer: 17522289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2062, '2018-09-17', '2018', '15159957', '01', '', 'Refer: 17525287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2063, '2018-09-17', '2018', '15159887', '01', '', 'Refer: 17528251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2064, '2018-09-17', '2018', '15185834', '01', '', 'Refer: 17524288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2065, '2018-09-17', '2018', '15173982', '01', '', 'Refer: 17524287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2066, '2018-09-17', '2018', '15184581', '01', '', 'Refer: 17526276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2067, '2018-09-17', '2018', '15159201', '01', '', 'Refer: 17528270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2069, '2018-09-17', '2018', '15185888', '01', '', 'Refer: 17527242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2070, '2018-09-17', '2018', '24161329', '10', '', 'Refer: 20444287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2071, '2018-09-17', '2018', '15186273', '01', '', 'Refer: 17524246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2072, '2018-09-17', '2018', '15186015', '01', '', 'Refer: 17524253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2073, '2018-09-17', '2002', '15161704', '11', '', 'Refer: 17521242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2074, '2018-09-17', '2018', '15186231', '01', '', 'Refer: 17522243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2075, '2018-09-17', '2018', '15173409', '01', '', 'Refer: 17524272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2076, '2018-09-17', '2018', '15173749', '01', '', 'Refer: 17524278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2077, '2018-09-17', '2018', '15162099', '01', '', 'Refer: 17520227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2078, '2018-09-17', '2000', '15185536', '37', '', 'Refer: 17524213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2079, '2018-09-17', '2001', '15172946', '51', '', 'Refer: 17524286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2080, '2018-09-17', '2004', '15150205', '54', '', 'Refer: 17524213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2081, '2018-09-17', '2018', '15159261', '01', '', 'Refer: 17522270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2082, '2018-09-17', '2002', '14148569', '92', '', 'Refer: 17655201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2083, '2018-09-17', '2018', '15186103', '01', '', 'Refer: 17526261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2084, '2018-09-17', '2018', '15173992', '01', '', 'Refer: 17525216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2085, '2018-09-17', '2018', '54150017', '01', '', 'Refer: 17521205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2086, '2018-09-17', '2018', '15173441', '01', '', 'Refer: 17522210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2087, '2018-09-17', '2018', '15172770', '01', '', 'Refer: 17524296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2088, '2018-09-17', '2000', '15185594', '37', '', 'Refer: 17524269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2089, '2018-09-17', '2018', '15185323', '01', '', 'Refer: 17527218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2090, '2018-09-17', '2018', '10091461', '01', '', 'Refer: 17528246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2091, '2018-09-17', '2018', '15159669', '01', '', 'Refer: 17520206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2092, '2018-09-17', '2000', '15161911', '01', '', 'Refer: 17521201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2093, '2018-09-17', '2001', '15173517', '60', '', 'Refer: 17525226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2094, '2018-09-17', '2018', '15185572', '01', '', 'Refer: 17526293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2095, '2018-09-17', '2001', '15173978', '13', '', 'Refer: 17529292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2097, '2018-09-17', '2000', '15161371', '77', '', 'Refer: 17523206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2098, '2018-09-17', '2018', '13089875', '01', '', 'Refer: 17520241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2100, '2018-09-17', '2018', '15148352', '01', '', 'Refer: 17520217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2101, '2018-09-17', '2018', '15185718', '01', '', 'Refer: 17524289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2102, '2018-09-17', '2018', '15147363', '01', '', 'Refer: 17520222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2103, '2018-09-17', '2018', '15173925', '01', '', 'Refer: 17524242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2104, '2018-09-17', '2018', '15185471', '01', '', 'Refer: 17524239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2105, '2018-09-17', '2007', '15147926', '60', '', 'Refer: 17527249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2106, '2018-09-17', '2003', '15159636', '01', '', 'Refer: 17524262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2107, '2018-09-17', '2004', '15159527', '00', '', 'Refer: 17527288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2109, '2018-09-17', '2000', '15186123', '01', '', 'Refer: 17524280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2110, '2018-09-17', '2018', '15161506', '01', '', 'Refer: 17520240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2111, '2018-09-17', '2018', '15185653', '10', '', 'Refer: 20449203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2113, '2018-09-17', '2018', '15161608', '01', '', 'Refer: 17521292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2114, '2018-09-17', '2018', '15159269', '01', '', 'Refer: 17522261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2115, '2018-09-17', '2001', '15173773', '12', '', 'Refer: 17523209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2116, '2018-09-17', '2018', '15185610', '01', '', 'Refer: 17526210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2117, '2018-09-17', '2018', '15159511', '01', '', 'Refer: 17528237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2118, '2018-09-17', '2003', '15159872', '95', '', 'Refer: 17521276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2119, '2018-09-17', '2002', '15161576', '74', '', 'Refer: 17521268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2120, '2018-09-17', '2018', '15161503', '01', '', 'Refer: 17521220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2121, '2018-09-17', '2018', '15159874', '04', '', 'Refer: 18458202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2122, '2018-09-17', '2018', '15159874', '03', '', 'Refer: 18128275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2123, '2018-09-17', '2018', '15185458', '01', '', 'Refer: 17526219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2124, '2018-09-17', '2018', '15159874', '02', '', 'Refer: 17818258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2125, '2018-09-17', '2018', '15159874', '01', '', 'Refer: 17528205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2126, '2018-09-17', '2018', '15173259', '01', '', 'Refer: 17526232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2127, '2018-09-17', '2018', '15148208', '01', '', 'Refer: 17520201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2128, '2018-09-17', '2018', '15160951', '01', '', 'Refer: 17520202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2129, '2018-09-17', '2002', '15159720', '47', '', 'Refer: 17522204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2130, '2018-09-17', '2018', '15185251', '01', '', 'Refer: 17524276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2131, '2018-09-17', '2018', '15184989', '01', '', 'Refer: 17520257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2132, '2018-09-17', '2018', '14102691', '01', '', 'Refer: 17528291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2133, '2018-09-17', '2018', '15173734', '01', '', 'Refer: 17524210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2134, '2018-09-17', '2002', '15161842', '44', '', 'Refer: 17521282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2135, '2018-09-17', '2018', '15185246', '01', '', 'Refer: 17524221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2136, '2018-09-17', '2002', '15173395', '17', '', 'Refer: 17523273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2137, '2018-09-17', '2018', '15148524', '01', '', 'Refer: 17520234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2138, '2018-09-17', '2018', '15173204', '01', '', 'Refer: 17524280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2139, '2018-09-17', '2018', '15159657', '01', '', 'Refer: 17522294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2140, '2018-09-17', '2004', '15161612', '06', '', 'Refer: 17522218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2142, '2018-09-17', '2018', '15172943', '01', '', 'Refer: 17527266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2143, '2018-09-17', '2018', '15185680', '01', '', 'Refer: 17524275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2146, '2018-09-17', '2000', '15160932', '94', '', 'Refer: 17521217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2147, '2018-09-17', '2018', '15173004', '01', '', 'Refer: 17527285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2148, '2018-09-17', '2000', '54148002', '76', '', 'Refer: 17527256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2149, '2018-09-17', '2018', '15185749', '01', '', 'Refer: 17524242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2150, '2018-09-17', '2018', '15136924', '01', '', 'Refer: 17520241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2151, '2018-09-17', '2000', '15161772', '76', '', 'Refer: 17523272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2153, '2018-09-17', '2018', '15186089', '01', '', 'Refer: 17527233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2154, '2018-09-17', '2018', '15184791', '01', '', 'Refer: 17520245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2155, '2018-09-17', '2009', '15148015', '52', '', 'Refer: 17523280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2156, '2018-09-17', '2007', '15148026', '34', '', 'Refer: 17527213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2157, '2018-09-17', '2018', '15173415', '01', '', 'Refer: 17524241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2159, '2018-09-17', '2004', '15160845', '24', '', 'Refer: 17522216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2160, '2018-09-17', '2001', '15147947', '34', '', 'Refer: 17523218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2161, '2018-09-17', '2002', '15011505', '35', '', 'Refer: 17521276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2162, '2018-09-17', '2018', '15159852', '01', '', 'Refer: 17528254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2163, '2018-09-17', '2001', '12045725', '09', '', 'Refer: 17522243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2164, '2018-09-17', '2002', '15159821', '92', '', 'Refer: 17527220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2165, '2018-09-17', '2018', '15161679', '01', '', 'Refer: 17521297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2166, '2018-09-17', '2018', '15150227', '01', '', 'Refer: 17525249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2167, '2018-09-17', '2018', '15184971', '01', '', 'Refer: 17522279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2168, '2018-09-17', '2018', '15161370', '01', '', 'Refer: 17520231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2169, '2018-09-17', '2018', '15185772', '01', '', 'Refer: 17524204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2170, '2018-09-17', '2018', '15160632', '01', '', 'Refer: 17521246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2171, '2018-09-17', '2018', '15185383', '01', '', 'Refer: 17524257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2172, '2018-09-17', '2017', '15159525', '00', '', 'Refer: 17533214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2173, '2018-09-17', '2018', '14148531', '01', '', 'Refer: 17525266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2174, '2018-09-17', '2018', '15173464', '01', '', 'Refer: 17524295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2175, '2018-09-17', '2001', '15173949', '84', '', 'Refer: 17524234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2176, '2018-09-17', '2001', '15160858', '48', '', 'Refer: 17657232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2177, '2018-09-17', '2018', '15172604', '01', '', 'Refer: 17524232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2178, '2018-09-17', '2018', '15173323', '01', '', 'Refer: 17524215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2179, '2018-09-17', '2018', '15185582', '01', '', 'Refer: 17522254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2180, '2018-09-17', '2018', '15173230', '01', '', 'Refer: 17524275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2181, '2018-09-17', '2018', '54148384', '99', '', 'Refer: 17529222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2182, '2018-09-17', '2018', '13124528', '01', '', 'Refer: 17526208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2183, '2018-09-17', '2003', '15173203', '98', '', 'Refer: 17528253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2184, '2018-09-17', '2000', '15185514', '37', '', 'Refer: 17524262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2185, '2018-09-17', '2001', '15161468', '72', '', 'Refer: 17528209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2186, '2018-09-17', '2018', '15173206', '99', '', 'Refer: 17569207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2187, '2018-09-17', '2003', '15173206', '28', '', 'Refer: 17523296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2188, '2018-09-17', '2018', '15185364', '01', '', 'Refer: 17524242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2189, '2018-09-17', '2018', '15186297', '01', '', 'Refer: 17524219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2190, '2018-09-17', '2018', '13113187', '01', '', 'Refer: 17526262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2191, '2018-09-17', '2018', '15174274', '01', '', 'Refer: 17527235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2192, '2018-09-17', '2000', '15184787', '37', '', 'Refer: 17520252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2193, '2018-09-17', '2018', '15159818', '01', '', 'Refer: 17528268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2194, '2018-09-17', '2003', '15161445', '91', '', 'Refer: 17522228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2195, '2018-09-17', '2018', '15160505', '01', '', 'Refer: 17522236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2196, '2018-09-17', '2018', '15185822', '01', '', 'Refer: 17524253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2197, '2018-09-17', '2000', '15186113', '01', '', 'Refer: 17524267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2198, '2018-09-17', '2018', '15161800', '01', '', 'Refer: 17521238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2199, '2018-09-17', '2001', '15172824', '30', '', 'Refer: 17529239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2200, '2018-09-17', '2018', '15185828', '01', '', 'Refer: 17524222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2201, '2018-09-17', '2018', '15184879', '01', '', 'Refer: 17522253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2202, '2018-09-17', '2004', '15159178', '56', '', 'Refer: 17522297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2203, '2018-09-17', '2018', '15159965', '01', '', 'Refer: 17528220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2204, '2018-09-17', '2018', '15173759', '01', '', 'Refer: 17527233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2205, '2018-09-29', '2018', '16174207', '00', '', 'Refer: 17740255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2206, '2018-09-29', '2018', '15113839', '01', '', 'Refer: 17973292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2207, '2018-09-28', '2018', '15136211', '01', '', 'Refer: 17656224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2208, '2018-09-28', '2017', '16173541', '02', '', 'Refer: 17655246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2209, '2018-09-28', '2017', '16173541', '04', '', 'Refer: 17655272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2210, '2018-09-28', '2017', '16173541', '03', '', 'Refer: 17655259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2211, '2018-09-28', '2018', '16186245', '01', '', 'Refer: 17650260', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2212, '2018-09-28', '2018', '16186380', '01', '', 'Refer: 17652203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2213, '2018-09-28', '2018', '15124852', '01', '', 'Refer: 17651263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2214, '2018-09-28', '2018', '16185301', '01', '', 'Refer: 17651272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2215, '2018-09-28', '2018', '15136203', '01', '', 'Refer: 17651265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2216, '2018-09-28', '2000', '16186031', '02', '', 'Refer: 17651214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2217, '2018-09-28', '20E', 'POSITO D', 'TE', '', 'Refer: RCERO/RE', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2218, '2018-09-27', '2018', '15136710', '01', '', 'Refer: 17656201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2219, '2018-09-27', '2018', '16186192', '01', '', 'Refer: 17651288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2220, '2018-09-27', '2018', '16185306', '01', '', 'Refer: 17651230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2221, '2018-09-27', '2018', '15078633', '10', '', 'Refer: 20442206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2222, '2018-09-27', '2018', '16160565', '86', '', 'Refer: 17706293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2223, '2018-09-27', '2018', '54079157', '10', '', 'Refer: 20444291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:53', '2018-12-06 02:49:53', NULL),
(2224, '2018-09-27', '2018', '15148013', '01', '', 'Refer: 17656273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2225, '2018-09-27', '2018', '12990395', '01', '', 'Refer: 17656268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2226, '2018-09-26', '2017', '14090893', '07', '', 'Refer: 17653278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2227, '2018-09-26', '2018', '15113185', '01', '', 'Refer: 17651271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL);
INSERT INTO `edocta` (`id`, `edoFechaOper`, `edoAnioPago`, `edoClaveAlu`, `edoMesPago`, `edoDigPago`, `edoDescripcion`, `edoImpAbono`, `edoImpCargo`, `edoEstado`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2228, '2018-09-25', '2018', '15136943', '01', '', 'Refer: 17659249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2229, '2018-09-25', '2018', '15136772', '01', '', 'Refer: 17651236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2230, '2018-09-24', '2018', '16148770', '99', '', 'Refer: 17720209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2231, '2018-09-24', '2018', '16186379', '01', '', 'Refer: 17651276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2232, '2018-09-24', '2018', '16186324', '01', '', 'Refer: 17651253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2233, '2018-09-21', '2018', '17184856', '94', '', 'Refer: 17623250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2234, '2018-09-20', '2018', '16185292', '94', '', 'Refer: 17553291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2235, '2018-09-20', '2018', '15125567', '01', '', 'Refer: 17650286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2236, '2018-09-19', '2018', '16162159', '01', '', 'Refer: 17651288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2237, '2018-09-19', '2017', '16173876', '08', '', 'Refer: 17653249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2238, '2018-09-19', '2017', '16173876', '07', '', 'Refer: 17653236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2239, '2018-09-19', '2018', '15102592', '86', '', 'Refer: 17595288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2240, '2018-09-18', '2017', '16160562', '05', '', 'Refer: 17650274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2241, '2018-09-18', '2017', '16160562', '86', '', 'Refer: 17596259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2242, '2018-09-18', '2017', '16160562', '04', '', 'Refer: 17650261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2243, '2018-09-18', '20E', 'POSITO D', 'TE', '', 'Refer: RCERO/RE', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2244, '2018-09-17', '2018', '16173651', '01', '', 'Refer: 17521257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2245, '2018-09-17', '2018', '15125387', '01', '', 'Refer: 17523247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2246, '2018-09-17', '2018', '16174090', '01', '', 'Refer: 17651285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2247, '2018-09-17', '2018', '16174090', '00', '', 'Refer: 17590211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2248, '2018-09-17', '2018', '15113413', '01', '', 'Refer: 17521236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2249, '2018-09-17', '2018', '16173563', '01', '', 'Refer: 17521275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2250, '2018-09-17', '2018', '15125237', '01', '', 'Refer: 17521236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2251, '2018-09-17', '2018', '16173575', '01', '', 'Refer: 17521213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2252, '2018-09-17', '2018', '16184623', '00', '', 'Refer: 17657223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2253, '2018-09-17', '2018', '16173266', '01', '', 'Refer: 17529264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2254, '2018-09-17', '2018', '15124484', '01', '', 'Refer: 17523212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2255, '2018-09-17', '2018', '14045796', '01', '', 'Refer: 17521216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2256, '2018-09-17', '2018', '15113481', '01', '', 'Refer: 17521208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2257, '2018-09-17', '2002', '15136200', '20', '', 'Refer: 17529247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2258, '2018-09-17', '2018', '16173551', '01', '', 'Refer: 17521240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2260, '2018-09-17', '2018', '15173659', '01', '', 'Refer: 17521235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2261, '2018-09-17', '2018', '15090582', '01', '', 'Refer: 17526223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2262, '2018-09-17', '2018', '16174172', '01', '', 'Refer: 17529235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2263, '2018-09-17', '2018', '16186222', '01', '', 'Refer: 17526209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2264, '2018-09-17', '2018', '15136581', '01', '', 'Refer: 17523257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2265, '2018-09-17', '2018', '16186224', '01', '', 'Refer: 17526231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2266, '2018-09-17', '2018', '15186082', '01', '', 'Refer: 17521272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2267, '2018-09-17', '2018', '16173008', '01', '', 'Refer: 17521264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2268, '2018-09-17', '2018', '15089898', '01', '', 'Refer: 17521242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2269, '2018-09-17', '2018', '16186261', '01', '', 'Refer: 17521282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2270, '2018-09-17', '2018', '15125420', '01', '', 'Refer: 17520264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2271, '2018-09-17', '2018', '16174237', '01', '', 'Refer: 17521248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2273, '2018-09-17', '2018', '16186263', '01', '', 'Refer: 17526272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2275, '2018-09-17', '2018', '16185290', '01', '', 'Refer: 17521291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2276, '2018-09-17', '2018', '16174295', '01', '', 'Refer: 17521207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2277, '2018-09-17', '2018', '15124591', '01', '', 'Refer: 17521280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2278, '2018-09-17', '2018', '12990131', '01', '', 'Refer: 17521268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2279, '2018-09-17', '2018', '16186295', '01', '', 'Refer: 17521268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2280, '2018-09-17', '2018', '15135860', '01', '', 'Refer: 17526291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2281, '2018-09-17', '2018', '16173095', '01', '', 'Refer: 17521251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2282, '2018-09-17', '2018', '16186276', '01', '', 'Refer: 17521253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2283, '2018-09-17', '2018', '10161210', '01', '', 'Refer: 17521278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2284, '2018-09-17', '2018', '10173588', '01', '', 'Refer: 17521278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2285, '2018-09-17', '2018', '16186221', '01', '', 'Refer: 17526295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2286, '2018-09-17', '2018', '16173554', '01', '', 'Refer: 17521273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2287, '2018-09-17', '2018', '16186247', '01', '', 'Refer: 17521225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2288, '2018-09-17', '2018', '15147237', '01', '', 'Refer: 17521223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2289, '2018-09-17', '2018', '15135947', '01', '', 'Refer: 17523223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2290, '2018-09-17', '2018', '15124479', '01', '', 'Refer: 17523254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2291, '2018-09-17', '2018', '15135861', '01', '', 'Refer: 17521237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2292, '2018-09-17', '2018', '16186314', '01', '', 'Refer: 17526235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2293, '2018-09-17', '2018', '16186260', '01', '', 'Refer: 17521271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2294, '2018-09-17', '2018', '14101720', '01', '', 'Refer: 17521290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2295, '2018-09-17', '2018', '16173087', '01', '', 'Refer: 17521260', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2296, '2018-09-17', '2018', '15124681', '01', '', 'Refer: 17523213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2297, '2018-09-17', '2018', '12990373', '01', '', 'Refer: 17521279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2298, '2018-09-16', '2018', '16184477', '01', '', 'Refer: 17523286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2299, '2018-09-16', '2018', '15147477', '01', '', 'Refer: 17526277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2300, '2018-09-16', '2018', '16173039', '09', '', 'Refer: 19981254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2301, '2018-09-16', '2018', '16173039', '08', '', 'Refer: 19671264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2302, '2018-09-16', '2018', '16173039', '07', '', 'Refer: 19361274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2303, '2018-09-16', '2018', '16173039', '06', '', 'Refer: 19051284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2304, '2018-09-16', '2018', '16173039', '05', '', 'Refer: 18741267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2305, '2018-09-16', '2018', '16173039', '04', '', 'Refer: 18451214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2306, '2018-09-16', '2018', '16173039', '03', '', 'Refer: 18121287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2307, '2018-09-16', '2018', '16173039', '02', '', 'Refer: 17811270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2308, '2018-09-16', '2018', '16173039', '01', '', 'Refer: 17521217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2309, '2018-09-16', '2018', '16186270', '01', '', 'Refer: 17526252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2310, '2018-09-16', '2018', '16173258', '09', '', 'Refer: 19981206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2311, '2018-09-16', '2018', '16173258', '08', '', 'Refer: 19671216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2312, '2018-09-16', '2018', '16173258', '07', '', 'Refer: 19361226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2313, '2018-09-16', '2018', '16173258', '06', '', 'Refer: 19051236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2314, '2018-09-16', '2018', '16173258', '05', '', 'Refer: 18741219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2315, '2018-09-16', '2018', '16173258', '04', '', 'Refer: 18451263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2316, '2018-09-16', '2018', '16173258', '03', '', 'Refer: 18121239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2317, '2018-09-16', '2018', '16173258', '02', '', 'Refer: 17811222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2318, '2018-09-16', '2018', '16173258', '01', '', 'Refer: 17521266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2319, '2018-09-15', '2018', '16173704', '01', '', 'Refer: 17521242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2320, '2018-09-15', '2018', '15125145', '01', '', 'Refer: 17521210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2321, '2018-09-15', '2018', '15089520', '01', '', 'Refer: 17521206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2322, '2018-09-15', '2005', '15113767', '26', '', 'Refer: 17525273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2323, '2018-09-15', '2018', '14124381', '01', '', 'Refer: 17521220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2324, '2018-09-15', '2018', '15136464', '01', '', 'Refer: 17526286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2325, '2018-09-15', '2004', '12002184', '20', '', 'Refer: 17525266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2326, '2018-09-15', '2018', '16172460', '01', '', 'Refer: 17520290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2327, '2018-09-15', '2018', '16173565', '01', '', 'Refer: 17521297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2328, '2018-09-15', '2018', '16185456', '01', '', 'Refer: 17521242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2329, '2018-09-15', '2018', '15056935', '01', '', 'Refer: 17523242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2330, '2018-09-15', '2018', '06173465', '01', '', 'Refer: 17521263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2331, '2018-09-15', '2018', '16173268', '01', '', 'Refer: 17529286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2332, '2018-09-15', '2018', '16172809', '01', '', 'Refer: 17529205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2333, '2018-09-15', '2018', '16173274', '01', '', 'Refer: 17521248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2334, '2018-09-15', '2018', '16185920', '01', '', 'Refer: 17521222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2335, '2018-09-15', '2018', '16173648', '01', '', 'Refer: 17521224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2336, '2018-09-14', '2002', '15136450', '83', '', 'Refer: 17522202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2337, '2018-09-14', '2003', '15136731', '11', '', 'Refer: 17524235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2338, '2018-09-14', '2018', '16173566', '01', '', 'Refer: 17525263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2339, '2018-09-14', '2018', '16173585', '01', '', 'Refer: 17521226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2340, '2018-09-14', '2018', '16185729', '01', '', 'Refer: 17521287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2341, '2018-09-14', '2018', '16185287', '01', '', 'Refer: 17526226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2342, '2018-09-14', '2018', '10162227', '01', '', 'Refer: 17529297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2343, '2018-09-14', '2018', '16186206', '01', '', 'Refer: 17521259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2344, '2018-09-14', '2018', '13990715', '01', '', 'Refer: 17521207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2345, '2018-09-14', '2018', '15185274', '01', '', 'Refer: 17521296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2346, '2018-09-14', '2018', '16186020', '01', '', 'Refer: 17523211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2347, '2018-09-14', '2018', '16173560', '01', '', 'Refer: 17521242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2348, '2018-09-14', '2018', '16173559', '01', '', 'Refer: 17521231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2349, '2018-09-14', '2018', '17185295', '01', '', 'Refer: 17526230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2350, '2018-09-14', '2018', '15136705', '01', '', 'Refer: 17526270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2351, '2018-09-14', '2018', '16173576', '01', '', 'Refer: 17521224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2352, '2018-09-14', '2018', '15125387', '99', '', 'Refer: 17650244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2353, '2018-09-14', '2018', '15173795', '01', '', 'Refer: 17521260', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2354, '2018-09-14', '2018', '15148060', '10', '', 'Refer: 20448227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2355, '2018-09-14', '2018', '16136903', '01', '', 'Refer: 17521230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2356, '2018-09-14', '2018', '16185880', '01', '', 'Refer: 17523212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2357, '2018-09-14', '2018', '15102514', '01', '', 'Refer: 17523248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2358, '2018-09-14', '2018', '15147239', '01', '', 'Refer: 17526213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2359, '2018-09-14', '2018', '15148886', '01', '', 'Refer: 17521204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2360, '2018-09-14', '2018', '10161020', '01', '', 'Refer: 17525212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2361, '2018-09-14', '2018', '15148886', '99', '', 'Refer: 17650227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2362, '2018-09-14', '2018', '16173566', '99', '', 'Refer: 17550215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2363, '2018-09-14', '2018', '10161020', '99', '', 'Refer: 17550261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2364, '2018-09-14', '2018', '10160651', '01', '', 'Refer: 17529203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2365, '2018-09-14', '2018', '15056790', '01', '', 'Refer: 17521205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2366, '2018-09-13', '2018', '15125237', '99', '', 'Refer: 17650259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2367, '2018-09-13', '2018', '16185293', '01', '', 'Refer: 17521227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2368, '2018-09-13', '2018', '16173563', '99', '', 'Refer: 17650201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2369, '2018-09-13', '2018', '16186157', '01', '', 'Refer: 17521221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2370, '2018-09-13', '2018', '16184465', '01', '', 'Refer: 17529232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2371, '2018-09-13', '2018', '10160677', '01', '', 'Refer: 17521288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2372, '2018-09-13', '2018', '15148001', '10', '', 'Refer: 20444205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2373, '2018-09-13', '2018', '16173598', '01', '', 'Refer: 17529279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2374, '2018-09-13', '2018', '15136345', '02', '', 'Refer: 17811242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2375, '2018-09-13', '2018', '15113435', '01', '', 'Refer: 17526252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2376, '2018-09-13', '2018', '36173764', '01', '', 'Refer: 17521257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2377, '2018-09-13', '2018', '16173586', '01', '', 'Refer: 17521237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2378, '2018-09-13', '2018', '16186380', '90', '', 'Refer: 17498257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2379, '2018-09-13', '2018', '16186180', '01', '', 'Refer: 17523209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2380, '2018-09-13', '2018', '16173557', '01', '', 'Refer: 17521209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2381, '2018-09-13', '2018', '16174228', '01', '', 'Refer: 17529253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2382, '2018-09-13', '2018', '15124516', '01', '', 'Refer: 17521231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2383, '2018-09-13', '2018', '15136348', '01', '', 'Refer: 17526287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2384, '2018-09-12', '2018', '16186379', '99', '', 'Refer: 17570244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2385, '2018-09-12', '2018', '15125145', '99', '', 'Refer: 17650233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2386, '2018-09-12', '2018', '10114047', '01', '', 'Refer: 17526270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2387, '2018-09-12', '2018', '16173584', '01', '', 'Refer: 17529222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2388, '2018-09-12', '2002', '14002241', '11', '', 'Refer: 17524266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2389, '2018-09-12', '2018', '10160708', '01', '', 'Refer: 17525277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2390, '2018-09-12', '2018', '10160708', '99', '', 'Refer: 17550229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2391, '2018-09-12', '2018', '16186034', '04', '', 'Refer: 18456207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2392, '2018-09-12', '2018', '16186034', '03', '', 'Refer: 18126280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2393, '2018-09-12', '2018', '16186034', '02', '', 'Refer: 17816263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2394, '2018-09-12', '2018', '16186034', '01', '', 'Refer: 17526210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2395, '2018-09-12', '2018', '15135942', '01', '', 'Refer: 17523265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2396, '2018-09-12', '2018', '16186316', '01', '', 'Refer: 17521289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2397, '2018-09-12', '2018', '16174162', '01', '', 'Refer: 17521215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2398, '2018-09-11', '2018', '16185979', '01', '', 'Refer: 17526257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2399, '2018-09-11', '2018', '16057190', '01', '', 'Refer: 17521232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2400, '2018-09-11', '2018', '15136345', '01', '', 'Refer: 17521286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2401, '2018-09-11', '2018', '15102514', '99', '', 'Refer: 17650245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2402, '2018-09-11', '2018', '16185669', '01', '', 'Refer: 17521225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2403, '2018-09-11', '2018', '16186333', '99', '', 'Refer: 17470204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2404, '2018-09-11', '2018', '15185271', '01', '', 'Refer: 17521263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2405, '2018-09-11', '2018', '15102115', '01', '', 'Refer: 17521262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2406, '2018-09-11', '2018', '15124605', '01', '', 'Refer: 17529231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2407, '2018-09-11', '2018', '15056790', '99', '', 'Refer: 17480241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2408, '2018-09-10', '2018', '15113452', '01', '', 'Refer: 17521277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2409, '2018-09-10', '2018', '14067636', '01', '', 'Refer: 17521205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2410, '2018-09-10', '2018', '16186314', '99', '', 'Refer: 17600205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2411, '2018-09-10', '2018', '15078743', '01', '', 'Refer: 17521257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2412, '2018-09-10', '2018', '15057012', '01', '', 'Refer: 17526282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2413, '2018-09-10', '2018', '15124854', '01', '', 'Refer: 17521215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2414, '2018-09-10', '2018', '16174228', '99', '', 'Refer: 17650269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2415, '2018-09-10', '2018', '15113481', '99', '', 'Refer: 17490261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2416, '2018-09-10', '2018', '15185279', '01', '', 'Refer: 17521254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2417, '2018-09-10', '2018', '15136581', '99', '', 'Refer: 17490284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2418, '2018-09-09', '2017', '16185289', '90', '', 'Refer: 17497288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2419, '2018-09-08', '2018', '16173648', '99', '', 'Refer: 17650247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2420, '2018-09-07', '2018', '16173062', '01', '', 'Refer: 17651249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2421, '2018-09-07', '2018', '16172462', '01', '', 'Refer: 17527209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2422, '2018-09-07', '2018', '15136464', '99', '', 'Refer: 17480257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2423, '2018-09-06', '2018', '16162138', '99', '', 'Refer: 17650204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2425, '2018-09-06', '2018', '54125187', '01', '', 'Refer: 17521242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2426, '2018-09-05', '2018', '16173562', '01', '', 'Refer: 17529271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2427, '2018-09-04', '2018', '16173598', '99', '', 'Refer: 17390209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2428, '2018-09-04', '2018', '15173795', '99', '', 'Refer: 17420291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2429, '2018-09-04', '2018', '16184705', '99', '', 'Refer: 17650221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2430, '2018-09-04', '2018', '15113185', '99', '', 'Refer: 17650224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:54', '2018-12-06 02:49:54', NULL),
(2432, '2018-09-03', '2018', '15113839', '99', '', 'Refer: 17650225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2433, '2018-09-03', '2018', '16173551', '99', '', 'Refer: 17380257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2434, '2018-09-03', '2018', '14067636', '99', '', 'Refer: 17380222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2435, '2018-09-03', '2018', '16186324', '99', '', 'Refer: 17440248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2436, '2018-09-02', '2018', '15135947', '99', '', 'Refer: 17380214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2437, '2018-09-28', '2018', '11186117', '01', '', 'Refer: 17656239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2440, '2018-09-27', '20ID', 'EI RECIB', 'OS', '', 'Refer: COTIABAN', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2441, '2018-09-27', '2018', '28184699', '02', '', 'Refer: 17814283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2442, '2018-09-24', '2018', '21184814', '01', '', 'Refer: 17656207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2443, '2018-09-24', '2018', '11185077', '02', '', 'Refer: 17811296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2444, '2018-09-24', '2018', '11185078', '02', '', 'Refer: 17811210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2446, '2018-09-19', '2018', '21174210', '10', '', 'Refer: 20442270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2447, '2018-09-19', '2018', '21184704', '01', '', 'Refer: 17656274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2448, '2018-09-18', '2018', '10186377', '01', '', 'Refer: 17651273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2449, '2018-09-17', '2018', '11172587', '01', '', 'Refer: 17521261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2450, '2018-09-17', '2018', '21185313', '01', '', 'Refer: 17526254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2451, '2018-09-17', '2018', '11173272', '01', '', 'Refer: 17526226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2452, '2018-09-17', '2018', '11160619', '01', '', 'Refer: 17520232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2453, '2018-09-17', '2018', '18186228', '01', '', 'Refer: 17524275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2454, '2018-09-17', '2018', '11161805', '10', '', 'Refer: 20446272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2455, '2018-09-17', '2018', '11173031', '01', '', 'Refer: 17521258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2456, '2018-09-17', '2018', '21184594', '01', '', 'Refer: 17521222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2457, '2018-09-17', '2018', '11172858', '01', '', 'Refer: 17521284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2458, '2018-09-17', '2018', '11160628', '01', '', 'Refer: 17520234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2459, '2018-09-17', '2018', '11172727', '01', '', 'Refer: 17526282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2460, '2018-09-17', '2018', '11174300', '01', '', 'Refer: 17523207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2461, '2018-09-17', '2018', '21174212', '01', '', 'Refer: 17521216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2462, '2018-09-17', '2018', '11161476', '01', '', 'Refer: 17521275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2463, '2018-09-17', '2018', '11173170', '01', '', 'Refer: 17521219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2464, '2018-09-17', '2018', '21185781', '01', '', 'Refer: 17521229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2465, '2018-09-17', '2018', '11160496', '34', '', 'Refer: 17527256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2466, '2018-09-17', '2018', '11160751', '01', '', 'Refer: 17521226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2467, '2018-09-17', '2018', '28185226', '01', '', 'Refer: 17524251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2469, '2018-09-17', '2018', '11160981', '01', '', 'Refer: 17528293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2470, '2018-09-17', '2018', '11184869', '01', '', 'Refer: 17521272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2471, '2018-09-17', '2018', '11184897', '01', '', 'Refer: 17521289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2472, '2018-09-17', '2018', '11173033', '01', '', 'Refer: 17521280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2473, '2018-09-17', '2018', '21174188', '01', '', 'Refer: 17526227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2474, '2018-09-17', '2018', '31186025', '01', '', 'Refer: 17521209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2475, '2018-09-17', '2018', '31185549', '01', '', 'Refer: 17521248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2476, '2018-09-17', '2018', '11173025', '09', '', 'Refer: 19981229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2477, '2018-09-17', '2018', '18185157', '01', '', 'Refer: 17524267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2478, '2018-09-17', '2018', '11173025', '08', '', 'Refer: 19671239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2479, '2018-09-17', '2018', '11173025', '07', '', 'Refer: 19361249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2480, '2018-09-17', '2018', '11173025', '06', '', 'Refer: 19051259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2481, '2018-09-17', '2018', '31185978', '01', '', 'Refer: 17521247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2482, '2018-09-17', '2018', '11173025', '05', '', 'Refer: 18741242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2483, '2018-09-17', '2018', '11173025', '04', '', 'Refer: 18451286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2484, '2018-09-17', '2018', '11173025', '03', '', 'Refer: 18121262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2485, '2018-09-17', '2018', '11173025', '02', '', 'Refer: 17811245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2486, '2018-09-17', '2018', '11173025', '01', '', 'Refer: 17521289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2487, '2018-09-17', '2018', '11174175', '01', '', 'Refer: 17521293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2488, '2018-09-16', '2018', '11184697', '01', '', 'Refer: 17521255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2489, '2018-09-16', '2018', '31185225', '01', '', 'Refer: 17521224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2490, '2018-09-15', '2018', '11173028', '09', '', 'Refer: 19987243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2491, '2018-09-15', '2018', '11173028', '08', '', 'Refer: 19677253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2492, '2018-09-15', '2018', '11173028', '07', '', 'Refer: 19367263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2493, '2018-09-15', '2018', '11173028', '06', '', 'Refer: 19057273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2494, '2018-09-15', '2018', '11173028', '05', '', 'Refer: 18747256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2495, '2018-09-15', '2018', '11173028', '04', '', 'Refer: 18457203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2496, '2018-09-15', '2018', '11173028', '03', '', 'Refer: 18127276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2497, '2018-09-15', '2018', '11173028', '02', '', 'Refer: 17817259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2498, '2018-09-15', '2018', '11173028', '01', '', 'Refer: 17527206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2499, '2018-09-15', '2018', '11186171', '01', '', 'Refer: 17521213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2500, '2018-09-15', '2018', '11160914', '01', '', 'Refer: 17520228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2501, '2018-09-15', '2018', '11185208', '01', '', 'Refer: 17521294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2502, '2018-09-15', '2018', '11184661', '01', '', 'Refer: 17521247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2503, '2018-09-14', '2018', '11172519', '01', '', 'Refer: 17521289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2504, '2018-09-14', '2018', '11186234', '01', '', 'Refer: 17521211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2505, '2018-09-14', '2018', '11185389', '01', '', 'Refer: 17521232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2507, '2018-09-14', '2018', '11161323', '01', '', 'Refer: 17520244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2508, '2018-09-14', '2018', '11161548', '10', '', 'Refer: 20446209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2509, '2018-09-14', '2018', '11173172', '10', '', 'Refer: 20446272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2510, '2018-09-14', '2018', '11174183', '01', '', 'Refer: 17521284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2511, '2018-09-14', '2018', '22184873', '01', '', 'Refer: 17521249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2512, '2018-09-14', '2018', '31184466', '01', '', 'Refer: 17521205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2513, '2018-09-14', '2018', '11162058', '01', '', 'Refer: 17528216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2514, '2018-09-14', '2018', '11160698', '10', '', 'Refer: 20446272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2517, '2018-09-14', '2018', '11184542', '01', '', 'Refer: 17521215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2518, '2018-09-14', '2018', '11186055', '01', '', 'Refer: 17521214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2519, '2018-09-14', '2018', '11173006', '01', '', 'Refer: 17521274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2520, '2018-09-14', '2018', '18186121', '01', '', 'Refer: 17523265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2521, '2018-09-14', '2018', '21173416', '01', '', 'Refer: 17521275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2522, '2018-09-14', '2018', '18185770', '01', '', 'Refer: 17524221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2523, '2018-09-14', '2018', '11184626', '01', '', 'Refer: 17521250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2524, '2018-09-14', '2018', '28185054', '01', '', 'Refer: 17521292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2525, '2018-09-14', '2018', '28185100', '01', '', 'Refer: 17524239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2526, '2018-09-14', '2018', '31186387', '01', '', 'Refer: 17521263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2527, '2018-09-14', '2018', '11184849', '01', '', 'Refer: 17521246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2528, '2018-09-14', '2018', '11173047', '01', '', 'Refer: 17520227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2529, '2018-09-14', '2018', '11172511', '01', '', 'Refer: 17529208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2532, '2018-09-13', '2018', '11161741', '01', '', 'Refer: 17521232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2533, '2018-09-13', '2018', '21184820', '01', '', 'Refer: 17521235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2536, '2018-09-13', '2018', '21184837', '01', '', 'Refer: 17521228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2537, '2018-09-13', '2018', '21185261', '01', '', 'Refer: 17521215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2538, '2018-09-13', '2018', '11186262', '01', '', 'Refer: 17521228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2540, '2018-09-12', '2018', '11184546', '01', '', 'Refer: 17520246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2541, '2018-09-12', '2018', '21186131', '01', '', 'Refer: 17521275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2542, '2018-09-12', '2018', '11186133', '01', '', 'Refer: 17521280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2543, '2018-09-12', '2018', '11184517', '01', '', 'Refer: 17520218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2544, '2018-09-12', '2018', '11160679', '01', '', 'Refer: 17520213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2545, '2018-09-12', '2018', '18184925', '01', '', 'Refer: 17524226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2546, '2018-09-12', '2018', '18184926', '01', '', 'Refer: 17524237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2548, '2018-09-12', '2018', '11185564', '01', '', 'Refer: 17521282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2549, '2018-09-12', '2018', '11160942', '09', '', 'Refer: 19981295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2550, '2018-09-12', '2018', '11160942', '08', '', 'Refer: 19671208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2551, '2018-09-12', '2018', '11160942', '07', '', 'Refer: 19361218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2552, '2018-09-12', '2018', '11160942', '06', '', 'Refer: 19051228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2553, '2018-09-12', '2018', '11160942', '05', '', 'Refer: 18741211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2554, '2018-09-12', '2018', '11160942', '04', '', 'Refer: 18451255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2555, '2018-09-12', '2018', '11160942', '03', '', 'Refer: 18121231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2556, '2018-09-12', '2018', '11160942', '02', '', 'Refer: 17811214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2557, '2018-09-12', '2018', '11160942', '01', '', 'Refer: 17521258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2558, '2018-09-11', '2018', '11185986', '01', '', 'Refer: 17520288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2559, '2018-09-11', '2018', '21173156', '01', '', 'Refer: 17521276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2560, '2018-09-11', '2018', '11185797', '01', '', 'Refer: 17521291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2561, '2018-09-11', '2018', '21186142', '01', '', 'Refer: 17521202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2562, '2018-09-11', '2018', '18186143', '01', '', 'Refer: 17524229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2563, '2018-09-10', '2018', '11173067', '01', '', 'Refer: 17521266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2564, '2018-09-10', '2018', '11173157', '01', '', 'Refer: 17521270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2565, '2018-09-10', '2018', '11185182', '01', '', 'Refer: 17521218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2566, '2018-09-10', '2018', '31186387', '99', '', 'Refer: 17603240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2567, '2018-09-10', '2018', '21184825', '01', '', 'Refer: 17521290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2568, '2018-09-10', '2018', '21174394', '01', '', 'Refer: 17523288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2569, '2018-09-09', '2018', '11172711', '01', '', 'Refer: 17528229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2570, '2018-09-08', '2018', '11161436', '01', '', 'Refer: 17520210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2571, '2018-09-08', '2018', '11184535', '01', '', 'Refer: 17524274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2572, '2018-09-08', '2018', '11160894', '01', '', 'Refer: 17528225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2573, '2018-09-08', '2018', '10186377', '99', '', 'Refer: 17573280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2574, '2018-09-08', '2018', '11186011', '02', '', 'Refer: 17811268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2575, '2018-09-08', '2018', '11186011', '01', '', 'Refer: 17521215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2577, '2018-09-07', '2018', '11185776', '01', '', 'Refer: 17521254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2578, '2018-09-06', '2018', '11184598', '01', '', 'Refer: 17521249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2579, '2018-09-06', '2018', '11173805', '01', '', 'Refer: 17521205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2581, '2018-09-06', '2018', '11160957', '34', '', 'Refer: 17467252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2582, '2018-09-06', '2018', '31184746', '01', '', 'Refer: 17523256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2583, '2018-09-06', '2018', '11185078', '01', '', 'Refer: 17521254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2584, '2018-09-06', '2018', '11185077', '01', '', 'Refer: 17521243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2585, '2018-09-05', '2018', '11160947', '10', '', 'Refer: 20448273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2587, '2018-09-05', '2018', '28185971', '01', '', 'Refer: 17524283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2588, '2018-09-05', '20ID', 'EI RECIB', 'OS', '', 'Refer: COTIABAN', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2589, '2018-09-04', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2592, '2018-09-29', '2018', '14185412', '01', '', 'Refer: 17866213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2593, '2018-09-29', '2018', '13159848', '06', '', 'Refer: 19188224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2594, '2018-09-29', '20ID', 'EI RECIB', 'OS', '', 'Refer: ANTANDER', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2595, '2018-09-28', '2018', '14173869', '01', '', 'Refer: 17658236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2597, '2018-09-28', '2018', '14185951', '01', '', 'Refer: 17658213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2598, '2018-09-28', '2018', '34184982', '01', '', 'Refer: 17658278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2599, '2018-09-28', '2018', '14173171', '01', '', 'Refer: 17658236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2601, '2018-09-28', '2018', '14185430', '01', '', 'Refer: 17658285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2602, '2018-09-28', '2018', '14185455', '02', '', 'Refer: 17819265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2603, '2018-09-28', '2017', '12068100', '10', '', 'Refer: 17652270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2606, '2018-09-28', '2018', '42124624', '01', '', 'Refer: 17658218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2607, '2018-09-27', '2018', '23148074', '10', '', 'Refer: 20445236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL);
INSERT INTO `edocta` (`id`, `edoFechaOper`, `edoAnioPago`, `edoClaveAlu`, `edoMesPago`, `edoDigPago`, `edoDescripcion`, `edoImpAbono`, `edoImpCargo`, `edoEstado`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2608, '2018-09-27', '2018', '52136846', '01', '', 'Refer: 17972294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2609, '2018-09-27', '2018', '14173898', '01', '', 'Refer: 17658264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2610, '2018-09-27', '2018', '14185992', '02', '', 'Refer: 17819272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2611, '2018-09-27', '2018', '33173820', '01', '', 'Refer: 17658203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2612, '2018-09-26', '2018', '24173827', '01', '', 'Refer: 17658276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2613, '2018-09-26', '2018', '14172599', '01', '', 'Refer: 17658205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2615, '2018-09-25', '2018', '52136833', '01', '', 'Refer: 17658235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2617, '2018-09-21', '2018', '62148874', '01', '', 'Refer: 17658279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:55', '2018-12-06 02:49:55', NULL),
(2620, '2018-09-19', '2018', '12090423', '03', '', 'Refer: 18127280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2621, '2018-09-19', '2018', '12090423', '02', '', 'Refer: 17819289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2622, '2018-09-19', '2018', '12090423', '01', '', 'Refer: 17658293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2623, '2018-09-19', '2018', '14186215', '01', '', 'Refer: 17658202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2624, '2018-09-19', '2018', '14161450', '01', '', 'Refer: 17658286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2625, '2018-09-18', '2018', '14173787', '01', '', 'Refer: 17658223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2626, '2018-09-18', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANORTE/I', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2627, '2018-09-18', '2018', '14161050', '02', '', 'Refer: 17819214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2628, '2018-09-18', '2018', '12090404', '79', '', 'Refer: 17537241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2629, '2018-09-18', '2018', '14173819', '01', '', 'Refer: 17655229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2630, '2018-09-17', '2018', '13159927', '01', '', 'Refer: 17525222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2631, '2018-09-17', '2018', '33173946', '01', '', 'Refer: 17529255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2632, '2018-09-17', '2018', '14185935', '01', '', 'Refer: 17529271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2633, '2018-09-17', '2018', '34186205', '01', '', 'Refer: 17522269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2634, '2018-09-17', '2018', '13159056', '01', '', 'Refer: 17522252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2635, '2018-09-17', '2018', '62147939', '01', '', 'Refer: 17529223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2636, '2018-09-17', '2018', '34174174', '01', '', 'Refer: 17525213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2638, '2018-09-17', '2018', '13148413', '01', '', 'Refer: 17529284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2640, '2018-09-17', '2018', '11045703', '01', '', 'Refer: 17522234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2641, '2018-09-17', '2018', '14173497', '01', '', 'Refer: 17529225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2642, '2018-09-17', '2018', '34172964', '01', '', 'Refer: 17528240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2644, '2018-09-17', '2018', '42101629', '01', '', 'Refer: 17529210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2646, '2018-09-17', '2018', '33159866', '01', '', 'Refer: 17529235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2647, '2018-09-17', '2018', '14185677', '01', '', 'Refer: 17529294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2648, '2018-09-17', '2018', '33162007', '01', '', 'Refer: 17522219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2649, '2018-09-17', '2018', '14161330', '10', '', 'Refer: 20445294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2650, '2018-09-17', '2018', '13135927', '01', '', 'Refer: 17522255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2651, '2018-09-17', '2018', '14161726', '01', '', 'Refer: 17529210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2652, '2018-09-17', '2018', '12091454', '01', '', 'Refer: 17525253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2653, '2018-09-17', '2018', '62135729', '01', '', 'Refer: 17522218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2654, '2018-09-17', '2018', '13159084', '01', '', 'Refer: 17525211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2655, '2018-09-17', '2018', '14173092', '01', '', 'Refer: 17528283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2656, '2018-09-17', '2018', '42102048', '01', '', 'Refer: 17522245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2657, '2018-09-17', '2018', '11067540', '01', '', 'Refer: 17528284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2658, '2018-09-17', '2018', '14161066', '10', '', 'Refer: 20445251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2659, '2018-09-17', '2018', '13135909', '01', '', 'Refer: 17527219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2660, '2018-09-17', '2018', '12113542', '01', '', 'Refer: 17529249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2661, '2018-09-17', '2018', '14161051', '01', '', 'Refer: 17529269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2662, '2018-09-17', '2018', '14185159', '01', '', 'Refer: 17525250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2663, '2018-09-17', '2018', '23148509', '01', '', 'Refer: 17528261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2665, '2018-09-17', '2018', '12089417', '01', '', 'Refer: 17528208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2666, '2018-09-17', '2018', '34173540', '01', '', 'Refer: 17522237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2667, '2018-09-17', '2018', '14185129', '01', '', 'Refer: 17528250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2669, '2018-09-17', '2018', '32101922', '01', '', 'Refer: 17529264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2670, '2018-09-17', '2018', '32101924', '01', '', 'Refer: 17529286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2672, '2018-09-17', '2018', '14162016', '01', '', 'Refer: 17529291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2673, '2018-09-17', '2018', '12090569', '01', '', 'Refer: 17528261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2674, '2018-09-17', '2018', '14185493', '01', '', 'Refer: 17529242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2675, '2018-09-17', '2018', '14161219', '01', '', 'Refer: 17528229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2676, '2018-09-17', '2018', '23161102', '01', '', 'Refer: 17528223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2677, '2018-09-17', '2018', '31089818', '01', '', 'Refer: 17528211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2678, '2018-09-17', '2018', '14172956', '10', '', 'Refer: 20445239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2679, '2018-09-17', '2018', '14173380', '01', '', 'Refer: 17522221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2680, '2018-09-17', '2018', '34174003', '01', '', 'Refer: 17529243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2681, '2018-09-17', '2018', '31079337', '01', '', 'Refer: 17522234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2682, '2018-09-17', '2018', '12090522', '01', '', 'Refer: 17525287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2683, '2018-09-17', '2018', '13136745', '01', '', 'Refer: 17529238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2684, '2018-09-17', '2018', '14161648', '01', '', 'Refer: 17529241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2685, '2018-09-17', '2018', '14172860', '01', '', 'Refer: 17529255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2686, '2018-09-17', '2018', '14184868', '01', '', 'Refer: 17529210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2687, '2018-09-17', '2018', '13159251', '34', '', 'Refer: 17592246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2689, '2018-09-17', '2018', '62148396', '01', '', 'Refer: 17529282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2690, '2018-09-17', '2018', '14185641', '01', '', 'Refer: 17529286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2691, '2018-09-17', '2018', '12090426', '01', '', 'Refer: 17525217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2692, '2018-09-17', '2018', '34185900', '01', '', 'Refer: 17529211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2694, '2018-09-17', '2018', '14185167', '01', '', 'Refer: 17529293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2695, '2018-09-17', '2018', '23162130', '01', '', 'Refer: 17528259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2696, '2018-09-17', '2018', '14173468', '01', '', 'Refer: 17529294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2697, '2018-09-17', '2018', '24173458', '01', '', 'Refer: 17529201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2698, '2018-09-17', '2018', '22067538', '01', '', 'Refer: 17528292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2700, '2018-09-17', '2018', '13147271', '01', '', 'Refer: 17528274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2701, '2018-09-17', '2018', '14185068', '01', '', 'Refer: 17529287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2702, '2018-09-17', '2018', '14172738', '01', '', 'Refer: 17522293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2703, '2018-09-17', '2018', '23159619', '01', '', 'Refer: 17528236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2704, '2018-09-17', '2018', '13135907', '01', '', 'Refer: 17528210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2705, '2018-09-17', '2018', '11045911', '01', '', 'Refer: 17528240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2706, '2018-09-17', '2018', '11045674', '01', '', 'Refer: 17528203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2707, '2018-09-17', '2018', '12079192', '01', '', 'Refer: 17529293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2709, '2018-09-17', '2018', '12101542', '01', '', 'Refer: 17528272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2711, '2018-09-17', '2018', '22101814', '09', '', 'Refer: 19980256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2712, '2018-09-17', '2018', '22101814', '08', '', 'Refer: 19672292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2713, '2018-09-17', '2018', '22101814', '07', '', 'Refer: 19362205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2715, '2018-09-17', '2018', '22101814', '06', '', 'Refer: 19052215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2716, '2018-09-17', '2018', '22101814', '05', '', 'Refer: 18742295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2717, '2018-09-17', '2018', '22101814', '04', '', 'Refer: 18452242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2718, '2018-09-17', '2018', '12090428', '01', '', 'Refer: 17529291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2719, '2018-09-17', '2018', '22101814', '03', '', 'Refer: 18120289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2721, '2018-09-17', '2018', '22101814', '02', '', 'Refer: 17812201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2722, '2018-09-17', '2018', '22101814', '01', '', 'Refer: 17522245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2723, '2018-09-17', '2018', '13135818', '01', '', 'Refer: 17529230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2726, '2018-09-17', '2018', '23148141', '01', '', 'Refer: 17527241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2727, '2018-09-17', '2018', '14161331', '01', '', 'Refer: 17529294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2728, '2018-09-16', '2018', '14184998', '01', '', 'Refer: 17528253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2729, '2018-09-16', '2018', '14173544', '01', '', 'Refer: 17522247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2731, '2018-09-15', '2018', '14185897', '01', '', 'Refer: 17528244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2732, '2018-09-15', '2018', '33161681', '01', '', 'Refer: 17527211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2735, '2018-09-15', '2018', '14173745', '06', '', 'Refer: 19059256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2736, '2018-09-15', '2018', '34186208', '01', '', 'Refer: 17529296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2737, '2018-09-15', '2018', '21079117', '01', '', 'Refer: 17529248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2738, '2018-09-15', '2018', '14173740', '01', '', 'Refer: 17529231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2739, '2018-09-15', '2018', '23148393', '01', '', 'Refer: 17522297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2740, '2018-09-15', '2018', '11045750', '01', '', 'Refer: 17528247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2742, '2018-09-15', '2018', '12136922', '01', '', 'Refer: 17529297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2745, '2018-09-15', '2018', '14173785', '01', '', 'Refer: 17522247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2748, '2018-09-15', '2018', '14161448', '01', '', 'Refer: 17528291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2750, '2018-09-15', '2018', '12113281', '01', '', 'Refer: 17529239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2752, '2018-09-14', '2018', '23159360', '01', '', 'Refer: 17529261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2753, '2018-09-14', '2018', '14173828', '01', '', 'Refer: 17529213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2754, '2018-09-14', '2018', '12080003', '01', '', 'Refer: 17525261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2756, '2018-09-14', '2018', '13158983', '01', '', 'Refer: 17525237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2757, '2018-09-14', '2018', '14172988', '01', '', 'Refer: 17529289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2758, '2018-09-14', '2018', '13147413', '01', '', 'Refer: 17528252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2759, '2018-09-14', '2018', '14161783', '01', '', 'Refer: 17528242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2760, '2018-09-14', '2018', '14185707', '01', '', 'Refer: 17529220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2761, '2018-09-14', '2018', '14185921', '01', '', 'Refer: 17529214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2762, '2018-09-14', '2018', '14160918', '01', '', 'Refer: 17528221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2763, '2018-09-14', '2018', '14173997', '01', '', 'Refer: 17529213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2764, '2018-09-14', '2018', '14172984', '01', '', 'Refer: 17529245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2765, '2018-09-14', '2018', '13147252', '01', '', 'Refer: 17525220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2766, '2018-09-14', '2018', '14162009', '10', '', 'Refer: 20444212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2767, '2018-09-14', '2018', '14185454', '01', '', 'Refer: 17529201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2768, '2018-09-14', '2018', '14186004', '01', '', 'Refer: 17529281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2769, '2018-09-14', '2018', '31067797', '01', '', 'Refer: 17522222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2771, '2018-09-14', '2018', '24173826', '01', '', 'Refer: 17525253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2776, '2018-09-14', '2018', '14184444', '01', '', 'Refer: 17529266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2777, '2018-09-14', '2018', '13159412', '01', '', 'Refer: 17528205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2778, '2018-09-14', '2018', '12091327', '01', '', 'Refer: 17529282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2780, '2018-09-14', '2018', '14161150', '01', '', 'Refer: 17529275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2781, '2018-09-14', '2018', '54186014', '01', '', 'Refer: 17529265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2782, '2018-09-14', '2018', '14161629', '01', '', 'Refer: 17529226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2783, '2018-09-14', '2018', '11056579', '10', '', 'Refer: 20445210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2784, '2018-09-14', '2018', '13136175', '01', '', 'Refer: 17527246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2787, '2018-09-14', '2018', '14173493', '10', '', 'Refer: 20445289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:56', '2018-12-06 02:49:56', NULL),
(2790, '2018-09-14', '2018', '54185726', '01', '', 'Refer: 17528290', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2792, '2018-09-14', '2018', '54185229', '01', '', 'Refer: 17529251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2793, '2018-09-14', '2018', '31089410', '01', '', 'Refer: 17522268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2794, '2018-09-14', '2018', '13135798', '01', '', 'Refer: 17528207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2795, '2018-09-14', '2018', '33159080', '10', '', 'Refer: 20444251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2796, '2018-09-14', '2018', '13148324', '01', '', 'Refer: 17528278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2797, '2018-09-14', '2018', '14184777', '01', '', 'Refer: 17529292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2801, '2018-09-14', '2018', '14185566', '01', '', 'Refer: 17529253', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2802, '2018-09-14', '2018', '13135758', '01', '', 'Refer: 17529265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2803, '2018-09-14', '2018', '23160735', '01', '', 'Refer: 17529294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2805, '2018-09-14', '2018', '14186149', '01', '', 'Refer: 17523230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2806, '2018-09-14', '2018', '12078893', '01', '', 'Refer: 17529210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2807, '2018-09-14', '2018', '12078411', '01', '', 'Refer: 17522216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2808, '2018-09-14', '2018', '14185146', '01', '', 'Refer: 17525204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2809, '2018-09-13', '2018', '14161456', '01', '', 'Refer: 17529295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2818, '2018-09-13', '2018', '13147776', '10', '', 'Refer: 20445244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2819, '2018-09-13', '2018', '14173762', '01', '', 'Refer: 17529279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2820, '2018-09-13', '2018', '13147779', '01', '', 'Refer: 17529266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2821, '2018-09-13', '2018', '12124240', '01', '', 'Refer: 17525263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2822, '2018-09-13', '2018', '33173164', '01', '', 'Refer: 17529220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2823, '2018-09-13', '2018', '14173706', '01', '', 'Refer: 17528232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2824, '2018-09-13', '2018', '52113443', '01', '', 'Refer: 17527285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2825, '2018-09-13', '2018', '23162017', '06', '', 'Refer: 19059276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2826, '2018-09-13', '2018', '14184852', '01', '', 'Refer: 17529228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2827, '2018-09-13', '2018', '14185619', '01', '', 'Refer: 17529238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2828, '2018-09-13', '2018', '14161996', '10', '', 'Refer: 20445249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2830, '2018-09-13', '2018', '11067821', '01', '', 'Refer: 17529236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2831, '2018-09-13', '2018', '13136140', '01', '', 'Refer: 17525223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2833, '2018-09-13', '2018', '13136251', '10', '', 'Refer: 20445230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2834, '2018-09-13', '2018', '13159047', '10', '', 'Refer: 20445255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2835, '2018-09-13', '2018', '34173023', '01', '', 'Refer: 17529250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2836, '2018-09-13', '2018', '14161997', '01', '', 'Refer: 17529249', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2838, '2018-09-13', '2018', '14173311', '01', '', 'Refer: 17522238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2839, '2018-09-13', '2018', '12078472', '01', '', 'Refer: 17529202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2840, '2018-09-13', '2018', '14161795', '10', '', 'Refer: 20445204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2841, '2018-09-13', '2018', '34185057', '01', '', 'Refer: 17528284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2842, '2018-09-13', '2018', '21078510', '10', '', 'Refer: 20444218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2843, '2018-09-13', '2018', '21078511', '10', '', 'Refer: 20445242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2844, '2018-09-13', '2018', '14161880', '01', '', 'Refer: 17529239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2846, '2018-09-13', '2018', '14172544', '01', '', 'Refer: 17529222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2847, '2018-09-13', '2018', '14174044', '01', '', 'Refer: 17529272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2848, '2018-09-13', '2018', '14172834', '01', '', 'Refer: 17529260', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2850, '2018-09-12', '2018', '54185130', '01', '', 'Refer: 17529245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2851, '2018-09-12', '2018', '14173005', '01', '', 'Refer: 17520289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2852, '2018-09-12', '20ID', 'EI RECIB', 'OS', '', 'Refer: COTIABAN', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2853, '2018-09-12', '2018', '13150303', '01', '', 'Refer: 17525267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2855, '2018-09-12', '2018', '12137058', '01', '', 'Refer: 17523287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2856, '2018-09-12', '2018', '14173893', '01', '', 'Refer: 17528236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2857, '2018-09-12', '2018', '14185926', '01', '', 'Refer: 17528256', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2858, '2018-09-12', '2018', '34172864', '10', '', 'Refer: 20445247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2859, '2018-09-12', '2018', '14185269', '01', '', 'Refer: 17529235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2862, '2018-09-12', '2018', '12112938', '02', '', 'Refer: 17815255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2863, '2018-09-12', '2018', '12089459', '09', '', 'Refer: 19988222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2864, '2018-09-12', '2018', '14184688', '01', '', 'Refer: 17529202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2865, '2018-09-12', '2018', '12089459', '03', '', 'Refer: 18128255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2866, '2018-09-12', '2018', '13159061', '01', '', 'Refer: 17529204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2868, '2018-09-12', '2018', '54185195', '01', '', 'Refer: 17529281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2869, '2018-09-12', '2018', '14174062', '01', '', 'Refer: 17528263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2871, '2018-09-12', '2018', '14160888', '01', '', 'Refer: 17529211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2873, '2018-09-12', '2018', '14173407', '01', '', 'Refer: 17529205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2874, '2018-09-12', '2018', '14185759', '01', '', 'Refer: 17529210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2875, '2018-09-12', '2018', '14185924', '01', '', 'Refer: 17527221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2876, '2018-09-11', '2018', '14160909', '01', '', 'Refer: 17528219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2877, '2018-09-11', '2018', '14173000', '01', '', 'Refer: 17529254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2878, '2018-09-11', '2018', '14184471', '01', '', 'Refer: 17529272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2880, '2018-09-11', '2018', '31067755', '01', '', 'Refer: 17525284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2881, '2018-09-11', '2018', '14185936', '01', '', 'Refer: 17529282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2882, '2018-09-11', '2018', '34173303', '01', '', 'Refer: 17529275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2885, '2018-09-11', '2018', '13159045', '01', '', 'Refer: 17529222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2886, '2018-09-11', '2018', '33159057', '01', '', 'Refer: 17528278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2887, '2018-09-11', '2018', '23159058', '01', '', 'Refer: 17529285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2888, '2018-09-11', '2018', '21078495', '01', '', 'Refer: 17529265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2889, '2018-09-11', '2018', '21067555', '01', '', 'Refer: 17529285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2890, '2018-09-11', '2018', '12124300', '01', '', 'Refer: 17529280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2892, '2018-09-11', '2018', '14185107', '01', '', 'Refer: 17529215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2893, '2018-09-11', '2018', '54185975', '01', '', 'Refer: 17529294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2894, '2018-09-11', '2018', '12112938', '01', '', 'Refer: 17525202', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2895, '2018-09-11', '2018', '14161008', '01', '', 'Refer: 17529281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2896, '2018-09-11', '2018', '62136116', '01', '', 'Refer: 17529277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2898, '2018-09-11', '2018', '33174219', '01', '', 'Refer: 17529246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2900, '2018-09-11', '2018', '14184767', '01', '', 'Refer: 17529279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2901, '2018-09-11', '2018', '13160990', '10', '', 'Refer: 20445248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2902, '2018-09-11', '2018', '14160967', '10', '', 'Refer: 20444286', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2903, '2018-09-10', '2018', '14172996', '01', '', 'Refer: 17525228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2904, '2018-09-10', '2018', '14172736', '01', '', 'Refer: 17529265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2905, '2018-09-10', '2018', '34186170', '01', '', 'Refer: 17528269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2906, '2018-09-10', '2018', '11045784', '09', '', 'Refer: 19982289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2907, '2018-09-10', '2018', '11045784', '08', '', 'Refer: 19673215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2908, '2018-09-10', '2018', '11045784', '07', '', 'Refer: 19363225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2909, '2018-09-10', '2018', '13159892', '01', '', 'Refer: 17525241', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2910, '2018-09-10', '2018', '11045784', '06', '', 'Refer: 19053235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2911, '2018-09-10', '2018', '11045784', '05', '', 'Refer: 18743218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2912, '2018-09-10', '2018', '11045784', '04', '', 'Refer: 18453262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2913, '2018-09-10', '2018', '11046379', '10', '', 'Refer: 20315277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2914, '2018-09-10', '2018', '11046379', '09', '', 'Refer: 19983295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2915, '2018-09-10', '2018', '11046379', '08', '', 'Refer: 19675234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2916, '2018-09-10', '2018', '11045784', '03', '', 'Refer: 18122225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2917, '2018-09-10', '2018', '11046379', '07', '', 'Refer: 19365244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2918, '2018-09-10', '2018', '11046379', '06', '', 'Refer: 19055254', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2919, '2018-09-10', '2018', '11046379', '05', '', 'Refer: 18745237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2920, '2018-09-10', '2018', '11046379', '04', '', 'Refer: 18455281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2921, '2018-09-10', '2018', '11046379', '03', '', 'Refer: 18123231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2922, '2018-09-10', '2018', '11045784', '02', '', 'Refer: 17813221', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2923, '2018-09-10', '2018', '11046379', '02', '', 'Refer: 17815240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2924, '2018-09-10', '2018', '11046379', '01', '', 'Refer: 17525284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2925, '2018-09-10', '2018', '11045784', '01', '', 'Refer: 17523265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2926, '2018-09-10', '2018', '12124346', '01', '', 'Refer: 17529204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2927, '2018-09-10', '2018', '13159042', '10', '', 'Refer: 20445297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2928, '2018-09-10', '2018', '33174153', '01', '', 'Refer: 17529215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2930, '2018-09-10', '2018', '13147331', '01', '', 'Refer: 17525297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2931, '2018-09-10', '2018', '14173188', '01', '', 'Refer: 17529269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2932, '2018-09-10', '2018', '14186152', '01', '', 'Refer: 17529244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2933, '2018-09-10', '2018', '14184827', '01', '', 'Refer: 17529244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2934, '2018-09-10', '2018', '14185769', '01', '', 'Refer: 17529223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2935, '2018-09-10', '2018', '12090400', '01', '', 'Refer: 17529274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2936, '2018-09-10', '2018', '34185868', '01', '', 'Refer: 17529263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2937, '2018-09-10', '2018', '14174032', '01', '', 'Refer: 17529237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2938, '2018-09-10', '2018', '24186086', '01', '', 'Refer: 17529230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2939, '2018-09-10', '2018', '13159251', '01', '', 'Refer: 17529225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2940, '2018-09-10', '2018', '23148358', '01', '', 'Refer: 17525242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2941, '2018-09-10', '2016', '14148353', '10', '', 'Refer: 17656232', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2946, '2018-09-09', '2018', '14184761', '01', '', 'Refer: 17529213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2948, '2018-09-09', '2018', '14161199', '01', '', 'Refer: 17528219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2949, '2018-09-08', '2018', '54185127', '01', '', 'Refer: 17529212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2950, '2018-09-08', '2018', '62147754', '01', '', 'Refer: 17522263', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2951, '2018-09-07', '2018', '14184690', '01', '', 'Refer: 17529224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2952, '2018-09-07', '2018', '14173676', '01', '', 'Refer: 17529222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2953, '2018-09-07', '2018', '14172537', '01', '', 'Refer: 17528229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2954, '2018-09-07', '2018', '13159050', '10', '', 'Refer: 20440223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2955, '2018-09-07', '2018', '14186305', '01', '', 'Refer: 17529246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2956, '2018-09-07', '2018', '34184810', '01', '', 'Refer: 17528272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2957, '2018-09-07', '2018', '13067532', '90', '', 'Refer: 17426220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2958, '2018-09-07', '2018', '11056550', '10', '', 'Refer: 20444266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2959, '2018-09-07', '2018', '14186137', '01', '', 'Refer: 17529273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2960, '2018-09-07', '2018', '13147205', '01', '', 'Refer: 17529240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2961, '2018-09-07', '2018', '54185928', '01', '', 'Refer: 17525210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2962, '2018-09-07', '2018', '14185489', '01', '', 'Refer: 17525243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2963, '2018-09-07', '2018', '14173715', '01', '', 'Refer: 17528234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2964, '2018-09-07', '2018', '12089420', '01', '', 'Refer: 17522260', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2965, '2018-09-07', '2018', '14173297', '01', '', 'Refer: 17523210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2966, '2018-09-07', '2018', '13147356', '01', '', 'Refer: 17522242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2967, '2018-09-07', '2018', '23147307', '01', '', 'Refer: 17527270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2968, '2018-09-06', '2018', '13147223', '01', '', 'Refer: 17525289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2969, '2018-09-06', '2018', '14161396', '01', '', 'Refer: 17529233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2970, '2018-09-06', '2018', '34185214', '01', '', 'Refer: 17528233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2971, '2018-09-06', '2018', '34185213', '01', '', 'Refer: 17529235', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2972, '2018-09-06', '2018', '14184727', '01', '', 'Refer: 17528214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2974, '2018-09-06', '2018', '14184728', '01', '', 'Refer: 17529238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2975, '2018-09-06', '2018', '33173799', '01', '', 'Refer: 17529222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2976, '2018-09-06', '2018', '33174019', '10', '', 'Refer: 20444210', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2978, '2018-09-06', '2018', '12078515', '01', '', 'Refer: 17528258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2979, '2018-09-06', '2018', '54185067', '01', '', 'Refer: 17529247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2981, '2018-09-06', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2983, '2018-09-06', '2018', '14173694', '01', '', 'Refer: 17529226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2984, '2018-09-06', '2018', '14173153', '01', '', 'Refer: 17529272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2985, '2018-09-06', '2018', '54184689', '01', '', 'Refer: 17529281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2986, '2018-09-06', '2018', '33173695', '01', '', 'Refer: 17529258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2987, '2018-09-06', '2018', '14160922', '01', '', 'Refer: 17522284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2988, '2018-09-06', '2018', '23159402', '10', '', 'Refer: 20449285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2990, '2018-09-06', '2018', '14184647', '01', '', 'Refer: 17529236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2994, '2018-09-05', '2018', '14185874', '01', '', 'Refer: 17529295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2995, '2018-09-05', '2018', '54185624', '01', '', 'Refer: 17529264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2996, '2018-09-05', '2018', '14185108', '01', '', 'Refer: 17529226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2997, '2018-09-05', '2018', '33161759', '01', '', 'Refer: 17522212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2998, '2018-09-05', '2018', '12114028', '01', '', 'Refer: 17527294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(2999, '2018-09-05', '2018', '34185153', '01', '', 'Refer: 17529270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(3000, '2018-09-05', '2018', '54185152', '01', '', 'Refer: 17529293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(3001, '2018-09-05', '2018', '13147406', '01', '', 'Refer: 17525233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:57', '2018-12-06 02:49:57', NULL),
(3002, '2018-09-05', '2018', '14185550', '01', '', 'Refer: 17529271', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3004, '2018-09-05', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3008, '2018-09-04', '2018', '34173672', '01', '', 'Refer: 17529212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3009, '2018-09-04', '2018', '14185538', '01', '', 'Refer: 17529236', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3010, '2018-09-04', '2018', '14185801', '01', '', 'Refer: 17529268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3011, '2018-09-04', '2018', '14186183', '01', '', 'Refer: 17527268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3012, '2018-09-04', '2018', '14185431', '01', '', 'Refer: 17529239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3013, '2018-09-04', '2018', '13159053', '02', '', 'Refer: 17815214', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3014, '2018-09-04', '2018', '13159053', '01', '', 'Refer: 17525258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3016, '2018-09-04', '2018', '14185172', '01', '', 'Refer: 17529251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3018, '2018-09-04', '2018', '14185187', '01', '', 'Refer: 17529222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3019, '2018-09-04', '2018', '14161003', '10', '', 'Refer: 20445237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3020, '2018-09-04', '2018', '14161001', '01', '', 'Refer: 17529204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3021, '2018-09-04', '2018', '14186057', '01', '', 'Refer: 17529282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3023, '2018-09-04', '2018', '21067582', '01', '', 'Refer: 17523213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3024, '2018-09-04', '2018', '13159468', '01', '', 'Refer: 17529252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3025, '2018-09-04', '2018', '14184468', '03', '', 'Refer: 18126270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3026, '2018-09-04', '2018', '14184468', '02', '', 'Refer: 17818279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3027, '2018-09-04', '2018', '14184468', '01', '', 'Refer: 17528226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3028, '2018-09-04', '2018', '14184735', '01', '', 'Refer: 17529218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3029, '2018-09-04', '2018', '14173987', '01', '', 'Refer: 17528284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3030, '2018-09-04', '2018', '11067499', '10', '', 'Refer: 20445261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3033, '2018-09-03', '2018', '14173448', '10', '', 'Refer: 20445279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3034, '2018-09-03', '20E', 'POSITO D', 'TE', '', 'Refer: RCERO/RE', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3035, '2018-09-03', '2018', '14186217', '01', '', 'Refer: 17529264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3036, '2018-09-03', '2018', '13159054', '01', '', 'Refer: 17525269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3037, '2018-09-03', '2018', '14185956', '01', '', 'Refer: 17529211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3038, '2018-09-03', '2018', '62148478', '10', '', 'Refer: 20445209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3039, '2018-09-03', '2018', '14172780', '01', '', 'Refer: 17529264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3041, '2018-09-01', '2018', '14173989', '01', '', 'Refer: 17529222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3042, '2018-09-01', '2018', '14174180', '99', '', 'Refer: 17452204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3043, '2018-09-01', '20ID', 'EI RECIB', 'OB', '', 'Refer: ANAMEX/0', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3044, '2018-09-29', '2018', '12147221', '01', '', 'Refer: 17865282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3045, '2018-09-29', '2018', '11102538', '01', '', 'Refer: 17865223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3046, '2018-09-28', '2018', '52173867', '01', '', 'Refer: 17657243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3048, '2018-09-28', '2018', '11136383', '01', '', 'Refer: 17657218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3049, '2018-09-27', '2018', '12147774', '01', '', 'Refer: 17657242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3051, '2018-09-27', '2017', '11148380', '10', '', 'Refer: 17651250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3052, '2018-09-26', '2018', '62184566', '01', '', 'Refer: 17657240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3054, '2018-09-26', '2018', '12184750', '01', '', 'Refer: 17657207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3055, '2018-09-26', '2018', '12185930', '01', '', 'Refer: 17658247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3056, '2018-09-24', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3059, '2018-09-24', '2018', '12184698', '06', '', 'Refer: 19058243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3060, '2018-09-24', '2018', '12184698', '05', '', 'Refer: 18748226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL);
INSERT INTO `edocta` (`id`, `edoFechaOper`, `edoAnioPago`, `edoClaveAlu`, `edoMesPago`, `edoDigPago`, `edoDescripcion`, `edoImpAbono`, `edoImpCargo`, `edoEstado`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3061, '2018-09-24', '2018', '12184698', '04', '', 'Refer: 18458270', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3062, '2018-09-24', '2018', '12184698', '03', '', 'Refer: 18128246', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3063, '2018-09-24', '2018', '12184698', '02', '', 'Refer: 17818229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3064, '2018-09-24', '2018', '11159313', '01', '', 'Refer: 17657230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3065, '2018-09-21', '2018', '22184812', '01', '', 'Refer: 17657211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3066, '2018-09-21', '2018', '12184813', '01', '', 'Refer: 17657205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3067, '2018-09-21', '2018', '22186349', '01', '', 'Refer: 17657280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3068, '2018-09-20', '20ID', 'EI RECIB', 'OM', '', 'Refer: ULTIVA B', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3072, '2018-09-19', '2018', '31136732', '10', '', 'Refer: 20448250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3073, '2018-09-19', '2018', '22184711', '01', '', 'Refer: 17657280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3074, '2018-09-19', '2018', '32173884', '99', '', 'Refer: 17657265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3075, '2018-09-18', '2018', '21159331', '01', '', 'Refer: 17659277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3076, '2018-09-18', '2018', '11159332', '01', '', 'Refer: 17658258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3078, '2018-09-18', '2018', '52186360', '99', '', 'Refer: 17537268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3079, '2018-09-18', '2018', '52174307', '01', '', 'Refer: 17657293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3081, '2018-09-18', '2018', '42184531', '01', '', 'Refer: 17657209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3082, '2018-09-17', '2018', '21161660', '01', '', 'Refer: 17523273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3083, '2018-09-17', '2018', '52173671', '01', '', 'Refer: 17529209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3084, '2018-09-17', '2018', '32172586', '01', '', 'Refer: 17526265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3085, '2018-09-17', '2018', '11159951', '01', '', 'Refer: 17528208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3086, '2018-09-17', '2018', '11113714', '01', '', 'Refer: 17525201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3087, '2018-09-17', '2018', '21124182', '01', '', 'Refer: 17526240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3088, '2018-09-17', '2018', '12185249', '01', '', 'Refer: 17529280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3089, '2018-09-17', '2018', '12135755', '01', '', 'Refer: 17526277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3090, '2018-09-17', '2018', '12172548', '01', '', 'Refer: 17528227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3091, '2018-09-17', '2018', '31162359', '01', '', 'Refer: 17528215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3092, '2018-09-17', '2018', '21161766', '01', '', 'Refer: 17525285', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3093, '2018-09-17', '2018', '12159015', '01', '', 'Refer: 17526228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3094, '2018-09-17', '2018', '21159125', '01', '', 'Refer: 17526262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3095, '2018-09-17', '2018', '31173093', '01', '', 'Refer: 17528289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3096, '2018-09-17', '2018', '42162105', '01', '', 'Refer: 17528296', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3097, '2018-09-17', '2018', '11135869', '01', '', 'Refer: 17529280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3098, '2018-09-17', '2018', '52173710', '99', '', 'Refer: 17657244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3099, '2018-09-17', '2018', '11161014', '01', '', 'Refer: 17528295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3100, '2018-09-17', '2018', '12135827', '01', '', 'Refer: 17526277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3102, '2018-09-17', '2018', '22159069', '01', '', 'Refer: 17521289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3103, '2018-09-17', '2018', '11135776', '01', '', 'Refer: 17529243', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3104, '2018-09-17', '2018', '12184828', '01', '', 'Refer: 17528216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3105, '2018-09-17', '2018', '22173383', '01', '', 'Refer: 17526297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3108, '2018-09-17', '2018', '21124249', '01', '', 'Refer: 17529224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3109, '2018-09-17', '2018', '21148508', '01', '', 'Refer: 17528224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3110, '2018-09-17', '2018', '31174303', '01', '', 'Refer: 17528242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3111, '2018-09-17', '2018', '11159137', '01', '', 'Refer: 17525267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3112, '2018-09-17', '2018', '32186168', '01', '', 'Refer: 17526292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3113, '2018-09-17', '2018', '12160727', '01', '', 'Refer: 17526234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3114, '2018-09-17', '2018', '12185794', '01', '', 'Refer: 17528265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3115, '2018-09-17', '2018', '52185795', '01', '', 'Refer: 17528247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3116, '2018-09-17', '2018', '12150299', '01', '', 'Refer: 17528265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3117, '2018-09-17', '2018', '12150456', '34', '', 'Refer: 17522226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3119, '2018-09-17', '2018', '12148021', '01', '', 'Refer: 17526252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3120, '2018-09-17', '2018', '11159148', '01', '', 'Refer: 17528233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3121, '2018-09-17', '2018', '11135925', '01', '', 'Refer: 17529201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3122, '2018-09-17', '2018', '21113622', '01', '', 'Refer: 17526205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3124, '2018-09-17', '2018', '22186009', '01', '', 'Refer: 17528217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3125, '2018-09-17', '2018', '11147259', '01', '', 'Refer: 17528213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3126, '2018-09-17', '2018', '11148706', '01', '', 'Refer: 17528219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3127, '2018-09-17', '2018', '22161344', '01', '', 'Refer: 17526292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3128, '2018-09-17', '2018', '21160803', '01', '', 'Refer: 17526282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3129, '2018-09-17', '2018', '42186251', '01', '', 'Refer: 17528262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3130, '2018-09-17', '2018', '12135902', '01', '', 'Refer: 17529252', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3131, '2018-09-17', '2018', '42161684', '01', '', 'Refer: 17528261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3132, '2018-09-17', '2018', '31161675', '01', '', 'Refer: 17528229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3133, '2018-09-17', '2018', '12159075', '01', '', 'Refer: 17525293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3134, '2018-09-17', '2018', '12172772', '01', '', 'Refer: 17528234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3135, '2018-09-17', '2018', '12160692', '01', '', 'Refer: 17528279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3136, '2018-09-17', '2018', '32161676', '01', '', 'Refer: 17526227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3138, '2018-09-17', '2018', '31124538', '01', '', 'Refer: 17526229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3141, '2018-09-17', '2018', '11147305', '01', '', 'Refer: 17528218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3142, '2018-09-17', '2018', '62184533', '01', '', 'Refer: 17528208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3143, '2018-09-17', '2018', '12161415', '01', '', 'Refer: 17529206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3144, '2018-09-17', '2018', '31147501', '01', '', 'Refer: 17526216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3145, '2018-09-17', '2018', '11147695', '01', '', 'Refer: 17528289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3146, '2018-09-17', '2018', '12147235', '01', '', 'Refer: 17527240', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3147, '2018-09-17', '2018', '12160629', '01', '', 'Refer: 17528265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3148, '2018-09-17', '2018', '11135867', '01', '', 'Refer: 17529258', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3149, '2018-09-17', '2018', '11135724', '10', '', 'Refer: 20444251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3150, '2018-09-17', '2018', '11158981', '10', '', 'Refer: 20447278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3151, '2018-09-17', '2018', '12136823', '01', '', 'Refer: 17527265', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3152, '2018-09-16', '2018', '12160626', '01', '', 'Refer: 17529245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3153, '2018-09-16', '2018', '12160730', '01', '', 'Refer: 17527280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3154, '2018-09-16', '2018', '21159091', '01', '', 'Refer: 17529234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3156, '2018-09-15', '2018', '12159955', '01', '', 'Refer: 17529278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3160, '2018-09-15', '2018', '21124612', '09', '', 'Refer: 19987284', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3161, '2018-09-15', '2018', '21124612', '08', '', 'Refer: 19677294', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3162, '2018-09-15', '2018', '21124612', '07', '', 'Refer: 19367207', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3163, '2018-09-15', '2018', '21124612', '06', '', 'Refer: 19057217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3164, '2018-09-15', '2018', '21124612', '05', '', 'Refer: 18747297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3165, '2018-09-15', '2018', '21124612', '04', '', 'Refer: 18457244', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3166, '2018-09-15', '2018', '21124612', '03', '', 'Refer: 18127220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:58', '2018-12-06 02:49:58', NULL),
(3167, '2018-09-15', '2018', '21124612', '02', '', 'Refer: 17817203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3168, '2018-09-15', '2018', '21124612', '01', '', 'Refer: 17527247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3169, '2018-09-15', '2018', '21125149', '01', '', 'Refer: 17528213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3170, '2018-09-15', '2018', '12172593', '01', '', 'Refer: 17529250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3171, '2018-09-15', '2018', '11125490', '01', '', 'Refer: 17528213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3172, '2018-09-15', '2018', '31125489', '01', '', 'Refer: 17527223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3173, '2018-09-15', '2018', '12135759', '01', '', 'Refer: 17528250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3174, '2018-09-15', '2018', '12185125', '01', '', 'Refer: 17528277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3175, '2018-09-15', '2018', '11125343', '01', '', 'Refer: 17528261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3176, '2018-09-15', '2018', '31162332', '01', '', 'Refer: 17528209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3177, '2018-09-14', '2018', '32172539', '10', '', 'Refer: 20447212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3178, '2018-09-14', '2018', '21161195', '01', '', 'Refer: 17528250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3179, '2018-09-14', '2018', '12184565', '10', '', 'Refer: 20445208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3180, '2018-09-14', '2018', '11135838', '01', '', 'Refer: 17527204', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3181, '2018-09-14', '2018', '31172680', '01', '', 'Refer: 17528229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3182, '2018-09-14', '2018', '31136002', '01', '', 'Refer: 17528223', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3183, '2018-09-14', '2018', '11147635', '01', '', 'Refer: 17529224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3184, '2018-09-14', '2018', '31124988', '01', '', 'Refer: 17527278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3185, '2018-09-14', '2018', '11125177', '01', '', 'Refer: 17529226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3186, '2018-09-14', '2018', '21147454', '10', '', 'Refer: 20448272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3187, '2018-09-14', '2017', '42159375', '10', '', 'Refer: 17653230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3190, '2018-09-14', '2018', '12136881', '01', '', 'Refer: 17525295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3191, '2018-09-14', '2018', '42186294', '01', '', 'Refer: 17528250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3192, '2018-09-14', '2018', '11147478', '01', '', 'Refer: 17528262', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3193, '2018-09-14', '2018', '12147260', '01', '', 'Refer: 17527224', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3194, '2018-09-14', '2018', '12186304', '01', '', 'Refer: 17528293', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3197, '2018-09-14', '2018', '12186006', '02', '', 'Refer: 17818220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3199, '2018-09-14', '2018', '12172545', '01', '', 'Refer: 17528291', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3200, '2018-09-14', '2018', '32172546', '01', '', 'Refer: 17526213', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3204, '2018-09-14', '2018', '11147819', '10', '', 'Refer: 20445287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3206, '2018-09-14', '2018', '12147230', '01', '', 'Refer: 17528295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3207, '2018-09-14', '2018', '31148344', '01', '', 'Refer: 17528215', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3209, '2018-09-14', '2018', '31148345', '01', '', 'Refer: 17528226', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3210, '2018-09-14', '2018', '32160584', '01', '', 'Refer: 17528208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3213, '2018-09-14', '2018', '12136398', '01', '', 'Refer: 17526216', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3215, '2018-09-14', '2018', '62184518', '01', '', 'Refer: 17526211', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3216, '2018-09-14', '2018', '52184519', '01', '', 'Refer: 17528231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3217, '2018-09-14', '2018', '12172837', '01', '', 'Refer: 17526228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3220, '2018-09-14', '2018', '12172577', '01', '', 'Refer: 17529268', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3221, '2018-09-14', '2018', '12172576', '01', '', 'Refer: 17529257', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3226, '2018-09-14', '2018', '62184485', '09', '', 'Refer: 19988218', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3227, '2018-09-14', '2018', '62184485', '08', '', 'Refer: 19678228', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3228, '2018-09-14', '2018', '62184485', '07', '', 'Refer: 19368238', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3229, '2018-09-14', '2018', '62184485', '06', '', 'Refer: 19058248', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3230, '2018-09-14', '2018', '62184485', '05', '', 'Refer: 18748231', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3231, '2018-09-14', '2018', '62184485', '04', '', 'Refer: 18458275', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3232, '2018-09-14', '2018', '62184485', '03', '', 'Refer: 18128251', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3233, '2018-09-14', '2018', '62184485', '02', '', 'Refer: 17818234', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3234, '2018-09-14', '2018', '62184485', '01', '', 'Refer: 17528278', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3235, '2018-09-14', '2018', '62184486', '01', '', 'Refer: 17528289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3236, '2018-09-14', '2018', '32185413', '09', '', 'Refer: 19988267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3237, '2018-09-14', '2018', '32185413', '08', '', 'Refer: 19678277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3238, '2018-09-14', '2018', '32185413', '07', '', 'Refer: 19368287', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3239, '2018-09-14', '2018', '32185413', '06', '', 'Refer: 19058297', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3240, '2018-09-14', '2018', '32185413', '05', '', 'Refer: 18748280', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3241, '2018-09-14', '2018', '32185413', '04', '', 'Refer: 18458227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3242, '2018-09-14', '2018', '32185413', '03', '', 'Refer: 18128203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3243, '2018-09-14', '2018', '32185413', '02', '', 'Refer: 17818283', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3244, '2018-09-14', '2018', '32185413', '01', '', 'Refer: 17528230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3245, '2018-09-14', '2018', '22160637', '01', '', 'Refer: 17528273', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3246, '2018-09-14', '2018', '12172600', '01', '', 'Refer: 17528201', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3247, '2018-09-14', '2018', '12160620', '01', '', 'Refer: 17529276', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3248, '2018-09-14', '2018', '12147774', '99', '', 'Refer: 17657208', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3249, '2018-09-13', '2018', '42172816', '01', '', 'Refer: 17529281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3250, '2018-09-13', '2018', '11147891', '01', '', 'Refer: 17529292', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3251, '2018-09-13', '2018', '42186158', '01', '', 'Refer: 17528225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3252, '2018-09-13', '2018', '22185207', '01', '', 'Refer: 17526281', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3253, '2018-09-13', '2018', '12173049', '09', '', 'Refer: 19988209', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3254, '2018-09-13', '2018', '12173049', '08', '', 'Refer: 19678219', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3255, '2018-09-13', '2018', '12173049', '07', '', 'Refer: 19368229', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3256, '2018-09-13', '2018', '12173049', '06', '', 'Refer: 19058239', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3257, '2018-09-13', '2018', '12173049', '05', '', 'Refer: 18748222', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3258, '2018-09-13', '2018', '12173049', '04', '', 'Refer: 18458266', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3259, '2018-09-13', '2018', '12173049', '03', '', 'Refer: 18128242', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3260, '2018-09-13', '2018', '12173049', '02', '', 'Refer: 17818225', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3261, '2018-09-13', '2018', '12173049', '01', '', 'Refer: 17528269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3262, '2018-09-13', '2018', '32161225', '09', '', 'Refer: 19986217', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3263, '2018-09-13', '2018', '32161225', '08', '', 'Refer: 19676227', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3264, '2018-09-13', '2018', '32161225', '07', '', 'Refer: 19366237', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3265, '2018-09-13', '2018', '32161225', '06', '', 'Refer: 19056247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3266, '2018-09-13', '2018', '32161225', '05', '', 'Refer: 18746230', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3267, '2018-09-13', '2018', '32161225', '04', '', 'Refer: 18456274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3268, '2018-09-13', '2018', '32161225', '03', '', 'Refer: 18126250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3269, '2018-09-13', '2018', '32161225', '02', '', 'Refer: 17816233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3270, '2018-09-13', '2018', '32161225', '01', '', 'Refer: 17526277', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3271, '2018-09-13', '2018', '42162020', '01', '', 'Refer: 17528250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3272, '2018-09-13', '2017', '42159375', '09', '', 'Refer: 17653233', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3274, '2018-09-13', '2018', '31135843', '01', '', 'Refer: 17525267', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3275, '2018-09-13', '2018', '12148458', '01', '', 'Refer: 17527255', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3276, '2018-09-13', '2018', '12136194', '01', '', 'Refer: 17528261', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3278, '2018-09-13', '2018', '12135844', '01', '', 'Refer: 17529212', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3279, '2018-09-13', '2018', '12186006', '01', '', 'Refer: 17528264', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3280, '2018-09-13', '2018', '31161183', '10', '', 'Refer: 20447282', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3282, '2018-09-13', '2018', '52185058', '01', '', 'Refer: 17528206', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3283, '2018-09-13', '2018', '12186258', '01', '', 'Refer: 17528288', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3284, '2018-09-13', '2018', '62186259', '01', '', 'Refer: 17527274', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3285, '2018-09-13', '2018', '12150151', '01', '', 'Refer: 17528205', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3286, '2018-09-12', '2017', '42159375', '08', '', 'Refer: 17653220', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3299, '2018-09-12', '2018', '11136838', '99', '', 'Refer: 17657259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3300, '2018-09-12', '2018', '42173892', '01', '', 'Refer: 17528250', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3301, '2018-09-12', '2018', '42185963', '01', '', 'Refer: 17528203', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3302, '2018-09-12', '2018', '12184551', '01', '', 'Refer: 17526295', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3303, '2018-09-12', '2018', '21125196', '01', '', 'Refer: 17528245', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3305, '2018-09-12', '2018', '12172561', '01', '', 'Refer: 17526247', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3306, '2018-09-12', '2018', '12148537', '09', '', 'Refer: 19986259', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3307, '2018-09-12', '2018', '12148537', '08', '', 'Refer: 19676269', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3308, '2018-09-12', '2018', '12148537', '07', '', 'Refer: 19366279', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3309, '2018-09-12', '2018', '12148537', '06', '', 'Refer: 19056289', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3310, '2018-09-12', '2018', '12148537', '05', '', 'Refer: 18746272', 0.00, 0.00, 'N', 1, '2018-12-06 02:49:59', '2018-12-06 02:49:59', NULL),
(3311, '2018-09-12', '2018', '12148537', '04', '', 'Refer: 18456219', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3312, '2018-09-12', '2018', '12148537', '03', '', 'Refer: 18126292', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3313, '2018-09-12', '2018', '12148537', '02', '', 'Refer: 17816275', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3314, '2018-09-12', '2018', '52185521', '10', '', 'Refer: 20445296', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3315, '2018-09-12', '2018', '12148537', '01', '', 'Refer: 17526222', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3316, '2018-09-12', '2018', '62185179', '01', '', 'Refer: 17528277', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3317, '2018-09-12', '2018', '12185316', '01', '', 'Refer: 17527296', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3318, '2018-09-12', '2018', '11136863', '01', '', 'Refer: 17526291', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3320, '2018-09-11', '2018', '21147405', '02', '', 'Refer: 17816279', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3321, '2018-09-11', '2018', '21147405', '01', '', 'Refer: 17526226', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3324, '2018-09-11', '2018', '22159747', '09', '', 'Refer: 19989210', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3325, '2018-09-11', '2018', '22159747', '08', '', 'Refer: 19679220', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3326, '2018-09-11', '2018', '22159747', '07', '', 'Refer: 19369230', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3327, '2018-09-11', '2018', '22159747', '06', '', 'Refer: 19059240', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3328, '2018-09-11', '2018', '21159125', '99', '', 'Refer: 17657214', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3329, '2018-09-11', '2018', '22159747', '05', '', 'Refer: 18749223', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3330, '2018-09-11', '2018', '22159747', '04', '', 'Refer: 18459267', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3331, '2018-09-11', '2018', '22159747', '03', '', 'Refer: 18129243', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3332, '2018-09-11', '2018', '22159747', '02', '', 'Refer: 17819226', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3333, '2018-09-11', '2018', '22159747', '01', '', 'Refer: 17529270', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3334, '2018-09-11', '2018', '11147248', '10', '', 'Refer: 20447239', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3335, '2018-09-11', '2018', '11136747', '10', '', 'Refer: 20447271', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3336, '2018-09-11', '2018', '12184555', '01', '', 'Refer: 17526242', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3337, '2018-09-11', '2018', '21124278', '09', '', 'Refer: 19983211', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3338, '2018-09-11', '2018', '21124278', '08', '', 'Refer: 19673221', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3339, '2018-09-11', '2018', '21124278', '07', '', 'Refer: 19363231', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3340, '2018-09-11', '2018', '21124278', '06', '', 'Refer: 19053241', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3341, '2018-09-11', '2018', '21124278', '05', '', 'Refer: 18743224', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3342, '2018-09-11', '2018', '21124278', '04', '', 'Refer: 18453268', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3343, '2018-09-11', '2018', '21124278', '03', '', 'Refer: 18123244', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3344, '2018-09-11', '2018', '21124278', '02', '', 'Refer: 17813227', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3345, '2018-09-11', '2018', '21124278', '01', '', 'Refer: 17523271', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3347, '2018-09-11', '2018', '21124559', '01', '', 'Refer: 17525236', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3350, '2018-09-10', '2018', '12159405', '01', '', 'Refer: 17529225', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3351, '2018-09-10', '2018', '32186175', '01', '', 'Refer: 17528201', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3352, '2018-09-10', '2018', '12147269', '01', '', 'Refer: 17526213', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3353, '2018-09-10', '2018', '52185232', '01', '', 'Refer: 17526219', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3354, '2018-09-10', '2018', '22185231', '01', '', 'Refer: 17528280', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3355, '2018-09-10', '2018', '11124304', '10', '', 'Refer: 20444212', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3356, '2018-09-10', '2018', '52184854', '01', '', 'Refer: 17528279', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3357, '2018-09-10', '2018', '12184698', '01', '', 'Refer: 17528273', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3358, '2018-09-10', '2018', '11136601', '01', '', 'Refer: 17528280', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3359, '2018-09-10', '2018', '32173099', '01', '', 'Refer: 17528271', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3361, '2018-09-09', '2018', '32185039', '01', '', 'Refer: 17528254', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3362, '2018-09-08', '20ID', 'EI RECIB', 'OH', '', 'Refer: SBC/0005', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3363, '2018-09-08', '2018', '21135833', '01', '', 'Refer: 17527263', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3364, '2018-09-08', '2018', '21113066', '01', '', 'Refer: 17527212', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3365, '2018-09-08', '2018', '12147753', '01', '', 'Refer: 17528245', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3366, '2018-09-08', '2018', '31161437', '01', '', 'Refer: 17527249', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3367, '2018-09-08', '2018', '11159330', '01', '', 'Refer: 17527250', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3368, '2018-09-08', '2018', '12136620', '01', '', 'Refer: 17521217', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3369, '2018-09-08', '2018', '11147641', '01', '', 'Refer: 17527264', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3370, '2018-09-08', '2018', '31090576', '01', '', 'Refer: 17529275', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3371, '2018-09-07', '2018', '32160661', '01', '', 'Refer: 17528263', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3372, '2018-09-07', '2018', '32185111', '01', '', 'Refer: 17528254', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3374, '2018-09-06', '2018', '52172764', '01', '', 'Refer: 17528214', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3377, '2018-09-06', '2018', '32174015', '10', '', 'Refer: 20447289', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3378, '2018-09-06', '2018', '32185886', '01', '', 'Refer: 17528228', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3380, '2018-09-06', '2018', '12159814', '01', '', 'Refer: 17526256', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3381, '2018-09-06', '2018', '21124301', '01', '', 'Refer: 17529295', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3382, '2018-09-06', '2018', '32160725', '09', '', 'Refer: 19988212', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3383, '2018-09-06', '2018', '32160725', '08', '', 'Refer: 19678222', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3384, '2018-09-06', '2018', '32160725', '07', '', 'Refer: 19368232', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3385, '2018-09-06', '2018', '32160725', '06', '', 'Refer: 19058242', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3386, '2018-09-06', '2018', '32160725', '05', '', 'Refer: 18748225', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3387, '2018-09-06', '2018', '32160725', '04', '', 'Refer: 18458269', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3388, '2018-09-06', '2018', '32160725', '03', '', 'Refer: 18128245', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3389, '2018-09-06', '2018', '32160725', '02', '', 'Refer: 17818228', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3390, '2018-09-06', '2018', '32160725', '01', '', 'Refer: 17528272', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3391, '2018-09-06', '2018', '31147357', '34', '', 'Refer: 17462206', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3395, '2018-09-06', '2018', '32162327', '01', '', 'Refer: 17528264', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3398, '2018-09-05', '2018', '42160969', '01', '', 'Refer: 17529238', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3399, '2018-09-05', '2018', '12184659', '01', '', 'Refer: 17528232', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3400, '2018-09-05', '2018', '12147436', '04', '', 'Refer: 18458295', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3401, '2018-09-05', '2018', '12147436', '03', '', 'Refer: 18128271', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3402, '2018-09-05', '2018', '12147436', '02', '', 'Refer: 17818254', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3403, '2018-09-05', '2018', '12147436', '01', '', 'Refer: 17528201', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3404, '2018-09-05', '2018', '32161173', '01', '', 'Refer: 17529245', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3405, '2018-09-05', '2018', '31161172', '01', '', 'Refer: 17529221', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3406, '2018-09-05', '2018', '31135966', '01', '', 'Refer: 17529201', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3407, '2018-09-05', '2018', '62184534', '01', '', 'Refer: 17528219', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3408, '2018-09-05', '2018', '32173498', '01', '', 'Refer: 17528231', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3409, '2018-09-05', '2018', '32184737', '01', '', 'Refer: 17529248', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3410, '2018-09-05', '2018', '52173020', '01', '', 'Refer: 17528212', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3411, '2018-09-04', '2018', '22184872', '01', '', 'Refer: 17526206', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3412, '2018-09-04', '2018', '42173361', '10', '', 'Refer: 20447262', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3413, '2018-09-04', '2018', '52185232', '34', '', 'Refer: 17427206', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3414, '2018-09-04', '2018', '22185231', '34', '', 'Refer: 17422273', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3415, '2018-09-04', '2017', '12124922', '99', '', 'Refer: 17651246', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3417, '2018-09-04', '2018', '32173048', '01', '', 'Refer: 17528292', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3418, '2018-09-04', '2018', '11135828', '09', '', 'Refer: 19986215', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3419, '2018-09-04', '2018', '11135828', '08', '', 'Refer: 19676225', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3420, '2018-09-04', '2018', '11135828', '07', '', 'Refer: 19366235', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3421, '2018-09-04', '2018', '11135828', '06', '', 'Refer: 19056245', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3422, '2018-09-04', '2018', '11135828', '05', '', 'Refer: 18746228', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3423, '2018-09-04', '2018', '11135828', '04', '', 'Refer: 18456272', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3424, '2018-09-04', '2018', '11135828', '03', '', 'Refer: 18126248', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3425, '2018-09-04', '2018', '11135828', '02', '', 'Refer: 17816231', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3426, '2018-09-04', '2018', '11135828', '01', '', 'Refer: 17526275', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3427, '2018-09-04', '2016', '12148424', '05', '', 'Refer: 17657256', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3428, '2018-09-04', '2016', '11089885', '05', '', 'Refer: 17657209', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3429, '2018-09-04', '2018', '12135996', '09', '', 'Refer: 19983275', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3430, '2018-09-04', '2018', '12135996', '08', '', 'Refer: 19673285', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3431, '2018-09-04', '2018', '12135996', '07', '', 'Refer: 19363295', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3432, '2018-09-04', '2018', '12135996', '06', '', 'Refer: 19053208', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3433, '2018-09-04', '2018', '12135996', '05', '', 'Refer: 18743288', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3434, '2018-09-04', '2018', '12135996', '04', '', 'Refer: 18453235', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3435, '2018-09-04', '2018', '12135996', '03', '', 'Refer: 18123211', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3436, '2018-09-04', '2018', '12135996', '02', '', 'Refer: 17813291', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3437, '2018-09-04', '2018', '12135996', '01', '', 'Refer: 17523238', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3438, '2018-09-04', '2018', '12172545', '99', '', 'Refer: 17657217', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3439, '2018-09-03', '20ID', 'EI RECIB', 'OI', '', 'Refer: NBURSA/0', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3441, '2018-09-03', '2018', '12160629', '99', '', 'Refer: 17657288', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3445, '2018-09-03', '2018', '12135763', '10', '', 'Refer: 20447247', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3446, '2018-09-03', '2018', '21161352', '01', '', 'Refer: 17525257', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3447, '2018-09-03', '20ID', 'EI RECIB', 'OS', '', 'Refer: ANTANDER', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3448, '2018-09-03', '2018', '11150487', '01', '', 'Refer: 17528251', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3449, '2018-09-03', '2018', '12159023', '01', '', 'Refer: 17529258', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL),
(3450, '2018-09-03', '2018', '22148310', '01', '', 'Refer: 17523257', 0.00, 0.00, 'N', 1, '2018-12-06 02:50:00', '2018-12-06 02:50:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` bigint(255) UNSIGNED NOT NULL COMMENT 'Identificador del empleado',
  `persona_id` bigint(255) UNSIGNED NOT NULL,
  `escuela_id` bigint(255) UNSIGNED NOT NULL,
  `empHorasCon` int(11) NOT NULL DEFAULT '0',
  `empPassword` varchar(191) DEFAULT NULL,
  `empCredencial` varchar(8) DEFAULT '' COMMENT 'Número de credencial',
  `empNomina` int(11) DEFAULT '0' COMMENT 'Identificador para el sistema de nóminas',
  `empRfc` varchar(13) NOT NULL DEFAULT '' COMMENT 'RFC del empleado',
  `empImss` varchar(11) DEFAULT '' COMMENT 'Número de IMSS',
  `empEstado` enum('A','B') DEFAULT 'A' COMMENT 'Estado del empleado Alta o Baja',
  `empFechaBaja` date DEFAULT NULL COMMENT 'Fecha en la que se da de Baja al empleado',
  `empCausaBaja` varchar(60) DEFAULT '' COMMENT 'Causa de la baja del empleado',
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `persona_id`, `escuela_id`, `empHorasCon`, `empPassword`, `empCredencial`, `empNomina`, `empRfc`, `empImss`, `empEstado`, `empFechaBaja`, `empCausaBaja`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 40, NULL, '', 0, '', '', 'A', NULL, '', 1, NULL, NULL, NULL),
(3, 3, 2, 30, '$2y$10$NSVwnn2d6MbaVTWhjpm9uOTRCKLlDx640G6ukpi3UxHNFbtZDbwlG', 'UNI00260', NULL, 'CECE691001UX8', NULL, 'A', NULL, '', 1, '2018-12-05 22:26:40', '2018-12-05 22:48:50', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escuelas`
--

CREATE TABLE `escuelas` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `departamento_id` bigint(255) UNSIGNED NOT NULL,
  `empleado_id` bigint(255) UNSIGNED NOT NULL,
  `escClave` char(3) NOT NULL COMMENT 'Clave única de la escuela',
  `escNombre` varchar(45) NOT NULL COMMENT 'Nombre real',
  `escNombreCorto` varchar(15) NOT NULL COMMENT 'Nombre corto',
  `escPorcExaPar` smallint(6) NOT NULL DEFAULT '70' COMMENT 'Porcentaje de los exámenes parciales para calificación final',
  `escPorcExaOrd` smallint(6) NOT NULL DEFAULT '30' COMMENT 'Porcentaje del Examen Ordinario para calificación final',
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catálogo de escuelas';

--
-- Volcado de datos para la tabla `escuelas`
--

INSERT INTO `escuelas` (`id`, `departamento_id`, `empleado_id`, `escClave`, `escNombre`, `escNombreCorto`, `escPorcExaPar`, `escPorcExaOrd`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'CCO', 'DEPARTAMENTO DE COMPUTO', 'COMPUTO', 70, 30, 1, NULL, NULL, NULL),
(2, 1, 3, 'ARQ', 'ARQUITECTURA', 'ARQUITECTURA', 70, 30, 1, '2018-12-05 22:43:37', '2018-12-05 22:43:37', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `pais_id` smallint(6) UNSIGNED NOT NULL,
  `edoNombre` varchar(30) NOT NULL,
  `edoAbrevia` varchar(10) NOT NULL,
  `edoRenapo` char(2) NOT NULL,
  `edoISO` char(3) NOT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Estados a los que puede pertenecer una escuela o persona';

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `pais_id`, `edoNombre`, `edoAbrevia`, `edoRenapo`, `edoISO`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'YUCATÁN', 'YUC', '', '', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas`
--

CREATE TABLE `fichas` (
  `id` bigint(255) UNSIGNED NOT NULL COMMENT 'folio_fic',
  `fchNumPer` smallint(6) DEFAULT NULL,
  `fchAnioPer` smallint(6) DEFAULT NULL,
  `fchClaveAlu` char(8) NOT NULL,
  `fchClaveCarr` char(3) DEFAULT NULL,
  `fchClaveProgAct` char(4) DEFAULT NULL,
  `fchGradoSem` smallint(6) DEFAULT NULL,
  `fchGrupo` char(1) DEFAULT NULL,
  `fchFechaImpr` date DEFAULT NULL,
  `fchHoraImpr` char(8) DEFAULT NULL,
  `fchUsuaImpr` char(8) DEFAULT NULL,
  `fchTipo` char(1) DEFAULT NULL,
  `fchConc` char(2) DEFAULT NULL,
  `fchFechaVenc1` date DEFAULT NULL,
  `fhcImp1` double(8,2) DEFAULT NULL,
  `fhcRef1` char(20) DEFAULT NULL,
  `fchFechaVenc2` date DEFAULT NULL,
  `fhcImp2` double(8,2) DEFAULT NULL,
  `fhcRef2` char(20) DEFAULT NULL,
  `fchEstado` char(1) DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `materia_id` bigint(255) UNSIGNED NOT NULL,
  `plan_id` bigint(255) UNSIGNED NOT NULL,
  `periodo_id` bigint(255) UNSIGNED NOT NULL,
  `gpoSemestre` smallint(6) NOT NULL,
  `gpoClave` char(3) NOT NULL,
  `gpoTurno` char(1) NOT NULL,
  `empleado_id` bigint(255) UNSIGNED NOT NULL,
  `empleado_sinodal_id` bigint(255) UNSIGNED DEFAULT NULL,
  `gpoMatClaveComplementaria` varchar(30) DEFAULT NULL,
  `gpoFechaExamenOrdinario` date DEFAULT NULL,
  `gpoHoraExamenOrdinario` time DEFAULT NULL,
  `gpoCupo` smallint(6) DEFAULT '0',
  `gpoNumeroFolio` varchar(6) DEFAULT NULL,
  `gpoNumeroActa` varchar(6) DEFAULT NULL,
  `gpoNumeroLibro` varchar(6) DEFAULT NULL,
  `grupo_equivalente_id` bigint(255) UNSIGNED DEFAULT NULL,
  `optativa_id` bigint(255) UNSIGNED DEFAULT NULL,
  `estado_act` char(1) DEFAULT 'A' COMMENT 'A = Abierto sin calificaciones\nB = Abierto pero calificado\nC = Cerrado',
  `fecha_mov_ord_act` date DEFAULT NULL,
  `clave_actv` char(2) DEFAULT NULL COMMENT 'SO = Solicitud de ordinario\nIO = Inscripción a ordinario\nAO = Actas de ordinario',
  `usuario_at` bigint(255) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `materia_id`, `plan_id`, `periodo_id`, `gpoSemestre`, `gpoClave`, `gpoTurno`, `empleado_id`, `empleado_sinodal_id`, `gpoMatClaveComplementaria`, `gpoFechaExamenOrdinario`, `gpoHoraExamenOrdinario`, `gpoCupo`, `gpoNumeroFolio`, `gpoNumeroActa`, `gpoNumeroLibro`, `grupo_equivalente_id`, `optativa_id`, `estado_act`, `fecha_mov_ord_act`, `clave_actv`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 2, 1, 'C', 'M', 3, NULL, NULL, '2018-12-10', '09:00:00', 25, NULL, NULL, NULL, NULL, NULL, 'A', NULL, NULL, 3, '2018-12-05 23:46:14', '2018-12-05 23:46:14', NULL),
(2, 2, 1, 2, 1, 'C', 'M', 3, NULL, NULL, '2018-12-11', '09:00:00', 25, NULL, NULL, NULL, NULL, NULL, 'A', NULL, NULL, 3, '2018-12-05 23:47:16', '2018-12-05 23:47:16', NULL),
(3, 3, 1, 2, 1, 'C', 'M', 3, NULL, NULL, '2018-12-12', '11:00:00', NULL, NULL, NULL, NULL, NULL, NULL, 'A', NULL, NULL, 3, '2018-12-05 23:47:50', '2018-12-05 23:47:50', NULL);

--
-- Disparadores `grupos`
--
DELIMITER $$
CREATE TRIGGER `grupos_BEFORE_INSERT` BEFORE INSERT ON `grupos` FOR EACH ROW BEGIN
	IF (NEW.gpoFechaExamenOrdinario =  "") THEN
		SET NEW.gpoFechaExamenOrdinario = NULL;
    END IF;
    IF (NEW.gpoHoraExamenOrdinario =  "") THEN
		SET NEW.gpoHoraExamenOrdinario = NULL;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico`
--

CREATE TABLE `historico` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `inscrito_id` bigint(255) UNSIGNED NOT NULL,
  `histNombreComplementario` varchar(30) DEFAULT NULL,
  `histPeriodoAcreditado` char(2) NOT NULL,
  `histTipoAcreditado` char(2) NOT NULL,
  `histFechaExamen` date NOT NULL,
  `histCalificacion` smallint(6) DEFAULT NULL,
  `histFolio` varchar(6) DEFAULT NULL,
  `hisActa` varchar(6) DEFAULT NULL,
  `histLibro` varchar(6) DEFAULT NULL,
  `histNombreOficial` varchar(78) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id` bigint(255) NOT NULL,
  `grupo_id` bigint(255) UNSIGNED NOT NULL,
  `aula_id` bigint(255) UNSIGNED NOT NULL,
  `ghDia` smallint(1) NOT NULL,
  `ghInicio` smallint(2) NOT NULL,
  `ghFinal` smallint(2) NOT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `idiomas`
--

CREATE TABLE `idiomas` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `curNumPer` smallint(6) NOT NULL,
  `curAnioPer` smallint(6) NOT NULL,
  `curClaveAlu` char(8) NOT NULL,
  `curClaveCarrera` char(3) NOT NULL,
  `curClavePlan` char(4) DEFAULT NULL,
  `curGradoSemestre` smallint(6) DEFAULT NULL,
  `curGrupo` char(3) DEFAULT NULL,
  `curFechaReg` date DEFAULT NULL,
  `curFechaBaja` date DEFAULT NULL,
  `curEstado` char(1) DEFAULT NULL,
  `curImporteInsc` double(8,2) DEFAULT NULL,
  `curImporteMens` double(8,2) DEFAULT NULL,
  `curUsuarioCuota` char(8) DEFAULT NULL,
  `curFechaCuota` date DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscProg`
--

CREATE TABLE `inscProg` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `inscClaveAlu` char(8) NOT NULL,
  `inscNumIdProg` char(3) NOT NULL,
  `inscClaveGrupo` char(4) DEFAULT NULL,
  `inscFechaRegistro` date DEFAULT NULL,
  `inscFechaBaja` date DEFAULT NULL,
  `inscEstado` char(1) DEFAULT NULL,
  `inscImportePago` double(8,2) DEFAULT NULL,
  `inscUsuaOperRegistro` int(10) DEFAULT NULL,
  `inscFechaOperRegistro` timestamp NULL DEFAULT NULL,
  `inscUsuaOperBaja` int(10) DEFAULT NULL,
  `inscFechaOperBaja` timestamp NULL DEFAULT NULL,
  `inscNumero` char(2) DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscritos`
--

CREATE TABLE `inscritos` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `curso_id` bigint(255) UNSIGNED NOT NULL,
  `grupo_id` bigint(255) UNSIGNED NOT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Disparadores `inscritos`
--
DELIMITER $$
CREATE TRIGGER `inscritos_BEFORE_INSERT` BEFORE INSERT ON `inscritos` FOR EACH ROW BEGIN
declare reprobado bool;
declare total_prerequisitos int;
declare total_aprobados int;
declare mensaje char(30);

set total_prerequisitos = 0;
set reprobado = false;
set mensaje = 'Debe materias de prerequisito';

select count(*)
into total_prerequisitos
from grupos as gpo
inner join materias as mat
	on gpo.materia_id = mat.id
inner join prerequisitos as pre
	on mat.id = pre.materia_id
where gpo.id = new.grupo_id;

if (total_prerequisitos > 0) then
	select count(*)
    into total_aprobados
	from vwhistoricosaprobados as hist
	inner join cursos as cur
		on hist.alumno = cur.alumno_id
		and cur.id = new.curso_id #el curso al que pertenece el alumno
	inner join prerequisitos as pre
		on hist.materia = pre.materia_prerequisito_id
	inner join materias as mat
		on pre.materia_id = mat.id
	inner join grupos as gpo
		on mat.id = gpo.materia_id
		and gpo.id = new.grupo_id #el grupo al que se quiere inscribir
	where hist.aprobado like 'A';
	set reprobado = true;
    
    if (total_aprobados < total_prerequisitos) then
		signal sqlstate '45000' set message_text = mensaje;
    end if;
end if;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `plan_id` bigint(255) UNSIGNED NOT NULL,
  `matClave` varchar(15) NOT NULL COMMENT 'Clave de la materia',
  `matNombre` varchar(60) NOT NULL COMMENT 'Nombre completo',
  `matNombreCorto` varchar(15) NOT NULL COMMENT 'Nombre corto',
  `matSemestre` tinyint(2) DEFAULT NULL COMMENT 'Semestre o período al que pertenece la materia',
  `matCreditos` tinyint(3) DEFAULT NULL COMMENT 'Valor en créditos. Para propedéutico es el número de pago del curso.',
  `matClasificacion` enum('B','O','U','X','C') DEFAULT 'B' COMMENT 'Clasificación de la materia',
  `matEspecialidad` char(3) DEFAULT NULL COMMENT 'Vertiente o especialidad al que pertenece',
  `matTipoAcreditacion` enum('N','A','M') DEFAULT 'N' COMMENT 'Tipo de Acreditación: Númerica, alfabética o mixta.',
  `matPorcentajeParcial` smallint(6) DEFAULT NULL COMMENT 'Porcentaje de la calificación total que se asigna a exámenes parciales',
  `matPorcentajeOrdinario` smallint(6) DEFAULT NULL COMMENT 'Porcentaje de la calificación total que se asigna al examen ordinario',
  `matNombreOficial` varchar(78) DEFAULT NULL COMMENT 'Nombre oficial de la materia',
  `matOrdenVisual` int(3) DEFAULT NULL,
  `matClaveEquivalente` varchar(12) DEFAULT NULL COMMENT 'Materia equivalente',
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catálogo de materias';

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `plan_id`, `matClave`, `matNombre`, `matNombreCorto`, `matSemestre`, `matCreditos`, `matClasificacion`, `matEspecialidad`, `matTipoAcreditacion`, `matPorcentajeParcial`, `matPorcentajeOrdinario`, `matNombreOficial`, `matOrdenVisual`, `matClaveEquivalente`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '17111', 'TALLER DE COMPOSICIÓN I', 'T. COMPO. I', 1, 18, 'B', NULL, 'N', 70, 30, NULL, NULL, NULL, 1, '2018-12-05 23:14:57', '2018-12-05 23:14:57', NULL),
(2, 1, '17121', 'ESTÁTICA', 'ESTÁTICA', 1, 6, 'B', NULL, 'N', 70, 30, NULL, NULL, NULL, 1, '2018-12-05 23:17:40', '2018-12-05 23:17:40', NULL),
(3, 1, '17131', 'REPRESENTACIÓN ARQUITECTÓNICA I', 'REP. ARQ. I', 1, 6, 'B', NULL, 'N', 70, 30, NULL, NULL, NULL, 3, '2018-12-05 23:19:32', '2018-12-05 23:19:32', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modules`
--

CREATE TABLE `modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `modules`
--

INSERT INTO `modules` (`id`, `name`, `slug`, `class`, `created_at`, `updated_at`) VALUES
(1, 'Usuarios', 'usuario', 'Administración', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(2, 'Campus', 'ubicacion', 'Catálogos', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(3, 'Departamentos', 'departamento', 'Catálogos', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(4, 'Escuelas', 'escuela', 'Catálogos', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(5, 'Programas', 'programa', 'Catálogos', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(6, 'Planes', 'plan', 'Catálogos', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(7, 'Periodos', 'periodo', 'Catálogos', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(8, 'Acuerdos', 'acuerdo', 'Catálogos', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(9, 'Materias', 'materia', 'Catálogos', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(10, 'Optativas', 'optativa', 'Catálogos', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(11, 'Aulas', 'aula', 'Catálogos', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(12, 'Paises', 'pais', 'Catálogos', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(13, 'Estados', 'estado', 'Catálogos', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(14, 'Municipios', 'municipio', 'Catálogos', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(15, 'Empleados', 'empleado', 'Control-Escolar', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(16, 'Alumnos', 'alumno', 'Control-Escolar', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(17, 'CGTS', 'cgt', 'Control-Escolar', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(18, 'Grupos', 'grupo', 'Control-Escolar', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(19, 'Calificaciones', 'calificacion', 'Control-Escolar', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(20, 'Paquetes', 'paquete', 'Control-Escolar', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(21, 'Preinscritos', 'curso', 'Control-Escolar', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(22, 'Inscritos', 'inscrito', 'Control-Escolar', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(23, 'Reporte inscritos y preinscritos', 'r_inscrito_preinscrito', 'Reportes', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(24, 'Lista de asistencia por grupo', 'r_asistencia_grupo', 'Reportes', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(25, 'Constancia de inscripción', 'r_constancia_inscripcion', 'Reportes', '2018-12-05 22:18:13', '2018-12-05 22:18:13'),
(26, 'Aplica Pagos', 'p_pago', 'Procesos', '2018-12-05 22:18:13', '2018-12-05 22:18:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id` smallint(6) UNSIGNED NOT NULL COMMENT 'Identificador de Municipio',
  `estado_id` smallint(6) UNSIGNED NOT NULL COMMENT 'Estado al que pertenece',
  `munNombre` varchar(50) NOT NULL DEFAULT '*No asignado*.' COMMENT 'Nombre del municipio',
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catálogo de Municipios de México. También se incluyen algunos de otros países.';

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id`, `estado_id`, `munNombre`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'MÉRIDA', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `optativas`
--

CREATE TABLE `optativas` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `materia_id` bigint(255) UNSIGNED NOT NULL,
  `optNumero` smallint(2) NOT NULL,
  `optClaveGenerica` varchar(15) NOT NULL,
  `optClaveEspecifica` varchar(25) NOT NULL,
  `optNombre` varchar(255) NOT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `pagClaveAlu` char(8) NOT NULL,
  `pagAnioPer` smallint(6) NOT NULL,
  `pagConcPago` char(2) NOT NULL,
  `pagFechaPago` date NOT NULL,
  `pagImpPago` double(8,2) DEFAULT NULL,
  `pagRefPago` char(5) DEFAULT NULL,
  `pagDigVer` char(1) DEFAULT NULL,
  `pagEstado` char(1) DEFAULT NULL,
  `pagObservacion` char(1) DEFAULT NULL,
  `pagFormaAplico` char(1) DEFAULT NULL,
  `pagComentario` char(78) DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `id` smallint(6) UNSIGNED NOT NULL COMMENT 'Identificador',
  `paisNombre` varchar(50) NOT NULL COMMENT 'Nombre conocido del país',
  `paisAbrevia` varchar(5) NOT NULL COMMENT 'Abreviatura del país',
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catálogo de Países de registro';

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `paisNombre`, `paisAbrevia`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'MÉXICO', '', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

CREATE TABLE `paquetes` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `periodo_id` bigint(255) UNSIGNED NOT NULL,
  `plan_id` bigint(255) UNSIGNED NOT NULL,
  `semestre` tinyint(2) UNSIGNED NOT NULL,
  `consecutivo` tinyint(3) UNSIGNED NOT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquete_detalle`
--

CREATE TABLE `paquete_detalle` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `paquete_id` bigint(255) UNSIGNED NOT NULL,
  `grupo_id` bigint(255) UNSIGNED NOT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos`
--

CREATE TABLE `periodos` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `departamento_id` bigint(255) UNSIGNED NOT NULL,
  `perNumero` smallint(1) NOT NULL,
  `perAnio` smallint(4) NOT NULL,
  `perFechaInicial` date NOT NULL,
  `perFechaFinal` date NOT NULL,
  `perEstado` char(1) DEFAULT 'A',
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `periodos`
--

INSERT INTO `periodos` (`id`, `departamento_id`, `perNumero`, `perAnio`, `perFechaInicial`, `perFechaFinal`, `perEstado`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 2018, '2018-01-01', '2018-06-30', 'A', 1, NULL, NULL, NULL),
(2, 1, 3, 2018, '2018-08-26', '2018-12-15', 'A', 1, NULL, NULL, NULL),
(3, 1, 1, 2019, '2019-01-07', '2019-06-30', 'A', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_programas_user`
--

CREATE TABLE `permisos_programas_user` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `programa_id` bigint(255) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permisos_programas_user`
--

INSERT INTO `permisos_programas_user` (`id`, `user_id`, `programa_id`, `created_at`, `updated_at`) VALUES
(2, 3, 1, '2018-12-05 22:58:14', '2018-12-05 22:58:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'A', 'super', 'Administrador del sistema', '2018-12-05 22:18:17', '2018-12-05 22:18:17'),
(2, 'B', 'master', 'Administrador del datos', '2018-12-05 22:18:17', '2018-12-05 22:18:17'),
(3, 'C', 'admin', 'Coordinadores y Directores', '2018-12-05 22:18:17', '2018-12-05 22:18:17'),
(4, 'D', 'user', 'Consultas', '2018-12-05 22:18:17', '2018-12-05 22:18:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_module_user`
--

CREATE TABLE `permission_module_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `module_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permission_module_user`
--

INSERT INTO `permission_module_user` (`id`, `permission_id`, `module_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(2, 1, 2, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(3, 1, 3, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(4, 1, 4, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(5, 1, 5, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(6, 1, 6, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(7, 1, 7, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(8, 1, 8, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(9, 1, 9, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(10, 1, 10, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(11, 1, 11, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(12, 1, 12, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(13, 1, 13, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(14, 1, 14, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(15, 1, 15, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(16, 1, 16, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(17, 1, 17, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(18, 1, 18, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(19, 1, 19, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(20, 1, 20, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(21, 1, 21, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(22, 1, 22, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(23, 1, 23, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(24, 1, 24, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(25, 1, 25, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(26, 1, 26, 1, '2018-12-05 22:18:20', '2018-12-05 22:18:20'),
(53, 4, 1, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(54, 4, 2, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(55, 4, 3, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(56, 4, 4, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(57, 4, 5, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(58, 4, 6, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(59, 4, 7, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(60, 4, 8, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(61, 3, 9, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(62, 3, 10, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(63, 3, 11, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(64, 4, 12, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(65, 4, 13, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(66, 4, 14, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(67, 4, 15, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(68, 3, 16, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(69, 3, 17, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(70, 3, 18, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(71, 3, 19, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(72, 3, 20, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(73, 3, 21, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(74, 3, 22, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(75, 3, 23, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(76, 3, 24, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(77, 3, 25, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14'),
(78, 4, 26, 3, '2018-12-05 22:58:14', '2018-12-05 22:58:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `perCurp` varchar(18) NOT NULL COMMENT 'Clave única de registro de población (CURP)',
  `perApellido1` varchar(30) NOT NULL COMMENT 'Primer apellido o Apellido paterno',
  `perApellido2` varchar(30) DEFAULT NULL COMMENT 'Segundo apellido o Apellido materno',
  `perNombre` varchar(40) NOT NULL COMMENT 'Nombre de la persona',
  `perFechaNac` date NOT NULL COMMENT 'Fecha de nacimiento de la persona',
  `municipio_id` smallint(6) NOT NULL COMMENT 'Municipio de Nacimiento',
  `perSexo` enum('F','M') NOT NULL COMMENT 'Sexo o género de la pesona',
  `perCorreo1` varchar(60) DEFAULT NULL COMMENT 'Correo electrónico',
  `perTelefono1` varchar(10) DEFAULT NULL COMMENT 'Teléfono de contacto',
  `perTelefono2` varchar(10) DEFAULT NULL COMMENT 'Teléfono alternativo de contacto',
  `perDirCP` int(5) UNSIGNED NOT NULL COMMENT 'Código Postal',
  `perDirCalle` varchar(25) NOT NULL COMMENT 'Dirección: Calle',
  `perDirNumInt` varchar(6) DEFAULT NULL COMMENT 'Dirección: Número interior',
  `perDirNumExt` varchar(6) NOT NULL COMMENT 'Dirección: Número exterior',
  `perDirColonia` varchar(60) NOT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Personas en general';

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `perCurp`, `perApellido1`, `perApellido2`, `perNombre`, `perFechaNac`, `municipio_id`, `perSexo`, `perCorreo1`, `perTelefono1`, `perTelefono2`, `perDirCP`, `perDirCalle`, `perDirNumInt`, `perDirNumExt`, `perDirColonia`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'PAMI870806HYNRRS07', 'PAREDES', 'MORENO', 'ISMAEL ALBERTO', '1987-08-06', 1, 'M', 'ismaelparedes@modelo.edu.mx', '9993729437', NULL, 97130, 'CALLE 1 X 10 Y 14', NULL, '319', 'VISTA ALEGRE NORTE', 1, NULL, NULL, NULL),
(3, 'CECE691001HQRRHD02', 'CERON', 'CHAVEZ', 'JOSE EDUARDO', '1969-10-01', 1, 'M', NULL, NULL, '9813267', 97200, '19E X 32', NULL, '285', 'TULIAS CHUBURNA', 1, '2018-12-05 22:26:40', '2018-12-05 22:48:50', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes`
--

CREATE TABLE `planes` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `programa_id` bigint(255) UNSIGNED NOT NULL,
  `planClave` varchar(4) NOT NULL,
  `planPeriodos` tinyint(2) NOT NULL COMMENT 'Cantidad de períodos',
  `planNumCreditos` smallint(6) NOT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catálogo de planes escolares';

--
-- Volcado de datos para la tabla `planes`
--

INSERT INTO `planes` (`id`, `programa_id`, `planClave`, `planPeriodos`, `planNumCreditos`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2016', 10, 0, 1, '2018-12-05 23:04:40', '2018-12-05 23:04:40', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prerequisitos`
--

CREATE TABLE `prerequisitos` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `materia_id` bigint(255) UNSIGNED NOT NULL,
  `materia_prerequisito_id` bigint(255) UNSIGNED NOT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE `programas` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `escuela_id` bigint(255) UNSIGNED NOT NULL,
  `empleado_id` bigint(255) UNSIGNED NOT NULL,
  `progClave` char(3) NOT NULL COMMENT 'Calve del programa',
  `progNombre` varchar(45) NOT NULL COMMENT 'Nombre real',
  `progNombreCorto` varchar(15) NOT NULL COMMENT 'Nombre corto',
  `progClaveSegey` smallint(6) DEFAULT NULL COMMENT 'Clave oficial ante la SEGEY',
  `progClaveEgre` varchar(20) DEFAULT NULL COMMENT 'Clave de Egreso ante la SEGEY',
  `progTituloOficial` varchar(78) DEFAULT NULL COMMENT 'Nombre completo en el título',
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catálogo de programas educativos';

--
-- Volcado de datos para la tabla `programas`
--

INSERT INTO `programas` (`id`, `escuela_id`, `empleado_id`, `progClave`, `progNombre`, `progNombreCorto`, `progClaveSegey`, `progClaveEgre`, `progTituloOficial`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 3, 'AXX', 'ARQUITECTURA', 'ARQUITECTURA', NULL, NULL, 'Licenciatura en Arquitectura', 1, '2018-12-05 22:45:12', '2018-12-05 22:45:12', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referencias`
--

CREATE TABLE `referencias` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `alumno_id` bigint(255) UNSIGNED NOT NULL,
  `programa_id` bigint(255) UNSIGNED NOT NULL,
  `refNum` char(4) NOT NULL,
  `refAnioPer` smallint(4) NOT NULL,
  `refConcPago` char(2) NOT NULL,
  `refFechaVenc` date NOT NULL,
  `refImpTotal` decimal(8,2) NOT NULL,
  `refImpConc` decimal(8,2) DEFAULT NULL,
  `refImpBeca` decimal(8,2) DEFAULT NULL,
  `refImpPP` decimal(8,2) DEFAULT NULL,
  `refImpAntCred` decimal(8,2) DEFAULT NULL,
  `refImpRecar` decimal(8,2) DEFAULT NULL,
  `refUsuarioAplico` int(10) UNSIGNED DEFAULT NULL,
  `refFechaAplico` timestamp NULL DEFAULT NULL,
  `refEstado` char(1) DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `id` bigint(255) UNSIGNED NOT NULL COMMENT 'identificador Numérico',
  `ubiClave` char(3) NOT NULL COMMENT 'Clave alfabetica',
  `ubiNombre` varchar(50) DEFAULT NULL COMMENT 'Nombre a mostrar',
  `ubiCalle` varchar(30) DEFAULT NULL COMMENT 'Calle',
  `ubiCP` varchar(30) DEFAULT NULL COMMENT 'Código Postal',
  `municipio_id` smallint(6) UNSIGNED NOT NULL COMMENT 'Población',
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`id`, `ubiClave`, `ubiNombre`, `ubiCalle`, `ubiCP`, `municipio_id`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'CME', 'CAMPUS MERIDA CHOLUL', NULL, NULL, 1, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `empleado_id` bigint(255) UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `empleado_id`, `username`, `password`, `remember_token`, `token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'ISMAEL', '$2y$10$gbtZqFVbUVtd9tCjvKxldOBmbmaBhe7uWQOZ3X2iKvrGrsPxIUscm', '0lg4ah6945w6VRMwCXRM2RkpOgPMufgEte2XBjaaX6St3idYOgYCqXu42Xjn', '', NULL, NULL, NULL),
(3, 3, 'ECERON', '$2y$10$uFpFxqVBCe/Sbsd36oxQ.O7RhJigIx5n1OkJwUMtGiS2o39rq1DoG', 'AKutJYOmUe9YrCmz6jCP2JlIlf5Yc50T5PFLnxgirdg0gM41eeTH7DG8Ml4a', 'jPD244U8tNCMirWgPomeF75G87lEpWNXlKdfzXlxoCAqTN6qD7QTzjIKQVI0mBeU', '2018-12-05 22:58:13', '2018-12-05 22:58:13', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuaGim`
--

CREATE TABLE `usuaGim` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `alumno_id` bigint(255) UNSIGNED DEFAULT NULL,
  `gimApellidoPaterno` char(30) DEFAULT NULL,
  `gimApellidoMaterno` char(30) DEFAULT NULL,
  `gimNombre` char(30) DEFAULT NULL,
  `gimTipo` char(3) DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vwhistoricosaprobados`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vwhistoricosaprobados` (
`alumno` bigint(255) unsigned
,`materia` bigint(255) unsigned
,`matnombre` varchar(60)
,`matTipoAcreditacion` varchar(1)
,`histCalificacion` smallint(6)
,`depCalMinAprob` tinyint(4)
,`aprobado` varchar(1)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vwhistoricosaprobados`
--
DROP TABLE IF EXISTS `vwhistoricosaprobados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vwhistoricosaprobados`  AS  select `cur`.`alumno_id` AS `alumno`,`mat`.`id` AS `materia`,`mat`.`matNombre` AS `matnombre`,`mat`.`matTipoAcreditacion` AS `matTipoAcreditacion`,`his`.`histCalificacion` AS `histCalificacion`,`dep`.`depCalMinAprob` AS `depCalMinAprob`,if((`his`.`histCalificacion` >= `dep`.`depCalMinAprob`),'A','R') AS `aprobado` from ((((((((`historico` `his` join `inscritos` `insc` on((`his`.`inscrito_id` = `insc`.`id`))) join `cursos` `cur` on((`insc`.`curso_id` = `cur`.`id`))) join `grupos` `gru` on((`insc`.`grupo_id` = `gru`.`id`))) join `materias` `mat` on((`gru`.`materia_id` = `mat`.`id`))) join `planes` `plan` on((`mat`.`plan_id` = `plan`.`id`))) join `programas` `prog` on((`plan`.`programa_id` = `prog`.`id`))) join `escuelas` `esc` on((`prog`.`escuela_id` = `esc`.`id`))) join `departamentos` `dep` on((`esc`.`departamento_id` = `dep`.`id`))) where ((`mat`.`matTipoAcreditacion` like 'N') and (`his`.`histPeriodoAcreditado` not in ('RV','RC'))) union select `cur`.`alumno_id` AS `alumno`,`mat`.`id` AS `materia`,`mat`.`matNombre` AS `matnombre`,`mat`.`matTipoAcreditacion` AS `matTipoAcreditacion`,`his`.`histCalificacion` AS `histCalificacion`,`dep`.`depCalMinAprob` AS `depCalMinAprob`,if((`his`.`histCalificacion` = 0),'A','R') AS `aprobado` from ((((((((`historico` `his` join `inscritos` `insc` on((`his`.`inscrito_id` = `insc`.`id`))) join `cursos` `cur` on((`insc`.`curso_id` = `cur`.`id`))) join `grupos` `gru` on((`insc`.`grupo_id` = `gru`.`id`))) join `materias` `mat` on((`gru`.`materia_id` = `mat`.`id`))) join `planes` `plan` on((`mat`.`plan_id` = `plan`.`id`))) join `programas` `prog` on((`plan`.`programa_id` = `prog`.`id`))) join `escuelas` `esc` on((`prog`.`escuela_id` = `esc`.`id`))) join `departamentos` `dep` on((`esc`.`departamento_id` = `dep`.`id`))) where ((`mat`.`matTipoAcreditacion` like 'A') and (`his`.`histPeriodoAcreditado` not in ('RV','RC'))) union select `cur`.`alumno_id` AS `alumno`,`mat`.`id` AS `materia`,`mat`.`matNombre` AS `matnombre`,`mat`.`matTipoAcreditacion` AS `matTipoAcreditacion`,`his`.`histCalificacion` AS `histCalificacion`,`dep`.`depCalMinAprob` AS `depCalMinAprob`,'A' AS `aprobado` from ((((((((`historico` `his` join `inscritos` `insc` on((`his`.`inscrito_id` = `insc`.`id`))) join `cursos` `cur` on((`insc`.`curso_id` = `cur`.`id`))) join `grupos` `gru` on((`insc`.`grupo_id` = `gru`.`id`))) join `materias` `mat` on((`gru`.`materia_id` = `mat`.`id`))) join `planes` `plan` on((`mat`.`plan_id` = `plan`.`id`))) join `programas` `prog` on((`plan`.`programa_id` = `prog`.`id`))) join `escuelas` `esc` on((`prog`.`escuela_id` = `esc`.`id`))) join `departamentos` `dep` on((`esc`.`departamento_id` = `dep`.`id`))) where (`his`.`histPeriodoAcreditado` in ('RV','RC')) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acuerdos`
--
ALTER TABLE `acuerdos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_plan_unique` (`plan_id`,`deleted_at`),
  ADD KEY `fk_acuerdos_plan_idx` (`plan_id`);

--
-- Indices de la tabla `aextra`
--
ALTER TABLE `aextra`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_aextra_unico` (`curNumPer`,`curAnioPer`,`curClaveAlu`,`curClaveCarrera`,`deleted_at`);

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `persona_id_UNIQUE` (`persona_id`,`deleted_at`),
  ADD UNIQUE KEY `aluClave_UNIQUE` (`aluClave`,`deleted_at`),
  ADD KEY `fk_alumno_persona_idx` (`persona_id`);

--
-- Indices de la tabla `aulas`
--
ALTER TABLE `aulas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `aula_unique` (`ubicacion_id`,`aulaClave`,`deleted_at`);

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inscrito_id_UNIQUE` (`inscrito_id`),
  ADD KEY `fk_inscrito_idx` (`inscrito_id`);

--
-- Indices de la tabla `cgt`
--
ALTER TABLE `cgt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_cgt` (`plan_id`,`periodo_id`,`cgtGradoSemestre`,`cgtGrupo`,`cgtTurno`,`deleted_at`),
  ADD KEY `fk_cgt_plan_idx` (`plan_id`),
  ADD KEY `fk_cgt_usuario_at_idx` (`usuario_at`),
  ADD KEY `fk_cgt_periodo_idx` (`periodo_id`);

--
-- Indices de la tabla `concAextra`
--
ALTER TABLE `concAextra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_cuota_unica` (`cuoTipo`,`dep_esc_prog_id`,`cuoAnio`,`deleted_at`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_cursos_unique` (`alumno_id`,`periodo_id`,`deleted_at`),
  ADD KEY `fk_curso_alumno_idx` (`alumno_id`),
  ADD KEY `fk_curso_cgt_idx` (`cgt_id`),
  ADD KEY `fk_curso_periodo_idx` (`periodo_id`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `depClave_UNIQUE` (`depClave`,`deleted_at`),
  ADD KEY `fk_departamento_actual_idx` (`perActual`),
  ADD KEY `fk_departamento_ubicacion_idx` (`ubicacion_id`);

--
-- Indices de la tabla `edocta`
--
ALTER TABLE `edocta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_edocta_unico` (`edoFechaOper`,`edoClaveAlu`,`edoMesPago`,`edoDigPago`,`edoImpAbono`,`edoImpCargo`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `empRfc_UNIQUE` (`empRfc`,`deleted_at`),
  ADD UNIQUE KEY `empNomina_UNIQUE` (`empNomina`,`deleted_at`),
  ADD UNIQUE KEY `empCredencial_UNIQUE` (`empCredencial`,`deleted_at`),
  ADD UNIQUE KEY `empPersona` (`persona_id`,`deleted_at`),
  ADD KEY `dk_empleado_persona_idx` (`persona_id`),
  ADD KEY `dk_empleado_escuela_idx` (`escuela_id`);

--
-- Indices de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `escClave_UNIQUE` (`escClave`,`deleted_at`),
  ADD KEY `fk_escuela_departamento_idx` (`departamento_id`),
  ADD KEY `fk_escuela_empleado_idx` (`empleado_id`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_estado_pais_idx` (`pais_id`);

--
-- Indices de la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_grupo_unico` (`materia_id`,`plan_id`,`periodo_id`,`gpoSemestre`,`gpoClave`,`gpoTurno`),
  ADD KEY `fk_grupo_empleado_idx` (`empleado_id`),
  ADD KEY `fk_grupo_sinodal_idx` (`empleado_sinodal_id`),
  ADD KEY `fk_grupo_optativa_idx` (`optativa_id`),
  ADD KEY `fk_grupo_materia_idx` (`materia_id`),
  ADD KEY `fk_grupo_periodo_idx` (`periodo_id`),
  ADD KEY `fk_grupo_plan_idx` (`plan_id`);

--
-- Indices de la tabla `historico`
--
ALTER TABLE `historico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_historico_inscrito_idx` (`inscrito_id`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_horario_aula` (`aula_id`,`ghDia`,`ghInicio`,`deleted_at`),
  ADD UNIQUE KEY `fk_horario_grupo` (`grupo_id`,`ghDia`,`ghInicio`,`deleted_at`),
  ADD KEY `fk_horario_aula_idx` (`aula_id`);

--
-- Indices de la tabla `idiomas`
--
ALTER TABLE `idiomas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_idioma_unico` (`curNumPer`,`curAnioPer`,`curClaveAlu`,`curClaveCarrera`,`deleted_at`);

--
-- Indices de la tabla `inscProg`
--
ALTER TABLE `inscProg`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_insc_prog_unico` (`inscClaveAlu`,`inscNumero`,`deleted_at`);

--
-- Indices de la tabla `inscritos`
--
ALTER TABLE `inscritos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_inscrito_unique` (`curso_id`,`grupo_id`,`deleted_at`),
  ADD KEY `fk_inscrito_curso_idx` (`curso_id`),
  ADD KEY `fk_inscrito_grupo_idx` (`grupo_id`,`deleted_at`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matClave_UNIQUE` (`matClave`,`deleted_at`),
  ADD KEY `fk_materia_plan_idx` (`plan_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `modules_slug_unique` (`slug`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_municipio_estado_idx` (`estado_id`);

--
-- Indices de la tabla `optativas`
--
ALTER TABLE `optativas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_optativa_unique` (`materia_id`,`deleted_at`,`optClaveEspecifica`),
  ADD KEY `fk_optativa_materia_idx` (`materia_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_paquete_unique` (`periodo_id`,`plan_id`,`deleted_at`,`semestre`,`consecutivo`),
  ADD KEY `fk_paquete_plan_idx` (`plan_id`);

--
-- Indices de la tabla `paquete_detalle`
--
ALTER TABLE `paquete_detalle`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_paquete_detalle_unique` (`paquete_id`,`grupo_id`,`deleted_at`),
  ADD KEY `fk_paquete_detalle_grupo_idx` (`grupo_id`);

--
-- Indices de la tabla `periodos`
--
ALTER TABLE `periodos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_periodo_unique` (`departamento_id`,`perNumero`,`perAnio`,`deleted_at`),
  ADD KEY `fk_periodo_departamento_idx` (`departamento_id`);

--
-- Indices de la tabla `permisos_programas_user`
--
ALTER TABLE `permisos_programas_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_permiso_programa_user_idx` (`user_id`),
  ADD KEY `fk_permiso_programa_idx` (`programa_id`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_slug_unique` (`slug`);

--
-- Indices de la tabla `permission_module_user`
--
ALTER TABLE `permission_module_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_module_user_permission_id_index` (`permission_id`),
  ADD KEY `permission_module_user_module_id_index` (`module_id`),
  ADD KEY `permission_module_user_user_id_index` (`user_id`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_planes_unique` (`programa_id`,`planClave`,`deleted_at`),
  ADD KEY `fk_planes_programa_idx` (`programa_id`);

--
-- Indices de la tabla `prerequisitos`
--
ALTER TABLE `prerequisitos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_prerequisito_unique` (`materia_id`,`materia_prerequisito_id`,`deleted_at`),
  ADD KEY `fk_prerequisito_materia_idx` (`materia_id`),
  ADD KEY `fk_prerequisito_materia2_idx` (`materia_prerequisito_id`);

--
-- Indices de la tabla `programas`
--
ALTER TABLE `programas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `progClave_UNIQUE` (`progClave`,`deleted_at`),
  ADD KEY `fk_programa_escuela_idx` (`escuela_id`),
  ADD KEY `fk_programa_empleado_idx` (`empleado_id`);

--
-- Indices de la tabla `referencias`
--
ALTER TABLE `referencias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_referencia_unica` (`alumno_id`,`refNum`),
  ADD KEY `fk_referencia_usu_apli_idx` (`refUsuarioAplico`),
  ADD KEY `fk_referencia_programa_idx` (`programa_id`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ubiClave_UNIQUE` (`ubiClave`,`deleted_at`),
  ADD KEY `fk_ubicacion_municipios_idx` (`municipio_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`,`deleted_at`),
  ADD KEY `fk_user_empleado_idx` (`empleado_id`);

--
-- Indices de la tabla `usuaGim`
--
ALTER TABLE `usuaGim`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usugim_alumno_idx` (`alumno_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acuerdos`
--
ALTER TABLE `acuerdos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aextra`
--
ALTER TABLE `aextra`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aulas`
--
ALTER TABLE `aulas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cgt`
--
ALTER TABLE `cgt`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `concAextra`
--
ALTER TABLE `concAextra`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `edocta`
--
ALTER TABLE `edocta`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3451;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identificador del empleado', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'folio_fic';

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `historico`
--
ALTER TABLE `historico`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `idiomas`
--
ALTER TABLE `idiomas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inscProg`
--
ALTER TABLE `inscProg`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inscritos`
--
ALTER TABLE `inscritos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identificador de Municipio', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `optativas`
--
ALTER TABLE `optativas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paquete_detalle`
--
ALTER TABLE `paquete_detalle`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `periodos`
--
ALTER TABLE `periodos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `permisos_programas_user`
--
ALTER TABLE `permisos_programas_user`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `permission_module_user`
--
ALTER TABLE `permission_module_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `planes`
--
ALTER TABLE `planes`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `prerequisitos`
--
ALTER TABLE `prerequisitos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programas`
--
ALTER TABLE `programas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `referencias`
--
ALTER TABLE `referencias`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'identificador Numérico', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuaGim`
--
ALTER TABLE `usuaGim`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acuerdos`
--
ALTER TABLE `acuerdos`
  ADD CONSTRAINT `fk_acuerdos_plan` FOREIGN KEY (`plan_id`) REFERENCES `planes` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `fk_alumno_persona` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `aulas`
--
ALTER TABLE `aulas`
  ADD CONSTRAINT `fk_aula_ubicacion` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicacion` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `fk_inscrito` FOREIGN KEY (`inscrito_id`) REFERENCES `inscritos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `cgt`
--
ALTER TABLE `cgt`
  ADD CONSTRAINT `fk_cgt_periodo` FOREIGN KEY (`periodo_id`) REFERENCES `periodos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cgt_plan` FOREIGN KEY (`plan_id`) REFERENCES `planes` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `fk_curso_alumno` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_curso_cgt` FOREIGN KEY (`cgt_id`) REFERENCES `cgt` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_curso_periodo` FOREIGN KEY (`periodo_id`) REFERENCES `periodos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD CONSTRAINT `fk_departamento_ubicacion` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicacion` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `dk_empleado_escuela` FOREIGN KEY (`escuela_id`) REFERENCES `escuelas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dk_empleado_persona` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `escuelas`
--
ALTER TABLE `escuelas`
  ADD CONSTRAINT `fk_escuela_departamento` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_escuela_empleado` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `estados`
--
ALTER TABLE `estados`
  ADD CONSTRAINT `fk_estado_pais` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `fk_grupo_empleado` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_materia` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_optativa` FOREIGN KEY (`optativa_id`) REFERENCES `optativas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_periodo` FOREIGN KEY (`periodo_id`) REFERENCES `periodos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_plan` FOREIGN KEY (`plan_id`) REFERENCES `planes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_sinodal` FOREIGN KEY (`empleado_sinodal_id`) REFERENCES `empleados` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `historico`
--
ALTER TABLE `historico`
  ADD CONSTRAINT `fk_historico_inscrito` FOREIGN KEY (`inscrito_id`) REFERENCES `inscritos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `fk_horario_aula` FOREIGN KEY (`aula_id`) REFERENCES `aulas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_horario_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `inscritos`
--
ALTER TABLE `inscritos`
  ADD CONSTRAINT `fk_inscrito_curso` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscrito_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `fk_materia_plan` FOREIGN KEY (`plan_id`) REFERENCES `planes` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD CONSTRAINT `fk_municipio_estado` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `optativas`
--
ALTER TABLE `optativas`
  ADD CONSTRAINT `fk_optativa_materia` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD CONSTRAINT `fk_paquete_periodos` FOREIGN KEY (`periodo_id`) REFERENCES `periodos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_paquete_plan` FOREIGN KEY (`plan_id`) REFERENCES `planes` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `paquete_detalle`
--
ALTER TABLE `paquete_detalle`
  ADD CONSTRAINT `fk_paquete_detalle_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_paquete_detalle_paquete` FOREIGN KEY (`paquete_id`) REFERENCES `paquetes` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `periodos`
--
ALTER TABLE `periodos`
  ADD CONSTRAINT `fk_periodo_departamento` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `permisos_programas_user`
--
ALTER TABLE `permisos_programas_user`
  ADD CONSTRAINT `fk_permiso_programa` FOREIGN KEY (`programa_id`) REFERENCES `programas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_permiso_programa_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `permission_module_user`
--
ALTER TABLE `permission_module_user`
  ADD CONSTRAINT `permission_module_user_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_module_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_module_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `planes`
--
ALTER TABLE `planes`
  ADD CONSTRAINT `fk_planes_programa` FOREIGN KEY (`programa_id`) REFERENCES `programas` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `prerequisitos`
--
ALTER TABLE `prerequisitos`
  ADD CONSTRAINT `fk_prerequisito_materia` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prerequisito_materia2` FOREIGN KEY (`materia_prerequisito_id`) REFERENCES `materias` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `programas`
--
ALTER TABLE `programas`
  ADD CONSTRAINT `fk_programa_empleado` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_programa_escuela` FOREIGN KEY (`escuela_id`) REFERENCES `escuelas` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `referencias`
--
ALTER TABLE `referencias`
  ADD CONSTRAINT `fk_referencia_alumno` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_referencia_programa` FOREIGN KEY (`programa_id`) REFERENCES `programas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_referencia_usu_apli` FOREIGN KEY (`refUsuarioAplico`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD CONSTRAINT `fk_ubicacion_municipios` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_empleado` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuaGim`
--
ALTER TABLE `usuaGim`
  ADD CONSTRAINT `fk_usugim_alumno` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
