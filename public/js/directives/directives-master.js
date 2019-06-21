/**
 * Directive to generate image
 */
app.directive("imageLoad",function () {
    return {
        restrict: 'E',
        scope: {
            imageLogo: '=image'
        },
        templateUrl: 'js/tpl/image-load.html'
    };
});
/**
 * Directive to generate table main register of information
 */
app.directive("tableDashboard",function () {
    return {
        restrict: 'E',
        templateUrl: 'js/tpl/table-dashboard.html' ,
        controllerAs: "tableActionController"
    };
});

