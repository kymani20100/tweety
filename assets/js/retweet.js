$(function(){
    $(document).on('click', '.retweet', function(){
        var tweet_id = $(this).data('tweet');
        var user_id  = $(this).data('user');
        var counter  = $(this).find('.retweetsCount');
    });
});