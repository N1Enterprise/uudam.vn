<style>
    @media screen and (min-width: 990px) {
        .modal-authentication .quick-add-modal__content {
            width: 40%;
        }
    }
</style>

<style>
    header-drawer {
        justify-self: start;
        margin-left: -1.2rem;
    }
    @media  screen and (min-width: 990px) {
        header-drawer {
            display: none;
        }
    }

    ul.mm-submenu {
        border: 0!important;
        text-transform: none;
        padding: 0!important;
        top: -99999px!important;
        margin: 0!important;
        position: absolute!important;
        list-style: none;
        width: auto;
        background: #fff;
        box-shadow: 0 0 20px rgba(0,0,0,.1)!important;
        font-family: "Helvetica Neue",Helvetica,Arial;
        font-weight: 400;
        line-height: normal;
        white-space: initial;
        height: auto;
        visibility: visible!important;
        opacity: 1;
        overflow: visible;
        z-index: 1000000!important;
        display: block!important;
        pointer-events: auto!important;
    }
    .horizontal-mega-menu ul.mm-submenu, .horizontal-mega-menu>li>ul.mm-submenu.tabbed>li>ul.mm-submenu li, .horizontal-mega-menu li.app-menu-item:hover ul.mm-submenu.simple li:hover, .horizontal-mega-menu li.app-menu-item.mega-hover ul.mm-submenu.simple li:hover {
        background: #ffffff !important;
    }
    .horizontal-mega-menu ul.mm-submenu, .horizontal-mega-menu ul.mm-submenu li, .horizontal-mega-menu ul.mm-submenu li.mm-contact-column span, .horizontal-mega-menu ul.mm-submenu li a, .horizontal-mega-menu ul.mm-submenu li a span, .horizontal-mega-menu ul.mm-submenu li.fa, .horizontal-mega-menu ul.mm-submenu.tree li:hover>a[data-href="no-link"], .horizontal-mega-menu ul.mm-submenu.tree li.mega-hover>a[data-href="no-link"], .horizontal-mega-menu ul.mm-submenu.tabbed>li.tab-opened>a[data-href="no-link"], .horizontal-mega-menu ul.mm-submenu li a[data-href="no-link"]:hover {
        color: #222222 !important;
    }
    .horizontal-mega-menu ul.mm-submenu, .horizontal-mega-menu ul.mm-submenu a, .horizontal-mega-menu ul.mm-submenu a>span, .horizontal-mega-menu ul.mm-submenu .money {
        font-size: 13px !important;
    }
    .vertical-mega-menu>.app-menu-item>.mm-submenu.height-transition {
        background-color: #017b86 !important;
    }
    .vertical-mega-menu[menuIdx="0"]>li.app-menu-item ul.mm-submenu.simple>li.mm-left-item {
        padding-left: 32px !important;
    }
    .vertical-mega-menu[menuIdx="0"]>li.app-menu-item ul.mm-submenu.simple>li.mm-right-item {
        padding-right: 32px !important;
    }
    .vertical-mega-menu ul.mm-submenu.simple > li .mm-list-name {
        border-bottom: 1px solid #ffffff !important;
    }
    .vertical-mega-menu ul.mm-submenu, .vertical-mega-menu ul.mm-submenu li.mm-contact-column span, .vertical-mega-menu ul.mm-submenu li a, .vertical-mega-menu ul.mm-submenu span, .vertical-mega-menu ul.mm-submenu>li>a>.toggle-menu-btn>.fa {
        color: #ffffff !important;
    }
    .vertical-mega-menu ul.mm-submenu, .vertical-mega-menu ul.mm-submenu span, .vertical-mega-menu ul.mm-submenu.simple>li ul.mm-product-list>li .mm-list-info {
        font-size: 13px !important;
    }
    .vertical-mega-menu ul.mm-submenu.simple > li .mm-list-name {
        border-bottom: 1px solid #ffffff !important;
    }
    .vertical-mega-menu ul.mm-submenu, .vertical-mega-menu ul.mm-submenu li.mm-contact-column span, .vertical-mega-menu ul.mm-submenu li a, .vertical-mega-menu ul.mm-submenu span, .vertical-mega-menu ul.mm-submenu>li>a>.toggle-menu-btn>.fa {
        color: #ffffff !important;
    }
    .vertical-mega-menu ul.mm-submenu, .vertical-mega-menu ul.mm-submenu span, .vertical-mega-menu ul.mm-submenu.simple>li ul.mm-product-list>li .mm-list-info {
        font-size: 13px !important;
    }
    .vertical-mega-menu[menuIdx="0"]>li.app-menu-item > a > .toggle-menu-btn {
        right: 32px !important;
        top: calc(50% + 0px) !important;
    }

    #admintopnav {
        position: relative;
        background: #b4a9a9;
        background-color: #b4a9a9;
        color: #c3c4c7;
        font-weight: 400;
        font-size: 13px;
        width: 100%;
        overflow: hidden;
        z-index: 4;
        display: flex;
        justify-content: space-between;
        padding: 0 35px;
    }

    #admintopnav a.split.highlight {
        background-color: #a49a9a;
        color: #fff;
    }


    #admintopnav a {
        color: #f2f2f2;
        text-align: center;
        text-decoration: none;
        padding: 4px 16px;
        display: flex;
        align-items: center;
    }

    #admintopnav a:hover {
        background-color: #a49a9a;
        color: #fff;
    }

    @media screen and (max-width: 800px) {
        #admintopnav {
            display: none;
        }
    }
