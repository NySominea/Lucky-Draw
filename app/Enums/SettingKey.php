<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class SettingKey extends Enum
{
    const SiteLogo = 'site_logo';
    const SiteName =  'site_name';
    const SiteAbbreviationName =  'site_abbreviation_name';
    const SiteUrl = 'site_url';
    const SiteDescription = 'site_description';
    const SiteCopyRight = 'site_copy_right';

    const ContactPhone = 'contact_phone';
    const ContactEmail = 'contact_email';
    const ContactFax = 'contact_fax';
    const ContactMessenger = 'contact_messenger';
    const ContactSkype = 'contact_skype';
    const ContactAddress = 'contact_address';

    const SocialFacebook = 'social_facebook';
    const SocialYoutube = 'social_youtube';
    const SocialLinkedIn = 'social_linked_in';
    const SocialInstagram = 'social_instagram';
    const SocialTelegram = 'social_telegram';
    const SocialGoogleMap = 'social_google_map';

    public static function imageKeys()
    {
        return [
            self::SiteLogo,
        ];
    }
}
