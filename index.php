<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 10/12/2018
 * Time: 13:36
 */

session_start();
session_unset();
session_destroy();

?>
<!DOCTYPE html>
<html lang="ES">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Inicio de sesi&otilde;n</title>
        <link rel="stylesheet" href="Lib/node_modules/angular-material/angular-material.min.css">
        <script src="Lib/Frameworks/Angular/angular-1.7.5/angular.min.js"></script>
        <script src="Lib/Frameworks/Angular/angular-1.7.5/angular-route.min.js"></script>
        <script src="Lib/Frameworks/Angular/angular-1.7.5/angular-animate.min.js"></script>
        <script src="Lib/Frameworks/Angular/angular-1.7.5/angular-aria.min.js"></script>
        <script src="Lib/Frameworks/Angular/angular-1.7.5/angular-messages.min.js"></script>
        <script src="Lib/Frameworks/Angular/angular-1.7.5/angular-cookies.min.js"></script>
        <script src="Lib/node_modules/angular-material/angular-material.min.js"></script>
        <script src="Lib/Aplications/ManagerSysApp.js"></script>
        <script src="Lib/Controllers/LogIn.js"></script>
        <script src="Lib/Controllers/Material.js"></script>
    </head>
    <body ng-app="ManagerSys">
        <div id="inputContainer" ng-controller="angular_material" ng-cloak style="height: 100%;">
            <md-content ng-controller="LogIn" layout="row" style="height: 100%;">
                <div flex="10">&nbsp;</div>
                <div flex="80" layout="column">
                    <div flex="20" flex-gt-sm="20" layout="row" layout-align="center center">
                        <div layout-padding ng-show="material.progressBar">
                            <center>
                                <md-progress-circular md-mode="indeterminate" class="md-accent"></md-progress-circular>
                            </center>
                        </div>
                    </div>
                    <div layout="row">
                        <div flex="0" flex-gt-sm="20">&nbsp;</div>
                        <div flex="100" flex-gt-sm="60">
                            <md-card>
                                <div layout="row" layout-padding ng-show="material.message.show" style="{{ material.message.color }}">
                                    <div flex="10">&nbsp;</div>
                                    <div flex="80" style="text-align: center;">
                                        <span class="md-headline">{{ material.message.message }}</span>
                                    </div>
                                    <div flex="10">&nbsp;</div>
                                </div>
                                <md-card-tittle style="text-align: center">
                                    <md-card-tittle-text>
                                        <h3 class="md-display-1">{{ content.title }}</h3>
                                    </md-card-tittle-text>
                                </md-card-tittle>
                                <md-card-content>
                                    <form name="formulario" ng-submit="logIn()" novalidate>
                                        <md-input-container class="md-block md-accent">
                                            <label>Usuario</label>
                                            <input required name="usuario" ng-model="project.usuario" autofocus>
                                            <div ng-messages="formulario.usuario.$error">
                                                <div ng-message="required">Este campo es requerido.</div>
                                            </div>
                                        </md-input-container>
                                        <md-input-container class="md-block md-accent">
                                            <label>Contrase&ntilde;a</label>
                                            <input required name="clave" type="password" ng-model="project.clave">
                                            <div ng-messages="formulario.clave.$error">
                                                <div ng-message="required">Este campo es requerido.</div>
                                            </div>
                                        </md-input-container>
                                        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
                                            <md-button class="md-raised md-primary" type="submit" ng-disabled="!formulario.$valid">Ingresar</md-button>
                                        </section>
                                    </form>
                                </md-card-content>
                            </md-card>
                        </div>
                        <div flex="0" flex-gt-sm="20">&nbsp;</div>
                    </div>
                    <div flex>&nbsp;</div>
                </div>
                <div flex="10">&nbsp;</div>
            </md-content>
        </div>
    </body>
</html>