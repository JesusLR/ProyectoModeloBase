-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 23-10-2018 a las 20:09:39
-- Versión del servidor: 10.1.35-MariaDB
-- Versión de PHP: 7.2.9

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

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`luislara`@`%` PROCEDURE `bajaCurso` (`periodo` SMALLINT, `anio` SMALLINT, `alumno` CHAR(8), `fechaBaja` DATE)  BEGIN
	UPDATE cursos
	SET
		curEstado = 'B',
		curFechaBaja = fechaBaja
	WHERE perNumero = periodo
	AND perAnio = anio
	AND aluClave = alumno;
END$$

CREATE DEFINER=`luislara`@`%` PROCEDURE `cambiaEstadoCurso` (`periodo` SMALLINT, `anio` SMALLINT, `alumno` CHAR(8), `estado` CHAR(1), `fechaBaja` DATE)  BEGIN
	UPDATE cursos
	SET
		curEstado = estado,
		curFechaBaja = fechaBaja
	WHERE perNumero = periodo
	AND perAnio = anio
	AND aluClave = alumno;
END$$

CREATE DEFINER=`luislara`@`%` PROCEDURE `eliminarCGT` (`periodo` SMALLINT, `anio` SMALLINT, `ubicacion` CHAR(3), `programa` CHAR(3), `plan` CHAR(4), `gradoSemestre` SMALLINT, `grupo` CHAR(3), `turno` CHAR(1))  BEGIN
delete from cgt
where `perNumero` = periodo
and `perAnio` = anio
and `ubiClave` = ubicacion
and `progClave` = programa
and `planClave` =plan
and `cgtGradoSemestre` = gradoSemestre
and `cgtGrupo` = grupo
and `cgtTurno` = turno;
END$$

CREATE DEFINER=`luislara`@`%` PROCEDURE `eliminarGrupo` (`periodo` SMALLINT, `anio` SMALLINT, `programa` CHAR(3), `plan` CHAR(4), `materia` CHAR(7), `grupo` CHAR(3), `turno` CHAR(1))  BEGIN
	DELETE FROM grupos
	WHERE perNumero = periodo
	AND perAnio = anio
	AND progClave like programa
	AND planClave like plan
	AND matClave like materia
	AND cgtGrupo like grupo
	AND cgtTurno like turno;
END$$

CREATE DEFINER=`luislara`@`%` PROCEDURE `eliminarGrupoHorario` (`periodo` INT, `anio` INT, `programa` CHAR(3), `plan` CHAR(4), `materia` CHAR(7), `grupo` CHAR(3), `turno` CHAR(1), `dia` INT, `inicio` INT)  BEGIN
	DELETE FROM gruposHorarios
	WHERE perNumero = periodo
		AND perAnio = anio
		AND progClave = programa
		AND planClave = plan
		AND matClave = materia
		AND cgtGrupo = grupo
		AND cgtTurno = turno
		AND ghDia = dia
		AND ghInicio = inicio
	;
END$$

CREATE DEFINER=`scem_admin`@`%` PROCEDURE `insertarAula` (`i_ubicacion_id` BIGINT(255), `i_aulaClave` CHAR(3), `i_aulaCupo` SMALLINT(6), `i_aulaDescripcion` VARCHAR(45), `i_aulaUbicacion` VARCHAR(45), `i_usuario_at` INT(10))  BEGIN
INSERT INTO `SCEM`.`aulas`
(
	`ubicacion_id`,
	`aulaClave`,
	`aulaCupo`,
	`aulaDescripcion`,
    `aulaUbicacion`,
	`usuario_at`
)
VALUES
(
	i_ubicacion_id,
    i_aulaClave ,
    i_aulaCupo,
    i_aulaDescripcion,
    i_aulaUbicacion,
    i_usuario_at
);

END$$

CREATE DEFINER=`scem_admin`@`%` PROCEDURE `insertarCGT` (`i_plan_id` BIGINT(255), `i_periodo_id` BIGINT(255), `i_cgtGradoSemestre` SMALLINT, `i_cgtGrupo` CHAR(3), `i_cgtTurno` CHAR(1), `i_cgtDescripcion` VARCHAR(30), `i_cgtCupo` SMALLINT(4), `i_empleado_id` BIGINT(255), `i_usuario_at` BIGINT(255))  BEGIN
INSERT INTO `SCEM`.`cgt`
(
	`plan_id`,
	`periodo_id`,
	`cgtGradoSemestre`,
	`cgtGrupo`,
	`cgtTurno`,
    `cgtDescripcion`,
	`cgtCupo`,
	`empleado_id`,
	`usuario_at`
)
VALUES
(
	 i_plan_id,
    i_periodo_id ,
    i_cgtGradoSemestre,
    i_cgtGrupo,
    i_cgtTurno,
    i_cgtDescripcion,
    i_cgtCupo,
    i_empleado_id,
    i_usuario_at
);

END$$

