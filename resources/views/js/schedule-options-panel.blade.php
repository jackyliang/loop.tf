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
         * 'campus'     - show only university city campus classes. Default - true
         **/
        var from = 1000;
        var to = 1200;
        var limit = '';
        var full = 1;
        var campus = 0;

        // Updates the URL to query the generated schedule API
        var url = getUpdatedURL();

        var date = new Date();

        /**
         * End FullCalendar Code
         **/

        $('#refresh').on('click', function(){
            updateResults();
        });

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
        });

        // Get the military time for 'from'
        $('#from li a').on('click', function(){
            from = $(this).data('military');
            getUpdatedURL();
        });

        // Get the military time for 'to'
        $('#to li a').on('click', function(){
            to = $(this).data('military');
            getUpdatedURL();
        });

        // Show full classes or not
        $('#full').change(function(){
            full = $("#full-checkbox").is(':checked') ? 1 : 0 ;
            getUpdatedURL();
        });

        // Show only University City classes or not
        $('#cc').change(function(){
            campus = $("#cc-checkbox").is(':checked') ? 1 : 0 ;
            getUpdatedURL();
        });

        /**
         * TODO: Fix this focus
         **/
        $('#focus').change(function() {
            console.log('yeah');
            $("#q").focus();
        });

        /**
         * Updates the global URL that's used to query the class generation API
         */
        function getUpdatedURL() {
            url = '{{ URL('schedulizer/generate') }}' + '?from=' + from + '&to=' + to + '&limit=' + limit + '&full=' + full + '&campus=' + campus;
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
                // TODO: Fix this focus
                return 'Oops! Looks like no schedules were generated. <a id="focus">Add</a> some classes or widen your filter options!';
            }
            // Build the unordered list of classes with their name and CRN
            var text = '';
            text += '<ul class="list-group class-cart">';
            for (i = 0; i < result.classes[index].length; i++) {
                text += '<li class="list-group-item">' + result.classes[index][i]['short_name'] + ' (' + result.classes[index][i]['crn'] + ')</li>';
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
                updateIndexOfSchedule();
                // Render the calendar on page-load
                renderCalendar(index);
                if(data.quantity === 0) {
                    notification(result.message, 'error');
                } else {
                    notification(result.message, 'success');
                }
            });
        }

        function renderCalendar(index) {

            var myDataset = result;

            $('#calendar').fullCalendar({
                editable: false,
                handleWindowResize: true,
                weekends: false, // Hide weekends
                defaultView: 'agendaWeek', // Only show week view
                header: false, // Hide buttons/titles
                minTime: '07:00:00', // Start time for the calendar
                columnFormat: {
                    week: 'dddd' // Only show day of the week names
                }
            });

            function GetDateString(myDate){
                // GET CURRENT DATE
                var date = new Date(myDate);

                // GET YYYY, MM AND DD FROM THE DATE OBJECT
                var yyyy = date.getFullYear().toString();
                var mm = (date.getMonth()+1).toString();
                var dd  = date.getDate().toString();

                // CONVERT mm AND dd INTO chars
                var mmChars = mm.split('');
                var ddChars = dd.split('');

                // CONCAT THE STRINGS IN YYYY-MM-DD FORMAT
                var datestring = yyyy + '-' + (mmChars[1]?mm:"0"+mmChars[0]) + '-' + (ddChars[1]?dd:"0"+ddChars[0]);

                return datestring;
            }

            // Clear all events to prepare for the next set of events.
            $('#calendar').fullCalendar('removeEvents');

            $('#calendar').fullCalendar('addEventSource',
                function(start, end, timezone, callback) {
                    var events = [];

                    for (loop = start.toDate().getTime(); loop <= end.toDate().getTime(); loop = loop + (24 * 60 * 60 * 1000)) {
                        var test_date = new Date(loop);
                        var obj = myDataset.classes[index];

                        for (j = 0; j < obj.length; j++) {

                            var days = obj[j].days;
                            if(days === 'TBD') {
                                continue;
                            }
                            var times = obj[j].times.split('-');
                            var daysArray = days.split('');

                            for (k = 0; k < daysArray.length; k++) {

                                var startDate = GetDateString(loop) + ' ' + times[0].trim();
                                var endDate = GetDateString(loop) + ' ' + times[1].trim();

                                if (daysArray[k] == 'M' && test_date.is().monday()) {
                                    events.push({
                                        title: obj[j].name,
                                        start: startDate,
                                        end: endDate
                                    });
                                } else if (daysArray[k] == 'T' && test_date.is().tuesday()) {
                                    events.push({
                                        title: obj[j].name,
                                        start: startDate,
                                        end: endDate
                                    });
                                } else if (daysArray[k] == 'W' && test_date.is().wednesday()) {
                                    events.push({
                                        title: obj[j].name,
                                        start: startDate,
                                        end: endDate
                                    });
                                } else if (daysArray[k] == 'R' && test_date.is().thursday()) {
                                    events.push({
                                        title: obj[j].name,
                                        start: startDate,
                                        end: endDate
                                    });
                                } else if (daysArray[k] == 'F' && test_date.is().friday()) {
                                    events.push({
                                        title: obj[j].name,
                                        start: startDate,
                                        end: endDate
                                    });
                                }
                            }
//

                        }
                    }
                    // return events generated
                    callback(events);
                }
            );
        }

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
                delay: 3000,
                min_height: "16px",
                animate_speed: 400,
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

        // Update the results on page-load
        updateResults();

        /**
         * Updates the title text of the schedule
         **/
        function updateIndexOfSchedule(){
            if(result.quantity === 0) {
                $("#schedule-panel-title").html('Schedule');
            } else {
                $("#schedule-panel-title").html('Schedule ' + (index + 1) + ' of ' + result.quantity);
            }
        }

        /**
         * Button behaviors for cycling through the generated schedules
         */
        $('.btn.btn-default.toggle-schedules').click(function(e) {
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

            updateIndexOfSchedule();

            text = formatList(result);
            $("#classes").html(text);

            renderCalendar(index);
        });
    });
</script>
