<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->delete();
        DB::table('users')->insert([
            ['name' => 'kieudangthanh', 'email' => 'kieudangthanh99@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'Kieu Dang Thanh','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-1.png','phone' => '0943563424','address' => 'So 14 duong Cau Giay quan Cau Giay - Ha Noi','birthday' => Carbon::create('1999-02-17'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'vudinhlong', 'email' => 'kieudangthanh123@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'Vu Dinh Long','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-2.png','phone' => '09863827364','address' => 'So 14 duong Van Lang quan Tay Ho - Ha Noi','birthday' => Carbon::create('1998-03-21'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'vuthilan', 'email' => 'lan@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'Vu Thi Lan','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-3.png','phone' => '0935324214','address' => 'So 11 duong Quan Hoa quan Cau Giay - Ha Noi','birthday' => Carbon::create('2000-12-11'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'nguyenngoclinh', 'email' => 'ngoclinh@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'Nguyen Ngoc Linh','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-4.png','phone' => '03358675234','address' => 'So 11 duong Hoang Mai quan Hoang Mai - Ha Noi','birthday' => Carbon::create('2003-5-21'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'khuatlananh', 'email' => 'lananh@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'Khuat Lan Anh','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-5.png','phone' => '03574343754','address' => 'So 411 duong Tran Thai Tong quan Cau Giay - Ha Noi','birthday' => Carbon::create('2002-2-24'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'user6', 'email' => 'user6@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'User 6','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-6.png','phone' => '0935324214','address' => 'So 11 duong Quan Hoa quan Cau Giay - Ha Noi','birthday' => Carbon::create('2000-12-11'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'user7', 'email' => 'user7@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'User 7','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-7.png','phone' => '03358675234','address' => 'So 11 duong Hoang Mai quan Hoang Mai - Ha Noi','birthday' => Carbon::create('2003-5-21'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'user8', 'email' => 'user8@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'User 8','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-8.png','phone' => '03574343754','address' => 'So 411 duong Tran Thai Tong quan Cau Giay - Ha Noi','birthday' => Carbon::create('2002-2-24'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'user9', 'email' => 'user9@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'User 9','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-9.png','phone' => '0935324214','address' => 'So 11 duong Quan Hoa quan Cau Giay - Ha Noi','birthday' => Carbon::create('2000-12-11'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'user10', 'email' => 'user10@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'User 10','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-10.png','phone' => '03358675234','address' => 'So 11 duong Hoang Mai quan Hoang Mai - Ha Noi','birthday' => Carbon::create('2003-5-21'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'user11', 'email' => 'user11@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'User 11','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-11.png','phone' => '03574343754','address' => 'So 411 duong Tran Thai Tong quan Cau Giay - Ha Noi','birthday' => Carbon::create('2002-2-24'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'user12', 'email' => 'user12@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'User 12','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-12.png','phone' => '0935324214','address' => 'So 11 duong Quan Hoa quan Cau Giay - Ha Noi','birthday' => Carbon::create('2000-12-11'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'user13', 'email' => 'user13@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'User 13','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-13.png','phone' => '03358675234','address' => 'So 11 duong Hoang Mai quan Hoang Mai - Ha Noi','birthday' => Carbon::create('2003-5-21'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'user14', 'email' => 'user14@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'User 14','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-14.png','phone' => '03574343754','address' => 'So 411 duong Tran Thai Tong quan Cau Giay - Ha Noi','birthday' => Carbon::create('2002-2-24'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'user15', 'email' => 'user15@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'User 15','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-15.png','phone' => '03574343754','address' => 'So 411 duong Tran Thai Tong quan Cau Giay - Ha Noi','birthday' => Carbon::create('2002-2-24'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'user16', 'email' => 'user16@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'User 816','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-16.png','phone' => '03574343754','address' => 'So 411 duong Tran Thai Tong quan Cau Giay - Ha Noi','birthday' => Carbon::create('2002-2-24'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'user17', 'email' => 'user17@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'User 17','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-17.png','phone' => '03574343754','address' => 'So 411 duong Tran Thai Tong quan Cau Giay - Ha Noi','birthday' => Carbon::create('2002-2-24'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'user18', 'email' => 'user18@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'User 18','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-18.png','phone' => '03574343754','address' => 'So 411 duong Tran Thai Tong quan Cau Giay - Ha Noi','birthday' => Carbon::create('2002-2-24'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'user19', 'email' => 'user19@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'User 19','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-19.png','phone' => '03574343754','address' => 'So 411 duong Tran Thai Tong quan Cau Giay - Ha Noi','birthday' => Carbon::create('2002-2-24'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')],
            ['name' => 'user20', 'email' => 'user20@gmail.com','password' => '$2y$10$mvAmdszCQvk1NbGBIqhHHuAjQTaCdpzB6wRSfLFn.Vvn1qt9WBZUm','description' => 'User 20','introduce'=> 'Yeu mau hong, thich mau tim','avatar' => 'http://localhost:8000/storage/avatar/user_avatar-20.png','phone' => '03574343754','address' => 'So 411 duong Tran Thai Tong quan Cau Giay - Ha Noi','birthday' => Carbon::create('2002-2-24'), 'status_verify' => 1, 'status_online' => 1, 'email_verified_at' => Carbon::create('1999-02-17')]

        ]);
    }
}