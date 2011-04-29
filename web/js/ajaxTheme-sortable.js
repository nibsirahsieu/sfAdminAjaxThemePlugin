function setupSortableTable(link) {
  jQuery(document).ready(function() {
    jQuery('#ajaxThemeSortable').tableDnD({
      onDrop: function (table, row) {
        return getJSONAjaxResponse('POST', link, jQuery.tableDnD.serialize(), ajaxThemeList.settings.$listContainer);
      }
    });
  });
}