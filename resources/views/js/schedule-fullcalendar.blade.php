
<script type="text/javascript">
    (function(){
        "use strict";
        $(document).ready(function(){
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();


            $('#calendar').fullCalendar({
                editable: false,
                weekMode: 'liquid',
                handleWindowResize: true,
                weekends: false,
                defaultView: 'agendaWeek',

                events: [{
                    start: '2015-08-26',
                    title: 'Mitrache Florin',
                    color: 'green',
                    url: 'calendar.php?nume=Mitrache Florin',
                    desc: 'test',
                    description: ''
                }, {
                    start: '2013-06-27',
                    title: 'Mitrache Florin',
                    color: 'green',
                    url: 'calendar.php?nume=Mitrache Florin',
                    desc: 'test',
                    description: ''
                }]
            });

        });
    })();
</script>
