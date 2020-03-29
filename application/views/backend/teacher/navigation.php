<div class="fixed-sidebar">
  <div class="fixed-sidebar-left sidebar--small" id="sidebar-left">
    <a href="<?php echo base_url();?>teacher/panel/" class="logo">
      <div class="img-wrap">
        <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'icon_white'))->row()->description;?>">
      </div>
    </a>
    <div class="mCustomScrollbar" data-mcs-theme="dark">
      <ul class="left-menu">
        <li>
          <a href="#" class="js-sidebar-open">
            <i class="left-menu-icon picons-thin-icon-thin-0069a_menu_hambuger"></i>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/panel/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('dashboard');?>">
                  <div class="left-menu-icon">
                    <i class="picons-thin-icon-thin-0045_home_house"></i>
                  </div></a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/message/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('messages');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
            </div>
          </a>
        </li>       
        <li>
          <a href="<?php echo base_url();?>teacher/teacher_list/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('teachers');?>">
            <div class="left-menu-icon">        
              <i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
            </div>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/students_area/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('students');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
            </div>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/my_routine/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('class_routine');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0029_time_watch_clock_wall"></i>
            </div>
          </a>
        </li>
          <li>
          <a href="<?php echo base_url();?>teacher/grados/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('academic');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0680_pencil_ruller_drawing"></i>
            </div>
          </a>
        </li>       
        <li>
          <a href="<?php echo base_url();?>teacher/student_report/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('behavior');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
            </div>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/manage_attendance/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('attendance');?>">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
            </div>
          </a>
        </li>
         <li>
          <a href="<?php echo base_url();?>teacher/news/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('news');?>">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0010_newspaper_reading_news"></i>
            </div>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/library/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('library');?>">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0017_office_archive"></i>
            </div>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/request/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('permissions');?>">
            <div class="left-menu-icon">
              <i class="os-icon os-icon picons-thin-icon-thin-0015_fountain_pen"></i>
            </div>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/calendar/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('calendar');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
            </div>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/files/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('my_files');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0125_cloud_sync"></i>
            </div>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/notify/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('notifications');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0286_mobile_message_sms"></i>
            </div>
          </a>
        </li>
      </ul>
    </div>
  </div>

  <div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1">
    <a href="<?php echo base_url();?>teacher/panel/" class="logo">
      <div class="img-wrap">
        <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'icon_white'))->row()->description;?>">
      </div>
      <div class="title-block">
        <h6 class="logo-title"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?></h6>
      </div>
    </a>
    <div class="mCustomScrollbar" data-mcs-theme="dark">
      <ul class="left-menu">
        <li>
          <a href="#" class="js-sidebar-open">
            <i class="left-menu-icon picons-thin-icon-thin-0069a_menu_hambuger"></i>
            <span class="left-menu-title"><?php echo get_phrase('minimize_menu');?></span>
          </a>
        </li>
        <li>
            <a href="<?php echo base_url();?>teacher/panel/">
                <div class="left-menu-icon">
                    <i class="picons-thin-icon-thin-0045_home_house"></i>
                </div>
                <span class="left-menu-title"><?php echo get_phrase('dashboard');?></span>
            </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/message/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('messages');?></span>
          </a>
        </li>       
        <li>
          <a href="<?php echo base_url();?>teacher/teacher_list/">
            <div class="left-menu-icon">        
              <i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('teachers');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/students_area/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('students');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/my_routine/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0029_time_watch_clock_wall"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('class_routine');?></span>
          </a>
        </li>
          <li>
          <a href="<?php echo base_url();?>teacher/grados/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0680_pencil_ruller_drawing"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('academic');?></span>
          </a>
        </li>       
        <li>
          <a href="<?php echo base_url();?>teacher/student_report/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('behavior');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/manage_attendance/">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('attendance');?></span>
          </a>
        </li>
         <li>
          <a href="<?php echo base_url();?>teacher/news/">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0010_newspaper_reading_news"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('news');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/library/">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0017_office_archive"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('library');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/request/">
            <div class="left-menu-icon">
              <i class="os-icon os-icon picons-thin-icon-thin-0015_fountain_pen"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('permissions');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/calendar/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('calendar');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/files/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0125_cloud_sync"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('my_files');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/notify/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0286_mobile_message_sms"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('notifications');?></span>
          </a>
        </li>
        <br><br>
        <li></li>
      </ul>
    </div>
  </div>
</div>

<div class="fixed-sidebar fixed-sidebar-responsive">
  <div class="fixed-sidebar-left sidebar--small" id="sidebar-left-responsive">
    <a href="<?php echo base_url();?>teacher/panel/" class="logo js-sidebar-open">
      <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'icon_white'))->row()->description;?>">
    </a>
  </div>
  <div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1-responsive">
    <a href="<?php echo base_url();?>teacher/panel/" class="logo">
      <div class="img-wrap">
        <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'icon_white'))->row()->description;?>">
      </div>
      <div class="title-block">
        <h6 class="logo-title"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?></h6>
      </div>
    </a>
    <div class="mCustomScrollbar" data-mcs-theme="dark">
      <ul class="left-menu">
        <li>
          <a href="#" class="js-sidebar-open">
            <i class="left-menu-icon picons-thin-icon-thin-0069a_menu_hambuger"></i>
            <span class="left-menu-title"><?php echo get_phrase('minimize_menu');?></span>
          </a>
        </li>
        <li>
            <a href="<?php echo base_url();?>teacher/panel/">
                <div class="left-menu-icon">
                    <i class="picons-thin-icon-thin-0045_home_house"></i>
                </div>
                <span class="left-menu-title"><?php echo get_phrase('dashboard');?></span>
            </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/message/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('messages');?></span>
          </a>
        </li>       
        <li>
          <a href="<?php echo base_url();?>teacher/teacher_list/">
            <div class="left-menu-icon">        
              <i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('teachers');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/students_area/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('students');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/my_routine/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0029_time_watch_clock_wall"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('class_routine');?></span>
          </a>
        </li>
          <li>
          <a href="<?php echo base_url();?>teacher/grados/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0680_pencil_ruller_drawing"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('academic');?></span>
          </a>
        </li>       
        <li>
          <a href="<?php echo base_url();?>teacher/student_report/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('behavior');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/manage_attendance/">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('attendance');?></span>
          </a>
        </li>
         <li>
          <a href="<?php echo base_url();?>teacher/news/">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0010_newspaper_reading_news"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('news');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/library/">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0017_office_archive"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('library');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/request/">
            <div class="left-menu-icon">
              <i class="os-icon os-icon picons-thin-icon-thin-0015_fountain_pen"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('permissions');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/calendar/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('calendar');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/files/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0125_cloud_sync"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('my_files');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>teacher/notify/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0286_mobile_message_sms"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('notifications');?></span>
          </a>
        </li><br><br>
        <li></li>
      </ul>
    </div>
  </div>
</div>