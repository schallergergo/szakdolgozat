@component('mail::message')
# {{__("New result is available")}}<br><br>

**{{__("Rider")}}**: {{$result->rider_name}}<br>
**{{__("Horse")}}**: {{$result->horse_name}}<br>
**{{__("Event")}}**: {{$result->event->eventname}}<br>
**{{__("Venue")}}**: {{$result->event->venue}}<br>
**{{__("Date")}}**: {{$result->event->date}}<br>
**{{__("Judge")}}**: {{$result->event->judge}}<br>
@component('mail::button', ['url' => "http://szakdolgozat.schallergergo.hu/result/show/".$result->id])
{{__("View result")}}
@endcomponent

{{__("Regards")}},<br>
{{ config('app.name') }}
@endcomponent