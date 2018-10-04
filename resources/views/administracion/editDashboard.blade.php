  <div class="modal fade" id="modal_postulaciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Postulaciones Candidato</h4>
        </div>
        <div class="modal-body">

            <div class="table-responsive">

                 <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Ciudad</th>
                        <th>Departamento</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="( postulaciones, key ) in fields.postulaciones">
                        <th scope="row">@{{key + 1}}</th>
                        <td>@{{postulaciones.name}}</td>
                        <td>@{{postulaciones.code}}</td>
                        <td>@{{postulaciones.county}}</td>
                        <td>@{{postulaciones.department}}</td>

                      </tr>

                    </tbody>
                  </table>


            </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i>  Cerrar</button>
          <!-- <button type="button" class="btn btn-primary" v-on:click.prevent="update_candidate()" ><i class="fa fa-save"></i> Actualizar </button> -->
        </div>
      </div>
    </div>
  </div>
