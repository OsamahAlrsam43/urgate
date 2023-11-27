<script>
    $('body').on('click', '.link-confirm', function (e) {
        e.preventDefault();
        var href = $(this).attr('href')
        $.confirm({
            title: 'Confirm',
            text: 'Are you sure you want to continue?',
            buttons: {
                confirm: {
                    action: function () {
                        location.href = href;
                    }
                },
                cancel: function () {}
            }
        });
    });
</script>
