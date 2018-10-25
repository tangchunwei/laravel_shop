<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Http\Requests\UserAddressRequest;
class UserAddressesController extends Controller
{
    public function store(UserAddressRequest $request){
        $request->user()->addresses()->create($request->only([
            'province'      ,
            'city'          ,
            'district'      ,
            'address'       ,
            'zip'           ,
            'contact_name'  ,
            'contact_phone' ,
        ]));
        return redirect()->route('user_addresses.index');
    }
    public function index(Request $request){
        return view("user_addresses.index",[
            'addresses'=>$request->user()->addresses,
        ]);
    }
    public function create(){
        return view('user_addresses.create_and_edit',[
            'address'=>new UserAddress()
        ]);
    }
}
