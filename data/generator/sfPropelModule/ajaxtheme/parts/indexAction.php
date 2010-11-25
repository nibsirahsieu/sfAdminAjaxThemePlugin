  public function executeIndex(sfWebRequest $request)
  {
    // sorting
    if ($request->getParameter('sort') && $this->isValidSortColumn($request->getParameter('sort')))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    // pager
    if ($request->getParameter('page'))
    {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

    if ($request->isXmlHttpRequest())
    {
      $partialFilter = null;
      sfConfig::set('sf_web_debug', false);
      $this->setLayout(false);
      sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Date'));
      if ($request->hasParameter('_reset')) {
        $partialFilter = $this->getPartial('<?php echo $this->getModuleName() ?>/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      $partialList = $this->getPartial('<?php echo $this->getModuleName() ?>/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      if ($partialFilter) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
  }
