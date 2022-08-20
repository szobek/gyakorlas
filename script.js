if (document.querySelector("#imgInp")) {

  imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
      imgName = file.name
      console.log(file);
      imgPreview.src = URL.createObjectURL(file)
      document.querySelector("#image_url").value = imgName.replaceAll(" ", "_")
    }
  }
}

if(document.querySelector("#img-view")){
  $("#modify-btn").on("click",e=>{
    e.preventDefault()
    $("#img-input").show()
    $("#img-view").hide()
  })
  
  $("#modify-btn-cancel").on("click",e=>{
    e.preventDefault()
    $("#img-input").hide()
    $("#img-view").show()
  })

}