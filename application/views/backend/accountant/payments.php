<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<div class="content-w" > 
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
      <div class="conty">
        <div class="os-tabs-w menu-shad">
          <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
              <li class="navs-item">
                <a class="navs-links active" href="<?php echo base_url();?>accountant/payments/"><i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo get_phrase('home');?></span></a>
              </li>
              <li class="navs-item">
                <a class="navs-links" href="<?php echo base_url();?>accountant/students_payments/"><i class="os-icon picons-thin-icon-thin-0426_money_payment_dollars_coins_cash"></i><span><?php echo get_phrase('payments');?></span></a>
              </li>
              <li class="navs-item">
                <a class="navs-links" href="<?php echo base_url();?>accountant/expense/"><i class="os-icon picons-thin-icon-thin-0420_money_cash_coins_payment_dollars"></i><span><?php echo get_phrase('expense');?></span></a>
              </li>
            </ul>
          </div>
        </div><br>
        	<div class="container-fluid" >
	            <div class="layout-w" >
              		<div class="content-w" >
	                  	<div class="content-i" >
                    		<div class="content-box" >
                      			<div class="app-em ail-w">
                      				<div class="ae-conte nt-w">                          
                            			<div class="aec-full-m essage-w">
                                			<div class="aec-full -message" style="background-color:#f2f4f8;">
                                  				<div class="container- fluid">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h2 style="float:left"><?php echo get_phrase('accounting');?></h2>
                                                    </div><hr>
		                                            <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
			                                            <div class="ui-block list" data-mh="friend-groups-item" style="">
				                                            <div class="friend-item friend-groups">
					<div class="friend-item-content">
						<div class="friend-avatar">
						    <br><br>
						    <i class="picons-thin-icon-thin-0383_graph_columns_growth_statistics" style="font-size:45px; color: #99bf2d;"></i>
							<h1 style="font-weight:bold;"><?php echo $this->db->get_where('settings' , array('type'=>'currency'))->row()->description; ?><?php $this->db->where('year' , $running_year); $this->db->where('status', 'completed'); $invoices  = $this->db->get('invoice')->result_array(); $to = 0; foreach($invoices as $r){$to+=$r['amount'];} echo number_format($to);?></h1>
							<div class="author-content">
								<div class="country"><b> <?php echo get_phrase('total_income');?></b></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="ui-block list" data-mh="friend-groups-item" style="">
				<div class="friend-item friend-groups">
					<div class="friend-item-content">
						<div class="friend-avatar">
						    <br><br>
						    <i class="picons-thin-icon-thin-0384_graph_columns_drop_statistics" style="font-size:45px; color: #dd2979;"></i>
							<h1 style="font-weight:bold;"><?php echo $this->db->get_where('settings' , array('type'=>'currency'))->row()->description; ?><?php $this->db->where('payment_type' , 'expense'); $this->db->where('year' , $running_year); $expenses = $this->db->get('payment')->result_array(); $t=0;
            	            foreach ($expenses as $rows){$t+= $rows['amount'];} echo number_format($t);?></h1>
							<div class="author-content">
								<div class="country"><b> <?php echo get_phrase('total_expense');?></b></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="ui-block list" data-mh="friend-groups-item" style="">
				<div class="friend-item friend-groups">
					<div class="friend-item-content">
						<div class="friend-avatar">
						    <br><br>
						    <i class="picons-thin-icon-thin-0406_money_dollar_euro_currency_exchange_cash" style="font-size:45px; color: #f4af08 ;"></i>
							<h1 style="font-weight:bold;"><?php $this->db->where('status', 'pending'); echo $this->db->count_all_results('invoice');?></h1>
							<div class="author-content">
								<div class="country"><b> <?php echo get_phrase('pending_payments');?></b></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="ui-block list" data-mh="friend-groups-item" style="">
				<div class="friend-item friend-groups">
					<div class="friend-item-content">
						<div class="friend-avatar">
						    <br><br>
						    <i class="picons-thin-icon-thin-0406_money_dollar_euro_currency_exchange_cash" style="font-size:45px; color: #0084ff;"></i>
							<h1 style="font-weight:bold;"><?php $this->db->where('status', 'completed'); echo $this->db->count_all_results('invoice');?></h1>
							<div class="author-content">
								<div class="country"><b> <?php echo get_phrase('completed_payments');?></b></div>
							</div> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <hr>
    <div class="row"> 
		<div class="col-sm-6">
			<div class="element-wrapper">
			    <h6 class="element-header"><?php echo get_phrase('recent_income');?></h6>
                <div class="element-box-tp">
                  <div class="table-responsive">
                    <table class="table table-padded">
                      <thead>
                        <tr>
                          <th><?php echo get_phrase('status');?></th>
                          <th><?php echo get_phrase('student');?></th>
                          <th><?php echo get_phrase('title');?></th>
                          <th><?php echo get_phrase('amount');?></th>
                        </tr>
                      </thead>
                      <tbody>
                    <?php
                        $this->db->limit(10);
                        $this->db->where('year' , $running_year);
                        $this->db->order_by('creation_timestamp' , 'desc');
                        $invoices = $this->db->get('invoice')->result_array();
                        foreach($invoices as $row): ?>
                        <tr>
                            <td>
                              <?php if($row['status'] == 'pending'):?>
                                <span class="status-pill yellow"></span><span><?php echo get_phrase('pending');?></span>
                              <?php endif;?>
                              <?php if($row['status'] == 'completed'):?>
                                <span class="status-pill green"></span><span><?php echo get_phrase('paid');?></span>
                              <?php endif;?>
                            </td>
                            <td class="cell-with-media">
                                <a href="<?php echo base_url();?>accountant/invoice_details/<?php echo $row['invoice_id'];?>/" style="color:grey;"><img alt="" src="<?php echo $this->crud_model->get_image_url('student', $row['student_id']);?>" style="height: 25px;"><span> <?php echo $this->crud_model->get_name('student', $row['student_id']);?></span></a>
                            </td>
                            <td><?php echo $row['title'];?></td>
                            <td><a class="badge badge-primary" href="javascript:void(0);"><?php echo $this->db->get_where('settings' , array('type'=>'currency'))->row()->description; ?><?php echo $row['amount'];?></a></td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
		</div>
		
	 
		<div class="col-sm-6">
		   <div class="element-wrapper">
              <h6 class="element-header"><?php echo get_phrase('recent_expense');?></h6>
                <div class="element-box-tp">
                  <div class="table-responsive">
                    <table class="table table-padded">
                      <thead>
                        <tr>
                          <th><?php echo get_phrase('title');?></th>
                          <th><?php echo get_phrase('category');?></th>
                          <th><?php echo get_phrase('amount');?></th>
                          <th><?php echo get_phrase('method');?></th>
                        </tr>
                      </thead>
                      <tbody>
                    <?php 
            	            $this->db->limit(10);
            	            $this->db->where('payment_type' , 'expense');
            	            $this->db->where('year' , $running_year);
                        	$this->db->order_by('timestamp' , 'desc');
            	            $expenses = $this->db->get('payment')->result_array();
            	            foreach ($expenses as $row):
        	            ?>
                        <tr>
                            <td><?php echo $row['title'];?></td>
                            <td><a class="btn btn-sm btn-rounded btn-purple text-white"><?php 
            if ($row['expense_category_id'] != 0 || $row['expense_category_id'] != '')
            echo $this->db->get_where('expense_category' , array('expense_category_id' => $row['expense_category_id']))->row()->name;
                ?></a></td>
                            <td><?php echo $this->db->get_where('settings' , array('type' =>'currency'))->row()->description;?><?php echo $row['amount'];?></td>
                            <td><a class="btn nc btn-rounded btn-sm btn-primary" style="color:white"><?php 
                    if ($row['method'] == 1) echo get_phrase('cash');
                    if ($row['method'] == 2) echo get_phrase('check');
                    if ($row['method'] == 3) echo get_phrase('card');
                ?></a></a></td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
		</div>
		</div>

                                      			<br>                                      
 
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