CREATE DEFINER=`scem_admin`@`%` PROCEDURE `insertarCurso` (`i_alumno_id` BIGINT(255), `i_cgt_id` BIGINT(255), `i_curTipoBeca` CHAR(1), `i_curPorcentajeBeca` SMALLINT(6), `i_curObservacionesBeca` CHAR(30), `i_curTipoIngreso` CHAR(2), `i_curImporteInscripcion` DECIMAL(8,2), `i_curImporteMensualidad` DECIMAL(8,2), `i_curImporteVencimiento` DECIMAL(8,2), `i_curImporteDescuento` DECIMAL(8,2), `i_curDiasProntoPago` SMALLINT(6), `i_curPlanPago` CHAR(1), `i_curOpcionTitulo` CHAR(1), `i_curAnioCuotas` SMALLINT(6), `i_usuario_at` INT(10))  BEGIN
INSERT INTO `SCEM`.`cursos`
(
	`alumno_id`,
	`cgt_id`,
	`curTipoBeca`,
	`curPorcentajeBeca`,
	`curObservacionesBeca`,
	`curTipoIngreso`,
	`curImporteInscripcion`,
	`curImporteMensualidad`,
	`curImporteVencimiento`,
	`curImporteDescuento`,
	`curDiasProntoPago`,
	`curPlanPago`,
	`curOpcionTitulo`,
	`curAnioCuotas`,
	`usuario_at`
)
VALUES
(
	i_alumno_id,
    i_cgt_id,
    i_curTipoBeca,
	i_curPorcentajeBeca,
	i_curObservacionesBeca,
	i_curTipoIngreso,
	i_curImporteInscripcion,
	i_curImporteMensualidad,
	i_curImporteVencimiento,
	i_curImporteDescuento,
	i_curDiasProntoPago,
	i_curPlanPago,
	i_curOpcionTitulo,
	i_curAnioCuotas,
    i_usuario_at
);

END$$

CREATE DEFINER=`scem_admin`@`%` PROCEDURE `insertarGrupo` (`i_cgt_id` BIGINT(255), `i_materia_id` BIGINT(255), `i_empleado_id` BIGINT(255), `i_empleado_sinodal_id` BIGINT(255), `i_gpoMatClaveComplementaria` VARCHAR(30), `i_gpoFechaExamenOrdinario` DATE, `i_gpoHoraExamenOrdinario` TIME, `i_gpoCupo` SMALLINT(6), `i_gpoNumeroFolio` VARCHAR(6), `i_gpoNumeroActa` VARCHAR(6), `i_gpoNumeroLibro` VARCHAR(6), `i_grupo_equivalente_id` BIGINT(255), `i_gpoNumeroOptativa` CHAR(2), `i_usuario_at` BIGINT(255))  BEGIN
INSERT INTO `SCEM`.`grupos`
(
	`cgt_id`,
	`materia_id`,
	`empleado_id`,
	`empleado_sinodal_id`,
	`gpoMatClaveComplementaria`,
    `gpoFechaExamenOrdinario`,
	`gpoHoraExamenOrdinario`,
	`gpoCupo`,
	`gpoNumeroFolio`,
    `gpoNumeroActa`,
    `gpoNumeroLibro`,
    `grupo_equivalente_id`,
    `gpoNumeroOptativa`,
    `usuario_at`
)
VALUES
(
	i_cgt_id,
    i_materia_id,
    i_empleado_id,
    i_empleado_sinodal_id,
    i_gpoMatClaveComplementaria,
    i_gpoFechaExamenOrdinario,
    i_gpoHoraExamenOrdinario,
    i_gpoCupo,
    i_gpoNumeroFolio,
    i_gpoNumeroActa,
    i_gpoNumeroLibro,
    i_grupo_equivalente_id,
    i_gpoNumeroOptativa,
    i_usuario_at
);

END$$

CREATE DEFINER=`luislara`@`%` PROCEDURE `insertarGrupoHorario` (`periodo` INT, `anio` INT, `programa` CHAR(3), `plan` CHAR(4), `materia` CHAR(7), `grupo` CHAR(3), `turno` CHAR(1), `dia` INT, `inicio` INT, `final` INT, `aula` CHAR(3))  BEGIN
	INSERT INTO gruposHorarios (
		perNumero,
		perAnio,
		progClave,
		planClave,
		matClave,
		cgtGrupo,
		cgtTurno,
		ghDia,
		ghInicio,
		ghFinal,
		ghAula
	)
	VALUES (
		periodo,
		anio,
		programa,
		plan,
		materia,
		grupo,
		turno,
		dia,
		inicio,
		final,
		aula
	);
END$$

CREATE DEFINER=`luislara`@`%` PROCEDURE `insertarInscrito` (`alumno` CHAR(8), `periodo` INT, `anio` INT, `programa` CHAR(3), `plan` CHAR(4), `materia` CHAR(15), `grupo` CHAR(3))  BEGIN
	insert into inscritos (
		aluClave,
		perNumero,
		perAnio,
		progClave,
		planClave,
		matClave,
		cgtGrupo
	)
	values (
		alumno, 
		periodo,
		anio,
		programa,
		plan,
		materia,
		grupo
	);
END$$

CREATE DEFINER=`luislara`@`%` PROCEDURE `modificarCGT` (`periodo` SMALLINT, `anio` SMALLINT, `ubicacion` CHAR(3), `programa` CHAR(3), `plan` CHAR(4), `grado` SMALLINT, `grupo` CHAR(3), `turno` CHAR(1), `descripcion` CHAR(30), `empleado` CHAR(6), `estado` CHAR(1), `cupo` SMALLINT, `total` SMALLINT, `inscritos` SMALLINT, `preinscritos` SMALLINT, `baja` SMALLINT, `otros` SMALLINT)  BEGIN
UPDATE cgt
SET
	perNumero = periodo,
	perAnio = anio,
	ubiClave = ubicacion,
	progClave = programa,
	planClave = plan,
	cgtGradoSemestre = grado,
	cgtGrupo = grupo,
	cgtTurno = turno,
	cgtDescripcion = descripcion,
	empClave = empleado,
	cgtEstado = estado,
	cgtCupo = cupo,
	cgtTotalRegistrados = total,
	cgtInscritos = inscritos,
	cgtPreinscritos = preinscritos,
	cgtBaja = baja,
	cgtOtros = otros
