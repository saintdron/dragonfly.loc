<div class="home-wrapper">
    <video id="video" poster="{{ asset(config('settings.video_dir')) }}/main_background_video.png" loop="loop" autoplay muted>
        <source src="{{ asset(config('settings.video_dir')) }}/main_background_video.webm" type='video/webm;'>
        <source src="{{ asset(config('settings.video_dir')) }}/main_background_video.mp4" type='video/mp4;'>
    </video>
    <img src="{{ asset(config('settings.video_dir')) }}/main_background_video.png">
    <div class="header">
        <img src="{{ asset(config('settings.brand_dir')) }}/logo.png">
    </div>
    <div class="footer">
        <img src="{{ asset(config('settings.brand_dir')) }}/compiled_2.png">
    </div>
</div>