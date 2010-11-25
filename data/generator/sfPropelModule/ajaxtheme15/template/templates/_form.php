[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]
[?php use_javascript(sfConfig::get('app_jquery_form_dir', '/sfAdminAjaxThemePlugin/js/jquery.form.js')) ?]
[?php use_javascript('<?php echo '/sfAdminAjaxThemePlugin/js/admin.form.js' ?>') ?]

<div class="sf_admin_form">
  [?php echo form_tag_for($form, '@<?php echo $this->params['route_prefix'] ?>', array('id' => '<?php echo $this->getModuleName() ?>-form')) ?]
    [?php echo $form->renderHiddenFields(false) ?]

    [?php if ($form->hasGlobalErrors()): ?]
      [?php echo $form->renderGlobalErrors() ?]
    [?php endif; ?]

    [?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?]
      [?php include_partial('<?php echo $this->getModuleName() ?>/form_fieldset', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?]
    [?php endforeach; ?]

    [?php include_partial('<?php echo $this->getModuleName() ?>/form_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
  </form>
</div>
[?php if ($sf_user->hasFlash('notice') || $sf_user->hasFlash('error')): ?]
  [?php if ($sf_user->hasFlash('notice')): ?]
    [?php $message = $sf_user->getFlash('notice') ?]
    [?php $class = 'notice' ?]
  [?php elseif ($sf_user->hasFlash('error')): ?]
    [?php $message = $sf_user->getFlash('error') ?]
    [?php $class = 'error' ?]
  [?php endif; ?]
  <script type="text/javascript">
    showMessage('[?php echo $message ?]', '[?php echo $class ?]');
  </script>
[?php endif; ?]
<script type="text/javascript">
/* <![CDATA[ */
$(function() {
  new setupAjaxForm('<?php echo $this->getModuleName() ?>-form');
});
/* ]]> */
</script>