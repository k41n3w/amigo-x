var ocApp = angular.module('ocApp', ['ngRoute', 'angularFileUpload', 'blockUI', 'toastr', 'ui.grid', 'ui.grid.pagination', 'ui.grid.autoResize', 'ui.grid.selection', 'ui.utils.masks', 'ui.grid.pinning', 'ui.grid.exporter'])
    .run(function($rootScope, $location, BASEURL, AuthService, $window, toastr) {
        $rootScope.$on('$routeChangeStart', function(event, next, current) {
            toastr.clear();
            // Verifica se existe um token ativo, caso negativo, redireciona de volta
            // para o login.
            // if (!AuthService.isAuthed()) {
            //     $location.path('/login');
            // }
            /*
             * Salva os dados do usuário da localStorage no rootScope para ser utilizado
             * pelo sistema.
             */

            $rootScope.userId = $window.localStorage.getItem('userId');
            $rootScope.userNome = $window.localStorage.getItem('userNome');

        });
    });

// Constante com a URL da aplicação // Altere para que atenda seu local de instalação
ocApp.constant('BASEURL', 'http://localhost/amigo-x/api/');

/*
 * "Injeta" a factory 'AuthInterceptor' nas chamadas ao servidor.
 * Caso seja uma 'request', ele buscará o token e mandará no cabeçalho do post
 * Caso seja uma 'response', se houver um token, ele salva na localStorage
 * do navegador.
 */
ocApp.config(function($httpProvider) {
    $httpProvider.interceptors.push('AuthInterceptor');
});

// Rotas para páginas internas do aplicativo.
ocApp.config(function($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: 'pages/principal.html',
            controller: 'principalController'
        })
        .when('/dashboard', {
            templateUrl: 'pages/dashboard.html',
            controller: 'dashboardController'
        })
        .when('/login', {
            templateUrl: 'pages/login.html',
            controller: 'loginController'
        })
        .when('/cadastrar-usuario', {
            templateUrl: 'pages/cadastrar-usuario.html',
            controller: 'usuarioController'
        })
        .when('/editar-senha', {
            templateUrl: 'pages/editar-senha.html',
            controller: 'editarSenhaController'
        })
        .when('/principal', {
            templateUrl: 'pages/principal.html',
            controller: 'principalController'
        })
        .when('/novo-grupo', {
            templateUrl: 'pages/cadastrar-grupo.html',
            controller: 'grupoController'
        })
        .when('/participar-grupo', {
            templateUrl: 'pages/participar-grupo.html',
            controller: 'participarGrupoController'
        })
        .when('/cadastrar-produto', {
            templateUrl: 'pages/cadastrar-produto.html',
            controller: 'produtoController'
        })
        .when('/meus-desejos', {
            templateUrl: 'pages/meus-desejos.html',
            controller: 'meusDesejosController'
        })
        .when('/grupos-desejos', {
            templateUrl: 'pages/grupos-desejos.html',
            controller: 'gruposDesejosController'
        })
        .when('/meus-produtos', {
            templateUrl: 'pages/meus-produtos.html',
            controller: 'meusProdutoController'
        })
        .when('/brincadeira', {
            templateUrl: 'pages/brincadeira.html',
            controller: 'brincadeiraController'
        })
        .otherwise({
            redirectTo: '/login'
        });
});

// opções do toastr message
ocApp.config(function(toastrConfig) {
    angular.extend(toastrConfig, {
        "positionClass": "toast-bottom-right",
        "closeButton": true,
        "maxOpened": 1,
        "extendedTimeOut": 5000
    });
});

ocApp.config(function(blockUIConfig) {

  blockUIConfig.message = '';
  blockUIConfig.template = '<div class="block-ui-overlay"></div><div class="block-ui-message-container" aria-live="assertive" aria-atomic="true"><div class="block-ui-message"><div class="loading text-center"><h6>Aguarde</h6><span></span><span></span><span></span></div></div></div>';

});

/*retorna o tamanho do arquivo*/
ocApp.filter('bytes', function() {
    return function(bytes, precision) {
        if (isNaN(parseFloat(bytes)) || !isFinite(bytes)) {
            return '-';
        }
        if (typeof precision === 'undefined') {
            precision = 1;
        }
        var units = ['bytes', 'kB', 'MB', 'GB', 'TB', 'PB'],
            number = Math.floor(Math.log(bytes) / Math.log(1024));

        return (bytes / Math.pow(1024, Math.floor(number))).toFixed(precision) + ' ' + units[number];
    };
});

// factory com funcoes para conversao de dados
ocApp.factory('Format', function() {
    return {
        toInt: function(value) {
            if (Number.isInteger(value)) {
                return value;
            }
            return parseInt(value);
        },
        convertePrazo: function (valor, limite) {
            var prazo = String(valor).replace(/[^0-9]+/, '');
            var quantCaracteres = prazo.length;

            if (quantCaracteres === 0) {
                return '';
            }
            return Number((quantCaracteres > limite) ? prazo.slice(0, limite) : prazo);
        }
    };
});

/*
 * Funções de Login
 */

ocApp.factory('AuthInterceptor', function(BASEURL, AuthService) {
    return {
        request: function(config) {
            var token = AuthService.getToken();
            if (config.url.indexOf(BASEURL) === 0 && token) {
                config.headers.Authorization = 'Bearer ' + token;
            }
            return config;
        },
        response: function(res) {
            if (res.config.url.indexOf(BASEURL) === 0 && res.data.retorno.token) {
                AuthService.saveToken(res.data.retorno.token);
            }
            return res;
        }
    };
});

ocApp.service('AuthService', function($window, $location, $rootScope) {
    // Metodos do JWT
    this.parseJwt = function(token) {
        var base64Url = token.split('.')[1];
        var base64 = base64Url.replace('-', '+').replace('_', '/');
        return JSON.parse($window.atob(base64));
    };
    this.saveToken = function(token) {
        $window.localStorage.setItem('jwtToken', token);
    };
    this.getToken = function() {
        return $window.localStorage.getItem('jwtToken');
    };
    this.isAuthed = function() {
        var token = this.getToken();
        if (token) {
            var params = this.parseJwt(token);
            return params;
        } else {
            return false;
        }
    };

    this.logout = function() {
        delete $rootScope.userId;
        delete $rootScope.userNome;
        $window.localStorage.clear();
        $location.path('/login');
    };
});
