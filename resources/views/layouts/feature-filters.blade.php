@if (isset($filters))
    <div class="filter-group feature-filters">
        <ul class="filter-group-content">
            @foreach ($filters as $filter)
                @if ($filter->website_categories_id === $filterCategory->id)
                <li>
                    <input class="filter-option" type="checkbox" name="filters[]" value="{{ $filter->filter }}"
                        @if ($currentFilters && in_array($filter->filter,$currentFilters))
                            checked
                        @endif
                    />
                    <label for="{{ $filter->filter }}">
                        {{ $filter->name }}
                    </label>
                </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif
