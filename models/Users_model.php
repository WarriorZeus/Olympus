<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * O L Y M P U S
 * 
 * Ο παρακάτω κώδικας αποτελεί κομμάτι της εφαρμογής “Olympus”. Με την εφαρμογή 
 * ο προγραμματιστής μπορεί να κατασκευάσει μια διαδικτυακή εφαρμογή και να 
 * διαχειριστεί τους χρήστες της. Η εφαρμογή είναι γραμμένη πάνω στο 
 * προγραμματιστικό πλαίσιο CodeIgniter και χρησιμοποιεί ακόμα δημοφιλείς 
 * πλατφόρμες προγραμματισμού όπως το Jquery και το Bootstrap. 
 */

/**
 * Description of Users_model
 *
 * @author zeus
 */
class Users_model extends CI_Model {
    
    private $result;

    public function __construct() {
        parent::__construct();
    }
    
    public function check_email($email) {
        $sql = "SELECT * FROM users WHERE user_email = '$email'";
        $this->result = $this->db->query($sql);
        return $this->result->num_rows();
    }
    
    public function check_username($username) {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $this->result = $this->db->query($sql);
        return $this->result->num_rows();
    }
    
    public function user_signup($user_email, $username, $user_password) {
        
        $data = array(
            "user_email" => $user_email,
            "username" => $username,
            "user_password" => $user_password,
            "user_type" => "newbee"
        );
        
        $check = $this->db->insert("users", $data);
        
        if($check === TRUE) {
            return array("status" => TRUE, "data" => array("user_email" => $user_email, "username" => $username));
        } else {
            return array("status" => FALSE, "msg" => "Η εγγραφή δεν ολοκληρώθηκε!");
        }
    }
    
    public function user_login($user_email, $user_password) {
 
        $sql = "SELECT * FROM users WHERE user_email = '$user_email' AND user_password = '$user_password'";
        $this->result = $this->db->query($sql);
        return $this->result->num_rows();
    }
}
