import './css/style.css';

const axios = require('axios');

const commentTpl = `
<div class="comment-container">
    <div class="comment-form">
        <form action="" id="commentForm">
            <div class="comment-input-group">
                <input type="text" name="nickname" value="" placeholder="昵称" required>
                <input type="email" name="email" value="" placeholder="邮箱" required>
                <input type="url" name="website" value="" placeholder="网站(http://)">
            </div>
            <div>
                <textarea name="content" placeholder="说点什么吧～" required></textarea>
            </div>
            <div class="comment-toolbar" style="display: none">
                <div>
                    <a href="javascript:;" class="comment-face-btn">表情</a>
                    ｜
                    <a href="javascript:;" class="comment-face-btn">预览</a>
                </div>
            </div>
            <div class="comment-btn-group">
                <button type="submit" class="comment-submit-btn">回复</button>
            </div>
        </form>
        <div class="comment-copyright">
            &copy; Powered By <a href="https://github.com/heropoo/pretty-comment">PrettyComment</a>
        </div>
    </div>

    <div class="comment-total"> 共有 0 条评论</div>

    <div class="comment-list">

        <!-- <div class="comment-item">
            <div class="comment-avatar">
                <img src="images/10.jpeg" alt="">
            </div>
            <div style="border: 1px solid #ccc">
                <div>小明</div>
                <div>2020-04-17 17:54</div>
                <div style="color: #333">啊哈哈哈哈哈哈哈4234234哈哈哈哈哈哈哈哈哈哈</div>
            </div>
        </div>

        -->

    </div>
</div>
`;

class PrettyComment {

    constructor(config) {
        this.api = '//p.comment.com';
        //this.api = '//127.0.0.1:4000';
        this.app_id = config.app_id;
        this.app_key = config.app_key;
        this.ele = config.ele;
        this.article_id = window.location.pathname;

        this.container = document.getElementById(this.ele);
    }

    load_comments() {
        let api = this.api;
        let app_id = this.app_id;
        let app_key = this.app_key;
        let article_id = this.article_id;

        let container = this.container;

        axios.get(api + "/api/comment", {
            headers: {'app-id': app_id, 'app-key': app_key},
            params: {article_id: article_id}
        }).then(function (response) {
            console.log(response);
            if (response.status === 200) {
                if (response.data.code === 0) {
                    container.getElementsByClassName('comment-total')[0].innerHTML = '共有 ' + response.data.data.total + ' 条评论';
                    let list = response.data.data.list;
                    let comment_list_tpl = '';
                    for (let i = 0; i < list.length; i++) {
                        comment_list_tpl += '<div class="comment-item">\n' +
                            '    <div class="comment-avatar">\n' +
                            '        <img src="' + list[i].user_head_img + '" alt="">\n' +
                            '    </div>\n' +
                            '    <div>\n' +
                            '        <div><span style="font-weight: bold"><a href="'
                            + (list[i].user_website ? list[i].user_website : 'javascript:;') + '">' + list[i].user_nickname
                            + '</a></span> <span>' + list[i].created_at + '</span></div>\n' +
                            '        <div style="color: #333;">' + list[i].content + '</div>\n' +
                            '    </div>\n' +
                            '</div>';
                    }
                    container.getElementsByClassName('comment-list')[0].innerHTML = comment_list_tpl;
                }
            } else {
                alert('网络请求失败');
            }
        });
    }

    render() {
        let api = this.api;
        let app_id = this.app_id;
        let app_key = this.app_key;
        let article_id = this.article_id;

        let container = this.container;
        container.innerHTML = commentTpl;

        this.load_comments();

        let that = this;

        document.getElementById('commentForm').onsubmit = function (e) {
            let thisForm = e.target;
            let data = {
                nickname: thisForm.nickname.value,
                email: thisForm.email.value,
                website: thisForm.website.value,
                content: thisForm.content.value,
                article_id: article_id
            };
            // data['nickname'] =
            axios.post(api + "/api/comment", JSON.stringify(data),
                {headers: {'app-id': app_id, 'app-key': app_key, 'Content-Type': 'application/json'}}
            ).then(function (response) {
                console.log(response);
                if (response.status === 200) {
                    if (response.data.code === 0) {
                        alert('评论成功');
                        that.load_comments()
                    } else {
                        alert(response.data.msg);
                    }
                } else {
                    alert('网络请求失败');
                }
            });
            return false;
        };
    }
}

window.PrettyComment = PrettyComment;