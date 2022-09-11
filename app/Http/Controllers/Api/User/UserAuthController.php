<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Traits\GeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;

use Auth;
class UserAuthController extends Controller
{

    use GeneralTrait;
    

    public function login_email(Request $request)
    { 
        
        $user= User::where('email','=',$request->email)->first();
        if(!$user){
            return $this->returnError('E001', 'بيانات الدخول غير صحيحة');




        }else if($user->status == 1){
            $credentials = $request->only(['email']);

            $token = Auth::guard('user_api')->login($user);
 
            if (!$token)
                return $this->returnError('E001', 'بيانات الدخول غير صحيحة');
 
            $user = Auth::guard('user_api')->user();
            $user->api_token = $token;
            //return token
            return $this->returnData('user', $user);
 




        }else{
            try {
                $rules = [
                    "email" => "required",
                    'code'=>'required'
                ];
    
                $validator = Validator::make($request->all(), $rules);
    
                if ($validator->fails()) {
                    $code = $this->returnCodeAccordingToInput($validator);
                    return $this->returnValidationError($code, $validator);
                }
    
                //login
                $data = $validator->validated();
    
               
                $user_code = $user->code;
                if($user_code == $data['code']){
                    $user->update(['status'=>'1']);
                 
    
               $credentials = $request->only(['email']);
    
               $token = Auth::guard('user_api')->login($user);
    
               if (!$token)
                   return $this->returnError('E001', 'بيانات الدخول غير صحيحة');
    
               $user = Auth::guard('user_api')->user();
               $user->api_token = $token;
               //return token
               return $this->returnData('user', $user);
    
    
    
                }else{
                    return $this->returnError('E001', 'كود التحقق غير صحيج');
    
                }
    
    
    
    
            } catch (\Exception $ex) {
                return $this->returnError($ex->getCode(), $ex->getMessage());
            }
    
    
        }
      
    }






    public function login_phone(Request $request)
    { 
        
        $user= User::where('phone','=',$request->phone)->first();
        if(!$user){
            return $this->returnError('E001', 'بيانات الدخول غير صحيحة');




        }else if($user->status == 1){
            $credentials = $request->only(['phone']);

            $token = Auth::guard('user_api')->login($user);
 
            if (!$token)
                return $this->returnError('E001', 'بيانات الدخول غير صحيحة');
 
            $user = Auth::guard('user_api')->user();
            $user->api_token = $token;
            //return token
            return $this->returnData('user', $user);
 




        }else{
            try {
                $rules = [
                    "phone" => "required",
                    'code'=>'required'
                ];
    
                $validator = Validator::make($request->all(), $rules);
    
                if ($validator->fails()) {
                    $code = $this->returnCodeAccordingToInput($validator);
                    return $this->returnValidationError($code, $validator);
                }
    
                //login
                $data = $validator->validated();
    
               
                $user_code = $user->code;
                if($user_code == $data['code']){
                    $user->update(['status'=>'1']);
                 
    
               $credentials = $request->only(['phone']);
    
               $token = Auth::guard('user_api')->login($user);
    
               if (!$token)
                   return $this->returnError('E001', 'بيانات الدخول غير صحيحة');
    
               $user = Auth::guard('user_api')->user();
               $user->api_token = $token;
               //return token
               return $this->returnData('user', $user);
    
    
    
                }else{
                    return $this->returnError('E001', 'كود التحقق غير صحيج');
    
                }
    
    
    
    
            } catch (\Exception $ex) {
                return $this->returnError($ex->getCode(), $ex->getMessage());
            }
    
    
        }
      
    }







    
    public function logout(Request $request)
    {
         $token = $request -> header('auth-token');

           if($token){
            try {
                JWTAuth::setToken($token)->invalidate(); //logout
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return  $this -> returnError('400','some thing went wrongs');
            }
            return $this->returnSuccessMessage('Logged out successfully');
           }else{
            return $this -> returnError('400','some thing went wrongs');
           }




       

    }

    public function register(Request $request) {
        $rules = [
            'first_name' => 'required|string|between:2,100',
            'last_name'=>'required|||max:100|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'phone'=>'required|max:100|unique:users',
            'city'=>'required|||max:100|between:2,100',
            'date'=>'required',

        ];
        $validator = Validator::make($request->all(), $rules);

        
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
      $data = $validator->validated();

       $code_virfy = rand(1000, 9999);

        $user = User::create(
            [
            'first_name'=>$data['first_name'] ,
            'last_name'=>$data['last_name'],
            'email' =>$data['email'],
            'phone'=>$data['phone'],
            'city'=>$data['city'],
            'date'=>$data['date'],
            'code'=>$code_virfy,
           
            ]
                );
                return $this->returnSuccessMessage('User successfully registered');
       
    }
}