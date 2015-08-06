<script type="text/javascript">
    $(function()
    {
        // once page loads, make AJAX request to update the cart quantity
        // TODO: Refactor this and /views/js/add-class.blade.php's getCartQuant
        $.ajax({
            url: '{{ URL('schedulizer/cart') }}',
            type: "GET",
            dataType: 'json'
        }).done(function(data){
            if(data.quantity > 0) {
                $('#jewel')
                        .show("slide", { direction: "up" }, 300)
                        .text(data.quantity);
            } else {
                $('#jewel')
                        .hide("slide", { direction: "down" }, 300)
                        .text(data.quantity);
            }
        });
    });
</script>
