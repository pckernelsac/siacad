<div class="content-w">
    <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
  <div class="conty">
  <div class="os-tabs-w menu-shad">
        <div class="os-tabs-controls">
          <ul class="navs navs-tabs upper">
            <li class="navs-item">
              <a class="navs-links active" data-toggle="tab" href="#permissions"><i class="os-icon picons-thin-icon-thin-0015_fountain_pen"></i><span><?php echo get_phrase('permissions');?></span></a>
            </li>
            <li class="navs-item">
              <a class="navs-links" data-toggle="tab" href="#apply"><i class="os-icon picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i><span><?php echo get_phrase('apply');?></span></a>
            </li>
          </ul>
        </div>
      </div>
  <div class="content-i">
    <div class="content-box">
        
        <div class="tab-content">
		<div class="tab-pane active" id="permissions">
        <div class="element-wrapper">
                <h6 class="element-header">
                  <?php echo get_phrase('behavior');?>
                  <div style="margin-top:auto;text-align:right;"><a href="#" data-target="#addroutine" data-toggle="modal" class="btn btn-control btn-grey-lighter btn-purple"><i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i><div class="ripple-container"></div></a></div>
                </h6>
                <div class="element-box-tp">
                  <div class="table-responsive">
                    <table class="table table-padded">
                      <thead>
                        <tr>
                            <th><?php echo get_phrase('status');?></th>
                          <th><?php echo get_phrase('reason');?></th>
				<th><?php echo get_phrase('description');?></th>
				<th><?php echo get_phrase('user');?></th>
				<th><?php echo get_phrase('from');?></th>
				<th><?php echo get_phrase('until');?></th>
				<th><?php echo get_phrase('file');?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
            	$count = 1;
            	$this->db->order_by('request_id', 'desc');
            	$requests = $this->db->get_where('request', array('teacher_id' => $this->session->userdata('login_user_id')))->result_array();
            	foreach ($requests as $row):
        	?>   
				<tr>
				    	<td>
					    <?php if($row['status'] == 2):?>
                                <span class="status-pill red"></span><span><?php echo get_phrase('rejected');?></span>
                              <?php endif;?>
                              <?php if($row['status'] == 0):?>
                                <span class="status-pill yellow"></span><span><?php echo get_phrase('pending');?></span>
                              <?php endif;?>
                              <?php if($row['status'] == 1):?>
                                <span class="status-pill green"></span><span><?php echo get_phrase('approved');?></span>
                              <?php endif;?>
					</td>
					<td><a class="btn nc btn-rounded btn-sm btn-purple" style="color:white"><?php echo $row['title']; ?></a></td>
					<td><?php echo $row['description']; ?></td>
					<td><img alt="" src="<?php echo $this->crud_model->get_image_url('teacher', $this->session->userdata('login_user_id'));?>" width="25px" style="border-radius: 10px;margin-right:5px;"> <?php echo $this->crud_model->get_name('teacher', $row['teacher_id']);?></td>
					<td><a class="btn nc btn-rounded btn-sm btn-primary" style="color:white"><?php echo $row['start_date']; ?></a></td>
					<td><a class="btn nc btn-rounded btn-sm btn-secondary" style="color:white"><?php echo $row['end_date']; ?></a></td>
					<td>
					<?php if($row['file'] == ""):?>
						<p><?php echo get_phrase('no_file');?></p>
					<?php endif;?>
					<?php if($row['file'] != ""):?>
						<a href="<?php echo base_url();?>uploads/request/<?php echo $row['file'];?>" class="btn btn-rounded btn-sm btn-primary" style="color:white"><i class="os-icon picons-thin-icon-thin-0042_attachment"></i> <?php echo get_phrase('download');?></a>
					<?php endif;?>
					</td>
				
				</tr>
			<?php endforeach;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
                </div>
                
                
                    <div class="tab-pane" id="apply">
          <div class="element-wrapper">
            <div class="element-box lined-primary">
			  <?php echo form_open(base_url() . 'teacher/request/create', array('enctype' => 'multipart/form-data'));?>
			  <h5 class="form-header"><?php echo get_phrase('apply');?></h5><br>
			  <div class="form-group">
				<label for=""> <?php echo get_phrase('reason');?></label><input class="form-control" name="title" placeholder="" required type="text">
			  </div>
			  <div class="form-group">
				  <label> <?php echo get_phrase('description');?></label><textarea name="description" class="form-control" required="" rows="4"></textarea>
				</div>
			  <div class="row">
				  <div class="col-sm-6">
					<div class="form-group">
					  <label for=""> <?php echo get_phrase('from');?></label>
					  <input type='text' class="datepicker-here" data-position="top left" data-language='en' name="start_date" data-multiple-dates-separator="/"/>
					</div>
				  </div>
				  <div class="col-sm-6">
					<div class="form-group">
					  <label for=""> <?php echo get_phrase('until');?></label>
					  <input type='text' class="datepicker-here" data-position="top left" data-language='en' name="end_date" data-multiple-dates-separator="/"/>
					</div>
				  </div>
				</div>
				<div class="form-group">
				<label for=""> <?php echo get_phrase('send_file');?></label>
				  <div class="input-group form-control">
				  <input type="file" name="file_name" id="file-3" class="inputfile inputfile-3" style="display:none"/>
					<label for="file-3"><i class="os-icon picons-thin-icon-thin-0042_attachment"></i> <span><?php echo get_phrase('send_file');?>...</span></label>
					</div>
				</div>
			  <div class="form-buttons-w text-right">
				<button class="btn btn-primary btn-rounded" type="submit"> <?php echo get_phrase('apply');?></button>
			  </div>
			<?php echo form_close();?>
			</div>
			</div>
          </div>
                
              </div>
              
     
      </div>
    </div>
    </div>
  </div>