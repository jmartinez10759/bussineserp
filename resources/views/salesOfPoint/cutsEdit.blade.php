<div id="modal_edit_register" class="modal fade" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Pedidos del Corte</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped highlight table-hover table-container">
                        <thead>
                            <tr>
                                <th>N° Orden</th>
                                <th>Comentarios</th>
                                <th>Subtotal</th>
                                <th>Iva</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="data in update" id="tr_@{{ update.id }}">
                                <td ng-bind="data.id"></td>
                                <td ng-bind="data.comments"></td>
                                <td ng-bind="data.subtotal | currency:$:2"></td>
                                <td ng-bind="data.iva | currency:$:2"></td>
                                <td ng-bind="data.total | currency:$:2"></td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>

            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times-circle"></i> Cerrar
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>