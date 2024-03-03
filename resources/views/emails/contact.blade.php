<!DOCTYPE html>
<html>
<head>
    <title>Контактные данные</title>
</head>
<body>
    <h1>Контактные данные</h1>
    <p>ФИО: {{ $formData['name'] }}</p>
    <p>Пол: {{ $formData['gender']}}</p>
    <p>Возраст: {{ $formData['age'] }}</p>
    <p>Дата рождения: {{ $formData['date'] }}</p>
    <p>Номер телефона: {{ $formData['phone'] }}</p>
    <p>Почта: {{ $formData['email'] }}</p>
</body>
</html>