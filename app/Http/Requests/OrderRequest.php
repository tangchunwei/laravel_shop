<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\ProductSku;
class OrderRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'address_id' => ['required',Rule::exists('user_addresses','id')->where('user_id',$this->user()->id)],
            'items'=>['required','array'],
            'items.*.sku_id'=>[
                // 检查items数组下每一个子数组的sku_id
                'required',
                function($attribute,$value,$fail){
                    if(!$sku=ProductSku::find($value)){
                        $fail('该商品不存在');
                    }
                    if(!$sku->product->on_sale){
                        $fail('该商品未上架');
                    }
                    if(!$sku->stock===0){
                        $fail('该商品已售完');
                    }
                    // 获取当前索引
                    preg_match('/items\.(\d+)\.sku_id/',$attribute,$m);
                    $index=$m[1];
                    // 根据索引找到用户所提交的购买数量
                    $amount=$this->input('items')[$index]['amount'];
                    if(is_int($amount) && $amount > $sku->stock)
                    {
                        $fail('该商品库存不足');
                    }
                },
            ],
            'item.*.amount' => ['required','integer','min:1'],
        ];
    }
}
