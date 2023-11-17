@extends('layouts.dashboard')

@section('template_title')
Calendario
@endsection

@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="{{ url('calendario') }}" class="breadcrumb">Calendario</a>
@endsection

@section('content')

<link href="fullcalendar/lib2/main.css" rel="stylesheet" />
<script src="fullcalendar/lib2/main.js"></script>


<script>
 document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar-preescolar');

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
            $("#creador").html('Creado por: ' + info.event.extendedProps.perNombre + ' ' + info.event.extendedProps.perApellido1 + ' ' + info.event.extendedProps.perApellido2);


            // recupera fecha inicial 
            let fechaI = moment(info.event.start).format('YYYY-MM-DD');
            let horaI = moment(info.event.start).format('H:mm');

            /* -------------------------- recupera fecha final -------------------------- */
            let fechaF = moment(info.event.end).format('YYYY-MM-DD');
            let horaF = moment(info.event.end).format('H:mm');

            $("#id_evento").val(info.event.id);
            $("#title").val(info.event.title);
            $("#start").val(fechaI);
            $("#hora-inicio").val(horaI)
            $("#end").val(fechaF);
            $("#hora-fin").val(horaF);
            $("#description").val(info.event.extendedProps.description);
            $("#color").val(info.event.backgroundColor);
            $("#user_id").val(info.event.extendedProps.user_id);

            $("#classTitle").removeClass("input-field");
            $("#classDescription").removeClass("input-field");
            $('#btnAgregar').hide();

            /* ----------------- obtener los valores de id para comparar ---------------- */
            let user = info.event.extendedProps.user_id;
            if ('{{ Auth::user()->id }}' == user) {
                $('#btnEditar').show();
                $('#btnDelete').show();
                $("#titulo").html('Editar evento');
            } else {
                $('#btnEditar').hide();
                $('#btnDelete').hide();
                $("#titulo").html('Detalle de evento');
            }


            $('#addEvento').modal('open');

        },

        /* ---------------- eventos que se muestran en el calendario ---------------- */
        events: "{{ url('/calendario/show') }}",


        /* --- al dar click en una fecha se muestra modal para agregar un eventos --- */
        dateClick: function(info, selectionInfo) {

            limpiar();

            let fecha = moment(info.dateStr).format('YYYY-MM-DD');
            $("#start").val(fecha);
            let hora = new Date();
            let horaNueva = moment(info.dateStr).format('H:mm');
            $("#hora-inicio").val(horaNueva);
            $("#titulo").html('Agregar evento');
            $("#classTitle").addClass("input-field");
            $("#classDescription").addClass("input-field");
            $('#btnAgregar').show();
            $('#btnEditar').hide();
            $("#btnDelete").hide();


            $('#addEvento').modal('open');

        },

    });
    calendar.setOption('locale', 'Es');
    calendar.render();

    /* ---------------------- accion para agregar un evento --------------------- */
    let validator;

    $('#btnAgregar').click(function() {
        objEvento = recolectarDatosGUI("POST");
        enviarInformacion('', objEvento);

        validator = "agregar";
    });

    /* --------------------- accion para modificar un evento -------------------- */
    $('#btnEditar').click(function() {
        objEvento = recolectarDatosGUIUpdate("PATCH");
        enviarInformacion('/' + $("#id_evento").val(), objEvento);

        validator = "editar";
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
            color: '{{$preescolar_agenda_colores->preesColor}}',
            textColor: '#fff',
            start: $("#start").val() + ' ' + $("#hora-inicio").val(),
            end: $("#end").val() + ' ' + $("#hora-fin").val(),
            user_id: '{{ Auth::user()->id }}',
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
            color: '{{$preescolar_agenda_colores->preesColor}}',
            textColor: '#fff',
            start: $("#start").val() + ' ' + $("#hora-inicio").val(),
            end: $("#end").val() + ' ' + $("#hora-fin").val(),
            user_id: '{{ Auth::user()->id }}',
            '_token': $("meta[name='csrf-token']").attr("content"),
            '_method': method
        }
        return (upEvento);

    }

    function enviarInformacion(accion, objEvento) {
        $.ajax({
            type: "POST",
            url: "{{url('/calendario')}}" + accion,
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
                if ($("#title").val() == "" || $("#description").val() == "" || $("#start").val() == "" || $("#hora-inicio").val() == "" || $("#end").val() == "" || $("#hora-fin").val() == "") {
                    Swal.fire(
                        'Oops...!',
                        'No deje campos vacíos',
                        'error'
                    );
                } else {
                    Swal.fire(
                        'Oops...!',
                        'Error en el servidor, intente de nuevo',
                        'error'
                    );
                }

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
        <div id='calendar-preescolar'></div>
    </div>
    <div class="col s1"></div>
</div>

{{-- se incluye la vista del modal  --}}
@include('preescolar.calendario.modal-event')

<style>
    #calendar {
        max-width: 1100px;
        margin: 0 auto;
    }
</style>

<script src="js/moment.min.js"></script>
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
@endsection