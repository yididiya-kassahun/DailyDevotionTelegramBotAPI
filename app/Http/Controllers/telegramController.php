<?php

namespace App\Http\Controllers;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Illuminate\Http\Request;
use App\Member;
use App\Devotion;
Use Exception;

class telegramController extends Controller
{
    protected $botToken;
    protected $telegram_url;

    public function __construct(){
       $this->botToken = '925095078:AAFhzNs7H4Re9cHEDDzAlbUtxGglLh0Ai7A';
       $this->telegram_url = 'https://api.telegram.org/bot'.$this->botToken;
    }

   public function getMessages(){
    // try{
      // $updates = file_get_contents($this->telegram_url."/getupdates");
      // $updates = file_get_contents("php://input");

      // **************|| Webhook Set ||********************
         Logger('message', ['mydata'=>request()->all()]); // Check request in log
           $request = request()->all();

           $addItem = new Member();
           $addItem->chat_id = $request['message']['from']['id'];
           $addItem->first_name = $request['message']['from']['first_name'];
           $addItem->text =$request['message']['text'];
           $addItem->save();

       $member = Member::where(['chat_id','=',$request['message']['from']['id']])->first();

        file_get_contents($this->telegram_url."/sendmessage?chat_id=".$member->chat_id."&text=".urlencode("ሰላም ").$member->first_name.urlencode (" እኔ የየእለቱ የእግዚአብሔር ቃል የጥሞና ማሰላሰያ እና የየዕለት የቃል ጥናት ጥቅስ የማቀርብላችሁ Bot ነኝ።"));

        return response()->json(['Data Successfully Saved & Sent!'], 200);

    //  }catch(Exception $e){
    //    return response()->json(['message'=>'Network Error !!'], 400);
      }

   public function sendMessage(Request $request){
       $members = Member::all();
       define('nam','jofnf');

          foreach($members as $member){
              file_get_contents($this->telegram_url."/sendmessage?chat_id=".$member->chat_id."&text=".urlencode($request['title'])."\n\n".urlencode($request['content']));
          }

          $devotion = new Devotion();
          $devotion->devotion_title = $request['title'];
          $devotion->devotion_content = $request['content'];
          $devotion->save();

          return response()->json(['Message Sent Successfully'], 200);
   }

   function getMembers(){
            $members = Member::paginate(5);
            return response()->json(['members'=>$members],200);
   }

   function getPosts(){
        $getPosts = Devotion::paginate(10);
        return response()->json(['posts'=>$getPosts]);
   }

   function deleteMember($id){

   }

   function countMembers(){
     $countMembers = Member::count();
     return response()->json(['totalMembers'=>$countMembers]);
   }

   function countPosts(){
     $countDevotion = Devotion::count();
     return response()->json(['totalDevotions'=>$countDevotion]);
   }

   function recentPosts(){

        $recentPost = Devotion::limit(3)->orderBy('created_at','asc')->paginate(3);

        return response()->json(['recentDevotion'=>$recentPost]);

   }
 }
