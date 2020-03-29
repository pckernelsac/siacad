<?php $admin_type = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('login_user_id')))->row()->owner_status;?>
<div class="fixed-sidebar">
  <div class="fixed-sidebar-left sidebar--small" id="sidebar-left">
    <a href="<?php echo base_url();?>admin/panel/" class="logo">
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
            <a href="<?php echo base_url();?>admin/panel/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('dashboard');?>">
                <div class="left-menu-icon">
                    <i class="picons-thin-icon-thin-0045_home_house"></i>
                </div>
            </a>
        </li>

        <!-- Messages Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'messages'))->row()->permissions == 1 || $admin_type == 1):?>
        <li>
          <a href="<?php echo base_url();?>admin/message/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('messages');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
            </div>
          </a>
        </li> 
        <?php endif;?>
        <!-- End Messages Access -->
        
        <li>
          <a href="<?php echo base_url();?>admin/users/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('users');?>">
            <div class="left-menu-icon">        
              <i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
            </div>
          </a>
        </li>
        
        <!-- Admissions Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'admissions'))->row()->permissions == 1 || $admin_type == 1):?>
            <li>
                <a href="<?php echo base_url();?>admin/new_student/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('admissions');?>">
                    <div class="left-menu-icon">
                        <i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
                    </div>
                </a>
            </li> 
        <?php endif;?>
        <!-- End Admissions Access -->
        
          <!-- Class Routine Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'schedules'))->row()->permissions == 1 || $admin_type == 1):?>
            <li>
              <a href="<?php echo base_url();?>admin/class_routine_view/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('class_routine');?>">
                <div class="left-menu-icon">
                  <i class="picons-thin-icon-thin-0029_time_watch_clock_wall"></i>
                </div>
              </a>
            </li>
          <?php endif;?>

          <!-- Academic Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'academic'))->row()->permissions == 1 || $admin_type == 1):?>
            <li>
              <a href="<?php echo base_url();?>admin/grados/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('academic');?>">
                <div class="left-menu-icon">
                  <i class="picons-thin-icon-thin-0680_pencil_ruller_drawing"></i>
                </div>
              </a>
            </li>   
          <?php endif;?>

          <!-- Library Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'library'))->row()->permissions == 1 || $admin_type == 1):?>
            <li>
              <a href="<?php echo base_url();?>admin/library/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('library');?>">
                <div class="left-menu-icon">
                  <i class="os-icon picons-thin-icon-thin-0017_office_archive"></i>
                </div>
              </a>
            </li>
          <?php endif;?>

          <!-- Attendance Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'attendance'))->row()->permissions == 1 || $admin_type == 1):?>
            <li>
              <a href="<?php echo base_url();?>admin/attendance/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('attendance');?>">
                <div class="left-menu-icon">
                  <i class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
                </div>
              </a>
            </li>
          <?php endif;?>

          <!-- Calendar Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'calendar'))->row()->permissions == 1 || $admin_type == 1):?>
            <li>
              <a href="<?php echo base_url();?>admin/calendar/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('calendar');?>">
                <div class="left-menu-icon">
                  <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
                </div>
              </a>
            </li>
          <?php endif;?>

          <!-- Files Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'files'))->row()->permissions == 1 || $admin_type == 1):?>
            <li>
              <a href="<?php echo base_url();?>admin/files/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('my_files');?>">
                <div class="left-menu-icon">
                  <i class="picons-thin-icon-thin-0125_cloud_sync"></i>
                </div>
              </a>
            </li>
          <?php endif;?>

          <!-- Polls Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'polls'))->row()->permissions == 1 || $admin_type == 1):?>        
            <li>
              <a href="<?php echo base_url();?>admin/polls/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('polls');?>">
                <div class="left-menu-icon">
                  <i class="os-icon picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                </div>
              </a>
            </li>
          <?php endif;?>

          <!-- Notifications Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'notifications'))->row()->permissions == 1 || $admin_type == 1):?>        
            <li>
              <a href="<?php echo base_url();?>admin/notify/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('notifications');?>">
                <div class="left-menu-icon">
                  <i class="picons-thin-icon-thin-0286_mobile_message_sms"></i>
                </div>
              </a>
            </li>
          <?php endif;?>

          <!-- Behavior Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'behavior'))->row()->permissions == 1 || $admin_type == 1):?>        
            <li>
              <a href="<?php echo base_url();?>admin/request_student/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('behavior');?>">
                <div class="left-menu-icon">
                  <i class="picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
                </div>
              </a>
            </li>
          <?php endif;?>

          <!-- News Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'news'))->row()->permissions == 1 || $admin_type == 1):?>        
            <li>
              <a href="<?php echo base_url();?>admin/news/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('news');?>">
                <div class="left-menu-icon">
                  <i class="os-icon picons-thin-icon-thin-0010_newspaper_reading_news"></i>
                </div>
              </a>
            </li>
          <?php endif;?>

          <!-- School Bus Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'school_bus'))->row()->permissions == 1 || $admin_type == 1):?>        
            <li>
              <a href="<?php echo base_url();?>admin/school_bus/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('school_bus');?>">
                <div class="left-menu-icon">
                  <i class="os-icon picons-thin-icon-thin-0470_bus_transport"></i>
                </div>
              </a>
            </li>
          <?php endif;?>

          <!-- Classrooms Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'classrooms'))->row()->permissions == 1 || $admin_type == 1):?>        
            <li>
              <a href="<?php echo base_url();?>admin/classrooms/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('classrooms');?>">
                <div class="left-menu-icon">
                  <i class="os-icon picons-thin-icon-thin-0047_home_flat"></i>
                </div>
              </a>
            </li>
          <?php endif;?>

          <!-- Payments Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'accounting'))->row()->permissions == 1 || $admin_type == 1):?>        
            <li>
              <a href="<?php echo base_url();?>admin/payments/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('accounting');?>">
                <div class="left-menu-icon">
                  <i class="picons-thin-icon-thin-0428_money_payment_dollar_bag_cash"></i>
                </div>
              </a>
            </li>
          <?php endif;?>

          <!-- System Reports Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'system_reports'))->row()->permissions == 1 || $admin_type == 1):?>        
            <li>
              <a href="<?php echo base_url();?>admin/general_reports/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('system_reports');?>">
                <div class="left-menu-icon">
                  <i class="picons-thin-icon-thin-0378_analytics_presentation_statistics_graph"></i>
                </div>
              </a>
            </li>
          <?php endif;?>

          <!-- Academic Settings Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'academic_settings'))->row()->permissions == 1 || $admin_type == 1):?>        
            <li>
              <a href="<?php echo base_url();?>admin/academic_settings/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('academic_settings');?>">
                <div class="left-menu-icon">
                  <i class="os-icon picons-thin-icon-thin-0006_book_writing_reading_read_manual"></i>
                </div>
              </a>
            </li>
          <?php endif;?>

          <!-- Settings Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'settings'))->row()->permissions == 1 || $admin_type == 1):?>        
            <li>
              <a href="<?php echo base_url();?>admin/system_settings/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('settings');?>">
                <div class="left-menu-icon">
                  <i class="picons-thin-icon-thin-0051_settings_gear_preferences"></i>
                </div>
              </a>
            </li>
          <?php endif;?>
      </ul>
    </div>
  </div>

  <div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1">
    <a href="<?php echo base_url();?>admin/panel/" class="logo">
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
          <a href="<?php echo base_url();?>admin/panel/">
                      <div class="left-menu-icon">
                        <i class="picons-thin-icon-thin-0045_home_house"></i>
                      </div>
                      <span class="left-menu-title"><?php echo get_phrase('dashboard');?></span>
                  </a>
        </li>

        <!-- Messages Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'messages'))->row()->permissions == 1 || $admin_type == 1):?>
          <li>
            <a href="<?php echo base_url();?>admin/message/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('messages');?></span>
            </a>
          </li>       
        <?php endif;?>

        <li>
          <a href="<?php echo base_url();?>admin/users/">
            <div class="left-menu-icon">        
              <i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('users');?></span>
          </a>
        </li>

        <!-- Admissions Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'admissions'))->row()->permissions == 1 || $admin_type == 1):?>
          <li>
            <a href="<?php echo base_url();?>admin/new_student/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('admissions');?></span>
            </a>
          </li> 
        <?php endif;?>

         <!-- Class Routine Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'schedules'))->row()->permissions == 1 || $admin_type == 1):?>
          <li>
            <a href="<?php echo base_url();?>admin/class_routine_view/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0029_time_watch_clock_wall"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('class_routine');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- Academic Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'academic'))->row()->permissions == 1 || $admin_type == 1):?>
          <li>
            <a href="<?php echo base_url();?>admin/grados/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0680_pencil_ruller_drawing"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('academic');?></span>
            </a>
          </li>       
        <?php endif;?>

        <!-- Library Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'library'))->row()->permissions == 1 || $admin_type == 1):?>
          <li>
            <a href="<?php echo base_url();?>admin/library/">
              <div class="left-menu-icon">
                <i class="os-icon picons-thin-icon-thin-0017_office_archive"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('library');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- Attendance Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'attendance'))->row()->permissions == 1 || $admin_type == 1):?>
          <li>
            <a href="<?php echo base_url();?>admin/attendance/">
              <div class="left-menu-icon">
                <i class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('attendance');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- Calendar Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'calendar'))->row()->permissions == 1 || $admin_type == 1):?>
          <li>
            <a href="<?php echo base_url();?>admin/calendar/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('calendar');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- Files Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'files'))->row()->permissions == 1 || $admin_type == 1):?>
          <li>
            <a href="<?php echo base_url();?>admin/files/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0125_cloud_sync"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('my_files');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- Polls Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'polls'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/polls/">
              <div class="left-menu-icon">
                <i class="os-icon picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('polls');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- Notifications Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'notifications'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/notify/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0286_mobile_message_sms"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('notifications');?></span>
            </a>
          </li>
        <?php endif;?>
        <!-- Behavior Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'behavior'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/request_student/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('behavior');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- News Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'news'))->row()->permissions == 1 || $admin_type == 1):?>        
         <li>
            <a href="<?php echo base_url();?>admin/news/">
              <div class="left-menu-icon">
                <i class="os-icon picons-thin-icon-thin-0010_newspaper_reading_news"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('news');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- School Bus Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'school_bus'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/school_bus/">
              <div class="left-menu-icon">
                <i class="os-icon picons-thin-icon-thin-0470_bus_transport"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('school_bus');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- Classrooms Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'classrooms'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/classrooms/">
              <div class="left-menu-icon">
                <i class="os-icon picons-thin-icon-thin-0047_home_flat"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('classrooms');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- Payments Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'accounting'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/payments/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0428_money_payment_dollar_bag_cash"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('accounting');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- System Reports Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'system_reports'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/general_reports/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0378_analytics_presentation_statistics_graph"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('system_reports');?></span>
            </a>
          </li>
        <?php endif;?>
        <!-- Academic Settings Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'academic_settings'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/academic_settings/">
              <div class="left-menu-icon">
                <i class="os-icon picons-thin-icon-thin-0006_book_writing_reading_read_manual"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('academic_settings');?></span>
            </a>
          </li>
        <?php endif;?>
        <!-- Settings Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'settings'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/system_settings/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0051_settings_gear_preferences"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('settings');?></span>
            </a>
          </li>
        <?php endif;?>
        <br><br>
        <li></li>
      </ul>
    </div>
  </div>
