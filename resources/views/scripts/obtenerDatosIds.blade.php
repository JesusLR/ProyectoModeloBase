<script>
  $(document).ready(function(){
  function obtenerDepartamento(ubicacion_id){
    $.get(base_url+`/datosId/obtenerDepartamento/${ubicacion_id}`,function(data){
      $('#departamento_id').empty();
      // $('#departamento_id').append('<option value="">Seleccionar departamento</option>');
      $.each(data,function(key,value){
        $('#departamento_id').append('<option value="'+value.id+'">'+value.depClave+' - '+value.depNombre+'</option>');
      });
      obtenerEscuelas($('#departamento_id').val());
      obtenerPeriodos($('#departamento_id').val());
    });
  }

  function obtenerPeriodos(departamento_id){
    $.get(base_url+`/datosId/obtenerPeriodos/${departamento_id}`,function(data){
      $('#periodo_id').empty();
      $.each(data,function(key,value){
        $('#periodo_id').append('<option value="'+value.id+'">'+value.perNumero+'-'+value.perAnio+'</option>');
      });
      obtenerFechas($('#periodo_id').val());
    });
  }
  
  function obtenerFechas(periodo_id){
    $.get(base_url+`/datos/obtenerFechas/${periodo_id}`,function(data){
      $('#fechaInicial').empty();
      $('#fechaFinal').empty();
      $('#fechaInicial').val(data['fechaInicial']);
      $('#fechaFinal').val(data['fechaFinal']);
      Materialize.updateTextFields();
    });
  }

  function obtenerEscuelas(departamento_id){
    $.get(base_url+`/datosId/obtenerEscuelas/${departamento_id}`,function(data){
      $('#escuela_id').empty();
      $('#escuela_id').append('<option value="">Seleccionar escuela</option>');
      $.each(data,function(key,value){
        $('#escuela_id').append('<option value="'+value.id+'">'+value.escClave+' - '+value.escNombre+'</option>');
      // obtenerProgramas($('#escuela_id').val());
      });
    });
  }
  
  function obtenerProgramas(escuela_id){
    $.get(base_url+`/datosId/obtenerProgramas/${escuela_id}`,function(data){
      if(data.length){
      $('#programa_id').empty();
      $('#plan_id').empty(); 
      $('#cgt_id').empty();
      $('#programa_id').append('<option value="null">Seleccionar programa</option>');
      $.each(data,function(key,value){
        $('#programa_id').append('<option value="'+value.id+'">'+value.progClave+' - '+value.progNombre+'</option>');
        // obtenerPlanes($('#programa_id').val());
      });
    }else{
      $('#programa_id').empty();
    }
    });
  }

  function obtenerPlanes(programa_id){
    $.get(base_url+`/datosId/obtenerPlanes/${programa_id}`,function(data){
      if(data.length){
      $('#plan_id').empty(); 
      $('#plan_id').append('<option value="">Seleccionar plan</option>');
      $.each(data,function(key,value){
        $('#plan_id').append('<option value="'+value.id+'">'+value.planClave+'</option>');
        obtenerCgts($('#plan_id').val(),$('#periodo_id').val());
      });
    }else{
      $('#plan_id').empty();
    }
    });
  }

  function obtenerCgts(plan_id,periodo_id){
    $.get(base_url+`/datosId/obtenerCgts/${plan_id}/${periodo_id}`,function(data){
      if(data.length){
      $('#cgt_id').empty();
      $.each(data,function(key,value){
        $('#cgt_id').append('<option value="'+value.id+'">'+value.cgtGradoSemestre+' '+value.cgtGrupo+' '+value.cgtTurno+'</option>');
      });
      
    }else{
      $('#cgt_id').empty();
    }
    });
  }

  function obtenerMaterias(plan_id){
    $.get(base_url+`/datosId/obtenerMaterias/${plan_id}`,function(data){
      $('#mat_id').empty(); 
      $('#mat_id').append('<option value="">Seleccionar materia</option>');
      $.each(data,function(key,value){
        $('#mat_id').append('<option value="'+value.id+'">'+value.matClave+' - '+value.matNombre+'</option>');
      });
    });
  }

  
// Rellenar los datos al entrar a la vista
obtenerDepartamento($('#ubicacion_id').val());

// Rellenar los datos al escoger una opción
$('#ubicacion_id').change(function(){
  var ubicacion_id = $(this).val();
  obtenerDepartamento(ubicacion_id);
});

$('#departamento_id').change(function(){
  var departamento_id = $(this).val();
  obtenerEscuelas(departamento_id);
});

$('#escuela_id').change(function(){
  var escuela_id = $(this).val();
  obtenerProgramas(escuela_id);
});

$('#programa_id').change(function(){
  var programa_id = $(this).val();
  obtenerPlanes(programa_id);
});

$('#plan_id').change(function(){
  var plan_id = $(this).val();
  var periodo_id = $('#periodo_id').val();
  obtenerCgts(plan_id,periodo_id);
});

$('#plan_id').change(function(){
  var plan_id = $(this).val();
  obtenerMaterias(plan_id);
});

$('#departamento_id').change(function(){
  var departamento_id = $(this).val();
  obtenerPeriodos(departamento_id);
});

$('#periodo_id').change(function(){
  var periodo_id = $(this).val();
  var plan_id = $('#plan_id').val();
  obtenerFechas(periodo_id);
  obtenerCgts(plan_id,periodo_id);
});

});
</script>