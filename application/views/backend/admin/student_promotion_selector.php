<hr />
<div class="row" style="text-align: center;">
	<div class="col-sm-4"></div>
	<div class="col-sm-4"></div>
</div>
<div class="element-box">
    <h5 class="form-header"><?php echo get_phrase('student_promotion');?></h5>

	<div class="table-responsive">
        <table class="table table-lightborder table-bordered">
			<thead>
				<tr style="background:#22b9ff;">
					<td class="text-white"><strong><?php echo get_phrase('name');?></strong></td>
					<td align="center" class="text-white"><strong><?php echo get_phrase('section');?></strong></td>
					<td align="center" class="text-white"><strong><?php echo get_phrase('roll');?></strong></td>
					<td align="center" class="text-white"><strong><?php echo get_phrase('options');?></strong></td>
				</tr>
			</thead>
			<tbody>
			<?php 
				$students = $this->db->get_where('enroll' , array('class_id' => $class_id_from , 'year' => $running_year))->result_array();
				foreach($students as $row):
					$query = $this->db->get_where('enroll' , array('student_id' => $row['student_id'],'year' => $promotion_year));?>
				<tr>
					<td><?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->first_name." ".$this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->last_name;?></td>
					<td align="center">
						<?php if($row['section_id'] != '' && $row['section_id'] != 0)
								echo $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;
						?>
					</td>
					<td align="center"><?php echo $row['roll'];?></td>
					<td>
						<?php if($query->num_rows() < 1):?>
                        <div class="form-group is-select">
                            <div class="select">
                                <select name="promotion_status_<?php echo $row['student_id'];?>" required="" id="promotion_status">
								    <option value="<?php echo $class_id_to;?>">
    									<?php echo get_phrase('promote_to') ." - ". $this->crud_model->get_class_name($class_id_to);?>
								    </option>
								    <option value="<?php echo $class_id_from;?>">
								    	<?php echo get_phrase('promote_to') ." - ". $this->crud_model->get_class_name($class_id_from);?></option>
							    </select>
							</div>
                        </div>
						<?php endif;?>
						<?php if($query->num_rows() > 0):?>
							<center><button class="btn btn-primary" type="button"><i class="picons-thin-icon-thin-0154_ok_successful_check"></i> <?php echo get_phrase('promoted');?></button></center>
						<?php endif;?>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	</div>
	</div>
<br>
	<center><button class="btn btn-success" type="submit"><i class="icon-paper-plane"></i>  <?php echo get_phrase('promote');?></button></center>

<script type="text/javascript">

	$(document).ready(function() {
        if($.isFunction($.fn.selectBoxIt))
		{
			$("select.selectboxit").each(function(i, el)
			{
				var $this = $(el),
					opts = {
						showFirstOption: attrDefault($this, 'first-option', true),
						'native': attrDefault($this, 'native', false),
						defaultText: attrDefault($this, 'text', ''),
					};
					
				$this.addClass('visible');
				$this.selectBoxIt(opts);
			});
		}
    });
</script>
<script type="text/javascript">
    function get_class_sections(class_id) 
    {
        $.ajax({
            url: '<?php echo base_url();?>admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });
    }
</script>
