<script type="text/javascript">
    $(function()
    {
        $.ui.autocomplete.prototype._renderItem = function( ul, item){
            var term = this.term.split(' ').join('|');
            var re = new RegExp("(" + term + ")", "gi") ;
            var t = item.label.replace(re,"<b>$1</b>");
            return $( "<li></li>" )
                    .data( "item.autocomplete", item )
                    .append( "<a>" + t + "</a>" )
                    .appendTo( ul );
        };
        $( "#q" ).autocomplete({
            source: '{{ URL('autocomplete') }}',
            minLength: 3,
            select: function(event, ui) {
                $('#q').val(ui.item.value);
            }
        });
    });
</script>