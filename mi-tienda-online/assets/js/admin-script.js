document.getElementById('user-search').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    const users = document.querySelectorAll('#user-list li');
    
    users.forEach(user => {
        const name = user.querySelector('span').textContent.toLowerCase();
        if (name.includes(searchValue)) {
            user.style.display = '';
        } else {
            user.style.display = 'none';
        }
    });
});

document.getElementById('product-search').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    const products = document.querySelectorAll('#product-list li');
    
    products.forEach(product => {
        const productText = product.textContent.toLowerCase();
        if (productText.includes(searchValue)) {
            product.style.display = '';
        } else {
            product.style.display = 'none';
        }
    });
});
