<?php

namespace app\exam\controller;

use phpDocumentor\Reflection\Types\Null_;
use think\Controller;
use think\Request;
use think\Validate;

class Exam extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //调用模型查询所有数据
        $data = \app\exam\model\Exam::order('id','desc')->select()->toArray();
        return view('show',['data'=>$data]);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //接值
        $param['name']=$request->input('name');
        //验证
        $validate=new Validate($param,[
            'name'  => 'require|unique',
        ]);
        if ($validate == true){
            return json(['code'=>2,'msg'=>'很抱歉，该模型已被添加','data'=>'']);
        }
        //调用模型执行添加
        $data = \app\exam\model\Exam::create($param,true);
        if ($data){
            return json(['code'=>0,'msg'=>'添加成功','data'=>$data]);
        }else{
            return json(['code'=>1,'msg'=>'添加失败','data'=>'']);
        }
    }
    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //验证参数
        if (!is_numeric($id)){
            $this->error('参数格式不正确');
        }
        //点用模型执行删除
        $res = \app\exam\model\Exam::destroy($id);
        if ($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    public function bin(){
        //查询回收的数据
        $data = \app\exam\model\Exam::onlyTrashed()->select()->toArray();
        return view('bin',['data'=>$data]);
    }
    public function empty($id){
        //验证参数
        if (!is_numeric($id)){
            $this->error('参数格式不正确');
        }
        //清空回收站
        $res=\app\exam\model\Exam::destroy(1,true);
        if ($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    public function re($id){
        //验证参数
        if (!is_numeric($id)){
            $this->error('参数格式不正确');
        }
        //恢复回收站
        $data = model('exam')->save(['delete_time'=>null],['id'=>$id]);
        if ($data){
            $this->redirect('Exam/index');
        }else{
            $this->error('数据恢复失败');
        }
     }
}
