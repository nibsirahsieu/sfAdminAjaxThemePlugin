//based on http://www.tutorialswitch.com/web-development/quick-and-simple-ajax-forms-with-json-responses/

function setupAjaxForm(form_id, form_validations){
	var form = '#' + form_id;
	
  var options = {
    dataType:  'json',
    url: jQuery(form).attr('action')+'?&ajaxify=1',
    beforeSubmit: function(){
      if(typeof form_validations == "function" && !form_validations()) {
        return false;
      }
    },
    success: function(json){
      if (json.type == 'error') {
        var errs = json.errs;
        jQuery(form).find('span.error').remove();
        jQuery.each(errs, function (index, value){
          var content = "<span class='error'>"+value+'</em>';
          jQuery('#'+index).after('&nbsp;'+content);
        })
        showMessage(json.message, json.type);
      } else {
        window.location.href = json.redirectToUrl;
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {}
  };
  jQuery(form).ajaxForm(options);
}
