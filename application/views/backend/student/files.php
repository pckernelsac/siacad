<div class="content-w"> 
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    	<div class="conty">
    		<div class="all-wrapper no-padding-content solid-bg-all">
      			<div class="layout-w">
        			<div class="content-w">
          				<div class="content-i">
            				<div class="content-box">
            					<div class="app-email-w">
  									<div class="app-email-i">
    									<div class="ae-side-menu">
      										<div class="aem-head">
        										<a class="ae-side-menu-toggler" href="#"><i class="picons-thin-icon-thin-0293_phone_call_number_dialer" style="font-size: 19px"></i></a>
      										</div>
      										<ul class="ae-main-menu">
      										    <li><a href="javascript:void(0);" data-toggle="modal" data-target="#bulkupload"><b style="font-size:20px">+</b><span> <?php echo get_phrase('folder');?></span></a></li>
      										    <li class="active"><a href="<?php echo base_url();?>student/files/"><i class="picons-thin-icon-thin-0177_puzzle_module_connect"></i><span><?php echo get_phrase('home');?></span></a></li>
        										<li><a href="<?php echo base_url();?>student/all/"><i class="picons-thin-icon-thin-0130_structure_map_files"></i><span><?php echo get_phrase('all');?></span></a></li>
        										<li><a href="<?php echo base_url();?>student/recent/"><i class="picons-thin-icon-thin-0117_folder_documents_revert_history"></i><span><?php echo get_phrase('recents');?></span></a></li>
        										<li><a href="<?php echo base_url();?>student/folders/"><i class="picons-thin-icon-thin-0111_folder_files_documents"></i><span><?php echo get_phrase('folders');?></span></a></li>
      										</ul>
    									</div>
    									<div class="ae-content-w">
      										<div class="ae-co ntent">        
        										<div class="aec-full-message-w">
          											<div class="aec-full-message">
            											<div class="message-head">
              												<div class="user-w with-status status-green">
                												<div class="user-name">
                  													<h6 class="user-title"><?php echo get_phrase('your_files');?></h6>
                  													<div class="user-role"><?php echo get_phrase('upload_new_file');?></div>
                												</div>
              												</div>
            											</div>
            											<div class="message-cont ent" style="text-align: center;">
              											<div id="dropzone" style="border: 3px dotted #0061da;">
                            <form action="<?php echo base_url();?>dropzone/upload?folder_key=<?php echo $token;?>" class="dropzone needsclick dz-clickable" id="demo-upload" style="border:0px;">
                              <input type="hidden" name="token_key" id="token_key" value="">
                              <div class="dz-message needsclick" id="dropzonePreview" style="min-height: 500px;">
                                <p><img src="<?php echo base_url();?>uploads/drop.svg" style="width: 35%;"></p>
                                <h3><?php echo get_phrase('drag_your_files_here');?><br></h3>
                                <span class="note needsclick">(<?php echo get_phrase('your_files_message');?>).</span>
                              </div>
                            </form>
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
      			</div>
      		<div class="display-type"></div>
    	</div>
	</div>
	
	
	 <div class="modal fade" id="bulkupload" tabindex="-1" role="dialog" aria-labelledby="bulkupload" aria-hidden="true" style="top:50px;">
      <div class="modal-dialog window-popup create-friend-group create-friend-group-1" role="document">
        <div class="modal-content">
        <?php echo form_open(base_url() . 'student/files/create_folder' , array('enctype' => 'multipart/form-data'));?>
          <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
          <div class="modal-header">
            <h6 class="title"><?php echo get_phrase('create_folder');?></h6>
          </div>
          <div class="modal-body">
            <div class="form-group with-button">
              <input class="form-control" placeholder="<?php echo get_phrase('name');?>" name="name" type="text" required>
            </div>
            <button type="submit" class="btn btn-rounded btn-purple btn-lg full-width"><?php echo get_phrase('create');?></button>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
</div>

<script>
 var key = document.getElementById("token_key").value;
 $(function() 
 {
    Dropzone.options.mydropzone = 
    {
        url: '<?php echo base_url();?>dropzone/upload?folder_key='+key, 
        addRemoveLinks: true,
        autoProcessQueue: true,
        autoDiscover: false,
        paramName: 'file', 
        previewsContainer: '#dropzonePreview',
        clickable: '#dropzonePreview',
        accept: function(file, done) {
            done();
        },
        error: function(file, errorMessage) {
        errors = true;
        },
       init: function() {
    this.on('success', function( file, resp ){
       alert("Success");
    });
  }
    };
  });
</script>