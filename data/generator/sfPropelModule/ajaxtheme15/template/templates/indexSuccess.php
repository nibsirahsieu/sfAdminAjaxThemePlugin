[?php use_helper('I18N', 'Date') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]
[?php use_javascript('<?php echo '/sfAdminAjaxThemePlugin/js/ajaxTheme-listl.js' ?>') ?]

<div id="sf_admin_container">
  <h1>[?php echo <?php echo $this->getI18NString('list.title') ?> ?]</h1>

  [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]

  <div id="sf_admin_header">
    [?php include_partial('<?php echo $this->getModuleName() ?>/list_header', array('pager' => $pager)) ?]
  </div>

<?php if ($this->configuration->hasFilterForm()): ?>
  <div id="sf_admin_bar">
    [?php include_partial('<?php echo $this->getModuleName() ?>/filters', array('form' => $filters, 'configuration' => $configuration)) ?]
  </div>
<?php endif; ?>

  <div id="sf_admin_content">
<?php if ($this->configuration->getValue('list.batch_actions')): ?>
    <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'batch')) ?]" method="post">
<?php endif; ?>
    <div id="ajaxtheme_list">
      [?php include_partial('<?php echo $this->getModuleName() ?>/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?]
    </div>
    <ul class="sf_admin_actions">
      [?php include_partial('<?php echo $this->getModuleName() ?>/list_batch_actions', array('helper' => $helper)) ?]
      [?php include_partial('<?php echo $this->getModuleName() ?>/list_actions', array('helper' => $helper)) ?]
    </ul>
<?php if ($this->configuration->getValue('list.batch_actions')): ?>
    </form>
<?php endif; ?>
  </div>

  <div id="sf_admin_footer">
    [?php include_partial('<?php echo $this->getModuleName() ?>/list_footer', array('pager' => $pager)) ?]
  </div>
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