<!-- Modal de Contribuyentes -->
<div class="modal fade" id="contribuyentesModal" tabindex="-1" aria-labelledby="contribuyentesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contribuyentesModalLabel">Añadir Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Buscar en el listado de contribuyentes -->
                <div class="input-group mb-3">
					<input type="text" id="contribuyente_search" class="form-control" placeholder="Buscar contribuyente...">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                </div>
                <!-- Botón para abrir el modal de Nuevo Contribuyente y cerrar el actual -->
                <a href="#" data-toggle="modal" data-target="#nuevoContribuyenteModal" id="openNuevoContribuyente" class="btn btn-sm bg-maroon">
                    <i class="fa-solid fa-user-plus"></i> Nuevo Contribuyente
                </a>
                <!-- Listar los contribuyentes -->
                <div class="list-group-container">
					<ul class="list-group list-group-unbordered mb-3">
						<li class="list-group-item">
							<!-- Contenido de los contribuyentes -->
						</li>
					</ul>
				</div>
            </div>
        </div>
    </div>
</div>