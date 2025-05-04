document.getElementById('kovihet').onclick = function() {
    var datumInput = document.getElementById('datum');
    var selectedDate = new Date(datumInput.value);
    selectedDate.setDate(selectedDate.getDate() + 7);

    
    var formattedDate = selectedDate.toISOString().slice(0, 10);

  
    datumInput.value = formattedDate;

 
    document.getElementById('elkuld').click();
};

document.getElementById('elozohet').onclick = function() {
    var datumInput = document.getElementById('datum');
    var selectedDate = new Date(datumInput.value);
    selectedDate.setDate(selectedDate.getDate() - 7); 

   
    var formattedDate = selectedDate.toISOString().slice(0, 10);

    
    datumInput.value = formattedDate;

   
    document.getElementById('elkuld').click();
};
