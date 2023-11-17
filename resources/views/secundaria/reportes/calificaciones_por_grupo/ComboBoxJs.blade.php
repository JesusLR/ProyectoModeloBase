<script type="text/javascript">

    $(document).ready(function() {

        $("select[name=tipoReporte]").change(function(){
            if($('select[name=tipoReporte]').val() == "porMes"){
                $("#vistaPorMes").show();
                $("#vistaPorBimestre").hide();
                $("#vistaPorTrimestre").hide();
                $("#vistaFinales").hide();
                $("#vistaRecuperativos").hide();

     
                $('#mesEvaluar').prop("required", true);
                 $("#bimestreEvaluar").removeAttr("required");
                 $("#trimestreEvaluar").removeAttr("required");
                 $("#tipoFinal").removeAttr("required");
                 $("#tipoRecuperativo").removeAttr("required");


                
            }
     
            if($('select[name=tipoReporte]').val() == "porBimestre"){
                 $("#vistaPorMes").hide();
                 $("#vistaPorBimestre").show();
                 $("#vistaPorTrimestre").hide();
                 $("#vistaFinales").hide();
                 $("#vistaRecuperativos").hide();


     
                 $('#bimestreEvaluar').prop("required", true);
                 $("#mesEvaluar").removeAttr("required");
                 $("#trimestreEvaluar").removeAttr("required");
                 $("#tipoFinal").removeAttr("required");
                 $("#tipoRecuperativo").removeAttr("required");


     
            }
     
            if($('select[name=tipoReporte]').val() == "porTrimestre"){
             
                 $("#vistaPorMes").hide();
                 $("#vistaPorBimestre").hide();
                 $("#vistaPorTrimestre").show();
                 $("#vistaFinales").hide();
                 $("#vistaRecuperativos").hide();


     
                 $('#trimestreEvaluar').prop("required", true);
                 $("#mesEvaluar").removeAttr("required");
                 $("#bimestreEvaluar").removeAttr("required");
                 $("#tipoFinal").removeAttr("required");
                 $("#tipoRecuperativo").removeAttr("required");


            }


               if($('select[name=tipoReporte]').val() == "califFinales"){
             
                    $("#vistaPorMes").hide();
                    $("#vistaPorBimestre").hide();
                    $("#vistaPorTrimestre").hide();
                    $("#vistaFinales").show();
                    $("#vistaRecuperativos").hide();


     
                    $('#trimestreEvaluar').removeAttr("required");
                    $("#mesEvaluar").removeAttr("required");
                    $("#bimestreEvaluar").removeAttr("required");
                    $("#tipoRecuperativo").removeAttr("required");

                    $('#tipoFinal').prop("required", true);


               }

               if($('select[name=tipoReporte]').val() == "califRecuperativos"){
             
                    $("#vistaPorMes").hide();
                    $("#vistaPorBimestre").hide();
                    $("#vistaPorTrimestre").hide();
                    $("#vistaFinales").hide();
                    $("#vistaRecuperativos").show();


     
                    $('#trimestreEvaluar').removeAttr("required");
                    $("#mesEvaluar").removeAttr("required");
                    $("#bimestreEvaluar").removeAttr("required");
                    $("#tipoFinal").removeAttr("required");
                    $('#tipoRecuperativo').prop("required", true);


               }
         });


         if($('select[name=tipoReporte]').val() == "porMes"){
          $("#vistaPorMes").show();
          $("#vistaPorBimestre").hide();
          $("#vistaPorTrimestre").hide();
          $("#vistaFinales").hide();
          $("#vistaRecuperativos").hide();


          $('#mesEvaluar').prop("required", true);
           $("#bimestreEvaluar").removeAttr("required");
           $("#trimestreEvaluar").removeAttr("required");
           $("#tipoFinal").removeAttr("required");
           $("#tipoRecuperativo").removeAttr("required");


          
      }
       
    });

</script>