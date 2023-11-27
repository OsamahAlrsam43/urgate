<style>
    h4.main-news-title {
        background: #edad37;
        text-align: center;
        padding: 10px;
        margin-bottom: 10px;
    }

    ul.general-news li {
        text-align: center;
        background: #cacaca;
        border: 1px solid #9e9e9e;
        font-size: 13px;
        margin-bottom: 5px;
    }
</style>

<h4 class="main-news-title">
    {{App::getLocale() == "ar" ? "اخبار عامة" : "General News"}}
</h4>

<ul class="general-news">
	<?php $i = 1; ?>
    @foreach(\App\Page::where("page_type", "news")->where("sticky", 1)->get() as $news)
        @if($i < 5)
            @if($news->sticky_date && strtotime($news->sticky_date) < time())
				<?php continue; ?>
            @endif
            <li><a href="{{url("page/".$news->id)}}">{{ $news->title[App::getLocale()] }}</a></li>
			<?php $i ++; ?>
        @endif
    @endforeach
</ul>