<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crud_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
    }

    function clear_cache() 
    {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
    
    function update_panel_news($param2)
    {
        $data['description']         = $this->input->post('description');
        $data['date2']               = date('H:i A');
        $this->db->where('news_code', $param2);
        $this->db->update('news', $data);            
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/news_images/' . $param2 . '.jpg');
    }
    
    function delete_news($param2)
    {
        unlink('uploads/news_images/'.$param2. ".jpg");
        $id = $this->db->get_where('news', array('news_code' => $param2))->row()->news_id;
        $this->db->where('news_code' , $param2);
        $this->db->delete('news');
    }
    
    function send_news_notify()
    {
        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $notify['notify'] = get_phrase('new_notice_info');
        $parents = $this->db->get('parent')->result_array();
        $students = $this->db->get('student')->result_array();
        $teachers = $this->db->get('teacher')->result_array();
        $accountant = $this->db->get('accountant')->result_array();
        $librarian = $this->db->get('librarian')->result_array();
        foreach($students as $row1)
        {
            $notify['user_id'] = $row1['student_id'];
            $notify['user_type'] = "student";
            $notify['url'] = "student/panel";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['type'] = 'news';
            $notify['year'] = $year;
            $notify['original_id'] = 0;
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }
        foreach($parents as $row2)
        {
            $notify['user_id'] = $row2['parent_id'];
            $notify['user_type'] = "parent";
            $notify['url'] = "parents/panel";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['type'] = 'news';
            $notify['original_id'] = 0;
            $notify['year'] = $year;
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }
        foreach($teachers as $row3)
        {
            $notify['user_id'] = $row3['teacher_id'];
            $notify['user_type'] = "teacher";
            $notify['url'] = "teacher/panel";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['type'] = 'news';
            $notify['original_id'] = 0;
            $notify['year'] = $year;
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }
        foreach($accountant as $row4)
        {
            $notify['user_id'] = $row4['accountant_id'];
            $notify['user_type'] = "accountant";
            $notify['url'] = "accountant/panel";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['type'] = 'news';
            $notify['year'] = $year;
            $notify['original_id'] = 0;
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }
        foreach($librarian as $row5)
        {
            $notify['user_id'] = $row5['librarian_id'];
            $notify['user_type'] = "librarian";
            $notify['url'] = "librarian/panel";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['year'] = $year;
            $notify['type'] = 'news';
            $notify['original_id'] = 0;
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }    
    }
    
    function send_polls_notify()
    {
        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $notify['notify'] = get_phrase('new_poll_notify');
        $parents = $this->db->get('parent')->result_array();
        $students = $this->db->get('student')->result_array();
        $teachers = $this->db->get('teacher')->result_array();
        $accountant = $this->db->get('accountant')->result_array();
        $librarian = $this->db->get('librarian')->result_array();
        foreach($students as $row1)
        {
            $notify['user_id'] = $row1['student_id'];
            $notify['user_type'] = "student";
            $notify['url'] = "student/panel";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['type'] = 'news';
            $notify['year'] = $year;
            $notify['original_id'] = 0;
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }
        foreach($parents as $row2)
        {
            $notify['user_id'] = $row2['parent_id'];
            $notify['user_type'] = "parent";
            $notify['url'] = "parents/panel";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['type'] = 'news';
            $notify['original_id'] = 0;
            $notify['year'] = $year;
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }
        foreach($teachers as $row3)
        {
            $notify['user_id'] = $row3['teacher_id'];
            $notify['user_type'] = "teacher";
            $notify['url'] = "teacher/panel";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['type'] = 'news';
            $notify['original_id'] = 0;
            $notify['year'] = $year;
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }
        foreach($accountant as $row4)
        {
            $notify['user_id'] = $row4['accountant_id'];
            $notify['user_type'] = "accountant";
            $notify['url'] = "accountant/panel";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['type'] = 'news';
            $notify['year'] = $year;
            $notify['original_id'] = 0;
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }
        foreach($librarian as $row5)
        {
            $notify['user_id'] = $row5['librarian_id'];
            $notify['user_type'] = "librarian";
            $notify['url'] = "librarian/panel";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['year'] = $year;
            $notify['type'] = 'news';
            $notify['original_id'] = 0;
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }    
    }
    
    function send_calendar_notify()
    {
        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $notify['notify'] = get_phrase('new_event_notify');
        $parents = $this->db->get('parent')->result_array();
        $students = $this->db->get('student')->result_array();
        $teachers = $this->db->get('teacher')->result_array();
        $accountant = $this->db->get('accountant')->result_array();
        $librarian = $this->db->get('librarian')->result_array();
        foreach($students as $row1)
        {
            $notify['user_id'] = $row1['student_id'];
            $notify['user_type'] = "student";
            $notify['url'] = "student/calendar";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['type'] = 'news';
            $notify['year'] = $year;
            $notify['original_id'] = 0;
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }
        foreach($parents as $row2)
        {
            $notify['user_id'] = $row2['parent_id'];
            $notify['user_type'] = "parent";
            $notify['url'] = "parents/calendar";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['type'] = 'news';
            $notify['original_id'] = 0;
            $notify['year'] = $year;
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }
        foreach($teachers as $row3)
        {
            $notify['user_id'] = $row3['teacher_id'];
            $notify['user_type'] = "teacher";
            $notify['url'] = "teacher/calendar";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['type'] = 'news';
            $notify['original_id'] = 0;
            $notify['year'] = $year;
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }
        foreach($accountant as $row4)
        {
            $notify['user_id'] = $row4['accountant_id'];
            $notify['user_type'] = "accountant";
            $notify['url'] = "accountant/calendar";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['type'] = 'news';
            $notify['year'] = $year;
            $notify['original_id'] = 0;
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }
        foreach($librarian as $row5)
        {
            $notify['user_id'] = $row5['librarian_id'];
            $notify['user_type'] = "librarian";
            $notify['url'] = "librarian/calendar";
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['year'] = $year;
            $notify['type'] = 'news';
            $notify['original_id'] = 0;
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }    
    }
    
    function get_correct_answer($question_bank_id = "")
    {
        $question_details = $this->db->get_where('question_bank', array('question_bank_id' => $question_bank_id))->row_array();
        return $question_details['correct_answers'];
    }
    
     function calculate_exam_mark($online_exam_id) {

        $checker = array(
            'online_exam_id' => $online_exam_id,
            'student_id' => $this->session->userdata('login_user_id')
        );
        $obtained_marks = 0;
        $online_exam_result = $this->db->get_where('online_exam_result', $checker);
        if ($online_exam_result->num_rows() == 0) {
            $data['obtained_mark'] = 0;
        }
        else{
            $results = $online_exam_result->row_array();
            $answer_script = json_decode($results['answer_script'], true);
            foreach ($answer_script as $row) {
                if ($row['submitted_answer'] == $row['correct_answers']) {
                    $obtained_marks = $obtained_marks + $this->get_question_details_by_id($row['question_bank_id'], 'mark');
                }
            }
            $data['obtained_mark'] = $obtained_marks;
        }
        $total_mark = $this->get_total_mark($online_exam_id);
        $query = $this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id))->row_array();
        $minimum_percentage = $query['minimum_percentage'];
        $minumum_required_marks = ($total_mark * $minimum_percentage) / 100;
        if ($minumum_required_marks > $obtained_marks) {
            $data['result'] = 'fail';
        }
        else {
            $data['result'] = 'pass';
        }
        $this->db->where($checker);
        $this->db->update('online_exam_result', $data);
    }
    
     function get_question_details_by_id($question_bank_id, $column_name = "") 
     {
        return $this->db->get_where('question_bank', array('question_bank_id' => $question_bank_id))->row()->$column_name;
    }

    function submit_online_exam($online_exam_id = "", $answer_script = ""){
        $checker = array(
            'online_exam_id' => $online_exam_id,
            'student_id' => $this->session->userdata('login_user_id')
        );
        $updated_array = array(
            'status' => 'submitted',
            'answer_script' => $answer_script
        );
        $this->db->where($checker);
        $this->db->update('online_exam_result', $updated_array);
        $this->calculate_exam_mark($online_exam_id);
    }
    
    function change_online_exam_status_to_attended_for_student($online_exam_id = "")
    {
        $checker = array(
            'online_exam_id' => $online_exam_id,
            'student_id' => $this->session->userdata('login_user_id')
        );
        if($this->db->get_where('online_exam_result', $checker)->num_rows() == 0)
        {
            $inserted_array = array(
                'status' => 'attended',
                'online_exam_id' => $online_exam_id,
                'student_id' => $this->session->userdata('login_user_id'),
                'exam_started_timestamp' => strtotime("now")
            );
            $this->db->insert('online_exam_result', $inserted_array);
        }
    }
    
    function check_availability_for_student($online_exam_id)
    {
        $result = $this->db->get_where('online_exam_result', array('online_exam_id' => $online_exam_id, 'student_id' => $this->session->userdata('login_user_id')))->row_array();
        return $result['status'];
    }
    
    function parent_check_availability_for_student($online_exam_id, $student_id)
    {
        $result = $this->db->get_where('online_exam_result', array('online_exam_id' => $online_exam_id, 'student_id' => $student_id))->row_array();
        return $result['status'];
    }
    
    function available_exams($student_id,$subject_id) 
    {
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $class_id = $this->db->get_where('enroll', array('student_id' => $student_id))->row()->class_id;
        $section_id = $this->db->get_where('enroll', array('student_id' => $student_id))->row()->section_id;
        $match = array('running_year' => $running_year, 'class_id' => $class_id, 'section_id' => $section_id,'subject_id' => $subject_id, 'status' => 'published');
        $this->db->order_by("online_exam_id", "dsc");
        $exams = $this->db->where($match)->get('online_exam')->result_array();
        return $exams;
    }
    
    function parent_available_exams($class_id,$section_id,$subject_id) 
    {
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $match = array('running_year' => $running_year, 'class_id' => $class_id, 'section_id' => $section_id,'subject_id' => $subject_id, 'status' => 'published');
        $this->db->order_by("online_exam_id", "dsc");
        $exams = $this->db->where($match)->get('online_exam')->result_array();
        return $exams;
    }
    
    function folderSize($dir)
    {
        $count_size = 0;
        $count = 0;
        $dir_array = scandir($dir);
        foreach($dir_array as $key=>$filename){
            if($filename!=".." && $filename!="."){
                if(is_dir($dir."/".$filename)){
                    $new_foldersize = foldersize($dir."/".$filename);
                    $count_size = $count_size+ $new_foldersize;
                }else if(is_file($dir."/".$filename)){
                    $count_size = $count_size + filesize($dir."/".$filename);
                    $count++;
                }
           }
        }
        return $count_size;
    }
    
    function get_birthdays()
    {
        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $array_users = array();
        $query_admins = $this->db->query("SELECT admin_id, first_name, last_name FROM admin WHERE substring_index(birthday, '/', 1) = ".date('m')."")->result_array();
        foreach($query_admins as $row)
        {
            $birthDate = $row['birthday'];
            $array_admins= array('name' => $row['first_name'],'user_id' => $row['admin_id'], 'type' => 'admin');
            array_push($array_users,$array_admins);
        }
        $query_teachers = $this->db->query("SELECT teacher_id, first_name, last_name FROM teacher WHERE substring_index(birthday, '/', 1) = ".date('m')."")->result_array();
        foreach($query_teachers as $row2)
        {
            $birthDate = $row2['birthday'];
            $time = strtotime($birthDate);
            $array_teachers = array('name' => $row2['first_name'],'user_id' => $row2['teacher_id'], 'type' => 'teacher');
            array_push($array_users,$array_teachers);
        }
        $query_accountant = $this->db->query("SELECT accountant_id, first_name, last_name FROM accountant WHERE substring_index(birthday, '/', 1) = ".date('m')."")->result_array();
        foreach($query_accountant as $row3)
        {
            $birthDate = $row3['birthday'];
            $time = strtotime($birthDate);
            $array_accountant = array('name' => $row3['first_name'],'user_id' => $row3['accountant_id'], 'type' => 'accountant');
            array_push($array_users,$array_accountant);
        }
        $query_librarian = $this->db->query("SELECT librarian_id, first_name, last_name FROM librarian WHERE substring_index(birthday, '/', 1) = ".date('m')."")->result_array();
        foreach($query_librarian as $row4)
        {
            $birthDate = $row4['birthday'];
            $time = strtotime($birthDate);
            $array_librarian = array('name' => $row4['first_name'],'user_id' => $row4['librarian_id'], 'type' => 'librarian');
            array_push($array_users,$array_librarian);
        }
        $query_student = $this->db->query("SELECT student_id FROM student WHERE substring_index(birthday, '/', 1) = ".date('m')."")->result_array();
        foreach($query_student as $row5)
        {
            $birthDate = $row5['birthday'];
            $time = strtotime($birthDate);
            $array_stduent = array('name' => $this->crud_model->get_name('student', $row5['student_id']),'user_id' => $row5['student_id'], 'type' => 'student');
            array_push($array_users,$array_stduent);
        }
        return $array_users;
    }
    
    
    function get_birthdays_by_month($month)
    {
        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $array_users = array();
        $query_admins = $this->db->query("SELECT admin_id, first_name, last_name, birthday FROM admin WHERE substring_index(birthday, '/', 1) = ".$month."")->result_array();
        foreach($query_admins as $row)
        {
            $birthDate = $row['birthday'];
            $array_admins= array('name' => $row['first_name'],'user_id' => $row['admin_id'],'birthday' => $row['birthday'], 'type' => 'admin');
            array_push($array_users,$array_admins);
        }
        $query_teachers = $this->db->query("SELECT teacher_id, first_name, last_name, birthday FROM teacher WHERE substring_index(birthday, '/', 1) = ".$month."")->result_array();
        foreach($query_teachers as $row2)
        {
            $birthDate = $row2['birthday'];
            $time = strtotime($birthDate);
            $array_teachers = array('name' => $row2['first_name'],'user_id' => $row2['teacher_id'],'birthday' => $row2['birthday'], 'type' => 'teacher');
            array_push($array_users,$array_teachers);
        }
        $query_accountant = $this->db->query("SELECT accountant_id, first_name, last_name, birthday FROM accountant WHERE substring_index(birthday, '/', 1) = ".$month."")->result_array();
        foreach($query_accountant as $row3)
        {
            $birthDate = $row3['birthday'];
            $time = strtotime($birthDate);
            $array_accountant = array('name' => $row3['first_name'],'user_id' => $row3['accountant_id'],'birthday' => $row3['birthday'], 'type' => 'accountant');
            array_push($array_users,$array_accountant);
        }
        $query_librarian = $this->db->query("SELECT librarian_id, first_name, last_name, birthday FROM librarian WHERE substring_index(birthday, '/', 1) = ".$month."")->result_array();
        foreach($query_librarian as $row4)
        {
            $birthDate = $row4['birthday'];
            $time = strtotime($birthDate);
            $array_librarian = array('name' => $row4['first_name'], 'user_id' => $row4['librarian_id'],'birthday' => $row4['birthday'], 'type' => 'librarian');
            array_push($array_users,$array_librarian);
        }
        $query_student = $this->db->query("SELECT student_id, birthday FROM student WHERE substring_index(birthday, '/', 1) = ".$month."")->result_array();
        foreach($query_student as $row5)
        {
            $birthDate = $row5['birthday'];
            $time = strtotime($birthDate);
            $array_stduent = array('name' => $this->crud_model->get_name('student', $row5['student_id']), 'birthday' => $row5['birthday'], 'user_id' => $row5['student_id'], 'type' => 'student');
            array_push($array_users,$array_stduent);
        }
        return $array_users;
    }

    function add_multiple_choice_question_to_online_exam($online_exam_id){
        if (sizeof($this->input->post('options')) != $this->input->post('number_of_options')) {
            $this->session->set_flashdata('error_message' , get_phrase('no_options_can_be_blank'));
            return;
        }
        foreach ($this->input->post('options') as $option) {
            if ($option == "") {
                $this->session->set_flashdata('error_message' , get_phrase('no_options_can_be_blank'));
                return;
            }
        }
        if (sizeof($this->input->post('correct_answers')) == 0) {
            $correct_answers = [""];
        }
        else{
            $correct_answers = $this->input->post('correct_answers');
        }
        $data['online_exam_id']     = $online_exam_id;
        $data['question_title']     = html_escape($this->input->post('question_title'));
        $data['mark']               = html_escape($this->input->post('mark'));
        $data['number_of_options']  = html_escape($this->input->post('number_of_options'));
        $data['type']               = 'multiple_choice';
        $data['options']            = json_encode($this->input->post('options'));
        $data['correct_answers']    = json_encode($correct_answers);
        $this->db->insert('question_bank', $data);
        $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
    }

    function add_true_false_question_to_online_exam($online_exam_id){
        $data['online_exam_id']     = $online_exam_id;
        $data['question_title']     = html_escape($this->input->post('question_title'));
        $data['type']               = 'true_false';
        $data['mark']               = html_escape($this->input->post('mark'));
        $data['correct_answers']    = html_escape($this->input->post('true_false_answer'));
        $this->db->insert('question_bank', $data);
        $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
    }

    function add_fill_in_the_blanks_question_to_online_exam($online_exam_id){
        $suitable_words_array = explode(',', html_escape($this->input->post('suitable_words')));
        $suitable_words = array();
        foreach ($suitable_words_array as $row) {
          array_push($suitable_words, strtolower($row));
        }
        $data['online_exam_id']     = $online_exam_id;
        $data['question_title']     = html_escape($this->input->post('question_title'));
        $data['type']               = 'fill_in_the_blanks';
        $data['mark']               = html_escape($this->input->post('mark'));
        $data['correct_answers']    = json_encode(array_map('trim',$suitable_words));
        $this->db->insert('question_bank', $data);
        $this->session->set_flashdata('flash_message' ,get_phrase('successfully_added'));
    }

    function update_true_false_question($question_id){
        $data['question_title']     = html_escape($this->input->post('question_title'));
        $data['mark']               = html_escape($this->input->post('mark'));
        $data['correct_answers']    = html_escape($this->input->post('true_false_answer'));
        $this->db->where('question_bank_id', $question_id);
        $this->db->update('question_bank', $data);
        $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
    }
    
    function get_total_mark($online_exam_id){
        $added_question_info = $this->db->get_where('question_bank', array('online_exam_id' => $online_exam_id))->result_array();
        $total_mark = 0;
        if (sizeof($added_question_info) > 0){
            foreach ($added_question_info as $single_question) {
                $total_mark = $total_mark + $single_question['mark'];
            }
        }
        return $total_mark;
    }
    
     function update_fill_in_the_blanks_question($question_id){
        $suitable_words_array = explode(',', html_escape($this->input->post('suitable_words')));
        $suitable_words = array();
        foreach ($suitable_words_array as $row) {
          array_push($suitable_words, strtolower($row));
        }
        $data['question_title']     = html_escape($this->input->post('question_title'));
        $data['mark']               = html_escape($this->input->post('mark'));
        $data['correct_answers']    = json_encode(array_map('trim',$suitable_words));

        $this->db->where('question_bank_id', $question_id);
        $this->db->update('question_bank', $data);
        $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
    }

    function delete_question_from_online_exam($question_id){
        $this->db->where('question_bank_id', $question_id);
        $this->db->delete('question_bank');
    }
    
    function update_multiple_choice_question($question_id){
        if (sizeof($this->input->post('options')) != $this->input->post('number_of_options')) {
            $this->session->set_flashdata('error_message' , get_phrase('no_options_can_be_blank'));
            return;
        }
        foreach ($this->input->post('options') as $option) {
            if ($option == "") {
                $this->session->set_flashdata('error_message' , get_phrase('no_options_can_be_blank'));
                return;
            }
        }
        if (sizeof($this->input->post('correct_answers')) == 0) {
            $correct_answers = [""];
        }
        else{
            $correct_answers = $this->input->post('correct_answers');
        }
        $data['question_title']     = html_escape($this->input->post('question_title'));
        $data['mark']               = html_escape($this->input->post('mark'));
        $data['number_of_options']  = html_escape($this->input->post('number_of_options'));
        $data['options']            = json_encode($this->input->post('options'));
        $data['correct_answers']    = json_encode($correct_answers);
        $this->db->where('question_bank_id', $question_id);
        $this->db->update('question_bank', $data);
        $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
    }

    function manage_online_exam_status($online_exam_id = "", $status = ""){
        $checker = array(
            'online_exam_id' => $online_exam_id
        );
        $updater = array(
            'status' => $status
        );

        $this->db->where($checker);
        $this->db->update('online_exam', $updater);
        $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
    }

    public function checkUser($userData = array())
    {
      $credential = array('g_oauth' => $userData['oauth_uid']);
      $query = $this->db->get_where('admin', $credential);
   
      if ($query->num_rows() > 0) 
      {
        return 'success';
      }
      $query = $this->db->get_where('teacher', $credential);
      if ($query->num_rows() > 0) 
      {
        return 'success';
      }
      $query = $this->db->get_where('student', $credential);
      if ($query->num_rows() > 0) 
      {
        return 'success';
      }
      $query = $this->db->get_where('parent', $credential);
      if ($query->num_rows() > 0) 
      {
        return 'success';                  
      }
      $query = $this->db->get_where('accountant', $credential);
      if ($query->num_rows() > 0) 
      {
        return 'success';                  
      }
      $query = $this->db->get_where('librarian', $credential);
      if ($query->num_rows() > 0) 
      {
        return 'success';                  
      }
    }

    public function checkusername($username)
    {
      $credential = array('username' => $username);
      $query = $this->db->get_where('admin', $credential);
      if ($query->num_rows() > 0) 
      {
        return 'success';
      }
      $query = $this->db->get_where('teacher', $credential);
      if ($query->num_rows() > 0) 
      {
        return 'success';
      }
      $query = $this->db->get_where('student', $credential);
      if ($query->num_rows() > 0) 
      {
        return 'success';
      }
      $query = $this->db->get_where('parent', $credential);
      if ($query->num_rows() > 0) 
      {
        return 'success';                  
      } 
      $query = $this->db->get_where('accountant', $credential);
      if ($query->num_rows() > 0) 
      {
        return 'success';                  
      } 
      $query = $this->db->get_where('librarian', $credential);
      if ($query->num_rows() > 0) 
      {
        return 'success';                  
      } 
    }

    public function checkUser2($userID)
    {
      $credential = array('fb_id' => $userID);
      $query = $this->db->get_where('admin', $credential);
   
      if ($query->num_rows() > 0) 
      {
        return 'success';
      }
      $query = $this->db->get_where('teacher', $credential);
      if ($query->num_rows() > 0) 
      {
        return 'success';
      }
      $query = $this->db->get_where('student', $credential);
      if ($query->num_rows() > 0) 
      {
        return 'success';
      }
      $query = $this->db->get_where('parent', $credential);
      if ($query->num_rows() > 0) 
      {
        return 'success';                  
      } 
      $query = $this->db->get_where('accountant', $credential);
      if ($query->num_rows() > 0) 
      {
        return 'success';                  
      } 
      $query = $this->db->get_where('librarian', $credential);
      if ($query->num_rows() > 0) 
      {
        return 'success';                  
      } 
    }

    function get_type_name_by_id($type, $type_id = '', $field = 'name') {
        return $this->db->get_where($type, array($type . '_id' => $type_id))->row()->$field;
    }

     function delete_cache($uri_string=null)
     {
        $CI =& get_instance();
        $path = $CI->config->item('cache_path');
        $path = rtrim($path, DIRECTORY_SEPARATOR);
        $cache_path = ($path == '') ? APPPATH.'cache/' : $path;
        $uri =  $CI->config->item('base_url').
        $CI->config->item('index_page').
        $uri_string;
        $cache_path .= md5($uri);
        return unlink($cache_path);
    }

    function count_attendance_students($status)
    {
        $timestamp   = strtotime(date('d-m-Y'));
        $this->db->where('timestamp', $timestamp);
        $this->db->where('status', $status);
        $this->db->from('attendance');
        $result = $this->db->count_all_results();
        return $result;
    }

    function clickatell($message = '' , $reciever = '') 
    {
        $clickatell_user       = $this->db->get_where('settings', array('type' => 'clickatell_username'))->row()->description;
        $clickatell_password   = $this->db->get_where('settings', array('type' => 'clickatell_password'))->row()->description;
        $clickatell_api_id     = $this->db->get_where('settings', array('type' => 'clickatell_api'))->row()->description;
        $clickatell_baseurl    = "http://api.clickatell.com";
        $text   = urlencode($message);
        $to     = $reciever_phone;
        $url = "$clickatell_baseurl/http/auth?user=$clickatell_user&password=$clickatell_password&api_id=$clickatell_api_id";
        $ret = file($url);
        $sess = explode(":",$ret[0]);
        print_r($sess);echo '<br>';
        if ($sess[0] == "OK") 
        {
            $sess_id = trim($sess[1]);
            $url = "$clickatell_baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text";
            $ret = file($url);
            $send = explode(":",$ret[0]);
            print_r($send);echo '<br>';
            if ($send[0] == "ID") {
                echo "successnmessage ID: ". $send[1];
            } else {
                echo "Failed";
            }
        } else {
            echo "Authentication fail: ". $ret[0];
        }
    }

    function twilio($message = "", $reciever = "") 
    {
        require_once(APPPATH . 'libraries/twilio_library/Twilio.php');
        $account_sid    = $this->db->get_where('settings', array('type' => 'twilio_account_sid'))->row()->description;
        $auth_token     = $this->db->get_where('settings', array('type' => 'twilio_auth_token'))->row()->description;
        $client         = new Services_Twilio($account_sid, $auth_token);
        $client->account->messages->create(array(
            'To'        => $reciever_phone,
            'From'      => $this->db->get_where('settings', array('type' => 'twilio_sender_phone_number'))->row()->description,
            'Body'      => $message
        ));
    }

    function tz_list() 
    {
        $zones_array = array();
        $timestamp = time();
        foreach(timezone_identifiers_list() as $key => $zone) 
        {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }
        return $zones_array;
    }

    function students_reports($student_name,$parent_email)
    {
        $parent_id = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->parent_id;
        $st_name = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->name;
        $p_name = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->name;
       $email_sub  = $this->db->get_where('email_template' , array('task' => 'student_reports'))->row()->subject;
       $email_msg  = $this->db->get_where('email_template' , array('task' => 'student_reports'))->row()->body;
       $STUDENT_NAME    =   $st_name;
       $PARENT_NAME =   $this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->name;
       $email_msg   =   str_replace('[PARENT]' , $PARENT_NAME, $email_msg);
       $email_msg   =   str_replace('[STUDENT]' , $STUDENT_NAME , $email_msg);
       $email_to    =   $this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->email;
       
        require("class.phpmailer.php");
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        
        $mail->SetFrom($this->db->get_where('settings', array('type' => 'system_email'))->row()->description, $this->db->get_where('settings', array('type' => 'system_name'))->row()->description);
        $mail->Subject = $email_sub;
        $email_data = array(
            'email_msg' => $email_msg
        );
        $mail->Body = $this->load->view('backend/mails/notify.php',$email_data,TRUE);
        $mail->AddAddress($email_to);   
        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }
    
   function send_homework_notify()
    {
        $subj = $this->db->get_where('subject', array('subject_id' => $this->input->post('subject_id')))->row()->name;
        $email_sub  = $this->db->get_where('email_template' , array('task' => 'new_homework'))->row()->subject;
        $email_msg   = $this->db->get_where('email_template' , array('task' => 'new_homework'))->row()->body;
        $email_msg  =  str_replace('[DESCRIPTION]' , $this->input->post('description'), $email_msg);
        $email_msg  =  str_replace('[TITLE]' , $this->input->post('title'), $email_msg);
        $email_msg  =  str_replace('[SUBJECT]' , $subj, $email_msg);

        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        require("class.phpmailer.php");
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        $st = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id'), 'section_id' => $this->input->post('section_id'), 'year' => $year))->result_array();
        foreach($st as $r)
        {
            $mail->SetFrom($this->db->get_where('settings', array('type' => 'system_email'))->row()->description, $this->db->get_where('settings', array('type' => 'system_name'))->row()->description);
            $mail->Subject = $email_sub;
            $email_data = array(
                'email_msg' => $email_msg
            );
            $mail->Body = $this->load->view('backend/mails/notify.php',$email_data,TRUE);
            $mail->AddAddress($this->db->get_where('student' , array('student_id' => $r['student_id']))->row()->email);   
        }
        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }
    
    function send_sms_via_msg91($message = '' , $reciever_phone = '') {

        $authKey       = $this->db->get_where('settings', array('type' => 'msg91_key'))->row()->description;
        $senderId      = $this->db->get_where('settings', array('type' => 'msg91_sender'))->row()->description;
        $country_code  = $this->db->get_where('settings', array('type' => 'msg91_code'))->row()->description;
        $route         = $this->db->get_where('settings', array('type' => 'msg91_route'))->row()->description;
        $mobileNumber = $reciever_phone;
        $message = urlencode($message);
        $postData = array(
            'authkey' => $authKey,
            'mobiles' => $mobileNumber,
            'message' => $message,
            'sender' => $senderId,
            'route' => $route,
            'country' => $country_code
        );
        $url="http://api.msg91.com/api/sendhttp.php";
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }
        curl_close($ch);
    }

    function parent_new_invoice($student_name,$parent_email)
    {
        $email_sub  = $this->db->get_where('email_template' , array('task' => 'parent_new_invoice'))->row()->subject;
        $email_msg  = $this->db->get_where('email_template' , array('task' => 'parent_new_invoice'))->row()->body;
        $STUDENT_NAME    =   $student_name;
        $PARENT_NAME =   $this->db->get_where('parent' , array('email' => $parent_email))->row()->name;
        $email_msg   =   str_replace('[PARENT]' , $PARENT_NAME, $email_msg);
        $email_msg   =   str_replace('[STUDENT]' , $STUDENT_NAME , $email_msg);
        $email_to    =   $parent_email;
        require("class.phpmailer.php");
        $data = array(
            'email_msg' => $email_msg
        );
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        $mail->SetFrom($this->db->get_where('settings', array('type' => 'system_email'))->row()->description, $this->db->get_where('settings', array('type' => 'system_name'))->row()->description);
        $mail->Subject = $email_sub;
        $mail->Body = $this->load->view('backend/mails/notify.php',$data,TRUE);
        $mail->AddAddress($email_to);
        if(!$mail->Send()) 
        {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }

     function student_new_invoice($student_name,$student_email)
    {
        $email_sub  = $this->db->get_where('email_template' , array('task' => 'student_new_invoice'))->row()->subject;
        $email_msg  = $this->db->get_where('email_template' , array('task' => 'student_new_invoice'))->row()->body;
        $STUDENT_NAME    =   $student_name;
        $email_msg   =   str_replace('[STUDENT]' , $STUDENT_NAME , $email_msg);
        $email_to    =   $student_email;
        $data = array(
            'email_msg' => $email_msg
        );
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        $mail->SetFrom($this->db->get_where('settings', array('type' => 'system_email'))->row()->description, $this->db->get_where('settings', array('type' => 'system_name'))->row()->description);
        $mail->Subject = $email_sub;
        $mail->Body = $this->load->view('backend/mails/notify.php',$data,TRUE);
        $mail->AddAddress($email_to);
        if(!$mail->Send()) 
        {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }

    function attendance($student_id,$parent_id)
    {
        $email_sub  = $this->db->get_where('email_template' , array('task' => 'student_absences'))->row()->subject;
        $email_msg  = $this->db->get_where('email_template' , array('task' => 'student_absences'))->row()->body;
        $STUDENT_NAME   =   $this->get_name('student', $student_id);
        $PARENT_NAME    =   $this->get_name('parent', $parent_id);
        $email_msg  =   str_replace('[PARENT]' , $PARENT_NAME, $email_msg);
        $email_msg  =   str_replace('[STUDENT]' , $STUDENT_NAME , $email_msg);
        $email_to   =   $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->email;
        require("class.phpmailer.php");
        $data = array(
            'email_msg' => $email_msg
        );
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        $mail->SetFrom($this->db->get_where('settings', array('type' => 'system_email'))->row()->description, $this->db->get_where('settings', array('type' => 'system_name'))->row()->description);
        $mail->Subject = $email_sub;
        $mail->Body = $this->load->view('backend/mails/notify.php',$data,TRUE);
        $mail->AddAddress($email_to);
        if(!$mail->Send()) 
        {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }

     function count_attendance_teacher($status)
    {
        $timestamp   = strtotime(date('d-m-Y'));
        $this->db->where('timestamp' , $timestamp);
        $this->db->where('status' , $status);
        $this->db->from('teacher_attendance');
        $result = $this->db->count_all_results();
        return $result;
    }
    
    function get_students($class_id) {
        $query = $this->db->get_where('student', array('class_id' => $class_id));
        return $query->result_array();
    }

    function get_student_info($student_id) {
        $query = $this->db->get_where('student', array('student_id' => $student_id));
        return $query->result_array();
    }

     function create_post() 
     {
        $data['title'] = $this->input->post('title');
        $data['type'] = $this->session->userdata('login_type');
        $data['description'] = $this->input->post('description');
        $data['class_id'] = $this->input->post('class_id');
        $data['file_name']         = $_FILES["file_name"]["name"];
        $data['section_id'] = $this->input->post('section_id');
        $data['timestamp'] = strtotime(date("d M,Y"));
        $data['subject_id'] = $this->input->post('subject_id');
        $data['teacher_id']  =   $this->session->userdata('login_user_id');
        $data['post_code'] = substr(md5(rand(100000000, 200000000)), 0, 10);
        $this->db->insert('forum', $data);
        $post_code = $this->db->get_where('forum', array('post_id' => $this->db->insert_id()))->row()->post_code;
        $docs_id            = $this->db->insert_id();
        move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/forum/" . $_FILES["file_name"]["name"]);
        return $post_code;
    }

    function homework_create() 
    {
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['time_end'] = $this->input->post('time_end');
        $data['date_end'] = $this->input->post('date_end');
        $data['type'] = $this->input->post('type');
        $data['class_id'] = $this->input->post('class_id');
        $data['file_name']         = $_FILES["file_name"]["name"];
        $data['section_id'] = $this->input->post('section_id');
        $data['user'] = $this->session->userdata('login_type');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['uploader_type']  =   $this->session->userdata('login_type');
        $data['uploader_id']  =   $this->session->userdata('login_user_id');
        $data['homework_code'] = substr(md5(rand(100000000, 200000000)), 0, 10);
        $this->db->insert('homework', $data);
        $homework_code = $this->db->get_where('homework', array('homework_id' => $this->db->insert_id()))->row()->homework_code;
        $doc_id            = $this->db->insert_id();
        move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/homework/" . $_FILES["file_name"]["name"]);
        return $homework_code;
    }

    function public_files($id)
    {
        $data['category_id'] = $id;
        $data['file']         = $_FILES["file_name"]["name"];
        $data['code'] = substr(md5(rand(100000000, 200000000)), 0, 10);
        $this->db->insert('homework', $data);
        $homework_code = $this->db->get_where('homework', array('homework_id' => $this->db->insert_id()))->row()->homework_code;
        move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/public/" . $_FILES["file_name"]["name"]);
    }   

    function update_homework($homework_code) {
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['time_end'] = $this->input->post('time_end');
        $this->db->where('homework_code', $homework_code);
        $this->db->update('homework', $data);
    }

    function update_post($post_code) {
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $this->db->where('post_code', $post_code);
        $this->db->update('forum', $data);
    }

    function create_group()
    {
        $data = array();
        $data['group_message_thread_code'] = substr(md5(rand(100000000, 20000000000)), 0, 15);
        $data['created_timestamp'] = date("d M, Y H:i");
        $data['group_name'] = $this->input->post('group_name');
        if(!empty($_POST['user'])) 
        {
            array_push($_POST['user'], $this->session->userdata('login_type').'_'.$this->session->userdata('admin_id'));
            $data['members'] = json_encode($_POST['user']);
        }
        else
        {
            $_POST['user'] = array();
            array_push($_POST['user'], $this->session->userdata('login_type').'_'.$this->session->userdata('admin_id'));
            $data['members'] = json_encode($_POST['user']);
        }
        $this->db->insert('group_message_thread', $data);
    }

    function update_group($thread_code = "")
    {
      $data = array();
      $data['group_name'] = $this->input->post('group_name');
      if(!empty($_POST['user'])) 
      {
          array_push($_POST['user'], $this->session->userdata('login_type').'_'.$this->session->userdata('admin_id'));
          $data['members'] = json_encode($_POST['user']);
      }
      else{
        $_POST['user'] = array();
        array_push($_POST['user'], $this->session->userdata('login_type').'_'.$this->session->userdata('admin_id'));
        $data['members'] = json_encode($_POST['user']);
      }
      $this->db->where('group_message_thread_code', $thread_code);
      $this->db->update('group_message_thread', $data);
    }

   function send_reply_group_message($message_thread_code) 
   {
        $message    = $this->input->post('message');
        $timestamp  = date("d M. H:iA");
        $sender     = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        if ($_FILES['attached_file_on_messaging']['name'] != "") 
        {
          $data_message['attached_file_name'] = $_FILES['attached_file_on_messaging']['name'];
          $data_message['file_type'] = strtolower(pathinfo($_FILES["attached_file_on_messaging"]["name"], PATHINFO_EXTENSION));
        }
        $data_message['group_message_thread_code']    = $message_thread_code;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['timestamp']              = $timestamp;
        $this->db->insert('group_message', $data_message);
    }

    function count_unread_messages() 
    {
        $unread_message_counter = 0;
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $this->db->group_by('message_thread_code');
        $this->db->where('read_status', 0);
        $this->db->where('reciever', $current_user);
        $unread_message_counter = $this->db->get('message')->num_rows();
        return $unread_message_counter;
    }
    
    function create_post_message($post_code = '') 
    {
        $data['message'] = $this->input->post('message');
        $data['post_id'] = $this->db->get_where('forum', array('post_code' => $post_code))->row()->post_id;
        $data['date'] = date("d M, Y H:iA");
        $data['user_type'] = $this->session->userdata('login_type');
        $data['user_id'] = $this->session->userdata('login_user_id');
        $this->db->insert('forum_message', $data);
    }

    function delete_homework($homework_code) {
        $file_n = $this->db->get_where('homework', array('homework_code' => $homework_code))->row()->file_name;
        unlink("uploads/homework/" . $file_n);
        $this->db->where('homework_code', $homework_code);
        $this->db->delete('homework');
    }

     function delete_post($post_code) {
        $this->db->where('post_code', $post_code);
        $this->db->delete('forum');
    }

    function admin_delete($admin_id) {
        $this->db->where('admin_id', $admin_id);
        $this->db->delete('admin');
    }
    
    function get_teachers() {
        $query = $this->db->get('teacher');
        return $query->result_array();
    }

    function get_teacher_name($teacher_id) {
        $query = $this->db->get_where('teacher', array('teacher_id' => $teacher_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['name'];
    }
    
    function update_online_exam(){

        $data['title'] = html_escape($this->input->post('exam_title'));
        $data['class_id'] = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['minimum_percentage'] = html_escape($this->input->post('minimum_percentage'));
        $data['instruction'] = html_escape($this->input->post('instruction'));
        $data['exam_date'] = strtotime(html_escape($this->input->post('exam_date')));
        $data['time_start'] = html_escape($this->input->post('time_start'));
        $data['time_end'] = html_escape($this->input->post('time_end'));
        $data['duration'] = strtotime(date('Y-m-d', $data['exam_date']).' '.$data['time_end']) - strtotime(date('Y-m-d', $data['exam_date']).' '.$data['time_start']);

        $this->db->where('online_exam_id', $this->input->post('online_exam_id'));
        $this->db->update('online_exam', $data);
    }
    
    function get_student_info_by_id($student_id) {
        $query = $this->db->get_where('student', array('student_id' => $student_id))->row_array();
        return $query;
    }

    function get_teacher_info($teacher_id) {
        $query = $this->db->get_where('teacher', array('teacher_id' => $teacher_id));
        return $query->result_array();
    }

    function get_subjects() {
        $query = $this->db->get('subject');
        return $query->result_array();
    }

    function get_subject_info($subject_id) {
        $query = $this->db->get_where('subject', array('subject_id' => $subject_id));
        return $query->result_array();
    }

    function get_subjects_by_class($class_id) {
        $query = $this->db->get_where('subject', array('class_id' => $class_id));
        return $query->result_array();
    }

    function get_subject_name_by_id($subject_id) {
        $query = $this->db->get_where('subject', array('subject_id' => $subject_id))->row();
        return $query->name;
    }

    function get_class_name($class_id) {
        $query = $this->db->get_where('class', array('class_id' => $class_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['name'];
    }

    function get_class_name_numeric($class_id) {
        $query = $this->db->get_where('class', array('class_id' => $class_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['name_numeric'];
    }

    function get_classes() {
        $query = $this->db->get('class');
        return $query->result_array();
    }
    
    function income($month)
    {
      $income = $this->db->get_where('payment', array('month' => $month, 'payment_type' => 'income'))->result_array();
      $total = 0;
      foreach($income as $row)
      {
        $total += $this->db->get_where('invoice', array('invoice_id' => $row['invoice_id']))->row()->amount;
      }
      return $total;
    }

    function expense($month)
    {
      $expese = $this->db->get_where('payment', array('month' => $month,'payment_type' => 'expense'))->result_array();
      $total = 0;
      foreach($expese as $row)
      {
        $total += $row['amount'];
      }
      return $total;
    }

    function get_class_info($class_id) {
        $query = $this->db->get_where('class', array('class_id' => $class_id));
        return $query->result_array();
    }

    function get_exams() {
        $query = $this->db->get('exam');
        return $query->result_array();
    }

    function get_exam_info($exam_id) {
        $query = $this->db->get_where('exam', array('exam_id' => $exam_id));
        return $query->result_array();
    }

    function get_grades() {
        $query = $this->db->get('grade');
        return $query->result_array();
    }

    function get_grade_info($grade_id) {
        $query = $this->db->get_where('grade', array('grade_id' => $grade_id));
        return $query->result_array();
    }

    function get_obtained_marks( $exam_id , $class_id , $subject_id , $student_id) {
        $marks = $this->db->get_where('mark' , array(
                                    'subject_id' => $subject_id,
                                        'exam_id' => $exam_id,
                                            'class_id' => $class_id,
                                                'student_id' => $student_id))->result_array();
                                        
        foreach ($marks as $row) {
            echo $row['mark_obtained'];
            echo $row['labuno'];
            echo $row['labdos'];
            echo $row['labtres'];
            echo $row['labcuatro'];
            echo $row['labcinco'];
            echo $row['labseis'];
            echo $row['labsiete'];
            echo $row['labocho'];
            echo $row['labnueve'];
        }
    }

    function get_highest_marks( $exam_id , $class_id , $subject_id ) {
        $this->db->where('exam_id' , $exam_id);
        $this->db->where('class_id' , $class_id);
        $this->db->where('subject_id' , $subject_id);
        $this->db->select_max('mark_obtained');
        $highest_marks = $this->db->get('mark')->result_array();
        foreach($highest_marks as $row) {
            echo $row['mark_obtained'];
        }
    }

    function get_grade($mark_obtained) 
    {
        $query = $this->db->get('grade');
        $grades = $query->result_array();
        foreach ($grades as $ro) {
            if ($mark_obtained >= $ro['mark_from'] && $mark_obtained <= $ro['mark_upto'])
                echo $ro['grade_point'];
        }
    }

    function create_log($data) {
        $data['timestamp'] = strtotime(date('Y-m-d') . ' ' . date('H:i:s'));
        $data['ip'] = $_SERVER["REMOTE_ADDR"];
        $location = new SimpleXMLElement(file_get_contents('http://freegeoip.net/xml/' . $_SERVER["REMOTE_ADDR"]));
        $data['location'] = $location->City . ' , ' . $location->CountryName;
        $this->db->insert('log', $data);
    }

    function get_system_settings() {
        $query = $this->db->get('settings');
        return $query->result_array();
    }
    
    function generateUsername($length = 8) 
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    function generatePassword($length = 8) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function truncate($type) {
        if ($type == 'all') {
            $this->db->truncate('student');
            $this->db->truncate('mark');
            $this->db->truncate('teacher');
            $this->db->truncate('subject');
            $this->db->truncate('class');
            $this->db->truncate('exam');
            $this->db->truncate('grade');
        } else {
            $this->db->truncate($type);
        }
    }
    
    function get_name($type = '', $id = '')
    {
        $first = $this->db->get_where(''.$type.'',array($type."_id" => $id))->row()->first_name;
        $last = $this->db->get_where(''.$type.'',array($type."_id" => $id))->row()->last_name;
        $name = $first." ".$last;
        return $name;
    }

    function get_image_url($type = '', $id = '') 
    {
        $img = $this->db->get_where(''.$type.'',array($type."_id" => $id))->row()->image;
        if (file_exists('uploads/' . $type . '_image/' . $img) && $img != "")
            $image_url = base_url() . 'uploads/' . $type . '_image/' . $img;
        else
            $image_url = base_url() . 'uploads/user.jpg';
        return $image_url;
    }

    function get_image_video($type = '', $id = '') 
    {
         if (file_exists('uploads/screen/' . $id . '.jpg'))
            $image_url = base_url() . 'uploads/screen/' . $id . '.jpg';
        else $image_url = base_url() . 'uploads/user.jpg';

        return $image_url;
    }

    function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   
        return round(pow(1024, $base - floor($base)), $precision) .''. $suffixes[floor($base)];
    }

    function save_study_material_info()
    {
        $data['type'] = $this->session->userdata('login_type');
        $data['timestamp']         = strtotime(date("Y-m-d H:i:s"));
        $data['title']             = $this->input->post('title');
        $data['description']       = $this->input->post('description');
        $data['upload_date'] = date('d M. H:iA');
        $data['publish_date'] = date('Y-m-d H:i:s');
        $data['file_name']         = str_replace(" ", "",$_FILES["file_name"]["name"]);
        $data['filesize']         =  $this->formatBytes($_FILES["file_name"]["size"]);
        $data['wall_type'] = 'material';
        $data['file_type']         = $this->input->post('file_type');
        $data['class_id']          = $this->input->post('class_id');
        $data['subject_id']         = $this->input->post('subject_id');
        $data['section_id']         = $this->input->post('section_id');
        $data['teacher_id'] = $this->session->userdata('login_user_id');
        $this->db->insert('document',$data);
        $document_id            = $this->db->insert_id();
        move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/document/" . str_replace(" ", "",$_FILES["file_name"]["name"]));
    }

    function get_expense($month)
    {
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $expense = $this->db->get_where('payment', array('year' => $year, 'payment_type' => 'expense', 'month' => $month))->result_array();
        $total = 0;
        foreach($expense as $row){
            $total += $row['amount'];
        }
        return $total;
    }
    
    function get_payments($month)
    {
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $expense = $this->db->get_where('payment', array('year' => $year, 'payment_type' => 'income', 'month' => $month))->result_array();
        $total = 0;
        foreach($expense as $row){
            $total += $row['amount'];
        }
        return $total;
    }
    
    function select_study_material_info()
    {
        $this->db->order_by("timestamp", "desc");
        return $this->db->get('document')->result_array(); 
    }

    function create_news() 
    {
        $data['news_code']           = substr(md5(rand(100000000, 200000000)), 0, 10);
        $data['description']         = $this->input->post('description');
        $data['date']                = date('d, M');
        $data['publish_date']        = date('Y-m-d H:i:s');
        $data['admin_id']        = $this->session->userdata('login_user_id');
        $data['date2']                = date('H:i A');
        $data['type']                = "news";
        $this->db->insert('news', $data);
        $news_code = $this->db->get_where('news' , array('news_id' => $this->db->insert_id()))->row()->news_code;
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/news_images/' . $news_code . '.jpg');
        return $news_code;
    }

    function import_db()
    {
        $this->load->database();
        $this->db->truncate('academic_settings');
        $this->db->truncate('accountant');
        $this->db->truncate('account_role');
        $this->db->truncate('admin');
        $this->db->truncate('attendance');
        $this->db->truncate('book');
        $this->db->truncate('book_request');
        $this->db->truncate('ci_sessions');
        $this->db->truncate('class');
        $this->db->truncate('class_routine');
        $this->db->truncate('deliveries');
        $this->db->truncate('document');
        $this->db->truncate('dormitory');
        $this->db->truncate('email_template');
        $this->db->truncate('enroll');
        $this->db->truncate('events');
        $this->db->truncate('exam');
        $this->db->truncate('expense_category');
        $this->db->truncate('file');
        $this->db->truncate('folder');
        $this->db->truncate('forum');
        $this->db->truncate('forum_message');
        $this->db->truncate('grade');
        $this->db->truncate('group_message');
        $this->db->truncate('group_message_thread');
        $this->db->truncate('homework');
        $this->db->truncate('horarios_examenes');
        $this->db->truncate('invoice');
        $this->db->truncate('language');
        $this->db->truncate('librarian');
        $this->db->truncate('mark');
        $this->db->truncate('mensaje_reporte');
        $this->db->truncate('message');
        $this->db->truncate('message_thread');
        $this->db->truncate('news');
        $this->db->truncate('notice_message');
        $this->db->truncate('notification');
        $this->db->truncate('online_exam');
        $this->db->truncate('online_exam_result');
        $this->db->truncate('online_users');
        $this->db->truncate('parent');
        $this->db->truncate('payment');
        $this->db->truncate('pending_users');
        $this->db->truncate('polls');
        $this->db->truncate('poll_response');
        $this->db->truncate('question_bank');
        $this->db->truncate('question_paper');
        $this->db->truncate('reporte_alumnos');
        $this->db->truncate('reporte_mensaje');
        $this->db->truncate('reports');
        $this->db->truncate('report_response');
        $this->db->truncate('request');
        $this->db->truncate('section');
        $this->db->truncate('settings');
        $this->db->truncate('student');
        $this->db->truncate('students_request');
        $this->db->truncate('subject');
        $this->db->truncate('teacher');
        $this->db->truncate('teacher_attendance');
        $this->db->truncate('teacher_files');
        $this->db->truncate('ticket');
        $this->db->truncate('ticket_message');
        $this->db->truncate('transport');

        $file_n = $_FILES["file_name"]["name"];
        move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/" . $_FILES["file_name"]["name"]);
        $filename = "uploads/".$file_n;
        $mysql_host = $this->db->hostname;
        $mysql_username = $this->db->username;
        $mysql_password = $this->db->password;
        $mysql_database = $this->db->database;
        mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connect to MySQL: ' . mysql_error());
        mysql_select_db($mysql_database) or die('Error to connect MySQL: ' . mysql_error());
        $templine = '';
        $lines = file($filename);
        foreach ($lines as $line)
        {
                if (substr($line, 0, 2) == '--' || $line == '')
                {
                    continue;
                }
                $templine .= $line;
                if (substr(trim($line), -1, 1) == ';')
                {
                    mysql_query($templine) or print('Error \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                    $templine = '';
                if (mysql_errno() == 1062) 
                {
                print 'no way!';
                }
            }
        }
        unlink("uploads/" . $file_n);
        $this->session->set_flashdata('flash_message' , "Import success");
    }

    function delete_book($libro_id) {
        $this->db->where('libro_id', $libro_id);
        $this->db->delete('libreria');
    }

    function create_news_message($news_code = '') 
    {
      $admins = $this->db->get('admin')->result_array();
      $notify['notify'] = "<strong>".$this->session->userdata('name')."</strong>". " ". get_phrase('new_comment') ." <b>".$this->db->get_where('news' , array('news_code' => $news_code))->row()->title."</b>";
      foreach($admins as $row)
      {
          $notify['user_id'] = $row['admin_id'];
          $notify['user_type'] = "admin";
          $notify['url'] = "admin/read/".$news_code;
          $notify['date'] = date('d M, Y');
          $notify['time'] = date('h:i A');
          $notify['status'] = 0;
          $notify['original_id'] = $this->session->userdata('login_user_id');
          $notify['original_type'] = $this->session->userdata('login_type');
          $this->db->insert('notification', $notify);
        }

        $data['message']      = $this->input->post('message');
        $data['news_id']      = $this->db->get_where('news' , array('news_code' => $news_code))->row()->news_id;
        $data['date']         = date("d M Y");
        $data['user_type']    = $this->session->userdata('login_type');
        $data['user_id']      = $this->session->userdata('login_user_id');
        return $this->db->insert('mensaje_reporte', $data);
    }    

     function create_notice_message($notice_code = '') 
    {
        $data['message']      = $this->input->post('message');
        $data['notice_id']   = $this->db->get_where('news_teacher' , array('notice_code' => $notice_code))->row()->notice_id;
        $data['date']         = date("d M Y");
        $data['user_type']    = $this->session->userdata('login_type');
        $data['user_id']      = $this->session->userdata('login_user_id');
        if ( $_FILES['userfile']['name'] != '')
            $data['message_file_name'] = $_FILES['userfile']['name'];
        $this->db->insert('notice_message', $data);
        if ( $_FILES['userfile']['name'] != '')
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/notice_message_file/' . $_FILES['userfile']['name']);
        
    }   
    
    function select_study_material_info_for_student()
    {
        $student_id = $this->session->userdata('student_id');
        $class_id   = $this->db->get_where('enroll', array('student_id' => $student_id,'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->row()->class_id;
        $this->db->order_by("timestamp", "desc");
        return $this->db->get_where('document', array('class_id' => $class_id))->result_array();
    }
    
    function update_study_material_info($document_id)
    {
        $data['timestamp']      = strtotime($this->input->post('timestamp'));
        $data['title']      = $this->input->post('title');
        $data['description']    = $this->input->post('description');
        $data['class_id']   = $this->input->post('class_id');
        $data['subject_id']     = $this->input->post('subject_id');
        $this->db->where('document_id',$document_id);
        $this->db->update('document',$data);
    }
    
    function delete_study_material_info($document_id)
    {
        $file_n = $this->db->get_where('document', array('document_id' => $document_id))->row()->file_name;
        unlink("uploads/document/" . $file_n);
        $this->db->where('document_id',$document_id);
        $this->db->delete('document');
    }

    function send_new_private_message() 
    {
        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $message    = $this->input->post('message');
        $timestamp  = date("d M. H:iA");
        $reciever   = $this->input->post('reciever');
        $sender     = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->num_rows();
        $num2 = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->num_rows();
        if ($num1 == 0 && $num2 == 0) 
        {
            $message_thread_code                        = substr(md5(rand(100000000, 20000000000)), 0, 15);
            $data_message_thread['message_thread_code'] = $message_thread_code;
            $data_message_thread['sender']              = $sender;
            $data_message_thread['reciever']            = $reciever;
            $data_message_thread['last_message_timestamp']            =date('Y-m-d H:i:s');
            $this->db->insert('message_thread', $data_message_thread);
        }
        if ($num1 > 0)
        {
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->row()->message_thread_code;
        }
        if ($num2 > 0)
        {
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->row()->message_thread_code;
        }
        $data_message['message_thread_code']    = $message_thread_code;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['reciever']               = $reciever;
        $data_message['timestamp']              = $timestamp;
        $data_message['file_type']              = strtolower(pathinfo($_FILES["file_name"]["name"], PATHINFO_EXTENSION));
        $data_message['file_name']              = $_FILES["file_name"]["name"];
        $this->db->insert('message', $data_message);

        $name = $this->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'));
        $notify['notify'] = "<strong>". $name."</strong>". " ". get_phrase('new_message_notify');
        $rec = explode("-", $this->input->post('reciever'));
        $notify['user_id'] = $rec[1];
        $notify['user_type'] = $rec[0];
        $notify['url'] = $rec[0]."/message/message_read/".$message_thread_code."/";
        $notify['date'] = date('d M, Y');
        $notify['time'] = date('h:i A');
        $notify['status'] = 0;
        $notify['year'] = $year;
        $notify['type'] = 'message';
        $notify['original_id'] = $this->session->userdata('login_user_id');
        $notify['original_type'] = $this->session->userdata('login_type');
        $this->db->insert('notification', $notify);
        return $message_thread_code;
    }
    
    function send_exam_notify()
    {
        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $name = $this->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'));
        $notify['notify'] = "<strong>".$name."</strong>". " ". get_phrase('online_exam_notify') ." <b>".$this->input->post('exam_title')."</b>";
        $students = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id'), 'section_id' => $this->input->post('section_id'), 'year' => $year))->result_array();
        foreach($students as $row)
        {
            $notify['user_id'] = $row['student_id'];
            $notify['user_type'] = 'student';
            $notify['url'] = "student/online_exams/".base64_encode($this->input->post('class_id').'-'.$this->input->post('section_id').'-'.$this->input->post('subject_id'));
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['type'] = 'exam';
            $notify['year'] = $year;
            $notify['class_id'] = $this->input->post('class_id');
            $notify['section_id'] = $this->input->post('section_id');
            $notify['subject_id'] = $this->input->post('subject_id');
            $notify['original_id'] = $this->session->userdata('login_user_id');
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }
    }
    
    function send_forum_notify()
    {
        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $name = $this->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'));
        $notify['notify'] = "<strong>".$name."</strong>". get_phrase('added_new_forum_discussion');
        $students = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id'), 'section_id' => $this->input->post('section_id'), 'year' => $year))->result_array();
        foreach($students as $row)
        {
            $notify['user_id'] = $row['student_id'];
            $notify['user_type'] = 'student';
            $notify['url'] = "student/forum/".base64_encode($this->input->post('class_id').'-'.$this->input->post('section_id').'-'.$this->input->post('subject_id'));
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['type'] = 'forum';
            $notify['year'] = $year;
            $notify['class_id'] = $this->input->post('class_id');
            $notify['section_id'] = $this->input->post('section_id');
            $notify['subject_id'] = $this->input->post('subject_id');
            $notify['original_id'] = $this->session->userdata('login_user_id');
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);
        }
    }

    function send_reply_message($message_thread_code) 
    {
        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $message    = $this->input->post('message');
        $timestamp  = date("d M. H:iA");
        $sender     = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $name = $this->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'));
        $data_message['file_name']              = $_FILES["file_name"]["name"];
        $data_message['message_thread_code']    = $message_thread_code;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['timestamp']              = $timestamp;
        $data_message['reciever'] = $this->input->post('reciever');
        $data_message['file_type']              = strtolower(pathinfo($_FILES["file_name"]["name"], PATHINFO_EXTENSION));
        $this->db->insert('message', $data_message);
        $reci;
        $notify['notify'] = "<strong>".$name."</strong>". " ". get_phrase('new_message_notify');
        $rec = explode("-", $this->input->post('reciever'));
        if($rec[0] == "parent"){
          $reci = "parents";
        }else{
          $reci = $rec[0];
        }
        $notify['user_id'] = $rec[1];
        $notify['user_type'] = $rec[0];
        $notify['date'] = date('d M, Y');
        $notify['time'] = date('h:i A');
        $notify['url'] = $reci."/message/message_read/".$message_thread_code;
        $notify['status'] = 0;
        $notify['type'] = 'message';
        $notify['year'] = $year;
        $notify['original_id']   = $this->session->userdata('login_user_id');
        $notify['original_type'] = $this->session->userdata('login_type');
        $this->db->insert('notification', $notify);
    }

    function mark_thread_messages_read($message_thread_code) {
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $this->db->where('sender !=', $current_user);
        $this->db->where('message_thread_code', $message_thread_code);
        $this->db->update('message', array('read_status' => 1));
    }
    
    function create_report() 
    {
        $data['title']          = $this->input->post('title');
        $data['report_code']    = substr(md5(rand(100000000, 20000000000)), 0, 15);
        $data['priority']       = $this->input->post('priority');
        $data['teacher_id']     = $this->input->post('teacher_id');
        $data['status']     = 0;
        $login_type             = $this->session->userdata('login_type');
        if($login_type == 'student') $data['student_id']  = $this->session->userdata('login_user_id');
        else $data['student_id']  = $this->input->post('student_id');
        $data['timestamp']      = date("d M, Y");
        $data['description']       = $this->input->post('description');
        if($_FILES['file']['name'] != '') $data['file']          = $_FILES['file']['name'];
        $this->db->insert('reporte_alumnos', $data);
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/reportes_alumnos/' . $_FILES['file']['name']);
    }

     function delete_report($report_code) {
        $this->db->where('report_code', $report_code);
        $this->db->delete('reporte_alumnos');
    }

    function count_unread_message_of_thread($message_thread_code) {
        $unread_message_counter = 0;
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $messages = $this->db->get_where('message', array('message_thread_code' => $message_thread_code))->result_array();
        foreach ($messages as $row) {
            if ($row['sender'] != $current_user && $row['read_status'] == '0')
                $unread_message_counter++;
        }
        return $unread_message_counter;
    }

    function permission_request()
    {
        $data['teacher_id']   = $this->session->userdata('login_user_id');
        $data['description']  = $this->input->post('description');
        $data['title']        = $this->input->post('title');
        $data['start_date']   = $this->input->post('start_date');
        $data['end_date']     = $this->input->post('end_date');
        $data['file']         = $_FILES["file_name"]["name"];
        $this->db->insert('request', $data);
    }
    
    function account_confirm($type = '', $id = '')
    {
        $user_email = $this->db->get_where($type, array($type.'_id' => $id))->row()->email;
        $user_name = $this->db->get_where($type, array($type.'_id' => $id))->row()->first_name." ".$this->db->get_where($type, array($type.'_id' => $id))->row()->last_name;
        $username = $this->db->get_where($type, array($type.'_id' => $id))->row()->username;
        require("class.phpmailer.php");
        $email_sub    =   "Congratulations! ";
        $email_msg   .=   "Hi <strong>".$user_name.",</strong><br><br>";
        $email_msg   .=  "The site administrator approved your account, you can now login. <br><br>";
        $email_msg   .=  "Your data are as follows:<br><br>";
        $email_msg   .=  "<strong>Name:</strong> ".$user_name."<br/>";
        $email_msg   .=  "<strong>Email:</strong> ".$user_email."<br/>";
        $email_msg   .=  "<strong>Username:</strong> ".$username."<br/>";
        $email_msg   .=  "<strong>Password:</strong> ********<br/><br/>";
        $data = array(
            'email_msg' => $email_msg
        );
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        $mail->SetFrom($this->db->get_where('settings', array('type' => 'system_email'))->row()->description, $this->db->get_where('settings', array('type' => 'system_name'))->row()->description);
        $mail->Subject = $email_sub;
        $mail->Body = $this->load->view('backend/mails/accept.php',$data,TRUE);
        $mail->AddAddress($user_email);
        if(!$mail->Send()) 
        {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }

    function create_backup() 
    {
        $this->load->dbutil();
        $options = array(
            'format' => 'txt', 
            'add_drop' => TRUE,
            'add_insert' => TRUE,
            'newline' => "\n"
        );
        $tables = array('');
        $file_name = 'system_backup';
        $backup = & $this->dbutil->backup(array_merge($options, $tables));
        $this->load->helper('download');
        force_download($file_name . '.sql', $backup);
    }
}