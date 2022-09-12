<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Scope;
use App\Models\Rate;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Http\Resources\ProfileResource;
use App\Http\Resources\RateResource;


use App\Traits\GeneralTrait;

use Auth;
use App\Models\User;



class UserController extends Controller
{
  use GeneralTrait;

    public function profile(){
    $user=  User::find(Auth::user()->id);
    $user['order_services']= count($user->order) ;
    $user['order_count']=count($user->orders);
   return $this->returnData(new ProfileResource($user),"success");
     
}

public function profile_update(Request $request){
  $rules = [
    'first_name' => 'string|between:2,100',
    'last_name'=>'string|max:100|between:2,100',
    'email' => 'string|email|max:100|unique:users',
    'phone'=>'max:100|unique:users',
    'city'=>'string|max:100|between:2,100',
    'date'=>'numeric',
    'ID_number'=>'string|between:2,20',
    
           
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        $code = $this->returnCodeAccordingToInput($validator);
        return $this->returnValidationError($code, $validator);
    }
    $data = $validator->validated();
    $user=  User::find(Auth::user()->id);
    $user->update($data);
    return $this->returnSuccessMessage('تم التعديل بنجاح');




}





public function scopes(){
  $scops=  User::find(Auth::user()->id)->scops;
  return $this->returnData($scops,"success");
}


public function store(Request $request){
  $rules = [
    'name_main'=>'required|string',
    'name_sub'=>'required|string',
    'file'=>'image',
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        $code = $this->returnCodeAccordingToInput($validator);
        return $this->returnValidationError($code, $validator);
    }
    $data = $validator->validated();
        if ($data['file'] != ''){
            $path=Storage::disk('public')->putFile('/file',$request->file);
            $data['file']=$path;
        }
        $data['user_id'] = $user_id = Auth::user()->id;
        Scope::create(
          $data
      );
      
      
      return $this->returnSuccessMessage('تم اضافة المجال بنجاح');
}
  
public function serviceProvider(Request $request){
   $rules = [
    'ID_number'=>'required|string|unique:users',
    'ID_img'=>'required|image|unique:users',
    'scope'=>'required|string',
    'about'=>'string',
    'Bank_Number'=>'required|string|unique:users'
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        $code = $this->returnCodeAccordingToInput($validator);
        return $this->returnValidationError($code, $validator);
    }
    $data = $validator->validated();
       if ($request->has('ID_img')){
        $path=Storage::disk('public')->putFile('/file',$request->ID_img);
        $data['ID_img']=$path;
       }
       $data['role']='service_provider';
        Auth::user()->update($data);
        return $this->returnSuccessMessage('تم ارسال طلبك الي الاداره وجاري معالجك طلبك في خلال 24 ساعه');

        
}
public function charging_wallet(Request $request){
  
  $user = Auth::user();
  $user->deposit($request->money); 
  $balance= $user->balance; // 0
  return $this->returnData(['balance'=>$balance ], 'تم شحن الرصيد بنجاح' );
}

public function withdraw_wallet(Request $request){
  
  $user = Auth::user();
  $user->forceWithdraw($request->money); /// 
  $balance= $user->balance; // 0

  return $this->returnData(['balance'=>$balance ] , 'تم سحب الرصيد بنجاح' );



  
}
public function rate_store($service_provider_id,Request $request){
  $rules = [
    'rate'=>'required',
    'desc'=>'required|string',
   
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        $code = $this->returnCodeAccordingToInput($validator);
        return $this->returnValidationError($code, $validator);
    }
    $data = $validator->validated();
    $data['user_id'] = Auth::user()->id;
    $data['service_provider_id'] = $service_provider_id;

    $count=count(Rate::where(['user_id'=>Auth::user()->id , 'service_provider_id'=>$service_provider_id])->get());


    if(User::find($service_provider_id)->role === 'service_provider'){
       if($count == 1){
        return $this->returnError(200 , 'لقد قمت بقتيم لهذا الشخص من قبل ');

       }else{
        Rate::create($data);
       }
    }else{
      return $this->returnError(200 , 'هذا ليس مزود خدمه ');

    }
    
    return $this->returnSuccessMessage('تم اضافة تقيمك بنجاح');

}
public function rate(){
  if(Auth::user()->role == 'service_provider' ){
   $data= Rate::where('service_provider_id','=',Auth::user()->id)->get();
   if(count($data) == 0){
    return $this->returnError(200 , 'لايوجد لديك تقيمات');

   }else{
    $Rate= RateResource::collection($data);
    return $this->returnData($Rate);
   }
    



  }else{
    return $this->returnError(200 , 'هذه الصالحيه ليست لك');

  }
}

}
