@extends('frontend.layouts.master')

@push('style_pages')
<link rel="stylesheet" href="{{ asset('backoffice/assets/vendors/general/slick/slick.css') }}">
<link rel="stylesheet" href="{{ asset('backoffice/assets/vendors/general/slick/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/blog-news/index.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-rte.css') }}">
@endpush

@section('content_body')
<section class="shopify-section section">
    <article class="article-template" itemscope="" itemtype="http://schema.org/BlogPosting">
        <div class="article-template__hero-container">
            <div class="article-template__hero-large media" itemprop="image">
                <img srcset="https://dharmacrafts.com/cdn/shop/articles/custom_resized_7e58797c-3196-4b22-abdc-d6036927629e.jpg?v=1685632619&width=3000" src="https://dharmacrafts.com/cdn/shop/articles/custom_resized_7e58797c-3196-4b22-abdc-d6036927629e.jpg?v=1685632619&width=3000" loading="lazy" width="4472" height="3578" alt="What an Eye Pillow is &amp; How to Use One">
            </div>
        </div>
        <header class="page-width page-width--narrow">
            <h1 class="article-template__title" itemprop="headline">What an Eye Pillow is &amp; How to Use One</h1>
            <span class="circle-divider caption-with-letter-spacing" itemprop="dateCreated pubdate datePublished">
                <time datetime="2023-06-01T15:32:52Z">June 1, 2023</time>
            </span>
        </header>
        <div class="article-template__social-sharing page-width page-width--narrow">
            <share-button class="share-button">
                <button class="share-button__button hidden">
                    <svg width="13" height="12" viewBox="0 0 13 12" class="icon icon-share" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                        <path d="M1.625 8.125V10.2917C1.625 10.579 1.73914 10.8545 1.9423 11.0577C2.14547 11.2609 2.42102 11.375 2.70833 11.375H10.2917C10.579 11.375 10.8545 11.2609 11.0577 11.0577C11.2609 10.8545 11.375 10.579 11.375 10.2917V8.125" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.14775 1.27137C6.34301 1.0761 6.65959 1.0761 6.85485 1.27137L9.56319 3.9797C9.75845 4.17496 9.75845 4.49154 9.56319 4.6868C9.36793 4.88207 9.05135 4.88207 8.85609 4.6868L6.5013 2.33203L4.14652 4.6868C3.95126 4.88207 3.63468 4.88207 3.43942 4.6868C3.24415 4.49154 3.24415 4.17496 3.43942 3.9797L6.14775 1.27137Z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.5 1.125C6.77614 1.125 7 1.34886 7 1.625V8.125C7 8.40114 6.77614 8.625 6.5 8.625C6.22386 8.625 6 8.40114 6 8.125V1.625C6 1.34886 6.22386 1.125 6.5 1.125Z" fill="currentColor"></path>
                    </svg> Share </button>
                <details id="Details-share-template--16599720231162__main">
                    <summary class="share-button__button" role="button" aria-expanded="false" aria-controls="Article-share-template--16599720231162__main">
                        <svg width="13" height="12" viewBox="0 0 13 12" class="icon icon-share" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                            <path d="M1.625 8.125V10.2917C1.625 10.579 1.73914 10.8545 1.9423 11.0577C2.14547 11.2609 2.42102 11.375 2.70833 11.375H10.2917C10.579 11.375 10.8545 11.2609 11.0577 11.0577C11.2609 10.8545 11.375 10.579 11.375 10.2917V8.125" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.14775 1.27137C6.34301 1.0761 6.65959 1.0761 6.85485 1.27137L9.56319 3.9797C9.75845 4.17496 9.75845 4.49154 9.56319 4.6868C9.36793 4.88207 9.05135 4.88207 8.85609 4.6868L6.5013 2.33203L4.14652 4.6868C3.95126 4.88207 3.63468 4.88207 3.43942 4.6868C3.24415 4.49154 3.24415 4.17496 3.43942 3.9797L6.14775 1.27137Z" fill="currentColor"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.5 1.125C6.77614 1.125 7 1.34886 7 1.625V8.125C7 8.40114 6.77614 8.625 6.5 8.625C6.22386 8.625 6 8.40114 6 8.125V1.625C6 1.34886 6.22386 1.125 6.5 1.125Z" fill="currentColor"></path>
                        </svg> Share
                    </summary>
                    <div id="Article-share-template--16599720231162__main" class="share-button__fallback motion-reduce">
                        <div class="field">
                            <span id="ShareMessage-template--16599720231162__main" class="share-button__message hidden" role="status"></span>
                            <input type="text" class="field__input" id="url" value="https://dharmacrafts.com/blogs/news/what-is-an-eye-pillow-how-to-use-one" placeholder="Link" onclick="this.select();" readonly="">
                            <label class="field__label" for="url">Link</label>
                        </div>
                        <button class="share-button__close hidden no-js-hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                                <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor"></path>
                            </svg>
                            <span class="visually-hidden">Close share</span>
                        </button>
                        <button class="share-button__copy no-js-hidden">
                            <svg class="icon icon-clipboard" width="11" height="13" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" viewBox="0 0 11 13">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2 1a1 1 0 011-1h7a1 1 0 011 1v9a1 1 0 01-1 1V1H2zM1 2a1 1 0 00-1 1v9a1 1 0 001 1h7a1 1 0 001-1V3a1 1 0 00-1-1H1zm0 10V3h7v9H1z" fill="currentColor"></path>
                            </svg>
                            <span class="visually-hidden">Copy link</span>
                        </button>
                    </div>
                </details>
            </share-button>
            <script src="//dharmacrafts.com/cdn/shop/t/20/assets/share.js?v=23059556731731026671665074180" defer="defer"></script>
        </div>
        <div class="article-template__content page-width page-width--narrow rte" itemprop="articleBody">
            <h3 style="text-align: center;">
                <b>What is an Eye Pillow?</b>
            </h3>
            <p>
                <span style="font-weight: 400;">These small but mighty </span>
                <a href="https://dharmacrafts.com/collections/yoga-supplies" target="_blank" title="Yoga Supplies | DharmaCrafts" rel="noopener noreferrer">
                    <span style="font-weight: 400;">yoga tools</span>
                </a>&nbsp; <span style="font-weight: 400;">are exactly what the name implies: a tiny pillow for your eyes! Not to be confused with an eye mask for sleeping, eye pillows typically do not have straps and are designed to rest freely on the face so as to not create excess pressure or discomfort.</span>
            </p>
            <p>
                <span style="font-weight: 400;">Each DharmaCrafts </span>
                <span style="font-weight: 400;">yoga eye pillow </span>
                <span style="font-weight: 400;">is individually handmade in the USA by our team of talented craftspeople. We use the same fabrics to craft our </span>
                <span style="font-weight: 400;">eye cushions</span>
                <span style="font-weight: 400;"> that we use for the rest of our </span>
                <a href="https://dharmacrafts.com/collections/cushions-and-benches" target="_blank" title="Meditation Cushions | DharmaCrafts" rel="noopener noreferrer">
                    <span style="font-weight: 400;">meditation cushion</span>
                </a>
                <span style="font-weight: 400;"> collections, so you can mix and match your new eye pillows with other DharmaCrafts </span>
                <span style="font-weight: 400;">meditation pillows</span>
                <span style="font-weight: 400;">.</span>
            </p>
            <p>
                <span style="font-weight: 400;">Our eye pillows are filled with 100% natural flax seed to create a beanbag-like filling that is free from chemicals, dyes, and plastics. We also offer the option to add dried lavender flower buds to your pillow to transform it into an </span>
                <a href="https://dharmacrafts.com/blogs/news/aromatherapy-therapeutic-smells-with-roots-in-ancient-history" target="_blank" title="&quot;Aromatherapy – Therapeutic Smells With Roots in Ancient History&quot; Blog" rel="noopener noreferrer">
                    <span style="font-weight: 400;">aromatherapy</span>
                </a>
                <span style="font-weight: 400;"> eye pillow</span>
                <span style="font-weight: 400;">.</span>
            </p>
            <div style="text-align: center;">
                <img src="https://cdn.shopify.com/s/files/1/0298/7753/4853/files/DC_EyePillow_Insert3_480x480.jpg?v=1685631486" alt="Flaxseed Eye Pillows | DharmaCrafts" style="float: none;">
            </div>
            <p style="text-align: center;">
                <em>Pictured: Eye pillow filling</em>
            </p>
            <p style="text-align: center;">&nbsp;</p>
            <h3 style="text-align: center;">
                <b>How Do Eye Pillows Work?</b>
            </h3>
            <p>
                <span style="font-weight: 400;">The purpose of an eye pillow is to promote relaxation and recovery - usually at the end of a yoga session during shavasana (</span>
                <span style="font-weight: 400;">corpse pose yoga</span>
                <span style="font-weight: 400;">), or cool down. Laying one of these little pillows across your eyes creates a gentle pressure against your eyelids and facial nerves. This gentle stimulation primarily targets the vagus nerve, which plays a role in transmitting information from the brain to the heart and digestive system, and tells the body that it’s time to relax. Eye pillows also help to block out light and keep the eyes closed, creating a welcome pause in sensory processing by our hardworking eyes.</span>
            </p>
            <div style="text-align: center;">
                <img src="https://cdn.shopify.com/s/files/1/0298/7753/4853/files/DC_EyePillow_Lifestyle1_86cddb7a-b5d9-413b-b674-fc6c30adea2e_480x480.jpg?v=1685631347" alt="Unscented Eye Pillows | DharmaCrafts" style="float: none;">
            </div>
            <p style="text-align: center;">
                <em>Pictured: DharmaCrafts Eye Pillows in&nbsp; <a href="https://dharmacrafts.com/products/eco-organic-eye-pillow-in-sweet-grass" target="_blank" title="DharmaCrafts Eco Organic Eye Pillow in Sweet Grass" rel="noopener noreferrer">Sweet Grass</a>, <a href="https://dharmacrafts.com/products/studio-eye-pillow-in-black" target="_blank" title="DharmaCrafts Studio Eye Pillow in Black" rel="noopener noreferrer">Black</a>, <a href="https://dharmacrafts.com/products/eco-organic-eye-pillow-in-sunshine" target="_blank" title="DharmaCrafts Eco Organic Eye Pillow in Sunshine" rel="noopener noreferrer">Sunshine</a>, &amp; <a href="https://dharmacrafts.com/products/studio-eye-pillow-in-deep-purple" target="_blank" title="DharmaCrafts Studio Eye Pillow in Deep Purple" rel="noopener noreferrer">Deep Purple</a>
                </em>
            </p>
            <p style="text-align: center;">&nbsp;</p>
            <h3 style="text-align: center;">
                <b>Ways to Use an Eye Pillow</b>
            </h3>
            <p>
                <span style="font-weight: 400;">Using a </span>
                <span style="font-weight: 400;">weighted eye pillow</span>
                <span style="font-weight: 400;"> is an effortless and effective way to enhance any meditation or yoga experience.</span>
            </p>
            <b>
                <li>During Savasana Yoga</li>
            </b>
            <p>
                <span style="font-weight: 400;">Savasana (also known as “shavasana" or “corpse pose”) is one of the best- known and simple yoga poses (asanas) to physically do, since it simply consists of lying flat on your back with your legs spread slightly apart and arms down, away from your torso.</span>
            </p>
            <p>
                <span style="font-weight: 400;">Many yoga instructors and yogis claim, though, that this seemingly “easy” yoga pose is actually one of the hardest to master </span>
                <i>
                    <span style="font-weight: 400;">because </span>
                </i>
                <span style="font-weight: 400;">it is so simple. After a rewarding session of yoga, practicing multiple poses and feeling your mind and body sync as you hold each one, simply lying down and doing </span>
                <i>
                    <span style="font-weight: 400;">nothing </span>
                </i>
                <span style="font-weight: 400;">often allows the mind to easily wonder.</span>
            </p>
            <p>
                <span style="font-weight: 400;">Incorporating our </span>
                <span style="font-weight: 400;">flax eye pillow</span>
                <span style="font-weight: 400;"> into your savasana cool down helps to deepen the experience of this asana by combining physical </span>
                <span style="font-weight: 400;">shavasana benefits</span>
                <span style="font-weight: 400;"> with the sensory stimulation of facial pressure.</span>
            </p>
            <b>
                <li>During Meditation</li>
            </b>
            <p>
                <span style="font-weight: 400;">Similarly to corpse pose yoga, </span>
                <span style="font-weight: 400;">supine meditation</span>
                <span style="font-weight: 400;"> (meditation performed while lying on the back) can also be equally difficult to retain a level of focus and ease without becoming distracted. Use a meditation eye pillow to encourage your body and mind to release itself into a meditative state. We also offer a variety of guided <a href="https://dharmacrafts.com/search?q=guided+meditation+scripts&amp;options%5Bprefix%5D=last" target="_blank" title="Guided Meditation Scripts | DharmaCrafts" rel="noopener noreferrer">meditation scripts</a> for different purposes that you can use to aid in your </span>
                <span style="font-weight: 400;"> meditation practice</span>
                <span style="font-weight: 400;">.</span>
            </p>
            <b>
                <li>For Anxiety, Stress, and General Relaxation</li>
            </b>
            <p>
                <span style="font-weight: 400;">Whether you’re someone who meditates every day right after a rigorous yoga routine, or only dabbles in each on occasion, feeling <a href="https://dharmacrafts.com/blogs/news/benefits-of-body-scan-meditation?_pos=39&amp;_sid=5c042bf84&amp;_ss=r" target="_blank" title="&quot;Benefits of Body Scan Meditation&quot; Blog" rel="noopener noreferrer">stressed</a> and overwhelmed are emotions we’re all familiar with. </span>
            </p>
            <p>
                <span style="font-weight: 400;">A </span>
                <span style="font-weight: 400;">lavender eye pillow</span>
                <span style="font-weight: 400;"> can serve as an excellent tool for </span>
                <span style="font-weight: 400;">natural stress and anxiety relief</span>
                <span style="font-weight: 400;">. When life starts to get too hectic or feelings of anxiety begin to creep in, simply place your eye cushion on your eyes or forehead to block out the world. Even if just for a few moments, this bit of respite will help you recollect and ground yourself. Keep an eye pillow at your desk, at work, or in your bag for on-the-go relief.</span>
            </p>
            <b>
                <li>For Sleep Issues/ Insomnia</li>
            </b>
            <p>
                <span style="font-weight: 400;">According to </span>
                <a href="https://www.sleepfoundation.org/how-sleep-works/sleep-facts-statistics#:~:text=According%20to%20estimates%2C%2050%20million,U.S.%20have%20ongoing%20sleep%20disorders" target="_blank" title="Sleep Statistics | SleepFoundation.org" rel="noopener noreferrer">
                    <span style="font-weight: 400;">SleepFoundation.org</span>
                </a>
                <span style="font-weight: 400;">, approximately 15% to 20% of Americans struggle with some sort of sleep disorder, such as insomnia and sleep apnea. With so many people having </span>
                <span style="font-weight: 400;">trouble sleeping</span>
                <span style="font-weight: 400;">, natural sleep solutions have consequently grown in popularity.</span>
            </p>
            <p>
                <span style="font-weight: 400;">While a simple </span>
                <span style="font-weight: 400;">scented eye pillow</span>
                <span style="font-weight: 400;"> may not fully resolve a severe sleep disorder, the gentle nerve stimulation and blackout effect of an eye pillow combined with the </span>
                <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC4505755/" target="_blank" title="&quot;Effect of Inhaled Lavender and Sleep Hygiene on Self-Reported Sleep Issues: A Randomized Controlled Trial&quot; | NCBI" rel="noopener noreferrer">
                    <span style="font-weight: 400;">proven effectiveness</span>
                </a>
                <span style="font-weight: 400;"> of lavender for sleep may offer some relief.</span>
            </p>
            <div style="text-align: center;">
                <img src="https://cdn.shopify.com/s/files/1/0298/7753/4853/files/DC_EyePillow_Tombo1_89dae52e-ab2f-4f25-9609-ed9e03b83464_480x480.jpg?v=1685631880" alt="DharmaCrafts Yoga Eye Pillow in Navy Dragonfly">
            </div>
            <p style="text-align: center;">
                <em>Pictured: <a href="https://dharmacrafts.com/products/yoga-eye-pillow-in-navy-dragonfly" target="_blank" title="DharmaCrafts Yoga Eye Pillow in Navy Dragonfly" rel="noopener noreferrer">DharmaCrafts Eye Pillow in&nbsp;Navy Dragonfly</a>
                </em>
            </p>
            <p style="text-align: center;">&nbsp;</p>
            <p>
                <b>Tip:</b>
                <span style="font-weight: 400;">Warm up your eye pillow by placing it on a radiator for a few minutes, or cool it down by placing it in the fridge/ freezer before you use it!</span>
            </p>
            <br>
            <span style="font-weight: 400;">Adding an eye pillow to your yoga or meditation routine may not seem as directly impactful as something like a </span>
            <a href="https://dharmacrafts.com/collections/zafu-zabuton-set" target="_blank" title="Zafu Zabuton Meditation Cushion Sets | DharmaCrafts" rel="noopener noreferrer">
                <span style="font-weight: 400;">zafu zabuton set</span>
            </a>
            <span style="font-weight: 400;"> or </span>
            <a href="https://dharmacrafts.com/collections/yoga-mat" target="_blank" title="Yoga Mats | DharmaCrafts" rel="noopener noreferrer">
                <span style="font-weight: 400;">yoga mat</span>
            </a>
            <span style="font-weight: 400;">, but these little pillows still carry a number of benefits that can be utilized by novices and experts alike.</span>
        </div>
        <div class="article-template__back element-margin-top center">
            <a href="/blogs/news" class="article-template__link link animate-arrow">
                <span class="icon-wrap">
                    <svg viewBox="0 0 14 10" fill="none" aria-hidden="true" focusable="false" role="presentation" class="icon icon-arrow" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.537.808a.5.5 0 01.817-.162l4 4a.5.5 0 010 .708l-4 4a.5.5 0 11-.708-.708L11.793 5.5H1a.5.5 0 010-1h10.793L8.646 1.354a.5.5 0 01-.109-.546z" fill="currentColor"></path>
                    </svg>
                </span> Back to blog </a>
        </div>
        <div class="article-template__comment-wrapper background-secondary">
            <div id="comments" class="page-width page-width--narrow">
                <form method="post" action="/blogs/news/what-is-an-eye-pillow-how-to-use-one/comments#comment_form" id="comment_form" accept-charset="UTF-8" class="comment-form">
                    <input type="hidden" name="form_type" value="new_comment">
                    <input type="hidden" name="utf8" value="✓">
                    <h2>Leave a comment</h2>
                    <div>
                        <div class="article-template__comment-fields">
                            <div class="field field--with-error">
                                <input type="text" name="comment[author]" id="CommentForm-author" class="field__input" autocomplete="name" value="" aria-required="true" required="" placeholder="Name">
                                <label class="field__label" for="CommentForm-author">Name <span aria-hidden="true">*</span>
                                </label>
                            </div>
                            <div class="field field--with-error">
                                <input type="email" name="comment[email]" id="CommentForm-email" autocomplete="email" class="field__input" value="" autocorrect="off" autocapitalize="off" aria-required="true" required="" placeholder="Email">
                                <label class="field__label" for="CommentForm-email">Email <span aria-hidden="true">*</span>
                                </label>
                            </div>
                        </div>
                        <div class="field field--with-error">
                            <textarea rows="5" name="comment[body]" id="CommentForm-body" class="text-area field__input" aria-required="true" required="" placeholder="Comment"></textarea>
                            <label class="form__label field__label" for="CommentForm-body">Comment <span aria-hidden="true">*</span>
                            </label>
                        </div>
                    </div>
                    <p class="article-template__comment-warning caption">Please note, comments need to be approved before they are published.</p>
                    <input type="submit" class="button" value="Post comment">
                </form>
            </div>
        </div>
    </article>
</section>
@endsection
