<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
      <div class="conty">
        <div class="os-tabs-w menu-shad">
          <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
              <li class="navs-item">
                <a class="navs-links active" href="<?php echo base_url();?>admin/system_settings/"><i class="os-icon picons-thin-icon-thin-0050_settings_panel_equalizer_preferences"></i><span><?php echo get_phrase('system_settings');?></span></a>
              </li>
              <li class="navs-item">
                <a class="navs-links" href="<?php echo base_url();?>admin/sms/"><i class="os-icon picons-thin-icon-thin-0287_mobile_message_sms"></i><span><?php echo get_phrase('sms');?></span></a>
              </li>
              <li class="navs-item">
                <a class="navs-links" href="<?php echo base_url();?>admin/email/"><i class="os-icon picons-thin-icon-thin-0315_email_mail_post_send"></i><span><?php echo get_phrase('email_settings');?></span></a>
              </li>
              <li class="navs-item">
                <a class="navs-links" href="<?php echo base_url();?>admin/translate/"><i class="os-icon picons-thin-icon-thin-0307_chat_discussion_yes_no_pro_contra_conversation"></i><span><?php echo get_phrase('translate');?></span></a>
              </li>
              <li class="navs-item">
                <a class="navs-links" href="<?php echo base_url();?>admin/database/"><i class="picons-thin-icon-thin-0356_database"></i><span><?php echo get_phrase('database');?></span></a>
              </li>
            </ul>
          </div>
        </div><br>
        <div class="all-wrapper no-padding-content solid-bg-all">
            <div class="layout-w">
              <div class="content-w">
                  <div class="content-i">
                    <div class="content-box">
                      <?php echo form_open(base_url() . 'admin/system_settings/do_update');?>
                      <div class="col-sm-12">
                        <div class="element-box lined-primary shadow" style="border-radius:10px;">
                          <h4 class="form-header"><?php echo get_phrase('system_settings');?></h4><br>
                          <div class="row">   
                            <div class="col-sm-6">
                              <div class="form-group label-floating">
                                <label class="control-label"><?php echo get_phrase('system_name');?></label>
                                <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>" type="text" name="system_name" required="">
                                <span class="material-input"></span>
                              </div>
                            </div>
                            <div class="col-sm-6"> 
                              <div class="form-group label-floating">
                                <label class="control-label"><?php echo get_phrase('system_title');?></label>
                                <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?>" type="text" name="system_title" required="">
                                <span class="material-input"></span>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group label-floating">
                                <label class="control-label"><?php echo get_phrase('system_email');?></label>
                                <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'system_email'))->row()->description;?>" type="text" name="system_email" required="">
                                <span class="material-input"></span>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group label-floating">
                                <label class="control-label"><?php echo get_phrase('system_phone');?></label>
                                <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description;?>" type="text" name="phone" required="">
                                        <span class="material-input"></span>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group label-floating">
                                <label class="control-label"><?php echo get_phrase('address');?></label>
                                <textarea class="form-control" name="address"><?php echo $this->db->get_where('settings', array('type' => 'address'))->row()->description;?></textarea>
                                <span class="material-input"></span>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="description-toggle">
                                <div class="description-toggle-content">
                                  <div class="h6"><?php echo get_phrase('allow_user_register');?></div>
                                  <p><?php echo get_phrase('user_register_message');?></p>
                                </div>          
                                <div class="togglebutton">
                                  <label><input name="register" value="1" type="checkbox" <?php if($this->db->get_where('settings', array('type' => 'register'))->row()->description == 1) echo "checked";?>></label>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group label-floating is-select">
                                <label class="control-label"><?php echo get_phrase('language');?></label>
                                <div class="select">
                                  <select name="language" required="">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php $fields = $this->db->list_fields('language');
                                        foreach ($fields as $field)
                                        {
                                          if ($field == 'phrase_id' || $field == 'phrase') continue;
                                          $current_default_language = $this->db->get_where('settings' , array('type'=>'language'))->row()->description; ?>
                                        <option value="<?php echo $field;?>"<?php if ($current_default_language == $field) echo 'selected';?>> <?php echo $field;?> </option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group label-floating is-select">
                                <label class="control-label"><?php echo get_phrase('timezone');?></label>
                                <div class="select">
                                  <select name="timezone" required="">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php foreach($this->crud_model->tz_list() as $t) { ?>
                                        <option value="<?php echo $t['zone'] ?>" <?php if($this->db->get_where('settings', array('type' => 'timezone'))->row()->description == $t['zone']) echo "selected";?>><?php echo $t['diff_from_GMT'] . ' - ' . $t['zone'] ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group label-floating is-select">
                                <label class="control-label"><?php echo get_phrase('running_year');?></label>
                                <div class="select">
                                  <select name="running_year" required="">
                                    <?php $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;?>
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php for($i = 0; $i < 10; $i++):?>
                                      <option value="<?php echo (2016+$i);?>-<?php echo (2016+$i+1);?>"
                                        <?php if($running_year == (2016+$i).'-'.(2016+$i+1)) echo 'selected';?>><?php echo (2016+$i);?>-<?php echo (2016+$i+1);?>
                                      </option>
                                    <?php endfor;?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group label-floating">
                                <label class="control-label"><?php echo get_phrase('currency');?></label>
                                <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'currency'))->row()->description;?>" type="text" name="currency" required="">
                                <span class="material-input"></span>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group label-floating">
                                <label class="control-label"><?php echo get_phrase('paypal_email');?></label>
                                <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'paypal_email'))->row()->description;?>" type="text" name="paypal_email" required="">
                                <span class="material-input"></span>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group label-floating">
                                <label class="control-label">Facebook</label>
                                <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'facebook'))->row()->description;?>" type="text" name="facebook">
                                <span class="material-input"></span>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group label-floating">
                                <label class="control-label">Twitter</label>
                                <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'twitter'))->row()->description;?>" type="text" name="twitter">
                                <span class="material-input"></span>
                              </div>
                            </div>  
                            <div class="col-sm-6">
                              <div class="form-group label-floating">
                                <label class="control-label">Instagram</label>
                                <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'instagram'))->row()->description;?>" type="text" name="instagram">
                                <span class="material-input"></span>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group label-floating">
                                <label class="control-label">YouTube</label>
                                <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'youtube'))->row()->description;?>" type="text" name="youtube">
                                <span class="material-input"></span>
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div style="float:right;">
                                <button class="btn btn-primary btn-rounded pull-right" type="submit"> <?php echo get_phrase('update');?></button>
                              </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close();?>

                    <div class="element-box lined-success shadow" style="border-radius:10px;">
                      <?php echo form_open(base_url() . 'admin/social/login');?>
                      <h4 class="form-header"><?php echo get_phrase('social_login');?></h4><br>
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="description-toggle">
                              <div class="description-toggle-content">
                                <div class="h6"><?php echo get_phrase('enable_social_login');?></div>
                                <p><?php echo get_phrase('social_login_message');?></p>
                              </div>          
                              <div class="togglebutton">
                                <label><input name="social_login" value="1" type="checkbox" <?php if($this->db->get_where('settings', array('type' => 'social_login'))->row()->description == 1) echo "checked";?>></label>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group label-floating">
                              <label class="control-label">Google Client ID</label>
                              <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'google_sync'))->row()->description;?>" type="text" name="google_sync">
                              <span class="material-input"></span>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group label-floating">
                              <label class="control-label">Google Secret</label>
                              <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'google_login'))->row()->description;?>" type="text" name="google_login">
                              <span class="material-input"></span>
                            </div>
                          </div>
                          <div class="col-sm-12">
                            <div class="form-group label-floating">
                              <label class="control-label">Facebook Sync UR</label>
                              <input class="form-control" value="<?php echo base_url();?>auth/facebook/" type="text" readonly>
                              <span class="material-input"></span>
                            </div>
                          </div>
                          <div class="col-sm-12">
                            <div class="form-group label-floating">
                              <label class="control-label">Facebook Login URL</label>
                              <input class="form-control" value="<?php echo base_url();?>auth/loginfacebook/" type="text" readonly>
                              <span class="material-input"></span>
                            </div>
                          </div>
                          <div class="col-sm-12">
                            <div class="form-group label-floating">
                              <label class="control-label">Google Sync URL</label>
                              <input class="form-control" value="<?php echo base_url();?>auth/sync/" type="text" readonly>
                              <span class="material-input"></span>
                            </div>
                          </div>
                          <div class="col-sm-12">
                            <div class="form-group label-floating">
                              <label class="control-label">Google Login URL</label>
                              <input class="form-control" value="<?php echo base_url();?>auth/login/" type="text" readonly>
                              <span class="material-input"></span>
                            </div>
                          </div>    
                          <div class="col-sm-12">
                            <button class="btn btn-primary btn-rounded pull-right" type="submit"> <?php echo get_phrase('update');?></button>
                          </div>
                        <div>
                      </div>
                    </div>
                    <?php echo form_close();?>
                  </div>

                  <div class="element-box lined-purple shadow" style="border-radius:10px;">
                    <h4 class="form-header"><i class="os-icon picons-thin-icon-thin-0688_paint_bucket_color"></i> <?php echo get_phrase('personalization');?></h4><br>
                    <?php echo form_open(base_url() . 'admin/system_settings/skin', array('enctype' => 'multipart/form-data'));?>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="control-label"><?php echo get_phrase('logo');?></label>
                            <input class="form-control" type="file" name="userfile">
                            <span class="material-input"></span>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="control-label"><?php echo get_phrase('logo_white');?></label>
                            <input class="form-control" type="file" name="logow">
                            <span class="material-input"></span>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="control-label"><?php echo get_phrase('icon_white');?></label>
                            <input class="form-control" type="file" name="icon_white">
                            <span class="material-input"></span>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="control-label"><?php echo get_phrase('favicon');?></label>
                            <input class="form-control" type="file" name="favicon">
                            <span class="material-input"></span>
                          </div>
                        </div>
                      </div>
                      <legend><span><?php echo get_phrase('background');?></span></legend>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <input class="form-control" type="file" name="bglogin">
                            <span class="material-input"></span>
                          </div>
                        </div>
                      </div>
                      <div class="form-buttons-w text-right">
                        <button class="btn btn-purple btn-rounded" type="submit"> <?php echo get_phrase('update');?></button>
                      </div>
                    </div>
                  </div>
                  <?php echo form_close();?> 
                  </div>
                </div>
              </div>
            </div>
          <div class="display-type"></div>
        </div>
    </div>
  </div>