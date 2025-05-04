function fetchData() {
    let cica = document.getElementById('result');
    cica.innerHTML = "";
    var xhr = new XMLHttpRequest();
    var formData = new FormData(document.getElementById('dateForm'));

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('result').innerHTML = xhr.responseText;
            } else {
                alert('Hiba történt a kérés során!');
            }
        }
    };

    xhr.open('POST', 'albumka.php', true);
    xhr.send(formData);
}


function filterData() {
    let cica = document.getElementById('result');
    cica.innerHTML = "";
    var xhr = new XMLHttpRequest();
    var performer = document.getElementById('eloado_heti_keres').value;
    var formData = new FormData();
    formData.append('performer', performer);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('result').innerHTML = xhr.responseText;
            } else {
                alert('Hiba történt a kérés során!');
            }
        }
    };

    xhr.open('POST', 'fili.php', true);
    xhr.send(formData);
}


function searchByAlbum() {
    let cica = document.getElementById('result');
    cica.innerHTML = "";

    var xhr = new XMLHttpRequest();
    var albumName = document.getElementById('album_keres').value;
    var performer = document.getElementById('eloado_heti_keres').value;
    var formData = new FormData();

    if(albumName != "")
    {
        formData.append('album_name', albumName);
    }

    if(performer != "")
    {
        formData.append('performer', performer);
    }
    
    

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('result').innerHTML = xhr.responseText;
            } else {
                alert('Hiba történt a kérés során!');
            }
        }
    };

    xhr.open('POST', 'fili.php', true);
    xhr.send(formData);
}
