<?php echo $this->Form->create('Site', array('controller' => 'sites', 'action' => 'descarga', 'admin' => true, 'class' => 'form-horizontal')); ?>
<?php echo $this->Form->input('site_id', array('type' => 'hidden', 'value' => $site_id)); ?>
<fieldset>

<!-- Form Name -->
<legend>Descargar plugin para sitio: <?php echo $site['Site']['domain']; ?></legend>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="SiteUnq">Habilitar solicitud única</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="SiteUnq">
    	<?php echo $this->Form->input('unq', array('type' => 'checkbox', 'value' => 1, 'label' => false, 'div' => false)); ?>
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="SiteSync">Habilitar la solicitud síncronica</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="SiteSync">
      <?php echo $this->Form->input('sync', array('type' => 'checkbox', 'value' => 1, 'label' => false, 'div' => false)); ?>
    </label>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-success">Descargar Aquí</button>
  </div>
</div>

</fieldset>
<?php echo $this->Form->end(); ?>