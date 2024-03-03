<!DOCTYPE html>
<html>
<head>
    <title>Тест</title>
</head>
<body>
    <h1>Данные</h1>
    <p>Имя: {{ $formData['name'] }}</p>
    <p>Фамилия: {{ $formData['surname'] }}</p>
    <p>Отчество: {{ $formData['lastname'] }}</p>
    <p>Группа: {{ $formData['group'] }}</p>
    <p>Первый вопрос: {{ $formData['first'] }}</p>
    <p>Второй вопрос: {{ $formData['second'] }}</p>
    <p>Третий вопрос: {{ $formData['third'] }}</p>
</body>
</html>