<?php $min = $this->db->get_where('academic_settings' , array('type' =>'minium_mark'))->row()->description;?>
<?php 
    $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
$student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array(); 
    foreach($student_info as $row): ?>
    <?php $class_id = $this->db->get_where('enroll', array('student_id' => $row['student_id'], 'year' => $running_year))->row()->class_id;?>
<div class="content-w"> 
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
  <div class="content-i">
    <div class="content-box">
      <div class="conty">
           <div class="back" style="margin-top:-20px;margin-bottom:10px">		
	                <a title="<?php echo get_phrase('return');?>" href="<?php echo base_url();?>admin/students/"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>	
	            </div>
          <div class="row">
              <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">                
                  <div id="newsfeed-items-grid">
                <div class="ui-block paddingtel">
                      <div class="user-profile">
                        <div class="up-head-w" style="background-image:url(<?php echo base_url();?>uploads/bglogin.jpg)">
                          <div class="up-main-info">
                              <div class="user-avatar-w">
                                 <div class="user-avatar">
                                      <img alt="" src="<?php echo $this->crud_model->get_image_url('student', $row['student_id']);?>" style="background-color:#fff;">
                                  </div>
                              </div>
                              <h3 class="text-white"><?php echo $row['first_name'];?> <?php echo $row['last_name'];?></h3>
                              <h5 class="up-sub-header">@<?php echo $row['username'];?></h5>
                          </div>
                          <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219" preserveAspectRatio="xMaxYMax meet" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF"><path class="decor-path" d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z"></path></g>
                          </svg>
                        </div>
                        <div class="up-controls">
                          <div class="row">
                              <div class="col-lg-6">
                                  <div class="value-pair">
                                      <div><?php echo get_phrase('account_type');?>:</div>
                                          <div class="value badge badge-pill badge-primary"><?php echo get_phrase('student');?></div>
                                  </div>
                                  <div class="value-pair">
                                      <div><?php echo get_phrase('member_since');?>:</div>
                                      <div class="value"><?php echo $row['since'];?>.</div>
                                  </div>
                                  <div class="value-pair">
                                      <div><?php echo get_phrase('roll');?>:</div>
                                      <div class="value"><?php echo $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->roll;?>.</div>
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>
                      </div>
                      <div class="row">
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
            <td><img alt="" src="" width="25px" style="border-radius: 10px;margin-right:5px;"> <?php echo $this->crud_model->get_name('teacher', $row3['teacher_id']); ?></td>
            <td>
            <?php $mark = $this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'exam_id' => $row2['exam_id'], 'student_id' => $student_id, 'year' => $running_year))->row()->labtotal;?>
            <?php if($mark < $min || $mark == 0):?>
              <a class="btn btn-rounded btn-sm btn-danger" style="color:white"><?php if($this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'exam_id' => $row2['exam_id'], 'student_id' => $student_id, 'year' => $running_year))->row()->labtotal == 0) echo '0'; else echo $mark;?></a>
              <?php endif;?>
              <?php if($mark >= $min):?>
                <a class="btn btn-rounded btn-sm btn-info" style="color:white"><?php echo $this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'exam_id' => $row2['exam_id'], 'student_id' => $student_id, 'year' => $running_year))->row()->labtotal;?></a>
              <?php endif;?>
            </td>
            <td><?php echo $grade = $this->crud_model->get_grade($this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'exam_id' => $row2['exam_id'], 'student_id' => $student_id, 'year' => $running_year))->row()->labtotal);?></td>
            
            <td><?php echo $this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'exam_id' => $row2['exam_id'], 'student_id' => $student_id, 'year' => $running_year))->row()->comment; ?></td>
            <?php $data = base64_encode($row2['exam_id']."-".$student_id."-".$row3['subject_id']); ?>
            <td><a class="btn btn-rounded btn-sm btn-primary" style="color:white" href="<?php echo base_url();?>admin/subject_marks/<?php echo $data;?>"><?php echo get_phrase('view_all');?></a></td>
          </tr>
            <?php endforeach; endforeach;?>
        </tbody>
      </table>
    <div class="form-buttons-w text-right">
     <a target="_blank" href="<?php echo base_url();?>admin/marks_print_view/<?php echo $student_id;?>/<?php echo $row2['exam_id'];?>"><button class="btn btn-rounded btn-success" type="submit"><i class="picons-thin-icon-thin-0333_printer"></i>  <?php echo get_phrase('print');?></button></a>
    </div>
    </div>
  </div>
    </div>
    <?php endforeach; endforeach; ?>
                        </div>
                  </div>
              </main>
              <div class="col col-xl-3 order-xl-1 col-lg-12 order-lg-2 col-md-12 col-sm-12 col-12 ">
                  <div class="crumina-sticky-sidebar">
                      <div class="sidebar__inner">
                        <div class="ui-block paddingtel">
                          <div class="ui-block-content">
                              <div class="widget w-about">
                                  <a href="javascript:void(0);" class="logo"><img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>"></a>
                                    <ul class="socials">
                                        <li><a href="<?php echo $this->db->get_where('settings', array('type' => 'facebook'))->row()->description;?>"><i class="fab fa-facebook-square" aria-hidden="true"></i></a></li>
                                        <li><a href="<?php echo $this->db->get_where('settings', array('type' => 'twitter'))->row()->description;?>"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                        <li><a href="<?php echo $this->db->get_where('settings', array('type' => 'youtube'))->row()->description;?>"><i class="fab fa-youtube" aria-hidden="true"></i></a></li>
                                        <li><a href="<?php echo $this->db->get_where('settings', array('type' => 'instagram'))->row()->description;?>"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                                  </ul>
                              </div>
                          </div>
                      </div>
                        <div class="ui-block paddingtel">
                          <div class="ui-block-content">
                            <div class="help-support-block">
                      <h3 class="title"><?php echo get_phrase('quick_links');?></h3>
                      <ul class="help-support-list">
                        <li>
                          <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                          <a href="<?php echo base_url();?>admin/student_portal/<?php echo $student_id;?>/"><?php echo get_phrase('personal_information');?></a>
                        </li>
                        <li>
                          <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                          <a href="<?php echo base_url();?>admin/student_update/<?php echo $student_id;?>/"><?php echo get_phrase('update_information');?></a>
                        </li>
                        <li>
                          <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                          <a href="<?php echo base_url();?>admin/student_invoices/<?php echo $student_id;?>/"><?php echo get_phrase('payments_history');?></a>
                        </li>
                        <li>
                          <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                          <a href="<?php echo base_url();?>admin/student_marks/<?php echo $student_id;?>/"><?php echo get_phrase('marks');?></a>
                        </li>
                        <li>
                          <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                          <a href="<?php echo base_url();?>admin/student_profile_attendance/<?php echo $student_id;?>/"><?php echo get_phrase('attendance');?></a>
                        </li>
                        <li>
                          <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                          <a href="<?php echo base_url();?>admin/student_profile_report/<?php echo $student_id;?>/"><?php echo get_phrase('behavior');?></a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</div>
<?php endforeach;?>