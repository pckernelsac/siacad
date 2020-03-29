<?php $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
          <div class="conty">
	<div class="content-i">
	 <div class="content-box">
	<div class="os-tabs-w">
			<div class="os-tabs-controls">
			  <ul class="navs navs-tabs upper">
			  	<?php 
			  	$n = 1;
			  	$children_of_parent = $this->db->get_where('student' , array('parent_id' => $this->session->userdata('parent_id')))->result_array();
                   foreach ($children_of_parent as $row):
                    ?>
                    <li class="navs-item">
                    	<?php $active = $n++;?>
				  		<a class="navs-links <?php if($active == 1) echo 'active';?>" data-toggle="tab" href="#<?php echo $row['username'];?>"><img alt="" src="<?php echo $this->crud_model->get_image_url('student', $row['student_id']);?>" width="25px" style="border-radius: 25px;margin-right:5px;"> <?php echo $this->crud_model->get_name('student', $row['student_id']);?></a>
					</li>
                <?php endforeach; ?>
			  </ul>
			</div>
		  </div>
      	  <div class="tab-content">
      	  	<?php 
			  	$n = 1;
			  	$children_of_parent = $this->db->get_where('student' , array('parent_id' => $this->session->userdata('parent_id')))->result_array();
                foreach ($children_of_parent as $row2):
                $class_id = $this->db->get_where('enroll' , array('student_id' => $row2['student_id'] , 'year' => $running_year))->row()->class_id;
	    		$section_id = $this->db->get_where('enroll' , array('student_id' => $row2['student_id'] , 'year' => $running_year))->row()->section_id;
            ?>
        	<?php $active = $n++;?>
	 		<div class="tab-pane <?php if($active == 1) echo 'active';?>" id="<?php echo $row2['username'];?>">
			 <div class="element-wrapper">
                <table class="table table-padded">
                      <thead>
                        <tr>
                          <th><?php echo get_phrase('priority');?></th>
                          <th><?php echo get_phrase('date');?></th>
                          <th><?php echo get_phrase('created_by');?></th>
                          <th><?php echo get_phrase('student');?></th>
                          <th><?php echo get_phrase('class');?></th>
                          <th><?php echo get_phrase('section');?></th>
                          <th><?php echo get_phrase('title');?></th>
                          <th><?php echo get_phrase('options');?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $reports = $this->db->get_where('reports', array('student_id' => $row2['student_id']))->result_array();
                    foreach($reports as $row):
                ?>
				        <?php $user = $row['user_id'];
                            $re = explode('-', $user);
                        ?>
                        <tr>
                            <td>
                              <?php if($row['priority'] == 'alta'):?>
                                <span class="status-pill red"></span><span><?php echo get_phrase('high');?></span>
                              <?php endif;?>
                              <?php if($row['priority'] == 'media'):?>
                                <span class="status-pill yellow"></span><span><?php echo get_phrase('medium');?></span>
                              <?php endif;?>
                              <?php if($row['priority'] == 'baja'):?>
                                <span class="status-pill green"></span><span><?php echo get_phrase('low');?></span>
                              <?php endif;?>
                            </td>
                            <td><span><?php echo $row['date'];?></span></td>
                            <td class="cell-with-media">
                                <img alt="" src="<?php echo $this->crud_model->get_image_url($re[0], $re[1]);?>" style="height: 25px;"><span><?php echo $this->crud_model->get_name($re[0], $re[1]);?></span>
                            </td>
                            <td class="cell-with-media">
                                <img alt="" src="<?php echo $this->crud_model->get_image_url('student', $row['student_id']);?>" style="height: 25px;"><span> <?php echo $this->crud_model->get_name('student', $row['student_id']);?></span>
                            </td>
                            <td><a class="badge badge-primary" href="javascript:void(0);"><?php echo $this->db->get_where('class', array('class_id' => $row['class_id']))->row()->name;?></a></td>
                            <td><a class="badge badge-success" href="javascript:void(0);"><?php echo $this->db->get_where('section', array('section_id' => $row['section_id']))->row()->name;?></a></td>
                            <td><?php echo $row['title'];?></td>
                            <td class="bolder">
                                <a href="<?php echo base_url();?>parents/view_report/<?php echo $row['code'];?>/" style="color:grey;"><i style="font-size:20px;" class="picons-thin-icon-thin-0012_notebook_paper_certificate" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('view_details');?>"></i></a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
			          </div>
				</div>  
				<?php endforeach;?>
			</div>
		</div>
	</div>
</div>
</div>