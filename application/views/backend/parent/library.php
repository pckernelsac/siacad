<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; 
  $class_id = $this->db->get_where('enroll', array('student_id' => $this->session->userdata('login_user_id'), 'year' => $running_year))->row()->class_id;
  $section_id = $this->db->get_where('enroll' , array('student_id' => $this->session->userdata('login_user_id'),'class_id' => $class_id,'year' => $running_year))->row()->section_id;
?>
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
                              <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" style="background-color: #fff;padding:10px;">
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
            <div class="os-tabs-w">
      <div class="os-tabs-controls">
        <ul class="navs navs-tabs upper">
          <?php 
            $n = 1;
            $children_of_parent = $this->db->get_where('student' , array('parent_id' => $this->session->userdata('parent_id')))->result_array();
            foreach ($children_of_parent as $row): ?>
            <li class="navs-item">
                      <?php $active = $n++;?>
                <a class="navs-links <?php if($active == 1) echo 'active';?>" data-toggle="tab" href="#<?php echo $row['username'];?>"><img alt="" src="<?php echo $this->crud_model->get_image_url('student', $row['student_id']);?>" width="25px" style="border-radius: 25px;margin-right:5px;"> <?php echo $this->crud_model->get_name('student', $row['student_id']);?></a>
              </li>
            <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <br>
        <div class="tab-content">
            <?php 
          $n = 1;
          $children_of_parent = $this->db->get_where('student' , array('parent_id' => $this->session->userdata('parent_id')))->result_array();
                foreach ($children_of_parent as $row2):
                $class_id = $this->db->get_where('enroll' , array('student_id' => $row2['student_id'] , 'year' => $running_year))->row()->class_id;
          $section_id = $this->db->get_where('enroll' , array('student_id' => $row2['student_id'] , 'year' => $running_year))->row()->section_id;
            ?>
          <?php $active = $n++;?>
      <div class="tab-pane <?php if($active == 1) echo 'active';?>" id="<?php echo $row2['username'];?>">
            <div class="element-wrapper">
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
        $book = $this->db->get_where('book', array('class_id' => $class_id))->result_array();
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
      <?php endforeach;?>
    </div>      
  </div>
</div>
<div class="display-type"></div>
</div>