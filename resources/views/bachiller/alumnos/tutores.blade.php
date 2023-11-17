<br>
<div class="row" style="background-color:#ECECEC;">
    <p style="text-align: center;font-size:1.2em;">Datos de los padres</p>
</div>
<div class="row">

	<div class="col s12 m6 l4" style="display: none">
		<div class="input-field">
			{!! Form::text('id', NULL, array('id' => 'id', 'class' => 'validate')) !!}
			<label for="id"><strong style="color: #000; font-size: 17px;">alumno id tutor</strong></label>
		</div>		
	</div>
	<div class="col s12 m6 l4">
		<div class="input-field">
			{!! Form::text('tutNombre', NULL, array('id' => 'tutNombre', 'class' => 'validate')) !!}
			<label for="tutNombre"><strong style="color: #000; font-size: 17px;">Nombre completo *</strong></label>
		</div>
	</div>
	<div class="col s12 m6 l4">
		<div class="input-field">
			{!! Form::number('tutTelefono', NULL, array('id' => 'tutTelefono', 'class' =>
			'validate','min'=>'0','max'=>'9999999999')) !!}
			<label for="tutTelefono"><strong style="color: #000; font-size: 17px;">Teléfono *</strong></label>
		</div>
	</div>
	<div class="col s12 m6 l4">
		<div class="input-field col s6 m6 l3">
			<a name="buscarTutor" id="buscarTutor" class="waves-effect btn-large tooltipped" data-position="right"
				data-tooltip="Buscar tutor por nombre y teléfono">
				<i class=material-icons>search</i>
			</a>
		</div>
		<div class="input-field col s6 m6 l3">
			<a name="vincularTutor" id="vincularTutor" class="waves-effect btn-large tooltipped" data-position="right"
				data-tooltip="Vincular tutor a este alumno" disabled>
				<i class=material-icons>sync</i>
			</a>
		</div>
	</div>
</div>

<br><br>
<p>(Los siguientes datos son opcionales)</p>
<div class="row">
	<div class="col s12 m6 l4">
		<div class="input-field">
			{!! Form::text('tutCalle', NULL, array('id' => 'tutCalle', 'class' => 'validate')) !!}
			<label for="tutCalle"><strong style="color: #000; font-size: 17px;">Calle</strong></label>
		</div>
	</div>
	<div class="col s12 m6 l4">
		<div class="input-field">
			{!! Form::text('tutColonia', NULL, array('id' => 'tutColonia', 'class' => 'validate')) !!}
			<label for="tutColonia"><strong style="color: #000; font-size: 17px;">Colonia</strong></label>
		</div>
	</div>
	<div class="col s12 m6 l4">
		<div class="input-field col s12 m6 l4">
			{!! Form::number('tutCodigoPostal', NULL, array('id' => 'tutCodigoPostal', 'class' =>
			'validate','min'=>'0','max'=>'99999')) !!}
			<label for="tutCodigoPostal"><strong style="color: #000; font-size: 17px;">Código Postal</strong></label>
		</div>
	</div>
</div>

<div class="row">
	<div class="col s12 m6 l4">
		<div class="input-field">
			{!! Form::text('tutPoblacion', NULL, array('id' => 'tutPoblacion', 'class' => 'validate')) !!}
			<label for="tutPoblacion"><strong style="color: #000; font-size: 17px;">Población</strong></label>
		</div>
	</div>
	<div class="col s12 m6 l4">
		<div class="input-field">
			{!! Form::text('tutEstado', NULL, array('id' => 'tutEstado', 'class' => 'validate'))!!}
			<label for="tutEstado"><strong style="color: #000; font-size: 17px;">Estado</strong></label>
		</div>
	</div>
	<div class="col s12 m6 l4">
		<div class="input-field">
			<label for="tutCorreo"><strong style="color: #000; font-size: 17px;">Correo Electrónico</strong></label>
			{!! Form::email('tutCorreo', NULL, array('id' => 'tutCorreo')) !!}
		</div>
	</div>
</div>

<div class="row">
	<div class="col s12 m6 l4">
		<div class="input-field col s6 m6 l3">
			<a name="crearTutor" id="crearTutor" class="waves-effect btn-large tooltipped #2e7d32 green darken-3"
				data-position="right" data-tooltip="Crear nuevo tutor">
				<i class=material-icons>person_add</i>
			</a>
		</div>
	</div>
</div>

<br>
<!-- TABLA DE TUTORES DEL ALUMNO. -->
<div class="row">
	<div class="col s12">
		<table id="tbl-tutores" class="responsive-table display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Nombre(s)</th>
					<th>Teléfono</th>
					<th>Calle</th>
					<th>Colonia</th>
					<th>CP</th>
					<th>Población</th>
					<th>Estado</th>
					{{--  <th>id</th>  --}}
					<th>Correo</th>		
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>