<?php

namespace App\Http\Controllers;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Illuminate\Http\Request;
use App\Member;
use App\Devotion;
use App\BotToken;
Use Exception;

class telegramController extends Controller
{
    protected $telegram_url;

    public function __construct(){
        $this->middleware('auth:api');
     //  $this->botToken = '1255978101:AAEwIjtn8M4l3UbdkNLhivCwc28EtNOGUwg';
       $this->telegram_url = 'https://api.telegram.org/bot';
    }

   public function getMessages(){
       $admin = auth('api')->user();

      // **************|| Webhook Set ||********************
         Logger('message', ['mydata'=>request()->all()]); // Check request in log
            $request = request()->all();

           $addMember = new Member();
           $addMember->chat_id = $request['message']['from']['id'];
           $addMember->first_name = $request['message']['from']['first_name'];
           $addMember->text =$request['message']['text'];
           $addMember->fellowship_id = $admin->fellowship_id;
           $addMember->save();

        $member = Member::where(['chat_id','=',$request['message']['from']['id'],'fellowship_id'=>$admin->fellowship_id])->first();

        file_get_contents($this->telegram_url."/sendmessage?chat_id=".$member->chat_id."&text=".urlencode("ሰላም ").$member->first_name.urlencode (" እኔ የየእለቱ የእግዚአብሔር ቃል የጥሞና ማሰላሰያ እና የየዕለት የቃል ጥናት ጥቅስ የማቀርብላችሁ Bot ነኝ።"));

        return response()->json(['Data Successfully Saved & Sent!'], 200);
      }

   public function sendMessage(Request $request){
       try{
       $admin = auth('api')->user();

       $members = Member::where(['fellowship_id'=>$admin->fellowship_id]);
       $getToken = BotToken::find($admin->id);

          foreach($members as $member){
              file_get_contents($this->telegram_url.$getToken->botToken."/sendmessage?chat_id=".$member->chat_id."&text=".urlencode($request['title'])."\n\n".urlencode($request['content']));
          }

          $devotion = new Devotion();
          $devotion->devotion_title = $request['title'];
          $devotion->devotion_content = $request['content'];
          $devotion->admin_id = $admin->id;
          $devotion->fellowship_id = $admin->fellowship_id;

          if($devotion->save()){
              return response()->json(['Message Sent Successfully'], 200);
          }
         return response()->json(['message' => 'Ooops! Message not sent', 'error' => $ex->getMessage()], 500);

        }catch(Exception $ex){
            return response()->json(['message' => 'Ooops! something went wrong', 'error' => $ex->getMessage()], 500);
        }
   }

   function addToken(Request $request){
           try{
               $admin = auth('api')->user();

               $requests = request()->only('botName','botToken');

               $rule = [
                   'botName'=> 'required|string',
                   'botToken' => 'required|string'
               ];
            $validator = Validator::make($requests, $rule);

            if($validator->fails()) {
                return response()->json(['error' => 'validation error' , 'message' => $validator->messages()], 400);
            }

            $addToken = new BotToken();
            $addToken->botName = $request['botName'];
            $addToken->botToken = $request['botToken'];
            $addToken->fellowship_id = $admin->fellowship_id;
            $addToken->adminId = $admin->id;

            if($addToken->save()){
                return response()->json(['message'=>' Bot Token Added Successfully',200]);
            }
           }catch(Exception $ex){
            return response()->json(['message' => 'Ooops! something went wrong', 'error' => $ex->getMessage()], 500);
           }
   }

   function getMembers(){
       try{
            $admin = auth('api')->user();

            $members = Member::where(['fellowship_id'=>$admin->fellowship_id])->paginate(5);
            return response()->json(['members'=>$members],200);

       }catch(Exception $ex){
            return response()->json(['message' => 'Ooops! something went wrong', 'error' => $ex->getMessage()], 500);
       }
   }

   function getPosts(){
       try{
        $admin = auth('api')->user();

        $getPosts = Devotion::where(['fellowship_id'=>$admin->fellowship_id,'admin_id'=>$admin->admin_id])->paginate(10);
        return response()->json(['posts'=>$getPosts]);

       }catch(Exception $ex){
        return response()->json(['message' => 'Ooops! something went wrong', 'error' => $ex->getMessage()], 500);
       }
   }

   function deleteMember($id){

   }

   function countMembers(){
       try{
       $admin = auth('api')->user();

       $countMembers = Member::where(['fellowship_id'=>$admin->fellowship_id,'admin_id'=>$admin->admin_id])->count();
       return response()->json(['totalMembers'=>$countMembers]);

       }catch(Exception $ex){
        return response()->json(['message' => 'Ooops! something went wrong', 'error' => $ex->getMessage()], 500);
       }
   }

   function countPosts(){
       try{
       $admin = auth('api')->user();

       $countDevotion = Devotion::where(['fellowship_id'=>$admin->fellowship_id,'admin_id'=>$admin->fellowship_id])->count();
       return response()->json(['totalDevotions'=>$countDevotion]);

       }catch(Exception $ex){
        return response()->json(['message' => 'Ooops! something went wrong', 'error' => $ex->getMessage()], 500);
       }
   }

   function recentPosts(){
       try{
        $admin = auth('api')->user();

        $recentPost = Devotion::where(['fellowship_id'=>$admin->fellowship_id,'admin_id'=>$admin->fellowship_id])->limit(3)->orderBy('created_at','asc')->paginate(3);
        return response()->json(['recentDevotion'=>$recentPost]);

       }catch(Exception $ex){
        return response()->json(['message' => 'Ooops! something went wrong', 'error' => $ex->getMessage()], 500);
       }
   }
 }
