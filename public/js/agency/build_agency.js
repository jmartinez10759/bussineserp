const URL = {
    url_all              : "agency/all"
};

app.controller('AgencyCtrl', ['ServiceController','FactoryController','NotificationsFactory','$scope', function( sc,fc,nf,$scope ) {

    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.fields = {};
        $scope.index();
    };

    $scope.index = function(){
        /*$scope.datos = [
            {
                'start': '2020-10-02',
                'title': 'Cumpleaños Jorge'
            },
            {
                'start': '2020-09-09',
                'title': 'Cumpleaños Memo'
            },
            {
                'start': '2020-09-23',
                'title': 'Cumpleaños Lina'
            }
        ];*/
        let url = fc.domain( URL.url_all);
        sc.requestHttp(url,{},"GET",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                let i = 0;
                angular.forEach(response.data.data,function (value, key){
                        $scope.datos[i] = {
                            'start': value.created_at,
                            'title': value.comments
                        };
                        i++;
                });
                console.log(response.data.data);
                $('#calendar').fullCalendar({
                    themeSystem: 'bootstrap3',
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay,listMonth'
                    },
                    weekNumbers: true,
                    eventLimit: true,
                    events: $scope.datos
                });

            }
        });
    };

}]);
