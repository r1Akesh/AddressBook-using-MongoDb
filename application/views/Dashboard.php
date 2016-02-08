<?php

//session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/listnav.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/book.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:700' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/functions.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js" type="text/javascript"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js" type="text/javascript"></script>
</head>

<body id='DashboardBody'>
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
<nav class="navbar navbar-inverse">
    <div class="col-md-12 container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Address Book |</a>
        </div>
        <ul class="nav navbar-nav">
            <li>
                <label class="btn btn-default" id="add_contact" data-backdrop="static" data-keyword="false"
                       data-toggle="modal" data-target="#add_contacts"><span
                        class='glyphicon glyphicon-plus-sign'></span>
                </label>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $_SESSION['user_name']; ?>
                    <span class="caret"></span>
                </a>

                <ul class="dropdown-menu">
                    <li><a href="#change_password" tabindex="-1" data-backdrop="static" data-keyword="false"
                           data-toggle="modal" data-target="#change_password">Change Password</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() . 'dashboard_controller/logout' ?>">Logout</a>
                    </li>

                </ul>
            </li>

        </ul>
    </div>
</nav>

<!--modal to add contacts-->
<div id="add_contacts" class="modal fade" tabindex=-1 role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Contacts</h4>
            </div>
            <form id='AddContacts' class="form-horizontal">
                <div class="modal-body">
                    <div class='col-md-12'>
                        <div class="form-group" id="contact_name">

                            <input class="form-control pull-left" name="first_name" id="fname" placeholder="First Name"
                                   onblur="" required>
                            <input class="form-control pull-right" name="last_name" id="lname" placeholder="Last Name"
                                   onblur="" required>
                        </div>
                        
                    </div>

                    <div class="contact_address">
                        <textarea class="form-control pull-left" rows="4" id="location" name="address"
                                  placeholder="Address" onblur="validate_address(this.id)" required></textarea>
                         
                        <div class="col-xs-5 pull-right" id="result"></div>
                    </div>
                    <div class="col-md-12">
                        
                    </div>
                    <br>
                    
                    <br>

                    <legend>Contacts</legend>
                    
                    <div class="row">
                        <div class='col-md-12' id="contact">
                            <div class="input-group pull-left">
                                <span class='input-group-addon'><i class='fa fa-phone fa-fw'></i></span>
                                <input type="text" class="form-control pull-left" id="phone" name="phone"
                                       placeholder="Phone Number" onblur="" required>

                            </div>
                            <div class="input-group pull-right">
                                <span class='input-group-addon'><i class='fa fa-envelope-o fa-fw'></i></span>
                                <input  class="form-control " id="email_addresss" name="email" placeholder="Email" onblur="DuplicateContact()" required>
                            </div>
                        </div>
                   </div>

                    
                    <br>
                    

                    <div class="alert alert-info" id="DuplicateContactAlert">Contact exists
                    </div>
                    <div class="alert alert-info" id="FormNotValid" style="display:none">Form is Not Valid.</div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="addContact" type="button" name='submit' onclick="add_contact()" >Add
                    </button>
                </div>
            </form>
        </div>
        <!-- modal content -->
    </div>
    <!-- /.modal dialog -->
