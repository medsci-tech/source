<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\Questions;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function index(){
        $questions = Questions::paginate(10);
//        dd($questions);
        return view('admin/questions',['questions'=>$questions]);
    }

    public function saveinfo(Request $request){
        if(!empty($request->id)){
            $question = Questions::find($request->id);
//            dd($question);
        }else{
            $question = new Questions();
        }

        if($request->isMethod('post')){

            $this->validate($request,[
                'is_show'=>'required|boolean',
                'title'=>'required',
                'content'=>'required',
            ],[
                'is_show.required'=>'请选择是否发布',
                'title.required'=>'标题不能为空',
                'content.required'=>'内容不能为空',
            ]);

            $question->is_show =$request->is_show;
            $question->title =$request->title;
            $question->content =$request->input('content');
            if($question->save()){
                return redirect('admin/questions/index');
            }else{
                return redirect()->back();
            };
        }

        return view('admin/questionsAdd',['question'=>$question]);
    }
}
