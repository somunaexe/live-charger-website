document.getElementById("search").addEventListener('keyup', liveSearch);
let search = document.getElementById("search");
let liveSearchResult = document.getElementById("txtHint");

/**
 * Conducts live search for chargers
 * @param item
 */
function liveSearch() {
    let searchValue = search.value;

    let xhr = new XMLHttpRequest();
    xhr.onload = function () {
        if (this.status === 200 && Object.keys(this.responseText).length === 0) {//No charger is returned
            liveSearchResult.innerHTML = "";//displays nothing
        } else if (this.status === 200 && Object.keys(this.responseText).length >= 0) {
            let data = JSON.parse(this.responseText);//converts the JSON string to a JavaScript object
            console.log(data);
            liveSearchResult.innerHTML = "Suggestions:<br/>"
            data.forEach(showLiveChargers);//shows the live search for the chargers
        }
        console.log(this.responseText);
    }
    xhr.open('GET', 'search.php?search=' + searchValue, true);//Makes an asynchronous call to the search function in search.php
    xhr.send();
}

/**
 * Shows the live search for the chargers
 * @param item
 */
function showLiveChargers(item) {
    liveSearchResult.innerHTML += "<li><p>" + item._address + ', £' + item._price + "</p><a href='request.php' target='_blank'>Request</a></li><br/>";
}
