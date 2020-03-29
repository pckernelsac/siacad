<?php $time1 = $this->db->get_where('homework', array('homework_code' => $homework_code))->row()->date_end; $time2 = $this->db->get_where('homework', array('homework_code' => $homework_code))->row()->time_end; ?>
<div class="content-w">
    <div class="conty">
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
	  <div class="os-tabs-w menu-shad">
		<div class="os-tabs-controls">
		  <ul class="navs navs-tabs upper">
			<li class="navs-item">
			  <a class="navs-links" href="<?php echo base_url();?>admin/homeworkroom/<?php echo $homework_code;?>/"><i class="os-icon picons-thin-icon-thin-0014_notebook_paper_todo"></i><span><?php echo get_phrase('homework_details');?></span></a>
			</li>
			<li class="navs-item">
			  <a class="navs-links active" href="<?php echo base_url();?>admin/homework_details/<?php echo $homework_code;?>/"><i class="os-icon picons-thin-icon-thin-0100_to_do_list_reminder_done"></i><span><?php echo get_phrase('deliveries');?></span></a>
			</li>
			<li class="navs-item">
			  <a class="navs-links" href="<?php echo base_url();?>admin/homework_edit/<?php echo $homework_code;?>/"><i class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i><span><?php echo get_phrase('edit');?></span></a>
			</li>
		  </ul>
		</div>
	  </div>
  <div class="content-i">
    <div class="content-box">
	<div class="row">	
	<div class="col-sm-12">
		<div class="pipeline white lined-primary">
		  <div class="pipeline-header">
			<h5 class="pipeline-name">
			  <?php echo get_phrase('deliveries');?>
			</h5>
		  </div>
		  <?php echo form_open(base_url() . 'admin/homework/review/' . $homework_code, array('enctype' => 'multipart/form-data')); ?>
			<div class="table-responsive">
                <table class="table table-lightborder">
                  <thead>
                    <tr>
                      <th><?php echo get_phrase('student');?></th>
                      <th><?php echo get_phrase('student_comment');?></th>
					  <th><?php echo get_phrase('delivery_status');?></th>
                      <th><?php echo get_phrase('file_response');?></th>
					  <th><?php echo get_phrase('teacher_comment');?></th>
                      <th style="width:50px"><?php echo get_phrase('mark');?></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $time = $time1. " ".$time2;
                  $homework_details = $this->db->get_where('deliveries', array('homework_code' => $homework_code))->result_array();
                  	foreach($homework_details as $row):
                   ?>
                    <tr>
                      <td style="min-width:170px">
                        <img alt="" src="<?php echo $this->crud_model->get_image_url('student', $row['student_id']); ?>" width="25px" style="border-radius: 10px;margin-right:5px;"> <?php echo $this->crud_model->get_name('student' , $row['student_id']); ?>
                      </td>
                      <td><?php echo $row['student_comment'];?></td>
					  <td>
					  	<?php if($row['date'] > $time):?>
						  	<a class="btn nc btn-rounded btn-sm btn-danger" style="color:white"><?php echo get_phrase('delayed_delivery');?></a>
						<?php endif;?>
						<?php if($row['date'] <= $time):?>
						  	<a class="btn nc btn-rounded btn-sm btn-success" style="color:white"><?php echo get_phrase('on_time');?></a>
						<?php endif;?>
					  </td>
                      <td>
                      	<?php $type = $this->db->get_where('homework', array('homework_code' => $homework_code))->row()->type;?>
                      	<?php if($type == 2 && $row['file_name'] != ""):?>
                        	<a class="btn btn-rounded btn-sm btn-primary" href="<?php echo base_url();?>uploads/homework_delivery/<?php echo $row['file_name'];?>" style="color:white"><i class="os-icon picons-thin-icon-thin-0042_attachment"></i> <?php echo $row['file_name'];?></a>
                        <?php endif;?>
                        <?php if($type == 1 && $row['file_name'] == ""):?>
                        	<a class="btn btn-rounded btn-sm btn-secondary" href="<?php echo base_url();?>admin/single_homework/<?php echo $row['id'];?>" style="color:white"><i class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i> <?php echo get_phrase('view_response');?></a>
                        <?php endif;?>
                      </td>
                      <td>
                        <textarea class="form-control" name="comment[]" rows="1"><?php echo $row['teacher_comment'];?></textarea>
                        <input type="hidden" name="answer_id[]" value="<?php echo $row['id'];?>">
                      </td>
					  <td width="7%">
                        <input class="form-control" required name="mark[]" type="text" value="<?php echo $row['mark'];?>">
                      </td>
                    </tr>
                	<?php endforeach;?>
                  </tbody>
                </table>
                <div class="form-buttons-w text-right">
                  <button class="btn btn-rounded btn-success" type="submit"> <?php echo get_phrase('apply');?></button>
                </div>
                <?php echo form_close();?>
              </div>
		</div>
		</div>
	</div>
</div>
</div>
</div>
</div>