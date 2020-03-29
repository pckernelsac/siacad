<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php
    $online_exam_details = $this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id))->row_array();
    $added_question_info = $this->db->get_where('question_bank', array('online_exam_id' => $online_exam_id))->result_array();
?>
<div class="content-w">
      <div class="conty">
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
<?php if($online_exam_id != ""):?>
    <div class="os-tabs-w menu-shad">
    <div class="os-tabs-controls">
      <ul class="navs navs-tabs upper">
      <li class="navs-item">
        <a class="navs-links active" href="<?php echo base_url();?>teacher/examroom/<?php echo $online_exam_id;?>/"><i class="os-icon picons-thin-icon-thin-0016_bookmarks_reading_book"></i><span><?php echo get_phrase('exam_details');?></span></a>
      </li>
      <li class="navs-item">
        <a class="navs-links" href="<?php echo base_url();?>teacher/exam_results/<?php echo $online_exam_id;?>/"><i class="os-icon picons-thin-icon-thin-0100_to_do_list_reminder_done"></i><span><?php echo get_phrase('results');?></span></a>
      </li>
      <li class="navs-item">
        <a class="navs-links" href="<?php echo base_url();?>teacher/exam_edit/<?php echo $online_exam_id;?>/"><i class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i><span><?php echo get_phrase('edit');?></span></a>
      </li>
      </ul>
    </div>
    </div>
  <div class="content-i">
    <div class="content-box">
<div class="back" style="margin-top:-20px;margin-bottom:10px">		
	<a href="<?php echo base_url();?>teacher/online_exams/<?php echo base64_encode($online_exam_details['class_id']."-".$online_exam_details['section_id']."-".$online_exam_details['subject_id']);?>/"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>	
	</div>
    <div class="row">
    <div class="col-md-6">
         <div class="pipeline white lined-primary">
            <div class="panel-heading">
                <h5 class="panel-title"><?php echo get_phrase('questions');?></h5>
            </div>
            <div class="panel-body">
<div style="overflow-x:auto;">
                <table  class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: center;" width="5%"><div>#</div></th>
                            <th style="text-align: center;"><div><?php echo get_phrase('type');?></div></th>
                            <th style="text-align: center;" width="60%"><div><?php echo get_phrase('question');?></div></th>
                            <th style="text-align: center;" width="10%"><div><?php echo get_phrase('mark');?></div></th>
                            <th style="text-align: center;"><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (sizeof($added_question_info) == 0):?>
                            <tr>
                                <td colspan="5"><?php echo get_phrase('no_questions');?></td>
                            </tr>
                            <?php
                              elseif (sizeof($added_question_info) > 0):
                              $i = 0;
                              foreach ($added_question_info as $added_question): 
                            ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo ++$i; ?></td>
                                    <td><span class="badge badge-success"><?php if($added_question['type'] == "fill_in_the_blanks") {echo get_phrase('blank_spaces');} else if($added_question['type'] == "multiple_choice"){echo get_phrase('multiple_choice');} else if($added_question['type'] == "true_false"){echo get_phrase('true_false');}?></span></td>
                                    <?php if ($added_question['type'] == 'fill_in_the_blanks'): ?>
                                        <td><small><?php echo str_replace('_', '____', $added_question['question_title']); ?></small></td>
                                    <?php else: ?>
                                        <td><small><?php echo $added_question['question_title']; ?></small></td>
                                    <?php endif; ?>
                                    <td style="text-align: center;"><?php echo $added_question['mark']; ?></td>
                                    <td style="text-align: center;">
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/update_online_exam_question/<?php echo $added_question['question_bank_id'];?>')" class="btn btn-success btn-sm"><i class="picons-thin-icon-thin-0001_compose_write_pencil_new" aria-hidden="true"></i></a>
                                        <a onClick="return confirm('<?php echo get_phrase('confirm_delete');?>')" href="<?php echo base_url();?>teacher/delete_question_from_online_exam/<?php echo $added_question['question_bank_id'];?>"  class="btn btn-danger btn-sm"  data-toggle="tooltip" title="<?php echo get_phrase('delete'); ?>"><i class="picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="pipeline white lined-success">
            <div class="panel-heading">
                <h5 class="panel-title" ><?php echo get_phrase('exam_details');?></h5>
            </div>
            <div class="panel-body">
<div style="overflow-x:auto;">
                <table  class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><b><?php echo get_phrase('title');?></b></td>
                            <td><?php echo $online_exam_details['title']; ?></td>
                            <td><b><?php echo get_phrase('date');?></b></td>
                            <td><?php echo date('M d, Y', $online_exam_details['exam_date']); ?></td>
                        </tr>
                        <tr>
                            <td><b><?php echo get_phrase('class');?></b></td>
                            <td><span class="btn btn-purple btn-sm"><?php echo $this->db->get_where('class', array('class_id' => $online_exam_details['class_id']))->row()->name; ?></span></td>
                            <td><b><?php echo get_phrase('hour');?></b></td>
                            <td><?php echo $online_exam_details['time_start'].":00".' - '.$online_exam_details['time_end'].":00"; ?></td>
                        </tr>
                        <tr>
                            <td><b><?php echo get_phrase('section');?></b></td>
                            <td><span class="btn btn-success btn-sm"><?php echo $this->db->get_where('section', array('section_id' => $online_exam_details['section_id']))->row()->name; ?></span></td>
                            <td><b><?php echo get_phrase('percentage_required');?></b></td>
                            <td><?php echo $online_exam_details['minimum_percentage'].'%'; ?></td>
                        </tr>
                        <tr>
                            <td><b><?php echo get_phrase('subject');?></b></td>
                            <td><?php echo $this->db->get_where('subject', array('subject_id' => $online_exam_details['subject_id']))->row()->name; ?></td>
                            <td><b><?php echo get_phrase('total_mark');?></b></td>
                            <td>
                                <?php if (sizeof($added_question_info) == 0):?>
                                    <?php echo 0; ?>
                                <?php elseif (sizeof($added_question_info) > 0):?>
                                    <?php
                                        $total_mark = 0;
                                        foreach ($added_question_info as $single_question) {
                                            $total_mark = $total_mark + $single_question['mark'];
                                        }
                                        echo $total_mark;
                                     ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
</div>
            </div>
        </div>
        <div class="pipeline white lined-danger">
            <div class="panel-heading">
                <h5 class="panel-title" >
                    <?php echo get_phrase('add_question');?>
                </h5>
            </div>
            <div class="panel-body">   
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('question_type');?></label>
                                <div class="select">
                                    <select name="question_type" id="question_type">
                                        <option value=""><?php echo get_phrase('select');?></option>
                                        <option value="multiple_choice"><?php echo get_phrase('multiple_choice');?></option>
                                        <option value="true_false"><?php echo get_phrase('true_false');?></option>
                                        <option value="fill_in_the_blanks"><?php echo get_phrase('blank_spaces');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="question_holder"></div>
            </div>
        </div>
    </div>
</div>
</div></div>
<?php endif;?>
</div>
</div>
<script type="text/javascript">

    $(document).ready(function() 
    {
        $('#question_type').on('change', function() {
            var question_type = $(this).val();
            if (question_type == '') {
                $('#question_holder').html('<div class="alert alert-danger"><?php echo get_phrase('select_an_question');?></div>');
                return;
            }
            var online_exam_id = '<?php echo $online_exam_id;?>';
            $.ajax({
                url: '<?php echo base_url();?>teacher/load_question_type/' + question_type + '/' + online_exam_id
            }).done(function(response) {
                $('#question_holder').html(response);
            });
        });
    });
    
</script>