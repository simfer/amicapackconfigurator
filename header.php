<?php
require_once 'config.php';
require_once "daelib.php";

//Session starts here
session_start();

if (isset($_SESSION ["idutente"]) && !empty($_SESSION ["idutente"])) {
    $idutente = $_SESSION ["idutente"];
    $res = GetPermissions($idutente);
    //var_dump($_SESSION);
    //die();
} else {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Simmaco Ferriero">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>AMICA Pack Configurator</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Table CSS -->
    <link rel="stylesheet" href="bower_components/bootstrap-table/dist/bootstrap-table.min.css">

    <!-- Bootstrap Dialog CSS -->
    <link rel="stylesheet" href="bower_components/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css">

    <!-- Bootstrap Datepicker CSS -->
    <link type="text/css" rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css">

    <!-- Toastr CSS -->
    <link href="bower_components/toastr/toastr.min.css" rel="stylesheet" type="text/css">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>


</head>

<body>
<div id="wrapper" style="height: 100%">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html" style="padding-top: 5px">
                <div><img src="images/logo-palmesano.png" style="width: 80px">AMICA Pack Configurator</div></a>
        </div>
        <!-- /.navbar-header -->
        <ul class="nav navbar-top-links navbar-right">
            Ciao, <?=$_SESSION["nome"]?>!
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="userinfo.php"><i class="fa fa-user fa-fw"></i> Profilo utente</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Preferenze</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="index.php"><i class="fa fa-sign-out fa-fw"></i> Disconnetti</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Cerca ...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <!-- /input-group -->
                    </li>
                    <li>
                        <a href="home.php"><i class="fa fa-home fa-fw"></i> Home</a>
                    </li>

                    <? if (in_array("ALL", $res) || in_array("CLI", $res)) { ?>
                        <li>
                            <a href="#"><i class="fa fa-child fa-fw"></i> Clienti<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="clienti.php">Gestione clienti</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    <? } ?>

                    <? if (in_array("ALL", $res) || in_array("PRE", $res)) { ?>
                        <li>
                            <a href="#"><i class="fa fa-tasks fa-fw"></i> Preventivi<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="preventivi.php">Gestione preventivi</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    <? } ?>

                    <? if (in_array("ALL", $res) || in_array("ADM", $res)) { ?>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Tabelle di sistema<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="parametri.php"> Parametri</a>
                                </li>
                                <li>
                                    <a href="professioni.php"> Professioni</a>
                                </li>
                                <li>
                                    <a href="etaintestatari.php"> Età intestatari</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    <? } ?>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
<!-- put body here -->
