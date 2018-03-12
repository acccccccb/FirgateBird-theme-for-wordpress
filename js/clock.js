var can = document.getElementById('canvas');
var locText = document.getElementById('location');
var ctx=can.getContext("2d");

//圆心坐标
var a = canvas.width/2;
var b = canvas.height/2;

function strokecircle(r,width,color){ // 表盘
    ctx.beginPath();
    ctx.strokeStyle = color;
    ctx.lineWidth = width;
    ctx.arc(a,b,r,0,2*Math.PI);
    ctx.stroke();
    ctx.closePath();
}

function strokeline(r,width,color,sec){ // 线条
    var t,u;
    ctx.beginPath();
    ctx.lineCap="round";
    ctx.strokeStyle = color;
    ctx.lineWidth = width;
    ctx.shadowColor="rgba(0,0,0,0.6)";
    ctx.shadowOffsetX=2;
    ctx.shadowOffsetY=2;
    ctx.shadowBlur=3;
    ctx.moveTo(a,b);
    t=a+r*Math.cos(2*Math.PI/360*sec);
    u=b+r*Math.sin(2*Math.PI/360*sec);
    ctx.lineTo(t,u);
    ctx.stroke();
    ctx.closePath();
}

function fillcircle(r,color){ // 填充圆
    ctx.beginPath();
    ctx.shadowColor="#ffffff";
    ctx.shadowOffsetX=0;
    ctx.shadowOffsetY=0;
    ctx.shadowBlur=0;
    ctx.arc(a,b,r,0,2*Math.PI);
    ctx.fillStyle=color;
    ctx.fill();
    ctx.closePath();
}

function grdcircle(r,color1,color2){ // 空心圆
    ctx.beginPath();
    var grd=ctx.createLinearGradient(150,0,150,300);
    grd.addColorStop(0,color1);
    grd.addColorStop(1,color2);
    ctx.shadowColor="#ffffff";
    ctx.shadowOffsetX=0;
    ctx.shadowOffsetY=0;
    ctx.shadowBlur=0;
    ctx.arc(a,b,r,0,2*Math.PI);
    ctx.fillStyle=grd;
    ctx.fill();
    ctx.closePath();
}


function clocknumber(r,color,fontstyle){ // 表盘数字
    ctx.beginPath();
    ctx.shadowColor="#ffffff";
    ctx.shadowOffsetX=0;
    ctx.shadowOffsetY=0;
    ctx.shadowBlur=0;
    ctx.font = fontstyle;
    for(var p=1;p<=60;p++) {
        var o = (p-15)*6;
        t=a+r*Math.cos(2*Math.PI/360*o);
        u=b+r*Math.sin(2*Math.PI/360*o);
        if(isInteger(p/5)){
            ctx.fillStyle=color;
            var text = ""+p/5+"";
            var w=ctx.measureText(text).width/2;
            ctx.fillText(p/5,t-w,u+9);
        }
        ctx.closePath();
    }
}

function fillText(x,y,fontcolor,fontstyle,text,align){ // 文字
    ctx.beginPath();
    ctx.shadowColor=fontcolor;
    ctx.shadowOffsetX=0;
    ctx.shadowOffsetY=0;
    ctx.shadowBlur=0;
    ctx.fillStyle=fontcolor;
    ctx.font=fontstyle;
    text = ""+text+"";
    if(align=="center") {
        ctx.fillText(text,x-(ctx.measureText(text).width/2),y);
    } else {
        ctx.fillText(text,x,y);
    }
    ctx.closePath();
}



function isInteger(obj) { // 判断整数
    return Math.floor(obj) === obj;
}

