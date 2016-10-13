<?php

// Start Session
session_start();

/*
Template Name: Agent Case Details
*/

?>

<!DOCTYPE html>
<style type="text/css">
    html, body {
        margin:0;
        padding:0;
    }

    #container {
        margin-left: 230px;
        _zoom: 1;
    }

    #nav {
        float: left;
        width: 230px;
        height: 100%;
        background: #32323a;
        margin-left: -230px;
        position:fixed;
    }

    #main {
        height: 400px;
    }
    /* style icon */
    .inner-addon .glyphicon {
        position: absolute;
        padding: 10px;
        pointer-events: none;
    }

    /* align icon */
    .left-addon .glyphicon {
        left: 0px;
    }

    /* add padding  */
    .left-addon input {
        padding-left: 30px;
    }

    a {
        letter-spacing: 1px;
    }

    .logo {
        height: 120px;
        width: 230px;
        padding-top: 20px;
        padding-left: 20px;
        padding-right:20px;
        padding-bottom: 20px;
        display: block;
        background-color: #28282e;
    }

    .logo img {
        width: 100%;
    }

    .nav-pills {
        background-color: #32323a;
        border-color: #030033;
    }

    .nav-pills > li > a {
        color: #95a0aa; /*Change active text color here*/
    }
    .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
        color: #000;  /*Sets the text hover color on navbar*/
    }

    li {
        border-bottom:1px #2a2a31 solid;
    }
    .footer {
        position: absolute;
        bottom:0px;
        left:0;
        right:0;
        margin:0 auto;
        text-align: center;
    }

    .copyRight {
        color:white;
        padding:0px;
    }

    .formPart {
        margin-left: 40px;
        padding-top: 30px;
    }

    th {
        color:white;
        font-size:11px;
        text-align:center;
    }

    .userNamePart {
        color:white;
        text-align: center;
        margin-bottom: 20px;
    }

    .title {
        padding:0px;
        margin:20px;
    }
    .title h4 {
        padding:0px;
        margin:0px;
        width: 300px;
        font-size: 20px;
        color:grey;
        font-style: bold;
    }

    .inputPart {
        padding-top: 30px;
        background-color: grey;
        color:white;
        height: 500px;
        width: 800px;
    }

    .table td {
        font-size:10px;
        vertical-align: middle;
    }

    .arrow-up {
        width:0;
        height:0;
        border-left:3px solid transparent;
        border-right:3px solid transparent;
        border-bottom:6px solid #fff;
        display: inline-block;
    }

    .arrow-down {
        width:0;
        height:0;
        border-left:3px solid transparent;
        border-right:3px solid transparent;
        border-top:6px solid #fff;
        display: inline-block;
    }



    .pageNum {
        text-align: center;
    }

    .pageNum a:link{
        font-size: 8px;
        color:black;
        text-decoration:underline;
    }

    .pageNum a:visited{
        color:black;
        text-decoration:underline;
    }

    .pageNum a:hover{
        color:black;
        text-decoration:underline;
    }

    .pageNum a:active{
        color:black;
        text-decoration:underline;
    }

    .table-striped {
        width: 790px !important;
        padding-left:20px;
        margin-left: 20px;
    }

    .table-striped th{
        font-size: 10px;
        color:#a9a9a9;
        text-align: center;
    }

    .table-striped td{
        text-align: center;
        color:#a9a9a9;
    }

    .houseInfo .table-striped tr {
        font-size: 10px;
        color:#a9a9a9;
    }

    .houseInfo .table-striped th {
        font-size: 10px;
        color:#a9a9a9;
    }

    .houseInfo .table-striped td {
        padding-top:2px !important;
        padding-bottom:2px !important;
    }

    .houseInfo .table-striped {
        /*	margin-top: 0px;
            margin-left: 0px;*/
        width: 415px !important;
        height: 200px !important;
        color: #a9a9a9;
    }

    .houseInfo {
        width: 100%;
        overflow: hidden;
        padding-left: 20px;
    }

    .houseImg {
        height: 200px;
        width: 300px;
        float: left;
        padding-top:25px;
    }

    .houseImg img {
        width: 100%;
    }

    .houseTable {
        width: 300px;
        margin-left: 350px;
    }

    .table-striped a:link {
        text-decoration: underline;
    }

    .dropdown {
        height: 20px;
        width: 25px;
    }

    select {
        border-radius: 3px;
        height: 20px;
        width: 70px;
    }

    .financial {
        width: 780px;
    }

    .financial h5{
        margin-left: 20px;
        color:#a9a9a9;
    }

    .approveButton {
        height: 30px;
        width: 100px;
        background-color: #32323a;
        color:#fff;
        font-size: 12px;
        float:right;
    }

    .line {
        width: 900px;
    }

    .total {
        float: left;
    }

    .selectTeamPart {
        float:left;
        padding-left: 240px;
        color:#a9a9a9;
    }

    .selectTeam {
        margin-top:-60px;
        margin-left: 420px;
    }

    .selectTeam select {
        border-radius: 3px;
        height: 30px;
        width: 130px;
    }
