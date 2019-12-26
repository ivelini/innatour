<footer class="main-footer">

    <div class="container">

        <div class="row">

            <div class="col-sm-12 col-sm-5 col-md-4">

                <div class="row">
                    <div class="footer-about col-sm-10 col-md-10">
                        <div class="footer-logo">
                            <a href="/">ИННА ТУР</a>
                        </div>

                        <p class="about-us-footer">
                            {{ !empty($data['sitePhones']) ? $data['sitePhones'] : '' }}<br />
                            {{ !empty($data['siteAddress']) ? $data['siteAddress'] : '' }}<br />
                            {{ !empty($data['siteClockWork']) ? $data['siteClockWork'] : '' }}
                        </p>

                        <p class="copy-right font12">&#169; Copyright 2019</p>

                    </div>
                </div>

            </div>

            <div class="col-sm-12 col-sm-7 col-md-8">

                <div class="row gap-20">

                    <div class="col-xss-6 col-xs-4 col-sm-5 mt-30-xs" style="text-align: center;">
                        <img style="width: 30%; margin: 0 auto;" src="\frontend\images\rostur.png" />
                        <a href="https://www.russiatourism.ru/operators/show.php?id=113579" target="_blank">"РОСТУРИЗМ"<br />Мы в реестре туроператоров:<br />РТО 020594 ООО "ТО Иннтур"</a>
                    </div>

                    <div class="col-xss-6 col-xs-4 col-sm-4 mt-30-xs">

                        <h4 class="footer-title">Информация</h4>

                        <ul class="menu-footer">
                            @if($pagesFooterInfo->count() > 0)
                                @foreach($pagesFooterInfo as $page)
                                    <li><a href="{{ route('page.show', $page->id) }}">{{ $page->nav_name }}</a></li>
                                @endforeach
                            @endif
                        </ul>

                    </div>

                    <div class="col-xss-12 col-xs-4 col-sm-3 mt-30-xs">

                        <h4 class="footer-title">Соц. сети</h4>

                        <ul class="menu-footer for-social">
                            @if(!empty($data['siteVk']))
                                <li><a href="{{  $data['siteVk'] }}">ВКОНТАКТЕ</a></li>
                            @endif
                                @if(!empty($data['siteOk']))
                                    <li><a href="{{  $data['siteOk'] }}">ОДНОКЛАССНИКИ</a></li>
                                @endif
                                @if(!empty($data['siteFb']))
                                    <li><a href="{{  $data['siteFb'] }}">FACEBOOK</a></li>
                                @endif
                                @if(!empty($data['siteInsta']))
                                    <li><a href="{{  $data['siteInsta'] }}">INSTAGRAMM</a></li>
                                @endif
                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div>

</footer>