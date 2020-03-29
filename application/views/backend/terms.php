<!DOCTYPE html>
<html><style>
    body{
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility; 
    }
</style>
  <head>
    <title><?php echo get_phrase('terms_conditions');?> | <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?></title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>style/cms/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>style/cms/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>style/cms/icon_fonts_assets/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <link href="<?php echo base_url();?>style/cms/icon_fonts_assets/picons-thin/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'favicon'))->row()->description;?>" rel="icon">
    <link href="<?php echo base_url();?>style/cms/css/main.css?version=3.3" rel="stylesheet">
  </head>
  <body class="auth-wrapper login" style="background: url('<?php echo base_url();?>uploads/bglogin.jpg');background-size: cover;background-repeat: no-repeat;">
      <div class="auth-box-w wider">
        <div class="logo-wy">
          <a href="<?php echo base_url();?>"><img alt="" src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" width="30%"></a><br><br>
        </div>
      <div class="steps-w">
        <div class="step-contents">
          <div class="step-content active" id="stepContent1">
              <h4><?php echo get_phrase('terms_conditions');?></h4><hr>
            <div class="row">
            <br>
            <p><?php echo $this->db->get_where('academic_settings' , array('type' =>'terms'))->row()->description;?></p>
            <hr>
            <div class="pull-right"><br><br><br>
                <a class="btn btn-purple btn-rounded text-white" href="<?php echo base_url();?>"> <?php echo get_phrase('return');?></a>
            <br><br>
            </div>
            </div>
          </div>
      </div>
      </div>
  </body>
</html>