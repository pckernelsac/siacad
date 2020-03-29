<div class="content-w" > 
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
      <div class="conty" >
           <div class="ui-blo ck">
				<div class="top-header top-header-favorit">
					<div class="top-header-thumb">
						<img src="<?php echo base_url();?>uploads/bglogin.jpg" style="height:180px; object-fit:cover;">
						<div class="top-header-author">
							<div class="author-thumb">
								<img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" style="background-color: #fff; padding:10px;">
							</div>
							<div class="author-content">
								<a href="javascript:void(0);" class="h3 author-name"><?php echo get_phrase('your_notifications');?></a>
								<div class="country"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>  |  <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?></div>
							</div>
						</div>
					</div>
					<div class="profile-section">
						<div class="control-block-button">
						</div>
					</div>
				</div>
			</div>
        <div class="container">
	        <div class="row">
		        <div class="col  col-sm-12 col-12">
			        <div class="ui-block">
				        <div class="ui-block-title">
					        <h6 class="title"><?php echo get_phrase('your_notifications');?></h6>
				        </div>
				        <?php 
                            $this->db->order_by('id', desc);
                            $notifications = $this->db->get_where('notification', array('user_id' => $this->session->userdata('login_user_id'), 'user_type' => $this->session->userdata('login_type')));
                            if($notifications->num_rows() > 0):?>
				        <ul class="notification-list">
				            <?php foreach($notifications->result_array() as $notify):?>
					        <li>
						        <div class="author-thumb">
							        <img src="<?php echo base_url();?>uploads/notify.svg">
						        </div>
						        <div class="notification-event">
							        <a href="<?php echo base_url();?><?php echo $notify['url'];?><?php if($notify['status'] == 0) {echo "?id=".$notify['id'];}?>" class="h6 notification-friend"><?php echo $notify['notify'];?></a>
							        <span class="notification-date"><time class="entry-date updated"><?php echo $notify['date'];?> <?php echo get_phrase('at');?> <?php echo $notify['time'];?></time></span>
							        <a onClick="return confirm('<?php echo get_phrase('confirm_delete');?>')" href="<?php echo base_url();?>accountant/notification/delete/<?php echo $notify['id'];?>"><i class="picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full"></i></a>
						        </div>
					        </li>
					        <?php endforeach;?>
				        </ul>
				        <?php else:?>
				            <div class="bg-white" style="padding:55px">
				                <h5><?php echo get_phrase('you_dont_have_notifications');?></h5>
				            </div>
				        <?php endif;?>
			        </div>
		        </div>
	        </div>
        </div>
	</div>
</div>