document.addEventListener('DOMContentLoaded', () => {
    // Initialize cart count display on every page
    updateCartCount();

    // Use event delegation for dynamically loaded buttons
    document.body.addEventListener('click', (e) => {
        const addToCartBtn = e.target.closest('.add-to-cart');
        if (addToCartBtn) {
            e.preventDefault();
            addToCart(addToCartBtn.dataset.id);
        }

        const rmFromCartBtn = e.target.closest('.remove-from-cart');
        if (rmFromCartBtn) {
            e.preventDefault();
            removeFromCart(rmFromCartBtn.dataset.id);
        }
    });
});

async function loadProducts() {
    const grid = document.getElementById('product-grid');
    if (!grid) return;
    
    try {
        const res = await fetch('api_products.php');
        const data = await res.json();
        
        if (data.success && data.products.length > 0) {
            grid.innerHTML = data.products.map(p => `
                <article class="card">
                    <a href="product.html?id=${p.id}">
                        <img src="${p.image}" alt="${p.name}" class="card-img" loading="lazy">
                    </a>
                    <div class="card-body">
                        <a href="product.html?id=${p.id}">
                            <h3 class="card-title">${p.name}</h3>
                        </a>
                        <p class="card-price">₹${parseFloat(p.price).toLocaleString('en-IN', {minimumFractionDigits: 2})}</p>
                        <button class="btn add-to-cart" data-id="${p.id}">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                </article>
            `).join('');
        } else {
            grid.innerHTML = '<p class="text-danger" style="grid-column: 1/-1; text-align: center;">No products found.</p>';
        }
    } catch (err) {
        grid.innerHTML = '<p class="text-danger" style="grid-column: 1/-1; text-align: center;">Failed to load products API. Ensure database is connected.</p>';
        console.error(err);
    }
}

async function loadProductDetails() {
    const container = document.getElementById('product-container');
    if (!container) return;
    
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');
    if (!id) {
        container.innerHTML = '<p class="text-danger text-center w-100 mt-3">Product ID not supplied. <br><a href="index.html" class="btn mt-3">Go Back</a></p>';
        return;
    }
    
    try {
        const res = await fetch(`api_product.php?id=${id}`);
        const data = await res.json();
        
        if (data.success && data.product) {
            const p = data.product;
            container.innerHTML = `
                <div class="product-details">
                    <div class="product-image-container">
                        <img src="${p.image}" alt="${p.name}" class="product-large-image">
                    </div>
                    <div class="product-info">
                        <h1 class="product-title">${p.name}</h1>
                        <p class="product-price">₹${parseFloat(p.price).toLocaleString('en-IN', {minimumFractionDigits: 2})}</p>
                        <p class="product-desc">${p.description.replace(/\n/g, '<br>')}</p>
                        <button class="btn btn-large add-to-cart" data-id="${p.id}" style="margin-top: 1rem;">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                        <a href="index.html" class="btn-secondary mt-3">
                            <i class="fas fa-arrow-left"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            `;
        } else {
             container.innerHTML = `<p class="text-danger text-center w-100 mt-3">${data.message || 'Product not found'}. <br><a href="index.html" class="btn mt-3">Go Back</a></p>`;
        }
    } catch (err) {
        container.innerHTML = '<p class="text-danger text-center w-100 mt-3">Failed to load product details API.</p>';
        console.error(err);
    }
}

