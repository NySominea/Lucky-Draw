<div class="row justify-content-center">
    <div class="col-md">
        <div class="form-group row mb-2 mb-md-3">
            <label for="name" class="col-md-3 col-form-label">Facebook URL</label>
            <div class="col-md-9">
                {{
                    Form::text(
                        SettingKey::SocialFacebook,
                        $settings[SettingKey::SocialFacebook],
                        ["class" => "form-control", 'id' => SettingKey::SocialFacebook,]
                    )
                }}
            </div>
        </div>
        <div class="form-group row mb-2 mb-md-3">
            <label for="name" class="col-md-3 col-form-label">LinkedIn URL</label>
            <div class="col-md-9">
                {{
                    Form::text(
                        SettingKey::SocialLinkedIn,
                        $settings[SettingKey::SocialLinkedIn],
                        ["class" => "form-control", 'id' => SettingKey::SocialLinkedIn,]
                    )
                }}
            </div>
        </div>
        <div class="form-group row mb-2 mb-md-3">
            <label for="name" class="col-md-3 col-form-label">Instagram URL</label>
            <div class="col-md-9">
                {{
                    Form::text(
                        SettingKey::SocialInstagram,
                        $settings[SettingKey::SocialInstagram],
                        ["class" => "form-control", 'id' => SettingKey::SocialInstagram,]
                    )
                }}
            </div>
        </div>
        <div class="form-group row mb-2 mb-md-3">
            <label for="name" class="col-md-3 col-form-label">Google Map</label>
            <div class="col-md-9">
                {{
                    Form::text(
                        SettingKey::SocialGoogleMap,
                        $settings[SettingKey::SocialGoogleMap],
                        ["class" => "form-control", 'id' => SettingKey::SocialGoogleMap,]
                    )
                }}
            </div>
        </div>
    </div>
</div>
