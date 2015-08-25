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
 * Description of Users
 *
 * Από τον Controller Users καθορίζονται όλες οι ενέργεις που πρέπει να κάνει 
 * ένας χρήστης για να εγγραφή, να συνδεθεί και να αποσυνδεθεί από την εφαρμογή.
 * 
 * @package Olympus
 * @category Controller
 * @author WarriorZeus
 */
class Users extends CI_Controller {

    /** 
     * Στην μεταβλητή $data "$this->data" αποθηκεύονται όλες οι πληροφορίες που
     * Θέλουμε να μεταφέρουμε στην διεπαφή με τον χρήστη.
     */
    private $data;
    
    public function __construct() {
        parent::__construct();
        
        // Βοηθητική λειτουργεία κατά τον προγραμματισμό της εφαρμογής.
        $this->output->enable_profiler($this->config->item('app_profiling'));
        
        // Ορισμός CSRF για την ασφάλεια της εφαρμογής.
        $this->data["csrf"] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
    }
    
    public function signup() {
        $this->load->view('signup_view', $this->data);
    }
    
    public function do_signup() {
        // Φώρτοση της κλάσσης ρυπτωγράφησης.
        $this->load->library('encrypt');
        
        // Φώρτοση του μοντέλου χρήστες.
        $this->load->model("Users_model");
        
        // Ορισμός user_email από POST
        $user_email = $this->input->post('user_email', TRUE);
        // Ορισμός username από POST
        $username = $this->input->post('username', TRUE);
        // Ορισμός user_password από POST
        $user_password = $this->input->post('user_password', TRUE);
        // Κρυπτογράφηση κωδικού χρήστη
        $encr_password = md5($user_password);
        
        // Εγγραφή νέου χρήστη στη βάση δεδομένων
        $check = $this->Users_model->user_signup($user_email, $username, $encr_password);
        
        if($check["status"] === TRUE) {
            $this->data["signup_status"] = "success";
            $this->data["user_data"] = $check["data"];
            
            $this->load->view('do_signup_view', $this->data);
        } else {
            $this->data["signup_status"] = "error";
            $this->load->view('do_signup_view', $this->data);
        }
        
    }
    
    public function login() {
        $this->load->view('login_view', $this->data);
    }
    
    public function do_login() {
        $this->load->library('encrypt');
        $this->load->model("Users_model");
        
        // Ορισμός user_email από POST
        $user_email = $this->input->post('user_email', TRUE);
        // Ορισμός username από POST
        $user_password = $this->input->post('user_password', TRUE);
        // Κρυπτογράφηση κωδικού χρήστη
        $encr_password = md5($user_password);
        
        $result = $this->Users_model->user_login($user_email, $encr_password);
        echo $result;
    }
    
    public function logout() {
        
    }
}
