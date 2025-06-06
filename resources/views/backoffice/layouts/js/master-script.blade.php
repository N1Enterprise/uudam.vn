<script>
function onSuccessUpdateUserProfile() {
    fstoast.success("{{ __('Your profile has been updated.') }}")

    window.location.reload();
}

function onSuccessUpdateUserPassword() {
    fstoast.success("{{ __('Your password has been changed.') }}")

    $('#userProfileModal').modal('hide');
}

var KAppOptions = {
    "colors": {
        "state": {
            "brand": "#5d78ff",
            "metal": "#c4c5d6",
            "light": "#ffffff",
            "accent": "#00c5dc",
            "primary": "#5867dd",
            "success": "#34bfa3",
            "info": "#36a3f7",
            "warning": "#ffb822",
            "danger": "#fd3995",
            "focus": "#9816f4"
        },
        "base": {
            "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
            "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
        }
    }
};
</script>
