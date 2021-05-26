//JS for dropdown menu

const navToggle = document.querySelector('#navToggle');
const nav = document.querySelector('#dropNav');

navToggle.addEventListener("mouseenter", () => {
	nav.classList.add('open');
})

list.addEventListener("mouseleave", () => {
	nav.classList.remove('open');
})

list.addEventListener("mouseenter", () => {
	nav.classList.add('open');
})

navToggle.addEventListener("mouseleave", () => {
	nav.classList.remove('open');
})


// ANCHOR Download-Anzeige Funktione 
function addDownloadCount(id) {
    const count = document.getElementById('downloads'+id);
    const oldNumber = count.innerHTML;
    count.innerHTML = parseInt(oldNumber,10) + 1;
    //alert(oldNumber);
}

function delErrors(){
    document.querySelectorAll('.error').forEach(element => {
        element.innerHTML = '';
    });
}