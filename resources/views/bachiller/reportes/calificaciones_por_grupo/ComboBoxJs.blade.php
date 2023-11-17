<script type="text/javascript">

    $(document).ready(function() {

        $("select[name=tipoReporte]").change(function(){
            if($('select[name=tipoReporte]').val() == "porMes"){
                $("#vistaPorMes").show();
                $("#vistaPorBimestre").hide();
                $("#vistaPorTrimestre").hide();
                $("#vistaFinales").hide();

     
                $('#mesEvaluar').prop("required", true);
                 $("#bimestreEvaluar").removeAttr("required");
                 $("#trimestreEvaluar").removeAttr("required");
                 $("#tipoFinal").removeAttr("required");

                
            }
     
            if($('select[name=tipoReporte]').val() == "porBimestre"){
                 $("#vistaPorMes").hide();
                 $("#vistaPorBimestre").show();
                 $("#vistaPorTrimestre").hide();
                 $("#vistaFinales").hide();

     
                 $('#bimestreEvaluar').prop("required", true);
                 $("#mesEvaluar").removeAttr("required");
                 $("#trimestreEvaluar").removeAttr("required");
                 $("#tipoFinal").removeAttr("required");

     
            }
     
            if($('select[name=tipoReporte]').val() == "porTrimestre"){
             
                 $("#vistaPorMes").hide();
                 $("#vistaPorBimestre").hide();
                 $("#vistaPorTrimestre").show();
                 $("#vistaFinales").hide();

     
                 $('#trimestreEvaluar').prop("required", true);
                 $("#mesEvaluar").removeAttr("required");
                 $("#bimestreEvaluar").removeAttr("required");
                 $("#tipoFinal").removeAttr("required");

            }


               if($('select[name=tipoReporte]').val() == "califFinales"){
             
                    $("#vistaPorMes").hide();
                    $("#vistaPorBimestre").hide();
                    $("#vistaPorTrimestre").hide();
                    $("#vistaFinales").show();

     
                    $('#trimestreEvaluar').removeAttr("required");
                    $("#mesEvaluar").removeAttr("required");
                    $("#bimestreEvaluar").removeAttr("required");
                    $('#tipoFinal').prop("required", true);


               }
         });
       
    });

</script>