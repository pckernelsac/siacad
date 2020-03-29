<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dropzone extends CI_Controller {
    public function __construct() {
       parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');    
        $this->load->helper(array('url','html','form')); 
    }
 
    public function index() 
    {
        $this->load->view('dropzone_view');
    }
    
    function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');   
        return round(pow(1024, $base - floor($base)), $precision) .'*'. $suffixes[floor($base)];
    }

    public function upload($param1 = '', $param2 = '', $param3 = '') 
    {
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        $root = md5($this->session->userdata('login_user_id'));
        $user_type = $this->session->userdata('login_type');
        $folder = $this->db->get_where('folder', array('token' => $_GET['folder_key']))->row()->name;
        if($_GET['folder_key'] == ''){
            $root_folder = md5($this->session->userdata('login_user_id'));
            if (!file_exists('uploads/users/'.$this->session->userdata('login_type').'/'.$root_folder)) {
                mkdir('uploads/users/'.$this->session->userdata('login_type').'/'.$root_folder, 0777, true);
            }
            $upload_folder = getcwd() . '/uploads/users/'.$user_type.'/'.$root.'/';
            
        }else if($_GET['folder_key'] != ''){
            $upload_folder = getcwd() . '/uploads/users/'.$user_type.'/'.$root.'/'.$folder.'/';
        }
    	ini_set( 'memory_limit', '200M' );
        ini_set('upload_max_filesize', '200M');  
        ini_set('post_max_size', '200M');  
        ini_set('max_input_time', 3600);  
        ini_set('max_execution_time', 3600);
        
        if (!empty($_FILES)) 
        {
        	$tempFile = $_FILES['file']['tmp_name'];
        	$fileName = $_FILES['file']['name'];
        	$targetPath = $upload_folder;
        	$targetFile = $targetPath . $fileName;
        	move_uploaded_file($tempFile, $targetFile);
        	$data['name'] = $fileName;
        	$data['user_type'] = $this->session->userdata('login_type');
        	$data['user_id'] = $this->session->userdata('login_user_id');
        	$data['date'] = date('d M, Y H:iA');
        	$data['fileorder']=date('d/m/Y');
        	$data['folder_token'] = $_GET['folder_key'];
        	$data['size'] = $this->formatBytes($_FILES["file"]["size"]);
        	$this->db->insert('file', $data);
        }
    }

    
}