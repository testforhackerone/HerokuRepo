<?php

use App\Model\AdminSetting;
use Illuminate\Database\Seeder;

class AdminSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminSetting::create(['slug' => 'app_title', 'value' => 'Quiz']);
        AdminSetting::create(['slug' => 'logo', 'value' => '']);
        AdminSetting::create(['slug' => 'login_logo', 'value' => '']);
        AdminSetting::create(['slug' => 'favicon', 'value' => '']);
        AdminSetting::create(['slug' => 'copyright_text', 'value' => 'Copyright@2018']);
        //General Settings
        AdminSetting::create(['slug' => 'lang', 'value' => 'en']);
        AdminSetting::create(['slug' => 'company_name', 'value' => 'New Company']);
        AdminSetting::create(['slug' => 'primary_email', 'value' => 'info@email.com']);
        AdminSetting::create(['slug' => 'user_registration', 'value' => 1]);
    }
}
