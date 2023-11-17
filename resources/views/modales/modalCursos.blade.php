{{-- MODAL EQUIVALENTES --}}
<div id="modalCursos-bachiller" class="modal">


    <div class="modal-content">
      <div class="row">
        <div class="col s12 ">
          <button class="btn modal-close" style="float:right;">cerrar</button>
        </div>
        <div class="col s12 ">
          <div class="card ">
            <div class="card-content">
              <span class="card-title nombres"></span>  
  
  
              <div class="row" id="Tabla">
                <div class="col s12">    
                  <div class="responsive-table display" cellspacing="0" width="100%" id="tablePrint">
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .tables tbody tr:nth-child(odd) {
      background: #F7F8F9;
      font-size: 14px;
    }

    .tables tbody tr:nth-child(even) {
      background: #F1F1F1;
      font-size: 14px;
    }

    .tables th {
      background: #01579B;
      color: #fff;
      font-size: 14px;

    }

    .tables {
      border-collapse: collapse;
      width: 100%;
      font-size: 14px;
    }
   
  </style>
  
  <script type="text/javascript">
    $(document).on("click", ".btn-modal-cursos-detalle-bachiller", function (e) {
      e.preventDefault()

      var alumno_id = $(this).data("alumno-id");
      $("#tablePrint").html("");
      $(".nombres").html("");

      $.get(base_url+`/api/cursosDetalles/${alumno_id}`, function(res,sta) {
          
          var curso_alumno = res.curso_alumno;

          if (curso_alumno.length > 0) {

            if(curso_alumno[0].perSexo == "M"){
              var es = "del alumno";
            }else{
              var es = "de la alumna";
            }

            $(".nombres").html(`Detalles de los cursos ${es} <b>${curso_alumno[0].aluClave} - ${curso_alumno[0].perApellido1} ${curso_alumno[0].perApellido2} ${curso_alumno[0].perNombre}</b>`);


              let myTable = "<table class='tables'><tr>"
                  myTable += "<th>Año</th>";
                  myTable += "<th>Período</th>";
                  myTable += "<th>Ubic</th>";
                  myTable += "<th>Dep</th>";
                  myTable += "<th>Esc</th>";
                  myTable += "<th>Prog</th>";
                  myTable += "<th>Plan</th>";
                  myTable += "<th>Edo</th>";
                  myTable += "<th>Fecha de baja</th>";
                  myTable += "<th>TI</th>";
                  myTable += "<th>Gdo/Sem</th>";
                  myTable += "<th>Gpo</th>";
                  myTable += "<th>Plan Pago</th>";
                  myTable += "<th>Beca</th>";
                  myTable += "</tr>";

                  curso_alumno.forEach(function(element, i) {
                      myTable += "<tr>";
                      myTable += `<td>${element.perAnio}</td>`;
                      myTable += `<td>${element.perNumero}</td>`;
                      myTable += `<td>${element.ubiClave}</td>`;
                      myTable += `<td>${element.depClave}</td>`;
                      myTable += `<td>${element.escClave}</td>`;
                      myTable += `<td>${element.progClave}</td>`;
                      myTable += `<td>${element.planClave}</td>`;
                      myTable += `<td>${element.curEstado}</td>`;

                      if(element.curFechaBaja != null){
                          var curFechaBaja = element.curFechaBaja;
                      }else{
                          var curFechaBaja = "";
                      }
                      myTable += `<td>${curFechaBaja}</td>`;

                      if(element.curTipoIngreso != null){
                          var curTipoIngreso = element.curTipoIngreso;
                      }else{
                          var curTipoIngreso = "";
                      }

                      myTable += `<td>${curTipoIngreso}</td>`;
                      myTable += `<td>${element.cgtGradoSemestre}</td>`;
                      myTable += `<td>${element.cgtGrupo}</td>`;
                      myTable += `<td>${element.curPlanPago}</td>`;

                      if(element.curTipoBeca != null){
                          var curTipoBeca = element.curTipoBeca;
                      }else{
                          var curTipoBeca = "";
                      }
                      myTable += `<td>${curTipoBeca}</td>`;
                      myTable += "</tr>";
                  });

                  myTable += "</table>";

                  $("#tablePrint").html(myTable);
          }else{
            $('#modalCursos-bachiller').modal('close');
            swal("Escuela Modelo", "El alumno no se encuentra registrado en ningun curso", "info");
          }
          
          
          

      });      
      
      $('.modal').modal();
      
  })
  </script>