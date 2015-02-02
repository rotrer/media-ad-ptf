<?php echo $this->Form->create('Plugin', array('action' => 'download', 'class' => 'form-horizontal', 'inputDefaults' => array(
        'label' => false,
        'div' => false
    ))); ?>
<fieldset>
<?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $plugin['Plugin']['id'])); ?>
<!-- Form Name -->
<legend>Descargar plugin</legend>

<div class="form-group">
  <label class="col-md-4 control-label" for="SiteUnq">Sitio</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="SiteUnq">
      <?php echo $plugin['Sites']['name']; ?> - <?php echo $plugin['Sites']['domain']; ?>
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="SiteUnq">Plugin</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="SiteUnq">
      <?php echo $plugin['Plugin']['name']; ?>
    </label>
  </div>
</div>

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
      <?php echo $this->Form->input('sync', array('type' => 'checkbox', 'checked' => $hasOop, 'value' => 1, 'label' => false, 'div' => false)); ?>
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

<?php echo $this->Form->create('Plugin', array('action' => 'updaterepo', 'class' => 'form-horizontal', 'inputDefaults' => array(
        'label' => false,
        'div' => false
    ))); ?>
<fieldset>
<?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $plugin['Plugin']['id'])); ?>

<!-- Form Name -->
<legend>Actualizar versión repositorio</legend>

<div class="form-group">
  <label class="col-md-4 control-label" for="SiteUnq">Sitio</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="SiteUnq">
      <?php echo $plugin['Sites']['name']; ?> - <?php echo $plugin['Sites']['domain']; ?>
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="SiteUnq">Plugin</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="SiteUnq">
      <?php echo $plugin['Plugin']['name']; ?>
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="SiteUnq">Versión</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="SiteUnq">
      <?php echo $plugin['Plugin']['version']; ?>
    </label>
  </div>
</div>

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
      <?php echo $this->Form->input('sync', array('type' => 'checkbox', 'checked' => $hasOop, 'value' => 1, 'label' => false, 'div' => false)); ?>
    </label>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="repobutton"></label>
  <div class="col-md-4">
    <button id="repobutton" name="repobutton" class="btn btn-success">Actualizar</button>
  </div>
</div>

</fieldset>
<?php echo $this->Form->end(); ?>