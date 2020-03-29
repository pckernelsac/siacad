<?php $edit_data = $this->db->get_where('class_routine' , array('class_routine_id' => $param2) )->result_array();
 foreach($edit_data as $row):?>
     <div class="modal-body">
         <div class="ui-block-title" style="background-color:#00579c">
          <h6 class="title" style="color:white"><?php echo get_phrase('update_routine');?></h6>
        </div>
        <div class="ui-block-content">
          <?php echo form_open(base_url() . 'admin/class_routine/update/'.$row['class_routine_id'] , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
              <div class="row">
                  <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('class');?></label>
                            <div class="select">
                                <select name="class_id" disabled>
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php $cl = $this->db->get('class')->result_array();
                                        foreach($cl as $row2): ?>
                                        <option value="<?php echo $row2['class_id'];?>" <?php if($row['class_id']==$row2['class_id'])echo 'selected';?>><?php echo $row2['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                  <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('section');?></label>
                            <div class="select">
                                <select name="section_id" disabled>
                                    <option value=""><?php echo get_phrase('select');?></option>
                                     <?php $sec = $this->db->get_where('section', array('class_id' => $row['class_id']))->result_array();
                                        foreach($sec as $row3): ?>
                                        <option value="<?php echo $row3['section_id'];?>" <?php if($row['section_id'] == $row3['section_id'])echo 'selected';?>><?php echo $row3['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('subject');?></label>
                            <div class="select">
                                <select name="subject_id" disabled>
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php $sec = $this->db->get_where('subject', array('class_id' => $row['class_id']))->result_array();
                                     foreach($sec as $row4): ?>
                                        <option value="<?php echo $row4['subject_id'];?>" <?php if($row['subject_id'] == $row4['subject_id'])echo 'selected';?>><?php echo $row4['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('day');?></label>
                            <div class="select">
                                <select name="day" required="">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php
                                    $days = $this->db->get_where('academic_settings', array('type' => 'routine'))->row()->description; 
                                    if($days == 1):?>
                                        <option value="Sunday" <?php if($row['day']== "Sunday") echo "selected";?>><?php echo get_phrase('sunday');?></option>
                                    <?php endif;?>
                                    <option value="Monday" <?php if($row['day']== "Monday") echo "selected";?>><?php echo get_phrase('monday');?></option>
                                    <option value="Tuesday" <?php if($row['day']== "Tuesday") echo "selected";?>><?php echo get_phrase('tuesday');?></option>
                                    <option value="Wednesday" <?php if($row['day']== "Wednesday") echo "selected";?>><?php echo get_phrase('wednesday');?></option>
                                    <option value="Thursday" <?php if($row['day']== "Thursday") echo "selected";?>><?php echo get_phrase('thursday');?></option>
                                    <option value="Friday" <?php if($row['day']== "Friday") echo "selected";?>><?php echo get_phrase('friday');?></option>
                                    <?php if($days == 1):?>
                                        <option value="Saturday" <?php if($row['day']== "Saturday") echo "selected";?>><?php echo get_phrase('saturday');?></option>
                                    <?php endif;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-12"><legend><span style="font-size:15px;"><?php echo get_phrase('start');?></span></legend></div>
                    <div class="col col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                         <?php 
                            if($row['time_start'] < 13)
                            {
                                $time_start     =   $row['time_start'];
                                $time_start_min =   $row['time_start_min'];
                                $starting_ampm  =   1;
                            }
                            else if($row['time_start'] > 12)
                            {
                                $time_start     =   $row['time_start'] - 12;
                                $time_start_min =   $row['time_start_min'];
                                $starting_ampm  =   2;
                            }
                        ?>
                            <label class="control-label"><?php echo get_phrase('hour');?></label>
                            <div class="select">
                                <select name="time_start" required="">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php for($i = 1; $i <= 12 ; $i++):?>
                                        <option value="<?php echo $i;?>" <?php if($i ==$time_start)echo "selected";?>><?php echo $i;?></option>
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
                                        <option value="<?php $n = $i * 5; if($n < 10) echo '0'.$n; else echo $n;?>" <?php if (($i * 5) == $time_start_min) echo 'selected';?>><?php $n = $i * 5; if($n < 10) echo '0'.$n; else echo $n;?></option>
                                    <?php endfor;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('time');?></label>
                            <div class="select">
                                <select name="starting_ampm">
                                    <option value="1" <?php if($starting_ampm   ==  '1') echo "selected";?>>AM</option>
                                    <option value="2" <?php if($starting_ampm   ==  '2') echo "selected";?>>PM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php 
                            if($row['time_end'] < 13)
                            {
                                $time_end		=	$row['time_end'];
                                $time_end_min   =   $row['time_end_min'];
                                $ending_ampm	=	1;
                            }
                            else if($row['time_end'] > 12)
                            {
                                $time_end		=	$row['time_end'] - 12;
                                $time_end_min   =   $row['time_end_min'];
                                $ending_ampm	=	2;
                            }
                    ?>
                    <div class="col-sm-12"><legend><span style="font-size:15px;"><?php echo get_phrase('end');?></span></legend></div>
                    <div class="col col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('hour');?></label>
                            <div class="select">
                                <select name="time_end" required="">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php for($i = 1; $i <= 12 ; $i++):?>
                                        <option value="<?php echo $i;?>" <?php if($i ==$time_end) echo "selected";?>><?php echo $i;?></option>
                                    <?php endfor;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('minutes');?></label>
                            <div class="select">
                                <select name="time_end_min" required="">
                                    <option value="">Seleccionar</option>
                                    <?php for($i = 0; $i <= 11 ; $i++):?>
                                        <option value="<?php $n = $i * 5; if($n < 10) echo '0'.$n; else echo $n;?>" <?php if (($i * 5) == $time_end_min) echo 'selected';?>><?php $n = $i * 5; if($n < 10) echo '0'.$n; else echo $n;?></option>
                                    <?php endfor;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('time');?></label>
                            <div class="select">
                                <select name="ending_ampm" required="">
                                    <option value="1" <?php if($ending_ampm	==	'1') echo "selected";?>>AM</option>
                                    <option value="2" <?php if($ending_ampm	==	'2') echo "selected";?>>PM</option>
                                </select>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="form-buttons-w text-right">
                <center><button class="btn btn-rounded btn-success" type="submit"><?php echo get_phrase('update');?></button></center>
              </div>
            <?php echo form_close();?>        
        </div>
      </div>
<?php endforeach; ?>