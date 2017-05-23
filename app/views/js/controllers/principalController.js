ocApp.controller('principalController', function ($http, $location, BASEURL, $scope, $window, $rootScope, toastr) {
  $scope.cadastro = function () {
      $location.path('/cadastrar-usuario');
  }
  $scope.entrar = function () {
      $location.path('/login');
  }
    //
    // $scope.reset = function(){
    //     var date = new Date(), y = date.getFullYear(), m = date.getMonth();
    //     var firstDay = new Date(y, m, 1);
    //     var lastDay = new Date(y, m + 1, 0);
    //     $scope.search = {
    //         'opcaoPesquisa': '0',
    //         'status': '0',
    //         'prioridade': '0',
    //         'nomeRequisitante': '',
    //         'idRequisicao': '',
    //         'dataInicial': moment(firstDay).format('DD/MM/YYYY'),
    //         'dataFinal': moment(lastDay).format('DD/MM/YYYY'),
    //         'quantidade': 25
    //     };
    // };
    //
    // $scope.tab_quantidade_resultados = [
    //     { label: 25,  value: 25 },
    //     { label: 50,  value: 50 },
    //     { label: 100,  value: 100 },
    //     { label: 'Todos',  value: false }
    // ];
    //
    // $scope.listarCountRecebidas = function () {
    //     var url = BASEURL + 'dashboard/count-received-requests';
    //     var config = {
    //         headers: { 'Content-Type': 'application/json;charset=utf-8;' }
    //     };
    //     var filtro = '';
    //     $http.post(url, filtro, config).success(function (data) {
    //         $scope.dadosRequisicoesRecebidas = data.retorno;
    //     }).error(function (error) {
    //
    //     });
    // };
    //
    // $scope.listarCountEnviadas = function () {
    //     var url = BASEURL + 'dashboard/count-sent-requests';
    //     var config = {
    //         headers: { 'Content-Type': 'application/json;charset=utf-8;' }
    //     };
    //     var filtro = '';
    //     $http.post(url, filtro, config).success(function (data) {
    //         $scope.dadosRequisicoesEnviadas = data.retorno;
    //     }).error(function (error) {
    //
    //     });
    // };
    //
    // $scope.listarStatus = function () {
    //     var url = BASEURL + 'requisicoes/listar-status';
    //     var config = {
    //         headers: { 'Content-Type': 'application/json;charset=utf-8;' }
    //     };
    //     var filtro = '';
    //     $http.post(url, filtro, config).success(function (data) {
    //         $scope.dadosStatus = data.retorno;
    //     }).error(function (error) {
    //
    //     });
    // };
    //
    // $scope.listarPrioridades = function () {
    //     var url = BASEURL + 'requisicoes/listar-prioridade';
    //     var config = {
    //         headers: { 'Content-Type': 'application/json;charset=utf-8;' }
    //     };
    //     var filtro = '';
    //     $http.post(url, filtro, config).success(function (data) {
    //         $scope.dadosPrioridades = data.retorno;
    //     }).error(function (error) {
    //
    //     });
    // };
    //
    // $scope.listarCountRecebidas();
    // $scope.listarCountEnviadas();
    // $scope.listarStatus();
    // $scope.listarPrioridades();
    // $scope.reset();
    //
    // $scope.toDate = function(dateStr) {
    //     var parts = dateStr.split("/");
    //     return new Date(parts[2], parts[1] - 1, parts[0]);
    // };
    //
    // $scope.toDate2 = function(dateStr) {
    //     var parts = dateStr.split("-");
    //     return (parts[2]+'/'+parts[1]+'/'+parts[0]);
    // };
    //
    // $scope.pesquisar = function(opcao) {
    //     if ($scope.search.quantidade === null) {
    //         toastr.error('Selecione uma quantidade de resultados.');
    //     }else if ($scope.search.dataInicial == '' || $scope.search.dataFinal == ''){
    //         toastr.error('Por favor preencha o campo data inicial e data final.');
    //     }else if (moment($scope.toDate($scope.search.dataInicial)).format('YYYY-MM-DD') > moment($scope.toDate($scope.search.dataFinal)).format('YYYY-MM-DD')){
    //         toastr.error('A data inicial deve ser menor que a data final.');
    //     } else {
    //         var url = '';
    //         if (opcao === '1'){
    //             url = BASEURL + 'dashboard/show_received';
    //         }else{
    //             url = BASEURL + 'dashboard/show_sent';
    //         }
    //         var config = {
    //             headers: { 'Content-Type': 'application/json;charset=utf-8;' }
    //         };
    //         var dadosConsulta = {
    //             "opcaoPesquisa": $scope.search.opcaoPesquisa,
    //             "status": $scope.search.status,
    //             "prioridade": $scope.search.prioridade,
    //             "nomeRequisitante": $scope.search.nomeRequisitante,
    //             "idRequisicao": $scope.search.idRequisicao,
    //             "dataInicial": moment($scope.toDate($scope.search.dataInicial)).format('YYYY-MM-DD'),
    //             "dataFinal": moment($scope.toDate($scope.search.dataFinal)).format('YYYY-MM-DD'),
    //             "quantidade": $scope.search.quantidade,
    //         };
    //         $http.post(url, dadosConsulta, config).success(function (data) {
    //             if (data.codigo == 1){
    //                 //console.log(data);
    //                 if (opcao == '1'){
    //                     $scope.gridRecebidas.data = data.retorno;
    //                 }else{
    //                     $scope.gridEnviadas.data = data.retorno;
    //                 }
    //             }else{
    //                 if (opcao === '1'){
    //                     $scope.gridRecebidas.data = '';
    //                 }else{
    //                     $scope.gridEnviadas.data = '';
    //                 }
    //             }
    //         }).error(function (error) {
    //             if (opcao === '1'){
    //                 $scope.gridRecebidas.data = '';
    //             }else{
    //                 $scope.gridEnviadas.data = '';
    //             }
    //         });
    //     }
    // };
    //
    // // Zera os campos de busca com o botão "resetar" ou ao trocar de aba.
    // $scope.limpaBusca = function () {
    //     $scope.search = angular.copy($scope.searchOriginal);
    // };
    //
    // // Função utilizada para adicinar a classe de requisição "atrasada".
    // $scope.isOverdue = function (objeto) {
    //     if (moment(objeto.prazolimite).isBefore(moment().subtract(1, 'day')) && (objeto.nomestatus !== "Concluído" || objeto.nomestatus !== "Recusado")) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // };
    //
    // // Passa os dados da requisição clicada na Dashboard para a timeline.
    // $scope.saveTimeline = function(idRequisicao, tipo) {
    //     window.localStorage.setItem('dadosRequisicaoAmigox', idRequisicao);
    //     window.localStorage.setItem('dadosRequisicaoTipoAmigox', tipo);
    // };
    //
    // $scope.gridRecebidas = {
    //     enableSorting: true,
    //     paginationPageSizes: [10, 50, 75],
    //     paginationPageSize: 10,
    //     enableVerticalScrollbar: 0,
    //     rowHeight:35,
    //     rowTemplate:'<div ng-class="{ danger : grid.appScope.isOverdue(row), info : row.entity.nomestatus == &quot;Concluído&quot;, success : row.entity.nomestatus == &quot;Aberto&quot;, refused : row.entity.nomestatus == &quot;Recusado&quot;  }"> <div ng-repeat="col in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ui-grid-cell></div></div>',
    //
    //     columnDefs: [
    //         {
    //             field: 'acompanhar',
    //             displayName: ' ',
    //             enableColumnMenu: false,
    //             enableSorting: false,
    //             cellTemplate:'<a  ng-click="grid.appScope.saveTimeline(row.entity.id, 1)" href="#timeline-requisicao" class="table-icon"><i class="fa fa-eye" aria-hidden="true"></i></a>',
    //             width: 35
    //         },
    //         {
    //             field: 'id',
    //             displayName: 'ID',
    //             enableColumnMenu: false,
    //             width: 60
    //         },
    //         { field: 'titulo', displayName: 'Título', minWidth: 150 },
    //         { field: 'nomerequisitante', displayName: 'Requisitante', minWidth:150 },
    //         { field: 'dataabertura', displayName: 'Abertura', cellTemplate:'<span>{{grid.appScope.toDate2(row.entity.dataabertura)}}</span>', width: 100 },
    //         { field: 'prazolimite', displayName: 'Vencimento', cellTemplate:'<p>{{grid.appScope.toDate2(row.entity.prazolimite)}}</p>', width: 120 },
    //         { field: 'nomeprioridade', displayName: 'Prioridade', width: 110 },
    //         { field: 'nomestatus', displayName: 'Status', width: 80 },
    //     ],
    //       data: []
    // };
    //
    // $scope.gridEnviadas = {
    //     enableSorting: true,
    //     paginationPageSizes: [10, 50, 75],
    //     paginationPageSize: 10,
    //     enableVerticalScrollbar: 0,
    //     rowHeight:35,
    //     rowTemplate:'<div ng-class="{ danger : grid.appScope.isOverdue(row.entity), info : row.entity.nomestatus == &quot;Concluído&quot;, success : row.entity.nomestatus == &quot;Aberto&quot;, refused : row.entity.nomestatus == &quot;Recusado&quot;  }"> <div ng-repeat="col in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ui-grid-cell></div></div>',
    //     columnDefs: [
    //         {
    //             field: 'id',
    //             displayName: ' ',
    //             enableColumnMenu: false,
    //             enableSorting: false,
    //             cellTemplate:'<a ng-click="grid.appScope.saveTimeline(row.entity.id, 2)" href="#timeline-requisicao" class="table-icon"><i class="fa fa-eye" aria-hidden="true"></i></a>',
    //             width: 20
    //         },
    //         {
    //             field: 'id',
    //             displayName: 'ID',
    //             enableColumnMenu: false,
    //             width: 60
    //         },
    //         { field: 'titulo', displayName: 'Título', minWidth: 150 },
    //         { field: 'nome', displayName: 'Responsável', minWidth:150 },
    //         { field: 'dataabertura', displayName: 'Abertura', cellTemplate:'<span>{{grid.appScope.toDate2(row.entity.dataabertura)}}</span>', width: 100 },
    //         { field: 'prazolimite', displayName: 'Vencimento', cellTemplate:'<p>{{grid.appScope.toDate2(row.entity.prazolimite)}}</p>', width: 120 },
    //         { field: 'nomeprioridade', displayName: 'Prioridade', width: 110 },
    //         { field: 'nomestatus', displayName: 'Status', width: 80 },
    //     ],
    //       data: []
    // };

});
