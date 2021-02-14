<div class="container portfolio_title">
    
    <div class="section-title">
        <h2>{{$title}}</h2>
    </div>

</div>

<div class="portfolio">
    
    <div id="filters" class="sixteen columns">
        <ul style="padding: 0px 0px 0px 0px">
            <li>
                <a href="{{route('pages')}}">
                    <h5>Страницы</h5>
                </a>
            </li>
            <li>
                <a href="{{route('portfolio')}}">
                    <h5>Портфолио</h5>
                </a>
            </li>
            <li>
                <form action="{{url('/logout')}}">
                    <button class="btn btn-primary">Выход из админки</button>
                </form>


            </li>
        </ul>
    </div>
    
</div>