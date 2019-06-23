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
        templateUrl: 'js/tpl/table-dashboard.html'
    };
});
/**
 * Directive to generate button update
 */
app.directive("buttonUpdate",function () {
    return {
        restrict: 'E',
        scope: {
            method: '&method' ,
            permission: '=permission' ,
            spinning: '=spinning'
        },
        templateUrl: 'js/tpl/button-update.html'
    };
});
/**
 * Directive to generate button register information
 */
app.directive("buttonRegister",function () {
    return {
        restrict: 'E',
        scope: {
            method: '&method' ,
            permission: '=permission' ,
            spinning: '=spinning'
        },
        templateUrl: 'js/tpl/button-register.html'
    };
});

