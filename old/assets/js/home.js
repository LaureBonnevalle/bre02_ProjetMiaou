document.addEventListener('DOMContentLoaded', function() {
    
    const messageElement = document.getElementById('session-message');              // Green
    const errorElement = document.getElementById('session-error');                  // Red
    const alertElement = document.getElementById('session-alert');                  // Yellow
    
    if (messageElement || errorElement || alertElement) {
        let isVisible = true;
        let interval = setInterval(() => {
            isVisible = !isVisible;
            if (messageElement) {
                messageElement.style.visibility = isVisible ? 'visible' : 'hidden';
            }
            if (errorElement) {
                errorElement.style.visibility = isVisible ? 'visible' : 'hidden';
            }
            if (alertElement) {
                alertElement.style.visibility = isVisible ? 'visible' : 'hidden';
            }
            
        }, 500); // Toggle visibility every 500 milliseconds (0.5 seconds)

        setTimeout(() => {
            clearInterval(interval);
             if (messageElement) {
                messageElement.style.display = 'none';
            }
            if (errorElement) {
                errorElement.style.display = 'none';
            }
            if (alertElement) {
                alertElement.style.display = 'none';
            }
            
            
            
        }, 10000); // Stop blinking and hide after 10 seconds (10000 milliseconds)
    }

//fonction retour haut de page
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    var button = document.getElementById("backToTopButton");
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        button.style.display = "block";
    } else {
        button.style.display = "none";
    }
}

document.getElementById('backToTopButton').addEventListener('click', function() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
});

// fonction timer
function startTimer(startTime, display) {
        setInterval(function () {
            let now = Date.now();
            let elapsed = Math.floor((now - startTime) / 1000);
            let hours = Math.floor(elapsed / 3600);
            let minutes = Math.floor((elapsed % 3600) / 60);
            let seconds = elapsed % 60;

            hours = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = hours + ":" + minutes + ":" + seconds;

            if (elapsed === 600) { // 10 minutes
                alert("Attention, il s'est écoulé 10 minutes");
            } else if (elapsed === 900) { // 15 minutes
                alert("Attention, il s'est écoulé 15 minutes");
            } else if (elapsed === 1200) { // 20 minutes
                alert("Attention, il s'est écoulé 20 minutes");
            }
        }, 1000);
    }

    window.onload = function () {
        let startTime = localStorage.getItem('startTime');
        if (!startTime) {
            startTime = Date.now();
            localStorage.setItem('startTime', startTime);
        } else {
            startTime = parseInt(startTime, 10);
        }
        let display = document.querySelector('#time');
        startTimer(startTime, display);
    };

    document.getElementById('logout').addEventListener('click', function() {
        localStorage.removeItem('startTime');
        // Rediriger vers la page de déconnexion
        window.location.href = '/logout';
    });
    /*
let data = [
    {
        "id": 1,
        "identity": "FONCTIONNAIRE 1",
        "dept": "Paris",
        "poste": "PARIS * Brigade des stups",
        "choix": [
            "PARIS * Brigade des mineurs",
            "PARIS * DSPAP-DTSP75 - Surete territoriale",
            "PARIS * Brigade de repression du proxenetisme"
        ]
    },
    {
        "id": 2,
        "identity": "FONCTIONNAIRE 2",
        "dept": "Paris",
        "poste": "PARIS * Brigade de repression du proxenetisme",
        "choix": [
            "PARIS * Brigade criminelle",
            "PARIS * Brigade des stups"
        ]
    }
];

// let width = window.innerWidth;
// let height = window.innerHeight;

let width = 550;
let height = 390;

let svg = d3.select("svg")
    .attr("width", width)
    .attr("height", height);

let simulation = d3.forceSimulation()
    .force("link", d3.forceLink().id(function(d) { return d.id; })
        .distance(function(d) {
            return d.type === 'fonctionnaire-dept' ? 80 : 220; // Distance réduite pour les liens bleus
        }))
    .force("charge", d3.forceManyBody().strength(-1500))
    .force("center", d3.forceCenter(width / 2, height / 2))
    .force("x", d3.forceX(width / 2).strength(0.1))
    .force("y", d3.forceY(height / 2).strength(0.1));

    let nodes = [];
    let links = [];
    
    let choixAjoutes = {}; // Objet pour suivre les choix déjà ajoutés
    
    data.forEach(function(d) {
        nodes.push({ id: d.id, name: d.identity, group: 'fonctionnaire', class: 'identity' });
        nodes.push({ id: d.id + "-poste", name: d.poste, group: 'poste', class: 'poste' });
        nodes.push({ id: d.id + "-dept", name: d.dept, group: 'dept', class: 'dept' });
    
        links.push({ source: d.id, target: d.id + "-poste", type: 'fonctionnaire-poste' });
        links.push({ source: d.id, target: d.id + "-dept", type: 'fonctionnaire-dept' });
    
        d.choix.forEach(function(choix, index) {
            if (!choixAjoutes[choix]) {
                let choixId = d.id + "-choix" + (index + 1);
                nodes.push({ id: choixId, name: choix, group: 'choix', class: 'choix' });
                links.push({ source: d.id, target: choixId, type: 'choix' });
                choixAjoutes[choix] = true;
            }
        });
    
        data.forEach(function(other) {
            if (other.id !== d.id) {
                d.choix.forEach(function(choix) {
                    if (choix === other.poste || choix === other.dept) {
                        links.push({ source: d.id, target: other.id + (choix === other.poste ? "-poste" : "-dept"), type: 'choix' });
                    }
                });
            }
        });
    });
    
    let link = svg.append("g")
        .attr("class", "links")
        .selectAll("line")
        .data(links)
        .enter().append("line")
        .attr("class", function(d) {
            return "link " + (d.type === 'fonctionnaire-poste' ? 'fonctionnaire-poste' : d.type === 'fonctionnaire-dept' ? 'fonctionnaire-dept' : 'choix');
        });
    
    let node = svg.append("g")
        .attr("class", "nodes")
        .selectAll("circle")
        .data(nodes)
        .enter().append("circle")
        .attr("class", "node")
        .attr("r", 10)
        .call(d3.drag()
            .on("start", dragstarted)
            .on("drag", dragged)
            .on("end", dragended));
    
    let labels = svg.append("g")
        .attr("class", "labels")
        .selectAll("text")
        .data(nodes)
        .enter().append("text")
        .attr("class", function(d) { return "label " + d.class; })
        .text(function(d) { return d.name; });
    
    simulation
        .nodes(nodes)
        .on("tick", ticked);
    
    simulation.force("link")
        .links(links);
    
    let margin = 20;
    
    function ticked() {
        link
            .attr("x1", function(d) { return d.source.x; })
            .attr("y1", function(d) { return d.source.y; })
            .attr("x2", function(d) { return d.target.x; })
            .attr("y2", function(d) { return d.target.y; });
    
        node
            .attr("cx", function(d) { return d.x = Math.max(margin, Math.min(width - margin, d.x)); })
            .attr("cy", function(d) { return d.y = Math.max(margin, Math.min(height - margin, d.y)); });
    
        labels
            .attr("x", function(d) { return d.x + 10; })
            .attr("y", function(d) { return d.y + 3; });
    }
    
    function dragstarted(event, d) {
        if (!event.active) simulation.alphaTarget(0.3).restart();
        d.fx = d.x;
        d.fy = d.y;
    }
    
    function dragged(event, d) {
        d.fx = event.x;
        d.fy = event.y;
    }
    
    function dragended(event, d) {
        if (!event.active) simulation.alphaTarget(0);
        d.fx = null;
        d.fy = null;
    }
    */
});





