<div class="row justify-content-center">
    <div class="col-md">
        <div class="form-group row mb-2 mb-md-3">
            <label for="name" class="col-md-3 col-form-label">Site Name</label>
            <div class="col-md-9">
                {{
                    Form::text(
                        SettingKey::SiteName,
                        $settings[SettingKey::SiteName],
                        ["class" => "form-control", 'id' => SettingKey::SiteName,]
                    )
                }}
            </div>
        </div>
        <div class="form-group row mb-2 mb-md-3">
            <label for="name" class="col-md-3 col-form-label">Site Abbreviation Name</label>
            <div class="col-md-9">
                {{
                    Form::text(
                        SettingKey::SiteAbbreviationName,
                        $settings[SettingKey::SiteAbbreviationName],
                        ["class" => "form-control", 'id' => SettingKey::SiteAbbreviationName,]
                    )
                }}
            </div>
        </div>
        <div class="form-group row mb-2 mb-md-3">
            <label for="name" class="col-md-3 col-form-label">Site URL</label>
            <div class="col-md-9">
                {{
                    Form::text(
                        SettingKey::SiteUrl,
                        $settings[SettingKey::SiteUrl],
                        ["class" => "form-control", 'id' => SettingKey::SiteUrl,]
                    )
                }}
            </div>
        </div>
        <div class="form-group row mb-2 mb-md-3">
            <label for="name" class="col-md-3 col-form-label">Site Copy Right</label>
            <div class="col-md-9">
                {{
                    Form::text(
                        SettingKey::SiteCopyRight,
                        $settings[SettingKey::SiteCopyRight],
                        ["class" => "form-control", 'id' => SettingKey::SiteCopyRight,]
                    )
                }}
            </div>
        </div>
        <div class="form-group row mb-2 mb-md-3">
            <label for="name" class="col-md-3 col-form-label">Site Description</label>
            <div class="col-md-9">
                {{
                    Form::textarea(
                        SettingKey::SiteDescription,
                        null,
                        ["class" => "form-control", 'id' => SettingKey::SiteDescription, 'rows' => 3]
                    )
                }}
            </div>
        </div>
    </div>
    <div class="px-md-4 py-md-0 py-2">
        <label for="name" class="">Site Logo (200x200)</label>
        @include('components.single-dropzone', [
            'width' => '200',
            'height' => '200',
            'name' => SettingKey::SiteLogo,
            'btn_label' => __('Upload Logo'),
            'image' => $settings[SettingKey::SiteLogo] ?: asset('images/logo.png'),
        ])
    </div>
</div>
