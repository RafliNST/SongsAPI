<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="/api/songs" method="post">
        @csrf
        <input type="text" name="title" id="" placeholder="judul lagu">
        <br>
        <input type="text" name="cover" id="" placeholder="cover lagu">
        <br>
        <input type="date" name="released_date" id="">
        <br>
        <select name="album_id" id="">
            @foreach ($albums as $album)
            <option value="{{ $album->id }}">
                {{ $album->title }}
            </option>
            @endforeach
        </select>
        <br>
        <select name="artists[]" id="">
            @foreach ($artists as $artist)
            <option value="{{ $artist->id }}">
                {{ $artist->name }}
            </option>
            @endforeach
        </select>
        <br>

        <input type="submit" value="kirim data">
    </form>
</body>
</html>