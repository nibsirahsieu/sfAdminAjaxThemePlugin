function setupAjaxForm(form_id, form_validations){
	var form = '#' + form_id;
	
	// en/disable submit button
	var disableSubmit = function(val){
		$(form + ' input[type=submit]').attr('disabled', val);
	};
	
	// setup jQuery Plugin 'ajaxForm' 	
	var options = {
		dataType:  'json',
    url: $(form).attr('action')+'?&ajaxify=1',
		beforeSubmit: function(){
      // run form validations if they exist
			if(typeof form_validations == "function" && !form_validations()) {
				// this will prevent the form from being subitted
				return false;
			}
		},
    //beforeSend: function() { disableSubmit(true); },
		success: function(json){
      //disableSubmit(false);
			if (json.type == 'error') {
        var errs = json.errs;
        $(form).find('span.error').remove();
        $.each(errs, function (index, value){
          var content = "<span class='error'>"+value+'</em>';
          $('#'+index).after('&nbsp;'+content);
        })
        showMessage(json.message, json.type);
      } else {
        window.location.href = json.redirectToUrl;
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {}
	};
	$(form).ajaxForm(options);
}