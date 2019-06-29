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
/**
 * Directive to generate popup
 */
app.directive('xeditable', ['$timeout', function ($timeout) {

    return {
        restrict: 'E',
        require: 'ngModel',
        scope: {
            ngModel: '=',
            placeholder: '@',
            title: '@'
        },
        replace: true,
        template: "<a class='editable' href='javascript:;' data-type='text' data-placement='right'>{{ngModel}}</a>",
        link: function (scope, elem, attrs, ctrl) {
            var loadXeditable = function () {
                angular.element(elem).editable({
                    display: function (value, srcData) {
                        ctrl.$setViewValue(value);
                        scope.$apply();
                    },
                    success: function (response, newValue) {
                        scope.ngModel = newValue;
                        scope.$emit('editRegisterConcepts', scope.$parent.item);
                    },
                    placeholder: scope.placeholder
                });
            };
            $timeout(function () {
                loadXeditable();
            }, 10);
        }
    };

}]);