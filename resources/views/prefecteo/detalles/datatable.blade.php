
	<div id="table-datatables">
	    <h4 class="header">Detalles</h4>
	    <br>
	    <br>
	    <div class="row">
	        <div class="col s12">
	            <table id="tbl-prefecteodetalles" class="responsive-table display" cellspacing="0" width="100%">
	                <thead>
	                <tr>
	                	<th>Folio</th>
	                    <th>Programa</th>
	                    <th>Grado</th>
	                    <th>Grupo</th>
	                    <th>Aula</th>
	                    <th>Inicial</th>
	                    <th>Termina</th>
	                    <th>Revisión</th>
	                    <th>Acciones</th>
	                </tr>
	                </thead>
	                <tfoot>
	                <tr>
	                    <th></th>
	                    <th></th>
	                    <th></th>
	                    <th></th>
	                    <th></th>
	                    <th></th>
	                    <th></th>
	                    <th></th>
	                    <th class="non_searchable"></th>
	                </tr>
	                </tfoot>
	            </table>
	        </div>
	    </div>
	</div>

	<div class="preloader">
	    <div id="preloader"></div>
	</div>

@section('footer_scripts')

	{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
	{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}
	<script type="text/javascript">

		const prefecteo_id = {!! json_encode($prefecteo->id) !!};

	    $(document).ready(function() {
	        $.fn.dataTable.ext.errMode = 'throw';
	        $('#tbl-prefecteodetalles').dataTable({
	            "language":{"url":base_url+"/api/lang/javascript/datatables"},
	            "serverSide": true,
	            "dom": '"top"i',
	            "pageLength": 5,
	            "stateSave": true,
	            "ajax": {
	                "type" : "GET",
	                'url': base_url+"/api/prefecteo/" + prefecteo_id + "/detalles",
	                beforeSend: function () {
	                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
	                },
	                complete: function () {
	                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
	                }, error: function(XMLHttpRequest, textStatus, errorThrown) {
	                    if (errorThrown === "Unauthorized") {
	                        swal({
	                            title: "Ups...",
	                            text: "La sesion ha expirado",
	                            type: "warning",
	                            confirmButtonText: "Ok",
	                            confirmButtonColor: '#3085d6',
	                            showCancelButton: false
	                            }, function(isConfirm) {
	                            if (isConfirm) {
	                                window.location.href = 'login';
	                            } else {
	                                window.location.href = 'login';
	                            }
	                        });
	                    }
	                }
	            },
	            "columns":[
	            	{data: "id"},
	                {data: "programa.progClave"},
	                {data: "grupo.gpoSemestre"},
	                {data: "grupo.gpoClave"},
	                {data: "aula.aulaClave"},
	                {data: "ghInicio"},
	                {data: "ghFinal"},
	                {data: "prefHora"},
	                {data: "action", name: "action"}
	            ],
	            //Apply the search
	            initComplete: function () {

	                var searchFill = JSON.parse(localStorage.getItem( 'DataTables_' + this.api().context[0].sInstance ))

	                var index = 0
	                this.api().columns().every(function () {
	                    var column = this;
	                    var columnClass = column.footer().className;
	                    if(columnClass != 'non_searchable'){
	                        var input = document.createElement("input");


	                        var columnDataOld = searchFill.columns[index].search.search
	                        $(input).attr("placeholder", "Buscar").addClass("busquedas").val(columnDataOld);


	                        $(input).appendTo($(column.footer()).empty())
	                        .on('change', function () {
	                            column.search($(this).val(), false, false, true).draw();
	                        });
	                    }

	                    index ++
	                });
	            },

	            stateSaveCallback: function(settings,data) {
	                localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
	            },
	            stateLoadCallback: function(settings) {
	                return JSON.parse(localStorage.getItem( 'DataTables_' + settings.sInstance ) )
	            }

	        });

	    });

	</script>
@endsection