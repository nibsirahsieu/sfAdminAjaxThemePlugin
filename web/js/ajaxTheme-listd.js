/*delegate version*/
$(function() {
  var formFilter = $('#sf_admin_bar form');
  var formBatch = $('#sf_admin_content form');
  var baseurl = location.protocol + '//' + location.host + location.pathname;
  
  showIndicator();

  //taken from https://gist.github.com/raw/358429
  $(window).bind( 'hashchange', function(e) {
    params = e.fragment; // pre-jQuery1.4: $.deparam.fragment(document.location.href);
    getHTMLAjaxResponse('GET', $.param.querystring(baseurl, params), {});
  });

  if (location.hash) $(window).trigger('hashchange');
  
  $('#ajaxtheme_list').delegate('.sf_admin_pagination a, thead th[class*=sf_admin_list_th_] a', 'click', function(e) {
    params = $.deparam.querystring(this.href);
    new_url = $.param.fragment(baseurl, params, 2);
    location.hash = $.param.fragment( new_url );
    return false;
  });

  $('#sf_admin_content').delegate('form input[type=submit]', 'click', function(e) {
    return getJSONAjaxResponse('POST', formFilter.attr('action'), formFilter.serialize());
  });

  $('#sf_admin_bar').delegate('form input[type=submit]', 'click', function(e) {
    location.hash = '#';
    return getHTMLAjaxResponse('POST', formFilter.attr('action'), formFilter.serialize());
  });

  $('#sf_admin_bar').delegate('form tfoot td a', 'click', function(e) {
    location.hash = '';
    return getHTMLAjaxResponse('GET', this.href, {});
  });
});