<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

use App\Models\User_Order;


use App\Http\Resources\ApiResource;
use App\Http\Resources\FavOrderResource;

use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\Facades\Storage;




use App\Traits\GeneralTrait;


class OrderController extends Controller
{
    use GeneralTrait;

    public function index(){
        
        
     $orders= ApiResource::collection(Order::get());
        return $this->returnData($orders);

       }

       public function store(Request $request){

        $rules = [
        'name_main'=>'required|string',
        'name_sub'=>'required|string',
        'desc'=>'required|string',
        'from'=>'numeric',
        'to'=>'numeric',
        'GBS'=>'required',
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
        $data['code_order'] =  $code_order = rand(1000, 9999);

       

        Order::create(
            $data
        );
        
        
        return $this->returnSuccessMessage('تم اضافة الطلب بنجاح');
      

       }

       public function update(Request $request, $id){
         
        $order = Order::find($id);
        if(!$order){
            return $this->returnError(404 , 'the order is not found');
        };
       

        $validator = validator::make($request->all(),[
            'name_main'=>'string',
            'name_sub'=>'string',
            'desc'=>'string',
            'from'=>'numeric',
            'to'=>'numeric',
            'GBS'=>'string',
            'file'=>'image',
        ]);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $data = $validator->validated();
            if ($request->has('file')){
                $path=Storage::disk('public')->putFile('/file',$request->file);
                $data['file']=$path;
            }
            if(Auth::user()->id == $order->user_id ){
                $order->update($data);

            }else{
                return $this->returnError(200 , 'هذه الصالحيه ليست لك');

            }

           return $this->returnSuccessMessage('تم تعديل الطلب بنجاح');


    
       }

       public function show ($id){
           $order = Order::find($id);
           
            if(!$order){
                return $this->returnError(404 , 'the order is not found');
            };

            return $this->returnData(new ApiResource($order));
           
       }
       public function destroy ($id){
        $order = Order::find($id);
        if(!$order){
            return $this->returnError(404 , 'the order is not found');
        };
        if(Auth::user()->id == $order->user_id ){
            $order->destroy($id);

        }else{
            return $this->returnError(200 , 'هذه الصالحيه ليست لك');

        }

        return $this->returnSuccessMessage('تم حذف الطلب بنجاح','200');
       }


        public function order(){
           $id= Auth::user()->id ;
        
          $data= User::find($id)->orders;
          
            
            $my_order = ApiResource::collection($data->load('user'));
           
           

           
            return $this->returnData($my_order);

            
        }









        public function request_order(Request $request ,$id){
            $validator = validator::make($request->all(),[
                'price'=>'required|numeric',
                
            ]);
                if ($validator->fails()) {
                    $code = $this->returnCodeAccordingToInput($validator);
                    return $this->returnValidationError($code, $validator);
                }
                $data = $validator->validated();
            
        
            if(Auth::user()->role === 'service_provider'){
                $order = Order::find($id);
             
                if(!$order){
                    return $this->returnError(404 , 'the order is not found');
                };
              
                if($order->status == 'receiving' ){{
                    if($order->user[0]->id !== Auth::user()->id){
                        return $this->returnError(404 , 'لايمكن تقديم لهذا الطلب');

                    }else{
                        return $this->returnError(404 , 'انت بالفعل لفدت قدم لهذا الطلب');

                    }
                }

                }else{
                    $order->user()->syncWithPivotValues(Auth::user()->id ,['price'=>$data['price']]);
                    $order->status='receiving';
                    $order->save();
                     return $this->returnSuccessMessage('تم تقديم الطلب بنجاح','200');
     
                }

               
               
            }else{
                return $this->returnError(200 , 'هذه الصالحيه ليست لك');

            }

            


        }

        

        public function accpet_order($id){
            $order = Order::find($id);
            if(Auth::user()->id ===$order->user_id ){
                $user=$order->user()->first();
                $order->user()->syncWithPivotValues($user->id,['status'=>'1']);
                $order->status='Discuss';
                $order->save();
                return $this->returnSuccessMessage('تم الموافقه علي الطلب بنجاح','200');
    
            }else{
                return $this->returnError(200 , 'هذه الصالحيه ليست لك');

            }
      
           
        

            
        }
     public function cancel_order($id){
        $order = Order::find($id);
        $user=$order->user()->first();
       if(!$user){
        return $this->returnError('E001', 'البيانات  غير صحيحة');
       }
       if(Auth::user()->id ===$order->user_id ){
        $order->user()->detach($user->id);
        $order->status=null;
        $order->save();
        return $this->returnSuccessMessage('تم رفض الطلب بنجاح','200');
       }

       

     }


     public function favoriteStore($id){
        $order = Order::find($id);
       if(!$order){
        return $this->returnError(200 , 'order is not found');

       }
        Auth::user()->fav()->syncWithoutDetaching($id);
        return $this->returnSuccessMessage('تم اضافة الطلب لقائمة المفضله بنجاح','200');

     }

     public function favoriteDelete($id){
        Auth::user()->fav()->detach($id);
        return $this->returnSuccessMessage('تم حذف الطلب من قائمة المفضلة بنجاح','200');

     }
     
     public function favorite(){
       $data= Auth::user()->fav;
       if(count($data) > 0 ){
        $my_fav= FavOrderResource::collection($data);

       return $this->returnData($my_fav);
       }else{
        return $this->returnError(200 , ' لايوجد طلبات مفضله لك');

       }
       
       

     }
     public function complete_order(){
        
        
        if( count(Auth::user()->orders->where('status','complete')) > 0){
                  
            $my_services = ApiResource::collection(Auth::user()->orders->where('status','complete')->load('user'));
            return $this->returnData($my_services,'success');


        }else{
            return $this->returnError(200 , '  لايوجد لديك طلبات منتهية' );

        }
         
         

         
     }
     public function Services(){
        if(Auth::user()->role == 'service_provider' ){
            if( count(Auth::user()->order) > 0){
              
                $my_services = ApiResource::collection(Auth::user()->order);
                return $this->returnData($my_services);


            }else{
                return $this->returnError(200 , ' لايوجد لديك خدمات');

            }
            }else{
                return $this->returnError(200 , 'هذه الصالحيه ليست لك');

            }

            
          
        }
        public function Services_complete(){
            if(Auth::user()->role == 'service_provider' ){
                if( count(Auth::user()->order->where('status','complete')) > 0){
                  
                    $my_services = ApiResource::collection(Auth::user()->order->where('status','complete'));
                    return $this->returnData($my_services);
    
    
                }else{
                    return $this->returnError(200 , '  لايوجد لديك خدمات منتهية' );
    
                }
                }else{
                    return $this->returnError(200 , 'هذه الصالحيه ليست لك');
    
                }
    
                
              
            }

     
      




}
