<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php $min = $this->db->get_where('academic_settings' , array('type' =>'minium_mark'))->row()->description;?>
<div class="content-w">
     <?php include 'fancy.php';?>
   <div class="header-spacer"></div>
    <div class="conty">
   <div class="content-i">
    <div class="content-box">

<div class="back">		<a href="<?php echo base_url();?>teacher/students_area/"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>	</div>
  <div class="row">
  <?php $student_info = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->result_array(); 
    foreach($student_info as $row): ?>
    <div class="col-sm-12">
      <div class="pipeline white lined-secondary">
        <div class="pipeline-header">
      <h5 class="pipeline-name">
        <?php echo get_phrase('student');?>
      </h5>
      </div>
     <div class="pipeline-item">
      <div class="pi-foot">
      <a class="extra-info" href="javascript:void(0);"><img alt="" src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" width="15%" style="margin-right:5px"><span class="text-white"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?></span></a>
      </div>
      <div class="pi-body">
      <div class="avatar" style="width:75px;">
        <img alt="" width="15%" src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>">
      </div>
      <div class="pi-info">
        <div class="h6 pi-name">
        <?php echo $this->crud_model->get_name('student', $row['student_id']);?><br>
        <small><?php echo get_phrase('roll');?>: <?php echo $row['roll'];?></small>
        </div>
        <div class="pi-sub">
        <?php echo get_phrase('class');?>: <?php echo $this->crud_model->get_class_name($row['class_id']); ?><br>
       <?php echo get_phrase('section');?>: <?php echo $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name; ?>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
<?php endforeach;?>

<?php 
    $student_info = $this->crud_model->get_student_info($student_id);
    $exams         = $this->crud_model->get_exams();
    foreach ($student_info as $row1):
    foreach ($exams as $row2):
?>
  <div class="col-sm-12">
    <div class="element-box lined-primary">
    <h5 class="form-header">
      <?php echo get_phrase('marks');?><br>
    <small><?php echo $row2['name'];?></small>
    </h5>
    <div class="table-responsive">
      <table class="table table-lightborder">
        <thead>
          <tr>
            <th><?php echo get_phrase('subject');?></th>
            <th><?php echo get_phrase('teacher');?></th>
            <th><?php echo get_phrase('mark');?></th>
            <th><?php echo get_phrase('grade');?></th>
            <th><?php echo get_phrase('comment');?></th>
            <th><?php echo get_phrase('view_all');?></th>
          </tr>
        </thead>
        <tbody>
          <?php 
              $subjects = $this->db->get_where('subject' , array('class_id' => $class_id))->result_array();
              foreach ($subjects as $row3): 
                $obtained_mark_query = $this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'exam_id' => $row2['exam_id'],'class_id' => $class_id, 'student_id' => $student_id, 'year' => $running_year));
              if($obtained_mark_query->num_rows() > 0) 
              {
                $marks = $obtained_mark_query->result_array();
              }
              foreach ($marks as $row4):
          ?>
          <tr>
            <td><?php echo $row3['name'];?></td>
            <td><img alt="" src="" width="25px" style="border-radius: 10px;margin-right:5px;"> <?php echo $this->crud_model->get_name('teacher', $row3['teacher_id']);?></td>
            <td>
            <?php $mark = $this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'exam_id' => $row2['exam_id'], 'student_id' => $student_id, 'year' => $running_year))->row()->labtotal;?>
            <?php if($mark < $min || $mark == 0):?>
              <a class="btn nc btn-rounded btn-sm btn-danger" style="color:white"><?php if($this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'exam_id' => $row2['exam_id'], 'student_id' => $student_id, 'year' => $running_year))->row()->labtotal == 0) echo '0'; else echo $mark;?></a>
              <?php endif;?>
              <?php if($mark >= $min):?>
                <a class="btn nc btn-rounded btn-sm btn-info" style="color:white"><?php echo $this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'exam_id' => $row2['exam_id'], 'student_id' => $student_id, 'year' => $running_year))->row()->labtotal;?></a>
              <?php endif;?>
            </td>
            <td><?php echo $grade = $this->crud_model->get_grade($this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'exam_id' => $row2['exam_id'], 'student_id' => $student_id, 'year' => $running_year))->row()->labtotal);?></td>

            <td><?php echo $this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'exam_id' => $row2['exam_id'], 'student_id' => $student_id, 'year' => $running_year))->row()->comment; ?></td>
            <?php $data = base64_encode($row2['exam_id']."-".$student_id."-".$row3['subject_id']); ?>
            <td><a class="btn btn-rounded btn-sm btn-primary" style="color:white" href="<?php echo base_url();?>teacher/subject_marks/<?php echo $data;?>"><?php echo get_phrase('view_all');?></a></td>
          </tr>
            <?php endforeach; endforeach;?>
        </tbody>
      </table>
       <div class="form-buttons-w text-right">
            <a target="_blank" href="<?php echo base_url();?>teacher/marks_print_view/<?php echo $student_id;?>/<?php echo $row2['exam_id'];?>"><button class="btn btn-rounded btn-success" type="submit"><i class="picons-thin-icon-thin-0333_printer"></i>  <?php echo get_phrase('print');?></button></a>
        </div>
    </div>
  </div>
    </div>
    <?php endforeach; endforeach; ?>
  </div>
  </div>
 </div>
</div>
</div>