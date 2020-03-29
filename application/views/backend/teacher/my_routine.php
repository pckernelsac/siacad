<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<div class="content-w">
    <div class="conty">
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
 <div class="os-tabs-w menu-shad">
        <div class="os-tabs-controls">
          <ul class="navs navs-tabs upper">
            <li class="navs-item">
              <a class="navs-links active" href="<?php echo base_url();?>teacher/my_routine/"><i class="os-icon picons-thin-icon-thin-0024_calendar_month_day_planner_events"></i><span><?php echo get_phrase('class_routine');?></span></a>
            </li>
            <li class="navs-item">
              <a class="navs-links" href="<?php echo base_url();?>teacher/exam_routine/"><i class="os-icon picons-thin-icon-thin-0016_bookmarks_reading_book"></i><span><?php echo get_phrase('exam_routine');?></span></a>
            </li>
          </ul>
        </div>
      </div>
  <div class="content-i">
    <div class="content-box"><div class="element-wrapper">

          <div class="element-wrapper">
            <div class="element-box table-responsive lined-primary shadow" id="print_area">
			<div class="row m-b">
				<div style="display:inline-block">
				<img style="max-height:60px;margin:0px 10px 20px 20px" src="<?php echo $this->crud_model->get_image_url('teacher', $this->session->userdata('login_user_id'));?>" alt=""/>		
				</div>
				<div style="padding-left:20px;display:inline-block;">
				<h5><?php echo get_phrase('my_routine');?></h5>
				<p><?php echo $this->crud_model->get_name('teacher', $this->session->userdata('login_user_id'));?></p>
				</div>
			</div>
			<table class="table table-schedule table-hover" cellpadding="0" cellspacing="0">
			<?php 
        $days = $this->db->get_where('academic_settings', array('type' => 'routine'))->row()->description; 
        if($days == 2) { $nday = 6;}else{$nday = 7;}
        for($d=$days; $d <= $nday; $d++):
        if($d==1)$day = 'Sunday';
				else if($d==2) $day = 'Monday';
				else if($d==3) $day = 'Tuesday';
				else if($d==4) $day = 'Wednesday';
				else if($d==5) $day = 'Thursday';
				else if($d==6) $day = 'Friday';
				else if($d==7) $day = 'Saturday';
			?>
				<tr>
				<table class="table table-schedule table-hover" cellpadding="0" cellspacing="0">
					<td width="120" height="90" style="text-align: center;" class="bg-primary text-white"><strong><?php echo ucwords($day);?></strong></td>
					<?php
                        $this->db->order_by("time_start", "asc");
                        $this->db->where('day' , $day);
                        $this->db->where('year' , $running_year);
                        $this->db->where('teacher_id' , $this->session->userdata('login_user_id'));
                        $routines   =   $this->db->get('class_routine')->result_array();
                        	foreach($routines as $row2):
                	?>
						<td style="text-align:center"><?php
                        if ($row2['time_start_min'] == 0 && $row2['time_end_min'] == 0) 
                        echo $row2['time_start'].'-'.$row2['time_end'];
                        if ($row2['time_start_min'] != 0 || $row2['time_end_min'] != 0)
                        echo $row2['time_start'].':'.$row2['time_start_min'].'-'.$row2['time_end'].':'.$row2['time_end_min'];
                    ?><br><b><?php echo $this->crud_model->get_subject_name_by_id($row2['subject_id']);?></b><br><small><?php echo $this->db->get_where('class', array('class_id' => $row2['class_id']))->row()->name;?> - <strong><?php echo $this->db->get_where('section', array('section_id' => $row2['section_id']))->row()->name;?></strong></small></td>
					<?php endforeach;?>
				</table>
				</tr>
				<?php endfor;?>				
				</table>
            </div>
            <button class="btn btn-rounded btn-primary pull-right" onclick="printDiv('print_area')" ><?php echo get_phrase('print');?></button><br><br><br>
          </div>
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