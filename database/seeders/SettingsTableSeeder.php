<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Enums\SettingKey;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ['key' => SettingKey::SiteLogo, 'value' => '/images/logo.png'],
            ['key' => SettingKey::SiteName, 'value' => 'Ny Sominea'],
            ['key' => SettingKey::SiteAbbreviationName, 'value' => 'NS'],
            ['key' => SettingKey::SiteUrl, 'value' => 'https://nysominea.com'],
            ['key' => SettingKey::SiteDescription, 'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'],
            ['key' => SettingKey::SiteCopyRight, 'value' => 'Copyright © 2020, All Rights Reserved'],

            ['key' => SettingKey::ContactPhone, 'value' => '+855 (93) 355 045'],
            ['key' => SettingKey::ContactEmail, 'value' => 'sominea.ny77@gmail.com'],
            ['key' => SettingKey::ContactAddress, 'value' => 'Takhmao, Kandal'],

            ['key' => SettingKey::SocialFacebook, 'value' => 'https://www.facebook.com/Ny.Sominea/'],
            ['key' => SettingKey::SocialLinkedIn, 'value' => 'https://www.linkedin.com/in/ny-sominea-6711b1158/'],
            ['key' => SettingKey::SocialInstagram, 'value' => 'https://www.instagram.com/?hl=en'],
            ['key' => SettingKey::SocialGoogleMap, 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7818.1057657639885!2d104.92889374494555!3d11.548064306976983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3109512ead29fd23%3A0xc59039af9a79d1d9!2sAEON%20MALL%20PHNOM%20PENH!5e0!3m2!1sen!2skh!4v1601365950214!5m2!1sen!2skh'],
        ];

        foreach ($settings as $item) {
            $setting = Setting::firstOrCreate(
                ['key' => $item['key']],
                $item
            );
        }
    }
}
