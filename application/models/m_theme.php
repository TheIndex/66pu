<?php

class M_theme extends CI_Model{

        var $theme_table = '';
        var $item_table = '';


	function __construct()
	{
		parent::__construct();
        $this->theme_table = $this->db->dbprefix('theme');
        $this->item_table = $this->db->dbprefix('item');
	}


	function add_theme()
	{
        if(true){
            $data = array(
//                'cat_id' => $cat -> id ,
                'theme_name' =>$_POST["theme_name"],
                'theme_slug' =>$_POST["theme_slug"],
                'theme_relation' =>(int)$_POST["theme_relation"],
			);
            $this->db->insert($this->theme_table, $data);
        }
    }

    function get_theme_info($cat_slug = ''){
    	if(!empty($cat_slug)){
    		$result = $this->db->get_where($this->theme_table, array('theme_slug'=>$cat_slug))->result();
    		return $result[0];
    	}else {
    		return '';
    	}
    }

	function get_all_theme()
	{
		$query = $this->db->get($this->theme_table);
		return $query;
	}
	function delete_theme($theme_id){
		$this->db->delete($this->theme_table,array('theme_id'=>$theme_id));
	}
	function update_theme(){
		 $data_decode = json_decode($_POST['data']);
		foreach($data_decode as $cat){
			$data = array(
               'theme_name' => $cat -> name,
               'theme_slug' => $cat -> slug,
               'theme_relation' => $cat -> relation
            );

			$this->db->where('theme_id', $cat -> id);
			$this->db->update($this->theme_table, $data);
        }
	}

	function delete_cat($cat_id){
		$this->db->delete($this->theme_table,array('cat_id'=>$cat_id));
	}

    /**
     * 查询每个类别对应的点击
     *
     * @return 查询结果
     */
	function query_cats(){
        
		$this->db->select('cat_name,COUNT(id) as count, SUM(click_count) as sum');
		$where = "cid=cat_id";
		$this->db->join($this->theme_table,$where);
		$this->db->order_by('count DESC');
		$this->db->group_by('cid');
		$query = $this->db->get($this->item_table);
		return $query;
	}

	/**
	 * 获取某类别点击总数
	 *
	 * @param integer cid 类别的id
	 * @return integer 类别点击总数
	 */
	function click_count_by_cid($cid=0){
                $theme_table = $this->theme_table;
                $item_table = $this->item_table;
		if($cid == 0){
			$this->db->select('SUM(click_count) as sum');
			$query = $this->db->get($item_table);
			$row = $query->row();
			  return $row->sum;
		}else {
			$this->db->where('cid='.$cid);
			$this->db->select('SUM(click_count) as sum');
			$query = $this->db->get($item_table);
			if ($query->num_rows() > 0)
			{
				$row = $query->row();
				  return $row->sum;
			}
		}
	}
}
