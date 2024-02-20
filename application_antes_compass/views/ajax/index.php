<div style="padding-left:30px; height:710px;">

	<br clear="all" /><br clear="all" />
	
	<div id="show_sub_categories">
		<select name="search_category" class="parent">
		<option value="" selected="selected">-- Categories --</option>
		<?php
		$query = "select * from ajax_categories where pid = 0";
		$results = mysql_query($query);
		
		while ($rows = mysql_fetch_assoc(@$results))
		{?>
			<option value="<?php echo $rows['id'];?>"><?php echo $meth->htmlprnt($rows['category']);?></option>
		<?php
		}?>
		</select>	
		
	</div>
	
	<br clear="all" /><br clear="all" />
	
</div>

</body>
</html>