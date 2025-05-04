


const userId = 'haii :3'; 


const submitButton = document.querySelector("[data-submit-button]");
const inputTextBox = document.querySelector("[data-input-textbox]");
const optionsListElem = document.querySelector("[data-options-list]");
const startButton = document.querySelector("[data-start-button]");
const container = document.querySelector("[data-container]");

let optionsList = [];
let sortingIterations;
let battleNum;

submitButton.addEventListener("click", handleSubmit);

inputTextBox.addEventListener("keypress", (e) => {
  if (e.key === "Enter") {
    handleSubmit(e);
  }
});

startButton.addEventListener("click", handleClickStart);

document.addEventListener("click", handleClickOptionButton);

document.addEventListener("click", handleClickILikeBoth);

function handleSubmit(e) {
  e.preventDefault();

  if (inputTextBox.value === "") {
    return;
  }

  if (optionsListElem.classList.contains("initial-options")) {
    optionsListElem.classList.remove("initial-options");
    optionsListElem.classList.add("options");
  }

  const newOption = document.createElement("span");
  newOption.setAttribute("class", "option");
  newOption.setAttribute(`data-option-${optionsList.length + 1}`, "");
  newOption.innerHTML = inputTextBox.value;

  const deleteButton = document.createElement("input");
  deleteButton.setAttribute("type", "button");
  deleteButton.setAttribute("class", "delete-button");
  deleteButton.setAttribute("value", "X");
  deleteButton.setAttribute("id", optionsList.length + 1);
  deleteButton.setAttribute(`data-delete-button-${optionsList.length + 1}`, "");
  deleteButton.setAttribute("onclick", "handleClickDeleteButton(event)");

  newOption.append(deleteButton);
  optionsListElem.append(newOption);

  if (optionsList.length >= 1) {
    const comma = document.createElement("span");
    comma.setAttribute(`data-comma-${optionsList.length}`, "");
    comma.innerHTML = ", ";
    optionsListElem.insertBefore(comma, newOption);
  }

  optionsList.push(inputTextBox.value);

  if (
    optionsList.length >= 2 &&
    startButton.classList.contains("start-button-initial")
  ) {
    startButton.classList.remove("start-button-initial");
    startButton.classList.add("start-button");
  }

  inputTextBox.value = "";
}

function handleClickDeleteButton(event) {
  event.preventDefault();

  const button = event.target;
  const ind = button.id;

  document.querySelector(`[data-option-${ind}]`).remove();

  if (ind !== "1") {
    document.querySelector(`[data-comma-${ind - 1}]`).remove();
  } else if (optionsList.length > 1) {
    document.querySelector(`[data-comma-${ind}]`).remove();
  }

  optionsList.splice(ind - 1, 1);

  const items = optionsListElem.querySelectorAll(".option");

  for (let i = parseInt(ind) - 1; i < items.length; i++) {
    items[i].removeAttribute(`data-option-${i + 2}`);
    items[i].setAttribute(`data-option-${i + 1}`, "");
    items[i].children[0].removeAttribute(`data-delete-button-${i + 2}`);
    items[i].children[0].setAttribute(`data-delete-button-${i + 1}`, "");
    items[i].children[0].setAttribute("id", i + 1);

    if (i !== 0) {
      const comma = optionsListElem.querySelector(`[data-comma-${i + 1}]`);
      comma.removeAttribute(`data-comma-${i + 1}`);
      comma.setAttribute(`data-comma-${i}`, "");
    }
  }

  if (optionsList.length < 2) {
    startButton.classList.remove("start-button");
    startButton.classList.add("start-button-initial");
  }

  if (optionsList.length === 0) {
    optionsListElem.classList.remove("options");
    optionsListElem.classList.add("initial-options");
  }
}

