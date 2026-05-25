<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Manager</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5em;
        }

        .content {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            height: fit-content;
        }

        .form-section h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 1.5em;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.5);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #5568d3;
        }

        button.delete-btn {
            background: #dc3545;
            width: auto;
            padding: 8px 15px;
            font-size: 14px;
        }

        button.delete-btn:hover {
            background: #c82333;
        }

        button.edit-btn {
            background: #ffc107;
            color: #333;
            width: auto;
            padding: 8px 15px;
            font-size: 14px;
        }

        button.edit-btn:hover {
            background: #e0a800;
        }

        .products-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .products-section h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 1.5em;
        }

        .product-item {
            background: #f9f9f9;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-size: 1.2em;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .product-description {
            color: #666;
            font-size: 0.95em;
            margin-bottom: 10px;
        }

        .product-price {
            color: #667eea;
            font-size: 1.3em;
            font-weight: 700;
        }

        .product-actions {
            display: flex;
            gap: 10px;
            margin-left: 20px;
        }

        .empty-message {
            text-align: center;
            color: #999;
            padding: 40px 20px;
            font-size: 1.1em;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
        }

        .loading {
            text-align: center;
            color: #667eea;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .content {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 1.8em;
            }

            .product-item {
                flex-direction: column;
            }

            .product-actions {
                margin-left: 0;
                margin-top: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📦 Product Manager</h1>

        <div class="content">
            <!-- Form Section -->
            <div class="form-section">
                <h2>Add Product</h2>
                <div id="message"></div>
                <form id="productForm">
                    <div class="form-group">
                        <label for="name">Product Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description *</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">Price *</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" required>
                    </div>

                    <button type="submit">Add Product</button>
                </form>
            </div>

            <!-- Products List Section -->
            <div class="products-section">
                <h2>Products List</h2>
                <div id="productsList" class="loading">Loading products...</div>
            </div>
        </div>
    </div>

    <script>
        const API_URL = 'http://127.0.0.1:8000/api/products';
        const form = document.getElementById('productForm');
        const productsList = document.getElementById('productsList');
        const messageDiv = document.getElementById('message');

        // Fetch and display products
        async function loadProducts() {
            try {
                const response = await fetch(API_URL);
                const products = await response.json();

                if (products.length === 0) {
                    productsList.innerHTML = '<div class="empty-message">No products yet. Add one to get started!</div>';
                    return;
                }

                productsList.innerHTML = products.map(product => `
                    <div class="product-item">
                        <div class="product-info">
                            <div class="product-name">${product.name}</div>
                            <div class="product-description">${product.description}</div>
                            <div class="product-price">$${parseFloat(product.price).toFixed(2)}</div>
                        </div>
                        <div class="product-actions">
                            <button class="edit-btn" onclick="editProduct(${product.id}, '${product.name}', '${product.description}', ${product.price})">Edit</button>
                            <button class="delete-btn" onclick="deleteProduct(${product.id})">Delete</button>
                        </div>
                    </div>
                `).join('');
            } catch (error) {
                productsList.innerHTML = `<div class="error">Error loading products: ${error.message}</div>`;
            }
        }

        // Add product
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const data = {
                name: document.getElementById('name').value,
                description: document.getElementById('description').value,
                price: parseFloat(document.getElementById('price').value)
            };

            try {
                let response;
                if (isEditMode) {
                    // UPDATE existing product
                    response = await fetch(`${API_URL}/${editingId}`, {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(data)
                    });
                } else {
                    // CREATE new product
                    response = await fetch(API_URL, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(data)
                    });
                }

                if (response.ok) {
                    const message = isEditMode ? 'Product updated successfully!' : 'Product added successfully!';
                    showMessage(message, 'success');
                    form.reset();
                    isEditMode = false;
                    editingId = null;
                    form.querySelector('button').textContent = 'Add Product';
                    loadProducts();
                } else {
                    const errors = await response.json();
                    showMessage(`Error: ${JSON.stringify(errors.errors)}`, 'error');
                }
            } catch (error) {
                showMessage(`Error: ${error.message}`, 'error');
            }
        });

        // Edit product
        let isEditMode = false;
        let editingId = null;

        function editProduct(id, name, description, price) {
            isEditMode = true;
            editingId = id;

            document.getElementById('name').value = name;
            document.getElementById('description').value = description;
            document.getElementById('price').value = price;

            // Change form to update mode
            const submitBtn = form.querySelector('button');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Update Product';

            form.onsubmit = async (e) => {
                e.preventDefault();

                const data = {
                    name: document.getElementById('name').value,
                    description: document.getElementById('description').value,
                    price: parseFloat(document.getElementById('price').value)
                };

                try {
                    const response = await fetch(`${API_URL}/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });

                    if (response.ok) {
                        showMessage('Product updated successfully!', 'success');
                        form.reset();
                        submitBtn.textContent = originalText;
                        form.onsubmit = null;
                        loadProducts();
                    } else {
                        showMessage('Error updating product', 'error');
                    }
                } catch (error) {
                    showMessage(`Error: ${error.message}`, 'error');
                }
            };

            window.scrollTo(0, 0);
        }

        // Delete product
        async function deleteProduct(id) {
            if (!confirm('Are you sure you want to delete this product?')) return;

            try {
                const response = await fetch(`${API_URL}/${id}`, {
                    method: 'DELETE'
                });

                if (response.ok) {
                    showMessage('Product deleted successfully!', 'success');
                    loadProducts();
                } else {
                    showMessage('Error deleting product', 'error');
                }
            } catch (error) {
                showMessage(`Error: ${error.message}`, 'error');
            }
        }

        // Show message
        function showMessage(text, type) {
            messageDiv.innerHTML = `<div class="${type}">${text}</div>`;
            setTimeout(() => {
                messageDiv.innerHTML = '';
            }, 3000);
        }

        // Load products on page load
        loadProducts();
    </script>
</body>
</html>
