let userId = 1;

async function hajszaler(userId, nev, link) {
    try {
        let response = await fetch('index.php/ehesvagyok', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ userId: userId, nev: nev, link: link })
        });
        let result = await response.json();
        console.log(result);

        
        document.getElementById('kerelemForm').reset();

    } catch (error) {
        console.error('Error saving user score:', error);
    }


    let cica1 = document.getElementById('nevecske');
    let cica2 = document.getElementById('linkecske');
    
    // nem mukodik?? 
    cica1.value = "";
    cica2.value = "";


    
}


document.getElementById('elkuld').addEventListener('click', function() {
    let nev = document.getElementById('nevecske').value;
    let link = document.getElementById('linkecske').value; 
    hajszaler(userId, nev, link); 
});
