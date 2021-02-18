<div class="widget-content">
    <div class="form-field term-description-wrap">
        <div style="margin-bottom: 10px;">
            <label for="firgatebird_logo_img">
                LOGO设置(100 x 50)：
                <a target="_blank" href="/wp-admin/upload.php">媒体库</a>
            </label>
        </div>
        <div style="margin-bottom: 10px;">
            <img class="mr10" alt="Brand" src="<?php echo !empty(get_option('firgatebird_logo_img')) ? get_option('firgatebird_logo_img') : (get_template_directory_uri() . '/static/img/logo.png'); ?>" width="100" height="50">
        </div>
        <input
            type="text"
            name="firgatebird_logo_img"
            id="firgatebird_logo_img"
            value="<?php echo get_option('firgatebird_logo_img'); ?>"
            placeholder="顶部导航logo图片地址(100 x 50)"
        >
    </div>
    <div class="form-field term-description-wrap" style="width: 49%;display: inline-block;">
        <div style="margin-bottom: 10px;">
            <label for="firgatebird_color">主题色：</label>
        </div>
        <input
            type="color"
            name="firgatebird_color"
            id="firgatebird_color"
            value="<?php echo get_option('firgatebird_color'); ?>"
            placeholder="主题色"
        >
    </div>
    <div class="form-field term-description-wrap" style="width: 49%;display: inline-block;">
        <div style="margin-bottom: 10px;">
            <label for="firgatebird_font_color">正文颜色：</label>
        </div>
        <input
            type="color"
            name="firgatebird_font_color"
            id="firgatebird_font_color"
            value="<?php echo get_option('firgatebird_font_color'); ?>"
            placeholder="正文颜色"
        >
    </div>
    <div class="form-field term-description-wrap">
        <label for="firgatebird_menu_type">
            <div style="margin-bottom: 10px;">导航样式：</div>
        </label>
        <select
            style="width: 100%;"
            class="postform"
            name="firgatebird_menu_type"
            id="firgatebird_menu_type"
            value="<?php echo get_option('firgatebird_menu_type'); ?>"
        >
            <option value="navbar-default" <?php echo get_option('firgatebird_menu_type')=='navbar-default'?'selected':'' ?> >浅色</option>
            <option value="navbar-inverse" <?php echo get_option('firgatebird_menu_type')=='navbar-inverse'?'selected':'' ?> >深色</option>
        </select>
    </div>

    <div class="form-field term-description-wrap">
        <div style="margin-bottom: 10px;">
            <label for="firgatebird_bg_img">
                背景图片：
                <a target="_blank" href="/wp-admin/upload.php">媒体库</a>
            </label>
        </div>
        <input
            type="text"
            name="firgatebird_bg_img"
            id="firgatebird_bg_img"
            value="<?php echo get_option('firgatebird_bg_img'); ?>"
            placeholder="背景图片"
        >
    </div>

    <div class="form-field term-description-wrap">
        <label for="firgatebird_bg_attachment">
            <div style="margin-bottom: 10px;">固定背景：</div>
        </label>
        <select
            style="width: 100%;"
            class="postform"
            name="firgatebird_bg_attachment"
            id="firgatebird_bg_attachment"
            value="<?php echo get_option('firgatebird_bg_attachment'); ?>"
        >
            <option value="scroll" <?php echo get_option('firgatebird_bg_attachment')=='scroll'?'selected':'' ?> >滚动</option>
            <option value="fixed" <?php echo get_option('firgatebird_bg_attachment')=='fixed'?'selected':'' ?> >固定</option>
        </select>
    </div>

    <div class="form-field term-description-wrap">
        <label for="firgatebird_bg_repeat">
            <div style="margin-bottom: 10px;">平铺模式：</div>
        </label>
        <select
            style="width: 100%;"
            class="postform"
            name="firgatebird_bg_repeat"
            id="firgatebird_bg_repeat"
            value="<?php echo get_option('firgatebird_bg_repeat'); ?>"
        >
            <option value="repeat" <?php echo get_option('firgatebird_bg_repeat')=='repeat'?'selected':'' ?> >默认</option>
            <option value="repeat-x" <?php echo get_option('firgatebird_bg_repeat')=='repeat-x'?'selected':'' ?> >水平重复</option>
            <option value="repeat-y" <?php echo get_option('firgatebird_bg_repeat')=='repeat-y'?'selected':'' ?> >垂直重复</option>
            <option value="no-repeat" <?php echo get_option('firgatebird_bg_repeat')=='no-repeat'?'selected':'' ?> >不重复</option>
        </select>
    </div>

    <div class="form-field term-description-wrap">
        <label for="firgatebird_bg_size">
            <div style="margin-bottom: 10px;">填充模式：</div>
        </label>
        <select
            style="width: 100%;"
            class="postform"
            name="firgatebird_bg_size"
            id="firgatebird_bg_size"
            value="<?php echo get_option('firgatebird_bg_size'); ?>"
        >
            <option value="auto" <?php echo get_option('firgatebird_bg_size')=='auto'?'selected':'' ?> >默认</option>
            <option value="cover" <?php echo get_option('firgatebird_bg_size')=='cover'?'selected':'' ?> >平铺</option>
            <option value="contain" <?php echo get_option('firgatebird_bg_size')=='contain'?'selected':'' ?> >填充</option>
        </select>
    </div>
</div>