</div>

<div class="fixed-sidebar fixed-sidebar-responsive">
  <div class="fixed-sidebar-left sidebar--small" id="sidebar-left-responsive">
    <a href="<?php echo base_url();?>admin/panel/" class="logo js-sidebar-open">
      <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'icon_white'))->row()->description;?>">
    </a>
  </div>
  <div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1-responsive">
    <a href="<?php echo base_url();?>" class="logo">
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
          <a href="<?php echo base_url();?>admin/panel/">
                      <div class="left-menu-icon">
                        <i class="picons-thin-icon-thin-0045_home_house"></i>
                      </div>
                      <span class="left-menu-title"><?php echo get_phrase('dashboard');?></span>
                  </a>
        </li>

        <!-- Messages Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'messages'))->row()->permissions == 1 || $admin_type == 1):?>
          <li>
            <a href="<?php echo base_url();?>admin/message/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('messages');?></span>
            </a>
          </li>       
        <?php endif;?>

        <li>
          <a href="<?php echo base_url();?>admin/users/">
            <div class="left-menu-icon">        
              <i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('users');?></span>
          </a>
        </li>

        <!-- Admissions Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'admissions'))->row()->permissions == 1 || $admin_type == 1):?>
          <li>
            <a href="<?php echo base_url();?>admin/new_student/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('admissions');?></span>
            </a>
          </li> 
        <?php endif;?>

         <!-- Class Routine Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'schedules'))->row()->permissions == 1 || $admin_type == 1):?>
            <li>
              <a href="<?php echo base_url();?>admin/class_routine_view/">
                <div class="left-menu-icon">
                  <i class="picons-thin-icon-thin-0029_time_watch_clock_wall"></i>
                </div>
                <span class="left-menu-title"><?php echo get_phrase('class_routine');?></span>
              </a>
            </li>
          <?php endif;?>

          <!-- Academic Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'academic'))->row()->permissions == 1 || $admin_type == 1):?>
            <li>
              <a href="<?php echo base_url();?>admin/grados/">
                <div class="left-menu-icon">
                  <i class="picons-thin-icon-thin-0680_pencil_ruller_drawing"></i>
                </div>
                <span class="left-menu-title"><?php echo get_phrase('academic');?></span>
              </a>
            </li>       
          <?php endif;?>

          <!-- Library Access -->
          <?php if($this->db->get_where('account_role', array('type' => 'library'))->row()->permissions == 1 || $admin_type == 1):?>
            <li>
              <a href="<?php echo base_url();?>admin/library/">
                <div class="left-menu-icon">
                  <i class="os-icon picons-thin-icon-thin-0017_office_archive"></i>
                </div>
                <span class="left-menu-title"><?php echo get_phrase('library');?></span>
              </a>
            </li>
          <?php endif;?>

          <!-- Attendance Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'attendance'))->row()->permissions == 1 || $admin_type == 1):?>
          <li>
            <a href="<?php echo base_url();?>admin/attendance/">
              <div class="left-menu-icon">
                <i class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('attendance');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- Calendar Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'calendar'))->row()->permissions == 1 || $admin_type == 1):?>
          <li>
            <a href="<?php echo base_url();?>admin/calendar/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('calendar');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- Files Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'files'))->row()->permissions == 1 || $admin_type == 1):?>
          <li>
            <a href="<?php echo base_url();?>admin/files/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0125_cloud_sync"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('my_files');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- Polls Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'polls'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/polls/">
              <div class="left-menu-icon">
                <i class="os-icon picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('polls');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- Notifications Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'notifications'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/notify/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0286_mobile_message_sms"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('notifications');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- Behavior Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'behavior'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>  
            <a href="<?php echo base_url();?>admin/request_student/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('behavior');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- News Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'news'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/news/">
              <div class="left-menu-icon">
                <i class="os-icon picons-thin-icon-thin-0010_newspaper_reading_news"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('news');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- School Bus Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'school_bus'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/school_bus/">
              <div class="left-menu-icon">
                <i class="os-icon picons-thin-icon-thin-0470_bus_transport"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('school_bus');?></span>
            </a>  
          </li>
        <?php endif;?>

        <!-- Classrooms Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'classrooms'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/classrooms/">
              <div class="left-menu-icon">
                <i class="os-icon picons-thin-icon-thin-0047_home_flat"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('classrooms');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- Payments Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'accounting'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/payments/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0428_money_payment_dollar_bag_cash"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('accounting');?></span>
            </a>
          </li>
        <?php endif;?>

        <!-- System Reports Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'system_reports'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/general_reports/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0378_analytics_presentation_statistics_graph"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('system_reports');?></span>
            </a>
          </li>
        <?php endif;?>
        <!-- Academic Settings Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'academic_settings'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/academic_settings/">
              <div class="left-menu-icon">
                <i class="os-icon picons-thin-icon-thin-0006_book_writing_reading_read_manual"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('academic_settings');?></span>
            </a>
          </li>
        <?php endif;?>
        <!-- Settings Access -->
        <?php if($this->db->get_where('account_role', array('type' => 'settings'))->row()->permissions == 1 || $admin_type == 1):?>        
          <li>
            <a href="<?php echo base_url();?>admin/system_settings/">
              <div class="left-menu-icon">
                <i class="picons-thin-icon-thin-0051_settings_gear_preferences"></i>
              </div>
              <span class="left-menu-title"><?php echo get_phrase('settings');?></span>
            </a>
          </li>
          <?php endif;?><br><br>
        <li></li>
      </ul>
    </div>
  </div>
</div>