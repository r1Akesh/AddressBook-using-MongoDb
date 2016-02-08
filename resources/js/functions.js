function check_user() {
    var user_name = document.getElementById("username").value.trim();
    var password = document.getElementById("password").value.trim();
    $.post($('#base_url').val() + 'welcome/login', {user_name: user_name, password: password}, function (data) {
        if (data.trim() == 1) {
            window.location.href = $('#base_url').val() + 'welcome/show_dashboard';
        } else {
            document.getElementById("alert_message").style.display = 'block';
        }
    });
}


function hide(id) {
    document.getElementById("register").style.display = 'block';
    document.getElementById("signin_btn").style.visibility = 'hidden';
    document.getElementById("signup_field").style.display = 'block';
    document.getElementById("signup").style.display = "none";
}


function usr_register() {
     jQuery.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "");
 var validator = $('#user_register').validate({
    rules:
    {
        FirstName:
        {
            required:true,
            lettersonly:true

        },
        LastName:'required',
        user_name:'required',
        password:'required'
    },
    messages:
    {
        FirstName:'',
        LastName:'',
        user_name:'',
        password:''
    }
  });
  var isvalid=$('#user_register').valid();
    if(!isvalid){
       validator.focusInvalid();
    }
   else{

    var first_name = document.getElementById("first_name").value.trim();
    var last_name = document.getElementById("last_name").value.trim();
    var user_name = document.getElementById("username").value.trim();
    var password = document.getElementById("password").value.trim();
    $.post($('#base_url').val() + "welcome/SignUp", {
        first_name: first_name,
        last_name: last_name,
        user_name: user_name,
        password: password
    }, function (data) {
        if (data == 1) {
            document.getElementById("register").style.display = 'none';
            document.getElementById("signin_btn").style.visibility = 'visible';
            document.getElementById("signup_field").style.display = 'none';
            document.getElementById("signup").style.display = "none";
            document.getElementById("username").value = '';
            document.getElementById("password").value = '';
        } else {
            alert("User not registered");
        }
        //console.log(data);
    });    
  }
}

function check_username(id) {
    var UserName = document.getElementById(id).value.trim();
    var value = document.getElementById('signup_field').style.display;
    if (value == 'block') {
        $.post($('#base_url').val() + "welcome/check_username", {username: UserName}, function (data) {
            if (data.trim() != 0) {
                document.getElementById('username_alert').style.display = 'block';
                document.getElementById("user_register").disabled = true;
            }
            else {
                document.getElementById("user_register").disabled = false;
                document.getElementById('username_alert').style.display = 'none';
            }

        });
    }
}


function add_contact() {
 jQuery.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "");    
 var validator=   $("#AddContacts").validate({
       rules:
       {
        first_name:
        {
            lettersonly:true,
            required:true

        },
        last_name:'required',
        address:'required',
        phone:
        {
            required:true,
            minlength:10,
            digits:true
        },
        email:
        {
            required:true,
            email:true
        }
       },
       messages:
       {
        first_name:'',
        last_name:'',
        address:'',
        phone:'',
        email:''
       }

    });    
     var isvalidate=$("#AddContacts").valid();
     if(!isvalidate){
        document.getElementById('FormNotValid').style.display='block';
        validator.focusInvalid();

     } else{

    var fname = document.getElementById('fname').value.trim();
    var lname = document.getElementById('lname').value.trim();
    var location = document.getElementById('location').value.trim();
    var phone = document.getElementById('phone').value.trim();
    var email = document.getElementById('email_addresss').value.trim();
    $.post($('#base_url').val() + "dashboard_controller/add_contacts", {
        first_name: fname,
        last_name: lname,
        address: location,
        phone: phone,
        email: email
    }, function (data) {
        if (data.trim()) {
            window.location.href = $('#base_url').val() + 'welcome/show_dashboard';
        }
        ;
    });    
  }
}


function validate_address(id) {
    var address;
    document.getElementById("addContact").disabled = false;
    address = document.getElementById(id).value;
    $.post($('#base_url').val() + "dashboard_controller/verify_address", {address: address}, function (data) {
        $('div#result').html(data);
        if (data.trim() == 'Address Not valid') {
            document.getElementById('addContact').disabled = true;
        }
        else {
            document.getElementById('addContact').disabled = false;
        }
    });
}


function DuplicateContact() {
    var FirstName = document.getElementById('fname').value.trim();
    var LastName = document.getElementById('lname').value.trim();
    var phone = document.getElementById('phone').value.trim();
    var email_id = document.getElementById('email_addresss').value.trim();


    $.post($('#base_url').val() + "dashboard_controller/DuplicateContact", {
        FirstName: FirstName,
        LastName: LastName,
        phone: phone
    }, function (data) {
        if (data.trim() == 1) {
            document.getElementById('DuplicateContactAlert').style.display = 'block';
            document.getElementById('addContact').disabled = true;
        }
        else {
            document.getElementById('DuplicateContactAlert').style.display = 'none';
            document.getElementById('addContact').disabled = false;
        }

    });
}

