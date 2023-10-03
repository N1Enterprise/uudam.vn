<div class="header__icons">
    <details-modal class="header__search">
        <details>
            <summary class="header__icon header__icon--search header__icon--summary link focus-inset modal__toggle" aria-haspopup="dialog" aria-label="Search" role="button">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-account" fill="none" viewBox="0 0 24 24" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
            </summary>
        </details>
    </details-modal>

    @if(empty($AUTHENTICATED_USER))
    <a href="?overlay=signin" class="header__icon header__icon--account link focus-inset small-hide" data-overlay-action-button="signin">
        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-account" fill="none" viewBox="0 0 18 19">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M6 4.5a3 3 0 116 0 3 3 0 01-6 0zm3-4a4 4 0 100 8 4 4 0 000-8zm5.58 12.15c1.12.82 1.83 2.24 1.91 4.85H1.51c.08-2.6.79-4.03 1.9-4.85C4.66 11.75 6.5 11.5 9 11.5s4.35.26 5.58 1.15zM9 10.5c-2.5 0-4.65.24-6.17 1.35C1.27 12.98.5 14.93.5 18v.5h17V18c0-3.07-.77-5.02-2.33-6.15-1.52-1.1-3.67-1.35-6.17-1.35z" fill="currentColor">
            </path>
        </svg>
        <span class="visually-hidden">Log in</span>
    </a>
    @else
    <a href="/profile" class="header__icon header__icon--account link focus-inset small-hide">
        <span>{{ $AUTHENTICATED_USER->email }}</span>
    </a>
    @endif

    <a href="/cart" class="header__icon header__icon--cart link focus-inset" id="cart-icon-bubble">
        <svg class="icon icon-cart" aria-hidden="true" focusable="false" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" fill="none">
            <path fill="currentColor" fill-rule="evenodd" d="M20.5 6.5a4.75 4.75 0 00-4.75 4.75v.56h-3.16l-.77 11.6a5 5 0 004.99 5.34h7.38a5 5 0 004.99-5.33l-.77-11.6h-3.16v-.57A4.75 4.75 0 0020.5 6.5zm3.75 5.31v-.56a3.75 3.75 0 10-7.5 0v.56h7.5zm-7.5 1h7.5v.56a3.75 3.75 0 11-7.5 0v-.56zm-1 0v.56a4.75 4.75 0 109.5 0v-.56h2.22l.71 10.67a4 4 0 01-3.99 4.27h-7.38a4 4 0 01-4-4.27l.72-10.67h2.22z"></path>
        </svg>
        <span class="visually-hidden">Cart</span>
        <div class="cart-count-bubble"><span aria-hidden="true">1</span><span class="visually-hidden">1 item</span>
        </div>
    </a>
</div>
