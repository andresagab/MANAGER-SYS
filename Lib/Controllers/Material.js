ManagerSys.controller('angular_material', function ($scope, $mdSidenav, $mdToast, $mdBottomSheet, config_global, $http, $cookies) {

    $scope.material = {
        preferences: {},
        theme: 'default',
        themes: {
            materialDark: {
                name: 'Dark',
                themingId: 'materialDark'
            },
            materialPinkDark: {
                name: 'Pink',
                themingId: 'materialPinkDark'
            },
            materialPurple: {
                name: 'Purple',
                themingId: 'materialPurple'
            },
            materialBlue: {
                name: 'Blue',
                themingId: 'materialBlue'
            },
            materialDefault: {
                name: 'Default',
                themingId: null
            }
        },
        linearBar: false,
        progressBar: false,
        message: {
            show: false,
            color: null,
            message: null,
        },
        fabButtonPage: {
            status: false,
            availableModes: ['md-fling', 'md-scale'],
            availableDirections: ['up', 'down', 'left', 'right'],
            selectedDirection: 'up',
            selectedMode: 'md-scale'
        },
        dialog: {
            progressBar: false,
            linearBar: false,
            dialogForm: {
                name: null,
                action: null,
                object: null
            },
            alertDlg: {
                status: false,
                color: null,
                message: null
            },
            btnAcceptDialog: false
        },
        dataPaginator: {
            previousPage: true,
            nextPage: true,
            availableRecordsForPage: [5, 10, 25, 50, 75, 100],
            recordsForPage: 5,
            totalRecords: 0,
            pages: 1,
            currentPage: 1,
            initialRecord: 0,
            finalRecord: 0,
            cacheObjects: {}
        },
        bottomSheet: {
            message: null
        }
    }
    
    $scope.setAlertMessage = function (show, message, color) {
        if (show) {
            $scope.material.message.show = show;
            $scope.material.message.message = message;
            $scope.material.message.color = color;
        } else {
            $scope.material.message.show = false;
            $scope.material.message.message = null;
            $scope.material.message.color = null;
        }
    }
    
}).config(function ($mdThemingProvider) {

    $mdThemingProvider.theme('customTheme')
        .primaryPalette('teal')
        .accentPalette('orange')
        .warnPalette('red');

    $mdThemingProvider.theme('materialDark')
        .primaryPalette('grey')
        .accentPalette('blue-grey')
        .warnPalette('brown');

    $mdThemingProvider.theme('materialPinkDark')
        .primaryPalette('pink')
        .accentPalette('grey')
        .warnPalette('orange');

    $mdThemingProvider.theme('materialPurple')
        .primaryPalette('purple')
        .accentPalette('blue')
        .warnPalette('amber');

    $mdThemingProvider.theme('materialBlue')
        .primaryPalette('blue')
        .accentPalette('green')
        .warnPalette('yellow');

    var theme = 'default';
    var data = JSON.parse(sessionStorage.getItem('userPreferences'));
    if (data != null) {
        if (JSON.parse(data.data) != null) {
            if (JSON.parse(data.data).theme != null) theme = JSON.parse(data.data).theme;
        }
    }

    $mdThemingProvider.enableBrowserColor({
        theme: theme,
        palette: 'primary',
        hue: '500'
    });

});