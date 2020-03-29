<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
         <div class="ae-content-w" style="background-color: #f2f4f8;">
                      <div class="top-header top-header-favorit">
                        <div class="top-header-thumb">
                          <img src="<?php echo base_url();?>uploads/bglogin.jpg" style="height:180px; object-fit:cover;">
                          <div class="top-header-author">
                            <div class="author-thumb">
                              <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" style="background-color: #fff; padding:10px;">
                            </div>
                            <div class="author-content">
                              <a href="javascript:void(0);" class="h3 author-name"><?php echo get_phrase('library');?></a>
                              <div class="country"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>  |  <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="profile-section" style="background-color: #fff;">
                          <div class="control-block-button">                                    
                          </div>
                        </div>
                      </div>
                    </div>
        <div class="content-box">
        <br>
        <?php echo form_open(base_url() . 'teacher/library/', array('class' => 'form m-b'));?>
		  <div class="row">
		      <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating is-select">
                    <label class="control-label"><?php echo get_phrase('filter_by_class');?></label>
                    <div class="select">
                        <select onchange="submit();" name="class_id" onchange="submit();">
                            <option value=""><?php echo get_phrase('select');?></option>
                            <?php $cl = $this->db->get('class')->result_array();
                                foreach($cl as $row):
                  	        ?>      
                                <option value="<?php echo $row['class_id'];?>" <?php if($id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
		  </div><?php echo form_close();?>
        <div class="tab-content ">
            <div class="tab-pane active" id="students">
            <div class="element-wrapper">
                <h6 class="element-header"><?php echo get_phrase('library');?></h6>
                <div class="element-box-tp">
                  <div class="table-responsive">
                    <table class="table table-padded">
                      <thead>
                        <tr>
				            <th><?php echo get_phrase('type');?></th>
				            <th><?php echo get_phrase('name');?></th>
				            <th><?php echo get_phrase('author');?></th>
				            <th><?php echo get_phrase('description');?></th>
				            <th><?php echo get_phrase('status');?></th>
				            <th><?php echo get_phrase('price');?></th>
				            <th><?php echo get_phrase('download');?></th>
			            </tr>
                      </thead>
                      <tbody>
                       <?php $count = 1; 
				$book = $this->db->get_where('book', array('class_id' => $id))->result_array();
			foreach($book as $row):?>
			<tr>
				<td>
				<?php if($row['type'] == 'virtual'):?>
					<a class="btn btn-rounded btn-sm btn-purple" style="color:white"><?php echo get_phrase('virtual');?></a>
				<?php else:?>
					<a class="btn btn-rounded btn-sm btn-info" style="color:white"><?php echo get_phrase('normal');?></a>
				<?php endif;?>
				</td>
				<td><?php echo $row['name'];?></td>
				<td><?php echo $row['author'];?></td>
				<td><?php echo $row['description'];?></td>
				<td>
				<?php if($row['status'] == 2):?>
					<div class="status-pill red" data-title="<?php echo get_phrase('unavailable');?>" data-toggle="tooltip"></div>
				<?php endif;?>
				<?php if($row['status'] == 1):?>
					<div class="status-pill green" data-title="<?php echo get_phrase('available');?>" data-toggle="tooltip"></div>
				<?php endif;?>
				</td>
				<td><a class="btn btn-rounded btn-sm btn-success" style="color:white"><?php echo $this->db->get_where('settings', array('type' => 'currency'))->row()->description;?><?php echo $row['price'];?></a></td>
				<td style="color:grey">
				<?php if($row['type'] == 'virtual' && $row['file_name'] != ""):?>
					<a class="btn btn-rounded btn-sm btn-primary" style="color:white" href="<?php echo base_url();?>uploads/library/<?php echo $row['file_name'];?>"><i class="picons-thin-icon-thin-0042_attachment"></i> <?php echo get_phrase('download');?></a>
				<?php else:?>
					<?php echo get_phrase('no_downloaded');?>
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
      </div>
    </div>      
  </div>
</div>
<div class="display-type"></div>
</div>