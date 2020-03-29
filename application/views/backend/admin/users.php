<?php $admin_type = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('login_user_id')))->row()->owner_status;?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
        <div class="conty">
          <div class="all-wrapper no-padding-content solid-bg-all">
              <div class="layout-w">
                  <div class="content-w">
                      <div class="content-i">
                        <div class="content-box">
                            <div class="app-email-w">
                            <div class="app-email-i">
                                <div class="ae-content-w" style="background-color: #f2f4f8;">
                      <div class="top-header top-header-favorit">
                        <div class="top-header-thumb">
                          <img src="<?php echo base_url();?>uploads/bglogin.jpg" alt="nature" style="height:180px; object-fit:cover;">
                          <div class="top-header-author">
                            <div class="author-thumb">
                              <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" alt="author" style="background-color: #fff; padding:10px;">
                            </div>
                            <div class="author-content">
                              <a href="javascript:void(0);" class="h3 author-name"><?php echo get_phrase('users');?></a>
                              <div class="country"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>  |  <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="profile-section" style="background-color: #fff;">
                          <div class="control-block-button">                                    
                          </div>
                        </div>
                      </div>
                            <div class="aec-full-message-w">
                                <div class="aec-full-message">
                                    <div class="container-fluid" style="background-color: #f2f4f8;"><br>
                                      <div class="col-sm- 12">     
                                        <div class="row">
                                        <?php if($this->db->get_where('account_role', array('type' => 'admins'))->row()->permissions == 1 || $admin_type == 1):?>
                                        <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                          <div class="ui-block" data-mh="friend-groups-item">
                                            <div class="friend-item friend-groups">
                                                <div class="friend-item-content">
                                                <?php if($admin_type == 1):?>
                                                  <div class="more">
                                                      <i class="icon-feather-more-horizontal"></i>
                                                      <ul class="more-dropdown">
                                                        <li><a data-toggle="modal" data-target="#permisosadmin" href="javascript:void(0);"><?php echo get_phrase('permissions');?></a></li>
                                                      </ul>
                                                  </div>
                                                  <?php endif;?>
                                                  <div class="friend-avatar">
                                                      <div class="author-thumb">
                                                        <img src="<?php echo base_url();?>uploads/icons/admins.svg" width="110px" style="background-color:#fff;padding:15px; border-radius:0px;">
                                                      </div>
                                                      <div class="author-content">
                                                        <a href="<?php echo base_url();?>admin/admins/" class="h5 author-name"><?php echo get_phrase('admins');?></a>
                                                        <div class="country"><?php echo $this->db->count_all_results('admin');?> <?php echo get_phrase('admins');?></div>
                                                      </div>
                                                  </div>
                                                </div>
                                            </div>
                                          </div>
                                      </div>
                                      <?php endif;?>
                                      <?php if($this->db->get_where('account_role', array('type' => 'teachers'))->row()->permissions == 1 || $admin_type == 1):?>
                                      <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                          <div class="ui-block" data-mh="friend-groups-item">        
                                            <div class="friend-item friend-groups">
                                                <div class="friend-item-content">
                                                  <div class="friend-avatar">
                                                      <div class="author-thumb">
                                                        <img src="<?php echo base_url();?>uploads/icons/teachers.svg" width="110px" style="background-color:#fff;padding:15px;border-radius:0px;">
                                                      </div>
                                                      <div class="author-content">
                                                        <a href="<?php echo base_url();?>admin/teachers/" class="h5 author-name"><?php echo get_phrase('teachers');?></a>
                                                        <div class="country"><?php echo $this->db->count_all_results('teacher');?> <?php echo get_phrase('teachers');?></div>
                                                      </div>
                                                  </div>        
                                                </div>
                                            </div>        
                                          </div>
                                      </div>
                                      <?php endif;?>
                                      <?php if($this->db->get_where('account_role', array('type' => 'students'))->row()->permissions == 1 || $admin_type == 1):?>
                                      <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                          <div class="ui-block" data-mh="friend-groups-item">                
                                            <div class="friend-item friend-groups">
                                                <div class="friend-item-content">        
                                                  <div class="friend-avatar">
                                                      <div class="author-thumb">
                                                        <img src="<?php echo base_url();?>uploads/icons/students.svg" width="110px" style="background-color:#fff;padding:15px; border-radius:0px;">
                                                      </div>
                                                      <div class="author-content">
                                                        <a href="<?php echo base_url();?>admin/students/" class="h5 author-name"><?php echo get_phrase('students');?></a>
                                                        <div class="country"><?php echo $this->db->count_all_results('student');?> <?php echo get_phrase('students');?></div>
                                                      </div>
                                                  </div>
                                                </div>
                                            </div>        
                                          </div>
                                      </div>
                                      <?php endif;?>
                                      <?php if($this->db->get_where('account_role', array('type' => 'parents'))->row()->permissions == 1 || $admin_type == 1):?>
                                      <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                          <div class="ui-block" data-mh="friend-groups-item">        
                                            <div class="friend-item friend-groups">        
                                                <div class="friend-item-content">        
                                                  <div class="friend-avatar">
                                                      <div class="author-thumb">
                                                        <img src="<?php echo base_url();?>uploads/icons/parents.svg" width="110px" style="background-color:#fff;padding:15px; border-radius:0px;">
                                                      </div>
                                                      <div class="author-content">
                                                        <a href="<?php echo base_url();?>admin/parents/" class="h5 author-name"><?php echo get_phrase('parents');?></a>
                                                        <div class="country"><?php echo $this->db->count_all_results('parent');?> <?php echo get_phrase('parents');?></div>
                                                      </div>
                                                  </div>
                                                </div>
                                            </div>
                                          </div>
                                      </div>
                                      <?php endif;?>
                                      <?php if($this->db->get_where('account_role', array('type' => 'accountants'))->row()->permissions == 1 || $admin_type == 1):?>
                                      <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                          <div class="ui-block" data-mh="friend-groups-item">        
                                            <div class="friend-item friend-groups">        
                                                <div class="friend-item-content">        
                                                  <div class="friend-avatar">
                                                      <div class="author-thumb">
                                                        <img src="<?php echo base_url();?>uploads/icons/accountant.svg" width="110px" style="background-color:#fff;padding:15px; border-radius:0px;">
                                                      </div>
                                                      <div class="author-content">
                                                        <a href="<?php echo base_url();?>admin/accountant/" class="h5 author-name"><?php echo get_phrase('accountants');?></a>
                                                        <div class="country">
                                                          <?php echo $this->db->count_all_results('accountant');?> <?php echo get_phrase('accountants');?></div>
                                                      </div>
                                                  </div>
                                                </div>
                                            </div>
                                          </div>
                                      </div>
                                      <?php endif;?>
                                      <?php if($this->db->get_where('account_role', array('type' => 'librarians'))->row()->permissions == 1 || $admin_type == 1):?>
                                      <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                          <div class="ui-block" data-mh="friend-groups-item">        
                                            <div class="friend-item friend-groups">        
                                                <div class="friend-item-content">        
                                                  <div class="friend-avatar">
                                                      <div class="author-thumb">
                                                        <img src="<?php echo base_url();?>uploads/icons/librarian.svg" width="110px" style="background-color:#fff;padding:15px; border-radius:0px;">
                                                      </div>
                                                      <div class="author-content">
                                                        <a href="<?php echo base_url();?>admin/librarian/" class="h5 author-name"><?php echo get_phrase('librarians');?></a>
                                                        <div class="country"><?php echo $this->db->count_all_results('librarian');?> <?php echo get_phrase('librarians');?></div>
                                                      </div>
                                                  </div>
                                                   
                                                </div>
                                            </div>
                                          </div>
                                      </div>
                                      <?php endif;?>
                                      <?php if($this->db->get_where('settings', array('type' => 'register'))->row()->description == 1):?>
                                      <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                          <div class="ui-block" data-mh="friend-groups-item">        
                                            <div class="friend-item friend-groups">        
                                                <div class="friend-item-content">        
                                                  <div class="friend-avatar">
                                                      <div class="author-thumb">
                                                        <img src="<?php echo base_url();?>uploads/icons/pendings.svg" width="110px" style="background-color:#fff;padding:15px; border-radius:0px;">
                                                      </div>
                                                      <div class="author-content">
                                                        <a href="<?php echo base_url();?>admin/pending/" class="h5 author-name"><?php echo get_phrase('pending_users');?></a>
                                                        <div class="country"><?php echo $this->db->count_all_results('pending_users');?> <?php echo get_phrase('pending');?></div>
                                                      </div>
                                                  </div>
                                                </div>
                                            </div>
                                          </div>
                                      </div>
                                      <?php endif;?>
                              </div>
                                  </div>
                                  </div>
                              </div>
                          </div>      
                      </div>  
                    </div>
                </div>  
              </div>
                      </div>
                  </div>
              </div>
            <div class="display-type"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="permisosadmin" tabindex="-1" role="dialog" aria-labelledby="permisosadmin" aria-hidden="true">
  <div class="modal-dialog window-popup edit-my-poll-popup" role="document">
    <div class="modal-content">
    <?php echo form_open(base_url() . 'admin/users/permissions/' , array('enctype' => 'multipart/form-data'));?>
      <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
      <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo get_phrase('admin_permissions');?></h6>
      </div>
      <div class="ui-block-title ui-block-title-small">
        <h6 class="title"><?php echo get_phrase('admin');?></h6>
      </div>
      <div class="modal-body">
        <div class="ui-block-content">
          <div class="row">
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="messages" value="1" <?php if($this->db->get_where('account_role', array('type' => 'messages'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('messages');?>
                </label>
              </div>
          	</div>
          	<div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="admins" value="1" <?php if($this->db->get_where('account_role', array('type' => 'admins'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('admins');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="parents" value="1" <?php if($this->db->get_where('account_role', array('type' => 'parents'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('parents');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="teachers" value="1" <?php if($this->db->get_where('account_role', array('type' => 'teachers'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('teachers');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="students" value="1" <?php if($this->db->get_where('account_role', array('type' => 'students'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('students');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="accountants" value="1" <?php if($this->db->get_where('account_role', array('type' => 'accountants'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('accountants');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="librarians" value="1" <?php if($this->db->get_where('account_role', array('type' => 'librarians'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('librarians');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="library" value="1" <?php if($this->db->get_where('account_role', array('type' => 'library'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('library');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
               <div class="checkbox">
                <label>
                  <input type="checkbox" name="academic" value="1" <?php if($this->db->get_where('account_role', array('type' => 'academic'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('academic');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="attendance" value="1" <?php if($this->db->get_where('account_role', array('type' => 'attendance'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('attendance');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="calendar" value="1" <?php if($this->db->get_where('account_role', array('type' => 'calendar'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('calendar');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="files" value="1" <?php if($this->db->get_where('account_role', array('type' => 'files'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('files');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="polls" value="1" <?php if($this->db->get_where('account_role', array('type' => 'polls'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('polls');?>
                </label>
              </div>
              </div>
             <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="notifications" value="1" <?php if($this->db->get_where('account_role', array('type' => 'notifications'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('notifications');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="admissions" value="1" <?php if($this->db->get_where('account_role', array('type' => 'admissions'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('admissions');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="behavior" value="1" <?php if($this->db->get_where('account_role', array('type' => 'behavior'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('behavior');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="news" value="1" <?php if($this->db->get_where('account_role', array('type' => 'news'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('news');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="school_bus" value="1" <?php if($this->db->get_where('account_role', array('type' => 'school_bus'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('school_bus');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="classrooms" value="1" <?php if($this->db->get_where('account_role', array('type' => 'classrooms'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('classrooms');?>
                </label>
              </div>
              </div>
 				<div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="accounting" value="1" <?php if($this->db->get_where('account_role', array('type' => 'accounting'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('accounting');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
               <div class="checkbox">
                <label>
                  <input type="checkbox" name="schedules" value="1" <?php if($this->db->get_where('account_role', array('type' => 'schedules'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('schedules');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="system_reports" value="1" <?php if($this->db->get_where('account_role', array('type' => 'system_reports'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('system_reports');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="academic_settings" value="1" <?php if($this->db->get_where('account_role', array('type' => 'academic_settings'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('academic_settings');?>
                </label>
              </div>
              </div>
              <div class="col-sm-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="settings" value="1" <?php if($this->db->get_where('account_role', array('type' => 'settings'))->row()->permissions == 1) echo "checked";?>>
                  <?php echo get_phrase('settings');?>
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="ui-block-title ui-block-title-small">
        <h6 class="title"><?php echo get_phrase('super_admin');?></h6>
      </div>
      <div class="modal-body">
        <div class="ui-block-content">
          <div class="row">
          <div class="col-sm-12">
              <?php echo get_phrase('all_permissions');?>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-rounded btn-success btn-lg full-width"><?php echo get_phrase('save');?></button>
      </div>
      <?php echo form_close();?>
    </div>
  </div>
</div>




<script type="text/javascript">
    function get_class_sections(class_id) 
    {
        $.ajax({
            url: '<?php echo base_url();?>admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });
    }
    function get_class_sections2(class_id) 
    {
        $.ajax({
            url: '<?php echo base_url();?>admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder2').html(response);
            }
        });
    }
</script>