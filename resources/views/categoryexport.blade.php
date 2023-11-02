<table>
    <tr> <td colspan="4">Project Procurement Management Plan</td></tr>
    <thead>

        <tr>
            <th>Code</th>
            <th>General Description</th>
            <th>Unit of Measure</th>
            <th>Quantity/Size</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $categoryName => $category)
            <tr>
                <td colspan="4">Category Name: {{ ucfirst($categoryName) }}</td>
            </tr>    
            @foreach ($category as $key => $item)
                @if ($key === 'products')
                    @foreach ($item as $product)
                        <tr>
                            <td>{{ $product[0] }}</td>
                            <td>{{ $product[1] }}</td>
                            <td>{{ $product[2] }}</td>
                            <td>{{ $product[3] }}</td>
                        </tr>
                    @endforeach
                    @continue
                @endif
                <tr><td colspan="4">Sub Total: {{ $item }}</td></tr>
            @endforeach
        @endforeach
    </tbody>
</table>