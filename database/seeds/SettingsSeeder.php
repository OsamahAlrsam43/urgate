<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'about_title' => [
                'en' => 'setting',
                'ar' => 'اعدادت'
            ],
            'about_content' => [
                'en' => 'setting',
                'ar' => 'اعدادت'
            ]
        ]);
    }
}
