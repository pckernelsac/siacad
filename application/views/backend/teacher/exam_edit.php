<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<div class="content-w">
          <div class="conty">
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
      <div class="os-tabs-w menu-shad">
        <div class="os-tabs-controls">
          <ul class="navs navs-tabs upper">
            <li class="navs-item">
              <a class="navs-links" href="<?php echo base_url();?>teacher/examroom/<?php echo $online_exam_id;?>/"><i class="os-icon picons-thin-icon-thin-0016_bookmarks_reading_book"></i><span><?php echo get_phrase('exam_details');?></span></a>
            </li>
            <li class="navs-item">
              <a class="navs-links" href="<?php echo base_url();?>teacher/exam_results/<?php echo $online_exam_id;?>/"><i class="os-icon picons-thin-icon-thin-0100_to_do_list_reminder_done"></i><span><?php echo get_phrase('results');?></span></a>
            </li>
            <li class="navs-item">
              <a class="navs-links active" href="<?php echo base_url();?>teacher/exam_edit/<?php echo $online_exam_id;?>/"><i class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i><span><?php echo get_phrase('edit');?></span></a>
            </li>
          </ul>
        </div>
      </div>
  <div class="content-i">
    <div class="content-box">
        <div>
            <div class="pipeline white lined-primary">
<?php
    $online_exam = $this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id))->row_array();
    $sections    = $this->db->get_where('section', array('class_id' => $online_exam['class_id']))->result_array();
    $subjects    = $this->db->get_where('subject', array('class_id' => $online_exam['class_id']))->result_array();
?>
<?php echo form_open(base_url() . 'teacher/online_exams/edit/', array('enctype' => 'multipart/form-data')); ?>
      <div class="row">
       <div class="col-sm-4">
        <div class="form-group">
        <label class="col-form-label" for=""><?php echo get_phrase('title');?></label>
          <div class="input-group">
          <input type="text" class="form-control" name="exam_title" value="<?php echo $online_exam['title']; ?>">
          </div>
        </div>
        </div>
         <div class="col-sm-4">
        <div class="form-group">
        <label class="col-form-label" for=""><?php echo get_phrase('date');?></label>
          <div class="input-group">
          <input type='text' class="datepicker-here" data-position="bottom left" data-language='en' name="exam_date" data-multiple-dates-separator="/" value="<?php echo date('m/d/Y', $online_exam['exam_date']); ?>"/>
          </div>
        </div>
        </div>
         <div class="col-sm-4">
          <div class="form-group">
            <label class="col-form-label" for=""><?php echo get_phrase('start_time');?></label>
            <div class="input-group clockpicker" data-align="top" data-autoclose="true">
              <input type="text" required="" name="time_start" class="form-control" value="<?php echo $online_exam['time_start'];?>">
            </div>
          </div>
        </div>
        <div class="col-sm-4">
        <div class="form-group">
        <label class="col-form-label" for=""><?php echo get_phrase('end_time');?></label>
          <div class="input-group clockpicker" data-align="top" data-autoclose="true">
              <input type="text" required="" name="time_end" class="form-control" value="<?php echo $online_exam['time_end'];?>">
            </div>
        </div>
        </div>

        <div class="col-sm-4">
        <div class="form-group">
        <label class="col-form-label" for=""><?php echo get_phrase('percentage_required');?></label>
          <div class="input-group">
          <input type="text" class="form-control" name="minimum_percentage" value="<?php echo $online_exam['minimum_percentage']; ?>">
          </div>
        </div>
        </div>

        <div class="col-sm-4">
        <div class="form-group">
        <label class="col-form-label" for=""><?php echo get_phrase('description');?></label>
          <div class="input-group">
            <textarea class="form-control" name="instruction" rows="5"><?php echo $online_exam['instruction']; ?></textarea>
          </div>
        </div>
        </div>
        <input type="hidden" value="<?php echo $online_exam['class_id'];?>" name="class_id">
        <input type="hidden" value="<?php echo $online_exam['section_id'];?>" name="section_id">
        <input type="hidden" value="<?php echo $online_exam['subject_id'];?>" name="subject_id">
        <input type="hidden" name="online_exam_id" value="<?php echo $online_exam['online_exam_id']; ?>"/>
        <div class="form-group">
          <div class="col-sm-12" style="text-align: center;">
            <button type="submit" class="btn btn-success"><?php echo get_phrase('update');?></button>
          </div>
        </div>
        </div>
    <?php echo form_close();?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>