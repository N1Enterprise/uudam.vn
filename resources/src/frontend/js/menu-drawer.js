$(document).ready(function() {
    $.each($('nav.header__inline-menu .horizontal-mega-menu .app-menu-item'), function(index, element) {
        const $menu = $(element);
        const $submenu = $menu.find('.mm-submenu');
        const $mainHeaderHeading = $('#shopify-section-header .header__heading');
        const $appHeader = $('header.header');

        const offsetLeft = $submenu.offset().left - $mainHeaderHeading.offset().left;
        const withOfAppHeader = $appHeader.width();

        $submenu.css('left', `-${offsetLeft}px`);
        $submenu.css('width', `${withOfAppHeader}px`);
    });

    $.each($('sticky-header .menu-drawer__menu a.menu-drawer__menu-item.list-menu__item.link--text .toggle-menu-btn'), function(index, element) {
        const expanedMenuButton = $(element);

        const menuLink = $(element).parent('a');

        menuLink.on('click', function(e) {
            e.preventDefault();

            const tagTarget = e.target;

            if ($(tagTarget).hasClass('toggle-menu-btn') || $(tagTarget).parents('.toggle-menu-btn').hasClass('toggle-menu-btn')) {
                const menuItem = $(tagTarget).parents('li.app-menu-item');

                menuItem.toggleClass('mm-hovering');
                menuItem.find('.mm-arrow-icon').toggleClass('mm-cross');
                menuItem.find('ul.mm-submenu').toggleClass('submenu-opened');
                menuItem.find('ul.mm-submenu').css({ 'max-height': menuItem.find('ul.mm-submenu').hasClass('submenu-opened') ? '1485px' : '0' });
                menuItem.find('ul.mm-submenu .mega-menu-item-container').parent().toggleClass('mmBounceInUp');
                menuItem.find('[data-menu-type="post"]').find('.mm-image-container').css({
                    height: '180px'
                });
                menuItem.find('[data-menu-type="post"]').find('.mm-image').css({
                    height: '180.062px',
                    width: '344px'
                });
            } else {
                const href = $(this).attr('href');

                if (href) {
                    window.location.href = href;
                }
            }
        });
    });
});

$('#Details-menu-drawer-container .header__icon').on('click', function() {
    $(this).attr('aria-expanded', $('#Details-menu-drawer-container').attr('open') !== undefined ? 'false' : 'true');
});
