///AJAX KERES KATTINTASKOR

function fetchData() {
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

    xhr.open('POST', 'adatok.php', true);
    xhr.send(formData);
}


function filterData() {
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

    xhr.open('POST', 'filter.php', true);
    xhr.send(formData);
}


function filterBySongHis() {
    var xhr = new XMLHttpRequest();
    var albumName = document.getElementById('song_keres').value;
   
    var formData = new FormData();

   
        formData.append('song_keres', albumName);
    

  
    
    

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('result').innerHTML = xhr.responseText;
            } else {
                alert('Hiba történt a kérés során!');
            }
        }
    };

    xhr.open('POST', 'filter.php', true);
    xhr.send(formData);
}
