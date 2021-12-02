<!DOCTYPE html>
<html>
<head>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('New event') }}</div>

                <div class="card-body">
                	<form action="{{url('')}}" target="_blank">
                    <h3>Hello {{$result->rider_name}}!</h3>
                    <p>New result is available:</p>
                    <p>Venue: {{$result->event->venue}}</p>
                    <p>Date: {{$result->event->date}}</p>
                    <button type="submit" class="btn btn-secondary btn-lg">Large button</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


