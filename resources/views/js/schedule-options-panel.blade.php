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
         * 'from'   - from what time you don't want classes. Default - 10 AM
         * 'to'     - to what time you don't want classes. Default - 12 PM
         * 'limit'   - days you don't want classes. Default - none
         * 'full'   - include full classes. Default - true
         * 'cc'     - show only center city campus classes. Default - true
         **/
        var from = 1000;
        var to = 1200;
        var limit = '';
        var full = 1;
        var cc = 1;

        // Updates the URL to query the generated schedule API
        var url = getUpdatedURL();

        /**
         * Updates the dropdown text for 'from'
         **/
        $('#from li').on('click', function(){
            $('#from-text').text($(this).text());
        });

        /**
         * Updates the dropdown text for 'to'
         **/
        $('#to li').on('click', function(){
            $('#to-text').text($(this).text());
        });

        /**
        * This generates the `days` value from the day of the week checkboxes,
        * the 'from' time span, the 'to' time span, the 'full' classes flag, and
        * show only center city campus
        **/
        // Generates the 'days' string i.e. MWF
        $("#limit").change(function(){
            var searchIDs = $("input:checkbox:checked").map(function(){
                return $(this).data('date');
            }).toArray();
            limit = searchIDs.join('');
            // TODO: Figure out a way to this without calling getUpdatedURL()
            // and updateResults() five times
            getUpdatedURL();
            updateResults();
        });

        // Get the military time for 'from'
        $('#from li a').on('click', function(){
            from = $(this).data('military');
            getUpdatedURL();
            updateResults();
        });

        // Get the military time for 'to'
        $('#to li a').on('click', function(){
            to = $(this).data('military');
            getUpdatedURL();
            updateResults();
        });

        // Show full classes or not
        $('#full').change(function(){
            full = $("#full-checkbox").is(':checked') ? 1 : 0 ;
            getUpdatedURL();
            updateResults();
        });

        // Show only Center City classes or not
        $('#cc').change(function(){
            cc = $("#cc-checkbox").is(':checked') ? 1 : 0 ;
            getUpdatedURL();
            updateResults();
        });

        /**
         * Updates the global URL that's used to query the class generation API
         */
        function getUpdatedURL() {
            url = '{{ URL('schedulizer/generate') }}' + '?from=' + from + '&to=' + to + '&limit=' + limit + '&full=' + full + '&cc=' + cc;
            return url;
        }

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
            // Build the unordered list of classes with their name and CRN
            var text = '';
            text += '<ul class="list-group">';
            for (i = 0; i < result.classes[index].length; i++) {
                text += '<li class="list-group-item">' + result.classes[index][i]['name'] + ' (' + result.classes[index][i]['crn'] + ')</li>';
            }
            text += '</ul>';
            return text;
        }

        /**
         * Show number of results in header as well as append the list of
         * classes to the cart panel. Uses the dynamically updated URL
         */
        function updateResults(){
            $.ajax({
                url: url,
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
        }

        // Update the results on page-load
        updateResults();

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
