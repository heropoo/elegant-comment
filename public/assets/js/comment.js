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
        var comment_container = document.getElementById(container);
        if(comment_container == undefined){
            comment_container = document.createElement('div');
            comment_container.id = container_id;
            document.body.appendChild(comment_container);
        }
        comment_container.innerText = 'comment loading';
    };

    return {
        init: init
    };
});