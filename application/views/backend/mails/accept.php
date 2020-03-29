<?php 
    $system_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
    $system_email = $this->db->get_where('settings', array('type' => 'system_email'))->row()->description;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta charset="UTF-8">
  <link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body style="margin:0px; background: #39a2d9; font-family: 'Rubik', sans-serif;">
<div width="100%" style="background: #39a2d9; padding: 0px; line-height:28px; height:100%;  width: 100%; color: #606060; ">
  <div style="max-width: 700px; padding:0px;  margin: 2% auto; font-size: 14px; background: #fff; border-top: 5px solid #001b3d; border-radius: 4px;">
  <div style="vertical-align: top; padding-bottom:50px;padding-top:50px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);background: #001b3d;" align="center"><a href="#"><img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logow'))->row()->description;?>" alt="EduappGT | School System Management" style="border:none;max-width:75%"></a></div>
    <div style="padding: 40px; background: #fff;">
      <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
        <tbody>
          <tr>
            <td>
              <p><?php echo $email_msg;?></p>
              <a href="<?php echo base_url();?>" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #39a2d9; border-radius: 60px; text-decoration:none; text-transform: uppercase;"> Sign In Now! </a><br><br>
              <span style="font-size: 16px; font-weight:bold"><?php echo $system_name;?></span> </td> </tr>
        </tbody>
      </table>
    </div>
    <div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px; border-top: 1px solid rgba(0, 0, 0, 0.1); padding:5px;">
        <p> <img alt="" src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" style="vertical-align: middle; height: 20px; width: auto;"> <?php echo $system_name;?><br>
    </div>
  </div>
</body>
</html>
