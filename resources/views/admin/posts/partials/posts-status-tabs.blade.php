<ul class="nav nav-tabs">
    <li role="presentation" @if($activeStatus === '')class="active"@endif><a href="{{ route('admin.posts.index') }}?type={{ $postType }}">{{ \Illuminate\Support\Facades\Config::get('blog.show-all') }}</a></li>
    @foreach($statuses as $status)
    <li role="presentation" @if($status === $activeStatus)class="active"@endif><a href="{{ route('admin.posts.index') }}?type={{ $postType }}&status={{ $status }}">{{ ucfirst($status) }}</a></li>
    @endforeach
</ul>