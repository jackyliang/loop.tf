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
    });
</script>
