/**
 * Created by Administrator on 2017/7/24 0024.
 */
$(document).ready(function(){
    var startMessage = "Microsoft Windows [版本 6.1.7601]<br/>版权所有 (c) 2009 Microsoft Corporation。保留所有权利。<br/><br/><br/>";
    //$(".result").append(startMessage);
    $('#sub').click(function(){
        if($('.chatbox').val() == ""){
            return false;
        } else {
            $.ajax({
                url:'chat.php',
                type:"POST",
                data:$('#send').serialize(),
                success: function(data) {
                    $('.result').append('<div>C:\/Users\/Administrator>' + data + '</div>');
                    $('.chatbox').val('');
                    $('.result').scrollTop($('.result')[0].scrollHeight);
                }
            });
        }
    });
});
function send() {
    $('#sub').click();
}