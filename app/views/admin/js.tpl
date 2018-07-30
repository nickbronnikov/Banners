<script>
    $(document).ready(function () {
        {if isset($banner)}
            banner_id = {$banner.id};
            let counter = 0;
            croppie = $('#cropImage').croppie({
                enableExif: true,
                viewport: {
                    width: 480,
                    height: 270,
                    type: 'square'
                },
                boundary: {
                    width: 500,
                    height: 500
                },
                url: '{$banner.image}',
                update: function() {
                    if(counter === 0) {
                        counter++;
                        $('#cropImage').croppie('setZoom', '0');
                    }
                }
            });

        {else}
        croppie = $('#cropImage').croppie({
            enableExif: true,
            viewport: {
                width: 480,
                height: 270,
                type: 'square'
            },
            boundary: {
                width: 500,
                height: 500
            },
            url: '/img/white.png'
        });
        {/if}
    });
</script>