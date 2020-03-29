<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Librarian extends CI_Controller
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
    if ($this->session->userdata('librarian_login') != 1)
    {
      redirect(base_url(), 'refresh');
    }
    if ($this->session->userdata('librarian_login') == 1)
    {
        redirect(base_url() . 'librarian/panel/', 'refresh');
    }
  }

  function notification($param1 ='', $param2 = '')
    {
        if ($this->session->userdata('librarian_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->db->where('id', $param2);
            $this->db->delete('notification');
            $this->session->set_flashdata('flash_message', get_phrase('successfully_deleted'));
            redirect(base_url() . 'librarian/notifications/', 'refresh');
        }
    }

    function news($param1 = '', $param2 = '', $param3 = '') 
    {
        if ($this->session->userdata('librarian_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name'] = 'news';
        $page_data['page_title'] = get_phrase('news');
        $this->load->view('backend/index', $page_data);
    }
    
     function update_book($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('librarian_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['book_id'] = $param1;
        $page_data['page_name']  =   'update_book';
        $page_data['page_title'] = get_phrase('update_book');
        $this->load->view('backend/index', $page_data);
    }
    
    function group($param1 = "group_message_home", $param2 = "")
    {
      if ($this->session->userdata('librarian_login') != 1)
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
            redirect(base_url() . 'librarian/group/group_message_read/'.$param2, 'refresh');
          }
          else
          {
            $file_path = 'uploads/group_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
            move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
          }
        }

        $this->crud_model->send_reply_group_message($param2);
        $this->session->set_flashdata('flash_message', get_phrase('message_sent'));
        redirect(base_url() . 'librarian/group/group_message_read/'.$param2, 'refresh');
      }
      $page_data['message_inner_page_name']   = $param1;
      $page_data['page_name']                 = 'group';
      $page_data['page_title']                = get_phrase('message_group');
      $this->load->view('backend/index', $page_data);
    }
    
    function calendar($param1 = '', $param2 = '', $param3 = '') 
    {
        if ($this->session->userdata('librarian_login') != 1) 
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
    
    function message($param1 = 'message_home', $param2 = '', $param3 = '') 
    {
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if ($this->session->userdata('librarian_login') != 1)
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
            redirect(base_url() . 'librarian/message/message_read/' . $message_thread_code, 'refresh');
        }
        if ($param1 == 'send_reply') 
        {
            $this->session->set_flashdata('flash_message' , get_phrase('reply_sent'));
            $this->crud_model->send_reply_message($param2);
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/messages/" . $_FILES["file_name"]["name"]);
            redirect(base_url() . 'librarian/message/message_read/' . $param2, 'refresh');
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
    
    function panel()
    {
        if ($this->session->userdata('librarian_login') != 1)
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
        $page_data['page_title'] = get_phrase('librarian_dashboard');
        $this->load->view('backend/index', $page_data);
    }

    function book_request($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('librarian_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == "accept")
        {
            $data['status'] = 1;
            $this->db->update('book_request', $data, array('book_request_id' => $param2));
            $book_id        = $this->db->get_where('book_request', array('book_request_id' => $param2))->row()->book_id;
            $issued_copies  = $this->db->get_where('book', array('book_id' => $book_id))->row()->issued_copies;
            $data2['issued_copies'] = $issued_copies + 1;
            $this->db->update('book', $data2, array('book_id' => $book_id));
            $this->session->set_flashdata('flash_message', get_phrase('request_accepted_successfully'));
            redirect(site_url('librarian/book_request/'), 'refresh');
        }
        if ($param1 == "reject")
        {
            $data['status'] = 2;
            $this->db->update('book_request', $data, array('book_request_id' => $param2));
            $this->session->set_flashdata('flash_message', get_phrase('request_rejected_successfully'));
            redirect(site_url('librarian/book_request'), 'refresh');
        }
        $data['page_name']  = 'book_request';
        $data['page_title'] = get_phrase('book_request');
        $this->load->view('backend/index', $data);
    }

    function my_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('librarian_login') != 1)
        {
          redirect(site_url('login'), 'refresh');
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
          $this->db->where('librarian_id', $this->session->userdata('login_user_id'));
          $this->db->update('librarian', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('facebook_delete'));
            redirect(base_url() . 'librarian/my_profile/', 'refresh');
        }
        if($param1 == '1')
        {
            $this->session->set_flashdata('error_message' , get_phrase('google_err'));
            redirect(base_url() . 'librarian/my_profile/', 'refresh');
        }
        if($param1 == '3')
        {
            $this->session->set_flashdata('error_message' , get_phrase('facebook_err'));
            redirect(base_url() . 'librarian/my_profile/', 'refresh');
        }
        if($param1 == '2')
        {
            $this->session->set_flashdata('flash_message' , get_phrase('google_true'));
            redirect(base_url() . 'librarian/my_profile/', 'refresh');
        }
        if($param1 == '4')
        {
            $this->session->set_flashdata('flash_message' , get_phrase('facebook_true'));
            redirect(base_url() . 'librarian/my_profile/', 'refresh');
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
            $this->db->where('librarian_id', $this->session->userdata('login_user_id'));
            $this->db->update('librarian', $data);
            
            unset($_SESSION['token']);
            unset($_SESSION['userData']);
            $gClient->revokeToken();
            $this->session->set_flashdata('flash_message' , get_phrase('google_delete'));
            redirect(base_url() . 'librarian/my_profile/', 'refresh');
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
            $this->db->where('librarian_id', $this->session->userdata('login_user_id'));
            $this->db->update('librarian', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/librarian_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            redirect(base_url() . 'librarian/librarian_update/', 'refresh');
        }
        $page_data['output'] = $output;
        $page_data['page_name']  = 'my_profile';
        $page_data['page_title'] = get_phrase('my_profile');
        $this->load->view('backend/index', $page_data);
    }
    
    function polls($param1 = '', $param2 = '')
    {
      if ($this->session->userdata('librarian_login') != 1)
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
        if($this->session->userdata('librarian_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        
        $page_data['page_name']  =  'notifications';
        $page_data['page_title'] =  get_phrase('your_notifications');
        $this->load->view('backend/index', $page_data);
    }
    
    function librarian_update($librarian_id)
    {
        if ($this->session->userdata('librarian_login') != 1) 
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
        
        $page_data['page_name']  = 'librarian_update';
        $page_data['page_title'] =  get_phrase('update_information');
        $page_data['output']  =  $output;
        $this->load->view('backend/index', $page_data);
    }
    
    function library($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('librarian_login') != 1){
             redirect(base_url(), 'refresh');
        } 
        if ($param1 == 'create') 
        {
            $fileTypes = array('pdf', 'doc', 'docx', '.mp3', 'wav', 'mp4', 'mov', 'wmv', 'txt'); // Allowed file extensions
            $fileParts = pathinfo($_FILES['file_name']['name']);
            if($this->input->post('type')  == 'virtual')
            {
                if (in_array(strtolower($fileParts['extension']), $fileTypes)) 
                {               
                    $data['name']        = $this->input->post('name');
                    $data['description'] = $this->input->post('description');
                    $data['price']       = $this->input->post('price');
                    $data['author']      = $this->input->post('author');
                    $data['total_copies']      = $this->input->post('total_copies');
                    $data['class_id']    = $this->input->post('class_id');
                    $data['type']        = $this->input->post('type');
                    $data['file_name']   = $_FILES["file_name"]["name"];
                    $data['status']      = $this->input->post('status');
                    move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/library/" . $_FILES["file_name"]["name"]);
                    $this->db->insert('book', $data);
                    $this->session->set_flashdata('flash_message' , get_phrase('successfully_uploaded'));
                    redirect(base_url() . 'librarian/library/', 'refresh');
                } 
                else 
                {
                    $this->session->set_flashdata('error_message' , "Extension not allowed.");
                    redirect(base_url() . 'librarian/library/' , 'refresh');
                }
            }else
            {
                $data['name']        = $this->input->post('name');
                $data['description'] = $this->input->post('description');
                $data['price']       = $this->input->post('price');
                $data['total_copies']      = $this->input->post('total_copies');
                $data['author']      = $this->input->post('author');
                $data['class_id']    = $this->input->post('class_id');
                $data['type']        = $this->input->post('type');
                $data['status']      = $this->input->post('status');
                $this->db->insert('book', $data);
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
                redirect(base_url() . 'librarian/library/', 'refresh');
            }
        }
        if ($param1 == 'update') 
        {
            $fileTypes = array('pdf', 'doc', 'docx', '.mp3', 'wav', 'mp4', 'mov', 'wmv', 'txt'); // Allowed file extensions
            $fileParts = pathinfo($_FILES['file_name']['name']);
            if($this->input->post('type')  == 'virtual')
            {
                    $data['name']        = $this->input->post('name');
                    $data['description'] = $this->input->post('description');
                    $data['price']       = $this->input->post('price');
                    $data['author']      = $this->input->post('author');
                    $data['class_id']    = $this->input->post('class_id');
                    $data['total_copies']      = $this->input->post('total_copies');
                    $data['type']        = $this->input->post('type');
                    if($_FILES["file_name"]["size"] > 0){
                        $data['file_name']   = $_FILES["file_name"]["name"];
                    }
                    $data['status']      = $this->input->post('status');
                    move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/library/" . $_FILES["file_name"]["name"]);
                    $this->db->where('book_id', $param2);
                    $this->db->update('book', $data);
                    $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
                    redirect(base_url() . 'librarian/update_book/'.$param2, 'refresh');
            }else
            {
                $data['name']        = $this->input->post('name');
                $data['description'] = $this->input->post('description');
                $data['price']       = $this->input->post('price');
                $data['author']      = $this->input->post('author');
                $data['class_id']    = $this->input->post('class_id');
                $data['total_copies']      = $this->input->post('total_copies');
                $data['type']        = $this->input->post('type');
                $data['status']      = $this->input->post('status');
                $this->db->where('book_id', $param2);
                $this->db->update('book', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
                redirect(base_url() . 'librarian/update_book/'.$param2, 'refresh');
            }
        }
        if ($param1 == 'delete') 
        {
            $this->db->where('book_id', $param2);
            $this->db->delete('book');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'librarian/library', 'refresh');
        }
        $id = $this->input->post('class_id');
        if ($id == '')
        {
            $id = $this->db->get('class')->first_row()->class_id;
        }
        $page_data['id']  = $id;
        $page_data['page_name']  = 'library';
        $page_data['page_title'] = get_phrase('library');
        $this->load->view('backend/index', $page_data);
    }
    
    function birthdays()
    {
        if ($this->session->userdata('librarian_login') != 1)
        { 
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'birthdays';
        $page_data['page_title'] = get_phrase('birthdays');
        $this->load->view('backend/index', $page_data);
    }
    
}
