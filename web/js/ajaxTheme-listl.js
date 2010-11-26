/*live version*/
$(window).bind('load', function() {
  var formFilter = $('#sf_admin_bar form');
  var formBatch = $('#sf_admin_content form');
  var baseurl = location.protocol + '//' + location.host + location.pathname;

  showIndicator();

  //taken from https://gist.github.com/raw/358429
  $(window).bind( 'hashchange', function(e) {
    params = e.fragment; // pre-jQuery1.4: $.deparam.fragment(document.location.href);
    if (params) getHTMLAjaxResponse('GET', $.param.querystring(baseurl, params), {});
  });

  if (location.hash) $(window).trigger('hashchange');
  
  //pagination and sorting
  $('#ajaxtheme_list .sf_admin_pagination a, #ajaxtheme_list thead th[class*=sf_admin_list_th_] a').live('click', function(e) {
    params = $.deparam.querystring(this.href);
    new_url = $.param.fragment(baseurl, params, 2);
    location.hash = $.param.fragment( new_url );
    return false;
  });

  //batch action
  $('#sf_admin_content form input[type=submit]').live('click', function(e) {
    return getJSONAjaxResponse('POST', formBatch.attr('action'), formBatch.serialize());
  });

  //---FILTER FORM ---
  /*submit*/
  $('#sf_admin_bar form input[type=submit]').live('click', function(e) {
    location.hash = '#';
    return getHTMLAjaxResponse('POST', formFilter.attr('action'), formFilter.serialize());
  });

  /*reset*/
  $('#sf_admin_bar form tfoot td a').live('click', function(e) {
    location.hash = '#';
    return getHTMLAjaxResponse('GET', this.href, {});
  });
});
