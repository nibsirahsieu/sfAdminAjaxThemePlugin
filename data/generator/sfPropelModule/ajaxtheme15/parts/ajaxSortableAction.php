  public function executeAjaxSortable(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $items = $request->getParameter('ajaxThemeSortable');

    sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

    $data = array();
    $data['type'] = 'notice';
    $data['msg'] = __('The items was ordered successfully.', array(), 'sf_admin');
    
    //start: create array id ==> order
    $newOrders = array();
    $i = 1;
    foreach ($items as $item)  {  
      $newOrders[$item] = $i++;
    }
    //end: create array id ==> order

    try
    {
      $query = PropelQuery::from('<?php echo $this->getModelClass() ?>');
      $query::create()->reorder($newOrders);

      $data['redirectToUrl'] = $this->getController()->genUrl('@<?php echo $this->getUrlForAction('list') ?>');
    }
    catch (Exception $e)
    {
      $data['type'] = 'error';
      $data['msg'] = __('A problem occurs when ordering items', array(), 'sf_admin');
    }

    sfConfig::set('sf_web_debug', false);
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($data));
  }
  

