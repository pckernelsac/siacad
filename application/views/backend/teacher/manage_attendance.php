<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<div class="content-w">
          <div class="conty">
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
	  <div class="os-tabs-w menu-shad">
		<div class="os-tabs-controls">
		  <ul class="navs navs-tabs upper">
			<li class="navs-item">
			  <a class="navs-links active"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo get_phrase('attendance');?></span></a>
			</li>
		  </ul>
		</div>
	  </div>
	   <div class="content-i">
	<div class="content-box">
	<?php echo form_open(base_url() . 'teacher/attendance_selector/', array('class' => 'form m-b'));?>
      <div class="row">
        <div class="col-sm-3">
            <div class="form-group label-floating is-select">
                <label class="control-label"><?php echo get_phrase('class');?></label>
                <div class="select">
                    <select name="class_id" required onchange="select_section(this.value)">
                        <option value=""><?php echo get_phrase('select');?></option>
                         <?php
                            $classes = $this->db->get('class')->result_array();
                            foreach ($classes as $row):?>
                                <option value="<?php echo $row['class_id']; ?>"
                            <?php if ($class_id == $row['class_id']) echo 'selected'; ?>><?php echo $row['name']; ?></option>
                        <?php endforeach; ?>
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
                <input type='text' class="datepicker-here" data-position="bottom left" value="<?php echo date("m/d/Y"); ?>" data-language='en' name="timestamp" data-multiple-dates-separator="/"/>
                <span class="material-input"></span>
            </div>
		</div>
        <div class="col-sm-3">
		  <button class="btn btn-success" style="margin-top:10px" type="submit"><?php echo get_phrase('update');?></button>
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