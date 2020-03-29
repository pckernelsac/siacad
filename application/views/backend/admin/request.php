<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
	        <div class="os-tabs-controls">
	            <ul class="navs navs-tabs upper">
		            <li class="navs-item">
		                <a class="navs-links" href="<?php echo base_url();?>admin/request_student/"><i class="os-icon picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i><span><?php echo get_phrase('reports');?></span></a>
		            </li>
		            <li class="navs-item">
		                <a class="navs-links active" href="<?php echo base_url();?>admin/request/"><i class="os-icon picons-thin-icon-thin-0015_fountain_pen"></i><span><?php echo get_phrase('permissions');?></span></a>
		            </li>
	            </ul>
	        </div>
        </div>
        <div class="content-box">
        <div class="os-tabs-w">
			<div class="os-tabs-controls">
			  <ul class="navs navs-tabs upper">
				<li class="navs-item">
				  <a class="navs-links active" data-toggle="tab" href="#students"><?php echo get_phrase('students');?></a>
				</li>
				<li class="navs-item">
				  <a class="navs-links" data-toggle="tab" href="#teachers"><?php echo get_phrase('teachers');?></a>
				</li>
			  </ul>
			</div>
		  </div>
		  <br>
        <div class="tab-content ">
            <div class="tab-pane active" id="students">
            <div class="element-wrapper">
                <h6 class="element-header">
                  <?php echo get_phrase('student_permissions');?>
                </h6>
                <div class="element-box-tp">
                  <div class="table-responsive">
                    <table class="table table-padded">
                      <thead>
                        <tr>
                          <th><?php echo get_phrase('title');?></th>
                          <th><?php echo get_phrase('description');?></th>
                          <th><?php echo get_phrase('student');?></th>
                          <th><?php echo get_phrase('from');?></th>
                          <th><?php echo get_phrase('until');?></th>
                          <th><?php echo get_phrase('status');?></th>
                          <th><?php echo get_phrase('options');?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
        		            $count = 1;
        		            $this->db->order_by('request_id', 'desc');
        		            $requests = $this->db->get('students_request')->result_array();
        		            foreach ($requests as $row) { 
        	            ?> 
                        <tr>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['description'];?></td>
                            <td class="cell-with-media">
                                <img alt="" src="<?php echo $this->crud_model->get_image_url('student', $row['student_id']);?>" style="height: 25px;"><span><?php echo $this->crud_model->get_name('student', $row['student_id']);?></span>
                            </td>
                            <td><a class="badge badge-success" style="color:white"><?php echo $row['start_date']; ?></a></td>
                            <td><a class="badge badge-primary" style="color:white"><?php echo $row['end_date']; ?></a></td>
                            <td>
                                <?php if($row['status'] == 0): ?>
						            <a class="btn nc btn-rounded btn-sm btn-warning" style="color:white"><?php echo get_phrase('pending');?></a>
					            <?php endif;?>
					            <?php if($row['status'] == 1): ?>
						            <a class="btn nc btn-rounded btn-sm btn-success" style="color:white"><?php echo get_phrase('approved');?></a>
					            <?php endif;?>
					            <?php if($row['status'] == 2): ?>
						            <a class="btn nc btn-rounded btn-sm btn-danger" style="color:white"><?php echo get_phrase('rejected');?></a>
					            <?php endif;?>
					       </td>
                            <td class="bolder">
                                <?php if($row['status'] == 0) { ?>
						            <a data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('approve');?>" onClick="return confirm('<?php echo get_phrase('confirm_approval');?>')" href="<?php echo base_url();?>admin/request_student/accept/<?php echo $row['request_id'];?>"><i style="color:gray" class="picons-thin-icon-thin-0154_ok_successful_check"></i></a>
						            <a data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('reject');?>" onClick="return confirm('<?php echo get_phrase('confirm_reject');?>')" href="<?php echo base_url();?>admin/request_student/reject/<?php echo $row['request_id'];?>"><i style="color:gray" class="picons-thin-icon-thin-0153_delete_exit_remove_close"></i></a>
						      <?php } ?>    
						      
						      <a data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('delete');?>" onClick="return confirm('<?php echo get_phrase('confirm_delete');?>')" href="<?php echo base_url();?>admin/request_student/delete/<?php echo $row['code'];?>"><i style="color:gray" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
      </div>
      
      
      
      <div class="tab-pane" id="teachers">
		  <div class="element-wrapper">
                <h6 class="element-header">
                  <?php echo get_phrase('teachers_permissions');?>
                </h6>
                <div class="element-box-tp">
		  <div class="table-responsive">
			<table class="table table-padded">
                      <thead>
                        <tr>
                          <th><?php echo get_phrase('title');?></th>
                          <th><?php echo get_phrase('description');?></th>
                          <th><?php echo get_phrase('teacher');?></th>
                          <th><?php echo get_phrase('from');?></th>
                          <th><?php echo get_phrase('until');?></th>
                          <th><?php echo get_phrase('options');?></th>
                        </tr>
                      </thead>
                      <tbody>
                         <?php
            	            $count = 1;
            	            $this->db->order_by('request_id', 'desc');
            	            $requests = $this->db->get('request')->result_array();
	                        foreach ($requests as $row) {
        	            ?>  
                        <tr>
                          <td><?php echo $row['title'];?></td>
                          <td><?php echo $row['description'];?></td>
                          <td class="cell-with-media">
                            <img alt="" src="<?php echo $this->crud_model->get_image_url('teacher', $row['teacher_id']);?>" style="height: 25px;"><span><?php echo $this->crud_model->get_name('teacher', $row['teacher_id']);?></span>
                          </td>
                          <td><a class="badge badge-success" style="color:white"><?php echo $row['start_date']; ?></a></td>
                          <td><a class="badge badge-primary" style="color:white"><?php echo $row['end_date']; ?></a></td>
                            <td>
                                <?php if($row['status'] == 0): ?>
						            <a class="btn nc btn-rounded btn-sm btn-warning" style="color:white"><?php echo get_phrase('pending');?></a>
					            <?php endif;?>
					            <?php if($row['status'] == 1): ?>
						            <a class="btn nc btn-rounded btn-sm btn-success" style="color:white"><?php echo get_phrase('approved');?></a>
					            <?php endif;?>
					            <?php if($row['status'] == 2): ?>
						            <a class="btn nc btn-rounded btn-sm btn-danger" style="color:white"><?php echo get_phrase('rejected');?></a>
					            <?php endif;?>
					       </td>
                          <td class="bolder">
                                <?php if($row['status'] == 0) { ?>
						            <a data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('approve');?>" onClick="return confirm('<?php echo get_phrase('confirm_approval');?>')" href="<?php echo base_url();?>admin/request/accept/<?php echo $row['request_id'];?>"><i style="color:gray" class="picons-thin-icon-thin-0154_ok_successful_check"></i></a>
						            <a data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('reject');?>" onClick="return confirm('<?php echo get_phrase('confirm_reject');?>')" href="<?php echo base_url();?>admin/request/reject/<?php echo $row['request_id'];?>"><i style="color:gray" class="picons-thin-icon-thin-0153_delete_exit_remove_close"></i></a>
						      <?php } ?>    
						      <a data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('delete');?>" onClick="return confirm('<?php echo get_phrase('confirm_delete');?>')" href="<?php echo base_url();?>admin/request_student/delete/<?php echo $row['code'];?>"><i style="color:gray" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
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
<div class="display-type"></div>
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
</script>

<script type="text/javascript">
    function get_class_students(class_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/get_class_stundets/' + class_id,
            success: function (response)
            {
                jQuery('#students_holder').html(response);
            }
        });
    }
</script>