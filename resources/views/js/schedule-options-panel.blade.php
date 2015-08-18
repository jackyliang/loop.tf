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

        $.ajax({
            url: '{{ URL('schedulizer/schedules') }}',
            type: "GET",
            dataType: 'json'
        }).done(function(data){
            // Get the hash
            window.location.hash = '#1';
            var type = window.location.hash.substr(1);
            console.log(JSON.stringify(data.classes[type]));
            $("#classes").html(JSON.stringify(data.classes[type]));
        });
    });
</script>
