<script type="text/javascript">
    $(function()
    {
        /**
         * Stores the generate schedule array from our API
         **/
        var result;

        /**
         * The starting index for the URL hash
         **/
        var index = 0;

        /**
         * This generates the URL which will query our schedule generation API
         * It contains:
         * 'from'   - from what time you don't want classes
         * 'to'     - to what time you don't want classes
         * 'days'   - days you don't want classes
         * 'full'   - include full classes
         * 'cc'     - show only center city campus classes
         **/
        var from = '';
        var to = '';
        var days = '';
        var full = '';
        var cc = '';
        var url = '';


        $('#from li').on('click', function(){
            $('#from-text').text($(this).text());
        });

        $('#to li').on('click', function(){
            $('#to-text').text($(this).text());
        });

        /**
         * This generates the `days` value from the day of the week checkboxes
         **/
        $(function(){
            $("input[type='checkbox']").change(function(){
                var searchIDs = $("input:checkbox:checked").map(function(){
                    return $(this).data('date');
                }).toArray();
                days = searchIDs.join('');
            });
        });

        /**
         * The API URL to the generated class schedules with custom parameters
         **/
        url = '{{ URL('schedulizer/generate') }}' + '?from=' + from + '&to=' + to + '&days=' + days + '&full=' + full + '&cc=' + cc;
        console.log(url);

        /**
         * This generates the HTML list of classes
         * @param result
         * @returns {*}
         */
        function formatList(result) {
            if(result.quantity === 0) {
                return 'Add some classes on the top right corner first!';
            }
            // Build the list of classes with their name and CRN
            var text = '';
            text += '<ul class="list-group">';
            for (i = 0; i < result.classes[index].length; i++) {
                text += '<li class="list-group-item">' + result.classes[index][i]['name'] + ' ' + result.classes[index][i]['crn'] + '</li>';
            }
            text += '</ul>';
            return text;
        }

        $.ajax({
            url: '{{ URL('schedulizer/generate') }}',
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
