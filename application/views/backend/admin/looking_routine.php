<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div> 
    <div class="conty">
      <div class="os-tabs-w menu-shad">
        <div class="os-tabs-controls">
          <ul class="navs navs-tabs upper">
            <li class="navs-item">
              <a class="navs-links" href="<?php echo base_url();?>admin/class_routine_view/"><i class="os-icon picons-thin-icon-thin-0024_calendar_month_day_planner_events"></i><span><?php echo get_phrase('class_routine');?></span></a>
            </li>
            <li class="navs-item">
              <a class="navs-links" href="<?php echo base_url();?>admin/teacher_routine/"><i class="os-icon picons-thin-icon-thin-0011_reading_glasses"></i><span><?php echo get_phrase('teacher_routine');?></span></a>
            </li>
            <li class="navs-item">
              <a class="navs-links active" href="<?php echo base_url();?>admin/looking_routine/"><i class="os-icon picons-thin-icon-thin-0016_bookmarks_reading_book"></i><span><?php echo get_phrase('exam_routine');?></span></a>
            </li>
          </ul>     
        </div>
      </div>
      <div class="content-box">
        <div class="row">
          <div class="col col-lg-9 col-md-9 col-sm-12 col-12">
            <?php echo form_open(base_url() . 'admin/looking_routine/', array('class' => 'form m-b'));?>
            <div class="form-group label-floating is-select">
              <label class="control-label"><?php echo get_phrase('filter_by_class');?></label>
              <div class="select">
                <select onchange="submit();" name="class_id" onchange="submit();">
                  <option value=""><?php echo get_phrase('select');?></option>
                  <?php $cl = $this->db->get('class')->result_array();
                  foreach($cl as $row):?>
                    <option value="<?php echo $row['class_id'];?>" <?php if($id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                  <?php endforeach;?>
                </select>
              </div>
            </div>
            <?php echo form_close();?>
          </div>
          <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
            <div class="text-">
              <button class="btn btn-rounded btn-success btn-upper" data-target="#addExamRoutine" data-toggle="modal" type="button">+ <?php echo get_phrase('add_routine');?></button>
            </div>
          </div>
        </div>               
        <div class="" style="padding-top:25px; padding-left:18px;">
          <div class="os-tabs-w">
            <div class="os-tabs-controls">
              <ul class="navs navs-tabs upper">
              <?php $query = $this->db->get_where('section' , array('class_id' => $id)); 
                if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $rows):?>
                <li class="navs-item">
                  <a class="navs-link <?php if($rows['name'] == 'A') echo 'active';?>" data-toggle="tab" href="#<?php echo $rows['name'];?>"><?php echo get_phrase('section');?> <?php echo $rows['name'];?></a>
                </li>
                <?php endforeach;?>
                <?php endif;?>
              </ul>
            </div>
          </div>
        </div>
        <div class="tab-content">
          <?php $query = $this->db->get_where('section' , array('class_id' => $id));
          if ($query->num_rows() > 0):
          $sections = $query->result_array();
          foreach ($sections as $row): ?>
          <div class="tab-pane <?php if($row['name'] == 'A') echo 'active';?>" id="<?php echo $row['name'];?>">
            <div class="element-wrapper">
              <div class="element-box table-responsive lined-primary shadow" id="print_area<?php echo $row['section_id'];?>">
                <div class="row m-b">
                  <div style="display:inline-block">
                    <img style="max-height:80px;margin:0px 10px 20px 20px" src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>"/>    
                  </div>
                  <div style="padding-left:20px;display:inline-block;">
                    <h5><?php echo get_phrase('class_routine');?></h5>
                    <p><?php echo $this->db->get_where('class', array('class_id' => $id))->row()->name;?><br><?php echo get_phrase('section');?> <?php echo $this->db->get_where('section', array('section_id' => $row['section_id']))->row()->name;?></p>
                  </div>
                </div>
                <table class="table table-bordered table-schedule table-hover" cellpadding="0" cellspacing="0" width="100%">
			<?php 
                $days = $this->db->get_where('academic_settings', array('type' => 'routine'))->row()->description; 
        		if($days == 2) { $nday = 6;}else{$nday = 7;}
        		for($d=$days; $d <= $nday; $d++):
                if($d==1)$day = 'Sunday';
				else if($d==2) $day ='Monday';
				else if($d==3) $day = 'Tuesday';
				else if($d==4) $day ='Wednesday';
				else if($d==5) $day ='Thursday';
				else if($d==6) $day ='Friday';
				else if($d==7) $day ='Saturday';
			?>
				<tr>
				<table class="table table-schedule table-hover" cellpadding="0" cellspacing="0">
					<td width="120" height="90" class="bg-primary text-white" style="text-align: center;"><strong><?php echo ucwords($day);?></strong></td>
					 <?php
                        $this->db->order_by("time_start", "asc");
                        $this->db->where('day' , $day);
                        $this->db->where('class_id' , $id);
                        $this->db->where('section_id' , $row['section_id']);
                        $this->db->where('year' , $running_year);
                        $routines   =   $this->db->get('horarios_examenes')->result_array();
                        foreach($routines as $row2):
                    ?>
					<td style="text-align:center">
					<div class="pi-controls" style="text-align:right">
						<div class="pi-settings os-dropdown-trigger">
						  <i class="os-icon picons-thin-icon-thin-0069a_menu_hambuger"></i>
						  <div class="os-dropdown">
							<div class="icon-w">
							  <i class="os-icon picons-thin-icon-thin-0069a_menu_hambuger"></i>
							</div>
							<ul>
							  <li>
								<a href="#!" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_e_routine/<?php echo $row2['horario_id'];?>');"><i class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i><span><?php echo get_phrase('edit');?></span></a>
							  </li>
							  <li>
								<a onClick="return confirm('<?php echo get_phrase('confirm_delete');?>')" href="<?php echo base_url();?>admin/exam_routine/delete/<?php echo $row2['horario_id'];?>"><i class="os-icon picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i><span><?php echo get_phrase('delete');?></span></a>
							  </li>
							</ul>
						  </div>
						</div>
					  </div>
					<strong><?php echo $row2['fecha'];?></strong><br>
					<?php echo '('.$row2['time_start'].':'.$row2['time_start_min']." "." <b>".$row2['amstart']."</b>".' - '.$row2['time_end'].':'.$row2['time_end_min']." "." <b>".$row2['amend']."</b>".')';
                    ?>
                    <br><b><?php echo $this->crud_model->get_subject_name_by_id($row2['subject_id']);?></b><br><small><?php echo $this->db->get_where('teacher', array('teacher_id' => $row2['teacher_id']))->row()->first_name." ".$this->db->get_where('teacher', array('teacher_id' => $row2['teacher_id']))->row()->last_name;?></small>
                    </td>
                    <?php endforeach;?>
				</table>
				</tr>
			<?php endfor;?>  
				</table>
          </div>
          <button class="btn btn-rounded btn-primary pull-right" onclick="printDiv('print_area<?php echo $row['section_id'];?>')" ><?php echo get_phrase('print');?></button><br><br><br>
        </div>  
      </div>
      <?php endforeach;?>
      <?php endif;?>
    </div>      
  </div>
