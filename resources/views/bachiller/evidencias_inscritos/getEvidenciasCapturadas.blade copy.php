<script type="text/javascript">

    $(document).ready(function() {

        $("#bachiller_evidencia_id").change( event => {
            var bachiller_grupo_id = $("#bachiller_grupo_id").val();

            $("#tableBody").html("");
            $("#puntosMaximos").text("");



            $.get(base_url+`/bachiller_evidencias_inscritos/capturas_realizadas/${bachiller_grupo_id}/${event.target.value}`,function(res,sta){            

                //Variable para cuando hay evidencias capturadas
                var bachiller_evidencias = res.bachiller_evidencias;
                //Variable a usar cuando no hay evidencias capturadas
                var bachiller_inscritos = res.bachiller_inscritos;

                console.log(res.bachiller_evidencias.length);

                //Creamos tabla cuando haya evidencias capturadas 
                if(bachiller_evidencias.length > 0){

                    $("#Tabla").show();
                    $("#submit-button").show();
                    $("#puntos").show();

                    const cuerpoTabla = document.querySelector("#tableBody");

                    bachiller_evidencias.forEach(function (element, i) {
                      
                        $("#puntosMaximos").text(element.eviPuntos);

                        // Crear un <tr>
                        const tr = document.createElement("tr");


                        // Creamos el <td> de nombre y lo adjuntamos a tr

                        let id = document.createElement("td");
                        id.innerHTML = `<input style='display:none;' name='bachiller_inscrito_evidencia_id[]' id='bachiller_inscrito_evidencia_id' type='hidden' value='${element.id}'>`; // el textContent del td es el nombre
                        tr.appendChild(id); //1

                        let bachiller_inscrito_id = document.createElement("td");
                        bachiller_inscrito_id.innerHTML =`<input style='display:none;' id='bachiller_inscrito_id' name='bachiller_inscrito_id[]' type='hidden' value='${element.bachiller_inscrito_id}'>`; 
                        tr.appendChild(bachiller_inscrito_id);//2

                        let numeroEvidencia = document.createElement("td");
                        numeroEvidencia.innerHTML =`<input name='evidencianumero[]' type='text' value='${element.eviNumero}'>`; 
                        tr.appendChild(numeroEvidencia);//3
                            

                        let numeroLista = document.createElement("td");
                        numeroLista.innerHTML = `${i+1}`; // el textContent del td es el nombre
                        tr.appendChild(numeroLista); //

                        let clavePago = document.createElement("td");
                        clavePago.innerHTML = `${element.aluClave}`; // el textContent del td es el nombre
                        tr.appendChild(clavePago); //                       
                       

                        let nombreAlumno = document.createElement("td");
                        nombreAlumno.textContent = `${element.perApellido1} ${element.perApellido2} ${element.perNombre}`; 
                        tr.appendChild(nombreAlumno);//


                        let puntosEvidencias = document.createElement("td");
                        puntosEvidencias.innerHTML = `<input type='number' id='ievPuntos' class='noUpperCase' name='ievPuntos[]' value='${element.ievPuntos}'>`; 
                        tr.appendChild(puntosEvidencias);//



                        let faltasEvidencias = document.createElement("td");
                        faltasEvidencias.innerHTML = `<input type='number' id='ievFaltas' name='ievFaltas[]' value='${element.ievFaltas}' step='1'>`; 
                        tr.appendChild(faltasEvidencias);//
                

                        

                        let claveCualitativa1 = document.createElement("td");                        
                        claveCualitativa1.innerHTML = `<select id='ievClaveCualitativa1' name='ievClaveCualitativa1[]' class='browser-default validate' style='margin-top: -20px; width: 100%;'></select>`;
                        tr.appendChild(claveCualitativa1);//

                        res.bachiller_conceptos_cualitativos.forEach(function (elemen, iy) {
                            agregar = $("#ievClaveCualitativa1").append(`<option value=${elemen.id}>${elemen.id} ${elemen.cuaClave}</option>`);                            
                        });
                        
                        let movimiento = document.createElement("td");
                        movimiento.innerHTML = `<input type='hidden' id='movimiento' name='movimiento' value='ACTUALIZAR'>`; 
                        tr.appendChild(movimiento);//
                        // Finalmente agregamos el <tr> al cuerpo de la tabla
                        cuerpoTabla.appendChild(tr);
                        // Y el ciclo se repite hasta que se termina de recorrer todo el arreglo


                        


                        //Ocultamos columnas
                        $(".ocultar").hide();
                        $('td:nth-child(1)').hide();
                        $('td:nth-child(2)').hide();
                        $('td:nth-child(3)').hide();



                    
                    });

                }else{
                    //Cuando no hay evidencias creadas

                    var evidencia = res.evidencia;
                    $("#puntosMaximos").text(evidencia.eviPuntos);


                    $("#Tabla").show();
                    $("#submit-button").show();
                    $("#puntos").show();

                    const cuerpoTabla = document.querySelector("#tableBody");

                    bachiller_inscritos.forEach(function (element, i) {
                      

                        // Crear un <tr>
                        const tr = document.createElement("tr");


                        // Creamos el <td> de nombre y lo adjuntamos a tr

                        let id = document.createElement("td");
                        id.innerHTML = `<input style='display:none;' name='id[]' type='hidden' value=''>`; // el textContent del td es el nombre
                        tr.appendChild(id); //1

                        let bachiller_inscrito_id = document.createElement("td");
                        bachiller_inscrito_id.innerHTML =`<input style='display:none;' name='bachiller_inscrito_id[]' id='bachiller_inscrito_id' type='hidden' value='${element.id}'>`; 
                        tr.appendChild(bachiller_inscrito_id);//2

                        let numeroEvidencia = document.createElement("td");
                        numeroEvidencia.innerHTML =`<input name='evidencianumero[]' type='text' value=''>`; 
                        tr.appendChild(numeroEvidencia);//2
                            

                        let numeroLista = document.createElement("td");
                        numeroLista.innerHTML = `${i+1}`; // el textContent del td es el nombre
                        tr.appendChild(numeroLista); //

                        let clavePago = document.createElement("td");
                        clavePago.innerHTML = `${element.aluClave}`; // el textContent del td es el nombre
                        tr.appendChild(clavePago); //                       
                       

                        let nombreAlumno = document.createElement("td");
                        nombreAlumno.textContent = `${element.perApellido1} ${element.perApellido2} ${element.perNombre}`; 
                        tr.appendChild(nombreAlumno);//


                        let puntosEvidencias = document.createElement("td");
                        puntosEvidencias.innerHTML = `<input type='number' id='ievPuntos' class='noUpperCase' name='ievPuntos[]' value=''>`; 
                        tr.appendChild(puntosEvidencias);//



                        let faltasEvidencias = document.createElement("td");
                        faltasEvidencias.innerHTML = `<input type='number' id='ievFaltas' name='ievFaltas[]' value='' step='1'>`; 
                        tr.appendChild(faltasEvidencias);//


                        let movimiento = document.createElement("td");
                        movimiento.innerHTML = `<input type='hidden' id='movimiento' name='movimiento' value='CREAR'>`; 
                        tr.appendChild(movimiento);//
                
                        
                        // Finalmente agregamos el <tr> al cuerpo de la tabla
                        cuerpoTabla.appendChild(tr);
                        // Y el ciclo se repite hasta que se termina de recorrer todo el arreglo




                        //Ocultamos columnas
                        $(".ocultar").hide();
                        $('td:nth-child(1)').hide();
                        $('td:nth-child(2)').hide();
                        $('td:nth-child(3)').hide();
                    
                    });
                }
                
            });
        });    
         

     });
</script>