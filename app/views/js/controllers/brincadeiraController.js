ocApp.controller('brincadeiraController', function ($http, $scope, toastr, BASEURL, $location, $window, $rootScope) {
  $scope.user = {
      name: ''
  };

if ($rootScope.modal === 0) {
    $window.location.reload();
    $rootScope = 1;
}

  $scope.brincadeira = function () {
      var url =  BASEURL + 'sorteio/listar-sorteio-grupo';
      var config = {
          headers: {'Content-Type': 'application/json'}
      };

      idGroup = {
          idgroup: $rootScope.idgroup
      };

      $http.post(url, idGroup, config).success(function (response) {
          console.log(response);
          if (response.codigo == 1) {
              $scope.mostrarAmigos = true;
          } else {
              toastr.error(response.retorno, 'Erro');
          }
      }).error(function (error) {
          console.log(error);
      });
  };


});
