<script language="javascript">

function recordDelete(id){
	if(confirm("Are you sure you want to delete this enquiry?")) {
		$.ajax({
			type: "POST",
			dataType:"JSON",
			url:  "<?php echo ADMIN_URL;?>ajax/ajax.enquiry.php",
			data: "action=delete&id="+id,
			success: function(data) {
				var msg = eval(data);  
				if(msg.action=='success') {
					$('.my-msg').html('<div class="infobox info-bg-success"><p>'+msg.message+'</p></div>').show().fadeOut(3000);
					$('#'+id).remove();
				} else {
					$('.my-msg').html('<div class="infobox info-bg-error"><p>'+msg.message+'</p></div>').show().fadeOut(3000);
				}
			}
		});
	}
}

$(document).ready(function(){
	// Status Toggler
	$('.statusToggler').on('click', function(){
		var id = $(this).attr('moduleId');
		var status = $(this).attr('status');
		var newStatus = (status == 1) ? 0 : 1;
		var $this = $(this);
		$.ajax({
			type: "POST",
			dataType: "JSON",
			url: "<?php echo ADMIN_URL;?>ajax/ajax.enquiry.php",
			data: "action=toggleStatus&id="+id+"&status="+newStatus,
			success: function(data) {
				if(data.action == 'success'){
					$this.attr('status', newStatus);
					if(newStatus == 1){
						$this.removeClass('bg-red').addClass('bg-green');
						$this.attr('title', 'Mark as Unseen');
						$this.find('i').removeClass('icon-eye-slash').addClass('icon-check');
					}else{
						$this.removeClass('bg-green').addClass('bg-red');
						$this.attr('title', 'Mark as Seen');
						$this.find('i').removeClass('icon-check').addClass('icon-eye-slash');
					}
				}
			}
		});
	});
});
</script>
