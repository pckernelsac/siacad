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
															<img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" style="background-color: #fff; padding:10px;">
														</div>
														<div class="author-content">
															<a href="javascript:void(0);" class="h3 author-name"><?php echo get_phrase('pending_users');?></a>
															<div class="country"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>  |  <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?></div>
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
                    									<div class="col-sm-12">                           
															    <div class="element-wrapper">
                    <div class="element-box-tp">
                  <div class="table-responsive">
                    <table class="table table-padded">
                        <thead>
                          <tr>
                            <th><?php echo get_phrase('name');?></th>
              <th><?php echo get_phrase('username');?></th>
              <th><?php echo get_phrase('email');?></th>
              <th><?php echo get_phrase('account_type');?></th>
              <th><?php echo get_phrase('options');?></th>
                          </tr>
                        </thead>
                          <tbody>
                          <?php $pending_users = $this->db->get('pending_users')->result_array();
		  	foreach($pending_users as $row):
		  ?>
                          <tr>
                            <td><?php echo $row['first_name']." ".$row['last_name'];?></td>
                            <td><?php echo $row['username'];?></td>
                            <td><?php echo $row['email'];?></td>
                            <td>
                                <div class="pt-btn">
                  	                <?php if($row['type'] == 'student'):?>
						                <a class="btn nc btn-sm btn-rounded btn-secondary" href="#"><?php echo get_phrase('student');?></a>
					                <?php endif;?>
					                <?php if($row['type'] == 'parent'):?>
						                <a class="btn nc btn-sm btn-rounded btn-purple" href="#"><?php echo get_phrase('parent');?></a>
					                <?php endif;?>
					                <?php if($row['type'] == 'admin'):?>
		  				                <a class="btn nc btn-sm btn-rounded btn-primary" href="#"><?php echo get_phrase('admin');?></a>
					                <?php endif;?>
					                <?php if($row['type'] == 'teacher'):?>
						                <a class="btn nc btn-sm btn-rounded btn-success" href="#"><?php echo get_phrase('teacher');?></a>
					                <?php endif;?>
                                </div>
                            </td>
                            <td>
              		            <?php if($row['type'] == 'student'):?>
						        <a href="<?php echo base_url();?>admin/student/accept/<?php echo $row['user_id'];?>" onClick="return confirm('<?php echo get_phrase('confirm_approval');?>')"><button class="btn btn-primary btn-rounded btn-sm"><?php echo get_phrase('accept');?></button></a>
					        <?php endif;?>
					        <?php if($row['type'] == 'parent'):?>
						        <a href="<?php echo base_url();?>admin/parents/accept/<?php echo $row['user_id'];?>" onClick="return confirm('<?php echo get_phrase('confirm_approval');?>')"><button class="btn btn-primary btn-rounded btn-sm"><?php echo get_phrase('accept');?></button></a>
					        <?php endif;?>
					        <?php if($row['type'] == 'teacher'):?>
						        <a href="<?php echo base_url();?>admin/teachers/accept/<?php echo $row['user_id'];?>" onClick="return confirm('<?php echo get_phrase('confirm_approval');?>')"><button class="btn btn-primary btn-rounded btn-sm"><?php echo get_phrase('accept');?></button></a>
					        <?php endif;?>
                	<a href="<?php echo base_url();?>admin/admissions/reject/<?php echo $row['user_id'];?>" onClick="return confirm('<?php echo get_phrase('confirm_reject');?>')"><button class="btn btn-danger btn-rounded btn-sm"><?php echo get_phrase('reject');?></button></a>
              </td>
                          </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
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
              </div>
            </div>
          <div class="display-type"></div>
      </div>
  </div>
</div>