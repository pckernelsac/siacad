<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller 
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->database();
        $this->load->library('session');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }

    function clear_cache()
    {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }
    
    function newpassword($email , $password)
    {
        require("class.phpmailer.php");
        $email_sub  = get_phrase('recover_your_password');
        $email_msg  = get_phrase('success_password')."<br>";
        $email_msg  .= get_phrase('new_password').": <b>". $password ."<b/><br>.";
        $data = array(
            'email_msg' => $email_msg
        );
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        $mail->SetFrom($this->db->get_where('settings', array('type' => 'system_email'))->row()->description, $this->db->get_where('settings', array('type' => 'system_name'))->row()->description);
        $mail->Subject = $email_sub;
        $mail->Body = $this->load->view('backend/mails/notify.php',$data,TRUE);
        $mail->AddAddress($email);
        if(!$mail->Send()) 
        {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }

    public function index() 
    {
        if ($this->session->userdata('admin_login') == 1)
        {
            redirect(base_url() . 'admin/tablero/', 'refresh');
        }
        if ($this->session->userdata('teacher_login') == 1)
        {
            redirect(base_url() . 'teacher/panel/', 'refresh');
        }
        if ($this->session->userdata('librarian_login') == 1)
        {
            redirect(base_url() . 'librarian/panel/', 'refresh');
        }
        if ($this->session->userdata('accountant_login') == 1)
        {
            redirect(base_url() . 'accountant/panel/', 'refresh');
        }
        if ($this->session->userdata('student_login') == 1)
        {
            redirect(base_url() . 'student/panel/', 'refresh');
        }
        if ($this->session->userdata('parent_login') == 1)
        {
            redirect(base_url() . 'parents/panel/', 'refresh');
        }
        $this->load->view('backend/login');
    }


    function auth() 
    {
      $username = $this->input->post('username');
      $password = $this->input->post('password');
      $credential = array('username' => $username, 'password' => sha1($password));

      $query = $this->db->get_where('admin', $credential);
      if ($query->num_rows() > 0) 
      {
        $row = $query->row();
        $this->session->set_userdata('admin_login', '1');
        $this->session->set_userdata('admin_id', $row->admin_id);
        $this->session->set_userdata('login_user_id', $row->admin_id);
        $this->session->set_userdata('name', $row->first_name);
        $this->session->set_userdata('login_type', 'admin');
        $status = read_file('index.php');
        $status = str_replace('item_status',  '1',   $status);
        write_file('index.php', $status);
        redirect(base_url() . 'admin/tablero/', 'refresh');
      }

      $query = $this->db->get_where('teacher', $credential);
      if ($query->num_rows() > 0) 
      {
          $row = $query->row();
          $this->session->set_userdata('teacher_login', '1');
          $this->session->set_userdata('teacher_id', $row->teacher_id);
          $this->session->set_userdata('login_user_id', $row->teacher_id);
          $this->session->set_userdata('name', $row->first_name);
          $this->session->set_userdata('login_type', 'teacher');
          redirect(base_url() . 'teacher/panel/', 'refresh');
      }

      $query = $this->db->get_where('student', $credential);
      if ($query->num_rows() > 0) 
      {
          $row = $query->row();
          $this->session->set_userdata('student_login', $row->student_session);
          $this->session->set_userdata('student_id', $row->student_id);
          $this->session->set_userdata('login_user_id', $row->student_id);
          $this->session->set_userdata('name', $row->first_name);
          $this->session->set_userdata('login_type', 'student');
          redirect(base_url() . 'student/panel/', 'refresh');
      }

      $query = $this->db->get_where('parent', $credential);
      if ($query->num_rows() > 0) 
      {
          $row = $query->row();
          $this->session->set_userdata('parent_login', '1');
          $this->session->set_userdata('parent_id', $row->parent_id);
          $this->session->set_userdata('login_user_id', $row->parent_id);
          $this->session->set_userdata('name', $row->first_name);
          $this->session->set_userdata('login_type', 'parent');
          redirect(base_url() . 'parents/panel/', 'refresh');
      }
      
      $query = $this->db->get_where('accountant', $credential);
      if ($query->num_rows() > 0) 
      {
          $row = $query->row();
          $this->session->set_userdata('accountant_login', '1');
          $this->session->set_userdata('accountant_id', $row->accountant_id);
          $this->session->set_userdata('login_user_id', $row->accountant_id);
          $this->session->set_userdata('name', $row->first_name);
          $this->session->set_userdata('login_type', 'accountant');
          redirect(base_url() . 'accountant/panel/', 'refresh');
      }
      
      $query = $this->db->get_where('librarian', $credential);
      if ($query->num_rows() > 0) 
      {
          $row = $query->row();
          $this->session->set_userdata('librarian_login', '1');
          $this->session->set_userdata('librarian_id', $row->librarian_id);
          $this->session->set_userdata('login_user_id', $row->librarian_id);
          $this->session->set_userdata('name', $row->first_name);
          $this->session->set_userdata('login_type', 'librarian');
          redirect(base_url() . 'librarian/panel/', 'refresh');
      }
      $this->session->set_flashdata('error', '1');
      redirect(base_url(), 'refresh');
    }

    function lost_password($param1 = '', $param2 = '')
    {
        if($param1 == 'recovery')
        {
            $email  = $_POST["field"];
            $reset_account_type = '';
            $new_password = substr( md5( rand(100000000,20000000000) ) , 0,7);
            $new_hashed_password    =   sha1($new_password);
            $query = $this->db->get_where('admin' , array('email' => $email));
            if ($query->num_rows() > 0) 
            {
                $this->db->where('email' , $email);
                $this->db->update('admin' , array('password' =>     $new_hashed_password));
                $this->newpassword($email , $new_password);
            }
            $query = $this->db->get_where('teacher' , array('email' => $email));
            if ($query->num_rows() > 0) 
            {
                $this->db->where('email' , $email);
                $this->db->update('teacher' , array('password' => $new_hashed_password));

                $this->newpassword($email , $new_password);
            }
            $query = $this->db->get_where('parent' , array('email' => $email));
            if ($query->num_rows() > 0) 
            {
                $this->db->where('email' , $email);
                $this->db->update('parent' , array('password' => $new_hashed_password));
                $this->newpassword($email , $new_password);
            }
            $query = $this->db->get_where('student' , array('email' => $email));
            if ($query->num_rows() > 0) 
            {
                $this->db->where('email' , $email);
                $this->db->update('student' , array('password' => $new_hashed_password));
                $this->newpassword($email , $new_password);
            }
            $query = $this->db->get_where('accountant' , array('email' => $email));
            if ($query->num_rows() > 0) 
            {
                $this->db->where('email' , $email);
                $this->db->update('accountant' , array('password' => $new_hashed_password));
                $this->newpassword($email , $new_password);
            }
            $query = $this->db->get_where('librarian' , array('email' => $email));
            if ($query->num_rows() > 0) 
            {
                $this->db->where('email' , $email);
                $this->db->update('librarian' , array('password' => $new_hashed_password));
                $this->newpassword($email , $new_password);
            }
            $this->session->set_flashdata('success_recovery', '1');
            redirect(base_url(), 'refresh'); 
        }
        $this->load->view('backend/lost');
    }

    
    function logout() 
    { 
      $this->session->sess_destroy();
      $this->session->set_flashdata('logout_notification', 'logged_out');
      redirect(base_url(), 'refresh');
    }
}