<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/book.css">
    <script src="<?php echo base_url(); ?>resources/js/functions.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/jquery.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js" type="text/javascript"></script>

</head>

<body>
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

<div id="main_window">
    <div class="col-md-4">
        <a href="#"><h1>Address Book</h1></a>
    </div>
    <div class="col-md-4 col-md-push-7">
        <label class="btn btn-primary  btn-md" data-backdrop="static" data-toggle="modal" data-target="#Login_modal">
            <span class="glyphicon glyphicon-log-in"></span>&nbsp;Login
        </label>
    </div>
</div>

<div id="Login_modal"  class="modal fade" role="dialog">
    <div class="modal-dialog " id="LoginDialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Sign-In</h4>
            </div>
            <form id="user_register" method="post">
                <div class="modal-body">
                    <div id="signup_field" style="display:none">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" id="first_name" name="FirstName"
                                   onblur=""
                                   placeholder="First Name" required>
                        </div>
                        <br><br>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class=" form-control" id="last_name" name="LastName"
                                   onblur=""
                                   placeholder="Last Name" required>
                        </div>
                        <br><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></span>
                        <input type="text" class="form-control" id="username" name="user_name" placeholder="Username"
                               onblur="check_username(this.id)" required>
                    </div>
                    <br><br>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                               onblur=""
                               required>
                    </div>

                </div>
                <div class="modal-footer">
                    <div id="alert_message" class="alert alert-success fade in" style="display: none"
                         onclick="">
                        <a href="#" class="close" aria-label="close">&times;</a>Invalid Credentials.Try Again
                    </div>
                    <div id="username_alert" class="alert alert-success fade in" style="display: none"
                         onclick="hide_alert(this.id)">
                        <a href="#" class="close" aria-label="close">&times;</a>Username already registered..
                    </div>

                    <button class="btn btn-success" id="signin_btn" name="SignIn" type="button" onclick="check_user()">
                        Sign-In
                    </button>
                    <button type="button" class="btn btn-primary" id="signup" onclick="hide(this.id)">SignUp</button>
                    <button class="btn btn-success" id="register" name="SignUp" type="button" onclick="usr_register()">Register </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/bootstrap.min.js"></script>
<script>


</script>
</body>
</html>

