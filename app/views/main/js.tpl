<script>
    $(document).ready(function () {
        {foreach $banners as $user}
            $('#user{$user.id}').flexslider({
                animation: "slide"
            });
        {/foreach}

    });
</script>