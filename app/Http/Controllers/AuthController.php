<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Fellowship;
use App\User;

class AuthController extends Controller
{

    function adminSignUp(Request $request){
           try{

            $requests = request()->only('fullName','email','phoneNumber','university_name','university_city','campus','password');
            $rule = [
                'fullName' => 'required|string|max:255',
                'email' => 'required|string|unique:users',
                'phoneNumber'=> 'regex:/^([0-9\s\-\+\(\)]*)$/',
                'university_name' => 'required|string',
                'university_city' => 'required|string',
                'campus'  => 'required|string',
                'password'  => 'required|string|min:4',
            ];
            $validator = Validator::make($requests, $rule);

            if($validator->fails()) {
                return response()->json(['error' => 'validation error' , 'message' => $validator->messages()], 400);
            }

            $fellowship = new Fellowship();
            $fellowship->university_name = $request->input('university_name');
            $fellowship->university_city = $request->input('university_city');
            $fellowship->campus = $request->input('campus');

        if($fellowship->save()) {
        $user = new User();
        $user->fullName = $request['fullName'];
        $user->email = $request['email'];
        $user->phoneNumber = $request['phoneNumber'];
        $user->fellowship_id = $fellowship->fellow_id;
        $user->password = $request['password'];
        $user->password = bcrypt($request->password);
        $user->save();

        $accessToken = $user->createToken('authToken')->accessToken;

        Auth::login($user);

        return response(['user' => $user, 'access_token' => $accessToken]);
        } else {
            $fellowship->delete();
            return response()->json(['error' => 'something went wrong unable to register'], 500);
        }
    }catch(Exception $ex) {
        return response()->json(['message' => 'Ooops! something went wrong', 'error' => $ex->getMessage()], 500);
      }
    }

    function adminSignIn(){

           try{

            $credentials = request()->only('email','password');
            $rules = [
                'email' => 'required|max:255',
                'password' => 'required|min:4'];
            $validator = Validator::make($credentials, $rules);

            if($validator->fails()){
                $error = $validator->messages();
                return response()->json(['status'=>false, 'result'=>null, 'message'=>null, 'error'=> $error],500);
            }
            if(!Auth::attempt($credentials)) {
                return response()->json(['status'=>false, 'result'=>null, 'message'=>'whoops! invalid credential has been used!','error'=>$exception->getMessage()], 401);
            }

            $contacts_id = DB::table('users')->select('id')->where([
                ['email', '=', $credentials['email']]
            ])->value('id');

            $role = DB::table('user_role')->select('role_id')->where([
                ['user_id', '=', $contacts_id]
            ])->value('role_id');

            $role_name = DB::table('roles')->select('name')->where([
                ['id', '=', $role]
            ])->value('name');

           // >>>>>>>>>>>>>>||||||| Check Role for Login ||||||||<<<<<<<<<<<<<<<<<<<

               if($role_name == 'Admin' || $role_name == 'Super Admin'){
                $user = Auth::user();
                $token = $user->createToken('authToken')->accessToken;
                
                $id=$user->id;
                $role=User::find($id)->roles;

                return response()->json(['status'=>true, 'message'=>'Authentication Successful','User_role_id'=>$role,'result'=>$user, 'token'=>$token],200);
               }else{

                return response()->json(['status'=>false, 'message'=>'Woops UnAuthenticated!!!!'],500);
               }

        }catch (Exception $exception){
            return response()->json(['status'=>false, 'result'=>null, 'message'=>'whoops! exception has occurred', 'error'=>$exception->getMessage()],500);
        }
    }


    public function logout (Request $request) {

        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been succesfully logged out!';
        return response($response, 200);

    }
}
