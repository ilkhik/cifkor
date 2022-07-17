<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h4>Группы товаров</h4>
        <ul>
            @if ($groupId !== 0)
            <a href="?group={{$parentGroup->id_parent}}">&#8592; {{$parentGroup->name}}</a>
            <br><br>
            @endif
            @foreach ($groups as $group)
            <li><a href="?group={{$group->id}}">{{$group->name}}({{$group->amount}})</a></li>
            @endforeach
        </ul>

        <h4>Товары</h4>
        <ul>
            @foreach ($products as $product)
            <li>{{$product->name}}</li>
            @endforeach
        </ul>
    </body>
</html>
