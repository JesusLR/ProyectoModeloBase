<script>
    $(document).ready(function() {

        
        $(document).on("click", "#btn-guardar-calificacion", function(e) {      
          

            var secundaria_calificacion_id = $("input[id='secundaria_calificacion_id']") .map(function(){return $(this).val();}).get();
            var calificacion_alumno = $("input[id='calificacion_alumno']") .map(function(){return $(this).val();}).get();
            var secundaria_inscrito_id = $("input[id='secundaria_inscrito_id']") .map(function(){return $(this).val();}).get();
            var mes_calificacion = $("#mes_calificacion").val();            
          

            e.preventDefault();

            $.ajax({
                url: "{{route('secundaria.secundaria_modificar_boleta.actualizar_calificaciones')}}",
                method: "POST",
                dataType: "json",
                data: {
                    "_token": $("meta[name=csrf-token]").attr("content"),
                    secundaria_calificacion_id: secundaria_calificacion_id,
                    calificacion_alumno: calificacion_alumno,
                    secundaria_inscrito_id: secundaria_inscrito_id,
                    mes_calificacion: mes_calificacion                 
                },
                success: function(data){
                    
                    if(data.response == "true"){
                        //swal("BIEN!!", "Se ha actualizado correctamente las calificaciones", "success");
                        swal({
                            title: "BIEN!",
                            text: "Se ha actualizado correctamente las calificaciones",
                            icon: "success",
                            buttons: true,
                            timer: 3000
                          });
                        document.getElementById('tablePrint').innerHTML = "";
                        $("#mostrar-save").hide();
                        $("#alumno_nombre").text("");
                    }else{
                        swal("Upsss...", "Error inesperado", "warning");
                    }
         
                },
                error: function(){
                    swal("Escuela Modelo", "Error inesperado, intende nuevamente", "error");
                }
            });
         
        });
    });
</script>