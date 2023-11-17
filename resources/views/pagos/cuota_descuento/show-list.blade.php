@extends('layouts.dashboard')

@section('template_title')
    Cuota Descuento
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('/pagos/registro_cuotas')}}" class="breadcrumb">Registro de cuotas</a>
    <label class="breadcrumb">Cuotas Descuento</label>
@endsection

@section('content')
@php
    use App\Http\Helpers\Utils;
    $cuota_id = isset($cuota) ? $cuota->id : null;
    $ruta = $cuota_id ? "/pagos/cuota_descuento/{$cuota_id}/agregar_descuento" : '/pagos/cuota_descuento/create';
@endphp

<div id="table-datatables">
    <h4 class="header">Cuotas Descuento</h4>

    @if(isset($cuota))
      @php
        $clave_relacion = null;
        $nombre_relacion = null;

        switch ($cuota->cuoTipo) {
          case 'D':
            $clave_relacion = $departamento ? $departamento->depClave : null;
            $nombre_relacion = $departamento ? $departamento->depNombre : null;
            break;
          case 'E':
            $clave_relacion = $escuela ? $escuela->escClave : null;
            $nombre_relacion = $escuela ? $escuela->escNombre : null;
            break;
          case 'P':
            $clave_relacion = $programa ? $programa->progClave : null;
            $nombre_relacion = $programa ? $programa->progNombre : null;
            break;
        }
      @endphp
      <div class="row">
          <div class="col s12 m6 l4">
            <p><b>Ubicacion: </b> {{$ubicacion->ubiClave}} {{$ubicacion->ubiNombre}}</p>
            <p><b>Cuota Año: </b> {{$cuota->cuoAnio}}</p>
            <p><b>Tipo: </b> {{$cuota->cuoTipo}}</p>
            <p><b>Pertenece a: </b> {{$clave_relacion}} - {{$nombre_relacion}}</p>
          </div>
          <div class="col s12 m6 l4">
            <p><b>Importe Inscripción 1: </b> {{ $cuota->cuoImporteInscripcion1 }}</p>
            <p><b>Fecha límite inscripción 1: </b> {{ Utils::fecha_string($cuota->cuoFechaLimiteInscripcion1, 'mesCorto') }}</p>
            <hr>
            <p><b>Importe Inscripción 2: </b> {{ $cuota->cuoImporteInscripcion2 }}</p>
            <p><b>Fecha límite inscripción 2: </b> {{ Utils::fecha_string($cuota->cuoFechaLimiteInscripcion2, 'mesCorto') }}</p>
            <hr>
            <p><b>Importe Inscripción 3: </b> {{ $cuota->cuoImporteInscripcion3 }}</p>
            <p><b>Fecha límite inscripción 3: </b> {{ Utils::fecha_string($cuota->cuoFechaLimiteInscripcion3, 'mesCorto') }}</p>
            <hr>
          </div>
          <div class="col s12 m6 l4">
            <p><b>Importe Padres de familia: </b> {{ $cuota->cuoImportePadresFamilia }}</p>
            <p><b>Importe Ordinario UADY: </b> {{ $cuota->cuoImporteOrdinarioUady }}</p>
            <p><b>Importe Mensualidad 10: </b> {{ $cuota->cuoImporteMensualidad10 }}</p>
            <p><b>Importe Mensualidad 11: </b> {{ $cuota->cuoImporteMensualidad11 }}</p>
            <p><b>Importe Mensualidad 12: </b> {{ $cuota->cuoImporteMensualidad12 }}</p>
            <p><b>Importe Vencimiento: </b> {{ $cuota->cuoImporteVencimiento }}</p>
            <p><b>Importe Pronto Pago: </b> {{ $cuota->cuoImporteProntoPago }}</p>
            <p><b>Días Pronto Pago: </b> {{ $cuota->cuoDiasProntoPago }}</p>
            <p><b>Número de cuenta: </b> {{ $cuota->cuoNumeroCuenta }}</p>
          </div>
      </div>
    @endif

    {{-- @php use App\Models\User; @endphp --}}
    {{-- @if (User::permiso("ubicacion") != "D" && User::permiso("ubicacion") != "P") --}}
    <a href="{{ url($ruta) }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a>
    <br>
    <br>
    {{-- @endif --}}

    <div class="row">
        <div class="col s12">
            <table id="tbl-cuotas-descuento" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    {{-- <th>Ubicacion</th> --}}
                    {{-- <th>Pertenece_a</th> --}}
                    <th>Fecha inicio</th>
                    <th>Fecha final</th>
                    <th>Grado inicial</th>
                    <th>Grado final</th>
                    <th>Tipo <br>Ingreso</th>
                    <th>Importe insc. 1</th>
                    <th>Fecha límite 1</th>
                    <th>Importe insc. 2</th>
                    <th>Fecha límite 2</th>
                    <th>Importe insc. 3</th>
                    <th>Fecha límite 3</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    {{-- <th></th> --}}
                    {{-- <th></th> --}}
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class="non_searchable"></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="preloader">
    <div id="preloader"></div>