function handleClickStart(e) {
  e.preventDefault();

  let child = container.lastElementChild;

  while (child) {
    container.removeChild(child);
    child = container.lastElementChild;
  }

  const sorterHeader = document.createElement("h2");
  sorterHeader.setAttribute("class", "sorter-header", "aaaa");
  sorterHeader.innerText = "Lista csináló!";

  const sorterDescription = document.createElement("div");

  // Create a new button element
  const button = document.createElement("input");
  button.setAttribute("type", "button");
  button.setAttribute("id", "menoke");
  button.setAttribute("value", "Mentés");
  button.setAttribute("class", "btn btn_tema shadow-none");

  button.addEventListener('click', function() {
    saveUserScore(userId, optionsList, document.getElementById('listanevecske').value);
});






container.appendChild(selectElement);
  


  

  sorterDescription.appendChild(button);
  const battleHeader = document.createElement("p");
  battleHeader.setAttribute("class", "battle-header");
  battleHeader.setAttribute("data-battle-header", "");
  battleHeader.innerText = "Válogatás #1";

  const sortedPercent = document.createElement("p");
  sortedPercent.setAttribute("class", "sorted-percent");
  sortedPercent.setAttribute("data-sorted-percent", "");
  sortedPercent.innerText = "0% válogatva";

  const sorterContainer = document.createElement("div");
  sorterContainer.setAttribute("class", "sorter-container");
  sorterContainer.setAttribute("data-sorter-container", "");

  shuffle(optionsList);
  sortingIterations = optionsList.length - 1;
  battleNum = 1;

  const firstOption = document.createElement("div");
  firstOption.setAttribute("class", "option-button first-option sorter-button");
  firstOption.setAttribute("data-option", "");
  firstOption.setAttribute("data-first-option", "");
  firstOption.setAttribute("ind", "0");
  firstOption.innerText = optionsList[0];

  const secondOption = document.createElement("div");
  secondOption.setAttribute(
    "class",
    "option-button second-option sorter-button"
  );
  secondOption.setAttribute("data-option", "");
  secondOption.setAttribute("data-second-option", "");
  secondOption.setAttribute("ind", "1");
  secondOption.innerText = optionsList[1];

  const iLikeBothButton = document.createElement("div");
  iLikeBothButton.setAttribute(
    "class",
    "i-like-both-button middle-button sorter-button"
  );
  iLikeBothButton.setAttribute("data-middle-button", "");
  iLikeBothButton.setAttribute("data-i-like-both-button", "");
  iLikeBothButton.innerText = "Mindkettő";

  const noOpinionButton = document.createElement("div");
  noOpinionButton.setAttribute(
    "class",
    "no-opinion-button middle-button sorter-button"
  );
  noOpinionButton.setAttribute("data-middle-button", "");
  noOpinionButton.setAttribute("data-no-opinion-button", "");
  noOpinionButton.innerText = "Egyik sem";

  sorterContainer.append(
    firstOption,
    secondOption,
    iLikeBothButton,
    noOpinionButton
  );
  container.append(
    sorterHeader,
    sorterDescription,
    battleHeader,
    sortedPercent,
    sorterContainer
  );
}

const selectElement = document.createElement("select");
selectElement.setAttribute("name", "sajatlista");
selectElement.setAttribute("id", "sajatlista");
selectElement.setAttribute("class", "lathatatlan");


function shuffle(array) {
  let currentIndex = array.length,
    randomIndex;

  while (currentIndex !== 0) {
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex--;

    [array[currentIndex], array[randomIndex]] = [
      array[randomIndex],
      array[currentIndex],
    ];
  }

  return array;
}

