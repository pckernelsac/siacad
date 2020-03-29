 <div class="content-w">
       <div class="conty">
           <?php $dat = base64_decode($data);
           $ex = explode('-',$dat);
           ?>
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
  <div class="os-tabs-w menu-shad">
    <div class="os-tabs-controls">
        <ul class="navs navs-tabs upper">
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>teacher/subject_dashboard/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo get_phrase('dashboard');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links active" href="<?php echo base_url();?>teacher/online_exams/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo get_phrase('online_exams');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>teacher/homework/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing"></i><span><?php echo get_phrase('homework');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>teacher/forum/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i><span><?php echo get_phrase('forum');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>teacher/study_material/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i><span><?php echo get_phrase('study_material');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>teacher/upload_marks/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo get_phrase('marks');?></span></a>
          </li>
        </ul>
      </div>
    </div>
  <div class="content-i">
  <div class="content-box">
  <div class="col-lg-12">   
  <div class="back hidden-sm-down" style="margin-top:-20px;margin-bottom:10px">   
  <a href="<?php echo base_url();?>teacher/online_exams/<?php echo $data;?>/"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>  
  </div>  
  <div class="element-wrapper"> 
    <div class="element-box lined-primary shadow">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo get_phrase('new_exam');?></h5>
      </div>
      <br>
      <?php echo form_open(base_url() . 'teacher/create_online_exam/'.$data, array('enctype' => 'multipart/form-data')); ?>
      <div class="row">
       <div class="col-sm-4">
        <div class="form-group">
        <label class="col-form-label" for=""><?php echo get_phrase('title');?></label>
          <div class="input-group">
          <input type="text" class="form-control" name="exam_title" required="">
          </div>
        </div>
        </div>
         <div class="col-sm-4">
        <div class="form-group">
        <label class="col-form-label" for=""><?php echo get_phrase('date');?></label>
          <div class="input-group">
          <input type='text' class="datepicker-here" data-position="top left" data-language='en' name="exam_date" data-multiple-dates-separator="/"/>
          </div>
        </div>
        </div>
         <div class="col-sm-4">
          <div class="form-group">
            <label class="col-form-label" for=""><?php echo get_phrase('start_time');?></label>
            <div class="input-group clockpicker" data-align="top" data-autoclose="true">
              <input type="text" required="" name="time_start" class="form-control">
            </div>
          </div>
        </div>
        <div class="col-sm-4">
        <div class="form-group">
        <label class="col-form-label" for=""><?php echo get_phrase('end_time');?></label>
          <div class="input-group clockpicker" data-align="top" data-autoclose="true">
              <input type="text" required="" name="time_end" class="form-control">
            </div>
        </div>
        </div>

        <div class="col-sm-4">
        <div class="form-group">
        <label class="col-form-label" for=""><?php echo get_phrase('percentage_required');?></label>
          <div class="input-group">
          <input type="text" class="form-control" name="minimum_percentage">
          </div>
        </div>
        </div>

        <div class="col-sm-4">
        <div class="form-group">
        <label class="col-form-label" for=""><?php echo get_phrase('description');?></label>
          <div class="input-group">
            <textarea class="form-control" name="instruction" rows="5"></textarea>
          </div>
        </div>
        </div>
        <input type="hidden" value="<?php echo $ex[0];?>" name="class_id">
        <input type="hidden" value="<?php echo $ex[1];?>" name="section_id">
        <input type="hidden" value="<?php echo $ex[2];?>" name="subject_id">
        <div class="form-group">
          <div class="col-sm-12" style="text-align: center;">
            <button type="submit" class="btn btn-success"><?php echo get_phrase('save');?></button>
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