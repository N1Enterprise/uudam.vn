<script>
    function tableCallbackFnRenderRole(data) {
        return $.fn.dataTable.render.text().display(data.join(', '));
    }
</script>
