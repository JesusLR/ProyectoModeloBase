@extends('layouts.dashboard')

@section('template_title')
Bachiller agenda
@endsection

@section('breadcrumbs')
<a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
<a href="{{ route('bachiller.bachiller_calendario.index') }}" class="breadcrumb">Calendario</a>
@endsection

@section('content')

<link href="fullcalendar/lib2/main.css" rel="stylesheet" />
<script src="fullcalendar/lib2/main.js"></script>


<script>
 document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('bachiller_calendar');

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

            if(info.event.extendedProps.empNombre != null){
                $("#creador").html('Creado por: ' + info.event.extendedProps.empNombre + ' ' + info.event.extendedProps.empApellido1 + ' ' + info.event.extendedProps.empApellido2);

            }else{
                $("#creador").html('Creado por: ' + info.event.extendedProps.perNombre + ' ' + info.event.extendedProps.perApellido1 + ' ' + info.event.extendedProps.perApellido2);
            
            }


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
            $("#color").val(info.event.backgroundColor);
            $("#user_id").val(info.event.extendedProps.usuario_at);

            $("#classTitle").removeClass("input-field");
            $("#classDescription").removeClass("input-field");
            $('#btnAgregar').hide();

            /* ----------------- obtener los valores de id para comparar ---------------- */
            let user = info.event.extendedProps.usuario_at;
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
        events: "{{ url('/bachiller_calendario/show') }}",


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
            color: '{{$bachiller_agenda_colores->preesColor}}',
            textColor: '#fff',
            start: $("#start").val() + ' ' + $("#hora-inicio").val(),
            end: $("#end").val() + ' ' + $("#hora-fin").val(),
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
            color: '{{$bachiller_agenda_colores->preesColor}}',
            textColor: '#fff',
            start: $("#start").val() + ' ' + $("#hora-inicio").val(),
            end: $("#end").val() + ' ' + $("#hora-fin").val(),
            usuario_at: '{{ Auth::user()->id }}',
            '_token': $("meta[name='csrf-token']").attr("content"),
            '_method': method
        }
        return (upEvento);

    }

    function enviarInformacion(accion, objEvento) {
        $.ajax({
            type: "POST",
            url: "{{url('/bachiller_calendario')}}" + accion,
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
            @if ($item->empNombre != "")
            <strong style="color: white">{{ $item->empNombre }} {{ $item->empApellido1 }}
                {{ $item->empApellido2 }}</strong>
            @else
            <strong style="color: white">{{ $item->perNombre }} {{ $item->perApellido1 }}
                {{ $item->perApellido2 }}</strong>
            @endif
            
        </div>

        @endforeach
    </div>
    <div class="col s9">
        <div id='bachiller_calendar'></div>
    </div>
    <div class="col s1"></div>
</div>

{{-- se incluye la vista del modal  --}}
@include('bachiller.calendario.modaEvento')

<style>
    #calendar {
        max-width: 1100px;
        margin: 0 auto;
    }
</style>

<script src="js/moment.min.js"></script>
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
@endsection
