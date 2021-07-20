	<footer class="footer"></footer>
</div> <!-- end .site -->
<?php include('includes/debug-output.php'); ?>



<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


<?php if($logged_in_user){ ?>
<script type="text/javascript">
    
    //Following interaction
    //if the viewer clicks "follow"
    $('.follows').on('click', '.follow-button', function(){
        //get the IDs of follower and followee
        var fromUserId = <?php echo $logged_in_user['user_id'] ?>;
        var toUserId = $(this).data('to');

        console.log(fromUserId, toUserId);

        //grab the parent div of this button
        var container = $(this).parents('.follows');

        //set up the request
        $.ajax({
            method  : 'GET',
            url     : 'ajax-handlers/follow.php',
            data    : {
                        'fromUserId' : fromUserId,
                        'toUserId' : toUserId
                      },
            success : function( response ){
                        container.html( response );
                      },
            error   : function(){
                        console.log('ajax failed');
                      }
        });
    });
</script>
<?php } ?>
<!-- AJAX Additions -->
</body>
</html>