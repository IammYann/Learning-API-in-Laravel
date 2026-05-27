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
        
        .product-category {
            background: #667eea;
            color: white;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 0.75em;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 8px;
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

        .product-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 8px;
        }

        .product-tag {
            background: #ff6b6b;
            color: white;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 0.7em;
            font-weight: 600;
        }

        .tags-section {
            margin: 15px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-height: 150px;
            overflow-y: auto;
        }

        .tags-section label {
            display: flex;
            align-items: center;
            margin: 5px 0;
            font-weight: 400;
        }

        .tags-section input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
        }

        .filter-section {
            margin-bottom: 15px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 5px;
        }

        .filter-section label {
            margin-bottom: 8px;
        }

        .filter-tag-btn {
            background: #667eea;
            color: white;
            padding: 5px 12px;
            border: none;
            border-radius: 15px;
            font-size: 0.85em;
            cursor: pointer;
            margin: 3px;
            transition: background 0.3s;
        }

        .filter-tag-btn.active {
            background: #ff6b6b;
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
    <!-- User Profile Header -->
    <div style="background: white; padding: 15px 0; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center;">
            <div id="userProfile" style="display: none; font-weight: 600; color: #333;">
                👤 <span id="profileName"></span>
            </div>
            <button id="logoutBtn" style="display: none; background: #dc3545; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: 600;" onclick="logout()">
                Logout
            </button>
        </div>
    </div>

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

                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select id="category_id" name="category_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                            <option value="">-- Select Category --</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tags</label>
                        <div class="tags-section" id="tagsSection">
                            <p style="color: #999; text-align: center;">Loading tags...</p>
                        </div>
                    </div>

                    <button type="submit">Add Product</button>
                </form>
            </div>

            <!-- Products List Section -->
            <div class="products-section">
                <h2>Products List</h2>
                <div class="filter-section" id="filterSection">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Filter by Tag:</label>
                    <button class="filter-tag-btn active" onclick="filterByTag(null)">All</button>
                    <div id="filterTagsContainer"></div>
                </div>
                <div id="productsList" class="loading">Loading products...</div>
            </div>
        </div>
    </div>

    <script>
        const API_URL = 'http://127.0.0.1:8000/api/products';
        const CATEGORIES_URL = 'http://127.0.0.1:8000/api/categories';
        const TAGS_URL = 'http://127.0.0.1:8000/api/tags';
        const form = document.getElementById('productForm');
        const productsList = document.getElementById('productsList');
        const messageDiv = document.getElementById('message');
        
        let categories = [];
        let tags = [];
        let allProducts = [];
        let selectedTagFilter = null;
        let isEditMode = false;
        let editingId = null;

        // === AUTH CHECK ===
        function getAuthToken() {
            return localStorage.getItem('auth_token');
        }

        function getAuthUser() {
            const user = localStorage.getItem('auth_user');
            return user ? JSON.parse(user) : null;
        }

        function showUserProfile() {
            const user = getAuthUser();
            if (user) {
                document.getElementById('userProfile').style.display = 'block';
                document.getElementById('profileName').textContent = user.name;
                document.getElementById('logoutBtn').style.display = 'block';
            }
        }

        async function logout() {
            const token = getAuthToken();
            try {
                await fetch('http://127.0.0.1:8000/api/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });
            } catch (error) {
                console.error('Logout error:', error);
            }
            
            localStorage.removeItem('auth_token');
            localStorage.removeItem('auth_user');
            window.location.href = '/auth';
        }

        // Check auth on page load
        window.addEventListener('DOMContentLoaded', () => {
            const token = getAuthToken();
            if (!token) {
                window.location.href = '/auth';
                return;
            }
            showUserProfile();
            loadInitialData();
        });

        function fetchWithAuth(url, options = {}) {
            const token = getAuthToken();
            const headers = {
                'Content-Type': 'application/json',
                ...(options.headers || {})
            };
            if (token) {
                headers['Authorization'] = `Bearer ${token}`;
            }
            return fetch(url, { ...options, headers });
        }

        // Load categories
        async function loadCategories() {
            try {
                const response = await fetchWithAuth(CATEGORIES_URL);
                const CategoriesData = await response.json();
                categories = Array.isArray(CategoriesData) ? CategoriesData : CategoriesData.data;
                const select = document.getElementById('category_id');
                select.innerHTML = '<option value="">-- Select Category --</option>';
                categories.forEach(cat => {
                    const opt = document.createElement('option');
                    opt.value = cat.id;
                    opt.textContent = cat.name;
                    select.appendChild(opt);
                });
            } catch (error) {
                console.error('Error loading categories:', error);
            }
        }

        // Load tags
        async function loadTags() {
            try {
                const response = await fetchWithAuth(TAGS_URL);
                const tagsData = await response.json();
                tags = Array.isArray(tagsData) ? tagsData : tagsData.data;                
                // Populate tags checkboxes
                const tagsSection = document.getElementById('tagsSection');
                tagsSection.innerHTML = tags.map(tag => `
                    <label>
                        <input type="checkbox" name="tags" value="${tag.id}">
                        ${tag.name}
                    </label>
                `).join('');

                // Populate filter buttons
                const filterContainer = document.getElementById('filterTagsContainer');
                filterContainer.innerHTML = tags.map(tag => `
                    <button class="filter-tag-btn" onclick="filterByTag(${tag.id})" data-tag="${tag.id}">
                        ${tag.name}
                    </button>
                `).join('');
            } catch (error) {
                console.error('Error loading tags:', error);
            }
        }

        function getCategoryName(id) {
            const cat = categories.find(c => c.id == id);
            return cat ? cat.name : 'Uncategorized';
        }

        function getTagName(id) {
            const tag = tags.find(t => t.id == id);
            return tag ? tag.name : 'Unknown';
        }

        // Load products
        async function loadProducts() {
            try {
                const response = await fetchWithAuth(API_URL);
                const data = await response.json();
                allProducts = Array.isArray(data) ? data : data.data;                
                displayProducts(allProducts);
            } catch (e) {
                productsList.innerHTML = `<div class="error">Error: ${e.message}</div>`;
            }
        }

        // Display products with optional filter
        function displayProducts(productsToShow) {
            if (productsToShow.length === 0) {
                productsList.innerHTML = '<div class="empty-message">No products found!</div>';
                return;
            }
            
            productsList.innerHTML = productsToShow.map(p => `
                <div class="product-item">
                    <div class="product-info">
                        <div class="product-name">${p.name}</div>
                        ${p.category_id ? `<div class="product-category">${getCategoryName(p.category_id)}</div>` : ''}
                        ${p.tags && p.tags.length > 0 ? `
                            <div class="product-tags">
                                ${p.tags.map(tag => `<span class="product-tag">${tag.name}</span>`).join('')}
                            </div>
                        ` : ''}
                        <div class="product-description">${p.description}</div>
                        <div class="product-price">$${parseFloat(p.price).toFixed(2)}</div>
                    </div>
                    <div class="product-actions">
                        <button class="edit-btn" onclick="editProduct(${p.id})">Edit</button>
                        <button class="delete-btn" onclick="deleteProduct(${p.id})">Delete</button>
                    </div>
                </div>
            `).join('');
        }

        // Filter products by tag
        function filterByTag(tagId) {
            selectedTagFilter = tagId;
            
            // Update button styles
            document.querySelectorAll('.filter-tag-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            if (tagId === null) {
                document.querySelector('.filter-tag-btn[onclick="filterByTag(null)"]')?.classList.add('active');
            } else {
                document.querySelector(`.filter-tag-btn[data-tag="${tagId}"]`)?.classList.add('active');
            }

            // Filter and display
            if (tagId === null) {
                displayProducts(allProducts);
            } else {
                const filtered = allProducts.filter(p => 
                    p.tags && p.tags.some(t => t.id == tagId)
                );
                displayProducts(filtered);
            }
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const selectedTags = Array.from(document.querySelectorAll('input[name="tags"]:checked'))
                .map(cb => parseInt(cb.value));
            
            const data = {
                name: document.getElementById('name').value,
                description: document.getElementById('description').value,
                price: parseFloat(document.getElementById('price').value)
            };
            
            const catId = document.getElementById('category_id').value;
            if (catId) data.category_id = catId;
            if (selectedTags.length > 0) data.tags = selectedTags;

            try {
                const method = isEditMode ? 'PUT' : 'POST';
                const url = isEditMode ? `${API_URL}/${editingId}` : API_URL;
                const res = await fetchWithAuth(url, {
                    method, 
                    body: JSON.stringify(data)
                });
                if (res.ok) {
                    showMessage(isEditMode ? 'Updated!' : 'Added!', 'success');
                    form.reset();
                    isEditMode = false;
                    editingId = null;
                    form.querySelector('button').textContent = 'Add Product';
                    // Clear tag checkboxes
                    document.querySelectorAll('input[name="tags"]').forEach(cb => cb.checked = false);
                    loadProducts();
                }
            } catch (e) {
                showMessage(`Error: ${e.message}`, 'error');
            }
        });

        function editProduct(id) {
            const product = allProducts.find(p => p.id == id);
            if (!product) return;

            isEditMode = true;
            editingId = id;
            
            document.getElementById('name').value = product.name;
            document.getElementById('description').value = product.description;
            document.getElementById('price').value = product.price;
            document.getElementById('category_id').value = product.category_id || '';
            
            // Set tag checkboxes
            document.querySelectorAll('input[name="tags"]').forEach(cb => {
                cb.checked = product.tags && product.tags.some(t => t.id == cb.value);
            });
            
            form.querySelector('button').textContent = 'Update Product';
            window.scrollTo(0, 0);
        }

        async function deleteProduct(id) {
            if (!confirm('Delete this product?')) return;
            try {
                const res = await fetchWithAuth(`${API_URL}/${id}`, { method: 'DELETE' });
                if (res.ok) {
                    showMessage('Deleted!', 'success');
                    loadProducts();
                }
            } catch (e) {
                showMessage(`Error: ${e.message}`, 'error');
            }
        }

        function showMessage(text, type) {
            messageDiv.innerHTML = `<div class="${type}">${text}</div>`;
            setTimeout(() => messageDiv.innerHTML = '', 3000);
        }

        function loadInitialData() {
            loadCategories();
            loadTags();
            loadProducts();
        }
    </script>
</body>
</html>
