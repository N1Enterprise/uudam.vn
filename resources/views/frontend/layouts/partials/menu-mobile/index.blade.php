<div class="master-mobile-menu">
    <div id="menu-bottom-tabs" class="tabs is-centered bannerTopHead menu-mobile-reponsive">
        <ul>
            <li class="menu-bottom-item">
                <a href="{{ route('fe.web.cart.index') }}" style="text-decoration: none;">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28.95 35.07" width="25" height="25"><defs><style>
                            .cls-1 {
                              fill: none;
                              stroke: #fff;
                              stroke-linecap: round;
                              stroke-linejoin: round;
                              stroke-width: 1.8px;
                            }
                          </style></defs> <g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path d="M10,10.54V5.35A4.44,4.44,0,0,1,14.47.9h0a4.45,4.45,0,0,1,4.45,4.45v5.19" class="cls-1"></path> <path d="M23.47,34.17h-18A4.58,4.58,0,0,1,.91,29.24L2.5,8.78A1.44,1.44,0,0,1,3.94,7.46H25a1.43,1.43,0,0,1,1.43,1.32L28,29.24A4.57,4.57,0,0,1,23.47,34.17Z" class="cls-1"></path></g></g></svg>
                    </span>
                    <span>Giỏ hàng</span>
                </a>
            </li>
            <li class="menu-bottom-item">
                <a href="{{ route('fe.web.home') }}" style="text-decoration: none;">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.71 17.72">
                            <defs>
                                <style>
                                    .cls-1 {
                                        fill: none;
                                        stroke: #231f20;
                                        stroke-linecap: round;
                                        stroke-linejoin: round;
                                        stroke-width: 1.07px;
                                    }
                                </style>
                            </defs>
                            <g id="Layer_2" data-name="Layer 2">
                                <g id="Layer_1-2" data-name="Layer 1">
                                    <path d="M.54,9.09V8.63a2.26,2.26,0,0,1,.75-1.16Q4.38,4.39,7.46,1.3A2.35,2.35,0,0,1,8.63.54h.46a2.28,2.28,0,0,1,1.17.76l6.35,6.35.2.21a1.54,1.54,0,0,1-.88,2.5,4.56,4.56,0,0,1-.54,0v4.91a1.79,1.79,0,0,1-1.86,1.87H11.05c-.41,0-.59-.19-.59-.6,0-1.25,0-2.49,0-3.74A.82.82,0,0,0,9.56,12c-.46,0-.92,0-1.38,0a.86.86,0,0,0-.93.92c0,1.24,0,2.48,0,3.72a.52.52,0,0,1-.59.59H4.22a1.8,1.8,0,0,1-1.9-1.9V10.41l0,0H2A1.49,1.49,0,0,1,.71,9.55,2.54,2.54,0,0,1,.54,9.09Z" class="cls-1"></path>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span>Trang chủ</span>
                </a>
            </li>
            @if(! empty($AUTHENTICATED_USER))
            <li class="menu-bottom-item about-smember">
                <a href="{{ route('fe.web.user.profile') }}" style="text-decoration: none;">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" focusable="false" role="presentation" class="icon icon-account" fill="none" viewBox="0 0 18 19" width="20">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6 4.5a3 3 0 116 0 3 3 0 01-6 0zm3-4a4 4 0 100 8 4 4 0 000-8zm5.58 12.15c1.12.82 1.83 2.24 1.91 4.85H1.51c.08-2.6.79-4.03 1.9-4.85C4.66 11.75 6.5 11.5 9 11.5s4.35.26 5.58 1.15zM9 10.5c-2.5 0-4.65.24-6.17 1.35C1.27 12.98.5 14.93.5 18v.5h17V18c0-3.07-.77-5.02-2.33-6.15-1.52-1.1-3.67-1.35-6.17-1.35z" fill="currentColor">
                            </path>
                        </svg>
                    </span>
                    <span>Tài khoản</span>
                </a>
            </li>
            @else
            <li class="menu-bottom-item about-smember">
                <button type="button" data-overlay-action-button="signin" class="a-link">
                    <span class="icon">
                        <svg id="icon-smember" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 560 560" width="20">
                            <defs>
                                <style>
                                    svg#icon-smember .cls-2 {
                                        fill: none;
                                        stroke-width: 30px;
                                    }
                                </style>
                            </defs>
                            <g id="Layer_2" data-name="Layer 2">
                                <g id="Layer_1-2" data-name="Layer 1">
                                    <circle cx="280" cy="280" r="265" class="cls-2"></circle>
                                    <circle cx="280" cy="210" r="115" class="cls-2"></circle>
                                    <path d="M86.82,461.4C124.71,354.71,241.91,298.93,348.6,336.82A205,205,0,0,1,473.18,461.4" class="cls-2"></path>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span>Đăng nhập</span>
                </button>
            </li>
            @endif

            <li class="menu-bottom-item about-smember">
                <a href="https://banggia.uudam.vn?redirect_from=website" target="_blank" style="text-decoration: none;">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.01 17.01">
                            <defs>
                                <style>
                                    .cls-1,
                                    .cls-2 {
                                        fill: none;
                                        stroke: #231f20;
                                        stroke-miterlimit: 10;
                                    }

                                    .cls-1 {
                                        stroke-width: 1.07px;
                                    }

                                    .cls-2 {
                                        stroke-linecap: round;
                                        stroke-width: 1.5px;
                                    }
                                </style>
                            </defs>
                            <g id="Layer_2" data-name="Layer 2">
                                <g id="Layer_1-2" data-name="Layer 1">
                                    <rect x="0.54" y="0.54" width="15.93" height="15.93" rx="2.54" class="cls-1"></rect>
                                    <line x1="5" y1="4.98" x2="12.01" y2="4.98" class="cls-2"></line>
                                    <line x1="5" y1="8.5" x2="12.01" y2="8.5" class="cls-2"></line>
                                    <line x1="5" y1="12.02" x2="7.04" y2="12.02" class="cls-2"></line>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span>Bảng giá</span>
                </a>
            </li>
        </ul>
    </div>
</div>