WHERE perNumero = periodo
	AND perAnio = anio
    AND ubiClave like ubicacion
    AND progClave like programa
	AND planClave like plan
	AND cgtGradoSemestre = grado
	AND cgtGrupo like grupo
	AND cgtTurno like turno;
END$$

CREATE DEFINER=`luislara`@`%` PROCEDURE `modificarCurso` (`periodo` SMALLINT, `anio` SMALLINT, `alumno` CHAR(8), `programa` CHAR(3), `plan` CHAR(4), `grado` SMALLINT, `grupo` CHAR(3), `tipoBeca` CHAR(1), `porcentajeBeca` SMALLINT, `observacionesBeca` CHAR(30), `tipoIngreso` CHAR(2), `importeInscripcion` DECIMAL, `importeMensualidad` DECIMAL, `importeVencimiento` DECIMAL, `importeDescuento` DECIMAL, `diasProntoPago` SMALLINT, `planPago` CHAR(1), `usuarioCuotas` CHAR(30), `fechaCuotas` DATE, `opcionTitulo` CHAR(1), `anioCuotas` SMALLINT, `ubicacion` CHAR(3))  BEGIN
	UPDATE cursos
	SET
		progClave = programa,
		planClave = plan,
		cgtGradoSemestre = grado,
		cgtGrupo = grupo,
		curTipoBeca = tipoBeca,
		curPorcentajeBeca = porcentajeBeca,
		curObservacionesBeca = observacionesBeca,
		curTipoIngreso = tipoIngreso,
		curImporteInscripcion = importeInscripcion,
		curImporteMensualidad = importeMensualidad,
		curImporteVencimiento = importeVencimiento,
		curImporteDescuento = importeDescuento,
		curDiasProntoPago = diasProntoPago,
		curPlanPago = planPago,
		curUsuarioCuotas = usuarioCuotas,
		curFechaCuotas = fechaCuotas,
		curOpcionTitulo = opcionTitulo,
		curAnioCuotas = anioCuotas,
		ubiClave = ubicacion
	WHERE perNumero like periodo
	AND perAnio = anio
	AND aluClave = alumno;
END$$

CREATE DEFINER=`luislara`@`%` PROCEDURE `modificarGrupo` (`periodo` INT, `anio` INT, `programa` CHAR(3), `plan` CHAR(4), `materia` CHAR(7), `grupo` CHAR(3), `turno` CHAR(1), `materiaComplementaria` CHAR(7), `fechaExamenOrdinario` DATE, `horaExamenOrdinario` TIME, `cupo` INT, `inscritos` INT, `programaEquivalente` CHAR(3), `planEquivalente` CHAR(4), `materiaEquivalente` CHAR(7), `grupoEquivalente` CHAR(3), `empleado` CHAR(4), `sinodal` CHAR(4), `folio` CHAR(6), `acta` CHAR(6), `libro` CHAR(6), `nombreOficialMateria` CHAR(78), `ubicacion` CHAR(3), `numeroOptativa` INT)  BEGIN
	update grupos
		set
			gpoMatClaveComplementaria = materiaComplementaria,
			gpoFechaExamenOrdinario = fechaExamenOrdinario,
			gpoHoraExamenOrdinario = horaExamenOrdinario,
			gpoCupo = cupo,
			gpoInscritos = inscritos,
			gpoProgClaveEquivalente = programaEquivalente,
			gpoPlanClaveEquivalente = planEquivalente,
			gpoMatClaveEquivalente = materiaEquivalente,
			gpoClaveEquivalente = grupoEquivalente,
			empClave = empleado,
			gpoEmpClaveSinodal = sinodal,
			gpoNumeroFolio = folio,
			gpoNumeroActa = acta,
			gpoNumeroLibro = libro,
			gpoNombreOficialMateria = nombreOficialMateria,
			ubiClave = ubicacion,
			gpoNumeroOptativa = numeroOptativa
		where perNumero = periodo
			and perAnio = anio
			and progClave = programa
			and planClave = plan
			and matClave = materia
			and cgtGrupo = grupo
			and cgtTurno = turno;

END$$

CREATE DEFINER=`luislara`@`%` PROCEDURE `modificarGrupoHorario` (`periodo` INT, `anio` INT, `programa` CHAR(3), `plan` CHAR(4), `materia` CHAR(15), `grupo` CHAR(3), `turno` CHAR(1), `diaOriginal` INT, `horaInicialOriginal` INT, `diaNuevo` INT, `horaInicialNuevo` INT, `horaFinal` INT, `aula` CHAR(3))  BEGIN
	UPDATE gruposHorarios
	SET ghDia = diaNuevo,
		ghInicio = horaInicialNuevo,
		ghFinal = horaFinal,
		ghAula = aula
	WHERE perNumero = periodo
		AND perAnio = anio
		AND progClave = programa
		AND planClave = plan
		AND matClave = materia
		AND cgtGrupo = grupo
		AND cgtTurno = turno
		AND ghDia = diaOriginal
		and ghInicio = horaInicialOriginal;
END$$