</div>

@endsection

@section('footer_scripts')

{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}
<script type="text/javascript">
    $(document).ready(function() {

        const cuota = {!! isset($cuota) ? json_encode($cuota) : null !!};

        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-cuotas-descuento').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "ajax": {
              "type" : "GET",
              'url': base_url+"/api/pagos/cuota_descuento",
              data: { 
                cuota_id: (cuota ? cuota.id : null) 
              },
              beforeSend: function () {
                $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
              },
              complete: function () {
                $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
              }, error: function(XMLHttpRequest, textStatus, errorThrown) {
                    if (errorThrown === "Unauthorized") {
                        swal({
                            title: "Ups...",
                            text: "La sesion ha expirado",
                            type: "warning",
                            confirmButtonText: "Ok",
                            confirmButtonColor: '#3085d6',
                            showCancelButton: false
                            }, function(isConfirm) {
                            if (isConfirm) {
                                window.location.href = 'login';
                            } else {
                                window.location.href = 'login';
                            }
                        });
                    }
                }
            },
            "columns":[
                // {data: "ubicacion", name: 'ubicacion'},
                // {data: "pertenece_a", name: 'pertenece_a'},
                {data: "cudFechaInicio", name: 'cudFechaInicio'},
                {data: "cudFechaFinal", name: 'cudFechaFinal'},
                {data: "cudGradoInicial", name: 'cudGradoInicial'},
                {data: "cudGradoFinal", name: 'cudGradoFinal'},
                {data: "cudTipoIngreso", name: 'cudTipoIngreso'},
                {data: "cuoImporteInscripcion1", name: 'cuoImporteInscripcion1'},
                {data: "cuoFechaLimiteInscripcion1", name: 'cuoFechaLimiteInscripcion1'},
                {data: "cuoImporteInscripcion2", name: 'cuoImporteInscripcion2'},
                {data: "cuoFechaLimiteInscripcion2", name: 'cuoFechaLimiteInscripcion2'},
                {data: "cuoImporteInscripcion3", name: 'cuoImporteInscripcion3'},
                {data: "cuoFechaLimiteInscripcion3", name: 'cuoFechaLimiteInscripcion3'},
                {data: "action"}
            ],
            //Apply the search
            initComplete: function () {
                var searchFill = JSON.parse(localStorage.getItem( 'DataTables_' + this.api().context[0].sInstance ))

                var index = 0
                this.api().columns().every(function () {
                    var column = this;
                    var columnClass = column.footer().className;
                    if(columnClass != 'non_searchable'){
                        var input = document.createElement("input");

                        var columnDataOld = searchFill.columns[index].search.search
                                $(input).attr("placeholder", "Buscar").addClass("busquedas").val(columnDataOld);

                        $(input).attr("placeholder", "Buscar");
                        $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    }

                    index ++
                });
            },
            stateSaveCallback: function(settings,data) {
                localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
            },
            stateLoadCallback: function(settings) {
                return JSON.parse(localStorage.getItem( 'DataTables_' + settings.sInstance ) )
            }
        });
    });
</script>


@endsection