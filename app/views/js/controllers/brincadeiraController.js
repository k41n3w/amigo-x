ocApp.controller('brincadeiraController', function ($http, $scope, toastr, BASEURL, $location, $window, $rootScope) {
  $scope.user = {
      name: ''
  };
  $rootScope.idgroup = $window.localStorage.getItem('idgroup');
  console.log($rootScope.idgroup);
  $scope.mostrarAmigosFim = false;
  $scope.mostrarAmigosIn = false;
  $scope.count = 0;

if ($rootScope.modal === 0) {
    $window.location.reload();
    $rootScope.modal = 1;
}

  $scope.brincadeira = function () {
      var url =  BASEURL + 'sorteio/listar-sorteio-grupo';
      var config = {
          headers: {'Content-Type': 'application/json'}
      };

      idGroup = {
          idgroup: $rootScope.idgroup
      };
console.log($rootScope.idgroup);
      $http.post(url, idGroup, config).success(function (response) {
          console.log(response);
          if (response.codigo == 1) {
              $scope.amigosSorteados =response.retorno;
              $scope.mostrarAmigos = true;

              $scope.origem = $scope.amigosSorteados[0].origem;
              $scope.destino = $scope.amigosSorteados[0].destino;
          } else {
              toastr.error(response.retorno, 'Erro');
          }
      }).error(function (error) {
        //  console.log(error);
      });
  };

  $scope.proximo = function () {

    var localCount = $scope.count;
    if (localCount + 1 < $scope.amigosSorteados.length){
      $scope.origem = $scope.amigosSorteados[localCount +1].origem;
      $scope.destino = $scope.amigosSorteados[localCount + 1].destino;
    }else{
        $scope.mostrarAmigosIn = true;
        $scope.mostrarAmigosFim = true;
    }
    $scope.count ++;
  };


});
