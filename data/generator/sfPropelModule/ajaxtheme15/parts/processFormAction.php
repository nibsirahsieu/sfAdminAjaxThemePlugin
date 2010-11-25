  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $ajaxify = $request->getParameter('ajaxify', 0);
    if ($ajaxify) $results = array('type' => '', 'message' => '', 'fields' => array());
    
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $results['type'] = 'success';
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';
      $<?php echo $this->getSingularName() ?> = $form->save();
      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $<?php echo $this->getSingularName() ?>)));
      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice .' You can add another one below.');
        if ($ajaxify == 1) {
          $results['redirectToUrl'] = $this->getController()->genUrl('@<?php echo $this->getUrlForAction('new') ?>');
        } else {
          $this->redirect('@<?php echo $this->getUrlForAction('new') ?>');
        }
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);
        if ($ajaxify == 1) {
          $results['redirectToUrl'] = $this->getController()->genUrl(array('sf_route' => '<?php echo $this->getUrlForAction('edit') ?>', 'sf_subject' => $<?php echo $this->getSingularName() ?>));
        } else {
          $this->redirect(array('sf_route' => '<?php echo $this->getUrlForAction('edit') ?>', 'sf_subject' => $<?php echo $this->getSingularName() ?>));
        }
      }
    }
    else
    {
      if ($ajaxify == 1) {
        $results['type'] = 'error';
        $results['message'] = 'The item has not been saved due to some errors.';
        $this->collectFormErrors($form->getFormFieldSchema(), $results['errs']);
      } else {
        $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
      }
    }
    if ($ajaxify == 1) {
      echo json_encode($results);
      exit;
    }
  }
