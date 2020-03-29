<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
      <div class="conty">
        <div class="os-tabs-w menu-shad">
          <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
              <li class="navs-item">
                <a class="navs-links" href="<?php echo base_url();?>admin/system_settings/"><i class="os-icon picons-thin-icon-thin-0050_settings_panel_equalizer_preferences"></i><span><?php echo get_phrase('system_settings');?></span></a>
              </li>
              <li class="navs-item">
                <a class="navs-links active" href="<?php echo base_url();?>admin/sms/"><i class="os-icon picons-thin-icon-thin-0287_mobile_message_sms"></i><span><?php echo get_phrase('sms');?></span></a>
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
                      <div class="col-sm-12">
                       	<?php $status = $this->db->get_where('settings', array('type' => 'sms_status'))->row()->description;?>
														<?php echo form_open(base_url() . 'admin/sms/update', array('class' => 'form m-b'));?>
															<div class="element-box shadow shadow lined-purple" style="border-radius:10px;">
				        										<div class="col-sm-12">
				        										    <div class="form-group label-floating is-select">
                                                                    <label class="control-label"><?php echo get_phrase('sms_service');?></label>
                                                                        <div class="select">
                                                                            <select name="sms_status" onchange="submit();">
                                                                                <option value="deactivate" <?php if($status == 'deactivate') echo 'selected';?>><?php echo get_phrase('disabled');?></option>
					    	                        							<option value="clickatell" <?php if($status == 'clickatell') echo 'selected';?>>Clickatell</option>
                                                    							<option value="twilio" <?php if($status == 'twilio') echo 'selected';?>>Twilio</option>
							                                                    <option value="msg91" <?php if($status == 'android') echo 'selected';?>>MSG91</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                								</div>
                                							<?php echo form_close();?>
                        								</div>
                                
	                								    <div class="row">
		                    									<div class="col-sm-4">
															      <div class="element-box shadow shadow lined-primary" style="border-radius:10px;">
		  															<h3 class="form-header">Clickatell</h3><br>
		  																<?php echo form_open(base_url() . 'admin/sms/clickatell');?>

		  																 <div class="col-sm-12">
                                     										<div class="form-group label-floating">
                                        										<label class="control-label">Clickatell Username</label>
                                        										<input class="form-control" required value="<?php echo $this->db->get_where('settings', array('type' => 'clickatell_username'))->row()->description;?>" type="text" name="clickatell_username" required="">
                                        										<span class="material-input"></span>
                                    										</div>
                                										</div>

                                										<div class="col-sm-12">
                                     										<div class="form-group label-floating">
                                        										<label class="control-label">Clickatell Password</label>
                                        										<input class="form-control" required value="<?php echo $this->db->get_where('settings', array('type' => 'clickatell_password'))->row()->description;?>" type="text" name="clickatell_password" required="">
                                        										<span class="material-input"></span>
                                    										</div>
                                										</div>

                                										<div class="col-sm-12">
                                     										<div class="form-group label-floating">
                                        										<label class="control-label">API ID</label>
                                        										<input class="form-control" required value="<?php echo $this->db->get_where('settings', array('type' => 'clickatell_api'))->row()->description;?>" type="text" name="clickatell_api" required="">
                                        										<span class="material-input"></span>
                                    										</div>
                                										</div>

		   																<div class="form-buttons-w text-right">
            																<button class="btn btn-rounded btn-primary" type="submit"> <?php echo get_phrase('update');?></button>
          																</div>
          															<?php echo form_close();?>
																</div>
															</div>
	
															<div class="col-sm-4">
		      													<div class="element-box shadow lined-danger" style="border-radius:10px;">
		  															<h3 class="form-header">Twilio</h3><br>
		  																<?php echo form_open(base_url() . 'admin/sms/twilio');?>
																		
																		<div class="col-sm-12">
                                     										<div class="form-group label-floating">
                                        										<label class="control-label">Twilio Account SID</label>
                                        										<input class="form-control" required value="<?php echo $this->db->get_where('settings', array('type' => 'twilio_account'))->row()->description;?>" type="text" name="twilio_account" required="">
                                        										<span class="material-input"></span>
                                    										</div>
                                										</div>

                                										<div class="col-sm-12">
                                     										<div class="form-group label-floating">
                                        										<label class="control-label">Authentication Token</label>
                                        										<input class="form-control" required value="<?php echo $this->db->get_where('settings', array('type' => 'authentication_token'))->row()->description;?>" type="text" name="authentication_token" required="">
                                        										<span class="material-input"></span>
                                    										</div>
                                										</div>

                                										<div class="col-sm-12">
                                     										<div class="form-group label-floating">
                                        										<label class="control-label">Registered Phone Number</label>
                                        										<input class="form-control" required value="<?php echo $this->db->get_where('settings', array('type' => 'registered_phone'))->row()->description;?>" type="text" name="registered_phone" required="">
                                        										<span class="material-input"></span>
                                    										</div>
                                										</div>
		   																<div class="form-buttons-w text-right">
            																<button class="btn btn-rounded btn-danger" type="submit"> <?php echo get_phrase('update');?> </button>
          																</div>
          															<?php echo form_close();?>
																</div>
															</div>
		
	
															<div class="col-sm-4">
																<div class="element-box shadow lined-success" style="border-radius:10px;">
		  															<h3 class="form-header">MSG91</h3><br>
																		<?php echo form_open(base_url() . 'admin/sms/msg91');?>

																		<div class="col-sm-12">
                                     										<div class="form-group label-floating">
                                        										<label class="control-label">Authentication Key SID</label>
                                        										<input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'msg91_key'))->row()->description;?>" type="text" name="msg91_key" required="">
                                        										<span class="material-input"></span>
                                    										</div>
                                										</div>
                                										<div class="col-sm-12">
                                     										<div class="form-group label-floating">
                                        										<label class="control-label">Sender ID</label>
                                        										<input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'msg91_sender'))->row()->description;?>" type="text" name="msg91_sender" required="">
                                        										<span class="material-input"></span>
                                    										</div>
                                										</div>
                                										<div class="col-sm-12">
                                     										<div class="form-group label-floating">
                                        										<label class="control-label">Route</label>
                                        										<input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'msg91_route'))->row()->description;?>" type="text" name="msg91_route" required="">
                                        										<span class="material-input"></span>
                                    										</div>
                                										</div>
                                										<div class="col-sm-12">
                                     										<div class="form-group label-floating">
                                        										<label class="control-label">Country Code</label>
                                        										<input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'msg91_code'))->row()->description;?>" type="text" name="msg91_code" required="">
                                        										<span class="material-input"></span>
                                    										</div>
                                										</div>

		   																<div class="form-buttons-w text-right">
            																<button class="btn btn-rounded btn-success" type="submit"> <?php echo get_phrase('update');?> </button>
          																</div>
          															<?php echo form_close();?>
																</div>
															</div>
													</div>
		
		
		<?php echo form_open(base_url() . 'admin/sms/services');?>
                            <div class="element-box lined-primary shadow" style="border-radius:10px;">
                            	<h3 class="form-header"><?php echo get_phrase('notify_send');?></h3><br>
                                <div class="row">   
                                <div class="col-sm-6">
                                	<h4><?php echo get_phrase('for_parents');?></h4>
                                	<hr>
                                    <div class="description-toggle">
    									<div class="description-toggle-content">
										    <div class="h6"><?php echo get_phrase('absences');?></div>
										    <p><?php echo get_phrase('absences_message');?></p>
									    </div>
									    <div class="togglebutton">
    										<label><input name="absences" value="1" type="checkbox" <?php if($this->db->get_where('settings', array('type' => 'absences'))->row()->description == 1) echo "checked";?>></label>
									    </div>
								    </div>
								    <br>
								    <div class="description-toggle">
    									<div class="description-toggle-content">
										    <div class="h6"><?php echo get_phrase('students_reports');?></div>
										    <p><?php echo get_phrase('students_reports_message');?></p>
									    </div>
									    <div class="togglebutton">
    										<label><input name="students_reports" value="1" type="checkbox" <?php if($this->db->get_where('settings', array('type' => 'students_reports'))->row()->description == 1) echo "checked";?>></label>
									    </div>
								    </div>
								    <br>
								    <div class="description-toggle">
    									<div class="description-toggle-content">
										    <div class="h6"><?php echo get_phrase('new_invoice');?></div>
										    <p><?php echo get_phrase('new_invoice_message');?></p>
									    </div>
									    <div class="togglebutton">
    										<label><input name="p_new_invoice" value="1" type="checkbox" <?php if($this->db->get_where('settings', array('type' => 'p_new_invoice'))->row()->description == 1) echo "checked";?>></label>
									    </div>
								    </div>
                                </div>
                                
                                <div class="col-sm-6"> 
                                	<h4><?php echo get_phrase('for_students');?></h4>
                                	<hr>
                                    <div class="description-toggle">
    									<div class="description-toggle-content">
										    <div class="h6"><?php echo get_phrase('new_invoices');?></div>
										    <p><?php echo get_phrase('new_invoice_message');?></p>
									    </div>
					
									    <div class="togglebutton">
    										<label><input name="s_new_invoice" value="1" type="checkbox" <?php if($this->db->get_where('settings', array('type' => 's_new_invoice'))->row()->description == 1) echo "checked";?>></label>
									    </div>
								    </div>
                                </div>
                                <hr>
                                <div class="col-sm-12">
                                    <div style="float:right;">
                                        <button class="btn btn-primary btn-rounded pull-right" type="submit"> <?php echo get_phrase('update');?></button>
                                    </div>
                                </div>
		                    </div>
		                </div>
		                <?php echo form_close();?> 
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <div class="display-type"></div>
        </div>
    </div>
  </div>