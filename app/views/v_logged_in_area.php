<h2>Welcome Back, <?php echo $this->session->userdata('username'); ?>!</h2>
<h4><?php echo anchor('member/logout', 'Logout'); ?></h4>
<p>This section represents the area that only logged in members can access.</p>