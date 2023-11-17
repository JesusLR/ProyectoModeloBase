-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 23-11-2018 a las 20:48:59
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
  `aluEstado` enum('R','B','P') NOT NULL DEFAULT 'P' COMMENT 'Estado inscripción: Baja, Regular, Preinscrito',
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
(1, 5, 11180100, 'P', '2018-11-12 18:03:16', 1, 1, NULL, 1, '2018-11-13 00:03:16', '2018-11-13 00:03:16', NULL);

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
(1, 1, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, 1, NULL, '2018-11-24 01:00:06', NULL);

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
(2, 1, 3, 1, 'A', 'M', 45, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2018-11-12 22:35:24', '2018-11-12 22:35:24', NULL),
(3, 1, 3, 1, 'B', 'M', 45, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2018-11-13 19:56:35', '2018-11-15 21:26:21', NULL);

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
(1, 0100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas`
--

CREATE TABLE `cuotas` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `cuoTipo` char(1) NOT NULL,
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
  `curTipoBeca` char(1) DEFAULT NULL,
  `curPorcentajeBeca` smallint(6) DEFAULT NULL,
  `curObservacionesBeca` char(30) DEFAULT NULL,
  `curFechaRegistro` date DEFAULT NULL,
  `curFechaBaja` date DEFAULT NULL,
  `curEstado` char(1) DEFAULT 'A',
  `curTipoIngreso` char(2) DEFAULT NULL,
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

INSERT INTO `cursos` (`id`, `alumno_id`, `cgt_id`, `curTipoBeca`, `curPorcentajeBeca`, `curObservacionesBeca`, `curFechaRegistro`, `curFechaBaja`, `curEstado`, `curTipoIngreso`, `curImporteInscripcion`, `curImporteMensualidad`, `curImporteVencimiento`, `curImporteDescuento`, `curDiasProntoPago`, `curPlanPago`, `curOpcionTitulo`, `curAnioCuotas`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, NULL, NULL, NULL, NULL, NULL, 'A', 'NI', NULL, NULL, NULL, NULL, NULL, 'N', 'N', NULL, 1, '2018-11-13 00:06:51', '2018-11-13 00:14:55', NULL);

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
(1, 1, 40, NULL, 'UNI00986', 0, 'PAMI870806MP1', '', 'A', NULL, '', 0, NULL, NULL, NULL),
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
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `cgt_id` bigint(255) UNSIGNED NOT NULL,
  `materia_id` bigint(255) UNSIGNED NOT NULL,
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

INSERT INTO `grupos` (`id`, `cgt_id`, `materia_id`, `empleado_id`, `empleado_sinodal_id`, `gpoMatClaveComplementaria`, `gpoFechaExamenOrdinario`, `gpoHoraExamenOrdinario`, `gpoCupo`, `gpoNumeroFolio`, `gpoNumeroActa`, `gpoNumeroLibro`, `grupo_equivalente_id`, `optativa_id`, `estado_act`, `fecha_mov_ord_act`, `clave_actv`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 2, 2, NULL, '2018-11-06', '10:00:00', 45, NULL, NULL, NULL, NULL, NULL, 'C', NULL, NULL, 1, '2018-11-12 22:12:16', '2018-11-12 22:12:16', NULL),
(2, 2, 2, 2, 2, NULL, '2018-11-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', NULL, NULL, 1, '2018-11-12 22:50:10', '2018-11-12 23:23:28', NULL),
(3, 2, 5, 1, NULL, NULL, NULL, NULL, 45, NULL, NULL, NULL, NULL, NULL, 'B', NULL, NULL, 1, '2018-11-13 00:42:45', '2018-11-24 00:05:54', NULL),
(4, 3, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', NULL, NULL, 1, '2018-11-13 19:57:38', '2018-11-13 19:57:38', NULL);

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
(1, 1, 3, 1, '2018-11-13 00:27:21', '2018-11-13 00:54:15', NULL);

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
(5, 1, '33151', 'ELECTRICIDAD Y MAGNETISMO', 'ELECTRICIDAD Y', 1, 6, 'B', NULL, 'A', 75, 25, 'Electricidad y Magnetismo', 1, NULL, 1, '2018-11-13 00:42:14', '2018-11-13 00:42:14', NULL);

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
(1, 'Usuarios', 'usuario', 'Administración', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(2, 'Campus', 'ubicacion', 'Catálogos', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(3, 'Departamentos', 'departamento', 'Catálogos', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(4, 'Escuelas', 'escuela', 'Catálogos', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(5, 'Programas', 'programa', 'Catálogos', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(6, 'Planes', 'plan', 'Catálogos', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(7, 'Periodos', 'periodo', 'Catálogos', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(8, 'Acuerdos', 'acuerdo', 'Catálogos', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(9, 'Materias', 'materia', 'Catálogos', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(10, 'Optativas', 'optativa', 'Catálogos', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(11, 'Aulas', 'aula', 'Catálogos', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(12, 'Paises', 'pais', 'Catálogos', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(13, 'Estados', 'estado', 'Catálogos', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(14, 'Municipios', 'municipio', 'Catálogos', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(15, 'Empleados', 'empleado', 'Control-Escolar', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(16, 'Alumnos', 'alumno', 'Control-Escolar', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(17, 'CGTS', 'cgt', 'Control-Escolar', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(18, 'Grupos', 'grupo', 'Control-Escolar', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(19, 'Calificaciones', 'calificacion', 'Control-Escolar', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(20, 'Paquetes', 'paquete', 'Control-Escolar', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(21, 'Preinscritos', 'curso', 'Control-Escolar', '2018-11-20 23:14:48', '2018-11-20 23:14:48'),
(22, 'Inscritos', 'inscrito', 'Control-Escolar', '2018-11-20 23:14:48', '2018-11-20 23:14:48');

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
(10, 2, 2, 1, '2018-11-16 23:34:43', '2018-11-16 23:34:43', NULL);

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
(1, 'A', 'super', 'Administrador del sistema', '2018-11-12 20:43:25', '2018-11-12 20:43:25'),
(2, 'B', 'master', 'Administrador del datos', '2018-11-12 20:43:25', '2018-11-12 20:43:25'),
(3, 'C', 'admin', 'Coordinadores y Directores', '2018-11-12 20:43:25', '2018-11-12 20:43:25'),
(4, 'D', 'user', 'Consultas', '2018-11-12 20:43:25', '2018-11-12 20:43:25');

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
(1, 1, 1, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(2, 1, 2, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(3, 1, 3, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(4, 1, 4, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(5, 1, 5, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(6, 1, 6, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(7, 1, 7, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(8, 1, 8, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(9, 1, 9, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(10, 1, 10, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(11, 1, 11, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(12, 1, 12, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(13, 1, 13, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(14, 1, 14, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(15, 1, 15, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(16, 1, 16, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(17, 1, 17, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(18, 1, 18, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(19, 1, 19, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(20, 1, 20, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(21, 1, 21, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(22, 1, 22, 1, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(23, 3, 18, 5, '2018-11-20 23:14:52', '2018-11-20 23:14:52'),
(24, 3, 19, 5, '2018-11-20 23:14:52', '2018-11-20 23:14:52');

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
(1, 'PAMI870806HYNRRS07', 'PAREDES', 'MORENO', 'ISMAEL ALBERTO', '1987-08-06', 1, 'M', 'ISMAELPAREDES@MODELO.EDU.MX', '9993729437', NULL, 97130, '1', NULL, '359', 'VISTA ALEGRE NORTE', 0, NULL, NULL, NULL),
(2, '000L990807MYNSRR06', 'IZA', 'LOPEZ', 'JESICA', '1981-09-18', 1, 'F', NULL, NULL, NULL, 97000, '2', NULL, '284', 'JUAN PABLO', 1, '2018-11-12 20:53:15', '2018-11-12 20:53:15', NULL),
(5, 'AAAE940526HDFLRD00', 'LOPEZ', 'LOPEZ', 'JUANITO', '2018-10-30', 1, 'M', NULL, NULL, NULL, 97000, '23', NULL, '234', 'CENTRO', 1, '2018-11-13 00:03:16', '2018-11-13 00:03:16', NULL);

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
(3, 4, 1, 'IBM', 'INGENIERIA BIOMEDICA', 'INGENIERIA BIOM', NULL, NULL, 'Ingeniería Biomédica', 1, '2018-11-12 21:00:00', '2018-11-12 21:00:00', NULL);

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
(1, 1, 1, 'ISMAEL', '$2y$10$gbtZqFVbUVtd9tCjvKxldOBmbmaBhe7uWQOZ3X2iKvrGrsPxIUscm', 'luZzHTI3I2osRSpTIxvpOIbJrY2letMp1TGTvxhRqagmH6WVq0GEnRHRJ7XI', '', NULL, NULL, NULL),
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
  ADD UNIQUE KEY `uk_cursos_unique` (`alumno_id`,`cgt_id`,`deleted_at`),
  ADD KEY `fk_curso_alumno_idx` (`alumno_id`),
  ADD KEY `fk_curso_cgt_idx` (`cgt_id`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `depClave_UNIQUE` (`depClave`,`deleted_at`),
  ADD KEY `fk_departamento_actual_idx` (`perActual`),
  ADD KEY `fk_departamento_ubicacion_idx` (`ubicacion_id`);

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
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_grupo_unique` (`cgt_id`,`materia_id`,`deleted_at`),
  ADD KEY `fk_grupo_cgt_idx` (`cgt_id`),
  ADD KEY `fk_grupo_empleado_idx` (`empleado_id`),
  ADD KEY `fk_grupo_sinodal_idx` (`empleado_sinodal_id`),
  ADD KEY `fk_grupo_optativa_idx` (`optativa_id`),
  ADD KEY `fk_grupo_materia_idx` (`materia_id`);

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
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `aulas`
--
ALTER TABLE `aulas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cgt`
--
ALTER TABLE `cgt`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `fk_curso_cgt` FOREIGN KEY (`cgt_id`) REFERENCES `cgt` (`id`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT ` fk_grupo_cgt` FOREIGN KEY (`cgt_id`) REFERENCES `cgt` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_empleado` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_materia` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_optativa` FOREIGN KEY (`optativa_id`) REFERENCES `optativas` (`id`) ON UPDATE CASCADE,
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
