<div class="widget-content">
    <div class="form-field term-description-wrap">
        <div style="margin-bottom: 10px;">
            <label for="firgatebird_home_keyword">首页关键词：</label>
            <p class="description">首页的keyword字段值，用英文逗号隔开</p>
        </div>
        <input
            type="text"
            name="firgatebird_home_keyword"
            id="firgatebird_home_keyword"
            value="<?php echo get_option('firgatebird_home_keyword'); ?>"
            placeholder="首页关键词"
        >
    </div>
    <div class="form-field term-description-wrap">
        <label for="firgatebird_custom_head">
            <div style="margin-bottom: 10px;">插入head标签上方的代码：</div>
        </label>
        <textarea
            name="firgatebird_custom_head"
            id="firgatebird_custom_head"
            cols="100"
            rows="5"
            placeholder="插入head标签上方的代码"
        ><?php echo get_option('firgatebird_custom_head'); ?></textarea>
    </div>
    <div class="form-field term-description-wrap">
        <label for="firgatebird_stats_code">
            <div style="margin-bottom: 10px;">统计代码：</div>
        </label>
        <textarea
            name="firgatebird_stats_code"
            id="firgatebird_stats_code"
            cols="100"
            rows="5"
            placeholder="页面底部统计代码"
        ><?php echo get_option('firgatebird_stats_code'); ?></textarea>
    </div>
    <div class="form-field term-description-wrap">
        <label for="firgatebird_custom_code">
            <div style="margin-bottom: 10px;">自定义HTML(插入到页面最下方)：</div>
        </label>
        <textarea
            name="firgatebird_custom_code"
            id="firgatebird_custom_code"
            cols="100"
            rows="5"
            placeholder="自定义HTML代码"
        ><?php echo get_option('firgatebird_custom_code'); ?></textarea>
    </div>
</div>
