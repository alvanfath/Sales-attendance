function previewImage(event) {
    if (event.target.files.length > 0) {
        var src = URL.createObjectURL(event.target.files[0]);
        var preview = document.getElementById("img-enduro");
        var close = document.getElementById("close");
        preview.classList.remove("d-none");
        close.classList.remove("d-none");
        preview.src = src;
        preview.style.display = "center";
        preview.style.width = "100%";
        preview.style.height = "200px";
    }
}

function previewClose(){
    var preview = document.getElementById("img-enduro");
    var close = document.getElementById("close");
    preview.classList.add("d-none");
    close.classList.add("d-none");
    preview.src = '';
}

function onlyNumber(evt) {
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}
