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
                        <?php $sections = $this->db->get_where('section', array('class_id' => $class_id))->result_array();
                            foreach ($sections as $row): ?>
                            <option value="<?php echo $row['section_id']; ?>" 
                                <?php if ($section_id == $row['section_id']) echo 'selected'; ?>>
                                <?php echo $row['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
		</div>
		<div class="col-sm-3">
		    <div class="form-group label-floating" style="background:#fff;">
                <label class="control-label"><?php echo get_phrase('date');?></label>
                <input type='text' class="datepicker-here" data-position="bottom left" data-language='en' name="timestamp" data-multiple-dates-separator="/" value="<?php echo date("m/d/Y", $timestamp); ?>"/>
                <span class="material-input"></span>
            </div>
		</div>
        <div class="col-sm-3">
		  <button class="btn btn-success" style="margin-top:10px" type="submit"><?php echo get_phrase('update');?></button>
		</div>
      </div>
      <input type="hidden" name="year" value="<?php echo $running_year;?>">
    <?php echo form_close();?>
    
    <?php if($section_id > 0 && $class_id > 0):?>
    <div class="ui-block">
                <article class="hentry post thumb-full-width">                
                  <div class="post__author author vcard inline-items">
                    <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" style="border-radius:0px;">                
                    <div class="author-date">
                      <a class="h6 post__author-name fn" href="javascript:void(0);"><?php echo get_phrase('attendance');?> <small>(<?php echo date("m/d/Y", $timestamp); ?>)</small>.</a>
                    </div>                
                  </div>                
                  <div class="edu-posts cta-with-media">
                    <?php echo form_open(base_url() . 'admin/attendance_update/' . $class_id . '/' . $section_id . '/' . $timestamp); ?>
      <div class="table-responsive">
        <table class="table table-lightborder table-bordered">
          <thead>
            <tr style="background:#0061da; color:#fff">
              <th><?php echo get_phrase('student');?></th>
              <th style="text-align: center;"><?php echo get_phrase('status');?></th>
            </tr>
          </thead>
          <tbody>
            <?php
                $count = 1;
                $attendance_of_students = $this->db->get_where('attendance', array(
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'year' => $running_year,
                    'timestamp' => $timestamp
                ))->result_array();
                foreach ($attendance_of_students as $row):
            ?>
            <tr>
              <td style="min-width:170px;">
                <img alt="" src="<?php echo $this->crud_model->get_image_url('student', $row['student_id']);?>" width="25px" style="border-radius: 10px;margin-right:5px;"> <?php echo $this->crud_model->get_name('student', $row['student_id']);?>
              </td>
              <td style="text-align: center;" nowrap>
                  <span class="radio">
                        <h6 data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('present');?>">
                            <label>
                                <input type="radio" <?php if ($row['status'] == 1) echo 'checked'; ?> value="1" name="status_<?php echo $row['attendance_id']; ?>"><span class="circle"></span><span class="check"></span>
                            </label>
                        </h6>
                    </span>
                    <span class="radio">
                        <h6 data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('late');?>">
                            <label>
                                <input type="radio" <?php if ($row['status'] == 3) echo 'checked'; ?> value="3" name="status_<?php echo $row['attendance_id']; ?>"><span class="circle"></span><span class="check"></span>
                            </label>
                        </h6>
                    </span>
                    <span class="radio">
                        <h6 data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('absent');?>">
                            <label>
                                <input type="radio" value="2" <?php if ($row['status'] == 2) echo 'checked'; ?> name="status_<?php echo $row['attendance_id']; ?>"><span class="circle"></span><span class="check"></span>
                            </label>
                        </h6>
                    </span>
                </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
        <div class="form-buttons-w text-center">
          <button class="btn btn-success btn-rounded" type="submit"><?php echo get_phrase('update');?></button>
        </div>
      </div>
      <?php echo form_close();?>
                  </div>
                </article>
              </div>
    <?php endif;?>
              
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