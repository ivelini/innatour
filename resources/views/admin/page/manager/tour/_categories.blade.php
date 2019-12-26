@foreach ($categories as $categoryItem)
    <option value="{{ $categoryItem->id ?? '' }}"
            @isset ($selectCategories)
                @foreach($selectCategories as $category)
                    @if ($category->id == $categoryItem->id)
                        selected
                    @endif
                @endforeach
            @endisset
    >
        {{ $delimiter ?? '' }}{{ $categoryItem->title ?? '' }}
    </option>

    @isset ($categoryItem->children)
        @include('admin.page.manager.tour._categories', [
            'categories' => $categoryItem->children,
            'delimiter' => ' -- ' . $delimiter
        ])
    @endisset

@endforeach