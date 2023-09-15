<h1>
    Создан новый заказ
</h1>

<table>
    @if($forAdmin)
    <tr >
        <th>Номер заказа</th>
        <td>
            Заказ №{{$order->id}}
        </td>
    </tr>
    @endif

    <tr>
        <th>Дата</th>
        <td>{{$order->created_at}}</td>
    </tr>
    <tr>
        <th>Информация о доставке</th>
        <td>{!! $order->order_details !!}</td>
    </tr>
</table>
<table class="text-center">
    <tr>
        <th colspan="2" width="50%">Товар</th>
        <th>Цена</th>
        <th>Кол-во</th>
    </tr>
    @foreach($order->items as $item)
        <tr>
            <td>
                <img src="{{$item->product->img_small}}" style="width: 100px">
            </td>
            <td>{{$item->product->title}}</td>
            <td> &#8381; {{$item->unit_price * $item->quantity}}</td>
            <td>{{$item->quantity}} шт.</td>
        </tr>
    @endforeach
</table>
