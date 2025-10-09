var S=0,c=[];const U=$(".message-form"),G=$(".message-input"),a=$(".wsus__chat_area_body"),f=$("meta[name=csrf_token]").attr("content"),L=$("meta[name=auth_id]").attr("content");$("meta[name=url]").attr("content");const r=$(".messenger-contacts"),o=()=>$("meta[name=id]").attr("content"),H=e=>$("meta[name=id]").attr("content",e);function N(){$(".wsus__message_paceholder").removeClass("d-none")}function A(){$(".wsus__message_paceholder").addClass("d-none"),$(".wsus__message_paceholder_black").addClass("d-none")}function I(e,s){if(e.files&&e.files[0]){var t=new FileReader;t.onload=function(n){$(s).attr("src",n.target.result)},t.readAsDataURL(e.files[0])}}let l=1,u=!1,M="",m=!1;function j(e){e!=M&&(l=1,u=!1),M=e,!m&&!u&&$.ajax({method:"GET",url:"/messenger/search",data:{query:e,page:l},beforeSend:function(){m=!0,$(".user_search_list_result").append(`
                <div class="text-center search-loader">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                `)},success:function(s){m=!1,$(".user_search_list_result").find(".search-loader").remove(),l<2?$(".user_search_list_result").html(s.records):$(".user_search_list_result").append(s.records),u=l>=(s==null?void 0:s.last_page),u||(l+=1)},error:function(s,t,n){m=!1,$(".user_search_list_result").find(".search-loader").remove()}})}function x(e,s,t=!1){$(e).on("scroll",function(){let n=$(this).get(0);(t?n.scrollTop==0:n.scrollTop+n.clientHeight>=n.scrollHeight)&&s()})}function F(e,s){let t;return function(...n){clearTimeout(t),t=setTimeout(()=>{e.apply(this,n)},s)}}function R(e){$.ajax({method:"GET",url:"/messenger/id-info",data:{id:e},beforeSend:function(){NProgress.start(),N()},success:function(s){B(s.fetch.id,!0),$(".wsus__chat_info_gallery").html(""),s!=null&&s.shared_photos?($(".nothing_share").addClass("d-none"),$(".wsus__chat_info_gallery").html(s.shared_photos)):$(".nothing_share").removeClass("d-none"),T(),s.favorite==1?$(".favourite").addClass("active"):$(".favourite").removeClass("active"),$(".messenger-header").find("img").attr("src",s.fetch.avatar?"storage/avatars/"+s.fetch.avatar:"icon-logo.png"),$(".messenger-header").find("h4").text(s.fetch.pseudo?s.fetch.pseudo:s.fetch.prenom?s.fetch.prenom:s.fetch.nom_salon),$(".messenger-info-view .user_photo").find("img").attr("src",s.fetch.avatar?"storage/avatars/"+s.fetch.avatar:"icon-logo.png"),$(".messenger-info-view").find(".user_name").text(s.fetch.pseudo?s.fetch.pseudo:s.fetch.prenom?s.fetch.prenom:s.fetch.nom_salon),$(".messenger-info-view").find(".user_unique_name").text(s.fetch.profile_type),NProgress.done()},error:function(s,t,n){A()}})}function V(){S+=1;let e=`temp_${S}`,s=!!$(".attachment-input").val();const t=G.val();if(t.length>0||s){const n=new FormData($(".message-form")[0]);n.append("id",o()),n.append("temporaryMsgId",e),n.append("_token",f),$.ajax({method:"POST",url:"/messenger/send-message",data:n,dataType:"JSON",processData:!1,contentType:!1,beforeSend:function(){s?a.append(D(t,e,!0)):a.append(D(t,e)),$(".no_messages").addClass("d-none"),k(a),y()},success:function(i){P(),C(o());const v=a.find(`.message-card[data-id=${i.tempID}]`);v.before(i.message),v.remove(),T()},error:function(i,v,ee){}})}}function D(e,s,t=!1){return t?`
        <div class="wsus__single_chat_area message-card" data-id="${s}">
            <div class="wsus__single_chat chat_right">
                <div class="pre_loader">
                    <div class="spinner-border text-light" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                ${e.length>0?`<p class="messages">${e}</p>`:""}

                <span class="clock"><i class="fas fa-clock"></i> now</span>
            </div>
        </div>
        `:`
        <div class="wsus__single_chat_area message-card" data-id="${s}">
            <div class="wsus__single_chat chat_right">
                <p class="messages">${e}</p>
                <span class="clock"><i class="fas fa-clock"></i> now</span>
            </div>
        </div>
        `}function q(e){return e.attachment?`
        <div class="wsus__single_chat_area message-card" data-id="${e.id}">
            <div class="wsus__single_chat">
            <a class="venobox" data-gall="gallery${e.id}" href="${e.attachment}">
                <img src="${e.attachment}" alt="" class="img-fluid w-100">
            </a>
                ${e.body!=null&&e.body.length>0?`<p class="messages">${e.body}</p>`:""}
            </div>
        </div>
        `:`
        <div class="wsus__single_chat_area message-card" data-id="${e.id}">
            <div class="wsus__single_chat">
                <p class="messages">${e.body}</p>
            </div>
        </div>
        `}function y(){$(".attachment-block").addClass("d-none"),U.trigger("reset");var e=$("#example1").emojioneArea();e.data("emojioneArea").setText("")}let d=1,h=!1,w=!1;function B(e,s=!1){s&&(d=1,h=!1),!h&&!w&&$.ajax({method:"GET",url:"/messenger/fetch-messages",data:{_token:f,id:e,page:d},beforeSend:function(){w=!0,a.prepend(`
                <div class="text-center messages-loader">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                `)},success:function(t){if(w=!1,a.find(".messages-loader").remove(),P(),d==1)a.html(t.messages),k(a);else{const n=$(a).find(".message-card").first(),i=n.offset().top-a.scrollTop();a.prepend(t.messages),a.scrollTop(n.offset().top-i)}h=d>=(t==null?void 0:t.last_page),h||(d+=1),T(),A()},error:function(t,n,i){console.log(i)}})}let g=1,b=!1,p=!1;function E(){!p&&!b&&$.ajax({method:"GET",url:"messenger/fetch-contacts",data:{page:g},beforeSend:function(){p=!0,r.append(`
                <div class="text-center contact-loader">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                `)},success:function(e){p=!1,r.find(".contact-loader").remove(),g<2?r.html(e.contacts):r.append(e.contacts),b=g>=(e==null?void 0:e.last_page),b||(g+=1),W()},error:function(e,s,t){p=!1,r.find(".contact-loader").remove()}})}function C(e){e!=L&&$.ajax({method:"GET",url:"/messenger/update-contact-item",data:{user_id:e},success:function(s){r.find(".no_contact").remove(),r.find(`.messenger-list-item[data-id="${e}"]`).remove(),r.prepend(s.contact_item),c.includes(+e)&&_(e),e==o()&&O(e)},error:function(s,t,n){}})}function P(e){$(`.messenger-list-item[data-id="${o()}"]`).find(".unseen_count").remove(),$.ajax({method:"POST",url:"/messenger/make-seen",data:{_token:f,id:o()},success:function(){},error:function(){}})}function Y(e){$(".favourite").toggleClass("active"),$.ajax({method:"POST",url:"messenger/favorite",data:{_token:f,id:e},success:function(s){s.status=="added"?notyf.success("Added to favorite list."):notyf.success("Removed from favorite list.")},error:function(s,t,n){}})}function z(e){Swal.fire({title:"Are you sure?",text:"You won't be able to revert this!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, delete it!"}).then(s=>{s.isConfirmed&&$.ajax({method:"DELETE",url:"/messenger/delete-message",data:{_token:f,message_id:e},beforeSend:function(){$(`.message-card[data-id="${e}"]`).remove()},success:function(t){C(o())},error:function(t,n,i){}})})}function O(e){$(".messenger-list-item").removeClass("active"),$(`.messenger-list-item[data-id="${e}"]`).addClass("active")}function k(e){$(e).stop().animate({scrollTop:$(e)[0].scrollHeight})}function T(){$(".venobox").venobox()}function J(){new Audio("/default/message-sound.mp3").play()}window.Echo.private("message."+L).listen("Message",e=>{console.log(e),o()!=e.from_id&&(C(e.from_id),J());let s=q(e);o()==e.from_id&&(a.append(s),k(a))});window.Echo.join("online").here(e=>{Q(e),$.each(e,function(s,t){_(t.id)})}).joining(e=>{X(e.id),_(e.id)}).leaving(e=>{Z(e.id),K(e.id)});function W(){$(".messenger-list-item").each(function(e,s){let t=$(this).data("id");c.includes(t)&&_(t)})}function _(e){let s=$(`.messenger-list-item[data-id="${e}"]`).find(".img").find("span");s.removeClass("inactive"),s.addClass("active")}function K(e){let s=$(`.messenger-list-item[data-id="${e}"]`).find(".img").find("span");s.removeClass("active"),s.addClass("inactive")}function Q(e){$.each(e,function(s,t){c.push(t.id)})}function X(e){c.push(e)}function Z(e){let s=c.indexOf(e);s!==-1&&c.splice(s,1)}$(document).ready(function(){E(),window.innerWidth<768&&($("body").on("click",".messenger-list-item",function(){$(".wsus__user_list").addClass("d-none")}),$("body").on("click",".back_to_list",function(){$(".wsus__user_list").removeClass("d-none")})),$("#select_file").change(function(){I(this,".profile-image-preview")});const e=F(function(){const t=$(".user_search").val();j(t)},500);$(".user_search").on("keyup",function(){$(this).val().length>0&&e()}),x(".user_search_list_result",function(){let t=$(".user_search").val();j(t)}),$("body").on("click",".messenger-list-item",function(){const t=$(this).attr("data-id");O(t),H(t),R(t),y()}),$(".message-form").on("submit",function(t){t.preventDefault(),V()}),$(".attachment-input").change(function(){I(this,".attachment-preview"),$(".attachment-block").removeClass("d-none")}),$(".cancel-attachment").on("click",function(){y()}),x(".wsus__chat_area_body",function(){B(o())},!0),x(".messenger-contacts",function(){E()}),$(".favourite").on("click",function(t){t.preventDefault(),Y(o())}),$("body").on("click",".dlt-message",function(t){t.preventDefault();let n=$(this).data("id");z(n)});function s(){var t=$(window).height();$(".wsus__chat_area_body").css("height",t-120+"px"),$(".messenger-contacts").css("max-height",t+"px"),$(".wsus__chat_info_gallery").css("max-height",t-400+"px"),$(".user_search_list_result").css({height:t-130+"px"})}s(),$(window).resize(function(){s()})});
