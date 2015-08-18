<script type="text/javascript">
    $(function()
    {
        var result;
        var index = 0;

        $('#from li').on('click', function(){
            $('#from-text').text($(this).text());
        });

        $('#to li').on('click', function(){
            $('#to-text').text($(this).text());
        });

        $(function(){
            $("input[type='checkbox']").change(function(){
                var item=$(this);
                if(item.is(":checked"))
                {
                    console.log($('#days').attr('value'));
                }
            });
        });

        /**
         * This generates the HTML list of classes
         * @param result
         * @returns {*}
         */
        function formatList(result) {
            if(result.quantity === 0) {
                return text = 'You have not added any classes! Click <a href="{{ URL('schedulizer/search') }}">here</a> to add some classes';
            }
            // Build the list of classes with their name and CRN
            var text = '';
            text += '<ul class="list-group">';
            for (i = 0; i < result.classes[index].length; i++) {
                text += '<li class="list-group-item">' + result.classes[index][i]['name'] + ' ' + result.classes[index][i]['crn'] + '</li>';
                console.log(result.classes[index][i]);
            }
            text += '</ul>';
            return text;
        }

        $.ajax({
            url: '{{ URL('schedulizer/schedules') }}',
            type: "GET",
            dataType: 'json'
        }).done(function(data){
            // Get the hash
            window.location.hash = '#' + (index + 1);
            // Save the response data to hash
            result = data;
            text = formatList(result);
            $("#classes").html(text);
            $("#num-results").html(result.message);
        });

        $('.btn.btn-default').click(function(e) {
            // Prevent the page redirect to another page, as you have href on it.
            // Or you can remove the href on the anchors.
            e.preventDefault();
            // Prevent undesired behaviors happen when data is not retrieved yet.
            if (!result || !result.classes) {
                return;
            }
            // Calculate next index for data to show.
            // I use the text < or > here to check, better way may be add class left/right to each anchor.
            var next = $(this).data('direction') === 'left' ? -1 : 1;
            index = index + next;
            // Make the index in boundary.
            if (index >= result.classes.length) {
                index = 0;
            } else if (index < 0) {
                index = result.classes.length - 1;
            }
            // Add hash.
            window.location.hash = '#' + (index + 1);

            text = formatList(result);
            $("#classes").html(text);
        });
    });
</script>