</div>
<br><br>
<!--Div to display contact details -->
<div class="col-md-3" id="contacts_list">
    <div class=" col-md-12  " id="contact_table">
        <ul class="list-group pull-left">
            <?php
            $i = 0;
            $j = 10;
            $k = 20;
            $ascii = 0;
            if (isset($contacts)) {
                foreach ($contacts as $contact) {

                    if (ord(strtoupper($contact['First_Name'][0])) != $ascii) {
                        $ascii = ord(strtoupper($contact['First_Name'][0]));
                        $letter = strtoupper($contact['First_Name'][0]);
                        echo "
                                 <html>
                                                                     
                                       <div class='col-md-1' id='contact_letters'  ><strong class='lead'> $letter </strong></div>
                                   
                                     
                                 </html>
                               ";

                    }

                    ?>


                    <div class="row col-md-12" id="contact_group">

                        <li id="<?php echo $contact['_id']; ?>" onclick="get_contact_details(this.id)"
                            style="display:inline;">
                            <b><?php
                                echo $contact['First_Name'] . ' ' . $contact['Last_Name'] ?></b>
                        </li>
                        <li style="display:inline;">
                            <button value=<?php echo $contact['_id']; ?> id="<?php echo $i; ?>"
                                    onclick="delete_contact(this.id)" class="btn btn-default pull-right"
                                    title="delete Contact"><span class="glyphicon glyphicon-erase"></span>

                            </button>
                        </li>
                        <li style="display:inline">
                            <button class="btn btn-default pull-right" id="<?php echo $j; ?>"
                                    value=<?php echo $contact['email']; ?>  onclick="ShowModal(this.id)"><span
                                    class="glyphicon glyphicon-envelope"></span></button>

                        </li>
                        <li style="display:inline">
                            <button class="btn btn-default pull-right" id="<?php echo $k; ?>"
                                    value=<?php echo $contact['_id']; ?>  onclick="edit_contact(this.id)"><span
                                    class="glyphicon glyphicon-edit"></span></button>

                        </li>
                    </div>


                    <?php

                    ++$i;
                    ++$j;
                    ++$k;

                }
            }
            ?>
        </ul>
    </div>
    <br><br>
</div>


<!-- Div to display contact details-->
<div class="col-md-5 col-md-offset-1" style="" id="details"></div>
<!--Div to show map-->

<div class="col-md-8 col-md-offset-0" id="map_canvas"></div>

<!--Modal to send email-->
<div id="Sendmail" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Send Email</h4>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input class="form-control " id="To" type="text" style="border:none" readonly>
                </div>
                <br><br>
                <textarea class="form-control" id="message" placeholder="Type Your mesage" rows="5"></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="send()">Send</button>
            </div>
        </div>
    </div>
</div>
<!-- modal for change password-->
<div id="change_password" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Change Password</h4>
            </div>
            <div class="modal-body">
                <form id="ChangePassword" name="change">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" id="CurrentPassword" name='CurrentPassword' placeholder='Current Password' required>
                    </div>
                    <br><br>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" id="NewPassword" name="NewPassword" placeholder='New Password' required>
                    </div>
                    <br><br>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" placeholder='Confirm Password' required>
                    </div>
                    <br><br><br>
                    <button class="btn btn-primary" type="button" name="submit" class="form-control"
                            onclick="change_password()">Done
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id='edit_contact' class='modal fade' role='dialog'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <h4 class='modal-title'>Edit Contact</h4>
            </div>
            <form id="EditContact">
                <div class='modal-body'>

                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='form-group' id='contact_name'>
                                <input type='text' class='form-control pull-left' id='first_name' name='fname' placeholder='First Name'>
                                <input type='text' class='form-control pull-right' id='last_name' name='lname' placeholder='Last Name'>
                            </div>
                        </div>
                    </div>
                    <br><br>

                    <div>
                        <textarea class='form-control' rows='4' id='address_edit' name="AddressEdit" onblur='validate_updated(this.id)'></textarea>

                    </div>
                    <div class='col-xs-12' id='result1' style='display:none'></div>

                    <br><br>

                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='input-group pull-left' style='width:40%'>
                                <span class='input-group-addon'><i class='fa fa-phone fa-fw'></i></span>
                                <input type='text' class='form-control' id="contact_edit" name='phone' onblur=''>
                            </div>
                            <div class='input-group pull-right' style='width:40%'>
                                <span class='input-group-addon'><i class='fa fa-envelope-o fa-fw'></i></span>
                                <input type='email' class='form-control' id='email' name='email'>
                            </div>
                        </div>
                    </div>

                     <div class="alert alert-info" id="EditNotValid" style="display:none">Form is Not Valid.</div>
                </div>
                <div class='modal-footer'>
                    <button type='button' onclick='save_edit(this.id)' class='btn btn-default' id='edit_button'>Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/jquery-listnav.js"></script>


</body>

<script type="text/javascript">
    $('#contacts_list ul').listnav();
    
    
</script>
</html>