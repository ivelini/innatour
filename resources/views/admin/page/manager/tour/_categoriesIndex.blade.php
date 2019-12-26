@foreach ($categories as $categoryItem)
        <tr>
            <td>
                <div class="card-img-actions m-1">
                    <img style="max-width: 250px; max-height: 150px;" src="
					@if($categoryItem->gallery->isNotEmpty())
                        {{ asset('storage/' .$categoryItem->gallery->first()->path) }}
                    @endif">
                </div>
            </td>
            <td>{{ $delimiter ?? '' }} {{ $categoryItem->title }}</td>
            <td>{{ $categoryItem->description }}</td>
            <td class="text-center"><a href="{{ route('manager.tour.indexCurrentCategory', $categoryItem->id) }}">{{ $categoryItem->tours->count() }}</a></td>
            <td class="text-center">
                <div class="list-icons">
                    <div class="dropdown">
                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                            <i class="icon-menu9"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="dropdown-item"
                               data-toggle="modal"
                               data-target="#modal_default"
                               data-id = "{{ $categoryItem->id }}"
                               data-parent_id = "{{ $categoryItem->parent_id }}"
                               data-title="{{ $categoryItem->title ?? '' }}"
                               data-description = "{{ $categoryItem->description }}"
                               data-description_img = "{{ $categoryItem->description_img }}"
                               data-path = "@if($categoryItem->gallery->isNotEmpty()){{ asset('storage/' .$categoryItem->gallery->first()->path) }}@endif"
                            ><i class="icon-pencil3"></i> Редактировать</a>
                            <a href="#" class="dropdown-item"
                               data-toggle="modal"
                               data-target="#modal_delete"
                               data-id = "{{ $categoryItem->id }}"
                            ><i class="icon-bin"></i> Удалить</a>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

    @isset ($categoryItem->children)
        @include('admin.page.manager.tour._categoriesIndex', [
            'categories' => $categoryItem->children,
            'delimiter' => ' -- ' . $delimiter
        ])
    @endisset

@endforeach