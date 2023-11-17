-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 05-12-2018 a las 16:52:08
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

--
-- Volcado de datos para la tabla `acuerdos`
--

INSERT INTO `acuerdos` (`id`, `plan_id`, `acuNumero`, `acuFecha`, `acuEstadoPlan`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '201', '2018-11-01', 'N', 1, '2018-11-17 00:12:23', '2018-11-17 00:12:23', NULL);

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

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `persona_id`, `aluClave`, `aluEstado`, `aluFechaIngr`, `aluNivelIngr`, `aluGradoIngr`, `aluMatricula`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 11180100, '', '2018-11-30 14:03:03', 1, 1, NULL, 1, '2018-11-13 00:03:16', '2018-11-30 20:03:03', NULL),
(2, 6, 11180101, '', '2018-11-27 15:13:30', 1, 1, NULL, 1, '2018-11-27 21:13:30', '2018-11-27 21:13:30', NULL);

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
(1, 1, '101', 45, NULL, NULL, 1, '2018-11-17 00:04:13', '2018-11-17 00:04:13', NULL);

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

--
-- Volcado de datos para la tabla `calificaciones`
--

INSERT INTO `calificaciones` (`id`, `inscrito_id`, `inscCalificacionParcial1`, `inscFaltasParcial1`, `inscCalificacionParcial2`, `inscFaltasParcial2`, `inscCalificacionParcial3`, `inscFaltasParcial3`, `inscPromedioParciales`, `inscCalificacionOrdinario`, `incsCalificacionFinal`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 60, 1, 70, 0, 65, 0, 65, 80, 69, 1, NULL, '2018-11-29 23:59:35', '2018-11-29 23:59:35'),
(2, 2, 70, 0, 80, 0, 95, 2, 81.67, 90, 84, 1, '2018-11-29 07:24:41', '2018-11-29 07:41:07', NULL),
(3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2018-11-30 00:01:00', '2018-11-30 00:01:00', NULL);

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

--
-- Volcado de datos para la tabla `cgt`
--

INSERT INTO `cgt` (`id`, `plan_id`, `periodo_id`, `cgtGradoSemestre`, `cgtGrupo`, `cgtTurno`, `cgtCupo`, `empleado_id`, `cgtEstado`, `cgtDescripcion`, `cgtTotalRegistrados`, `cgtInscritos`, `cgtPreinscritos`, `cgtBaja`, `cgtOtros`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 3, 1, 'A', 'M', 45, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2018-11-12 21:42:34', '2018-11-12 22:11:09', NULL),
(2, 1, 3, 1, 'A', 'M', 40, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2018-11-12 22:35:24', '2018-11-30 22:33:17', NULL),
(3, 1, 3, 1, 'B', 'M', 45, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2018-11-13 19:56:35', '2018-11-27 21:07:59', NULL);

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

--
-- Volcado de datos para la tabla `cuotas`
--

INSERT INTO `cuotas` (`id`, `cuoTipo`, `dep_esc_prog_id`, `cuoAnio`, `cuoImportePadresFamilia`, `cuoImporteOrdinarioUady`, `cuoImporteMensualidad10`, `cuoImporteMensualidad11`, `cuoImporteMensualidad12`, `cuoImporteInscripcion1`, `cuoFechaLimiteInscripcion1`, `cuoImporteInscripcion2`, `cuoFechaLimiteInscripcion2`, `cuoImporteInscripcion3`, `cuoFechaLimiteInscripcion3`, `cuoImporteVencimiento`, `cuoImporteProntoPago`, `cuoDiasProntoPago`, `cuoNumeroCuenta`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'D', 1, 2017, '200.00', '200.00', '4500.00', '4200.00', '4000.00', '3900.00', '2017-12-01', '4200.00', '2018-02-01', '4500.00', '2018-08-01', '200.00', '150.00', 15, '978302293', 1, NULL, NULL, NULL);

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

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `alumno_id`, `cgt_id`, `periodo_id`, `curTipoBeca`, `curPorcentajeBeca`, `curObservacionesBeca`, `curFechaRegistro`, `curFechaBaja`, `curEstado`, `curTipoIngreso`, `curImporteInscripcion`, `curImporteMensualidad`, `curImporteVencimiento`, `curImporteDescuento`, `curDiasProntoPago`, `curPlanPago`, `curOpcionTitulo`, `curAnioCuotas`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 3, NULL, NULL, NULL, NULL, NULL, 'R', 'NI', NULL, NULL, NULL, NULL, NULL, 'N', 'N', NULL, 1, '2018-11-13 00:06:51', '2018-11-13 00:14:55', NULL),
(6, 2, 2, 3, NULL, NULL, NULL, NULL, NULL, 'R', 'NI', NULL, NULL, NULL, NULL, NULL, 'N', 'S', NULL, 1, '2018-11-27 21:22:07', '2018-11-30 23:25:48', NULL);

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
(1, 1, 5, 'SUP', 'LICENCIATURA', 'LICENCIATURA', '31PSU0009X', 'UNIVERSIDAD MODELO', 1, 3, 3, 60, 45, 'QUÍMICA FARMACÉUTICA BIÓLOGA', 'CELIA MARÍA DEL SOCORRO QUINTAL AVILÉS', 'SECRETARIA ADMINISTRATIVA', NULL, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edocta`
--

CREATE TABLE `edocta` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `fec_oper_edo` date NOT NULL,
  `anio_pago_edo` char(4) DEFAULT NULL,
  `cve_pago_edo` char(8) NOT NULL,
  `mes_pago_edo` char(2) DEFAULT NULL,
  `dig_pago_edo` char(1) DEFAULT NULL,
  `descrip_edo` char(30) DEFAULT NULL,
  `imp_abono_edo` double(17,2) DEFAULT NULL,
  `imp_cargo_edo` double(17,2) DEFAULT NULL,
  `estado_edo` char(1) DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `edocta`
--

INSERT INTO `edocta` (`id`, `fec_oper_edo`, `anio_pago_edo`, `cve_pago_edo`, `mes_pago_edo`, `dig_pago_edo`, `descrip_edo`, `imp_abono_edo`, `imp_cargo_edo`, `estado_edo`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2018-09-30', '2018', '14184515', '1', '1', 'nose', 4725.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(2, '2018-09-30', '2018', '15150041', '1', '1', 'nose', 3206.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(3, '2018-09-29', '2018', '15150277', '1', '1', 'nose', 3206.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(4, '2018-09-29', '2018', '15173772', '1', '1', 'nose', 3634.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(5, '2018-09-29', '2018', '15186076', '1', '1', 'nose', 4725.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(6, '2018-09-28', '2018', '00000914', '1', '1', 'nose', 0.00, 288.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(7, '2018-09-28', '2018', '00000914', '1', '1', 'nose', 0.00, 1800.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(8, '2018-09-28', '2018', '14160958', '1', '1', 'nose', 3825.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(9, '2018-09-28', '2018', '14184515', '1', '1', 'nose', 3300.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(10, '2018-09-28', '2018', '14184605', '1', '1', 'nose', 3825.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(11, '2018-09-28', '2018', '15150372', '1', '1', 'nose', 5000.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(12, '2018-09-28', '2018', '15150317', '1', '1', 'nose', 2138.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(13, '2018-09-28', '2018', '16091075', '1', '1', 'nose', 2000.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(14, '2018-09-28', '2018', '15184622', '1', '1', 'nose', 5150.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(15, '2018-09-28', '2018', '15186391', '1', '1', 'nose', 4800.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(16, '2018-09-28', '2018', '14186128', '1', '1', 'nose', 3825.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(17, '2018-09-28', '2018', '15174036', '1', '1', 'nose', 2950.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(18, '2018-09-28', '2018', '14185697', '1', '1', 'nose', 3825.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(19, '2018-09-28', '2018', '14172725', '1', '1', 'nose', 3825.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(20, '2018-09-28', '2018', '15173965', '1', '1', 'nose', 6500.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(21, '2018-09-27', '2018', '14161243', '1', '1', 'nose', 3825.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(22, '2018-09-27', '2018', '15172685', '1', '1', 'nose', 37600.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(23, '2018-09-27', '2018', '15159376', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(24, '2018-09-26', '2018', '14185164', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(25, '2018-09-26', '2018', '14185164', '1', '1', 'nose', 3825.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(26, '2018-09-26', '2018', '15161078', '1', '1', 'nose', 4000.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(27, '2018-09-25', '2018', '15150060', '1', '1', 'nose', 4700.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(28, '2018-09-25', '2018', '14185914', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(29, '2018-09-25', '2018', '15186155', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(30, '2018-09-25', '2018', '15185154', '1', '1', 'nose', 4575.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(31, '2018-09-24', '2018', '15186211', '1', '1', 'nose', 4575.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(32, '2018-09-24', '2018', '15150060', '1', '1', 'nose', 4000.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(33, '2018-09-24', '2018', '15185596', '1', '1', 'nose', 4800.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(34, '2018-09-24', '2018', '15185318', '1', '1', 'nose', 5150.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(35, '2018-09-24', '2018', '15161750', '1', '1', 'nose', 42750.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(36, '2018-09-24', '2018', '54186178', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(38, '2018-09-21', '2018', '15161485', '1', '1', 'nose', 1100.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(39, '2018-09-21', '2018', '14160539', '1', '1', 'nose', 3825.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(40, '2018-09-20', '2018', '15150372', '1', '1', 'nose', 8000.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(41, '2018-09-19', '2018', '15161650', '1', '1', 'nose', 2993.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(42, '2018-09-19', '2018', '15161379', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(43, '2018-09-19', '2018', '14173761', '1', '1', 'nose', 4000.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(44, '2018-09-19', '2018', '14186001', '1', '1', 'nose', 3825.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(45, '2018-09-19', '2018', '15185244', '1', '1', 'nose', 4700.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(46, '2018-09-18', '2018', '15173840', '1', '1', 'nose', 4700.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(47, '2018-09-18', '2018', '15185434', '1', '1', 'nose', 3075.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(48, '2018-09-18', '2018', '14161143', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(51, '2018-09-18', '2018', '15185398', '1', '1', 'nose', 4575.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(52, '2018-09-17', '2018', '14173292', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(53, '2018-09-17', '2018', '15159252', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(54, '2018-09-17', '2018', '15161231', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(55, '2018-09-17', '2018', '15185258', '1', '1', 'nose', 4800.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(56, '2018-09-17', '2018', '15147421', '1', '1', 'nose', 4475.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(57, '2018-09-17', '2018', '14186161', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(58, '2018-09-17', '2018', '15159386', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(59, '2018-09-17', '2018', '15161223', '1', '1', 'nose', 2138.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(60, '2018-09-17', '2018', '14161125', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(61, '2018-09-17', '2018', '14172792', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(62, '2018-09-17', '2018', '15185629', '1', '1', 'nose', 4800.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(63, '2018-09-17', '2018', '15172427', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(64, '2018-09-17', '2018', '15150231', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(65, '2018-09-17', '2018', '15160672', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(66, '2018-09-17', '2018', '14173111', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(67, '2018-09-17', '2018', '15174004', '1', '1', 'nose', 5900.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(68, '2018-09-17', '2018', '15173150', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(69, '2018-09-17', '2018', '15161941', '1', '1', 'nose', 4800.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(70, '2018-09-17', '2018', '15150488', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(71, '2018-09-17', '2018', '14173899', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(72, '2018-09-17', '2018', '34173306', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(73, '2018-09-17', '2018', '15172773', '1', '1', 'nose', 4425.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(74, '2018-09-17', '2018', '15186315', '1', '1', 'nose', 2138.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(75, '2018-09-17', '2018', '15174149', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(76, '2018-09-17', '2018', '15161934', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(77, '2018-09-17', '2018', '15173015', '1', '1', 'nose', 2138.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(78, '2018-09-17', '2018', '15173883', '1', '1', 'nose', 3840.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(79, '2018-09-17', '2018', '15161825', '1', '1', 'nose', 2779.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(80, '2018-09-17', '2018', '15160552', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(81, '2018-09-17', '2018', '15172442', '1', '1', 'nose', 2880.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(82, '2018-09-17', '2018', '15173392', '1', '1', 'nose', 4800.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(83, '2018-09-17', '2018', '15186214', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(84, '2018-09-17', '2018', '15160940', '1', '1', 'nose', 3360.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(85, '2018-09-17', '2018', '15159364', '1', '1', 'nose', 2351.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(86, '2018-09-17', '2018', '15160822', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(87, '2018-09-17', '2018', '14172693', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(88, '2018-09-17', '2018', '15160535', '1', '1', 'nose', 4800.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(89, '2018-09-17', '2018', '14172794', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(90, '2018-09-17', '2018', '15184745', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(91, '2018-09-17', '2018', '15161321', '1', '1', 'nose', 4800.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(92, '2018-09-17', '2018', '15173873', '1', '1', 'nose', 3634.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(93, '2018-09-17', '2018', '14172648', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(94, '2018-09-17', '2018', '15173738', '1', '1', 'nose', 2400.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(95, '2018-09-17', '2018', '15172976', '1', '1', 'nose', 4720.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(96, '2018-09-17', '2018', '15161512', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(97, '2018-09-17', '2018', '14185665', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(98, '2018-09-17', '2018', '15147708', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(99, '2018-09-17', '2018', '14172805', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(100, '2018-09-17', '2018', '15186096', '1', '1', 'nose', 4920.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(101, '2018-09-17', '2018', '15185773', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(102, '2018-09-17', '2018', '15160530', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(103, '2018-09-17', '2018', '15185168', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(104, '2018-09-17', '2018', '15160884', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(105, '2018-09-17', '2018', '15185275', '1', '1', 'nose', 2993.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(106, '2018-09-17', '2018', '15172435', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(107, '2018-09-17', '2018', '14160663', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(108, '2018-09-17', '2018', '15185569', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(109, '2018-09-17', '2018', '15158934', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(110, '2018-09-17', '2018', '15185402', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(111, '2018-09-17', '2018', '14161856', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(113, '2018-09-17', '2018', '15173053', '1', '1', 'nose', 6370.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(115, '2018-09-17', '2018', '15161443', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(116, '2018-09-17', '2018', '15161691', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(117, '2018-09-17', '2018', '14159024', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(118, '2018-09-17', '2018', '15172848', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(119, '2018-09-17', '2018', '15172552', '1', '1', 'nose', 3360.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(120, '2018-09-17', '2018', '15173333', '1', '1', 'nose', 3634.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(121, '2018-09-17', '2018', '14160782', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(122, '2018-09-17', '2018', '14184495', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(123, '2018-09-17', '2018', '15172836', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(124, '2018-09-17', '2018', '15159395', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(125, '2018-09-17', '2018', '15173810', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(126, '2018-09-17', '2018', '15161627', '1', '1', 'nose', 2351.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(127, '2018-09-17', '2018', '15147289', '1', '1', 'nose', 4475.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(128, '2018-09-17', '2018', '15184829', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(129, '2018-09-17', '2018', '15161121', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(130, '2018-09-17', '2018', '15173143', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(131, '2018-09-17', '2018', '14174400', '1', '1', 'nose', 2996.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(132, '2018-09-17', '2018', '15161134', '1', '1', 'nose', 2138.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(133, '2018-09-17', '2018', '15159114', '1', '1', 'nose', 2351.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(134, '2018-09-17', '2018', '15185982', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(135, '2018-09-17', '2018', '15161543', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(136, '2018-09-17', '2018', '15159388', '1', '1', 'nose', 5570.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(137, '2018-09-17', '2018', '15150169', '1', '1', 'nose', 2138.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(138, '2018-09-17', '2018', '15160710', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(139, '2018-09-17', '2018', '15186095', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(140, '2018-09-17', '2018', '15161304', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(141, '2018-09-17', '2018', '15186141', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(142, '2018-09-17', '2018', '15147403', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(143, '2018-09-17', '2018', '15185036', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(144, '2018-09-17', '2018', '15158904', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(145, '2018-09-17', '2018', '15159163', '1', '1', 'nose', 3206.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(146, '2018-09-17', '2018', '15172968', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(147, '2018-09-17', '2018', '14185006', '1', '1', 'nose', 2644.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(148, '2018-09-17', '2018', '14186167', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(149, '2018-09-17', '2018', '15173077', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(150, '2018-09-17', '2018', '15172684', '1', '1', 'nose', 4130.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(151, '2018-09-17', '2018', '15148406', '1', '1', 'nose', 4475.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(152, '2018-09-17', '2018', '15185871', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(153, '2018-09-17', '2018', '14172818', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(154, '2018-09-17', '2018', '15185783', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(155, '2018-09-17', '2018', '15160889', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(156, '2018-09-17', '2018', '15172413', '1', '1', 'nose', 4080.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(157, '2018-09-16', '2018', '15160553', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(158, '2018-09-16', '2018', '14159377', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(159, '2018-09-16', '2018', '15185175', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(160, '2018-09-16', '2018', '15162239', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(161, '2018-09-16', '2018', '14147348', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(162, '2018-09-16', '2018', '15162001', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(163, '2018-09-16', '2018', '15159827', '1', '1', 'nose', 1785.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(164, '2018-09-16', '2018', '15185110', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(165, '2018-09-16', '2018', '15161021', '1', '1', 'nose', 4870.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(166, '2018-09-16', '2018', '15161004', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(167, '2018-09-16', '2018', '14172703', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(168, '2018-09-16', '2018', '15159576', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(169, '2018-09-16', '2018', '15159319', '1', '1', 'nose', 2993.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(170, '2018-09-16', '2018', '15184640', '1', '1', 'nose', 4080.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(171, '2018-09-15', '2018', '15173052', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(172, '2018-09-15', '2018', '15173961', '1', '1', 'nose', 2565.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(173, '2018-09-15', '2018', '15160784', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(174, '2018-09-15', '2018', '15174198', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(175, '2018-09-15', '2018', '15184756', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(176, '2018-09-15', '2018', '15150290', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(177, '2018-09-15', '2018', '15172390', '1', '1', 'nose', 3840.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(178, '2018-09-15', '2018', '15172423', '1', '1', 'nose', 3840.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(179, '2018-09-15', '2018', '14161933', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(180, '2018-09-15', '2018', '15185236', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(181, '2018-09-15', '2018', '15173692', '1', '1', 'nose', 3835.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(182, '2018-09-15', '2018', '15160887', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(183, '2018-09-15', '2018', '15172960', '1', '1', 'nose', 4720.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(184, '2018-09-15', '2018', '15160630', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(187, '2018-09-15', '2018', '15172833', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(188, '2018-09-15', '2018', '15172832', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(189, '2018-09-15', '2018', '15158902', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(190, '2018-09-15', '2018', '15160723', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(191, '2018-09-15', '2018', '15160997', '1', '1', 'nose', 4400.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(192, '2018-09-15', '2018', '14186116', '1', '1', 'nose', 1763.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(193, '2018-09-15', '2018', '15147422', '1', '1', 'nose', 2993.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(194, '2018-09-15', '2018', '15160982', '1', '1', 'nose', 4800.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(195, '2018-09-15', '2018', '15162000', '1', '1', 'nose', 4080.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(196, '2018-09-15', '2018', '15159318', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(197, '2018-09-15', '2018', '15173152', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(198, '2018-09-15', '2018', '15162030', '1', '1', 'nose', 4800.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(199, '2018-09-15', '2018', '15147739', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(200, '2018-09-15', '2018', '15185218', '1', '1', 'nose', 1283.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(201, '2018-09-15', '2018', '14161657', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(202, '2018-09-15', '2018', '15159727', '1', '1', 'nose', 2138.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(203, '2018-09-15', '2018', '14159227', '1', '1', 'nose', 4920.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(204, '2018-09-15', '2018', '15162116', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(205, '2018-09-15', '2018', '34185909', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(206, '2018-09-15', '2018', '15172406', '1', '1', 'nose', 4720.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(207, '2018-09-15', '2018', '15173781', '1', '1', 'nose', 3840.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(208, '2018-09-14', '2018', '15172789', '1', '1', 'nose', 4700.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(209, '2018-09-14', '2018', '15172789', '1', '1', 'nose', 4000.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(211, '2018-09-14', '2018', '15150027', '1', '1', 'nose', 2138.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(212, '2018-09-14', '2018', '15173036', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(213, '2018-09-14', '2018', '15186264', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(214, '2018-09-14', '2018', '14184658', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(215, '2018-09-14', '2018', '15173075', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(216, '2018-09-14', '2018', '14159719', '1', '1', 'nose', 4920.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(217, '2018-09-14', '2018', '15185126', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(218, '2018-09-14', '2018', '15159467', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(219, '2018-09-14', '2018', '14185133', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(220, '2018-09-14', '2018', '15174166', '1', '1', 'nose', 2779.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(221, '2018-09-14', '2018', '15173780', '1', '1', 'nose', 2950.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(222, '2018-09-14', '2018', '15162192', '1', '1', 'nose', 4800.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(223, '2018-09-14', '2018', '15174213', '1', '1', 'nose', 2138.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(224, '2018-09-14', '2018', '15160828', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(225, '2018-09-14', '2018', '15185203', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:48', '2018-12-05 21:39:48', NULL),
(226, '2018-09-14', '2018', '15185761', '1', '1', 'nose', 2993.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(227, '2018-09-14', '2018', '15174096', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(228, '2018-09-14', '2018', '15186212', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(229, '2018-09-14', '2018', '15172483', '1', '1', 'nose', 3835.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(230, '2018-09-14', '2018', '15184632', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(231, '2018-09-14', '2018', '15185953', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(232, '2018-09-14', '2018', '15185908', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(233, '2018-09-14', '2018', '15159515', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(239, '2018-09-14', '2018', '15186233', '1', '1', 'nose', 4920.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(240, '2018-09-14', '2018', '15172694', '1', '1', 'nose', 5900.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(241, '2018-09-14', '2018', '15147974', '1', '1', 'nose', 5000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(242, '2018-09-14', '2018', '15161894', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(243, '2018-09-14', '2018', '15161071', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(244, '2018-09-14', '2018', '15186134', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(245, '2018-09-14', '2018', '15174037', '1', '1', 'nose', 2138.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(246, '2018-09-14', '2018', '14186112', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(247, '2018-09-14', '2018', '15172982', '1', '1', 'nose', 3840.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(248, '2018-09-14', '2018', '15185464', '1', '1', 'nose', 1710.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(249, '2018-09-14', '2018', '15160750', '1', '1', 'nose', 3848.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(250, '2018-09-14', '2018', '15160749', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(251, '2018-09-14', '2018', '15185902', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(252, '2018-09-14', '2018', '14172979', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(253, '2018-09-14', '2018', '14185416', '1', '1', 'nose', 1763.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(254, '2018-09-14', '2018', '15186188', '1', '1', 'nose', 2993.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(255, '2018-09-14', '2018', '14172659', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(256, '2018-09-14', '2018', '15161170', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(257, '2018-09-14', '2018', '15161120', '1', '1', 'nose', 4400.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(258, '2018-09-14', '2018', '15161118', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(259, '2018-09-14', '2018', '14161136', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(260, '2018-09-14', '2018', '15184882', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(261, '2018-09-14', '2018', '14186150', '1', '1', 'nose', 2644.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(262, '2018-09-14', '2018', '15172396', '1', '1', 'nose', 3634.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(263, '2018-09-14', '2018', '15173469', '1', '1', 'nose', 4305.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(264, '2018-09-14', '2018', '15185917', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(265, '2018-09-14', '2018', '14172484', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(266, '2018-09-14', '2018', '15161015', '1', '1', 'nose', 4800.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(267, '2018-09-14', '2018', '15161313', '1', '1', 'nose', 2400.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(268, '2018-09-14', '2018', '14160671', '1', '1', 'nose', 2820.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(269, '2018-09-14', '2018', '15147769', '1', '1', 'nose', 4475.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(270, '2018-09-14', '2018', '15173356', '1', '1', 'nose', 3540.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(271, '2018-09-14', '2018', '15147677', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(272, '2018-09-14', '2018', '14161205', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(273, '2018-09-14', '2018', '14184824', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(274, '2018-09-14', '2018', '15160885', '1', '1', 'nose', 12800.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(275, '2018-09-14', '2018', '15160885', '1', '1', 'nose', 4700.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(276, '2018-09-14', '2018', '15160515', '1', '1', 'nose', 1100.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(277, '2018-09-14', '2018', '14185102', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(278, '2018-09-14', '2018', '54174010', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(279, '2018-09-14', '2018', '15184986', '1', '1', 'nose', 4800.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(280, '2018-09-14', '2018', '15185096', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(281, '2018-09-14', '2018', '15159739', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(282, '2018-09-14', '2018', '15184848', '1', '1', 'nose', 3206.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(283, '2018-09-14', '2018', '14185696', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(284, '2018-09-14', '2018', '15160827', '1', '1', 'nose', 3025.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(285, '2018-09-13', '2018', '15160913', '1', '1', 'nose', 4700.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(286, '2018-09-13', '2018', '15161010', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(287, '2018-09-13', '2018', '14160799', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(288, '2018-09-13', '2018', '15185981', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(289, '2018-09-13', '2018', '15173127', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(290, '2018-09-13', '2018', '15174053', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(291, '2018-09-13', '2018', '15186343', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(292, '2018-09-13', '2018', '15186060', '1', '1', 'nose', 2993.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(293, '2018-09-13', '2018', '15184747', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(294, '2018-09-13', '2018', '15185216', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(295, '2018-09-13', '2018', '15184999', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(296, '2018-09-13', '2018', '15172962', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(297, '2018-09-13', '2018', '15161234', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(298, '2018-09-13', '2018', '15150031', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(299, '2018-09-13', '2018', '15160623', '1', '1', 'nose', 2138.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(303, '2018-09-13', '2018', '15174208', '1', '1', 'nose', 39950.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(304, '2018-09-13', '2018', '15172695', '1', '1', 'nose', 5900.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(305, '2018-09-13', '2018', '15185166', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(306, '2018-09-13', '2018', '15173473', '1', '1', 'nose', 5900.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(307, '2018-09-13', '2018', '15172397', '1', '1', 'nose', 1283.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(308, '2018-09-13', '2018', '15173527', '1', '1', 'nose', 2138.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(309, '2018-09-13', '2018', '15173038', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(310, '2018-09-13', '2018', '14150150', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(311, '2018-09-13', '2018', '14173903', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(312, '2018-09-13', '2018', '14173804', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(313, '2018-09-13', '2018', '14162043', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(314, '2018-09-13', '2018', '15185955', '1', '1', 'nose', 3075.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(315, '2018-09-13', '2018', '15184764', '1', '1', 'nose', 3075.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(316, '2018-09-13', '2018', '15172424', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(317, '2018-09-13', '2018', '15184602', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(318, '2018-09-13', '2018', '14159105', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(319, '2018-09-13', '2018', '15162354', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(320, '2018-09-13', '2018', '15161938', '1', '1', 'nose', 2400.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(321, '2018-09-13', '2018', '15185113', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(322, '2018-09-13', '2018', '14161731', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(323, '2018-09-13', '2018', '15161942', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(324, '2018-09-13', '2018', '15159324', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(325, '2018-09-13', '2018', '15161487', '1', '1', 'nose', 54200.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(326, '2018-09-13', '2018', '15147355', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(327, '2018-09-13', '2018', '15161618', '1', '1', 'nose', 3634.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(328, '2018-09-13', '2018', '14172778', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(329, '2018-09-13', '2018', '15161126', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(330, '2018-09-12', '2018', '15172789', '1', '1', 'nose', 4000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(334, '2018-09-12', '2018', '15173070', '1', '1', 'nose', 2138.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(337, '2018-09-12', '2018', '15159613', '1', '1', 'nose', 2138.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(338, '2018-09-12', '2018', '15184863', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(339, '2018-09-12', '2018', '14173291', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(341, '2018-09-12', '2018', '54174294', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(342, '2018-09-12', '2018', '15150277', '1', '1', 'nose', 3206.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(343, '2018-09-12', '2018', '15186064', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(344, '2018-09-12', '2018', '15161625', '1', '1', 'nose', 5970.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(345, '2018-09-12', '2018', '14186191', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(346, '2018-09-12', '2018', '15161111', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(347, '2018-09-12', '2018', '15160829', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(348, '2018-09-12', '2018', '15173772', '1', '1', 'nose', 3634.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(349, '2018-09-12', '2018', '15185938', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(350, '2018-09-12', '2018', '15185647', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(351, '2018-09-12', '2018', '15186048', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(352, '2018-09-12', '2018', '15159081', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(353, '2018-09-12', '2018', '14173055', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(354, '2018-09-12', '2018', '15184522', '1', '1', 'nose', 5900.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(355, '2018-09-12', '2018', '15173064', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(356, '2018-09-12', '2018', '15159963', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(357, '2018-09-12', '2018', '14185177', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(358, '2018-09-12', '2018', '15185149', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(359, '2018-09-12', '2018', '14161013', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(360, '2018-09-12', '2018', '14172562', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(361, '2018-09-12', '2018', '14161159', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(362, '2018-09-12', '2018', '15185200', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(363, '2018-09-12', '2018', '15159159', '1', '1', 'nose', 2550.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(364, '2018-09-12', '2018', '14185049', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(365, '2018-09-12', '2018', '15185151', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(366, '2018-09-12', '2018', '15161685', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(367, '2018-09-11', '2018', '15160582', '1', '1', 'nose', 4675.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(368, '2018-09-11', '2018', '15150041', '1', '1', 'nose', 3206.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(369, '2018-09-11', '2018', '15160659', '1', '1', 'nose', 2138.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(370, '2018-09-11', '2018', '15173889', '1', '1', 'nose', 2779.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(371, '2018-09-11', '2018', '15186391', '1', '1', 'nose', 4700.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(372, '2018-09-11', '2018', '15161033', '1', '1', 'nose', 3634.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(373, '2018-09-11', '2018', '15185016', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(374, '2018-09-11', '2018', '14173822', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(375, '2018-09-11', '2018', '14172524', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(376, '2018-09-11', '2018', '15185441', '1', '1', 'nose', 17100.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(377, '2018-09-11', '2018', '14184817', '1', '1', 'nose', 2115.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(378, '2018-09-11', '2018', '15184893', '1', '1', 'nose', 6620.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(379, '2018-09-11', '2018', '15185879', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(380, '2018-09-11', '2018', '15185116', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(382, '2018-09-11', '2018', '15185211', '1', '1', 'nose', 2993.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(383, '2018-09-11', '2018', '15185084', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(384, '2018-09-11', '2018', '14173757', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(385, '2018-09-11', '2018', '15186203', '1', '1', 'nose', 3206.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(386, '2018-09-11', '2018', '15185403', '1', '1', 'nose', 4320.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(387, '2018-09-11', '2018', '14173996', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(389, '2018-09-11', '2018', '14173996', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(390, '2018-09-11', '2018', '15186290', '1', '1', 'nose', 4800.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(391, '2018-09-11', '2018', '14161879', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(392, '2018-09-11', '2018', '15173142', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(393, '2018-09-11', '2018', '14184917', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(394, '2018-09-11', '2018', '15185387', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(395, '2018-09-11', '2018', '15162046', '1', '1', 'nose', 2750.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(396, '2018-09-10', '2018', '15160826', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(398, '2018-09-10', '2018', '15160869', '1', '1', 'nose', 4700.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(399, '2018-09-10', '2018', '15150011', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(400, '2018-09-10', '2018', '14172531', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(401, '2018-09-10', '2018', '15184980', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(402, '2018-09-10', '2018', '15185942', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL);
INSERT INTO `edocta` (`id`, `fec_oper_edo`, `anio_pago_edo`, `cve_pago_edo`, `mes_pago_edo`, `dig_pago_edo`, `descrip_edo`, `imp_abono_edo`, `imp_cargo_edo`, `estado_edo`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(403, '2018-09-10', '2018', '15186182', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(404, '2018-09-10', '2018', '15159259', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(405, '2018-09-10', '2018', '15184479', '1', '1', 'nose', 4920.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(406, '2018-09-10', '2018', '14173261', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(407, '2018-09-10', '2018', '15184496', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(408, '2018-09-10', '2018', '15185883', '1', '1', 'nose', 43445.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(409, '2018-09-10', '2018', '15160687', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(410, '2018-09-10', '2018', '15160915', '1', '1', 'nose', 3840.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(411, '2018-09-10', '2018', '15184891', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(412, '2018-09-10', '2018', '15185526', '1', '1', 'nose', 60050.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(413, '2018-09-10', '2018', '14172806', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(414, '2018-09-10', '2018', '15147693', '1', '1', 'nose', 5000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(415, '2018-09-09', '2018', '15173073', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(416, '2018-09-08', '2018', '15159888', '1', '1', 'nose', 4475.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(418, '2018-09-08', '2018', '15173954', '1', '1', 'nose', 4720.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(419, '2018-09-08', '2018', '15147318', '1', '1', 'nose', 2138.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(420, '2018-09-08', '2018', '15184988', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(421, '2018-09-08', '2018', '15172674', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(422, '2018-09-08', '2018', '15185099', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(423, '2018-09-08', '2018', '14172843', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(424, '2018-09-07', '2018', '15161379', '1', '1', 'nose', 4700.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(425, '2018-09-07', '2018', '15159252', '1', '1', 'nose', 4700.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(426, '2018-09-07', '2018', '15184851', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(427, '2018-09-07', '2018', '15186315', '1', '1', 'nose', 4700.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(428, '2018-09-07', '2018', '15174004', '1', '1', 'nose', 4700.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(429, '2018-09-07', '2018', '15174432', '1', '1', 'nose', 32375.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(430, '2018-09-07', '2018', '15150479', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(431, '2018-09-07', '2018', '15150197', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(435, '2018-09-07', '2018', '15186369', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(436, '2018-09-07', '2018', '14161013', '1', '1', 'nose', 3450.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(437, '2018-09-07', '2018', '14186145', '1', '1', 'nose', 17630.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(438, '2018-09-07', '2018', '15159150', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(439, '2018-09-07', '2018', '14174361', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(440, '2018-09-07', '2018', '15173886', '1', '1', 'nose', 3420.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(441, '2018-09-07', '2018', '14161107', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(442, '2018-09-07', '2018', '15186094', '1', '1', 'nose', 3634.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(443, '2018-09-07', '2018', '14173192', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(444, '2018-09-07', '2018', '15185071', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(445, '2018-09-30', '2018', '15148547', '1', '1', 'nose', 4800.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(446, '2018-09-29', '2018', '15159070', '1', '1', 'nose', 3925.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(447, '2018-09-28', '2018', '15161046', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(448, '2018-09-28', '2018', '15161046', '1', '1', 'nose', 3925.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(449, '2018-09-28', '2018', '00000873', '1', '1', 'nose', 0.00, 328.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(450, '2018-09-28', '2018', '00000873', '1', '1', 'nose', 0.00, 2050.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(451, '2018-09-28', '2018', '15172973', '1', '1', 'nose', 2500.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(452, '2018-09-28', '2018', '15161870', '1', '1', 'nose', 4125.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(453, '2018-09-28', '2018', '14186319', '1', '1', 'nose', 3025.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(454, '2018-09-28', '2018', '15174030', '1', '1', 'nose', 3925.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(455, '2018-09-28', '2018', '14162014', '1', '1', 'nose', 3550.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(456, '2018-09-28', '2018', '15158950', '1', '1', 'nose', 4650.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(457, '2018-09-28', '2018', '13186248', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(458, '2018-09-27', '2018', '15173699', '1', '1', 'nose', 3625.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(459, '2018-09-26', '2018', '15161165', '1', '1', 'nose', 1000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(460, '2018-09-26', '2018', '15172868', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(461, '2018-09-26', '2018', '15147344', '1', '1', 'nose', 3475.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(462, '2018-09-26', '2018', '15159409', '1', '1', 'nose', 14475.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(463, '2018-09-26', '2018', '15147397', '1', '1', 'nose', 5000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(464, '2018-09-25', '2018', '15185765', '1', '1', 'nose', 3925.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(465, '2018-09-25', '2018', '15160835', '1', '1', 'nose', 3825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(466, '2018-09-25', '2018', '13147217', '1', '1', 'nose', 3525.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(467, '2018-09-25', '2018', '14135810', '1', '1', 'nose', 3925.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(468, '2018-09-24', '2018', '14173677', '1', '1', 'nose', 3025.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(469, '2018-09-24', '2018', '14185661', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(470, '2018-09-22', '2018', '15162109', '1', '1', 'nose', 3925.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(471, '2018-09-22', '2018', '15148547', '1', '1', 'nose', 22500.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(472, '2018-09-21', '2018', '15162178', '1', '1', 'nose', 3925.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(473, '2018-09-21', '2018', '15161832', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(474, '2018-09-20', '2018', '15173700', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(475, '2018-09-20', '2018', '15173700', '1', '1', 'nose', 11192.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(476, '2018-09-20', '2018', '15162378', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(477, '2018-09-20', '2018', '15173821', '1', '1', 'nose', 3825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(478, '2018-09-20', '2018', '15159345', '1', '1', 'nose', 3925.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(479, '2018-09-20', '2018', '15173257', '1', '1', 'nose', 3925.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(480, '2018-09-20', '2018', '15172869', '1', '1', 'nose', 3775.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(481, '2018-09-20', '2018', '15173716', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(482, '2018-09-19', '2018', '33161763', '1', '1', 'nose', 3225.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(483, '2018-09-19', '2018', '13160691', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(484, '2018-09-18', '2018', '15160852', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(485, '2018-09-18', '2018', '15172449', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(486, '2018-09-18', '2018', '15184463', '1', '1', 'nose', 3925.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(487, '2018-09-18', '2018', '15172405', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(488, '2018-09-18', '2018', '15147175', '1', '1', 'nose', 5000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(489, '2018-09-18', '2018', '15136280', '1', '1', 'nose', 5000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(490, '2018-09-17', '2018', '15160721', '1', '1', 'nose', 2794.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(491, '2018-09-17', '2018', '14159474', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(492, '2018-09-17', '2018', '15162200', '1', '1', 'nose', 2794.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(493, '2018-09-17', '2018', '14136621', '1', '1', 'nose', 3115.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(494, '2018-09-17', '2018', '15184619', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(495, '2018-09-17', '2018', '15160554', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(496, '2018-09-17', '2018', '15161613', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(497, '2018-09-17', '2018', '15185073', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(498, '2018-09-17', '2018', '15184606', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(499, '2018-09-17', '2018', '15185056', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(500, '2018-09-17', '2018', '15147751', '1', '1', 'nose', 3560.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(501, '2018-09-17', '2018', '13186285', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(502, '2018-09-17', '2018', '14159367', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(503, '2018-09-17', '2018', '14184497', '1', '1', 'nose', 2119.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(504, '2018-09-17', '2018', '24124577', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(505, '2018-09-17', '2018', '15162089', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(506, '2018-09-17', '2018', '15172385', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(507, '2018-09-17', '2018', '13186144', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(508, '2018-09-17', '2018', '15160785', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(509, '2018-09-17', '2018', '15172450', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(510, '2018-09-17', '2018', '13172394', '1', '1', 'nose', 1725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(511, '2018-09-17', '2018', '13172394', '1', '1', 'nose', 3250.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(512, '2018-09-17', '2018', '15186174', '1', '1', 'nose', 3560.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(513, '2018-09-17', '2018', '15160657', '1', '1', 'nose', 3560.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(514, '2018-09-17', '2018', '15162368', '1', '1', 'nose', 4450.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(515, '2018-09-17', '2018', '15161743', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(516, '2018-09-17', '2018', '15148714', '1', '1', 'nose', 4450.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(517, '2018-09-17', '2018', '13172391', '1', '1', 'nose', 2425.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(518, '2018-09-17', '2018', '13172386', '1', '1', 'nose', 2260.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(519, '2018-09-17', '2018', '15173896', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(520, '2018-09-17', '2018', '14184921', '1', '1', 'nose', 3325.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(521, '2018-09-17', '2018', '15161566', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(522, '2018-09-17', '2018', '15173932', '1', '1', 'nose', 2794.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(523, '2018-09-17', '2018', '15173524', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(524, '2018-09-17', '2018', '14185713', '1', '1', 'nose', 3325.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(525, '2018-09-17', '2018', '15159641', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(526, '2018-09-17', '2018', '15184793', '1', '1', 'nose', 5610.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(527, '2018-09-17', '2018', '15162051', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(528, '2018-09-17', '2018', '15147438', '1', '1', 'nose', 3560.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(529, '2018-09-17', '2018', '15147245', '1', '1', 'nose', 2448.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(530, '2018-09-17', '2018', '15159140', '1', '1', 'nose', 2421.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(531, '2018-09-17', '2018', '15185950', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(532, '2018-09-17', '2018', '13124525', '1', '1', 'nose', 3325.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(533, '2018-09-17', '2018', '14174042', '1', '1', 'nose', 2260.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(534, '2018-09-17', '2018', '13174137', '1', '1', 'nose', 1438.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(535, '2018-09-17', '2018', '23174049', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(536, '2018-09-17', '2018', '15184631', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(537, '2018-09-17', '2018', '13159237', '1', '1', 'nose', 32175.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(538, '2018-09-17', '2018', '15185756', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(539, '2018-09-17', '2018', '15172678', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(540, '2018-09-17', '2018', '15162119', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(541, '2018-09-17', '2018', '13147747', '1', '1', 'nose', 3325.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(542, '2018-09-17', '2018', '15148202', '1', '1', 'nose', 5000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(543, '2018-09-17', '2018', '15150071', '1', '1', 'nose', 2421.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(544, '2018-09-17', '2018', '14186334', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(545, '2018-09-17', '2018', '15184585', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(546, '2018-09-17', '2018', '15159077', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(547, '2018-09-17', '2018', '15159813', '1', '1', 'nose', 2421.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(548, '2018-09-17', '2018', '15184505', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(549, '2018-09-17', '2018', '15185005', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(550, '2018-09-17', '2018', '15173962', '1', '1', 'nose', 3166.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(551, '2018-09-17', '2018', '15173782', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(552, '2018-09-17', '2018', '23173535', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(553, '2018-09-17', '2018', '15185474', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(554, '2018-09-17', '2018', '15173149', '1', '1', 'nose', 2794.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(555, '2018-09-17', '2018', '15172417', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(556, '2018-09-17', '2018', '13185033', '1', '1', 'nose', 2425.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(557, '2018-09-17', '2018', '15184450', '1', '1', 'nose', 3115.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(558, '2018-09-17', '2018', '15173285', '1', '1', 'nose', 3166.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(559, '2018-09-17', '2018', '15148595', '1', '1', 'nose', 3560.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(560, '2018-09-17', '2018', '15172747', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(561, '2018-09-17', '2018', '14174041', '1', '1', 'nose', 2260.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(562, '2018-09-17', '2018', '15161992', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(563, '2018-09-17', '2018', '15160686', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(564, '2018-09-17', '2018', '15173791', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(565, '2018-09-17', '2018', '15172418', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(566, '2018-09-17', '2018', '14161764', '1', '1', 'nose', 2450.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(567, '2018-09-17', '2018', '14172431', '1', '1', 'nose', 3325.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(568, '2018-09-17', '2018', '15148595', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(569, '2018-09-17', '2018', '14161764', '1', '1', 'nose', 2300.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(570, '2018-09-17', '2018', '15159021', '1', '1', 'nose', 2049.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(571, '2018-09-17', '2018', '15185693', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(572, '2018-09-17', '2018', '15174412', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(573, '2018-09-17', '2018', '15185695', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(574, '2018-09-17', '2018', '15184499', '1', '1', 'nose', 3166.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(575, '2018-09-17', '2018', '15172724', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(576, '2018-09-17', '2018', '15173698', '1', '1', 'nose', 2794.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(577, '2018-09-17', '2018', '15160548', '1', '1', 'nose', 3166.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(578, '2018-09-17', '2018', '13172542', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(579, '2018-09-17', '2018', '14147737', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(580, '2018-09-17', '2018', '15172381', '1', '1', 'nose', 3338.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(581, '2018-09-17', '2018', '15148162', '1', '1', 'nose', 3560.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(582, '2018-09-17', '2018', '13184572', '1', '1', 'nose', 2425.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(583, '2018-09-17', '2018', '15185396', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(584, '2018-09-17', '2018', '15185419', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(585, '2018-09-17', '2018', '15184596', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(586, '2018-09-17', '2018', '15161712', '1', '1', 'nose', 3166.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(587, '2018-09-17', '2018', '15136898', '1', '1', 'nose', 4450.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(588, '2018-09-17', '2018', '15185519', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(589, '2018-09-17', '2018', '13159154', '1', '1', 'nose', 3325.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(590, '2018-09-17', '2018', '13124506', '1', '1', 'nose', 3560.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(591, '2018-09-17', '2018', '15147872', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(592, '2018-09-17', '2018', '15161360', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(593, '2018-09-17', '2018', '14184900', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(594, '2018-09-17', '2018', '14160667', '1', '1', 'nose', 2260.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(595, '2018-09-17', '2018', '13185003', '1', '1', 'nose', 2425.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(596, '2018-09-17', '2018', '14161849', '1', '1', 'nose', 3325.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(597, '2018-09-17', '2018', '15172777', '1', '1', 'nose', 2421.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(598, '2018-09-17', '2018', '14160729', '1', '1', 'nose', 2660.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(599, '2018-09-17', '2018', '15173166', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(600, '2018-09-17', '2018', '15160776', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(601, '2018-09-16', '2018', '14172402', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(602, '2018-09-16', '2018', '15184670', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(603, '2018-09-16', '2018', '15147629', '1', '1', 'nose', 4450.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(604, '2018-09-16', '2018', '15185223', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(605, '2018-09-16', '2018', '15159632', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(606, '2018-09-16', '2018', '14185768', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(607, '2018-09-16', '2018', '15161246', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(608, '2018-09-16', '2018', '15162079', '1', '1', 'nose', 2794.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(609, '2018-09-16', '2018', '14135864', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(610, '2018-09-16', '2018', '15150073', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(611, '2018-09-16', '2018', '15161837', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(612, '2018-09-16', '2018', '13185989', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(613, '2018-09-16', '2018', '13147333', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(614, '2018-09-16', '2018', '15150383', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(615, '2018-09-15', '2018', '15173902', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(616, '2018-09-15', '2018', '15161841', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(617, '2018-09-15', '2018', '15159962', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(618, '2018-09-15', '2018', '15172653', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(619, '2018-09-15', '2018', '15172517', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(620, '2018-09-15', '2018', '15147475', '1', '1', 'nose', 1335.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(621, '2018-09-15', '2018', '13185626', '1', '1', 'nose', 2425.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(622, '2018-09-15', '2018', '15173335', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(623, '2018-09-15', '2018', '15159638', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(624, '2018-09-15', '2018', '15185895', '1', '1', 'nose', 40975.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(625, '2018-09-15', '2018', '15136814', '1', '1', 'nose', 3560.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(626, '2018-09-15', '2018', '14185446', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(627, '2018-09-15', '2018', '14185142', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(628, '2018-09-15', '2018', '15161046', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(629, '2018-09-15', '2018', '14172700', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(630, '2018-09-15', '2018', '15173345', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(631, '2018-09-15', '2018', '15185401', '1', '1', 'nose', 2225.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(632, '2018-09-15', '2018', '15159289', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(633, '2018-09-15', '2018', '13184637', '1', '1', 'nose', 2425.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(634, '2018-09-15', '2018', '15161310', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(635, '2018-09-15', '2018', '15172384', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(636, '2018-09-14', '2018', '15160537', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(637, '2018-09-14', '2018', '15185866', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(638, '2018-09-14', '2018', '15172395', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(639, '2018-09-14', '2018', '15160549', '1', '1', 'nose', 2794.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(640, '2018-09-14', '2018', '15159302', '1', '1', 'nose', 4450.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(641, '2018-09-14', '2018', '13136632', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(642, '2018-09-14', '2018', '13162379', '1', '1', 'nose', 2425.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(643, '2018-09-14', '2018', '14161799', '1', '1', 'nose', 1413.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(644, '2018-09-14', '2018', '15161420', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(645, '2018-09-14', '2018', '14172393', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(646, '2018-09-14', '2018', '15161254', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(647, '2018-09-14', '2018', '15184853', '1', '1', 'nose', 3338.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(648, '2018-09-14', '2018', '15162363', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(649, '2018-09-14', '2018', '15147265', '1', '1', 'nose', 2225.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(650, '2018-09-14', '2018', '14160670', '1', '1', 'nose', 2260.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(651, '2018-09-14', '2018', '14160669', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(652, '2018-09-14', '2018', '15172415', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(653, '2018-09-14', '2018', '14172428', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(654, '2018-09-14', '2018', '15159197', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(655, '2018-09-14', '2018', '15172873', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(656, '2018-09-14', '2018', '14173406', '1', '1', 'nose', 1978.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(657, '2018-09-14', '2018', '14113568', '1', '1', 'nose', 3560.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(658, '2018-09-14', '2018', '13150352', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(659, '2018-09-14', '2018', '15185941', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(660, '2018-09-14', '2018', '13147704', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(661, '2018-09-14', '2018', '15161403', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(662, '2018-09-14', '2018', '13172404', '1', '1', 'nose', 2425.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(663, '2018-09-14', '2018', '14162180', '1', '1', 'nose', 3550.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(664, '2018-09-14', '2018', '15160791', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(665, '2018-09-14', '2018', '15174435', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(666, '2018-09-14', '2018', '15174413', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(667, '2018-09-14', '2018', '15161358', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(668, '2018-09-14', '2018', '15186218', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(669, '2018-09-14', '2018', '15147440', '1', '1', 'nose', 4450.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(670, '2018-09-14', '2018', '13160642', '1', '1', 'nose', 2588.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(671, '2018-09-14', '2018', '15172564', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(672, '2018-09-14', '2018', '15184493', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(673, '2018-09-14', '2018', '15161927', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(674, '2018-09-14', '2018', '15160808', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(675, '2018-09-14', '2018', '15160781', '1', '1', 'nose', 745.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(676, '2018-09-14', '2018', '13185943', '1', '1', 'nose', 2425.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(677, '2018-09-14', '2018', '15184668', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(678, '2018-09-14', '2018', '13124502', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(679, '2018-09-14', '2018', '13184652', '1', '1', 'nose', 2425.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(680, '2018-09-14', '2018', '15160810', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(681, '2018-09-14', '2018', '15161785', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(682, '2018-09-14', '2018', '14135744', '1', '1', 'nose', 2225.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(683, '2018-09-14', '2018', '15184642', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(684, '2018-09-14', '2018', '14135914', '1', '1', 'nose', 3115.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(685, '2018-09-14', '2018', '15185169', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(686, '2018-09-14', '2018', '33185892', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(687, '2018-09-14', '2018', '15185609', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(688, '2018-09-14', '2018', '13160574', '1', '1', 'nose', 2588.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(689, '2018-09-14', '2018', '15160501', '1', '1', 'nose', 3115.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(690, '2018-09-14', '2018', '15160839', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(691, '2018-09-14', '2018', '13147321', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(692, '2018-09-14', '2018', '15184475', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(693, '2018-09-14', '2018', '15184663', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(694, '2018-09-14', '2018', '15150189', '1', '1', 'nose', 2421.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(695, '2018-09-14', '2018', '15186136', '1', '1', 'nose', 4450.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(696, '2018-09-14', '2018', '15173316', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(697, '2018-09-14', '2018', '15184694', '1', '1', 'nose', 3560.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(698, '2018-09-14', '2018', '13148465', '1', '1', 'nose', 31025.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(699, '2018-09-14', '2018', '15185074', '1', '1', 'nose', 1550.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(700, '2018-09-14', '2018', '14135985', '1', '1', 'nose', 30042.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(701, '2018-09-14', '2018', '15185445', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(702, '2018-09-14', '2018', '14173817', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(703, '2018-09-14', '2018', '15185554', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(704, '2018-09-14', '2018', '15185784', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(705, '2018-09-14', '2018', '15184614', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(706, '2018-09-14', '2018', '15184580', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(707, '2018-09-14', '2018', '15184981', '1', '1', 'nose', 3960.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(708, '2018-09-14', '2018', '15174440', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(709, '2018-09-14', '2018', '14159487', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(710, '2018-09-14', '2018', '13159139', '1', '1', 'nose', 1663.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(711, '2018-09-14', '2018', '15185552', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(712, '2018-09-14', '2018', '15185059', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(713, '2018-09-14', '2018', '15184503', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(714, '2018-09-14', '2018', '15147621', '1', '1', 'nose', 2225.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(715, '2018-09-14', '2018', '15159748', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(716, '2018-09-14', '2018', '15184826', '1', '1', 'nose', 2794.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(717, '2018-09-14', '2018', '15147766', '1', '1', 'nose', 2225.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(718, '2018-09-14', '2018', '15161031', '1', '1', 'nose', 4450.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(719, '2018-09-14', '2018', '13052345', '1', '1', 'nose', 2425.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(720, '2018-09-14', '2018', '15148135', '1', '1', 'nose', 3115.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(721, '2018-09-14', '2018', '13159113', '1', '1', 'nose', 2260.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(722, '2018-09-13', '2018', '15174286', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(723, '2018-09-13', '2018', '15172383', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(724, '2018-09-13', '2018', '15172874', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(725, '2018-09-13', '2018', '15184883', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(727, '2018-09-13', '2018', '14148563', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(728, '2018-09-13', '2018', '15184511', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(729, '2018-09-13', '2018', '15172398', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(730, '2018-09-13', '2018', '13136680', '1', '1', 'nose', 3325.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(731, '2018-09-13', '2018', '15184587', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(732, '2018-09-13', '2018', '15147927', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(733, '2018-09-13', '2018', '15185052', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(734, '2018-09-13', '2018', '15172453', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(735, '2018-09-13', '2018', '14160805', '1', '1', 'nose', 2543.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(736, '2018-09-13', '2018', '14184871', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(737, '2018-09-13', '2018', '15184500', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(738, '2018-09-13', '2018', '15174442', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(739, '2018-09-13', '2018', '15160724', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(740, '2018-09-13', '2018', '15159194', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(741, '2018-09-13', '2018', '14160777', '1', '1', 'nose', 2260.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(742, '2018-09-13', '2018', '15184453', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(743, '2018-09-13', '2018', '14148366', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(744, '2018-09-13', '2018', '15161233', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(745, '2018-09-13', '2018', '14172400', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(746, '2018-09-13', '2018', '15172426', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(747, '2018-09-13', '2018', '13186132', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(748, '2018-09-13', '2018', '15184696', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(749, '2018-09-12', '2018', '15172677', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(750, '2018-09-12', '2018', '15161166', '1', '1', 'nose', 2421.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(751, '2018-09-12', '2018', '15172468', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(752, '2018-09-12', '2018', '15160728', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(753, '2018-09-12', '2018', '15185578', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(754, '2018-09-12', '2018', '15185520', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(755, '2018-09-12', '2018', '15148520', '1', '1', 'nose', 3560.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(756, '2018-09-12', '2018', '14184655', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(757, '2018-09-12', '2018', '15184492', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(758, '2018-09-12', '2018', '14186292', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(759, '2018-09-12', '2018', '13135766', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(760, '2018-09-12', '2018', '15160715', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(761, '2018-09-12', '2018', '14173430', '1', '1', 'nose', 2260.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(762, '2018-09-12', '2018', '15174395', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(763, '2018-09-12', '2018', '15161249', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(764, '2018-09-12', '2018', '15186281', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(765, '2018-09-12', '2018', '15185891', '1', '1', 'nose', 2794.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(766, '2018-09-12', '2018', '15186135', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(767, '2018-09-12', '2018', '15174386', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(768, '2018-09-12', '2018', '15172652', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(769, '2018-09-12', '2018', '15184576', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(770, '2018-09-12', '2018', '13174410', '1', '1', 'nose', 2425.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(771, '2018-09-12', '2018', '13174416', '1', '1', 'nose', 1940.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(772, '2018-09-12', '2018', '15173981', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(773, '2018-09-12', '2018', '14148157', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(774, '2018-09-12', '2018', '15091058', '1', '1', 'nose', 6000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(775, '2018-09-11', '2018', '15147245', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(776, '2018-09-11', '2018', '15184490', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(777, '2018-09-11', '2018', '15160495', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(778, '2018-09-11', '2018', '15185070', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(779, '2018-09-11', '2018', '15185722', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(780, '2018-09-11', '2018', '15184568', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(781, '2018-09-11', '2018', '15174402', '1', '1', 'nose', 20493.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(782, '2018-09-11', '2018', '15186169', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(783, '2018-09-11', '2018', '15185040', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL);
INSERT INTO `edocta` (`id`, `fec_oper_edo`, `anio_pago_edo`, `cve_pago_edo`, `mes_pago_edo`, `dig_pago_edo`, `descrip_edo`, `imp_abono_edo`, `imp_cargo_edo`, `estado_edo`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(784, '2018-09-11', '2018', '15184742', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(785, '2018-09-11', '2018', '15185570', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(786, '2018-09-11', '2018', '13162358', '1', '1', 'nose', 13343.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(787, '2018-09-11', '2018', '15184809', '1', '1', 'nose', 3560.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(788, '2018-09-11', '2018', '13136334', '1', '1', 'nose', 3115.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(789, '2018-09-11', '2018', '15162374', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(790, '2018-09-11', '2018', '15184997', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(791, '2018-09-11', '2018', '14184527', '1', '1', 'nose', 31025.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(792, '2018-09-11', '2018', '15147642', '1', '1', 'nose', 3115.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(793, '2018-09-11', '2018', '14186160', '1', '1', 'nose', 3325.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(794, '2018-09-11', '2018', '13184620', '1', '1', 'nose', 2425.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(795, '2018-09-11', '2018', '15174341', '1', '1', 'nose', 4450.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(796, '2018-09-11', '2018', '15148343', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(797, '2018-09-11', '2018', '15160867', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(798, '2018-09-11', '2018', '15148153', '1', '1', 'nose', 3560.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(799, '2018-09-11', '2018', '15147246', '1', '1', 'nose', 3115.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(800, '2018-09-10', '2018', '15160825', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(801, '2018-09-10', '2018', '15184714', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(802, '2018-09-10', '2018', '15162178', '1', '1', 'nose', 3825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(803, '2018-09-10', '2018', '15172867', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(804, '2018-09-10', '2018', '15185197', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(805, '2018-09-10', '2018', '15161517', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(806, '2018-09-10', '2018', '15184443', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(807, '2018-09-10', '2018', '15159349', '1', '1', 'nose', 6655.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(808, '2018-09-10', '2018', '13172446', '1', '1', 'nose', 2425.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(809, '2018-09-10', '2018', '15174409', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(810, '2018-09-10', '2018', '15161017', '1', '1', 'nose', 4450.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(811, '2018-09-10', '2018', '15174433', '1', '1', 'nose', 2794.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(812, '2018-09-10', '2018', '15172654', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(813, '2018-09-10', '2018', '15160817', '1', '1', 'nose', 2421.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(814, '2018-09-10', '2018', '15159836', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(815, '2018-09-10', '2018', '14184586', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(816, '2018-09-10', '2018', '15184834', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(817, '2018-09-10', '2018', '15186376', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(818, '2018-09-10', '2018', '15184915', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(819, '2018-09-10', '2018', '15185017', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(820, '2018-09-10', '2018', '15174128', '1', '1', 'nose', 4450.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(821, '2018-09-10', '2018', '15185766', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(822, '2018-09-10', '2018', '15185309', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(823, '2018-09-10', '2018', '15147622', '1', '1', 'nose', 2225.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(824, '2018-09-10', '2018', '15150331', '1', '1', 'nose', 28688.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(825, '2018-09-10', '2018', '15173653', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(826, '2018-09-10', '2018', '13160587', '1', '1', 'nose', 25875.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(827, '2018-09-10', '2018', '13172416', '1', '1', 'nose', 4200.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(828, '2018-09-10', '2018', '15185666', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(829, '2018-09-10', '2018', '15186240', '1', '1', 'nose', 3338.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(830, '2018-09-09', '2018', '14160731', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(832, '2018-09-09', '2018', '23161747', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(833, '2018-09-09', '2018', '13172446', '1', '1', 'nose', 2575.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(834, '2018-09-09', '2018', '15161718', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(835, '2018-09-08', '2018', '14186087', '1', '1', 'nose', 3325.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(836, '2018-09-08', '2018', '15172676', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(837, '2018-09-08', '2018', '15150108', '1', '1', 'nose', 3575.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(838, '2018-09-08', '2018', '15185523', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(839, '2018-09-08', '2018', '13184654', '1', '1', 'nose', 1698.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(840, '2018-09-08', '2018', '15160631', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(841, '2018-09-07', '2018', '15185577', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(842, '2018-09-07', '2018', '15185608', '1', '1', 'nose', 2794.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(843, '2018-09-07', '2018', '15160865', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(844, '2018-09-07', '2018', '14161326', '1', '1', 'nose', 665.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(845, '2018-09-07', '2018', '14186130', '1', '1', 'nose', 3325.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(846, '2018-09-07', '2018', '14184843', '1', '1', 'nose', 2260.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(847, '2018-09-07', '2018', '13161224', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(848, '2018-09-07', '2018', '15136083', '1', '1', 'nose', 5000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(850, '2018-09-07', '2018', '15136083', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(851, '2018-09-07', '2018', '15160721', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(852, '2018-09-06', '2018', '14136621', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(853, '2018-09-06', '2018', '15161535', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(854, '2018-09-06', '2018', '15147719', '1', '1', 'nose', 3560.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(855, '2018-09-06', '2018', '15160808', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(856, '2018-09-06', '2018', '15185132', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(857, '2018-09-06', '2018', '13186335', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(858, '2018-09-06', '2018', '14184455', '1', '1', 'nose', 2260.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(859, '2018-09-06', '2018', '14160704', '1', '1', 'nose', 3550.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(860, '2018-09-06', '2018', '15136923', '1', '1', 'nose', 3338.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(861, '2018-09-06', '2018', '15172670', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(862, '2018-09-06', '2018', '15185393', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(863, '2018-09-05', '2018', '23185583', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(864, '2018-09-05', '2018', '13185584', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(865, '2018-09-05', '2018', '14185196', '1', '1', 'nose', 3325.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(866, '2018-09-05', '2018', '14185684', '1', '1', 'nose', 1663.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(867, '2018-09-05', '2018', '14173940', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(868, '2018-09-05', '2018', '15172883', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(869, '2018-09-05', '2018', '15161516', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(870, '2018-09-05', '2018', '13174411', '1', '1', 'nose', 2425.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(871, '2018-09-05', '2018', '15185792', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(872, '2018-09-05', '2018', '15185433', '1', '1', 'nose', 2608.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(873, '2018-09-05', '2018', '15185575', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(874, '2018-09-05', '2018', '13124491', '1', '1', 'nose', 28683.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(875, '2018-09-05', '2018', '15147872', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(876, '2018-09-05', '2018', '13172474', '1', '1', 'nose', 2425.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(877, '2018-09-05', '2018', '15173162', '1', '1', 'nose', 2670.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(878, '2018-09-05', '2018', '15184886', '1', '1', 'nose', 2235.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(879, '2018-09-04', '2018', '15160657', '1', '1', 'nose', 3825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(880, '2018-09-04', '2018', '15162368', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(881, '2018-09-04', '2018', '15159885', '1', '1', 'nose', 4450.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(883, '2018-09-04', '2018', '15148419', '1', '1', 'nose', 2670.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(885, '2018-09-04', '2018', '15185223', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(886, '2018-09-04', '2018', '15160920', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(887, '2018-09-04', '2018', '15184502', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(888, '2018-09-04', '2018', '15172678', '1', '1', 'nose', 3350.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(889, '2018-09-04', '2018', '15160810', '1', '1', 'nose', 869.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(890, '2018-09-04', '2018', '13124505', '1', '1', 'nose', 2980.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(891, '2018-09-04', '2018', '13186335', '1', '1', 'nose', 3250.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(892, '2018-09-04', '2018', '15173654', '1', '1', 'nose', 3725.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(893, '2018-09-04', '2018', '13160801', '1', '1', 'nose', 10000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(894, '2018-09-04', '2018', '14124473', '1', '1', 'nose', 4450.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(895, '2018-09-04', '2018', '14185977', '1', '1', 'nose', 3325.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(896, '2018-09-04', '2018', '14184473', '1', '1', 'nose', 2825.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(897, '2018-09-04', '2018', '15135940', '1', '1', 'nose', 1558.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(898, '2018-09-03', '2018', '15186028', '1', '1', 'nose', 2225.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(899, '2018-09-03', '2018', '33161763', '1', '1', 'nose', 3925.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(900, '2018-09-03', '2018', '15136814', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(901, '2018-09-03', '2018', '14185307', '1', '1', 'nose', 1978.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(902, '2018-09-03', '2018', '15160719', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(903, '2018-09-03', '2018', '15173149', '1', '1', 'nose', 3200.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(904, '2018-09-03', '2018', '13136334', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(905, '2018-09-03', '2018', '13184582', '1', '1', 'nose', 26675.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(906, '2018-09-03', '2018', '15159598', '1', '1', 'nose', 3575.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(907, '2018-09-03', '2018', '15159598', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(908, '2018-09-30', '2018', '00003362', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(909, '2018-09-30', '2018', '00002973', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(910, '2018-09-30', '2018', '15150030', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(911, '2018-09-30', '2018', '00184609', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(913, '2018-09-29', '2018', '00003366', '1', '1', 'nose', 250.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(914, '2018-09-29', '2018', '00001917', '1', '1', 'nose', 300.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(915, '2018-09-29', '2018', '09186420', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(916, '2018-09-29', '2018', '15159530', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(918, '2018-09-28', '2018', '15159969', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(919, '2018-09-28', '2018', '15159254', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(921, '2018-09-28', '2018', '15147956', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(923, '2018-09-28', '2018', '15185518', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(924, '2018-09-28', '2018', '15186102', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(926, '2018-09-28', '2018', '14124501', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(928, '2018-09-28', '2018', '15991518', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(929, '2018-09-28', '2018', '15184938', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(931, '2018-09-28', '2018', '15184765', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(933, '2018-09-28', '2018', '15159257', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(934, '2018-09-28', '2018', '15159744', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:49', '2018-12-05 21:39:49', NULL),
(935, '2018-09-28', '2018', '15159185', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(936, '2018-09-28', '2018', '54148384', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(938, '2018-09-27', '2018', '00003432', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(939, '2018-09-27', '2018', '23185927', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(940, '2018-09-27', '2018', '52148394', '1', '1', 'nose', 3550.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(941, '2018-09-27', '2018', '13113958', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(943, '2018-09-27', '2018', '13173806', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(944, '2018-09-27', '2018', '15185350', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(946, '2018-09-27', '2018', '15185342', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(948, '2018-09-27', '2018', '15150052', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(949, '2018-09-27', '2018', '22102369', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(950, '2018-09-26', '2018', '00002889', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(951, '2018-09-26', '2018', '00003431', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(952, '2018-09-26', '2018', '13185715', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(953, '2018-09-26', '2018', '15161302', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(954, '2018-09-26', '2018', '12184750', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(955, '2018-09-26', '2018', '21184818', '1', '1', 'nose', 625.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(956, '2018-09-26', '2018', '00003422', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(957, '2018-09-26', '2018', '15159336', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(959, '2018-09-26', '2018', '15161221', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(960, '2018-09-26', '2018', '14124501', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(961, '2018-09-26', '2018', '15161221', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(962, '2018-09-26', '2018', '15184573', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(964, '2018-09-25', '2018', '00003395', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(965, '2018-09-25', '2018', '15159804', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(967, '2018-09-25', '2018', '00003470', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(968, '2018-09-25', '2018', '00003227', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(969, '2018-09-25', '2018', '00003478', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(970, '2018-09-25', '2018', '00003420', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(971, '2018-09-25', '2018', '00003419', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(972, '2018-09-25', '2018', '15185518', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(973, '2018-09-25', '2018', '12159023', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(975, '2018-09-24', '2018', '54148002', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(977, '2018-09-24', '2018', '15147363', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(979, '2018-09-24', '2018', '15148183', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(980, '2018-09-24', '2018', '00003317', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(981, '2018-09-24', '2018', '00003488', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(982, '2018-09-24', '2018', '00003388', '1', '1', 'nose', 300.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(983, '2018-09-24', '2018', '11125501', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(985, '2018-09-24', '2018', '11078853', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(987, '2018-09-24', '2018', '09186386', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(988, '2018-09-24', '2018', '15159889', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(989, '2018-09-24', '2018', '09186408', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(991, '2018-09-24', '2018', '12135804', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(992, '2018-09-23', '2018', '00172433', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(993, '2018-09-23', '2018', '00003421', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(994, '2018-09-22', '2018', '00003213', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(995, '2018-09-21', '2018', '00003481', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(996, '2018-09-21', '2018', '09186407', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(997, '2018-09-21', '2018', '15147637', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(998, '2018-09-21', '2018', '09186386', '1', '1', 'nose', 700.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(999, '2018-09-21', '2018', '13184725', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1000, '2018-09-20', '2018', '15150388', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1001, '2018-09-20', '2018', '62162360', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1002, '2018-09-20', '2018', '15161469', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1003, '2018-09-20', '2018', '09186338', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1004, '2018-09-20', '2018', '09186337', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1005, '2018-09-20', '2018', '31091541', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1006, '2018-09-20', '2018', '15147874', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1007, '2018-09-20', '2018', '00003484', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1008, '2018-09-20', '2018', '15161499', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1009, '2018-09-20', '2018', '15161370', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1010, '2018-09-20', '2018', '15161500', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1012, '2018-09-20', '2018', '09186355', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1013, '2018-09-20', '2018', '09186356', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1014, '2018-09-20', '2018', '09186409', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1015, '2018-09-20', '2018', '09186399', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1016, '2018-09-20', '2018', '15162080', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1018, '2018-09-20', '2018', '00002894', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1019, '2018-09-20', '2018', '12147828', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1021, '2018-09-20', '2018', '10184681', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1022, '2018-09-20', '2018', '00003375', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1023, '2018-09-20', '2018', '13101717', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1024, '2018-09-20', '2018', '00002446', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1025, '2018-09-20', '2018', '52160950', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1027, '2018-09-20', '2018', '00150365', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1028, '2018-09-20', '2018', '09186400', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1030, '2018-09-20', '2018', '15148183', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1031, '2018-09-20', '2018', '15150057', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1032, '2018-09-20', '2018', '00002259', '1', '1', 'nose', 500.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1033, '2018-09-20', '2018', '13184725', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1034, '2018-09-20', '2018', '00162221', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1035, '2018-09-20', '2018', '15147637', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1036, '2018-09-20', '2018', '15150058', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1037, '2018-09-20', '2018', '15172635', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1039, '2018-09-19', '2018', '00174263', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1041, '2018-09-19', '2018', '00003464', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1042, '2018-09-19', '2018', '09186393', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1043, '2018-09-19', '2018', '09186392', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1044, '2018-09-19', '2018', '00003435', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1045, '2018-09-19', '2018', '09186384', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1046, '2018-09-19', '2018', '15159943', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1047, '2018-09-19', '2018', '39186383', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1048, '2018-09-19', '2018', '15172835', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1050, '2018-09-19', '2018', '15159228', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1052, '2018-09-19', '2018', '32161676', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1054, '2018-09-19', '2018', '13101590', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1056, '2018-09-18', '2018', '09186353', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1057, '2018-09-18', '2018', '10162212', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1058, '2018-09-18', '2018', '00148767', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1060, '2018-09-18', '2018', '00172433', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1061, '2018-09-18', '2018', '34161988', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1062, '2018-09-18', '2018', '14159870', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1064, '2018-09-18', '2018', '09186399', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1065, '2018-09-18', '2018', '62160656', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1067, '2018-09-18', '2018', '54160647', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1068, '2018-09-18', '2018', '09186403', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1070, '2018-09-18', '2018', '31101559', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1071, '2018-09-18', '2018', '32185039', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1072, '2018-09-17', '2018', '00001463', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1073, '2018-09-17', '2018', '00003459', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1074, '2018-09-17', '2018', '00003198', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1075, '2018-09-17', '2018', '00003337', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1076, '2018-09-17', '2018', '11161805', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1077, '2018-09-17', '2018', '15172645', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1078, '2018-09-17', '2018', '14113133', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1079, '2018-09-17', '2018', '09186402', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1080, '2018-09-17', '2018', '15148015', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1081, '2018-09-17', '2018', '15159708', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1084, '2018-09-17', '2018', '15161679', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1085, '2018-09-17', '2018', '09186396', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1086, '2018-09-17', '2018', '15159294', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1087, '2018-09-17', '2018', '15159614', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1088, '2018-09-17', '2018', '54148190', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1090, '2018-09-17', '2018', '09186348', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1091, '2018-09-17', '2018', '15161751', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1092, '2018-09-17', '2018', '42172549', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1093, '2018-09-17', '2018', '12147260', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1094, '2018-09-16', '2018', '14124923', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1095, '2018-09-16', '2018', '15162061', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1097, '2018-09-16', '2018', '09186392', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1098, '2018-09-15', '2018', '15113767', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1099, '2018-09-15', '2018', '15161850', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1100, '2018-09-15', '2018', '00150378', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1101, '2018-09-15', '2018', '09186393', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1102, '2018-09-14', '2018', '31090725', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1103, '2018-09-14', '2018', '00174281', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1105, '2018-09-14', '2018', '12160664', '1', '1', 'nose', 400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1106, '2018-09-14', '2018', '31160665', '1', '1', 'nose', 800.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1107, '2018-09-14', '2018', '12147260', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1108, '2018-09-14', '2018', '13160585', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1109, '2018-09-14', '2018', '10162215', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1111, '2018-09-14', '2018', '09186398', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1112, '2018-09-14', '2018', '09186336', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1114, '2018-09-14', '2018', '12135804', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1115, '2018-09-14', '2018', '10160649', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1116, '2018-09-14', '2018', '15150052', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1118, '2018-09-13', '2018', '15150030', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1119, '2018-09-13', '2018', '00184672', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1120, '2018-09-13', '2018', '52159068', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1121, '2018-09-13', '2018', '22159069', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1122, '2018-09-13', '2018', '32135865', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1123, '2018-09-13', '2018', '12135762', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1124, '2018-09-13', '2018', '13135764', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1125, '2018-09-13', '2018', '15161499', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1126, '2018-09-13', '2018', '00001472', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1127, '2018-09-13', '2018', '10174242', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1128, '2018-09-13', '2018', '12101728', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1131, '2018-09-13', '2018', '13172502', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1133, '2018-09-13', '2018', '09186395', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1134, '2018-09-13', '2018', '13159054', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1136, '2018-09-13', '2018', '19186394', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1137, '2018-09-13', '2018', '00003473', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1138, '2018-09-13', '2018', '15159461', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1139, '2018-09-13', '2018', '00162224', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1140, '2018-09-13', '2018', '13161395', '1', '1', 'nose', 625.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1141, '2018-09-13', '2018', '13160603', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1142, '2018-09-12', '2018', '34161988', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1143, '2018-09-12', '2018', '31162359', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1144, '2018-09-12', '2018', '62162360', '1', '1', 'nose', 625.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1145, '2018-09-12', '2018', '62162360', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1146, '2018-09-12', '2018', '15159560', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1148, '2018-09-12', '2018', '09186356', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1149, '2018-09-12', '2018', '09186355', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1150, '2018-09-12', '2018', '00002584', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1151, '2018-09-12', '2018', '00002951', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1153, '2018-09-12', '2018', '13160815', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1155, '2018-09-12', '2018', '00002571', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1156, '2018-09-12', '2018', '15172947', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1157, '2018-09-12', '2018', '15161751', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1158, '2018-09-12', '2018', '09186337', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1159, '2018-09-12', '2018', '09186338', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1160, '2018-09-12', '2018', '15161469', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1161, '2018-09-12', '2018', '00003449', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1162, '2018-09-12', '2018', '15161353', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1163, '2018-09-12', '2018', '14174027', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1164, '2018-09-12', '2018', '52174186', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1165, '2018-09-11', '2018', '00003468', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1166, '2018-09-11', '2018', '00002955', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1167, '2018-09-11', '2018', '00003446', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1168, '2018-09-11', '2018', '00184608', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1169, '2018-09-11', '2018', '09186389', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1170, '2018-09-11', '2018', '15172991', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1172, '2018-09-11', '2018', '00003461', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1173, '2018-09-11', '2018', '00003474', '1', '1', 'nose', 250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1174, '2018-09-11', '2018', '54159659', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1176, '2018-09-11', '2018', '31090725', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1177, '2018-09-11', '2018', '00003458', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1178, '2018-09-11', '2018', '10158901', '1', '1', 'nose', 400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1179, '2018-09-11', '2018', '15148417', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1181, '2018-09-11', '2018', '15161703', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1183, '2018-09-11', '2018', '09186385', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1184, '2018-09-11', '2018', '00162233', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1187, '2018-09-11', '2018', '00003326', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1188, '2018-09-11', '2018', '33184447', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1189, '2018-09-11', '2018', '62184445', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1192, '2018-09-10', '2018', '15150077', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1193, '2018-09-10', '2018', '15161353', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1194, '2018-09-10', '2018', '15159185', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1195, '2018-09-10', '2018', '00003460', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1196, '2018-09-10', '2018', '00174282', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1198, '2018-09-10', '2018', '00174277', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1201, '2018-09-10', '2018', '15161005', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1203, '2018-09-10', '2018', '00001479', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1204, '2018-09-10', '2018', '00003467', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1205, '2018-09-10', '2018', '09186364', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1206, '2018-09-10', '2018', '00003465', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1207, '2018-09-09', '2018', '31101559', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1208, '2018-09-09', '2018', '00162232', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1209, '2018-09-09', '2018', '15172645', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1210, '2018-09-09', '2018', '13160603', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1211, '2018-09-08', '2018', '10160533', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1212, '2018-09-08', '2018', '12147753', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1213, '2018-09-08', '2018', '62147754', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1214, '2018-09-08', '2018', '09186382', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1216, '2018-09-08', '2018', '15161850', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1217, '2018-09-08', '2018', '12135738', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1219, '2018-09-08', '2018', '15159907', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1220, '2018-09-07', '2018', '15150058', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1221, '2018-09-07', '2018', '23172536', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1223, '2018-09-07', '2018', '00003466', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1224, '2018-09-07', '2018', '13135764', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1226, '2018-09-07', '2018', '32135865', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1228, '2018-09-07', '2018', '12135762', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1230, '2018-09-07', '2018', '52184519', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1231, '2018-09-07', '2018', '62184518', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1234, '2018-09-07', '2018', '15160712', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1235, '2018-09-06', '2018', '15159593', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL);
INSERT INTO `edocta` (`id`, `fec_oper_edo`, `anio_pago_edo`, `cve_pago_edo`, `mes_pago_edo`, `dig_pago_edo`, `descrip_edo`, `imp_abono_edo`, `imp_cargo_edo`, `estado_edo`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1236, '2018-09-06', '2018', '00174278', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1237, '2018-09-06', '2018', '10160545', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1238, '2018-09-06', '2018', '15161370', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1239, '2018-09-06', '2018', '31091541', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1240, '2018-09-06', '2018', '13101717', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1241, '2018-09-06', '2018', '10160649', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1242, '2018-09-06', '2018', '00150378', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1243, '2018-09-06', '2018', '13160585', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1244, '2018-09-06', '2018', '15113767', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1245, '2018-09-06', '2018', '15161804', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1246, '2018-09-06', '2018', '15161679', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1247, '2018-09-06', '2018', '21124301', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1248, '2018-09-06', '2018', '00162221', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1249, '2018-09-06', '2018', '00174240', '1', '1', 'nose', 625.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1250, '2018-09-06', '2018', '00174239', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1251, '2018-09-05', '2018', '42172549', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1252, '2018-09-05', '2018', '16185880', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1253, '2018-09-05', '2018', '00003451', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1254, '2018-09-05', '2018', '09186348', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1255, '2018-09-05', '2018', '00003428', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1256, '2018-09-05', '2018', '15150057', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1257, '2018-09-05', '2018', '16173450', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1259, '2018-09-05', '2018', '00003163', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1260, '2018-09-05', '2018', '00184608', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1261, '2018-09-05', '2018', '15172991', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1262, '2018-09-05', '2018', '31135966', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1264, '2018-09-05', '2018', '09186347', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1265, '2018-09-05', '2018', '09186354', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1267, '2018-09-04', '2018', '00003434', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1268, '2018-09-04', '2018', '19186358', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1269, '2018-09-04', '2018', '00003442', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1270, '2018-09-04', '2018', '00003430', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1271, '2018-09-04', '2018', '29186357', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1272, '2018-09-04', '2018', '00003426', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1273, '2018-09-04', '2018', '14173987', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1274, '2018-09-04', '2018', '20184625', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1277, '2018-09-04', '2018', '00001054', '1', '1', 'nose', 500.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1278, '2018-09-04', '2018', '00173178', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1279, '2018-09-03', '2018', '00186287', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1280, '2018-09-03', '2018', '00003180', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1281, '2018-09-03', '2018', '00002567', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1282, '2018-09-03', '2018', '15150030', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1283, '2018-09-03', '2018', '00002744', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1284, '2018-09-03', '2018', '00003452', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1285, '2018-09-03', '2018', '14113133', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1286, '2018-09-03', '2018', '00003439', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1287, '2018-09-03', '2018', '00003440', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1288, '2018-09-03', '2018', '15159582', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1290, '2018-09-03', '2018', '00002426', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1291, '2018-09-03', '2018', '19186358', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1292, '2018-09-03', '2018', '00003172', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1293, '2018-09-03', '2018', '09186353', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1294, '2018-09-03', '2018', '00174316', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1296, '2018-09-02', '2018', '00003445', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1297, '2018-09-02', '2018', '00003176', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1298, '2018-09-01', '2018', '00003443', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1299, '2018-09-01', '2018', '00003444', '1', '1', 'nose', 200.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1300, '2018-09-01', '2018', '00150364', '1', '1', 'nose', 650.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1301, '2018-09-29', '2018', '23173913', '1', '1', 'nose', 4425.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1302, '2018-09-28', '2018', '23173684', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1303, '2018-09-28', '2018', '42148875', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1304, '2018-09-28', '2018', '52162047', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1305, '2018-09-28', '2018', '13186036', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1306, '2018-09-27', '2018', '32136845', '1', '1', 'nose', 3578.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1307, '2018-09-27', '2018', '13185694', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1308, '2018-09-27', '2018', '52147775', '1', '1', 'nose', 2584.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1309, '2018-09-27', '2018', '33186372', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1310, '2018-09-26', '2018', '13184553', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1311, '2018-09-24', '2018', '62150209', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1312, '2018-09-24', '2018', '32136231', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1313, '2018-09-24', '2018', '13160732', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1314, '2018-09-22', '2018', '23173030', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1315, '2018-09-21', '2018', '13185414', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1316, '2018-09-21', '2018', '13159104', '1', '1', 'nose', 35000.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1317, '2018-09-20', '2018', '13172716', '1', '1', 'nose', 2400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1318, '2018-09-20', '2018', '13160734', '1', '1', 'nose', 2783.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1319, '2018-09-20', '2018', '62174339', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1320, '2018-09-20', '2018', '13173976', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1321, '2018-09-18', '2018', '52147449', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1322, '2018-09-18', '2018', '13160689', '1', '1', 'nose', 4275.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1323, '2018-09-18', '2018', '23186359', '1', '1', 'nose', 6450.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1324, '2018-09-18', '2018', '21080173', '1', '1', 'nose', 4440.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1325, '2018-09-17', '2018', '13173084', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1326, '2018-09-17', '2018', '52162184', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1327, '2018-09-17', '2018', '13173488', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1328, '2018-09-17', '2018', '62172547', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1329, '2018-09-17', '2018', '62162360', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1330, '2018-09-17', '2018', '23174197', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1331, '2018-09-17', '2018', '62159734', '1', '1', 'nose', 2385.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1332, '2018-09-17', '2018', '21090435', '1', '1', 'nose', 2385.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1333, '2018-09-17', '2018', '21090444', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1334, '2018-09-17', '2018', '52162104', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1335, '2018-09-17', '2018', '11089407', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1336, '2018-09-17', '2018', '12113710', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1337, '2018-09-17', '2018', '13172671', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1338, '2018-09-17', '2018', '12113474', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1339, '2018-09-17', '2018', '21090613', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1340, '2018-09-17', '2018', '11078897', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1341, '2018-09-17', '2018', '12101891', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1342, '2018-09-17', '2018', '12124922', '1', '1', 'nose', 2584.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1343, '2018-09-17', '2018', '11091455', '1', '1', 'nose', 2584.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1344, '2018-09-17', '2018', '13184667', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1345, '2018-09-17', '2018', '13174155', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1346, '2018-09-17', '2018', '13160596', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1347, '2018-09-17', '2018', '13184772', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1348, '2018-09-17', '2018', '13185987', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1349, '2018-09-17', '2018', '13185600', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1350, '2018-09-17', '2018', '11078401', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1351, '2018-09-17', '2018', '12112961', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1352, '2018-09-17', '2018', '13184864', '1', '1', 'nose', 28620.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1353, '2018-09-17', '2018', '13161103', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1354, '2018-09-17', '2018', '13172584', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1355, '2018-09-17', '2018', '12101812', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1356, '2018-09-17', '2018', '52159068', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1357, '2018-09-17', '2018', '13184541', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1358, '2018-09-17', '2018', '12101645', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1359, '2018-09-17', '2018', '31102580', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1360, '2018-09-17', '2018', '12124494', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1361, '2018-09-17', '2018', '13161132', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1362, '2018-09-17', '2018', '22136874', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1363, '2018-09-17', '2018', '31113131', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1364, '2018-09-17', '2018', '23173836', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1365, '2018-09-17', '2018', '31113484', '1', '1', 'nose', 2981.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1366, '2018-09-17', '2018', '12148206', '1', '1', 'nose', 2981.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1367, '2018-09-17', '2018', '12124638', '1', '1', 'nose', 2385.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1368, '2018-09-17', '2018', '13186237', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1369, '2018-09-17', '2018', '12135903', '1', '1', 'nose', 2981.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1370, '2018-09-17', '2018', '13184725', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1371, '2018-09-17', '2018', '11089532', '1', '1', 'nose', 1193.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1372, '2018-09-17', '2018', '13173841', '1', '1', 'nose', 2981.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1373, '2018-09-17', '2018', '12101738', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1374, '2018-09-17', '2018', '12147312', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1375, '2018-09-17', '2018', '42159620', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1376, '2018-09-17', '2018', '31113716', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1377, '2018-09-17', '2018', '11090584', '1', '1', 'nose', 2385.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1378, '2018-09-17', '2018', '12101815', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1387, '2018-09-17', '2018', '21101816', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1396, '2018-09-17', '2018', '13160604', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1397, '2018-09-17', '2018', '11101543', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1398, '2018-09-17', '2018', '11090410', '1', '1', 'nose', 2385.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1399, '2018-09-17', '2018', '13184773', '1', '1', 'nose', 2783.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1400, '2018-09-17', '2018', '13172823', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1401, '2018-09-17', '2018', '13161104', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1402, '2018-09-17', '2018', '31091541', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1403, '2018-09-17', '2018', '42136639', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1404, '2018-09-16', '2018', '12124315', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1405, '2018-09-16', '2018', '13160601', '1', '1', 'nose', 2981.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1406, '2018-09-16', '2018', '62161570', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1407, '2018-09-16', '2018', '12135831', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1408, '2018-09-15', '2018', '62161686', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1409, '2018-09-15', '2018', '13172509', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1410, '2018-09-15', '2018', '23174430', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1411, '2018-09-15', '2018', '22136604', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1412, '2018-09-15', '2018', '24186022', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1413, '2018-09-15', '2018', '13172712', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1414, '2018-09-15', '2018', '52162328', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1415, '2018-09-14', '2018', '13184550', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1416, '2018-09-14', '2018', '13172504', '1', '1', 'nose', 28620.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1417, '2018-09-14', '2018', '13160736', '1', '1', 'nose', 2186.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1418, '2018-09-14', '2018', '31090725', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1419, '2018-09-14', '2018', '12124418', '1', '1', 'nose', 795.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1420, '2018-09-14', '2018', '12102151', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1421, '2018-09-14', '2018', '12124302', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1422, '2018-09-14', '2018', '31113193', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1423, '2018-09-14', '2018', '12101820', '1', '1', 'nose', 596.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1424, '2018-09-14', '2018', '62173173', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1425, '2018-09-14', '2018', '21079260', '1', '1', 'nose', 2783.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1426, '2018-09-14', '2018', '13186301', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1427, '2018-09-14', '2018', '13185715', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1428, '2018-09-14', '2018', '23173707', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1429, '2018-09-14', '2018', '13160600', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1430, '2018-09-14', '2018', '13184537', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1431, '2018-09-14', '2018', '13161103', '1', '1', 'nose', 6450.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1432, '2018-09-14', '2018', '13172713', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1433, '2018-09-14', '2018', '32136231', '1', '1', 'nose', 2400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1434, '2018-09-14', '2018', '13161011', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1435, '2018-09-14', '2018', '13172508', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1436, '2018-09-14', '2018', '12101723', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1437, '2018-09-14', '2018', '13160585', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1438, '2018-09-14', '2018', '13161507', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1439, '2018-09-14', '2018', '12091255', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1440, '2018-09-14', '2018', '12147828', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1441, '2018-09-14', '2018', '23174331', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1442, '2018-09-14', '2018', '62172447', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1443, '2018-09-14', '2018', '12124987', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1444, '2018-09-14', '2018', '00148811', '1', '1', 'nose', 2385.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1445, '2018-09-14', '2018', '12124316', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1446, '2018-09-14', '2018', '12135804', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1447, '2018-09-14', '2018', '52148322', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1448, '2018-09-14', '2018', '32136563', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1449, '2018-09-14', '2018', '32136610', '1', '1', 'nose', 994.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1450, '2018-09-14', '2018', '42147201', '1', '1', 'nose', 3379.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1451, '2018-09-14', '2018', '33184484', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1452, '2018-09-14', '2018', '13160660', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1453, '2018-09-14', '2018', '12160636', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1454, '2018-09-14', '2018', '12124260', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1455, '2018-09-14', '2018', '52160950', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1456, '2018-09-14', '2018', '13160591', '1', '1', 'nose', 2981.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1457, '2018-09-13', '2018', '13160759', '1', '1', 'nose', 6450.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1458, '2018-09-13', '2018', '32136845', '1', '1', 'nose', 6450.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1459, '2018-09-13', '2018', '11078662', '1', '1', 'nose', 32202.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1460, '2018-09-13', '2018', '23173185', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1461, '2018-09-13', '2018', '13185264', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1463, '2018-09-13', '2018', '13160594', '1', '1', 'nose', 2783.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1464, '2018-09-13', '2018', '13184552', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1465, '2018-09-13', '2018', '12101728', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1466, '2018-09-13', '2018', '11078602', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1467, '2018-09-13', '2018', '42136232', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1468, '2018-09-13', '2018', '23185762', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1469, '2018-09-13', '2018', '12101585', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1470, '2018-09-13', '2018', '52158899', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1471, '2018-09-13', '2018', '32158898', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1472, '2018-09-13', '2018', '32136193', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1473, '2018-09-13', '2018', '12147290', '1', '1', 'nose', 2981.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1482, '2018-09-13', '2018', '12101710', '1', '1', 'nose', 2783.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1483, '2018-09-13', '2018', '12112834', '1', '1', 'nose', 28620.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1484, '2018-09-13', '2018', '32147234', '1', '1', 'nose', 35775.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1485, '2018-09-13', '2018', '13173288', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1486, '2018-09-13', '2018', '33186052', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1487, '2018-09-13', '2018', '13161395', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1488, '2018-09-13', '2018', '12124825', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1489, '2018-09-13', '2018', '00162224', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1490, '2018-09-13', '2018', '13160603', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1491, '2018-09-13', '2018', '12124267', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1492, '2018-09-13', '2018', '13184554', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1493, '2018-09-12', '2018', '13184771', '1', '1', 'nose', 2783.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1494, '2018-09-12', '2018', '13161103', '1', '1', 'nose', 5800.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1495, '2018-09-12', '2018', '13184922', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1496, '2018-09-12', '2018', '52147775', '1', '1', 'nose', 6450.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1497, '2018-09-12', '2018', '13161656', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1498, '2018-09-12', '2018', '12124649', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1499, '2018-09-12', '2018', '12124650', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1500, '2018-09-12', '2018', '13161974', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1501, '2018-09-12', '2018', '23184927', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1502, '2018-09-12', '2018', '13185447', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1503, '2018-09-12', '2018', '13184876', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1504, '2018-09-12', '2018', '12124363', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1505, '2018-09-12', '2018', '12124178', '1', '1', 'nose', 17892.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1506, '2018-09-12', '2018', '12113635', '1', '1', 'nose', 2783.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1507, '2018-09-12', '2018', '12124843', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1508, '2018-09-11', '2018', '13160599', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1509, '2018-09-11', '2018', '52162142', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1510, '2018-09-11', '2018', '21101601', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1515, '2018-09-11', '2018', '12112855', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1516, '2018-09-11', '2018', '13184875', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1517, '2018-09-11', '2018', '42136719', '1', '1', 'nose', 17888.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1518, '2018-09-11', '2018', '11113115', '1', '1', 'nose', 35775.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1519, '2018-09-11', '2018', '23173382', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1520, '2018-09-11', '2018', '62150455', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1521, '2018-09-11', '2018', '13173806', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1522, '2018-09-11', '2018', '32148216', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1523, '2018-09-10', '2018', '62174118', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1524, '2018-09-10', '2018', '62161475', '1', '1', 'nose', 28620.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1525, '2018-09-10', '2018', '52161474', '1', '1', 'nose', 35775.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1526, '2018-09-10', '2018', '62173065', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1527, '2018-09-10', '2018', '13160595', '1', '1', 'nose', 17892.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1528, '2018-09-10', '2018', '13161722', '1', '1', 'nose', 6450.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1529, '2018-09-10', '2018', '13160737', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1530, '2018-09-10', '2018', '13160737', '1', '1', 'nose', 35775.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1531, '2018-09-10', '2018', '11078409', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1541, '2018-09-10', '2018', '13184842', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1542, '2018-09-10', '2018', '13173743', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1543, '2018-09-10', '2018', '13160648', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1544, '2018-09-10', '2018', '13160598', '1', '1', 'nose', 2783.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1545, '2018-09-10', '2018', '13160605', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1546, '2018-09-09', '2018', '13172506', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1547, '2018-09-08', '2018', '32136760', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1548, '2018-09-07', '2018', '13172716', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1549, '2018-09-07', '2018', '13160738', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1550, '2018-09-07', '2018', '13160738', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1551, '2018-09-07', '2018', '23173030', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1552, '2018-09-07', '2018', '23172536', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1553, '2018-09-07', '2018', '13184770', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1554, '2018-09-07', '2018', '13161174', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1555, '2018-09-07', '2018', '33186309', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1556, '2018-09-07', '2018', '33185567', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1557, '2018-09-07', '2018', '62160500', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1558, '2018-09-06', '2018', '11089499', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1559, '2018-09-06', '2018', '13184544', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1560, '2018-09-06', '2018', '12112908', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1561, '2018-09-06', '2018', '13173693', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1562, '2018-09-06', '2018', '13185767', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1563, '2018-09-06', '2018', '12113552', '1', '1', 'nose', 6450.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1564, '2018-09-06', '2018', '32136231', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1565, '2018-09-06', '2018', '23185138', '1', '1', 'nose', 35775.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1566, '2018-09-06', '2018', '13160717', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1575, '2018-09-06', '2018', '13160606', '1', '1', 'nose', 17892.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1576, '2018-09-05', '2018', '33186372', '1', '1', 'nose', 6450.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1577, '2018-09-05', '2018', '11067898', '1', '1', 'nose', 78263.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1578, '2018-09-05', '2018', '13173991', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1579, '2018-09-05', '2018', '42147451', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1580, '2018-09-05', '2018', '62147520', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1581, '2018-09-05', '2018', '13184539', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1582, '2018-09-05', '2018', '13173371', '1', '1', 'nose', 3180.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1583, '2018-09-05', '2018', '13184774', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1584, '2018-09-05', '2018', '24173083', '1', '1', 'nose', 1988.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1585, '2018-09-04', '2018', '23173684', '1', '1', 'nose', 6450.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1586, '2018-09-04', '2018', '23174165', '1', '1', 'nose', 3975.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1587, '2018-09-30', '2018', '15161745', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1588, '2018-09-29', '2018', '15174214', '1', '1', 'nose', 7100.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1589, '2018-09-29', '2018', '15161343', '1', '1', 'nose', 7840.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1590, '2018-09-29', '2018', '15185507', '1', '1', 'nose', 7100.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1591, '2018-09-29', '2018', '13124252', '1', '1', 'nose', 1980.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1592, '2018-09-29', '2018', '15173447', '1', '1', 'nose', 6890.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1593, '2018-09-28', '2018', '15172762', '1', '1', 'nose', 7690.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1594, '2018-09-28', '2018', '15185199', '1', '1', 'nose', 6100.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1595, '2018-09-28', '2018', '15159664', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1596, '2018-09-28', '2018', '15161530', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1597, '2018-09-28', '2018', '15159189', '1', '1', 'nose', 5840.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1598, '2018-09-28', '2018', '13114004', '1', '1', 'nose', 66800.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1599, '2018-09-28', '2018', '15173348', '1', '1', 'nose', 6890.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1600, '2018-09-28', '2018', '15161440', '1', '1', 'nose', 4478.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1601, '2018-09-28', '2018', '15148351', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1602, '2018-09-28', '2018', '15185851', '1', '1', 'nose', 5280.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1603, '2018-09-28', '2018', '15136159', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1604, '2018-09-28', '2018', '15186286', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1605, '2018-09-28', '2018', '15161659', '1', '1', 'nose', 4888.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1606, '2018-09-28', '2018', '42034739', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1607, '2018-09-28', '2018', '15159321', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1608, '2018-09-28', '2018', '15161606', '1', '1', 'nose', 7690.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1609, '2018-09-28', '2018', '15159433', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1610, '2018-09-28', '2018', '15174292', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1611, '2018-09-28', '2018', '15159945', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1612, '2018-09-28', '2018', '15173823', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1613, '2018-09-28', '2018', '15148437', '1', '1', 'nose', 5250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1614, '2018-09-28', '2018', '15185440', '1', '1', 'nose', 6020.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1615, '2018-09-28', '2018', '15173009', '1', '1', 'nose', 7690.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1616, '2018-09-28', '2018', '15078824', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1617, '2018-09-28', '2018', '15173196', '1', '1', 'nose', 5353.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1618, '2018-09-28', '2018', '15173481', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1619, '2018-09-28', '2018', '15172651', '1', '1', 'nose', 4920.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1620, '2018-09-28', '2018', '15173941', '1', '1', 'nose', 6890.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1621, '2018-09-28', '2018', '15159509', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1622, '2018-09-28', '2018', '15185919', '1', '1', 'nose', 7690.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1623, '2018-09-28', '2018', '15186124', '1', '1', 'nose', 6020.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1624, '2018-09-28', '2018', '15136339', '1', '1', 'nose', 74160.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1625, '2018-09-28', '2018', '15148483', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1626, '2018-09-28', '2018', '15186007', '1', '1', 'nose', 6900.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1627, '2018-09-28', '2018', '15185814', '1', '1', 'nose', 66800.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1628, '2018-09-28', '2018', '15161821', '1', '1', 'nose', 3450.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1629, '2018-09-28', '2018', '14124503', '1', '1', 'nose', 5340.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1630, '2018-09-28', '2018', '54148384', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1631, '2018-09-28', '2018', '15147393', '1', '1', 'nose', 2238.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1632, '2018-09-28', '2018', '22078597', '1', '1', 'nose', 740.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1633, '2018-09-28', '2018', '15173858', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1634, '2018-09-28', '2018', '15185329', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1635, '2018-09-27', '2018', '15159312', '1', '1', 'nose', 7690.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1636, '2018-09-27', '2018', '15159759', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1637, '2018-09-27', '2018', '15173245', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1638, '2018-09-27', '2018', '15173931', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1639, '2018-09-27', '2018', '15159546', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1640, '2018-09-27', '2018', '15186375', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1641, '2018-09-27', '2018', '15159370', '1', '1', 'nose', 41400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1642, '2018-09-27', '2018', '15159658', '1', '1', 'nose', 53300.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1643, '2018-09-27', '2018', '15160621', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1644, '2018-09-27', '2018', '15090549', '1', '1', 'nose', 2000.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1645, '2018-09-27', '2018', '15148262', '1', '1', 'nose', 1020.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1646, '2018-09-27', '2018', '15173234', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1647, '2018-09-27', '2018', '14090529', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1648, '2018-09-27', '2018', '15159495', '1', '1', 'nose', 4080.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1649, '2018-09-27', '2018', '15162100', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1650, '2018-09-27', '2018', '15159539', '1', '1', 'nose', 2550.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1651, '2018-09-27', '2018', '15136529', '1', '1', 'nose', 250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1652, '2018-09-27', '2018', '15186341', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1653, '2018-09-27', '2018', '15148188', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1654, '2018-09-27', '2018', '15161693', '1', '1', 'nose', 7690.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1655, '2018-09-27', '2018', '15173801', '1', '1', 'nose', 8000.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1656, '2018-09-27', '2018', '15136069', '1', '1', 'nose', 250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1657, '2018-09-27', '2018', '05159502', '1', '1', 'nose', 6900.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1658, '2018-09-27', '2018', '15159513', '1', '1', 'nose', 6500.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1659, '2018-09-27', '2018', '15185381', '1', '1', 'nose', 250.00, 0.00, 'V', 1, '2018-12-05 21:39:50', '2018-12-05 21:39:50', NULL),
(1660, '2018-09-27', '2018', '15161501', '1', '1', 'nose', 250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1661, '2018-09-27', '2018', '15161115', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1662, '2018-09-27', '2018', '15102522', '1', '1', 'nose', 3000.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL);
INSERT INTO `edocta` (`id`, `fec_oper_edo`, `anio_pago_edo`, `cve_pago_edo`, `mes_pago_edo`, `dig_pago_edo`, `descrip_edo`, `imp_abono_edo`, `imp_cargo_edo`, `estado_edo`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1663, '2018-09-27', '2018', '15150052', '1', '1', 'nose', 5840.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1664, '2018-09-26', '2018', '15160762', '1', '1', 'nose', 250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1665, '2018-09-26', '2018', '15172820', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1666, '2018-09-26', '2018', '15159810', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1667, '2018-09-26', '2018', '15148692', '1', '1', 'nose', 20000.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1668, '2018-09-26', '2018', '15136853', '1', '1', 'nose', 250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1669, '2018-09-26', '2018', '11013128', '1', '1', 'nose', 6900.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1670, '2018-09-26', '2018', '15186187', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1671, '2018-09-26', '2018', '15185825', '1', '1', 'nose', 7340.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1672, '2018-09-26', '2018', '15186298', '1', '1', 'nose', 3300.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1673, '2018-09-26', '2018', '15184928', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1674, '2018-09-26', '2018', '07173161', '1', '1', 'nose', 7500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1675, '2018-09-26', '2018', '15159327', '1', '1', 'nose', 3290.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1677, '2018-09-26', '2018', '14147886', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1678, '2018-09-26', '2018', '15159999', '1', '1', 'nose', 94000.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1679, '2018-09-26', '2018', '11990002', '1', '1', 'nose', 2780.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1680, '2018-09-26', '2018', '11990032', '1', '1', 'nose', 250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1681, '2018-09-26', '2018', '15159472', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1682, '2018-09-26', '2018', '15172783', '1', '1', 'nose', 3815.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1683, '2018-09-26', '2018', '15185114', '1', '1', 'nose', 4290.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1684, '2018-09-26', '2018', '15159498', '1', '1', 'nose', 5840.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1685, '2018-09-26', '2018', '15161780', '1', '1', 'nose', 2365.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1689, '2018-09-26', '2018', '15147673', '1', '1', 'nose', 250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1690, '2018-09-26', '2018', '15159777', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1691, '2018-09-26', '2018', '15159777', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1692, '2018-09-25', '2018', '15147813', '1', '1', 'nose', 250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1693, '2018-09-25', '2018', '15185826', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1694, '2018-09-25', '2018', '15185448', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1695, '2018-09-25', '2018', '15159908', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1696, '2018-09-25', '2018', '15136003', '1', '1', 'nose', 250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1697, '2018-09-25', '2018', '15185752', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1698, '2018-09-25', '2018', '15161715', '1', '1', 'nose', 1150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1699, '2018-09-25', '2018', '15185957', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1700, '2018-09-25', '2018', '15173249', '1', '1', 'nose', 3998.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1701, '2018-09-25', '2018', '15159593', '1', '1', 'nose', 4820.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1702, '2018-09-25', '2018', '15159643', '1', '1', 'nose', 3290.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1703, '2018-09-25', '2018', '15172708', '1', '1', 'nose', 3815.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1704, '2018-09-25', '2018', '15161119', '1', '1', 'nose', 5750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1705, '2018-09-25', '2018', '15159449', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1706, '2018-09-25', '2018', '15173013', '1', '1', 'nose', 6890.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1707, '2018-09-25', '2018', '15124751', '1', '1', 'nose', 895.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1708, '2018-09-25', '2018', '15172907', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1709, '2018-09-25', '2018', '15174059', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1710, '2018-09-25', '2018', '15024589', '1', '1', 'nose', 5000.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1711, '2018-09-25', '2018', '15185798', '1', '1', 'nose', 250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1712, '2018-09-25', '2018', '15173364', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1713, '2018-09-25', '2018', '15150206', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1714, '2018-09-24', '2018', '15159617', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1715, '2018-09-24', '2018', '54174063', '1', '1', 'nose', 8640.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1716, '2018-09-24', '2018', '15173872', '1', '1', 'nose', 2153.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1717, '2018-09-24', '2018', '15185487', '1', '1', 'nose', 7690.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1718, '2018-09-24', '2018', '15161422', '1', '1', 'nose', 7690.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1719, '2018-09-24', '2018', '15148311', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1720, '2018-09-24', '2018', '14136700', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1721, '2018-09-24', '2018', '15159937', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1722, '2018-09-24', '2018', '15150214', '1', '1', 'nose', 5250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1723, '2018-09-24', '2018', '15159508', '1', '1', 'nose', 1400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1724, '2018-09-24', '2018', '15148437', '1', '1', 'nose', 6900.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1725, '2018-09-24', '2018', '15161440', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1726, '2018-09-24', '2018', '15174138', '1', '1', 'nose', 3690.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1727, '2018-09-24', '2018', '15172831', '1', '1', 'nose', 36180.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1728, '2018-09-24', '2018', '15148607', '1', '1', 'nose', 19500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1729, '2018-09-24', '2018', '15185654', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1730, '2018-09-24', '2018', '15148578', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1731, '2018-09-24', '2018', '15161230', '1', '1', 'nose', 33950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1732, '2018-09-24', '2018', '15185450', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1733, '2018-09-24', '2018', '15173069', '1', '1', 'nose', 26400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1734, '2018-09-24', '2018', '15159432', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1735, '2018-09-24', '2018', '15150225', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1736, '2018-09-24', '2018', '15160772', '1', '1', 'nose', 7690.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1737, '2018-09-24', '2018', '15148521', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1738, '2018-09-23', '2018', '15161152', '1', '1', 'nose', 5750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1739, '2018-09-23', '2018', '15159745', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1740, '2018-09-22', '2018', '15159454', '1', '1', 'nose', 1020.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1741, '2018-09-22', '2018', '15161646', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1742, '2018-09-21', '2018', '15150142', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1743, '2018-09-21', '2018', '15185310', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1744, '2018-09-21', '2018', '15186098', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1745, '2018-09-21', '2018', '15160527', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1746, '2018-09-21', '2018', '14091349', '1', '1', 'nose', 39400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1747, '2018-09-21', '2018', '15172606', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1748, '2018-09-21', '2018', '15159498', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1749, '2018-09-21', '2018', '15150111', '1', '1', 'nose', 5840.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1750, '2018-09-21', '2018', '15161667', '1', '1', 'nose', 740.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1752, '2018-09-21', '2018', '15185728', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1753, '2018-09-21', '2018', '15185469', '1', '1', 'nose', 6020.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1754, '2018-09-21', '2018', '14113727', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1755, '2018-09-21', '2018', '14113727', '1', '1', 'nose', 29450.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1756, '2018-09-21', '2018', '10185297', '1', '1', 'nose', 1400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1757, '2018-09-21', '2018', '15161305', '1', '1', 'nose', 33020.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1758, '2018-09-20', '2018', '15150271', '1', '1', 'nose', 3240.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1759, '2018-09-20', '2018', '15159790', '1', '1', 'nose', 2200.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1760, '2018-09-20', '2018', '17184857', '1', '1', 'nose', 1400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1761, '2018-09-20', '2018', '15185597', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1762, '2018-09-20', '2018', '17185014', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1763, '2018-09-20', '2018', '15159287', '1', '1', 'nose', 1400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1764, '2018-09-20', '2018', '15185580', '1', '1', 'nose', 7690.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1765, '2018-09-20', '2018', '10185139', '1', '1', 'nose', 1400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1766, '2018-09-20', '2018', '15161531', '1', '1', 'nose', 7690.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1767, '2018-09-20', '2018', '15161072', '1', '1', 'nose', 3328.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1768, '2018-09-20', '2018', '15186327', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1769, '2018-09-20', '2018', '15161782', '1', '1', 'nose', 3040.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1770, '2018-09-20', '2018', '15150163', '1', '1', 'nose', 11200.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1771, '2018-09-20', '2018', '15150353', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1772, '2018-09-20', '2018', '15186344', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1773, '2018-09-20', '2018', '15160891', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1774, '2018-09-20', '2018', '15148489', '1', '1', 'nose', 7690.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1775, '2018-09-20', '2018', '15161896', '1', '1', 'nose', 5628.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1776, '2018-09-20', '2018', '15160504', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1777, '2018-09-20', '2018', '15150014', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1778, '2018-09-19', '2018', '15161772', '1', '1', 'nose', 3615.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1781, '2018-09-19', '2018', '14159972', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1782, '2018-09-19', '2018', '15162091', '1', '1', 'nose', 23000.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1783, '2018-09-19', '2018', '14125165', '1', '1', 'nose', 5400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1784, '2018-09-19', '2018', '15150009', '1', '1', 'nose', 20000.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1785, '2018-09-19', '2018', '15148521', '1', '1', 'nose', 4475.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1787, '2018-09-19', '2018', '15172656', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1788, '2018-09-19', '2018', '15090772', '1', '1', 'nose', 895.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1789, '2018-09-19', '2018', '14150081', '1', '1', 'nose', 6020.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1790, '2018-09-19', '2018', '15150149', '1', '1', 'nose', 20000.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1791, '2018-09-19', '2018', '15161356', '1', '1', 'nose', 59150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1792, '2018-09-19', '2018', '13113241', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1793, '2018-09-19', '2018', '15091239', '1', '1', 'nose', 6000.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1794, '2018-09-19', '2018', '15102452', '1', '1', 'nose', 4475.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1795, '2018-09-19', '2018', '15173605', '1', '1', 'nose', 4430.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1796, '2018-09-19', '2018', '15161510', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1797, '2018-09-18', '2018', '15135939', '1', '1', 'nose', 250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1798, '2018-09-18', '2018', '15147874', '1', '1', 'nose', 4320.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1799, '2018-09-18', '2018', '15161285', '1', '1', 'nose', 6490.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1800, '2018-09-18', '2018', '11013121', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1801, '2018-09-18', '2018', '19186405', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1802, '2018-09-18', '2018', '15173461', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1803, '2018-09-18', '2018', '15185903', '1', '1', 'nose', 6950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1804, '2018-09-18', '2018', '15147689', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1805, '2018-09-18', '2018', '15172629', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1806, '2018-09-18', '2018', '15150101', '1', '1', 'nose', 21800.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1807, '2018-09-18', '2018', '15173561', '1', '1', 'nose', 13000.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1808, '2018-09-18', '2018', '15172919', '1', '1', 'nose', 6900.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1809, '2018-09-18', '2018', '13112987', '1', '1', 'nose', 740.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1810, '2018-09-18', '2018', '15173483', '1', '1', 'nose', 38150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1811, '2018-09-18', '2018', '23102135', '1', '1', 'nose', 740.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1812, '2018-09-18', '2018', '13113001', '1', '1', 'nose', 48917.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1813, '2018-09-18', '2018', '15185546', '1', '1', 'nose', 4040.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1814, '2018-09-18', '2018', '15159279', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1815, '2018-09-18', '2018', '17185143', '1', '1', 'nose', 1400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1816, '2018-09-18', '2018', '15174287', '1', '1', 'nose', 1230.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1817, '2018-09-17', '2018', '15136484', '1', '1', 'nose', 3425.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1818, '2018-09-17', '2018', '15174121', '1', '1', 'nose', 3690.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1819, '2018-09-17', '2018', '15159368', '1', '1', 'nose', 5840.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1820, '2018-09-17', '2018', '15148562', '1', '1', 'nose', 5215.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1821, '2018-09-17', '2018', '15172571', '1', '1', 'nose', 5750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1822, '2018-09-17', '2018', '15161442', '1', '1', 'nose', 5750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1823, '2018-09-17', '2018', '15159260', '1', '1', 'nose', 2550.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1824, '2018-09-17', '2018', '15185344', '1', '1', 'nose', 4620.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1825, '2018-09-17', '2018', '15159157', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1826, '2018-09-17', '2018', '15160503', '1', '1', 'nose', 5215.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1827, '2018-09-17', '2018', '15147284', '1', '1', 'nose', 5215.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1828, '2018-09-17', '2018', '15161663', '1', '1', 'nose', 1150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1829, '2018-09-17', '2018', '14148115', '1', '1', 'nose', 3815.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1830, '2018-09-17', '2018', '14125295', '1', '1', 'nose', 3290.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1831, '2018-09-17', '2018', '15161561', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1832, '2018-09-17', '2018', '15161145', '1', '1', 'nose', 5750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1833, '2018-09-17', '2018', '15161626', '1', '1', 'nose', 6490.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1834, '2018-09-17', '2018', '15185857', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1835, '2018-09-17', '2018', '15174034', '1', '1', 'nose', 6890.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1836, '2018-09-17', '2018', '15172993', '1', '1', 'nose', 3075.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1837, '2018-09-17', '2018', '15161515', '1', '1', 'nose', 5750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1838, '2018-09-17', '2018', '15161425', '1', '1', 'nose', 5340.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1839, '2018-09-17', '2018', '15185186', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1840, '2018-09-17', '2018', '15186272', '1', '1', 'nose', 7340.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1841, '2018-09-17', '2018', '15161469', '1', '1', 'nose', 4190.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1842, '2018-09-17', '2018', '15150257', '1', '1', 'nose', 2550.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1843, '2018-09-17', '2018', '13124187', '1', '1', 'nose', 3960.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1844, '2018-09-17', '2018', '15159555', '1', '1', 'nose', 5840.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1845, '2018-09-17', '2018', '14124520', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1846, '2018-09-17', '2018', '15159911', '1', '1', 'nose', 1863.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1847, '2018-09-17', '2018', '15172786', '1', '1', 'nose', 3690.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1848, '2018-09-17', '2018', '15161501', '1', '1', 'nose', 4600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1849, '2018-09-17', '2018', '15161100', '1', '1', 'nose', 3615.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1850, '2018-09-17', '2018', '15162048', '1', '1', 'nose', 2013.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1851, '2018-09-17', '2018', '15161279', '1', '1', 'nose', 5750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1852, '2018-09-17', '2018', '15173229', '1', '1', 'nose', 3998.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1853, '2018-09-17', '2018', '15162126', '1', '1', 'nose', 6490.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1854, '2018-09-17', '2018', '14150065', '1', '1', 'nose', 5280.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1855, '2018-09-17', '2018', '15150175', '1', '1', 'nose', 5840.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1856, '2018-09-17', '2018', '13136384', '1', '1', 'nose', 4700.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1857, '2018-09-17', '2018', '15161289', '1', '1', 'nose', 4888.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1858, '2018-09-17', '2018', '15148652', '1', '1', 'nose', 4475.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1859, '2018-09-17', '2018', '15186279', '1', '1', 'nose', 7340.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1860, '2018-09-17', '2018', '52024540', '1', '1', 'nose', 7340.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1861, '2018-09-17', '2018', '15161846', '1', '1', 'nose', 3450.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1862, '2018-09-17', '2018', '15174025', '1', '1', 'nose', 5280.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1863, '2018-09-17', '2018', '15150083', '1', '1', 'nose', 5840.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1864, '2018-09-17', '2018', '15159780', '1', '1', 'nose', 5840.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1865, '2018-09-17', '2018', '31024538', '1', '1', 'nose', 3290.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1866, '2018-09-17', '2018', '15161754', '1', '1', 'nose', 6490.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1867, '2018-09-17', '2018', '15160497', '1', '1', 'nose', 3580.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1868, '2018-09-17', '2018', '34148359', '1', '1', 'nose', 3615.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1869, '2018-09-17', '2018', '15147673', '1', '1', 'nose', 2238.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1870, '2018-09-17', '2018', '54147183', '1', '1', 'nose', 5840.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1871, '2018-09-17', '2018', '15124828', '1', '1', 'nose', 3133.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1872, '2018-09-17', '2018', '15159441', '1', '1', 'nose', 2238.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1873, '2018-09-17', '2018', '15159709', '1', '1', 'nose', 4080.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1874, '2018-09-17', '2018', '15160850', '1', '1', 'nose', 5900.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1875, '2018-09-17', '2018', '15173239', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1876, '2018-09-17', '2018', '15159969', '1', '1', 'nose', 3290.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1877, '2018-09-17', '2018', '15173539', '1', '1', 'nose', 6890.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1878, '2018-09-17', '2018', '15173241', '1', '1', 'nose', 6890.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1879, '2018-09-17', '2018', '15159372', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1880, '2018-09-17', '2018', '15185204', '1', '1', 'nose', 4040.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1881, '2018-09-17', '2018', '14113810', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1882, '2018-09-17', '2018', '15147956', '1', '1', 'nose', 2978.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1883, '2018-09-17', '2018', '15173618', '1', '1', 'nose', 4430.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1884, '2018-09-17', '2018', '11034848', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1885, '2018-09-17', '2018', '13113958', '1', '1', 'nose', 5280.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1886, '2018-09-17', '2018', '13101751', '1', '1', 'nose', 3615.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1887, '2018-09-17', '2018', '11991926', '1', '1', 'nose', 1790.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1888, '2018-09-17', '2018', '15161865', '1', '1', 'nose', 5750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1889, '2018-09-17', '2018', '15147962', '1', '1', 'nose', 4475.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1890, '2018-09-17', '2018', '15173224', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1891, '2018-09-17', '2018', '15148673', '1', '1', 'nose', 3133.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1892, '2018-09-17', '2018', '15174140', '1', '1', 'nose', 6890.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1893, '2018-09-17', '2018', '15184789', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1894, '2018-09-17', '2018', '14136715', '1', '1', 'nose', 5340.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1895, '2018-09-17', '2018', '15185025', '1', '1', 'nose', 5280.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1896, '2018-09-17', '2018', '15159615', '1', '1', 'nose', 5840.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1897, '2018-09-17', '2018', '15159193', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1898, '2018-09-17', '2018', '15159526', '1', '1', 'nose', 4820.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1899, '2018-09-17', '2018', '15172927', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1900, '2018-09-17', '2018', '15159982', '1', '1', 'nose', 2550.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1901, '2018-09-17', '2018', '15173400', '1', '1', 'nose', 2585.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1902, '2018-09-17', '2018', '15150004', '1', '1', 'nose', 4565.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1903, '2018-09-17', '2018', '15162168', '1', '1', 'nose', 5750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1904, '2018-09-17', '2018', '15174073', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1905, '2018-09-17', '2018', '15159222', '1', '1', 'nose', 4565.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1906, '2018-09-17', '2018', '15185322', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1907, '2018-09-17', '2018', '15172952', '1', '1', 'nose', 4920.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1908, '2018-09-17', '2018', '31035213', '1', '1', 'nose', 1725.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1909, '2018-09-17', '2018', '15172955', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1910, '2018-09-17', '2018', '15185613', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1911, '2018-09-17', '2018', '15184847', '1', '1', 'nose', 3300.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1912, '2018-09-17', '2018', '15159957', '1', '1', 'nose', 3060.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1913, '2018-09-17', '2018', '15159887', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1914, '2018-09-17', '2018', '15185834', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1915, '2018-09-17', '2018', '15173982', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1916, '2018-09-17', '2018', '15184581', '1', '1', 'nose', 4620.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1917, '2018-09-17', '2018', '15159201', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1918, '2018-09-17', '2018', '15185888', '1', '1', 'nose', 5280.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1919, '2018-09-17', '2018', '24161329', '1', '1', 'nose', 47520.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1920, '2018-09-17', '2018', '15186273', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1921, '2018-09-17', '2018', '15186015', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1922, '2018-09-17', '2018', '15161704', '1', '1', 'nose', 6490.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1923, '2018-09-17', '2018', '15186231', '1', '1', 'nose', 3300.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1924, '2018-09-17', '2018', '15173409', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1925, '2018-09-17', '2018', '15173749', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1926, '2018-09-17', '2018', '15162099', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1927, '2018-09-17', '2018', '15185536', '1', '1', 'nose', 7340.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1928, '2018-09-17', '2018', '15172946', '1', '1', 'nose', 4123.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1929, '2018-09-17', '2018', '15150205', '1', '1', 'nose', 1760.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1930, '2018-09-17', '2018', '15159261', '1', '1', 'nose', 2550.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1931, '2018-09-17', '2018', '14148569', '1', '1', 'nose', 5660.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1932, '2018-09-17', '2018', '15186103', '1', '1', 'nose', 4620.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1933, '2018-09-17', '2018', '15173992', '1', '1', 'nose', 4920.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1934, '2018-09-17', '2018', '54150017', '1', '1', 'nose', 5750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1935, '2018-09-17', '2018', '15173441', '1', '1', 'nose', 4613.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1936, '2018-09-17', '2018', '15172770', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1937, '2018-09-17', '2018', '15185594', '1', '1', 'nose', 7340.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1938, '2018-09-17', '2018', '15185323', '1', '1', 'nose', 5280.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1939, '2018-09-17', '2018', '10091461', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1940, '2018-09-17', '2018', '15159669', '1', '1', 'nose', 4080.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1941, '2018-09-17', '2018', '15161911', '1', '1', 'nose', 6490.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1942, '2018-09-17', '2018', '15173517', '1', '1', 'nose', 5660.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1943, '2018-09-17', '2018', '15185572', '1', '1', 'nose', 4620.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1944, '2018-09-17', '2018', '15173978', '1', '1', 'nose', 3815.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1945, '2018-09-17', '2018', '15161371', '1', '1', 'nose', 3615.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1946, '2018-09-17', '2018', '13089875', '1', '1', 'nose', 3133.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1947, '2018-09-17', '2018', '15148352', '1', '1', 'nose', 4475.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1948, '2018-09-17', '2018', '15185718', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1949, '2018-09-17', '2018', '15147363', '1', '1', 'nose', 4475.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1950, '2018-09-17', '2018', '15173925', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1951, '2018-09-17', '2018', '15185471', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1952, '2018-09-17', '2018', '15147926', '1', '1', 'nose', 4320.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1953, '2018-09-17', '2018', '15159636', '1', '1', 'nose', 4123.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1954, '2018-09-17', '2018', '15159527', '1', '1', 'nose', 5840.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1955, '2018-09-17', '2018', '15186123', '1', '1', 'nose', 7340.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1956, '2018-09-17', '2018', '15161506', '1', '1', 'nose', 3450.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1957, '2018-09-17', '2018', '15185653', '1', '1', 'nose', 43040.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1958, '2018-09-17', '2018', '15161608', '1', '1', 'nose', 5750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1959, '2018-09-17', '2018', '15159269', '1', '1', 'nose', 2550.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1960, '2018-09-17', '2018', '15173773', '1', '1', 'nose', 6890.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1961, '2018-09-17', '2018', '15185610', '1', '1', 'nose', 4620.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1962, '2018-09-17', '2018', '15159511', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1963, '2018-09-17', '2018', '15159872', '1', '1', 'nose', 3545.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1964, '2018-09-17', '2018', '15161576', '1', '1', 'nose', 6490.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1965, '2018-09-17', '2018', '15161503', '1', '1', 'nose', 5750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1966, '2018-09-17', '2018', '15159874', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1968, '2018-09-17', '2018', '15185458', '1', '1', 'nose', 4620.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1971, '2018-09-17', '2018', '15173259', '1', '1', 'nose', 2460.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1972, '2018-09-17', '2018', '15148208', '1', '1', 'nose', 4475.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1973, '2018-09-17', '2018', '15160951', '1', '1', 'nose', 3450.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1974, '2018-09-17', '2018', '15159720', '1', '1', 'nose', 3290.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1975, '2018-09-17', '2018', '15185251', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1976, '2018-09-17', '2018', '15184989', '1', '1', 'nose', 5610.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1977, '2018-09-17', '2018', '14102691', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1978, '2018-09-17', '2018', '15173734', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1979, '2018-09-17', '2018', '15161842', '1', '1', 'nose', 6490.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1980, '2018-09-17', '2018', '15185246', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1981, '2018-09-17', '2018', '15173395', '1', '1', 'nose', 6890.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1982, '2018-09-17', '2018', '15148524', '1', '1', 'nose', 4475.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1983, '2018-09-17', '2018', '15173204', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1984, '2018-09-17', '2018', '15159657', '1', '1', 'nose', 2550.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1985, '2018-09-17', '2018', '15161612', '1', '1', 'nose', 5340.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1986, '2018-09-17', '2018', '15172943', '1', '1', 'nose', 3075.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1987, '2018-09-17', '2018', '15185680', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1988, '2018-09-17', '2018', '15160932', '1', '1', 'nose', 6490.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1989, '2018-09-17', '2018', '15173004', '1', '1', 'nose', 3075.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1990, '2018-09-17', '2018', '54148002', '1', '1', 'nose', 5840.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1991, '2018-09-17', '2018', '15185749', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1992, '2018-09-17', '2018', '15136924', '1', '1', 'nose', 4475.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1993, '2018-09-17', '2018', '15161772', '1', '1', 'nose', 3615.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1994, '2018-09-17', '2018', '15186089', '1', '1', 'nose', 5280.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1995, '2018-09-17', '2018', '15184791', '1', '1', 'nose', 5610.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1996, '2018-09-17', '2018', '15148015', '1', '1', 'nose', 5215.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1997, '2018-09-17', '2018', '15148026', '1', '1', 'nose', 4320.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1998, '2018-09-17', '2018', '15173415', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(1999, '2018-09-17', '2018', '15160845', '1', '1', 'nose', 4765.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2000, '2018-09-17', '2018', '15147947', '1', '1', 'nose', 5215.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2001, '2018-09-17', '2018', '15011505', '1', '1', 'nose', 6490.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2002, '2018-09-17', '2018', '15159852', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2003, '2018-09-17', '2018', '12045725', '1', '1', 'nose', 4765.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2004, '2018-09-17', '2018', '15159821', '1', '1', 'nose', 5840.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2005, '2018-09-17', '2018', '15161679', '1', '1', 'nose', 5750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2006, '2018-09-17', '2018', '15150227', '1', '1', 'nose', 1020.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2007, '2018-09-17', '2018', '15184971', '1', '1', 'nose', 3300.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2008, '2018-09-17', '2018', '15161370', '1', '1', 'nose', 2875.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2009, '2018-09-17', '2018', '15185772', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2010, '2018-09-17', '2018', '15160632', '1', '1', 'nose', 5750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2011, '2018-09-17', '2018', '15185383', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2012, '2018-09-17', '2018', '15159525', '1', '1', 'nose', 6900.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2013, '2018-09-17', '2018', '14148531', '1', '1', 'nose', 4920.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2014, '2018-09-17', '2018', '15173464', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2015, '2018-09-17', '2018', '15173949', '1', '1', 'nose', 4123.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2016, '2018-09-17', '2018', '15160858', '1', '1', 'nose', 7000.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2017, '2018-09-17', '2018', '15172604', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2018, '2018-09-17', '2018', '15173323', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2019, '2018-09-17', '2018', '15185582', '1', '1', 'nose', 3300.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2020, '2018-09-17', '2018', '15173230', '1', '1', 'nose', 6150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2021, '2018-09-17', '2018', '54148384', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2022, '2018-09-17', '2018', '13124528', '1', '1', 'nose', 4620.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2023, '2018-09-17', '2018', '15173203', '1', '1', 'nose', 5045.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2024, '2018-09-17', '2018', '15185514', '1', '1', 'nose', 7340.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2025, '2018-09-17', '2018', '15161468', '1', '1', 'nose', 1890.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2026, '2018-09-17', '2018', '15173206', '1', '1', 'nose', 7400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2027, '2018-09-17', '2018', '15173206', '1', '1', 'nose', 6890.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2028, '2018-09-17', '2018', '15185364', '1', '1', 'nose', 1980.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2029, '2018-09-17', '2018', '15186297', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2030, '2018-09-17', '2018', '13113187', '1', '1', 'nose', 4950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2031, '2018-09-17', '2018', '15174274', '1', '1', 'nose', 3075.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2032, '2018-09-17', '2018', '15184787', '1', '1', 'nose', 6680.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2033, '2018-09-17', '2018', '15159818', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2034, '2018-09-17', '2018', '15161445', '1', '1', 'nose', 5340.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2035, '2018-09-17', '2018', '15160505', '1', '1', 'nose', 2550.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2036, '2018-09-17', '2018', '15185822', '1', '1', 'nose', 1980.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2037, '2018-09-17', '2018', '15186113', '1', '1', 'nose', 2060.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2038, '2018-09-17', '2018', '15161800', '1', '1', 'nose', 5750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2039, '2018-09-17', '2018', '15172824', '1', '1', 'nose', 3815.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2040, '2018-09-17', '2018', '15185828', '1', '1', 'nose', 6600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2041, '2018-09-17', '2018', '15184879', '1', '1', 'nose', 3300.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2042, '2018-09-17', '2018', '15159178', '1', '1', 'nose', 3290.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2043, '2018-09-17', '2018', '15159965', '1', '1', 'nose', 5100.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2044, '2018-09-17', '2018', '15173759', '1', '1', 'nose', 3075.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2045, '2018-09-29', '2018', '16174207', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2046, '2018-09-29', '2018', '15113839', '1', '1', 'nose', 2250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2047, '2018-09-28', '2018', '15136211', '1', '1', 'nose', 3090.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL);
INSERT INTO `edocta` (`id`, `fec_oper_edo`, `anio_pago_edo`, `cve_pago_edo`, `mes_pago_edo`, `dig_pago_edo`, `descrip_edo`, `imp_abono_edo`, `imp_cargo_edo`, `estado_edo`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2048, '2018-09-28', '2018', '16173541', '1', '1', 'nose', 4700.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2051, '2018-09-28', '2018', '16186245', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2052, '2018-09-28', '2018', '16186380', '1', '1', 'nose', 2000.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2053, '2018-09-28', '2018', '15124852', '1', '1', 'nose', 2575.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2054, '2018-09-28', '2018', '16185301', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2055, '2018-09-28', '2018', '15136203', '1', '1', 'nose', 2575.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2056, '2018-09-28', '2018', '16186031', '1', '1', 'nose', 6050.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2057, '2018-09-27', '2018', '15136710', '1', '1', 'nose', 3605.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2058, '2018-09-27', '2018', '16186192', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2059, '2018-09-27', '2018', '16185306', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2060, '2018-09-27', '2018', '15078633', '1', '1', 'nose', 27810.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2061, '2018-09-27', '2018', '16160565', '1', '1', 'nose', 6000.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2062, '2018-09-27', '2018', '54079157', '1', '1', 'nose', 28675.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2063, '2018-09-27', '2018', '15148013', '1', '1', 'nose', 3605.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2064, '2018-09-27', '2018', '12990395', '1', '1', 'nose', 3605.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2065, '2018-09-26', '2018', '14090893', '1', '1', 'nose', 45000.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2066, '2018-09-26', '2018', '15113185', '1', '1', 'nose', 2575.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2067, '2018-09-25', '2018', '15136943', '1', '1', 'nose', 1545.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2068, '2018-09-25', '2018', '15136772', '1', '1', 'nose', 2575.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2069, '2018-09-24', '2018', '16148770', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2070, '2018-09-24', '2018', '16186379', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2071, '2018-09-24', '2018', '16186324', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2072, '2018-09-21', '2018', '17184856', '1', '1', 'nose', 1400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2073, '2018-09-20', '2018', '16185292', '1', '1', 'nose', 1400.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2074, '2018-09-20', '2018', '15125567', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2075, '2018-09-19', '2018', '16162159', '1', '1', 'nose', 2685.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2076, '2018-09-19', '2018', '16173876', '1', '1', 'nose', 4850.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2078, '2018-09-19', '2018', '15102592', '1', '1', 'nose', 5000.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2079, '2018-09-18', '2018', '16160562', '1', '1', 'nose', 3133.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2080, '2018-09-18', '2018', '16160562', '1', '1', 'nose', 6000.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2082, '2018-09-17', '2018', '16173651', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2083, '2018-09-17', '2018', '15125387', '1', '1', 'nose', 2250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2084, '2018-09-17', '2018', '16174090', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2085, '2018-09-17', '2018', '16174090', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2086, '2018-09-17', '2018', '15113413', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2087, '2018-09-17', '2018', '16173563', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2088, '2018-09-17', '2018', '15125237', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2089, '2018-09-17', '2018', '16173575', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2090, '2018-09-17', '2018', '16184623', '1', '1', 'nose', 11300.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2091, '2018-09-17', '2018', '16173266', '1', '1', 'nose', 4500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2092, '2018-09-17', '2018', '15124484', '1', '1', 'nose', 2250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2093, '2018-09-17', '2018', '14045796', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2094, '2018-09-17', '2018', '15113481', '1', '1', 'nose', 2685.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2095, '2018-09-17', '2018', '15136200', '1', '1', 'nose', 3925.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2096, '2018-09-17', '2018', '16173551', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2097, '2018-09-17', '2018', '15173659', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2098, '2018-09-17', '2018', '15090582', '1', '1', 'nose', 3090.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2099, '2018-09-17', '2018', '16174172', '1', '1', 'nose', 4500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2100, '2018-09-17', '2018', '16186222', '1', '1', 'nose', 3605.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2101, '2018-09-17', '2018', '15136581', '1', '1', 'nose', 2700.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2102, '2018-09-17', '2018', '16186224', '1', '1', 'nose', 3605.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2103, '2018-09-17', '2018', '15186082', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2104, '2018-09-17', '2018', '16173008', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2105, '2018-09-17', '2018', '15089898', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2106, '2018-09-17', '2018', '16186261', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2107, '2018-09-17', '2018', '15125420', '1', '1', 'nose', 2833.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2108, '2018-09-17', '2018', '16174237', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2109, '2018-09-17', '2018', '16186263', '1', '1', 'nose', 3605.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2110, '2018-09-17', '2018', '16185290', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2111, '2018-09-17', '2018', '16174295', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2112, '2018-09-17', '2018', '15124591', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2113, '2018-09-17', '2018', '12990131', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2114, '2018-09-17', '2018', '16186295', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2115, '2018-09-17', '2018', '15135860', '1', '1', 'nose', 3090.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2116, '2018-09-17', '2018', '16173095', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2117, '2018-09-17', '2018', '16186276', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2118, '2018-09-17', '2018', '10161210', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2119, '2018-09-17', '2018', '10173588', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2120, '2018-09-17', '2018', '16186221', '1', '1', 'nose', 3605.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2121, '2018-09-17', '2018', '16173554', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2122, '2018-09-17', '2018', '16186247', '1', '1', 'nose', 2575.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2123, '2018-09-17', '2018', '15147237', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2124, '2018-09-17', '2018', '15135947', '1', '1', 'nose', 2700.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2125, '2018-09-17', '2018', '15124479', '1', '1', 'nose', 2250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2126, '2018-09-17', '2018', '15135861', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2127, '2018-09-17', '2018', '16186314', '1', '1', 'nose', 3605.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2128, '2018-09-17', '2018', '16186260', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2129, '2018-09-17', '2018', '14101720', '1', '1', 'nose', 2575.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2130, '2018-09-17', '2018', '16173087', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2131, '2018-09-17', '2018', '15124681', '1', '1', 'nose', 2250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2132, '2018-09-17', '2018', '12990373', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2133, '2018-09-16', '2018', '16184477', '1', '1', 'nose', 5150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2134, '2018-09-16', '2018', '15147477', '1', '1', 'nose', 3090.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2135, '2018-09-16', '2018', '16173039', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2144, '2018-09-16', '2018', '16186270', '1', '1', 'nose', 3090.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2145, '2018-09-16', '2018', '16173258', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2154, '2018-09-15', '2018', '16173704', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2155, '2018-09-15', '2018', '15125145', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2156, '2018-09-15', '2018', '15089520', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2157, '2018-09-15', '2018', '15113767', '1', '1', 'nose', 3125.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2158, '2018-09-15', '2018', '14124381', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2159, '2018-09-15', '2018', '15136464', '1', '1', 'nose', 3605.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2160, '2018-09-15', '2018', '12002184', '1', '1', 'nose', 3125.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2161, '2018-09-15', '2018', '16172460', '1', '1', 'nose', 4475.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2162, '2018-09-15', '2018', '16173565', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2163, '2018-09-15', '2018', '16185456', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2164, '2018-09-15', '2018', '15056935', '1', '1', 'nose', 2250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2165, '2018-09-15', '2018', '06173465', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2166, '2018-09-15', '2018', '16173268', '1', '1', 'nose', 4500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2167, '2018-09-15', '2018', '16172809', '1', '1', 'nose', 4500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2168, '2018-09-15', '2018', '16173274', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2169, '2018-09-15', '2018', '16185920', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2170, '2018-09-15', '2018', '16173648', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2171, '2018-09-14', '2018', '15136450', '1', '1', 'nose', 4150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2172, '2018-09-14', '2018', '15136731', '1', '1', 'nose', 3700.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2173, '2018-09-14', '2018', '16173566', '1', '1', 'nose', 1350.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2174, '2018-09-14', '2018', '16173585', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2175, '2018-09-14', '2018', '16185729', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2176, '2018-09-14', '2018', '16185287', '1', '1', 'nose', 3605.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2177, '2018-09-14', '2018', '10162227', '1', '1', 'nose', 4500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2178, '2018-09-14', '2018', '16186206', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2179, '2018-09-14', '2018', '13990715', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2180, '2018-09-14', '2018', '15185274', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2181, '2018-09-14', '2018', '16186020', '1', '1', 'nose', 5150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2182, '2018-09-14', '2018', '16173560', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2183, '2018-09-14', '2018', '16173559', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2184, '2018-09-14', '2018', '17185295', '1', '1', 'nose', 3605.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2185, '2018-09-14', '2018', '15136705', '1', '1', 'nose', 3605.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2186, '2018-09-14', '2018', '16173576', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2187, '2018-09-14', '2018', '15125387', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2188, '2018-09-14', '2018', '15173795', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2189, '2018-09-14', '2018', '15148060', '1', '1', 'nose', 32445.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2190, '2018-09-14', '2018', '16136903', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2191, '2018-09-14', '2018', '16185880', '1', '1', 'nose', 5150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2192, '2018-09-14', '2018', '15102514', '1', '1', 'nose', 2014.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2193, '2018-09-14', '2018', '15147239', '1', '1', 'nose', 3090.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2194, '2018-09-14', '2018', '15148886', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2195, '2018-09-14', '2018', '10161020', '1', '1', 'nose', 1350.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2196, '2018-09-14', '2018', '15148886', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2197, '2018-09-14', '2018', '16173566', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2198, '2018-09-14', '2018', '10161020', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2199, '2018-09-14', '2018', '10160651', '1', '1', 'nose', 4500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2200, '2018-09-14', '2018', '15056790', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2201, '2018-09-13', '2018', '15125237', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2202, '2018-09-13', '2018', '16185293', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2203, '2018-09-13', '2018', '16173563', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2204, '2018-09-13', '2018', '16186157', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2205, '2018-09-13', '2018', '16184465', '1', '1', 'nose', 4500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2206, '2018-09-13', '2018', '10160677', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2207, '2018-09-13', '2018', '15148001', '1', '1', 'nose', 28675.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2208, '2018-09-13', '2018', '16173598', '1', '1', 'nose', 4500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2209, '2018-09-13', '2018', '15136345', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2210, '2018-09-13', '2018', '15113435', '1', '1', 'nose', 3605.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2211, '2018-09-13', '2018', '36173764', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2212, '2018-09-13', '2018', '16173586', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2213, '2018-09-13', '2018', '16186380', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2214, '2018-09-13', '2018', '16186180', '1', '1', 'nose', 5150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2215, '2018-09-13', '2018', '16173557', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2216, '2018-09-13', '2018', '16174228', '1', '1', 'nose', 4500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2217, '2018-09-13', '2018', '15124516', '1', '1', 'nose', 2575.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2218, '2018-09-13', '2018', '15136348', '1', '1', 'nose', 3090.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2219, '2018-09-12', '2018', '16186379', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2220, '2018-09-12', '2018', '15125145', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2221, '2018-09-12', '2018', '10114047', '1', '1', 'nose', 3090.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2222, '2018-09-12', '2018', '16173584', '1', '1', 'nose', 4500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2223, '2018-09-12', '2018', '14002241', '1', '1', 'nose', 3250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2224, '2018-09-12', '2018', '10160708', '1', '1', 'nose', 1350.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2225, '2018-09-12', '2018', '10160708', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2226, '2018-09-12', '2018', '16186034', '1', '1', 'nose', 3090.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2230, '2018-09-12', '2018', '15135942', '1', '1', 'nose', 2250.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2231, '2018-09-12', '2018', '16186316', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2232, '2018-09-12', '2018', '16174162', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2233, '2018-09-11', '2018', '16185979', '1', '1', 'nose', 3605.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2234, '2018-09-11', '2018', '16057190', '1', '1', 'nose', 2575.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2235, '2018-09-11', '2018', '15136345', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2236, '2018-09-11', '2018', '15102514', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2237, '2018-09-11', '2018', '16185669', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2238, '2018-09-11', '2018', '16186333', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2239, '2018-09-11', '2018', '15185271', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2240, '2018-09-11', '2018', '15102115', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2241, '2018-09-11', '2018', '15124605', '1', '1', 'nose', 1545.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2242, '2018-09-11', '2018', '15056790', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2243, '2018-09-10', '2018', '15113452', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2244, '2018-09-10', '2018', '14067636', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2245, '2018-09-10', '2018', '16186314', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2246, '2018-09-10', '2018', '15078743', '1', '1', 'nose', 1343.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2247, '2018-09-10', '2018', '15057012', '1', '1', 'nose', 3090.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2248, '2018-09-10', '2018', '15124854', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2249, '2018-09-10', '2018', '16174228', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2250, '2018-09-10', '2018', '15113481', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2251, '2018-09-10', '2018', '15185279', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2252, '2018-09-10', '2018', '15136581', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2253, '2018-09-09', '2018', '16185289', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2254, '2018-09-08', '2018', '16173648', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2255, '2018-09-07', '2018', '16173062', '1', '1', 'nose', 3600.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2256, '2018-09-07', '2018', '16172462', '1', '1', 'nose', 2238.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2257, '2018-09-07', '2018', '15136464', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2258, '2018-09-06', '2018', '16162138', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2259, '2018-09-06', '2018', '54125187', '1', '1', 'nose', 4120.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2260, '2018-09-05', '2018', '16173562', '1', '1', 'nose', 4500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2261, '2018-09-04', '2018', '16173598', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2262, '2018-09-04', '2018', '15173795', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2263, '2018-09-04', '2018', '16184705', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2264, '2018-09-04', '2018', '15113185', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2265, '2018-09-03', '2018', '15113839', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2266, '2018-09-03', '2018', '16173551', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2267, '2018-09-03', '2018', '14067636', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2268, '2018-09-03', '2018', '16186324', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2269, '2018-09-02', '2018', '15135947', '1', '1', 'nose', 5500.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2270, '2018-09-28', '2018', '11186117', '1', '1', 'nose', 3375.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2271, '2018-09-27', '2018', '28184699', '1', '1', 'nose', 2950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2272, '2018-09-24', '2018', '21184814', '1', '1', 'nose', 3375.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2273, '2018-09-24', '2018', '11185077', '1', '1', 'nose', 2520.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2274, '2018-09-24', '2018', '11185078', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2275, '2018-09-19', '2018', '21174210', '1', '1', 'nose', 5670.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2276, '2018-09-19', '2018', '21184704', '1', '1', 'nose', 3375.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2277, '2018-09-18', '2018', '10186377', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2278, '2018-09-17', '2018', '11172587', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2279, '2018-09-17', '2018', '21185313', '1', '1', 'nose', 2363.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2280, '2018-09-17', '2018', '11173272', '1', '1', 'nose', 2363.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2281, '2018-09-17', '2018', '11160619', '1', '1', 'nose', 1575.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2282, '2018-09-17', '2018', '18186228', '1', '1', 'nose', 2950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2283, '2018-09-17', '2018', '11161805', '1', '1', 'nose', 28350.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2284, '2018-09-17', '2018', '11173031', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2285, '2018-09-17', '2018', '21184594', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2286, '2018-09-17', '2018', '11172858', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2287, '2018-09-17', '2018', '11160628', '1', '1', 'nose', 1575.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2288, '2018-09-17', '2018', '11172727', '1', '1', 'nose', 2363.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2289, '2018-09-17', '2018', '11174300', '1', '1', 'nose', 2205.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2290, '2018-09-17', '2018', '21174212', '1', '1', 'nose', 2520.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2291, '2018-09-17', '2018', '11161476', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2292, '2018-09-17', '2018', '11173170', '1', '1', 'nose', 2520.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2293, '2018-09-17', '2018', '21185781', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2294, '2018-09-17', '2018', '11160496', '1', '1', 'nose', 625.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2295, '2018-09-17', '2018', '11160751', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2296, '2018-09-17', '2018', '28185226', '1', '1', 'nose', 2950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2297, '2018-09-17', '2018', '11160981', '1', '1', 'nose', 2048.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2298, '2018-09-17', '2018', '11184869', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2299, '2018-09-17', '2018', '11184897', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2300, '2018-09-17', '2018', '11173033', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2301, '2018-09-17', '2018', '21174188', '1', '1', 'nose', 2363.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2302, '2018-09-17', '2018', '31186025', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2303, '2018-09-17', '2018', '31185549', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2304, '2018-09-17', '2018', '11173025', '1', '1', 'nose', 2520.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2305, '2018-09-17', '2018', '18185157', '1', '1', 'nose', 2950.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2309, '2018-09-17', '2018', '31185978', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2315, '2018-09-17', '2018', '11174175', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2316, '2018-09-16', '2018', '11184697', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2317, '2018-09-16', '2018', '31185225', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2318, '2018-09-15', '2018', '11173028', '1', '1', 'nose', 2678.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2327, '2018-09-15', '2018', '11186171', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2328, '2018-09-15', '2018', '11160914', '1', '1', 'nose', 945.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2329, '2018-09-15', '2018', '11185208', '1', '1', 'nose', 2520.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2330, '2018-09-15', '2018', '11184661', '1', '1', 'nose', 2520.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2331, '2018-09-14', '2018', '11172519', '1', '1', 'nose', 315.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2332, '2018-09-14', '2018', '11186234', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2333, '2018-09-14', '2018', '11185389', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2334, '2018-09-14', '2018', '11161323', '1', '1', 'nose', 1575.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2335, '2018-09-14', '2018', '11161548', '1', '1', 'nose', 28350.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2336, '2018-09-14', '2018', '11173172', '1', '1', 'nose', 28350.00, 0.00, 'V', 1, '2018-12-05 21:39:51', '2018-12-05 21:39:51', NULL),
(2337, '2018-09-14', '2018', '11174183', '1', '1', 'nose', 2520.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2338, '2018-09-14', '2018', '22184873', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2339, '2018-09-14', '2018', '31184466', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2340, '2018-09-14', '2018', '11162058', '1', '1', 'nose', 1418.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2341, '2018-09-14', '2018', '11160698', '1', '1', 'nose', 28350.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2342, '2018-09-14', '2018', '11184542', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2343, '2018-09-14', '2018', '11186055', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2344, '2018-09-14', '2018', '11173006', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2345, '2018-09-14', '2018', '18186121', '1', '1', 'nose', 2360.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2346, '2018-09-14', '2018', '21173416', '1', '1', 'nose', 2520.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2347, '2018-09-14', '2018', '18185770', '1', '1', 'nose', 2950.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2348, '2018-09-14', '2018', '11184626', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2349, '2018-09-14', '2018', '28185054', '1', '1', 'nose', 2520.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2350, '2018-09-14', '2018', '28185100', '1', '1', 'nose', 2950.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2351, '2018-09-14', '2018', '31186387', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2352, '2018-09-14', '2018', '11184849', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2353, '2018-09-14', '2018', '11173047', '1', '1', 'nose', 1575.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2354, '2018-09-14', '2018', '11172511', '1', '1', 'nose', 1260.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2355, '2018-09-13', '2018', '11161741', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2356, '2018-09-13', '2018', '21184820', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2357, '2018-09-13', '2018', '21184837', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2358, '2018-09-13', '2018', '21185261', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2359, '2018-09-13', '2018', '11186262', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2360, '2018-09-12', '2018', '11184546', '1', '1', 'nose', 1575.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2361, '2018-09-12', '2018', '21186131', '1', '1', 'nose', 2520.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2362, '2018-09-12', '2018', '11186133', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2363, '2018-09-12', '2018', '11184517', '1', '1', 'nose', 1575.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2364, '2018-09-12', '2018', '11160679', '1', '1', 'nose', 1575.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2365, '2018-09-12', '2018', '18184925', '1', '1', 'nose', 2950.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2366, '2018-09-12', '2018', '18184926', '1', '1', 'nose', 2950.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2367, '2018-09-12', '2018', '11185564', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2368, '2018-09-12', '2018', '11160942', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2377, '2018-09-11', '2018', '11185986', '1', '1', 'nose', 1575.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2378, '2018-09-11', '2018', '21173156', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2379, '2018-09-11', '2018', '11185797', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2380, '2018-09-11', '2018', '21186142', '1', '1', 'nose', 2520.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2381, '2018-09-11', '2018', '18186143', '1', '1', 'nose', 2950.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2382, '2018-09-10', '2018', '11173067', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2383, '2018-09-10', '2018', '11173157', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2384, '2018-09-10', '2018', '11185182', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2385, '2018-09-10', '2018', '31186387', '1', '1', 'nose', 5600.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2386, '2018-09-10', '2018', '21184825', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2387, '2018-09-10', '2018', '21174394', '1', '1', 'nose', 2205.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2388, '2018-09-09', '2018', '11172711', '1', '1', 'nose', 1890.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2389, '2018-09-08', '2018', '11161436', '1', '1', 'nose', 1575.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2390, '2018-09-08', '2018', '11184535', '1', '1', 'nose', 2950.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2391, '2018-09-08', '2018', '11160894', '1', '1', 'nose', 2048.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2392, '2018-09-08', '2018', '10186377', '1', '1', 'nose', 5600.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2393, '2018-09-08', '2018', '11186011', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2395, '2018-09-07', '2018', '11185776', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2396, '2018-09-06', '2018', '11184598', '1', '1', 'nose', 2520.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2397, '2018-09-06', '2018', '11173805', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2398, '2018-09-06', '2018', '11160957', '1', '1', 'nose', 625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2399, '2018-09-06', '2018', '31184746', '1', '1', 'nose', 2205.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2400, '2018-09-06', '2018', '11185078', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2401, '2018-09-06', '2018', '11185077', '1', '1', 'nose', 2520.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2402, '2018-09-05', '2018', '11160947', '1', '1', 'nose', 14175.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2403, '2018-09-05', '2018', '28185971', '1', '1', 'nose', 2950.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2404, '2018-09-29', '2018', '14185412', '1', '1', 'nose', 4675.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2405, '2018-09-29', '2018', '13159848', '1', '1', 'nose', 4525.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2406, '2018-09-28', '2018', '14173869', '1', '1', 'nose', 4525.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2407, '2018-09-28', '2018', '14185951', '1', '1', 'nose', 4525.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2408, '2018-09-28', '2018', '34184982', '1', '1', 'nose', 4525.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2409, '2018-09-28', '2018', '14173171', '1', '1', 'nose', 4525.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2410, '2018-09-28', '2018', '14185430', '1', '1', 'nose', 4525.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2411, '2018-09-28', '2018', '14185455', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2412, '2018-09-28', '2018', '12068100', '1', '1', 'nose', 4150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2413, '2018-09-28', '2018', '42124624', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2414, '2018-09-27', '2018', '23148074', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2415, '2018-09-27', '2018', '52136846', '1', '1', 'nose', 2958.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2416, '2018-09-27', '2018', '14173898', '1', '1', 'nose', 4525.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2417, '2018-09-27', '2018', '14185992', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2418, '2018-09-27', '2018', '33173820', '1', '1', 'nose', 4525.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2419, '2018-09-26', '2018', '24173827', '1', '1', 'nose', 4525.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2420, '2018-09-26', '2018', '14172599', '1', '1', 'nose', 4525.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2421, '2018-09-25', '2018', '52136833', '1', '1', 'nose', 4525.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2422, '2018-09-21', '2018', '62148874', '1', '1', 'nose', 4525.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2423, '2018-09-19', '2018', '12090423', '1', '1', 'nose', 4825.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2424, '2018-09-19', '2018', '12090423', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2425, '2018-09-19', '2018', '12090423', '1', '1', 'nose', 4525.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2426, '2018-09-19', '2018', '14186215', '1', '1', 'nose', 4525.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2427, '2018-09-19', '2018', '14161450', '1', '1', 'nose', 4525.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2428, '2018-09-18', '2018', '14173787', '1', '1', 'nose', 4525.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2429, '2018-09-18', '2018', '14161050', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2430, '2018-09-18', '2018', '12090404', '1', '1', 'nose', 1200.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2431, '2018-09-18', '2018', '14173819', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2432, '2018-09-17', '2018', '13159927', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2433, '2018-09-17', '2018', '33173946', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2434, '2018-09-17', '2018', '14185935', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2435, '2018-09-17', '2018', '34186205', '1', '1', 'nose', 3591.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2436, '2018-09-17', '2018', '13159056', '1', '1', 'nose', 3591.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2437, '2018-09-17', '2018', '62147939', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2438, '2018-09-17', '2018', '34174174', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2439, '2018-09-17', '2018', '13148413', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2440, '2018-09-17', '2018', '11045703', '1', '1', 'nose', 2958.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2441, '2018-09-17', '2018', '14173497', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2442, '2018-09-17', '2018', '34172964', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2443, '2018-09-17', '2018', '42101629', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2444, '2018-09-17', '2018', '33159866', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2445, '2018-09-17', '2018', '14185677', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2446, '2018-09-17', '2018', '33162007', '1', '1', 'nose', 2958.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2447, '2018-09-17', '2018', '14161330', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2448, '2018-09-17', '2018', '13135927', '1', '1', 'nose', 2958.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2449, '2018-09-17', '2018', '14161726', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2450, '2018-09-17', '2018', '12091454', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2451, '2018-09-17', '2018', '62135729', '1', '1', 'nose', 2958.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2452, '2018-09-17', '2018', '13159084', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2453, '2018-09-17', '2018', '14173092', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2454, '2018-09-17', '2018', '42102048', '1', '1', 'nose', 2958.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2455, '2018-09-17', '2018', '11067540', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2456, '2018-09-17', '2018', '14161066', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2457, '2018-09-17', '2018', '13135909', '1', '1', 'nose', 1268.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2458, '2018-09-17', '2018', '12113542', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2459, '2018-09-17', '2018', '14161051', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2460, '2018-09-17', '2018', '14185159', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2461, '2018-09-17', '2018', '23148509', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2462, '2018-09-17', '2018', '12089417', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2463, '2018-09-17', '2018', '34173540', '1', '1', 'nose', 3591.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2464, '2018-09-17', '2018', '14185129', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2465, '2018-09-17', '2018', '32101922', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2466, '2018-09-17', '2018', '32101924', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2467, '2018-09-17', '2018', '14162016', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2468, '2018-09-17', '2018', '12090569', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2469, '2018-09-17', '2018', '14185493', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL);
INSERT INTO `edocta` (`id`, `fec_oper_edo`, `anio_pago_edo`, `cve_pago_edo`, `mes_pago_edo`, `dig_pago_edo`, `descrip_edo`, `imp_abono_edo`, `imp_cargo_edo`, `estado_edo`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2470, '2018-09-17', '2018', '14161219', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2471, '2018-09-17', '2018', '23161102', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2472, '2018-09-17', '2018', '31089818', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2473, '2018-09-17', '2018', '14172956', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2474, '2018-09-17', '2018', '14173380', '1', '1', 'nose', 3591.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2475, '2018-09-17', '2018', '34174003', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2476, '2018-09-17', '2018', '31079337', '1', '1', 'nose', 3591.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2477, '2018-09-17', '2018', '12090522', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2478, '2018-09-17', '2018', '13136745', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2479, '2018-09-17', '2018', '14161648', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2480, '2018-09-17', '2018', '14172860', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2481, '2018-09-17', '2018', '14184868', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2482, '2018-09-17', '2018', '13159251', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2483, '2018-09-17', '2018', '62148396', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2484, '2018-09-17', '2018', '14185641', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2485, '2018-09-17', '2018', '12090426', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2486, '2018-09-17', '2018', '34185900', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2487, '2018-09-17', '2018', '14185167', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2488, '2018-09-17', '2018', '23162130', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2489, '2018-09-17', '2018', '14173468', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2490, '2018-09-17', '2018', '24173458', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2491, '2018-09-17', '2018', '22067538', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2492, '2018-09-17', '2018', '13147271', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2493, '2018-09-17', '2018', '14185068', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2494, '2018-09-17', '2018', '14172738', '1', '1', 'nose', 3591.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2495, '2018-09-17', '2018', '23159619', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2496, '2018-09-17', '2018', '13135907', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2497, '2018-09-17', '2018', '11045911', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2498, '2018-09-17', '2018', '11045674', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2499, '2018-09-17', '2018', '12079192', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2500, '2018-09-17', '2018', '12101542', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2501, '2018-09-17', '2018', '22101814', '1', '1', 'nose', 1656.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2502, '2018-09-17', '2018', '22101814', '1', '1', 'nose', 1056.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2507, '2018-09-17', '2018', '12090428', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2511, '2018-09-17', '2018', '13135818', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2512, '2018-09-17', '2018', '23148141', '1', '1', 'nose', 3169.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2513, '2018-09-17', '2018', '14161331', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2514, '2018-09-16', '2018', '14184998', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2515, '2018-09-16', '2018', '14173544', '1', '1', 'nose', 2958.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2516, '2018-09-15', '2018', '14185897', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2517, '2018-09-15', '2018', '33161681', '1', '1', 'nose', 3169.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2518, '2018-09-15', '2018', '14173745', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2519, '2018-09-15', '2018', '34186208', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2520, '2018-09-15', '2018', '21079117', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2521, '2018-09-15', '2018', '14173740', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2522, '2018-09-15', '2018', '23148393', '1', '1', 'nose', 3591.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2523, '2018-09-15', '2018', '11045750', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2524, '2018-09-15', '2018', '12136922', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2525, '2018-09-15', '2018', '14173785', '1', '1', 'nose', 2958.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2526, '2018-09-15', '2018', '14161448', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2527, '2018-09-15', '2018', '12113281', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2528, '2018-09-14', '2018', '23159360', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2529, '2018-09-14', '2018', '14173828', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2530, '2018-09-14', '2018', '12080003', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2531, '2018-09-14', '2018', '13158983', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2532, '2018-09-14', '2018', '14172988', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2533, '2018-09-14', '2018', '13147413', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2534, '2018-09-14', '2018', '14161783', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2535, '2018-09-14', '2018', '14185707', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2536, '2018-09-14', '2018', '14185921', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2537, '2018-09-14', '2018', '14160918', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2538, '2018-09-14', '2018', '14173997', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2539, '2018-09-14', '2018', '14172984', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2540, '2018-09-14', '2018', '13147252', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2541, '2018-09-14', '2018', '14162009', '1', '1', 'nose', 31620.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2542, '2018-09-14', '2018', '14185454', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2543, '2018-09-14', '2018', '14186004', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2544, '2018-09-14', '2018', '31067797', '1', '1', 'nose', 1690.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2545, '2018-09-14', '2018', '24173826', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2546, '2018-09-14', '2018', '13160600', '1', '1', 'nose', 4000.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2547, '2018-09-14', '2018', '14184444', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2548, '2018-09-14', '2018', '13159412', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2549, '2018-09-14', '2018', '12091327', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2550, '2018-09-14', '2018', '14161150', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2551, '2018-09-14', '2018', '54186014', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2552, '2018-09-14', '2018', '14161629', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2553, '2018-09-14', '2018', '11056579', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2554, '2018-09-14', '2018', '13136175', '1', '1', 'nose', 1268.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2555, '2018-09-14', '2018', '14173493', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2556, '2018-09-14', '2018', '54185726', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2557, '2018-09-14', '2018', '54185229', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2558, '2018-09-14', '2018', '31089410', '1', '1', 'nose', 3591.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2559, '2018-09-14', '2018', '13135798', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2560, '2018-09-14', '2018', '33159080', '1', '1', 'nose', 31620.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2561, '2018-09-14', '2018', '13148324', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2562, '2018-09-14', '2018', '14184777', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2563, '2018-09-14', '2018', '14185566', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2564, '2018-09-14', '2018', '13135758', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2565, '2018-09-14', '2018', '23160735', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2566, '2018-09-14', '2018', '14186149', '1', '1', 'nose', 2535.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2567, '2018-09-14', '2018', '12078893', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2568, '2018-09-14', '2018', '12078411', '1', '1', 'nose', 2958.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2569, '2018-09-14', '2018', '14185146', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2570, '2018-09-13', '2018', '14161456', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2571, '2018-09-13', '2018', '13147776', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2572, '2018-09-13', '2018', '14173762', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2573, '2018-09-13', '2018', '13147779', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2574, '2018-09-13', '2018', '12124240', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2575, '2018-09-13', '2018', '33173164', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2576, '2018-09-13', '2018', '14173706', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2577, '2018-09-13', '2018', '52113443', '1', '1', 'nose', 1268.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2578, '2018-09-13', '2018', '23162017', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2579, '2018-09-13', '2018', '14184852', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2580, '2018-09-13', '2018', '14185619', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2581, '2018-09-13', '2018', '14161996', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2582, '2018-09-13', '2018', '11067821', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2583, '2018-09-13', '2018', '13136140', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2584, '2018-09-13', '2018', '13136251', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2585, '2018-09-13', '2018', '13159047', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2586, '2018-09-13', '2018', '34173023', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2587, '2018-09-13', '2018', '14161997', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2588, '2018-09-13', '2018', '14173311', '1', '1', 'nose', 2958.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2589, '2018-09-13', '2018', '12078472', '1', '1', 'nose', 1901.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2590, '2018-09-13', '2018', '14161795', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2591, '2018-09-13', '2018', '34185057', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2592, '2018-09-13', '2018', '21078510', '1', '1', 'nose', 31620.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2593, '2018-09-13', '2018', '21078511', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2594, '2018-09-13', '2018', '14161880', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2595, '2018-09-13', '2018', '14172544', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2596, '2018-09-13', '2018', '14174044', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2597, '2018-09-13', '2018', '14172834', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2598, '2018-09-12', '2018', '54185130', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2599, '2018-09-12', '2018', '14173005', '1', '1', 'nose', 3803.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2600, '2018-09-12', '2018', '13150303', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2601, '2018-09-12', '2018', '12137058', '1', '1', 'nose', 2535.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2602, '2018-09-12', '2018', '14173893', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2603, '2018-09-12', '2018', '14185926', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2604, '2018-09-12', '2018', '34172864', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2605, '2018-09-12', '2018', '14185269', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2606, '2018-09-12', '2018', '12112938', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2607, '2018-09-12', '2018', '12089459', '1', '1', 'nose', 600.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2608, '2018-09-12', '2018', '14184688', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2610, '2018-09-12', '2018', '13159061', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2611, '2018-09-12', '2018', '54185195', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2612, '2018-09-12', '2018', '14174062', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2613, '2018-09-12', '2018', '14160888', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2614, '2018-09-12', '2018', '14173407', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2615, '2018-09-12', '2018', '14185759', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2616, '2018-09-12', '2018', '14185924', '1', '1', 'nose', 1268.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2617, '2018-09-11', '2018', '14160909', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2618, '2018-09-11', '2018', '14173000', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2619, '2018-09-11', '2018', '14184471', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2620, '2018-09-11', '2018', '31067755', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2621, '2018-09-11', '2018', '14185936', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2622, '2018-09-11', '2018', '34173303', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2623, '2018-09-11', '2018', '13159045', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2624, '2018-09-11', '2018', '33159057', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2625, '2018-09-11', '2018', '23159058', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2626, '2018-09-11', '2018', '21078495', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2627, '2018-09-11', '2018', '21067555', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2628, '2018-09-11', '2018', '12124300', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2629, '2018-09-11', '2018', '14185107', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2630, '2018-09-11', '2018', '54185975', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2631, '2018-09-11', '2018', '12112938', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2632, '2018-09-11', '2018', '14161008', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2633, '2018-09-11', '2018', '62136116', '1', '1', 'nose', 2324.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2634, '2018-09-11', '2018', '33174219', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2635, '2018-09-11', '2018', '14184767', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2636, '2018-09-11', '2018', '13160990', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2637, '2018-09-11', '2018', '14160967', '1', '1', 'nose', 31620.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2638, '2018-09-10', '2018', '14172996', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2639, '2018-09-10', '2018', '14172736', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2640, '2018-09-10', '2018', '34186170', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2641, '2018-09-10', '2018', '11045784', '1', '1', 'nose', 3135.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2642, '2018-09-10', '2018', '11045784', '1', '1', 'nose', 2535.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2644, '2018-09-10', '2018', '13159892', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2648, '2018-09-10', '2018', '11046379', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2649, '2018-09-10', '2018', '11046379', '1', '1', 'nose', 2713.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2661, '2018-09-10', '2018', '12124346', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2662, '2018-09-10', '2018', '13159042', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2663, '2018-09-10', '2018', '33174153', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2664, '2018-09-10', '2018', '13147331', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2665, '2018-09-10', '2018', '14173188', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2666, '2018-09-10', '2018', '14186152', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2667, '2018-09-10', '2018', '14184827', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2668, '2018-09-10', '2018', '14185769', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2669, '2018-09-10', '2018', '12090400', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2670, '2018-09-10', '2018', '34185868', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2671, '2018-09-10', '2018', '14174032', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2672, '2018-09-10', '2018', '24186086', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2673, '2018-09-10', '2018', '13159251', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2674, '2018-09-10', '2018', '23148358', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2675, '2018-09-10', '2018', '14148353', '1', '1', 'nose', 4125.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2676, '2018-09-09', '2018', '14184761', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2677, '2018-09-09', '2018', '14161199', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2678, '2018-09-08', '2018', '54185127', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2679, '2018-09-08', '2018', '62147754', '1', '1', 'nose', 1056.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2680, '2018-09-07', '2018', '14184690', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2681, '2018-09-07', '2018', '14173676', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2682, '2018-09-07', '2018', '14172537', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2683, '2018-09-07', '2018', '13159050', '1', '1', 'nose', 20213.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2684, '2018-09-07', '2018', '14186305', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2685, '2018-09-07', '2018', '34184810', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2686, '2018-09-07', '2018', '13067532', '1', '1', 'nose', 1500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2687, '2018-09-07', '2018', '11056550', '1', '1', 'nose', 31620.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2688, '2018-09-07', '2018', '14186137', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2689, '2018-09-07', '2018', '13147205', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2690, '2018-09-07', '2018', '54185928', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2691, '2018-09-07', '2018', '14185489', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2692, '2018-09-07', '2018', '14173715', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2693, '2018-09-07', '2018', '12089420', '1', '1', 'nose', 1690.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2694, '2018-09-07', '2018', '14173297', '1', '1', 'nose', 2535.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2695, '2018-09-07', '2018', '13147356', '1', '1', 'nose', 2958.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2696, '2018-09-07', '2018', '23147307', '1', '1', 'nose', 1268.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2697, '2018-09-06', '2018', '13147223', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2698, '2018-09-06', '2018', '14161396', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2699, '2018-09-06', '2018', '34185214', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2700, '2018-09-06', '2018', '34185213', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2701, '2018-09-06', '2018', '14184727', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2702, '2018-09-06', '2018', '14184728', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2703, '2018-09-06', '2018', '33173799', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2704, '2018-09-06', '2018', '33174019', '1', '1', 'nose', 31620.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2705, '2018-09-06', '2018', '12078515', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2706, '2018-09-06', '2018', '54185067', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2707, '2018-09-06', '2018', '14173694', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2708, '2018-09-06', '2018', '14173153', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2709, '2018-09-06', '2018', '54184689', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2710, '2018-09-06', '2018', '33173695', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2711, '2018-09-06', '2018', '14160922', '1', '1', 'nose', 2958.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2712, '2018-09-06', '2018', '23159402', '1', '1', 'nose', 29721.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2713, '2018-09-06', '2018', '14184647', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2714, '2018-09-05', '2018', '14185874', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2715, '2018-09-05', '2018', '54185624', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2716, '2018-09-05', '2018', '14185108', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2717, '2018-09-05', '2018', '33161759', '1', '1', 'nose', 3591.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2718, '2018-09-05', '2018', '12114028', '1', '1', 'nose', 1268.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2719, '2018-09-05', '2018', '34185153', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2720, '2018-09-05', '2018', '54185152', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2721, '2018-09-05', '2018', '13147406', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2722, '2018-09-05', '2018', '14185550', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2723, '2018-09-04', '2018', '34173672', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2724, '2018-09-04', '2018', '14185538', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2725, '2018-09-04', '2018', '14185801', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2726, '2018-09-04', '2018', '14186183', '1', '1', 'nose', 3169.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2727, '2018-09-04', '2018', '14185431', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2728, '2018-09-04', '2018', '13159053', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2730, '2018-09-04', '2018', '14185172', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2731, '2018-09-04', '2018', '14185187', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2732, '2018-09-04', '2018', '14161003', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2733, '2018-09-04', '2018', '14161001', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2734, '2018-09-04', '2018', '14186057', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2735, '2018-09-04', '2018', '21067582', '1', '1', 'nose', 2535.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2736, '2018-09-04', '2018', '13159468', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2737, '2018-09-04', '2018', '14184468', '1', '1', 'nose', 3980.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2738, '2018-09-04', '2018', '14184468', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2740, '2018-09-04', '2018', '14184735', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2741, '2018-09-04', '2018', '14173987', '1', '1', 'nose', 3380.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2742, '2018-09-04', '2018', '11067499', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2743, '2018-09-03', '2018', '14173448', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2744, '2018-09-03', '2018', '14186217', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2745, '2018-09-03', '2018', '13159054', '1', '1', 'nose', 2113.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2746, '2018-09-03', '2018', '14185956', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2747, '2018-09-03', '2018', '62148478', '1', '1', 'nose', 39225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2748, '2018-09-03', '2018', '14172780', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2749, '2018-09-01', '2018', '14173989', '1', '1', 'nose', 4225.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2750, '2018-09-01', '2018', '14174180', '1', '1', 'nose', 6750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2751, '2018-09-29', '2018', '12147221', '1', '1', 'nose', 3950.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2752, '2018-09-29', '2018', '11102538', '1', '1', 'nose', 3950.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2753, '2018-09-28', '2018', '52173867', '1', '1', 'nose', 3800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2754, '2018-09-28', '2018', '11136383', '1', '1', 'nose', 3800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2755, '2018-09-27', '2018', '12147774', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2756, '2018-09-27', '2018', '11148380', '1', '1', 'nose', 22720.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2757, '2018-09-26', '2018', '62184566', '1', '1', 'nose', 3800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2758, '2018-09-26', '2018', '12184750', '1', '1', 'nose', 3800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2759, '2018-09-26', '2018', '12185930', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2760, '2018-09-24', '2018', '12184698', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2765, '2018-09-24', '2018', '11159313', '1', '1', 'nose', 3800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2766, '2018-09-21', '2018', '22184812', '1', '1', 'nose', 3800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2767, '2018-09-21', '2018', '12184813', '1', '1', 'nose', 3800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2768, '2018-09-21', '2018', '22186349', '1', '1', 'nose', 3800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2769, '2018-09-19', '2018', '31136732', '1', '1', 'nose', 15750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2770, '2018-09-19', '2018', '22184711', '1', '1', 'nose', 3800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2771, '2018-09-19', '2018', '32173884', '1', '1', 'nose', 6250.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2772, '2018-09-18', '2018', '21159331', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2773, '2018-09-18', '2018', '11159332', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2774, '2018-09-18', '2018', '52186360', '1', '1', 'nose', 6250.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2775, '2018-09-18', '2018', '52174307', '1', '1', 'nose', 3800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2776, '2018-09-18', '2018', '42184531', '1', '1', 'nose', 3800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2777, '2018-09-17', '2018', '21161660', '1', '1', 'nose', 2975.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2778, '2018-09-17', '2018', '52173671', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2779, '2018-09-17', '2018', '32172586', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2780, '2018-09-17', '2018', '11159951', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2781, '2018-09-17', '2018', '11113714', '1', '1', 'nose', 2100.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2782, '2018-09-17', '2018', '21124182', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2783, '2018-09-17', '2018', '12185249', '1', '1', 'nose', 2450.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2784, '2018-09-17', '2018', '12135755', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2785, '2018-09-17', '2018', '12172548', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2786, '2018-09-17', '2018', '31162359', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2787, '2018-09-17', '2018', '21161766', '1', '1', 'nose', 2100.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2788, '2018-09-17', '2018', '12159015', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2789, '2018-09-17', '2018', '21159125', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2790, '2018-09-17', '2018', '31173093', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2791, '2018-09-17', '2018', '42162105', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2792, '2018-09-17', '2018', '11135869', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2793, '2018-09-17', '2018', '52173710', '1', '1', 'nose', 6250.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2794, '2018-09-17', '2018', '11161014', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2795, '2018-09-17', '2018', '12135827', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2796, '2018-09-17', '2018', '22159069', '1', '1', 'nose', 3150.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2797, '2018-09-17', '2018', '11135776', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2798, '2018-09-17', '2018', '12184828', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2799, '2018-09-17', '2018', '22173383', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2800, '2018-09-17', '2018', '21124249', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2801, '2018-09-17', '2018', '21148508', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2802, '2018-09-17', '2018', '31174303', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2803, '2018-09-17', '2018', '11159137', '1', '1', 'nose', 2100.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2804, '2018-09-17', '2018', '32186168', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2805, '2018-09-17', '2018', '12160727', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2806, '2018-09-17', '2018', '12185794', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2807, '2018-09-17', '2018', '52185795', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2808, '2018-09-17', '2018', '12150299', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2809, '2018-09-17', '2018', '12150456', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2810, '2018-09-17', '2018', '12148021', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2811, '2018-09-17', '2018', '11159148', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2812, '2018-09-17', '2018', '11135925', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2813, '2018-09-17', '2018', '21113622', '1', '1', 'nose', 1050.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2814, '2018-09-17', '2018', '22186009', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2815, '2018-09-17', '2018', '11147259', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2816, '2018-09-17', '2018', '11148706', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2817, '2018-09-17', '2018', '22161344', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2818, '2018-09-17', '2018', '21160803', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2819, '2018-09-17', '2018', '42186251', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2820, '2018-09-17', '2018', '12135902', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2821, '2018-09-17', '2018', '42161684', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2822, '2018-09-17', '2018', '31161675', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2823, '2018-09-17', '2018', '12159075', '1', '1', 'nose', 2100.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2824, '2018-09-17', '2018', '12172772', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2825, '2018-09-17', '2018', '12160692', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2826, '2018-09-17', '2018', '32161676', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2827, '2018-09-17', '2018', '31124538', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2828, '2018-09-17', '2018', '11147305', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2829, '2018-09-17', '2018', '62184533', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2830, '2018-09-17', '2018', '12161415', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2831, '2018-09-17', '2018', '31147501', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2832, '2018-09-17', '2018', '11147695', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2833, '2018-09-17', '2018', '12147235', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2834, '2018-09-17', '2018', '12160629', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2835, '2018-09-17', '2018', '11135867', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2836, '2018-09-17', '2018', '11135724', '1', '1', 'nose', 23625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2837, '2018-09-17', '2018', '11158981', '1', '1', 'nose', 31500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2838, '2018-09-17', '2018', '12136823', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2839, '2018-09-16', '2018', '12160626', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2840, '2018-09-16', '2018', '12160730', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2841, '2018-09-16', '2018', '21159091', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2842, '2018-09-15', '2018', '12159955', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2843, '2018-09-15', '2018', '21124612', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2852, '2018-09-15', '2018', '21125149', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2853, '2018-09-15', '2018', '12172593', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2854, '2018-09-15', '2018', '11125490', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2855, '2018-09-15', '2018', '31125489', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2856, '2018-09-15', '2018', '12135759', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2857, '2018-09-15', '2018', '12185125', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2858, '2018-09-15', '2018', '11125343', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2859, '2018-09-15', '2018', '31162332', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2860, '2018-09-14', '2018', '32172539', '1', '1', 'nose', 31500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2861, '2018-09-14', '2018', '21161195', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2862, '2018-09-14', '2018', '12184565', '1', '1', 'nose', 6300.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2863, '2018-09-14', '2018', '11135838', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2864, '2018-09-14', '2018', '31172680', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2865, '2018-09-14', '2018', '31136002', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2866, '2018-09-14', '2018', '11147635', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2867, '2018-09-14', '2018', '31124988', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2868, '2018-09-14', '2018', '11125177', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2869, '2018-09-14', '2018', '21147454', '1', '1', 'nose', 15750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2870, '2018-09-14', '2018', '42159375', '1', '1', 'nose', 3550.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2871, '2018-09-14', '2018', '12136881', '1', '1', 'nose', 2100.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2872, '2018-09-14', '2018', '42186294', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2873, '2018-09-14', '2018', '11147478', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2874, '2018-09-14', '2018', '12147260', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2875, '2018-09-14', '2018', '12186304', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2876, '2018-09-14', '2018', '12186006', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2877, '2018-09-14', '2018', '12172545', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2878, '2018-09-14', '2018', '32172546', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2879, '2018-09-14', '2018', '11147819', '1', '1', 'nose', 25200.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL);
INSERT INTO `edocta` (`id`, `fec_oper_edo`, `anio_pago_edo`, `cve_pago_edo`, `mes_pago_edo`, `dig_pago_edo`, `descrip_edo`, `imp_abono_edo`, `imp_cargo_edo`, `estado_edo`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2880, '2018-09-14', '2018', '12147230', '1', '1', 'nose', 875.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2881, '2018-09-14', '2018', '31148344', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2882, '2018-09-14', '2018', '31148345', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2883, '2018-09-14', '2018', '32160584', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2884, '2018-09-14', '2018', '12136398', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2885, '2018-09-14', '2018', '62184518', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2886, '2018-09-14', '2018', '52184519', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2887, '2018-09-14', '2018', '12172837', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2888, '2018-09-14', '2018', '12172577', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2889, '2018-09-14', '2018', '12172576', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2890, '2018-09-14', '2018', '62184485', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2899, '2018-09-14', '2018', '62184486', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2900, '2018-09-14', '2018', '32185413', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2909, '2018-09-14', '2018', '22160637', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2910, '2018-09-14', '2018', '12172600', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2911, '2018-09-14', '2018', '12160620', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2912, '2018-09-14', '2018', '12147774', '1', '1', 'nose', 6250.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2913, '2018-09-13', '2018', '42172816', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2914, '2018-09-13', '2018', '11147891', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2915, '2018-09-13', '2018', '42186158', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2916, '2018-09-13', '2018', '22185207', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2917, '2018-09-13', '2018', '12173049', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2926, '2018-09-13', '2018', '32161225', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2935, '2018-09-13', '2018', '42162020', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2936, '2018-09-13', '2018', '42159375', '1', '1', 'nose', 3550.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2937, '2018-09-13', '2018', '31135843', '1', '1', 'nose', 2100.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2938, '2018-09-13', '2018', '12148458', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2939, '2018-09-13', '2018', '12136194', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2940, '2018-09-13', '2018', '12135844', '1', '1', 'nose', 2450.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2941, '2018-09-13', '2018', '12186006', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2942, '2018-09-13', '2018', '31161183', '1', '1', 'nose', 31500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2943, '2018-09-13', '2018', '52185058', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2944, '2018-09-13', '2018', '12186258', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2945, '2018-09-13', '2018', '62186259', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2946, '2018-09-13', '2018', '12150151', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2947, '2018-09-12', '2018', '42159375', '1', '1', 'nose', 3550.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2948, '2018-09-12', '2018', '11136838', '1', '1', 'nose', 6250.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2949, '2018-09-12', '2018', '42173892', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2950, '2018-09-12', '2018', '42185963', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2951, '2018-09-12', '2018', '12184551', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2952, '2018-09-12', '2018', '21125196', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2953, '2018-09-12', '2018', '12172561', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2954, '2018-09-12', '2018', '12148537', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2962, '2018-09-12', '2018', '52185521', '1', '1', 'nose', 25200.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2964, '2018-09-12', '2018', '62185179', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2965, '2018-09-12', '2018', '12185316', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2966, '2018-09-12', '2018', '11136863', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2967, '2018-09-11', '2018', '21147405', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2969, '2018-09-11', '2018', '22159747', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2973, '2018-09-11', '2018', '21159125', '1', '1', 'nose', 6250.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2979, '2018-09-11', '2018', '11147248', '1', '1', 'nose', 31500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2980, '2018-09-11', '2018', '11136747', '1', '1', 'nose', 31500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2981, '2018-09-11', '2018', '12184555', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2982, '2018-09-11', '2018', '21124278', '1', '1', 'nose', 1400.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2991, '2018-09-11', '2018', '21124559', '1', '1', 'nose', 2100.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2992, '2018-09-10', '2018', '12159405', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2993, '2018-09-10', '2018', '32186175', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2994, '2018-09-10', '2018', '12147269', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2995, '2018-09-10', '2018', '52185232', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2996, '2018-09-10', '2018', '22185231', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2997, '2018-09-10', '2018', '11124304', '1', '1', 'nose', 4725.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2998, '2018-09-10', '2018', '52184854', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(2999, '2018-09-10', '2018', '12184698', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3000, '2018-09-10', '2018', '11136601', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3001, '2018-09-10', '2018', '32173099', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3002, '2018-09-09', '2018', '32185039', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3003, '2018-09-08', '2018', '21135833', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3004, '2018-09-08', '2018', '21113066', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3005, '2018-09-08', '2018', '12147753', '1', '1', 'nose', 875.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3006, '2018-09-08', '2018', '31161437', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3007, '2018-09-08', '2018', '11159330', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3008, '2018-09-08', '2018', '12136620', '1', '1', 'nose', 700.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3009, '2018-09-08', '2018', '11147641', '1', '1', 'nose', 1750.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3010, '2018-09-08', '2018', '31090576', '1', '1', 'nose', 795.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3011, '2018-09-07', '2018', '32160661', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3012, '2018-09-07', '2018', '32185111', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3013, '2018-09-06', '2018', '52172764', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3014, '2018-09-06', '2018', '32174015', '1', '1', 'nose', 31500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3015, '2018-09-06', '2018', '32185886', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3016, '2018-09-06', '2018', '12159814', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3017, '2018-09-06', '2018', '21124301', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3018, '2018-09-06', '2018', '32160725', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3027, '2018-09-06', '2018', '31147357', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3028, '2018-09-06', '2018', '32162327', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3029, '2018-09-05', '2018', '42160969', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3030, '2018-09-05', '2018', '12184659', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3031, '2018-09-05', '2018', '12147436', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3035, '2018-09-05', '2018', '32161173', '1', '1', 'nose', 2450.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3036, '2018-09-05', '2018', '31161172', '1', '1', 'nose', 2450.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3037, '2018-09-05', '2018', '31135966', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3038, '2018-09-05', '2018', '62184534', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3039, '2018-09-05', '2018', '32173498', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3040, '2018-09-05', '2018', '32184737', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3041, '2018-09-05', '2018', '52173020', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3042, '2018-09-04', '2018', '22184872', '1', '1', 'nose', 2800.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3043, '2018-09-04', '2018', '42173361', '1', '1', 'nose', 31500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3044, '2018-09-04', '2018', '52185232', '1', '1', 'nose', 625.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3045, '2018-09-04', '2018', '22185231', '1', '1', 'nose', 1250.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3046, '2018-09-04', '2018', '12124922', '1', '1', 'nose', 6050.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3047, '2018-09-04', '2018', '32173048', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3048, '2018-09-04', '2018', '11135828', '1', '1', 'nose', 1050.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3057, '2018-09-04', '2018', '12148424', '1', '1', 'nose', 10000.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3058, '2018-09-04', '2018', '11089885', '1', '1', 'nose', 10000.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3059, '2018-09-04', '2018', '12135996', '1', '1', 'nose', 2975.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3068, '2018-09-04', '2018', '12172545', '1', '1', 'nose', 6250.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3069, '2018-09-03', '2018', '12160629', '1', '1', 'nose', 6250.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3070, '2018-09-03', '2018', '12135763', '1', '1', 'nose', 31500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3071, '2018-09-03', '2018', '21161352', '1', '1', 'nose', 2100.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3072, '2018-09-03', '2018', '11150487', '1', '1', 'nose', 3500.00, 0.00, 'V', 1, '2018-12-05 21:39:52', '2018-12-05 21:39:52', NULL),
(3073, '2018-09-03', '2018', '12159023', '1', '1', 'nose', 2625.00, 0.00, 'V', 1, '2018-12-05 21:39:53', '2018-12-05 21:39:53', NULL),
(3074, '2018-09-03', '2018', '22148310', '1', '1', 'nose', 2975.00, 0.00, 'V', 1, '2018-12-05 21:39:53', '2018-12-05 21:39:53', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` bigint(255) UNSIGNED NOT NULL COMMENT 'Identificador del empleado',
  `persona_id` bigint(255) UNSIGNED NOT NULL,
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

INSERT INTO `empleados` (`id`, `persona_id`, `empHorasCon`, `empPassword`, `empCredencial`, `empNomina`, `empRfc`, `empImss`, `empEstado`, `empFechaBaja`, `empCausaBaja`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 40, '$2y$10$69YsV2AYVCutMBPyhtCJeONgH54/KyOK9KIYMpzb8OOX.gpk6/OL6', 'UNI00986', 0, 'PAMI870806MP1', NULL, 'A', NULL, '', 1, NULL, '2018-11-30 20:00:43', NULL),
(2, 2, 40, '$2y$10$t1orbPiH9xd.lVGWredOAecwvE775Uw/R34DGHksdoyuX8naXlvOS', '12345678', NULL, 'IAMD873982MDJ', NULL, 'A', NULL, '', 1, '2018-11-12 20:54:07', '2018-11-12 20:54:07', NULL);

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
(1, 1, 1, 'CCO', 'CENTRO DE COMPUTO', 'CENTRO DE COMPU', 70, 30, 0, NULL, NULL, NULL),
(3, 1, 2, 'ESA', 'ESCUELA DE SALUD', 'ESCUELA DE SALU', 70, 30, 1, '2018-11-12 20:56:21', '2018-11-12 20:56:21', NULL),
(4, 1, 1, 'EIN', 'ESCUELA DE INGENIERIA', 'ESCUELA DE INGE', 72, 25, 1, '2018-11-12 20:59:07', '2018-11-12 20:59:07', NULL);

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
  `alumno_id` bigint(255) UNSIGNED NOT NULL,
  `num_per_fic` smallint(6) DEFAULT NULL,
  `anio_per_fic` smallint(6) DEFAULT NULL,
  `clave_carr_fic` char(3) DEFAULT NULL,
  `clave_prog_act_fic` char(4) DEFAULT NULL,
  `grado_sem_fic` smallint(6) DEFAULT NULL,
  `grupo_fic` char(1) DEFAULT NULL,
  `fec_impr_fic` date DEFAULT NULL,
  `hora_impr_fic` char(8) DEFAULT NULL,
  `usua_impr_fic` char(8) DEFAULT NULL,
  `tipo_fic` char(1) DEFAULT NULL,
  `conc_fic` char(2) DEFAULT NULL,
  `fvenc1_fic` date DEFAULT NULL,
  `imp1_fic` double(8,2) DEFAULT NULL,
  `ref1_fic` char(20) DEFAULT NULL,
  `fvenc2_fic` date DEFAULT NULL,
  `imp2_fic` double(8,2) DEFAULT NULL,
  `ref2_fic` char(20) DEFAULT NULL,
  `estado_fic` char(1) DEFAULT NULL,
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
(1, 1, 1, 3, 1, 'A', 'M', 2, 2, NULL, '2018-11-06', '10:00:00', 45, NULL, NULL, NULL, NULL, NULL, 'C', NULL, NULL, 1, '2018-11-12 22:12:16', '2018-11-12 22:12:16', NULL),
(2, 2, 1, 3, 1, 'A', 'M', 2, 2, NULL, '2018-11-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', NULL, NULL, 1, '2018-11-12 22:50:10', '2018-11-12 23:23:28', NULL),
(3, 5, 1, 3, 1, 'EXX', 'M', 1, NULL, NULL, NULL, NULL, 40, NULL, NULL, NULL, NULL, NULL, 'B', NULL, NULL, 1, '2018-11-13 00:42:45', '2018-11-30 22:48:21', NULL),
(4, 5, 1, 3, 1, 'B', 'M', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', NULL, NULL, 1, '2018-11-13 19:57:38', '2018-11-27 21:04:04', NULL);

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
-- Volcado de datos para la tabla `inscritos`
--

INSERT INTO `inscritos` (`id`, `curso_id`, `grupo_id`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 3, 1, '2018-11-13 00:27:21', '2018-11-29 23:59:35', '2018-11-29 23:59:35'),
(2, 6, 3, 1, '2018-11-29 07:24:40', '2018-11-29 07:24:40', NULL),
(3, 1, 4, 1, '2018-11-30 00:00:59', '2018-11-30 00:00:59', NULL);

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
(1, 2, '21111', 'ANATOMIA Y FISIOLOGIA HUMANA', 'ANATOMIA Y FISI', 1, 12, 'B', NULL, 'N', 70, 30, 'Anatomía y Fisiología Humana', 1, NULL, 1, '2018-11-12 21:07:12', '2018-11-12 21:07:12', NULL),
(2, 1, '33111', 'ALGERA Y GEOMETRIA ANALITICA', 'ALGERA Y GEOMET', 2, 9, 'B', NULL, 'N', 75, 25, 'Álgebra y Geometría Analítica', NULL, NULL, 1, '2018-11-12 21:08:52', '2018-11-12 21:08:52', NULL),
(3, 1, '3375119', 'OPTATIVA I', 'OPTATIVA I', 1, 6, 'O', NULL, 'N', 75, 25, 'Optativa 1', NULL, NULL, 1, '2018-11-12 21:10:04', '2018-11-12 22:49:00', NULL),
(4, 3, '37131', 'HISTOLOGIA Y EMBRIOLOGIA BUCAL', 'HISTOLOGIA Y EM', 1, 6, 'B', NULL, 'N', 70, 30, 'Histología Bucal', NULL, NULL, 1, '2018-11-12 21:12:02', '2018-11-12 21:12:02', NULL),
(5, 1, '33151', 'ELECTRICIDAD Y MAGNETISMO', 'ELECTRICIDAD Y', 1, 6, 'B', NULL, 'N', 75, 25, 'Electricidad y Magnetismo', 1, NULL, 1, '2018-11-13 00:42:14', '2018-11-13 00:42:14', NULL);

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
(1, 'Usuarios', 'usuario', 'Administración', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(2, 'Campus', 'ubicacion', 'Catálogos', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(3, 'Departamentos', 'departamento', 'Catálogos', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(4, 'Escuelas', 'escuela', 'Catálogos', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(5, 'Programas', 'programa', 'Catálogos', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(6, 'Planes', 'plan', 'Catálogos', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(7, 'Periodos', 'periodo', 'Catálogos', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(8, 'Acuerdos', 'acuerdo', 'Catálogos', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(9, 'Materias', 'materia', 'Catálogos', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(10, 'Optativas', 'optativa', 'Catálogos', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(11, 'Aulas', 'aula', 'Catálogos', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(12, 'Paises', 'pais', 'Catálogos', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(13, 'Estados', 'estado', 'Catálogos', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(14, 'Municipios', 'municipio', 'Catálogos', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(15, 'Empleados', 'empleado', 'Control-Escolar', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(16, 'Alumnos', 'alumno', 'Control-Escolar', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(17, 'CGTS', 'cgt', 'Control-Escolar', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(18, 'Grupos', 'grupo', 'Control-Escolar', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(19, 'Calificaciones', 'calificacion', 'Control-Escolar', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(20, 'Paquetes', 'paquete', 'Control-Escolar', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(21, 'Preinscritos', 'curso', 'Control-Escolar', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(22, 'Inscritos', 'inscrito', 'Control-Escolar', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(23, 'Reporte inscritos y preinscritos', 'r_inscrito_preinscrito', 'Reportes', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(24, 'Lista de asistencia por grupo', 'r_asistencia_grupo', 'Reportes', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(25, 'Constancia de inscripción', 'r_constancia_inscripcion', 'Reportes', '2018-12-04 01:07:45', '2018-12-04 01:07:45'),
(26, 'Aplica Pagos', 'p_pago', 'Procesos', '2018-12-04 01:07:45', '2018-12-04 01:07:45');

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

--
-- Volcado de datos para la tabla `optativas`
--

INSERT INTO `optativas` (`id`, `materia_id`, `optNumero`, `optClaveGenerica`, `optClaveEspecifica`, `optNombre`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 2312, '2323', '2424', 'PROGRAMACIÓN', 1, '2018-11-12 22:36:52', '2018-11-12 22:36:52', NULL);

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

--
-- Volcado de datos para la tabla `paquetes`
--

INSERT INTO `paquetes` (`id`, `periodo_id`, `plan_id`, `semestre`, `consecutivo`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 1, 1, 1, 1, '2018-11-13 20:31:33', '2018-11-13 20:31:33', NULL),
(2, 3, 1, 1, 2, 1, '2018-11-16 23:34:43', '2018-11-16 23:34:43', NULL);

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

--
-- Volcado de datos para la tabla `paquete_detalle`
--

INSERT INTO `paquete_detalle` (`id`, `paquete_id`, `grupo_id`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 1, 2, 1, '2018-11-13 21:15:58', '2018-11-13 21:15:58', NULL),
(9, 1, 3, 1, '2018-11-13 21:15:58', '2018-11-13 21:15:58', NULL),
(10, 2, 2, 1, '2018-11-16 23:34:43', '2018-11-30 23:01:49', '2018-11-30 23:01:49'),
(11, 2, 2, 1, '2018-11-30 23:01:49', '2018-11-30 23:02:13', '2018-11-30 23:02:13'),
(12, 2, 3, 1, '2018-11-30 23:01:49', '2018-11-30 23:02:13', '2018-11-30 23:02:13'),
(13, 2, 3, 1, '2018-11-30 23:02:13', '2018-11-30 23:02:13', NULL);

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
(1, 1, 1, 2017, '2017-01-23', '2017-12-07', 'A', 1, '2018-11-12 21:03:43', '2018-11-12 21:03:43', NULL),
(2, 1, 2, 2017, '2017-07-01', '2017-07-31', 'A', 1, '2018-11-12 21:04:14', '2018-11-12 21:04:14', NULL),
(3, 1, 3, 2017, '2017-08-21', '2018-01-21', 'A', 1, '2018-11-12 21:04:42', '2018-11-12 21:04:42', NULL);

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
(1, 5, 1, '2018-11-12 21:32:03', '2018-11-12 21:32:03');

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
(1, 'A', 'super', 'Administrador del sistema', '2018-11-28 02:06:19', '2018-11-28 02:06:19'),
(2, 'B', 'master', 'Administrador del datos', '2018-11-28 02:06:19', '2018-11-28 02:06:19'),
(3, 'C', 'admin', 'Coordinadores y Directores', '2018-11-28 02:06:19', '2018-11-28 02:06:19'),
(4, 'D', 'user', 'Consultas', '2018-11-28 02:06:19', '2018-11-28 02:06:19');

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
(1, 1, 1, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(2, 1, 2, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(3, 1, 3, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(4, 1, 4, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(5, 1, 5, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(6, 1, 6, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(7, 1, 7, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(8, 1, 8, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(9, 1, 9, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(10, 1, 10, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(11, 1, 11, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(12, 1, 12, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(13, 1, 13, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(14, 1, 14, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(15, 1, 15, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(16, 1, 16, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(17, 1, 17, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(18, 1, 18, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(19, 1, 19, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(20, 1, 20, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(21, 1, 21, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(22, 1, 22, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(23, 1, 23, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(24, 1, 24, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(25, 1, 25, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48'),
(26, 1, 26, 1, '2018-12-04 01:07:48', '2018-12-04 01:07:48');

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
(1, 'PAMI870806HYNRRS07', 'PAREDES', 'MORENO', 'ISMAEL ALBERTO', '1987-08-06', 1, 'M', 'ISMAELPAREDES@MODELO.EDU.MX', '9993729437', NULL, 97130, '1', NULL, '359', 'VISTA ALEGRE NORTE', 1, NULL, '2018-11-30 20:00:34', NULL),
(2, '000L990807MYNSRR06', 'IZA', 'LOPEZ', 'JESICA', '1981-09-18', 1, 'F', NULL, NULL, NULL, 97000, '2', NULL, '284', 'JUAN PABLO', 1, '2018-11-12 20:53:15', '2018-11-12 20:53:15', NULL),
(5, 'AAAE940526HDFLRD00', 'LOPEZ', 'LOPEZ', 'JUANITO', '2018-10-30', 1, 'M', NULL, NULL, NULL, 97000, '23', NULL, '234', 'CENTRO', 1, '2018-11-13 00:03:16', '2018-11-13 00:03:16', NULL),
(6, 'PAMI870806HYNRRS04', 'PEREZ', 'PEREZ', 'PANCHITO', '2018-10-31', 1, 'M', NULL, NULL, NULL, 97000, '1', NULL, 'A', 'CENTRO', 1, '2018-11-27 21:13:30', '2018-11-27 21:13:30', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes`
--

CREATE TABLE `planes` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `programa_id` bigint(255) UNSIGNED NOT NULL,
  `planClave` varchar(4) NOT NULL,
  `planPeriodos` tinyint(2) NOT NULL COMMENT 'Cantidad de períodos',
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catálogo de planes escolares';

--
-- Volcado de datos para la tabla `planes`
--

INSERT INTO `planes` (`id`, `programa_id`, `planClave`, `planPeriodos`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, '2017', 8, 1, '2018-11-12 21:00:36', '2018-11-12 21:00:36', NULL),
(2, 1, '2017', 8, 1, '2018-11-12 21:00:49', '2018-11-12 21:00:49', NULL),
(3, 2, '2017', 8, 1, '2018-11-12 21:02:09', '2018-11-12 21:02:09', NULL);

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

--
-- Volcado de datos para la tabla `prerequisitos`
--

INSERT INTO `prerequisitos` (`id`, `materia_id`, `materia_prerequisito_id`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 5, 1, '2018-11-14 00:07:49', '2018-11-14 00:07:49', NULL);

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
(1, 3, 2, 'NUT', 'NUTRICION', 'NUTRICION', NULL, NULL, 'Licenciatura en Nutrición', 1, '2018-11-12 20:57:43', '2018-11-12 20:57:43', NULL),
(2, 3, 2, 'CDX', 'CIRUJANO DENTISTA', 'CIRUJANO DENTIS', NULL, NULL, 'Cirujano Dentista', 1, '2018-11-12 20:58:18', '2018-11-12 20:58:18', NULL),
(3, 4, 1, 'IBM', 'INGENIERIA BIOMEDICA', 'INGENIERIA BIOM', NULL, NULL, 'Ingeniería Biomédica', 1, '2018-11-12 21:00:00', '2018-11-12 21:00:00', NULL),
(4, 4, 1, 'IMK', 'INGENIERIA MECATRONICA', 'INGENIERIA MECA', NULL, NULL, 'Ingeniería Mecatrónica', 1, '2018-11-30 20:09:35', '2018-11-30 20:09:35', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referencias`
--

CREATE TABLE `referencias` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `alumno_id` bigint(255) UNSIGNED NOT NULL,
  `programa_id` bigint(255) UNSIGNED NOT NULL,
  `num_ref` char(4) NOT NULL,
  `anio_per_ref` smallint(4) NOT NULL,
  `conc_pago_ref` char(2) NOT NULL,
  `fecha_venc_ref` date NOT NULL,
  `imp_total_ref` decimal(8,2) NOT NULL,
  `imp_conc_ref` decimal(8,2) DEFAULT NULL,
  `imp_beca_ref` decimal(8,2) DEFAULT NULL,
  `imp_pp_ref` decimal(8,2) DEFAULT NULL,
  `imp_ant_cred_ref` decimal(8,2) DEFAULT NULL,
  `imp_recar_ref` decimal(8,2) DEFAULT NULL,
  `usua_gen_ref` int(10) UNSIGNED NOT NULL,
  `fec_gen_ref` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usua_apli_ref` int(10) UNSIGNED DEFAULT NULL,
  `fec_apli_ref` timestamp NULL DEFAULT NULL,
  `edo_ref` char(1) DEFAULT NULL,
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
(1, 'CME', 'MERIDA CHOLUL', 'CHOLUL', '97000', 1, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `empleado_id` bigint(255) UNSIGNED NOT NULL,
  `escuela_id` bigint(255) UNSIGNED NOT NULL,
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

INSERT INTO `users` (`id`, `empleado_id`, `escuela_id`, `username`, `password`, `remember_token`, `token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'ISMAEL', '$2y$10$gbtZqFVbUVtd9tCjvKxldOBmbmaBhe7uWQOZ3X2iKvrGrsPxIUscm', 'nANT58BTJsS6hRryUVU7nunQ5tCnWTuZruu9VGUB3nxXGGbwM50BnaokuwHh', '', NULL, NULL, NULL),
(5, 2, 3, 'JESICA', '$2y$10$2ggPqeWEk/LKQs5TxFMZ2uSB6lsQsg5gpeXav/VleZ0WVe6V/derO', 'FFbZi87nfQKQzbVDx59jC0cjESqzM2Sv0LTcrxfUars1izMhC1JPaa5HsZd1', 'INebFI9if4KtKBSGQiQd0KMqOPPFyZt0F9v6pjfRVlgdAucBhOr7fd22GOYttBr3', '2018-11-12 21:32:03', '2018-11-12 21:32:03', NULL);

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
  ADD UNIQUE KEY `uk_edocta_unico` (`fec_oper_edo`,`cve_pago_edo`,`mes_pago_edo`,`dig_pago_edo`,`imp_abono_edo`,`imp_cargo_edo`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `empRfc_UNIQUE` (`empRfc`,`deleted_at`),
  ADD UNIQUE KEY `empNomina_UNIQUE` (`empNomina`,`deleted_at`),
  ADD UNIQUE KEY `empCredencial_UNIQUE` (`empCredencial`,`deleted_at`),
  ADD UNIQUE KEY `empPersona` (`persona_id`,`deleted_at`),
  ADD KEY `dk_empleado_persona_idx` (`persona_id`);

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
  ADD UNIQUE KEY `uk_referencia_unica` (`alumno_id`,`num_ref`),
  ADD KEY `fk_referencia_usu_gen_idx` (`usua_gen_ref`),
  ADD KEY `fk_referencia_usu_apli_idx` (`usua_apli_ref`),
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
  ADD KEY `fk_user_empleado_idx` (`empleado_id`),
  ADD KEY `fk_user_escuela_idx` (`escuela_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acuerdos`
--
ALTER TABLE `acuerdos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `aulas`
--
ALTER TABLE `aulas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cgt`
--
ALTER TABLE `cgt`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `edocta`
--
ALTER TABLE `edocta`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3075;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identificador del empleado', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- AUTO_INCREMENT de la tabla `inscritos`
--
ALTER TABLE `inscritos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `paquete_detalle`
--
ALTER TABLE `paquete_detalle`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `periodos`
--
ALTER TABLE `periodos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `permisos_programas_user`
--
ALTER TABLE `permisos_programas_user`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `permission_module_user`
--
ALTER TABLE `permission_module_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `planes`
--
ALTER TABLE `planes`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `prerequisitos`
--
ALTER TABLE `prerequisitos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `programas`
--
ALTER TABLE `programas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `fk_referencia_usu_apli` FOREIGN KEY (`usua_apli_ref`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_referencia_usu_gen` FOREIGN KEY (`usua_gen_ref`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD CONSTRAINT `fk_ubicacion_municipios` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_empleado` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_escuela` FOREIGN KEY (`escuela_id`) REFERENCES `escuelas` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
