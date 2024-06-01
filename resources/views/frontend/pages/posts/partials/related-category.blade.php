<div class="page-related-category article-template__content page-width page-width--narrow rte">
    <div class="sub-header">Bài viết cùng chủ đề:</div>
    <ul>
        @foreach ($postCategory->posts as $post)
        <li>
            <a href="{{ route('fe.web.posts.index', data_get($post, 'slug')) }}" class="related-item" target="_blank">{{ data_get($post, 'name') }}</a>
        </li>
        @endforeach
    </ul>
</div>
