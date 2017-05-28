ocApp.controller('produtoController', function ($http, $scope, toastr, BASEURL, $location, $rootScope) {
  $scope.produto = {
      description: '',
      value: ''
  };

  $scope.compra = function (idgroup) {
      $rootScope.description = idgroup.description;
      $rootScope.idproducts = idgroup.idproducts;
      console.log($rootScope.idproducts);
  };

  $scope.cadastrar = function () {
      var url =  BASEURL + 'produto/cadastrar-produto';
      var config = {
          headers: {'Content-Type': 'application/json'}
      };
      console.log($scope.produto);
      // parseFloat($scope.produto.value);
      $http.post(url, $scope.produto, config).success(function (response) {
          console.log(response);
          if (response.codigo == 1) {
              toastr.success(response.retorno);
              $scope.produto.description = '';
              $scope.produto.value= '';
          } else {
              toastr.error(response.retorno, 'Erro');
          }
      }).error(function (error) {
          console.log(error);
          toastr.error(error.message, 'Erro');

      });
  };

  $scope.searchProdutos = function () {
      var url =  BASEURL + 'produto/listar-produtos';
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
          toastr.error(error.message, 'Erro');
          $scope.gridOptions.data = '';
      });
  };

  $scope.venderProduto = function () {
      var url = BASEURL + 'produto/comprar-produto';
      var config = {
          headers: { 'Content-Type': 'application/json;charset=utf-8;' }
      };

      $scope.venda = {
        'idproducts': $rootScope.idproducts
      };
      console.log($scope.venda);
      $http.post(url, $scope.venda, config).success(function (data) {
          console.log(data);
          if (data.codigo === 0) {
              toastr.error('Erro ao entrar no grupo.');
          }else{
              toastr.success('Produto adicionado a sua lista.');
          }
      }).error(function (error) {

      });
  };

  $scope.desejarProduto = function () {
      var url = BASEURL + 'produto/desejar-produto';
      var config = {
          headers: { 'Content-Type': 'application/json;charset=utf-8;' }
      };

      $scope.deseja = {
        'idproducts': $rootScope.idproducts
      };
      console.log($scope.deseja);
      $http.post(url, $scope.deseja, config).success(function (data) {
          console.log(data);
          if (data.codigo === 0) {
              toastr.error('Erro ao entrar no grupo.');
          }else{
              toastr.success('Este item acaba de entrar na sua lista de desejos.');
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
        rowTemplate:'<div ng-class="{ inativo : row.entity.inativo==true }"> <div ng-repeat="col in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ui-grid-cell></div></div>',
        columnDefs: [
            {
                field: 'idproducts',
                displayName: 'Comprar',
                enableColumnMenu: false,
                enableSorting: false,
                cellTemplate:'<a role="button" data-toggle="modal" data-target="#modalComprar" class="table-icon" data-tipo="Editar" ng-click="grid.appScope.compra(row.entity)" data-keyboard="true"><i class="fa fa-money" aria-hidden="true"></i></a>',
                width: 80
            },
            { field: 'description', displayName: 'Descrição', minWidth:200 },
            { field: 'value', cellFilter: 'currency', displayName: 'Preço', minWidth:200 },
            {
                field: 'idproducts',
                displayName: 'Desejar',
                enableColumnMenu: false,
                enableSorting: false,
                cellTemplate:'<a role="button" data-toggle="modal" data-target="#modalDesejar" class="table-icon" data-tipo="Editar" ng-click="grid.appScope.compra(row.entity)" data-keyboard="true"><i class="fa fa-heart-o" aria-hidden="true"></i></a>',
                width: 80
            },
        ],
          data: []
    };

});
