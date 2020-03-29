<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }
    
    function marks_print_view($student_id , $exam_id) 
     {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect('login', 'refresh');
        }
        $ex = explode('-', base64_decode($student_id));
        $class_id     = $this->db->get_where('enroll' , array('student_id' => $this->session->userdata('login_user_id'), 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->row()->class_id;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;

        $page_data['student_id'] =   $student_id;
        $page_data['class_id']   =   $class_id;
        $page_data['exam_id']    =   $exam_id;
        $this->load->view('backend/student/marks_print_view', $page_data);
    }
    
    function submit_online_exam($online_exam_id = "")
    {
        $answer_script = array();
        $question_bank = $this->db->get_where('question_bank', array('online_exam_id' => $online_exam_id))->result_array();
        foreach ($question_bank as $question) 
        {
          $correct_answers  = $this->crud_model->get_correct_answer($question['question_bank_id']);
          $container_2 = array();
          if (isset($_POST[$question['question_bank_id']])) 
          {
              foreach ($this->input->post($question['question_bank_id']) as $row) 
              {
                  $submitted_answer = "";
                  if ($question['type'] == 'true_false') {
                      $submitted_answer = $row;
                  }
                  elseif($question['type'] == 'fill_in_the_blanks'){
                    $suitable_words = array();
                    $suitable_words_array = explode(',', $row);
                    foreach ($suitable_words_array as $key) {
                      array_push($suitable_words, strtolower($key));
                    }
                    $submitted_answer = json_encode(array_map('trim',$suitable_words));
                  }
                  else{
                      array_push($container_2, strtolower($row));
                      $submitted_answer = json_encode($container_2);
                  }
                  $container = array(
                      "question_bank_id" => $question['question_bank_id'],
                      "submitted_answer" => $submitted_answer,
                      "correct_answers"  => $correct_answers
                  );
              }
          }
          else {
              $container = array(
                  "question_bank_id" => $question['question_bank_id'],
                  "submitted_answer" => "",
                  "correct_answers"  => $correct_answers
              );
          }
          array_push($answer_script, $container);
        }
        $this->crud_model->submit_online_exam($online_exam_id, json_encode($answer_script));
        redirect(base_url() . 'student/online_exams/'.$this->input->post('datainfo').'/', 'refresh');
    }
    
    function online_exam_result($param1 = '', $param2 = '') 
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'online_exam_result';
        $page_data['param2'] = $param1;
        $page_data['page_title'] = get_phrase('online_exam_results');
        $this->load->view('backend/index', $page_data);
    }
    
    function take_online_exam($online_exam_code  = '') 
    {
        if ($this->session->userdata('student_login') != 1){
            redirect(site_url('login'), 'refresh');
        }
        $online_exam_id = $this->db->get_where('online_exam', array('code' => $online_exam_code))->row()->online_exam_id;
        $student_id = $this->session->userdata('login_user_id');
        $check = array('student_id' => $student_id, 'online_exam_id' => $online_exam_id);
        $taken = $this->db->where($check)->get('online_exam_result')->num_rows();
        $this->crud_model->change_online_exam_status_to_attended_for_student($online_exam_id);

        $status = $this->crud_model->check_availability_for_student($online_exam_id);
        if ($status == 'submitted'){
            $page_data['page_name']  = 'page_not_found';
        }
        else{
            $page_data['page_name']  = 'online_exam_take';
        }
        $page_data['page_title'] = get_phrase('online_exam');
        $page_data['online_exam_id'] = $online_exam_id;
        $page_data['exam_info'] = $this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id));
        $this->load->view('backend/index', $page_data);
    }
    
    public function index()
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($this->session->userdata('student_login') == 1)
        {
            redirect(base_url() . 'student/panel/', 'refresh');
        }
    }
    
    function subject_dashboard($data  = '') 
     {
         if ($this->session->userdata('student_login') != 1)
        { 
            redirect(base_url(), 'refresh');
        }
         $page_data['data'] = $data;
         $page_data['page_name']    = 'subject_dashboard';
         $page_data['page_title']   = get_phrase('subject_dashboard');
         $this->load->view('backend/index',$page_data);
     }
    
     function birthdays()
    {
        if ($this->session->userdata('student_login') != 1)
        { 
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'birthdays';
        $page_data['page_title'] = get_phrase('birthdays');
        $this->load->view('backend/index', $page_data);
    }

    function calendar($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('student_login') != 1)
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
        $page_data['page_name']  = 'calendar';
        $page_data['page_title'] = get_phrase('calendar');
        $page_data['code']   = $code;
        $this->load->view('backend/index', $page_data); 
    }
    
     function group($param1 = "group_message_home", $param2 = "")
     {
      if ($this->session->userdata('student_login') != 1)
      {
          redirect(base_url(), 'refresh');
      }
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
        if ($_FILES['attached_file_on_messaging']['name'] != "") {
          if($_FILES['attached_file_on_messaging']['size'] > $max_size)
          {
            $this->session->set_flashdata('error_message' , "2MB allowed");
              redirect(base_url() . 'stundent/group/group_message_read/'.$param2, 'refresh');
          }
          else{
            $file_path = 'uploads/group_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
            move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
          }
        }

        $this->crud_model->send_reply_group_message($param2);
        $this->session->set_flashdata('flash_message', get_phrase('message_sent'));
        redirect(base_url() . 'student/group/group_message_read/'.$param2, 'refresh');
      }
      $page_data['message_inner_page_name']   = $param1;
      $page_data['page_name']                 = 'group';
      $page_data['page_title']                = get_phrase('message_group');
      $this->load->view('backend/index', $page_data);
    }

    function polls($param1 = '', $param2 = '')
      {
        if ($this->session->userdata('student_login') != 1)
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
            return $this->db->insert('poll_response', $data);
        }
    }

    function exam_view($param1 = '' , $param2 = '', $question_id)
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'take_exam') 
        {
            $page_data['room_page'] = 'take_exam';
            $page_data['exam_code'] = $param2;
            if($this->db->get_where('student_question',array('exam_code'=>$param2,'student_id' => $this->session->userdata('login_user_id')))->row()->answered == 'answered')
            {
                redirect(base_url() . 'student/online_exams/', 'refresh');
            } 
        }
        if ($param1 == 'results')
        {
            $page_data['room_page'] = 'results';
            $page_data['exam_code'] = $param2;
        }
        $page_data['page_name']   = 'exam_room'; 
        $page_data['page_title']  = "";
        $this->load->view('backend/index', $page_data);
    }

   function take($exam_code  = '')
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['questions'] = $this->db->get_where('questions' , array('exam_code' => $exam_code))->result_array();
        if($this->db->get_where('student_question',array('exam_code'=>$exam_code,'student_id'=>$this->session->userdata('login_user_id')))->row()->answered == 'answered')
        {
            redirect(base_url() . 'student/online_exams/', 'refresh');
        } 
        $page_data['exam_code'] = $exam_code;
        $page_data['page_name']   = 'take'; 
        $page_data['page_title']  = "";
        $this->load->view('backend/index', $page_data);
    }

    function attendance_report() 
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['month']        = date('m');
        $page_data['page_name']    = 'attendance_report';
        $page_data['page_title']   = get_phrase('attendance_report');
        $this->load->view('backend/index',$page_data);
    }

    function examroom($online_exam_code = "") 
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $online_exam_id = $this->db->get_where('online_exam', array('code' => $online_exam_code))->row()->online_exam_id;
        
        $class_id = $this->db->get_where('online_exam', array('code' => $online_exam_code))->row()->class_id;
        $section_id = $this->db->get_where('online_exam', array('code' => $online_exam_code))->row()->section_id;
        $subject_id = $this->db->get_where('online_exam', array('code' => $online_exam_code))->row()->subject_id;
        $student_id = $this->session->userdata('login_user_id');
        $check = array('student_id' => $student_id, 'online_exam_id' => $online_exam_id);
        $taken = $this->db->where($check)->get('online_exam_result')->num_rows();
        $this->crud_model->change_online_exam_status_to_attended_for_student($online_exam_id);
        $status = $this->crud_model->check_availability_for_student($online_exam_id);
        if ($status == 'submitted')
        {
            redirect(base_url() . 'student/online_exams/'.base64_encode($class_id.'-'.$section_id.'-'.$subject_id).'/', 'refresh');
        }
        else{
            $page_data['page_name']    = 'examroom';
        }
        $page_data['code'] = $online_exam_code;
        $page_data['page_title']   = get_phrase('take_exam');
        $this->load->view('backend/index',$page_data);
    }

    function exam($code = "") 
    { 
        $page_data['questions'] = $this->db->get_where('questions' , array('exam_code' => $code))->result_array();
        if($this->db->get_where('student_question',array('exam_code'=>$code,'student_id'=>$this->session->userdata('login_user_id')))->row()->answered == 'answered')
        {
            redirect(base_url() . 'student/online_exams/', 'refresh');
        } 
        $page_data['exam_code'] = $code; 
        $page_data['page_name']    = 'exam';
        $page_data['page_title']   = get_phrase('online_exam');
        $this->load->view('backend/index',$page_data);
     }

     function exam_results($code = '') 
     {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $page_data['exam_code'] = $code;
        $page_data['page_name']     = 'exam_results';
        $page_data['page_title']    = get_phrase('exam_results');
        $this->load->view('backend/index', $page_data);
    }
    
    function print_marks() 
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        $page_data['month']        = date('m');
        $page_data['page_name']    = 'print_marks';
        $page_data['page_title']   = "";
        $this->load->view('backend/index',$page_data);
    }

    function subject_marks($data  = '', $param2  = '') 
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param2 != ""){
            $page = $param2;
        }else{
            $page = $this->db->get('exam')->first_row()->exam_id;
        }
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if($_GET['id'] != "")
        {
            $notify['status'] = 1;
            $this->db->where('id', $_GET['id']);
            $this->db->update('notification', $notify);
        }
        $page_data['exam_id'] = $page;
        $page_data['data'] = $data;
        $page_data['page_name']    = 'subject_marks';
        $page_data['page_title']   =  get_phrase('subject_marks');
        $this->load->view('backend/index',$page_data);
    }

    function view_invoice($id  = '') 
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['invoice_id'] = $id;
        $page_data['page_name']    = 'view_invoice';
        $page_data['page_title']   = get_phrase('invoice');
        $this->load->view('backend/index',$page_data);
    }

    function view_report($code  = '') 
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['code'] = $code;
        $page_data['page_name']    = 'view_report';
        $page_data['page_title']   = get_phrase('view_report');
        $this->load->view('backend/index',$page_data);
    }

    function my_profile($param1 = '', $param2 = '') 
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        include_once 'src/Google_Client.php';
        include_once 'src/contrib/Google_Oauth2Service.php';
        $clientId = $this->db->get_where('settings', array('type' => 'google_sync'))->row()->description; //Google client ID
        $clientSecret = $this->db->get_where('settings', array('type' => 'google_login'))->row()->description; //Google client secret
        $redirectURL = base_url().'auth/sync/'; //Callback URL
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
          $this->db->where('student_id', $this->session->userdata('login_user_id'));
          $this->db->update('student', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('facebook_delete'));
            redirect(base_url() . 'student/my_profile/', 'refresh');
        }
        if($param1 == '1')
        {
            $this->session->set_flashdata('error_message' , get_phrase('google_err'));
            redirect(base_url() . 'student/my_profile/', 'refresh');
        }
        if($param1 == '3')
        {
            $this->session->set_flashdata('error_message' , get_phrase('facebook_err'));
            redirect(base_url() . 'student/my_profile/', 'refresh');
        }
        if($param1 == '2')
        {
            $this->session->set_flashdata('flash_message' , get_phrase('google_true'));
            redirect(base_url() . 'student/my_profile/', 'refresh');
        }
        if($param1 == '4')
        {
            $this->session->set_flashdata('flash_message' , get_phrase('facebook_true'));
            redirect(base_url() . 'student/my_profile/', 'refresh');
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
            $this->db->where('student_id', $this->session->userdata('login_user_id'));
            $this->db->update('student', $data);
            
            unset($_SESSION['token']);
            unset($_SESSION['userData']);
            $gClient->revokeToken();
            $this->session->set_flashdata('flash_message' , get_phrase('google_delete'));
            redirect(base_url() . 'student/my_profile/', 'refresh');
        }
        if($param1 == 'update')
        {
            $md5 = md5(date('d-m-Y H:i:s'));
            $data['email'] = $this->input->post('email');
            $data['phone'] = $this->input->post('phone');
            $data['address'] = $this->input->post('address');
            if($this->input->post('password') != "")
            {
                $data['password'] = sha1($this->input->post('password'));
            }
            if($_FILES['userfile']['size'] > 0){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            $this->db->where('student_id', $this->session->userdata('login_user_id'));
            $this->db->update('student', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            clearstatcache();
            redirect(base_url().'student/student_update/','refresh');
        }
        $page_data['output']         = $output;
        $page_data['page_name']    = 'my_profile';
        $page_data['page_title']   = get_phrase('profile');
        $this->load->view('backend/index',$page_data);
     }

    function report_attendance_view($class_id = '' , $section_id = '', $month = '', $year = '') 
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
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

    function attendance_report_selector()
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $data['class_id']   = $this->input->post('class_id');
        $data['year']       = $this->input->post('year');
        $data['month']  = $this->input->post('month');
        $data['section_id'] = $this->input->post('section_id');
        redirect(base_url().'student/report_attendance_view/'.$data['class_id'].'/'.$data['section_id'].'/'.$data['month'].'/'.$data['year'],'refresh');
    }

    function panel()
    {
        if ($this->session->userdata('student_login') != 1)
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
    
    function teachers($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'teachers';
        $page_data['page_title'] = get_phrase('teachers');
        $this->load->view('backend/index', $page_data);
    }
    
    function subject($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $student_profile         = $this->db->get_where('student', array('student_id' => $this->session->userdata('student_id')))->row();
        $student_class_id        = $this->db->get_where('enroll' , array('student_id' => $student_profile->student_id,'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->row()->class_id;
        $page_data['subjects']   = $this->db->get_where('subject', array('class_id' => $student_class_id,'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->result_array();
        $page_data['page_name']  = 'subject';
        $page_data['page_title'] = get_phrase('subjects');
        $this->load->view('backend/index', $page_data);
    }
    
    function my_marks($student_id = '') 
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $student = $this->db->get_where('student' , array('student_id' => $student_id))->result_array();
        foreach ($student as $row)
        {
            if($row['student_id'] == $this->session->userdata('login_user_id'))
            {
                $page_data['student_id'] =   $student_id;
            } else if($row['parent_id'] != $this->session->userdata('login_user_id'))
            {
                redirect(base_url(), 'refresh');
            }
        }

        $class_id     = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->row()->class_id;
        $student_name = $this->db->get_where('student' , array('student_id' => $student_id))->row()->name;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
        $page_data['page_name']  =   'my_marks';
        $page_data['page_title'] =   get_phrase('marks');
        $page_data['class_id']   =   $class_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function class_routine($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        $student_profile         = $this->db->get_where('student', array('student_id' => $this->session->userdata('student_id')))->row();
        $page_data['class_id']   = $this->db->get_where('enroll' , array('student_id' => $student_profile->student_id,'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->row()->class_id;
        $page_data['student_id'] = $student_profile->student_id;
        $page_data['page_name']  = 'class_routine';
        $page_data['page_title'] = get_phrase('class_routine');
        $this->load->view('backend/index', $page_data);
    }

    function exam_routine($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        $student_profile         = $this->db->get_where('student', array('student_id' => $this->session->userdata('student_id')))->row();
        $page_data['class_id']   = $this->db->get_where('enroll' , array('student_id' => $student_profile->student_id,'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->row()->class_id;
        $page_data['student_id'] = $student_profile->student_id;
        $page_data['page_name']  = 'exam_routine';
        $page_data['page_title'] = get_phrase('exam_routine');
        $this->load->view('backend/index', $page_data);
    }

    function homework($student_id = '')
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $page_data['page_name']  = 'homework';
        $page_data['page_title'] = get_phrase('homework');
        $page_data['data']   = $student_id;
        $this->load->view('backend/index', $page_data);
    }

    function online_exams($student_id = '')
    {
        if ($this->session->userdata('student_login') != 1)
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
        $info = base64_decode($student_id);
        $ex = explode('-', $info);
        
        $page_data['exams'] = $this->crud_model->available_exams($this->session->userdata('login_user_id'),$ex[2]);
        $page_data['data'] = $student_id;
        $page_data['page_name']  = 'online_exams';
        $page_data['page_title'] = get_phrase('online_exams');
        $page_data['student_id']   = $student_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function descargar_libro($libro_code = '')
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $file_name = $this->db->get_where('libreria', array('libro_code' => $libro_code))->row()->file_name;
        $this->load->helper('download');
        $data = file_get_contents("uploads/libreria/" . $file_name);
        $name = $file_name;
        force_download($name, $data);
    }

   function invoice($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'make_payment') 
        {
            $invoice_id      = $this->input->post('invoice_id');
            $system_settings = $this->db->get_where('settings', array('type' => 'paypal_email'))->row();
            $invoice_details = $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row();
            
            $this->paypal->add_field('rm', 2);
            $this->paypal->add_field('no_note', 0);
            $this->paypal->add_field('currency_code', $this->db->get_where('settings' , array('type' =>'currency'))->row()->description);
            $this->paypal->add_field('item_name', $invoice_details->title);
            $this->paypal->add_field('amount', $invoice_details->due);
            $this->paypal->add_field('custom', $invoice_details->invoice_id);
            $this->paypal->add_field('business', $system_settings->description);
            $this->paypal->add_field('notify_url', base_url() . 'student/invoice/');
            $this->paypal->add_field('cancel_return', base_url() . 'student/invoice/paypal_cancel');
            $this->paypal->add_field('return', base_url() . 'student/invoice/paypal_success');
            $this->paypal->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
            $this->paypal->submit_paypal_post();
        }
        if ($param1 == 'paypal_cancel') 
        {
            redirect(base_url() . 'student/invoice/', 'refresh');
        }
        if ($param1 == 'paypal_success') 
        {
            foreach ($_POST as $key => $value) 
                {
                    $value = urlencode(stripslashes($value));
                    $ipn_response .= "\n$key=$value";
                }
                $data['payment_details']   = $ipn_response;
                $data['payment_timestamp'] = strtotime(date("m/d/Y"));
                $data['payment_method']    = 'paypal';
                $data['status']            = 'completed';
                $invoice_id                = $_POST['custom'];
                $this->db->where('invoice_id', $invoice_id);
                $this->db->update('invoice', $data);

                $data2['method']       =   'paypal';
                $data2['invoice_id']   =   $_POST['custom'];
                $data2['timestamp']    =   strtotime(date("m/d/Y"));
                $data2['payment_type'] =   'income';
                $data2['title']        =   $this->db->get_where('invoice' , array('invoice_id' => $data2['invoice_id']))->row()->title;
                $data2['description']  =   $this->db->get_where('invoice' , array('invoice_id' => $data2['invoice_id']))->row()->description;
                $data2['student_id']   =   $this->db->get_where('invoice' , array('invoice_id' => $data2['invoice_id']))->row()->student_id;
                $data2['amount']       =   $this->db->get_where('invoice' , array('invoice_id' => $data2['invoice_id']))->row()->amount;
                $this->db->insert('payment' , $data2);
            redirect(base_url() . 'student/invoice/', 'refresh');
        }
        $student_profile         = $this->db->get_where('student', array('student_id'   => $this->session->userdata('student_id')))->row();
        $student_id              = $student_profile->student_id;
        $page_data['invoices']   = $this->db->get_where('invoice', array('student_id' => $student_id))->result_array();
        $page_data['page_name']  = 'invoice';
        $page_data['page_title'] = get_phrase('invoice');
        $this->load->view('backend/index', $page_data);
    }
    
    function student_info($student_id  = '', $param1='')
    {
        if ($this->session->userdata('student_login') != 1)
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
        
        $page_data['output']  = $output;
        $page_data['page_name']  = 'student_info';
        $page_data['page_title'] =  get_phrase('student_portal');
        $page_data['student_id'] =  $student_id;
        $this->load->view('backend/index', $page_data);
    }


    function student_update($student_id = '', $param1='')
    {
        if ($this->session->userdata('student_login') != 1)
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
        
        
        $page_data['page_name']  = 'student_update';
        $page_data['output']  = $output;
        $page_data['page_title'] =  get_phrase('student_portal');
        $page_data['student_id'] =  $student_id;
        $this->load->view('backend/index', $page_data);
    }
    
    
    function notifications() 
    {
        if($this->session->userdata('student_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        $page_data['page_name']  =  'notifications';
        $page_data['page_title'] =  get_phrase('your_notifications');
        $this->load->view('backend/index', $page_data);
    }


    function send_report() 
    {
        if ($this->session->userdata('student_login') != 1) 
        {
            redirect(base_url(), 'refresh');
        }

        $page_data['page_name'] = 'send_report';
        $page_data['page_title'] = get_phrase('teacher_report');
        $this->load->view('backend/index', $page_data);
    }

    function noticeboard($param1 = '', $param2 = '') 
    {
        if ($this->session->userdata('student_login') != 1) 
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name'] = 'noticeboard';
        $page_data['page_title'] = get_phrase('news');
        $this->load->view('backend/index', $page_data);
    }

    function message($param1 = 'message_home', $param2 = '', $param3 = '') 
    {
        if ($this->session->userdata('student_login') != 1) 
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
        if ($param1 == 'send_new') 
        {
            $this->session->set_flashdata('flash_message' , get_phrase('message_sent'));
            $message_thread_code = $this->crud_model->send_new_private_message();
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/messages/" . $_FILES["file_name"]["name"]);
            redirect(base_url() . 'student/message/message_read/' . $message_thread_code, 'refresh');
        }
        if ($param1 == 'send_reply') 
        {
            $this->session->set_flashdata('flash_message' , get_phrase('reply_sent'));
            $this->crud_model->send_reply_message($param2);
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/messages/" . $_FILES["file_name"]["name"]);
            redirect(base_url() . 'student/message/message_read/' . $param2, 'refresh');
        }
        if ($param1 == 'message_read') 
        {
            $page_data['current_message_thread_code'] = $param2;
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['infouser'] = $param2;
        $page_data['message_inner_page_name']   = $param1;
        $page_data['page_name']                 = 'message';
        $page_data['page_title']                = get_phrase('private_message');
        $this->load->view('backend/index', $page_data);
    }
    
    function study_material($task = "", $document_id = "")
    {
        if ($this->session->userdata('student_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        }
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if($_GET['id'] != "")
        {
            $notify['status'] = 1;
            $this->db->where('id', $_GET['id']);
            $this->db->update('notification', $notify);
        }
        $data['study_material_info']    = $this->crud_model->select_study_material_info_for_student();
        $data['page_name']              = 'study_material';
        $data['data']              = $task;
        $data['page_title']             = get_phrase('study_material');
        $this->load->view('backend/index', $data);
    }

    function library($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('student_login') != 1) 
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
        if ($param1 == "request")
        {
            $data['book_id']            = $this->input->post('book_id');
            $data['student_id']         = $this->session->userdata('login_user_id');
            $data['issue_start_date']   = strtotime($this->input->post('start'));
            $data['issue_end_date']     = strtotime($this->input->post('end'));
            $this->db->insert('book_request', $data);
            $this->session->set_flashdata('flash_message', get_phrase('successfully_updated'));
            redirect(base_url() . 'student/library/' . $param2, 'refresh');
        }
        $page_data['books']      = $this->db->get('book')->result_array();
        $page_data['page_name']  = 'library';
        $page_data['page_title'] = get_phrase('library');
        $this->load->view('backend/index', $page_data);
    }

    function homeworkroom($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('student_login') != 1) 
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
        $page_data['homework_code'] = $param1;
        $page_data['page_name']   = 'homework_room'; 
        $page_data['page_title']  = get_phrase('homework');
        $this->load->view('backend/index', $page_data);
    }

    function delivery($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('student_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'file')
        {
            $data['homework_code'] = $param2;
            $name = substr(md5(rand(0, 1000000)), 0, 7).$_FILES["file_name"]["name"];
            $data['student_id']    = $this->session->userdata('login_user_id');
            $data['date']          = date('m/d/Y H:i');
            $data['class_id']      = $this->input->post('class_id');
            $data['section_id']    = $this->input->post('section_id');
            $data['file_name']     =  $name;
            $data['student_comment'] = $this->input->post('comment');
            $data['subject_id'] = $this->input->post('subject_id');
            $data['status'] = 1;
            $this->db->insert('deliveries', $data);
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/homework_delivery/" . $name);
            $this->session->set_flashdata('flash_message', get_phrase('successfully_updated'));
            redirect(base_url() . 'student/homeworkroom/' . $param2, 'refresh');
        }
        if($param1 == 'text')
        {
            $data['homework_code'] = $param2;
            $data['student_id']    = $this->session->userdata('login_user_id');
            $data['date']          = date('m/d/Y H:i');
            $data['class_id']      = $this->input->post('class_id');
            $data['section_id']    = $this->input->post('section_id');
            $data['homework_reply'] =  $this->input->post('reply');
            $data['student_comment'] = $this->input->post('comment');
            $data['subject_id'] = $this->input->post('subject_id');
            $data['status'] = 1;
            $this->db->insert('deliveries', $data);
            $this->session->set_flashdata('flash_message', get_phrase('successfully_updated'));
            redirect(base_url() . 'student/homeworkroom/' . $param2, 'refresh');
        }
    }

    function homework_file($param1 = '', $param2 = '', $param3 = '') 
    {
        if ($this->session->userdata('student_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $homework_code = $this->db->get_where('homework', array('homework_id'))->row()->homework_code;
        if ($param1 == 'upload')
        {
            $this->crud_model->upload_homework_file($param2);
            $this->session->set_flashdata('flash_message', get_phrase('successfully_updated'));
            redirect(base_url() . 'student/homeworkroom/file/' . $param2, 'refresh');
        }
        else if ($param1 == 'download')
        {
            $this->crud_model->download_homework_file($param2);
        }
    }

    function forumroom($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('student_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $page_data['post_code'] = $param1;
        $page_data['page_name']   = 'forum_room'; 
        $page_data['page_title']  = get_phrase('forum');
        $this->load->view('backend/index', $page_data);
    }

     function create_report_message($code = '') 
     {
        if ($this->session->userdata('student_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $data['message']      = $this->input->post('message');
        $data['report_code']  = $this->input->post('report_code');
        $data['timestamp']    = date("d M, Y");
        $data['sender_type']    = $this->session->userdata('login_type');
        $data['sender_id']      = $this->session->userdata('login_user_id');
        $this->db->insert('reporte_mensaje', $data);
    }  

    function notification($param1 ='', $param2 = '')
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->db->where('id', $param2);
            $this->db->delete('notification');
            $this->session->set_flashdata('flash_message', get_phrase('successfully_deleted'));
            redirect(base_url() . 'student/panel/', 'refresh');
        }
    }

    function forum_message($param1 = '', $param2 = '', $param3 = '')
     {
        if ($this->session->userdata('student_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'add') 
        {
            $this->crud_model->create_post_message($this->input->post('post_code')); 
            $notify['notify'] = "<strong>".  $this->crud_model->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'))."</strong>". " ". get_phrase('comment_forum') ." <b>".$this->db->get_where('forum', array('post_code' => $this->input->post('post_code')))->row()->title."</b>";
            $for_type = $this->db->get_where('forum', array('post_code' => $this->input->post('post_code')))->row()->type;
            $for_id   = $this->db->get_where('forum', array('post_code' => $this->input->post('post_code')))->row()->teacher_id;
            $notify['user_id'] = $for_id;
            $notify['user_type'] = $for_type;
            $notify['url'] = $for_type."/forumroom/".$this->input->post('post_code')."/";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['original_id'] = $this->session->userdata('login_user_id');
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }
    }

    function forum($param1 = '', $param2 = '', $student_id = '') 
    {
        if ($param1 == 'create') 
        {
            $post_code = $this->crud_model->create_post();
            $this->session->set_flashdata('flash_message', get_phrase('successfully_added'));
            redirect(base_url() . 'student/forumroom/post/' . $post_code , 'refresh');
        }

        $page_data['page_name'] = 'forum';
        $page_data['page_title'] = get_phrase('forum');
        $page_data['data']   = $param1;
        $this->load->view('backend/index', $page_data);
    }
    
    
    function files($task = "", $code = "")
    {
        if ($this->session->userdata('student_login') != 1)
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
                $data = file_get_contents("uploads/users/student/". $user_folder."/".$folder_name.'/'.$file_name);
            }else{
                $data = file_get_contents("uploads/users/student/". $user_folder.'/'.$file_name);
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
                $data['user_type'] = 'student';
                $data['token'] = base64_encode($data['name']);
                $data['date'] = date('d M, Y H:iA');
                $this->db->insert('folder', $data);
                mkdir('uploads/users/'.$this->session->userdata('login_type').'/'.$folder.'/'.$data['name'], 0777, true);
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_uploaded'));
                redirect(base_url() . 'student/folders/', 'refresh');
            }else{
                $this->session->set_flashdata('flash_message' ,get_phrase('folder_already_exist'));
                redirect(base_url() . 'student/files/', 'refresh');
            }
        }
        if ($task == 'delete')
        {
            $user_folder = md5($this->session->userdata('login_user_id'));
            
            $file_name = $this->db->get_where('file', array('file_id' => $code))->row()->name;
            $folder = $this->db->get_where('file', array('file_id' => $code))->row()->folder_token;
            $folder_name = $this->db->get_where('folder', array('token' => $folder))->row()->name;
            if($folder != ""){
                unlink("uploads/users/student/". $user_folder."/".$folder_name.'/'.$file_name);
            }else{
                unlink("uploads/users/student/". $user_folder.'/'.$file_name);
            }
            $this->db->where('file_id',$code);
            $this->db->delete('file');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'student/all/');
        }

        $data['page_name']              = 'files';
        $data['page_title']             = get_phrase('my_files');
        $this->load->view('backend/index', $data);
    }
    
    function folders($task = '', $param2 = '')
    {
      if ($this->session->userdata('student_login') != 1)
      {
        redirect(base_url(), 'refresh');
      }
      if($task == 'update')
      {
        $user_folder = md5($this->session->userdata('login_user_id'));
        $old_folder = $this->db->get_where('folder', array('folder_id' => $param2))->row()->name;
        rename('uploads/users/student/'.$user_folder.'/'.$old_folder,'uploads/users/student/'.$user_folder.'/'.$this->input->post('name'));
        
        $data['name'] = $this->input->post('name');
        $data['token'] = base64_encode($this->input->post('name'));
        $this->db->where('folder_id', $param2);
        $this->db->update('folder', $data);
        $this->session->set_flashdata('flash_message' ,get_phrase('successfully_updated'));
        redirect(base_url() . 'student/folders/', 'refresh');
      }
      if($task == 'delete')
      {
        $user_folder = md5($this->session->userdata('login_user_id'));
        $folder = $this->db->get_where('folder', array('folder_id' => $param2))->row()->name;
        $this->deleteDir('uploads/users/student/'.$user_folder.'/'.$folder);
        $this->db->where('folder_id', $param2);
        $this->db->delete('folder');
        $this->session->set_flashdata('flash_message' ,get_phrase('successfully_deleted'));
        redirect(base_url() . 'student/folders/', 'refresh');
      }
      $page_data['page_title']             = get_phrase('folders');
      $page_data['token']   = $task;
      $page_data['page_name']   = 'folders';
      $this->load->view('backend/index', $page_data);
    }
    
    function upload_file($param1 = '', $param2 = '')
    {
        $page_data['token']  = $param1;
        $page_data['page_name']  = 'upload_file';
        $page_data['page_title'] = get_phrase('upload_file');
        $this->load->view('backend/index', $page_data);
    }
    
    function request($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('student_login') != 1)
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
        if ($param1 == "create")
        {
            $data['student_id']   = $this->session->userdata('login_user_id');
            $data['description']  = $this->input->post('description');
            $data['parent_id']    = $this->db->get_where('student', array('student_id' => $this->session->userdata('login_user_id')))->row()->parent_id;
            $data['title']        = $this->input->post('title');
            $data['start_date']   = $this->input->post('start_date');
            $data['end_date']     = $this->input->post('end_date');
            $data['status']     = 0;
            $this->db->insert('students_request', $data);

            $notify['notify'] = "<strong>". $this->crud_model->get_name('student', $this->session->userdata('login_user_id'))."</strong>". " ". get_phrase('absence_request');
            $admins = $this->db->get('admin')->result_array();
            foreach($admins as $row)
            {
                $notify['user_id'] = $row['admin_id'];
                $notify['user_type'] = "admin";
                $notify['url'] = "admin/request";
                $notify['date'] = date('d M, Y');
                $notify['time'] = date('h:i A');
                $notify['status'] = 0;
                $notify['original_id'] = $this->session->userdata('login_user_id');
                $notify['original_type'] = $this->session->userdata('login_type');
                $this->db->insert('notification', $notify);
            }
            redirect(base_url() . 'student/request/', 'refresh');
        }
        $data['page_name']  = 'request';
        $data['page_title'] = get_phrase('permissions');
        $this->load->view('backend/index', $data);
    }
    
    function recent()
    {
        if($this->session->userdata('student_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        
        $page_data['page_name']  =  'recent';
        $page_data['page_title'] =  get_phrase('recents');
        $this->load->view('backend/index', $page_data);
    }
    
    function all($class_id = '', $section_id = '')
    {
      if ($this->session->userdata('student_login') != 1)
      {
        redirect(base_url(), 'refresh');
      }
      $page_data['page_name']   = 'all';
      $page_data['page_title']  = get_phrase('all_files');
      $this->load->view('backend/index', $page_data);
    }
    
    function deleteDir($path) {
        return is_file($path) ? @unlink($path) :
        array_map(__FUNCTION__, glob($path.'/*')) == @rmdir($path);
    }
    
}