<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $products=factory(\App\Models\Product::class,30)->create();
        foreach($products as $product){
            // 创建三个sku，并且每个sku的product_id字段都设置为当前循环商品的id
            $skus=factory(\App\Models\ProductSku::class,3)->create(['product_id'=>$product->id]);
            // 找出价格最低的sku价格，把商品设置为该价格
            $product->update(['price'=>$skus->min('price')]);
        }
    }
}
