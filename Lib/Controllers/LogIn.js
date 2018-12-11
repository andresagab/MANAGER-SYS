ManagerSys.controller('LogIn', function ($scope, $http, config_global) {

    sessionStorage.clear();

    $scope.project={
        P: 'SYS_'
    }

    $scope.content={
        title: 'Inicio de sesion',
        alert: false,
        colorAlert: null,
        messageForm: null,
        progressBar: false
    }

    $scope.showAlert=function (show, color, message) {
        if (show){
            $scope.content.alert=true;
            $scope.content.colorAlert=color;
            $scope.content.messageForm=message;
        } else {
            $scope.content.alert=false;
            $scope.content.colorAlert=null;
            $scope.content.messageForm=null;
        }
    }

    $scope.session = null;

    $scope.logIn=function () {
        if ($scope.formulario.$valid) {
            //$scope.showAlert(false, null, null);
            $scope.setAlertMessage(false, null, null);
            $scope.material.progressBar= true;
            $http({
                url: config_global.scripts + "/dataJSON.php",
                method: 'POST',
                data: $scope.project,
                params: {
                    metod: 'logIn'
                },
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            }).then(function (response) {
                $scope.material.progressBar = false;
                if (response.status==200){
                    if (response.data!=null){
                        if (response.data.error!=null){
                            $scope.session = response.data;
                            $scope.setResponseLogIn();
                        }
                    }
                }
            }, function (response) {
                $scope.material.progressBar = false;
                var message=null;
                console.log(response);
                switch (response.status){
                    case 404:
                        message="No se encontro el archivo solicitado";
                        break;
                    case -1:
                        message="No se pudo conectar con el servidor, porfavor revisa tu conexion a internet";
                        break;
                }
                $scope.setAlertMessage(true, message, 'background-color: #EF5350; color: #fff;');
            });
        } else {
            $scope.setAlertMessage(true, 'Debes diligenciar todo el formulario', 'background-color: #EF5350; color: #fff;');
        }
    }

    $scope.setResponseLogIn=function () {
        console.log($scope.session);
        switch ($scope.session.error){
            case -1:
                if ($scope.session.logIn){
                    sessionStorage.setItem('sessionUser', JSON.stringify($scope.session.user));
                    sessionStorage.setItem('userPreferences', JSON.stringify($scope.session.preferences));
                    //document.location = "System/Tools/login.php?user=" + $scope.session.user.usuario;
                } else {
                    $scope.session = null;
                    $scope.setAlertMessage(true, 'Usuario y/o contraseña incorrecto', 'background-color: #EF5350; color: #fff;');
                }
                break;
            case 0:
                $scope.session = null;
                $scope.setAlertMessage(true, 'El usuario es incorrecto o no esta registrado en la base de datos', 'background-color: #EF5350; color: #fff;');
                break;
            case 1:
                $scope.session=null;
                $scope.setAlertMessage(true, 'Constraseña incorrecta', 'background-color: #EF5350; color: #fff;');
                break;
        }
    }

});