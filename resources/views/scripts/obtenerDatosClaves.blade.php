<script>
    $(document).ready(function(){
    function obtenerDepartamento(ubiClave){
      $.get(base_url+`/datos/obtenerDepartamento/${ubiClave}`,function(data){
        $('#depClave').empty().append('<option value="">SELECCIONAR DEPARTAMENTO</option>');
        $.each(data['departamentos'],function(key,value){
          $('#depClave').append('<option value="'+value.depClave+'">'+value.depClave+' - '+value.depNombre+'</option>');
        });
        // obtenerEscuelas($('#depClave').val());
        // obtenerPeriodos($('#depClave').val());
      });
    }

    function obtenerPeriodos(depClave){
      $.get(base_url+`/datos/obtenerPeriodos/${depClave}`,function(data){
        $('#periodo').empty();
        $.each(data,function(key,value){
          $('#periodo').append('<option value="'+value.id+'">'+value.perNumero+'-'+value.perAnio+'</option>');
        });
        obtenerFechas($('#periodo').val())
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

    function obtenerEscuelas(ubiClave,depClave){
      $.get(base_url+`/datos/obtenerEscuelas/${ubiClave}/${depClave}`,function(data){
        $('#escClave').empty().append('<option value="">SELECCIONAR ESCUELA</option>');
        $.each(data,function(key,value){
          $('#escClave').append('<option value="'+value.escClave+'">'+value.escClave+' - '+value.escNombre+'</option>');
        // obtenerProgramas($('#escClave').val());
        });
      });
    }
    
    function obtenerProgramas(ubiClave,depClave,escClave){
      $.get(base_url+`/datos/obtenerProgramas/${ubiClave}/${depClave}/${escClave}`,function(data){
        if(data.length){
        $('#progClave').empty().append('<option value="">SELECCIONAR PROGRAMA</option>');
        $.each(data,function(key,value){
          $('#progClave').append('<option value="'+value.progClave+'">'+value.progClave+' - '+value.progNombre+'</option>');
          // obtenerPlanes($('#progClave').val());
        });
      }else{
        $('#progClave').empty();
      }
      });
    }

    function obtenerPlanes(ubiClave,depClave,escClave,progClave){
      $.get(base_url+`/datos/obtenerPlanes/${ubiClave}/${depClave}/${escClave}/${progClave}`,function(data){
        if(data.length){
        $('#planClave').empty().append('<option value="">SELECCIONAR PLAN</option>');
        $.each(data,function(key,value){
          $('#planClave').append('<option value="'+value.planClave+'">'+value.planClave+'</option>');
          // obtenerMaterias($('#planClave').val());
        });
      }else{
        $('#planClave').empty();
      }
      });
    }

    function obtenerMaterias(ubiClave,depClave,escClave,progClave,planClave){
      $.get(base_url+`/datos/obtenerMaterias/${ubiClave}/${depClave}/${escClave}/${progClave}/${planClave}`,function(data){
        $('#matClave').empty().append('<option value="">SELECCIONAR MATERIA</option>');
        $.each(data,function(key,value){
          $('#matClave').append('<option value="'+value.matClave+'">'+value.matClave+' - '+value.matNombre+'</option>');
        });
      });
    }

    
  // Rellenar los datos al entrar a la vista
  obtenerDepartamento($('#ubiClave').val());
  
  // Rellenar los datos al escoger una opción
  $('#ubiClave').change(function(){
    var ubiClave = $(this).val();
    $('#depClave').empty().append('<option value="">SELECCIONAR DEPARTAMENTO</option>');
    $('#escClave').empty().append('<option value="">SELECCIONAR ESCUELA</option>');
    $('#progClave').empty().append('<option value="">SELECCIONAR PROGRAMA</option>');
    $('#planClave').empty().append('<option value="">SELECCIONAR PLAN</option>');
    $('#matClave').empty().append('<option value="">SELECCIONAR MATERIA</option>');
    obtenerDepartamento(ubiClave);
  });

  $('#depClave').change(function(){
    var ubiClave = $('#ubiClave').val();
    var depClave = $(this).val();
    $('#escClave').empty().append('<option value="">SELECCIONAR ESCUELA</option>');
    $('#progClave').empty().append('<option value="">SELECCIONAR PROGRAMA</option>');
    $('#planClave').empty().append('<option value="">SELECCIONAR PLAN</option>');
    $('#matClave').empty().append('<option value="">SELECCIONAR MATERIA</option>');
    obtenerEscuelas(ubiClave,depClave);
  });

  $('#escClave').change(function(){
    var ubiClave = $('#ubiClave').val();
    var depClave = $('#depClave').val();
    var escClave = $(this).val();
    $('#progClave').empty().append('<option value="">SELECCIONAR PROGRAMA</option>');
    $('#planClave').empty().append('<option value="">SELECCIONAR PLAN</option>');
    $('#matClave').empty().append('<option value="">SELECCIONAR MATERIA</option>');
    obtenerProgramas(ubiClave,depClave,escClave);
  });

  $('#progClave').change(function(){
    var ubiClave = $('#ubiClave').val();
    var depClave = $('#depClave').val();
    var escClave = $('#escClave').val();
    var progClave = $(this).val();
    $('#planClave').empty().append('<option value="">SELECCIONAR PLAN</option>');
    $('#matClave').empty().append('<option value="">SELECCIONAR MATERIA</option>');
    obtenerPlanes(ubiClave,depClave,escClave,progClave);
  });

  $('#planClave').change(function(){
    var ubiClave = $('#ubiClave').val();
    var depClave = $('#depClave').val();
    var escClave = $('#escClave').val();
    var progClave = $('#progClave').val();
    var planClave = $(this).val();
    obtenerMaterias(ubiClave,depClave,escClave,progClave,planClave);
  });

  $('#depClave').change(function(){
    var depClave = $(this).val();
    obtenerPeriodos(depClave);
  });

  $('#periodo').change(function(){
    var periodo_id = $(this).val();
    obtenerFechas(periodo_id);
  });
  
});
</script>