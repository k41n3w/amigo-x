ocApp.controller('gruposDesejosController', function ($http, $scope, toastr, BASEURL, $location, $rootScope) {
  $scope.listarMeusDesejos = function () {
      var url = BASEURL + 'desejo/grupos-desejo';
      var config = {
          headers: { 'Content-Type': 'application/json;charset=utf-8;' }
      };
      console.log($scope.venda);
      $http.post(url, $scope.venda, config).success(function (data) {
          console.log(data);
          if (data.codigo === 0) {
              toastr.error('Erro ao Listar Desejos.');
              $scope.gridOptions.data = '';
          }else{
            $scope.gridOptions.data = data.retorno;
          }
      }).error(function (error) {

      });
  };
$scope.listarMeusDesejos();
    $scope.gridOptions = {
        enableSorting: true,
        paginationPageSizes: [10, 50, 75],
        paginationPageSize: 10,
        enableVerticalScrollbar: 0,
        rowHeight:35,
        rowTemplate:'<div ng-class="{ inativo : row.entity.inativo==true }"> <div ng-repeat="col in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ui-grid-cell></div></div>',
        columnDefs: [
            { field: 'description', displayName: 'Descrição', minWidth:200 },
            { field: 'value', displayName: 'Preço', minWidth:200 },
            { field: 'username', displayName: 'Amigo', minWidth:200 },
            { field: 'gruponame', displayName: 'Grupo', minWidth:200 },
        ],
          data: []
    };

});
