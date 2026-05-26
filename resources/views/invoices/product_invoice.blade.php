<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial; margin: 20px; }
        .invoice-header { text-align: center; margin-bottom: 30px; }
        .invoice-details { margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>📋 Product Invoice</h1>
        <p>Invoice #{{ $product->id }} - Date: {{ now()->format('Y-m-d') }}</p>
    </div>

    <div class="invoice-details">
        <h3>Product Details</h3>
        <table>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Product Name</td>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <td>Description</td>
                <td>{{ $product->description }}</td>
            </tr>
            <tr>
                <td>Price</td>
                <td>${{ number_format($product->price, 2) }}</td>
            </tr>
            @if($product->category)
            <tr>
                <td>Category</td>
                <td>{{ $product->category->name }}</td>
            </tr>
            @endif
        </table>

        @if($product->tags->count() > 0)
        <h3>Tags</h3>
        <p>
            @foreach($product->tags as $tag)
                <span style="background: #ff6b6b; color: white; padding: 3px 8px; border-radius: 3px; margin: 2px;">
                    {{ $tag->name }}
                </span>
            @endforeach
        </p>
        @endif
    </div>

    <div style="margin-top: 30px; border-top: 1px solid #ddd; padding-top: 10px;">
        <p><small>Generated on {{ now()->format('Y-m-d H:i:s') }}</small></p>
    </div>
</body>
</html>