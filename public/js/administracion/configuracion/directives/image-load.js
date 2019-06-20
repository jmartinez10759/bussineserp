/**
 * Directive to generate image
 */
app.directive("imageLoad",function () {
    return {
        restrict: 'E',
        scope: {
            imageLogo: '=image'
        },
        templateUrl: 'js/administracion/configuracion/tpl/image-load.html'
    };
});