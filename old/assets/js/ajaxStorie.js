document.addEventListener('DOMContentLoaded', function() {
    const personnageSelect = document.querySelector('select[name="personnage_id"]');
    const lieuSelect = document.querySelector('select[name="lieu_id"]');
    const objetSelect = document.querySelector('select[name="objet_id"]');
    const personnageImageDiv = document.getElementById('personnage-image');
    const objetImageDiv = document.getElementById('objet-image');
    const lieuImageDiv = document.getElementById('lieu-image');
    const storySection = document.querySelector('story-section'); // Ajouter cette ligne

    // Observe le changement sur le select personnage
    personnageSelect.addEventListener('change', function() {
        const personnageId = this.value;
        fetch(`?route=getImage&entity=personnage&id=${personnageId}`)
            .then(response => response.json())
            .then(data => {
                personnageImageDiv.innerHTML = `<img src="${data}" alt="Image de personnage">`;
                fetchStory();
            })
            .catch(error => console.error('Error:', error));
    });

    // Observe le changement sur le select objet
    objetSelect.addEventListener('change', function() {
        const objetId = this.value;
        fetch(`?route=getImage&entity=objet&id=${objetId}`)
       
            .then(response => response.json())
            .then(data => {
                objetImageDiv.innerHTML = `<img src="${data}" alt="Image d'objet">`;
                fetchStory();
            })
            .catch(error => console.error('Error:', error));
    });

    // Observe le changement sur le select lieu
    lieuSelect.addEventListener('change', function() {
        const lieuId = this.value;
        fetch(`?route=getImage&entity=lieu&id=${lieuId}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                lieuImageDiv.innerHTML = `<img src="${data}" alt="Image de lieu">`;
                fetchStory();
            })
            .catch(error => console.error('Error:', error));
    });

    function fetchStory() {
        const personnageId = personnageSelect.value;
        const objetId = objetSelect.value;
        const lieuId = lieuSelect.value;
        console.log(personnageId);
        console.log(objetId);
        console.log(lieuId);

       if (personnageId && objetId && lieuId) {
            fetch(`?route=getHistoire`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    personnage_id: personnageId,
                    objet_id: objetId,
                    lieu_id: lieuId
                })
                
            })
            .then(response => response.json())
                .then(histoire => {
                    storySection.innerHTML = `
                        <div>
                            <h2>${histoire.titre}</h2>
                            <article>${histoire.histoire_content}</article>
                        </div>
                        <div>
                            <button id="play-audio" style="display:none;">
                                <img id="play-icon" src="../img/Miaou/play.png" alt="Play">
                                <img id="pause-icon" src="../img/Miaou/pause.png" alt="Pause" style="display:none;">
                            </button>
                            <audio id="audio" src="${histoire.audio}"></audio>
                        </div>
                        <div>
                            <a href="${histoire.url}" download>Télécharger le fichier pdf</a>
                            <div class="progress-bar" id="progress-bar"></div>
                        </div>
                        <div>
                            <a href="${histoire.audio}" download>Télécharger le fichier mp3</a>
                            <div class="progress-bar" id="progress-bar"></div>
                        </div>
                    `;
                    
                    const playButton = document.getElementById('play-audio');
                    const playIcon = document.getElementById('play-icon');
                    const pauseIcon = document.getElementById('pause-icon');
                    const audio = document.getElementById('audio');

                    playButton.style.display = 'block';

                    playButton.addEventListener('click', function() {
                        if (audio.paused) {
                            audio.play();
                            playIcon.style.display = 'none';
                            pauseIcon.style.display = 'block';
                        } else {
                            audio.pause();
                            playIcon.style.display = 'block';
                            pauseIcon.style.display = 'none';
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    }
});
