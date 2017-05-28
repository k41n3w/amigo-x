ocApp.controller('usuarioController', function ($http, $scope, toastr, BASEURL, $location) {
  $scope.user = {
      login: '',
      password: '',
      name: ''
  };

  $scope.cadastrar = function () {
    var texto = $('.btn-login').html();
    $('.btn-login').html('<span class="ajaxloader"></span>');
      $scope.submitted = true;
      var url =  BASEURL + 'usuario/cadastrar-usuario';
      var config = {
          headers: {'Content-Type': 'application/json'}
      };
      //console.log($scope.user);
      $http.post(url, $scope.user, config).success(function (response) {
          //console.log(response);
          if (response.codigo == 1) {
              toastr.success(response.retorno);
              $location.path('/login');
          } else {
              toastr.error(response.retorno, 'Erro');
          }
          $('.ajaxloader').remove();
          $('.btn-login').html(texto);
          $('.ajaxloader').remove();
          $('.btn-login').html(texto);
      }).error(function (error) {
          //console.log(error);return;
          toastr.error(error.message, 'Erro');
          $('.ajaxloader').remove();
          $('.btn-login').html(texto);
          $('.ajaxloader').remove();
          $('.btn-login').html(texto);
      });
  };
    
});
