define(function(){
    var id,token,container;   //article_id,auth_token and container
    var init = function(config){
        config = config || {};
        if(config.token == undefined){
            console.warn('Please set `token`');
            return false;
        }
        id = config.id || window.location.href;
        token = config.token;
        container = config.container || '#_comment_'+Math.round(Math.random()*10000000);
        console.log(id, token, container);
        var container_id = container.substr(1);
        console.log('container_id:'+container_id);
        var comment_container = document.getElementById(container_id);
        if(comment_container == undefined){
            comment_container = document.createElement('div');
            comment_container.id = container_id;
            document.body.appendChild(comment_container);
        }
        comment_container.className = 'comment-container';

        comment_container.innerHTML = '<div>' +
            '<ul class="comment-list">' +
            '<li><a href="#" target="_blank">小明</a>：写的真好👍</li>' +
            '<li><a href="https://www.ioio.pw" target="_blank">Heropoo</a>：嘻嘻~😄😄</li>' +
            '</ul>' +
            '<form action="#" id="'+container_id+'_form">' +
            '<div class="row"><label>您的留言 <span class="red-star">*</span>：</label><textarea name="content" id="'+container_id+'_content" cols="10" rows="5" placeholder="请输入您的留言" required></textarea></div>' +
            '<div class="row"><label>您的大名 <span class="red-star">*</span>：</l30abel><input type="text" name="username" id="'+container_id+'_username" value="" placeholder="请输入您的大名" required></div>' +
            '<div class="row"><label>电子邮件 <span class="red-star">*</span>：</l30abel><input type="email" name="email" id="'+container_id+'_email" value="" placeholder="请输入您的Email" required></div>' +
            '<div class="row"><label>个人网址 &nbsp;&nbsp;：</label><input type="url" name="website" id="'+container_id+'_email" value="" placeholder="请输入您的个人网站"></div>' +
            '<div class="row"><label></label><button>发布</button></div>' +
            '</form>'+
            '</div>';
    };

    return {
        init: init
    };
});