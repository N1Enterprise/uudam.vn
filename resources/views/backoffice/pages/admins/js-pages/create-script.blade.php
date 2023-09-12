<script>
    $(document).ready(function () {
        $("#random-password").click(function () {
            let password = $("#password");
            password.prop("type", "text");
            password.val(Math.random().toString(36).slice(6));
        });
    });
</script>
