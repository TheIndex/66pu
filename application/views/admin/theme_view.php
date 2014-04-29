<div class="container">
	<?php
	//如果是保存成功
	if($theme_saved) {

		?>
		<div class="alert fade in">
			<strong>成功</strong>
			类别信息已经成功保存！
		</div>
	<?php
	}
	?>

	<table class="table">
		<thead>
		<tr>
			<th>
				序号
			</th>
			<th>
				分类名称
			</th>
			<th>
				英文缩写（slug）
			</th>
			<th>
				关联Cuzy主题Id
			</th>
			<th>
				删除
			</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$index = 1;
		foreach ($theme->result() as $row) {
			echo '<tr class="theme_row">';
			echo '<td>' . $index . '</td>';
			echo '<td><input type="text" class="input-small theme_name" value="' . $row->theme_name . '"></td>';
			echo '<td><input type="text" class="input-small theme_slug" value="' . $row->theme_slug . '"></td>';
			echo '<td><input type="text" class="input-small theme_relation" value="' . $row->theme_relation . '"></td>';
			echo '<td class="cid hide" value="' . $row->theme_id . '">' . $row->theme_id . '</td>';
			echo '<td><a href="'.site_url('admin/themedelete/'.$row->theme_id).'">×</a></td>';
			echo '</tr>';
			$index ++;
		}
		?>
		</tbody>
	</table>
	<a href="##" title="" class="btn btn-primary" id="btn-save">保存</a>
	<a href="<?php echo site_url('admin/themeadd')?>" title="">新增主题</a>
	</div>


</div>

<script type='text/javascript' src='<?php echo base_url() ?>assets/js/jquery.js'></script>
<script type='text/javascript' src='<?php echo base_url() ?>assets/js/json.js'></script>
<script>
	(function ($){
		$('#btn-save').click(function (){
			var data = new Array();
			$('.theme_row').each(function (index){
				data[index] = {id: $(this).find('.cid').attr('value'), name: $(this).find('.theme_name').attr('value'),
					slug: $(this).find('.theme_slug').attr('value'),relation: $(this).find('.theme_relation').attr
					('value')}
			});
			data = JSON.stringify(data);

			// The rest of this code assumes you are not using a library.
			// It can be made less wordy if you use one.
			var form = document.createElement("form");
			form.setAttribute("method", 'POST');
			form.setAttribute("action", "<?php echo site_url('admin/themeupdate_op');?>");

			var hiddenField = document.createElement("input");
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", 'data');
			hiddenField.setAttribute("value", data);

			form.appendChild(hiddenField);

			document.body.appendChild(form);
			form.submit();
		});

	})(jQuery);
</script>
<script type="text/javascript" src="http://localhost/33pu/assets/js/bootstrap.min.js"></script>
</body>
<html>