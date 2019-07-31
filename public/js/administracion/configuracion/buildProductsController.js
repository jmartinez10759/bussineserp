const URL = {
  url_insert           : "products/register"
  ,url_update          : "products/update"
  ,url_edit            : "products/{id}/edit"
  ,url_destroy         : "products/{id}/destroy"
  ,url_all             : "products/all"
  ,url_edit_tasa       : "tasa/{factorId}/tasaByFactor"
  ,url_edit_taxes      : "taxes/{tasaId}/taxesByTasa"
  ,url_upload          : 'upload/files'
};

app.controller('ProductsController', ['ServiceController','FactoryController','NotificationsFactory','$scope', function( sc,fc,nf,$scope ) {

    $scope.constructor = function(){
        $scope.datos    = [];
        $scope.insert   = {estatus: 1};
        $scope.update   = {};
        $scope.fields   = {};
        $scope.index();
        $scope.register = [];
        $scope.titles   = [
            "Categorias",
            "Codigo Producto",
            "Unidad de Medida",
            "Producto",
            "Stock",
            "SubTotal",
            "Total",
            "Estatus" ,
            ""
        ];
    };

    $scope.index = function(){
        var url = fc.domain( URL.url_all );
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                console.log(response.data.data);
                $scope.register = [];
                angular.forEach(response.data.data.products,function (value,key) {
                    $scope.register[key] = {
                        'id'        : value.id ,
                        'categories': (value.categories) ? value.categories.nombre : '' ,
                        'keys'      : value.codigo ,
                        'units'     : (value.units)? value.units.clave+' - '+value.units.descripcion : '' ,
                        'products'  : value.nombre ,
                        'stock'     : value.stock ,
                        'subtotal'  : '$ '+value.subtotal.toLocaleString(),
                        'total'     : '$ '+value.total.toLocaleString() ,
                        'estatus'   : value.estatus ,
                        'btnDelete' : ""
                    };
                });
                $scope.datos         = {"titles" : $scope.titles, "register" : $scope.register};
                $scope.cmbUnits      = response.data.data.units;
                $scope.cmbServices   = response.data.data.services;
                $scope.cmbCategories = response.data.data.categories;
                $scope.cmbFactorType = response.data.data.factorType;
                $scope.cmbTasas      = response.data.data.tasas;
            }
        });

    };

    $scope.insertRegister = function(){
        var url = fc.domain( URL.url_insert );
        var fields = $scope.insert;
        var validation = {
            'CODIGO'       : $scope.insert.codigo
            ,'PRODUCTO'    : $scope.insert.nombre
            ,'DESCRIPCION'  : $scope.insert.descripcion
        };

        if( nf.fieldsValidation(validation)){
            $scope.spinning = true;
            sc.requestHttp(url,fields,"POST",false).then(function (response) {
                if (sc.validateSessionStatus(response)){
                    nf.toastInfo(response.data.message, nf.titleMgsSuccess);
                    nf.modal("#modal_add_register",true);
                    $scope.constructor();
                }
                $scope.spinning = false;
            });
        }
    };

    $scope.updateRegister = function(){
        var url = fc.domain( URL.url_update );
        var fields = $scope.update;
        var validation = {
             'CODIGO'       : $scope.update.codigo
            ,'PRODUCTOS'    : $scope.update.nombre
            ,'DESCRIPCION'  : $scope.update.descripcion
        };

      if( nf.fieldsValidation(validation)){
          $scope.spinning = true;
          sc.requestHttp(url,fields,"PUT",false).then(function (response) {
              if (sc.validateSessionStatus(response)){
                  nf.toastInfo(response.data.message, nf.titleMgsSuccess);
                  nf.modal("#modal_edit_register",true);
                  nf.trEffect($scope.update.id);
                  $scope.index();
              }
              $scope.spinning = false;
          });
      }

    };

    $scope.editRegister = function(id){

        var url = fc.domain(URL.url_edit,id);
        sc.requestHttp(url,null,"GET",false).then(function (response) {

            var datos = ['categories','units','updated_at','created_at','$$hashKey','pivot'];
            $scope.update = sc.mapObject(response.data.data, datos);
            $scope.update.companyId = angular.isDefined($scope.update.companies[0])?$scope.update.companies[0].id : "";
            $scope.getGroupByCompany($scope.update.companyId);
            $scope.update.groupId = [];
            angular.forEach($scope.update.groups,function (value, key) {
                $scope.update.groupId[key] = value.id;
            });
            $scope.getTasas($scope.update.id_tipo_factor);
            $scope.getTaxes($scope.update.id_tasa,true);
            nf.modal("#modal_edit_register");
            console.log($scope.update);

        });

    };

    $scope.destroyRegister = function( id ){
      var url = fc.domain( URL.url_destroy,id );
        nf.buildSweetAlertOptions("¿Borrar Registro?", "¿Realmente desea eliminar el registro?", "warning", function () {
            sc.requestHttp(url, null, "DELETE", false).then(function (response) {
                if (sc.validateSessionStatus(response)) {
                    nf.toastSuccess(response.data.message, nf.titleMgsSuccess);
                    $scope.index();
                }
            });
        }, null, "SI", "NO");
    
    };

    $scope.totalConcepts = function(subTotal, taxIva, update){
        var iva = (taxIva) ? taxIva : 0;
        var subtotal = (subTotal) ? subTotal : 0;
        console.log(iva);
        console.log(subtotal);
        var taxes = parseFloat( subtotal * iva );
        var result = parseFloat(parseFloat( subtotal ) + parseFloat(taxes)).toFixed(2);
        if (update){
            $scope.update.total = result;
        } else {
            $scope.insert.total = result;
        }
        console.log(result);
    
    };

    $scope.getTasas = function(factorId){
      var url = fc.domain( URL.url_edit_tasa, factorId );
      sc.requestHttp(url,null,"GET",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                $scope.cmbTasas = response.data.data;
                console.log(response.data.data);
            }
      });
    
    };

    $scope.getTaxes = function(tasaId,update){
      var url = fc.domain( URL.url_edit_taxes, tasaId );
      sc.requestHttp(url,null,"GET",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                $scope.cmbTaxes = response.data.data.taxes;
                var subtotal = 0;
                if (update) {
                    $scope.update.iva = response.data.data.valor_maximo;
                    $scope.update.id_impuesto = ($scope.cmbTaxes)? $scope.cmbTaxes[0].id:"";
                    subtotal = $scope.update.subtotal;
                }else{
                    $scope.insert.iva = response.data.data.valor_maximo;
                    $scope.insert.id_impuesto = ($scope.cmbTaxes)? $scope.cmbTaxes[0].id:"";
                    subtotal = $scope.insert.subtotal;
                }
                $scope.totalConcepts(subtotal,response.data.data.valor_maximo,update);
                console.log(response.data.data);
            }
      });

    };

    $scope.fileUpload = function(update){

      var uploadUrl = fc.domain( URL.url_upload );
      var identify = {
        div_content   : 'fileProducts',
        div_dropzone  : 'dropzoneFileProducts',
        file_name     : 'file'
      };
        var message = "Dar Clíc aquí o arrastrar archivo";
        $scope.update.logo = "";
        uploadFile({'name': 'products_'+$scope.update.id },uploadUrl,message,1,identify,'.png, .jpg',function( request ){
            console.log(request.data);
            var image = request.data[0]+"?version="+Math.random();
            if(update){
                $scope.update.logo = image;
                console.log($scope.update.logo);
                /*var html = '';
                html = '<img class="img-responsive" src="'+$scope.update.logo+'?'+Math.random()+'" height="268px" width="200px">'
                jQuery('#imagen_edit').html("");
                jQuery('#imagen_edit').html(html);        */
            }else{
                $scope.insert.logo = image;
                /*var html = '';
                html = '<img class="img-responsive" src="'+$scope.insert.logo+'" height="268px" width="200px">'
                jQuery('#imagen').html("");
                jQuery('#imagen').html(html);*/
            }
              jQuery.fancybox.close({
                  'type'      : 'inline'
                  ,'src'      : "#upload_file"
                  ,'modal'    : true
              });
      });
          jQuery.fancybox.open({
              'type'      : 'inline'
              ,'src'      : "#upload_file"
              ,'modal'    : true
          });
    }

}]);
