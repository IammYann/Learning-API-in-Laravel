<h2>New Product Added! 📦</h2>

<p><strong>Product Name:</strong> {{ $product->name }}</p>
<p><strong>Description:</strong> {{ $product->description }}</p>
<p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>

@if($product->category)
    <p><strong>Category:</strong> {{ $product->category->name }}</p>
@endif

@if($product->tags->count() > 0)
    <p><strong>Tags:</strong> 
        @foreach($product->tags as $tag)
            <span style="background: #ff6b6b; color: white; padding: 2px 8px; border-radius: 3px; margin: 2px;">
                {{ $tag->name }}
            </span>
        @endforeach
    </p>
@endif

<p>Regards,<br>Product Manager Team</p>