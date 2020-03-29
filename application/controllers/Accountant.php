<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Accountant extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
    }
    
    public function index()
    {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($this->session->userdata('accountant_login') == 1)
            redirect(site_url('accountant/panel'), 'refresh');
    }

    function notification($param1 ='', $param2 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->db->where('id', $param2);
            $this->db->delete('notification');
            $this->session->set_flashdata('flash_message', get_phrase('successfully_deleted'));
            redirect(base_url() . 'accountant/notifications/', 'refresh');
        }
    }
    
    function group($param1 = "group_message_home", $param2 = "")
    {
      if ($this->session->userdata('accountant_login') != 1)
          redirect(base_url(), 'refresh');
      $max_size = 2097152;

      if ($param1 == 'group_message_read') 
      {
        $page_data['current_message_thread_code'] = $param2;
      }
      else if($param1 == 'send_reply')
      {
        if (!file_exists('uploads/group_messaging_attached_file/')) 
        {
          $oldmask = umask(0);
          mkdir ('uploads/group_messaging_attached_file/', 0777);
        }
        if ($_FILES['attached_file_on_messaging']['name'] != "") 
        {
          if($_FILES['attached_file_on_messaging']['size'] > $max_size)
          {
            $this->session->set_flashdata('error_message' , "2MB Allowed");
            redirect(base_url() . 'accountant/group/group_message_read/'.$param2, 'refresh');
          }
          else
          {
            $file_path = 'uploads/group_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
            move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
          }
        }

        $this->crud_model->send_reply_group_message($param2);
        $this->session->set_flashdata('flash_message', get_phrase('message_sent'));
        redirect(base_url() . 'accountant/group/group_message_read/'.$param2, 'refresh');
      }
      $page_data['message_inner_page_name']   = $param1;
      $page_data['page_name']                 = 'group';
      $page_data['page_title']                = get_phrase('message_group');
      $this->load->view('backend/index', $page_data);
    }
    
    function message($param1 = 'message_home', $param2 = '', $param3 = '') 
    {
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if ($this->session->userdata('accountant_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($_GET['id'] != "")
        {
            $notify['status'] = 1;
            $this->db->where('id', $_GET['id']);
            $this->db->update('notification', $notify);
        }
        if ($param1 == 'send_new') 
        {
            $this->session->set_flashdata('flash_message' , get_phrase('message_sent'));
            $message_thread_code = $this->crud_model->send_new_private_message();
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/messages/" . $_FILES["file_name"]["name"]);
            redirect(base_url() . 'accountant/message/message_read/' . $message_thread_code, 'refresh');
        }
        if ($param1 == 'send_reply') 
        {
            $this->session->set_flashdata('flash_message' , get_phrase('reply_sent'));
            $this->crud_model->send_reply_message($param2);
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/messages/" . $_FILES["file_name"]["name"]);
            redirect(base_url() . 'accountant/message/message_read/' . $param2, 'refresh');
        }
        if ($param1 == 'message_read') 
        {
            $page_data['current_message_thread_code'] = $param2; 
            $this->crud_model->mark_thread_messages_read($param2);
        }
        $page_data['infouser'] = $param2;
        $page_data['message_inner_page_name']   = $param1;
        $page_data['page_name']                 = 'message';
        $page_data['page_title']                = get_phrase('private_messages');
        $this->load->view('backend/index', $page_data);
    }
    
    function birthdays()
    {
        if ($this->session->userdata('accountant_login') != 1)
        { 
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'birthdays';
        $page_data['page_title'] = get_phrase('birthdays');
        $this->load->view('backend/index', $page_data);
    }
    
    function polls($param1 = '', $param2 = '')
    {
      if ($this->session->userdata('accountant_login') != 1)
      {
            redirect(base_url(), 'refresh');
      }
      if($param1 == 'response')
      {
         $data['poll_code'] = $this->input->post('poll_code');
         $data['answer'] = $this->input->post('answer');
         $user = $this->session->userdata('login_user_id');
         $user_type = $this->session->userdata('login_type');
         $data['user'] = $user_type ."-".$user;
         $data['date'] = date('d M, Y');
         $this->db->insert('poll_response', $data);
      }
    }
    
     function notifications()
    {
        if($this->session->userdata('accountant_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        
        $page_data['page_name']  =  'notifications';
        $page_data['page_title'] =  get_phrase('your_notifications');
        $this->load->view('backend/index', $page_data);
    }
    
    function news($param1 = '', $param2 = '', $param3 = '') 
    {
        if ($this->session->userdata('accountant_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name'] = 'news';
        $page_data['page_title'] = get_phrase('news');
        $this->load->view('backend/index', $page_data);
    }
    
     function calendar($param1 = '', $param2 = '', $param3 = '') 
    {
        if ($this->session->userdata('accountant_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if($_GET['id'] != "")
        {
            $notify['status'] = 1;
            $this->db->where('id', $_GET['id']);
            $this->db->update('notification', $notify);
        }
        $page_data['page_name'] = 'calendar';
        $page_data['page_title'] = get_phrase('calendar_events');
        $this->load->view('backend/index', $page_data);
    }
    
    function my_profile($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        include_once 'src/Google_Client.php';
        include_once 'src/contrib/Google_Oauth2Service.php';
        $clientId = $this->db->get_where('settings', array('type' => 'google_sync'))->row()->description; //Google client ID
        $clientSecret = $this->db->get_where('settings', array('type' => 'google_login'))->row()->description; //Google client secret
        $redirectURL = base_url().'auth/sync/'; //Callback URL
        //Call Google API
        $gClient = new Google_Client();
        $gClient->setApplicationName('google');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectURL);
        $google_oauthV2 = new Google_Oauth2Service($gClient);
        $authUrl = $gClient->createAuthUrl();
        $output = filter_var($authUrl, FILTER_SANITIZE_URL);
        if($param1 == 'remove_facebook')
        {
          $data['fb_token']    =  "";
          $data['fb_id']    =  "";
          $data['fb_photo']    =  "";
          $data['fb_name']       =  "";
          $data['femail'] = "";
          unset($_SESSION['access_token']);
          unset($_SESSION['userData']);
          $this->db->where('accountant_id', $this->session->userdata('login_user_id'));
          $this->db->update('accountant', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('facebook_delete'));
            redirect(base_url() . 'accountant/my_profile/', 'refresh');
        }
        if($param1 == '1')
        {
            $this->session->set_flashdata('error_message' , get_phrase('google_err'));
            redirect(base_url() . 'accountant/my_profile/', 'refresh');
        }
        if($param1 == '3')
        {
            $this->session->set_flashdata('error_message' , get_phrase('facebook_err'));
            redirect(base_url() . 'accountant/my_profile/', 'refresh');
        }
        if($param1 == '2')
        {
            $this->session->set_flashdata('flash_message' , get_phrase('google_true'));
            redirect(base_url() . 'accountant/my_profile/', 'refresh');
        }
        if($param1 == '4')
        {
            $this->session->set_flashdata('flash_message' , get_phrase('facebook_true'));
            redirect(base_url() . 'accountant/my_profile/', 'refresh');
        }  
        if($param1 == 'remove_google')
        {
            include_once 'src/Google_Client.php';
            include_once 'src/contrib/Google_Oauth2Service.php';
            $gClient = new Google_Client();
            $gClient->setApplicationName('google');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectURL);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            $data['g_oauth'] = "";
            $data['g_fname'] = "";
            $data['g_lname'] = "";
            $data['g_picture'] = "";
            $data['link'] = "";
            $data['g_email'] = "";  
            $this->db->where('accountant_id', $this->session->userdata('login_user_id'));
            $this->db->update('accountant', $data);
            
            unset($_SESSION['token']);
            unset($_SESSION['userData']);
            $gClient->revokeToken();
            $this->session->set_flashdata('flash_message' , get_phrase('google_delete'));
            redirect(base_url() . 'accountant/my_profile/', 'refresh');
        }
        if ($param1 == 'update_profile') 
        {
            $md5 = md5(date('d-m-y H:i:s'));
            $data['email']        = $this->input->post('email');
            $data['idcard']     = $this->input->post('idcard');
            $data['phone']     = $this->input->post('phone');
            $data['address']     = $this->input->post('address');
            if($this->input->post('password') != ""){
                $data['password']     = sha1($this->input->post('password'));   
            }
            if($_FILES['userfile']['name'] != ""){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            $this->db->where('accountant_id', $this->session->userdata('login_user_id'));
            $this->db->update('accountant', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/accountant_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            redirect(base_url() . 'accountant/accountant_update/', 'refresh');
        }
        $page_data['page_name']  = 'my_profile';
        $page_data['page_title'] = get_phrase('my_profile');
        $page_data['output'] = $output;
        $this->load->view('backend/index', $page_data); 
    }
    
    function accountant_update($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        include_once 'src/Google_Client.php';
        include_once 'src/contrib/Google_Oauth2Service.php';
        $clientId = $this->db->get_where('settings', array('type' => 'google_sync'))->row()->description; //Google client ID
        $clientSecret = $this->db->get_where('settings', array('type' => 'google_login'))->row()->description; //Google client secret
        $redirectURL = base_url().'auth/sync/'; //Callback URL
        //Call Google API
        $gClient = new Google_Client();
        $gClient->setApplicationName('google');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectURL);
        $google_oauthV2 = new Google_Oauth2Service($gClient);
        $authUrl = $gClient->createAuthUrl();
        $output = filter_var($authUrl, FILTER_SANITIZE_URL);
        
        $page_data['page_name']  = 'accountant_update';
        $page_data['page_title'] = get_phrase('update_information');
        $page_data['output'] = $output;
        $this->load->view('backend/index', $page_data); 
    }
    
    function students_payments($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        $page_data['page_name']  = 'students_payments';
        $page_data['page_title'] = get_phrase('student_payments');
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data); 
    }
    
    function expense($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'create') 
        {
            $data['title']               =   $this->input->post('title');
            $data['expense_category_id'] =   $this->input->post('expense_category_id');
            $data['description']         =   $this->input->post('description');
            $data['payment_type']        =   'expense';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['month']              =   date('m');
            $data['timestamp']           =   $this->input->post('timestamp');
            $data['month']             =   date('M');
            $data['year']                =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->insert('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));

            redirect(base_url() . 'accountant/expense', 'refresh');
        }
        if ($param1 == 'edit') 
        {
            $data['title']               =   $this->input->post('title');
            $data['expense_category_id'] =   $this->input->post('expense_category_id');
            $data['description']         =   $this->input->post('description');
            $data['payment_type']        =   'expense';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['year']                =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->where('payment_id' , $param2);
            $this->db->update('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'accountant/expense', 'refresh');
        }
        if ($param1 == 'delete') {
            $this->db->where('payment_id' , $param2);
            $this->db->delete('payment');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'accountant/expense/', 'refresh');
        }
        $page_data['page_name']  = 'expense';
        $page_data['page_title'] = get_phrase('expense');
        $this->load->view('backend/index', $page_data); 
    }

    function expense_category($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'create') {
            $data['name']   =   $this->input->post('name');
            $this->db->insert('expense_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'accountant/expense');
        }
        if ($param1 == 'update') {
            $data['name']   =   $this->input->post('name');
            $this->db->where('expense_category_id' , $param2);
            $this->db->update('expense_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'accountant/expense');
        }
        if ($param1 == 'delete') {
            $this->db->where('expense_category_id' , $param2);
            $this->db->delete('expense_category');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'accountant/expense');
        }
        $page_data['page_name']  = 'expense';
        $page_data['page_title'] = get_phrase('expense');
        $this->load->view('backend/index', $page_data);
    }
    
    function invoice($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'bulk') 
        {
            foreach ($this->input->post('student_id') as $id) 
            {
                $data['student_id']         = $id;
                $data['class_id']         = $this->input->post('class_id');
                $data['title']              = html_escape($this->input->post('title'));
                $data['description']        = html_escape($this->input->post('description'));
                $data['amount']             = html_escape($this->input->post('amount'));
                $data['due']                = $data['amount'];
                $data['status']             = $this->input->post('status');
                $data['creation_timestamp'] = date('d M, Y');
                $data['year']               = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

                $this->db->insert('invoice', $data);
                $invoice_id = $this->db->insert_id();

                $data2['invoice_id']        =   $invoice_id;
                $data2['student_id']        =   $id;
                $data2['title']             =   html_escape($this->input->post('title'));
                $data2['description']       =   html_escape($this->input->post('description'));
                $data2['payment_type']      =  'income';
                $data2['method']            =   $this->input->post('method');
                $data2['amount']            =   html_escape($this->input->post('amount'));
                $data2['timestamp']         =   strtotime($this->input->post('date'));
                $data2['month']             =   date('M');
                $data2['year']               =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

                $this->db->insert('payment' , $data2);
            }
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'accountant/students_payments/', 'refresh');
        }
        if ($param1 == 'create') 
        {
            $data['student_id']         = $this->input->post('student_id');
            $data['class_id']           = $this->input->post('class_id');
            $data['title']              = $this->input->post('title');
            $data['description']        = $this->input->post('description');
            $data['amount']             = $this->input->post('amount');
            $data['due']                = $data['amount'];
            $data['status']             = $this->input->post('status');
            $data['creation_timestamp'] = date('d M, Y');
            $data['year']               = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            
            $this->db->insert('invoice', $data);
            $invoice_id = $this->db->insert_id();

            $data2['invoice_id']        =   $invoice_id;
            $data2['student_id']        =   $this->input->post('student_id');
            $data2['title']             =   $this->input->post('title');
            $data2['description']       =   $this->input->post('description');
            $data2['payment_type']      =  'income';
            $data2['method']            =   $this->input->post('method');
            $data2['amount']            =   $this->input->post('amount');
            $data2['timestamp']         =   strtotime($this->input->post('date'));
            $data2['month']             =   date('M');
            $data2['year']              =  $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->insert('payment' , $data2);

            $student_name = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->name;
            $student_email = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->email;
            $student_phone = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->phone;
            $parent_id = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->parent_id;
            $parent_phone = $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->phone;
            $parent_email = $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->email;
            $notify = $this->db->get_where('settings' , array('type' => 'p_new_invoice'))->row()->description;
            $notify2 = $this->db->get_where('settings' , array('type' => 's_new_invoice'))->row()->description;

              $message = "A new invoice has been generated for " . $student_name;
              $sms_status = $this->db->get_where('settings' , array('type' => 'sms_status'))->row()->description;

            if($notify == 1)
            {
              if ($sms_status == 'msg91') 
                {
                    $result = $this->crud_model->send_sms_via_msg91($message, $parent_phone);
                }
              else if ($sms_status == 'twilio') 
              {
                  $this->crud_model->twilio($message,"".$parent_phone."");
              }
              else if ($sms_status == 'clickatell') 
              {
                  $this->crud_model->clickatell($message,$parent_phone);
              }
            }
            $this->crud_model->parent_new_invoice($student_name, "".$parent_email."");
            if($notify2 == 1)
            {
              if ($sms_status == 'msg91') 
                {
                    $result = $this->crud_model->send_sms_via_msg91($message, $student_phone);
                }
              else if ($sms_status == 'twilio') 
              {
                  $this->crud_model->twilio($message,"".$student_phone."");
              }
              else if ($sms_status == 'clickatell') 
              {
                  $this->crud_model->clickatell($message,$student_phone);
              }
            }
            $this->crud_model->student_new_invoice($student_name, "".$student_email."");
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'accountant/students_payments/', 'refresh');
        }
        if ($param1 == 'do_update') 
        {
            $data['title']              = $this->input->post('title');
            $data['description']        = $this->input->post('description');
            $data['amount']             = $this->input->post('amount');
            $data['status']             = $this->input->post('status');

            $this->db->where('invoice_id', $param2);
            $this->db->update('invoice', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'accountant/students_payments/', 'refresh');
        }else if ($param1 == 'edit') 
        {
            $page_data['edit_data'] = $this->db->get_where('invoice', array('invoice_id' => $param2))->result_array();
        }

        if ($param1 == 'delete') 
        {
            $this->db->where('invoice_id', $param2);
            $this->db->delete('invoice');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'accountant/students_payments/', 'refresh');
        }
        $page_data['page_name']  = 'invoice';
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data);
    }
    
    function invoice_details($id)
    {
        if ($this->session->userdata('accountant_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $page_data['invoice_id'] = $id;
        $page_data['page_title'] = get_phrase('invoice_details');
        $page_data['page_name']  = 'invoice_details';
        $this->load->view('backend/index', $page_data);
    }
    
    function new_payment($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['classes']    = $this->db->get('class')->result_array();
        $page_data['page_name']  = 'new_payment';
        $page_data['page_title'] = get_phrase('new_payment');
        $this->load->view('backend/index', $page_data);
    }
    
    function payments($param1 = '' , $param2 = '' , $param3 = '') 
    {
        if ($this->session->userdata('accountant_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'payments';
        $page_data['page_title'] = get_phrase('payments');
        $this->load->view('backend/index', $page_data); 
    }
    
    function panel()
    {
        if ($this->session->userdata('accountant_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if($_GET['id'] != "")
        {
            $notify['status'] = 1;
            $this->db->where('id', $_GET['id']);
            $this->db->update('notification', $notify);
        }
        $page_data['page_name']  = 'panel';
        $page_data['page_title'] = get_phrase('accountant_dashboard');
        $this->load->view('backend/index', $page_data);
    }

    
}
