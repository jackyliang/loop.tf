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
            $('#jewel').text('');
            $('#jewel').hide();
            if(data.quantity > 0) {
                $('#jewel').show();
                $('#jewel').text(data.quantity);
            }
        });
    });
</script>