DELIMITER ;

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
(2, 1, 11990032, 'P', '2018-10-16 19:20:44', 0, 0, NULL, 23, NULL, NULL, NULL);

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
(1, 1, '201', 20, 'EJEMPLO DE DESCRIPCIÓN DE AULA', 'PLANTA BAJA', 23, NULL, NULL, NULL),
(3, 1, '110', 30, '', '', 23, NULL, '2018-10-17 21:34:24', '2018-10-17 21:34:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `inscCalificacionParcial1` smallint(6) DEFAULT NULL,
  `inscFaltasParcial1` smallint(6) DEFAULT NULL,
  `inscCalificacionParcial2` smallint(6) DEFAULT NULL,
  `inscFaltasParcial2` smallint(6) DEFAULT NULL,
  `inscCalificacionParcial3` smallint(6) DEFAULT NULL,
  `inscFaltasParcial3` smallint(6) DEFAULT NULL,
  `inscPromedioParciales` smallint(6) DEFAULT NULL,
  `inscCalificacionOrdinario` smallint(6) DEFAULT NULL,
  `incsCalificacionFinal` smallint(6) DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED ZEROFILL NOT NULL,
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

--
-- Volcado de datos para la tabla `cgt`
--

INSERT INTO `cgt` (`id`, `plan_id`, `periodo_id`, `cgtGradoSemestre`, `cgtGrupo`, `cgtTurno`, `cgtCupo`, `empleado_id`, `cgtEstado`, `cgtDescripcion`, `cgtTotalRegistrados`, `cgtInscritos`, `cgtPreinscritos`, `cgtBaja`, `cgtOtros`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 2, 1, 1, 'A', 'M', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, NULL, '2018-10-17 20:09:08', NULL),
(5, 2, 6, 1, 'A', 'M', 10, 1, NULL, '', NULL, NULL, NULL, NULL, NULL, 20, NULL, NULL, NULL),
(6, 2, 1, 1, 'B', 'M', 10, 1, NULL, '', NULL, NULL, NULL, NULL, NULL, 20, NULL, NULL, NULL),
(7, 2, 6, 1, 'B', 'M', 10, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL);

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
(1, 0114);

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

--
-- Volcado de datos para la tabla `cuotas`
--

INSERT INTO `cuotas` (`id`, `cuoTipo`, `dep_esc_prog_id`, `cuoAnio`, `cuoImportePadresFamilia`, `cuoImporteOrdinarioUady`, `cuoImporteMensualidad10`, `cuoImporteMensualidad11`, `cuoImporteMensualidad12`, `cuoImporteInscripcion1`, `cuoFechaLimiteInscripcion1`, `cuoImporteInscripcion2`, `cuoFechaLimiteInscripcion2`, `cuoImporteInscripcion3`, `cuoFechaLimiteInscripcion3`, `cuoImporteVencimiento`, `cuoImporteProntoPago`, `cuoDiasProntoPago`, `cuoNumeroCuenta`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'D', 2, 2018, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6400.00', '2018-05-05', '7400.00', '2018-07-10', NULL, NULL, NULL, '0679569', 23, NULL, NULL, NULL);

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
(4, 2, 4, '', NULL, '', NULL, NULL, 'A', 'RE', NULL, NULL, NULL, NULL, NULL, '', 'N', NULL, 23, NULL, '2018-10-17 20:09:08', NULL),
(5, 2, 5, '', NULL, '', NULL, NULL, 'A', 'PI', NULL, NULL, NULL, NULL, NULL, '', 'N', NULL, 23, NULL, '2018-10-17 20:58:07', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `ubicacion_id` bigint(255) UNSIGNED NOT NULL,
  `depNivel` tinyint(10) NOT NULL,
  `depClave` char(3) NOT NULL COMMENT 'Clave de tres carácteres del departamento',
  `depNombre` varchar(45) DEFAULT NULL COMMENT 'Nombre completo',
  `depNombreCorto` varchar(15) DEFAULT NULL COMMENT 'Nombre abreviado',
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
(2, 1, 5, 'SUP', 'SUPERIOR', 'SUPERIOR', NULL, NULL, 1, 6, 7, 60, 30, NULL, NULL, NULL, NULL, 23, NULL, NULL, NULL),
(4, 1, 1, 'BAC', 'BACHILLERATO', 'BACHILLERATO', 'BAC', 'BACHILLERATO', 1, 6, 7, 7, 10, 'MAESTRO', 'ISMAEL PAREDES', 'DIRECTOR', 'UADY', 23, '2018-10-23 18:24:41', '2018-10-23 18:24:41', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` bigint(255) UNSIGNED NOT NULL COMMENT 'Identificador del empleado',
  `persona_id` bigint(255) UNSIGNED NOT NULL,
  `escuela_id` bigint(255) UNSIGNED NOT NULL COMMENT 'Departamento al que pertenece',
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
(1, 1, 2, 0, NULL, '11990032', 0, '', '', 'A', NULL, '', 23, NULL, NULL, NULL),
(3, 2, 2, 0, NULL, '11990034', 3434, '34233434', '', 'A', NULL, '', 23, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escuelas`
--

CREATE TABLE `escuelas` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `departamento_id` bigint(255) UNSIGNED NOT NULL,
  `escClave` char(3) NOT NULL COMMENT 'Clave única de la escuela',
  `escNombre` varchar(45) NOT NULL COMMENT 'Nombre real',
  `escNombreCorto` varchar(15) NOT NULL COMMENT 'Nombre corto',
  `escPorcExaPar` decimal(6,2) NOT NULL DEFAULT '70.00' COMMENT 'Porcentaje de los exámenes parciales para calificación final',
  `escPorcExaOrd` decimal(6,2) NOT NULL DEFAULT '30.00' COMMENT 'Porcentaje del Examen Ordinario para calificación final',
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catálogo de escuelas';

--
-- Volcado de datos para la tabla `escuelas`
--

INSERT INTO `escuelas` (`id`, `departamento_id`, `escClave`, `escNombre`, `escNombreCorto`, `escPorcExaPar`, `escPorcExaOrd`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 2, 'ADI', 'ACADEMIA DE INGLES', 'ACADEMIA DE ING', '70.00', '30.00', 23, NULL, NULL, NULL),
(3, 2, 'ING', 'INGENIERIA', 'INGENIERIA', '40.00', '70.00', 23, '2018-10-23 22:03:20', '2018-10-23 22:03:20', NULL);

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
(1, 1, 'Aguascalientes', 'Ags.', '', 'AGU', 23, NULL, NULL, NULL),
(2, 1, 'Baja California', 'B.C.', '', 'BCN', 23, NULL, NULL, NULL),
(3, 1, 'Baja California Sur', 'B.C.S.', '', 'BCS', 23, NULL, NULL, NULL),
(4, 1, 'Campeche', 'Camp.', '', 'CAM', 23, NULL, NULL, NULL),
(5, 1, 'Chiapas', 'Chis.', '', 'CHP', 23, NULL, NULL, NULL),
(6, 1, 'Chihuahua', 'Chih.', '', 'CHH', 23, NULL, NULL, NULL),
(7, 1, 'Coahuila', 'Coah.', '', 'COA', 23, NULL, NULL, NULL),
(8, 1, 'Colima', 'Col.', '', 'COL', 23, NULL, NULL, NULL),
(9, 1, 'Ciudad de México', 'D.F.', '', 'CMX', 23, NULL, NULL, NULL),
(10, 1, 'Durango', 'Dgo.', '', 'DUR', 23, NULL, NULL, NULL),
(11, 1, 'Guanajuato', 'Gto.', '', 'GUA', 23, NULL, NULL, NULL),
(12, 1, 'Guerrero', 'Gro.', '', 'GRO', 23, NULL, NULL, NULL),
(13, 1, 'Hidalgo', 'Hgo.', '', 'HID', 23, NULL, NULL, NULL),
(14, 1, 'Jalisco', 'Jal.', '', 'JAL', 23, NULL, NULL, NULL),
(15, 1, 'Estado de México', 'Edo. Méx.', '', 'MEX', 23, NULL, NULL, NULL),
(16, 1, 'Michoacán', 'Mich.', '', 'MIC', 23, NULL, NULL, NULL),
(17, 1, 'Morelos', 'Mor.', '', 'MOR', 23, NULL, NULL, NULL),
(18, 1, 'Nayarit', 'Nay.', '', 'NAY', 23, NULL, NULL, NULL),
(19, 1, 'Nuevo León', 'N.L.', '', 'NLE', 23, NULL, NULL, NULL),
(20, 1, 'Oaxaca', 'Oax.', '', 'OAX', 23, NULL, NULL, NULL),
(21, 1, 'Puebla', 'Pue.', '', 'PUE', 23, NULL, NULL, NULL),
(22, 1, 'Querétaro', 'Qro.', '', 'QUE', 23, NULL, NULL, NULL),
(23, 1, 'Quintana Roo', 'Q. Roo.', '', 'ROO', 23, NULL, NULL, NULL),
(24, 1, 'San Luis Potosí', 'S.L.P.', '', 'SLP', 23, NULL, NULL, NULL),
(25, 1, 'Sinaloa', 'Sin.', '', 'SIN', 23, NULL, NULL, NULL),
(26, 1, 'Sonora', 'Son.', '', 'SON', 23, NULL, NULL, NULL),
(27, 1, 'Tabasco', 'Tab.', '', 'TAB', 23, NULL, NULL, NULL),
(28, 1, 'Tamaulipas', 'Tamps.', '', 'TAM', 23, NULL, NULL, NULL),
(29, 1, 'Tlaxcala', 'Tlax.', '', 'TLA', 23, NULL, NULL, NULL),
(30, 1, 'Veracruz', 'Ver.', '', 'VER', 23, NULL, NULL, NULL),
(31, 1, 'Yucatán', 'Yuc.', '', 'YUC', 23, NULL, NULL, NULL),
(32, 1, 'Zacatecas', 'Zac.', '', 'ZAC', 23, NULL, NULL, NULL),
(33, 1, 'California', 'CA', '', 'CA', 23, NULL, NULL, NULL),
(34, 1, 'Pernambuco', 'PE', '', 'PE', 23, NULL, NULL, NULL),
(35, 1, 'Distrito de Belice', 'DB', '', 'DB', 23, NULL, NULL, NULL);

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
  `gpoNumeroOptativa` char(2) DEFAULT NULL,
  `usuario_at` bigint(255) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `cgt_id`, `materia_id`, `empleado_id`, `empleado_sinodal_id`, `gpoMatClaveComplementaria`, `gpoFechaExamenOrdinario`, `gpoHoraExamenOrdinario`, `gpoCupo`, `gpoNumeroFolio`, `gpoNumeroActa`, `gpoNumeroLibro`, `grupo_equivalente_id`, `gpoNumeroOptativa`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 4, 4, 1, 1, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 23, NULL, '2018-10-17 20:09:07', NULL),
(11, 5, 4, 1, 1, '', NULL, NULL, NULL, '', '', '', NULL, '', 23, NULL, NULL, NULL),
(12, 6, 4, 3, 3, '', NULL, NULL, 20, '', '', '', NULL, '', 23, NULL, '2018-10-17 20:19:21', NULL),
(13, 7, 5, 3, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 23, NULL, NULL, NULL);

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

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id`, `grupo_id`, `aula_id`, `ghDia`, `ghInicio`, `ghFinal`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 8, 1, 1, 9, 12, 23, '2018-09-24 23:29:02', '2018-10-17 20:09:07', NULL),
(6, 12, 3, 1, 8, 12, 23, '2018-09-25 00:29:19', '2018-10-17 21:34:24', '2018-10-17 21:34:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscritos`
--

CREATE TABLE `inscritos` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `curso_id` bigint(255) UNSIGNED NOT NULL,
  `grupo_id` bigint(255) UNSIGNED NOT NULL,
  `calificacion_id` bigint(255) UNSIGNED DEFAULT NULL,
  `historico_id` bigint(255) UNSIGNED DEFAULT NULL,
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `inscritos`
--

INSERT INTO `inscritos` (`id`, `curso_id`, `grupo_id`, `calificacion_id`, `historico_id`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 4, 8, NULL, NULL, 23, '2018-10-02 00:56:21', '2018-10-17 20:09:07', NULL),
(10, 5, 11, NULL, NULL, 23, '2018-10-08 23:47:15', '2018-10-17 20:58:07', NULL),
(11, 5, 13, NULL, NULL, 23, '2018-10-08 23:47:15', '2018-10-17 21:00:17', NULL);

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
  `matClave` varchar(7) NOT NULL COMMENT 'Clave de la materia',
  `matNombre` varchar(60) NOT NULL COMMENT 'Nombre completo',
  `matNombreCorto` varchar(15) DEFAULT NULL COMMENT 'Nombre corto',
  `matSemestre` tinyint(2) DEFAULT NULL COMMENT 'Semestre o período al que pertenece la materia',
  `matCreditos` tinyint(3) DEFAULT NULL COMMENT 'Valor en créditos. Para propedéutico es el número de pago del curso.',
  `matClasificacion` enum('B','O','U','X','C') DEFAULT 'B' COMMENT 'Clasificación de la materia',
  `matEspecialidad` char(3) DEFAULT NULL COMMENT 'Vertiente o especialidad al que pertenece',
  `matTipoAcreditacion` enum('N','A','M') DEFAULT 'N' COMMENT 'Tipo de Acreditación: Númerica, alfabética o mixta.',
  `matPorcentajeParcial` decimal(6,2) DEFAULT NULL COMMENT 'Porcentaje de la calificación total que se asigna a exámenes parciales',
  `matPorcentajeOrdinario` decimal(6,2) DEFAULT NULL COMMENT 'Porcentaje de la calificación total que se asigna al examen ordinario',
  `matNombreOficial` varchar(78) DEFAULT NULL COMMENT 'Nombre oficial de la materia',
  `matClaveEquivalente` varchar(12) DEFAULT NULL COMMENT 'Materia equivalente',
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catálogo de materias';

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `plan_id`, `matClave`, `matNombre`, `matNombreCorto`, `matSemestre`, `matCreditos`, `matClasificacion`, `matEspecialidad`, `matTipoAcreditacion`, `matPorcentajeParcial`, `matPorcentajeOrdinario`, `matNombreOficial`, `matClaveEquivalente`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 2, '1111', 'ADMINISTRACION I', 'ADMINISTRACION ', 1, 8, 'B', NULL, 'N', NULL, NULL, NULL, NULL, 23, NULL, NULL, NULL),
(5, 2, '222', 'ADMINISTRACION 2', 'ADMINISTRACION', NULL, NULL, 'B', NULL, 'N', NULL, NULL, NULL, NULL, 23, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_01_26_115212_create_permissions_table', 1),
(4, '2018_08_29_115212_create_modules_table', 1),
(5, '2018_08_2_000001_create_permission_module_user_table', 1);

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
(1, 'Usuarios', 'usuario', 'Administración', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(2, 'Alumnos', 'alumno', 'Control-Escolar', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(3, 'Grupos', 'grupo', 'Control-Escolar', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(4, 'Preinscripciones', 'preinscripcion', 'Control-Escolar', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(5, 'Inscripciones', 'inscripcion', 'Control-Escolar', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(6, 'CGT', 'cgt', 'Control-Escolar', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(7, 'Paquetes', 'paquete', 'Control-Escolar', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(8, 'Ubicacion', 'ubicacion', 'Catálogos', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(9, 'Departamento', 'departamento', 'Catálogos', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(10, 'Escuela', 'escuela', 'Catálogos', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(11, 'Programa', 'programa', 'Catálogos', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(12, 'Planes', 'plan', 'Catálogos', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(13, 'Periodo', 'periodo', 'Catálogos', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(14, 'Materia', 'materia', 'Catálogos', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(15, 'Aula', 'aula', 'Catálogos', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(16, 'Empleado', 'empleado', 'Control-Escolar', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(17, 'Curso', 'curso', 'Control-Escolar', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(18, 'Inscrito', 'inscrito', 'Control-Escolar', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(19, 'Pago', 'pago', 'Control-Escolar', '2018-09-01 00:29:46', '2018-09-01 00:29:46');

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
(7, 31, 'Mérida', 23, NULL, NULL, NULL);

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
(1, 'México', 'MEX', 23, NULL, NULL, NULL),
(2, 'Estados Unidos de América', 'EEUU', 23, NULL, NULL, NULL),
(3, 'Brasil', 'BRA', 23, NULL, NULL, NULL),
(4, 'Belice', 'BEL', 23, NULL, NULL, NULL);

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
(3, 6, 2, 1, 1, 23, '2018-09-26 21:42:33', '2018-10-17 20:33:00', '2018-10-17 20:33:00'),
(4, 6, 2, 1, 2, 23, '2018-09-28 20:52:44', '2018-09-28 20:52:44', NULL);

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
(1, 3, 8, 23, '2018-09-26 21:42:33', '2018-10-17 20:09:07', NULL),
(2, 3, 13, 23, '2018-09-26 21:42:33', '2018-10-17 20:33:00', NULL),
(3, 4, 8, 23, '2018-09-28 20:52:44', '2018-10-17 20:09:07', NULL),
(4, 4, 13, 23, '2018-09-28 20:52:44', '2018-09-28 20:52:44', NULL);

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
(1, 2, 1, 2018, '2018-01-01', '2018-07-31', 'A', 23, NULL, NULL, NULL),
(6, 2, 3, 2018, '2018-08-01', '2018-12-31', 'A', 23, NULL, NULL, NULL),
(7, 2, 2, 2019, '2019-01-01', '2019-07-31', 'A', 23, NULL, NULL, NULL);

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
(1, 'A', 'super', 'Administrador del sistema', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(2, 'B', 'master', 'Administrador del datos', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(3, 'C', 'admin', 'Coordinadores y Directores', '2018-09-01 00:29:46', '2018-09-01 00:29:46'),
(4, 'D', 'user', 'Consultas', '2018-09-01 00:29:46', '2018-09-01 00:29:46');

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
(22, 1, 1, 23, '2018-09-10 18:55:49', '2018-09-10 18:55:49'),
(23, 1, 2, 23, '2018-09-10 18:55:49', '2018-09-10 18:55:49'),
(24, 1, 3, 23, '2018-09-10 18:55:49', '2018-09-10 18:55:49'),
(25, 1, 4, 23, '2018-09-10 18:55:49', '2018-09-10 18:55:49'),
(26, 1, 5, 23, '2018-09-10 18:55:49', '2018-09-10 18:55:49'),
(27, 1, 6, 23, '2018-09-10 18:55:49', '2018-09-10 18:55:49'),
(28, 1, 7, 23, '2018-09-10 18:55:49', '2018-09-10 18:55:49'),
(86, 1, 8, 23, NULL, NULL),
(87, 1, 9, 23, NULL, NULL),
(88, 1, 10, 23, NULL, NULL),
(89, 1, 11, 23, NULL, NULL),
(90, 1, 12, 23, NULL, NULL),
(91, 1, 13, 23, NULL, NULL),
(92, 1, 14, 23, NULL, NULL),
(93, 1, 15, 23, NULL, NULL),
(94, 1, 16, 23, NULL, NULL),
(95, 1, 17, 23, NULL, NULL),
(96, 1, 18, 23, NULL, NULL);

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
(1, 'DFDGDFDF', 'paredes', 'moreno', 'ismael', '0000-00-00', 50, 'M', NULL, NULL, NULL, 97000, '', '', '', '', 23, NULL, NULL, NULL),
(2, '', 'lara', 'poot', 'luis', '0000-00-00', 0, 'F', NULL, NULL, NULL, 0, '', '', '', '', 23, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes`
--

CREATE TABLE `planes` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `programa_id` bigint(255) UNSIGNED NOT NULL,
  `planClave` varchar(4) NOT NULL,
  `planPeriodos` tinyint(2) DEFAULT NULL COMMENT 'Cantidad de períodos',
  `usuario_at` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catálogo de planes escolares';

--
-- Volcado de datos para la tabla `planes`
--

INSERT INTO `planes` (`id`, `programa_id`, `planClave`, `planPeriodos`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 2, '2017', 8, 23, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prerequisitos`
--

CREATE TABLE `prerequisitos` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `materia_id` bigint(255) UNSIGNED NOT NULL,
  `materia_prerequisito_id` bigint(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE `programas` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `escuela_id` bigint(255) UNSIGNED NOT NULL,
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

INSERT INTO `programas` (`id`, `escuela_id`, `progClave`, `progNombre`, `progNombreCorto`, `progClaveSegey`, `progClaveEgre`, `progTituloOficial`, `usuario_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 2, 'ADE', 'ADMINISTRACION Y DESARROLLO EMPRESARIAL', 'ADMINISTRACION ', NULL, NULL, NULL, 23, NULL, NULL, NULL);

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
(1, 'CME', 'MERIDA CHOLUL', NULL, NULL, 7, 23, NULL, NULL, NULL),
(2, 'CVA', 'VALLADOLID', NULL, NULL, 7, 23, NULL, NULL, NULL),
(3, 'CCH', 'CHETUMAL', NULL, NULL, 7, 23, NULL, NULL, NULL),
(5, 'CMO', 'MERIDA PASEO MONTEJO', NULL, NULL, 7, 23, NULL, NULL, NULL);

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
(23, 1, 'ismael', '$2y$10$gbtZqFVbUVtd9tCjvKxldOBmbmaBhe7uWQOZ3X2iKvrGrsPxIUscm', 'M16jXWFek7tvh6u6pHrlxb7fG7ESgxxbcWMZUW4Xc52g0Q16COdupdTxE6QI', 'ZElz0Dhm6fmVqJVPkxwuZuTAZ1t9vMwAb06djzueyIQWcdjNrntbANKzLfl54kDl', '2018-09-10 18:55:49', '2018-09-10 22:17:35', NULL);

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
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `aluClave_UNIQUE` (`aluClave`),
  ADD UNIQUE KEY `persona_id_UNIQUE` (`persona_id`);

--
-- Indices de la tabla `aulas`
--
ALTER TABLE `aulas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_aula_unica` (`ubicacion_id`,`aulaClave`);

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cgt`
--
ALTER TABLE `cgt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_cgt_unico` (`plan_id`,`periodo_id`,`cgtGradoSemestre`,`cgtGrupo`,`cgtTurno`),
  ADD KEY `fk_cgt_plan_idx` (`plan_id`),
  ADD KEY `fk_cgt_periodo_idx` (`periodo_id`),
  ADD KEY `fk_cgt_usuario_at_idx` (`usuario_at`);

--
-- Indices de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_cuota_unica` (`cuoTipo`,`dep_esc_prog_id`,`cuoAnio`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_curso_unico` (`alumno_id`,`cgt_id`),
  ADD KEY `fk_curso_cgt_idx` (`cgt_id`),
  ADD KEY `fk_curso_alumno_idx` (`alumno_id`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `depClave_UNIQUE` (`depClave`),
  ADD KEY `fk_departamento_ubicacion_idx` (`ubicacion_id`),
  ADD KEY `fk_departamento_actual_idx` (`perActual`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `empRfc_UNIQUE` (`empRfc`),
  ADD UNIQUE KEY `empCredencial_UNIQUE` (`empCredencial`),
  ADD UNIQUE KEY `empNomina_UNIQUE` (`empNomina`),
  ADD KEY `fk_empleado_escuela_idx` (`escuela_id`),
  ADD KEY `fk_empleado_persona_idx` (`persona_id`);

--
-- Indices de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `escClave_UNIQUE` (`escClave`),
  ADD KEY `fk_escuela_departamento_idx` (`departamento_id`);

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
  ADD UNIQUE KEY `uk_grupo_unico` (`cgt_id`,`materia_id`),
  ADD KEY `fk_grupo_cgt_idx` (`cgt_id`),
  ADD KEY `fk_grupo_materia_idx` (`materia_id`),
  ADD KEY `fk_grupo_empleado_idx` (`empleado_id`),
  ADD KEY `fk_grupo_sinodal_idx` (`empleado_sinodal_id`);

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
  ADD UNIQUE KEY `uk_horarios_unico` (`grupo_id`,`ghDia`,`ghInicio`),
  ADD UNIQUE KEY `uk_aula_unico` (`aula_id`,`ghDia`,`ghInicio`),
  ADD KEY `fk_horario_aula_idx` (`aula_id`);

--
-- Indices de la tabla `inscritos`
--
ALTER TABLE `inscritos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_inscrito_unico` (`curso_id`,`grupo_id`),
  ADD KEY `fk_inscrito_curso_idx` (`curso_id`),
  ADD KEY `fk_inscrito_grupo_idx` (`grupo_id`),
  ADD KEY `fk_inscrito_historico_idx` (`historico_id`),
  ADD KEY `fk_inscrito_calificacion_idx` (`calificacion_id`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matClave_UNIQUE` (`matClave`),
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
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_paquete_unico` (`periodo_id`,`plan_id`,`semestre`,`consecutivo`),
  ADD KEY `fk_paquete_plan_idx` (`plan_id`);

--
-- Indices de la tabla `paquete_detalle`
--
ALTER TABLE `paquete_detalle`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_paquete_detalle_unico` (`paquete_id`,`grupo_id`),
  ADD KEY `fk_paquete_grupo_idx` (`grupo_id`);

--
-- Indices de la tabla `periodos`
--
ALTER TABLE `periodos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_periodo_departamento_idx` (`departamento_id`);

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
  ADD KEY `fk_planes_programa_idx` (`programa_id`);

--
-- Indices de la tabla `prerequisitos`
--
ALTER TABLE `prerequisitos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_prerequisito_unico` (`materia_id`,`materia_prerequisito_id`),
  ADD KEY `fk_prerequisito_materia_idx` (`materia_id`),
  ADD KEY `fk_prerequisito_materia2_idx` (`materia_prerequisito_id`);

--
-- Indices de la tabla `programas`
--
ALTER TABLE `programas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `progClave_UNIQUE` (`progClave`),
  ADD KEY `fk_programa_escuela_idx` (`escuela_id`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ubiClave_UNIQUE` (`ubiClave`),
  ADD KEY `fk_ubicacion_municipios_idx` (`municipio_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `fk_user_empleado_idx` (`empleado_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `aulas`
--
ALTER TABLE `aulas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cgt`
--
ALTER TABLE `cgt`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identificador del empleado', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `historico`
--
ALTER TABLE `historico`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `inscritos`
--
ALTER TABLE `inscritos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identificador de Municipio', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `paquete_detalle`
--
ALTER TABLE `paquete_detalle`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `periodos`
--
ALTER TABLE `periodos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `permission_module_user`
--
ALTER TABLE `permission_module_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `planes`
--
ALTER TABLE `planes`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `prerequisitos`
--
ALTER TABLE `prerequisitos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programas`
--
ALTER TABLE `programas`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'identificador Numérico', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

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
  ADD CONSTRAINT `fk_empleado_escuela` FOREIGN KEY (`escuela_id`) REFERENCES `escuelas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_empleado_persona` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `escuelas`
--
ALTER TABLE `escuelas`
  ADD CONSTRAINT `fk_escuela_departamento` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `estados`
--
ALTER TABLE `estados`
  ADD CONSTRAINT `fk_estado_pais` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `fk_grupo_cgt` FOREIGN KEY (`cgt_id`) REFERENCES `cgt` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_empleado` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grupo_materia` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON UPDATE CASCADE,
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
  ADD CONSTRAINT `fk_horarios_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `inscritos`
--
ALTER TABLE `inscritos`
  ADD CONSTRAINT `fk_inscrito_calificacion` FOREIGN KEY (`calificacion_id`) REFERENCES `calificaciones` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscrito_curso` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscrito_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscrito_historico` FOREIGN KEY (`historico_id`) REFERENCES `historico` (`id`) ON UPDATE CASCADE;

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
-- Filtros para la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD CONSTRAINT `fk_paquete_periodo` FOREIGN KEY (`periodo_id`) REFERENCES `periodos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_paquete_plan` FOREIGN KEY (`plan_id`) REFERENCES `planes` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `paquete_detalle`
--
ALTER TABLE `paquete_detalle`
  ADD CONSTRAINT `fk_paquete_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_paquete_maestro` FOREIGN KEY (`paquete_id`) REFERENCES `paquetes` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `periodos`
--
ALTER TABLE `periodos`
  ADD CONSTRAINT `fk_periodo_departamento` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `fk_programa_escuela` FOREIGN KEY (`escuela_id`) REFERENCES `escuelas` (`id`) ON UPDATE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
