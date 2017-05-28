ocApp.controller('meusProdutoController', function ($http, $scope, toastr, BASEURL, $location, $rootScope) {
  $scope.produto = {
      description: '',
      value: ''
  };

  $scope.searchProdutos = function () {
      var url =  BASEURL + 'produto/meus-produtos';
      var config = {
          headers: {'Content-Type': 'application/json'}
      };
      if ($scope.produto.description === '' || $scope.produto.description === undefined || $scope.produto.description === null) {
        $scope.produto.description = '';
      }
      console.log($scope.produto);
      $http.post(url, $scope.produto, config).success(function (data) {
          console.log(data.retorno);
          if (data.codigo == 1) {
              $scope.gridOptions.data = data.retorno;
          } else {
              toastr.error(data.retorno, 'Erro');
              $scope.gridOptions.data = '';
          }
      }).error(function (error) {
          console.log(error);
          $scope.gridOptions.data = '';
      });
  };
  $scope.searchProdutos();
    $scope.gridOptions = {
        enableSorting: true,
        paginationPageSizes: [10, 50, 75],
        paginationPageSize: 10,
        enableVerticalScrollbar: 0,
        rowHeight:35,
        rowTemplate:'<div ng-class="{ inativo : row.entity.inativo==true }"> <div ng-repeat="col in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ui-grid-cell></div></div>',
        columnDefs: [
            { field: 'description', displayName: 'Descrição', minWidth:200 },
            { field: 'value', cellFilter: 'currency', displayName: 'Preço', minWidth:200 },
        ],
          data: []
    };

});
