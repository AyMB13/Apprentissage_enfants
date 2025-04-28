// mainapp.js
function searchItems() {
    let input = document.getElementById('searchInput').value.toLowerCase();
    let categories = document.querySelectorAll('.category-card');

    categories.forEach(function (category) {
        let title = category.querySelector('h3').textContent.toLowerCase();
        if (title.indexOf(input) > -1) {
            category.style.display = '';
        } else {
            category.style.display = 'none';
        }
    });
}

function loadCategory(categoryId) {
    
    window.location.href = 'category.php?id=' + categoryId;
}