function get_contact_details(id) {
    var user_id = id;
    $.post($('#base_url').val() + "dashboard_controller/get_contact_details", {user_id: user_id}, function (data) {
        $('div#details').html(data);


    });
}


function delete_contact(id) {
    var response = confirm('Do you want to delete this contact?');
    if (response) {
        var user_id = document.getElementById(id).value;
        $.post($('#base_url').val() + "dashboard_controller/delete_contact", {user_id: user_id}, function (data) {
            window.location.href = $('#base_url').val() + 'welcome/show_dashboard';
        });
    }
}

function ShowModal(id) {
    var email = document.getElementById(id).value.trim();
    document.getElementById('To').value = email;
    $("#Sendmail").modal();
}

function send() {
    var To = document.getElementById('To').value;
    var message = document.getElementById('message').value.trim();
    if (message != '') {
        $.post($('#base_url').val() + "dashboard_controller/SendEmail", {To: To, message: message}, function (data) {
            if (data.trim() == 'sent') {
                alert("email sent.");
                window.location.href = $('#base_url').val() + 'welcome/show_dashboard';
            }
            else {
                alert("email not sent");
            }
        });
    }

}

function edit_contact(id) {
    var contact_id = document.getElementById(id).value;
    var name;
    $.post($('#base_url').val() + "dashboard_controller/EditContact", {contact_id: contact_id}, function (data) {
        var details = $.parseJSON(data);
        var First_Name = details[0]['First_Name'];
        var Last_Name = details[0]['Last_Name'];
        var address = details[0]['Address'];
        var PhoneNumber = details[0]['PhoneNumber'];
        var email = details[0]['email'];

        document.getElementById('first_name').value = First_Name;
        document.getElementById('last_name').value = Last_Name;
        document.getElementById('address_edit').value = address;
        document.getElementById('contact_edit').value = PhoneNumber;
        document.getElementById('email').value = email;
        document.getElementById('edit_button').value = contact_id;
        $("#edit_contact").modal();
    });
}

function save_edit(id) {
   var validator = $('#EditContact').validate({
       rules:
       {
          fname:'required',
          lname:'required',
          AddressEdit:'required',
          phone:
          {
            required:true,
            digits:true,
            minlength:10
          },
          email:
          {
            required:true,
            email:true
          }
       },
       messages:
       {
        fname:'',
        lname:'',
        AddressEdit:'',
        phone:'',
        email:''
       }

   });
   var isvalidate=$("#EditContact").valid();
       if (!isvalidate) {
        document.getElementById('EditNotValid').style.display='block';
        validator.focusInvalid();
       }
      else{
    var contact_id = document.getElementById(id).value;
    var FirstName = document.getElementById('first_name').value
    var LastName = document.getElementById('last_name').value;
    var address = document.getElementById('address_edit').value;
    var PhoneNumber = document.getElementById('contact_edit').value;
    var email = document.getElementById('email').value;
    $.post($('#base_url').val() + "dashboard_controller/SaveEdit", {
        contact_id: contact_id,
        FirstName: FirstName,
        LastName: LastName,
        address: address,
        email: email,
        PhoneNumber: PhoneNumber
    }, function (data) {
        window.location.href = $('#base_url').val() + 'welcome/show_dashboard';
    });   
  }
}

function change_password() {

 var validator = $('#ChangePassword').validate({

        rules:
        {
            CurrentPassword:'required',
            NewPassword:'required',
            ConfirmPassword:
            {
                required:true,
                equalTo:'#NewPassword'
            }
        },
        messages:
        {
            CurrentPassword:'',
            NewPassword:'',
            ConfirmPassword:''
        }
    });
    var isvalid=$('#ChangePassword').valid();
       if (!isvalid) {
         validator.focusInvalid();
       } else{
     var CurrentPassword = document.getElementById('CurrentPassword').value;
    var NewPassword = document.getElementById('NewPassword').value;
    $.post($('#base_url').val() + "dashboard_controller/ChangePassword", {
        CurrentPassword: CurrentPassword,
        NewPassword: NewPassword
    }, function (data) {
        window.location.href = $('#base_url').val() + 'welcome/show_dashboard';
    });   
   }
}

function validate_updated(id) {
    var address = document.getElementById(id).value.trim();
    document.getElementById('edit_button').disabled = false;
    document.getElementById('result1').style.display = 'block';

    $.post($('#base_url').val() + "dashboard_controller/verify_address", {address: address}, function (data) {
        $('div#result1').html(data);
        if (data.trim() == 'Address Not valid') {
            document.getElementById('edit_button').disabled = true;
        }
        else {
            document.getElementById('edit_button').disabled = false;
        }
    });
}






    

