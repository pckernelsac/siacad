<div class="content-w"> 
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
    <div class="content-i">
      <div class="content-box">
        <div class="conty">
          <div class="row">        
            <main class="col col-xl-6 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
              <div class="ui-block paddingtel">                                
                <div class="news-feed-form">
                  <div class="tab-content">
                    <div class="edu-wall-content ng-scope" id="new_post">
                      <div class="tab-pane active show">
                        <?php echo form_open(base_url() . 'admin/news/create/', array('enctype' => 'multipart/form-data')); ?>
                        <div class="author-thumb" style="padding-right:15px;">
                          <img src="<?php echo $this->crud_model->get_image_url('admin', $this->session->userdata('login_user_id'));?>" style="width:45px;">
                        </div>
                        <div class="form-group with-icon label-floating is-empty" style="padding-left:10px;">
                          <textarea onkeyup="textAreaAdjust(this)" style="overflow:hidden" class="form-control" placeholder="<?php echo get_phrase('hi');?> <?php echo $this->db->get_where('admin', array('admin_id' => $this->session->userdata('login_user_id')))->row()->first_name;?> <?php echo get_phrase('what_publish');?>" name="description" required=""></textarea>
                          <span class="material-input"></span>
                        </div>
                        <div class="form-group" style="margin-bottom:-15px;">
                          <input type="file" name="userfile" id="file-3" class="inputfile inputfile-3" style="display:none">
                          <label style="font-size:15px;" for="file-3"><i class="os-icon picons-thin-icon-thin-0042_attachment"></i> <span><?php echo get_phrase('upload_image');?>...</span></label>
                        </div>
                        <div class="add-options-message btm-post edupostfoot edu-wall-actions" style="padding:10px 5px;">
                          <a href="javascript:void(0);" class="options-message" onclick="post()" data-toggle="tooltip" data-placement="top"   data-original-title="<?php echo get_phrase('news');?>">
                            <i class="os-icon picons-thin-icon-thin-0032_flag"></i>
                          </a>
                          <a href="javascript:void(0);" class="options-message" onclick="poll()" data-toggle="tooltip" data-placement="top"   data-original-title="<?php echo get_phrase('polls');?>">
                            <i class="os-icon picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                          </a>
                          <button class="btn btn-rounded btn-success" style="float:right"><i class="picons-thin-icon-thin-0317_send_post_paper_plane" style="font-size:12px"></i> <?php echo get_phrase('publish');?></button>
                        </div>        
                        <?php echo form_close();?>
                      </div>                          
                    </div>
                    <script>
                        function textAreaAdjust(o) {
                            o.style.height = "1px";
                            o.style.height = (25+o.scrollHeight)+"px";
                        }
                    </script>
                    <div class="edu-wall-content ng-scope" id="new_poll" style="display: none;"> 
                    <?php echo form_open(base_url() . 'admin/polls/create/' , array('enctype' => 'multipart/form-data'));?>
                      <div class="tab-pane active show"><br>
                        <div class="col-sm-12"><h5 class="form-header"><?php echo get_phrase('create_poll');?></h5></div>
                        <div class="form-group">
                          <div class="col-sm-12">
                            <div class="form-group label-floating">
                              <label class="control-label"><?php echo get_phrase('question');?></label>
                              <input class="form-control" type="text" name="question">
                              <span class="material-input"></span>
                              <span class="material-input"></span>
                            </div>
                          </div>
                        </div><br>
                        <div id="bulk_add_form">
                          <div id="student_entry">
                            <div class="form-group">
                              <div class="col-sm-12">
                                <label class="col-form-label" for=""><?php echo get_phrase('options');?></label>
                                <div class="input-group">
                                  <input class="form-control" name="options[]" placeholder="<?php echo get_phrase('options');?>" type="text">
                                  <button class="btn btn-sm btn-danger bulk text-center" href="javascript:void(0);" onclick="deleteParentElement(this)"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="student_entry_append"></div>
                        </div>  <br>
                        <center><a href="javascript:void(0);" class="btn btn-rounded btn-primary btn-sm" onclick="append_student_entry()">+ <?php echo get_phrase('more_options');?></a></center><br>
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
                        </div><br>
                    <?php echo form_close();?>
                        <div class="add-options-message btm-post edupostfoot edu-wall-actions" style="padding:10px 5px;">
                          <a href="javascript:void(0);" class="options-message" onclick="post()" data-toggle="tooltip" data-placement="top"   data-original-title="<?php echo get_phrase('news');?>">
                            <i class="os-icon picons-thin-icon-thin-0032_flag"></i>
                          </a>
                          <a href="javascript:void(0);" class="options-message" onclick="poll()" data-toggle="tooltip" data-placement="top"   data-original-title="<?php echo get_phrase('poll');?>">
                            <i class="os-icon picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                          </a>
                          <button class="btn btn-rounded btn-success" style="float:right"><i class="picons-thin-icon-thin-0317_send_post_paper_plane" style="font-size:12px"></i> <?php echo get_phrase('publish');?></button>
                        </div>        
                      </div>    
                    <?php echo form_close();?>
                  </div> 
                </div>
              </div>                
            </div>
            <div id="panel">
            <?php 
              $db = $this->db->query('SELECT description, publish_date, type,news_id FROM news UNION SELECT question,publish_date,type,id FROM polls ORDER BY publish_date DESC')->result_array();
              foreach($db as $wall):
            ?>
            <?php if($wall['type'] == 'news'):?>
              <div class="ui-block paddingtel">    
              <?php 
                $news_code = $this->db->get_where('news', array('news_id' => $wall['news_id']))->row()->news_code;
                $admin_id = $this->db->get_where('news', array('news_id' => $wall['news_id']))->row()->admin_id;?>    
                <article class="hentry post has-post-thumbnail thumb-full-width">
                  <div class="post__author author vcard inline-items">
                    <img src="<?php echo $this->crud_model->get_image_url('admin', $admin_id);?>">                
                    <div class="author-date">
                      <a class="h6 post__author-name fn" href="javascript:void(0);"><?php echo $this->crud_model->get_name('admin', $admin_id);?></a>
                      <div class="post__date">
                        <time class="published" style="color: #0084ff;"><?php echo $this->db->get_where('news', array('news_id' => $wall['news_id']))->row()->date." ".$this->db->get_where('news', array('news_id' => $wall['news_id']))->row()->date2;?></time>
                      </div>
                    </div>                
                    <div class="more">
                      <i class="icon-options"></i>                                
                      <ul class="more-dropdown">
                        <li><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_wall/<?php echo $news_code;?>');"><?php echo get_phrase('edit');?></a></li>
                        <li><a onClick="return confirm('<?php echo get_phrase('confirm_delete');?>')"  href="<?php echo base_url();?>admin/news/delete/<?php echo $news_code;?>"><?php echo get_phrase('delete');?></a></li>
                      </ul>
                    </div>
                  </div><hr>
                  <p><?php echo $wall['description'];?></p>
                  <?php 
                    $file = base_url('uploads/news_images/'.$news_code.'.jpg');?>
                    <?php if (@getimagesize($file)):?>
                    <div class="post-thumb">
                      <img src="<?php echo base_url();?>uploads/news_images/<?php echo $news_code;?>.jpg">
                    </div>
                    <?php endif;?>
                    <div class="control-block-button post-control-button">
                      <a href="javascript:void(0);" class="btn btn-control" style="background-color:#001b3d; color:#fff;" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('news');?>">
                        <i class="picons-thin-icon-thin-0032_flag"></i>
                      </a>
                    </div>
                  </article>
                </div>
              <?php endif;?>
              <?php if($wall['type'] == 'polls'):?>
                <?php echo form_open(base_url() . 'admin/polls/response/' , array('enctype' => 'multipart/form-data'));?>
                <?php 
                  $usrdb = $this->db->get_where('polls', array('id' => $wall['news_id']))->row()->user;
                  $poll_code = $this->db->get_where('polls', array('id' => $wall['news_id']))->row()->poll_code;
                  $admin_id = $this->db->get_where('polls', array('id' => $wall['news_id']))->row()->admin_id;
                  $options = $this->db->get_where('polls', array('id' => $wall['news_id']))->row()->options;
                ?>  
                <?php if($usrdb == 'admin' || $usrdb == 'all'):?>
                <?php 
                  $type = 'admin';
                  $id = $this->session->userdata('login_user_id');
                  $user = $type. "-".$id;
                  $query = $this->db->get_where('poll_response', array('poll_code' => $poll_code, 'user' => $user));
                ?>
                <?php if($query->num_rows() <= 0):?>
                  <div class="ui-block paddingtel">
                    <input type="hidden" name="poll_code" id="poll_code" value="<?php echo $poll_code;?>">
                    <article class="hentry post">
                      <div class="post__author author vcard inline-items">
                        <img src="<?php echo $this->crud_model->get_image_url('admin', $admin_id);?>" alt="author">
                        <div class="author-date">
                          <a class="h6 post__author-name fn" href="javascript:void(0);"><?php echo $this->crud_model->get_name('admin', $admin_id);?></a>
                          <div class="post__date">
                            <time class="published" style="color: #0084ff;"><?php echo $this->db->get_where('polls', array('id' => $wall['news_id']))->row()->date." ".$this->db->get_where('polls', array('id' => $wall['news_id']))->row()->date2;?></time>
                          </div>
                        </div>
                        <div class="more">
                          <i class="icon-options"></i>                                
                          <ul class="more-dropdown">
                            <li><a href="<?php echo base_url();?>admin/view_poll/<?php echo $poll_code;?>/"><?php echo get_phrase('go_to_details');?></a></li>
                            <li><a onClick="return confirm('<?php echo get_phrase('confirm_delete');?>')" href="<?php echo base_url();?>admin/polls/delete/<?php echo $poll_code;?>"><?php echo get_phrase('delete');?></a></li>
                          </ul>
                        </div>
                      </div><hr>
                      <div class="control-block-button post-control-button">
                        <a href="javascript:void(0);" class="btn btn-control" style="background-color:#99bf2d; color:#fff;" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('polls');?>">
                          <i class="picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                        </a>
                      </div> 
                      <ul class="widget w-pool">
                        <li><h4><?php echo $wall['description'];?></h4></li><br>
                        <?php 
                          $array = ( explode(',' , $options));
                          for($i = 0 ; $i<count($array)-1; $i++):
                        ?>
                        <li>
                          <div class="skills-item">
                            <div class="skills-item-info">
                            <span class="skills-item-title">
                              <span class="radio">
                                <h6><label>
                                <input type="radio" id="answer" name="answer<?php echo $poll_code;?>" value="<?php echo $array[$i];?>"><span class="circle"></span><span class="check"></span>
                                <?php echo $array[$i];?>
                                </label></h6>
                              </span>
                            </span>
                            </div>
                            </div>  
                          </li>
                        <?php endfor;?>
                        </ul>
                        <a href="javascript:void(0);" class="btn btn-md-2 btn-border-think custom-color c-grey full-width" onClick="vote('<?php echo $poll_code;?>')"><?php echo get_phrase('vote');?><div class="ripple-container"></div></a>
                      </article>
                      </div>
                    <?php endif;?>
                    <?php if($query->num_rows() > 0):?>
                    <div class="ui-block paddingtel">
                      <article class="hentry post">
                        <div class="post__author author vcard inline-items">
                          <img src="<?php echo $this->crud_model->get_image_url('admin', $admin_id);?>">
                          <div class="author-date">
                            <a class="h6 post__author-name fn" href="javascript:void(0);"><?php echo $this->crud_model->get_name('admin', $admin_id);?></a>
                            <div class="post__date">
                              <time class="published" style="color: #0084ff;"><?php echo $this->db->get_where('polls', array('id' => $wall['news_id']))->row()->date." ".$this->db->get_where('polls', array('id' => $wall['news_id']))->row()->date2;?>
                              </time>
                            </div>
                          </div>
                          <div class="more">
                            <i class="icon-options"></i>                                
                            <ul class="more-dropdown">
                              <li><a href="<?php echo base_url();?>admin/view_poll/<?php echo $poll_code;?>/"><?php echo get_phrase('go_to_details');?></a></li>
                              <li><a onClick="return confirm('<?php echo get_phrase('confirm_delete');?>')" href="<?php echo base_url();?>admin/polls/delete/<?php echo $poll_code;?>"><?php echo get_phrase('delete');?></a></li>
                            </ul>
                          </div>
                        </div><hr>
                        <div class="control-block-button post-control-button">
                          <a href="javascript:void(0);" class="btn btn-control" style="background-color:#99bf2d; color:#fff;" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('polls');?>">
                            <i class="picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                          </a>
                        </div>
                        <div>
                          <ul class="widget w-pool">
                            <li>
                              <h4><?php echo $wall['description'];?></h4>
                            </li><br>
                            <?php 
                              $this->db->where('poll_code', $poll_code);
                              $polls = $this->db->count_all_results('poll_response');
                              $array = ( explode(',' , $options));
                              $questions = count($array)-1;
                              $op = 0;
                              for($i = 0 ; $i<count($array)-1; $i++):
                            ?>
                            <?php 
                              $this->db->group_by('poll_code');
                              $po = $this->db->get_where('poll_response', array('poll_code' => $poll_code))->result_array();
                              foreach($po as $p):
                            ?>
                            <li>
                              <div class="skills-item">
                                <div class="skills-item-info">
                                  <span class="skills-item-title">
                                  <?php 
                                    $this->db->where('answer', $array[$i]);
                                    $res = $this->db->count_all_results('poll_response');
                                  ?>
                                  <h6><label><?php echo $array[$i];?></label></h6>
                                  </span>
                                  <?php 
                                    $response = $res/$polls;
                                    $response2 = $response*100;
                                  ?>
                                  <span class="skills-item-count">
                                    <span class="count-animate" data-speed="1000" data-refresh-interval="50" data-to="62" data-from="0"></span>
                                    <span class="units"><?php echo round($response2);?>/100%</span>
                                  </span>
                                </div>
                                <div class="skills-item-meter">
                                  <span class="skills-item-meter-active bg-primary skills-animate" style="width: <?php echo $response2;?>%; opacity: 1;"></span>
                                </div>
                              </div>
                            </li>
                          <?php endforeach;?>
                        <?php endfor;?>
                      </ul>
                    </div>
                  </article>
                </div>
              <?php endif;?>
              <?php endif;?>
              <?php echo form_close();?>
              <?php endif;?>
              <?php endforeach;?>
            </div>
          </main>
          <div class="col col-xl-3 order-xl-1 col-lg-6 order-lg-2 col-md-6 col-sm-12 col-12">
            <div class="crumina-sticky-sidebar">
              <div class="sidebar__inner">
                <div class="ui-block paddingtel">
                  <div class="ui-block-content">
                    <div class="widget w-about">
                      <a href="javascript:void(0);" class="logo"><img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" title="<?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>"></a>
                      <ul class="socials">
                        <li><a href="<?php echo $this->db->get_where('settings', array('type' => 'facebook'))->row()->description;?>"><i class="fab fa-facebook-square" aria-hidden="true"></i></a></li>
                        <li><a href="<?php echo $this->db->get_where('settings', array('type' => 'twitter'))->row()->description;?>"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="<?php echo $this->db->get_where('settings', array('type' => 'youtube'))->row()->description;?>"><i class="fab fa-youtube" aria-hidden="true"></i></a></li>
                        <li><a href="<?php echo $this->db->get_where('settings', array('type' => 'instagram'))->row()->description;?>"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="ui-block paddingtel">
				    <div class="widget w-create-fav-page">
    					<div class="icons-block" style="margin-bottom: 10px;">
						    <i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate text-white" style="font-size:25px;"></i>
					    </div>
					    <div class="content">
						    <h3 class="title"><?php echo get_phrase('welcome_admin_dashboard');?></h3>
					    </div>
				    </div>
			    </div>
                <div class="ui-block paddingtel" >
                  <div class="pipeline white lined-success" >
                    <div class="element-wrapper" >
                      <h6 class="element-header"><?php echo get_phrase('online_users');?></h6>
                      <?php 
                        if(!isset($_SESSION)){session_start();}
                        $session    = session_id();
                        $time       = time();
                        $time_check = $time-300;
                        $this->db->where('session', $session);
                        $count = $this->db->get('online_users')->num_rows();
                        if($count == 0)
                        { 
                          $data['time'] = $time;
                          $data['type'] = $this->session->userdata('login_type');
                          $data['id_usuario'] = $this->session->userdata('login_user_id');
                          $data['gp'] = $this->session->userdata('login_user_id')."-".$this->session->userdata('login_type');
                          $data['session'] = $session;
                          $this->db->insert('online_users',$data);
                        }
                        else 
                        {
                          $data['session'] = $session;
                          $data['time'] = $time;
                          $data['gp'] = $this->session->userdata('login_user_id')."-".$this->session->userdata('login_type');
                          $data['id_usuario'] = $this->session->userdata('login_user_id');
                          $data['type'] = $this->session->userdata('login_type');
                          $this->db->where('session', $session);
                          $this->db->update('online_users', $data);
                        }  
                        $this->db->where('time <', $time_check);
                        $this->db->delete('online_users');
                      ?>          
                        <div class="full-ch at-w">
                          <div class="chat-content-w min">
                            <div class="chat-content min">  
                              <div class="users-list-w">
                              <?php  
                                $this->db->group_by('gp');
                                $usuarios = $this->db->get('online_users')->result_array();
                                foreach($usuarios as $row): ?>
                                <div class="user-w with-status min status-green">
                                  <div class="user-avatar-w min">
                                    <div class="user-avatar" >
                                      <img alt="" src="<?php echo $this->crud_model->get_image_url($row['type'], $row['id_usuario']);?>">
                                    </div>
                                  </div>
                                  <div class="user-name">
                                    <h6 class="user-title min"><?php echo $this->crud_model->get_name($row['type'], $row['id_usuario']);?></h6>
                                    <div class="user-role min">
                                    <?php if($row['type'] == 'student'):?>
                                      <span class="badge badge-warning"><?php echo get_phrase('student');?></span>
                                    <?php endif;?>
                                    <?php if($row['type'] == 'accountant'):?>
                                      <span class="badge badge-info"><?php echo get_phrase('accountant');?></span>
                                    <?php endif;?>
                                    <?php if($row['type'] == 'librarian'):?>
                                      <span class="badge badge-info"><?php echo get_phrase('librarian');?></span>
                                    <?php endif;?>
                                    <?php if($row['type'] == 'parent'):?>
                                      <span class="badge badge-purple"><?php echo get_phrase('parent');?></span>
                                    <?php endif;?>
                                    <?php if($row['type'] == 'admin'):?>
                                      <span class="badge badge-primary"><?php echo get_phrase('admin');?></span> 
                                    <?php endif;?>
                                    <?php if($row['type'] == 'teacher'):?>
                                      <span class="badge badge-success"><?php echo get_phrase('teacher');?></span>
                                    <?php endif;?>
                                    </div>
                                  </div>            
                                </div>
                                <?php endforeach;?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="ui-block paddingtel">
                    <div class="ui-block-title">
                    <h6 class="title"><?php echo get_phrase('accounting');?></h6>
                  </div>
                  <div class="ui-block-content">
                    <canvas id="myChart" width="400" height="400"></canvas>
                  </div>
                </div>
                <div class="header-spacer"></div>
              </div>
            </div>
          </div>
          <div class="col col-xl-3 order-xl-3 col-lg-6 order-lg-3 col-md-6 col-sm-12 col-12">
            <div class="crumina-sticky-sidebar">
              <div class="sidebar__inner">
                <div class="ui-block paddingtel">
                  <div class="today-events calendar ">
                    <div class="today-events-thumb">
                      <div class="date">
                        <div class="day-number"><?php echo date('d');?></div>
                        <div class="day-week"><?php echo date('l');?></div>
                        <div class="month-year" style="color:#FFF"><?php echo date('F');?>, <?php echo date('Y');?>.</div>
                      </div>
                    </div>
                    <div class="list">
                      <div class="control-block-button">
                        <a href="<?php echo base_url();?>admin/calendar/" class="btn btn-control bg-breez" style="background-color: #22b9ff;">
                          <i class="fa fa-plus text-white"></i>
                        </a>
                      </div>
                      <?php $date = date('Y-m-d')." "."00:00:00";
                        $events = $this->db->get_where('events', array('start' => $date)); ?>
                        <div id="accordion-1" role="tablist" aria-multiselectable="true" class="day-event" data-month="12" data-day="2">
                        <?php  if($events->num_rows() > 0):?>
                        <?php foreach($events->result_array() as $event): ?>
                          <div class="card">
                            <div class="card-header" role="tab" id="headingOne-1">
                              <div class="event-time">
                                <h5 class="mb-0 title"><a href="<?php echo base_url();?>admin/calendar/"><?php echo $event['title'];?></a></h5>
                              </div>
                            </div>
                          </div>
                        <?php endforeach;?>
                        <?php else:?>
                        <center><div style="padding-bottom : 75px;padding-top :75px;"><p><?php echo get_phrase('no_today_events');?></p><img src="<?php echo base_url();?>uploads/calendar.png" width="20%"/></div></center>
                        <?php endif;?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="ui-block paddingtel">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                      <ol class="carousel-indicators">
                      <?php 
                        $var = 0;
                        $var1 = 0;
                        $birthdays = $this->crud_model->get_birthdays();
                        foreach($birthdays as $birth):
                        $var++;
                      ?>
                        <li data-target="#myCarousel" data-slide-to="<?php echo $var-1;?>" class="<?php if($var == 1) echo "active";?>"></li>
                      <?php endforeach;?>
                      </ol>
                      <div class="carousel-inner">
                        <?php foreach($birthdays as $day): $var1++;?>
                          <div class="item <?php if($var1 == 1) echo "active";?>">
                            <div class="widget w-birthday-alert">
                              <div class="icons-block">
                                <i class="picons-thin-icon-thin-0447_gift_wrapping"></i>
                              </div>
                              <div class="content">
                                <div class="author-thumb">
                                  <img src="<?php echo $this->crud_model->get_image_url($day['type'], $day['user_id']);?>" class="bg-white">
                                </div>
                                <span><?php echo get_phrase('this_month_is_birthday');?></span>
                                <a href="#" class="h4 title"><?php echo $this->crud_model->get_name($day['type'], $day['user_id']);?></a>
                                <a href="<?php echo base_url();?>admin/birthdays/" class="text-white"><p><?php echo get_phrase('view_all_birthdays');?></p></a>
                              </div>
                            </div>
                          </div>
                        <?php endforeach;?>
                        <a class="left carousel-control" href="#myCarousel" data-slide="prev"></a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next"></a>
                      </div>
                    </div>
                  </div>
                  <div class="ui-block paddingtel">
                    <div class="ui-block-title"><h6 class="title"><?php echo get_phrase('absent_students');?></h6></div>
                    <?php
                      $check  = array('timestamp' => strtotime(date('Y-m-d')) , 'status' => '2');
                      $query = $this->db->get_where('attendance' , $check);
                      $absent_today   = $query->result_array();
                    ?>
                    <?php if($query->num_rows() > 0):?>
                      <ul class="widget w-friend-pages-added notification-list friend-requests">                  
                      <?php foreach($absent_today as $attendance):?>
                        <li class="inline-items">
                          <div class="author-thumb">
                            <img src="<?php echo $this->crud_model->get_image_url('student', $attendance['student_id']);?>" alt="author" width="35px">
                          </div>
                          <div class="notification-event">
                            <a href="<?php echo base_url();?>admin/student_portal/<?php echo $attendance['student_id'];?>/" class="h6 notification-friend"><?php echo $this->crud_model->get_name('student', $attendance['student_id']);?></a>
                            <span class="chat-message-item"><?php echo $this->db->get_where('class', array('class_id' => $attendance['class_id']))->row()->name;?></span>
                          </div>
                        </li>
                        <?php endforeach;?>
                      </ul>
                    <?php else:?>
                    <center>
                      <div style="padding-bottom : 75px;padding-top :75px;"><p><?php echo get_phrase('no_absent_students');?></p><img src="<?php echo base_url();?>uploads/plan.png" width="20%"></div></center>
                    <?php endif;?>
                    <div class="header-spacer"></div>
                  </div><br>
                </div>
              </div> 
            </div>
          </div>
        </div>
        <a class="back-to-top" href="javascript:void(0);">
          <img src="<?php echo base_url();?>style/olapp/svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
        </a>
      </div>
    </div>
  </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
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
<script>
  function post()
  {
    $("#new_post").show(500);
    $("#new_poll").hide(500);
  }
  
  function poll()
  {
    $("#new_post").hide(500);    
    $("#new_poll").show(500);
  }
