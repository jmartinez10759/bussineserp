<div class="" id="modal_add_register" tabindex="-1" role="dialog" aria-hidden="true" style="display:none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">REGISTRO DE LLAMADAS</h4>
      </div>

      <div class="modal-body ">

        <form class="form-horizontal" >
          <div class="form-group">
            <label class="control-label col-sm-2">FOLIO:</label>
            <div class="col-sm-4">
              <input type="text" name="folio" class="form-control" placeholder="" style="text-transform: uppercase;">
            </div>

            <label class="control-label col-sm-2" >FOTO:</label>
            <div class="col-sm-4">
              <input type="file" name="foto" class="form-control" placeholder="">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2" >NOMBRE (ES): </label>
            <div class="col-sm-4">
              <input type="text" name="nombres" class="form-control" placeholder="" >
            </div>

            <label class="control-label col-sm-2" >SOLICITUD: </label>
            <div class="col-sm-4">
              <input type="text" name="folio_factura" class="form-control" placeholder="" >
            </div>
          </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" >APELLIDO PATERNO: </label>
                            <div class="col-sm-4">
                                <input type="text" name="ap_paterno" class="form-control" placeholder="" >
                            </div>

                            <label class="control-label col-sm-2" >TELEFONO: </label>
                            <div class="col-sm-4">
                                <input type="number" name="telefono" class="form-control" placeholder="" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" >APELLIDO MATERNO: </label>
                            <div class="col-sm-4">
                                <input type="text" name="ap_materno" class="form-control" placeholder="" >
                            </div>

                            <label class="control-label col-sm-2" >INE: </label>
                            <div class="col-sm-4">
                                <input type="file" name="ine" class="form-control" placeholder="" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" >FECHA DE NACIMIENTO: </label>
                            <div class="col-sm-4">
                                <input type="text" name="ap_paterno" class="form-control" placeholder="" >
                            </div>

                            <label class="control-label col-sm-2" >CURP: </label>
                            <div class="col-sm-4">
                                <input type="text" name="telefono" class="form-control" placeholder="" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" >DIRECCIÓN: </label>
                            <div class="col-sm-4">
                                <input type="text" name="ap_paterno" class="form-control" placeholder="" >
                            </div>

                            <label class="control-label col-sm-2" >INE PADRES: </label>
                            <div class="col-sm-4">
                                <input type="file" name="ine_padres" class="form-control" placeholder="" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" >DESCRIPCIÓN: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" row="5"></textarea>
                            </div>

                            <label class="control-label" ><button type="button" class="btn btn-info">BUSCAR</button> </label>
                            <div class="col-sm-1">

                            </div>
                        </div>

          </form>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-success" v-on:click.prevent="">Enviar</button>
          <button type="button" class="btn btn-danger" data-fancybox-close>Cancelar</button>
        </div>

      </div>
    </div>

  </div>