function handleClickOptionButton(e) {
  e.preventDefault();

  if (sortingIterations < 1 || !e.target.hasAttribute("data-option")) {
    return;
  }

  const firstOption = document.querySelector("[data-first-option]");
  const secondOption = document.querySelector("[data-second-option]");
  const firstInd = firstOption.getAttribute("ind");
  const secondInd = secondOption.getAttribute("ind");
  const maxInd = Math.max(parseInt(firstInd), parseInt(secondInd));

  const newOptionInd = maxInd + 1 <= sortingIterations ? maxInd + 1 : 0;

  if (e.target.hasAttribute("data-first-option")) {
    if (parseInt(firstInd) > parseInt(secondInd)) {
      [optionsList[parseInt(firstInd)], optionsList[parseInt(secondInd)]] = [
        optionsList[parseInt(secondInd)],
        optionsList[parseInt(firstInd)],
      ];
      secondOption.setAttribute("ind", firstInd);
    }

    if (newOptionInd === 0) {
      firstOption.innerText =
        typeof optionsList[0] === "string"
          ? optionsList[0]
          : optionsList[0][Math.floor(Math.random() * optionsList[0].length)];
      firstOption.setAttribute("ind", "0");
      secondOption.innerText =
        typeof optionsList[1] === "string"
          ? optionsList[1]
          : optionsList[1][Math.floor(Math.random() * optionsList[1].length)];
      secondOption.setAttribute("ind", "1");
      sortingIterations--;
    } else {
      firstOption.innerText =
        typeof optionsList[newOptionInd] === "string"
          ? optionsList[newOptionInd]
          : optionsList[newOptionInd][
              Math.floor(Math.random() * optionsList[newOptionInd].length)
            ];
      firstOption.setAttribute("ind", newOptionInd.toString());
    }
  } else {
    if (parseInt(secondInd) > parseInt(firstInd)) {
      [optionsList[parseInt(firstInd)], optionsList[parseInt(secondInd)]] = [
        optionsList[parseInt(secondInd)],
        optionsList[parseInt(firstInd)],
      ];
      firstOption.setAttribute("ind", secondInd);
    }

    if (newOptionInd === 0) {
      firstOption.innerText =
        typeof optionsList[0] === "string"
          ? optionsList[0]
          : optionsList[0][Math.floor(Math.random() * optionsList[0].length)];
      firstOption.setAttribute("ind", "0");
      secondOption.innerText =
        typeof optionsList[1] === "string"
          ? optionsList[1]
          : optionsList[1][Math.floor(Math.random() * optionsList[1].length)];
      secondOption.setAttribute("ind", "1");
      sortingIterations--;
    } else {
      secondOption.innerText =
        typeof optionsList[newOptionInd] === "string"
          ? optionsList[newOptionInd]
          : optionsList[newOptionInd][
              Math.floor(Math.random() * optionsList[newOptionInd].length)
            ];
      secondOption.setAttribute("ind", newOptionInd.toString());
    }
  }

  if (sortingIterations === 0) {
    generateResultsChart();
    document.querySelector("[data-sorted-percent]").innerHTML = "100% kiválogatva";
  } else {
    battleNum++;
    document.querySelector(
      "[data-battle-header]"
    ).innerHTML = `Battle #${battleNum}`;
    document.querySelector("[data-sorted-percent]").innerHTML = `${Math.round(
      ((battleNum - 1) * 100) /
        ((optionsList.length * (optionsList.length - 1)) / 2)
    )}% sorted`;
  }
}

