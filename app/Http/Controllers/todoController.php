<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ToDo;

class todoController extends Controller
{
    function home(){
            $getTodo = ToDo::all();
                return view('layout.todolist',['todos'=>$getTodo]);
        }

    function myToDoList(Request $request){
        $this->validate($request,[
               'title' => 'string|required',
               'content' => 'string|required'
        ]);

               $val = new ToDo();
               $val->title = $request['title'];
               $val->content = $request['content'];
               $val->save();
                return redirect()->back();
        }

        function deleteToDo($id){

            $deleteToDo = ToDo::find($id);
            if($deleteToDo){
                $deleteToDo->delete();
                return redirect()->back();
            }else{
                return  response()->json('Error file not found',400);;
            }

        }

        function updateToDo($id){
           $updateToDo = ToDo::find($id);
           if($updateToDo){
               
           }
        }
    }

