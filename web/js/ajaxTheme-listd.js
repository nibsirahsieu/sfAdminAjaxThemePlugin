/*delegate version*/
var ajaxThemeList = {
  init: function(settings) {
    ajaxThemeList.settings = {
      $listContainer: jQuery('#ajaxtheme_list'),
      pageClass: 'ajaxtheme_page',
      sortClass: 'ajaxtheme_sort',
      $formBatch: jQuery('#sf_admin_content form'),
      $filterContainer: jQuery('#sf_admin_bar'),
      baseURL: location.protocol + '//' + location.host + location.pathname
    };
    jQuery.extend(ajaxThemeList.settings, settings);
    ajaxThemeList.onReady();

    /*taken from https://gist.github.com/raw/358429*/
    jQuery(window).bind( 'hashchange', function(e) {
      var settings = ajaxThemeList.settings;
      var params = e.fragment;
      if (params) getHTMLAjaxResponse('GET', jQuery.param.querystring(settings.baseURL, params), {}, settings.$listContainer, settings.$filterContainer);
    });

    if (window.location.hash) jQuery(window).trigger('hashchange');

  },
  onReady : function() {
    ajaxThemeList.delegatePaginationAndSorting();
    ajaxThemeList.delegateBatchAction();
    ajaxThemeList.delegateFormFilter();
  },

  delegatePaginationAndSorting: function () {
    var settings = ajaxThemeList.settings;
    settings.$listContainer.delegate("a[class="+settings.pageClass+"], a[class="+settings.sortClass+"]", 'click', function(e) {
      var params = jQuery.deparam.querystring(this.href);
      var new_url = jQuery.param.fragment(settings.baseURL, params, 2);
      window.location.hash = jQuery.param.fragment( new_url );
      return false;
    });
  },
  delegateBatchAction: function() {
    var formBatch = ajaxThemeList.settings.$formBatch;
    if (formBatch.length > 0) {
      formBatch.delegate('input[type=submit]', 'click', function(e) {
        return getJSONAjaxResponse('POST', formBatch.attr('action'), formBatch.serialize(), ajaxThemeList.settings.$listContainer);
      });
    }
  },
  delegateFormFilter: function() {
    var settings = ajaxThemeList.settings;
    if (settings.$filterContainer.length > 0) {
      settings.$filterContainer.delegate('input[type=submit]', 'click', function(e) {
        e.preventDefault(); //should be here, to enable event delegation ??
        window.location.hash = '#';
        var formFilter = settings.$filterContainer.find('form');
        return getHTMLAjaxResponse('POST', formFilter.attr('action'), formFilter.serialize(), settings.$listContainer);
      });
    }
  }
};
