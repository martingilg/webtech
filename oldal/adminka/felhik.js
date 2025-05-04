


async function felhazsnaloMegjelenitese() {
    try {
        let eredmeny = await fetch('index.php/osszesfelho');
        let adatok = await eredmeny.json();
        let eri = document.getElementById('felhimegjelen');

        let tableHTML = "<table class='table table-striped table-bordered text-center'><thead><tr><th>#</th><th>Felhasználók</th><th>Művelet</th></tr></thead><tbody>";

        for (const a of adatok) {
            tableHTML += "<tr><td>" + a['id'] + "</td><td>" + a['username'] + "</td><td><button class='btn btn-pink' id='engedely" + a['id'] + "'>💗</button><button class='btn btn-danger' id='elutasit" + a['id'] + "'>💔</button></td></tr>";
        }

        tableHTML += "</tbody></table>";

        eri.innerHTML = tableHTML;

        for (const a of adatok) {
            document.getElementById('engedely' + a['id']).addEventListener('click', function () {
                letrehoz(a['username'], a['id']);
            });
            document.getElementById('elutasit' + a['id']).addEventListener('click', function () {
                deleteMeow(a['id']);
            });
        }

    } catch (error) {
        console.log(error);
    }
}



async function deleteMeow(idfelhi) {
   
    
 
    
    try {
        let response = await fetch('index.php/deletecica', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ idfelhi: idfelhi })
        });
        let result = await response.json();
        console.log(result); 

        if (result.valasz === "Sikeres") {
           window.location.reload();
          
          
       }
    } catch (error) {
        console.error('jaj de rossz:', error);
    }

}


function letrehoz(value, id) {
    let hateemel = document.getElementById('eldorado');
    hateemel.innerHTML = '';

   
    let felhikenevInput = document.createElement('input');
    felhikenevInput.type = 'text';
    felhikenevInput.id = 'felhikenev';
    felhikenevInput.value = value;
    felhikenevInput.classList.add('szovegbox'); 

    let ujjelszoInput = document.createElement('input');
    ujjelszoInput.type = 'text';
    ujjelszoInput.id = 'ujjelszo';
    ujjelszoInput.placeholder = 'Jelszó';
    ujjelszoInput.classList.add('szovegbox'); 

    let bekuldesText = document.createElement('div'); 
 
    bekuldesText.classList.add('mt-3'); 

    let bekuldesButton = document.createElement('input');
    bekuldesButton.type = 'button';
    bekuldesButton.id = 'bekuldesAdmin';
    bekuldesButton.value = 'Beküldés';
    bekuldesButton.classList.add('btn', 'btn-pink');

   
    hateemel.appendChild(felhikenevInput);
    hateemel.appendChild(ujjelszoInput);
    hateemel.appendChild(bekuldesText); 
    hateemel.appendChild(bekuldesButton);


    bekuldesButton.addEventListener('click', function () {
        let ujnev = document.getElementById('felhikenev').value;
        let ujjelszo = document.getElementById('ujjelszo').value;

        updejtke(id, ujnev, ujjelszo); 
    });
}


async function updejtke(idke, ujnev, ujjelszo) {
   
    
 
    
    try {
        let response = await fetch('index.php/norbiupdate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ idke: idke, ujnev: ujnev, ujjelszo:ujjelszo})
        });
        let result = await response.json();
        console.log(result); 

        if (result.valasz === "Sikeres") {

            window.location.reload();
          
       }
    } catch (error) {
        console.error('jaj de rossz:', error);
    }

}

window.addEventListener('load', function () {

    
    felhazsnaloMegjelenitese();
});