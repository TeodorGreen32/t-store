function openModalProduct(id) {
 
  fetch(`./initModal.php?id=${id}`)
    .then((response) => response.text())
    .then((text) => {
        var myModal = new bootstrap.Modal(document.getElementById("exampleModalLive"));
        myModal.show();
        var parser = new DOMParser();
        var doc = parser.parseFromString(text, "text/html");
        document.querySelectorAll("#exampleModalLive .modal-body > div").forEach(el=>{
            el.remove();
        })
        document.querySelector("#exampleModalLive .modal-body").append(doc.querySelector('.block-content'))

        
    });
}

function clearFormHistory() {
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
}
function sendAdminForm(){
    let form = document.querySelector('form[send-function=ajax-admin]');
    form.addEventListener('submit',e=>{
        e.preventDefault();
        let formData = new FormData(form)
        fetch('addProduct.php',{
            method: "post",
            body:formData
        })
    })
}
// function removeProductFromId(id){
//   fetch(`./removeProduct.php?id=${id}`);
// }