</script>
<script>
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['<?php echo get_phrase('expense');?>', '<?php echo get_phrase('income');?>'],
        datasets: [{
            label: '#<?php echo get_phrase('accounting');?>',
            data: [<?php echo $this->crud_model->get_expense(date('M'));?>, <?php echo $this->crud_model->get_payments(date('M'));?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(153, 191, 45, 0.7)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(153, 191, 45, 1)'
            ],
            borderWidth: 1
        }]
    }, 
    options: {
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: !0,
                            userCallback: function (value, index, values) {
                                value = value.toString();
                                value = value.split(/(?=(?:...)*$)/);
                                value = value.join('.');
                                return '$' + value;
                            }
                        }
                }]
        },
        tooltips: {
            mode: 'label',
            label: 'mylabel',
            callbacks: {
                label: function (tooltipItem, data) {
                    var value = Number(data.datasets[0].data[tooltipItem.index]).toFixed(2);
                    return '$' + number_format(value);
                }, },
        }
    }
});

function number_format(number, decimals, dec_point, thousands_point) {
    if (number == null || !isFinite(number)) {
        throw new TypeError("number is not valid");
    }
    if (!decimals) {
        var len = number.toString().split('.').length;
        decimals = len > 1 ? len : 0;
    }
    if (!dec_point) {
        dec_point = '.';
    }
    if (!thousands_point) {
        thousands_point = ',';
    }
    number = parseFloat(number).toFixed(decimals);
    number = number.replace(".", dec_point);
    var splitNum = number.split(dec_point);
    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
    number = splitNum.join(dec_point);
    return number;
}
</script>
<script>
    var post_message        =   '<?php echo get_phrase('thank_you_polls');?>';
    function vote(poll_code)
    {
      answer = $('input[name=answer'+poll_code+']:checked').val();
      if(answer!="" && poll_code!="")
      {
        $.ajax({url:"<?php echo base_url();?>admin/polls/response/",type:'POST',data:{answer:answer,poll_code:poll_code},success:function(result)
        {
          $('#panel').load(document.URL + ' #panel');
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 8000
            }); 
            Toast.fire({
            type: 'success',
            title: post_message
            })
        }});
      }else{
        alert('<?php echo get_phrase('select_an_option');?>');
      }
    }
</script>