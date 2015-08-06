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
            $('#fixed-button').text('');
            if(data.quantity > 0) {
                $('#fixed-button').text(data.quantity);
            }
        });
    });
</script>
