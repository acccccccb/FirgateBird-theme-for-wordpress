jQuery(document).ready(function(jQuery){
	jQuery(".ajax-article-delete").click(function(){
		let ajaxLink = jQuery(this).attr("data-link");
		let ajaxHtml = jQuery.ajax({
				type: "GET",
				url: "" + ajaxLink + "",
				dataType: "html",
				success:function(data) {
					//let ajaxEgg = jQuery("#data-target").html();
					jQuery("#ajax-box").html(data);
					let ddd = jQuery("#ajax-target").html();
					jQuery("#ajax-box").html(ddd);
				},
				error:function() {
					console.log("异常！");
				}
			});
		//let ajaxOrange = ajaxHtml.html();
		//let ajaxApple = jQuery(ajaxHtml.html).attr("#ajax-target").html();
		//jQuery("#ajax-box").html(ajaxHtml.responseHTML);
		//jQuery('#ajax-box').html(ajaxApple);
	});

	//jQuery('.index-article>p>a>img').click(function(){
	//	let imgUrl = jQuery(this).parents('a').attr('href');
	//	jQuery('#img-url').html('<p><img src="' + imgUrl + '" class="img-thumbnail"  /></p><p><a href="'+ imgUrl +'" target="_blank" class="btn btn-default" >查看原图</a></p>');
	//	jQuery('#img-mask').fadeIn(300);
	//	return false;
	//});
	//jQuery('.index-article>p>img').click(function(){
	//	let imgSrc = jQuery(this).attr('src');
	//	jQuery('#img-url').html('<p><img src="' + imgSrc + '" class="img-thumbnail" /></p><p><a href="'+ imgSrc +'" target="_blank" class="btn btn-default btn-xs" >查看原图</a></p>');
	//	jQuery('#img-mask').fadeIn(300);
	//	return false;
	//});

	//jQuery('#img-mask').click(function(){
	//	jQuery('#img-mask').fadeOut(300);
	//});

	jQuery(window).on('scroll',function(){
	    if((jQuery(window).scrollTop()>50)) {
	        //jQuery("#go_top").fadeIn(300);
	        jQuery("#go_top").stop(true).show().removeClass('plane-out').addClass('plane').animate({
				right:20
			},200);
	    }
	    else {
	        //jQuery("#go_top").fadeOut(300);
			jQuery("#go_top").stop(true).removeClass('plane').addClass('plane-out').animate({
				right:-150
			},200,function(){
				jQuery("#go_top").hide();
			});
	    }
	});
	jQuery('#go_top>a').on('click',function(){
		jQuery('body,html').animate({ scrollTop: 0 }, 400);
		return false;
	});

jQuery("input[type=submit]").bind("click", function(e){
        jQuery("input[required=required],textarea[required=required]").trigger("blur");
        let inputV = [];
        //遍历input[type=required]的value长度并填入数组
            jQuery("input[required=required],textarea[required=required]").each(function(){
            let inputLeng = jQuery(this).val().length;
            inputV.push(inputLeng);
        });
        //判断数组中是否包含数值0
        let KeyNum = inputV.indexOf(0);
        if(KeyNum==-1){
            //验证成功时提交当前表单
            jQuery(this).closest("form").submit();
        } else {
            //验证失败时执行
            console.info("必填项没有填写");
        }
    });

    //失去焦点时验证表单
    jQuery("input[required=required],textarea[required=required]").blur(function(){
        let inputValue = jQuery(this).val().length;
        if(inputValue == 0) {
            jQuery(this).css("border-color","#F64646");
        } else {
            jQuery(this).css("border-color","");
        }
    });
    //修改评论区表情的显示位置
    let smiley = jQuery('.smiley').clone();
    jQuery('.smiley').remove();
    jQuery('.form-group').before(smiley);
	//二级导航
	jQuery('.menu-item-has-children').addClass('dropdown blog-nav-hover');
	jQuery('.menu-item-has-children>a').attr({
		'data-toggle':'dropdown',
		'aria-expanded':'false'
	}).append('<span class="caret"></span>');
	jQuery('.sub-menu').addClass('dropdown-menu').attr('row','menu');

	jQuery('.article-body>p>a').hover(function(){
		jQuery(this).attr({
			"data-toggle":"tooltip",
			"data-original-title":"LinkTo: " + jQuery(this).attr('href')
		});
		jQuery(function () { jQuery("[data-toggle='tooltip']").tooltip(); });
		jQuery(this).tooltip('show');
	});
	// 文章评论特效
	jQuery('.comment').mouseenter(function(){
		jQuery(this).find('.avatar').addClass('avatar-antimate');
	});
	jQuery('.comment').mouseleave(function(){
		jQuery(this).find('.avatar').removeClass('avatar-antimate');
	});
	//瀑布流
    function Mymasnory(){
        jQuery('.masonry').masonry({
            itemSelector: '.item',
            gutterWidth: 220,
            isAnimated: true,
        })
    }
    Mymasnory();
    jQuery(window).resize(function() {
        Mymasnory();
    });
	// scrollreveal
	window.sr = ScrollReveal({
        // 'bottom', 'left', 'top', 'right'
        origin: 'bottom',
		// Can be any valid CSS distance, e.g. '5rem', '10%', '20vw', etc.
        distance: '0px',
		// Time in milliseconds.
        duration: 500,
        delay: 0,
		// Starting angles in degrees, will transition from these values to 0 in all axes.
        rotate: { x: 0, y: 0, z: 0 },
		// Starting opacity value, before transitioning to the computed opacity.
        opacity: 0,
		// Starting scale value, will transition from this value to 1
        scale: 1,
		// Accepts any valid CSS easing, e.g. 'ease', 'ease-in-out', 'linear', etc.
        easing: 'cubic-bezier(0.6, 0.2, 0.1, 1)',
		// `<html>` is the default reveal container. You can pass either:
		// DOM Node, e.g. document.querySelector('.fooContainer')
		// Selector, e.g. '.fooContainer'
        container: window.document.documentElement,
		// true/false to control reveal animations on mobile.
        mobile: true,
		// true:  reveals occur every time elements become visible
		// false: reveals occur once as elements become visible
        reset: true,
		// 'always' — delay for all reveal animations
		// 'once'   — delay only the first time reveals occur
		// 'onload' - delay only for animations triggered by first load
        useDelay: 'always',
		// Change when an element is considered in the viewport. The default value
		// of 0.20 means 20% of an element must be visible for its reveal to occur.
        viewFactor: 0.1,
		// Pixel values that alter the container boundaries.
		// e.g. Set `{ top: 48 }`, if you have a 48px tall fixed toolbar.
		// --
		// Visual Aid: https://scrollrevealjs.org/assets/viewoffset.png
        viewOffset: { top: 0, right: 0, bottom: 0, left: 0 },
		// Callbacks that fire for each triggered element reveal, and reset.
        beforeReveal: function (domEl) {},
        beforeReset: function (domEl) {},
		// Callbacks that fire for each completed element reveal, and reset.
        afterReveal: function (domEl) {},
        afterReset: function (domEl) {}
	});
    sr.reveal('' +
		'.scrollreveal,' +
		'.sidebar-bg>aside,' +
		'.comments-main,' +
		'.more-article,' +
		'.Rolling-effects' +
		'');
	sr.reveal('.sidebar-bg>aside',{
        origin: 'right',
    });
	// 确认对话框
    window.$confirmModal = (params) => {
        const title = params.title || '';
        const content = params.content || '';
        document.getElementById('confirmModalTitle').innerText = title;
        document.getElementById('confirmModalContent').innerText = content;
        const confirm = () => {
            params.confirm();
            jQuery('#confirmModal').modal('hide');
        };
        document.getElementById('confirmModalOnOk').addEventListener('click', confirm);
        jQuery('#confirmModal').on('hidden.bs.modal', function (e) {
            document.getElementById('confirmModalOnOk').removeEventListener('click', confirm);
            if(typeof params.cancel === 'function') {
                params.cancel();
            }
        });
        jQuery('#confirmModal').modal('show');
    }
});
