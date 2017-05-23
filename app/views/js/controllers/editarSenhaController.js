ocApp.controller('editarSenhaController', function ($scope, $http, toastr, BASEURL) {
    $scope.request = {
        operacao: "edit_password",
        oldPasswd: '',
        confirmPasswd: '',
        newPasswd: ''
    };

    $scope.changePassword = function() {
        var url = BASEURL + 'usuario/alterar-senha';
        var config = {
            headers: {
                'Content-Type': 'application/json;charset=utf-8;'}
        };
        var dadosSenha = {
            "senhaantiga": $scope.request.oldPasswd,
            "senhanova": $scope.request.newPasswd
        };
        console.log(dadosSenha);
        $http.post(url, dadosSenha, config).success(function(data){
            console.log(data);
            if(data.codigo === 1) {
                toastr.success(data.retorno);
            }else{
                toastr.error(data.retorno);
            }
        }).error(function(data){
            toastr.error('Não foi possivel alterar a senha!');
        });

    };
});
