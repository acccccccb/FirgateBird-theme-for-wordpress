/*
 FrigateBird-LightBox
 Version:	v1.0.0
 Author:		futureis404
 Website:	http://www.python-pro.com
 GitHub:		https://github.com/futureis404/FrigateBird-LightBox
 */
$(document).ready(function(){
    var ImgBoxFlash = 400; //闪烁时间
    var OpenBox = 500; //打开时间
    var CloseBox = 500; //关闭时间
    var scale = 1;//缩放大小
    var RangeImg = '.article-body>p>img,.article-body>p>a>img';

    var ImgText,ImgTit;
    var ViewImgObj = [];
    var JSONIndex = -1;
    var ViewImgHtml = '';
    //初始化数据
    function LoadIni() {
        $('.ImgBox>img').css({
            'max-height':500 * scale + 'px'
        });
        $('.ImgWindow>.ImgBox>img').css({
            'max-width':600 * scale + 'px'
        });
        $('.ImgListBoxMain').css({
            'width': 600 * scale +'px',
            'height':86 * scale + 'px'
        });
        $('.ImgListBox>.ViewImgList').css({
            'width':110 * scale + 'px',
            'height':70 * scale + 'px',
            'margin':4 * scale + 'px',
            'padding':4 * scale + 'px'
        });
        $('.ImgWindow').css({
            'padding':20 * scale + 'px'
        });
    }
    function ImgFlash() {
        $(".ImgBox").stop(true).fadeOut(ImgBoxFlash,function(){
            $(".ImgBox").fadeIn(ImgBoxFlash);
        });
    }
    function ImgWindow(){
        var AlertHtml = '';
        AlertHtml +='<div class="imgmask mask"></div>';
        AlertHtml +='<div class="ImgWindow">';
        AlertHtml +='<div class="ImgPrev"><img src="/wp-content/themes/FrigateBird/plug-in/FrigateBird-LightBox-master/ico/prev.png" /></div>';
        AlertHtml +='<div class="ImgNext"><img src="/wp-content/themes/FrigateBird/plug-in/FrigateBird-LightBox-master/ico/next.png" /></div>';
        AlertHtml +='<div class="ImgBox">' + ImgText;
        AlertHtml +='<div class="ImgText">' + ImgTit + '</div>';
        AlertHtml +='</div>';
        AlertHtml +='<div class="ImgListBoxMain">';
        AlertHtml +='<div class="ImgListBox">'+ViewImgHtml+'</div>';
        AlertHtml +='</div>';
        AlertHtml +='<div class="ImgKey"><span>可用方向键"←"和"→"浏览</span></div>';
        AlertHtml +='<div class="closeBtnIco" ><img src="/wp-content/themes/FrigateBird/plug-in/FrigateBird-LightBox-master/ico/close.png" /></div>';
        AlertHtml +='<span class="ImgNumber"></span>';
        AlertHtml +='</div>';
        AlertHtml +='</div>';
        $('body').append(AlertHtml);
        $(".mask").fadeIn(OpenBox,function(){
            $('.ImgWindow').fadeIn(OpenBox);
        });
    }
    //关闭
    function CloseImgWindow() {
        $(".ImgWindow").fadeOut(CloseBox,function(){
            $(".imgmask,.ImgWindow").remove();
        });
    }
    //调整位置
    function MoveTo(){
        var ImgWindowWidth = ($('.ImgWindow>.ImgBox').outerWidth(true) + 20*scale*2)/2;
        var ImgWindowHeight = ($('.ImgWindow>.ImgBox').outerHeight(true) + $('.ImgListBoxMain').outerHeight(true) + 20*scale*2 ) / 2;
        $('.ImgWindow').stop().animate({marginLeft:-ImgWindowWidth,marginTop:-ImgWindowHeight});
        LoadIni();
    }
    //点击下方缩略图显示对应图片
    $(document).on('click','.ViewImgList',function(){
        ImgFlash();
        var ViewImgListSrc = $(this).children('img').attr('src');
        var ViewImgListTit = $(this).children('img').attr('alt');
        var ViewImgListIndex = $(this).index();
        var ViewImgListLength = $('.ViewImgList').length;
        var ImgListMove = $(this).outerWidth(true) * ($(this).index()-2);

        setTimeout(function(){
            $('.ImgBox').children('img').attr('src',''+ ViewImgListSrc +'');
        },ImgBoxFlash/2.5);

        $('.ImgText').text(''+ ViewImgListTit +'');
        $(this).addClass('ViewImgListFocus').siblings('.ViewImgList').removeClass('ViewImgListFocus');
        $('.ImgNumber').text(ViewImgListIndex + 1 + ' / '+ $('.ViewImgList').length);
        MoveTo();
        if(ViewImgListIndex < 2 || ViewImgListIndex + 2 >= ViewImgListLength ) {
            return false;
        } else {
            $('.ImgListBox').animate({ 'marginLeft':-ImgListMove+'px' });
        }
    });

    //键盘事件
    $(document).keydown(function(event){
        var ImgKey = event.keyCode;
        if (ImgKey==37) {
            $('.ImgPrev').click();
        }
        if (ImgKey==39) {
            $('.ImgNext').click();
        }
    });

    $(RangeImg).each(function(){
        JSONIndex++;
        var JSONUrl = $(this).attr('src');
        var JSONTitle = $(this).attr('alt');
        var JSONViewImg = {"index":JSONIndex,"url":JSONUrl,"title":JSONTitle};
        ViewImgObj.push(JSONViewImg);
        ViewImgHtml += '<div class="ViewImgList"><img alt="'+JSONTitle+'" src="'+JSONUrl+'" /></div>';
    });

    //上一张图
    $('body').on('click','.ImgPrev',function(){
        ImgFlash();
        var TempImgUrl = $(this).siblings('.ImgBox').children('img').attr('src');
        $.each(ViewImgObj,function(index, content){
            if(content.url==TempImgUrl){
                var ImgNumber = content.index - 1;
                if(ImgNumber == -1) {
                    ImgNumber = JSONIndex;
                }

                setTimeout(function(){
                    $('.ImgBox').html('<img src="' + ViewImgObj[ImgNumber].url + '" />' + '<div class="ImgText">' + ViewImgObj[ImgNumber].title + '</div>');
                },ImgBoxFlash/2.5);

                $('.ViewImgList:eq('+ViewImgObj[ImgNumber].index+')').addClass('ViewImgListFocus').siblings('.ViewImgList').removeClass('ViewImgListFocus');
                var ImgListMove = $('.ViewImgList:eq('+ViewImgObj[ImgNumber].index+')').outerWidth(true) * (ViewImgObj[ImgNumber].index-2);
                var ViewImgObjMaxLength = $('.ViewImgList').length;
                if(ViewImgObj[ImgNumber].index <= 2 && ViewImgObjMaxLength > 5 ) {
                    $('.ImgListBox').animate({ 'marginLeft':'0px' });
                }
                if(ViewImgObj[ImgNumber].index > 2 && ViewImgObj[ImgNumber].index < ViewImgObjMaxLength - 3 && ViewImgObjMaxLength > 5) {
                    $('.ImgListBox').animate({ 'marginLeft':-ImgListMove+'px' });
                }
                if(ViewImgObj[ImgNumber].index >= ViewImgObjMaxLength - 3 && ViewImgObjMaxLength > 5) {
                    ImgListMove = $('.ViewImgList').outerWidth(true) * (ViewImgObjMaxLength-5);
                    $('.ImgListBox').animate({ 'marginLeft':-ImgListMove+'px' });
                }
                var FocusImgIndex = ViewImgObj[ImgNumber].index + 1;
                $('.ImgNumber').text(FocusImgIndex + ' / '+ $('.ViewImgList').length);
            }
        });
        MoveTo();
    });
    //下一张图
    $('body').on('click','.ImgNext',function(){
        ImgFlash();
        var TempImgUrl = $(this).siblings('.ImgBox').children('img').attr('src');
        $.each(ViewImgObj,function(index, content){
            if(content.url==TempImgUrl){
                var ImgNumber = content.index + 1;
                if(ImgNumber > JSONIndex) {
                    ImgNumber = 0;
                }
                setTimeout(function(){
                    $('.ImgBox').html('<img src="' + ViewImgObj[ImgNumber].url + '" />' + '<div class="ImgText">' + ViewImgObj[ImgNumber].title + '</div>');
                },ImgBoxFlash/2.5);

                $('.ViewImgList:eq('+ViewImgObj[ImgNumber].index+')').addClass('ViewImgListFocus').siblings('.ViewImgList').removeClass('ViewImgListFocus');
                var ImgListMove = $('.ViewImgList:eq('+ViewImgObj[ImgNumber].index+')').outerWidth(true) * (ViewImgObj[ImgNumber].index-2);
                var ViewImgObjMaxLength = $('.ViewImgList').length;
                if(ViewImgObj[ImgNumber].index <= 2 && ViewImgObjMaxLength > 5 ) {
                    $('.ImgListBox').animate({ 'marginLeft':'0px' });
                }
                if(ViewImgObj[ImgNumber].index > 2 && ViewImgObj[ImgNumber].index < ViewImgObjMaxLength - 3 && ViewImgObjMaxLength > 5) {
                    $('.ImgListBox').animate({ 'marginLeft':-ImgListMove+'px' });
                }
                if(ViewImgObj[ImgNumber].index >= ViewImgObjMaxLength - 3 && ViewImgObjMaxLength > 5) {
                    ImgListMove = $('.ViewImgList').outerWidth(true) * (ViewImgObjMaxLength-5);
                    $('.ImgListBox').animate({ 'marginLeft':-ImgListMove+'px' });
                }
                var FocusImgIndex = ViewImgObj[ImgNumber].index + 1;
                $('.ImgNumber').text(FocusImgIndex + ' / '+ $('.ViewImgList').length);
            }
        });
        MoveTo();
    });

    $('body').on('click','.closeBtnIco,.CloseBtn,.mask,.ImgBox',function(){
        CloseImgWindow();
    });

    $(RangeImg).on('click',function(){
        var deviceImg = $(this).attr('src');
        ImgTit = $(this).attr('alt');
        ImgText = '<img src="' + deviceImg + '" />';
        ImgWindow();
        var Temp1ImgUrl = $(this).attr('src');
        var ImgIndexLength = $('.ViewImgList').length;
        $('.ImgListBox').css({
            'width': $('.ViewImgList').outerWidth(true) * ImgIndexLength * 1.2 +'px'
        });
        $.each(ViewImgObj,function(index, content){
            if(content.url==Temp1ImgUrl){
                var Img1Number = content.index;
                if(Img1Number == -1) {
                    Img1Number = JSONIndex;
                }
                var ImgListMove = $('.ViewImgList').outerWidth(true) * (Img1Number-2);

                if(Img1Number <= 2) {
                    $('.ImgListBox').animate({ 'marginLeft':'0px' });
                }
                if(Img1Number > 2 && Img1Number < ImgIndexLength - 3 && ImgIndexLength > 5) {
                    $('.ImgListBox').animate({ 'marginLeft':-ImgListMove+'px' });
                }
                if(Img1Number >= ImgIndexLength - 3 && ImgIndexLength > 5 ) {
                    ImgListMove = $('.ViewImgList').outerWidth(true) * (ImgIndexLength-5);
                    $('.ImgListBox').animate({ 'marginLeft':-ImgListMove+'px' });
                }
                $('.ViewImgList:eq('+ViewImgObj[Img1Number].index+')').addClass('ViewImgListFocus').siblings('.ViewImgList').removeClass('ViewImgListFocus');
                var FocusImgIndex = ViewImgObj[Img1Number].index + 1;
                $('.ImgNumber').text(FocusImgIndex + ' / '+ $('.ViewImgList').length);
            }
        });
        LoadIni();
        var ImgWindowWidth = (-$('.ImgWindow').outerWidth(true)/2) * scale ;
        var ImgWindowHeight = (-$('.ImgWindow').outerHeight(true)/2) * scale;
        $('.ImgWindow').animate({marginLeft:ImgWindowWidth,marginTop:ImgWindowHeight});
    });
});