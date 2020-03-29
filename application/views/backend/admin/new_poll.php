<div class="content-w">
     <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
      	<div class="conty">

  <div class="content-i">
	  <div class="content-box">
	        <div class="back" style="margin-top:-20px;margin-bottom:10px">		
	<a href="<?php echo base_url();?>admin/polls/"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>	
	</div>
				  <div class="row">
  				 <div class="col-lg-12">
						<div class="element-wrapper">
	  						<div class="element-box lined-primary shadow">
							<?php echo form_open(base_url() . 'admin/polls/create_wall/' , array('enctype' => 'multipart/form-data'));?>
		  					<h5 class="form-header"><?php echo get_phrase('create_poll');?></h5><br>
		  					<div class="form-group">
			  					<div class="col-sm-12">
			  						<label class="col-form-label" for="" style="text-align: left;"><?php echo get_phrase('question');?></label>
			  						<div class="input-group">
										<div class="input-group-addon">
											<i class="picons-thin-icon-thin-0382_graph_columns_statistics"></i>
				  						</div>
										<input class="form-control" placeholder="<?php echo get_phrase('question');?>" name="question" required="" type="text">
									</div>
			  					</div>
							</div>
							<div id="bulk_add_form">
      							<div id="student_entry">
									<div class="form-group">
			  							<div class="col-sm-12">
			  								<label class="col-form-label" for=""><?php echo get_phrase('options');?></label>
			  									<div class="input-group">
													<input class="form-control" name="options[]" placeholder="<?php echo get_phrase('options');?>" required="" type="text">
													<button class="btn btn-sm btn-danger bulk text-center" href="#" onclick="deleteParentElement(this)"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></button>
												</div>
										</div>
				  					</div>
								</div>
								<div id="student_entry_append"></div>
							</div>	
          					<center><a href="javascript:void(0);" class="btn btn-rounded btn-success btn-sm" onclick="append_student_entry()">+ <?php echo get_phrase('more_options');?></a></center>							<br>
							<div class="form-group">
				            	<div class="col-sm-12">
            						<div class="form-group label-floating is-select">
                                            <label class="control-label"><?php echo get_phrase('users');?></label>
                                                <div class="select">
                                                    <select name="user" id="slct">
                                                        <option value=""><?php echo get_phrase('select');?></option>
                                                        <option value="all"><?php echo get_phrase('all');?></option>
                                                        <option value="admin"><?php echo get_phrase('admins');?></option>
                                                        <option value="student"><?php echo get_phrase('students');?></option>
                                                        <option value="parent"><?php echo get_phrase('parents');?></option>
                                                        <option value="teacher"><?php echo get_phrase('teachers');?></option>    
                                                    </select>
                                                </div>
                                            </div>
              					</div>            	
          					</div>
		  					<div class="form-buttons-w">
								<button class="btn btn-primary btn-rounded" type="submit"> <?php echo get_phrase('save');?></button>
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
</div>
<script type="text/javascript">

   var blank_student_entry = '';

   	$(document).ready(function() 
   	{
      	blank_student_entry = $('#student_entry').html();
      	for ($i = 1; $i < 1; $i++) 
      	{
        	$("#student_entry").append(blank_student_entry);
      	}
   	});
   	function append_student_entry()
   	{
    	$("#student_entry_append").append(blank_student_entry);
   	}
   	function deleteParentElement(n)
   	{
      	n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
   	}
</script>