<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<div class="content-w">
    <div class="conty">
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
	  <div class="os-tabs-w menu-shad">
		<div class="os-tabs-controls">
		  <ul class="navs navs-tabs upper">
			<li class="navs-item">
			  <a class="navs-links active" href="<?php echo base_url();?>admin/attendance/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo get_phrase('student_attendance');?></span></a>
			</li>
			<li class="navs-item">
			  <a class="navs-links" href="<?php echo base_url();?>admin/teacher_attendance/"><i class="os-icon picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i><span><?php echo get_phrase('teacher_attendance');?></span></a>
			</li>
			<li class="navs-item">
			  <a class="navs-links" href="<?php echo base_url();?>admin/teacher_attendance_report/"><i class="os-icon os-icon picons-thin-icon-thin-0386_graph_line_chart_statistics"></i><span><?php echo get_phrase('teacher_attendance_report');?></span></a>
			</li>
		  </ul>
		</div>
	  </div>
    <div class="content-i">
    	<div class="content-box">
    	<?php echo form_open(base_url() . 'admin/attendance_selector/', array('class' => 'form m-b'));?>
	    <div class="row">
    		<div class="col-sm-3">
		        <div class="form-group label-floating is-select">
                    <label class="control-label"><?php echo get_phrase('class');?></label>
                    <div class="select">
                        <select name="class_id" required onchange="select_section(this.value)">
                            <option value=""><?php echo get_phrase('select');?></option>
                            <?php
    					        $classes = $this->db->get('class')->result_array();
					            foreach($classes as $row):                        
				            ?> 
                            	<option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>    
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
		    </div>
		    <div class="col-sm-3">
    		    <div class="form-group label-floating is-select">
                    <label class="control-label"><?php echo get_phrase('section');?></label>
                    <div class="select">
                        <select name="section_id" required id="section_holder">
                            <option value=""><?php echo get_phrase('select');?></option>
                        </select>
                    </div>
                </div>
		    </div>
		    <div class="col-sm-3">
    		    <div class="form-group label-floating" style="background:#fff;">
                    <label class="control-label"><?php echo get_phrase('date');?></label>
                    <input type='text' class="datepicker-here" data-position="bottom left" data-language='en' value="<?php echo date('m/d/Y');?>" name="timestamp" data-multiple-dates-separator="/"/>
                    <span class="material-input"></span>
                </div>
		    </div>
		    <div class="col-sm-3">
		        <button class="btn btn-success" style="margin-top:10px" type="submit"><?php echo get_phrase('view');?></button>
		    </div>
	    </div>
    	<input type="hidden" name="year" value="<?php echo $running_year;?>">
    	<?php echo form_close();?>
        </div>
    </div>
    </div>
</div>
<script type="text/javascript">
    function select_section(class_id) 
    {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/get_sectionss/' + class_id,
            success:function (response)
            {
                jQuery('#section_holder').html(response);
            }
        });
    }
</script>