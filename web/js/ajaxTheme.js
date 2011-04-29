function getHTMLAjaxResponse(type, url, data, lst, flt) {
  jQuery.ajax({
    type:type,
    url: url,
    data:data,
    beforeSend:function() { },
    success:function(response, textStatus) {
      var r = response.split('#__filter__#');
      if (r.length > 1 && flt != undefined && flt.length > 0) flt.html(r[1]);
      lst.html(r[0]);
    },
    error:function(XMLHttpRequest, textStatus, errorThrown) {
      alert(textStatus);
    }
  });
  return false;
}

function getJSONAjaxResponse(type, url, data, lst) {
  jQuery.ajax({
    type:type,
    dataType: 'json',
    url: url,
    data:data,
    beforeSend:function() { },
    success:function(response, textStatus) {
      if (response.type == 'notice') {
        if (lst == undefined || lst.length == 0) window.location.href = response.redirectToUrl;
        showMessage(response.msg, response.type);
        getHTMLAjaxResponse('GET', response.redirectToUrl, {}, lst)
      } else {
        showMessage(response.msg, response.type);
      }
    },
    error:function(XMLHttpRequest, textStatus, errorThrown) { alert(textStatus);}
  });
  return false;
}

function showMessage(msg, cls) {
  jQuery('#ajaxThemeConfirmation').removeClass('error notice').addClass(cls).html(msg).appendTo('body').delay(400).slideDown(400).delay(3000).slideUp(400);
}

function showIndicator() {
  jQuery('<div id="ajaxThemeLoader">Loading...</div>').ajaxStart(function() {
    jQuery(this).show();
  }).ajaxStop(function() {
    jQuery(this).hide();
  }).appendTo('body');
}
