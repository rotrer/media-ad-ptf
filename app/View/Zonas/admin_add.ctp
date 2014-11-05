<?php echo $this->Form->create('Zona', array('class' => 'form-horizontal', 'inputDefaults' => array(
        'label' => false,
        'div' => false
  	))); ?>
<fieldset>

<!-- Form Name -->
<legend>Nueva Zona</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Nombre</label>  
  <div class="col-md-6">
  <?php echo $this->Form->input('name', array('placeholder' => "", 'class' => "form-control input-md", 'required' => "required")); ?>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="id_tag_template">ID Tag Template</label>  
  <div class="col-md-6">
  <?php echo $this->Form->input('id_tag_template', array('placeholder' => "ej: #header", 'class' => "form-control input-md", 'required' => "required")); ?>
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="adunit">AdUnit</label>
  <div class="col-md-6">
  	<?php echo $this->Form->input('adunit', array('empty' => 'Seleccione', 'class' => "form-control adunit_sel_single", 'required' => "required")); ?>
  	<?php echo $this->Form->input('adunit_name', array('type' => 'hidden')); ?>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="site">Sitio</label>
  <div class="col-md-6">
    <?php echo $this->Form->input('site', array('empty' => 'Seleccione', 'class' => "form-control", 'required' => "required")); ?>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Guardar</button>
  </div>
</div>

</fieldset>
<?php echo $this->Form->end(); ?>