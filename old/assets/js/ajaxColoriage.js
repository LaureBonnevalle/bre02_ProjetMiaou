/*document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.querySelector('select[name="categorie_id"]');
    const coloriagesContainer = document.getElementById('coloriages-container');

    selectElement.addEventListener('change', function() {
        const categorieId = this.value;

        fetch(`/path/to/getColoriagesByCategorie/${categorieId}`)
            .then(response => response.json())
            .then(coloriages => {
                coloriagesContainer.innerHTML = ''; // Clear the container

                coloriages.forEach(coloriage => {
                    const coloriageElement = document.createElement('div');
                    coloriageElement.innerHTML = `
                        <a href="${coloriage.url}" download="${coloriage.name}.pdf">${coloriage.name}</a>
                        <img src="${coloriage.thumbnail_url}" alt="${coloriage.name}">
                    `;
                    coloriagesContainer.appendChild(coloriageElement);
                });
            })
            .catch(error => console.error('Error:', error));
    });
});*/

document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.getElementById('categorie-select');
    const fetchButton = document.getElementById('fetch-coloriages');
    const coloriagesList = document.getElementById('coloriages-list');
    const previewSection = document.getElementById('preview-section');

    fetchButton.addEventListener('click', function() {
        const categorieId = selectElement.value;

        fetch(`/index.php?route=coloriagesListe&categorie_id=${categorieId}`)
            .then(response => response.json())
            .then(coloriages => {
                coloriagesList.innerHTML = ''; // Clear the list

                coloriages.forEach(coloriage => {
                    const coloriageElement = document.createElement('li');
                    coloriageElement.textContent = coloriage.name;
                    coloriageElement.setAttribute('data-url', coloriage.url);
                    coloriageElement.setAttribute('data-id', coloriage.id);
                    coloriageElement.addEventListener('click', function() {
                        showPreview(coloriage.url, coloriage.id);
                    });
                    coloriagesList.appendChild(coloriageElement);
                });
            })
            .catch(error => console.error('Error:', error));
    });

    function showPreview(url, id) {
        previewSection.innerHTML = `
            <a href="${url}" download>Télécharger</a>
            <div class="progress-bar" id="progress-bar"></div>
            <img src="path/to/thumbnails/${id}.jpg" alt="Aperçu du coloriage">
        `;

        const downloadLink = previewSection.querySelector('a');
        const progressBar = document.getElementById('progress-bar');

        downloadLink.addEventListener('click', function(e) {
            e.preventDefault();

            const xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.responseType = 'blob';

            xhr.onprogress = function(event) {
                if (event.lengthComputable) {
                    const percentComplete = (event.loaded / event.total) * 100;
                    progressBar.style.width = `${percentComplete}%`;
                }
            };

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const blob = xhr.response;
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = `${id}.pdf`;
                    link.click();
                }
            };

            xhr.send();
        });
    }
});