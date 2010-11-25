/*live version*/
$(window).bind('load', function() {
  var formFilter = $('#sf_admin_bar form');
  var formBatch = $('#sf_admin_content form');

  showIndicator();

  //pagination
  $('#ajaxtheme_list .sf_admin_pagination a').live('click', function(e) {
    return getHTMLAjaxResponse('GET', this.href, {});
  });

  //sorting
  $('#ajaxtheme_list thead th[class*=sf_admin_list_th_] a').live('click', function(e) {
    return getHTMLAjaxResponse('GET', this.href, {});
  });

  //batch action
  $('#sf_admin_content form input[type=submit]').live('click', function(e) {
    return getJSONAjaxResponse('POST', formBatch.attr('action'), formBatch.serialize());
  });

  //filter (submit)
  $('#sf_admin_bar form input[type=submit]').live('click', function(e) {
    return getHTMLAjaxResponse('POST', formFilter.attr('action'), formFilter.serialize());
  });

  //filter (reset)
  $('#sf_admin_bar form tfoot td a').live('click', function(e) {
    return getHTMLAjaxResponse('GET', this.href, {});
  });
});