function handleClickILikeBoth(e) {
  e.preventDefault();

  if (
    sortingIterations < 1 ||
    (!e.target.hasAttribute("data-i-like-both-button") &&
      !e.target.hasAttribute("data-no-opinion-button"))
  ) {
    return;
  }

  const firstOption = document.querySelector("[data-first-option]");
  const secondOption = document.querySelector("[data-second-option]");
  const firstInd = firstOption.getAttribute("ind");
  const secondInd = secondOption.getAttribute("ind");
  const minInd = Math.min(parseInt(firstInd), parseInt(secondInd));
  sortingIterations--;

  if (minInd + 2 <= optionsList.length - 1) {
    optionsList =
      typeof optionsList[parseInt(firstInd)] === "string" &&
      typeof optionsList[parseInt(secondInd)] === "string"
        ? [
            ...optionsList.slice(0, minInd),
            [firstOption.innerText, secondOption.innerText],
            ...optionsList.slice(minInd + 2),
          ]
        : typeof optionsList[parseInt(firstInd)] !== "string" &&
          typeof optionsList[parseInt(secondInd)] !== "string"
        ? [
            ...optionsList.slice(0, minInd),
            optionsList[parseInt(firstInd)].concat(
              optionsList[parseInt(secondInd)]
            ),
            ...optionsList.slice(minInd + 2),
          ]
        : typeof optionsList[minInd] !== "string"
        ? [
            ...optionsList.slice(0, minInd),
            optionsList[minInd].concat([optionsList[minInd + 1]]),
            ...optionsList.slice(minInd + 2),
          ]
        : [
            ...optionsList.slice(0, minInd),
            optionsList[minInd + 1].concat([optionsList[minInd]]),
            ...optionsList.slice(minInd + 2),
          ];

    if (sortingIterations < 1) {
      generateResultsChart();
      return;
    }

    if (minInd === parseInt(firstInd)) {
      secondOption.innerText =
        typeof optionsList[minInd + 1] === "string"
          ? optionsList[minInd + 1]
          : optionsList[minInd + 1][
              Math.floor(Math.random() * optionsList[minInd + 1].length)
            ];
    } else {
      firstOption.innerText =
        typeof optionsList[minInd + 1] === "string"
          ? optionsList[minInd + 1]
          : optionsList[minInd + 1][
              Math.floor(Math.random() * optionsList[minInd + 1].length)
            ];
    }
  } else {
    optionsList =
      typeof optionsList[parseInt(firstInd)] === "string" &&
      typeof optionsList[parseInt(secondInd)] === "string"
        ? [
            ...optionsList.slice(0, minInd),
            [firstOption.innerText, secondOption.innerText],
          ]
        : typeof optionsList[parseInt(firstInd)] !== "string" &&
          typeof optionsList[parseInt(secondInd)] !== "string"
        ? [
            ...optionsList.slice(0, minInd),
            optionsList[parseInt(firstInd)].concat(
              optionsList[parseInt(secondInd)]
            ),
          ]
        : typeof optionsList[minInd] !== "string"
        ? [
            ...optionsList.slice(0, minInd),
            optionsList[minInd].concat([optionsList[minInd + 1]]),
          ]
        : [
            ...optionsList.slice(0, minInd),
            optionsList[minInd + 1].concat([optionsList[minInd]]),
          ];

    if (sortingIterations < 1) {
      generateResultsChart();
      document.querySelector("[data-sorted-percent]").innerHTML = "100% sorted";
      return;
    }

    firstOption.innerText =
      typeof optionsList[0] === "string"
        ? optionsList[0]
        : optionsList[0][Math.floor(Math.random() * optionsList[0].length)];
    firstOption.setAttribute("ind", "0");
    secondOption.innerText =
      typeof optionsList[1] === "string"
        ? optionsList[1]
        : optionsList[1][Math.floor(Math.random() * optionsList[1].length)];
    secondOption.setAttribute("ind", "1");
    sortingIterations--;
  }

  battleNum++;
  document.querySelector(
    "[data-battle-header]"
  ).innerHTML = `Battle #${battleNum}`;
  document.querySelector("[data-sorted-percent]").innerHTML = `${Math.round(
    ((battleNum - 1) * 100) /
      ((optionsList.length * (optionsList.length - 1)) / 2)
  )}% sorted`;
}