</div>
<div class="display-type"></div>
</div>

<div class="modal fade" id="addExamRoutine" tabindex="-1" role="dialog" aria-labelledby="addExamRoutine" aria-hidden="true">
  <div class="modal-dialog window-popup edit-my-poll-popup" role="document">
    <div class="modal-content">
      <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
      </a>
      <div class="modal-body">
        <div class="ui-block-title" style="background-color:#00579c">
          <h6 class="title" style="color:white"><?php echo get_phrase('add_routine');?></h6>
        </div>
        <div class="ui-block-content">
          <?php echo form_open(base_url() . 'admin/exam_routine/create' , array('target'=>'_top'));?>
              <div class="row">
                  <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('class');?></label>
                            <div class="select">
                                <select name="class_id" onchange="get_class_sections(this.value); get_class_subject(this.value);" required="">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php $cl = $this->db->get('class')->result_array();
                                    foreach($cl as $row):
                                  ?>
                                    <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                                  <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                  <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('section');?></label>
                            <div class="select">
                                <select name="section_id" id="section_selector_holder" required="">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('subject');?></label>
                            <div class="select">
                                <select name="subject_id" id="subject_selector_holder" required="">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group date-time-picker label-floating is-focused">
						    <label class="control-label"><?php echo get_phrase('date');?></label>
							<input type='text' class="datepicker-here" data-position="bottom left" data-language='en' name="datetimepicker" data-multiple-dates-separator="/"/>
                        </div>
                    </div>
                    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('day');?></label>
                            <div class="select">
                                <select name="day" required="">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php
                                        $days = $this->db->get_where('academic_settings', array('type' => 'routine'))->row()->description; 
                                        if($days == 1):?>
                                          <option value="Sunday"><?php echo get_phrase('sunday');?></option>
                                    <?php endif;?>
                                    <option value="Monday"><?php echo get_phrase('monday');?></option>
                                    <option value="Tuesday"><?php echo get_phrase('tuesday');?></option>
                                    <option value="Wednesday"><?php echo get_phrase('wednesday');?></option>
                                    <option value="Thursday"><?php echo get_phrase('thursday');?></option>
                                    <option value="Friday"><?php echo get_phrase('friday');?></option>
                                    <?php if($days == 1):?>
                                      <option value="Saturday"><?php echo get_phrase('saturday');?></option>
                                  <?php endif;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-12"><legend><span style="font-size:15px;"><?php echo get_phrase('start');?></span></legend></div>
                    <div class="col col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('hour');?></label>
                            <div class="select">
                                <select name="time_start" required="">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php for($i = 1; $i <= 12 ; $i++):?>
                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php endfor;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('minutes');?></label>
                            <div class="select">
                                <select name="time_start_min" required="">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php for($i = 0; $i <= 11 ; $i++):?>
                                        <option value="<?php $n = $i * 5; if($n < 10) echo '0'.$n; else echo $n;?>"><?php $n = $i * 5; if($n < 10) echo '0'.$n; else echo $n;?></option>
                                    <?php endfor;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label" required=""><?php echo get_phrase('time');?></label>
                            <div class="select">
                                <select name="starting_ampm">
                                    <option value="1">AM</option>
                                    <option value="2">PM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-12"><legend><span style="font-size:15px;"><?php echo get_phrase('end');?></span></legend></div>
                    <div class="col col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label" required=""><?php echo get_phrase('hour');?></label>
                            <div class="select">
                                <select name="time_end">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php for($i = 1; $i <= 12 ; $i++):?>
                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php endfor;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label" required=""><?php echo get_phrase('minutes');?></label>
                            <div class="select">
                                <select name="time_end_min">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php for($i = 0; $i <= 11 ; $i++):?>
                                        <option value="<?php $n = $i * 5; if($n < 10) echo '0'.$n; else echo $n;?>"><?php $n = $i * 5; if($n < 10) echo '0'.$n; else echo $n;?></option>
                                    <?php endfor;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('time');?></label>
                            <div class="select" >
                                <select name="ending_ampm" required="">
                                    <option value="1">AM</option>
                          <option value="2">PM</option>
                                </select>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="form-buttons-w text-right">
                <center><button class="btn btn-rounded btn-success btn-lg" type="submit"><?php echo get_phrase('save');?></button></center>
              </div>
            <?php echo form_close();?>        
        </div>
      </div>
    </div>
  </div>
</div>

<script>
 function printDiv(nombreDiv) 
 {
     var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;
     document.body.innerHTML = contenido;
     window.print();
     document.body.innerHTML = contenidoOriginal;
}
</script> 
<script type="text/javascript">
    function get_class_sections(class_id) 
    {
        $.ajax({
            url: '<?php echo base_url();?>admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });
    }
</script>
<script type="text/javascript">
    function get_class_subject(class_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/get_class_subject/' + class_id,
            success: function (response)
            {
                jQuery('#subject_selector_holder').html(response);
            }
        });
    }
</script>