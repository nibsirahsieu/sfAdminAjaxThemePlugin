  public function executeBatch(sfWebRequest $request)
  {
    if ($request->isXmlHttpRequest()) {
      sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
      sfConfig::set('sf_web_debug', false);
      $this->getResponse()->setContentType('application/json');
      $response = array('type' => 'error', 'msg' => '');
    }
    
    $request->checkCSRFProtection();

    if (!$ids = $request->getParameter('ids'))
    {
      if ($request->isXmlHttpRequest()) {
        $response['msg'] = __('You must at least select one item.', array(), 'sf_admin');
        return $this->renderText(json_encode($response));
      } else {
        $this->getUser()->setFlash('error', 'You must at least select one item.');
        $this->redirect('@<?php echo $this->getUrlForAction('list') ?>');
      }
    }

    if (!$action = $request->getParameter('batch_action'))
    {
      if ($request->isXmlHttpRequest()) {
        $response['msg'] = __('You must select an action to execute on the selected items.', array(), 'sf_admin');
        return $this->renderText(json_encode($response));
      } else {
        $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');
        $this->redirect('@<?php echo $this->getUrlForAction('list') ?>');
      }
    }

    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {
      throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
    }

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($action)))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $validator = new sfValidatorPropelChoice(array('multiple' => true, 'model' => '<?php echo $this->getModelClass() ?>'));
    try
    {
      // validate ids
      $ids = $validator->clean($ids);

      // execute batch
      return $this->$method($request);
    }
    catch (sfValidatorError $e)
    {
      if ($request->isXmlHttpRequest()) {
        $response['msg'] = __('A problem occurs when deleting the selected items as some items do not exist anymore.', array(), 'sf_admin');
        return $this->renderText(json_encode($response));
      } else {
        $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items as some items do not exist anymore.');
      }
    }

    $this->redirect('@<?php echo $this->getUrlForAction('list') ?>');
  }

  protected function executeBatchDelete(sfWebRequest $request)
  {
    if ($request->isXmlHttpRequest()) {
      sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
      sfConfig::set('sf_web_debug', false);
      $this->getResponse()->setContentType('application/json');
      $response = array('type' => 'error', 'msg' => '');
    }
    
    $ids = $request->getParameter('ids');

    $count = 0;
    foreach (<?php echo constant($this->getModelClass().'::PEER') ?>::retrieveByPks($ids) as $object)
    {
      $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $object)));

      $object->delete();
      if ($object->isDeleted())
      {
        $count++;
      }
    }

    if ($count >= count($ids))
    {
      if ($request->isXmlHttpRequest()) {
        $response['type'] = 'notice';
        $response['msg'] = __('The selected items have been deleted successfully.', array(), 'sf_admin');
      } else {
        $this->getUser()->setFlash('notice', 'The selected items have been deleted successfully.');
      }
    }
    else
    {
      if ($request->isXmlHttpRequest()) {
        $response['msg'] = __('A problem occurs when deleting the selected items.', array(), 'sf_admin');
      } else {
        $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items.');
      }
    }

    if ($request->isXmlHttpRequest()) {
      $response['redirectToUrl'] = $this->getController()->genUrl('@product');
      return $this->renderText(json_encode($response));
    } else {
      $this->redirect('@<?php echo $this->getUrlForAction('list') ?>');
    }
  }
