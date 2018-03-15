$(function(){
    $(document).on('click', '.deleteTweet', function(){
        var tweet_id = $(this).data('tweet');
       //console.log(tweet_id);
        $.post('http://localhost/tweety/core/ajax/deleteTweet.php', {showPopup:tweet_id}, function(data){
            $('.popupTweet').html(data);
            $('.close-retweet-popup,.cancel-it').click(function(){
                $('.retweet-popup').fadeOut(1000);
            });

            $(document).on('click', '.delete-it', function(){
                $.post('http://localhost/tweety/core/ajax/deleteTweet.php', {deleteTweet:tweet_id}, function(data){
                     $('.retweet-popup').fadeOut(1000);
                     location.reload();
                });
            });
        });
    });

    $(document).on('click', '.deleteComment', function(){
        var commentID = $(this).data('comment');
        var tweet_id = $(this).data('tweet');

        $.post('http://localhost/tweety/core/ajax/deleteComment.php', {deleteComment:commentID}, function(data){
             $.post('http://localhost/tweety/core/ajax/popuptweets.php', {showpopup:tweet_id}, function(data){
                $('.popupTweet').html(data);
                $('.tweet-show-popup-box-cut').click(function(){
                    $('.tweet-show-popup-wrap').hide(500);
                });
            });
        });
    });
});