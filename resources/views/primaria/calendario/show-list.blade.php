@extends('layouts.dashboard')

@section('template_title')
Primaria agenda
@endsection

@section('breadcrumbs')
<a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
<a href="{{ route('primaria_calendario.index') }}" class="breadcrumb">Calendario</a>
@endsection

@section('content')

<link href="fullcalendar/lib2/main.css" rel="stylesheet" />
<script src="fullcalendar/lib2/main.js"></script>


<script>
 document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('primaria_calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },

        views: {
            dayGridMonth: {
                buttonText: "Mes",
            },
            timeGridWeek: {
                buttonText: "Semana",
            },
            timeGridDay: {
                buttonText: "Día",
            },
            listMonth: {
                buttonText: "Lista",
            },
            timeGrid: {
                dayMaxEventRows: 4 // ajustar a 4 solo para timeGridWeek / timeGridDay
            },
        },
        navLinks: true, // cun clic en los nombres de día / semana para navegar por las vistas
        businessHours: true, // mostrar el horario comercial
        editable: true,
        selectable: true,
        initialView: 'timeGridWeek',


        eventClick: function(info) {
            $("#creador").html('Creado por: ' + info.event.extendedProps.perNombreCreador + ' ' + info.event.extendedProps.perApellido1Creador + ' ' + info.event.extendedProps.perApellido2Creador);


            // recupera fecha inicial
            let fechaI = moment(info.event.start).format('YYYY-MM-DD');
            let horaIHora = moment(info.event.start).format('H');
            let horaIMin = moment(info.event.start).format('mm');
            if(horaIHora < 10){
                horaIHora = '0' + horaIHora;
            }
            let horaI = horaIHora + ':' + horaIMin;

            

            /* -------------------------- recupera fecha final -------------------------- */
            let fechaF = moment(info.event.end).format('YYYY-MM-DD');
            let horaFHora = moment(info.event.end).format('H');
            let horaFMin = moment(info.event.start).format('mm');
            if(horaFHora < 10){
                horaFHora = '0' + horaFHora;
            }
            let horaF = horaFHora + ':' + horaFMin;
            $("#id_evento").val(info.event.id);
            $("#title").val(info.event.title);
            $("#start").val(fechaI);
            $("#hora-inicio").val(horaI)
            $("#end").val(fechaF);
            $("#hora-fin").val(horaF);
            $("#description").val(info.event.extendedProps.description);
            $("#lugarEvento").val(info.event.extendedProps.lugarEvento);
            $("#color").val(info.event.backgroundColor);
            $("#user_id").val(info.event.extendedProps.usuario_at);

            //validamos para llenar el combo 
            if(info.event.extendedProps.empleado_id_dos != null){
                $("#primaria_empleado_id1").append('<option value="'+info.event.extendedProps.empleado_id_uno+'" selected>'+info.event.extendedProps.perApellido1Uno+ " " + info.event.extendedProps.perApellido2Uno + " " + info.event.extendedProps.perNombreUno + '</option>');
            }

            if(info.event.extendedProps.empleado_id_dos != null){
                $("#primaria_empleado_id2").append('<option value="'+info.event.extendedProps.empleado_id_dos+'" selected>'+info.event.extendedProps.perApellido1Dos+ " " + info.event.extendedProps.perApellido2Dos + " " + info.event.extendedProps.perNombreDos + '</option>');
            }

            if(info.event.extendedProps.empleado_id_dos != null){
                $("#primaria_empleado_id3").append('<option value="'+info.event.extendedProps.empleado_id_tres+'" selected>'+info.event.extendedProps.perApellido1Tres+ " " + info.event.extendedProps.perApellido2Tres + " " + info.event.extendedProps.perNombreTres + '</option>');
            }



            $("#classTitle").removeClass("input-field");
            $("#classDescription").removeClass("input-field");
            $('#btnAgregar').hide();

            /* ----------------- obtener los valores de id para comparar ---------------- */
            let empleado_id = info.event.extendedProps.empleado_id_creador;

            if ('{{ Auth::user()->empleado_id }}' == empleado_id) {
                $('#btnEditar').show();
                $('#btnDelete').show();
                $("#titulo").html('Editar evento');
            } else {
                $('#btnEditar').hide();
                $('#btnDelete').hide();
                $("#titulo").html('Detalle de evento');
            }

            //evitar cerrar el modal cuando se hace click fuera del cuadro
            $("#addEvento").modal({
                dismissible: false
            });
            $('#addEvento').modal('open');

        },

        /* ---------------- eventos que se muestran en el calendario ---------------- */
        events: "{{ url('/primaria_calendario/show') }}",


        /* --- al dar click en una fecha se muestra modal para agregar un eventos --- */
        dateClick: function(info, selectionInfo) {

            limpiar();

            let fecha = moment(info.dateStr).format('YYYY-MM-DD');
            $("#start").val(fecha);
            $("#end").val(fecha);

            let hora = new Date();
            let horaNuevaHora = moment(info.dateStr).format('H');
            let horaNuevaMin = moment(info.dateStr).format('mm');
            if(horaNuevaHora < 10){
                horaNuevaHora = '0' + horaNuevaHora;
            }
            let horaNueva = horaNuevaHora + ':' + horaNuevaMin;

            $("#hora-inicio").val(horaNueva);
            $("#titulo").html('Agregar evento');
            $("#classTitle").addClass("input-field");
            $("#classDescription").addClass("input-field");
            $('#btnAgregar').show();
            $('#btnEditar').hide();
            $("#btnDelete").hide();

            //evitar cerrar el modal cuando se hace click fuera del cuadro
            $("#addEvento").modal({
                dismissible: false
            });

            $('#addEvento').modal('open');


        },

    });
    calendar.setOption('locale', 'Es');
    calendar.render();

    /* ---------------------- accion para agregar un evento --------------------- */
    let validator;

    $('#btnAgregar').click(function() {

        if ($("#title").val() == "" || $("#description").val() == "" || 
                $("#start").val() == "" || $("#hora-inicio").val() == "" || 
                $("#end").val() == "" || $("#hora-fin").val() == "" ||  
                $("#lugarEvento").val() == "" || $("#primaria_empleado_id1").val() == "") {
                    Swal.fire(
                        'Oops...!',
                        'No deje campos vacíos',
                        'error'
                    );
        } else {
            objEvento = recolectarDatosGUI("POST");
            enviarInformacion('', objEvento);
            validator = "agregar";
        }       
        

    });

    /* --------------------- accion para modificar un evento -------------------- */
    $('#btnEditar').click(function() {
        if ($("#title").val() == "" || $("#description").val() == "" || 
                $("#start").val() == "" || $("#hora-inicio").val() == "" || 
                $("#end").val() == "" || $("#hora-fin").val() == "" ||  
                $("#lugarEvento").val() == "" || $("#primaria_empleado_id1").val() == "") {
                    Swal.fire(
                        'Oops...!',
                        'No deje campos vacíos',
                        'error'
                    );
        } else {
            objEvento = recolectarDatosGUIUpdate("PATCH");
            enviarInformacion('/' + $("#id_evento").val(), objEvento);
    
            validator = "editar";
        }       
    });

    /* --------------------- accion para eleminar un evento --------------------- */
    $('#btnDelete').click(function() {
        objEvento = recolectarDatosGUI("DELETE");
        enviarInformacion('/' + $("#id_evento").val(), objEvento);

        validator = "eliminar";
    });

    function recolectarDatosGUI(method) {
        let fechaHoy = moment().format('YYYY-MM-DD');
        let horaHoy = moment().format('H:mm');

        nuevoEvento = {
            id: $("#id_evento").val(),
            title: $("#title").val(),
            description: $("#description").val(),
            lugarEvento: $("#lugarEvento").val(),
            color: '{{$primaria_agenda_colores->preesColor}}',
            textColor: '#fff',
            start: $("#start").val() + ' ' + $("#hora-inicio").val(),
            end: $("#end").val() + ' ' + $("#hora-fin").val(),
            primaria_empleado_id1: $("#primaria_empleado_id1").val(),
            primaria_empleado_id2: $("#primaria_empleado_id2").val(),
            primaria_empleado_id3: $("#primaria_empleado_id3").val(),
            primaria_empleado_creador: "{{ Auth::user()->empleado_id }}",
            usuario_at: '{{ Auth::user()->id }}',
            created_at: fechaHoy + ' ' + horaHoy,
            '_token': $("meta[name='csrf-token']").attr("content"),
            '_method': method
        }
        return (nuevoEvento);

    }

    function recolectarDatosGUIUpdate(method) {

        upEvento = {
            id: $("#id_evento").val(),
            title: $("#title").val(),
            description: $("#description").val(),
            lugarEvento: $("#lugarEvento").val(),
            color: '{{$primaria_agenda_colores->preesColor}}',
            textColor: '#fff',
            start: $("#start").val() + ' ' + $("#hora-inicio").val(),
            end: $("#end").val() + ' ' + $("#hora-fin").val(),
            primaria_empleado_id1: $("#primaria_empleado_id1").val(),
            primaria_empleado_id2: $("#primaria_empleado_id2").val(),
            primaria_empleado_id3: $("#primaria_empleado_id3").val(),
            usuario_at: '{{ Auth::user()->id }}',
            '_token': $("meta[name='csrf-token']").attr("content"),
            '_method': method
        }
        return (upEvento);

    }

    function enviarInformacion(accion, objEvento) {
        $.ajax({
            type: "POST",
            url: "{{url('/primaria_calendario')}}" + accion,
            data: objEvento,
            success: function(msg) {

                $('#addEvento').modal('close');

                if (validator == "agregar") {
                    Swal.fire(
                        'Bien!',
                        'Evento agregado con éxito',
                        'success'
                    );
                }
                if (validator == "editar") {
                    Swal.fire(
                        'Bien!',
                        'Evento actualizado con éxito',
                        'success'
                    );
                }
                if (validator == "eliminar") {
                    Swal.fire(
                        'Bien!',
                        'Evento eliminado con éxito',
                        'success'
                    );
                }

                limpiar();
                calendar.refetchEvents();

            },
            error: function() {
                

            }
        });
    }

    /* -------------------------------------------------------------------------- */
    /*                  funcion para limpiar los campos del modal                 */
    /* -------------------------------------------------------------------------- */
    function limpiar() {
        $("#id_evento").val("");
        $("#title").val("");
        $("#description").val("");
        $("#end").val("");
        $("#hora-fin").val("");
        $("#creador").html("");
        $("#primaria_empleado_id1").val("");
        $("#primaria_empleado_id2").val("");
        $("#primaria_empleado_id3").val("");
    }
});


</script>



<div class="row">
    <div class="col s2">
        {{--  //pinta el div de acuerdo al color de cada usuario          --}}
        @foreach ($colores_usuarios as $item)

        <div style="background-color: {{$item->preesColor}}" class="card-panel lighten-2">
            <strong style="color: white">{{ $item->perNombre }} {{ $item->perApellido1 }}
                {{ $item->perApellido2 }}</strong>
        </div>

        @endforeach
    </div>
    <div class="col s9">
        <div id='primaria_calendar'></div>
    </div>
    <div class="col s1"></div>
</div>

{{-- se incluye la vista del modal  --}}
@include('primaria.calendario.modaEvento')

<style>
    #calendar {
        max-width: 1100px;
        margin: 0 auto;
    }
</style>

<script src="js/moment.min.js"></script>
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
@endsection
