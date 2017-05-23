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
      console.log($scope.user);
      $http.post(url, $scope.user, config).success(function (response) {
          console.log(response);
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
          console.log(error);return;
          toastr.error(error.message, 'Erro');
          $('.ajaxloader').remove();
          $('.btn-login').html(texto);
          $('.ajaxloader').remove();
          $('.btn-login').html(texto);
      });
  };
    //
    // $scope.reset = function () {
    //     $scope.objDados = {
    //         nome: '',
    //         idusuario: '',
    //         usuario: '',
    //         senha: '',
    //         senhaConfirma: '',
    //         setor: '',
    //         idsetor: '',
    //         iddepartamento: '',
    //         cargo: '',
    //         responsavel: '0',
    //         inativo: '0',
    //         ramal: '',
    //         email: '',
    //         celular: '',
    //         subnivel: '',
    //         id: 0,
    //         modo:'salvar'
    //     };
    // };
    //
    // $scope.search = {
    //     tipo: 'nomeusuario'
    // };
    //
    // $scope.listarDepartamentos = function () {
    //     var url = BASEURL + 'departamento/listar-departamentos';
    //     var config = {
    //         headers: { 'Content-Type': 'application/json;charset=utf-8;' }
    //     };
    //     var filtro = '';
    //     $http.post(url, filtro, config).success(function (data) {
    //         $scope.dadosDepartamentos = data.retorno;
    //         $scope.dadosDepartamentos2 = data.retorno;
    //     }).error(function (error) {
    //
    //     });
    // };
    //
    // $scope.listarCargos = function () {
    //     var url = BASEURL + 'cargos/listar-cargos';
    //     var config = {
    //         headers: { 'Content-Type': 'application/json;charset=utf-8;' }
    //     };
    //     var filtro = '';
    //     $http.post(url, filtro, config).success(function (data) {
    //         $scope.dadosCargos = data.retorno;
    //         $scope.dadosCargos2 = data.retorno;
    //     }).error(function (error) {
    //
    //     });
    // };
    //
    // $scope.listarSetores = function (opt) {
    //     var url = BASEURL + 'setores/listar-setores';
    //     var config = {
    //         headers: { 'Content-Type': 'application/json;charset=utf-8;' }
    //     };
    //     var filtro = '';
    //     $http.post(url, filtro, config).success(function (data) {
    //         $scope.dadosSetores = data.retorno;
    //         $scope.dadosSetores2 = data.retorno;
    //     }).error(function (error) {
    //
    //     });
    // };
    //
    // $scope.reset();
    // $scope.listarDepartamentos();
    // $scope.listarSetores();
    // $scope.listarCargos();
    //
    // $scope.searchResult = function () {
    //     var url = BASEURL + 'usuario/listar-usuarios';
    //     var config = {
    //         headers: { 'Content-Type': 'application/json;charset=utf-8;' }
    //     };
    //     var filtro = {
    //         [$scope.search.tipo]: $scope.search.valor
    //     };
    //     //console.log(filtro);
    //     $http.post(url, filtro, config).success(function (data) {
    //         //console.log(data);
    //         if (data.codigo == 1){
    //             $scope.gridOptions.data = data.retorno;
    //         }else{
    //             toastr.error(data.retorno);
    //             $scope.gridOptions.data = '';
    //         }
    //     }).error(function (error) {
    //         $scope.gridOptions.data = '';
    //         toastr.error(error.message);
    //     });
    // };
    //
    // $scope.listaUsuariosCadastrados = function () {
    //     var url = BASEURL + 'usuario/listar-usuarios-cadastrados';
    //     var config = {
    //         headers: { 'Content-Type': 'application/json;charset=utf-8;' }
    //     };
    //     var filtro = {
    //         [$scope.search.tipo]: $scope.search.valor
    //     };
    //     //console.log(filtro);
    //     $http.post(url, filtro, config).success(function (data) {
    //         //console.log(data);
    //         if (data.codigo == 1){
    //             $scope.gridOptions.data = data.retorno;
    //         }else{
    //             toastr.error(data.retorno);
    //             $scope.gridOptions.data = '';
    //         }
    //     }).error(function (error) {
    //         $scope.gridOptions.data = '';
    //         toastr.error(error.message);
    //     });
    // };
    //
    // $scope.gridOptions = {
    //     enableSorting: true,
    //     paginationPageSizes: [10, 50, 75],
    //     paginationPageSize: 10,
    //     enableVerticalScrollbar: 0,
    //     rowHeight:35,
    //     rowTemplate:'<div ng-class="{ inativo : row.entity.inativo==true }"> <div ng-repeat="col in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ui-grid-cell></div></div>',
    //     columnDefs: [
    //         {
    //             field: 'idusuario',
    //             displayName: ' ',
    //             enableColumnMenu: false,
    //             enableSorting: false,
    //             cellTemplate:'<a role="button" data-toggle="modal" data-target="#modalInserirEditar" class="table-icon" data-tipo="Editar" ng-click="grid.appScope.modalEditar(row.entity)" data-keyboard="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>',
    //             width: 30
    //         },
    //         { field: 'nome', displayName: 'Nome', minWidth:200 },
    //         { field: 'usuario', displayName: 'Usuário', minWidth:200 },
    //         { field: 'email', displayName: 'Email', minWidth:200 },
    //         { field: 'nomesetor', displayName: 'Setor', minWidth:200 },
    //         { field: 'inativo', visible: false },
    //     ],
    //       data: []
    // };
    //
    // $scope.modalEditar = function(id) {
    //     $scope.reset();
    //     for (var propriedade in id) {
    //         if ($scope.objDados.hasOwnProperty(propriedade)) {
    //             $scope.objDados[propriedade] = id[propriedade];
    //         }
    //     }
    //     $scope.objDados.modo ='editar';
    // };
    //
    // $scope.restauraPesquisa = function() {
    //     delete $scope.search.valor;
    // };
    //
    // $scope.modalCadastrar = function() {
    //     $scope.reset();
    // };
    //
    // $scope.adicionaItem = function() {
    //     var url = '';
    //     var config = '';
    //     if ($scope.objDados.modo === 'editar'){
    //         url = BASEURL + 'usuario/alterar-usuario';
    //         config = {
    //             headers: { 'Content-Type': 'application/json;charset=utf-8;' }
    //         };
    //         var senhaUsuario = $scope.objDados.senha;
    //         if(senhaUsuario != ''){
    //             if (!$scope.comparaSenha()){
    //                 return false;
    //             }
    //         }
    //         var dadosEdicao = {
    //             	"id": $scope.objDados.idusuario,
    //                 "dados": {
    //                     "nome": $scope.objDados.nome,
    //                     "usuario": $scope.objDados.usuario,
    //                 	"senha": senhaUsuario,
    //                     "setor": $scope.objDados.idsetor,
    //                     "departamento": $scope.objDados.iddepartamento,
    //                     "cargo": $scope.objDados.cargo,
    //                     "responsavel": $scope.objDados.responsavel,
    //                 	"inativo": $scope.objDados.inativo,
    //                     "ramal": $scope.objDados.ramal,
    //                     "email": $scope.objDados.email,
    //                 	"celular": $scope.objDados.celular,
    //                 	"subnivel": $scope.objDados.subnivel
    //                 }
    //         };
    //         //console.log(dadosEdicao);
    //         $http.post(url, dadosEdicao, config).success(function (response) {
    //             //console.log(response);
    //             if (response.codigo === 1) {
    //                 toastr.success(response.retorno);
    //                 $scope.reset();
    //                 delete $scope.objDados;
    //                 $scope.searchResult();
    //             }else{
    //                 toastr.error(response.retorno);
    //                 $scope.reset();
    //             }
    //         }).error(function (error) {
    //             toastr.error('Houve um erro ao alterar o cadastro.');
    //         });
    //     }else{
    //         url = BASEURL + 'usuario/cadastrar';
    //         config = {
    //             headers: { 'Content-Type': 'application/json;charset=utf-8;' }
    //         };
    //         if (!$scope.comparaSenha()){
    //             return false;
    //         }
    //         var dadosCadastro = {
    //             "nome": $scope.objDados.nome,
    //             "usuario": $scope.objDados.usuario,
    //         	"senha": $scope.objDados.senha,
    //             "setor": $scope.objDados.idsetor,
    //             "departamento": $scope.objDados.iddepartamento,
    //             "cargo": $scope.objDados.cargo,
    //             "responsavel": $scope.objDados.responsavel,
    //         	"inativo": $scope.objDados.inativo,
    //             "ramal": $scope.objDados.ramal,
    //             "email": $scope.objDados.email,
    //         	"celular": $scope.objDados.celular,
    //         	"subnivel": '0'
    //         };
    //         //console.log(dadosCadastro);
    //         $http.post(url, dadosCadastro, config).success(function (response) {
    //             //console.log(response);
    //             if (response.codigo === 1) {
    //                 toastr.success(response.retorno);
    //                 $scope.reset();
    //                 delete $scope.objDados;
    //                 $scope.searchResult();
    //             }else{
    //                 toastr.error(response.retorno);
    //             }
    //         }).error(function (error) {
    //             toastr.error('Houve um erro ao inserir o cadastro.');
    //         });
    //     }
    // };
    //
    // $scope.comparaSenha = function() {
    //     if ($scope.objDados.senha  == ''){
    //         toastr.error('Preencha o campo senha.');
    //         $scope.objDados.senha = '';
    //         $scope.objDados.confirmasenha = '';
    //         return false;
    //     }else if($scope.objDados.senha != $scope.objDados.senhaConfirma) {
    //         toastr.error('As senhas são diferentes.');
    //         $scope.objDados.senha = '';
    //         $scope.objDados.confirmasenha = '';
    //         return false;
    //     }
    //     return true;
    // };

});
