<div id="modal_edit_register" class="modal fade" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Conceptos del Pedido</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">

                    <table class="table table-striped table-responsive highlight table-hover table-container">
                        <thead>
                            <tr>
                                <th>Cantidad</th>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="data in update" id="tr_@{{ update.id }}">
                                <td ng-bind="data.quality"></td>
                                <td ng-bind="data.products.codigo"></td>
                                <td ng-bind="data.products.nombre"></td>
                                <td ng-bind="data.products.descripcion"></td>
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