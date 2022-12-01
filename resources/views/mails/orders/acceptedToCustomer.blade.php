Ваш заказ на <a href="{{route('events.show', $order->event->id)}}">мероприятие</a> одобрен организатором.<br>
<br>
Адрес: г {{$order->event->city_name}}, {{$order->event->full_street}}, д {{$order->event->building}}<br>
Время начала: {{$order->event->start_date}} {{$order->event->start_time}}<br>
Телефон для связи с организатором: {{$order->event->formated_phone}}<br>
<br>
Для прохода на мероприятие назовите организатору код:<br>
{{$order->code}}

