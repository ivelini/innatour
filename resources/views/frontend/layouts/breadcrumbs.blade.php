@if(strcasecmp(Request::route()->action['as'], 'index') != 0)
    <div class="breadcrumb-wrapper">

        <div class="container">

            <div class="row">

                <div class="col-xs-12 col-sm-6">
                    @if(strcasecmp(Request::route()->action['as'], 'tour.show') == 0 || strcasecmp(Request::route()->action['as'], 'manager.tour.show') == 0)
                        {{ Breadcrumbs::render('tour', $tour->categories->first(), $tour) }}
                    @elseif(strcasecmp(Request::route()->action['as'], 'category.indexCurrentCategory') == 0)
                        {{ Breadcrumbs::render('category', $category) }}
                    @elseif(strcasecmp(Request::route()->action['as'], 'scope.indexCurrentScope') == 0)
                        {{ Breadcrumbs::render('scope', $scope) }}
                    @elseif(strcasecmp(Request::route()->action['as'], 'page.show') == 0)
                        {{ Breadcrumbs::render('page', $page) }}
                    @endif

                </div>

                <div class="col-xs-12 col-sm-6 hidden-xs">
                    <p class="hot-line"><i class="fa fa-phone"></i>
                        Телефон: {{ !empty($data['sitePhones']) ? $data['sitePhones'] : '' }}</p>
                </div>

            </div>

        </div>

    </div>
@endif