<?php

//如果是一个列表，那么列出所有的子项来checkbox
 ?>

<div class="container">
	<form action="<?php echo site_url('admin/themeadd_op') ?>" method="post" class="form-inline">
		<table class="table">
			<thead>
			<tr>
				<th>
					主题名称
				</th>
				<th>
					英文缩写（slug）
				</th>
				<th>
					关联Cuzy主题Id
				</th>
			</tr>
			</thead>
			<tbody>
			<tr class="cat_row">
				<td>
					<input type="text" class="input-small cat_name" name="theme_name" value=""/>
				</td>
				<td>
					<input type="text" class="input-small cat_slug" name="theme_slug" value="">
				</td>
				<td >
					<input type="text" class="input-small cat_slug" name="theme_relation" value="">
				</td>
			</tr>
			</tbody>
		</table>
		<button type="submit" class="btn btn-primary">走你</button>
		<form>
</div>
<?php
if(!empty($data)){
	echo '<div style="padding:20px;">';
	echo '<ul class="unstyled">';
	foreach($data as $item_cat){
		?>
			<li>
                <input type="checkbox" value="<?php echo $item_cat['cid'] ?>">

				<?php
				if($item_cat['is_parent'] == '1' && $item_catx['parent_cid'] == "0")
				{
					 echo '<a href="'.site_url('admin/catadd').'/'.$item_cat['cid'].'">'.$item_cat['name'].'</a>';
				}else{
					echo '<span>'.$item_cat['name'].'</span>';
				}
				?>
             </li>
		<?php
		}
    echo '</ul>';

    //添加按钮，用来添加子项
    echo '<input type="submit" value="添加" class="btn btn-success" id="btn-add">';
    echo '</div>';
}
	?>

    <script type='text/javascript' src='<?php echo base_url()?>assets/js/jquery.js'></script>
    <script type='text/javascript' src='<?php echo base_url()?>assets/js/json.js'></script>
    <script>
        (function($) {
            $('#btn-add').click(function(){
                var data = new Array();
                $('input:checked').each(function(index){
                    data[index] = {id : $(this).attr('value'), name : $(this).next().text()}
                });
                     data = JSON.stringify(data);

                        // The rest of this code assumes you are not using a library.
                        // It can be made less wordy if you use one.
                        var form = document.createElement("form");
                        form.setAttribute("method", 'POST');
                        form.setAttribute("action", "<?php echo site_url('admin/catadd_op') ?>");

                        var hiddenField = document.createElement("input");
                        hiddenField.setAttribute("type", "hidden");
                        hiddenField.setAttribute("name", 'data');
                        hiddenField.setAttribute("value", data);

                        form.appendChild(hiddenField);

                        document.body.appendChild(form);
                        form.submit();


            }

            );
        })(jQuery);
    </script>

</body>
</html>
