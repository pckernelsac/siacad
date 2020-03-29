<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
    class Admin extends CI_Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->library('session');
            $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            $this->output->set_header('Pragma: no-cache');    
            $this->load->library('excel');
        }
        
        public function index()
        {
            if ($this->session->userdata('admin_login') != 1)
            {
                redirect(base_url(), 'refresh');
            }
            if ($this->session->userdata('admin_login') == 1)
            {
                redirect(base_url() . 'admin/panel/', 'refresh');
            }
        }
    
        function panel($param1 = '', $param2 = '')
        {
            if ($this->session->userdata('admin_login') != 1)
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
            $page_data['page_title'] = get_phrase('dashboard');
            $this->load->view('backend/index', $page_data);
        }
        
        function news($param1 = '', $param2 = '', $param3 = '') 
        {
            if ($this->session->userdata('admin_login') != 1) 
            {
                $this->session->set_userdata('last_page', current_url());
                redirect(base_url(), 'refresh');
            }
            if ($param1 == 'create') 
            {
                $this->crud_model->create_news();
                $this->crud_model->send_news_notify();
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
                redirect(base_url() . 'admin/panel/', 'refresh');
            }
            if ($param1 == 'update_panel') 
            {
                $this->crud_model->update_panel_news($param2);
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
                redirect(base_url() . 'admin/panel/', 'refresh');
            }
            if ($param1 == 'update_news') 
            {
                $this->crud_model->update_panel_news($param2);
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
                redirect(base_url() . 'admin/news/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->crud_model->delete_news($param2);
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
                redirect(base_url() . 'admin/panel/', 'refresh');
            }
            if ($param1 == 'delete2') 
            {
                $this->crud_model->delete_news($param2);
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
                redirect(base_url() . 'admin/news/', 'refresh');
            }
            $page_data['page_name'] = 'news';
            $page_data['page_title'] = get_phrase('news');
            $this->load->view('backend/index', $page_data);
        }
        
        function message($param1 = 'message_home', $param2 = '', $param3 = '') 
        {
            parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
            if ($this->session->userdata('admin_login') != 1)
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
                redirect(base_url() . 'admin/message/message_read/' . $message_thread_code, 'refresh');
            }
            if ($param1 == 'send_reply') 
            {
                $this->session->set_flashdata('flash_message' , get_phrase('reply_sent'));
                $this->crud_model->send_reply_message($param2);
                move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/messages/" . $_FILES["file_name"]["name"]);
                redirect(base_url() . 'admin/message/message_read/' . $param2, 'refresh');
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
    
        function group($param1 = "group_message_home", $param2 = "", $param3 = '')
        {
            if ($this->session->userdata('admin_login') != 1)
            {
                redirect(base_url(), 'refresh');
            }
            $max_size = 2097152;
            if ($param1 == "create_group") 
            {
                $this->crud_model->create_group();
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
                redirect(base_url() . 'admin/group/', 'refresh');
            }
            elseif($param1 == "delete_group")
            {
                $this->db->where('group_message_thread_code', $param2);
                $this->db->delete('group_message');
                $this->db->where('group_message_thread_code', $param2);
                $this->db->delete('group_message_thread');
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
                redirect(base_url() . 'admin/group/', 'refresh');
            }
            elseif ($param1 == "edit_group") 
            {
                $this->crud_model->update_group($param2);
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
                redirect(base_url() . 'admin/group/', 'refresh');
            }
            else if ($param1 == 'group_message_read') 
            {
                $page_data['current_message_thread_code'] = $param2;
            }
            else if ($param1 == 'create_message_group') 
            {
                $page_data['current_message_thread_code'] = $param2;
            }
            else if ($param1 == 'update_group') 
            {
                $page_data['current_message_thread_code'] = $param2;
            }
            else if($param1 == 'send_reply')
            {
                if(!file_exists('uploads/group_messaging_attached_file/')) 
                {
                    $oldmask = umask(0);
                    mkdir ('uploads/group_messaging_attached_file/', 0777);
                }
                if ($_FILES['attached_file_on_messaging']['name'] != "") 
                {
                    if($_FILES['attached_file_on_messaging']['size'] > $max_size)
                    {
                        $this->session->set_flashdata('error_message' , "2MB Allowed");
                        redirect(base_url() . 'admin/group/group_message_read/'.$param2, 'refresh');
                    }
                    else{
                        $file_path = 'uploads/group_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
                        move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
                    }
                }
    
                $this->crud_model->send_reply_group_message($param2);
                $this->session->set_flashdata('flash_message', get_phrase('message_sent'));
                redirect(base_url() . 'admin/group/group_message_read/'.$param2, 'refresh');
            }
            $page_data['message_inner_page_name']   = $param1;
            $page_data['page_name']                 = 'group';
            $page_data['page_title']                = get_phrase('message_group');
            $this->load->view('backend/index', $page_data);
        }
    
        function pending($param1 = '', $param2 = '')
        {
            if ($this->session->userdata('admin_login') != 1)
            {
                redirect(base_url(), 'refresh');
            }
            $page_data['page_name']  = 'pending';
            $page_data['page_title'] = get_phrase('pending_users');
            $this->load->view('backend/index', $page_data);
        }
    
    function students_report($param1 = '', $param2 = '')
    {
      if ($this->session->userdata('admin_login') != 1)
      {
        redirect(base_url(), 'refresh');
      }
      $page_data['class_id']   = $this->input->post('class_id');
      $page_data['section_id']   = $this->input->post('section_id');
      $page_data['page_name']   = 'students_report';
      $page_data['page_title']  = get_phrase('students_report');
      $this->load->view('backend/index', $page_data);
    }
    
    function general_reports($class_id = '', $section_id = '')
    {
      if ($this->session->userdata('admin_login') != 1)
      {
        redirect(base_url(), 'refresh');
      }
      $page_data['page_name']   = 'general_reports';
      $page_data['class_id']   = $this->input->post('class_id');
      $page_data['section_id']   = $this->input->post('section_id');
      $page_data['page_title']  = get_phrase('general_reports');
      $this->load->view('backend/index', $page_data);
    }
    
    function all($class_id = '', $section_id = '')
    {
      if ($this->session->userdata('admin_login') != 1)
      {
        redirect(base_url(), 'refresh');
      }
      
      $page_data['page_name']   = 'all';
      $page_data['page_title']  = get_phrase('my_files');
      $this->load->view('backend/index', $page_data);
    }

    function birthdays()
    {
        if ($this->session->userdata('admin_login') != 1)
        { 
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'birthdays';
        $page_data['page_title'] = get_phrase('birthdays');
        $this->load->view('backend/index', $page_data);
    }

    function librarian($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        { 
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'create') 
        {
            $md5 = md5(date('d-m-Y H:i:s'));
            $data['first_name']        = $this->input->post('first_name');
            $data['last_name']    = $this->input->post('last_name');
            $data['address']     = $this->input->post('address');
            $data['image']       = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            $data['phone']       = $this->input->post('phone');
            $data['gender']       = $this->input->post('gender');
            $data['idcard']       = $this->input->post('idcard');
            $data['email']       = $this->input->post('email');
            $data['birthday']       = $this->input->post('datetimepicker');
            $data['since']       = date('d M, Y');
            $data['username']     = $this->input->post('username');
            $data['password']     = sha1($this->input->post('password'));
            $this->db->insert('librarian', $data);
            $teacher_id = $this->db->insert_id();
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/librarian_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/librarian/', 'refresh');
        }
        if ($param1 == 'update') 
        {
            $md5 = md5(date('d-m-y H:i:s'));
            $data['first_name']         = $this->input->post('first_name');
            $data['last_name']         = $this->input->post('last_name');
            $data['username']     = $this->input->post('username');
            $data['email']        = $this->input->post('email');
            $data['gender']     = $this->input->post('gender');
            $data['phone']     = $this->input->post('phone');
            $data['idcard']     = $this->input->post('idcard');
            $data['address']     = $this->input->post('address');
            if($this->input->post('password') != ""){
                $data['password']     = sha1($this->input->post('password'));   
            }
            if($_FILES['userfile']['name'] != ""){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            $this->db->where('librarian_id', $param2);
            $this->db->update('librarian', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/librarian_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            redirect(base_url() . 'admin/librarian/', 'refresh');
        }
        if ($param1 == 'update_profile') 
        {
            $md5 = md5(date('d-m-y H:i:s'));
            $data['first_name']         = $this->input->post('first_name');
            $data['last_name']         = $this->input->post('last_name');
            $data['username']     = $this->input->post('username');
            $data['email']        = $this->input->post('email');
            $data['idcard']     = $this->input->post('idcard');
            $data['birthday']       = $this->input->post('datetimepicker');
            $data['phone']     = $this->input->post('phone');
            $data['address']     = $this->input->post('address');
            if($this->input->post('password') != ""){
                $data['password']     = sha1($this->input->post('password'));   
            }
            if($_FILES['userfile']['name'] != ""){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            $this->db->where('librarian_id', $param2);
            $this->db->update('librarian', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/librarian_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            redirect(base_url() . 'admin/librarian_update/'.$param2.'/', 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $this->db->where('librarian_id', $param2);
            $this->db->delete('librarian');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/librarian/', 'refresh');
        }
        $page_data['page_name']  = 'librarian';
        $page_data['page_title'] = get_phrase('librarians');
        $this->load->view('backend/index', $page_data);
    }

    function upload($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'upload';
        $page_data['page_title'] = get_phrase('upload_files');
        $this->load->view('backend/index', $page_data);
    }
    
    function new_payment($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'new_payment';
        $page_data['page_title'] = get_phrase('new_payment');
        $this->load->view('backend/index', $page_data);
    }
    
    function recent()
    {
        if($this->session->userdata('admin_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        $page_data['page_name']  =  'recent';
        $page_data['page_title'] =  get_phrase('recent_files');
        $this->load->view('backend/index', $page_data);
    }

    function accountant($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'create') 
        {
            $md5 = md5(date('d-m-Y H:i:s'));
            $data['first_name']        = $this->input->post('first_name');
            $data['last_name']    = $this->input->post('last_name');
            $data['address']     = $this->input->post('address');
            $data['image']       = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            $data['phone']       = $this->input->post('phone');
            $data['gender']       = $this->input->post('gender');
            $data['idcard']       = $this->input->post('idcard');
            $data['birthday']       = $this->input->post('datetimepicker');
            $data['email']       = $this->input->post('email');
            $data['since']       =date('d M, Y');
            $data['username']     = $this->input->post('username');
            $data['password']     = sha1($this->input->post('password'));
            $this->db->insert('accountant', $data);
            $teacher_id = $this->db->insert_id();
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/accountant_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/accountant/', 'refresh');
        }
        if ($param1 == 'update') 
        {
            $md5 = md5(date('d-m-y H:i:s'));
            $data['first_name']         = $this->input->post('first_name');
            $data['last_name']         = $this->input->post('last_name');
            $data['username']     = $this->input->post('username');
            $data['email']        = $this->input->post('email');
            $data['gender']     = $this->input->post('gender');
            $data['phone']     = $this->input->post('phone');
            $data['idcard']     = $this->input->post('idcard');
            $data['address']     = $this->input->post('address');
            if($this->input->post('password') != ""){
                $data['password']     = sha1($this->input->post('password'));   
            }
            if($_FILES['userfile']['name'] != ""){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            $this->db->where('accountant_id', $param2);
            $this->db->update('accountant', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/accountant_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            redirect(base_url() . 'admin/accountant/', 'refresh');
        }
        if ($param1 == 'update_profile') 
        {
            $md5 = md5(date('d-m-y H:i:s'));
            $data['first_name']         = $this->input->post('first_name');
            $data['last_name']         = $this->input->post('last_name');
            $data['username']     = $this->input->post('username');
            $data['email']        = $this->input->post('email');
            $data['birthday']     = $this->input->post('datetimepicker');
            $data['idcard']     = $this->input->post('idcard');
            $data['phone']     = $this->input->post('phone');
            $data['address']     = $this->input->post('address');
            if($this->input->post('password') != ""){
                $data['password']     = sha1($this->input->post('password'));   
            }
            if($_FILES['userfile']['name'] != ""){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            $this->db->where('accountant_id', $param2);
            $this->db->update('accountant', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/accountant_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            redirect(base_url() . 'admin/accountant_update/'.$param2.'/', 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $this->db->where('accountant_id', $param2);
            $this->db->delete('accountant');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/accountant/', 'refresh');
        }
        $page_data['page_name']  = 'accountant';
        $page_data['page_title'] = get_phrase('accountants');
        $this->load->view('backend/index', $page_data);
    }

    function notifications($param1 = '', $param2 = '')
    {
        if($this->session->userdata('admin_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->db->where('id', $param2);
            $this->db->delete('notification');
            redirect(base_url() . 'admin/notifications/', 'refresh');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
        }
        $page_data['page_name']  =  'notifications';
        $page_data['page_title'] =  get_phrase('your_notifications');
        $this->load->view('backend/index', $page_data);
    }

    function academic_settings($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'do_update') 
        {
            $data['description'] = $this->input->post('report_teacher');
            $this->db->where('type' , 'students_reports');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('minium_mark');
            $this->db->where('type' , 'minium_mark');
            $this->db->update('academic_settings' , $data);
            if($this->input->post('routine') == "1"){
                $routine =  $this->input->post('routine');
            }else{
                $routine = 2;
            }
            $data['description'] = $routine;
            $this->db->where('type' , 'routine');
            $this->db->update('academic_settings' , $data);
            $data['description'] = $this->input->post('terms');
            $this->db->where('type' , 'terms');
            $this->db->update('academic_settings' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/academic_settings/', 'refresh');
        }
        $page_data['page_name']  = 'academic_settings';
        $page_data['page_title'] = get_phrase('academic_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }
    
    function query() 
    {
        if($_POST['b'] != "")
        {       
            $this->db->like('name' , $_POST['b']);
            $query = $this->db->get_where('student')->result_array();
            if(count($query) > 0)
            {
                foreach ($query as $row) 
                {
                    echo '<p style="text-align: left; color:#fff; font-size:14px;"><a style="text-align: left; color:#fff; font-weight: bold;" href="'.base_url().'admin/student_portal/'. $row['student_id'] .'/">'. $row['name'] .'</a>' ." &nbsp;".$status.""."</p>";
                }
            } else{
                echo '<p class="col-md-12" style="text-align: left; color: #fff; font-weight: bold; ">'.get_phrase('no_results').'</p>';
            }
        }
    }
 
    function new_student($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name']  = 'new_student';
        $page_data['page_title'] = get_phrase('admissions');
        $this->load->view('backend/index', $page_data);
    }

    function grade($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(site_url('login'), 'refresh');
        }
        if ($param1 == 'create') 
        {
            $data['name']        = $this->input->post('name');
            $data['grade_point'] = $this->input->post('point');
            $data['mark_from']   = $this->input->post('from');
            $data['mark_upto']   = $this->input->post('to');
            $this->db->insert('grade', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/grade/', 'refresh');
        }
        if ($param1 == 'update') 
        {
            $data['name']        = $this->input->post('name');
            $data['grade_point'] = $this->input->post('point');
            $data['mark_from']   = $this->input->post('from');
            $data['mark_upto']   = $this->input->post('to');
            $this->db->where('grade_id', $param2);
            $this->db->update('grade', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/grade/', 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $this->db->where('grade_id', $param2);
            $this->db->delete('grade');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/grade/', 'refresh');
        }
        $page_data['page_name']  = 'grade';
        $page_data['page_title'] = get_phrase('grades');
        $this->load->view('backend/index', $page_data);
    }

    function users($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'permissions')
        {
            $data['permissions'] = $this->input->post('messages');
            $this->db->where('type' , 'messages');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('admins');
            $this->db->where('type' , 'admins');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('parents');
            $this->db->where('type' , 'parents');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('teachers');
            $this->db->where('type' , 'teachers');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('students');
            $this->db->where('type' , 'students');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('accountants');
            $this->db->where('type' , 'accountants');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('librarians');
            $this->db->where('type' , 'librarians');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('library');
            $this->db->where('type' , 'library');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('academic');
            $this->db->where('type' , 'academic');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('attendance');
            $this->db->where('type' , 'attendance');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('calendar');
            $this->db->where('type' , 'calendar');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('files');
            $this->db->where('type' , 'files');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('polls');
            $this->db->where('type' , 'polls');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('notifications');
            $this->db->where('type' , 'notifications');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('admissions');
            $this->db->where('type' , 'admissions');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('behavior');
            $this->db->where('type' , 'behavior');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('news');
            $this->db->where('type' , 'news');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('school_bus');
            $this->db->where('type' , 'school_bus');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('classrooms');
            $this->db->where('type' , 'classrooms');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('accounting');
            $this->db->where('type' , 'accounting');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('schedules');
            $this->db->where('type' , 'schedules');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('system_reports');
            $this->db->where('type' , 'system_reports');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('academic_settings');
            $this->db->where('type' , 'academic_settings');
            $this->db->update('account_role' , $data);
            
            $data['permissions'] = $this->input->post('settings');
            $this->db->where('type' , 'settings');
            $this->db->update('account_role' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/users/', 'refresh');
        }
        $page_data['page_name']                 = 'users';
        $page_data['page_title']                = get_phrase('users');
        $this->load->view('backend/index', $page_data);
    }
    
    function admins($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'create') 
        {
            $md5 = md5(date('d-m-y H:i:s'));
            $data['first_name']         = $this->input->post('first_name');
            $data['last_name']         = $this->input->post('last_name');
            $data['username']     = $this->input->post('username');
            $data['password']     = sha1($this->input->post('password'));
            $data['email']        = $this->input->post('email');
            $data['birthday']     = $this->input->post('datetimepicker');
            $data['gender']     = $this->input->post('gender');
            $data['phone']     = $this->input->post('phone');
            $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            $data['address']     = $this->input->post('address');
            $data['since']     = date('d M, Y');
            $data['owner_status'] = $this->input->post('owner_status');
            $this->db->insert('admin', $data);
            $admin_id = $this->db->insert_id();
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/admins/', 'refresh');
        }
        if ($param1 == 'update') 
        {
            $md5 = md5(date('d-m-y H:i:s'));
            $data['first_name']         = $this->input->post('first_name');
            $data['last_name']         = $this->input->post('last_name');
            $data['username']     = $this->input->post('username');
            $data['email']        = $this->input->post('email');
            if($this->input->post('datetimepicker') != ""){
                $data['birthday']     = $this->input->post('datetimepicker');   
            }
            $data['gender']     = $this->input->post('gender');
            $data['phone']     = $this->input->post('phone');
            $data['address']     = $this->input->post('address');
            if($this->input->post('password') != ""){
                $data['password']     = sha1($this->input->post('password'));   
            }
            if($_FILES['userfile']['size'] > 0){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            $data['owner_status'] = $this->input->post('owner_status');
            $this->db->where('admin_id', $param2);
            $this->db->update('admin', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/admins/', 'refresh');
        }
        if ($param1 == 'update_profile') 
        {
            $data['first_name']         = $this->input->post('first_name');
            $data['last_name']         = $this->input->post('last_name');
            $data['username']     = $this->input->post('username');
            $data['email']        = $this->input->post('email');
            $data['profession']        = $this->input->post('profession');
            $data['idcard']        = $this->input->post('idcard');
            if($this->input->post('datetimepicker') != ""){
                $data['birthday']     = $this->input->post('datetimepicker');   
            }
            if(!empty($_FILES['userfile']['tmp_name'])){
                $data['image']     = md5(date('d-m-y H:i:s')).str_replace(' ', '', $_FILES['userfile']['name']);
            }
            $data['gender']     = $this->input->post('gender');
            $data['phone']     = $this->input->post('phone');
            $data['address']     = $this->input->post('address');
            if($this->input->post('password') != ""){
                $data['password']     = sha1($this->input->post('password'));   
            }
            $data['owner_status'] = $this->input->post('owner_status');
            $this->db->where('admin_id', $param2);
            $this->db->update('admin', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_image/' . md5(date('d-m-y H:i:s')).str_replace(' ', '', $_FILES['userfile']['name']));
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/admin_update/'.$param2.'/', 'refresh');
        }
        if ($param1 == 'delete')
        {
            $this->db->where('admin_id', $param2);
            $this->db->delete('admin');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/admins/', 'refresh');
        }
        $page_data['page_name']     = 'admins';
        $page_data['page_title']    = get_phrase('admins');
        $this->load->view('backend/index', $page_data);
    }

    function students($id = '')
    {
      if ($this->session->userdata('admin_login') != 1)
      {
        redirect(base_url(), 'refresh');
      }
      $id = $this->input->post('class_id');
      if ($id == '')
      {
        $id = $this->db->get('class')->first_row()->class_id;
      }
      $page_data['page_name']   = 'students';
      $page_data['page_title']  = get_phrase('students');
      $page_data['class_id']  = $id;
      $this->load->view('backend/index', $page_data);
    }

    function admin_profile($admin_id = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'admin_profile';
        $page_data['page_title'] =  get_phrase('profile');
        $page_data['admin_id']  =  $admin_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function accountant_profile($accountant_id = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'accountant_profile';
        $page_data['page_title'] =  get_phrase('profile');
        $page_data['accountant_id']  =  $accountant_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function librarian_profile($librarian_id = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'librarian_profile';
        $page_data['page_title'] =  get_phrase('profile');
        $page_data['librarian_id']  =  $librarian_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function librarian_update($librarian_id = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'librarian_update';
        $page_data['page_title'] =  get_phrase('librarian_update');
        $page_data['librarian_id']  =  $librarian_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function accountant_update($accountant_id = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'accountant_update';
        $page_data['page_title'] =  get_phrase('update_information');
        $page_data['accountant_id']  =  $accountant_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function admin_update($admin_id = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'admin_update';
        $page_data['page_title'] =  get_phrase('update_information');
        $page_data['admin_id']  =  $admin_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function update_account($admin_id = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
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
        $page_data['page_name']  = 'update_account';
        $page_data['output']  = $output;
        $page_data['page_title'] =  get_phrase('profile');
        $this->load->view('backend/index', $page_data);
    }

    function teachers($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'accept')
        {
            $pending = $this->db->get_where('pending_users', array('user_id' => $param2))->result_array();
            foreach ($pending as $row) 
            {
                $data['first_name'] = $row['first_name'];
                $data['last_name'] = $row['last_name'];
                $data['email'] = $row['email'];
                $data['username'] = $row['username'];
                $data['sex'] = $row['sex'];
                $data['password'] = $row['password'];
                $data['phone'] = $row['phone'];
                $data['since'] = $row['since'];
                $this->db->insert('teacher', $data);
                $teacher_id = $this->db->insert_id();
                $this->crud_model->account_confirm('teacher', $teacher_id);
            }
            $this->db->where('user_id', $param2);
            $this->db->delete('pending_users');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/teachers/', 'refresh');
        }
        if ($param1 == 'create') 
        {
            $md5 = md5(date('d-m-y H:i:s'));
            $data['first_name']        = $this->input->post('first_name');
            $data['last_name']        = $this->input->post('last_name');
            $data['sex']         = $this->input->post('gender');
            $data['email']       = $this->input->post('email');
            $data['phone']       = $this->input->post('phone');
            $data['idcard']      = $this->input->post('idcard');
            $data['since']      = date('d M, Y');
            $data['birthday']    = $this->input->post('datetimepicker');
            $data['address']     = $this->input->post('address');
            $data['username']     = $this->input->post('username');
            if(!empty($_FILES['userfile']['tmp_name'])){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            $data['password']     = sha1($this->input->post('password'));
            $this->db->insert('teacher', $data);
            $teacher_id = $this->db->insert_id();
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/teachers/', 'refresh');
        }
        if ($param1 == 'update') 
        {
            $md5 = md5(date('d-m-y H:i:s'));
            $data['first_name']        = $this->input->post('first_name');
            $data['last_name']        = $this->input->post('last_name');
            $data['email']       = $this->input->post('email');
            $data['phone']       = $this->input->post('phone');
            $data['idcard']      = $this->input->post('idcard');
            $data['address']     = $this->input->post('address');
            $data['username']     = $this->input->post('username');
            if(!empty($_FILES['userfile']['tmp_name'])){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            if($this->input->post('password') != ""){
             $data['password']     = sha1($this->input->post('password'));   
            }
            $this->db->where('teacher_id', $param2);
            $this->db->update('teacher', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            redirect(base_url() . 'admin/teachers/', 'refresh');
        }
        if ($param1 == 'update_profile') 
        {
            $md5 = md5(date('d-m-y H:i:s'));
            $data['first_name']        = $this->input->post('first_name');
            $data['last_name']        = $this->input->post('last_name');
            $data['email']       = $this->input->post('email');
            $data['phone']       = $this->input->post('phone');
            $data['idcard']      = $this->input->post('idcard');
            $data['birthday']    = $this->input->post('datetimepicker');
            $data['address']     = $this->input->post('address');
            $data['username']     = $this->input->post('username');
            if($_FILES['userfile']['name'] != ""){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            if($this->input->post('password') != ""){
             $data['password']     = sha1($this->input->post('password'));   
            }
            $this->db->where('teacher_id', $param2);
            $this->db->update('teacher', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            redirect(base_url() . 'admin/teacher_update/'.$param2. '/', 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $this->db->where('teacher_id', $param2);
            $this->db->delete('teacher');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/teachers/', 'refresh');
        }
        $page_data['teachers']   = $this->db->get('teacher')->result_array();
        $page_data['page_name']  = 'teachers';
        $page_data['page_title'] = get_phrase('teachers');
        $this->load->view('backend/index', $page_data);
    }
    
    function teacher_profile($teacher_id = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
        {            
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'teacher_profile';
        $page_data['page_title'] =  get_phrase('profile');
        $page_data['teacher_id']  =  $teacher_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function teacher_update($teacher_id = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
        {            
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'teacher_update';
        $page_data['page_title'] =  get_phrase('update_information');
        $page_data['teacher_id']  =  $teacher_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function teacher_schedules($teacher_id = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
        {            
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'teacher_schedules';
        $page_data['page_title'] =  get_phrase('teacher_schedules');
        $page_data['teacher_id']  =  $teacher_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function teacher_subjects($teacher_id = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
        {            
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'teacher_subjects';
        $page_data['page_title'] =  get_phrase('teacher_subjects');
        $page_data['teacher_id']  =  $teacher_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function parents($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
           redirect(base_url(), 'refresh');
        }
        if ($param1 == 'create') 
        {
            $md5 = md5(date('d-m-y H:i:s'));
            $data['first_name']             = $this->input->post('first_name');
            $data['last_name']              = $this->input->post('last_name');
            $data['gender']                 = $this->input->post('gender');
            $data['profession']             = $this->input->post('profession');
            $data['email']                  = $this->input->post('email');
            $data['phone']                  = $this->input->post('phone');
            $data['home_phone']             = $this->input->post('home_phone');
            $data['since']             = date('d M, Y');
            $data['idcard']                 = $this->input->post('idcard');
            $data['business']               = $this->input->post('business');
            $data['business_phone']         = $this->input->post('business_phone');
            $data['address']          = $this->input->post('address');
            $data['username']     = $this->input->post('username');
            $data['password']     = sha1($this->input->post('password'));
            $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            $this->db->insert('parent', $data);
            $parent_id     =   $this->db->insert_id();
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/parent_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/parents/', 'refresh');
        }
        if ($param1 == 'update') 
        {
            if(!empty($_FILES['userfile']['tmp_name'])){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            $data['first_name']             = $this->input->post('first_name');
            $data['last_name']              = $this->input->post('last_name');
            $data['gender']                 = $this->input->post('gender');
            $data['profession']             = $this->input->post('profession');
            $data['email']                  = $this->input->post('email');
            $data['phone']                  = $this->input->post('phone');
            $data['home_phone']             = $this->input->post('home_phone');
            $data['idcard']                 = $this->input->post('idcard');
            $data['business']               = $this->input->post('business');
            $data['business_phone']         = $this->input->post('business_phone');
            $data['address']          = $this->input->post('address');
            $data['username']     = $this->input->post('username');
            if($this->input->post('password') != ""){
                $data['password'] = sha1($this->input->post('password'));
            }
            $this->db->where('parent_id' , $param2);
            $this->db->update('parent' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/parent_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            redirect(base_url() . 'admin/parents/', 'refresh');
        }
        if ($param1 == 'update_profile') 
        {
            if(!empty($_FILES['userfile']['tmp_name'])){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            $data['first_name']             = $this->input->post('first_name');
            $data['last_name']              = $this->input->post('last_name');
            $data['gender']                 = $this->input->post('gender');
            $data['profession']             = $this->input->post('profession');
            $data['email']                  = $this->input->post('email');
            $data['phone']                  = $this->input->post('phone');
            $data['home_phone']             = $this->input->post('home_phone');
            $data['idcard']                 = $this->input->post('idcard');
            $data['business']               = $this->input->post('business');
            $data['business_phone']         = $this->input->post('business_phone');
            $data['address']          = $this->input->post('address');
            $data['username']     = $this->input->post('username');
            if($this->input->post('password') != ""){
                $data['password'] = sha1($this->input->post('password'));
            }
            $this->db->where('parent_id' , $param2);
            $this->db->update('parent' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/parent_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            redirect(base_url() . 'admin/parent_update/'.$param2.'/', 'refresh');
        }
        if($param1 == 'accept')
        {
            $pending = $this->db->get_where('pending_users', array('user_id' => $param2))->result_array();
            foreach ($pending as $row) 
            {
                $data['first_name'] = $row['first_name'];
                $data['last_name'] = $row['last_name'];
                $data['email'] = $row['email'];
                $data['username'] = $row['username'];
                $data['profession'] = $row['profession'];
                $data['since'] = $row['since'];
                $data['password'] = $row['password'];
                $data['phone'] = $row['phone'];
                $this->db->insert('parent', $data);
                $parent_id = $this->db->insert_id();
                $this->crud_model->account_confirm('parent', $parent_id);
            }
            $this->db->where('user_id', $param2);
            $this->db->delete('pending_users');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/parents/', 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $this->db->where('parent_id' , $param2);
            $this->db->delete('parent');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/parents/', 'refresh');
        }
        $page_data['page_title']  = get_phrase('parents');
        $page_data['page_name']  = 'parents';
        $this->load->view('backend/index', $page_data);
    }

    function marks()
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'marks';
        $page_data['page_title'] = get_phrase('marks');
        $this->load->view('backend/index', $page_data);
    }

    function notify($param1 = '', $param2 = '')
    {
      if ($this->session->userdata('admin_login') != 1)
      {
          redirect(base_url(), 'refresh');
      }
      if($param1 == 'send_emails')
      {
        require("class.phpmailer.php");
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        $mail->SetFrom($this->db->get_where('settings', array('type' => 'system_email'))->row()->description, $this->db->get_where('settings', array('type' => 'system_name'))->row()->description);
        $mail->Subject = $this->input->post('subject');
        $data = array(
            'email_msg' => $this->input->post('content')
        );
        $mail->Body = $this->load->view('backend/mails/notify.php',$data,TRUE);
        $users = $this->db->get(''.$this->input->post('type').'')->result_array();
        foreach($users as $row)
        {
            $mail->AddAddress($row['email']);
        }
        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
        $this->session->set_flashdata('flash_message' , "Correos enviados correctamente");
        redirect(base_url() . 'admin/notify/', 'refresh');
      }
      if($param1 == 'sms')
      {       
        $sms_status = $this->db->get_where('settings' , array('type' => 'sms_status'))->row()->description; 
        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $class_id   =   $this->input->post('class_id');
        $receiver   =   $this->input->post('receiver');
        if($receiver == 'student'){
            $users = $this->db->get_where('enroll' , array('class_id' => $class_id, 'year' => $year))->result_array();
        }else{
            $users = $this->db->get(''.$this->input->post('receiver').'')->result_array();
        }
        $message = $this->input->post('message');
        foreach ($users as $row) 
        {
            if($receiver == 'student'){
                $phones = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->phone;
            }else{
                $phones = $row['phone'];
            }
            if ($sms_status == 'twilio') 
            {
                 $this->crud_model->twilio($message,$phones);
            }else if ($sms_status == 'clickatell') 
            {
                 $this->crud_model->clickatell($message,$phones);
            }  
            else if ($sms_status == 'msg91') 
            {
                 $this->crud_model->send_sms_via_msg91($message,$phones);
            }  
        }
        $this->session->set_flashdata('flash_message' , get_phrase('sent_successfully'));
        redirect(base_url() . 'admin/notify/', 'refresh');
      }
      $page_data['page_name']  = 'notify';
      $page_data['page_title'] = get_phrase('notifications');
      $this->load->view('backend/index', $page_data);
    }

    function parent_profile($parent_id = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['parent_id']  = $parent_id;
        $page_data['page_name']  = 'parent_profile';
        $page_data['page_title'] = get_phrase('profile');
        $this->load->view('backend/index', $page_data);
    }
    
    function parent_update($parent_id = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['parent_id']  = $parent_id;
        $page_data['page_name']  = 'parent_update';
        $page_data['page_title'] = get_phrase('update_information');
        $this->load->view('backend/index', $page_data);
    }
    
    function parent_childs($parent_id = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['parent_id']  = $parent_id;
        $page_data['page_name']  = 'parent_childs';
        $page_data['page_title'] = get_phrase('parent_childs');
        $this->load->view('backend/index', $page_data);
    }
    
    function delete_student($student_id = '', $class_id = '') 
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $tables = array('student', 'attendance', 'enroll', 'invoice', 'mark', 'payment', 'students_request', 'student_question', 'reporte_alumnos');
        $this->db->delete($tables, array('student_id' => $student_id));
        $threads = $this->db->get('message_thread')->result_array();
        if (count($threads) > 0) 
        {
            foreach ($threads as $row) 
            {
                $sender = explode('-', $row['sender']);
                $receiver = explode('-', $row['reciever']);
                if (($sender[0] == 'student' && $sender[1] == $student_id) || ($receiver[0] == 'student' && $receiver[1] == $student_id)) 
                {
                    $thread_code = $row['message_thread_code'];
                    $this->db->delete('message', array('message_thread_code' => $thread_code));
                    $this->db->delete('message_thread', array('message_thread_code' => $thread_code));
                }
            }
        }
        $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
        redirect(base_url() . 'admin/students/', 'refresh');
    }
    
    function attendance_selector()
    {
        $data['class_id']   = $this->input->post('class_id');
        $data['year']       = $this->input->post('year');
        $originalDate =$this->input->post('timestamp');
        $newDate = date("d-m-Y", strtotime($originalDate));
        $data['timestamp']  = strtotime($newDate);
        $data['section_id'] = $this->input->post('section_id');
            $query = $this->db->get_where('attendance' ,array(
                'class_id'=>$data['class_id'],
                    'section_id'=>$data['section_id'],
                        'year'=>$data['year'],
                            'timestamp'=>$data['timestamp']));
        if($query->num_rows() < 1) 
        {
            $students = $this->db->get_where('enroll' , array('class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']))->result_array();
            foreach($students as $row) {
                $attn_data['class_id']   = $data['class_id'];
                $attn_data['year']       = $data['year'];
                $attn_data['timestamp']  = $data['timestamp'];
                $attn_data['section_id'] = $data['section_id'];
                $attn_data['student_id'] = $row['student_id'];
                $this->db->insert('attendance' , $attn_data);  
            }
        }
        redirect(base_url().'admin/manage_attendance/'.$data['class_id'].'/'.$data['section_id'].'/'.$data['timestamp'],'refresh');
    }
    
    function attendance_update($class_id = '' , $section_id = '' , $timestamp = '')
    {        
        $sms_status = $this->db->get_where('settings' , array('type' => 'sms_status'))->row()->description;
        $notify = $this->db->get_where('settings' , array('type' => 'absences'))->row()->description;
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $attendance_of_students = $this->db->get_where('attendance' , array('class_id'=>$class_id,'section_id'=>$section_id,'year'=>$running_year,'timestamp'=>$timestamp))->result_array();
        foreach($attendance_of_students as $row) 
        {
            $attendance_status = $this->input->post('status_'.$row['attendance_id']);
            $this->db->where('attendance_id' , $row['attendance_id']);
            $this->db->update('attendance' , array('status' => $attendance_status));
            if ($attendance_status == 2) 
            {
                $student_name   = $this->crud_model->get_name('student',$row['student_id']);
                $parent_id      = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->parent_id;
                $parent_em      = $this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->email;
                $receiver       = $this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->phone;
                $message        = 'Your child' . ' ' . $student_name . ' is absent today.';
                if($notify == 1)
                {
                    if ($sms_status == 'msg91') 
                    {
                        $this->crud_model->send_sms_via_msg91($message, $receiver);
                    }
                    else if ($sms_status == 'twilio') 
                    {
                        $this->crud_model->twilio($message,"".$receiver."");
                    }
                    else if ($sms_status == 'clickatell') 
                    {
                        $this->crud_model->clickatell($message,$receiver);
                    }
              }
              $this->crud_model->attendance($row['student_id'], $parent_id);
            }
        }
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
        redirect(base_url().'admin/manage_attendance/'.$class_id.'/'.$section_id.'/'.$timestamp , 'refresh');
    }

    function database($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'restore')
        {
            $this->crud_model->import_db();
            $this->session->set_flashdata('flash_message' , get_phrase('restored'));
            redirect(base_url() . 'admin/database/', 'refresh');
        }
        if($param1 == 'create')
        {
            $this->crud_model->create_backup();
            $this->session->set_flashdata('flash_message' , get_phrase('backup_created'));
            redirect(base_url() . 'admin/database/', 'refresh');
        }
        $page_data['page_name']                 = 'database';
        $page_data['page_title']                = get_phrase('database');
        $this->load->view('backend/index', $page_data);
    }

    function sms($param1 = '', $param2 = '')
    {
        if($param1 == 'update')
        {
            $data['description'] = $this->input->post('sms_status');
            $this->db->where('type' , 'sms_status');
            $this->db->update('settings' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/sms/', 'refresh');
        }
        if($param1 == 'msg91')
        {
            $data['description'] = $this->input->post('msg91_key');
            $this->db->where('type' , 'msg91_key');
            $this->db->update('settings' , $data);
            
            $data['description'] = $this->input->post('msg91_sender');
            $this->db->where('type' , 'msg91_sender');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('msg91_route');
            $this->db->where('type' , 'msg91_route');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('msg91_code');
            $this->db->where('type' , 'msg91_code');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/sms/', 'refresh');
        }
        if($param1 == 'clickatell')
        {
            $data['description'] = $this->input->post('clickatell_username');
            $this->db->where('type' , 'clickatell_username');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('clickatell_password');
            $this->db->where('type' , 'clickatell_password');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('clickatell_api');
            $this->db->where('type' , 'clickatell_api');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/sms/', 'refresh');
        }
        if($param1 == 'twilio') 
        {
            $data['description'] = $this->input->post('twilio_account');
            $this->db->where('type' , 'twilio_account');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('authentication_token');
            $this->db->where('type' , 'authentication_token');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('registered_phone');
            $this->db->where('type' , 'registered_phone');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/sms/', 'refresh');
        }
        if($param1 == 'services') 
        {
            $data['description'] = $this->input->post('absences');
            $this->db->where('type' , 'absences');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('students_reports');
            $this->db->where('type' , 'students_reports');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('p_new_invoice');
            $this->db->where('type' , 'p_new_invoice');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('new_homework');
            $this->db->where('type' , 'new_homework');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('s_new_invoice');
            $this->db->where('type' , 's_new_invoice');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/sms/', 'refresh');
        }
        $page_data['page_name']  = 'sms';
        $page_data['page_title'] = get_phrase('sms');
        $this->load->view('backend/index', $page_data);
    }

    function email($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'template')
        {
            $data['subject'] = $this->input->post('subject');
            $data['body'] = $this->input->post('body');
            $this->db->where('email_template_id', $param2);
            $this->db->update('email_template', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/email/', 'refresh');
        }
        $page_data['page_name']  = 'email';
        $page_data['current_email_template_id']  = 1;
        $page_data['page_title'] = get_phrase('email_settings');
        $this->load->view('backend/index', $page_data);
    }

    function view_teacher_report()
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'view_teacher_report';
        $page_data['page_title'] = get_phrase('teacher_report');
        $this->load->view('backend/index', $page_data);
    }

    function translate($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'update') 
        {
            $page_data['edit_profile']  = $param2;
        }
        if ($param1 == 'update_phrase') 
        {
            $language   =   $param2;
            $total_phrase   =   $this->input->post('total_phrase');
            for($i = 1 ; $i <= $total_phrase ; $i++)
            {
                $this->db->where('phrase_id' , $i);
                $this->db->update('language' , array($language => $this->input->post('phrase'.$i)));
            }
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/translate/update/'.$language, 'refresh');
        }
        if ($param1 == 'add') 
        {
            $language = $this->input->post('language');
            $this->load->dbforge();
            $fields = array(
                $language => array(
                'type' => 'LONGTEXT'
                )
            );
            $this->dbforge->add_column('language', $fields);
            move_uploaded_file($_FILES['file_name']['tmp_name'], 'style/flags/' . $this->input->post('language') . '.png');
            $this->session->set_flashdata('flash_message', get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/translate/', 'refresh');
        }
        if ($param1 == 'do_update') 
        {
            $language        = $this->input->post('language');
            $data[$language] = $this->input->post('phrase');
            $this->db->where('phrase_id', $param2);
            $this->db->update('language', $data);
            $this->session->set_flashdata('flash_message', "");
            redirect(base_url() . 'admin/translate/', 'refresh');
        }
        $page_data['page_name']  = 'translate';
        $page_data['page_title'] = get_phrase('translate');
        $this->load->view('backend/index', $page_data);
    }

    function polls($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'create')
        {
            $data['question'] = $this->input->post('question');
            foreach ($this->input->post('options') as $row)
            {
                $data['options'] .= $row . ',';
            }
            $data['user'] = $this->input->post('user');
            $data['status'] = 1;
            $data['date'] = date('d M');
            $data['date2'] = date('h:i A');
            $data['admin_id']        = $this->session->userdata('login_user_id');
            $data['type'] = "polls";
            $data['publish_date']        = date('Y-m-d H:i:s');
            $data['poll_code'] = substr(md5(rand(0, 1000000)), 0, 7);
            $this->crud_model->send_polls_notify();
            $this->db->insert('polls', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/panel/', 'refresh');
        }
        if($param1 == 'create_wall')
        {
            $data['question'] = $this->input->post('question');
            foreach ($this->input->post('options') as $row)
            {
                $data['options'] .= $row . ',';
            }
            $data['user'] = $this->input->post('user');
            $data['status'] = 1;
            $data['date'] = date('d M');
            $this->crud_model->send_polls_notify();
            $data['date2'] = date('h:i A');
            $data['admin_id']        = $this->session->userdata('login_user_id');
            $data['type'] = "polls";
            $data['publish_date']        = date('Y-m-d H:i:s');
            $data['poll_code'] = substr(md5(rand(0, 1000000)), 0, 7);
            $this->db->insert('polls', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/polls/', 'refresh');
        }
        if($param1 == 'response')
        {
            $data['poll_code'] = $this->input->post('poll_code');
            $data['answer'] = $this->input->post('answer');
            $data['date2'] = date('h:i A');
            $user = $this->session->userdata('login_user_id');
            $user_type = $this->session->userdata('login_type');
            $data['user'] = $user_type ."-".$user;
            $data['date'] = date('d M, Y');
            $this->db->insert('poll_response', $data);
        }
        if($param1 == 'delete')
        {
            $this->db->where('poll_code', $param2);
            $this->db->delete('polls');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/panel/', 'refresh');
        }
        if($param1 == 'delete2')
        {
            $this->db->where('poll_code', $param2);
            $this->db->delete('polls');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/polls/', 'refresh');
        }
        $page_data['page_name']  = 'polls';
        $page_data['page_title'] = get_phrase('polls');
        $this->load->view('backend/index', $page_data);
    }

    function view_poll($code = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['code'] = $code;
        $page_data['page_name']  = 'view_poll';
        $page_data['page_title'] = get_phrase('poll_details');
        $this->load->view('backend/index', $page_data);
    }
    
    function new_poll($code = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'new_poll';
        $page_data['page_title'] = get_phrase('new_poll');
        $this->load->view('backend/index', $page_data);
    }

    function admissions($param1 = '', $param2 = '', $param3 = '')
    {
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($_GET['id'] != "")
        {
            $notify['status'] = 1;
            $this->db->where('id', $_GET['id']);
            $this->db->update('notification', $notify);
        }
        if($param1 == 'reject')
        {
            $this->db->where('user_id', $param2);
            $this->db->delete('pending_users');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/admissions/', 'refresh');
        }
        $page_data['page_name']  = 'admissions';
        $page_data['page_title'] = get_phrase('admissions');
        $this->load->view('backend/index', $page_data);
    }

    function teacher_routine()
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $teacher_id = $this->input->post('teacher_id');
        $page_data['page_name']  = 'teacher_routine';
        $page_data['teacher_id']  = $teacher_id;
        $page_data['page_title'] = get_phrase('teacher_routine');
        $this->load->view('backend/index', $page_data);
    }
    
    function get_class_area()
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $id = $this->input->post('class_id');
        redirect(base_url() . 'admin/students_area/'.$id."/", 'refresh');
    }

    function student_portal($student_id, $param1='')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $class_id     = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->row()->class_id;
        $student_name = $this->db->get_where('student' , array('student_id' => $student_id))->row()->name;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
        $system = $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
        $page_data['page_name']  = 'student_portal';
        $page_data['page_title'] =  get_phrase('student_portal');
        $page_data['student_id'] =  $student_id;
        $page_data['class_id']   =   $class_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function student_update($student_id = '', $param1='')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'student_update';
        $page_data['page_title'] =  get_phrase('student_portal');
        $page_data['student_id'] =  $student_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function student_invoices($student_id = '', $param1='')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'student_invoices';
        $page_data['page_title'] =  get_phrase('student_invoices');
        $page_data['student_id'] =  $student_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function student_marks($student_id = '', $param1='')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'student_marks';
        $page_data['page_title'] =  get_phrase('student_marks');
        $page_data['student_id'] =  $student_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function student_attendance_report_selector()
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $data['class_id']   = $this->input->post('class_id');
        $data['year']       = $this->input->post('year');
        $data['month']  = $this->input->post('month');
        $data['section_id'] = $this->input->post('section_id');
        redirect(base_url().'admin/student_profile_attendance/'.$this->input->post('student_id').'/'.$data['class_id'].'/'.$data['section_id'].'/'.$data['month'].'/'.$data['year'].'/','refresh');
    }
    
    function student_profile_attendance($student_id = '', $param1='', $param2 = '', $param3 = '', $param4 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'student_profile_attendance';
        $page_data['page_title'] =  get_phrase('student_attendance');
        $page_data['student_id'] =  $student_id;
        $page_data['class_id'] =  $param1;
        $page_data['section_id'] =  $param2;
        $page_data['month'] =  $param3;
        $page_data['year'] =  $param4;
        $this->load->view('backend/index', $page_data);
    }
    
    function student_profile_report($student_id = '', $param1='')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'student_profile_report';
        $page_data['page_title'] =  get_phrase('behavior');
        $page_data['student_id'] =  $student_id;
        $this->load->view('backend/index', $page_data);
    }

    function student_info($student_id = '', $param1='')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'student_info';
        $page_data['page_title'] =  get_phrase('student_portal');
        $page_data['student_id'] =  $student_id;
        $this->load->view('backend/index', $page_data);
    }

    function get_sections($class_id = '')
    {
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/admin/student_bulk_sections' , $page_data);
    }

    function my_account($param1 = "", $page_id = "")
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        }     

        include_once 'src/Google_Client.php';
        include_once 'src/contrib/Google_Oauth2Service.php';
        $clientId = $this->db->get_where('settings', array('type' => 'google_sync'))->row()->description; //Google client ID
        $clientSecret = $this->db->get_where('settings', array('type' => 'google_login'))->row()->description; //Google client secret
        $redirectURL = base_url().'auth/sync/';
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
          $this->db->where('admin_id', $this->session->userdata('login_user_id'));
          $this->db->update('admin', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('facebook_delete'));
            redirect(base_url() . 'admin/my_account/', 'refresh');
        }
        if($param1 == '1')
        {
            $this->session->set_flashdata('error_message' , get_phrase('google_err'));
            redirect(base_url() . 'admin/my_account/', 'refresh');
        }
        if($param1 == '3')
        {
            $this->session->set_flashdata('error_message' , get_phrase('facebook_err'));
            redirect(base_url() . 'admin/my_account/', 'refresh');
        }
        if($param1 == '2')
        {
            $this->session->set_flashdata('flash_message' , get_phrase('google_true'));
            redirect(base_url() . 'admin/my_account/', 'refresh');
        }
        if($param1 == '4')
        {
            $this->session->set_flashdata('flash_message' , get_phrase('facebook_true'));
            redirect(base_url() . 'admin/my_account/', 'refresh');
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
            $this->db->where('admin_id', $this->session->userdata('login_user_id'));
            $this->db->update('admin', $data);
            
            unset($_SESSION['token']);
            unset($_SESSION['userData']);
            $gClient->revokeToken();
            $this->session->set_flashdata('flash_message' , get_phrase('google_delete'));
            redirect(base_url() . 'admin/my_account/', 'refresh');
        }
        if ($param1 == 'update_profile') 
        {
            $data['first_name']         = $this->input->post('first_name');
            $data['last_name']         = $this->input->post('last_name');
            $data['username']     = $this->input->post('username');
            $data['email']        = $this->input->post('email');
            $data['profession']        = $this->input->post('profession');
            $data['idcard']        = $this->input->post('idcard');
            if($this->input->post('datetimepicker') != ""){
                $data['birthday']     = $this->input->post('datetimepicker');   
            }
            if(!empty($_FILES['userfile']['tmp_name'])){
                $data['image']     = md5(date('d-m-y H:i:s')).str_replace(' ', '', $_FILES['userfile']['name']);
            }
            $data['gender']     = $this->input->post('gender');
            $data['phone']     = $this->input->post('phone');
            $data['address']     = $this->input->post('address');
            if($this->input->post('password') != ""){
                $data['password']     = sha1($this->input->post('password'));   
            }
            $this->db->where('admin_id', $this->session->userdata('login_user_id'));
            $this->db->update('admin', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_image/' . md5(date('d-m-y H:i:s')).str_replace(' ', '', $_FILES['userfile']['name']));
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/update_account/', 'refresh');
        }

        $data['page_name']              = 'my_account';
        $data['output']         = $output;
        $data['page_title']             = get_phrase('profile');
        $this->load->view('backend/index', $data);
    }
    
    function book_request($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != 1)
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
            redirect(site_url('admin/book_request/'), 'refresh');
        }
        if ($param1 == "reject")
        {
            $data['status'] = 2;
            $this->db->update('book_request', $data, array('book_request_id' => $param2));
            $this->session->set_flashdata('flash_message', get_phrase('request_rejected_successfully'));
            redirect(site_url('admin/book_request'), 'refresh');
        }
        $data['page_name']  = 'book_request';
        $data['page_title'] = get_phrase('book_request');
        $this->load->view('backend/index', $data);
    }

    function request($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != 1)
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
        if ($param1 == "accept")
        {
            $teacher = $this->db->get_where('request', array('request_id' => $param2))->row()->teacher_id;
            $notify['notify'] = "<strong>". $this->crud_model->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'))."</strong>". " ". get_phrase('absence_approved');
            $notify['user_id'] = $teacher;
            $notify['user_type'] = "teacher";
            $notify['url'] = "docente/request";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['original_id'] = $this->session->userdata('login_user_id');
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
            $data['status'] = 1;
            $this->db->update('request', $data, array('request_id' => $param2));
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/request/', 'refresh');
        }
                
        if ($param1 == "reject")
        {
            $teacher = $this->db->get_where('request', array('request_id' => $param2))->row()->teacher_id;
            $notify['notify'] = "<strong>".  $this->crud_model->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'))."</strong>". " ". get_phrase('absence_rejected');
            $notify['user_id'] = $teacher;
            $notify['user_type'] = "teacher";
            $notify['url'] = "docente/request";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['original_id'] = $this->session->userdata('login_user_id');
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
            $data['status'] = 2;
            $this->db->update('request', $data, array('request_id' => $param2));
            $this->session->set_flashdata('flash_message' , get_phrase('rejected_successfully'));
            redirect(base_url() . 'admin/request/', 'refresh');
        }
        
        $data['page_name']  = 'request';
        $data['page_title'] = get_phrase('permissions');
        $this->load->view('backend/index', $data);
    }

    function request_student($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != 1)
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
        if ($param1 == "accept")
        {

            $data['status'] = 1;
            $this->db->update('students_request', $data, array('request_id' => $param2));
            $student = $this->db->get_where('students_request', array('request_id' => $param2))->row()->student_id;
            $parent = $this->db->get_where('students_request', array('request_id' => $param2))->row()->parent_id;
            $notify['notify'] = "<strong>".  $this->crud_model->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'))."</strong>". " ". get_phrase('absence_approved_for') ." <b>".$this->db->get_where('student', array('student_id' => $student))->row()->name."</b>";
            $notify['user_id'] = $parent;
            $notify['user_type'] = "parent";
            $notify['url'] = "parents/request";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['original_id'] = $this->session->userdata('login_user_id');
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/request/', 'refresh');
        }
                
        if ($param1 == "reject")
        {
            $data['status'] = 2;
            $this->db->update('students_request', $data, array('request_id' => $param2));

            $parent = $this->db->get_where('students_request', array('request_id' => $param2))->row()->parent_id;
            $student = $this->db->get_where('students_request', array('request_id' => $param2))->row()->student_id;
            $notify['notify'] = "<strong>". $this->crud_model->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'))."</strong>". " ". get_phrase('absence_rejected_for') ." <b>".$this->db->get_where('student', array('student_id' => $student))->row()->name."</b>";
            $notify['user_id'] = $parent;
            $notify['user_type'] = "parent";
            $notify['url'] = "parents/request";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['original_id'] = $this->session->userdata('login_user_id');
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
            $this->session->set_flashdata('flash_message' , get_phrase('rejected_successfully'));
            redirect(base_url() . 'admin/request/', 'refresh');
        }
        if($param1 == 'delete')
        {
           $this->db->where('report_code',$param2);
           $this->db->delete('report_response');
           $this->db->where('code',$param2);
           $this->db->delete('reports');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/request_student/', 'refresh');
        }
        if($param1 == 'delete_teacher')
        {
            $this->db->where('report_code',$param2);
           $this->db->delete('reporte_alumnos');
           $this->db->where('report_code',$param2);
           $this->db->delete('reporte_mensaje');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/request_student/', 'refresh');
        }
        $data['page_name']  = 'request_student';
        $data['page_title'] = get_phrase('reports');
        $this->load->view('backend/index', $data);
    }

    function create_report_message($code = '') 
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $data['message']      = $this->input->post('message');
        $data['report_code']  = $this->input->post('report_code');
        $data['timestamp']    = date("d M, Y");
        $data['sender_type']    = $this->session->userdata('login_type');
        $data['sender_id']      = $this->session->userdata('login_user_id');
        return $this->db->insert('reporte_mensaje', $data);
    }  

    function view_report($param1 = '', $param2 = '', $param3 = '') 
    {
        if ($this->session->userdata('admin_login') != 1) 
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
        if($param1 == 'update')
        {
            $data['status'] = 1;
            $this->db->where('report_code', $param2);
            $this->db->update('reporte_alumnos', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/view_report/'.$param2, 'refresh');
        }
        $page_data['report_code'] = $param1;
        $page_data['page_title'] =   get_phrase('report_details');
        $page_data['page_name']  = 'view_report';
        $this->load->view('backend/index', $page_data);
    }

    function manage_online_exam_status($online_exam_id = "", $status = "", $data){
        $this->crud_model->manage_online_exam_status($online_exam_id, $status);
            redirect(base_url() . 'admin/online_exams/'.$data."/", 'refresh');
    }

    function online_exams($param1 = '', $param2 = '', $param3 ='') 
    {
        if ($param1 == 'edit') 
        {
            if ($this->input->post('class_id') > 0 && $this->input->post('section_id') > 0 && $this->input->post('subject_id') > 0) {
                $this->crud_model->update_online_exam();
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
                redirect(base_url() . 'admin/exam_edit/' . $this->input->post('online_exam_id'), 'refresh');
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('error_updated'));
                redirect(base_url() . 'admin/exam_edit/' . $this->input->post('online_exam_id'), 'refresh');
            }
        }
        if ($param1 == 'questions') 
        {
            $this->crud_model->add_questions();
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/exam_questions/' . $param2 , 'refresh');
        }
        if ($param1 == 'delete_questions') 
        {
            $this->db->where('question_id', $param2);
            $this->db->delete('questions');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/exam_questions/'.$param3, 'refresh');
        }
        if ($param1 == 'delete'){
            $this->crud_model->delete_exam($param2);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/online_exams/', 'refresh');
        }
        $page_data['data'] = $param1;
        $page_data['page_name'] = 'online_exams';
        $page_data['page_title'] = get_phrase('online_exams');
        $this->load->view('backend/index', $page_data);
    }

    function exam_edit($exam_code= '') 
    { 
        if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }   
        $page_data['online_exam_id'] = $exam_code;
        $page_data['page_name'] = 'exam_edit';
        $page_data['page_title'] = get_phrase('update_exam');
        $this->load->view('backend/index', $page_data);
    }

    function exam_results($exam_code = '') 
    { 
        if ($this->session->userdata('admin_login') != 1) 
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
        $page_data['online_exam_id'] = $exam_code;
        $page_data['page_name'] = 'exam_results';
        $page_data['page_title'] = get_phrase('exams_results');
        $this->load->view('backend/index', $page_data);
    }

    function manage_exams($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->db->where('online_exam_id', $param2);
            $this->db->delete('online_exam');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/online_exams/'.$param3."/", 'refresh');
        }
    }

    function homeworkroom($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'file') 
        {
            $page_data['room_page']    = 'homework_file';
            $page_data['homework_code'] = $param2;
        }  
        else if ($param1 == 'details') 
        {
            $page_data['room_page'] = 'homework_details';
            $page_data['homework_code'] = $param2;
        }
        else if ($param1 == 'edit') 
        {
            $page_data['room_page'] = 'homework_edit';
            $page_data['homework_code'] = $param2;
        }
        $page_data['homework_code'] =   $param1;
        $page_data['page_name']   = 'homework_room'; 
        $page_data['page_title']  = get_phrase('homework');
        $this->load->view('backend/index', $page_data);
    }

    function homework_edit($homework_code = '') 
    {   
        if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        } 
        $page_data['homework_code'] = $homework_code;
        $page_data['page_name'] = 'homework_edit';
        $page_data['page_title'] = get_phrase('homework');
        $this->load->view('backend/index', $page_data);
    }

    function single_homework($param1 = '', $param2 = '') 
    {
       if ($this->session->userdata('admin_login') != 1)
       {
            redirect(base_url(), 'refresh');
       }
       $page_data['answer_id'] = $param1;
       $page_data['page_name'] = 'single_homework';
       $page_data['page_title'] = get_phrase('homework');
       $this->load->view('backend/index', $page_data);
    }

    function homework_details($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['homework_code'] = $param1;
        $page_data['page_name']  = 'homework_details';
        $page_data['page_title'] = get_phrase('homework_details');
        $this->load->view('backend/index', $page_data);
    }
    
    function new_exam($data = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['data'] = $data;
        $page_data['page_name']  = 'new_exam';
        $page_data['page_title'] = get_phrase('new_exam');
        $this->load->view('backend/index', $page_data);
    }

    function homework($param1 = '', $param2 = '', $param3 = '') 
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'create') 
        {
            $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['time_end'] = $this->input->post('time_end');
            $data['date_end'] = $this->input->post('date_end');
            $data['type'] = $this->input->post('type');
            $data['wall_type'] = 'homework';
            $data['publish_date'] = date('Y-m-d H:i:s');
            $data['upload_date'] = date('d M. H:iA');
            $data['year'] = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $data['status'] = $this->input->post('status');
            $data['class_id'] = $this->input->post('class_id');
            $data['file_name']         = $_FILES["file_name"]["name"];
            $data['section_id'] = $this->input->post('section_id');
            $data['user'] = $this->session->userdata('login_type');
            $data['subject_id'] = $this->input->post('subject_id');
            $data['uploader_type']  =   $this->session->userdata('login_type');
            $data['uploader_id']  =   $this->session->userdata('login_user_id');
            $data['homework_code'] = substr(md5(rand(100000000, 200000000)), 0, 10);
            $this->db->insert('homework', $data);
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/homework/" . $_FILES["file_name"]["name"]);
            $this->crud_model->send_homework_notify();
            $homework_code = $data['homework_code'];
            $notify['notify'] = "<strong>".$this->crud_model->get_name($this->session->userdata('login_type'),$this->session->userdata('login_user_id'))."</strong>". " ". get_phrase('new_homework_notify') ." <b>".$this->input->post('title')."</b>";
            $students = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id'), 'section_id' => $this->input->post('section_id'), 'year' => $year))->result_array();
            foreach($students as $row)
            {
                $notify['user_id'] = $row['student_id'];
                $notify['user_type'] = 'student';
                $notify['url'] = "student/homeworkroom/".$homework_code;
                $notify['date'] = date('d M, Y');
                $notify['time'] = date('h:i A');
                $notify['status'] = 0;
                $notify['type'] = 'homework';
                $notify['class_id'] = $this->input->post('class_id');
                $notify['section_id'] = $this->input->post('section_id');
                $notify['year'] = $year;
                $notify['subject_id'] = $this->input->post('subject_id');
                $notify['original_id'] = $this->session->userdata('login_user_id');
                $notify['original_type'] = $this->session->userdata('login_type');
                $this->db->insert('notification', $notify);
            }
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/homeworkroom/' . $homework_code .'/', 'refresh');
        }
        if($param1 == 'update')
        {
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['time_end'] = $this->input->post('time_end');
            $data['date_end'] = $this->input->post('date_end');
            $data['user'] = $this->session->userdata('login_type');
            $data['status'] = $this->input->post('status');
            $data['type'] = $this->input->post('type');
            $this->db->where('homework_code', $param2);
            $this->db->update('homework', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/homework_edit/' . $param2 , 'refresh');
        }
        if($param1 == 'review')
        {
            $id = $this->input->post('answer_id');
            $mark = $this->input->post('mark');
            $comment = $this->input->post('comment');
            $entries = sizeof($mark);
            for($i = 0; $i < $entries; $i++) 
            {
                $data['mark']    = $mark[$i];
                $data['teacher_comment'] = $comment[$i];
                $this->db->where_in('id', $id[$i]);
                $this->db->update('deliveries', $data);
            }
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/homework_details/' . $param2 , 'refresh');
        }
        if($param1 == 'single')
        {
            $student_id = $this->db->get_where('deliveries', array('id' => $this->input->post('id')))->row()->student_id;
            $code = $this->db->get_where('deliveries', array('id' => $this->input->post('id')))->row()->homework_code;
            $title = $this->db->get_where('homework', array('homework_code' => $code))->row()->title;

            $data['teacher_comment'] = $this->input->post('comment');
            $data['mark'] = $this->input->post('mark');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('deliveries', $data);

            $notify['notify'] = "<strong>". $this->crud_model->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'))."</strong>". " ". get_phrase('homework_rated') ." <b>".$title.".</b>";
            $notify['user_id'] = $student_id;
            $notify['user_type'] = 'student';
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['url'] = "student/homeworkroom/".$code;
            $notify['status'] = 0;
            $notify['original_id']   = $this->session->userdata('login_user_id');
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/single_homework/' . $this->input->post('id') , 'refresh');
        }
        if ($param1 == 'edit') 
        {
            $this->crud_model->update_homework($param2);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/homeworkroom/edit/' . $param2 , 'refresh');
        }
        if ($param1 == 'delete')
        {
            $this->crud_model->delete_homework($param2);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/homework/'.$param3."/", 'refresh');
        }
        $page_data['data'] = $param1;
        $page_data['page_name'] = 'homework';
        $page_data['page_title'] = get_phrase('homework');
        $this->load->view('backend/index', $page_data);
    }

    function forum($param1 = '', $param2 = '', $param3 = '') 
    {
        if ($param1 == 'create') 
        {
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['class_id'] = $this->input->post('class_id');
            $data['type'] = $this->session->userdata('login_type');
            $data['section_id'] = $this->input->post('section_id');
            if($this->input->post('post_status') != "1"){
                $data['post_status'] = 0;
            }else{
                $data['post_status'] = $this->input->post('post_status');   
            }
            $data['publish_date'] = date('Y-m-d H:i:s');
            $data['upload_date'] = date('d M. H:iA');
            $data['wall_type'] = "forum";
            $data['timestamp'] = date("d M, Y H:iA");
            $data['subject_id'] = $this->input->post('subject_id');
            $data['file_name']         = $_FILES["userfile"]["name"];
            $data['teacher_id']  =   $this->session->userdata('login_user_id');
            $data['post_code'] = substr(md5(rand(100000000, 200000000)), 0, 10);
            $this->db->insert('forum', $data);
            $this->crud_model->send_forum_notify();
            move_uploaded_file($_FILES["userfile"]["tmp_name"], "uploads/forum/" . $_FILES["userfile"]["name"]);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/forum/' . $param2."/" , 'refresh');
        }
        if ($param1 == 'update') 
        {
            if($this->input->post('post_status') != "1"){
                $data['post_status'] = 0;
            }else{
                $data['post_status'] = $this->input->post('post_status');   
            }
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['type'] = $this->session->userdata('login_type');
            $data['timestamp'] = date("d M,Y H:iA");
            $data['teacher_id']  =   $this->session->userdata('login_user_id');
            $this->db->where('post_code', $param2);
            $this->db->update('forum', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/edit_forum/' . $param2 , 'refresh');
        }
        if ($param1 == 'delete')
        {
            $this->crud_model->delete_post($param2);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/forum/'.$param3."/" , 'refresh');
        }
        $page_data['data'] = $param1;
        $page_data['page_name'] = 'forum';
        $page_data['page_title'] = get_phrase('forum');
        $this->load->view('backend/index', $page_data);
    }

    function study_material($task = "", $document_id = "", $data = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        } 
        if ($task == "create")
        {
            $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->crud_model->save_study_material_info();
            $notify['notify'] = "<strong>".$this->crud_model->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'))."</strong> ". " ".get_phrase('study_material_notify');
            $students = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id'),'section_id' => $this->input->post('section_id'), 'year' => $year))->result_array();
            foreach($students as $row)
            {
                $notify['user_id'] = $row['student_id'];
                $notify['user_type'] = 'student';
                $notify['url'] = "student/study_material/".base64_encode($this->input->post('class_id').'-'.$this->input->post('section_id').'-'.$this->input->post('subject_id'));
                $notify['date'] = date('d M, Y');
                $notify['time'] = date('h:i A');
                $notify['type'] = 'material';
                $notify['status'] = 0;
                $notify['year'] = $year;
                $notify['class_id'] = $this->input->post('class_id');
                $notify['section_id'] = $this->input->post('section_id');
                $notify['subject_id'] = $this->input->post('subject_id');
                $notify['original_id'] = $this->session->userdata('login_user_id');
                $notify['original_type'] = $this->session->userdata('login_type');
                $this->db->insert('notification', $notify);
            }
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_uploaded'));
            redirect(base_url() . 'admin/study_material/'.$document_id."/" , 'refresh');
        }
        if ($task == "delete")
        {
            $this->crud_model->delete_study_material_info($document_id);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/study_material/'.$data."/");
        }
        $page_data['data'] = $task;
        $page_data['page_name']              = 'study_material';
        $page_data['page_title']             = get_phrase('study_material');
        $this->load->view('backend/index', $page_data);
    }

    function edit_forum($code = '')
    {
        $page_data['page_name']  = 'edit_forum';
        $page_data['page_title'] = get_phrase('update_forum');
        $page_data['code']   = $code;
        $this->load->view('backend/index', $page_data);    
    }

    function forumroom($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'comment') 
        {
            $page_data['room_page']    = 'comments';
            $page_data['post_code'] = $param2; 
        }
        else if ($param1 == 'posts') 
        {
            $page_data['room_page'] = 'post';
            $page_data['post_code'] = $param2; 
        }
        else if ($param1 == 'edit') 
        {
            $page_data['room_page'] = 'post_edit';
            $page_data['post_code'] = $param2;
        }
        $page_data['page_name']   = 'forum_room'; 
        $page_data['post_code']   = $param1;
        $page_data['page_title']  = get_phrase('forum');
        $this->load->view('backend/index', $page_data);
    }

    function forum_message($param1 = '', $param2 = '', $param3 = '') 
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'add') 
        {
            $this->crud_model->create_post_message($this->input->post('post_code'));
        }
    }
    
    function manage_multiple_choices_options() {
        $page_data['number_of_options'] = $this->input->post('number_of_options');
        $this->load->view('backend/admin/manage_multiple_choices_options', $page_data);
    }
    
    function load_question_type($type, $online_exam_id) {
        $page_data['question_type'] = $type;
        $page_data['online_exam_id'] = $online_exam_id;
        $this->load->view('backend/admin/online_exam_add_'.$type, $page_data);
    }
    
    function manage_online_exam_question($online_exam_id = "", $task = "", $type = ""){
        if ($this->session->userdata('admin_login') != 1){
            redirect(base_url(), 'refresh');
        }
        if ($task == 'add') {
            if ($type == 'multiple_choice') {
                $this->crud_model->add_multiple_choice_question_to_online_exam($online_exam_id);
            }
            elseif ($type == 'true_false') {
                $this->crud_model->add_true_false_question_to_online_exam($online_exam_id);
            }
            elseif ($type == 'fill_in_the_blanks') {
                $this->crud_model->add_fill_in_the_blanks_question_to_online_exam($online_exam_id);
            }
            redirect(base_url() . 'admin/examroom/'.$online_exam_id, 'refresh');
        }
    }

    function examroom($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']   = 'exam_room'; 
        $page_data['online_exam_id']  = $param1;
        $page_data['page_title']  = get_phrase('online_exams');
        $this->load->view('backend/index', $page_data);
    }
    
    function create_online_exam($info = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $year =  $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $data['publish_date'] = date('Y-m-d H:i:s');
        $data['uploader_type'] = $this->session->userdata('login_type');
        $data['wall_type'] = "exam";
        $data['uploader_id'] = $this->session->userdata('login_user_id');
        $data['upload_date'] = date('d M. H:iA');
        
        $data['code']  = substr(md5(uniqid(rand(), true)), 0, 7);
        $data['title'] = html_escape($this->input->post('exam_title'));
        $data['class_id'] = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        
        $data['minimum_percentage'] = html_escape($this->input->post('minimum_percentage'));
        $data['instruction'] = html_escape($this->input->post('instruction'));
        $data['exam_date'] = strtotime(html_escape($this->input->post('exam_date')));
        $data['time_start'] = html_escape($this->input->post('time_start').":00");
        $data['time_end'] = html_escape($this->input->post('time_end').":00");
        $data['duration'] = strtotime(date('Y-m-d', $data['exam_date']).' '.$data['time_end']) - strtotime(date('Y-m-d', $data['exam_date']).' '.$data['time_start']);
        $data['running_year'] = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $this->crud_model->send_exam_notify();
        $this->db->insert('online_exam', $data);
        $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
        redirect(base_url().'admin/online_exams/'.$info."/", 'refresh');
    }

    function invoice($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
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
            redirect(base_url() . 'admin/students_payments/', 'refresh');
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
            redirect(base_url() . 'admin/students_payments/', 'refresh');
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
            redirect(base_url() . 'admin/students_payments/', 'refresh');
        }else if ($param1 == 'edit') 
        {
            $page_data['edit_data'] = $this->db->get_where('invoice', array('invoice_id' => $param2))->result_array();
        }

        if ($param1 == 'delete') 
        {
            $this->db->where('invoice_id', $param2);
            $this->db->delete('invoice');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/students_payments/', 'refresh');
        }
        $page_data['page_name']  = 'invoice';
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data);
    }
    
    function get_class_students_mass($class_id = '')
    {
        $students = $this->db->get_where('enroll' , array('class_id' => $class_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->result_array();
        echo '
            <div class="col-sm-12">';
            foreach ($students as $row) 
            {
                echo '<div class="custom-control custom-checkbox">';
                    echo '<input checked type="checkbox" name="student_id[]" id="' . $row['student_id'] . '" value="' . $row['student_id'] . '" class="custom-control-input"> <label for="' . $row['student_id'] . '" class="custom-control-label">' . $this->crud_model->get_name('student', $row['student_id'])  .'</label>';
                echo '</div>';
        }
        echo '</div>';
    }
    
    function delete_question_from_online_exam($question_id){
        $online_exam_id = $this->db->get_where('question_bank', array('question_bank_id' => $question_id))->row()->online_exam_id;
        $this->crud_model->delete_question_from_online_exam($question_id);
        $this->session->set_flashdata('flash_message' , "Eliminada");
            redirect(base_url() . 'admin/examroom/'.$online_exam_id, 'refresh');
    }
    
    function update_online_exam_question($question_id = "", $task = "", $online_exam_id = "") {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');
        $online_exam_id = $this->db->get_where('question_bank', array('question_bank_id' => $question_id))->row()->online_exam_id;
        $type = $this->db->get_where('question_bank', array('question_bank_id' => $question_id))->row()->type;
        if ($task == "update") {
            if ($type == 'multiple_choice') {
                $this->crud_model->update_multiple_choice_question($question_id);
            }
            elseif($type == 'true_false'){
                $this->crud_model->update_true_false_question($question_id);
            }
            elseif($type == 'fill_in_the_blanks'){
                $this->crud_model->update_fill_in_the_blanks_question($question_id);
            }
            redirect(base_url() . 'admin/examroom/'.$online_exam_id, 'refresh');
        }
        $page_data['question_id'] = $question_id;
        $page_data['page_name'] = 'update_online_exam_question';
        $page_data['page_title'] = get_phrase('update_questions');
        $this->load->view('backend/index', $page_data);
    }

    function search_query($search_key = '') 
    {        
        if ($_POST)
        {
            redirect(base_url() . 'admin/search_results?query=' . base64_encode($this->input->post('search_key')), 'refresh');
        }
    }

    function search_results()
    {
        if($this->session->userdata('admin_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if ($_GET['query'] == "")
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['search_key'] =  $_GET['query'];
        $page_data['page_name']  =  'search_results';
        $page_data['page_title'] =  get_phrase('search_results');
        $this->load->view('backend/index', $page_data);
    }

    function invoice_details($id = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $page_data['invoice_id'] = $id;
        $page_data['page_title'] = get_phrase('invoice_details');
        $page_data['page_name']  = 'invoice_details';
        $this->load->view('backend/index', $page_data);
    }

    function looking_report($report_code = '') 
    {
        if ($this->session->userdata('admin_login') != 1) 
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
        $page_data['code'] = $report_code;
        $page_data['page_name'] = 'looking_report';
        $page_data['page_title'] = get_phrase('report_details');
        $this->load->view('backend/index', $page_data);
    }

    function student($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
           redirect(base_url(), 'refresh');
        }
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        if($param1 == 'excel')
        {
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setCellValue('A1', get_phrase('first_name'));
            $objPHPExcel->getActiveSheet()->setCellValue('B1', get_phrase('last_name'));
            $objPHPExcel->getActiveSheet()->setCellValue('C1', get_phrase('username'));
            $objPHPExcel->getActiveSheet()->setCellValue('D1', get_phrase('email'));
            $objPHPExcel->getActiveSheet()->setCellValue('E1', get_phrase('phone'));
            $objPHPExcel->getActiveSheet()->setCellValue('F1', get_phrase('gender'));
            $objPHPExcel->getActiveSheet()->setCellValue('G1', get_phrase('class'));
            $objPHPExcel->getActiveSheet()->setCellValue('H1', get_phrase('section'));
            $objPHPExcel->getActiveSheet()->setCellValue('I1', get_phrase('parent'));
    
            $a = 2; $b =2; $c =2; $d =2; $e =2; $f = 2;$g = 2;$h=2; $i = 2;
    
            $query = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id'), 'section_id' => $this->input->post('section_id'), 'year' => $running_year))->result_array();
            foreach($query as $row)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->first_name);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->last_name);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->username);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->email);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->phone);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$f++, $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->sex);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$g++, $this->db->get_where('class', array('class_id' => $row['class_id']))->row()->name);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$h++, $this->db->get_where('section', array('section_id' => $row['section_id']))->row()->name);
                $parent_id = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->parent_id;
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i++, $this->crud_model->get_name('parent',$parent_id));
            }
            $objPHPExcel->getActiveSheet()->setTitle('Estudiantes');
        
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="export_students_'.date('d-m-y:h:i:s').'.xlsx"');
            header("Content-Transfer-Encoding: binary ");
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
            $objWriter->setOffice2003Compatibility(true);
            $objWriter->save('php://output');
        }
        if ($param1 == 'addmission') 
        {
            $md5 = md5(date('d-m-Y H:i:s'));
            $data['first_name']           = $this->input->post('first_name');
            $data['last_name']           = $this->input->post('last_name');
            $data['birthday']       = $this->input->post('datetimepicker');
            $data['username']       = $this->input->post('username');
            $data['student_session'] = 1;
            $data['email']          = $this->input->post('email');
            $data['since']           = date("d M,Y");
            $data['phone']          = $this->input->post('phone');
            $data['sex']            = $this->input->post('gender');
            $data['password']       = sha1($this->input->post('password'));
            $data['address']        = $this->input->post('address');
            $data['transport_id']  = $this->input->post('transport_id');
            $data['dormitory_id']  = $this->input->post('dormitory_id');
            $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            if($this->input->post('account') != '1')
            {
                $data['parent_id']      = $this->input->post('parent_id');    
            }else if($this->input->post('account') == '1'){
                $data3['first_name']             = $this->input->post('parent_first_name');
                $data3['last_name']              = $this->input->post('parent_last_name');
                $data3['gender']                 = $this->input->post('parent_gender');
                $data3['profession']             = $this->input->post('parent_profession');
                $data3['email']                  = $this->input->post('parent_email');
                $data3['phone']                  = $this->input->post('parent_phone');
                $data3['home_phone']             = $this->input->post('parent_home_phone');
                $data3['idcard']                 = $this->input->post('parent_idcard');
                $data3['business']               = $this->input->post('parent_business');
                $data3['since']           = date("d M,Y");
                $data3['business_phone']         = $this->input->post('parent_business_phone');
                $data3['address']          = $this->input->post('parent_address');
                $data3['username']     = $this->input->post('parent_username');
                $data3['password']     = sha1($this->input->post('parent_password'));
                $data3['image']     = "";
                $this->db->insert('parent', $data3);
                $parent_id = $this->db->insert_id();
                $data['parent_id']      = $parent_id;    
            }
            $data['diseases']  = $this->input->post('diseases');
            $data['allergies']  = $this->input->post('allergies');
            $data['doctor']  = $this->input->post('doctor');
            $data['doctor_phone']  = $this->input->post('doctor_phone');
            $data['authorized_person']  = $this->input->post('auth_person');
            $data['authorized_phone']  = $this->input->post('auth_phone');
            $data['note']  = $this->input->post('note');
            $this->db->insert('student', $data);
            $student_id = $this->db->insert_id();
            $data4['student_id']     = $student_id;
            $data4['enroll_code']    = substr(md5(rand(0, 1000000)), 0, 7);
            $data4['class_id']       = $this->input->post('class_id');
            if ($this->input->post('section_id') != '') 
            {
                $data4['section_id'] = $this->input->post('section_id');
            }
            $data4['roll']           = $this->input->post('roll');
            $data4['date_added']     = strtotime(date("Y-m-d H:i:s"));
            $data4['year']           = $running_year;
            $this->db->insert('enroll', $data4);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/new_student/', 'refresh');
        }
        if ($param1 == 'do_update') 
        {
            $md5 = md5(date('d-m-Y H:i:s'));
            $data['first_name']      = $this->input->post('first_name');
            $data['last_name']       = $this->input->post('last_name');
            $data['birthday']        = $this->input->post('datetimepicker');
            $data['email']           = $this->input->post('email');
            $data['phone']           = $this->input->post('phone');
            $data['sex']             = $this->input->post('gender');
            $data['username']        = $this->input->post('username');
            if($this->input->post('password') != "")
            {
               $data['password'] = sha1($this->input->post('password'));
            }
            $data['address']         = $this->input->post('address');
            $data['transport_id']    = $this->input->post('transport_id');
            $data['dormitory_id']    = $this->input->post('dormitory_id');
            $data['diseases']    = $this->input->post('diseases');
            $data['allergies']    = $this->input->post('allergies');
            $data['doctor']    = $this->input->post('doctor');
            $data['doctor_phone']    = $this->input->post('doctor_phone');
            $data['authorized_person']    = $this->input->post('auth_person');
            $data['authorized_phone']    = $this->input->post('auth_phone');
            $data['note']    = $this->input->post('note');
            if($_FILES['userfile']['size'] > 0){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            $data['parent_id']       = $this->input->post('parent_id');
            $data['student_session'] = $this->input->post('student_session');
            $this->db->where('student_id', $param2);
            $this->db->update('student', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));

            $data2['roll'] = $this->input->post('roll');
            $data2['class_id'] = $this->input->post('class_id');
            $data2['section_id'] = $this->input->post('section_id');
            $this->db->where('student_id', $param2);
            $this->db->update('enroll', $data2);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            $this->crud_model->clear_cache();
            redirect(base_url() . 'admin/student_update/'. $param2.'/', 'refresh');
        }
        if ($param1 == 'do_updates') 
        {
            $md5 = md5(date('d-m-Y H:i:s'));
            $data['first_name']            = $this->input->post('first_name');
            $data['last_name']            = $this->input->post('last_name');
            $data['username']        = $this->input->post('username');
            $data['phone']           = $this->input->post('phone');
            $data['address']         = $this->input->post('address');
            $data['parent_id']       = $this->input->post('parent_id');
            $data['student_session'] = $this->input->post('student_session');
            $data['email']           = $this->input->post('email');
            if($_FILES['userfile']['size'] > 0){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            if($this->input->post('password') != "")
            {
               $data['password'] = sha1($this->input->post('password'));
            }
            $this->db->where('student_id', $param2);
            $this->db->update('student', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            redirect(base_url() . 'admin/students/', 'refresh');
        }
        if($param1 == 'accept')
        {
            $pending = $this->db->get_where('pending_users', array('user_id' => $param2))->result_array();
            foreach ($pending as $row) 
            {
                $data['first_name'] = $row['first_name'];
                $data['last_name'] = $row['last_name'];
                $data['email'] = $row['email'];
                $data['username'] = $row['username'];
                $data['sex'] = $row['sex'];
                $data['password'] = $row['password'];
                $data['birthday'] = $row['birthday'];
                $data['phone'] = $row['phone'];
                $data['since'] = $row['since'];
                $data['date'] = date('d M, Y');
                $this->db->insert('student', $data);
                $student_id = $this->db->insert_id();

                $data2['student_id']     = $student_id;
                $data2['enroll_code']    = substr(md5(rand(0, 1000000)), 0, 7);
                $data2['class_id']       = $row['class_id'];
                $data2['section_id']     = $row['section_id'];
                $data2['roll']           = $row['roll'];
                $data2['date_added']     = strtotime(date("Y-m-d H:i:s"));
                $data2['year']           = $running_year;
                $this->db->insert('enroll', $data2);
                $this->crud_model->account_confirm('student', $student_id);
            }
            $this->db->where('user_id', $param2);
            $this->db->delete('pending_users');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/students/', 'refresh');
        }
        if($param1 == 'bulk')
        {
            $path = $_FILES["upload_student"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach($object->getWorksheetIterator() as $worksheet)
            {
               $highestRow = $worksheet->getHighestRow();
               $highestColumn = $worksheet->getHighestColumn();
               for($row=2; $row <= $highestRow; $row++)
               {                     
                    $data['first_name']    =  $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $data['last_name']     =  $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $data['email']         =  $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $data['phone']         =  $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $data['sex']           =  $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $data['username']      =  $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $data['password']      =  sha1($worksheet->getCellByColumnAndRow(6, $row)->getValue());
                    $data['address']       =  $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $data['since']         =  date('d M, Y');
                    if($data['first_name'] != "")
                    {
                        $this->db->insert('student',$data);
                        $student_id = $this->db->insert_id();
                        $data2['enroll_code']   =   substr(md5(rand(0, 1000000)), 0, 7);
                        $data2['student_id']    =   $student_id;
                        $data2['class_id']      =   $this->input->post('class_id');
                        if($this->input->post('section_id') != '') 
                        {
                            $data2['section_id']    =   $this->input->post('section_id');
                        }
                        $data2['roll']          =   $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $data2['date_added']    =   strtotime(date("Y-m-d H:i:s"));
                        $data2['year']          =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
                        $this->db->insert('enroll' , $data2);
                    }
               }
            }
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/students/', 'refresh');
        }
    }

    function student_promotion($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'promote') 
        {
            $running_year  =   $this->input->post('running_year');  
            $from_class_id =   $this->input->post('promotion_from_class_id'); 
            $students_of_promotion_class =   $this->db->get_where('enroll' , array('class_id' => $from_class_id , 'year' => $running_year))->result_array();
            foreach($students_of_promotion_class as $row) 
            {
                $enroll_data['enroll_code']     =   substr(md5(rand(0, 1000000)), 0, 7);
                $enroll_data['student_id']      =   $row['student_id'];
                $enroll_data['class_id']        =   $this->input->post('promotion_status_'.$row['student_id']);
                $enroll_data['year']            =   $this->input->post('promotion_year');
                $enroll_data['date_added']      =   strtotime(date("Y-m-d H:i:s"));
                $this->db->insert('enroll' , $enroll_data);
            } 
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_promoted'));
            redirect(base_url() . 'admin/student_promotion' , 'refresh');
        }
        $page_data['page_title']    = get_phrase('student_promotion');
        $page_data['page_name']  = 'student_promotion';
        $this->load->view('backend/index', $page_data);
    }

    function get_students_to_promote($class_id_from = '' , $class_id_to  = '', $running_year  = '', $promotion_year = '')
    {
        $page_data['class_id_from']     =   $class_id_from;
        $page_data['class_id_to']       =   $class_id_to;
        $page_data['running_year']      =   $running_year;
        $page_data['promotion_year']    =   $promotion_year;
        $this->load->view('backend/admin/student_promotion_selector' , $page_data);
    }

    function view_marks($student_id = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $year =  $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $class_id     = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' =>$year))->row()->class_id;
        $page_data['class_id']   =   $class_id;
        $page_data['page_name']  = 'view_marks';
        $page_data['page_title'] = get_phrase('marks');
        $page_data['student_id']   = $student_id;
        $this->load->view('backend/index', $page_data);    
    }

    function subject_marks($data = '') 
     {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
         $page_data['data'] = $data;
         $page_data['page_name']    = 'subject_marks';
         $page_data['page_title']   = get_phrase('subject_marks');
         $this->load->view('backend/index',$page_data);
     }
     
     function subject_dashboard($data = '') 
     {
         if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
         $page_data['data'] = $data;
         $page_data['page_name']    = 'subject_dashboard';
         $page_data['page_title']   = get_phrase('subject_dashboard');
         $this->load->view('backend/index',$page_data);
     }

    function courses($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'create') 
        {
            $md5 = md5(date('d-m-y H:i:s'));
            $data['name']       = $this->input->post('name');
            $data['class_id']   = $this->input->post('class_id');
            $data['color']   = $this->input->post('color');
            $data['icon']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            $data['teacher_id'] = $this->input->post('teacher_id');
            $data['year']       = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->insert('subject', $data);
            $subject_id = $this->db->insert_id();
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/subject_icon/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/cursos/'.base64_encode($param2)."/", 'refresh');
        }
        if ($param1 == 'update_labs') 
        {
            $class_id = $this->db->get_where('subject', array('subject_id' => $param2))->row()->class_id;
            $data['la1'] = $this->input->post('la1');
            $data['la2'] = $this->input->post('la2');
            $data['la3'] = $this->input->post('la3');
            $data['la4'] = $this->input->post('la4');
            $data['la5'] = $this->input->post('la5');
            $data['la6'] = $this->input->post('la6');
            $data['la7'] = $this->input->post('la7');
            $data['la8'] = $this->input->post('la8');
            $data['la9'] = $this->input->post('la9');
            $data['la10'] = $this->input->post('la10');
            $this->db->where('subject_id', $param2);
            $this->db->update('subject', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/upload_marks/'.base64_encode($class_id."-".$this->input->post('section_id')."-".$param2).'/', 'refresh');
        }
        if ($param1 == 'update') 
        {
            $class_id = $this->db->get_where('subject', array('subject_id' => $param2))->row()->class_id;
            $md5 = md5(date('d-m-y H:i:s'));
            $data['color']   = $this->input->post('color');
            if($_FILES['userfile']['size'] > 0){
                $data['icon']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            $data['section_id']   = $this->input->post('section_id');
            $data['name'] = $this->input->post('name');
            $data['teacher_id'] = $this->input->post('teacher_id');
            $this->db->where('subject_id', $param2);
            $this->db->update('subject', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/subject_icon/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/cursos/'.base64_encode($class_id."-".$this->input->post('section_id').'-'.$param2)."/", 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $this->db->where('subject_id', $param2);
            $this->db->delete('subject');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/cursos/', 'refresh');
        }
        $class = $this->input->post('class_id');
        if ($class == '')
        {
            $class = $this->db->get('class')->first_row()->class_id;
        }
        $page_data['class_id']   = $class;
        $page_data['subjects']   = $this->db->get_where('subject' , array('class_id' => $param1))->result_array();
        $page_data['page_name']  = 'coursess';
        $page_data['page_title'] = get_phrase('subjects');
        $this->load->view('backend/index', $page_data);
    }
    
    function online_exam_result($param1 = '', $param2 = '') 
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'online_exam_result';
        $page_data['param2'] = $param1;
        $page_data['student_id'] = $param2;
        $page_data['page_title'] = get_phrase('online_exam_results');
        $this->load->view('backend/index', $page_data);
    }

    function manage_classes($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'create') 
        {
            $data['name']         = $this->input->post('name');
            $data['teacher_id']   = $this->input->post('teacher_id');
            $this->db->insert('class', $data);
            $class_id = $this->db->insert_id();
            $data2['class_id']  =   $class_id;
            $data2['name']      =   'A';
            $this->db->insert('section' , $data2);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/grados/', 'refresh');
        }
        if ($param1 == 'update')
        {
            $data['name']         = $this->input->post('name');
            $data['teacher_id']   = $this->input->post('teacher_id');
            $this->db->where('class_id', $param2);
            $this->db->update('class', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/grados/', 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $this->db->where('class_id', $param2);
            $this->db->delete('class');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/grados/', 'refresh');
        }
        $page_data['classes']    = $this->db->get('class')->result_array();
        $page_data['page_name']  = 'manage_class';
        $page_data['page_title'] = get_phrase('manage_class');
        $this->load->view('backend/index', $page_data);
    }

    function get_subject($class_id = '') 
    {
        $subject = $this->db->get_where('subject' , array('class_id' => $class_id))->result_array();
        foreach ($subject as $row) 
        {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function upload_book()
    {
        $data['libro_code'] =   substr(md5(rand(0, 1000000)), 0, 7);
        $data['nombre']                 =   $this->input->post('nombre');
        $data['autor']                  =   $this->input->post('autor');
        $data['description']            =   $this->input->post('description');
        $data['class_id']               =   $this->input->post('class_id');
        $data['subject_id']             =   $this->input->post('subject_id');
        $data['uploader_type']          =   $this->session->userdata('login_type');
        $data['uploader_id']            =   $this->session->userdata('login_user_id');
        $data['year']                   =   $this->db->get_where('settings',array('type'=>'running_year'))->row()->description;
        $data['timestamp']              =   strtotime(date("Y-m-d H:i:s"));
        $files = $_FILES['file_name'];
        $this->load->library('upload');
        $config['upload_path']   =  'uploads/libreria/';
        $config['allowed_types'] =  '*';
        $_FILES['file_name']['name']     = $files['name'];
        $_FILES['file_name']['type']     = $files['type'];
        $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
        $_FILES['file_name']['size']     = $files['size'];
        $this->upload->initialize($config);
        $this->upload->do_upload('file_name');
        $data['file_name'] = $_FILES['file_name']['name'];
        $this->db->insert('libreria', $data);
        redirect(base_url() . 'index.php?admin/virtual_library/' . $data['class_id'] , 'refresh');
    }

    function download_book($libro_code = '')
    {
        $file_name = $this->db->get_where('libreria', array('libro_code' => $libro_code))->row()->file_name;
        $this->load->helper('download');
        $data = file_get_contents("uploads/libreria/" . $file_name);
        $name = $file_name;
        force_download($name, $data);
    }

    function delete_book($libro_id = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $this->crud_model->delete_book($libro_id);
        redirect(base_url() . 'admin/virtual_library/' . $data['class_id'] , 'refresh');
    }

    function section($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $class = $this->input->post('class_id');
        if ($class == '')
        {
            $class = $this->db->get('class')->first_row()->class_id;
        }
        if($param1 == 'update')
        {
            $data['name'] = $this->input->post('name');
            $data['teacher_id'] = $this->input->post('teacher_id');
            $this->db->where('section_id', $param2);
            $this->db->update('section', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/section/', 'refresh');
        }
        $page_data['page_name']  = 'section';
        $page_data['page_title'] = get_phrase('sections');
        $page_data['class_id']   = $class;
        $this->load->view('backend/index', $page_data);    
    }

    function sections($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'create') 
        {
            $data['name']       =   $this->input->post('name');
            $data['class_id']   =   $this->input->post('class_id');
            $data['teacher_id'] =   $this->input->post('teacher_id');
            $this->db->insert('section' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/section/' . $data['class_id'] ."/", 'refresh');
        }
        if ($param1 == 'edit') {
            $data['name']       =   $this->input->post('name');
            $data['class_id']   =   $this->input->post('class_id');
            $data['teacher_id'] =   $this->input->post('teacher_id');
            $this->db->where('section_id' , $param2);
            $this->db->update('section' , $data);
            redirect(base_url() . 'admin/section/' . $data['class_id'] , 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $this->db->where('section_id' , $param2);
            $this->db->delete('section');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/section/' , 'refresh');
        }
    }

    function get_class_section($class_id = '')
    {
        $sections = $this->db->get_where('section' , array('class_id' => $class_id))->result_array();
        echo '<option value="">' . get_phrase('select') . '</option>';
        foreach ($sections as $row) 
        {
            echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_class_stundets($section_id = '')
    {
        $students = $this->db->get_where('enroll' , array('section_id' => $section_id))->result_array();
        foreach ($students as $row) 
        {
         echo '<option value="' . $row['student_id'] . '">' . $this->db->get_where('student', array('student_id'=> $row['student_id']))->row()->first_name." ".$this->db->get_where('student', array('student_id'=> $row['student_id']))->row()->last_name  . '</option>';
        }
    }

    function get_class_subject($class_id = '')
    {
        $subjects = $this->db->get_where('subject' , array('class_id' => $class_id))->result_array();
        foreach ($subjects as $row) 
        {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_class_students($class_id = '')
    {
        $students = $this->db->get_where('enroll' , array(
            'class_id' => $class_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->result_array();
        foreach ($students as $row) {
            echo '<option value="' . $row['student_id'] . '">' . $this->crud_model->get_name('student', $row['student_id']) . '</option>';
        }
    }

    function semesters($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'create') 
        {
            $data['name']    = $this->input->post('name');
            $this->db->insert('exam', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/semesters/', 'refresh');
        }
        if ($param1 == 'update') 
        {
            $data['name']    = $this->input->post('name');
            $this->db->where('exam_id', $param2);
            $this->db->update('exam', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/semesters/', 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $this->db->where('exam_id', $param2);
            $this->db->delete('exam');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/semesters/', 'refresh');
        }
        $page_data['exams']      = $this->db->get('exam')->result_array();
        $page_data['page_name']  = 'semester';
        $page_data['page_title'] = get_phrase('semesters');
        $this->load->view('backend/index', $page_data);
    }

    function update_book($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['book_id'] = $param1;
        $page_data['page_name']  =   'update_book';
        $page_data['page_title'] = get_phrase('update_book');
        $this->load->view('backend/index', $page_data);
    }

    function upload_marks($datainfo = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param2 != ""){
            $page = $param2;
        }else{
            $page = $this->db->get('exam')->first_row()->exam_id;
        }
        $info = base64_decode($datainfo);
        $ex = explode('-', $info);
        $data['exam_id']    = $page;
        $data['class_id']   = $ex[0];
        $data['section_id'] = $ex[1];
        $data['subject_id'] = $ex[2];
        $data['year']       = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
        $students = $this->db->get_where('enroll' , array('class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']))->result_array();
        foreach($students as $row) 
        {
            $verify_data = array('exam_id' => $data['exam_id'],'class_id' => $data['class_id'],'section_id' => $data['section_id'],
            'student_id' => $row['student_id'],'subject_id' => $data['subject_id'], 'year' => $data['year']);
            $query = $this->db->get_where('mark' , $verify_data);
            if($query->num_rows() < 1) 
            {   
                $data['student_id'] = $row['student_id'];
                $this->db->insert('mark' , $data);
            }
        }
        $page_data['exam_id'] = $page;
        $page_data['data'] = $datainfo;
        $page_data['page_name']  =   'upload_marks';
        $page_data['page_title'] = get_phrase('upload_marks');
        $this->load->view('backend/index', $page_data);
    }

    function marks_selector()
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $data['exam_id']    = $this->input->post('exam_id');
        $data['class_id']   = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['year']       = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
        $students = $this->db->get_where('enroll' , array('class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']))->result_array();
        foreach($students as $row) 
        {
        $verify_data = array('exam_id' => $data['exam_id'],
                            'class_id' => $data['class_id'],
                            'section_id' => $data['section_id'],
                            'student_id' => $row['student_id'],
                                'subject_id' => $data['subject_id'],
                                    'year' => $data['year']);

        $query = $this->db->get_where('mark' , $verify_data);
        if($query->num_rows() < 1) 
        {   
                $data['student_id'] = $row['student_id'];
                $this->db->insert('mark' , $data);
        }
     }
        redirect(base_url() . 'admin/marks_upload/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['subject_id'] , 'refresh');
    }

    function marks_update($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $marks_of_students = $this->db->get_where('mark' , array('exam_id' => $exam_id, 'class_id' => $class_id,'section_id' => $section_id, 'year' => $running_year,'subject_id' => $subject_id))->result_array();
        foreach($marks_of_students as $row) 
        {
            $obtained_marks = $this->input->post('marks_obtained_'.$row['mark_id']);
            $labouno = $this->input->post('lab_uno_'.$row['mark_id']);
            $labodos = $this->input->post('lab_dos_'.$row['mark_id']);
            $labotres = $this->input->post('lab_tres_'.$row['mark_id']);
            $labocuatro = $this->input->post('lab_cuatro_'.$row['mark_id']);
            $labocinco = $this->input->post('lab_cinco_'.$row['mark_id']);
            $laboseis = $this->input->post('lab_seis_'.$row['mark_id']);
            $labosiete = $this->input->post('lab_siete_'.$row['mark_id']);
            $laboocho = $this->input->post('lab_ocho_'.$row['mark_id']);
            $labonueve = $this->input->post('lab_nueve_'.$row['mark_id']);
            $comment = $this->input->post('comment_'.$row['mark_id']);
            $labototal = $obtained_marks + $labouno + $labodos + $labotres + $labocuatro + $labocinco + $laboseis + $labosiete + $laboocho + $labonueve + $labfinal;
            $this->db->where('mark_id' , $row['mark_id']);
            $this->db->update('mark' , array('mark_obtained' => $obtained_marks , 'labuno' => $labouno
            , 'labdos' => $labodos, 'labtres' => $labotres, 'labcuatro' => $labocuatro, 'labcinco' => $labocinco, 'labseis' => $laboseis
                , 'labsiete' => $labosiete, 'labocho' => $laboocho, 'labnueve' => $labonueve, 'labtotal' => $labototal, 'comment' => $comment));
        }
        $info = base64_encode($class_id.'-'.$section_id.'-'.$subject_id);
        $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
        redirect(base_url().'admin/upload_marks/'.$info.'/'.$exam_id.'/' , 'refresh');
    }

    function tab_sheet($class_id = '' , $exam_id = '', $section_id = '') 
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($this->input->post('operation') == 'selection') 
        {
            $page_data['exam_id']    = $this->input->post('exam_id');
            $page_data['section_id']    = $this->input->post('section_id');
            $page_data['class_id']   = $this->input->post('class_id');
            if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0) 
            {
                redirect(base_url() . 'admin/tab_sheet/' . $page_data['class_id'] . '/' . $page_data['exam_id']. '/' . $page_data['section_id'] , 'refresh');
            } else 
            {
                redirect(base_url() . 'admin/tab_sheet/', 'refresh');
            }
        }
        $page_data['exam_id']    = $exam_id;
        $page_data['class_id']   = $class_id;
        $page_data['section_id']   = $section_id;
        $page_data['page_info'] = 'Exam marks';
        $page_data['page_name']  = 'tab_sheet';
        $page_data['page_title'] = get_phrase('tabulation_sheet');
        $this->load->view('backend/index', $page_data);
    }

    function tab_sheet_print($class_id  = '', $section_id = '', $subject_id = '') 
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['class_id'] = $class_id;
        $page_data['exam_id']  = $exam_id;
        $page_data['section_id']  = $section_id;
        $page_data['subject_id']  = $subject_id;
        $this->load->view('backend/admin/tab_sheet_print' , $page_data);
    }

    function marks_get_subject($class_id = '')
    {
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/admin/marks_get_subject' , $page_data);
    }

    function class_routine($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'create') 
        {
            $data['class_id']       = $this->input->post('class_id');
            if($this->input->post('section_id') != '') 
            {
                $data['section_id'] = $this->input->post('section_id');
            }
            $subject_id = $this->input->post('subject_id');
            $teacher_id = $this->db->get_where('subject', array('subject_id' => $subject_id))->row()->teacher_id;
            $data['subject_id']     = $this->input->post('subject_id');
            $data['time_start']     = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
            $data['time_end']       = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
            $data['time_start_min'] = $this->input->post('time_start_min');
            $data['time_end_min']   = $this->input->post('time_end_min');
            $data['day']            = $this->input->post('day');
            if($this->input->post('ending_ampm') == 1){
                $sts = "AM";
            }else{
                $sts = "PM";
            }
            $data['amend']            = $sts;
            if($this->input->post('starting_ampm') == 1){
                $st = "AM";
            }else{
                $st = "PM";
            }
            $data['amend']            = $sts;
            $data['amstart']            = $st;
            $data['day']            = $this->input->post('day');
            $data['teacher_id'] = $teacher_id;
            $data['year']           = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->insert('class_routine', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/class_routine_view/', 'refresh');
        }
        if ($param1 == 'update') 
        {
            $data['time_start']     = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
            $data['time_end']       = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
            $data['time_start_min'] = $this->input->post('time_start_min');
            $data['time_end_min']   = $this->input->post('time_end_min');
            if($this->input->post('ending_ampm') == 1){
                $sts = "AM";
            }else{
                $sts = "PM";
            }
            $data['amend']            = $sts;
            if($this->input->post('starting_ampm') == 1){
                $st = "AM";
            }else{
                $st = "PM";
            }
            $data['amstart']            = $st;
            $data['day']            = $this->input->post('day');
            $data['year']           = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->where('class_routine_id', $param2);
            $this->db->update('class_routine', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/class_routine_view/', 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $this->db->where('class_routine_id', $param2);
            $this->db->delete('class_routine');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/class_routine_view/' . $class_id, 'refresh');
        } 
    }

    function exam_routine($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'create') 
        {
            $data['class_id']       = $this->input->post('class_id');
            if($this->input->post('section_id') != '') 
            {
                $data['section_id'] = $this->input->post('section_id');
            }
            if($this->input->post('ending_ampm') == 1){
                $sts = "AM";
            }else{
                $sts = "PM";
            }
            $data['amend']            = $sts;
            if($this->input->post('starting_ampm') == 1){
                $st = "AM";
            }else{
                $st = "PM";
            }
            $data['amend']            = $sts;
            $data['amstart']            = $st;
            $data['teacher_id']     = $this->db->get_where('subject', array('subject_id' => $this->input->post('subject_id')))->row()->teacher_id;
            $data['subject_id']     = $this->input->post('subject_id');
            $data['time_start']     = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
            $data['time_end']       = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
            $data['time_start_min'] = $this->input->post('time_start_min');
            $data['time_end_min']   = $this->input->post('time_end_min');
            $data['fecha']          = $this->input->post('datetimepicker');
            $data['day']            = $this->input->post('day');
            $data['year']           = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->insert('horarios_examenes', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/looking_routine/', 'refresh');
        }
        if ($param1 == 'update') 
        {
            if($this->input->post('ending_ampm') == 1){
                $sts = "AM";
            }else{
                $sts = "PM";
            }
            $data['amend']            = $sts;
            if($this->input->post('starting_ampm') == 1){
                $st = "AM";
            }else{
                $st = "PM";
            }
            $data['amend']            = $sts;
            $data['amstart']            = $st;
            $data['time_start']     = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
            $data['time_end']       = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
            $data['time_start_min'] = $this->input->post('time_start_min');
            $data['time_end_min']   = $this->input->post('time_end_min');
            $data['day']            = $this->input->post('day');
            $data['year']           = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->where('horario_id', $param2);
            $this->db->update('horarios_examenes', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/looking_routine/', 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $class_id = $this->db->get_where('horarios_examenes' , array('horario_id' => $param2))->row()->class_id;
            $this->db->where('horario_id', $param2);
            $this->db->delete('horarios_examenes');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/looking_routine/', 'refresh');
        }
    }

    function looking_routine()
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $id = $this->input->post('class_id');
        if ($id == '')
        {
            $id = $this->db->get('class')->first_row()->class_id;
        }
        $page_data['page_name']  = 'looking_routine';
        $page_data['id']  =   $id;
        $page_data['page_title'] = get_phrase('exam_routine');
        $this->load->view('backend/index', $page_data);
    }

    function add_exam_routine()
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'add_exam_routine';
        $page_data['page_title'] = get_phrase('add_exam_routine');
        $this->load->view('backend/index', $page_data);
    }

    function class_routine_add()
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'class_routine_add';
        $page_data['page_title'] = "";
        $this->load->view('backend/index', $page_data);
    }

    function class_routine_view($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $id = $this->input->post('class_id');
        if ($id == '')
        {
            $id = $this->db->get('class')->first_row()->class_id;
        }
        if($param1 == 'update')
        {
           $id = $_POST['Event'][0];
	   $start = $_POST['Event'][1];
	   $end = $_POST['Event'][2];

           $data['start'] = $start;
           $data['end'] = $end;
           $this->db->where('id', $id);
           $this->db->update('events', $data);
	        echo 1;
        }
        $page_data['page_name']  = 'class_routine_view';
        $page_data['id']  =   $id;
        $page_data['page_title'] = get_phrase('class_routine');
        $this->load->view('backend/index', $page_data);
    }

    function get_class_section_subject($class_id = '')
    {
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/admin/class_routine_section_subject_selector' , $page_data);
    }

    function section_subject_edit($class_id  = '', $class_routine_id = '')
    {
        $page_data['class_id']          =   $class_id;
        $page_data['class_routine_id']  =   $class_routine_id;
        $this->load->view('backend/admin/class_routine_section_subject_edit' , $page_data);
    }

    function attendance()
    {
        if($this->session->userdata('admin_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        $page_data['page_name']  =  'attendance';
        $page_data['page_title'] =  get_phrase('attendance');
        $this->load->view('backend/index', $page_data);
    }

    function manage_attendance($class_id = '' , $section_id = '' , $timestamp = '')
    {
        if($this->session->userdata('admin_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        $class_name = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
        $page_data['class_id'] = $class_id;
        $page_data['timestamp'] = $timestamp;
        $page_data['page_name'] = 'manage_attendance';
        $section_name = $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
        $page_data['section_id'] = $section_id;
        $page_data['page_title'] = get_phrase('attendance');
        $this->load->view('backend/index', $page_data);
    }

    function get_sectionss($class_id = '')
    {
        $sections = $this->db->get_where('section' , array('class_id' => $class_id))->result_array();
        foreach ($sections as $row) 
        {
            echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_section($class_id = '') 
    {
          $page_data['class_id'] = $class_id; 
          $this->load->view('backend/admin/manage_attendance_section_holder' , $page_data);
    }

     function attendance_report($param1 = '', $param2 = '', $param3 = '', $param4 = '') 
     {
        if($param1 == 'check')
        {
            $data['class_id']   = $this->input->post('class_id');
            $data['year']       = $this->input->post('year');
            $data['month']  = $this->input->post('month');
            $data['section_id'] = $this->input->post('section_id');
            redirect(base_url().'admin/attendance_report/'.$data['class_id'].'/'.$data['section_id'].'/'.$data['month'].'/'.$data['year'],'refresh');
        }
        $page_data['class_id'] = $param1;
        $page_data['month']    = $param3;
        $page_data['year']    = $param4;
        $page_data['section_id'] = $param2;
        $page_data['page_name']    = 'attendance_report';
        $page_data['page_title']   = get_phrase('attendance_report');
        $this->load->view('backend/index',$page_data);
     }
     
    function get_class_studentss($section_id = '')
    {
        $students = $this->db->get_where('enroll' , array('section_id' => $section_id))->result_array();
        foreach ($students as $row) 
        {
         echo '<option value="' . $row['student_id'] . '">' . $this->crud_model->get_name('student', $row['student_id'])  . '</option>';
        }
    }
    
    function tabulation_report($param1 = '', $param2 = '')
    {
      if ($this->session->userdata('admin_login') != 1)
      {
        redirect(base_url(), 'refresh');
      }
      $page_data['class_id']   = $this->input->post('class_id');
      $page_data['section_id']   = $this->input->post('section_id');
      $page_data['subject_id']   = $this->input->post('subject_id');
      $page_data['page_name']   = 'tabulation_report';
      $page_data['page_title']  = get_phrase('tabulation_report');
      $this->load->view('backend/index', $page_data);
    }
    
    function accounting_report($param1 = '', $param2 = '')
    {
      if ($this->session->userdata('admin_login') != 1)
      {
        redirect(base_url(), 'refresh');
      }
      $page_data['page_name']   = 'accounting_report';
      $page_data['page_title']  = get_phrase('accounting_report');
      $this->load->view('backend/index', $page_data);
    }
     
     function marks_report($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'generate')
        {
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/marks_report/', 'refresh');
        }
        $page_data['class_id']   = $this->input->post('class_id');
        $page_data['section_id']   = $this->input->post('section_id');
        $page_data['student_id']   = $this->input->post('student_id');
        $page_data['exam_id']   = $this->input->post('exam_id');
        $page_data['page_name']   = 'marks_report';
        $page_data['page_title']  = get_phrase('marks_report');
        $this->load->view('backend/index', $page_data);
    }

     function report_attendance_view($class_id = '' , $section_id = '', $month = '', $year = '') 
     {
        if($this->session->userdata('admin_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        $class_name = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
        $page_data['class_id'] = $class_id;
        $page_data['month']    = $month;
        $page_data['year']    = $year;
        $page_data['page_name'] = 'report_attendance_view';
        $section_name = $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
        $page_data['section_id'] = $section_id;
        $page_data['page_title'] = get_phrase('attendance_report');
        $this->load->view('backend/index', $page_data);
     }

    function create_report($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'send')
        {
            $parent_id = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->parent_id;
            $student_name = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->name;
            $parent_phone = $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->phone;
            $parent_email = $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->email;
            $data['student_id'] = $this->input->post('student_id');
            $data['class_id']   = $this->input->post('class_id');
            $data['section_id'] = $this->input->post('section_id');
            $one = 'admin';
            $two = $this->session->userdata('login_user_id');
            $data['user_id']    = $one."-".$two;
            $data['title']      = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['file'] = $_FILES["file_name"]["name"];
            $data['date'] = date('d M, Y');
            $data['priority'] = $this->input->post('priority');
            $data['status'] = 0;
            $data['code'] = substr(md5(rand(0, 1000000)), 0, 7);
            $this->db->insert('reports', $data);
            $this->crud_model->students_reports($this->input->post('student_id'),$parent_id);
            move_uploaded_file($_FILES["file_name"]["tmp_name"], 'uploads/report_files/'. $_FILES["file_name"]["name"]);
            
            $notify = $this->db->get_where('settings' , array('type' => 'students_reports'))->row()->description;
            if($notify == 1)
            {
              $message = "A behavioral report has been created for " . $student_name;
              $sms_status = $this->db->get_where('settings' , array('type' => 'sms_status'))->row()->description;
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
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/request_student/', 'refresh');
        }
        if($param1 == 'response')
        {
            $data['report_code'] = $this->input->post('report_code');
            $data['message'] = $this->input->post('message');
            $data['date'] = date('d M, Y');
            $data['sender_type'] = $this->session->userdata('login_type');
            $data['sender_id'] = $this->session->userdata('login_user_id');
            $this->db->insert('report_response', $data);
        }
        if($param1 == 'update')
        {
            $notify['notify'] =  "<b>".$this->db->get_where('reports', array('code' => $param2))->row()->title."</b>"." ". get_phrase('report_solved');

            $user = $this->db->get_where('reports', array('code' => $param2))->row()->user_id;
            $final = explode("-", $user);
            $user_type = $final[0];
            $user_id = $final[1];
            $student_id = $this->db->get_where('reports', array('code' => $param2))->row()->student_id;
            $parent_id  = $this->db->get_where('student', array('student_id' => $student_id))->row()->parent_id;

            $notify['user_id'] = $user_id;
            $notify['user_type'] = $user_type;
            $notify['url'] = $user_type."/view_report/".$param2;
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['original_id'] = $this->session->userdata('login_user_id');
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);

            $notify2['notify'] = $notify['notify'];
            $notify2['user_id'] = $parent_id;
            $notify2['user_type'] = 'parent';
            $notify2['url'] = "parents/view_report/".$param2;
            $notify2['date'] = date('d M, Y');
            $notify2['time'] = date('h:i A');
            $notify2['status'] = 0;
            $notify2['original_id'] = $this->session->userdata('login_user_id');
            $notify2['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify2);

            $data['status'] = 1;
            $this->db->where('code', $param2);
            $this->db->update('reports', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/looking_report/'.$param2, 'refresh');
        }
    }
    
    function calendar($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
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
         if($param1 == 'create')
         {
            if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['color']))
            {
	            $title = $_POST['title'];
	            $start = $_POST['start'];
	            $end = $_POST['end'];
            	$color = $_POST['color'];
                $this->db->query("INSERT INTO events(title, start, end, color) values ('$title', '$start', '$end', '$color')");
                $this->crud_model->send_calendar_notify();
            }
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/calendar/', 'refresh');
         }
         if($param1 == 'update'){
            if (isset($_POST['delete']) && isset($_POST['id']))
            {
                $id = $_POST['id'];
                $query = $this->db->query("DELETE FROM events WHERE id = $id");
                if ($query == false) 
                {
                    die ('Erreur prepare');
                }
                $res = $query;
                if ($res == false) 
                {
                    die ('Erreur execute');
                }
            }elseif (isset($_POST['title']) && isset($_POST['color']) && isset($_POST['id'])){
                $id = $_POST['id'];
                $title = $_POST['title'];
                $color = $_POST['color'];
                $query = $this->db->query("UPDATE events SET  title = '$title', color = '$color' WHERE id = $id ");
                if ($query == false) 
                {
                    die ('Erreur prepare');
                }
                $sth = $query;
                if ($sth == false) 
                {
                    die ('Erreur execute');
                }
            }
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/calendar/', 'refresh');
         }
         if($param1 == 'update_date')
         {
            if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2]))
            {
	            $id = $_POST['Event'][0];
	            $start = $_POST['Event'][1];
	            $end = $_POST['Event'][2];
	            $query = $this->db->query("UPDATE events SET  start = '$start', end = '$end' WHERE id = $id ");
	            if ($query == false) {
	                die ('Erreur prepare');
	            }
	            else{
    		        die ('OK');
	            }
            }
         }
        $page_data['page_name']  = 'calendar';
        $page_data['page_title'] = get_phrase('calendar');
        $this->load->view('backend/index', $page_data); 
    }

    function attendance_report_selector()
    {
       if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $data['class_id']   = $this->input->post('class_id');
        $data['year']       = $this->input->post('year');
        $data['month']  = $this->input->post('month');
        $data['section_id'] = $this->input->post('section_id');
        redirect(base_url().'admin/report_attendance_view/'.$data['class_id'].'/'.$data['section_id'].'/'.$data['month'].'/'.$data['year'],'refresh');
    }
   
    function students_payments($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        $page_data['page_name']  = 'students_payments';
        $page_data['page_title'] = get_phrase('student_payments');
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data); 
    }

    function payments($param1 = '' , $param2 = '' , $param3 = '') 
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'payments';
        $page_data['page_title'] = get_phrase('payments');
        $this->load->view('backend/index', $page_data); 
    }

    function expense($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
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

            redirect(base_url() . 'admin/expense', 'refresh');
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
            redirect(base_url() . 'admin/expense', 'refresh');
        }
        if ($param1 == 'delete') {
            $this->db->where('payment_id' , $param2);
            $this->db->delete('payment');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/expense/', 'refresh');
        }
        $page_data['page_name']  = 'expense';
        $page_data['page_title'] = get_phrase('expense');
        $this->load->view('backend/index', $page_data); 
    }

    function expense_category($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'create') {
            $data['name']   =   $this->input->post('name');
            $this->db->insert('expense_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/expense');
        }
        if ($param1 == 'update') {
            $data['name']   =   $this->input->post('name');
            $this->db->where('expense_category_id' , $param2);
            $this->db->update('expense_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/expense');
        }
        if ($param1 == 'delete') {
            $this->db->where('expense_category_id' , $param2);
            $this->db->delete('expense_category');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/expense');
        }
        $page_data['page_name']  = 'expense';
        $page_data['page_title'] = get_phrase('expense');
        $this->load->view('backend/index', $page_data);
    }

     function teacher_attendance()
    {
        if($this->session->userdata('admin_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        $page_data['page_name']  =  'teacher_attendance';
        $page_data['page_title'] =  get_phrase('teacher_attendance');
        $this->load->view('backend/index', $page_data);
    }

    function teacher_attendance_report() 
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
         $page_data['month']        =  date('m');
         $page_data['page_name']    = 'teacher_attendance_report';
         $page_data['page_title']   = get_phrase('teacher_attendance_report');
         $this->load->view('backend/index',$page_data);
     }

    function teacher_report_selector()
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $data['year']       = $this->input->post('year');
        $data['month']      = $this->input->post('month');
        $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
        redirect(base_url().'admin/teacher_report_view/'.$data['month'].'/'.$data['year'],'refresh');
    }

    function teacher_report_view($month = '', $year = '') 
    {
        if($this->session->userdata('admin_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        $page_data['month']    = $month;
        $page_data['year']    = $year;
        $page_data['page_name'] = 'teacher_report_view';
        $page_data['page_title'] = get_phrase('teacher_attendance_report');
        $this->load->view('backend/index', $page_data);
     }

    function attendance_teacher()
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $data['year']       = $this->input->post('year');
        $str = $this->input->post('timestamp');
        $originalDate =$this->input->post('timestamp');
        $newDate = date("d-m-Y", strtotime($originalDate));
        $data['timestamp']  = strtotime($newDate);
        $query = $this->db->get_where('teacher_attendance' ,array('year'=>$data['year'],'timestamp'=>$data['timestamp']));
        if($query->num_rows() < 1) 
        {
            $teacher = $this->db->get_where('teacher')->result_array();
            foreach($teacher as $row) 
            {
                $attn_data['teacher_id']   = $row['teacher_id'];
                $attn_data['year']       = $data['year'];
                $attn_data['timestamp']  = $data['timestamp'];
                $this->db->insert('teacher_attendance' , $attn_data);  
            }
        }
        redirect(base_url().'admin/teacher_attendance_view/'. $data['timestamp'],'refresh');
    }

    function attendance_update2($timestamp = '')
    {
         if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $attendance_of = $this->db->get_where('teacher_attendance' , array('year'=>$running_year,'timestamp'=>$timestamp))->result_array();
        foreach($attendance_of as $row) 
        {
            $attendance_status = $this->input->post('status_'.$row['attendance_id']);
            $this->db->where('attendance_id' , $row['attendance_id']);
            $this->db->update('teacher_attendance' , array('status' => $attendance_status));
        }
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
        redirect(base_url().'admin/teacher_attendance_view/'.$timestamp , 'refresh');
    }

    function teacher_attendance_view($timestamp = '')
    {
        if($this->session->userdata('admin_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        $page_data['timestamp'] = $timestamp;
        $page_data['page_name'] = 'teacher_attendance_view';
        $page_data['page_title'] = get_phrase('teacher_attendance');
        $this->load->view('backend/index', $page_data);
    }

    function school_bus($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'create') 
        {
            $data['route_name']        = $this->input->post('route_name');
            $data['number_of_vehicle'] = $this->input->post('number_of_vehicle');
            $data['driver_name'] = $this->input->post('driver_name');
            $data['driver_phone'] = $this->input->post('driver_phone');
            $data['route']        = $this->input->post('route');
            $data['route_fare']        = $this->input->post('route_fare');
            $this->db->insert('transport', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/school_bus/', 'refresh');
        }
        if ($param1 == 'update') 
        {
            $data['route_name']        = $this->input->post('route_name');
            $data['number_of_vehicle'] = $this->input->post('number_of_vehicle');
            $data['driver_name'] = $this->input->post('driver_name');
            $data['driver_phone'] = $this->input->post('driver_phone');
            $data['route']        = $this->input->post('route');
            $data['route_fare']        = $this->input->post('route_fare');
            $this->db->where('transport_id', $param2);
            $this->db->update('transport', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/school_bus', 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $this->db->where('transport_id', $param2);
            $this->db->delete('transport');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/school_bus/', 'refresh');
        }
        $page_data['transports'] = $this->db->get('transport')->result_array();
        $page_data['page_name']  = 'school_bus';
        $page_data['page_title'] = get_phrase('school_bus');
        $this->load->view('backend/index', $page_data); 
    }

    function classrooms($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {

           redirect(base_url(), 'refresh');
        }
        if ($param1 == 'create') 
        {
            $data['name']           = $this->input->post('name');
            $data['number']         = $this->input->post('number');
            $this->db->insert('dormitory', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'admin/classrooms/', 'refresh');
        }
        if ($param1 == 'update') 
        {
            $data['name']           = $this->input->post('name');
            $this->db->where('dormitory_id', $param2);
            $this->db->update('dormitory', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/classrooms/', 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $this->db->where('dormitory_id', $param2);
            $this->db->delete('dormitory');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/classrooms/', 'refresh');
        }
        $page_data['dormitories'] = $this->db->get('dormitory')->result_array();
        $page_data['page_name']   = 'classroom';
        $page_data['page_title']  = get_phrase('classrooms');
        $this->load->view('backend/index', $page_data);
    }

     function social($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'login')
        {   
            $data['description'] = $this->input->post('social_login');
            $this->db->where('type' , 'social_login');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('google_login');
            $this->db->where('type' , 'google_login');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('google_sync');
            $this->db->where('type' , 'google_sync');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/system_settings/', 'refresh');
        }
    }

    function system_settings($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'do_update') 
        {
            $data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
            $this->db->update('settings' , $data);
            
            $data['description'] = $this->input->post('language');
            $this->db->where('type' , 'language');
            $this->db->update('settings' , $data);
            
            $data['description'] = $this->input->post('timezone');
            $this->db->where('type' , 'timezone');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('register');
            $this->db->where('type' , 'register');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_title');
            $this->db->where('type' , 'system_title');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('address');
            $this->db->where('type' , 'address');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('phone');
            $this->db->where('type' , 'phone');
            $this->db->update('settings' , $data);
            
            $data['description'] = $this->input->post('facebook');
            $this->db->where('type' , 'facebook');
            $this->db->update('settings' , $data);
            
            $data['description'] = $this->input->post('twitter');
            $this->db->where('type' , 'twitter');
            $this->db->update('settings' , $data);
            
            $data['description'] = $this->input->post('instagram');
            $this->db->where('type' , 'instagram');
            $this->db->update('settings' , $data);
            
            $data['description'] = $this->input->post('youtube');
            $this->db->where('type' , 'youtube');
            $this->db->update('settings' , $data);
            
            $data['description'] = $this->input->post('currency');
            $this->db->where('type' , 'currency');
            $this->db->update('settings' , $data);
            
            $data['description'] = $this->input->post('paypal_email');
            $this->db->where('type' , 'paypal_email');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_email');
            $this->db->where('type' , 'system_email');
            $this->db->update('settings' , $data);


            $data['description'] = $this->input->post('running_year');
            $this->db->where('type' , 'running_year');
            $this->db->update('settings' , $data);
        
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/system_settings/', 'refresh');
        }
        if($param1 == 'skin')
        {
            $md5 = md5(date('d-m-y H:i:s'));
            
            if($_FILES['favicon']['size'] > 0)
            {
                $data['description'] = $md5.str_replace(' ', '', $_FILES['favicon']['name']);
                $this->db->where('type' , 'favicon');
                $this->db->update('settings' , $data);
                move_uploaded_file($_FILES['favicon']['tmp_name'], 'uploads/' . $md5.str_replace(' ', '', $_FILES['favicon']['name']));
            }
            
            if($_FILES['logow']['size'] > 0)
            {
                $data['description'] = $md5.str_replace(' ', '', $_FILES['logow']['name']);
                $this->db->where('type' , 'logow');
                $this->db->update('settings' , $data);
                move_uploaded_file($_FILES['logow']['tmp_name'], 'uploads/' . $md5.str_replace(' ', '', $_FILES['logow']['name']));
            }
            
            if($_FILES['icon_white']['size'] > 0)
            {
                $data['description'] = $md5.str_replace(' ', '', $_FILES['icon_white']['name']);
                $this->db->where('type' , 'icon_white');
                $this->db->update('settings' , $data);
                move_uploaded_file($_FILES['icon_white']['tmp_name'], 'uploads/' . $md5.str_replace(' ', '', $_FILES['icon_white']['name']));
            }
            
            if($_FILES['userfile']['size'] > 0)
            {
                $data['description'] = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
                $this->db->where('type' , 'logo');
                $this->db->update('settings' , $data);
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            }
            
            if($_FILES['bglogin']['size'] > 0)
            {
                $data['description'] = $md5.str_replace(' ', '', $_FILES['bglogin']['name']);
                $this->db->where('type' , 'bglogin');
                $this->db->update('settings' , $data);
                move_uploaded_file($_FILES['bglogin']['tmp_name'], 'uploads/' . $md5.str_replace(' ', '', $_FILES['bglogin']['name']));
            }
            
            if($_FILES['logocolor']['size'] > 0)
            {
                $data['description'] = $md5.str_replace(' ', '', $_FILES['logocolor']['name']);
                $this->db->where('type' , 'logocolor');
                $this->db->update('settings' , $data);
                move_uploaded_file($_FILES['logocolor']['tmp_name'], 'uploads/' . $md5.str_replace(' ', '', $_FILES['logocolor']['name']));
            }
            
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/system_settings/', 'refresh');
        }
        if($param1 == 'social')
        {
            $data['description'] = $this->input->post('facebook');
            $this->db->where('type' , 'facebook');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('twitter');
            $this->db->where('type' , 'twitter');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('instagram');
            $this->db->where('type' , 'instagram');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('youtube');
            $this->db->where('type' , 'youtube');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'admin/system_settings/', 'refresh');
        }
        $page_data['page_name']  = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    function grados($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'grados';
        $page_data['page_title'] = get_phrase('classes');
        $this->load->view('backend/index', $page_data);
    }
    
    function cursos($class_id = '')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['class_id']  = $class_id;
        $page_data['page_name']  = 'cursos';
        $page_data['page_title'] =  get_phrase('subjects');
        $this->load->view('backend/index', $page_data);
    }

    function library($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1){
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

                    $notify['notify'] = "<strong>". $this->crud_model->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'))."</strong>". " ". get_phrase('book_added')." <b>".$this->db->get_where('class', array('class_id' => $this->input->post('class_id')))->row()->name."</b>";
            
                    $students = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id')))->result_array();
                    foreach($students as $row1)
                    {
                        $notify2['notify'] = $notify['notify'];
                        $notify2['user_id'] = $row1['student_id'];
                        $notify2['user_type'] = "student";
                        $notify2['url'] = "student/library/";
                        $notify2['date'] = date('d M, Y');
                        $notify2['time'] = date('h:i A');
                        $notify2['status'] = 0;
                        $notify2['original_id'] = $this->session->userdata('login_user_id');
                        $notify2['original_type'] = $this->session->userdata('login_type');
                        $this->db->insert('notification', $notify2);
                    }
                    $this->session->set_flashdata('flash_message' , get_phrase('successfully_uploaded'));
                    redirect(base_url() . 'admin/library', 'refresh');
                } 
                else 
                {
                    $this->session->set_flashdata('error_message' , "Extension not allowed.");
                    redirect(base_url() . 'admin/library/' , 'refresh');
                }
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
                $this->db->insert('book', $data);

                 $notify['notify'] = "<strong>". $this->crud_model->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'))."</strong>". " ". get_phrase('book_added')." <b>".$this->db->get_where('class', array('class_id' => $this->input->post('class_id')))->row()->name."</b>";
            
                $students = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id')))->result_array();
                foreach($students as $row1)
                {
                    $notify2['notify'] = $notify['notify'];
                    $notify2['user_id'] = $row1['student_id'];
                    $notify2['user_type'] = "student";
                    $notify2['url'] = "student/library/";
                    $notify2['date'] = date('d M, Y');
                    $notify2['time'] = date('h:i A');
                    $notify2['status'] = 0;
                    $notify2['original_id'] = $this->session->userdata('login_user_id');
                    $notify2['original_type'] = $this->session->userdata('login_type');
                    $this->db->insert('notification', $notify2);
                }
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
                redirect(base_url() . 'admin/library', 'refresh');
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
                    $data['type']        = $this->input->post('type');
                    $data['total_copies']      = $this->input->post('total_copies');
                    $data['file_name']   = $_FILES["file_name"]["name"];
                    $data['status']      = $this->input->post('status');
                    move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/library/" . $_FILES["file_name"]["name"]);
                    $this->db->where('book_id', $param2);
                    $this->db->update('book', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
                    redirect(base_url() . 'admin/update_book/'.$param2, 'refresh');
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
                redirect(base_url() . 'admin/update_book/'.$param2, 'refresh');
            }
        }
        if ($param1 == 'delete') 
        {
            $this->db->where('book_id', $param2);
            $this->db->delete('book');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/library', 'refresh');
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

     function marks_print_view($student_id  = '', $exam_id = '') 
     {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $class_id     = $this->db->get_where('enroll' , array(
            'student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->row()->class_id;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;

        $page_data['student_id'] =   $student_id;
        $page_data['class_id']   =   $class_id;
        $page_data['exam_id']    =   $exam_id;
        $this->load->view('backend/admin/marks_print_view', $page_data);
    }
    
    function upload_file($param1 = '', $param2 = '')
    {
        $page_data['token']  = $param1;
        $page_data['page_name']  = 'upload_file';
        $page_data['page_title'] = get_phrase('library');
        $this->load->view('backend/index', $page_data);
    }
    
    function folders($task = '', $param2 = '')
    {
      if ($this->session->userdata('admin_login') != 1)
      {
        redirect(base_url(), 'refresh');
      }
      if($task == 'update')
      {
        $user_folder = md5($this->session->userdata('login_user_id'));
        $old_folder = $this->db->get_where('folder', array('folder_id' => $param2))->row()->name;
        rename('uploads/users/admin/'.$user_folder.'/'.$old_folder,'uploads/users/admin/'.$user_folder.'/'.$this->input->post('name'));
        
        $data['name'] = $this->input->post('name');
        $data['token'] = base64_encode($this->input->post('name'));
        $this->db->where('folder_id', $param2);
        $this->db->update('folder', $data);
        $this->session->set_flashdata('flash_message' ,get_phrase('successfully_updated'));
        redirect(base_url() . 'admin/folders/', 'refresh');
      }
      if($task == 'delete')
      {
        $user_folder = md5($this->session->userdata('login_user_id'));
        $folder = $this->db->get_where('folder', array('folder_id' => $param2))->row()->name;
        $this->deleteDir('uploads/users/admin/'.$user_folder.'/'.$folder);
        $this->db->where('folder_id', $param2);
        $this->db->delete('folder');
        $this->session->set_flashdata('flash_message' ,get_phrase('successfully_deleted'));
        redirect(base_url() . 'admin/folders/', 'refresh');
      }
      $page_data['page_title']             = get_phrase('my_folders');
      $page_data['token']   = $task;
      $page_data['page_name']   = 'folders';
      $this->load->view('backend/index', $page_data);
    }
    
    function deleteDir($path  = '') {
        return is_file($path) ? @unlink($path) :
        array_map(__FUNCTION__, glob($path.'/*')) == @rmdir($path);
    }

    function files($task = "", $code = "")
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        }       
        if($task == 'download'){
            $user_folder = md5($this->session->userdata('login_user_id'));
            $file_name = $this->db->get_where('file', array('file_id' => $code))->row()->name;
            $folder = $this->db->get_where('file', array('file_id' => $code))->row()->folder_token;
            $folder_name = $this->db->get_where('folder', array('token' => $folder))->row()->name;
            $this->load->helper('download');
            if($folder != ""){
                $data = file_get_contents("uploads/users/admin/". $user_folder."/".$folder_name.'/'.$file_name);
            }else{
                $data = file_get_contents("uploads/users/admin/". $user_folder.'/'.$file_name);
            }
            $name = $file_name;
            force_download($name, $data);
        }
        if($task == 'create_folder')
        {
            $folder = md5($this->session->userdata('login_user_id'));
            if (!file_exists('uploads/users/'.$this->session->userdata('login_type').'/'.$folder)) {
                mkdir('uploads/users/'.$this->session->userdata('login_type').'/'.$folder, 0777, true);
            }
            if (!file_exists('uploads/users/'.$this->session->userdata('login_type').'/'.$folder.'/'.$this->input->post('name'))) 
            {
                $data['name'] = $this->input->post('name');
                $data['user_id'] = $this->session->userdata('login_user_id');
                $data['user_type'] = 'admin';
                $data['token'] = base64_encode($data['name']);
                $data['date'] = date('d M, Y H:iA');
                $this->db->insert('folder', $data);
                mkdir('uploads/users/'.$this->session->userdata('login_type').'/'.$folder.'/'.$data['name'], 0777, true);
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_uploaded'));
                redirect(base_url() . 'admin/folders/', 'refresh');
            }else{
                $this->session->set_flashdata('flash_message' ,get_phrase('folder_already_exist'));
                redirect(base_url() . 'admin/files/', 'refresh');
            }
        }
        if ($task == 'delete')
        {
            $user_folder = md5($this->session->userdata('login_user_id'));
            
            $file_name = $this->db->get_where('file', array('file_id' => $code))->row()->name;
            $folder = $this->db->get_where('file', array('file_id' => $code))->row()->folder_token;
            $folder_name = $this->db->get_where('folder', array('token' => $folder))->row()->name;
            if($folder != ""){
                unlink("uploads/users/admin/". $user_folder."/".$folder_name.'/'.$file_name);
            }else{
                unlink("uploads/users/admin/". $user_folder.'/'.$file_name);
            }
            $this->db->where('file_id',$code);
            $this->db->delete('file');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'admin/all/');
        }
        $data['page_name']              = 'files';
        $data['page_title']             = get_phrase('my_files');
        $this->load->view('backend/index', $data);
    }
}