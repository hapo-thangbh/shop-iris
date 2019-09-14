<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shops')->insert([
            [
               'name' => 'IRIS SHOP',
                'address' => 'Số 63 Ngõ 354 Trường Chinh, Đống Đa, Hà Nội',
                'phone' => '0989011640',
                'facebook' => 'fb.com/irisvn.page',
                'shoppe' => 'shopee.vn/giaynu99k',
                'note_1' => 'Cảm ơn bạn đã tin tưởng IRIS. Bạn giúp shop đánh giá sản phẩm dịch vụ của IRIS nhé bạn!',
                'note_2' => 'Khách hàng được đổi hàng trong vòng 02 ngày kể từ ngày mua hàng nếu sản phẩm chưa qua sử dụng và còn nguyên hóa đơn mua hàng.  Giá trị sản phẩm đổi phải lớn hơn hoặc bằng giá trị sản phẩm đã mua.',
            ],
        ]);
    }
}
