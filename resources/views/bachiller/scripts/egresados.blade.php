
	/*
    * Busca los periodos y los agrega a los select.
    * debe tener ambos parámetros para ejecutarse.
    */
    function buscarPeriodos(ubiClave,depClave,selectItems,periodosSelects){
      if(ubiClave && depClave){ //if_ubi_dep.
        $.ajax({
          processing : 'true',
          serverSide : 'true',
          url : base_url+"/departamento/periodos/"+ubiClave+"/"+depClave,
          method : "POST",
          data : {"ubiClave":ubiClave,"depClave":depClave,"_token":"{{csrf_token()}}"},
          dataType:"json",
          success:function(data){
            console.log(data);
            var periodos = data['periodos'];

            $.each(selectItems, function (key, value){
                $('#' + value).empty().attr('disabled',false)
                    .append(new Option('Seleccionar...',''));
            });

            $.each(periodos, function (key, value){
              var perNumAnio = value.perNumero+'-'+value.perAnio+' ('+value.departamento.depClave+')';
              var periodo_id = value.id;

              $.each(selectItems, function (key, value) {
                var option = new Option(perNumAnio, periodo_id);
                var item = $('#' + value);
                item.append(option);
              });

            });

            $.each(periodosSelects, function (key, value) {
            	var element = $('#' + key);
            	element.val(value);
            	console.log(key + ': ' +value+' - '+ element.val());
            });

          },error: function(){
            console.log('nada');
          }

        });

      }else{

        $.each(selectItems, function (key, value){
            $('#' + value).empty().attr('disabled',true)
                .append(new Option('Seleccionar...',''));
        });

      }//if_ubi_dep.
    }//buscarPeriodos.


    //Detecta qué tipo de elemento es, le asigna el valor correspondiente.
    function fillFormElements(fillableForm){

        $.each(fillableForm, function(key, value) {
            var element = $('#' + key);
            if(element.is('select')){
                element.val(value).select2();
                console.log(key + ': ' +value+' - '+ element.val());
            }else if(element.is('input:text')){
                element.val(value);
                Materialize.updateTextFields();
            }else{
                element.val(value);
            }
        });

    }//fillFormElements.

    function disableElements(elements){
    	$.each(elements, function(key, value) {
            var element = $('#' + value);
            if(element.is('select')){
            	$('#' + value).attr('disabled', true);
            }else{
            	element.attr('readonly', true);
            }
            
        });
    }//disableElements.





