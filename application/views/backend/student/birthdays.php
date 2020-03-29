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
                                             <div class="ae-content-w" style="background-color: #f2f4f8;">
                                                       <div class="top-header top-header-favorit">
                                                            <div class="top-header-thumb">
                                                                 <img src="<?php echo base_url();?>uploads/bglogin.jpg" alt="nature" style="height:180px; object-fit:cover;">
                                                                 <div class="top-header-author">
                                                                      <div class="author-thumb">
                                                                           <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" alt="author" style="background-color: #fff; padding:10px">
                                                                      </div>
                                                                      <div class="author-content">
                                                                           <a href="javascript:void(0);" class="h3 author-name"><?php echo get_phrase('birthdays');?></a>
                                                                           <div class="country"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>  |  <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?></div>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                            <div class="profile-section" style="background-color: #fff;">
                                                                 <div class="control-block-button">
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  <div class="aec-full-message-w">
                                                       <div class="aec-full-message">
                                                            <div class="container-fluid" style="background-color: #f2f4f8;"><br>
                                                                 <div class="col-sm-12">                           
                                                                           <div class="row">
                                                                                <?php
                                                                                     for ($i = 1; $i <= 12; $i++):
                                                                                     if ($i == 1) {$m = get_phrase('january'); $ma = 01;}
                                                                                     else if ($i == 2) {$m = get_phrase('february'); $ma = 02;}
                                                                                     else if ($i == 3) {$m = get_phrase('march'); $ma = 03;}
                                                                                     else if ($i == 4) {$m = get_phrase('april'); $ma = 04;}
                                                                                     else if ($i == 5) {$m = get_phrase('may'); $ma = 05;}
                                                                                     else if ($i == 6) {$m = get_phrase('june'); $ma = 06;}
                                                                                     else if ($i == 7) {$m = get_phrase('july'); $ma = 07;}
                                                                                     else if ($i == 8) {$m = get_phrase('august'); $ma = 08;}
                                                                                     else if ($i == 9) {$m = get_phrase('september'); $ma = 09;}
                                                                                     else if ($i == 10) {$m = get_phrase('october'); $ma = 10;}
                                                                                     else if ($i == 11) {$m = get_phrase('november'); $ma = 11;}
                                                                                     else if ($i == 12) {$m = get_phrase('december');  $ma = 12;}
                                                                                ?>
                                                                                     <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                          <div class="ui-block" style="background:#99bf2d;">
                                                                                               <div class="ui-block-title">
                                                                                                    <h6 class="title text-white"><?php echo $m; ?></h6>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                     <?php 
                                                                                          $data = $this->crud_model->get_birthdays_by_month($ma);
                                                                                          foreach($data as $day):
                                                                                     ?>
                                                                                          <div class="col col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                                               <div class="ui-block">
                                                                                                    <div class="birthday-item inline-items">
                                                                                                         <div class="author-thumb">
                                                                                                              <img width="35px" src="<?php echo $this->crud_model->get_image_url($day['type'], $day['user_id']);?>">
                                                                                                         </div>
                                                                                                         <div class="birthday-author-name">
                                                                                                              <a href="javascript:void(0);" class="h6 author-name"><?php echo $this->crud_model->get_name($day['type'], $day['user_id']);?></a>
                                                                                                              <div class="birthday-date"><?php echo get_phrase('birthday');?>: <?php echo $day['birthday'];?></div>
                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     <?php endforeach;?>
                                                                                <?php endfor; ?>
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
</div>