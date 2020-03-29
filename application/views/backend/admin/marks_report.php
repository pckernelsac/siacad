<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;?>
		<div class="content-w">
		        <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
			<div class="os-tabs-w menu-shad">
		<div class="os-tabs-controls">
			<ul class="navs navs-tabs">
				<li class="navs-item">
				  <a class="navs-links" href="<?php echo base_url();?>admin/general_reports/"><i class="picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i> <span><?php echo get_phrase('classes');?></span></a>
				</li>
				<li class="navs-item">
				  <a class="navs-links" href="<?php echo base_url();?>admin/students_report/"><i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>  <span><?php echo get_phrase('students');?></span></a>
				</li>
				<li class="navs-item">
				  <a class="navs-links" href="<?php echo base_url();?>admin/attendance_report/"><i class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>  <span><?php echo get_phrase('attendance');?></span></a>
				</li>
				<li class="navs-item">
				  <a class="navs-links <?php if($page_name == 'marks_report') echo "active";?>" href="<?php echo base_url();?>admin/marks_report/"><i class="picons-thin-icon-thin-0100_to_do_list_reminder_done"></i>  <span><?php echo get_phrase('final_marks');?></span></a>
				</li>
				<li class="navs-item">
				  <a class="navs-links" href="<?php echo base_url();?>admin/tabulation_report/"><i class="picons-thin-icon-thin-0070_paper_role"></i> <span><?php echo get_phrase('tabulation_sheet');?></span></a>
				</li>
				<li class="navs-item">
				  <a class="navs-links" href="<?php echo base_url();?>admin/accounting_report/"><i class="picons-thin-icon-thin-0406_money_dollar_euro_currency_exchange_cash"></i>  <span><?php echo get_phrase('accounting');?></span></a>
				</li>
			 </ul>
		</div>
	</div>
  			<div class="content-i">
	    		<div class="content-box">
	  				<h5 class="form-header"><?php echo get_phrase('student_card');?></h5><hr>
	  				<?php echo form_open(base_url() . 'admin/marks_report/', array('class' => 'form m-b'));?>
	  				<div class="row">
						<div class="col-sm-3">
						    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('class');?></label>
                            <div class="select">
                                <select name="class_id" required="" onchange="get_class_sections(this.value)">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php 
                                        $class = $this->db->get('class')->result_array();
                                        foreach ($class as $row): ?>
                                        <option value="<?php echo $row['class_id']; ?>" <?php if($class_id == $row['class_id']) echo "selected";?>><?php echo $row['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
					</div>
					<div class="col-sm-3">
					     <div class="form-group label-floating is-select">
                                    <label class="control-label"><?php echo get_phrase('section');?></label>
                                    <div class="select">
                                        <?php if($section_id == ""):?>
		  								<select name="section_id" required id="section_holder" onchange="get_student(this.value)">
            								<option value=""><?php echo get_phrase('select');?></option>
										</select>
									<?php else:?>
										<select name="section_id" required id="section_holder" onchange="get_student(this.value)">
	            							<option value=""><?php echo get_phrase('select');?></option>
            								<?php 
            									$sections = $this->db->get_where('section', array('class_id' => $class_id))->result_array();
            									foreach ($sections as $key):
            								?>
	            								<option value="<?php echo $key['section_id'];?>" <?php if($section_id == $key['section_id']) echo "selected";?>><?php echo $key['name'];?></option>
            								<?php endforeach;?>
										</select>
									<?php endif;?>
                                </div>
                            </div>
					</div>
					<div class="col-sm-3">
					    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('student');?></label>
                            <div class="select">
                                <?php if($student_id == ""):?>
		  								<select name="student_id" required id="student_holder">
            								<option value=""><?php echo get_phrase('select');?></option>
										</select>
									<?php else:?>
										<select name="student_id" required id="student_holder">
	            							<option value=""><?php echo get_phrase('select');?></option>
            								<?php 
            									$students = $this->db->get_where('enroll', array('class_id' => $class_id))->result_array();
            									foreach ($students as $key):
            								?>
	            								<option value="<?php echo $key['student_id'];?>" <?php if($student_id == $key['student_id']) echo "selected";?>><?php echo $this->crud_model->get_name('student', $key['student_id']);?></option>
            								<?php endforeach;?>
										</select>
									<?php endif;?>
                            </div>
                        </div>
					</div>
					<div class="col-sm-2">
					    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('semester');?></label>
                            <div class="select">
                                <select name="exam_id" required>
            					<option value=""><?php echo get_phrase('select');?></option>
            					<?php $exam = $this->db->get('exam')->result_array();
            						foreach($exam as $row):
            					?>
            						<option value="<?php echo $row['exam_id'];?>" <?php if($exam_id == $row['exam_id']) echo "selected";?>><?php echo $row['name'];?></option>
            					<?php endforeach;?>
							</select>
                            </div>
                        </div>
					</div>
					<div class="col-sm-1">
		  				<div class="form-group"> 
			  				<button class="btn btn-success btn-upper" style="margin-top:20px" type="submit"><i class="picons-thin-icon-thin-0154_ok_successful_check"></i></button>
		  				</div>
					</div>
					
	  			</div><hr>
	  			<?php echo form_close();?>
	  			<?php if($class_id != "" && $section_id != "" && $student_id != "" && $exam_id != ""):?>
					<div class="element-wrapper">
        				<div class="rcard-w">
          					<div class="infos">
            					<div class="info-1">
              						<div class="rcard-logo-w">
                						<img alt="" src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>">
              						</div>
              						<div class="company-name"><?php echo $system_name;?></div>
              						<div class="company-address"><?php echo get_phrase('marks');?></div>
              						<div class="company-address"><?php echo $this->db->get_where('exam', array('exam_id' => $exam_id))->row()->name;?></div>
            					</div>
            					<div class="info-2">
            						<div class="rcard-profile">
            							<img alt="" src="<?php echo $this->crud_model->get_image_url('student', $student_id);?>">
            						</div>
              						<div class="company-name"><?php echo $this->crud_model->get_name('student', $student_id);?></div>
              						<div class="company-address">
                						<?php echo get_phrase('roll');?>: <?php echo $this->db->get_where('enroll', array('student_id' => $student_id))->row()->roll;?><br/><?php echo $this->db->get_where('class', array('class_id' => $class_id))->row()->name;?><br/><?php echo $this->db->get_where('section' , array('class_id' => $class_id))->row()->name;?>
              						</div>
            					</div>
          					</div>
          					<div class="rcard-heading">
            					<h5><?php echo $exam_name;?></h5>
            					<div class="rcard-date"><?php echo $class_name;?></div>
          					</div>
            				<div class="rcard-table table-responsive">
              					<table class="table">
                					<thead>
                  						<tr>
                    						<th class="text-center"><?php echo get_phrase('subject');?></th>
                    						<th class="text-center"><?php echo get_phrase('teacher');?></th>
                    						<th class="text-center"><?php echo get_phrase('mark');?></th>
                  						</tr>
                					</thead>
                				<tbody>
                 				<?php 
                    				$exams = $this->crud_model->get_exams();
                    				$subjects = $this->db->get_where('subject' , array('class_id' => $class_id))->result_array();
                    				foreach ($subjects as $row3):
                    				$mark = $this->db->get_where('mark' , array('student_id' => $student_id,'subject_id' => $row3['subject_id'], 'class_id' => $class_id, 'exam_id' => $exam_id, 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description));    
                    				if($mark->num_rows() > 0) 
                    				{
                        				$marks = $mark->result_array();
                    				}                
                    				foreach ($marks as $row4):
                    			?>
                    			<tr>
                        			<td><?php echo $row3['name'];?></td>
                        			<td><?php echo $this->crud_model->get_name('teacher', $row3['teacher_id']);?></td>
                        			<td class="text-center"><?php echo $this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'exam_id' => $exam_id, 'student_id'=> $student_id,'year' => $running_year))->row()->labtotal; ?></td>
                    			</tr>
                    			<?php endforeach; endforeach; ?>
                			</tbody>
              			</table>
          			</div>
          			<div class="rcard-footer">
            			<div class="rcard-logo">
	              			<img alt="" src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>"><span><?php echo $system_name;?></span>
            			</div>
            			<div class="rcard-info">
              				<span><?php echo $system_email;?></span><span><?php echo $phone;?></span>
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
 
<script type="text/javascript">
    function get_class_sections(class_id) 
    {
        $.ajax({
            url: '<?php echo base_url();?>admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_holder').html(response);
            }
        });
    }
</script>

<script type="text/javascript">
    function get_student(section_id) 
    {
        $.ajax({
            url: '<?php echo base_url();?>admin/get_class_students/' + section_id ,
            success: function(response)
            {
                jQuery('#student_holder').html(response);
            }
        });
    }
</script>