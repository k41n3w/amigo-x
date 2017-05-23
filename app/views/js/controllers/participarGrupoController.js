ocApp.controller('participarGrupoController', function ($http, BASEURL, $scope, $window, $rootScope, toastr) {
    $scope.search = {
        name: ''
    };

    $scope.grupo = function (idgroup) {
        $rootScope.idGroup = idgroup.idgroup;
        $rootScope.nameGroup = idgroup.name;
        console.log($rootScope.idGriup);
    };

    $scope.searchResult = function () {
        var url = BASEURL + 'grupo/listar-grupo';
        var config = {
            headers: { 'Content-Type': 'application/json;charset=utf-8;' }
        };
        if ($scope.search.name === undefined) {
          $scope.search.name = '';
        }
        console.log($scope.search);
        $http.post(url, $scope.search, config).success(function (data) {
            console.log(data);
            if (data.codigo == 1) {
                $scope.gridOptions.data = data.retorno;
            }else{
                $scope.gridOptions.data = '';
            }

        }).error(function (error) {
            $scope.gridOptions.data = '';
        });
    };

    $scope.entrarGrupo = function () {
        var url = BASEURL + 'groups-in/cadastrar-usuario-grupo';
        var config = {
            headers: { 'Content-Type': 'application/json;charset=utf-8;' }
        };

        $scope.inGroup = {
          'idgroup': $rootScope.idGroup
        };
        console.log($scope.inGroup);
        $http.post(url, $scope.inGroup, config).success(function (data) {
            console.log(data);
            if (data.codigo === 0) {
                toastr.error('Erro ao entrar no grupo.');
            }else{
                toastr.success('Parabéns agora você faz parte do grupo.');
            }
        }).error(function (error) {

        });
    };

    $scope.gridOptions = {
        enableSorting: true,
        paginationPageSizes: [10, 50, 75],
        paginationPageSize: 10,
        enableVerticalScrollbar: 0,
        rowHeight:35,
        rowTemplate:'<div ng-repeat="col in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ui-grid-cell></div></div>',
        columnDefs: [
            {
                field: 'idgroup',
                displayName: 'Participar',
                enableColumnMenu: false,
                enableSorting: false,
                cellTemplate:'<a role="button" data-toggle="modal" data-target="#modalEntrarGrupo" class="table-icon" data-tipo="Editar" ng-click="grid.appScope.grupo(row.entity)" data-keyboard="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>',
                width: 120
            },
            { field: 'name', displayName: 'Nome', minWidth:200 },
        ],
          data: []
    };

});
