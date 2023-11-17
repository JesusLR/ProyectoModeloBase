@extends('layouts.dashboard')

@section('template_title')
    Tipos Programa Educación Continua
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Tipos programa educación continua</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">TIPOS PROGRAMA EDUCACIÓN CONTINUA</h4>
    @php use App\Models\User; @endphp
    {{-- @if (User::permiso("educontinua") != "D" && User::permiso("educontinua") != "P") --}}
    <a href="{{ url('/tiposProgEduContinua/create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a>
    <br>
    <br>
    {{-- @endif --}}
    <div class="row">
        <div class="col s12">
            <table id="tbl-educontinua" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>Abreviatura</th>
                  <th>Nombre</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
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
        $('#tbl-educontinua').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "ajax": {
              "type" : "GET",
              'url': base_url+"/api/tiposProgEduContinua",
              beforeSend: function () {
                $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
              },
              complete: function () {
                $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
              },
            },
            "columns":[
              {data: "tpAbreviatura", name: 'tiposprograma.tpAbreviatura'},
              {data: "tpNombre", name: 'tiposprograma.tpNombre'},
              {data: "action"}
            ],
            //Apply the search
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var columnClass = column.footer().className;
                    if(columnClass != 'non_searchable'){
                        var input = document.createElement("input");
                        $(input).attr("placeholder", "Buscar");
                        $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    }
                });
            }
        });
    });
</script>


@endsection