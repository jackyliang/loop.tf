<script type="text/javascript">
    $(function()
    {
        $( "#q" ).autocomplete({
            source: '{{ URL('autocomplete') }}',
            minLength: 3,
            select: function(event, ui) {
                $('#q').val(ui.item.value);
            }
        });
    });
</script>