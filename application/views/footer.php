        </div>
      </div>
    </div>
    <!--End Content-->
  </div>
</div>
<div id="footer">
	(c) 2010. Created and Maintained by ALTO DESEMPE&Ntilde;O <br>
	eMail.- informacion@altodesempenio.com
</div>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<!-- All functions for this theme + document.ready processing -->
<script src="<?php echo BASEURL ?>public/js/admin/devoops.js"></script>
<script type="text/javascript" src="<?php echo BASEURL ?>public/plugins/toast/javascript/jquery.toastmessage.js" async></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js" async></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js" async></script>
<script src="<?php echo BASEURL ?>public/js/jquery.dataTables.yadcf.js" async></script>
<script type="text/javascript" src="<?php echo BASEURL ?>public/js/admin/script.js"></script>
</body>
</html>
</body>
</html>
<script type="text/javascript">
		// $('#backbutton').remove();
		$('#backbutton a').click(function(){
			if(document.referrer.includes("logout") || !document.referrer.includes(BASEURL) || document.referrer.includes('inicio')){
				event.preventDefault();
				var r = confirm("Si regresa a la pantalla anterior terminará su sesión");
				if (r == true) {
					history.back();return false;
				} else {
					event.preventDefault();
				}
			}else{
				history.back();return false;
			}
		});
	</script>
	<?php  ?>