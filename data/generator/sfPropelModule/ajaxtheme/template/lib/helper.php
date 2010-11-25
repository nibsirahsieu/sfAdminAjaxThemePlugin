[?php

/**
 * <?php echo $this->getModuleName() ?> module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage <?php echo $this->getModuleName()."\n" ?>
 * @author     ##AUTHOR_NAME##
 */
abstract class Base<?php echo ucfirst($this->getModuleName()) ?>GeneratorHelper extends sfModelGeneratorHelper
{
  public function getUrlForAction($action)
  {
    return 'list' == $action ? '<?php echo $this->params['route_prefix'] ?>' : '<?php echo $this->params['route_prefix'] ?>_'.$action;
  }

  public function linkToDelete($object, $param)
  {
    $link = parent::linkToDelete($object, $param);
    if ($link != '') {
      $link = str_replace('f.submit()', 'getJSONAjaxResponse(\'POST\', this.href, $(f).serialize())', $link);
    }
    return $link;
  }
}
