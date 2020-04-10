<?php

use Illuminate\Database\Seeder;

class specification extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('specification')->delete();
        DB::table('specification')->insert([
			'id' => 1,
            'specification' => '<table> <tbody> <tr class="bg-grey"> <td> Động cơ/Hộp số </td> <td>E</td> <td>G</td> <td>RS</td> </tr> <tr> <td>Kiểu động cơ</td> <td>1.8L SOHC i-VTEC, 4 xi lanh thẳng hàng,16 van</td> <td>1.8L SOHC i-VTEC, 4 xi lanh thẳng hàng,16 van</td> <td>1.5L DOHC VTEC TURBO, 4 xi lanh thẳng hàng,16 van</td> </tr> <tr> <td>Hộp số</td> <td colspan="3">Vô cấp CVT,Ứng dụng EARTH DREAMS TECNOLOGY</td> </tr> <tr> <td>Dung tích xi lanh (cm³)</td> <td>1.799</td> <td>1.799</td> <td>1.498</td> </tr> <tr> <td>Công xuất cực đại (Hp/rpm)</td> <td>139/6.500</td> <td>139/6.500</td> <td>170/5.500</td> </tr> <tr> <td>Mô-men xoắn cực đại (Nm/rpm)</td> <td>174/4.300</td> <td>174/4.300</td> <td>220/1.700-5.500</td> </tr> <tr> <td>Mô-men xoắn cực đại (Nm/rpm)</td> <td>174/4.300</td> <td>174/4.300</td> <td>220/1.700-5.500</td> </tr> <tr> <td>Mô-men xoắn cực đại (Nm/rpm)</td> <td>174/4.300</td> <td>174/4.300</td> <td>220/1.700-5.500</td> </tr> <tr> <td>Tốc độ tối đa (km/h)</td> <td colspan="3">200</td> </tr> <tr> <td>Thời gian tắng tốc từ 0 đến 100 km/h (giây)</td> <td>9.8</td> <td>10</td> <td>8.3</td> </tr> <tr> <td>Thời gian tắng tốc từ 0 đến 100 km/h (giây)</td> <td>9.8</td> <td>10</td> <td>8.3</td> </tr> <tr> <td>Thời gian tắng tốc từ 0 đến 100 km/h (giây)</td> <td>9.8</td> <td>10</td> <td>8.3</td> </tr> <tr> <td>Thời gian tắng tốc từ 0 đến 100 km/h (giây)</td> <td>9.8</td> <td>10</td> <td>8.3</td> </tr> <tr> <td>Thời gian tắng tốc từ 0 đến 100 km/h (giây)</td> <td>9.8</td> <td>10</td> <td>8.3</td> </tr> <tr> <td>Thời gian tắng tốc từ 0 đến 100 km/h (giây)</td> <td>9.8</td> <td>10</td> <td>8.3</td> </tr> <tr> <td>Hệ thống nhiên liệu</td> <td>40</td> <td>40</td> <td>40</td> </tr> <tr> <td>Dung tích thùng nhiêu liệu (lít)</td> <td>40</td> <td>40</td> <td>40</td> </tr> <tr> <td>Dung tích thùng nhiêu liệu (lít)</td> <td colspan="3">47</td> </tr> <tr> <td>Hệ thống nhiên liệu</td> <td>PGM-FI</td> <td>PGM-FI</td> <td>PGM-FI (Phun xăng trực tiếp)</td> </tr> <tr> <td>Mức tiêu thụ nhiên liệu chu trình đô thị cơ bản (lít/100km)</td> <td>8.5</td> <td>8.5</td> <td>8.1</td> </tr> <tr> <td>Mức tiêu thụ nhiên liệu chu trình đô thị phụ (lít/100km)</td> <td>4.9</td> <td>4.8</td> <td>5</td> </tr> <tr> <td>Dung tích xi lanh (cm³)</td> <td>4.9</td> <td>4.8</td> <td>5</td> </tr> <tr> <td>Mô-men xoắn cực đại (Nm/rpm)</td> <td>4.9</td> <td>4.8</td> <td>5</td> </tr> <tr> <td>Van bướm ga điều chỉnh bằng điện tử</td> <td>4.9</td> <td>4.8</td> <td>5</td> </tr> </tbody> </table>',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
