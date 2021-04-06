<div class="widget-content">
    <div class="form-field term-description-wrap">
        <div style="margin-bottom: 10px;">
            <label for="firgatebird_home_keyword">开发者ID(AppID)：</label>
        </div>
        <input
            type="text"
            name="firgatebird_wx_appid"
            id="firgatebird_wx_appid"
            value="<?php echo get_option('firgatebird_wx_appid'); ?>"
            placeholder="微信公众号appid"
        >
    </div>
    <div class="form-field term-description-wrap">
        <div style="margin-bottom: 10px;">
            <label for="firgatebird_home_keyword">开发者密码(AppSecret)：</label>
        </div>
        <input
            type="text"
            name="firgatebird_wx_secret"
            id="firgatebird_wx_secret"
            value="<?php echo get_option('firgatebird_wx_secret'); ?>"
            placeholder="微信公众号AppSecret"
        >
    </div>
</div>