function scale(r,width){ // 刻度
    for(var p=1;p<=60;p++) {
        var o=p*6;
        t=a+r*Math.cos(2*Math.PI/360*o);
        u=b+r*Math.sin(2*Math.PI/360*o);
        if(isInteger(o/5)){
            ctx.lineWidth=2*width;
            v=a+(r-12)*Math.cos(2*Math.PI/360*o);
            c=b+(r-12)*Math.sin(2*Math.PI/360*o);
        } else {
            ctx.lineWidth=width;
            v=a+(r-6)*Math.cos(2*Math.PI/360*o);
            c=b+(r-6)*Math.sin(2*Math.PI/360*o);
        }
        ctx.beginPath();
        ctx.strokeStyle="#000000";
        ctx.lineCap="round";
        ctx.moveTo(t,u);
        ctx.lineTo(v,c);
        ctx.stroke();
        ctx.closePath();
    }
}

function second(s,l){ // 秒针
    var sec = (s-15)*6;
    strokeline(l,2,"red",sec);
}
function minute(rot,s,l){ // 分针
    rot = rot+s/60-15;
    var sec = rot*6;
    strokeline(l,8,"#222222",sec);
    strokeline(l-2,2,"#ffffff",sec);
}
function hour(rot,m,l){ // 时针
    rot = rot*5+(m/60)*5-15;
    var sec = rot*6;
    strokeline(l,10,"#222222",sec);
    strokeline(l-2,2,"#ffffff",sec);
}

function strokerect(x,y,a,b,width,color){ // 矩形
    ctx.beginPath();
    ctx.strokeStyle=color;
    ctx.lineWidth=width;
    ctx.strokeRect(x,y,a,b);
    ctx.closePath();
}

function fillerect(x,y,a,b,width,color){ // 矩形
    ctx.beginPath();
    ctx.fillStyle=color;
    ctx.lineWidth=width;
    ctx.fillRect(x,y,a,b);
    ctx.closePath();
}

function getTime(){ // 获取时间
    var myDate = new Date();
    var myDay = myDate.getDate()
    var myWeek = myDate.getDay();
    var timeSec = myDate.getSeconds();
    var timeMinu = myDate.getMinutes();
    var timeHour = myDate.getHours();
    var Millsec = myDate.getMilliseconds()/1000;
    var arr_week = new Array("MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN");
    myDate = {
        "myDay":myDay,
        "myWeek":arr_week[myWeek],
        "timeSec":timeSec,
        "timeMinu":timeMinu,
        "timeHour":timeHour,
        "Millsec":Millsec
    };
    return myDate;
}

function CanvasScale(n){ // 缩放
    n = n/350;
    can.width=350*n;
    can.height=350*n;
    ctx.scale(n,n);
}

function clock(){
    var s = getTime().timeSec;
    var m = getTime().timeMinu;
    var h = getTime().timeHour;
    var ms = getTime().Millsec;
    var myweek = getTime().myWeek;
    var myday = getTime().myDay;
    
    ctx.clearRect(0,0, canvas.width, canvas.height);
    grdcircle(150,"#333","#000");
    grdcircle(144,"#999","#ccc");
    grdcircle(134,"#666","#999");
    grdcircle(133,"#fff","#dedede");
    scale(131,1);
    fillText(175,123,"#222","18px Georgia bold","CANVAS","center");
    fillText(175,236,"#222","10px Tahoma bold","WWW.IHTMLCSS.COM","center");
    strokerect(208,167,52,17,1,"#000");
    fillerect(209,168,50,16,1,"#f1f1f1");
    fillerect(241,167,1,17,1,"#222");
    if (myweek=="SUN"){
        var weekcolor = "red";
    } else {
        var weekcolor = "#222";
    }
    fillText(225,181,weekcolor,"14px Tahoma bold",myweek,"center");
    fillText(250,181,"#222","14px Tahoma bold",myday,"center");
    clocknumber(102,"#222","24px Arial  bold");
    fillcircle(10,"#999");

    hour(h,m,70);
    minute(m,s,92);
    second(s+ms,120);
    second(s+ms+30,18);
    fillcircle(5,"red");
    fillcircle(3,"#e2d8a1");
}
self.setInterval(clock,200);
CanvasScale(600);// 缩放