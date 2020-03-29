<?php 
    $folder = $this->db->get_where('folder' , array('folder_id' => $param2))->result_array();
    foreach($folder as $row):
?>
    <div class="modal-body">
        <div class="modal-header" style="background-color:#00579c">
            <h6 class="title" style="color:white"><?php echo get_phrase('update_folder');?></h6>
        </div>
        <div class="ui-block-content">
              <?php echo form_open(base_url() . 'teacher/folders/update/'.$row['folder_id'], array('enctype' => 'multipart/form-data'));?>
                <div class="row">
                    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group label-floating">
                            <label class="control-label"><?php echo get_phrase('name');?></label>
                            <input class="form-control" type="text" name="name" required="" value="<?php echo $row['name'];?>">
                        </div>
                    </div>
                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                        <button class="btn btn-rounded btn-success btn-lg " type="submit"><?php echo get_phrase('update');?></button>
                    </div>
                </div>
            <?php echo form_close();?>
        </div>
    </div>
<?php endforeach;?>
 