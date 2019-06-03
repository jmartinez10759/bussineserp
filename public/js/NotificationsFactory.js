app.factory("NotificationsFactory",["sweetAlert","toastr","swangular", function (sweetAlert,toastr,swangular) {


    function NotificationsFactory() {
        this.alert = sweetAlert.swal;
        this.swangular = swangular.open;
        this.checkType = function(type) {
            return type === 'success' ? "¡Éxito!" :
                (type === "error" ? "¡Error!" :
                    (type === "info" ? "¡Vaya!" : "Aviso"));
        };
    };

    NotificationsFactory.prototype.titleMgsSuccess     = "Registros Correctos";
    NotificationsFactory.prototype.titleMgsError       = "Registros Incorrectos";
    NotificationsFactory.prototype.titleMgsUpdate      = "Registro actualizado corretamente";
    NotificationsFactory.prototype.titleRegisterSuccess= "Registro insertado corretamente.";
    NotificationsFactory.prototype.titleRegisterError  = "Ocurrio un error, Favor de verificar";
    NotificationsFactory.prototype.validateRegister    = "Favor de Verificar los campos color Rojo";
    NotificationsFactory.prototype.sessionExpired      = "Expiro su sesión, favor de ingresar al portal";
    NotificationsFactory.prototype.contentType         = 'application/json';

    NotificationsFactory.prototype.buildSweetAlert = function(msg,type,timer) {
        var title = this.checkType(type);

        this.alert({
            title: title,
            type: type,
            html: msg,
            timer: timer ? timer : 2000,
            showConfirmButton: false,
            allowOutsideClick: false
        });
    };

    NotificationsFactory.prototype.buildSweetAlertOptions = function (title,msg,type,successCallback,dismissCallback,confirm_button_text,dismiss_button_text) {
        this.alert({
            title: title,
            type: type,
            html: msg,
            showCancelButton: true,
            buttonsStyling: true,
            confirmButtonClass: "btn btn-success",
            cancelButtonClass: "btn btn-danger",
            confirmButtonText: angular.isDefined(confirm_button_text) && confirm_button_text !== null ? confirm_button_text : "Aceptar",
            cancelButtonText: angular.isDefined(dismiss_button_text) && dismiss_button_text !== null ? dismiss_button_text : "Cancelar",
            allowOutsideClick: false,
            closeOnConfirm: true,
            closeOnCancel: true
        }).then(function(result) {
            if (angular.isDefined(result.value) && result.value) {
                successCallback();
            } else if(dismissCallback !== null) {
                dismissCallback();
            }
        });
    };

    NotificationsFactory.prototype.toastError = function(msg,title) {
        toastr.error(msg,title);
    };

    NotificationsFactory.prototype.toastSuccess = function(msg, title) {
        toastr.success(msg, title);
    };

    NotificationsFactory.prototype.toastInfo = function(msg, title) {
        toastr.info(msg,title);
    };

    NotificationsFactory.prototype.toastWarning = function(msg, title) {
        toastr.warning(msg,title);
    };

    NotificationsFactory.prototype.modal = function (identifier,hide) {
        if (identifier){
            var modalId = $(identifier);
            if (hide){
                modalId.modal('hide');
            }else{
                modalId.modal({keyboard: false, backdrop: "static"});
            }
        }
    };

    NotificationsFactory.prototype.trEffect = function(id,time){
        var time = (time)? time: 8000;
        jQuery('#tr_' + id).effect("highlight", {}, time);
    };


    return new NotificationsFactory();
}]);