async function loadCart() {
    const container = document.getElementById('cart-container');
    if (!container) return;
    
    try {
        const res = await fetch('ajax_cart.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({action: 'get_cart'})
        });
        const data = await res.json();
        
        if (data.success) {
            if (data.cart.length === 0) {
                 container.innerHTML = `
                    <h1 class="section-title">Your Shopping Cart</h1>
                    <div class="empty-cart text-center">
                        <i class="fas fa-shopping-basket fa-4x text-light mb-3"></i>
                        <h2>Your cart is empty</h2>
                        <p class="text-light">Looks like you haven't added any items to your cart yet.</p>
                        <a href="index.html" class="btn btn-large mt-3">Start Shopping</a>
                    </div>
                 `;
            } else {
                 const itemsHtml = data.cart.map(item => `
                    <div class="cart-item">
                        <img src="${item.image}" alt="${item.name}" class="cart-img">
                        <div class="cart-item-details">
                            <h3>${item.name}</h3>
                            <p class="text-light">
                                ₹${parseFloat(item.price).toLocaleString('en-IN', {minimumFractionDigits: 2})} &times; ${item.quantity}
                            </p>
                            <p class="font-bold text-primary mt-3">
                                ₹${parseFloat(item.subtotal).toLocaleString('en-IN', {minimumFractionDigits: 2})}
                            </p>
                        </div>
                        <button class="btn-danger remove-from-cart" data-id="${item.id}" title="Remove Item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                 `).join('');
                 
                 container.innerHTML = `
                    <h1 class="section-title">Your Shopping Cart</h1>
                    <div class="cart-layout">
                        <div class="cart-items">
                            ${itemsHtml}
                        </div>
                        <div class="cart-summary">
                            <h3>Order Summary</h3>
                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span>₹${parseFloat(data.total).toLocaleString('en-IN', {minimumFractionDigits: 2})}</span>
                            </div>
                            <div class="summary-row">
                                <span>Estimated Shipping</span>
                                <span class="text-primary font-bold">FREE</span>
                            </div>
                            <div class="summary-total">
                                <span>Total</span>
                                <span>₹${parseFloat(data.total).toLocaleString('en-IN', {minimumFractionDigits: 2})}</span>
                            </div>
                            <button class="btn btn-block btn-large mt-3" onclick="alert('Proceeding to Checkout! This is a demo template.')">
                                <i class="fas fa-lock"></i> Proceed to Checkout
                            </button>
                            <a href="index.html" class="btn-secondary btn-block mt-3 text-center">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                 `;
            }
        }
    } catch (err) {
        container.innerHTML = '<p class="text-danger text-center w-100 mt-3">Failed to load cart data.</p>';
        console.error(err);
    }
}

async function addToCart(productId) {
    try {
        const res = await fetch('ajax_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'add', product_id: productId })
        });
        const data = await res.json();
        
        if (data.success) {
            updateCartCountDisplay(data.count);
            showToast(`<i class="fas fa-check-circle"></i> ${data.message}`);
        }
    } catch (err) {
        console.error('Error adding to cart', err);
        showToast(`<i class="fas fa-exclamation-triangle"></i> Failed to add to cart`);
    }
}

async function removeFromCart(productId) {
    try {
        const res = await fetch('ajax_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'remove', product_id: productId })
        });
        const data = await res.json();
        
        if (data.success) {
            // Re-render the cart dynamically without reloading
            if (document.getElementById('cart-container')) {
                loadCart();
                updateCartCountDisplay(data.count);
            }
        }
    } catch (err) {
        console.error('Error removing from cart', err);
    }
}

async function updateCartCount() {
    try {
        const res = await fetch('ajax_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'get_count' })
        });
        const data = await res.json();
        if (data.success) {
            updateCartCountDisplay(data.count);
        }
    } catch (err) {
        console.error('Error fetching cart count', err);
    }
}

function updateCartCountDisplay(count) {
    const badges = document.querySelectorAll('.cart-count');
    badges.forEach(badge => {
        badge.textContent = count;
        badge.classList.remove('pulse');
        void badge.offsetWidth; // Reflow forcing
        badge.classList.add('pulse');
    });
}

let toastTimeout;
function showToast(messageHtml) {
    let toast = document.getElementById('toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'toast';
        document.body.appendChild(toast);
    }
    
    toast.innerHTML = messageHtml;
    toast.classList.add('show');
    
    clearTimeout(toastTimeout);
    toastTimeout = setTimeout(() => { 
        toast.classList.remove('show'); 
    }, 3000);
}
