<?php

// Start Session
session_start();

/*
Template Name: Superuser Create Account
*/


    // init Data

    // Validate Mandatory Fields
    function date_validated()
    {
        $firstName = test_input($_POST["firstName"]);
        $lastName = test_input($_POST["lastName"]);
        $contactNumber = test_input($_POST["contactNumber"]);
        $email = test_input($_POST["email"]);
        $isAdmin  = (int)$_POST["isAdmin"] == 'TRUE' ? true : false;
        $isAdmin = test_input($isAdmin);

        global $errorMessage;
        global $isError;
        if (empty($firstName) || empty($lastName) || empty($contactNumber) || empty($email) || empty($isAdmin)) {
            $errorMessage = "Mandatory fields are empty";
            $isError = true;
            return false;
        } else {
            $errorMessage = null;
            $isError = false;
            return true;
        }
    }

    // Create Account
    if(isset($_POST['create_account']) && date_validated() === true) {
        // Generate Password
        $password = generate_password();
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $contactNumber = $_POST['contactNumber'];
        $email = $_POST['email'];
        $isAdmin = $_POST['isAdmin'] == 'TRUE' ? true : false;

        // Check if account exist
        $isAccountExistResult = is_account_exist($email);
        $isAccountExistResultRow = mysqli_fetch_array($isAccountExistResult);
        if(!is_null($isAccountExistResultRow)){
            $errorMessage = "Email already exist";
            $isError = true;
        }
        else{
            $errorMessage = null;
            $isError = false;
            // Create Account
            $createAccountArray = array (
                "password" => $password,
                "firstName" => $firstName,
                "lastName" => $lastName,
                "contactNumber" => $contactNumber,
                "email" => $email,
                "isAdmin" => $isAdmin
            );

            $createAccountResult = superuser_create_account($createAccountArray);
            $result_rows = [];
            while($row = mysqli_fetch_array($createAccountResult))
            {
                $result_rows[] = $row;
            }
            $accountID = $result_rows[0]["LAST_INSERT_ID()"];

            // Send User Password By Email
            if(!is_null($accountID)){
                $sendEmailResult = send_user_password($email, $firstName, $lastName,$password);
            }

            // Navigate
            if(!is_null($accountID)){
                $url = get_home_url() . '/superuser-member-info';
                echo("<script>window.location.assign('$url');</script>");
            }
        }
    }
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
    }

    .formPart {
        margin-right: 40px;
        margin-left: 40px;
        padding-top: 40px;
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
        color:#616161;
        font-weight: bold;
    }

    .inputPart {
        padding-top: 30px;
        background-color: #eeeeee;
        color:#a9a9a9;
        height: 350px;
        width: 600px;
        font-size: 11px;
    }

    .requireTitle {
        width: 150px;
        padding-left: 20px;
        float:left;
        padding-top: 5px;
    }

    .inputContent {
        overflow: hidden;
        margin-bottom: 30px;
    }

    fieldset {
        overflow: hidden
    }

    .radioButtonPart {
        float: left;
        clear: none;
    }

    label {
        float: left;
        clear: none;
        display: block;
        padding: 5px 4em 0 3px;
    }

    input[type=radio],
    input.radio {
        float: left;
        clear: none;
        padding-top: 5px;
        margin: 2px 0 0 2px;
        font-size: 11px !important;
        color:#616161;
    }

    .selectTeam {
        float: left;
        clear: none;
        margin: 2px 0 0 2px;
    }

    .dropdown {
        height: 40px;
        width: 50px;
    }

    select {
        border-radius: 3px;
        height: 30px;
        width: 80px;
    }

    .create {
        float:left;
        padding-left: 20px;
        margin-left: 0px;
    }

    .createButton {
        border-radius: 5px;
        background-color: #32323a;
        border: #32323a;
        color:#fff;
        font-weight: 100px;
        height: 30px;
        width: 100px;
    }

    .error-message a{
        color: red;
        font-size: 100%;
    }
</style>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>NuStream 新勢力地產</title>
</head>
<body>
<div id="container">
    <?php
    include_once(__DIR__ . '/navigation.php');
    ?>
    <div id="main">
        <div class="formPart">
            <div class="title"><h4>CREATE NEW ACCOUNT</h4></div>
            <form method="post">
                <div class="form-group inputPart">
                    <div class="requireTitle">MEMBER NAME</div>
                    <div class="inputContent">
                        <input class="prayer-first-name" type="text" name="firstName" id="firstName" placeholder=" FIRST NAME*" style="font-size:15px;" require/>
                        <input class="prayer-email" type="text" name="lastName" id="lastNmae" placeholder=" LAST NAME*" style="font-size:15px;" require/>
                    </div>
                    <div class="requireTitle">CONTACT NUMBER*</div>
                    <div class="inputContent contactNum">
                        <input class="prayer-email" type="text" name="contactNumber" id="contactNumber" placeholder="CONTACT NUMBER*" style="font-size:15px;" size="45" require/>
                    </div>
                    <div class="requireTitle">EAMIL ADDRESS*</div>
                    <div class="inputContent contactEmail">
                        <input class="prayer-email" type="email" name="email" id="emailAddress" placeholder="EAMIL ADDRESS*" style="font-size:15px;" size="45" require/>
                    </div>
                    <div class="requireTitle">ACCOUNT TYPE*</div>
                    <div class="inputContent" >
                        <fieldset>
                            <div class="radioButtonPart">
                                <input type="radio" class="radio" name="isAdmin" value="TRUE" checked="checked" style="margin-top:5px;" />
                                <label for="teamLeader" style="font-weight:100 !important; ">ADMIN</label>
                                <input type="radio" class="radio" name="isAdmin" value="FALSE" style="margin-top:5px;" />
                                <label for="teamLeader" style="font-weight:100 !important;">ACCOUNTANT</label>
                            </div>
                        </fieldset>
                    </div>
                    <div class="create">
                        <input class="createButton" type="submit" value="Create" name="create_account">
                        <?php
                        if($isError){
                            echo '<div class="error-message"><a>';
                            global $errorMessage;
                            echo $errorMessage;
                            echo '</a></div>';
                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