</style>
<!--end::Layout Skins -->

<!--start::Social authentication -->
<style>
    .social-authentication .social-authentication__item {
        width: 60px;
        height: 60px;
        background-color: rgb(var(--color-background));
        border: 0.1rem solid rgba(var(--color-foreground), 0.1);
        border-radius: 50%;
        color: rgba(var(--color-foreground), 0.55);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        margin: 5px;
    }

    .social-authentication .social-authentication__item.facebook {
        background-color: #25479b;
    }

    .social-authentication__title {
        position: relative;
    }

    .social-authentication__title span {
        font-size: 15px;
        color: rgb(120, 120, 120);
        display: inline-block;
        background: rgb(255, 255, 255);
        padding: 0px 20px;
        position: relative;
        z-index: 2;
    }

    .social-authentication__title::before {
        content: "";
        width: 100%;
        height: 1px;
        background: rgb(242, 242, 242);
        position: absolute;
        left: 0px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1;
    }

    .swal-button {
        padding: 8px 16px;
        border-radius: 4px;
        height: 36px;
        cursor: pointer;
        box-sizing: border-box;
    }

    .swal-button.swal2-confirm {
        border: 1px solid #000;
        color: #000;
        background: #fff;
    }

    .swal-button.swal2-cancel {
        background: #000;
        border: 1px solid #000;
        color: #fff;
        margin-right: 10px;
    }
</style>
<!--end::Layout Skins -->