function generateResultsChart() {
  const resultsContainer = document.createElement("div");
  resultsContainer.setAttribute("class", "results-container");

  const resultsTable = document.createElement("table");
  resultsTable.setAttribute("class", "results-table");

  const tableHeader = document.createElement("tr");
  tableHeader.setAttribute(
    "class",
    "results-table-row results-table-header-row"
  );

  const rank = document.createElement("th");
  rank.setAttribute(
    "class",
    "results-table-cell rank-header results-table-rank results-table-header"
  );
  rank.innerHTML = "Rank";
  tableHeader.append(rank);

  const character = document.createElement("th");
  character.setAttribute(
    "class",
    "results-table-cell character-header results-table-header"
  );
  character.innerHTML = "Név";
  tableHeader.append(character);

  resultsTable.append(tableHeader);
  resultsContainer.append(resultsTable);

  for (let i = 1; i <= optionsList.length; i++) {
    const newRow = document.createElement("tr");
    newRow.setAttribute("class", "results-table-row");

    const characterRank = document.createElement("td");
    characterRank.setAttribute(
      "class",
      "results-table-cell results-table-rank"
    );
    characterRank.innerHTML = i.toString();
    newRow.append(characterRank);

    const characterName = document.createElement("td");
    characterName.setAttribute(
      "class",
      "results-table-cell results-table-character"
    );
    characterName.innerHTML =
      typeof optionsList[i - 1] === "string"
        ? optionsList[i - 1]
        : optionsList[i - 1].join(", ");
    newRow.append(characterName);

    resultsTable.append(newRow);
  }

  container.append(resultsContainer);
}


async function saveUserScore(userId, list, listname) {
  try {
    let response = await fetch('index.php/lista', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ userId: userId, list: list, listname: listname })
    });
    window.location.reload();
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }

    let result = await response.json();
    console.log(result); 


   

  } catch (error) {
    console.error('Error saving user score:', error);
  }
}







async function listaLeker() {
    try {
        let eredmeny = await fetch('index.php/osszesAdat');
        let adatok = await eredmeny.json();
        let szakok = document.getElementById('sajatlista');
       
        for (const a of adatok) {
            szakok.innerHTML += "<option value='" + a['id'] + "'>" + a['listname'] + "</option>";
        }

        for (const a of adatok) {


        
         

          document.getElementById('torli').addEventListener('click', function () {
              deleteMeow(a['id']);
          });
      }
    } catch (error) {
        console.log(error);
    }
}


   


window.addEventListener('load', function() {
    listaLeker();
});







document.getElementById('muti').addEventListener('click', function() {
  let sajatlista = document.getElementById('sajatlista').value;
  nemee(sajatlista); 
});

async function nemee(lisid) {
  try {
    let eredmeny = await fetch('index.php/megjelnoites', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ lisid: lisid })
    });
    let adatok = await eredmeny.json();

    console.log('Response from server:', adatok); 

    if (adatok.error) {
      console.error('Error from server:', adatok.error);
      return;
    }

    let szakok = document.getElementById('eredm');
    szakok.innerHTML = ''; 

   
    let table = document.createElement('table');
    table.classList.add('responsive-table');
    table.classList.add('cute-table');

  
    let headerRow = document.createElement('tr');
    let positionHeader = document.createElement('th');
    positionHeader.textContent = 'Helyezés';
    let nameHeader = document.createElement('th');
    nameHeader.textContent = 'Név';
    headerRow.appendChild(positionHeader);
    headerRow.appendChild(nameHeader);
    table.appendChild(headerRow);

  
    let i = 1;
    adatok.list.forEach(listName => {
      let row = document.createElement('tr');
      let positionCell = document.createElement('td');
      positionCell.textContent = i;
      let nameCell = document.createElement('td');
      nameCell.textContent = listName;
      row.appendChild(positionCell);
      row.appendChild(nameCell);
      table.appendChild(row);
      i++;
    });


    szakok.appendChild(table);



    let jajj = document.createElement('button');
jajj.id = 'torli';
jajj.textContent = 'Törlés';
jajj.classList.add("btn", "btn_tema", "shadow-none"); 
szakok.appendChild(jajj);
jajj.addEventListener('click', function () {
  deleteMeow(lisid);
});
    
  } catch (error) {
    console.log(error);
  }
}


async function deleteMeow(lisid) {
   
    
 
    
  try {
      let response = await fetch('index.php/jajtorlom', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify({ lisid: lisid })
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






