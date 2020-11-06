<?php

namespace App\Http\Controllers;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Illuminate\Http\Request;
use App\Member;
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
       $updates = file_get_contents($this->telegram_url."/getupdates");
       $decode_content = json_decode($updates,true);

       foreach($decode_content['result'] as $content){
           $addItem = new Member();
           $addItem->chat_id = $content['message']['from']['id'];
           $addItem->first_name = $content['message']['from']['first_name'];
           $addItem->text =$content['message']['text'];
           $addItem->save();
       }
       $members = Member::all();
       $message = "Daily Devotional Bot ";
          foreach($members as $member){
              file_get_contents($this->telegram_url."/sendmessage?chat_id=".$member->chat_id."&text=hello ".$member->first_name." ".$message);
          }
       return response()->json(['Data Successfully Saved & Sent!'], 200);
    //  }catch(Exception $e){
    //    return response()->json(['message'=>'Network Error !!'], 400);
    //  }
   }
   public function sendMessage(Requset $request){
       $members = Member::all();
          foreach($members as $member){
              file_get_contents($this->telegram_url."/sendmessage?chat_id=".$member->chat_id."&text= ".$request['content']);
          }

          return response()->json(['Message Sent Successfully'], 200);
   }
 }
