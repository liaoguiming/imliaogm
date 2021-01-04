@extends('home.chatBase')

@section('content')
    <style>
        .main-div{margin:0 auto;width: 1200px;background-color: rgb(95,103,106);min-height: 653px;height: 673px;}
        .chat-div{width: 1200px;height: 673px;}
        .info-div{min-width: 800px;height: 671px;border: 1px solid #ccc;background-color: #FFFFFF;}
        .info-div p{font-size: 15px;padding: 10px 20px;}
        /*左边侧栏开始*/
        .nav{width: 60px;height: 673px;float: left;border-right: 1px solid #ccc;background-color: rgb(46,42,41)}
        .nav ul{}
        .nav ul li{height: 53px;line-height: 53px;text-align: center;cursor: pointer;}
        .avatar{height: 73px;text-align: center;line-height: 73px; cursor: pointer;}
        /*左边侧栏结束*/
        /*左边好友框开始*/
        .left{width: 250px;border-right: 1px solid #ccc;float: left;height: 673px;}
        .online-num{font-size: 15px;padding: 10px;font-weight: bold;height: 53px; line-height: 53px;text-align: center}
        .chat-online-group{height:64px;overflow: hidden;border-top: 1px solid #ccc}
        .chat-online-group ul{height:64px;font-size: 14px;}
        .chat-online-group ul li{text-align: left;padding: 10px;cursor: pointer;overflow: hidden;}
        .chat-online-group ul li span{height: 24px; line-height: 24px;}
        .chat-online-group ul li:hover{background-color: #f0f7ff}
        .chat-online-group ul li img{border-radius: 50%}
        .chat-online-group-last-info{font-size: 12px;color: rgb(153,153,160);margin-top: 5px;}
        .chat-online-person{height:580px;overflow: hidden;}
        .chat-online-person ul{height:580px;overflow-y: scroll;font-size: 14px;}
        .chat-online-person ul::-webkit-scrollbar {/*滚动条整体样式*/
            width: 10px;     /*高宽分别对应横竖滚动条的尺寸*/
            height: 1px;
            scrollbar-arrow-color:red;
            display: none;
        }
        .chat-online-person ul::-webkit-scrollbar-thumb {/*滚动条里面小方块*/
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.2);
            background: rgb(95,103,106);
            scrollbar-arrow-color:red;
        }
        .chat-online-person ul::-webkit-scrollbar-track {/*滚动条里面轨道*/
            -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.2);
            border-radius: 0;
            background: #FFFFFF;
        }
        .chat-online-person ul li{text-align: left;padding: 10px;cursor: pointer;overflow: hidden;}
        .chat-online-person ul li span{height: 24px; line-height: 24px;}
        .chat-online-person ul li:hover{background-color: #f0f7ff}
        .chat-online-person ul li img{border-radius: 50%}
        /*左边好友框结束*/
        /*右边聊天框开始*/
        .right{width: 886px;float: right;}
        .chat-title{height: 53px;padding: 10px;text-align: center;font-size: 15px;font-weight: bold; line-height: 53px;}
        .chat-main{height: 469px;overflow: scroll;border-top: 1px solid #ccc; margin-bottom: 15px;}
        .chat-main::-webkit-scrollbar {/*滚动条整体样式*/
            width: 10px;     /*高宽分别对应横竖滚动条的尺寸*/
            height: 1px;
            scrollbar-arrow-color:red;
            display: none;
        }
        .chat-main::-webkit-scrollbar-thumb {/*滚动条里面小方块*/
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.2);
            background: rgb(95,103,106);
            scrollbar-arrow-color:red;
        }
        .chat-main::-webkit-scrollbar-track {/*滚动条里面轨道*/
            -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.2);
            border-radius: 0;
            background: #FFFFFF;
        }
        .chat-input{border-top: 1px solid #ccc;font-size: 13px;height: 80px;}
        .chat-with{color: red}
        .input-info{font-size: 15px;padding: 20px;}
        .input-button{float: right;margin-right: 30px;background-color:rgb(95,103,106);margin-top: 30px;}
        /*右边聊天框结束*/
        .record-user-name{font-size: 12px !important; color: #005AA0;}
        .record-p{margin-left: 5px}
        .record-content{background-color: #f0f7ff;padding: 10px;margin-right: 5px;}
        .send{color: green;font-size: 13px;text-align: right;padding: 5px 25px;}
        .time{text-align: center;padding-top: 10px;color: grey !important;}
        .welcome{float: right; padding-right: 30px;}
    </style>
    <div class="main-div">
        <div class="chat-div">
            <div class="info-div">
                <div class="nav">
                        <div class="avatar"><img src="/static/home/img/avatar.jpg" width="40" height="40" style="border-radius: 50%;"></div>
                        <ul>
                            <li><img src="/static/home/img/im.png" width="24" height="24" index="0"></li>
                            <li><img src="/static/home/img/friend.png" width="24" height="24" index="1"></li>
                        </ul>
                </div>
                <div class="left">
                    <div class="online-num">当前在线人数：<span class="online-number">{{$onlineNum}}</span>人</div>
                    <div class="chat-online-group">
                        <ul>
                            <li onselectstart="return false" onclick="group_dblclick();" class="group-li">
                                <div style="float: left;"><img src="/static/home/img/avatar.jpg" width="36" height="36" style="padding: 2px;"/></div>
                                <div style="float: left; height: 44px;overflow: hidden;margin-left: 8px;">
                                    <div class="chat-every-title">群聊天室</div>
                                    <div class="chat-online-group-last-info"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="chat-online-person">
                        <ul>
                        </ul>
                    </div>
                </div>
                <div class="right">
                    <div class="chat-title"><span class="chat-with"></span><span class="welcome"></span></div>
                    <div id="showChatInfo" class="chat-main"></div>
                    <div class="chat-input">
                        <input type="text" placeholder="" autocomplete="off" class="layui-input input-info" id="inputInfo" style="border: none;">
                        <button type="button" class="layui-btn input-button" onclick="sendInfo();">发送</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var AllHtml = "";
        //websocket连接信息
        var websocket = {};
        //cookie保存的用户名
        var userName = "{{$userName}}";
        //聊天记录
        var chatRecord = [];
        var wsServer = '';
        $(document).ready(function(){
            $('.chat-input').click(function(){
                $('#inputInfo').focus();
            });
            if(!userName){
                //如果没有昵称,需要选择一个昵称
                setName();
            }else{
                //有昵称则直接连接服务器
                getWebSocket(userName);
            }
            //聊天面板最左侧hover操作
            $('.nav ul li').each(function(){
                var index = $(this).find('img').attr('index');
                var icon_list = ['im.png', 'friend.png'];
                var icon_hover_list = ['im_hover.png', 'friend_hover.png'];
                $(this).hover(function(){
                    $(this).find('img').attr('src', '/static/home/img/' + icon_hover_list[index]);
                },function(){
                    $(this).find('img').attr('src', '/static/home/img/' + icon_list[index]);
                });
            })
        });

        //websocket连接服务器
        function getWebSocket(userName){
            //wsServer = 'ws://192.168.2.128:9502/?userName=' + userName;
            wsServer = 'ws://118.24.148.110:9502/?userName=' + userName;
            websocket = new WebSocket(wsServer);
            websocket.onopen = function (evt) {
                appendHtml();
            };
            //接受到服务器返回的消息
            websocket.onmessage = function (evt) {
                //解析json数据
                var info = jQuery.parseJSON(evt.data);
                //获取在线人数
                var num = info.online_num > 0 ? info.online_num : 0;
                //聊天记录
                chatRecord = info.data;
                //展示在线人数
                $('.online-number').html(num);
                //获取群聊天室最后发言
                $('.chat-online-group-last-info').html(info.groupLastInfo);
                //进入页面后默认进入群聊天室
                if($('.chat-with').html() == ''){
                    $('.welcome').attr('fd', info.fd);
                    group_dblclick();
                }
                if(info.type == 'private' && info.show_fd > 0){
                    //如果接受到私聊信息需要自动打开对话框并显示聊天记录
                    var _open = $('#li_fd_' + info.show_fd);
                    li_dblclick(_open, info.show_fd,  _open.attr('index'));
                }else if(info.type == 'public' && info.show_fd == 0){
                    //如果是群聊
                    group_dblclick();
                }
                //显示左边聊天列表
                initFriends(info.fd_keys, info.fd_vals, info.personLastInfo, info.show_fd);
                //根据cookie设置用户信息
                if(userName){
                    $('.welcome').html("欢迎你，" + userName);
                }
                appendHtml();
            };
            websocket.onclose = function (evt) {
                var info = jQuery.parseJSON(evt.data);
                AllHtml += '<p>' + "服务器已经关闭连接..." + '</p>';
                appendHtml();
                $('.online-number').html(0);
            };
            websocket.onerror = function (evt, e) {
                AllHtml += '<p>' + "服务器出错,请稍候重试！..." + '</p>';
                appendHtml();
            };
        }

        //进入群聊天室
        function group_dblclick(){
            var _chat_with = $('.chat-with');
            _chat_with.html("群聊天室");
            _chat_with.attr('index', -1);
            _chat_with.attr('fd', 0);
            _chat_with.attr('type', 'public');
            $('.chat-li').css('background-color', '#FFFFFF');
            $('.group-li').css('background-color', '#f0f7ff');
            //展示群聊天室聊天信息
            showChatRecord(chatRecord, 0);
        }

        //双击好友  默认连接服务器的人都是好友 都能看见对方
        function li_dblclick(obj, fd, a){
            //双击后先清除页面聊天记录展示
            AllHtml = '';
            var _chat_with = $('.chat-with');
            _chat_with.html(obj.find('.chat-every-title').html());
            _chat_with.attr('index', a);
            _chat_with.attr('fd', fd);
            _chat_with.attr('type', 'private');
            $('.chat-li').css('background-color', '#FFFFFF');
            $('.group-li').css('background-color', '#FFFFFF');
            obj.css('background-color', '#f0f7ff');
            //展示私聊聊天信息
            showChatRecord(chatRecord, 1);
        }

        //显示聊天记录
        function showChatRecord(data, type){
            var _chat_with = $('.chat-with').html();
            group = '';
            person = '';
            for(var a = 0; a < data.length; a++) {
                if (0 == data[a]['to_fd'] && 'group' == data[a]['to']) {
                    if(userName == data[a]['user_name']){
                        group += '<p class="time">' + data[a]['time'] + '</p>';
                        group += '<p class="record-user-name send">' + data[a]['user_name'] + '</p><p class="record-p send"><span class="record-content">' + data[a]['content'] + '</span></p>';
                    }else{
                        group += '<p class="time">' + data[a]['time'] + '</p>';
                        group += '<p class="record-user-name">' + data[a]['user_name'] + '</p><p class="record-p"><span class="record-content">' + data[a]['content'] + '</span></p>';
                    }
                }else if(0 != data[a]['to_fd']){
                    if(userName == data[a]['from'] && _chat_with == data[a]['to']){
                        person += '<p class="time">' + data[a]['time'] + '</p>';
                        person += '<p class="record-user-name send">' + data[a]['user_name'] + '</p><p class="record-p send"><span class="record-content">' + data[a]['content'] + '</span></p>';
                    }else if(userName == data[a]['to'] && _chat_with == data[a]['from']){
                        person += '<p class="time">' + data[a]['time'] + '</p>';
                        person += '<p class="record-user-name">' + data[a]['user_name'] + '</p><p class="record-p"><span class="record-content">' + data[a]['content'] + '</span></p>';
                    }
                }
            }
            AllHtml = type == 0 ? group : person;
            appendHtml();
        }

        //根据在线人数展示聊天好友
        /**
         *
         * @param fds 所有连接的数组
         * @param userNames 所有用户名的数组 和连接数组一一对应
         * @param showId 需要展示的数组
         */
        function initFriends(fds, userNames, last, showId){
            var html = '';
            open = open ? open : $('.chat-with').attr('fd');
            for(var i = 0; i < fds.length; i++){
                if($('.welcome').attr('fd') != fds[i]){
                    if(fds[i] == showId){
                        html += '<li style="background-color:#f0f7ff" onselectstart="return false" class="chat-li" ondblclick="li_dblclick($(this), '+fds[i]+', '+i+')" onmouseover="li_mouseover(this)" onmouseout="li_mouseout(this)" id="li_fd_'+fds[i]+'" index="'+i+'">';
                    }else{
                        html += '<li onselectstart="return false" class="chat-li" ondblclick="li_dblclick($(this), '+fds[i]+', '+i+')" onmouseover="li_mouseover(this)" onmouseout="li_mouseout(this)" id="li_fd_'+fds[i]+'" index="'+i+'">';
                    }
                    html += '<div style="float: left;"><img src="/static/home/img/avatar.jpg" width="36" height="36" style="padding: 2px;"/></div>';
                    html += '<div style="float: left; height: 44px;overflow: hidden;margin-left: 8px;">';
                    html += '<div class="chat-every-title" id="server_fd_'+fds[i]+'">'+userNames[i]+'</div>';
                    html += '<div style="font-size: 12px;color: rgb(153,153,160);margin-top: 5px;cursor: pointer;" id="last_chat_record_'+fds[i]+'">双击聊天</div></div></li>'
                }
            }
            $('.chat-online-person ul').html(html);
        }

        function get_name(){
            $.get('/getName', {}, function(json){
                $('#getName').val(json.name);
            });
        }

        function setName(){
            layer.open({
                title : '聊天昵称'
                ,type: 1
                ,offset: 'auto'
                ,area: '400px;'
                ,id: 'layerDemo1' //防止重复弹出
                ,content: '<div style="padding: 30px; color: #ccc;font-size: 14px;height: 50px;"><input type="text" placeholder="输入一个聊天昵称或者随机选择一个昵称" autocomplete="off" class="layui-input" style="float: left; width: 80%" id="getName"><img src="/static/home/img/touzi.jpg" style="margin-left: 5px;float: left;cursor: pointer;" width="36" height="36" onclick="get_name();"></div>'
                ,btn: '确定'
                ,btnAlign: 'c' //按钮居中
                ,shade: 0.3 //不显示遮罩
                ,yes: function(){
                    var name = $('#getName').val();
                    if(!name){
                        layer.msg('请输入昵称或者随机选择一个昵称');return;
                    }
                    $.post('/saveName', {name:name}, function(data){
                        if(data.error == 0){
                            $('.welcome').html("欢迎你，" + name);
                            getWebSocket(name);
                            userName = name;
                            layer.closeAll();
                        }else{
                            layer.msg(data.msg);
                        }
                    });
                }
            });
        }

        //聊天信息操作
        function appendHtml(){
            var _showInfo = $('#showChatInfo');
            _showInfo.html(AllHtml);
            _showInfo.animate({scrollTop: _showInfo[0].scrollHeight}, 100);
        }
        //好友列表鼠标移入移出事件
        function li_mouseover(obj){
            $('.chat-li').not('.chat-li:eq(' +$('.chat-with').attr('index')+ ')').css('background-color', '#FFFFFF');
            $(obj).css('background-color', '#f0f7ff');
        }
        function li_mouseout(obj){
            $('.chat-li').css('background-color', '#FFFFFF');
            $('.chat-li:eq(' +$('.chat-with').attr('index')+ ')').css('background-color', '#f0f7ff');
        }
        function getTime(){
            var myDate = new Date;
            var year = myDate.getFullYear(); //获取当前年
            var mon = myDate.getMonth() + 1; //获取当前月
            var date = myDate.getDate(); //获取当前日
            // var h = myDate.getHours();//获取当前小时数(0-23)
            // var m = myDate.getMinutes();//获取当前分钟数(0-59)
            // var s = myDate.getSeconds();//获取当前秒
            var week = myDate.getDay();
            var weeks = ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"];
            console.log(year, mon, date, weeks[week])
            $("#time").html(year + "年" + mon + "月" + date + "日" + weeks[week]);
        }

        function sendInfo(){
            var _input = $('#inputInfo');
            var _chat = $('.chat-with');
            var html = _input.val();
            if(html == ''){
                layer.msg("发送信息不能为空,请重新输入。");return;
            }
            data = {
                type:_chat.attr('type'),
                content:html,
                userName:userName,
                chatWith:_chat.html(),
                chatWithFd:_chat.attr('fd')
            };
            console.log(data);
            websocket.send(JSON.stringify(data));
            _input.val('');
            appendHtml();
        }

        $(document).keyup(function(event){
            if(event.keyCode ==13){
                var _inputInfo = $('#inputInfo');
                if(_inputInfo.is(':focus') || _inputInfo.val()){
                    sendInfo();
                }else{
                    _inputInfo.focus();
                }
            }
        });
    </script>
@endsection

