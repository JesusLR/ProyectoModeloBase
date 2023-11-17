<script>
    $(document).ready(function(){
        
        $("#que_se_va_a_calificar").change(function(){
            if($('select[id=que_se_va_a_calificar]').val() == "parcial1"){
    
                $("#Tablaalumnos").show();
                $(".btn-guardar").show();
    
                $("#ordi1").show();
                $('td:nth-child(4)').show();
                $("#faltasOrdi1").show();
                $('td:nth-child(5)').show();
    
                //ocultamos segundo parcial
                $("#ordi2").hide();
                $('td:nth-child(6)').hide();
                $("#faltasOrdi2").hide();
                $('td:nth-child(7)').hide();
    
                //ocultamos tercer parcial
                $("#ordi3").hide();
                $('td:nth-child(8)').hide();
                $("#faltasOrdi3").hide();
                $('td:nth-child(9)').hide();
    
                //ocultamos tercer parcial
                $("#ordi4").hide();
                $('td:nth-child(10)').hide();
                $("#faltasOrdi4").hide();
                $('td:nth-child(11)').hide();
    
                //ocultamos calificacion recuperacion
                $("#recu1").hide();
                $('td:nth-child(12)').hide();

                $("#recu2").hide();
                $('td:nth-child(13)').hide();
    
                $("#recu3").hide();
                $('td:nth-child(14)').hide();

                $("#recu4").hide();
                $('td:nth-child(15)').hide();

                //ocultamos los extraordinarios
                $("#extra1").hide();
                $('td:nth-child(16)').hide();

                $("#extra2").hide();
                $('td:nth-child(17)').hide();
    
                $("#extra3").hide();
                $('td:nth-child(18)').hide();

                $("#extra4").hide();
                $('td:nth-child(19)').hide();

                //ocultamos calificacion especial
                $("#espe").hide();
                $('td:nth-child(20)').hide();
    
                
            }            
        });
    
        $("#que_se_va_a_calificar").change(function(){
            if($('select[id=que_se_va_a_calificar]').val() == "parcial2"){
                $("#Tablaalumnos").show();
                $(".btn-guardar").show();
                $("#ordi2").show();
                $('td:nth-child(6)').show();
                $("#faltasOrdi2").show();
                $('td:nth-child(7)').show();
    
                //ocultamos primero parcial
                $("#ordi1").hide();
                $('td:nth-child(4)').hide();
                $("#faltasOrdi1").hide();
                $('td:nth-child(5)').hide();
    
                //ocultamos tercer parcial
                $("#ordi3").hide();
                $('td:nth-child(8)').hide();
                $("#faltasOrdi3").hide();
                $('td:nth-child(9)').hide();
    
                //ocultamos cuarto parcial
                $("#ordi4").hide();
                $('td:nth-child(10)').hide();
                $("#faltasOrdi3").hide();
                $('td:nth-child(11)').hide();
    
                //ocultamos calificacion recuperacion
                $("#recu1").hide();
                $('td:nth-child(12)').hide();

                $("#recu2").hide();
                $('td:nth-child(13)').hide();
    
                $("#recu3").hide();
                $('td:nth-child(14)').hide();

                $("#recu4").hide();
                $('td:nth-child(15)').hide();

                  //ocultamos los extraordinarios
                  $("#extra1").hide();
                  $('td:nth-child(16)').hide();
  
                  $("#extra2").hide();
                  $('td:nth-child(17)').hide();
      
                  $("#extra3").hide();
                  $('td:nth-child(18)').hide();
  
                  $("#extra4").hide();
                  $('td:nth-child(19)').hide();

                  //ocultamos calificacion especial
                $("#espe").hide();
                $('td:nth-child(20)').hide();
            }            
        });
    
        $("#que_se_va_a_calificar").change(function(){
            if($('select[id=que_se_va_a_calificar]').val() == "parcial3"){
                $("#Tablaalumnos").show();
                $(".btn-guardar").show();
                $("#ordi3").show();
                $('td:nth-child(8)').show();
                $("#faltasOrdi3").show();
                $('td:nth-child(9)').show();
    
                //ocultamos primer parcial
                $("#ordi1").hide();
                $('td:nth-child(4)').hide();
                $("#faltasOrdi1").hide();
                $('td:nth-child(5)').hide();
    
                //ocultamos segundo parcial
                $("#ordi2").hide();
                $('td:nth-child(6)').hide();
                $("#faltasOrdi2").hide();
                $('td:nth-child(7)').hide();
    
                //ocultamos cuarto parcial
                $("#ordi4").hide();
                $('td:nth-child(10)').hide();
                $("#faltasOrdi4").hide();
                $('td:nth-child(11)').hide();
    
                //ocultamos calificacion recuperacion
                $("#recu1").hide();
                $('td:nth-child(12)').hide();

                $("#recu2").hide();
                $('td:nth-child(13)').hide();
    
                $("#recu3").hide();
                $('td:nth-child(14)').hide();

                $("#recu4").hide();
                $('td:nth-child(15)').hide();

                  //ocultamos los extraordinarios
                  $("#extra1").hide();
                  $('td:nth-child(16)').hide();
  
                  $("#extra2").hide();
                  $('td:nth-child(17)').hide();
      
                  $("#extra3").hide();
                  $('td:nth-child(18)').hide();
  
                  $("#extra4").hide();
                  $('td:nth-child(19)').hide();

                  //ocultamos calificacion especial
                $("#espe").hide();
                $('td:nth-child(20)').hide();
           
            }            
        });
    
        $("#que_se_va_a_calificar").change(function(){
            if($('select[id=que_se_va_a_calificar]').val() == "parcial4"){
                $("#Tablaalumnos").show();
                $(".btn-guardar").show();
                $("#ordi4").show();
                $('td:nth-child(10)').show();
                $("#faltasOrdi4").show();
                $('td:nth-child(11)').show();
    
                //ocultamos primer parcial
                $("#ordi1").hide();
                $('td:nth-child(4)').hide();
                $("#faltasOrdi1").hide();
                $('td:nth-child(5)').hide();
    
                //ocultamos segundo parcial
                $("#ordi2").hide();
                $('td:nth-child(6)').hide();
                $("#faltasOrdi2").hide();
                $('td:nth-child(7)').hide();
    
                //ocultamos tercer parcial
                $("#ordi3").hide();
                $('td:nth-child(8)').hide();
                $("#faltasOrdi3").hide();
                $('td:nth-child(9)').hide();
    
                //ocultamos calificacion recuperacion
                $("#recu1").hide();
                $('td:nth-child(12)').hide();

                $("#recu2").hide();
                $('td:nth-child(13)').hide();
    
                $("#recu3").hide();
                $('td:nth-child(14)').hide();

                $("#recu4").hide();
                $('td:nth-child(15)').hide();

                  //ocultamos los extraordinarios
                  $("#extra1").hide();
                  $('td:nth-child(16)').hide();
  
                  $("#extra2").hide();
                  $('td:nth-child(17)').hide();
      
                  $("#extra3").hide();
                  $('td:nth-child(18)').hide();
  
                  $("#extra4").hide();
                  $('td:nth-child(19)').hide();

                  //ocultamos calificacion especial
                $("#espe").hide();
                $('td:nth-child(20)').hide();
                
           
            }            
        });
    
    
    
        //RECUPERACION
        $("#que_se_va_a_calificar").change(function(){
            if($('select[id=que_se_va_a_calificar]').val() == "recuperacion"){
                $("#Tablaalumnos").show();
                $(".btn-guardar").show();
                $("#recu1").show();
                $('td:nth-child(12)').show();

                $("#recu2").show();
                $('td:nth-child(13)').show();
    
                $("#recu3").show();
                $('td:nth-child(14)').show();

                $("#recu4").show();
                $('td:nth-child(15)').show();
    
                //ocultamos primer parcial
                $("#ordi1").hide();
                $('td:nth-child(4)').hide();
                $("#faltasOrdi1").hide();
                $('td:nth-child(5)').hide();
    
                //ocultamos segundo parcial
                $("#ordi2").hide();
                $('td:nth-child(6)').hide();
                $("#faltasOrdi2").hide();
                $('td:nth-child(7)').hide();
    
                //ocultamos tercer parcial
                $("#ordi3").hide();
                $('td:nth-child(8)').hide();
                $("#faltasOrdi3").hide();
                $('td:nth-child(9)').hide();
    
                //ocultamos cuarto parcial
                $("#ordi4").hide();
                $('td:nth-child(10)').hide();
                $("#faltasOrdi4").hide();
                $('td:nth-child(11)').hide();

                  //ocultamos los extraordinarios
                  $("#extra1").hide();
                  $('td:nth-child(16)').hide();
  
                  $("#extra2").hide();
                  $('td:nth-child(17)').hide();
      
                  $("#extra3").hide();
                  $('td:nth-child(18)').hide();
  
                  $("#extra4").hide();
                  $('td:nth-child(19)').hide();
    
                  //ocultamos calificacion especial
                $("#espe").hide();
                $('td:nth-child(20)').hide();
               
           
            }            
        });
    
        //EXTRAORDINARIO
        $("#que_se_va_a_calificar").change(function(){
            if($('select[id=que_se_va_a_calificar]').val() == "extraordinario"){
                $("#Tablaalumnos").show();
                $(".btn-guardar").show();
                
                  //mostramos los extraordinarios
                  $("#extra1").show();
                  $('td:nth-child(16)').show();
  
                  $("#extra2").show();
                  $('td:nth-child(17)').show();
      
                  $("#extra3").show();
                  $('td:nth-child(18)').show();
  
                  $("#extra4").show();
                  $('td:nth-child(19)').show();
    
                //ocultamos primer parcial
                $("#ordi1").hide();
                $('td:nth-child(4)').hide();
                $("#faltasOrdi1").hide();
                $('td:nth-child(5)').hide();
    
                //ocultamos segundo parcial
                $("#ordi2").hide();
                $('td:nth-child(6)').hide();
                $("#faltasOrdi2").hide();
                $('td:nth-child(7)').hide();
    
                //ocultamos tercer parcial
                $("#ordi3").hide();
                $('td:nth-child(8)').hide();
                $("#faltasOrdi3").hide();
                $('td:nth-child(9)').hide();
    
                //ocultamos cuarto parcial
                $("#ordi4").hide();
                $('td:nth-child(10)').hide();
                $("#faltasOrdi4").hide();
                $('td:nth-child(11)').hide();
    
                //ocultamos recuperacion
                $("#recu1").hide();
                $('td:nth-child(12)').hide();

                $("#recu2").hide();
                $('td:nth-child(13)').hide();
    
                $("#recu3").hide();
                $('td:nth-child(14)').hide();

                $("#recu4").hide();
                $('td:nth-child(15)').hide();

                //ocultamos calificacion especial
                $("#espe").hide();
                $('td:nth-child(20)').hide();
           
            }            
        });
    
        //ESPECIAL
        $("#que_se_va_a_calificar").change(function(){
            if($('select[id=que_se_va_a_calificar]').val() == "especial"){
                $("#Tablaalumnos").show();
                $(".btn-guardar").show();
               
                //ocultamos calificacion especial
                $("#espe").show();
                $('td:nth-child(20)').show();
    
                //ocultamos primer parcial
                $("#ordi1").hide();
                $('td:nth-child(4)').hide();
                $("#faltasOrdi1").hide();
                $('td:nth-child(5)').hide();
    
                //ocultamos segundo parcial
                $("#ordi2").hide();
                $('td:nth-child(6)').hide();
                $("#faltasOrdi2").hide();
                $('td:nth-child(7)').hide();
    
                //ocultamos tercer parcial
                $("#ordi3").hide();
                $('td:nth-child(8)').hide();
                $("#faltasOrdi3").hide();
                $('td:nth-child(9)').hide();
    
                //ocultamos cuarto parcial
                $("#ordi4").hide();
                $('td:nth-child(10)').hide();
                $("#faltasOrdi4").hide();
                $('td:nth-child(11)').hide();
    
                $("#recu1").hide();
                $('td:nth-child(12)').hide();

                $("#recu2").hide();
                $('td:nth-child(13)').hide();
    
                $("#recu3").hide();
                $('td:nth-child(14)').hide();

                $("#recu4").hide();
                $('td:nth-child(15)').hide();

                //ocultamos calificaciones recuperacion
                $("#recu1").hide();
                $('td:nth-child(12)').hide();

                $("#recu2").hide();
                $('td:nth-child(13)').hide();
    
                $("#recu3").hide();
                $('td:nth-child(14)').hide();

                $("#recu4").hide();
                $('td:nth-child(15)').hide();

                //ocultamos calificaciones extraordinarios
                $("#extra1").hide();
                $('td:nth-child(16)').hide();

                $("#extra2").hide();
                $('td:nth-child(17)').hide();
    
                $("#extra3").hide();
                $('td:nth-child(18)').hide();

                $("#extra4").hide();
                $('td:nth-child(19)').hide();
           
            }            
        });
    });
    </script>