@if (isset($categories))
    <div class="product-filters">
        <h3>List by Feature</h3>
        <h4>Filter Products by:</h4>
        <form>
            @foreach (Request::intersect(['search']) as $name => $value)
                @if (is_array($value))
                    @foreach ($value as $item)
                        <input type="hidden" name="{{ $name }}[]" value="{{ $item }}" />
                    @endforeach
                @else
                    <input type="hidden" name="{{ $name }}" value="{{ $value }}" />
                @endif
            @endforeach
            <div class="filter-group">
                <ul class="filter-group-content">
                    <li>
                        <label>
                            <input type="radio"
                                id="no-category"
                                class="no-category"
                                name="category"
                                style="float: left"
                                value=""
                            @if (!$category) checked @endif />
                            All categories
                        </label>
                        @if (!isset($filters))
                            @include ('layouts.feature-filters')
                        @endif
                    </li>
                    @foreach ($categories as $filterCategory)
                        <li class="cat">
                            <label>
                                <input type="radio"
                                    class="category-display"
                                    name="category"
                                    id="{{$filterCategory->category }}"
                                    style="float: left"
                                    value="{{ $filterCategory->category }}"
                                    @if ($category && $category->id === $filterCategory->id) checked @endif />
                                {{ $filterCategory->name }}
                            </label>
                            <div class="filters">
                            @if ($category && $category->id === $filterCategory->id)
                                @include ('layouts.feature-filters')
                            @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </form>
    </div>
@endif
