function onPageLoaded() {
    resp = {
        'glyphs': document.getElementById("glyphs").innerHTML,
        'words': document.getElementById("words").innerHTML,
        'phrases': document.getElementById("phrases").innerHTML
    }
}

function searchboxModified() {
    // fill req with json data
    action = document.getElementById("ancient_search").checked ? 'search_ancient' : 'search_english'
    searchQuery = document.querySelector("#searchbox > textarea").value
    json_data = {
        'action': action,
        'query': searchQuery
    }

    sendAJAXRequest(json_data)
}

function searchboxFontSwitch() {
    checked = document.getElementById("ancient_search").checked
    searchbox = document.querySelector("#searchbox > textarea")
    searchbox.className = checked ? "ancient" : "english"

    if (checked) {
        // checked: searching in ancient
        newEntryDiv = document.getElementById("new_entry_group")
        if (newEntryDiv != null) {
            newEntryDiv.className = ""
        }

    } else {
        // unchecked: searching in english
        newEntryDiv = document.getElementById("new_entry_group")
        if (newEntryDiv != null) {
            newEntryDiv.className = "hidden"
        }
    }

    if (searchbox.value != "")
        searchboxModified()
}

function onWordEditSubmit(e, word_id) {

    // fill req with json data
    // action = document.getElementById("ancient_search").checked ? 'search_ancient' : 'search_english'
    searchQuery = document.querySelector("#searchbox > textarea").value
    searchQueryOption = document.getElementById("ancient_search").checked ? 'ancient' : 'english'
    word_glyphs = document.getElementById("word_glyphs_" + word_id).value
    word_translation = document.getElementById("word_translation_" + word_id).value
    word_confirmed = document.getElementById("word_confirmed_" + word_id).checked
    json_data = {
        'action': 'word_edit',
        'query': searchQuery,
        'searchQueryOption': searchQueryOption,
        'word_id': word_id,
        'word_glyphs': word_glyphs,
        'word_translation': word_translation,
        'word_confirmed': word_confirmed
    }

    sendAJAXRequest(json_data)

    e.preventDefault()
    return false
}

function submitNewEntries() {
    if (!document.getElementById("ancient_search").checked) {
        displayErrorMessage("Only ancient can be added")
        return
    }

    searchQuery = document.querySelector("#searchbox > textarea").value
    json_data = {
        'action': 'new_entry',
        'query': searchQuery
    }

    sendAJAXRequest(json_data)
}

function deletePhrase(phrase_id) {
    searchQuery = document.querySelector("#searchbox > textarea").value
    searchQueryOption = document.getElementById("ancient_search").checked ? 'ancient' : 'english'

    json_data = {
        'action': 'delete_phrase',
        'query': searchQuery,
        'searchQueryOption': searchQueryOption,
        'phraseId': phrase_id
    }

    sendAJAXRequest(json_data)
}

function sendAJAXRequest(req_data) {
    req = new XMLHttpRequest()
    req.onreadystatechange = asyncSearchResponseReceived
    req.open("POST", "dictionary", true)
    req.setRequestHeader("Content-type", "application/json")
    req.send(JSON.stringify(req_data))
}

function asyncSearchResponseReceived() {
    if (req.readyState == 4) {
        if (req.status == 200) {
            resp = JSON.parse(req.responseText)
        }
        else {
            htmlParser = new DOMParser();
            doc = htmlParser.parseFromString(req.responseText, "text/html");
            displayErrorMessage(doc.title);
        }
        document.getElementById("glyphs").innerHTML = resp.glyphs
        document.getElementById("words").innerHTML = resp.words
        document.getElementById("phrases").innerHTML = resp.phrases
    }
}

function displayErrorMessage(errorMsg) {
    document.getElementById("errordiv").innerHTML = "<div id=\"errormsg\"> " + errorMsg + " </div>"
}

window.addEventListener("load", onPageLoaded);