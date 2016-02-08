<?php
class Database_Model extends CI_Model
{
		
  public function login($username,$password){
		$condition=array(
			'User_Name' => $username,
			'password'  => md5($password)
			);
		$user=$this->mongo_db->get_where('Users',$condition);
		return count($user);
	}

	public function signup($first_name,$last_name,$user_name,$password){
       $document=array(
       	  'First_Name' => $first_name,
       	  'Last_Name'  => $last_name,
          'User_Name'  => $user_name,
          'password'   => md5($password)
       	);
       $collection = $this->mongo_db->db->selectCollection('Users');
       $registered   =  $collection->insert($document);
      return $registered['ok'];
     
	}

	public function check_username($username){
		$condition = array(
            'User_Name'=>$username
			);
		$user = $this->mongo_db->get_where('Users',$condition);
		return count($user);
	}


	public function add_contacts($data){
		$collection = $this->mongo_db->db->selectCollection('contacts');
		$added = $collection->insert($data);
		return $added['ok'];
	}


	public function CheckDuplicateContacts( $username,$FirstName, $LastName, $phone){
		$condition = array(
          'username'  => $username,
          'First_Name'=> $FirstName,
          'Last_Name' => $LastName,
          'PhoneNumber'=>$phone
			);
		$exists = $this->mongo_db->get_where('contacts',$condition);
		return count($exists);
	 }

	public function load_contacts($username)
    {
    	$condition  = array(
          'username'=>$username
    		);
       $result = $this->mongo_db->db->contacts->find($condition);
       $result->sort(array('First_Name'=>1));
       return $result;

    }


    public function get_contact_details($user_id)
    {
        $condition = array(
             '_id'=> new MongoID($user_id)
        	);
        $details = $this->mongo_db->get_where('contacts',$condition);
        return $details;
    }


     public function delete_contact($user_id)
    {
       $condition = array(
             '_id'=> new MongoID($user_id)
        	);
       $this->mongo_db->where($condition)->delete('contacts');
    }


     public function change_password($user_name, $current_password, $new_passowrd)
    {
        $data = array(
            'password' => $new_passowrd
        );
        $condition = array(
            'User_Name' => $user_name,
            'password'  => $current_password
        );
        $this->mongo_db->where($condition)->set($data)->update('users');
       

    }

     public function GetDetails($contact_id){
         $condition = array(
             '_id'=> new MongoID($contact_id)
         );
         $details=$this->mongo_db->get_where('contacts',$condition);
         return $details;
     }

     public function SaveEdit($condition,$contact_id){
         $this->mongo_db->where('_id', new MongoId($contact_id))->set($condition)->update('contacts');
     }

     public function ChangePassword($CurrentPassword,$NewPassword,$username){
         $condition=array(
             'User_Name'=>$username,
             'password'=>md5($CurrentPassword)
         );
         $change=array(
             'password'=>md5($NewPassword)
         );
         $this->mongo_db->where($condition)->set($change)->update('Users');
     }

}
?>