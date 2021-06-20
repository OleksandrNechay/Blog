@php
    /** @var \App\Models\Post $item */
@endphp

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if($item->is_published)
                    Опубліковано
                @else
                    Чорновик
                @endif
            </div>
            <div class="card-body">
                <div class="card-title"></div>
                <div class="card-subtitle md-2 text-muted"></div>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#maindata" role="tab"> Основні дані </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#adddata" role="tab"> Додаткові дані </a>
                    </li>
                </ul>
                <br>
                <div class="tab-content">
                    <div class="tab-pane active" id="maindata" role="tabpanel">
                        <div class="form-group">
                            <label for="title"> Заголовок </label>
                            <input name="title" value="{{ $item->title }}"
                                   id    = "title"
                                   type  = "text"
                                   class = "form-control"
                                   minlength = "3"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="content_raw"> Стаття </label>
                            <textarea name="content_raw"
                                      id    = "content_raw"
                                      class = "form-control"
                                      rows= "20"> {{ (old('content_raw', $item->content_raw)) }} </textarea>
                        </div>
                        <label for="image"> Фонова картинка</label>
                        <input name="image"
                               type="file"
                               class="form-control"
                               placeholder="image">
                    </div>
                    <div class="tab-pane" id="adddata" role="tabpanel">
                        <div class="form-group">
                            <label for="category_id"> Категорія </label>
                            <select name="category_id"
                                    id    = "category_id"
                                    class = "form-control"
                                    placeholder="Виберіть категорію"
                                    required>
                                @foreach($categoryList as $categoryOption)
                                    <option value="{{ $categoryOption->id}}"
                                            @if($categoryOption->id == $item->category_id) selected @endif>
                                        {{ $categoryOption->id_title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="slug"> Ідентифікатор </label>
                            <input name="slug" value="{{ $item->slug }}"
                                   id    = "slug"
                                   type  = "text"
                                   class = "form-control">
                        </div>

                        <div class="form-group">
                            <label for="excerpt"> Витримка </label>
                            <textarea name="excerpt"
                                      id    = "excerpt"
                                      class = "form-control"
                                      rows= "3"> {{ (old('excerpt', $item->excerpt)) }} </textarea>
                        </div>
                        <div class="form-check">
                            <input name="is_published"
                                   type="hidden"
                                   value="0">

                            <input type="checkbox"
                                   name="is_published"
                                   class="form-check-input"
                                   value="1"
                                   @if($item->is_published)
                                   checked="checked"
                                @endif
                            >
                            <label class="form-check-lavel" for="is_published"> Опубліковано </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js')}}"></script>
<script>
    CKEDITOR.replace( 'content_raw', {
        filebrowserUploadUrl:'storage/image'
    });
</script>
