ocApp.controller('dashboardController', function ($http, $location, BASEURL, $scope, $window, $rootScope, toastr) {
//$scope.Nome = $window.localStorage.getItem('userNome');

$scope.search = {
  meusGrupos: '',
  grupoParticipante: ''
}

$scope.pesquisar = function(opcao) {
    var url = '';
    url = BASEURL + 'grupo/listar-grupo-dashboard';
    if (opcao === '1'){
      var dadosConsulta = {
        name: $scope.search.meusGrupos,
        tipo: 1
      };
    }else{
      var dadosConsulta = {
        name: $scope.search.grupoParticipante,
        tipo: 2
      };
    }
    var config = {
        headers: { 'Content-Type': 'application/json;charset=utf-8;' }
    };
    console.log(dadosConsulta);
    $http.post(url, dadosConsulta, config).success(function (data) {
      console.log(data);
        if (data.codigo === 1){
          console.log(dadosConsulta.tipo);
            if ( dadosConsulta.tipo == '2'){
              console.log('gridGruposParticipantes');
                $scope.gridGruposParticipantes.data = data.retorno;
            }else{
              console.log('gridMeusGrupos');
                $scope.gridMeusGrupos.data = data.retorno;
            }
        }else{

        }
    }).error(function (error) {

    });
};

$scope.sortear = function(opcao) {
    url = BASEURL + '';
    var config = {
        headers: { 'Content-Type': 'application/json;charset=utf-8;' }
    };

    console.log(dadosConsulta);
    $http.post(url, dadosSorteio, config).success(function (data) {
      console.log(data);
        if (data.codigo === 1){

        }else{

        }
    }).error(function (error) {

    });
};

$scope.brincadeira = function(opcao) {
    url = BASEURL + '';
    var config = {
        headers: { 'Content-Type': 'application/json;charset=utf-8;' }
    };

    console.log(dadosConsulta);
    $http.post(url, dadosSorteio, config).success(function (data) {
      console.log(data);
        if (data.codigo === 1){

        }else{

        }
    }).error(function (error) {

    });
};

$scope.gridMeusGrupos = {
    enableSorting: true,
    paginationPageSizes: [10, 50, 75],
    paginationPageSize: 10,
    enableVerticalScrollbar: 0,
    rowHeight:35,
    rowTemplate:'<div ng-class="{ danger : isOverdue(row), info : row.entity.nomestatus == &quot;Concluído&quot;, success : row.entity.nomestatus == &quot;Aberto&quot;, refused : row.entity.nomestatus == &quot;Recusado&quot;  }"> <div ng-repeat="col in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ui-grid-cell></div></div>',

    columnDefs: [
        {
            field: 'idgroup',
            displayName: 'Acompanhar',
            enableColumnMenu: false,
            enableSorting: false,
            cellTemplate:'<a role="button" ng-click="" data-toggle="modal" data-target="#modalMeuGrupo" class="table-icon"><i class="fa fa-eye" aria-hidden="true"></i></a>',
            width: 100
        },
        { field: 'name', displayName: 'Nome', width: 400 },
    ],
      data: []
};

$scope.gridGruposParticipantes = {
  enableSorting: true,
  paginationPageSizes: [10, 50, 75],
  paginationPageSize: 10,
  enableVerticalScrollbar: 0,
  rowHeight:35,
  rowTemplate:'<div ng-class="{ danger : isOverdue(row), info : row.entity.nomestatus == &quot;Concluído&quot;, success : row.entity.nomestatus == &quot;Aberto&quot;, refused : row.entity.nomestatus == &quot;Recusado&quot;  }"> <div ng-repeat="col in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ui-grid-cell></div></div>',

  columnDefs: [
      {
          field: 'idgroup',
          displayName: 'Acompanhar',
          enableColumnMenu: false,
          enableSorting: false,
          cellTemplate:'<a role="button" ng-click="" data-target="#modalComprar" class="table-icon"><i class="fa fa-eye" aria-hidden="true"></i></a>',
          width: 100
      },
      { field: 'name', displayName: 'Nome', width: 400 },
  ],
    data: []
};
});
