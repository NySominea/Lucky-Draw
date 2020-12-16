<div class="row justify-content-center">
    <div class="col-md">
        <div class="form-group row mb-2 mb-md-3">
            <label for="name" class="col-md-3 col-form-label">Phone</label>
            <div class="col-md-9">
                {{
                    Form::text(
                        SettingKey::ContactPhone,
                        $settings[SettingKey::ContactPhone],
                        ["class" => "form-control", 'id' => SettingKey::ContactPhone,]
                    )
                }}
            </div>
        </div>
        <div class="form-group row mb-2 mb-md-3">
            <label for="name" class="col-md-3 col-form-label">Email</label>
            <div class="col-md-9">
                {{
                    Form::text(
                        SettingKey::ContactEmail,
                        $settings[SettingKey::ContactEmail],
                        ["class" => "form-control", 'id' => SettingKey::ContactEmail,]
                    )
                }}
            </div>
        </div>
        <div class="form-group row mb-2 mb-md-3">
            <label for="name" class="col-md-3 col-form-label">Address</label>
            <div class="col-md-9">
                {{
                    Form::textarea(
                        SettingKey::ContactAddress,
                        null,
                        ["class" => "form-control", 'id' => SettingKey::ContactAddress, 'rows' => 2]
                    )
                }}
            </div>
        </div>
    </div>
</div>
