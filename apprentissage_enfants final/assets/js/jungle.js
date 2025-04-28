function startApp() {
    document.getElementById('welcome-screen').style.display = 'none';
    document.getElementById('main-app').style.display = 'block';
}

function loadCategory(categoryId) {
    fetch(`api/get_items.php?category_id=${categoryId}`)
        .then(response => response.json())
        .then(items => {
            let html = '<div class="items-grid">';
            
            items.forEach(item => {
                html += `
                <div class="item-card">
                    <h3>${item.nom}</h3>
                    ${item.image_path ? `<img src="assets/images/${item.image_path}" alt="${item.nom}">` : ''}
                    <p>${item.description}</p>
                    ${item.audio_path ? `<audio controls src="assets/audio/${item.audio_path}"></audio>` : ''}
                </div>
                `;
            });
            
            html += '</div>';
            document.getElementById('content-display').innerHTML = html;
        });
}

function searchItems() {
    const term = document.getElementById('searchInput').value;
    if(term.trim() === '') return;
    
    fetch(`api/search.php?q=${encodeURIComponent(term)}`)
        .then(response => response.json())
        .then(results => {
            let html = '<h2>Résultats de recherche</h2><div class="search-results">';
            
            results.forEach(item => {
                html += `
                <div class="result-card">
                    <h3>${item.nom}</h3>
                    <p>Catégorie: ${item.categorie_nom}</p>
                </div>
                `;
            });
            
            document.getElementById('content-display').innerHTML = html + '</div>';
        });
}