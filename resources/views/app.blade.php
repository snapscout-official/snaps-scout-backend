<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
  {{-- @vite('resources/css/app.css') --}}
</head>
<body>
  <table class="table table-bordered mb-5">
    <thead>
        <tr class="table-danger">
            <th scope="col">Product Name</th>
            <th scope="col">Spec Name</th>
            <th scope="col">Spec Value</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            @php
              $counter = 0;
            @endphp
            @foreach($product->specs as $spec)
                
                  @foreach($spec->values as $value)
                    <tr>
                        @if($counter === 0 )
                            <td rowspan="{{ count($product->specs) * count($spec->values) }}">{{ $product->product_name }}</td>
                        @endif
                        @if($loop->index === 0 )
                            <td rowspan="{{ count($spec->values) }}">{{ $spec->specs_name }}</td>
                        @endif
                        <td>{{ $value->spec_value }}</td>
                      </tr>
                      @php
                          $counter+=1;
                      @endphp
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>

</body>
</html>