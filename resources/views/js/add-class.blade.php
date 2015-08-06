<script type="text/javascript">
    $(function()
    {
        // NOTE: If you change these constants, you have to change the button
        // string defined in results.blade.php too.
        var ADD = "I want this!";
        var REMOVE = "Get rid of it!";

        /**
         * PNotification to indicate the status of a class
         * @param text The text to display on the notification
         * @param type The type of notification (success.. error.. etc)
         *
         * PNotification to indicate the status of a class
         */
        function notification(text, type) {
            new PNotify({
                text: text,
                type: type,
                animation: 'slide',
                delay: 1500,
                min_height: "16px",
                animate_speed: 100,
                text_escape: true,
                nonblock: {
                    nonblock: true,
                    nonblock_opacity: .1
                },
                buttons: {
                    show_on_nonblock: true
                }
            });
        }

        /**
         * Change the look of the button in the callback
         * @param button The button object i.e. $(this)
         * @param remove The class to remove
         * @param add    The class to add
         * @param text   The text to replace on the button
         */
        function changeButton(button, remove, add, text) {
            button.removeClass(remove);
            button.addClass(add);
            button.text(text);
        }

        /**
         * Get and change the cart quantity
         * TODO: Refactor this and views/js/cart-quantity.blade.php
         */
        function getCartQuantity() {
            $('#jewel').text('');
            $.getJSON("{{ url('schedulizer/cart') }}", function(data) {
                $('#jewel')
                        .hide("slide", { direction: "down" }, 100)
                        .text(data.quantity);
                if(data.quantity > 0) {
                    $('#jewel')
                            .show("slide", { direction: "right" }, 1000)
                            .text(data.quantity);
                }
            });
        }

        /*
         * TODO: documentation
         */
        $('.btn-material-yellow-600').click(function(){
            var $localThis = $(this);
            var $className = $(this).data('class-name');

            if($(this).text().trim() == ADD) {
                $.ajax({
                    type: 'post',
                    url: '{{ URL('schedulizer/add') }}',
                    data: {
                        "class": $className,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'json'
                }).done(function(data){
                    getCartQuantity();
                    // If the code is 1, it indicates that the class was
                    // successfully added to cart, so change the button to red,
                    // change the text, and flash a success notification
                    if(data.code === 1) {
                        notification(data.message, 'success');

                        // Change the button to the "Remove Me!" style
                        changeButton(
                            $localThis,
                            'btn-material-yellow-600 mdi-content-add-circle-outline',
                            'btn-danger mdi-content-remove-circle-outline',
                            '\n' + REMOVE
                        );
                    } else if (data.code === 0) {
                        // If the code is 0, it indicates that the item already
                        // exists in the cart, so change the button to red,
                        // change the text, and flash an error message
                        notification(data.message, 'error');

                        // Change the button to the "Remove Me!" style
                        changeButton(
                            $localThis,
                            'btn-material-yellow-600 mdi-content-add-circle-outline',
                            'btn-danger mdi-content-remove-circle-outline',
                            '\n' + REMOVE
                        );
                    } else {
                        notification(data.message, 'error');
                    }
                });
                return false;
            } else if($(this).text().trim() == REMOVE){
                $.ajax({
                    type: 'post',
                    url: '{{ URL('schedulizer/remove') }}',
                    data: {
                        "class": $className,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'json'
                }).done(function(data){
                    getCartQuantity();
                    // If the code is 1, it indicates that the class was
                    // successfully removed from the cart, so change the button
                    // back to yellow, change the text, and flash a success notif
                    if(data.code === 1) {
                        notification(data.message, 'success');

                        // Change the button to the "Add Me!" style
                        changeButton(
                            $localThis,
                            'btn-danger mdi-content-remove-circle-outline',
                            'btn-material-yellow-600 mdi-content-add-circle-outline',
                            '\n' + ADD
                        );
                    } else if(data.code === 0) {
                        // If the code is 0, it indicates that the class was not
                        // found in the cart, so change the button to yellow,
                        // change the text, and flash an error message
                        notification(data.message, 'error');

                        // Change the button to the "Add Me!" style
                        changeButton(
                            $localThis,
                            'btn-danger mdi-content-remove-circle-outline',
                            'btn-material-yellow-600 mdi-content-add-circle-outline',
                            '\n' + ADD
                        );
                    } else {
                        // Something else went wrong, and it shouldn't happen,
                        // so just flash a notif
                        notification(data.message, 'error');
                    }
                });
                return false;
            }

        });
    });
</script>