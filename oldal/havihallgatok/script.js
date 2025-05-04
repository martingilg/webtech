let pont = 0;
let userId = 1; 

async function karLeker() {
    try {
        let eredmeny = await fetch('index.php/havieloadok');
        let adatok = await eredmeny.json();
        let szakok = document.getElementById('artists');
        
        szakok.innerHTML = ''; 
        for (const a of adatok) {
            let div = document.createElement('div');
            let p = document.createElement('p');
            p.textContent = a['eloado'];
            let img = document.createElement('img');
            img.classList.add('artist-img');
            img.src = a['kep'];
            div.appendChild(p);
            div.appendChild(img);
            div.addEventListener('click', async function() {
                let klikkeltHallgato = a['helyezes'];
                let masikHallgato = adatok.find(artist => artist['eloado'] != a['eloado'])['helyezes'];
                
                
                adatok.forEach(artist => {
                    let havihallgato = parseInt(artist['havihallgato']).toLocaleString(); 
                    let hallgatoSzoveg = document.createElement('p');
                    hallgatoSzoveg.textContent = artist['eloado'] + ': ' + havihallgato;
                    szakok.appendChild(hallgatoSzoveg);
                    hallgatoSzoveg.setAttribute('data-aos', 'fade-down');
                    hallgatoSzoveg.setAttribute('data-aos-duration', '1500');
                    szakok.appendChild(hallgatoSzoveg);
                });
                
                if (parseInt(klikkeltHallgato) < parseInt(masikHallgato)) {
                    
                    pont++;
                } else {
                    alert("Jaj ne, vesztettél! A végső pontod: " + pont);
                    pont = 0;
                }
                let erike = document.getElementById('ponti');
                erike.innerHTML = "<h4 class ='aaaa'>szia ennyi pontod van:" + pont + "</h4>";
                console.log(klikkeltHallgato);

             
                await saveUserScore(userId, pont);

               
                await new Promise(resolve => setTimeout(resolve, 1500));
                
                karLeker(); 
                
            });
            szakok.appendChild(div);
        }
    } catch (error) {
        console.log(error);
    }
}

async function saveUserScore(userId, score) {
   
   if(pont > 0)
   {

   
    try {
        let response = await fetch('index.php/saveUserScore', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ userId: userId, score: score })
        });
        let result = await response.json();
        console.log(result); 
    } catch (error) {
        console.error('Error saving user score:', error);
    }
}
}



async function hajszkor() {
    try {
        let eredmeny = await fetch('index.php/highscore');
        let adatok = await eredmeny.json();
        let menci = document.getElementById('highscore');
        let i = 1;

       
        menci.innerHTML = '';

       
        let table = document.createElement('table');
        table.classList.add('table', 'table-striped', 'aaaa');

    
        let thead = document.createElement('thead');
        thead.innerHTML = `
            <tr>
                <th scope="col">Helyezés</th>
                <th scope="col">Név</th>
                <th scope="col">Pontszám</th>
                <th scope="col">Időpont</th>
            </tr>
        `;
        table.appendChild(thead);

        // Create table body
        let tbody = document.createElement('tbody');
        for (const a of adatok) {
            let row = document.createElement('tr');
            row.innerHTML = `
                <th scope="row">${i}</th>
                <td>${a['felhi']}</td>
                <td>${a['legnagyobb']}</td>
                <td>${a['ido']}</td>
            `;
            tbody.appendChild(row);
            i++;
        }
        table.appendChild(tbody);

        hajszkor();
        menci.appendChild(table);
    } catch (error) {
        console.log(error);
    }
}

window.addEventListener('load', () => {
    karLeker();
    hajszkor();
});
