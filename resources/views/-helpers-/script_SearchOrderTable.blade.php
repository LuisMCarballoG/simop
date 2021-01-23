<script>
    // Write on keyup event of keyword input element
    $(document).ready(function(){
        $("#tabla").tablesorter();
        $("#buscador").keyup(function(){
            _this = this;
            // Show only matching TR, hide rest of them
            $.each($("#tabla tbody tr"), function() {
                if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                    $(this).hide();
                else
                    $(this).show();
            });
        });
    });
</script>