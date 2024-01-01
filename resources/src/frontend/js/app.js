const appEnv = (() => {
    const boShared = JSON.parse($('[data-bo-shared]').attr('data-bo-shared') || '{}');

    return boShared?.app_env;
})();

$(document).ready(function() {

    if (['local'].includes(appEnv)) {
        return;
    }

    $(document).on('keyup', function(e) {
        if (e.key == 'PrintScreen') {
            navigator.clipboard.writeText('');
            return blockScreenContentOrImage();
        }

        unblockScreenContentOrImage();
    });

    /** TO DISABLE PRINTS WITH CTRL+P **/
    $(document).on('keydown', function(e) {
        if (e.ctrlKey && e.key == 'p') {
            e.cancelBubble = true;
            e.preventDefault();
            e.stopImmediatePropagation();
            return blockScreenContentOrImage();
        }

        if (e.metaKey && e.shiftKey) {
            return blockScreenContentOrImage();
        }
    });

    function blockScreenContentOrImage() {
        $(document).find('img').addClass('overlay-prevent');
    }

    function unblockScreenContentOrImage() {
        $(document).find('img').removeClass('overlay-prevent');
    }

   // Disable pinch-to-zoom on touch devices
   $(document).on('gesturestart', function(e) {
        e.preventDefault();
    });

    // Additional prevention for certain browsers
    $(document).on('touchmove', function(e) {
        e.preventDefault();
    });

    $(document).on('keydown', function(e) {
        // "I" key
        if (e.ctrlKey && e.shiftKey && e.which == 73) {
            disabledEvent(e);
        }
        // "J" key
        if (e.ctrlKey && e.shiftKey && e.which == 74) {
            disabledEvent(e);
        }
        // "S" key + macOS
        if (e.which == 83 && (navigator.platform.match('Mac') ? e.metaKey : e.ctrlKey)) {
            disabledEvent(e);
        }
        // "U" key
        if (e.ctrlKey && e.which == 85) {
            disabledEvent(e);
        }
        // "F12" key
        if (e.which == 123) {
            disabledEvent(e);
        }
    });

    $(document).on('selectstart', function() {
        return false;
    });

    $(document).on('dblclick', function(e) {
        e.preventDefault();
    });

    $(document).ready(function() {
        $(document).on('contextmenu', function(e) {
            e.preventDefault();
        });
    });


    if (window.console) {
        window.console.log = function() {};
        window.console.error = function() {};
    }

    if (window.sidebar) {
        $(document).on('mousedown', function() {
            return false;
        });

        $(document).on('click', function() {
            return true;
        });
    }

    function disabledEvent(e) {
        if (e.stopPropagation) {
            e.stopPropagation();
        } else if (window.event) {
            window.event.cancelBubble = true;
        }

        e.preventDefault();

        return false;
    }
});