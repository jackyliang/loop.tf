<script type="text/javascript">
    $(function()
    {
        $('#from li a').on('click', function(){
            $('#from-text').text($(this).text());
        });

        $('#to li a').on('click', function(){
            $('#to-text').text($(this).text());
        });

        $(function(){
            $("input[type='checkbox']").change(function(){
                var item=$(this);
                if(item.is(":checked"))
                {
                    console.log($('#checkbox').val());
                }
            });
        });
    });
</script>
