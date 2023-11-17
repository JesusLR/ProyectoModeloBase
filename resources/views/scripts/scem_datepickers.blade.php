{{-- JQUERY UI --}}
{!! HTML::script(asset('js/jquery-ui.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::style(asset('css/jquery-ui.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}

<script type="text/javascript">
	$(document).ready(function () {
	    var options = {
	    	dateFormat: 'dd/mm/yy',
	        dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
	        dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
	        dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
	        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", 
	        	"Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
	        monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun",
	        	"Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
	        prevText: "Previo",
	        nextText: "Siguiente",
	    };
	    $('.scem_datepicker').datepicker(options);

	});
</script>