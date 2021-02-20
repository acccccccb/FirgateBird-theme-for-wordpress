<div class="widget-content">
    <div class="form-field term-description-wrap">
        <label for="firgatebird_light_word">
            <div style="margin-bottom: 10px;">是否开启轻言：</div>
        </label>
        <p class="description">这是一个类似微博的小工具，可以在主题自带的小工具里显示简短的信息，支持HTML代码</p>
        <select
            style="width: 100%;"
            class="postform"
            name="firgatebird_light_word"
            id="firgatebird_light_word"
            value="<?php echo get_option('firgatebird_light_word'); ?>"
        >
            <option value="1" <?php echo get_option('firgatebird_light_word')=='1'?'selected':'' ?> >是</option>
            <option value="" <?php echo get_option('firgatebird_light_word')==''?'selected':'' ?> >否</option>
        </select>
    </div>
    <div class="form-field term-description-wrap">
        <label for="firgatebird_live2d">
            <div style="margin-bottom: 10px;">是否显示看板娘：</div>
        </label>
        <select
            style="width: 100%;"
            class="postform"
            name="firgatebird_live2d"
            id="firgatebird_live2d"
            value="<?php echo get_option('firgatebird_live2d'); ?>"
        >
            <option value="1" <?php echo get_option('firgatebird_live2d')=='1'?'selected':'' ?> >是</option>
            <option value="" <?php echo get_option('firgatebird_live2d')==''?'selected':'' ?> >否</option>
        </select>
    </div>
    <div class="form-field term-description-wrap">
        <div style="margin-bottom: 10px;">
            <label for="firgatebird_live2d_message">
                点击看板娘时说的话：
            </label>
        </div>
        <p class="description">点击看板娘时说的话，每行一句</p>
        <textarea
            name="firgatebird_live2d_message"
            id="firgatebird_live2d_message"
            cols="100"
            rows="5"
            placeholder="点击看板娘时说的话，每行一句"
        ><?php echo get_option('firgatebird_live2d_message'); ?></textarea>
    </div>
</div>
