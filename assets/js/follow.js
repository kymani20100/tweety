$(function(){
    $('.follow-btn').click(function(){
        var followID = $(this).data('follow');
        $button      = $(this);

        if($button.hasClass('following-btn')){
            $.post('http://localhost/tweety/core/ajax/follow.php', {unfollow:followID}, function(data){
                data = JSON.parse(data);
                $button.removeClass('following-btn');
                $button.removeClass('unfollow-btn');
                $button.html('<i class="fa fa-rss"></i> Follow');
                $('.count-following').text(data.following);
                $('.count-followers').text(data.followers);
            });
        }else{

             $.post('http://localhost/tweety/core/ajax/follow.php', {follow:followID}, function(data){
                data = JSON.parse(data);
                $button.removeClass('follow-btn');
                $button.addClass('following-btn');
                $button.text('Following');
                $('.count-following').text(data.following);
                $('.count-followers').text(data.followers);
            });
        }
    });
    $('.follow-btn').hover(function(){
        $button = $(this);

        if($button.hasClass('following-btn')){
            $button.addClass('unfollow-btn');
            $button.text('Unfollow');
        }
    }, function(){

        if($button.hasClass('following-btn')){
            $button.removeClass('unfollow-btn');
            $button.text('Following');
        }

    });
        
});