<html>
<head>

<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js" ></script>
<script type="text/javascript">

jQuery( document ).ready(function() {
	jQuery.ajax({
        'url' : 'http://memoryhelper.netne.net/memoryhelper/index.php/notifications/send_gcm_notifications_to_clients',
        'type' : 'POST', //the way you want to send data to your URL
        'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
			//alert( data );
        }
    });
});

</script>

</head>
<body></body>

</html>