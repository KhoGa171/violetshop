<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            'description'=>"Shop Thời Trang Violet với phương châm là “ Sẽ luôn luôn là người bạn đồng hành cùng với phong cách thời trang của bạn”. Violet sẽ là một trong những shop đồ thời trang uy tín và chất lượng nhất tại Tp.Huế chúng tôi luôn mang đến cho khách hàng những sản phẩm mới nhất và chất lượng, giá thành hợp lý nhất tại cửa hàng Thời Trang Violet dưới đây là đối nét giới thiệu cơ bản về Shop Thời Trang Nam Cao Cấp Violet.",
            'short_des'=>"Shop Thời Trang Violet với phương châm là “ Sẽ luôn luôn là người bạn đồng hành cùng với phong cách thời trang của bạn”. ",
            'photo'=>"/storage/photos/1/logo.png",
            'logo'=>'/storage/photos/1/logo.png',
            'address'=>"68 Hùng Vương, Tp Huế",
            'email'=>"violetshop@gmail.com",
            'phone'=>"+0234 3868868",
        );
        DB::table('settings')->insert($data);
    }
}
