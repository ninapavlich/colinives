$(document).ready(function() {
	initScrollPanes()
});


function initScrollPanes(){
	$('.scroll-pane').jScrollPane({
			showArrows: false
		});
		

		
		$(function()
		{
		$('.scroll-pane').each(

			function()
			{
				console.log("CREATE JSCROLL PANE")
				$(this).jScrollPane(
					{
						showArrows: $(this).is('.arrow')
					}
				);
				var api = $(this).data('jsp');
				var throttleTimeout;
				$(window).bind(
					'resize',
					function()
					{
						if ($.browser.msie) {
							// IE fires multiple resize events while you are dragging the browser window which
							// causes it to crash if you try to update the scrollpane on every one. So we need
							// to throttle it to fire a maximum of once every 50 milliseconds...
							if (!throttleTimeout) {
								throttleTimeout = setTimeout(
									function()
									{
										api.reinitialise();
										throttleTimeout = null;
									},
									50
								);
							}
						} else {
							api.reinitialise();
						}
					}
				);
			}
		)

		});
		
}