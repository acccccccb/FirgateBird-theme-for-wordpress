$(document).ready(function(){
	//播放音乐
	var audioHTML = '<audio id="BgSound" src = "http://www.ihtmlcss.com/wp-content/uploads/2017/10/STEEL_BEAST_6BEETS.mp3" autoplay></audio>';
	$('.sidebar-site-img').mouseover(function(){
		$('body').append(audioHTML);
	});
	$('.sidebar-site-img').mouseout(function(){
		$('#BgSound').remove();
	});
	//$(".blog-nav-hover").hover(function(){
	//	$(this).children(".dropdown-toggle").click();
	//});

	$(".ajax-article-delete").click(function(){
		var ajaxLink = $(this).attr("data-link");
		var ajaxHtml = $.ajax({
				type: "GET",
				url: "" + ajaxLink + "",
				dataType: "html",
				success:function(data) {  
					console.log("成功！");
					//console.log(data);
					//var ajaxEgg = $("#data-target").html();
					//console.log(ajaxEgg);
					$("#ajax-box").html(data);
					var ddd = $("#ajax-target").html();
					$("#ajax-box").html(ddd);
					console.log(ddd);
				},  
				error:function() {   
					console.log("异常！");  
				}
			});
		//var ajaxOrange = ajaxHtml.html();
		//var ajaxApple = $(ajaxHtml.html).attr("#ajax-target").html();
		//$("#ajax-box").html(ajaxHtml.responseHTML);				
		//console.log(data);
		//$('#ajax-box').html(ajaxApple);
	});
	
	//$('.index-article>p>a>img').click(function(){
	//	var imgUrl = $(this).parents('a').attr('href');
	//	$('#img-url').html('<p><img src="' + imgUrl + '" class="img-thumbnail"  /></p><p><a href="'+ imgUrl +'" target="_blank" class="btn btn-default" >查看原图</a></p>');
	//	$('#img-mask').fadeIn(300);
	//	return false;
	//});
	//$('.index-article>p>img').click(function(){
	//	var imgSrc = $(this).attr('src');
	//	$('#img-url').html('<p><img src="' + imgSrc + '" class="img-thumbnail" /></p><p><a href="'+ imgSrc +'" target="_blank" class="btn btn-default btn-xs" >查看原图</a></p>');
	//	$('#img-mask').fadeIn(300);
	//	return false;
	//});

	//$('#img-mask').click(function(){
	//	$('#img-mask').fadeOut(300);
	//});

	$(window).on('scroll',function(){
	    if(($(window).scrollTop()>50)) {
	        //$("#go_top").fadeIn(300);
	        $("#go_top").stop(true).show().removeClass('plane-out').addClass('plane').animate({
				right:20
			},200);
	    }
	    else {
	        //$("#go_top").fadeOut(300);
			$("#go_top").stop(true).removeClass('plane').addClass('plane-out').animate({
				right:-150
			},200,function(){
				$("#go_top").hide();
			});
	    }
	});
	$('#go_top>a').on('click',function(){
		$('body,html').animate({ scrollTop: 0 }, 400);
		return false;
	});
	
$("input[type=submit]").bind("click", function(e){
        $("input[required=required],textarea[required=required]").trigger("blur");
        var inputV = [];
        //遍历input[type=required]的value长度并填入数组
            $("input[required=required],textarea[required=required]").each(function(){
            var inputLeng = $(this).val().length;
            inputV.push(inputLeng);
        });
        //判断数组中是否包含数值0
        var KeyNum = inputV.indexOf(0);
        if(KeyNum==-1){
            //验证成功时提交当前表单
            $(this).closest("form").submit();
        } else {
            //验证失败时执行
            $('#myModal').modal();
            console.info("必填项没有填写");
        }
    });

    //失去焦点时验证表单
    $("input[required=required],textarea[required=required]").blur(function(){
        var inputValue = $(this).val().length;
        if(inputValue == 0) {
            $(this).css("border-color","#F64646");
        } else {
            $(this).css("border-color","");
        }
    });	
    //修改评论区表情的显示位置
    var smiley = $('.smiley').clone();
    $('.smiley').remove();
    $('.form-group').before(smiley);
	//二级导航
	$('.menu-item-has-children').addClass('dropdown blog-nav-hover');
	$('.menu-item-has-children>a').attr({
		'data-toggle':'dropdown',
		'aria-expanded':'false'
	}).append('<span class="caret"></span>');
	$('.sub-menu').addClass('dropdown-menu').attr('row','menu');
	
	$('.article-body>p>a').hover(function(){
		console.log('tips');
		$(this).attr({
			"data-toggle":"tooltip",
			"data-original-title":"LinkTo: " + $(this).attr('href')
		});
		$(function () { $("[data-toggle='tooltip']").tooltip(); });
		$(this).tooltip('show');
	});
	// 文章评论特效
	$('.comment').mouseenter(function(){
		$(this).find('.avatar').addClass('avatar-antimate');
	});
	$('.comment').mouseleave(function(){
		$(this).find('.avatar').removeClass('avatar-antimate');
	});
	//瀑布流
    function Mymasnory(){
        $('.masonry').masonry({
            itemSelector: '.item',
            gutterWidth: 220,
            isAnimated: true,
        })
    }
    Mymasnory();
    $(window).resize(function() {
        Mymasnory();
        console.log('Mymasnory');
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
});
