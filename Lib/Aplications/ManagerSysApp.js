var ManagerSys = angular.module('ManagerSys', ['ngMaterial', 'ngRoute', 'ngAnimate', 'ngCookies']);

ManagerSys.constant('config_global', {
    'nameSite': 'KODE',
    'scripts': document.location.origin + '/Work/MANAGER-SYS/System/Scripts',
    'template': document.location.origin + '/Work/MANAGER-SYS/System/Templates'
});