<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class Welcome extends CI_Controller {

	public function index(){
	    $this->load->view('welcome_message');
	   // $this->load->model('database_model');
	}

   //Function for login
   public function login(){
	   	$username = $_POST['user_name'];
	   	$password = $_POST['password'];
	   	$this->load->model('database_model');
	    $Valid = $this->database_model->login($username,$password);
       if ($Valid==1) {
      
       $_SESSION['user_name']=$username;
	    echo $Valid;  
      }  
    }

    //Function for sign-up 
    public function SignUp(){
  	 $first_name = $_POST['first_name'];
     $last_name  = $_POST['last_name'];
     $user_name  = $_POST['user_name'];
     $password   = $_POST['password'];
     $this->load->model('database_model');
     $registered = $this->database_model->signup($first_name,$last_name,$user_name,$password);
     echo $registered;
    }

  //Function to Show Dashboard.
  public function show_dashboard(){
    $username = $_SESSION['user_name'];
    $this->load->model('database_model');
    $data['contacts']= $this->database_model->load_contacts($username);
    $this->load->view('Dashboard', $data);
  }  

   //Function to check existing usernames.
   public function check_username(){
   	    $username = $_POST['username'];
        $this->load->model('database_model');
        $result=$this->database_model->check_username($username); 
         echo $result;  
   }

   

}
?>


	



