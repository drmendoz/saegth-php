<?php 

$msg="Prueba final";
$email = "p.arredondov91@gmail.com";
$subj = "Final Mercury";
Util::sendMail($email,$subj,$msg);

?>
<!-- <button onclick="showtoast();">TOAST</button> -->

<script type="text/javascript">
	// function showtoast(){
	// 	$().toastmessage('showNoticeToast', 'some message here');
	// 	$().toastmessage('showSuccessToast', "some message here");
	// 	$().toastmessage('showWarningToast', "some message here");
	// 	$().toastmessage('showErrorToast', "some message here");
	// }
</script>