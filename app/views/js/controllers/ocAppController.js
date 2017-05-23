ocApp.controller('ocAppController', function($scope, $window, toastr, $location, AuthService, BASEURL) {

    // $scope.objresponsavel = JSON.parse(localStorage.getItem('objresponsavel'));

    $scope.goToView = function(id){
        $window.localStorage.setItem('idsetor', id);
        $location.path('/dashboard-setor');
    };

    $scope.activeLink = function() {
        if (Timeline.getDeptoId() !== null) {
            return true;
        } else {
            return false;
        }
    };

    $scope.HeaderController = function($scope, $location) {
        $scope.isActive = function(viewLocation) {
            return viewLocation === $location.path();
        };
    };

    $scope.$on('$viewContentLoaded', function() {
        // vir o nome certo do modal, se é cadastrar ou editar
        $('#modalInserirEditar').on('show.bs.modal', function (event) {
            var recipient = $(event.relatedTarget).data('tipo');
            $(this).find('.modalTipo').text(recipient);
        });

        //coloca focus no primeiro campo do modal de inserir e editar, para que assim o modal possa ser fechado com o "esc"
        $(window.document).on('shown.bs.modal', '#modalInserirEditar', function() {
            window.setTimeout(function() {
                $(this).find('input:first').focus();
            }.bind(this), 100);
        });

        // mostra e esconde filtro de acordo com o select
        $('#lstBuscaFiltro').change(function() {
            var option = $(this).val();

            $('.filtro.open').fadeOut().fadeOut( "fast", function() {
                $(this).removeClass('open');
                $('#filtro-'+option).fadeIn().addClass('open');
            });
        });

        $(document).tooltip({
            selector: '[data-toggle="tooltip"]'
        });

        $('.datepicker').datetimepicker({
            locale: 'pt-br',
            viewMode: 'days',
            format: 'DD/MM/YYYY'
        });

        $(".datepicker input").mask("99/99/9999");

        $('.timepicker').datetimepicker({
            format: 'HH:mm'
        });

        $(".timepicker input").mask("99:99");

        var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

        // quando for celular, fechar o menu quando clicar em um link do menu
        var tam = $(window).width();

        if (tam < 800) {
            $(".second-nav li").each(function() {
                $(this).addClass("close-menu");
            });
        } else {
            $(".second-nav li").each(function() {
                $(this).removeClass("close-menu");
            });
        }

        $('.close-menu').on("click", function() {
            $('#sidebar').removeClass('active');
        });

        $('.second-nav a').on("click", function() {
            toastr.clear();
        });

    });

    /*
     * Logout no Header
     */
    $scope.doLogout = function() {
        AuthService.logout();
    };

    // $scope.tab_permission = [];
    //
    // $scope.$on('loadPermissions', function (event, data) {
    //     $scope.tab_permission = data;
    // });
    //
    // $scope.hasAccess = function (idAccess) {
    //     if ($window.localStorage.getItem('userNome') === 'Administrador') {
    //         return true;
    //     }
    //
    //     if ($scope.tab_permission.length > 0) {
    //         // se o usuario for o Administrador nao realiza a verificacao
    //         var index = Source.getIndex(idAccess, $scope.tab_permission);
    //         return $scope.tab_permission[index].acesso;
    //     }
    // };
    //
    // $scope.hasAccessMenu = function (arrayMenus) {
    //     // se o usuario for o Administrador nao realiza a verificacao
    //     if ($window.localStorage.getItem('userNome') === 'Administrador') {
    //         return true;
    //     }
    //
    //     var numeroAcessos = 0;
    //     for (var index = 0, length = arrayMenus.length; index < length; index++) {
    //         if ($scope.hasAccess(arrayMenus[index]) === false) {
    //             numeroAcessos++;
    //         }
    //     }
    //
    //     if (numeroAcessos === arrayMenus.length) {
    //         return false;
    //     }
    //
    //     return true;
    // };
});
