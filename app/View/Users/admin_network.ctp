<?php echo $this->Form->create(null, array('controller' => 'users', 'action' => 'login', 'class' => 'form-horizontal')); ?>
	<fieldset>

	<!-- Form Name -->
	<legend>Seleecione Network de trabajo</legend>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="email">Networks</label>  
	  <div class="col-md-6">
	    <ul class="list-group">
			  <?php foreach ($networks as $key => $net) { ?>
			  <li class="list-group-item">
			  	<?php echo $this->Html->link($net->displayName, array('controller' => 'pages', 'action' => 'setnetwork', $net->networkCode), array('escape' => false)); ?>
			  </li>
				<?php } ?>
			</ul>
	  </div>
	</div>
	
	</fieldset>
<?php echo $this->Form->end(); ?>