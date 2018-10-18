<!-- Main content -->
<section class="content">
  <div class="row">

    <div class="col-md-12">
      <div class="box box-defaulf" style="height:90%">
        <!-- <div class="box-header with-border"></div> -->
        <!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
            <input type="text"class="form-control" placeholder="Para:" v-model="newKeep.emisor" id="emisor">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Asunto:" v-model="newKeep.asunto" id="asunto">
          </div>
          <div class="form-group">
             <textarea class="form-control compose-textarea" style="height: 300px"></textarea>
          </div>
          <div class="form-group">
            <div class="btn btn-default btn-file">
              <i class="fa fa-paperclip"></i> Attachment
              <input type="file" name="attachment" v-on:change="newKeep.attachment" multiple >
            </div>
            <p class="help-block">Max. 32MB</p>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <div class="pull-right">
            <button type= "button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Cancelar</button>
            <button type="button" class="btn btn-primary" v-on:click.prevent="send_correo()" {{$email}}><i class="fa fa-envelope-o"></i> Enviar</button>
          </div>
          <!-- <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button> -->
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /. box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
