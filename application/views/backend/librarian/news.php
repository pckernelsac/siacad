<div class="content-w"> 
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
  <div class="content-box">
   <div class="conty">
  <div class="conta iner">
      <h3><?php echo get_phrase('news');?></h3>
  <div class="row">
    <?php
      $this->db->order_by('news_id', 'desc');
      $news = $this->db->get('news')->result_array();
      foreach($news as $wall):
      ?>
    <div class="col col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="ui-block paddingtel">    
        <article class="hentry post has-post-thumbnail thumb-full-width">
            <div class="post__author author vcard inline-items">
                <img src="<?php echo $this->crud_model->get_image_url('admin', $wall['admin_id']);?>">                
                <div class="author-date">
                    <a class="h6 post__author-name fn" href="javascript:void(0);"><?php echo $this->crud_model->get_name('admin', $wall['admin_id']);?></a>
                    <div class="post__date">
                        <time class="published" style="color: #0084ff;"><?php echo $this->db->get_where('news', array('news_id' => $wall['news_id']))->row()->date." ".$this->db->get_where('news', array('news_id' => $wall['news_id']))->row()->date2;?></time>
                    </div>
                </div>                
            </div><hr>
            <p><?php echo $wall['description'];?></p>
            <?php  $file = base_url('uploads/news_images/'.$wall['news_code'].'.jpg');?>
            <?php if (@getimagesize($file)):?>
                <div class="post-thumb">
                    <img src="<?php echo base_url();?>uploads/news_images/<?php echo $wall['news_code'];?>.jpg">
                </div>
            <?php endif;?>
            <div class="control-block-button post-control-button">
                <a href="javascript:void(0);" class="btn btn-control" style="background-color:#001b3d; color:#fff;" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('news');?>">
                    <i class="picons-thin-icon-thin-0032_flag"></i>
                </a>
            </div>
        </article>
    </div>
  </div>
  <?php endforeach;?>
    </div>
    </div>
    </div>
  </div>
</div>