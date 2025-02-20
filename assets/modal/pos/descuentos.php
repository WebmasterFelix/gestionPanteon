<div class="modal fade" id="descuentosModal" tabindex="-1" role="dialog" aria-labelledby="descuentoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="descuentoModalLabel">Aplicar Descuento al Total</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formDescuento">
                    <div class="form-group">
                        <label for="valorDescuento">Valor del Descuento</label>
                        <input type="number" class="form-control" id="valorDescuento" placeholder="Ingresa el valor del descuento" min="0">
                    </div>
                    <div class="form-group">
                        <label for="tituloDescuento">Título del Descuento (Opcional)</label>
                        <input type="text" class="form-control" id="tituloDescuento" placeholder="Escribe un título para el descuento">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="aplicarDescuento">Aplicar Descuento</button>
            </div>
        </div>
    </div>
</div>