<div class="wrapper container-fluid">

    <!-- Создаем форму -->
    {!! Form::open([
                    'url' => route('portfolioEdit', array('portfolio' => $data['id'])),
                  'class' => 'form-horizontal',
                 'method' => 'POST',
                'enctype' => 'multipart/form-data'
                  ]) !!}
    <div class="form-group">
        <!-- Скрытое поле -->
        {!! Form::hidden('id', $data['id']) !!}
        {!! Form::label('name','Название: ', ['class' => 'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::text('name', $data['name'], ['class' => 'form-control', 'placeholder' => 'Введите название страницы']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('filter','Фильтр: ', ['class' => 'col-xs-2 control-label'] ) !!}
        <div class="col-xs-8">
            {!! Form::text('filter', $data['filter'], ['class' => 'form-control', 'placeholder' => 'Введите фильтр']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('old_images', 'Изображение:', ['class' => 'col-xs-2 control-label']) !!}
        <div class="col-xs-offset-2 col-xs-10">
            {!! Html::image('assets/img/'.$data['images'],'',['class' => 'img-circle']) !!}
            {!! Form::hidden('old_images', $data['images']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('images', 'Изображение: ', ['class' => 'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::file('images',[         'class' => 'filestyle',
                                          'data-text' => 'Выберите изображение',
                                      'data-btnClass' => 'btn-primary',
                                   'data-placeholder' => 'Файла нет']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            <!-- Кнопка отправки формы: -->
            {!! Form::button('Сохранить', ['class' => 'btn btn-primary',
                                            'type' => 'submit']) !!}
        </div>
    </div>

    <!-- Закрывающий тэг формы -->
{!! Form::close() !!}


</div>