</style>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="http://cdn.static.runoob.com/libs/angular.js/1.4.6/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div id="container">
    <?php
        include_once(__DIR__ . '/navigation.php');
    ?>
    <div id="main">
        <div class="formPart">
            <div class="houseInfo">
                <div class="houseImg"><img src="img/house.jpg"></div>
                <div class="houseTable">
                    <div style="width:300px; padding:0px;"><h5 style="z-index:100;color:#a9a9a9; margin-top:0px; margin-left:10px;">HOUSE INFORMATION</h5></div>
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>MLS#</td>
                            <td>N32326234</td>
                        </tr>
                        <tr>
                            <td>ADDRESS</td>
                            <td>17 Inverary, Toronto Ontario M1T2W6</td>
                        </tr>
                        <tr>
                            <td>PROPERTY TYPE</td>
                            <td>PROPERTY TYPE</td>
                        </tr>
                        <tr>
                            <td>LAND SIZE (LOT)</td>
                            <td>LAND SIZE (LOT)</td>
                        </tr>
                        <tr>
                            <td>HOUSE SIZE(SQF)</td>
                            <td>HOUSE SIZE(SQF)</td>
                        </tr>
                        <tr>
                            <td>LISTING PRICE</td>
                            <td>LISTING PRICE</td>
                        </tr>
                        <tr>
                            <td>OWNER'S NAME</td>
                            <td>OWNER'S NAME</td>
                        </tr>
                        <tr>
                            <td>TEAM MEMBER'S NAME</td>
                            <td>TEAM MEMBER'S NAME</td>
                        </tr>
                        <tr>
                            <td>COMMISSION RATE</td>
                            <td>2.25%</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="width:300px; padding:0px 0px 0px 10px;"><h5 style="z-index:100;color:#a9a9a9; margin-top:0px; margin-left:10px;">SERVICES INFO</h5></div>
            <table class="table table-striped">
                <thead style="background-color:#fffeff;">
                <tr>
                    <th></th>
                    <th>SERIVE TYPE</th>
                    <th>PROVIDER</th>
                    <th>ESTIMATE COST</th>
                    <th>REAL COST</th>
                    <th>BEFORE</th>
                    <th>AFTER</th>
                    <th>INVOICE</th>
                    <th>STATUS</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>STAGING</td>
                    <td>SAFE LOCS</td>
                    <td style="text-align:center;">$360</td>
                    <td>$3900</td>
                    <td><a href="#">UPLOAD<a></td>
                    <td><a href="#">UPLOAD<a></td>
                    <td><a href="#">UPLOAD<a></td>
                    <td>BENDING</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>TOUCH UP</td>
                    <td>ABSCADS</td>
                    <td style="text-align:center;">$360</td>
                    <td>$3900</td>
                    <td><a href="#">UPLOAD<a></td>
                    <td><a href="#">UPLOAD<a></td>
                    <td><a href="#">UPLOAD<a></td>
                    <td>APPROVED</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>CLEARN UP</td>
                    <td>ABSCADS</td>
                    <td style="text-align:center;">$360</td>
                    <td>$3900</td>
                    <td>NONE</td>
                    <td><a href="#">UPLOAD<a></td>
                    <td>NONE</td>
                    <td>BENDING</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>YARDWORK</td>
                    <td>ABSCADS</td>
                    <td style="text-align:center;">$360</td>
                    <td>$3900</td>
                    <td style="text-align:center;">-</td>
                    <td><a href="#">UPLOAD<a></td>
                    <td>NONE</td>
                    <td>APPROVED</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>INSPECTION</td>
                    <td>ABSCADS</td>
                    <td style="text-align:center;">$360</td>
                    <td>$3900</td>
                    <td style="text-align:center;">-</td>
                    <td><a href="#">VIEW<a></td>
                    <td style="text-align:center;">-</td>
                    <td>APPROVED</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>STORAGR</td>
                    <td>ABSCADS</td>
                    <td style="text-align:center;">$360</td>
                    <td>$3900</td>
                    <td style="text-align:center;">-</td>
                    <td style="text-align:center;">-</td>
                    <td><a href="#">VIEW<a></td>
                    <td>BENDING</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>RELOCATION HOME</td>
                    <td>ABSCADS</td>
                    <td style="text-align:center;">$360</td>
                    <td>$3900</td>
                    <td></td>
                    <td></td>
                    <td><a href="#">VIEW<a></td>
                    <td>APPROVED</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>PHOTOGRAPHY</td>
                    <td>ABSCADS</td>
                    <td style="text-align:center;">$360</td>
                    <td>$3900</td>
                    <td style="text-align:center;">-</td>
                    <td style="text-align:center;">-</td>
                    <td style="text-align:center;">-</td>
                    <td style="text-align:center;">-</td>
                </tr>
                </tbody>
            </table>
            <div class="financial" style="display:block; float:left; margin-left:20px;">
                <div class="line" style="float:left;">
                    <hr style="height:1px; width:500px;border:none;border-top:2px solid #a9a9a9; float:left;" />
                </div>
                <div class="total">
                    <h5>Total Cost: $5000.00</h5>
                    <h5>Final Commission: $15000.00</h5>
                </div>
                <div class="selectTeamPart">
                    <div class="selectTeam">
                        <div class="dropdown">
                            <select>
                                <option value="1">SELECT TEAM</option>
                                <option value="2">ONE</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div style="height:150px;"></div>
            </div>
        </div>
    </div>
</div>
</div>
</body>