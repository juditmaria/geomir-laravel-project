const submit  = document.getElementById('destroy')
const confirm = document.getElementById('confirm')

// Disable form submit button
submit.addEventListener("click", function( event ) {
    event.preventDefault()
    return false
})

// Enable submit via modal confirmation
confirm.addEventListener("click", function( event ) {
    document.getElementById("form").submit(); 
})

// Open modal when query param is present
const params = new Proxy(new URLSearchParams(window.location.search), {
    get: (searchParams, prop) => searchParams.get(prop),
})
if (params.delete && params.delete == 1) {
    submit.click()
}