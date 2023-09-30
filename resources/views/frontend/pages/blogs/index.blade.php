@extends('frontend.layouts.master')

@push('style_pages')
<style>
    .section-template__main-padding {
        padding-top: 27px;
        padding-bottom: 9px;
    }

    @media screen and (min-width: 750px) {
        .section-template__main-padding {
            padding-top: 36px;
            padding-bottom: 12px;
        }
    }
</style>
<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/blogs/index.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-article-card.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-card.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-pagination.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-slider-2.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-price.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('frontend/assets/css/common/spr.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('frontend/assets/css/common/recommendation.css') }}"> --}}
@endpush


@section('content_body')
<section class="shopify-section section">
    <div class="main-blog page-width section-template__main-paddingg">
        <h1 class="title--primary">DharmaCrafts' Teachings</h1>
        <div class="blog-articles blog-articles--collage"><div class="blog-articles__article article">
            <div class="card-wrapper underline-links-hover">

                <div class="card article-card
                  card--standard
                   article-card__image--medium
                   card--media

                  " style="--ratio-percent: 66.66666666666666%;">
                  <div class="card__inner  color-background-2 gradient ratio" style="--ratio-percent: 66.66666666666666%;"><div class="article-card__image-wrapper card__media">
                        <div class="article-card__image media media--hover-effect">

                          <img srcset="//dharmacrafts.com/cdn/shop/articles/koun_what_do_you_think_about.jpg?v=1695653795&amp;width=165 165w,//dharmacrafts.com/cdn/shop/articles/koun_what_do_you_think_about.jpg?v=1695653795&amp;width=360 360w,//dharmacrafts.com/cdn/shop/articles/koun_what_do_you_think_about.jpg?v=1695653795&amp;width=533 533w,//dharmacrafts.com/cdn/shop/articles/koun_what_do_you_think_about.jpg?v=1695653795&amp;width=720 720w,//dharmacrafts.com/cdn/shop/articles/koun_what_do_you_think_about.jpg?v=1695653795&amp;width=1000 1000w,//dharmacrafts.com/cdn/shop/articles/koun_what_do_you_think_about.jpg?v=1695653795&amp;width=1500 1500w,//dharmacrafts.com/cdn/shop/articles/koun_what_do_you_think_about.jpg?v=1695653795 2727w" src="//dharmacrafts.com/cdn/shop/articles/koun_what_do_you_think_about.jpg?v=1695653795&amp;width=533" sizes="(min-width: 1600px) 750px, (min-width: 750px) calc((100vw - 130px) / 2), calc((100vw - 50px) / 2)" alt="What Do You Think About All Day? - Koun Franz" class="motion-reduce" loading="lazy" width="2727" height="1818">

                        </div>
                      </div><div class="card__content">
                      <div class="card__information">
                        <h3 class="card__heading h2">
                          <a href="/blogs/news/what-do-you-think-about-all-day-koun-franz" class="full-unstyled-link">
                            What Do You Think About All Day? - Koun Franz
                          </a>
                        </h3>
                        <div class="article-card__info caption-with-letter-spacing h5"><span class="circle-divider"><time datetime="2023-09-25T16:33:08Z">September 25, 2023</time></span></div><p class="article-card__excerpt rte-width">There’s a meme—nearly twenty years old now—of an adorable little kitten with the simple caption “Kitten Thinks of Nothing but Murder All Day.” I laughed the first time I saw...
            </p><div class="article-card__footer"></div></div></div>
                  </div>
                  <div class="card__content">
                    <div class="card__information">
                      <h3 class="card__heading h2">
                        <a href="/blogs/news/what-do-you-think-about-all-day-koun-franz" class="full-unstyled-link">
                          What Do You Think About All Day? - Koun Franz
                        </a>
                      </h3>
                      <div class="article-card__info caption-with-letter-spacing h5"><span class="circle-divider"><time datetime="2023-09-25T16:33:08Z">September 25, 2023</time></span></div><p class="article-card__excerpt rte-width">There’s a meme—nearly twenty years old now—of an adorable little kitten with the simple caption “Kitten Thinks of Nothing but Murder All Day.” I laughed the first time I saw...
            </p><div class="article-card__footer"></div></div></div>
                </div>
              </div></div><div class="blog-articles__article article">
            <div class="card-wrapper underline-links-hover">

                <div class="card article-card
                  card--standard
                   article-card__image--medium
                   card--media

                  " style="--ratio-percent: 66.79338103756709%;">
                  <div class="card__inner  color-background-2 gradient ratio" style="--ratio-percent: 66.79338103756709%;"><div class="article-card__image-wrapper card__media">
                        <div class="article-card__image media media--hover-effect">

                          <img srcset="//dharmacrafts.com/cdn/shop/articles/custom_resized_b7c11c8b-f858-4b6f-9c72-401185661354.jpg?v=1694699258&amp;width=165 165w,//dharmacrafts.com/cdn/shop/articles/custom_resized_b7c11c8b-f858-4b6f-9c72-401185661354.jpg?v=1694699258&amp;width=360 360w,//dharmacrafts.com/cdn/shop/articles/custom_resized_b7c11c8b-f858-4b6f-9c72-401185661354.jpg?v=1694699258&amp;width=533 533w,//dharmacrafts.com/cdn/shop/articles/custom_resized_b7c11c8b-f858-4b6f-9c72-401185661354.jpg?v=1694699258&amp;width=720 720w,//dharmacrafts.com/cdn/shop/articles/custom_resized_b7c11c8b-f858-4b6f-9c72-401185661354.jpg?v=1694699258&amp;width=1000 1000w,//dharmacrafts.com/cdn/shop/articles/custom_resized_b7c11c8b-f858-4b6f-9c72-401185661354.jpg?v=1694699258&amp;width=1500 1500w,//dharmacrafts.com/cdn/shop/articles/custom_resized_b7c11c8b-f858-4b6f-9c72-401185661354.jpg?v=1694699258 4472w" src="//dharmacrafts.com/cdn/shop/articles/custom_resized_b7c11c8b-f858-4b6f-9c72-401185661354.jpg?v=1694699258&amp;width=533" sizes="(min-width: 1600px) 750px, (min-width: 750px) calc((100vw - 130px) / 2), calc((100vw - 50px) / 2)" alt="Principles of Form - Koun Franz" class="motion-reduce" loading="lazy" width="4472" height="2987">

                        </div>
                      </div><div class="card__content">
                      <div class="card__information">
                        <h3 class="card__heading h2">
                          <a href="/blogs/news/principles-of-form-by-koun-franz" class="full-unstyled-link">
                            Principles of Form - Koun Franz
                          </a>
                        </h3>
                        <div class="article-card__info caption-with-letter-spacing h5"><span class="circle-divider"><time datetime="2023-09-14T13:49:17Z">September 14, 2023</time></span></div><p class="article-card__excerpt rte-width">For years, I resisted any kind of online practice. I was aware of a handful of communities that met either periodically or exclusively over Zoom, and though I admired the...
            </p><div class="article-card__footer"></div></div></div>
                  </div>
                  <div class="card__content">
                    <div class="card__information">
                      <h3 class="card__heading h2">
                        <a href="/blogs/news/principles-of-form-by-koun-franz" class="full-unstyled-link">
                          Principles of Form - Koun Franz
                        </a>
                      </h3>
                      <div class="article-card__info caption-with-letter-spacing h5"><span class="circle-divider"><time datetime="2023-09-14T13:49:17Z">September 14, 2023</time></span></div><p class="article-card__excerpt rte-width">For years, I resisted any kind of online practice. I was aware of a handful of communities that met either periodically or exclusively over Zoom, and though I admired the...
            </p><div class="article-card__footer"></div></div></div>
                </div>
              </div></div><div class="blog-articles__article article">
            <div class="card-wrapper underline-links-hover">

                <div class="card article-card
                  card--standard
                   article-card__image--medium
                   card--media

                  " style="--ratio-percent: 66.67307692307692%;">
                  <div class="card__inner  color-background-2 gradient ratio" style="--ratio-percent: 66.67307692307692%;"><div class="article-card__image-wrapper card__media">
                        <div class="article-card__image media media--hover-effect">

                          <img srcset="//dharmacrafts.com/cdn/shop/articles/AdobeStock_303648262.jpg?v=1660156489&amp;width=165 165w,//dharmacrafts.com/cdn/shop/articles/AdobeStock_303648262.jpg?v=1660156489&amp;width=360 360w,//dharmacrafts.com/cdn/shop/articles/AdobeStock_303648262.jpg?v=1660156489&amp;width=533 533w,//dharmacrafts.com/cdn/shop/articles/AdobeStock_303648262.jpg?v=1660156489&amp;width=720 720w,//dharmacrafts.com/cdn/shop/articles/AdobeStock_303648262.jpg?v=1660156489&amp;width=1000 1000w,//dharmacrafts.com/cdn/shop/articles/AdobeStock_303648262.jpg?v=1660156489&amp;width=1500 1500w,//dharmacrafts.com/cdn/shop/articles/AdobeStock_303648262.jpg?v=1660156489 5200w" src="//dharmacrafts.com/cdn/shop/articles/AdobeStock_303648262.jpg?v=1660156489&amp;width=533" sizes="(min-width: 1600px) 750px, (min-width: 750px) calc((100vw - 130px) / 2), calc((100vw - 50px) / 2)" alt="5 Things to Know About Obon: Japan’s Buddhist Festival of the Dead" class="motion-reduce" loading="lazy" width="5200" height="3467">

                        </div>
                      </div><div class="card__content">
                      <div class="card__information">
                        <h3 class="card__heading h2">
                          <a href="/blogs/news/5-things-to-know-about-obon-japan-s-buddhist-festival-of-the-dead" class="full-unstyled-link">
                            5 Things to Know About Obon: Japan’s Buddhist F...
                          </a>
                        </h3>
                        <div class="article-card__info caption-with-letter-spacing h5"><span class="circle-divider"><time datetime="2023-08-11T14:35:17Z">August 11, 2023</time></span></div><p class="article-card__excerpt rte-width">The Obon Festival (お盆) is one of multiple Buddhist holidays celebrated throughout the year. Obon, or “Bon” as it is also known, is a 3-day lantern festival celebrated annually in...
            </p><div class="article-card__footer"></div></div></div>
                  </div>
                  <div class="card__content">
                    <div class="card__information">
                      <h3 class="card__heading h2">
                        <a href="/blogs/news/5-things-to-know-about-obon-japan-s-buddhist-festival-of-the-dead" class="full-unstyled-link">
                          5 Things to Know About Obon: Japan’s Buddhist F...
                        </a>
                      </h3>
                      <div class="article-card__info caption-with-letter-spacing h5"><span class="circle-divider"><time datetime="2023-08-11T14:35:17Z">August 11, 2023</time></span></div><p class="article-card__excerpt rte-width">The Obon Festival (お盆) is one of multiple Buddhist holidays celebrated throughout the year. Obon, or “Bon” as it is also known, is a 3-day lantern festival celebrated annually in...
            </p><div class="article-card__footer"></div></div></div>
                </div>
              </div></div><div class="blog-articles__article article">
            <div class="card-wrapper underline-links-hover">

                <div class="card article-card
                  card--standard
                   article-card__image--medium
                   card--media

                  " style="--ratio-percent: 66.65921288014312%;">
                  <div class="card__inner  color-background-2 gradient ratio" style="--ratio-percent: 66.65921288014312%;"><div class="article-card__image-wrapper card__media">
                        <div class="article-card__image media media--hover-effect">

                          <img srcset="//dharmacrafts.com/cdn/shop/articles/custom_resized_093dad6d-f86d-4ee8-80fb-bb4ac1e7d227.jpg?v=1687451808&amp;width=165 165w,//dharmacrafts.com/cdn/shop/articles/custom_resized_093dad6d-f86d-4ee8-80fb-bb4ac1e7d227.jpg?v=1687451808&amp;width=360 360w,//dharmacrafts.com/cdn/shop/articles/custom_resized_093dad6d-f86d-4ee8-80fb-bb4ac1e7d227.jpg?v=1687451808&amp;width=533 533w,//dharmacrafts.com/cdn/shop/articles/custom_resized_093dad6d-f86d-4ee8-80fb-bb4ac1e7d227.jpg?v=1687451808&amp;width=720 720w,//dharmacrafts.com/cdn/shop/articles/custom_resized_093dad6d-f86d-4ee8-80fb-bb4ac1e7d227.jpg?v=1687451808&amp;width=1000 1000w,//dharmacrafts.com/cdn/shop/articles/custom_resized_093dad6d-f86d-4ee8-80fb-bb4ac1e7d227.jpg?v=1687451808&amp;width=1500 1500w,//dharmacrafts.com/cdn/shop/articles/custom_resized_093dad6d-f86d-4ee8-80fb-bb4ac1e7d227.jpg?v=1687451808 4472w" src="//dharmacrafts.com/cdn/shop/articles/custom_resized_093dad6d-f86d-4ee8-80fb-bb4ac1e7d227.jpg?v=1687451808&amp;width=533" sizes="(min-width: 1600px) 750px, (min-width: 750px) calc((100vw - 130px) / 2), calc((100vw - 50px) / 2)" alt="How to Create an Outdoor Meditation Space" class="motion-reduce" loading="lazy" width="4472" height="2981">

                        </div>
                      </div><div class="card__content">
                      <div class="card__information">
                        <h3 class="card__heading h2">
                          <a href="/blogs/news/how-to-create-an-outdoor-meditation-space" class="full-unstyled-link">
                            How to Create an Outdoor Meditation Space
                          </a>
                        </h3>
                        <div class="article-card__info caption-with-letter-spacing h5"><span class="circle-divider"><time datetime="2023-06-22T16:51:25Z">June 22, 2023</time></span></div><p class="article-card__excerpt rte-width">In the busy, technology-centered world we live in today, it can be all too easy to lose sight of ourselves and get caught up in the demands of daily life....
            </p><div class="article-card__footer"></div></div></div>
                  </div>
                  <div class="card__content">
                    <div class="card__information">
                      <h3 class="card__heading h2">
                        <a href="/blogs/news/how-to-create-an-outdoor-meditation-space" class="full-unstyled-link">
                          How to Create an Outdoor Meditation Space
                        </a>
                      </h3>
                      <div class="article-card__info caption-with-letter-spacing h5"><span class="circle-divider"><time datetime="2023-06-22T16:51:25Z">June 22, 2023</time></span></div><p class="article-card__excerpt rte-width">In the busy, technology-centered world we live in today, it can be all too easy to lose sight of ourselves and get caught up in the demands of daily life....
            </p><div class="article-card__footer"></div></div></div>
                </div>
              </div></div><div class="blog-articles__article article">
            <div class="card-wrapper underline-links-hover">

                <div class="card article-card
                  card--standard
                   article-card__image--medium
                   card--media

                  " style="--ratio-percent: 80.00894454382828%;">
                  <div class="card__inner  color-background-2 gradient ratio" style="--ratio-percent: 80.00894454382828%;"><div class="article-card__image-wrapper card__media">
                        <div class="article-card__image media media--hover-effect">

                          <img srcset="//dharmacrafts.com/cdn/shop/articles/custom_resized_7e58797c-3196-4b22-abdc-d6036927629e.jpg?v=1685632619&amp;width=165 165w,//dharmacrafts.com/cdn/shop/articles/custom_resized_7e58797c-3196-4b22-abdc-d6036927629e.jpg?v=1685632619&amp;width=360 360w,//dharmacrafts.com/cdn/shop/articles/custom_resized_7e58797c-3196-4b22-abdc-d6036927629e.jpg?v=1685632619&amp;width=533 533w,//dharmacrafts.com/cdn/shop/articles/custom_resized_7e58797c-3196-4b22-abdc-d6036927629e.jpg?v=1685632619&amp;width=720 720w,//dharmacrafts.com/cdn/shop/articles/custom_resized_7e58797c-3196-4b22-abdc-d6036927629e.jpg?v=1685632619&amp;width=1000 1000w,//dharmacrafts.com/cdn/shop/articles/custom_resized_7e58797c-3196-4b22-abdc-d6036927629e.jpg?v=1685632619&amp;width=1500 1500w,//dharmacrafts.com/cdn/shop/articles/custom_resized_7e58797c-3196-4b22-abdc-d6036927629e.jpg?v=1685632619 4472w" src="//dharmacrafts.com/cdn/shop/articles/custom_resized_7e58797c-3196-4b22-abdc-d6036927629e.jpg?v=1685632619&amp;width=533" sizes="(min-width: 1600px) 750px, (min-width: 750px) calc((100vw - 130px) / 2), calc((100vw - 50px) / 2)" alt="What an Eye Pillow is &amp; How to Use One" class="motion-reduce" loading="lazy" width="4472" height="3578">

                        </div>
                      </div><div class="card__content">
                      <div class="card__information">
                        <h3 class="card__heading h2">
                          <a href="/blogs/news/what-is-an-eye-pillow-how-to-use-one" class="full-unstyled-link">
                            What an Eye Pillow is &amp; How to Use One
                          </a>
                        </h3>
                        <div class="article-card__info caption-with-letter-spacing h5"><span class="circle-divider"><time datetime="2023-06-01T15:32:52Z">June 1, 2023</time></span></div><p class="article-card__excerpt rte-width">What is an Eye Pillow? These small but mighty yoga tools&nbsp;are exactly what the name implies: a tiny pillow for your eyes! Not to be confused with an eye mask...
            </p><div class="article-card__footer"></div></div></div>
                  </div>
                  <div class="card__content">
                    <div class="card__information">
                      <h3 class="card__heading h2">
                        <a href="/blogs/news/what-is-an-eye-pillow-how-to-use-one" class="full-unstyled-link">
                          What an Eye Pillow is &amp; How to Use One
                        </a>
                      </h3>
                      <div class="article-card__info caption-with-letter-spacing h5"><span class="circle-divider"><time datetime="2023-06-01T15:32:52Z">June 1, 2023</time></span></div><p class="article-card__excerpt rte-width">What is an Eye Pillow? These small but mighty yoga tools&nbsp;are exactly what the name implies: a tiny pillow for your eyes! Not to be confused with an eye mask...
            </p><div class="article-card__footer"></div></div></div>
                </div>
              </div></div><div class="blog-articles__article article">
            <div class="card-wrapper underline-links-hover">

                <div class="card article-card
                  card--standard
                   article-card__image--medium
                   card--media

                  " style="--ratio-percent: 63.02083333333333%;">
                  <div class="card__inner  color-background-2 gradient ratio" style="--ratio-percent: 63.02083333333333%;"><div class="article-card__image-wrapper card__media">
                        <div class="article-card__image media media--hover-effect">

                          <img srcset="//dharmacrafts.com/cdn/shop/articles/yoga-g04caafdbe_1920.jpg?v=1682013577&amp;width=165 165w,//dharmacrafts.com/cdn/shop/articles/yoga-g04caafdbe_1920.jpg?v=1682013577&amp;width=360 360w,//dharmacrafts.com/cdn/shop/articles/yoga-g04caafdbe_1920.jpg?v=1682013577&amp;width=533 533w,//dharmacrafts.com/cdn/shop/articles/yoga-g04caafdbe_1920.jpg?v=1682013577&amp;width=720 720w,//dharmacrafts.com/cdn/shop/articles/yoga-g04caafdbe_1920.jpg?v=1682013577&amp;width=1000 1000w,//dharmacrafts.com/cdn/shop/articles/yoga-g04caafdbe_1920.jpg?v=1682013577&amp;width=1500 1500w,//dharmacrafts.com/cdn/shop/articles/yoga-g04caafdbe_1920.jpg?v=1682013577 1920w" src="//dharmacrafts.com/cdn/shop/articles/yoga-g04caafdbe_1920.jpg?v=1682013577&amp;width=533" sizes="(min-width: 1600px) 750px, (min-width: 750px) calc((100vw - 130px) / 2), calc((100vw - 50px) / 2)" alt="Our 7 Best Products for Welcoming New Beginnings This Spring" class="motion-reduce" loading="lazy" width="1920" height="1210">

                        </div>
                      </div><div class="card__content">
                      <div class="card__information">
                        <h3 class="card__heading h2">
                          <a href="/blogs/news/our-7-best-products-for-welcoming-new-beginnings-this-spring" class="full-unstyled-link">
                            Our 7 Best Products for Welcoming New Beginning...
                          </a>
                        </h3>
                        <div class="article-card__info caption-with-letter-spacing h5"><span class="circle-divider"><time datetime="2023-04-20T18:45:33Z">April 20, 2023</time></span></div><p class="article-card__excerpt rte-width">In cultures all around the world, springtime is known as the season of renewal, rejuvenation, and getting a fresh start. While any time of year is appropriate for setting new...
            </p><div class="article-card__footer"></div></div></div>
                  </div>
                  <div class="card__content">
                    <div class="card__information">
                      <h3 class="card__heading h2">
                        <a href="/blogs/news/our-7-best-products-for-welcoming-new-beginnings-this-spring" class="full-unstyled-link">
                          Our 7 Best Products for Welcoming New Beginning...
                        </a>
                      </h3>
                      <div class="article-card__info caption-with-letter-spacing h5"><span class="circle-divider"><time datetime="2023-04-20T18:45:33Z">April 20, 2023</time></span></div><p class="article-card__excerpt rte-width">In cultures all around the world, springtime is known as the season of renewal, rejuvenation, and getting a fresh start. While any time of year is appropriate for setting new...
            </p><div class="article-card__footer"></div></div></div>
                </div>
              </div></div></div>
              <div class="pagination-wrapper">
                <nav class="pagination" role="navigation" aria-label="Pagination">
                  <ul class="pagination__list list-unstyled" role="list"><li><a role="link" aria-disabled="true" class="pagination__item pagination__item--current light" aria-current="page" aria-label="Page 1">1</a></li><li><a href="/blogs/news?page=2" class="pagination__item link" aria-label="Page 2">2</a></li><li><a href="/blogs/news?page=3" class="pagination__item link" aria-label="Page 3">3</a></li><li><span class="pagination__item">…</span></li><li><a href="/blogs/news?page=43" class="pagination__item link" aria-label="Page 43">43</a></li><li>
                      <a href="/blogs/news?page=2" class="pagination__item pagination__item--prev pagination__item-arrow link motion-reduce" aria-label="Next page"><svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-caret" viewBox="0 0 10 6">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor">
            </path></svg>
            </a>
                    </li></ul>
                </nav>
              </div>
    </div>
</section>
@endsection
