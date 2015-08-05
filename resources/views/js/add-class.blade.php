<script type="text/javascript">
    $(function()
    {

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
                animate_speed: 'fast',
                buttons: {
                    closer_hover: false,
                    sticker_hover: false
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

        // 1. /add/ will return success if item successfully added to cart
        //        - PNotify would success and say "class X added to cart"
        //        - Button will change to "remove me!"
        // 2. /remove/ will return success if successfully taken out of the cart
        //        - PNotify will succeed and say "class X removed from cart"
        //        - Button will change to "Add Me!"
        // 3. /add/ will return fail if item is already in cart
        //        - PNotify will fail and say "item already in cart"
        //        - Button will change to "remove me!"
        $('.btn-material-yellow-600').click(function(){
            var $localThis = $(this);
            var $className = $(this).data('class-name');
            if($(this).text().trim() == "Add Me!") {
                $.ajax({
                    type: 'post',
                    url: '{{ URL('schedulizer/add') }}',
                    data: {
                        "class": $className,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'json'
                }).done(function(data){
                    // TODO: If /add/ returns failure and message, then it
                    // indicates item is already in cart, so throw PNotify fail,
                    // and change button text to "remove me"
                    notification('Added ' + $className, 'success');

                    // Change the button to the "Remove Me!" style
                    changeButton(
                        $localThis,
                        'btn-material-yellow-600 mdi-content-add-circle-outline',
                        'btn-danger mdi-content-remove-circle-outline',
                        '\nRemove Me!'
                    );
                });
                return false;
            } else if($(this).text().trim() == "Remove Me!"){
                $.ajax({
                    type: 'post',
                    url: '{{ URL('schedulizer/add') }}',
                    data: {
                        "class": $className,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'json'
                }).done(function(data){
                    notification('Removed ' + $className, 'error');

                    // Change the button to the "Add Me!" style
                    changeButton(
                        $localThis,
                        'btn-danger mdi-content-remove-circle-outline',
                        'btn-material-yellow-600 mdi-content-add-circle-outline',
                        '\nAdd Me!'
                    );
                });
                return false;
            }

        });
    });
</script>