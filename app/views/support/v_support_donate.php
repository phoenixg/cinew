<?php $this->load->helper('MY_others');?>
<div id="">
	<div id=""><h3>donate 流程说明：</h3> [提交表单（数额、联系方式）-联系确认（退回）-评价（退回）-选择一种donate方式]</div>
	<div id=""><h3>donate 声明：</h3> 
		1 donate信息将会对任何人公开，但个人信息（如qq）不会公开，仅公开：数额、捐赠者称谓<br />
		2 这些信息，无论公开非公开，不会用于与donate有关的其他用途<br />
		3 任何donater都有权利查看donate报表，以及donate amount使用情况。点击这里查看。<br />
	</div>
	
	
	<div id="donate_form">
	    <?php 
	    echo validation_errors('<p class="error">');
		echo form_open('support/donate') . "\n";
		echo 'How much would you like to donate?'."\n";
		echo '<br />';
		?>
		<select data-placeholder="Choose an amount..." class="chzn-select" style="width:100px;" name="amount">
 		<?php 
 			$amount = array('5','10','20','30','50','100','200','300','400','500','1000','2000','5000');
 			foreach ($amount as $v)
 			{
 				echo '<option value="'.$v.'">'.'&yen;&nbsp;'.$v.'</option>'."\n";
 			}
 		?>
		</select>
 		<br />
		<?php
		echo 'Please leave your contact info,anything I can contact with you to confirm your 
			  donation, eg Peter(peter@domain.com)/Mary(QQ:)/Mike(cell phone:)';
		$data = array(
              'name'        => 'contact_info',
              'id'          => 'contact_info',
              'value'       => '',
              'maxlength'   => '250',
              'size'        => '50',
              'style'       => 'width:30%',
            );
		
		echo form_input($data) . "\n";
		echo '(>= 5 words)';
		echo '<br />';
		echo form_submit('submit', 'Apply for donation') . "\n";
		echo form_hidden('ip',getIP());
		echo form_close();
		?>
	</div>

</div>

<link rel="stylesheet" href="<?=base_url()?>public/chosen/chosen.css" />
<script src="<?=base_url()?>public/chosen/jquery-1.6.2.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>public/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript"> $(".chzn-select").chosen(); </script>