<div id="search_input">
	<div>
		<form id="myForm" action="<?php echo site_url('admin/search')?>" method="get">
			<a href="<?php echo site_url('admin')?>" class="logo"></a>
			<input type="text" value="<?php echo $keyword?>" name="keyword" class="input-xlarge" style="margin-bottom:0;">
			<input  type="submit" value="搜索" class="btn btn-success" />
		</form>
	</div>
	<div>
		<select id="cat_select" name="cat_id" style="margin-bottom:0;">
		<option value="0">全部</option>
		<?php
			$option = '';
			foreach($cat->result() as $row){
				$cat_id = $row->cat_id;
				$select = ($cat_id == $select_id) ? 'selected' : '';
				
				$option .= "<option value='{$cat_id}' {$select}>{$row->cat_name}</option>";
			}
			echo $option;
		?>
		</select>
		<span class="muted">（点击商品后会自动添加到该分类）</span>
	</div>
</div><!-- .search_input -->

<!-- 搜索结果列表 -->
<ul id='search-list'>
<?php
	if(empty($data)){
		echo '没有找到条目，请修改关键词或者类别。';
	} else{
		foreach($data as $taobaoke_item){
		?>
			<li>
				<a href='<?php echo $taobaoke_item['click_url'] ?>' data-num_id='<?php echo $taobaoke_item['num_iid'] ?>'
				title='<?php echo htmlspecialchars(strip_tags($taobaoke_item['title']),ENT_QUOTES); ?>' data-price='<?php echo $taobaoke_item['promotion_price']?>'
				data-sellernick='<?php echo htmlspecialchars($taobaoke_item['nick'],ENT_QUOTES); ?>'>
					<img src="<?php echo $taobaoke_item['pic_url']?>" alt="<?php echo htmlspecialchars(strip_tags($taobaoke_item['title']),ENT_QUOTES)?>"/>
				</a>
				<p><span class="right"><?php echo max($taobaoke_item['volume'],$taobaoke_item['commission_num'])?>件</span>
					<span>佣金<?php echo $taobaoke_item['commission'] ?></span> /
					<span>单价<?php echo round($taobaoke_item['promotion_price'])?></span>
				</p>
			</li>
		<?php
		}
	}
?>
</ul>
<div class="pagenav_wrapper">
    <div class="pagenav">
        <?php echo $pagination;?>
    </div>
</div>

<script type='text/javascript' src='<?php echo base_url()?>assets/js/jquery.js'></script>
<script type="text/javascript">
(function($) {
	var global_clickurl,global_title,global_price,global_nick;
	$('.pagenav a').click(function(e){
		e.preventDefault();
		
		var select_id = $('#cat_select').val();
		var href = $(this).attr('href');
		location.href = href +'?select_id='+ select_id;
	});
		//搜索结果中的条目点击
	$('#search-list li a').click(
			function(event){
				event.preventDefault();
				var item = {},
					thisItem = $(this),
					successMessage = '<div class="alert alert-success">添加成功！</div>';

				item.img_url = thisItem.find('img').attr('src');
//				item.sellernick = thisItem.data('sellernick');
				item.title = htmlEncode(thisItem.attr('title'));
				item.price = thisItem.data('price');
				item.click_url = thisItem.attr('href');
				item.cid = $('#cat_select').val();
				item.num_iid = thisItem.data('num_id');

				$.post('<?php echo site_url("admin/setitem/")?>',
						   { img_url: item.img_url,
							title: item.title,
							cid: item.cid,
							sellernick: item.sellernick,
							click_url: item.click_url,
							price: item.price,
							num_iid: item.num_iid
						   },
						   function(data) {

						   }).success(function(body){
							 if(body == '1'){
							 	thisItem.addClass('success').append(successMessage);
							 }else{
							 	alert(body);
							 }
						   }).error(function(body){
						   	alert('添加失败'+body);
						   });

					event.preventDefault();
		}
	);

	function htmlEncode(value){
	  return $('<div/>').text(value).html();
	}

	function htmlDecode(value){
	  return $('<div/>').html(value).text();
	}

})(jQuery);
</script>
</body>
<html>
