<script type="text/javascript">
    $(function()
    {
        /**
         * Stores the generated schedule array from our API
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

        /**
         * This generates the `days` value from the day of the week checkboxes,
         * the 'from' time span, the 'to' time span, the 'full' classes flag, and
         * show only center city campus
         **/
        $(function(){
            // Generates the 'days' string
            $("#days").change(function(){
                var searchIDs = $("input:checkbox:checked").map(function(){
                    return $(this).data('date');
                }).toArray();
                days = searchIDs.join('');
            });

            // Generates the military time for 'from'
            $('#from li a').on('click', function(){
                from = $(this).data('military');
            });

            // Generate the military time for 'to'
            $('#to li a').on('click', function(){
                to = $(this).data('military');
            });

            // Generate the bool
            // TODO: Fix this full checkbox
            $('#full').change(function(){
                $(this).is(':checked')
                if($(this).is(':checked')){
                    console.log("Checkbox is checked.");
                }
                else if($(this).prop("checked") == false){
                    console.log("Checkbox is unchecked.");
                }
            });

        });

        /**
         * The API URL to the generated class schedules with custom parameters
         **/
        url = '{{ URL('schedulizer/generate') }}' + '?from=' + from + '&to=' + to + '&days=' + days + '&full=' + full + '&cc=' + cc;
        console.log(url);

        /**
         * This generates the HTML list of classes
         * @param result  The array from the class generation JSON API
         * @returns {*}   The HTML for the list of classes used to generate
         *                the schedules
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

        /**
         * Show number of results in header as well as append the list of
         * classes to the cart panel
         */
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

        /**
         * Button behaviors for cycling through the generated schedules
         */
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
