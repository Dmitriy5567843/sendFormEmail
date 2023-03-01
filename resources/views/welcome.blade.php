<!DOCTYPE html>
<html>
<head>
    <title>Вибір автомобіля</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<h2>Вибір автомобіля</h2>



<form action="{{route('send')}}" METHOD="POST">
    @csrf
    <div>
        <label for="car_mark">Модель:</label>
        <select id="car_mark" name="car_mark">
            <option name="mark" value="">Виберіть модель</option>
            @foreach ($marks as $mark)
                <option value="{{ $mark->id }}">{{ $mark->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="car_model">Марка:</label>
        <select id="car_model" name="car_model">
            <option name="model" value="">Виберіть марку</option>
        </select>
    </div>

    <div>
        <button id="send_car_data">Відправити</button>
    </div>

</form>
<script>
    $(document).ready(function() {
        // Делаем поле модели недоступным
        $('#car_model').prop('disabled', true);

        // Обработчик изменения значения поля марки
        $('#car_mark').change(function() {
            // Если выбрано значение "Выберите марку", делаем поле модели недоступным
            if ($(this).val() == '') {
                $('#car_model').prop('disabled', true);
            } else {
                // В противном случае, делаем поле модели доступным и отправляем запрос на сервер для получения списка моделей
                $('#car_model').prop('disabled', false);
                var markId = $(this).val();
                $.get('/car-models', {mark_id: markId}, function(carModels) {
                    var options = '';
                    $.each(carModels, function(key, carModel) {
                        options += '<option value="' + carModel.id + '">' + carModel.name + '</option>';
                    });
                    $('#car_model').html(options);
                });
            }
        });
    });
</script>

</body>
</html>
