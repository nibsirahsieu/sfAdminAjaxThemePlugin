function getHTMLAjaxResponse(type, url, data) {
  $.ajax({
    type:type,
    url: url,
    data:data,
    beforeSend:function() { },
    success:function(response, textStatus) {
      var r = response.split('#__filter__#');
      if (r.length > 1) $('#sf_admin_bar').html(r[1]);
      $('#ajaxtheme_list').html(r[0]);
    },
    error:function(XMLHttpRequest, textStatus, errorThrown) {
      alert(textStatus);
    }
  });
  return false;
}

function getJSONAjaxResponse(type, url, data) {
  $.ajax({
    type:type,
    dataType: 'json',
    url: url,
    data:data,
    beforeSend:function() { },
    success:function(response, textStatus) {
      if (response.type == 'notice') {
        if ($('#ajaxtheme_list').length == 0) window.location.href = response.redirectToUrl;
        showMessage(response.msg, response.type);
        getHTMLAjaxResponse('GET', response.redirectToUrl, {})
      }
    },
    error:function(XMLHttpRequest, textStatus, errorThrown) {}
  });
  return false;
}

function showMessage(msg, cls) {
  $('#ajaxThemeConfirmation').removeClass('error notice').addClass(cls).html(msg).appendTo('body').delay(400).slideDown(400).delay(3000).slideUp(400);
}

function showIndicator() {
  $('<div id="ajaxThemeLoader">Loading...</div>').ajaxStart(function() {$(this).show();}).ajaxStop(function() {$(this).hide();}).appendTo('body');
}