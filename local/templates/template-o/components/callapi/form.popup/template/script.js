function Popup(config) {
	this.init.apply(this, arguments);
}

Popup.prototype.init = function(config) {
	this.props = config;
	this.initOpen();
	this.formAction();
}

Popup.prototype.initOpen = function() {
	var $this = this;
	$( 'body' ).on( 'click', $this.props.button, function(e) {
		var html = $($this.props.form).html();
		$.fancybox.open({
			content: html,
			opts : {
				afterClose: function() {
				}
			}
		});		
	});				
}

Popup.prototype.formAction = function() {

	var $this = this;
	var selector = $this.props.action+' .submit';

	$( 'body' ).on( 'click', selector, function(e) {
		e.preventDefault();

		var $button = this;
		var data = $(this).parent().serialize();
		$.ajax({
			url: $this.props.ajax,
			type: 'POST',
			dataType: 'html',
			data: data,
		})
		.done(function(data) {
			var jData = JSON.parse(data);
			if(jData.TYPE == "SUCCESS")
				{
					$($button).parent().find(".report").html(jData.MESSAGE);
					setTimeout(function() {
						$.fancybox.close();
					}, 2000);
				}
			else if (jData.TYPE == "FAIL")
				{
					 $($button).parent().find(".report").html(jData.MESSAGE);
				}	
		})
		.fail(function() {
		})
	});
}