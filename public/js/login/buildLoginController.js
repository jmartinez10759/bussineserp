const URL = {
    url_edit    : 'login'
};

app.controller('LoginController', ['ServiceController','FactoryController','NotificationsFactory','$scope',"$timeout", function( sc,fm,nf,$scope,time ) {

    $scope.constructor = function () {
        $scope.datos    = [];
        $scope.serching = false;
        $scope.enabled  = false;
        $scope.randomImages()
    };

    $scope.startSession = function () {
        let url = fm.domain(URL.url_edit);
        let fields = {
            "email"     : $scope.datos.email.trim().toLowerCase() ,
            "password"  : sha1($scope.datos.password)
        };
        $scope.enabled  = true;
        $scope.serching = true;
        sc.requestHttp(url, fields, 'POST', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                redirect(response.data.data.ruta);
            }
            $scope.enabled  = false;
            $scope.serching = false;
        });
    };

    $scope.randomImages = function () {


    };

}]);



/*new Vue({
  el: "#login-block",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {
      'email' : ""
      ,'password': ""
    },
    fillKeep: {
      'email' : ""
      ,'password': ""
    },

  },
  mixins : [mixins],
  methods:{
    consulta_general: function(){
      //alert();
    }
    ,inicio_sesion: function(){

        var url = domain( "login" );
        this.newKeep.email.trim().toLowerCase();
        this.newKeep.password = sha1( this.newKeep.password.trim() );
        jQuery("*").css("cursor", "wait");
        var response = MasterController.method_master(url,this.newKeep,"post");
        response.then(response => {
            toastr.info(response.data.message , title );
            redirect( domain( response.data.result.ruta ) );
        }).catch(error => {
            if( error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect();
                return;
            }
          toastr.error(error.response.data.message, error.response.data.error.description);
          for (var i in this.newKeep) {
            this.newKeep[i] = "";
          }
          jQuery("*").css("cursor", "default");
          jQuery('#correo').parent().parent().addClass('has-error');
          jQuery('#password').parent().parent().addClass('has-error');
        });

    }

  }


});*/
