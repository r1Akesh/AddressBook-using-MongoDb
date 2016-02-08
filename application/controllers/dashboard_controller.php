<?php
session_start();

class Dashboard_Controller extends CI_Controller
{
    
    //Function to add new contacts.
    public function add_contacts()
    {
        $data = array(
            'username'   => $_SESSION['user_name'],
            'First_Name' => $_POST['first_name'],
            'Last_Name'  => $_POST['last_name'],
            'Address'    => $_POST['address'],
            'PhoneNumber'=> $_POST['phone'],
            'email'      => $_POST['email']
        );
        $this->load->model('database_model');
        $result = $this->database_model->add_contacts($data);
        echo $result;
    }

    
    //Function to verify Address.
    public function verify_address()
    {
        $address = $_POST['address'];
            $url = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=' . urlencode($address);
        $results = json_decode(file_get_contents($url), 1);

        $parts = array(
            'address' => array('street_number', 'route'),
            'city'    => array('locality'),
            'state'   => array('administrative_area_level_1'),
            'zip'     => array('postal_code'),
        );
        if (!empty($results['results'][0]['address_components'])) {
            $ac = $results['results'][0]['address_components'];
            foreach ($parts as $need => &$types) {
                foreach ($ac as &$a) {
                    if (in_array($a['types'][0], $types)) $address_out[$need] = $a['short_name'];
                    elseif (empty($address_out[$need])) $address_out[$need] = '';
                }
            }
            echo "City:" . $address_out['city'];
            echo "<br>State:" . $address_out['state'];
            echo "<br>Zip:" . $address_out['zip'];

        } else echo ' ';
        $Address     = urlencode($address);
        $request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=" . $Address . "&sensor=true";
        $xml    = simplexml_load_file($request_url) or die("url not loading");
        $status = $xml->status;
        if ($status == "OK") {
            $Lat = $xml->result->geometry->location->lat;
            $Lon = $xml->result->geometry->location->lng;
            //$LatLng = "$Lat,$Lon";
            echo "<br>Latitude: " . $Lat;
            echo "<br>";
            echo "longitude: " . $Lon;
        } else {
            echo "Address Not valid";
        }
    }

   
   //Function to check Duplicate contacts
    public function DuplicateContact()
    {
        $username  = $_SESSION['user_name'];
        $FirstName = $_POST['FirstName'];
        $LastName  = $_POST['LastName'];
        $phone     = $_POST['phone'];
        $this->load->model('database_model');
        $check = $this->database_model->CheckDuplicateContacts($username, $FirstName, $LastName, $phone);
        echo $check;

    }


    public function logout()
    {
        unset($_SESSION['user_name']);
        session_destroy();
        redirect("/welcome");
    }


    public function get_contact_details()
    {

        $user_id = $_POST['user_id'];
        $this->load->model('database_model');
        $data = $this->database_model->get_contact_details($user_id);
        $firstname = $data[0]['First_Name'];
        $lastname  = $data[0]['Last_Name'];
        $address   = $data[0]['Address'];
        $phone     = $data[0]['PhoneNumber'];
        $email     = $data[0]['email'];
        echo "
                <address>
                        <p id='contact_name' class='text-capitalize'>$firstname $lastname</p><br><br>
                        <i class='fa fa-road fa-lg'></i> &nbsp <span class='contact_details'> $address </span>
                      <br>
                       
                      <i class='fa fa-phone fa-lg'></i> &nbsp <small class='contact_details'>$phone</small>
                       <br>
                           <i class='fa fa-envelope fa-lg'></i>&nbsp <small class='contact_details'>$email</small>
               </address>
     
                <script>
            var userLocation = '$address';

    if (GBrowserIsCompatible()) {
        var geocoder = new GClientGeocoder();
        geocoder.getLocations(userLocation, function (locations) {
            if (locations.Placemark) {
                var north = locations.Placemark[0].ExtendedData.LatLonBox.north;
                var south = locations.Placemark[0].ExtendedData.LatLonBox.south;
                var east = locations.Placemark[0].ExtendedData.LatLonBox.east;
                var west = locations.Placemark[0].ExtendedData.LatLonBox.west;

                var bounds = new GLatLngBounds(new GLatLng(south, west),
                    new GLatLng(north, east));

                var map = new GMap2(document.getElementById('map_canvas'));

                map.setCenter(bounds.getCenter(), map.getBoundsZoomLevel(bounds));
                map.addOverlay(new GMarker(bounds.getCenter()));
            }
        });
    }  
      </script>
    ";
        //echo $data[0]['username'];
    }



    public function delete_contact()
    {

        $user_id = $_POST['user_id'];
        $this->load->model('database_model');
        $this->database_model->delete_contact($user_id);
        redirect("/welcome/show_dashboard");
    }


    public function SendEmail()
    {
        $to = $_POST['To'];
        $message = $_POST['message'];
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'rakesh.roushan259@gmail.com',
            'smtp_pass' => 'toocooltoocozy'
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('rakesh.roushan259@gmail.com');
        $this->email->to($to);
        $this->email->message($message);
        if ($this->email->send()) {
            echo "sent";
        } else {
            show_error($this->email->print_debugger());
        }
    }


    public function change_password()
    {
               $user_name = $_SESSION['user_name'];
        $current_password = $_POST['password'];
        $new_password     = $_POST['new_password'];
        $this->load->model('database_model');
        $this->database_model->change_password($user_name, $current_password, $new_password);


    }

    public function EditContact()
    {
        $contact_id = $_POST['contact_id'];
        $this->load->model('database_model');
        $details = $this->database_model->GetDetails($contact_id);
        echo json_encode($details);
    }

    public function SaveEdit()
    {
        $contact_id = $_POST['contact_id'];
        $condition = array(
            'First_Name' => $_POST['FirstName'],
            'Last_Name'  => $_POST['LastName'],
            'Address'    => $_POST['address'],
            'email'      => $_POST['email'],
            'PhoneNumber' => $_POST['PhoneNumber']

        );
        $PhoneNumber = $_POST['PhoneNumber'];
        $this->load->model('database_model');
        $this->database_model->SaveEdit($condition, $contact_id);

    }

    public function ChangePassword()
    {
        $username    = $_SESSION['user_name'];
        $CurrentPassword = $_POST['CurrentPassword'];
        $NewPassword     = $_POST['NewPassword'];
        $this->load->model('database_model');
        $this->database_model->ChangePassword($CurrentPassword, $NewPassword, $username);
        
    }

}

?>