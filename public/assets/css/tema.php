<?php header("Content-type: text/css"); ?>
<?php
/*
 * Para customizar o menu, acesse:  http://smarchal.com/twbscolor/?bd=048FD2&bh=047AB5&cd=ffffff&ch=f0f0f0
 * altere as cores e copie os valores para as variaveis abaixo
 */
/*
  $bd = '048FD2';
  $bh = '047AB5';
  $cd = 'ffffff';
  $ch = 'dcdcdc';
  $bk = '000';
  $bd_cat = 'F74141';
  $bh_cat = 'FF3333';
  $cd_cat = 'ecf0f1';
  $ch_cat = 'ecdbff';
  $bk_cat = '000';
 */

function get_color($c)
{
    if (isset($_GET["$c"])) {
        return str_replace('#', '', strip_tags($_GET["$c"]));
    } else {
        return '';
    }
}

$bd = get_color('bd');
$bh = get_color('bh');
$cd = get_color('cd');
$ch = get_color('ch');
$bt = get_color('bt');
$br = get_color('br');

$bd = $ch;
$bh = $cd;

$style = "
.img-radius {border-radius: $br%;padding-top: 7px;}

.ch{color:#$ch !important;}
.cd{color:#$cd !important;}
.bd{color:#$bd !important;}
.bh{color:#$bh !important;}

/*TOP LOGO*/
#myNav {background: #$bt !important;}
#card-title {background: #$bt !important;}

/* BG */
.bg-custom{ background: #$bd !important; }

/* FOOTER CONDICOES */
#footer-company{
    background: #$bh;
    color: #$cd;
     padding: 15px;
}
/* BTN */
.btn-custom{
    background: #$bd !important;
    color: #$cd !important;
}
.btn-custom:hover{
    color: #$cd !important;
}
.btn-default{
    background: #$bh !important;
    color:#$cd !important;
}
.btn-default:hover{
    background: #$bd !important;
}

/* ALERT-CUSTOM BG */
.alert-custom{
    font-size: 18px !important;
    background: #$bd;
    color: #$cd;
    padding:6px !important;
}

/*LABEL-SUCCESS*/
.label-success{ background:#$bd !important;}

/*CORES TOOLTIPS HOVER BOOTSTRAP*/
.tooltip-inner {
    max-width: 200px;
    padding: 3px 8px;
    color: #$ch;
    text-align: center;
    text-decoration: none;
    background-color: #$bh;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
}
.tooltip-arrow {
    position: absolute;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
}
.tooltip.top .tooltip-arrow {
    bottom: 0;
    left: 50%;
    margin-left: -5px;
    border-top-color: #$bh;
    border-width: 5px 5px 0;
}
.tooltip.right .tooltip-arrow {
    top: 50%;
    left: 0;
    margin-top: -5px;
    border-right-color: #$bh;
    border-width: 5px 5px 5px 0;
}
.tooltip.left .tooltip-arrow {
    top: 50%;
    right: 0;
    margin-top: -5px;
    border-left-color: #$bh;
    border-width: 5px 0 5px 5px;
}
.tooltip.bottom .tooltip-arrow {
    top: 0;
    left: 50%;
    margin-left: -5px;
    border-bottom-color: #$bh;
    border-width: 0 5px 5px;
}
/*FIM CORES TOOLTIPS HOVER BOOTSTRAP*/
.lista-item:hover{
    -webkit-transition: all 0.4s ease-in-out;
    -moz-transition: all 0.4s ease-in-out;
    -o-transition: all 0.4s ease-in-out;
    -ms-transition: all 0.4s ease-in-out;
    transition: all 0.4s ease-in-out;
    box-shadow:0 0 0 0px #$bh inset;
}
.bootstrap-select.btn-group .no-results {
   background: #$cd !important;
}
.bootstrap-select.btn-group .dropdown-menu .notify {
   background: #$cd !important;
}
.bootstrap-select .selected a{
background: #$bh !important;
}
/*CORES CUSTOM DA NAVBAR BOOTSTRAP*/

.dropdown-menu {background-color: #$bd;}
.dropdown-menu a { color: #$cd !important;}
.dropdown-menu a:hover {background-color: #$bh !important;}
.dropdown-toggle{padding-left:10px !important;padding-right:10px !important;}
.dropdown-toggle:hover {background-color: #$bh !important;}
.navbar-default {
    background-color: #$bd;
    border-color: #$bh;
    border: 0px solid #$bh;
}
.navbar-default .navbar-brand {
    color: #$cd;
}
.navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus {
    color: #$ch;
}
.navbar-default .navbar-text {
    color: #$cd;
}
.navbar-default .navbar-nav > li > a {
    color: #$cd;
}
.navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
   color: #$ch;
}
.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
    color: #$ch;
    background-color: #$bh;
}
.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
    color: #$ch;
    background-color: #$bh !important;
}
.navbar-default .navbar-toggle {
   color: #$ch;
   border-color: #$bh !important;
}
.navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
   background-color: #$bt !important;
}
.navbar-default .navbar-toggle .icon-bar {
   background-color: #$cd !important;
   color: #$cd !important;
}
.navbar-default .navbar-toggle i{
    color: #$cd !important;
}

.navbar-default .navbar-collapse,
.navbar-default .navbar-form {
   border-color: #$cd;
}
.navbar-default .navbar-link {
   color: #$cd;
}
.navbar-default .navbar-link:hover {
    color: #$ch;
}


@media (max-width: 767px) {
    .navbar-default .navbar-nav .open .dropdown-menu > li > a {
       color: #$cd;
    }
    .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
       color: #$ch;
    }
    .navbar-default .navbar-nav .open .dropdown-menu > .active > a, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
        color: #$ch;
        background-color: #$bh;
    }
}
.navbar a{
    /*font-size: 13px !important;*/
}
.navbar .glyphicon{font-size: 15px !important;}
.navbar{
    border-radius:0px;
    -moz-border-radius:0px;
    -webkit-border-radius:0px;
}
.menu-fixed-border{
    border-bottom: 1px solid #$bh;
}
.navbar-wrapper {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index:900;
    margin-top: 20px;
}
.navbar-wrapper .container {
    padding-left: 0;
    padding-right: 0;
}
.navbar-wrapper .navbar {
    padding-left: 15px;
    padding-right: 15px;
}
.navbar-content{
    padding: 15px;
    padding-bottom:0px;
    color:#$ch !important;
}
.navbar-content:before, .navbar-content:after{
    display: table;
    content: \"\";
    line-height: 0;
}
.navbar-nav.navbar-right:last-child {
    margin-right: 15px !important;
}
.navbar-footer{
    background-color:#$ch !important;
}
.navbar-footer-content { padding:15px 15px 15px 15px; }
.dropdown-menu {
    padding: 0px;
    overflow: hidden;
}
.navbar-content *{
    text-shadow: none !important;
    -moz-text-shadow: none #fff !important;
    -moz-box-shadow:none !important;
    -webkit-box-shadow:none !important;
    background: none;
    text-decoration: none !important;
    color:#$ch !important;
}

.badge{
    background-color: green !important;
    color: #fff !important;  
 }
/*FIM CORES CUSTOM DA NAVBAR BOOTSTRAP*/
.text-color1{
    color: #$ch !important;
}
.text-color-1{
    color: #$ch !important;
    border-bottom: 1px solid #$ch !important;
}
";
echo preg_replace('/\s+/', ' ', $style);
