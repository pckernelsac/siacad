<div class="content-w">
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
    <div class="conty">
      <div class="os-tabs-w menu-shad">
        <div class="os-tabs-controls">
          <ul class="navs navs-tabs upper">
            <li class="navs-item">
              <a class="navs-links" href="<?php echo base_url();?>admin/system_settings/"><i class="os-icon picons-thin-icon-thin-0050_settings_panel_equalizer_preferences"></i><span><?php echo get_phrase('system_settings');?></span></a>
            </li>
            <li class="navs-item">
              <a class="navs-links" href="<?php echo base_url();?>admin/sms/"><i class="os-icon picons-thin-icon-thin-0287_mobile_message_sms"></i><span><?php echo get_phrase('sms');?></span></a>
            </li>
            <li class="navs-item">
              <a class="navs-links " href="<?php echo base_url();?>admin/email/"><i class="os-icon picons-thin-icon-thin-0315_email_mail_post_send"></i><span><?php echo get_phrase('email_settings');?></span></a>
            </li>
            <li class="navs-item">
              <a class="navs-links active" href="<?php echo base_url();?>admin/translate/"><i class="os-icon picons-thin-icon-thin-0307_chat_discussion_yes_no_pro_contra_conversation"></i><span><?php echo get_phrase('translate');?></span></a>
            </li>
            <li class="navs-item">
              <a class="navs-links" href="<?php echo base_url();?>admin/database/"><i class="picons-thin-icon-thin-0356_database"></i><span><?php echo get_phrase('database');?></span></a>
            </li>
          </ul>
        </div>
      </div>
      <div class="content-i">
        <div class="content-box">
          <div class="row">
            <div class="col-sm-12">
              <div class="element-box shadow shadow lined-primary" style="border-radius:10px;">
                  <button class="btn btn-rounded btn-success" data-toggle="modal" data-target="#addlang"><?php echo get_phrase('add_language');?></button><hr>
                <?php if (isset($edit_profile)):?>
                  <?php $current_editing_language = $edit_profile; echo form_open(base_url() . 'admin/translate/update_phrase/'.$current_editing_language); ?>
                  <div class="row" >
                  <?php 
                    $count = 1;
                    $language_phrases = $this->db->query("SELECT `phrase_id` , `phrase` , `$current_editing_language` FROM `language`")->result_array();
                    foreach($language_phrases as $row)
                    {
                      $count++;
                      $phrase_id      = $row['phrase_id'];          
                      $phrase       = $row['phrase'];           
                      $phrase_language  = $row[$current_editing_language];  
                    ?>
                    <div class="col-sm-3">
                      <div class="element-box infodash centered padded" style="background: #a01a7a; border-radius:15px;">
                        <div class="bg-icon">
                          <i class="icon-ghost"></i>
                        </div>
                        <div><h4 style="color: #FFF;"><?php echo $row['phrase'];?></h4></div>
                        <input class="form-control" value="<?php echo $phrase_language;?>" type="text" name="phrase<?php echo $row['phrase_id'];?>" style="border-radius:25px; background-color:#fff;">
                      </div>
                    </div>
                <?php } ?>
                <input type="hidden" name="total_phrase" value="<?php echo $this->db->count_all_results('language');?>">
                  <div class="col-sm-12">
                    <div class="form-buttons-w text-right">
                      <button class="btn btn-rounded btn-primary" type="submit"> <?php echo get_phrase('update');?> </button>
                    </div>
                </div>
              <?php echo form_close(); ?>
            </div>
          <?php endif;?>

          <?php if (!isset($edit_profile)):?>
            <div class="col-md-12">
              <div class="full-chat-middle">
                <div class="chat-content-w min">
                  <div class="chat-content min">
                    <div class="users-list-w">
                      <?php $number = count($this->db->list_fields('language'))-1;
                      $data = $this->db->list_fields('language');
                      for($i = 2; $i <= $number; $i++):
                      ?>
                        <div class="user-w">
                          <div class="user-avatar-w">
                            <div class="user-avatar">
                              <img alt="" src="<?php echo base_url();?>style/flags/<?php echo $data[$i];?>.png">
                            </div>
                          </div>
                          <div class="user-name">
                            <h6 class="user-title"><?php echo ucwords($data[$i]);?></h6>
                          </div>        
                          <a class="btn btn-rounded  btn-primary" href="<?php echo base_url();?>admin/translate/update/<?php echo $data[$i];?>"><i class="picons-thin-icon-thin-0307_chat_discussion_yes_no_pro_contra_conversation"></i> <?php echo get_phrase('update');?></a>
                        </div>
                      <?php endfor;?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endif;?>
      </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="addlang" tabindex="-1" role="dialog" aria-labelledby="addlang" aria-hidden="true" style="margin-top: 150px;">
  <div class="modal-dialog window-popup edit-widget edit-widget-twitter" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo get_phrase('add_language');?></h6>
        <a href="#" class="more" aria-label="Close" class="close" data-dismiss="modal"><i class="icon-feather-x"></i></a>
      </div>
      <div class="modal-body">
          <?php echo form_open(base_url() . 'admin/translate/add/', array('enctype' => 'multipart/form-data')); ?>
            <div class="form-group label-floating is-empty">
                <label class="control-label"><?php echo get_phrase('name');?></label>
                <input class="form-control" name="language" type="text">
            </div>   
           <div class="form-group">
                <label class="control-label"><?php echo get_phrase('flag');?></label>
                <input class="form-control" name="file_name" type="file">
            </div>
      <button class="btn btn-rounded btn-purple  btn-icon-left" type="submit"><?php echo get_phrase('save');?></button></center>
      <?php echo form_close();?>
    </div>
    </div>
  </div>
</div>