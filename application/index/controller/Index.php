<?php
namespace app\index\controller;
use think\Request;
use app\index\model\Article;
use think\Paginator;
use think\Db;
use think\captcha\Captcha;
use think\Session;

class Index
{
    public function index()
    {
        return view('index');
    }
	public function session1(){
		Session::set('test','test');
	}
	public function session2(){
		$result=Session::get('test');
		var_dump($result);
	}
	//新增
	public function insert(){
		header("Access-Control-Allow-Origin: http://a.com"); // 允许a.com发起的跨域请求  
		//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *  
		header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求  
		header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); 
		$request=Request::instance();
		$data=$request->post();
		$Article=new Article;
		$result=$Article->insertData($data);
		exit(json_encode(array('status'=>0,'msg'=>'success'),JSON_UNESCAPED_UNICODE));
        // return $this->fetch('index');
        //$this->ajaxReturn($data, 'JSON');
		//return $this->ajaxReturn(array('status'=>0,'msg'=>'success'));
	}
	//展示
	public function show(){
		header("Access-Control-Allow-Origin: http://a.com"); // 允许a.com发起的跨域请求  
		//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *  
		header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求  
		header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); 
		$Article=new Article;
		$arr=$Article->show();
		exit(json_encode(array('status'=>0,'result'=>$arr),JSON_UNESCAPED_UNICODE));
	}
	//展示分页1
	public function showPaginate(){
		header("Access-Control-Allow-Origin: http://a.com"); // 允许a.com发起的跨域请求  
		//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *  
		header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求  
		header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); 
		$Article=new Article;
		$request=Request::instance();
		$pager=$request->param('page');
		$arr=$Article->showPaginate($pager);
		exit(json_encode(array('status'=>0,'page'=>$pager,'result'=>$arr),JSON_UNESCAPED_UNICODE));
	}
	//展示分页2
	public function showFenye(){
		header("Access-Control-Allow-Origin: http://a.com"); // 允许a.com发起的跨域请求  
		//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *  
		header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求  
		header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); 
		$Article=new Article;
		$request=Request::instance();
		$pager=$request->param('page');
		$arr=$Article->showFenye($pager);
		exit(json_encode(array('status'=>0,'page'=>$pager,'result'=>$arr),JSON_UNESCAPED_UNICODE));
	}
	//删除
	public function delete(){
		header("Access-Control-Allow-Origin: http://a.com"); // 允许a.com发起的跨域请求  
		//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *  
		header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求  
		header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); 
		$request=Request::instance();
		$id=$request->param('id');
		$Article=new Article;
		$result = $Article->deleteData($id);
        if ($result) {
            exit(json_encode(array('status'=>0,'msg'=>'success'),JSON_UNESCAPED_UNICODE));
        } else {
            exit(json_encode(array('status'=>1,'msg'=>'error'),JSON_UNESCAPED_UNICODE));
        }
	}
	 //修改页面
    public function updateShow()
    {
    	header("Access-Control-Allow-Origin: http://a.com"); // 允许a.com发起的跨域请求  
		//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *  
		header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求  
		header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); 
        $request = Request::instance();
        $id = $request->param('id');
        $Article=new Article;
        $res = $Article->findData($id);
         exit(json_encode(array('status'=>0,'result'=>$res,'id'=>$id),JSON_UNESCAPED_UNICODE));
    }
	//修改数据
	public function save(){
		header("Access-Control-Allow-Origin: http://a.com"); // 允许a.com发起的跨域请求  
		//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *  
		header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求  
		header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); 
		$Article=new Article;
		$request=Request::instance();
		$data=$request->post();
		$id=$request->post('id');
		$result = $Article->updateData($data,$id);
		if($result){
			exit(json_encode(array('status'=>0,'msg'=>'success'),JSON_UNESCAPED_UNICODE));
		}else{
			exit(json_encode(array('status'=>1,'msg'=>'error'),JSON_UNESCAPED_UNICODE));
		}
	}
	//上传文件
	public function upload(){
		header("Access-Control-Allow-Origin: http://a.com"); // 允许a.com发起的跨域请求  
		//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *  
		header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求  
		header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); 
		//获取表单上传文件 
		$file=request()->file('files');
		if(empty($file)){
			exit(json_encode(array('status'=>1,'msg'=>'上传文件不能为空'),JSON_UNESCAPED_UNICODE));
		}else{
		   //移动到框架应用根目录/public/uploads/ 目录下 
		   $info = $file->rule('uniqid')-> validate(['size'=>10240000,'ext'=>'bmp,gif,jgeg,png,jpg'])->move(ROOT_PATH . 'public' . DS . 'uploads'); 
		   //$data = ROOT_PATH .DS . 'uploads' . DS . $info->getSaveName();
		   if($info){
		     exit(json_encode(array('status'=>0,'msg'=>'上传成功','path' => 'http://' . $_SERVER['HTTP_HOST'] . '/tp5/public/uploads/' . str_replace('\\','/',$info->getSaveName())),JSON_UNESCAPED_UNICODE));
		   }else{
		   	 exit(json_encode(array('status'=>1,'msg'=>'上传失败'),JSON_UNESCAPED_UNICODE));
		   }
		}
	}
	//验证码
	public function vertify(){
		header("Access-Control-Allow-Origin: http://a.com"); // 允许a.com发起的跨域请求  
		//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *  
		header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求  
		header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); 
		//$Verify->expire = 1800;
		//$Verify->useZh= false; //中文验证码字符串
		//$Verify->fontSize= 15; //验证码字体大小(px)
		//$Verify->useCurve= true; //是否画混淆曲线
		//$Verify->useNoise= true; //是否添加杂点
		//$Verify->imageH= true; //是否添加杂点
		//$Verify->imageW= true; //是否添加杂点
		//$Verify->reset= true; //验证成功后是否重置
		$config=[
			'codeSet'  => '12',         // 验证码字体大小(px)5.   
		    'fontSize' => 28,         // 是否画混淆曲线7.      
		    'useCurve' => false,          // 验证码图片高度9.      
		    'imageH'   => 50,        // 验证码图片宽度11.       
		    'imageW'   => 200,         // 验证码位数13.       
		    'length'   => 2,         // 验证成功后是否重置        15.      
		    'reset'    => true

		];
		$codes= new Captcha($config);
		return $codes->entry();
		 $codes->sessionGet();
		//return $codes->sessionGet();
		//string(32) "d2d977c58444271d9c780187e93f80e5" array(2) { ["verify_code"]=> string(32) "8d50d3d0e3704d6f93c3e5f0d925e090" ["verify_time"]=> int(1533628638) }
	}
	//验证
	public function check(){		
      	$code=input('code');
		$captcha = new Captcha();
		$res_captcha = $captcha->check($code, 1);
		if(!$res_captcha){
			return json(['code'=>-1,'data'=>'','msg'=>'验证码错误!']);	
		}else{
			return json(['code'=>0,'data'=>'','msg'=>'验证通过!']);	
		}
//		$captcha = new captcha\Captcha();
//      if (!$captcha->check(input("post.code"))){
//          exit(json_encode(array('status'=>1,'msg'=>'error','cp'=>input("post.code")),JSON_UNESCAPED_UNICODE));
//		}
	}
}
