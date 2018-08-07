<?php
namespace app\index\model;
use think\Db;
use think\Model;
use think\Paginator;

class Article extends Model{
	protected $table = 'article';//表名
	//增加
	function insertData($data)
	{
		return Db::table($this->table)->insertGetId($data);
	}
	//展示
	function show()
	{
		return Db::table($this->table)->select();
	}
	//分页1
	function showPaginate($pager){
		$limit=5;
		$pre = ($pager-1)*$limit;
		$pages= Db::table($this->table)->limit($pre,$limit)->select();
		return $pages;
	}
	//分页2
	function showFenye($pager){
		$pages= Db::table($this->table)->page($pager,5)->select();
		return $pages;
	}
	//删除
	function deleteData($id)
	{
		return Db::table($this->table)->where('id','=',$id)->delete();
	}
	//查询单条
	function findData($id)
	{
		return Db::table($this->table)->field('id,title,content')->where('id='.$id.'')->find();
	}
	//修改
	function updateData($data,$id)
	{
		return Db::table($this->table)->where('id','=',$id)->update($data);
	}
}
?>