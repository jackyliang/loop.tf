<script type="text/javascript">
    $(function()
    {
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

        var result;
        var index = 0;

        $.ajax({
            url: '{{ URL('schedulizer/schedules') }}',
            type: "GET",
            dataType: 'json'
        }).done(function(data){
            // Get the hash
            window.location.hash = '#' + (index + 1);

            // Save the response data to hash
            result = data;
            $("#classes").html(JSON.stringify(result.classes[index]));
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
            var next = $(this).text() === '<' ? -1 : 1;
            index = index + next;
            // Make the index in boundary.
            if (index >= result.classes.length) {
                index = 0;
            } else if (index < 0) {
                index = result.classes.length - 1;
            }
            // Add hash.
            window.location.hash = '#' + (index + 1);
            $("#classes").html(JSON.stringify(result.classes[index]));
        });
    });
</script>
