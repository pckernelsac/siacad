<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">		
		<div class="os-tabs-controls">		  
			<ul class="navs navs-tabs upper">			
				<li class="navs-item">			  
					<a class="navs-links " href="<?php echo base_url();?>librarian/library/"><i class="os-icon picons-thin-icon-thin-0017_office_archive"></i>
					<span><?php echo get_phrase('library');?></span></a>
				</li>
				<li class="navs-item">			  
					<a class="navs-links active" href="<?php echo base_url();?>librarian/book_request/"><i class="os-icon picons-thin-icon-thin-0086_import_file_load"></i>
					<span><?php echo get_phrase('book_request');?></span></a>
				</li>
			</ul>		
		</div>
	</div>  
        <div class="content-box">
        <br>
        <div class="tab-content ">
            <div class="tab-pane active" id="students">
            <div class="element-wrapper">
                <h6 class="element-header">
                  <?php echo get_phrase('book_request');?>
                </h6>
                <div class="element-box-tp">
                  <div class="table-responsive">
                    <table class="table table-padded">
                      <thead>
                        <tr>
                            <th><?php echo get_phrase('book');?></th>
                            <th><?php echo get_phrase('requested_by');?></th>
                            <th><?php echo get_phrase('starting_date');?></th>
                            <th><?php echo get_phrase('ending_date');?></th>
                            <th><?php echo get_phrase('status');?></th>
                            <th><?php echo get_phrase('options');?></th>
			            </tr>
                      </thead>
                      <tbody>
                       <?php
                        $this->db->order_by('book_request_id', 'desc');
                        $book_requests = $this->db->get('book_request')->result_array();
                        foreach ($book_requests as $row) { ?>   
			           <tr>
                        <td><a href="javascript:void(0);" class="badge badge-success"><?php echo $this->db->get_where('book', array('book_id' => $row['book_id']))->row()->name; ?></a></td>
                        <td><?php echo $this->crud_model->get_name('student', $row['student_id']) ?></td>
                        <td><?php echo date('d/m/Y', $row['issue_start_date']); ?></td>
                        <td><?php echo date('d/m/Y', $row['issue_end_date']); ?></td>
                        <td>
                            <?php
                                if($row['status'] == 0)
                                    $status = '<div class="status-pill yellow" data-title="'. get_phrase('pending').'" data-toggle="tooltip"></div>';
                                else if($row['status'] == 1)
                                    $status = '<div class="status-pill green" data-title="'. get_phrase('approved').'" data-toggle="tooltip"></div>';
                                else
                                    $status = '<div class="status-pill red" data-title="'. get_phrase('rejected').'" data-toggle="tooltip"></div>';
                                echo $status;
                            ?>
                        </td>
                        <td>
                            <?php if($row['status'] == 0) { ?>
                                <a data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('approve');?>" onClick="return confirm('<?php echo get_phrase('confirm_approval');?>')" href="<?php echo base_url();?>librarian/book_request/accept/<?php echo $row['book_request_id'];?>"><i style="color:gray" class="picons-thin-icon-thin-0154_ok_successful_check"></i></a>
						        <a data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('reject');?>" onClick="return confirm('<?php echo get_phrase('confirm_reject');?>')" href="<?php echo base_url();?>librarian/book_request/reject/<?php echo $row['book_request_id'];?>"><i style="color:gray" class="picons-thin-icon-thin-0153_delete_exit_remove_close"></i></a>
                            <?php } else echo get_phrase('no_actions_available'); ?>
                        </td>
			           </tr>
			        <?php } ?>
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