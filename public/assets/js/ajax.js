function changeManagement(e) {
    let usersManagement = document.querySelector('.users-management');
    let productsManagement = document.querySelector('.products-management');
    let categoriesManagement = document.querySelector('.categories-management');
    if (e.innerHTML == 'Products') {
        usersManagement.style.display = 'none';
        productsManagement.style.display = 'block';
        categoriesManagement.style.display = 'none';
    } else if (e.innerHTML == 'Categories') {
        usersManagement.style.display = 'none';
        productsManagement.style.display = 'none';
        categoriesManagement.style.display = 'block';
    } else if (e.innerHTML == 'Users') {
        usersManagement.style.display = 'block';
        productsManagement.style.display = 'none';
        categoriesManagement.style.display = 'none';
    }
}