<style>
    html {
        box-sizing: border-box;
        font-size: calc(var(--font-body-scale) * 62.5%);
        height: 100%;
    }

    body {
        display: grid;
        grid-template-rows: auto auto 1fr auto;
        grid-template-columns: 100%;
        min-height: 100%;
        margin: 0;
        font-size: 1.5rem;
        letter-spacing: 0.06rem;
        line-height: calc(1 + 0.8 / var(--font-body-scale));
        font-family: var(--font-body-family);
        font-style: var(--font-body-style);
        font-weight: var(--font-body-weight);
    }

    @media screen and (min-width: 750px) {
        .section-header {
            margin-bottom: 0px;
        }
    }

    .section-header {
        margin-bottom: 0px;
    }

    *,
    *::before,
    *::after {
        box-sizing: inherit;
    }

    @media screen and (min-width: 750px) {
        body {
            font-size: 1.6rem;
        }
    }

    @media screen and (min-width: 990px) {
        .header {
            padding-top: 20px;
            padding-bottom: 20px;
        }
    }

    .header {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .list-menu--inline {
        display: inline-flex;
        flex-wrap: wrap;
    }

    .list-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .list-menu__item {
        display: flex;
        align-items: center;
        line-height: calc(1 + 0.3 / var(--font-body-scale));
    }

    .header__heading-logo {
        max-width: 180px;
    }

    .footer {
        margin-top: 36px;
    }

    .section-footer-padding {
        padding-top: 27px;
        padding-bottom: 27px;
    }

    @media screen and (min-width: 750px) {
        .footer {
            margin-top: 48px;
        }
    }


    .section-template-padding {
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }


    @media screen and (min-width: 750px) {
        .section-template-padding {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    }

    .ls-title {
        color: #121212;
        font-size: 13px;
        font-weight: 400;
        font-family: Poppins, sans-serif;
    }

    .ls-original-price {
        letter-spacing: 1px;
        color: #121212bf !important;
        font-size: 13px !important;
    }

    .ls-price,
    .ls-sale-price,
    .ls-original-price {
        font-size: 16px;
        font-weight: 400;
        font-family: Assistant, sans-serif;
    }

    .ls-price {
        letter-spacing: 1px;
    }

    .ls-price {
        color: #121212;
    }

    .ls-price,
    .ls-sale-price,
    .ls-original-price {
        font-size: 16px;
        font-weight: 400;
        font-family: Assistant, sans-serif;
    }

    .text-left {
        text-align: left !important;
    }

    .ls-ul.limespot-recommendation-box-carousel-shelf.view-list-mode {
        flex-wrap: wrap;
        margin: 0 -15px !important;
    }

    .view-list-mode .limespot-recommendation-box-item {
        flex: 0 0 calc(100%/4);
        max-width: calc(100%/4) !important;
        margin-right: 0 !important;
        padding: 15px;
    }

    .view-list-mode .limespot-recommendation-box-item img {
        border-radius: 0 !important;
        -webkit-border-radius: 0 !important;
        -moz-border-radius: 0 !important;
        -ms-border-radius: 0 !important;
        -o-border-radius: 0 !important;
    }

    .menu-drawer-container {
        display: flex;
    }

    .ls-box-title {
        text-align: left;
        font-family: Poppins, sans-serif;
        font-size: 24px;
        font-weight: 400;
    }

    .ls-box-title {
        margin: 10px 0;
    }

    .slick-prev.slick-arrow {
        display: none!important;
    }

    .redirect-link {
        display: block;
        margin: 0 auto;
        width: fit-content;
        margin-left: 0;
        margin-right: 0;
        margin-top: 1rem;
    }

    .form-errors {
        display: none;
    }

    .form-errors.show {
        display: block!important;
        margin-bottom: 9px;
        font-size: 14px;
        color: #c90a0a;
        margin-top: -5px;
    }

    .d-none {
        display: none!important;
    }

    .owl-dots {
        display: none!important;
    }

    .prevent,
    .disabled {
        pointer-events: none;
        opacity: .7;
    }

    .w-100 {
        width: 100%;
    }

    .skeleton {
        width: 100%;
        height: 20px;
        background-color: #EEE;
        margin-bottom: 1px;
        display: block!important;
    }

    .msg-error {
        color: #d80101;
        font-size: 13px;
    }
    .input.is-invalid {
        border: 1px solid #d80101;
    }

    /* read more in collection description */
    .read_more_span {
        overflow: hidden;
        display: block;
        font-size: 1rem;
        line-height: 1.5rem;
        height: 5rem;
    }

    .read_more_span--clamp {
        height: min-content
    }

    .read_more_span p,
    .read_more_span span {
        margin: 0;
    }

    .read_more_btn {
        margin: 0 auto;
    }

    /* Modal force z-index*/
    .modal__content {
        z-index: 1000;
    }

    /*Infinite Scroll*/
    .Infinite-Scroll-Pagination {
        display: flex;
        justify-content: center;
    }

    .recommendation-items {
        margin: 0 -5px;
    }
    .recommendation-target {
        padding: 0 7px;
    }

    .multicolumn-card__image-wrapper .media--adapt {
        padding-bottom: 59.78043912175649%;
    }

    @media screen and (max-width: 500px) {
        .multicolumn-card__image-wrapper .media--adapt {
            padding-bottom: 70%;
        }

        [data-recommendation-product-identifier] .recommendation-target {
            padding: 0 2px;
        }
    }
</style>