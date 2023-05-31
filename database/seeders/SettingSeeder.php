<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // General
            [
                'key' => 'logo',
                'value' => '',
                'label_en' => 'Logo',
                'label_ar' => 'لوقو',
                'type' => 'file',
                'group' => 'general',
            ],
            [
                'key' => 'about_ar',
                'value' => '',
                'label_en' => 'About me in Arabic?',
                'label_ar' => 'عني بالعربية؟',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'about_en',
                'value' => '',
                'label_en' => 'About me in English?',
                'label_ar' => 'عني في اللغة الإنجليزية؟',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'termsOfUse_ar',
                'value' => '',
                'label_en' => 'Terms of use in Arabic',
                'label_ar' => 'شروط الاستخدام بالعربي',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'termsOfUse_en',
                'value' => '',
                'label_en' => 'Terms of use in English',
                'label_ar' => 'شروط الاستخدام بالانجليزي',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'shutDown',
                'value' => '',
                'label_en' => 'Closed for maintenance',
                'label_ar' => 'أغلاق للصيانة',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'privacyPolicy_ar',
                'value' => '',
                'label_en' => 'Arabic privacy policy',
                'label_ar' => 'سياسة الخصوصية بالعربي',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'privacyPolicy_en',
                'value' => '',
                'label_en' => 'Privacy Policy in English',
                'label_ar' => 'سياسة الخصوصية بالأنجليزي',
                'type' => 'text',
                'group' => 'general',
            ],
            // Social
            [
                'key' => 'instagram',
                'value' => '',
                'label_en' => 'Instagram',
                'label_ar' => 'انستغرام',
                'type' => 'text',
                'group' => 'social',
            ],
            [
                'key' => 'snapChat',
                'value' => '',
                'label_en' => 'Snap Chat',
                'label_ar' => 'سناب شات',
                'type' => 'text',
                'group' => 'social',
            ],
            [
                'key' => 'tikTok',
                'value' => '',
                'label_en' => 'Tiktok',
                'label_ar' => 'تيك توك',
                'type' => 'text',
                'group' => 'social',
            ],
            [
                'key' => 'twitter',
                'value' => '',
                'label_en' => 'Twitter',
                'label_ar' => 'تويتر',
                'type' => 'text',
                'group' => 'social',
            ],
            [
                'key' => 'WhatsApp',
                'value' => '',
                'label_en' => 'WhatsApp',
                'label_ar' => 'ال WhatsApp',
                'type' => 'text',
                'group' => 'social',
            ],
            [
                'key' => 'email',
                'value' => '',
                'label_en' => 'Email',
                'label_ar' => 'بريد إلكتروني',
                'type' => 'text',
                'group' => 'social',
            ],
        ];
        foreach ($data as $value) {
            Setting::create([
                'key' => $value['key'],
                'value' => $value['value'],
                'label_ar' => $value['label_ar'],
                'label_en' => $value['label_en'],
                'type' => $value['type'],
                'group' => $value['group'],
            ]);
        }
    }
}
