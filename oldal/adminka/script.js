async function spotifyJavi() {
    try {
        let eredmeny = await fetch('index.php/spotifyjavaslat');
        let adatok = await eredmeny.json();
        let eri = document.getElementById('cicus');

        let tableHTML = "<table class='table table-striped table-bordered text-center'><thead><tr><th>Username</th><th>Name</th><th>Link</th><th>Action</th></tr></thead><tbody>";

        for (const a of adatok) {
            tableHTML += "<tr><td id='neves'>" + a['username'] + "</td><td>" + a['nevecske'] + "</td><td>" + "<a href='" + a['linkecske'] + "'>" + a['linkecske'] + "</a>" + "</td><td><button class='btn btn-pink' id='engedely" + a['id'] + "'>💗</button><button class='btn btn-danger' id='elutasit" + a['id'] + "'>💔</button></td></tr>";
        }

        tableHTML += "</tbody></table>";

        eri.innerHTML = tableHTML;

   
        for (const a of adatok) {
            document.getElementById('engedely' + a['id']).addEventListener('click', function () {
                letrehoz(a['nevecske']);
            });

            document.getElementById('elutasit' + a['id']).addEventListener('click', function () {
                deleteJavaslat(a['id']);
            });
        }
    } catch (error) {
        console.log(error);
    }
}

async function deleteJavaslat(idka) {
   
    
 
    
     try {
         let response = await fetch('index.php/nembiromtovabb', {
             method: 'POST',
             headers: {
                 'Content-Type': 'application/json'
             },
             body: JSON.stringify({ idka: idka })
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





 function letrehoz(value) {
    let hateemel = document.getElementById('eldorado')
    hateemel.innerHTML = "<input type='number' id='helyezes' class='form-control mt-3' placeholder='Helyezés'><input type='text' id='eloadonev' value='" + value + "' class='form-control mt-3' placeholder='Név'><input type='number' id='hallgatokszama' class='form-control mt-3' placeholder='Havi hallgatók'><input type='text' id='linkes' class='form-control mt-3' placeholder='Link'><input type ='button' id ='bekuldesAdmin' value ='Beküldés!' class='btn btn-pink mt-3'>";

    document.getElementById('bekuldesAdmin').addEventListener('click', function() {
        let helyezes = document.getElementById('helyezes').value; 
        let nevecskeje = document.getElementById('eloadonev').value; 
        let havihallgatok = document.getElementById('hallgatokszama').value; 
        let keplink = document.getElementById('linkes').value; 
        bekuldesecske(helyezes, nevecskeje, havihallgatok, keplink); 
    });
}

async function bekuldesecske(helyezes, nevecskeje, havihallgatok, keplink) {
   
    
 
    
    try {
        let response = await fetch('index.php/ne', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ helyezes: helyezes, nevecskeje: nevecskeje, havihallgatok:havihallgatok, keplink:keplink })
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

    
    spotifyJavi();
});



