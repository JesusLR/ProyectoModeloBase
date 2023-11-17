@extends('layouts.dashboard')

@section('template_title')
    Referencia
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}      
@endsection

@section('breadcrumbs')
    <!-- <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('curso')}}" class="breadcrumb">Lista de preinscritos</a> -->
@endsection

@section('content')

<div>
    <table>
        <thead>
        </thead>
        <tbody>
            <tr>
                <th width="10%">Nombre</th>
                <td><?=$nombreCompleto?></td>
            </tr>
            <tr>
                <th width="10%">Tipo de mensualidad</th>
                <td><?=$curPlanPago?></td>
            </tr>
            <tr>
                <th>Año cuota</th>
                <td><?=$cuoAnio?></td>
            </tr>
            <tr>
                <th>Cuota generacional</th>
                <td><?=$cuoAnioGeneracion?></td>
            </tr>
            <tr>
                <th>Id de departamento</th>
                <td><?=$dep_id?></td>
            </tr>
            <tr>
                <th>Id de escuela</th>
                <td><?=$esc_id?></td>
            </tr>
            <tr>
                <th>Id de programa</th>
                <td><?=$prog_id?></td>
            </tr>
            <tr>
                <th>Concepto</th>
                <td><?=$concepto?></td>
            </tr>
            <tr>
                <th>Mensualidad</th>
                <td><?=$mensualidad?></td>
            </tr>
            <tr>
                <th>Inscripcion</th>
                <td><?=$inscripcionProrrateada?></td>
            </tr>
            <tr>
                <th>Pronto pago</th>
                <td><?=$prontoPago?></td>
            </tr>
            <tr>
                <th>Beca</th>
                <td><?=$curPorcentajeBeca?></td>
            </tr>
            <tr>
                <th>Descuento Beca</th>
                <td><?=$descuentoImporte?></td>
            </tr>
            <tr>
                <th>Recargos</th>
                <td><?=$recargo?></td>
            </tr>
            <tr>
                <th>Fecha de vencimiento</th>
                <td><?=$fechaVencimiento?></td>
            </tr>
            <tr>
                <th>Meses adeudo</th>
                <td><?=$diferenciaMeses?></td>
            </tr>
            <tr>
                <th>Importe total</th>
                <td><?=$importeTotalDecimal?></td>
            </tr>
            <tr>
                <th>Referencia</th>
                <td><?=$referenciaPago?></td>
            </tr>
        </tbody>
    </table>
</div>

@endsection

@section('footer_scripts')

{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}



@endsection