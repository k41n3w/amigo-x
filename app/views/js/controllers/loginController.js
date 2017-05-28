ocApp.controller('loginController', function ($http, $scope, $rootScope, $window, $location, toastr, BASEURL, AuthService) {

    $scope.user = {
        strLogin: '',
        strSenha: ''
    };

    if (AuthService.isAuthed()) {
        $location.path('/');
    }


    $scope.login = function () {
      var texto = $('.btn-login').html();
      $('.btn-login').html('<span class="ajaxloader"></span>');
        $scope.submitted = true;
        var url = BASEURL + 'usuario/login';
        JSON.stringify(url);
        var config = {
            headers: {'Content-Type': 'application/json'}
        };
      //  console.log($scope.user);
        $http.post(url, $scope.user, config).success(function (response) {
          //  console.log(response);
            if ($scope.verificaToken(response.retorno.token)) {
                AuthService.saveToken(response.retorno.token);
                $scope.salvaUsuarioDepto(response.retorno.userNome, response.retorno.userId);
                $location.path('/dashboard');
            } else if (response.codigo == 0) {
                toastr.error(response.retorno, 'Login Inválido');
            }
            $('.ajaxloader').remove();
            $('.btn-login').html(texto);
            $('.ajaxloader').remove();
            $('.btn-login').html(texto);
        }).error(function (error) {
          //  console.log(error);return;
            toastr.error(error.message, 'Login Inválido');
            $('.ajaxloader').remove();
            $('.btn-login').html(texto);
            $('.ajaxloader').remove();
            $('.btn-login').html(texto);
        });
    };

    $scope.verificaToken = function (res) {
        var token = res ? res : false;
        if (typeof res === "string") {
            if (localStorage.getItem('jwtToken') !== null) {
                return true;
            } else {
                AuthService.logout();
                return false;
            }
        } else {
            return false;
        }
    };

    $scope.salvaUsuarioDepto = function (userNome, userId) {
        $window.localStorage.setItem('userNome', userNome);
        $window.localStorage.setItem('userId', userId);
    };

    function getId(id, source) {
        for (var index = 0, max = source.length; index < max; index++) {
            if (source[index].id === id) {
                return index;
            }
        }
        return undefined;
    }
    $scope.cadastro = function () {
        $location.path('/cadastrar-usuario');
    };
});
