/*delegate version*/
$(function() {
  var formFilter = $('#sf_admin_bar form');
  var formBatch = $('#sf_admin_content form');

  showIndicator();
  
  $('#ajaxtheme_list').delegate('.sf_admin_pagination a, thead th[class*=sf_admin_list_th_] a', 'click', function(e) {
    return getHTMLAjaxResponse('GET', this.href, {});
  });

  $('#sf_admin_content').delegate('form input[type=submit]', 'click', function(e) {
    return getJSONAjaxResponse('POST', formFilter.attr('action'), formFilter.serialize());
  });

  $('#sf_admin_bar').delegate('form input[type=submit]', 'click', function(e) {
    return getHTMLAjaxResponse('POST', formFilter.attr('action'), formFilter.serialize());
  });

  $('#sf_admin_bar').delegate('form tfoot td a', 'click', function(e) {
    return getHTMLAjaxResponse('GET', this.href, {});
  });
});