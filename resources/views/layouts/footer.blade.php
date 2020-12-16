<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="text-md-right footer-links d-none d-sm-block">
                    <script>document.write(new Date().getFullYear())</script> &copy; {{ $settings[SettingKey::SiteName] ?: config('app.name') }} by <span class="text-danger">{{ config('app.author') }}</span>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->
