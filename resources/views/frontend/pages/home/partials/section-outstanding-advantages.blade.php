<div class="section-template-padding page-width section-template__video-padding">
    <div class="section-content-template">
        <div class="recommendation-target">
            <div class="video-section__media deferred-media no-js-hidden gradient global-media-settings">
                <div class="video-section__media-wrapper" home_video_wrapper-resize-detection>
                    <div class="video-section__media-left_content">
                        <ul>
                            @foreach (data_get($videoOutsideUI, 'featured_keys', []) as $item)
                            <li class="video-section__media-featured_item">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24" fill="none">
                                        <path d="M4 14L9 19L20 8M6 8.88889L9.07692 12L16 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="content">
                                    <span class="title">{{ data_get($item, 'title') }}</span>
                                    <p class="desc">{{ data_get($item, 'desc') }}</p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="video-section__media-right_content video-keys-featured-detection d-none">
                        <video id="home_video_wrapper" src="{{ data_get($videoOutsideUI, 'source_url') }}" autoplay="true" loop muted="muted"></video>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
