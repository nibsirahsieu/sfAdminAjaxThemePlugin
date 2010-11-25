<div id="ajaxThemeConfirmation">
  [?php if ($sf_user->hasFlash('notice')): ?]
    [?php echo __($sf_user->getFlash('notice'), array(), 'sf_admin') ?]
  [?php elseif ($sf_user->hasFlash('error')): ?]
    [?php echo __($sf_user->getFlash('error'), array(), 'sf_admin') ?]
  [?php endif; ?]
</div>